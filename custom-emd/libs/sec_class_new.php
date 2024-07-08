<?php
  /**

   * Security Class

   * @author Gulfam Khan

   * @copyright 2019

   */
 Class Security
  {
    // DECLARE THE REQUIRED VARIABLES
    public $ENC_METHOD = "AES-256-CBC"; // THE ENCRYPTION METHOD.
    public $ENC_KEY = "SOME_RANDOM_KEY"; // ENCRYPTION KEY
    public $ENC_IV = "SOME_RANDOM_IV"; // ENCRYPTION IV.
    public $ENC_SALT = "xS$98_ER"; // THE SALT FOR PASSWORD ENCRYPTION ONLY.
    // DECLARE  REQUIRED VARIABLES TO CLASS CONSTRUCTOR
    function __construct($METHOD = NULL, $KEY = NULL, $IV = NULL, $SALT = NULL)
     {
       try
        {
          // Setting up the Encryption Method when needed.
          $this->ENC_METHOD = (isset($METHOD) && !empty($METHOD) && $METHOD != NULL) ?
          $METHOD : $this->ENC_METHOD;
          // Setting up the Encryption Key when needed.
          $this->ENC_KEY = (isset($KEY) && !empty($KEY) && $KEY != NULL) ?
          $KEY : $this->ENC_KEY;
          // Setting up the Encryption IV when needed.
          $this->ENC_IV = (isset($IV) && !empty($IV) && $IV != NULL) ?
          $IV : $this->ENC_IV;
          // Setting up the Encryption IV when needed.
          $this->ENC_SALT = (isset($SALT) && !empty($SALT) && $SALT != NULL) ?
          $SALT : $this->ENC_SALT;
        }
        catch (Exception $e)
         {
           return "Caught exception: ".$e->getMessage();
         }
     }
    // THIS FUNCTION WILL ENCRYPT THE PASSED STRING
    public function Encrypt($string)
    {
      try
       {
         $output = false;
         $key = hash('sha256', $this->ENC_KEY);
         // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
         $iv = substr(hash('sha256', $this->ENC_IV), 0, 16);
         $output = openssl_encrypt($string, $this->ENC_METHOD, $key, 0, $iv);
         $output = base64_encode($output);
         return $output;
       }
       catch (Exception $e)
        {
          return "Caught exception: ".$e->getMessage();
        }
    }
    // THIS FUNCTION WILL DECRYPT THE ENCRYPTED STRING.
    public function Decrypt($string)
    {
      try
      {
        $output = false;
        // hash
        $key = hash('sha256', $this->ENC_KEY);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $this->ENC_IV), 0, 16);
       $output = openssl_decrypt(base64_decode($string), $this->ENC_METHOD, $key, 0, $iv);
       return $output;
      }
     catch (Exception $e)
      {
        return "Caught exception: ".$e->getMessage();
      }
    }
    // THIS FUNCTION FOR PASSWORDS ONLY, BECAUSE IT CANNOT BE DECRYPTED IN FUTURE.
    public function EncryptPassword($Input)
      {
        try
          {
            if (!isset($Input) || $Input == null || empty($Input)) { return false;}
            // GENERATE AN ENCRYPTED PASSWORD SALT
            $SALT = $this->Encrypt($this->ENC_SALT);
            $SALT = md5($SALT);
            // PERFORM MD5 ENCRYPTION ON PASSWORD SALT.
            // ENCRYPT PASSWORD
            $Input = md5($this->Encrypt(md5($Input)));
            $Input = $this->Encrypt($Input);
            $Input =  md5($Input);
            // PERFORM ANOTHER ENCRYPTION FOR THE ENCRYPTED PASSWORD + SALT.
            $Encrypted = $this->Encrypt($SALT).$this->Encrypt($Input);
            $Encrypted = sha1($Encrypted.$SALT);
            // RETURN THE ENCRYPTED PASSWORD AS MD5
            return md5($Encrypted);
          }
        catch (Exception $e)
         {
           return "Caught exception: ".$e->getMessage();
         }
      }
  
    public function encode_it($value){
          
          /*Parameters Guidence*/
          #$value   (Text for encryption)
          
          global $db;
          $info_select_sql = "SELECT * FROM ".PREFIX."settings";
          $fetched_info    = $db->fetch_single_row($info_select_sql);
          
          $container_array = array();
          $string_for_enc  = $value;
          //$container_array[] = $enc_key;
          
          for ($i=0; $i < $fetched_info['basic_enc_level']+1 ; $i++) { 
              $enc_text = base64_encode($string_for_enc);
              $string_for_enc = $enc_text;
              $container_array[] = $enc_text;
          }
      $last_iteration_value = count($container_array)-1;

      /*Encrypted Text*/
      return $cyphir_text = $container_array[$last_iteration_value];
      }

    public function decode_it($enc_data){

            global $db, $custom_fun;
            $info_select_sql = "SELECT * FROM ".PREFIX."settings";
            $fetched_info    = $db->fetch_single_row($info_select_sql);

            $de_cyphir_text = $enc_data;
            $dec_levels     = array();
            
            for ($i = $fetched_info['basic_enc_level']; $i >= 0 ; $i--) { 
                $new_dec = base64_decode($de_cyphir_text);
                $de_cyphir_text = $new_dec;
                $dec_levels[] =  $de_cyphir_text;
            }
            
            $last_iteration_dec_levels = count($dec_levels)-1;
            return $dec_levels[$last_iteration_dec_levels];
    }



  }
?>