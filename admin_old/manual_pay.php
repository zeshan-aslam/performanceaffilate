<?php

	include '../includes/session.php';
	include '../includes/constants.php';
	include '../includes/functions.php';
	include '../includes/allstripslashes.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	include_once "../random_tableinsert.php";

?>
