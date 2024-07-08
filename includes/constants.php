<?php

#-----------------------------------------------------------------------------
# Databse parametrs
#-----------------------------------------------------------------------------
 
 
#-----------------------------------------------------------------------------
# Payment parametrs
#-----------------------------------------------------------------------------

//Added on 4-AUG-2006 for default Currency
	$default_currency_code		= "GBP";
	$default_currency_caption	= "Pound";

//For Automatic Updates of Currency Rates From XE.com	
	$const_getCurrencyRatesFromXe		= "0";

//Added on 19-JUNE for Fraud Protection
	$fraudsettings_recentclick 		= "0"; 
	$fraudsettings_clickseconds 	= "12";
	$fraudsettings_clickaction 		= "do not save"; 
	$fraudsettings_recentsale 		= "0";
	$fraudsettings_saleseconds 		= "10";
	$fraudsettings_saleaction 		= "decline";
	$fraudsettings_decline_recentsale = "1";
	$fraudsettings_login_retry 		= "2";
	$fraudsettings_login_delay 		= "10";
	
	//Added on 16-JUNE-2006
    $const_imp_rate    =0;

	//minimum ammounts of deposit for merchants
	$normal_user       =0;
	$advanced_user     =0;
	$admin_clickrate   =10;
	$admin_salerate    =10;
	$admin_leadrate    =10;
	$minimum_amount    =25;
	$minimum_withdraw  =25;
    $program_fee       = 0;
    $program_type       =1;
    $program_value      ="7 month";
    $membership_type       =1;
    $membership_value      ="1 month";
	
	//Maximum amount limits for merchants/affiliates/admin
	$merchant_maximum_amount 	= 1000000;
	$affiliate_maximum_amount 	= 1000000;
	$admin_maximum_amount		= 4000000;
	
	//Commission type (flatrate/percentage) for click/lead/sale
	global $admin_clickrate_type;
	global $admin_leadrate_type;
	global $admin_salerate_type;
	$admin_clickrate_type		= "percentage";
	$admin_leadrate_type		= "percentage";
	$admin_salerate_type		= "percentage";
	
   # icon width and Height
   global $icon_height;
   $icon_height = "16";

   global $icon_width;
   $icon_width  = "16";

   $timeZoneArray  = array( "Newzealand Time(-12)"
   							,"Midway Isles, Samoa (-11)"
                            ,"Hawaii (-10)"
                            ,"AKST - Alaska Standard Time(-9)"
   							,"PST - Pacific Standard Time(-8)"
                            ,"MST - Mountain Standard Time(-7)"
                    		,"CST - Central Standard Time(-6)"
                            ,"EST - Eastern Standard Time(-5)"
                    		,"SA West - Atlantic Time(-4)"
                            ,"SA East - East Brasil Time (-3)"
                   			,"Middle Atlantic (-2)"
                            ,"Island Time (-1)"
                            ,"GMT - Greenwitch Meridian Time (0)"
                    		,"CET - Central European Time (+1)"
                            ,"EET - East European Time (+2)"
                            ,"Irak, Kuwait, Russia(+3)"
                    		,"Mauritius, Kazachstan (+4)"
                    		,"West Asia (+5)"
                            ,"Central Asia (+6)"
                    		,"Indo China Time (+7)"
                    		,"Chinese Shore Time (+8)"
                    		,"JST - Japan Standard Time (+9)"
                            ,"AUS - Australian Time(+10)"
                    		,"Central Pacifik (+11)"
                            ,"Newzealand Time (12)"
                         );

#-----------------------------------------------------------------------------
# Site Title and no of rec
#-----------------------------------------------------------------------------
	$title  = "Performance Affiliate Network";
	$lines  = 10;

#-----------------------------------------------------------------------------
# Site Url
#-----------------------------------------------------------------------------
$secured_site_url = "https://performanceaffiliate.com";
$track_site_url   = "https://performanceaffiliate.com";

#-----------------------------------------------------------------------------
# Cooments
#-----------------------------------------------------------------------------
	$norec      = "No Records of this type" ;
	$blank      = "Invalid Entry. Please fill in all required fields";
	$emailerr   = "Please Enter a valid E-mail Id";
	$emailexist = "E-mail Id already Exists";


  $currArray 	= array('Yen'=>'&yen','Pound'=>'&pound','Swiss Francs'=>'CHF','Euro'=>'&euro;');

   reset ($_GET);
     foreach ($_GET as $key => $value)//to stripslash all get variables
     {
           $value	=	stripslashes(trim($value));
           $_GET[$key]=$value;
     }

     reset ($_POST);

    foreach ($_POST as $key => $value)//to stripslash all posted variables
     {
          $value	=	stripslashes(trim($value));
          $$key		=	$value;
          //echo "$key=>$value <br/>";
     }


    reset ($_GET);
    reset ($_POST);

?>