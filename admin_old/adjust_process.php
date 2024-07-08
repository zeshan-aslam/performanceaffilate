<?php

include_once '../includes/db-connect.php';
  include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include '../includes/allstripslashes.php';



 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);

 $id			=intval($_GET['id']);
 $amount		=$_POST['amount'];
 $action   		=$_POST['action'];

 //geting records from table
   	  $affiliate_sql ="SELECT * FROM   affiliate_pay  WHERE pay_affiliateid='$id'";
	  $affiliate_ret =mysqli_query($con,$affiliate_sql);

	  //checking for each records
	  if(mysqli_num_rows($affiliate_ret)>0)
	  {
	          $row                  =mysqli_fetch_object($affiliate_ret);
	          $affiliate_pay_amount =$row->pay_amount;

	  }

    /*  //geting records from table
   	  $admin_sql ="SELECT * FROM   admin_pay  ";
	  $admin_ret =mysqli_query($con,$admin_sql);

	  //checking for each records
	  if(mysqli_num_rows($admin_ret)>0)
	  {
	          $row                  =mysqli_fetch_object($admin_ret);
	          $admin_pay_amount    =$row->pay_amount;

	  }                         */

 $amount = $amount;
 if(($action=="add")||(($action=="deduct") && (($affiliate_pay_amount-$amount)>0)))
 {
	     switch($action)
	     {
	     case 'add' :
	          $affiliate_pay_amount += $amount;
             // $admin_pay_amount    -= $amount;
			//-----if after adding the amount it exceeded the maximum limit set up by the admin----
			if($affiliate_pay_amount>$affiliate_maximum_amount)
			{
				//redirect back to the page along with the message
				$msg = urlencode("Amount cannot be added since it exceeds the maximum balance amount limit.");
				header("Location:index.php?Act=adjust_affiliate&affid=$id&msg=$msg");
 				exit;
			}	
	         break;
	      case 'deduct' :
	         $affiliate_pay_amount -= $amount;
           //  $admin_pay_amount     += $amount;
	         break;

	     }


	      /* $sql ="update admin_pay set pay_amount='$admin_pay_amount'";
	       $ret =mysqli_query($con,$sql); */

           $today=date("Y-m-d");
           $sql  = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
           $sql .= "VALUES ('', '$id', '$action', 'a','$amount','$today')";
           mysqli_query($con,$sql);

	      //paying for affiliate
           $sql ="update affiliate_pay set pay_amount='$affiliate_pay_amount' where pay_affiliateid='$id'";
           $ret =mysqli_query($con,$sql);

    $msg="Amount"." ".$action."ed successfully";
  }
    else
  {
  	 $msg="Sorry Affiliate Account  doesn't have sufficient amount to do this transaction ";
  }
  $msg		=urlencode($msg);
  header("Location:index.php?Act=adjust_affiliate&affid=$id&msg=$msg");
 exit;
?>