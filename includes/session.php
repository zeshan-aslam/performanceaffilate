<?php

	  // Report simple running errors
    
  
    /*
    $_SESSION["CRMMERCHANT"] = "";
    $_SESSION["ADMIN"] = "";
    $_SESSION["ADMINNAME"] = "";
    $_SESSION["MAIL"] = "";
    $_SESSION["MERCHANT"] = "";
    $_SESSION["AFFILIATE"] = "";
    $_SESSION["HEADER"] = "";
    $_SESSION["BODY"] = "";
    $_SESSION["FOOTER"] = "";
    $_SESSION["msg"] = "";
    $_SESSION["res"] = "";
    $_SESSION["SESSIONSTATUS"] = "";
    $_SESSION["JOINSTATUS"] = "";
    $_SESSION["MERCHANTID"] = "";
    $_SESSION["AFFILIATEID"] = "";
    $_SESSION["PROGRAMID"] = "";
    $_SESSION["DES"] = "";
    $_SESSION["LINKS"] = "";
    $_SESSION["PGMID"] = "";
    $_SESSION["MAILAMNT"] = "";
    $_SESSION["MAILHEADER"] = "";
    $_SESSION["MAILFOOTER"] = "";
    $_SESSION["TRANS_MERCHANTID"] = "";

    $_SESSION["BANNERCODE"] = "";
    $_SESSION["VAR"] = "";

   $_SESSION["SORTINGTABLE"] = "";
   $_SESSION["MER_SORTINGTABLE"] = "";
   $_SESSION["CAT_SORTING"] = "";
   $_SESSION["LANGUAGE"] = "";
   $_SESSION["MERCHANTNAME"] = "";
   $_SESSION["PAYMODE"] = "";
   $_SESSION["MERCHANTBALANCE"] = "";

   $_SESSION["AFFILIATENAME"] = "";

   $_SESSION["AFFILIATEBALANCE"] = "";
   
   $_SESSION["ADMINLASTLOGGEDIP"] = "";
   $_SESSION["USERRETRIEDCOUNT"] = "";
   $_SESSION["ADMINUSERID"] = "";
   
   $_SESSION["DEFAULTCURRENCYSYMBOL"] = "";
   
   $_SESSION["AFF_ADDRESS"] = "";
   $_SESSION["MER_ADDRESS"] = "";
   
   $_SESSION["AFFILIATE_REFERER_ID"] = "";
   */


   $USERCOOKIE_FOR_TRACKING = array();
  
	//to get all session variables
    foreach ($_SESSION as $key => $value)
    {
           $value=stripslashes(trim($value));
           $$key=$value;           
    }  
?>