<?php

	include_once 'includes/db-connect.php';
	
	
	$sql = " TRUNCATE TABLE `partners_aianalytics` ";
	mysqli_query($con,$sql);

	$sql = " TRUNCATE TABLE `partners_aibannedips` ";
	mysqli_query($con,$sql);

	$sql = " TRUNCATE TABLE `partners_aiowner` ";
	mysqli_query($con,$sql);

	$sql = " TRUNCATE TABLE `partners_aitrackinginfo` ";
	mysqli_query($con,$sql);

	$sql = " TRUNCATE TABLE `partners_auid` ";
	mysqli_query($con,$sql);

	$sql = " TRUNCATE TABLE `partners_ipstats` ";
	mysqli_query($con,$sql);

	$sql = " TRUNCATE TABLE `partners_owner_auid` ";
	mysqli_query($con,$sql);

	$sql = " TRUNCATE TABLE `partners_owner_auid_ip` ";
	mysqli_query($con,$sql);



?>