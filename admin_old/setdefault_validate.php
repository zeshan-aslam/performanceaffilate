<?php   	ob_start();

# iinclude session variables
  include '../includes/session.php';

# include database constants
  include '../includes/constants.php';

# include common fuctions
  include '../includes/functions.php';

# functions on get and post variables
  include '../includes/allstripslashes.php';

# crete databse instance
  $partners=new partners;

# establish databse connection
  $partners->connection($host,$user,$pass,$db);

  $idArray  = explode(",",$currid);

  $url 		= "index.php?Act=setDefault&id=$id";

  for ($idCount=0; $idCount<count($idArray); $idCount++) {

    # relation value
    $relation[$idCount] = $_POST['currency_relation'][$idArray[$idCount]];

    # checking for emapty values
    if(empty($relation[$idCount])) {
         $err = 1;
         header("location:$url&ErrMsg=Please Fill All Fields");
         exit();
    }

    # cehcking for numeric
    if(!is_numeric($relation[$idCount])) {
         $err = 2;
         header("location:$url&ErrMsg=Please Enter Only Numeric Values");
         exit();
    }

  }

   #-------------------------------------------------------------------------------
   # set selected currency as default
   #-------------------------------------------------------------------------------
   $sql = "UPDATE partners_currency SET currency_default = 'no' WHERE currency_default = 'yes'" ;
   mysql_query($sql);

   $sql = "UPDATE partners_currency SET currency_default = 'yes' WHERE currency_id = '$id'" ;
   mysql_query($sql);

   #-------------------------------------------------------------------------------
   #  set relation
   #-------------------------------------------------------------------------------
   for ($idCount=0; $idCount<count($idArray); $idCount++) {
     $sql = "UPDATE partners_currency SET currency_relation = $relation[$idCount] WHERE currency_id = '$idArray[$idCount]'" ;
   	 mysql_query($sql);
    //$idArray[$idCount]." = ".$relation[$idCount];
   }

  $msg =7;
  header("Location:index.php?Act=currency&msg=$msg");
  exit();

?>
