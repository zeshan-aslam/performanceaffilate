<?php
  /**

   * Messages Part

   */

$success_message_contents ='<strong>Success!</strong> Action has performed Successfully.';  
$error_message_contents   ='<strong>Error!</strong> Something going wrong unable perform action.';  
$file_upload_error        ='<strong>Error!</strong> Something going wrong unable upload file.';  
$duplicate_error          ='<strong>Error!</strong> Unable to Insert duplicate value.';
$bid_off                  ='<strong>Error!</strong> You Can not bid right now, wait until next bid.';
$bid_on                   ='<strong>Success!</strong> Bid Successfully.';
$car_add                   ='<strong>Error!</strong> Car already added.';

define("SUCCESS", $success_message_contents);     #code ACKT 
define("ERROR", $error_message_contents);         #code ACKF
define("FILE_UPLOAD_ERROR", $file_upload_error);  #
define("DUP_ERROR",$duplicate_error);
define("BID_ON",$bid_on);
define("BID_OFF",$bid_off);
define("CAR_ADD",$car_add);		      		 	

   /**

   * $_GET Handling

   */
#ACTION = FVA (Values for FVA)
define("EC", "B8EC");  #EC Edit Commond  (B BASE)  
define("IX", "B1IX");  #IX Insert Extra  (B BASE)   
define("SENTID", "MDAKI");  #SENTID (When sending url with ID)
define("SENTIDU","MDAKU"); 
define("ACT","SEPW");   #ACT (Using short form of action)  
?>