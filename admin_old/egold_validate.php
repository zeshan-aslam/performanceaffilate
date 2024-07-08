<?php	ob_start();

 //*****************************************************************************/

    include_once '../includes/session.php';
    include '../includes/constants.php';
    include '../includes/functions.php';
    include_once '../includes/allstripslashes.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

	$nname = trim($txtpayeename);
	$acno  = trim($txtacno);
	$goldid = $_GET['goldid'];
    $userid = 0;

		$name 	= addslashes($name);
		$no 	= addslashes($no);
		$email 	= addslashes($email);
		// checking whether a record exist in the table
		$sql="select * from partners_egold where egold_user_id='$userid'";
		$retpay = mysql_query($sql);
		if (mysql_num_rows($retpay)>0)
		{
			$sql = "update partners_egold set ";
			$sql.=" egold_accno='$acno',egold_payeename='$nname' where egold_user_id='$userid'";
			mysql_query($sql);
		}
		else
		{
			$sql = "insert into partners_egold (egold_accno,egold_payeename,egold_user_id)values(";
			$sql.=" '$acno','$nname','$userid')";
			mysql_query($sql);
		}
		$msg ="Update Successfull";
		header("Location:index.php?Act=payments&payid=5&mode=edit&msg=$msg");
		exit;

?>