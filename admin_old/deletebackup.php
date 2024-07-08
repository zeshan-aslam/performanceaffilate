<?php   
	$filename 	= $_GET['fl'];
	$path		= "dump/$filename";

	if (file_exists($path))
	{
		unlink($path);
	}
	header("Location:restore.php");
	exit;
?>