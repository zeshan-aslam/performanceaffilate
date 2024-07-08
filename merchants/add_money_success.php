<?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
   include_once '../includes/allstripslashes.php';


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

	include_once 'language_include.php';

	$bal		=	$_SESSION['MERCHANTBALANCE'];
    $mid		=	$_SESSION['MERCHANTID'];
    $amount	   	=   $_GET['amount'];
    $grandtotal	= 	$bal + $amount;

   // echo $grandtotal."tot";

//----------------------------------  security -------------------------------------------------------------//
		$secid         = $_GET['secid'];
    	$secpass       = $_GET['secpass'];

	  $secsql	= "select * from random_gen where rand_genid='".addslashes($secid)."' and rand_genpwd='".addslashes($secpass)."'";
      $secres=mysqli_query($con,$secsql);
      if(mysqli_num_rows($secres)>0)
      {

	          $secdel ="delete from random_gen where rand_genid='".addslashes($secid)."' and rand_genpwd='".addslashes($secpass)."'";
	       	  mysqli_query($con,$secdel);

      }
      else
      {
		$msg=$lang_perror;
        header("location:index.php?Act=add_money&msg=$msg");
         exit;

      }
// ----------------------------- security test end ------------------------------------------//


    $sql		="UPDATE `merchant_pay` SET `pay_amount` = '$grandtotal' WHERE `pay_merchantid` = '$mid'";
    mysqli_query($con,$sql);




    //------------------------code added by rakhi------------------------------//

          //-----------------payment------------------------------------------//

          	 	$today=date("Y-m-d");
           		$sql3  = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
           		$sql3 .= "VALUES ('', '$mid', 'deposit', 'm','$amount','$today')";
           		mysqli_query($con,$sql3);

          //------------------------------------------------------------------//

          //-------making approved---------------------------------------------//

          	   if($grandtotal>$minimum_amount)
               {
                  $sql        ="UPDATE `partners_merchant` SET merchant_status='approved' where `merchant_id` = '$mid'";
        		  mysqli_query($con,$sql);
               }

          //-------------------------------------------------------------------//


    //-------------------------------------------------------------------------//



        $_SESSION['MERCHANTBALANCE']	=	$grandtotal;
        $msg         = $lang_add_success_message ;
        header("location:index.php?Act=add_money&msg=$msg");
        exit;
?>