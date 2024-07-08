<?php
ob_start();
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

   $host       ='localhost';
   $user       ='afdbuser';
   $pass       ='tnf-@840L';
   $db         ='db_per_aff_clone';


   $con = mysqli_connect($host,$user,$pass,$db);

   $GLOBALS["con"] = $con;

   if(mysqli_connect_error())
   {
   		die("Failed to connect to MySql: ".mysqli_connect_error());
   }
	

?>