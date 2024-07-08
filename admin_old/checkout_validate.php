<?php	ob_start();
 //*****************************************************************************/

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
		if (!empty($name) && !empty($no))
			$msg ="Not a valid Email id";
		$err ="1";
	}
	else
		$err="0";

	if ($err != "0")
	{
		//case of error
		//$msg= "Enter values in all fields";
		header("Location:index.php?Act=checkout&payid=1&mode=edit&email=$email&ret=T&msg=$msg");
		exit;
	}
	else
	{
		$name = addslashes($name);
		$no = addslashes($no);
		$email = addslashes($email);
		// checking whether a record exist in the table
		$sql="select * from partners_checkout where checkout_user_id='$userid'";
		$retpay = mysql_query($sql);
		if (mysql_num_rows($retpay)>0)
		{
			$sql = "update partners_checkout set ";
			$sql.=" checkout_email='$email' where checkout_user_id='$userid'";
			mysql_query($sql);
		}
		else
		{
			$sql = "insert into partners_checkout (checkout_email,checkout_user_id)values(";
			$sql.=" '$email','$userid')";
			mysql_query($sql);
		}
		$msg ="Update Successfull";
		header("Location:index.php?Act=payments&payid=1&mode=edit&msg=$msg");
		exit;
	}

?>