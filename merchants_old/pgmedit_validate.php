<?php  ob_start();
#  modified 19/1/2005

#---------------------------------------------------------------------------
# including files
#---------------------------------------------------------------------------
        include_once '../includes/constants.php';
        include_once '../includes/functions.php';
        include_once '../includes/function1.php';
        include_once '../includes/session.php';
    include_once '../includes/allstripslashes.php';
#---------------------------------------------------------------------------
# setting connection
#---------------------------------------------------------------------------
    $partners        =        new partners;
    $partners->connection($host,$user,$pass,$db);

#---------------------------------------------------------------------------
# including language file
#---------------------------------------------------------------------------
          include_once 'language_include.php';

#---------------------------------------------------------------------------
# getting all form variables
#---------------------------------------------------------------------------

  $mode                                        =$_GET['mode'];
  $pgmid                                   =$_GET['id'];
  $_SESSION['DES']                ="";

  $pgmDate               = date("Y-m-d");
  $currValue                         = $_POST['currValue'];

  $url                  =stripslashes(trim($_POST['url']));
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

  $affiliater            =$_POST['affiliater'];

  $status                =$_POST['status'];
  $ip                    =$_POST['ip'];

  // ** Modified by SMA 22-Feb-06  ** //
  $impression            =stripslashes(trim($_REQUEST['impression']));
  $geo_impression    =$_REQUEST['chk_geo_impression'];
  $impressionr           =stripslashes(trim($_REQUEST['impressionr']));
  $impressione           =stripslashes(trim($_REQUEST['impressione']));
  $impressionunit         =  stripslashes(trim($_REQUEST['impressionunit']));
  
  //modified for Recurring Commission
	$recur_sale			= $_REQUEST['chk_recursale'];
	$recur_percentage	= stripslashes(trim($_REQUEST['txt_recurpercent']));
	$recur_period		= stripslashes(trim($_REQUEST['cmb_recurperiod']));
  
  // ** End Modify **//
        ## ** Modifiedon 11-apr-06  ** ##
   $cookieTime                        = $_POST['cookieTime'];
   $cookiePeriod                  = $_POST['cookiePeriod'];
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
     $countries                                = array();
     if(is_array($_POST['sel_countries']))
             $countries             = array_values($_POST['sel_countries']);
        $geo_click                                = $_POST['chk_geo_click'];
        $geo_lead                                = $_POST['chk_geo_lead'];
        $geo_sale                                = $_POST['chk_geo_sale'];

        //if merchant has enabled geo targeting feature for click/lead/sale then he should select some countries
        if($geo_click=="on" or $geo_lead=="on" or $geo_sale=="on" or $geo_impression=="on")
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

        //Modified by SMA 22-Feb-06 //
          if($geo_impression=="on") $geo_impression = "1";
          else $geo_impression = "0";

          //adding return values to variable, to be added along with all headers
          $retValues =  "&txt_totalcommission=$txt_totalcommission&txt_completion_date=$txt_completion_date&impression=$impression&geo_impression=$geo_impression&impressionr=$impressionr&impressione=$impressione&impressionunit=$impressionunit&geo_impression=$geo_impression&vip_pgm=$vip_pgm";
        //End Modify //
        //------Geo Targeting-----------

if($err!="0.0.0")
{  
    $msg                        =        $lpgm_error1 ;
    $_SESSION['DES']=        $description;

    //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale&countries=$countries$retValues");
    header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
    exit;
}

//Program title can have maximum 80 characters
if(strlen($url)>80)
{
        $msg = $lpgm_error12;
        $_SESSION['DES']=   $description;

        //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
        header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
        exit;
}

#---------------------------------------------------------------------------
# checking for isnumeric  (transaction rates)
#---------------------------------------------------------------------------
 //modified by SMA 2-Feb-06

   //checks if impression rate is numeric
   if(!empty($impression)){
         if((!is_numeric($impression)))
         {
              $msg                        =        $lpgm_error8  ;
              $_SESSION['DES']=        $description;

              //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
              header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
              exit;
        }
   }

   //checks if impression unit is valid
   if(!empty($impressionunit)){
         if((!is_numeric($impressionunit)))
         {
              $msg                        =        $lpgm_error8  ;
              $_SESSION['DES']=        $description;

              //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
              header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
              exit;
        }
   }

 //End modify

//echo   $click."-".$sale."-".$lead;
if((empty($click)) and  (empty($lead))  and (empty($sale)) and (empty($impression)))
{
       $msg                                =        $lpgm_error8;
       $_SESSION['DES']        =        $description;

       //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
       header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
       exit;
 }


if((!empty($click)))
{
     if((!is_numeric($click)))
     {
             $msg                        =        $lpgm_error8  ;
             $_SESSION['DES']=        $description;

             //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
             header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
             exit;
     }
}
if(!empty($lead))
{
        if((!is_numeric($lead)))
        {
             $msg                        =        $lpgm_error8  ;
             $_SESSION['DES']=        $description;

             //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
             header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
             exit;
        }
}
if(!empty($sale))
{
        if((!is_numeric($sale)))
        {
             $msg                        =        $lpgm_error8  ;
             $_SESSION['DES']=        $description;

             //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
             header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
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
			 header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale");	
			exit;
		} else {
			if((!is_numeric($recur_percentage))) {
				$msg = $lpgm_error8;
				$_SESSION['DES']=	$description;
				$_SESSION['SESS_RETVALUE']        =        "&$returnstring&msg=$msg";
				header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale");	
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
if(!empty($ip)){
    if((!is_numeric($ip))){
            $msg                        =        $lpgm_error9  ;
            $_SESSION['DES']=        $description;

            //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
            header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
            exit;
    }
}

#---------------------------------------------------------------------------
# checking for valid cookie time
#---------------------------------------------------------------------------
if(!empty($cookieTime)){
    if((!is_numeric($cookieTime))){
             $msg                        =        $lpgm_errorCookie  ;
             $_SESSION['DES']=        $description;

             //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&cookie=$cookieTime&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
             header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");
             exit;
    }
}


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

  ## ** Modifiedon 11-apr-06  ** ##
  $vip_pgm   =stripslashes(trim($_REQUEST['vip_pgm']));

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
                $newRow         =  mysqli_fetch_object($newRet);
            $merPgmType = $newRow->merchant_pgmapproval;
        }

        if($merPgmType=="manual"){
                $pgmstatus = 'inactive';
        }else{
                $pgmstatus = 'active';
        }



    #---------------------------------------------------------------------------
    #inserting to pgm table
    #---------------------------------------------------------------------------
      $newCookie = $cookieTime." ".$cookiePeriod;
      $country_list = implode(",",$countries);
            $sql1= "UPDATE `partners_program` SET `program_id` = '$pgmid',
                        `program_merchantid` = '$MERCHANTID',
                        `program_url` = '$url',
                        `program_description` = '$description',
                        `program_ipblocking` = '$ip',
                        `program_cookie` = '$newCookie',
                        `program_date` = '$today',
                        `program_countries` = '$country_list',
                        `program_status` = '$pgmstatus',
                                                `program_geotargeting_click` = '$geo_click',
                                                `program_geotargeting_lead` = '$geo_lead',
                                                `program_geotargeting_sale` = '$geo_sale',
                                                program_geotargeting_impression = '$geo_impression'
                         WHERE `program_id` = '$pgmid'" ;


            mysqli_query($con,$sql1);

    #---------------------------------------------------------------------------
    #inserting to pgmstatus table
    #---------------------------------------------------------------------------
           //$sql2="UPDATE `partners_pgmstatus`  SET `pgmstatus_programid`='$pgmid', `pgmstatus_clickapproval`='$clickr' , `pgmstatus_leadapproval`='$leadr' , `pgmstatus_saleapproval`='$saler' , `pgmstatus_mailaffiliate`='$aval' , `pgmstatus_mailmerchant`='$mval' , `pgmstatus_affiliateapproval`='$affiliater',pgmstatus_clickmail='$clicke',pgmstatus_leadmail='$leade',pgmstatus_salemail='$salee' WHERE pgmstatus_programid='$pgmid'";
           $sql2 ="UPDATE `partners_pgmstatus`  SET `pgmstatus_programid`='$pgmid', `pgmstatus_clickapproval`='$clickr' , `pgmstatus_leadapproval`='$leadr' , `pgmstatus_saleapproval`='$saler' , `pgmstatus_mailaffiliate`='$aval' , `pgmstatus_mailmerchant`='$mval' , `pgmstatus_affiliateapproval`='$affiliater',pgmstatus_clickmail='$clicke',pgmstatus_leadmail='$leade',pgmstatus_salemail='$salee'";
           $sql2 .= " ,pgmstatus_impressionapproval ='$impressionr' , pgmstatus_impressionmail ='$impressione'";
           $sql2 .= " WHERE pgmstatus_programid='$pgmid'";
            mysqli_query($con,$sql2);

    #---------------------------------------------------------------------------
    #inseting to pgm commccion rates
    #---------------------------------------------------------------------------

              if($currValue != $default_currency_caption)
              {
               $click = getDefaultCurrencyValue($pgmDate, $currValue, $click)  ;
               $lead  = getDefaultCurrencyValue($pgmDate, $currValue, $lead)  ;
               $impression = getDefaultCurrencyValue($pgmDate, $currValue, $impression)  ;
               if($saletype1 != "%") $sale =  getDefaultCurrencyValue($pgmDate, $currValue, $sale)  ;

             }

             $click =   round($click,2);
             $lead  =   round($lead,2);
             $sale  =   round($sale,2);
             $impression  =   round($impression,2);

	//Modified on 21-June-2006 by SMA to add new feilds related to recurring Sale Commission
			if($recur_sale) $recur_sale="1"; else $recur_sale="0";

            //$sql4="UPDATE `partners_firstlevel`  SET `firstlevel_programid`='$pgmid' , `firstlevel_clickrate`='$click' , `firstlevel_leadrate`='$lead' , `firstlevel_salerate`='$sale' , `firstlevel_saletype`='$saletype1' WHERE firstlevel_programid='$pgmid'";
            $sql4="UPDATE `partners_firstlevel`  SET `firstlevel_programid`='$pgmid' , `firstlevel_clickrate`='$click' , `firstlevel_leadrate`='$lead' , `firstlevel_salerate`='$sale' , `firstlevel_saletype`='$saletype1' ".
			" , firstlevel_impressionrate='$impression', firstlevel_unitimpression='$impressionunit', firstlevel_recur_sale='$recur_sale', firstlevel_recur_percentage='$recur_percentage', firstlevel_recur_period='$recur_period' ".
			" WHERE firstlevel_programid='$pgmid'";

            mysqli_query($con,$sql4);

            $msg=$lang_pgm_editsucess;


             $_SESSION['DES']=$description;
             //header("Location:index.php?Act=programedit&url=$url&click=$click&lead=$lead&sale=$sale&saletype1=$saletype1&clickr=$clickr&leadr=$leadr&saler=$saler&clicke=$clicke&leade=$leade&salee=$salee&msg=$msg&second=$second&secondtype=$secondtype&secondtxt=$secondtxt&mailaffil=$mailaffil&mailme=$mailme&affiliater=$affiliater&ip=$ip&status=$status&mode=$mode&id=$pgmid&geo_click=$geo_click&geo_lead=$geo_lead&geo_sale=$geo_sale$retValues");
             header("Location:index.php?Act=programedit&mode=edit&id=$pgmid&msg=$msg");

?>