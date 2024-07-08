<?php	ob_start();


include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';

include_once 'transactions.php';




  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);
  
  	include_once 'language_include.php';

  $mode=$_GET['mode'];
  $pgmid=$_GET['id'];

  //echo $pgmid;

  $sql="select * from partners_joinpgm  where joinpgm_programid=$pgmid";

   $total=GetPaymentDetails($sql,$currValue,$default_currency_caption); //getting payments (click,sale,lead) values
  $total =explode('~',$total);

  $tot=$total[1]+$total[2]+$total[3]+$total[4];


  if($tot==0)
  {


   $sql1="delete from partners_program where program_id=$pgmid";
   $sql2="delete from partners_firstlevel where firstlevel_programid='$pgmid'";
   $sql3="delete from partners_secondlevel where secondlevel_programid='$pgmid'";
   $sql4="delete from partners_html where html_programid=$pgmid";
   $sql5="delete from partners_popup where popup_programid=$pgmid";
   $sql6="delete from partners_flash where flash_programid=$pgmid";
   $sql7="delete from partners_banner where banner_programid=$pgmid";
   $sql8="delete from partners_text where text_programid=$pgmid";
   $sql9="delete from partners_pgmstatus where pgmstatus_programid=$pgmid";
   $sql10="delete from partners_group where group_programid=$pgmid";


      mysqli_query($con,$sql1);
      mysqli_query($con,$sql2);
      mysqli_query($con,$sql3);
      mysqli_query($con,$sql4);
      mysqli_query($con,$sql5);
      mysqli_query($con,$sql6);
      mysqli_query($con,$sql7);
      mysqli_query($con,$sql8);
      mysqli_query($con,$sql9);
      mysqli_query($con,$sql10);  

    $msg=$lpgm_error4;
    header("Location:index.php?Act=programs&msg=$msg&del=del");


  }
   else
   {
    $msg=$lpgm_error5;
    header("Location:index.php?Act=programs&msg=$msg&programs=$pgmid");

   }


?>