<?php		ob_start();
	//
    include_once '../includes/session.php';
 	include_once '../includes/constants.php' ;
 	include_once '../includes/functions.php';
    include_once '../includes/allstripslashes.php';

    $connection=new partners;
 	$connection->connection($host,$user,$pass,$db);

    $version = trim($_POST['version']);
	$delimdata = trim($_POST['delimdata']);
	$relayresponse		= trim($_POST['relayresponse']);
	$login = trim($_POST['login']);
	$trankey = trim($_POST['trankey']);
	$cctype		= trim($_POST['cctype']);


	$payid = $_GET['payid'];
    $userid = 0;
    echo $payid;
    if (empty($login))
		$err ="1";
	else
		$err="0";


	$msg ="Login cannot be null";

	if ($err != "0")
	{
		//case of error
		$msg= urlencode($msg);
		header("Location:index.php?Act=creditcard&payid=3&mode=edit&version=$version&delimdata=$delimdata&relayresponse=$relayresponse&trankey=$trankey&cctype=$cctype&msg=$msg");
		exit;
	}
	else
	{

		// checking whether a record exist in the table
		$sql="select * from partners_creditcard";
		$retpay = mysql_query($sql);
		if (mysql_num_rows($retpay)>0)
		{
			$sql = "update partners_creditcard set ";
			$sql.=" cc_version='$version',cc_delimdata='$delimdata',cc_relayresponse='$relayresponse',cc_login='$login',cc_trankey='$trankey',cc_type='$cctype' ";
			mysql_query($sql);
			//echo $sql;
		}
		else
		{
			$sql = "insert into partners_creditcard (cc_version,cc_delimdata,cc_relayresponse,cc_login,cc_trankey,cc_type)
			 values('$version','$delimdata','$relayresponse','$login','$trankey','$cctype')";
			//echo $sql;
			mysql_query($sql);
		}
    	$msg ="Updation Successfull!!!!";
       	header("Location:index.php?Act=payments&payid=1&mode=edit&msg=$msg");
		exit;
	}

?>