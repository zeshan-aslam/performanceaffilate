<?php	ob_start();

    session_start();
    session_register("VAR");
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';
	include_once 'includes/function1.php';
    include_once 'testmail.php';


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    $aid					=	intval(trim($_GET['aid']));                   //joinprogram id
    $linkid					=	trim($_GET['linkid']);                //ad link id
    $ipaddress				= 	$HTTP_SERVER_VARS['REMOTE_ADDR'];     //getting ip address
    $link   			    =	substr($linkid,0,1);                  // getting type of ad(banner,text etc)
    $id     			    =	substr($linkid,1,strlen($linkid)-1);

    $status				    =	"";
    $trackurl  = $track_site_url."/trackingcode.php?aid=$aid&linkid=$linkid";
	
	//add sub id if exists
	$subid					= $_GET['subid'];
	if(!empty($subid)) $trackurl .= "&subid=$subid";	
	
	
//Modified for ANP Phase 4 from 15-JUNE
                $color = $_REQUEST['color'];
                if($color)
                {
                        $color = explode("~",$color);
                                $col_boder = "#".$color[0];
                                $col_back = "#".$color[1];
                                $col_title = "#".$color[2];
                                $col_url = "#".$color[3];
                                $col_head = "#".$color[4];
                                $col_desc = "#".$color[5];
                }
                $width = $_REQUEST['width'];
                $height = $_REQUEST['height'];
				
        		$newwindow                = trim($_REQUEST['newwindow']);   
				if($newwindow == 1)  
				{
					$OpenWindow = "target='_blank'";
					$flashWind        = "_blank";
                } else {
                        $OpenWindow = "";
                        $flashWind        = "_parent";
                }				
	

#----------------------------------------------------------------------------
#  raw impressions
#----------------------------------------------------------------------------
# checking whtehre the impression is from the same session

    $phpSess  = (!empty($_COOKIE['PHPSESSID']))?$_COOKIE['PHPSESSID']:$_SERVER['HTTP_COOKIE'];



    if(($_SESSION['VAR']!= $phpSess ) or (empty($phpSess))) {
       $_SESSION['VAR'] = $phpSess;
       $sessset	=	0;
    }else{
       $sessset	=	1;
    }


   $imagelist  = "";
#------------------------------------------------------------------------
# getting redirecting url
# getting ad status
#------------------------------------------------------------------------

 switch($link) //
      {
        case 'H':    //link is  Html

                $sql        = " select html_text,program_id,program_merchantid, html_status ";
                $sql	   .= " from partners_html, partners_program ";
                $sql	   .= " where html_id = '$id' ";
                $sql	   .= " And html_programid = program_id";
                $result     = @mysql_query($sql);
                $row        = @mysql_fetch_object($result) ;

                if(@mysql_num_rows($result)>0) {
                  $url       =  stripslashes($row->html_text);
                  $programid = $row->program_id;
                  $mid		 = $row->program_merchantid;
				  $status    	= $row->html_status;
                  # checking whether a genuin click.
                   $imagelist  = $url;
                }


                break;
/**/
        case 'N':   //link is  text

                $sql        = " select text_text,program_id,program_merchantid ";
                $sql	   .= " from partners_text_old, partners_program ";
                $sql	   .= " where text_id = '$id' ";
                $sql	   .= " And text_programid = program_id";

                $result     = @mysql_query($sql);
                $row        = @mysql_fetch_object($result) ;

                if(@mysql_num_rows($result)>0){
                 $url       =  stripslashes($row->text_text);
                 $programid = $row->program_id;
                 $mid		= $row->program_merchantid;
                 $imagelist  = $url;
                 }


                break;

        case 'T':   //link is New  text Ad
				$text_obj = new text_display;

                $sql        = " select text_text,program_id,program_merchantid,text_status ";
                $sql           .= " from partners_text, partners_program ";
                $sql           .= " where text_id = '$id' ";
                $sql           .= " And text_programid = program_id";

                $result     = @mysql_query($sql);
                $row        = @mysql_fetch_object($result) ;

                if(@mysql_num_rows($result)>0)
				{
						$url       	=  stripslashes($row->text_text);
						$programid 	= $row->program_id;
						$mid        = $row->program_merchantid;
						$status    	= $row->text_status;
						if($col_boder)
						{
							 $textAd = $text_obj->displayTextAd($id,$col_boder,$col_back,$col_title,$col_url,$col_head,$col_desc,$trackurl,$newwindow,$width,$height,$track_site_url);
							 $imagelist  = $textAd;
						} else 
						{
							$imagelist  = $url;
						}
                 }


                break;

        case 'B':  //link is  banner

                $sql        = " select banner_name,banner_height, banner_width, program_id,program_merchantid, banner_status ";
                $sql	   .= " from partners_banner, partners_program ";
                $sql	   .= " where banner_id = '$id' ";
                $sql	   .= " And banner_programid = program_id";

                $result     =@mysql_query($sql);
                $row        =@mysql_fetch_object($result);
                if(@mysql_num_rows($result)>0)
                {
                 $url       =  stripslashes($row->banner_name);
                 $programid = $row->program_id;
                 $mid		= $row->program_merchantid;
                 $bannerHeight = $row->banner_height;
                 $bannerWidth = $row->banner_width;
				 $status    	= $row->banner_status;
                $imagelist  = "<img src='$url'  border='0' width='$bannerWidth' height='$bannerHeight' >";
                }



                break;

         case 'P':   //link is  popup

                $sql        = " select popup_url, program_url,popup_height,popup_width,popup_scrollbar,program_id,program_merchantid, popup_status ";
                $sql	   .= " from partners_popup, partners_program ";
                $sql	   .= " where popup_id = '$id' ";
                $sql	   .= " And popup_programid = program_id";
                $result     = @mysql_query($sql);
                $row        = @mysql_fetch_object($result);
                if(@mysql_num_rows($result)>0)
                {
                 $url       =  stripslashes($row->popup_url);
                 $programid = $row->program_id;
                 $mid		= $row->program_merchantid;
                 $height	= $row->popup_height;
                 $width		= $row->popup_width;
                 $scrollbars= $row->popup_scrollbar;
				 $status    	= $row->popup_status;
                  $imagelist  = " <script> nw = open('$trackurl','new',height='$height',width='$width',scrollbars='$scrollbars'); nw.focus; </script>";
                }


                break;

         case 'F':   //link is  flash

                $sql        = " select flash_url,program_id,program_merchantid, flash_width, flash_height, flash_status  ";
                $sql	   .= " from partners_flash, partners_program ";
                $sql	   .= " where flash_id = '$id' ";

                $sql	   .= " And flash_programid = flash_programid";

                $result     = @mysql_query($sql);
                $row        = @mysql_fetch_object($result);

                if(@mysql_num_rows($result)>0){
                 	$url       = stripslashes($row->flash_url);
                    $programid = $row->program_id;
                    $mid	   = $row->program_merchantid;
					$status    	= $row->flash_status;
                    $i      = $row->flash_width."_".$row->flash_height;


                   $main   = "merchants/images/flash/".$i.".swf";
                   $topm   = $track_site_url."/merchants/images/flash/".$i.".swf";
                   $imagelist  =    "<EMBED src='$topm?inner=$row->flash_url&url=$trackurl' quality=4 width='$row->flash_width' height='$row->flash_height' >";
				}




                break;
      }
#------------------------------------------------------------------------
# Recording Impression
#------------------------------------------------------------------------
	$today  				=   date("Y-m-d");
    $referer 				=   getenv(HTTP_REFERER);

#------------------------------------------------------------------------
# Checking whether the request comes from rotator
# gets joinid, join status and merchant id
#------------------------------------------------------------------------

# requests is from rotator
   if($Act=="Rotator")
   {
           #getting the joinid and merchant id
           $sql        =        "select * from partners_joinpgm where joinpgm_affiliateid='$aid' and joinpgm_programid='$programid'";
               $ret        =        @mysql_query($sql);
           if(@mysql_num_rows($ret)>0) {
                      $row                =        @mysql_fetch_object($ret);
                      $joinid        =        $row->joinpgm_id;
                      $mid                =        $row->joinpgm_merchantid;
           }

           # getting the rotaor status
           $sql        =        "select rotatorsta_status,(rotator_id) from partners_rotatorsta,partners_rotator where rotatorsta_merid='$mid' and rotator_affilid='$aid' and rotator_id=rotatorsta_roid";
           $ret        =        @mysql_query($sql);
            if(@mysql_num_rows($ret)>0)
            {
                  $row                        =        @mysql_fetch_object($ret);
                  $joinstatus        =        trim($row->rotatorsta_status);

            }
    }else{
                    # getting join status, merchantid, joinid
            $sql        =      "select * from partners_joinpgm where joinpgm_affiliateid='$aid' and joinpgm_programid='$programid'";
            $ret        =        @mysql_query($sql);
            if(@mysql_num_rows($ret)>0)
            {
                $row                =        @mysql_fetch_object($ret);
                $joinstatus        =        trim($row->joinpgm_status);
                $joinid                =        $row->joinpgm_id;
                $mid                =        $row->joinpgm_merchantid;
           }
    }



#------------------------------------------------------------------------------
# getting affiliate status
#------------------------------------------------------------------------------
    $sql        =        "select * from partners_affiliate where affiliate_id='$aid'";
    $ret        =        @mysql_query($sql);
    if(@mysql_num_rows($ret)>0){
             $row                =        @mysql_fetch_object($ret);
             $affstatus =        trim($row->affiliate_status);
    }


#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------
    $sql        =        "select * from partners_merchant where merchant_id='$mid'";
    $ret        =        @mysql_query($sql);
    if(@mysql_num_rows($ret)>0) {
             $row                = @mysql_fetch_object($ret);
             $merstatus = trim($row->merchant_status);
             $randNo        = trim($row->merchant_randNo);
    }

#------------------------------------------------------------------------------
# getting program status
#------------------------------------------------------------------------------
    $sql="select * from partners_program where program_id='$programid'";
    $ret=@mysql_query($sql);
    if(@mysql_num_rows($ret)>0)
    {
             $row                        	= @mysql_fetch_object($ret);
             $pgmstatus                		= trim($row->program_status);
             $ipblocking        			= $row->program_ipblocking;
             $max_commision     			= $row->program_maxcommission;
             $pgm_enddate       			= $row->program_enddate;

            list($cookieTime,$cookiePeriod) = explode(" ",trim($row->program_cookie));
							
    }

#------------------------------------------------------------------------------
# Checking whether all the status are approved
#------------------------------------------------------------------------------
$test_while=1;
while($test_while==1)
{   //This while loop is included to break from loop bcoz the break works only in a loop
   	$test_while=0;
  	if(($affstatus=='approved') and ($merstatus=='approved') and ($joinstatus =='approved') and ($pgmstatus=='active') and (strtolower($status)=='active'))
  	{

        # getting current time
        $currenttime  =   date("Y-m-d  H:i:s");
        $currenttime1 =   date("d-m-Y  H:i:s");

       //////////////////////////////////////////////////////////////////////////
       //////// Start of IP Blocking ///////////////////////////////////////////
       //////////////////////////////////////////////////////////////////////////

        # adding currenttime + ipblocking time
        $sql      =   "select DATE_ADD('$currenttime',INTERVAL $ipblocking MINUTE) d " ;
        $ret      =   @mysql_query($sql);

        # getting  currenttime+ipblocking
        $row      =   @mysql_fetch_object($ret);
        $iptime   =   $row->d;

        # getting last impression time for checking ip is blocked for impression for the time being
        $sql   =   "select *,date_format(ipblocking_impressiontime,'%H/%i/%s/%d/%m/%y') as d from partners_ipblocking  where ipblocking_ipaddress='$ipaddress' and ipblocking_programid='$programid' " ;
        $ret   =   @mysql_query($sql);

        # ip is present in the database
        if(@mysql_num_rows($ret)>0)
        {
            $row      =   @mysql_fetch_object($ret);
            $ipblock  =   $row->d;
            $ipid     =   $row->ipblocking_id;

            # comparing last impression and current impression time
            if(CompareTime($ipblock))
            {
                    # impression is within the ip block time
                    # exit and store the impression as a raw impression
                    # merchant need not pay for this impression
                    break;
            }else
            {
                 # impression is not within the ip block time
                #
                # recording transaction to impression table merchant should pay
                RecordImpression($mid,$programid,$joinid,$aid,$linkid,$subid);

                # updating last impression time
                $sql  ="update partners_ipblocking set ipblocking_impressiontime='$iptime',ipblocking_affiliateid='$aid',ipblocking_merchantid='$mid',ipblocking_programid='$programid',ipblocking_joinpgmid='$joinid',ipblocking_linkid='$linkid',ipblocking_randNo='$randNo'  where ipblocking_id='$ipid'";
                @mysql_query($sql);

           }
       }
       # ip address is not present in database.........firsttime login
       else
       {
          # genuine click
          # record entry
          RecordImpression($mid,$programid,$joinid,$aid,$linkid,$subid);

           # updating last click time
          $sql    =   "insert into partners_ipblocking(ipblocking_ipaddress,ipblocking_time,ipblocking_affiliateid,ipblocking_merchantid,ipblocking_programid,ipblocking_joinpgmid,ipblocking_linkid,ipblocking_randNo,ipblocking_impressiontime)values('$ipaddress','$currenttime','$aid','$mid','$programid','$joinid','$linkid','$randNo','$iptime') ";
          @mysql_query($sql);
       }
       //////////////////////////////////////////////////////////////////////////
       ///////// End IP Blocking  ///////////////////////////////////////////
       //////////////////////////////////////////////////////////////////////////



       // Impression Transaction calculation and recording.  Finds if there are impression_unit number of records
       //with status Y in impression table.  If records found insert into transaction table & change status to N
       find_impression_transaction($programid, $aid,$mid,$joinid,$linkid,$subid);

 	} //end if all status approved
}//end while($test_while==1)

// add raw impression
#added on 15.Mar.06
InsertRawTrans_daily($programid, $aid,$mid, $linkid, $today)  ;




#------------------------------------------------------------------------
# getting redirecting url  ends here
#------------------------------------------------------------------------
 // echo $url;
  $imagelist = "<a href='$trackurl' onclick='return getCookie();'>$imagelist</a>";
  echo "document.write(\"$imagelist\");";

?>
<!-- Jascript cookie checkking -->
function getCookie() {
    var name  = "myCookie";
	var start = document.cookie.indexOf( name + "=" );
	var len   = start + name.length + 1; 
	if ( (start<0) && 	( name != document.cookie.substring( 0, name.length ) ) )
	{
		setCookie();
    	return true;
	}
	if ( start == -1 ) {
        setCookie();
    	return true;
    }
	var end = document.cookie.indexOf( ";", len );
	if ( end == -1 ) end = document.cookie.length;
    var cookieTime = document.cookie.substring( len, end );
    var varTime   = new Date();
    var currTime  = varTime.getTime();
    if(cookieTime>currTime) {
         return false;
    }
    else {
        setCookie();
        return true;
    }
 }
<!-- set cookie time -->
function setCookie() {
  var expdate 	  = new Date ();
  var newTime = expdate.getTime()+ (1000*20);
  document.cookie = "myCookie = " + newTime + " ; expires = " + expdate  ;
}


<?php
///  *********  FUNCTIONS    ********* //////

function  CompareTime($ipblock)
{
	//comparing date
       $dtarray       =explode("/",$ipblock);
       $iphour        =$dtarray[0];
       $ipminute      =$dtarray[1];
       $ipsecond      =$dtarray[2];
       $ipdate        =$dtarray[3];
       $ipmonth       =$dtarray[4];
       $ipyear        =$dtarray[5];

 	//current
       $d=date("d");
       $m=date("m");
       $y=date("Y");
       $h=date("H");
       $i=date("i");
       $s=date("s");
       $today=mktime($h,$i,$s,$m,$d,$y);
       $ipblock= mktime($iphour,$ipminute,$ipsecond,$ipmonth,$ipdate,$ipyear);

       if($ipblock>$today)
          return true;
       else
          return false;

}
# ends here


 # inserting value into transaction table
 function RecordImpression($mid,$programid,$joinid,$aid,$linkid,$subid)
 {

       $referer = getenv(HTTP_REFERER);
       $today         = date("Y-m-d");

    //--------------------------------------------------------
    //--------Check Geo Targeting--------------
    //--------------------------------------------------------
        $ip  = getenv('REMOTE_ADDR');

        //checking ip of user against countries selected for the program
        $user_ip = (ip2long($ip) < 0 ? -1 * ip2long($ip) : ip2long($ip));
        $temp_con = "OUT";

        $selq = "SELECT `program_countries`,`program_geotargeting_impression` FROM `partners_program` WHERE `program_id` = $programid";
        $row  = mysql_fetch_object(mysql_query($selq));
        $offer_in = explode(",",$row->program_countries);

        //if geo-targeting feature is enabled for click, then check whether the click is from allowed list of countries
        if($row->program_geotargeting_impression)
        {
                for($cind=0;$cind<count($offer_in);$cind++)
                {
                     $selq = "SELECT `ip_from`,`ip_to` FROM `partners_countryFlag` WHERE `country_name` = '".$offer_in[$cind]."'"
                                ." AND ip_from <=".$user_ip." AND `ip_to` >=".$user_ip."";
                     $ip_res = mysql_query($selq) ;
                     if(mysql_num_rows($ip_res) > 0)
                        $temp_con = "IN";
                }
         }
         else $temp_con = "IN";

    //-------- End of Geo Targeting-------------------------------------------

         if($temp_con == "IN")
         {
                 InsertDailyImpression($programid, $aid, $mid, $linkid, $subid, $today);
         }
 } # end function    RecordImpression


        /**************************************************************************************
        Created By         : SMA
        Created On         : 16-JUNE-2006
           Function to insert impression Records based on the program, merchant, affiliate,
            link, subid, and date of the impression.  If the record already exists then the
                count of the fielda imp_count and imp_pending is updated.   Else a new record is
                inserted for the details by setting the count of the fielda imp_count and
                imp_pending  to 1
        **************************************************************************************/
        function InsertDailyImpression($programid, $aid,$mid, $linkid, $subid, $today)
        {
                $daily_impr_count         = 1;
                $daily_pending_impr = 1;
                $sql = "SELECT * FROM partners_impression_daily WHERE  ".
                " imp_programid                 = '".$programid."' AND ".
                " imp_merchantid                = '".$mid."' AND ".
                " imp_affiliateid                = '".$aid."' AND ".
                " imp_linkid                        = '".$linkid."' AND ".
                " imp_date                                = '".$today."' AND ".
                " imp_subid                                = '".$subid."'  ";

                $res = mysql_query($sql);
                if(mysql_num_rows($res) > 0)
                {
                        //updating coun tfor existing daily impression
                        $row = mysql_fetch_object($res);
                        $impr_daily_id                = $row->imp_id;
                        //Increments daily count and pending count by 1
                        $daily_impr_count         += $row->imp_count;
                        $daily_pending_impr        += $row->imp_pending ;

                        $sql_count        = "UPDATE partners_impression_daily         SET ".
                        " imp_count                ='".$daily_impr_count."', ".
                        " imp_pending        ='".$daily_pending_impr."' WHERE ".
                        " imp_id                ='".$impr_daily_id."'";
                }
                else
                {
                        //inserting new record for daily impression
                        $sql_count = "INSERT INTO partners_impression_daily SET ".
                        " imp_programid                 = '".$programid."' , ".
                        " imp_merchantid                = '".$mid."' , ".
                        " imp_affiliateid                = '".$aid."' , ".
                        " imp_linkid                        = '".$linkid."' , ".
                        " imp_date                                = '".$today."' , ".
                        " imp_subid                                = '".$subid."' , ".
                        " imp_count                                ='".$daily_impr_count."', ".
                        " imp_pending                        ='".$daily_pending_impr."'  ";

                }
                $res_count = @mysql_query($sql_count);

        }
        // end of function InsertDailyImpression

 //------------------------------------------------------------------------------------
    # This function is used to insert/update the  raw impression count into
    # the table partners_rawtrans_daily
    #Created on 14.Mar.06 by SMI
    //------------------------------------------------------------------------------------
    function InsertRawTrans_daily($programid, $aid,$mid, $linkid, $today)
    {
                $daily_impression        = 1;
                $sql           = "SELECT * FROM partners_rawtrans_daily";
                $sql_where = "  WHERE  transdaily_affiliateid='$aid' AND transdaily_programid='$programid'
                              AND  transdaily_merchantid='$mid' AND transdaily_date ='$today'
                              AND transdaily_linkid = '$linkid'";
                            $res        = mysql_query($sql.$sql_where); // echo $sql.$sql_where ;
                if(mysql_num_rows($res)>0)
                {
                    #get the existing impression count
                    $row        = mysql_fetch_object($res);
                    $daily_impression += $row->{transdaily_impression};
                    #update
                    $sql         = "UPDATE partners_rawtrans_daily SET ";
                    $sql.= " transdaily_impression = $daily_impression ".$sql_where;
                }
                else
                {
                        #insert record
                    $sql = "INSERT INTO `partners_rawtrans_daily` SET
                            transdaily_affiliateid='$aid' , transdaily_programid='$programid',
                            transdaily_merchantid='$mid' , transdaily_date ='$today' ,
                            transdaily_linkid = '$linkid' ,transdaily_impression = $daily_impression ";

                }
               // echo '<br>sql='.$sql  ;exit;
                $ret =@mysql_query($sql) ;

    }// end function InsertRawTrans_daily



    //------------------------------------------------------------------------------------
    #Checks if the number of impressions for the curent affiliate and program is greater tahn or equal to
    # units of impression defined for the program.  If the mode of approval of impression is automatic then
    # transfers the amount of the impression to the affiliate and admin accoun tfrom the merchant account.
    # If mode of approval is manual then the transaction is recorded to the transaction table.  In both cases
    # the records are deleted from the impression table for each transaction that takes place.
    //------------------------------------------------------------------------------------
    function find_impression_transaction($programid, $aid,$mid,$joinid,$linkid,$subid)
    {
        $imp_obj = new impression();
        $today                                  =   date("Y-m-d");
        $referer                                 =   getenv(HTTP_REFERER);

        #-----------------------------------------------------------
        # getting commission rate and unit for impression
        #-----------------------------------------------------------

		$sql_impr = "SELECT * FROM partners_program WHERE program_id = '$programid' ";
		$res_impr = @mysql_query($sql_impr);
		if(@mysql_num_rows($res_impr) > 0)
		{
			$row_impr = mysql_fetch_object($res_impr);
			
			$impr_rate 		= $row_impr->program_impressionrate;
			$impr_unit 		= $row_impr->program_unitimpression;
			
			$admin_impr    	= $row_impr->program_admin_impr;
			$admin_default	= $row_impr->program_admin_default;
			
			$approval    	= $row_impr->program_impressionapproval;
			$impr_mail   	= $row_impr->program_impressionmail;
			$mailmerchant  	= $row_impr->program_mailmerchant;
			$mailaffiliate  = $row_impr->program_mailaffiliate;
	

			if($admin_default)
			{
				 $admin_impr_rate  =  $GLOBALS['const_imp_rate'];
			}
			else
			{
				$admin_impr_rate  =  $admin_impr;
			}
		
	
			# Get impression coun tfrom new table partners_Impression_daily
			$imp_sql = "SELECT sum(imp_pending) AS impr_count FROM partners_impression_daily  
				WHERE imp_programid='$programid' AND imp_merchantid ='$mid' AND imp_affiliateid='$aid'";
			$imp_res =@mysql_query($imp_sql) ;
	
			$rows        = @mysql_fetch_object($imp_res);
			$impr_count  = $rows->impr_count;
	
			if($impr_count >= $impr_unit)
			{
				/*$unit = $impr_count / $impr_unit;
				$int_part = explode(".",$unit);
				$unit =  $int_part[0];*/
	
	
					 $str_impid = "";
					 $from = $i * $impr_unit;
	
					 #Get impression count from new table partners_Impression_daily
					 $trans_sql = "SELECT * FROM partners_impression_daily WHERE imp_programid='$programid' AND imp_merchantid ='$mid' AND imp_affiliateid='$aid' AND imp_pending > 0 ";

					 $trans_res =  @mysql_query($trans_sql) or die(@mysql_error());
	
					 if(mysql_num_rows($trans_res) > 0)
					 {
						while($rows  = @mysql_fetch_object($trans_res))
						{
							//getting the impression ids of the records to be sent for transaction
							$str_impid .= $rows->imp_id.",";
							$imp_subid = $rows->imp_subid;
						}
						$imp_id_len = strlen($str_impid);
						$str_impid = substr($str_impid,0,$imp_id_len-1);
						
						//Transaction of records based on their approval method
						  if($approval=="automatic")
						  {
								$approvalstatus="approved";          // automatic approval
	
								#  get merchant account
							   $sql        = "SELECT *  FROM `merchant_pay`  WHERE pay_merchantid='$mid' ";
							   $res        = @mysql_query($sql);
	
							   $num                =        @mysql_num_rows($res);
							   $cut_off   =        $minimum_amount;
	
							   if($num>0)
							   {
								   $row1                            =   @mysql_fetch_object($res);
								   $merchant_balance   = $row1->pay_amount;
	
								   if(($merchant_balance- ($impr_rate + $admin_impr_rate)) > $cut_off)
								   {
										# Update Account info of admin,affil,merchant
	
										#----------------------------------------------------------
										# Adding money to affiliate account
										$merchant_balance = $merchant_balance-($impr_rate + $admin_impr_rate);
	
										$sql1       = "SELECT *  FROM `affiliate_pay` where pay_affiliateid=$aid ";
										$res1       = @mysql_query($sql1);
	
										$num=@mysql_num_rows($res1);
										if($num>0)
										{
										   $row1           =  @mysql_fetch_object($res1);
										   $curamount  =  $row1->pay_amount;
										   $curamount  =  $curamount + $impr_rate;
	
										   $sql2 = "update affiliate_pay set pay_amount='$curamount' where pay_affiliateid=$aid";
										   $ret2 = @mysql_query($sql2);
										}else
										{
										   $sql2 = "INSERT INTO  affiliate_pay set pay_affiliateid=$aid , pay_amount='$impr_rate'";
										   $ret2 = @mysql_query($sql2);
										}
										# affiliate account editing Ends here
										#----------------------------------------------------------
	
									   # Subtract Money From Merchant Account
									   $sql        = "UPDATE  `merchant_pay` SET  pay_amount=$merchant_balance  WHERE pay_merchantid='$mid' ";
									   $res        = @mysql_query($sql);
									   # END OF  Subtract Money From Merchant Account
	
									   #----------------------------------------------------------
									   # Adding To Admins Account
									   $sql1      = "SELECT *  FROM `admin_pay`  ";
									   $res1      = @mysql_query($sql1);
	
									   $num        =        @mysql_num_rows($res1);
									   if($num>0)
									   {
										  $row1                              =  @mysql_fetch_object($res1);
										  $admin_curamount    = $row1->pay_amount;
										  $admin_curamount    = $admin_curamount+$admin_impr_rate;
									   }
	
									   $sql  = "UPDATE `admin_pay` SET `pay_amount` = '$admin_curamount'";
									   $res  = @mysql_query($sql);
									   # END OF Adding to admin's account
								   }
							  }
						 }
						 else  # manuall approval
						 {
							 $approvalstatus = "pending";
						 }
						//End Transactions
	
						//Record transaction details to transaction table
						$imp_obj->update_imp_transaction($joinid,$approvalstatus,$today,$impr_rate,$linkid,$admin_impr_rate,$referer,$ipaddress,$name,$imp_subid,$str_impid,$impr_unit);
	
						//Insert Impression Transaction details
						if ($mailmerchant=="yes") {
							MailMerchant($aid,$mid,$programid,$impr_rate,$admin_impr_rate,"impression");
						}
	
						if($mailaffiliate=="yes"){
							MailAffilaite($aid,$mid,$programid,$impr_rate,"impression");
						}
					 }
			}
		}	
    }

?>