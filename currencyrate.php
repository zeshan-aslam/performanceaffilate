<?php	
  #-------------------------------------------------------------------------------
  # Currency Update Script

  # Pgmmr        : Ankit Kedia
  # Date Created : 9th May 2020
  # Date Modfd   : 9th May 2020
  # Last Modified: By Ankit Kedia
  #-------------------------------------------------------------------------------

	include_once 'includes/db-connect.php';
  include_once 'includes/session.php';
  include_once 'includes/constants.php';
  include_once 'includes/functions.php';
  include_once 'testmail.php';

  $partners = new partners;
  $partners->connection($host,$user,$pass,$db);

  $today = date("Y-m-d");

  $json = file_get_contents('https://api.exchangeratesapi.io/latest?base=GBP&symbols=USD,GBP,EUR');
  $response["data"] = json_decode($json);
  $response["status"] = true;
   

  $obj = json_decode($json);

  if($obj != null)
  {
    $data = $obj->rates;

    $sql = "Insert into partners_currency_log (data) values('".mysqli_real_escape_string($con, $json)."') ";
    $result = mysqli_query($con,$sql); 



    if(isset($data->EUR))
    {
        $sql = "update partners_currency_relation set relation_value = '".$data->EUR."', relation_date = '".$today."' where relation_currency_code = 'EUR' ";

         $result = mysqli_query($con,$sql); 
    }

    if(isset($data->USD))
    {
        $sql = "update partners_currency_relation set relation_value = '".$data->USD."', relation_date = '".$today."' where relation_currency_code = 'USD' ";

         $result = mysqli_query($con,$sql); 
    }

    if(isset($data->GBP))
    {
        $sql = "update partners_currency_relation set relation_value = '".$data->GBP."', relation_date = '".$today."' where relation_currency_code = 'GBP' ";

         $result = mysqli_query($con,$sql); 
    }

  }
  

  echo json_encode($response);

?>