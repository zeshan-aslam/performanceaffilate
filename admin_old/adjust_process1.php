<?php	

	include_once '../includes/db-connect.php';
	include '../includes/session.php';
	include '../includes/constants.php';
	include '../includes/functions.php';
	include '../includes/allstripslashes.php';
	
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$id			= intval($_GET['id']);
	$amount		= $_POST['amount'];
	$action   	= $_POST['action'];

	//geting records from table
	$merchant_sql = "SELECT * FROM merchant_pay WHERE pay_merchantid='$id'";
	$merchant_ret = mysqli_query($con,$merchant_sql);
	
	//checking for each records
	if(mysqli_num_rows($merchant_ret)>0)
	{
		$row                  =mysqli_fetch_object($merchant_ret);
		$merchant_pay_amount =$row->pay_amount;
	}

	$amount = $amount;

 	if(($action=="add")||(($action=="deduct") && (($merchant_pay_amount-$amount)>$minimum_amount)))
 	{
		switch($action){
			case 'add' :
				$merchant_pay_amount += $amount;
				//  $admin_pay_amount    -= $amount;
				//-----if after adding the amount it exceeded the maximum limit set up by the admin----
				if($merchant_pay_amount>$merchant_maximum_amount and !empty($merchant_maximum_amount))    //17AUG2005
				{
					//redirect back to the page along with the message
					$msg = urlencode("Amount cannot be added since it exceeds the maximum balance amount limit.");
					header("Location:index.php?Act=adjust_merchant&merid=$id&msg=$msg");
					exit;
				}
			break;
			case 'deduct' :
				$merchant_pay_amount -= $amount;
			break;
		 }

	  //paying for merchant
	       $sql = "update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$id'";
	       $ret = mysqli_query($con,$sql);

      	   if($merchant_pay_amount>$minimum_amount)
           {
                  $sql	= "UPDATE `partners_merchant` SET merchant_status='approved' where `merchant_id` = '$id'";
        		  mysqli_query($con,$sql);
           }else{
                  $sql	= "UPDATE `partners_merchant` SET merchant_status='empty' where `merchant_id` = '$id'";
        		  mysqli_query($con,$sql);
           }

           $today=date("Y-m-d");
           $sql  = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
           $sql .= "VALUES ('', '$id', '$action', 'm','$amount','$today')";
           mysqli_query($con,$sql);

    $msg="Amount"." ".$action."ed successfully";
  }
  else
  {
  	 $msg="Sorry Merchant Account doesn't have sufficient amount to do this transaction ";
  }
  $msg		=urlencode($msg);
  header("Location:index.php?Act=adjust_merchant&merid=$id&msg=$msg");
 exit;
?>