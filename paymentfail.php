<?php



   include_once 'includes/constants.php';
   include_once 'includes/functions.php';
   include_once 'includes/session.php';

   $partners=new partners;
   $partners->connection($host,$user,$pass,$db);

   include_once 'language_include.php';


  $curid        = $_GET['curid'];

  /*//geting records from table
  $sql =" DELETE FROM partners_merchant WHERE merchant_id = $curid";
  $ret =mysql_query($sql);

  //geting records from table
  $sql =" DELETE FROM partners_login WHERE login_id = $curid AND login_flag='m'";
  $ret =mysql_query($sql);

   //geting records from table
  $sql =" DELETE FROM merchant_pay WHERE pay_merchantid = $curid ";
  $ret =mysql_query($sql);*/

  $msg=$lang_perror;
  header("Location:index.php?Act=register&msg=$msg");
  exit;


?>
