<?php	
 //*****************************************************************************/

    include_once '../includes/db-connect.php';                            
    include_once '../includes/session.php';
    include '../includes/constants.php';
    include '../includes/functions.php';
     include_once '../includes/allstripslashes.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

    $handle = new partners;
	$name = trim($txtname);
	$email = trim($txtemail);
	$no		= trim($txtno);
	$payid = $_GET['payid'];
    $userid = 0;


	if (!$handle->is_email($email))
	{

			$msg ="Not a valid Email id";
			$err ="1";
	}
	else
		$err="0";

	if ($err != "0")
	{
		//case of error
		//$msg= "Enter values in all fields";
		header("Location:index.php?Act=paypal&payid=1&mode=edit&email=$email&ret=T&msg=$msg");
		exit;
	}
	else
	{
		$name = addslashes($name);
		$no = addslashes($no);
		$email = addslashes($email);
		// checking whether a record exist in the table
		$sql="select * from partners_paypal where paypal_user_id=$userid";
		$retpay = mysqli_query($con,$sql);
		if (mysqli_num_rows($retpay)>0)
		{
			$sql = "update partners_paypal set ";
			$sql.=" paypal_email='$email' where paypal_user_id=$userid";
			mysqli_query($con,$sql);
		}
		else
		{
			$sql = "insert into partners_paypal (paypal_email,paypal_user_id)values(";
			$sql.=" '$email',$userid)";
			mysqli_query($con,$sql);
		}
		$msg ="Updated Successfully";
		header("Location:index.php?Act=payments&payid=1&mode=edit&msg=$msg");
		exit;
	}

?>