<?php
  /**

   * Security Class
   * @copyright 2022
   */
 Class Security
  {

    
    // DECLARE THE REQUIRED VARIABLES
    private $secLimit = 5;
  
    public function encode_it($value){
          
          /*Parameters Guidence*/
          #$value   (Text for encryption)
          
          $container_array = array();
          $string_for_enc  = $value;
        
          for ($i=0; $i < $this->secLimit+1 ; $i++) { 
              $enc_text = base64_encode($string_for_enc);
              $string_for_enc = $enc_text;
              $container_array[] = $enc_text;
          }
      $last_iteration_value = count($container_array)-1;

      /*Encrypted Text*/
      return $cyphir_text = $container_array[$last_iteration_value];
      }

    public function decode_it($enc_data){

            $de_cyphir_text = $enc_data;
            $dec_levels     = array();
            
            for ($i = $this->secLimit; $i >= 0 ; $i--) { 
                $new_dec = base64_decode($de_cyphir_text);
                $de_cyphir_text = $new_dec;
                $dec_levels[] =  $de_cyphir_text;
            }
            
            $last_iteration_dec_levels = count($dec_levels)-1;
            return $dec_levels[$last_iteration_dec_levels];
    }



  }
?>