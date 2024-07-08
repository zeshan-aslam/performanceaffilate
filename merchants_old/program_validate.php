<?php	ob_start();
#---------------------------------------------------------------------------
# including files
#---------------------------------------------------------------------------
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
    include_once '../includes/allstripslashes.php';
#---------------------------------------------------------------------------
# setting connection
#---------------------------------------------------------------------------
    $partners	=	new partners;
    $partners->connection($host,$user,$pass,$db);

#---------------------------------------------------------------------------
# including language file
#---------------------------------------------------------------------------
  	include_once 'language_include.php';

#---------------------------------------------------------------------------
# getting all form variables
#---------------------------------------------------------------------------
    $_SESSION['DES']="";
    $_SESSION['SESS_RETVALUE']="";


     $url                   =stripslashes(trim($_POST['url']));
     $description           =stripslashes(trim($_POST['description']));
     $click                 =stripslashes(trim($_POST['click']));
     $lead                  =stripslashes(trim($_POST['lead']));
     $sale                  =stripslashes(trim($_POST['sale']));
     $saletype1             =stripslashes(trim($_POST['saletype1']));

     $clickr                =stripslashes(trim($_POST['clickr']));
     $leadr                 =stripslashes(trim($_POST['leadr']));
     $saler                 =stripslashes(trim($_POST['saler']));


     $clicke                =stripslashes(trim($_POST['clicke']));
     $leade                 =stripslashes(trim($_POST['leade']));
     $salee                 =stripslashes(trim($_POST['salee']));

     $second                =stripslashes(trim($_POST['second']));
     $secondtype            =stripslashes(trim($_POST['secondtype']));
     $secondtxt             =stripslashes(trim($_POST['secondtxt']));

     $mailaffil             =stripslashes(trim($_POST['mailaffil']));
     $mailme                =stripslashes(trim($_POST['mailme']));

     $affiliater            =stripslashes(trim($_POST['affiliater']));

     $status                =stripslashes(trim($_POST['status']));
     $ip                    =stripslashes(trim($_POST['ip']));
	 
     $countries				= array();
     if(is_array($_POST['sel_countries']))
     	$countries             = array_values($_POST['sel_countries']);

     $cookieTime			= $_POST['cookieTime'];
     $cookiePeriod			= $_POST['cookiePeriod'];

     $pgmDate               = date("Y-m-d");
     $currValue				= $_POST['currValue'];
	 
// ** Modified by SMA 17-JUNE-06  ** //
    $impression            =stripslashes(trim($_REQUEST['impression']));
    $geo_impression    =$_REQUEST['chk_geo_impression'];
    $impressionr           =stripslashes(trim($_REQUEST['impressionr']));
    $impressione           =stripslashes(trim($_REQUEST['impressione']));
    $impressionunit         =  stripslashes(trim($_REQUEST['impressionunit']));

//Modified for Recurring Commission
	$recur_sale			= $_REQUEST['chk_recursale'];
	$recur_percentage	= stripslashes(trim($_REQUEST['txt_recurpercent']));
	$recur_period		= stripslashes(trim($_REQUEST['cmb_recurperiod']));
// ** End Modify **//
	 
#---------------------------------------------------------------------------
# validation
#---------------------------------------------------------------------------

	if(empty($url))
	   $err = "1";
	else
	   $err = "0";


	if(empty($description))
	   $err .= ".1";

	else
	   $err .= ".0";

	//------Geo Targeting-----------
	$geo_click				= $_POST['chk_geo_click'];
	$geo_lead				= $_POST['chk_geo_lead'];
	$geo_sale				= $_POST['chk_geo_sale'];
	
	//if merchant has enabled geo targeting feature for click/lead/sale then he should select some countries
	if($geo_click=="on" or $geo_lead=="on" or $geo_sale=="on")
	{
		if(count($countries) < 1) $err .= ".1";
		else $err .= ".0";
	}else $err .= ".0";
	if($geo_click=="on") $geo_click = "1";
	else $geo_click = "0";
	if($geo_lead=="on") $geo_lead = "1";
	else $geo_lead = "0";
	if($geo_sale=="on") $geo_sale = "1";
	else $geo_sale = "0";
	
//Modified by SMA 17-JUNE-06 //
		if($geo_impression=="on") $geo_impression = "1";
		else $geo_impression = "0";
		//------Geo Targeting-----------
		
		//adding return values to variable, to be added along with all headers
		$retValues =  "&impression=$impression&geo_impression=$geo_impression&impressionr=$impressionr&impressione=$impressione&impressionunit=$impressionunit&geo_impression=$geo_impression&recur_sale=$recur_sale&recur_percentage=$recur_percentage&recur_period=$recur_period";
		
		$returnstring        = "url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues";
//End Modify //
#---------------------------------------------------------------------------
# empty checking
#---------------------------------------------------------------------------
if($err!="0.0.0")   
{
	$msg				=	$lpgm_error1;
	$_SESSION['DES']	=	$description;
	$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
	 header("Location:index.php?Act=newprogram");
	exit;
}elseif($second=="YES")
{

	#---------------------------------------------------------------------------
	# checking for isnumeric
	#---------------------------------------------------------------------------
	if(empty($secondtxt)) 
	{
		$msg			=	$lpgm_error6;
		$_SESSION['DES']=	$description;
		$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
		 header("Location:index.php?Act=newprogram");
		exit;
	}
	if((!is_numeric($secondtxt))) 
	{
		$msg			=	$lpgm_error7;
		$_SESSION['DES']=   $description;
		$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
		 header("Location:index.php?Act=newprogram");
		exit;
	}
	
}

//Program title can have maximum 80 characters
if(strlen($url)>80)
{
	$msg = $lpgm_error12;
	$_SESSION['DES']=   $description;
	$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
	 header("Location:index.php?Act=newprogram");	

	exit;
}

#---------------------------------------------------------------------------
# checking for isnumeric  (transactiob rates)
#---------------------------------------------------------------------------

//Modified on 17-JUNE-2006
	//checks if impression rate is numeric
	if(!empty($impression))
	{
		 if((!is_numeric($impression)))
		 {
				$msg                        =        $lpgm_error8  ;
				$_SESSION['DES']=        $description;
				$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
				 header("Location:index.php?Act=newprogram");
				exit;
		}
	}
	
	//checks if impression unit is valid
	if(!empty($impressionunit))
	{
		 if((!is_numeric($impressionunit)))
		 {
			  $msg                        =        $lpgm_error8  ;
			  $_SESSION['DES']=        $description;
								$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
								 header("Location:index.php?Act=newprogram");
			  //header("Location:index.php?Act=newprogram&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
			  exit;
		}
	}
//End modify

if((empty($click)) and  (empty($lead))  and (empty($sale)) and (empty($impression))) 
{
	$msg				=	$lpgm_error8;
	$_SESSION['DES']	=	$description;
	$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
	header("Location:index.php?Act=newprogram");	
	
	exit;
 }

if(!empty($click))
{
 	if((!is_numeric($click)))
	{
     	$msg			=	$lpgm_error8  ;
		$_SESSION['DES']=	$description;
		$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
		 header("Location:index.php?Act=newprogram");	

		exit;
	}
}
if(!empty($lead))
{
 	if((!is_numeric($lead)))
	{
        $msg			=	$lpgm_error8  ;
		$_SESSION['DES']=	$description;
		$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
		 header("Location:index.php?Act=newprogram");	

		exit;
	}
}
if(!empty($sale))
{
 	if((!is_numeric($sale)))
	{
        $msg			=	$lpgm_error8  ;
		$_SESSION['DES']=	$description;
		$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
		 header("Location:index.php?Act=newprogram");	

		exit;
	}
}

//Added by SMA on 20-JUNE-2006	
	if($recur_sale)
	{
		if(empty($recur_percentage)) {
			$msg = $err_enterRecurPercent;
			$_SESSION['DES']=	$description;
			$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
			 header("Location:index.php?Act=newprogram");	
			exit;
		} else {
			if((!is_numeric($recur_percentage))) {
				$msg = $lpgm_error8;
				$_SESSION['DES']=	$description;
				$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
				header("Location:index.php?Act=newprogram");	
				exit;
			}
		}
		if(empty($recur_period)) {
			$msg = $err_enterRecurperiod;
			$_SESSION['DES']=	$description;
			$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
			 header("Location:index.php?Act=newprogram");	
			exit;
		} else {
			if((!is_numeric($recur_period)) || ($recur_period == 0)) {
				$msg = $err_validRecurPeriod;
				$_SESSION['DES']=	$description;
				$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
				header("Location:index.php?Act=newprogram");	
				exit;
			}
		}
	}
//End Add on 20-JUNE-2006

#---------------------------------------------------------------------------
# checking for valid ip block time
#---------------------------------------------------------------------------
if(!empty($ip))
{
 	if((!is_numeric($ip)))
	{
     	$msg			=	$lpgm_error9  ;
		$_SESSION['DES']=	$description;
		$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
		 header("Location:index.php?Act=newprogram");	

        exit;
	}
}

#---------------------------------------------------------------------------
# checking for valid cookie time
#---------------------------------------------------------------------------
if(!empty($cookieTime))
{
 	if((!is_numeric($cookieTime)))
	{
     	$msg			=	$lpgm_errorCookie  ;
		$_SESSION['DES']=	$description;
		$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
		 header("Location:index.php?Act=newprogram");	
        exit;
	}
}

#---------------------------------------------------------------------------
# checking whether normal user adds more than one pgm
#---------------------------------------------------------------------------
   $sql		=	"SELECT  * FROM partners_merchant,partners_program  WHERE merchant_id =  '$MERCHANTID' AND merchant_type   = 'normal' and merchant_id=program_merchantid";
   $result  = mysqli_query($con,$sql);
   if(mysqli_num_rows($result)>0)
   {
		$msg				=	$lpgm_error2;
		$_SESSION['DES']	=	$description;
		
		header("Location:index.php?Act=accounts&fromprg=$msg");
		exit;
   }
   else{

          $url                   =addslashes(trim($_POST['url']));
          $description           =addslashes(trim($_POST['description']));
          $click                 =addslashes(trim($_POST['click']));
          $lead                  =addslashes(trim($_POST['lead']));
          $sale                  =addslashes(trim($_POST['sale']));
          $saletype1             =addslashes(trim($_POST['saletype1']));

          $clickr                =addslashes(trim($_POST['clickr']));
          $leadr                 =addslashes(trim($_POST['leadr']));
          $saler                 =addslashes(trim($_POST['saler']));


          $clicke                =addslashes(trim($_POST['clicke']));
          $leade                 =addslashes(trim($_POST['leade']));
          $salee                 =addslashes(trim($_POST['salee']));

          $second                =addslashes(trim($_POST['second']));
          $secondtype            =addslashes(trim($_POST['secondtype']));
          $secondtxt             =addslashes(trim($_POST['secondtxt']));

          $mailaffil             =addslashes(trim($_POST['mailaffil']));
          $mailme                =addslashes(trim($_POST['mailme']));

          $affiliater            =addslashes(trim($_POST['affiliater']));

          $status                =addslashes(trim($_POST['status']));
          $ip                    =addslashes(trim($_POST['ip']));

         #---------------------------------------------------------------------------
         # hetting mail to affiliate and me while transaction happens
         #---------------------------------------------------------------------------
          if($mailaffil=="")  $aval="no";
          else                $aval="yes";

          if($mailme=="")     $mval="no";
          else                $mval="yes";

          $today = date("Y-m-d");

        #-----------------------------------------------------------------
        #check for approval type
        #-----------------------------------------------------------------

        $newSql = "SELECT merchant_pgmapproval FROM partners_merchant WHERE merchant_id ='$MERCHANTID' "    ;
        $newRet = mysqli_query($con,$newSql);

        $merPgmType = "manual";

        if(mysqli_num_rows($newRet)){
        	$newRow 	=  mysqli_fetch_object($newRet);
            $merPgmType = $newRow->merchant_pgmapproval;
        }

        if($merPgmType=="manual"){
                $pgmstatus = 'inactive';
        }else{
                $pgmstatus = 'active';
        }

        #---------------------------------------------------------------------------
        #inseting to pgm table
        #---------------------------------------------------------------------------

        $newCookie = $cookieTime." ".$cookiePeriod;
        $country_list = implode(",",$countries);

//Modified on 17-JUNE-2006
		$sql1="INSERT INTO `partners_program` ( `program_id` , `program_merchantid` , `program_url` , `program_description` , `program_ipblocking` , `program_cookie`,`program_date` , `program_status`,`program_countries`,`program_geotargeting_click`,`program_geotargeting_lead`,`program_geotargeting_sale`, program_geotargeting_impression)
						VALUES ('', '$MERCHANTID', '$url', '$description', '$ip','$newCookie', '$today', '$pgmstatus','$country_list','$geo_click','$geo_lead','$geo_sale', '$geo_impression')";

	    mysqli_query($con,$sql1);

	    $curentid	=	mysql_insert_id();

        $newCookie  = "USERCOOKIE_FOR_TRACKING_".$curentid;

       // $$newCookie  = "ANP";
       $USERCOOKIE_FOR_TRACKING[$curentid] = "ANP";


       #---------------------------------------------------------------------------
       # inserting all the status to pgmstatus table
       #---------------------------------------------------------------------------
//Modified on 17-JUNE-2006
        $sql2="INSERT INTO `partners_pgmstatus` (`pgmstatus_programid` , `pgmstatus_clickapproval` , `pgmstatus_leadapproval` , `pgmstatus_saleapproval` , `pgmstatus_mailaffiliate` , `pgmstatus_mailmerchant` , `pgmstatus_affiliateapproval`,pgmstatus_clickmail,pgmstatus_leadmail,pgmstatus_salemail,pgmstatus_impressionapproval,pgmstatus_impressionmail )
                            VALUES ('$curentid', '$clickr', '$leadr', '$saler', '$aval', '$mval', '$affiliater','$clicke','$leade','$salee','$impressionr', '$impressione')";

      #---------------------------------------------------------------------------
      # inserting coommion details
      #---------------------------------------------------------------------------
       if($currValue != $default_currency_caption)   {
               $click = getDefaultCurrencyValue($pgmDate, $currValue, $click)  ;
               $lead  = getDefaultCurrencyValue($pgmDate, $currValue, $lead)  ;
               if($saletype1 != "%") $sale =  getDefaultCurrencyValue($pgmDate, $currValue, $sale)  ;
			  $impression  = getDefaultCurrencyValue($pgmDate, $currValue, $impression)  ;
       }

       $click =   round($click,2);
       $lead  =   round($lead,2);
       $sale  =   round($sale,2);
	   $impression  =   round($impression,2);

//Modified on 20-JUNE-2006
		if($recur_sale) $recur_sale = "1"; else $recur_sale = "0";
				
	  	/*$sql4="INSERT INTO `partners_firstlevel` (`firstlevel_programid` , `firstlevel_clickrate` , `firstlevel_leadrate` , `firstlevel_salerate` , `firstlevel_saletype`, firstlevel_impressionrate, firstlevel_unitimpression )
						VALUES ('$curentid', '$click', '$lead', '$sale', '$saletype1','$impression', '$impressionunit' )";
*/
		$sql4="INSERT INTO `partners_firstlevel` (`firstlevel_programid` , `firstlevel_clickrate` , `firstlevel_leadrate` , `firstlevel_salerate` , `firstlevel_saletype`, firstlevel_impressionrate, firstlevel_unitimpression, firstlevel_recur_sale, firstlevel_recur_percentage, firstlevel_recur_period)
						VALUES ('$curentid', '$click', '$lead', '$sale', '$saletype1','$impression', '$impressionunit', '$recur_sale', '$recur_percentage', '$recur_period')";

	    mysqli_query($con,$sql4);

        mysqli_query($con,$sql2);

		 #---------------------------------------------------------------------------
		 # inserting secondtire detils
		 #---------------------------------------------------------------------------
		 if($second=="YES") {
				$sql3="INSERT INTO `partners_secondlevel` ( `secondlevel_id` , `secondlevel_programid` , `secondlevel_clickrate` , `secondlevel_leadrate` , `secondlevel_salerate` , `secondlevel_saletype` )
					   VALUES ('', '$curentid', '0', '0', '$secondtxt', '$secondtype')";
	
			   mysqli_query($con,$sql3);
		 }
		 payProgramFee($MERCHANTID,$program_fee,$curentid);
	
		   $msg		=	$lpgm_success	;
		   header("Location:index.php?Act=programs&programs=$curentid");

  }




?>