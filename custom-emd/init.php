<?php
// define("PREFIX", "aa_");
define("PREFIX", "");
define("UPLOAD_DIR"    , "img/");
define("UPLOADED_FILES" , "UPLOADS/FILES/");

define("SITEURL", "https://performanceaffiliate.com/");
$server_name = "localhost";
$user_name   = "afdbuser";
$password    = "tnf-@840L";
$sl_db       = "db_per_aff_clone";

require_once("libs/messages_and_get_handling.php");
require_once("libs/db_op_class.php");
$db = new database_opeartions();
$db->db_connect($server_name,$user_name,$password,$sl_db);
  
require_once("libs/sec_class_new.php");
$sec = new security();

require_once("libs/class_functions.php");
$custom_fun = new custom_functions();








?>


