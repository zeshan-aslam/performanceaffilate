<?php
include_once '../includes/constants.php';
  include_once '../includes/db-connect.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
   $MERCHANTID   =$_SESSION['MERCHANTID'];  
   global $con;
   if(isset($_POST['coupon_save']))
	{
		$postid = isset($_GET['coupon_id']) ? $_GET['coupon_id'] : -1;
		$name = mysqli_real_escape_string($con,$_POST['coupon_name']);
		$coupon = mysqli_real_escape_string($con,$_POST['coupon_coupon']);
		$discount_amount = mysqli_real_escape_string($con,$_POST['discount_amount']);
		$discount_type = mysqli_real_escape_string($con,$_POST['discount_type']);
		$valid_from = mysqli_real_escape_string($con,$_POST['coupon_valid_from']);
		$valid_to = mysqli_real_escape_string($con,$_POST['coupon_valid_to']);
		$detail = mysqli_real_escape_string($con,$_POST['coupon_detail']);
		$merchant_id = $MERCHANTID;
		if($postid == -1){
			$ok = mysqli_query($con,"INSERT INTO `affilate_coupon`( `name`, `coupon`, `valid_from`, `valid_to`, `coupon_detail`,`discount_amount`,`discount_type`, `merchant_id`,`date`) VALUES ('$name','$coupon','$valid_from','$valid_to','$detail','$discount_amount','$discount_type','$merchant_id',Now())");
			if($ok){
				$_SESSION['successcoupon'] = "Coupon saved successfully";
				header('Location:index.php?Act=coupons');
			}else{
				$_SESSION['faliurecoupon'] = "Please try again";
				header('Location:index.php?Act=add_coupon');
			}
		}else{
			$ok = mysqli_query($con,"UPDATE `affilate_coupon` SET `name`='$name',`coupon`='$coupon',`discount_amount`='$discount_amount',`discount_type`='$discount_type',`valid_from`='$valid_from',`valid_to`='$valid_to',`coupon_detail`='$detail' WHERE id = '$postid'");
			if($ok){
				$_SESSION['successcoupon'] = "Coupon updated successfully";
				header('Location:index.php?Act=add_coupon&action=edit&coupon_id='.$postid);
			}else{
				$_SESSION['faliurecoupon'] = "Please try again";
				header('Location:index.php?Act=add_coupon&action=edit&coupon_id='.$postid);
			}
		}		
	}
	
if(isset($_POST['action']) && $_POST['action'] == 'delete'){
	$tableid= $_POST['tableid'];
    $tablename= $_POST['table_name'];
   $return_url= $_POST['return_url'];
   global $prefix,$con;
	$table = $prefix.$tablename;

	$result = mysqli_query($con,"delete from $table where id='$tableid'");
  if($result){
	$_SESSION['success'] = "Record Successfully Deleted"; 
	echo $return_url;
	}else{
   echo mysqli_error($con);
  }
 }
?>