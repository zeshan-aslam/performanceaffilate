<?php	
// header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Origin: <origin>");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


  #-------------------------------------------------------------------------------
  # Tracking code for click

  # Pgmmr        : RR
  # Date Created :   21-1-2004
  # Date Modfd   :   16-1-2005
  # Last Modified: By DPT on June/01/05 (if click is in IP block period, record the click and forward click to URL, but merchant need not pay)
  #				   By DPT on July/30/05 (to incorporate sub-id tracking)	
  #				   By DPT on August/01/05 (to incorporate flatrate/percentage for commission)
  #				   By DPT on September/07/05 (to change the ipaddress getting line)
  #-------------------------------------------------------------------------------

	include_once 'includes/db-connect.php';
    include_once 'includes/session.php';
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';
    include_once 'testmail.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);



	
	//if admin has set up the click rate in percentage
	//if($admin_clickrate_type=="percentage") $admin_clickrate 

    $Act                    =	trim($_GET['Act']);
    $aid					=	intval(trim($_GET['aid']));                   //joinprogram id
    $linkid					=	trim($_GET['linkid']);                //ad link id
    $ipaddress				=   $HTTP_SERVER_VARS['REMOTE_ADDR'];     //getting ip address
	if(empty($ipaddress)) $ipaddress = $_SERVER['REMOTE_ADDR'];
    $link   			    =	substr($linkid,0,1);                  // getting type of ad(banner,text etc)
    $id     			    =	substr($linkid,1,strlen($linkid)-1);
    $status				    =	"";                                   // ad link status

    $referer 				= 	getenv(HTTP_REFERER);

	//get sub id
	$subid					= $_REQUEST['subid'];
	$presenttime  			=   date("Y-m-d  H:i:s");


  //Ankit Kedia --> 25th May 2019 - Code For AUID 

  $auid = isset($_GET['auid']) && trim($_GET['auid']) != "" ? trim($_GET['auid']) : "";
  $trafficSource = isset($_GET['trafficSource']) && trim($_GET['trafficSource']) != "" ? trim($_GET['trafficSource']) : "";
  $redirectURL = isset($_GET['redirectURL']) && trim($_GET['redirectURL']) != "" ? trim($_GET['redirectURL']) : "";
  
//{CLICKID}
   
   if($auid != "" && $aid > 0)
   {
      $auidid = 0;
      $ownerid = 0;
      $ipid = 0;

      $sql = "select * from partners_auid where affiliateid = '$aid' and auid = '$auid' ";
      $result  = @mysqli_query($con,$sql);
      
      if(!(mysqli_num_rows($result) > 0))
      {
        $sql = " Insert into partners_auid (affiliateid, auid) values ('$aid', '$auid') ";
        @mysqli_query($con,$sql);

        $auidid = mysqli_insert_id($con);
      }
      else
      {

        $row = @mysqli_fetch_assoc($result) ;
        var_dump($row);
        $auidid = $row["id"];

        $sql = " Select * from partners_owner_auid where auidid = '$auidid' ";
        $result  = @mysqli_query($con,$sql);

        if(mysqli_num_rows($result) > 0)
      	{
        	$row = @mysqli_fetch_assoc($result) ;
        	$ownerid = $row["ownerid"];
		}

      }

      $sql = " Select * from partners_ipstats where ipaddress = '$ipaddress' ";
      $result  = @mysqli_query($con,$sql);
      
      if(!(mysqli_num_rows($result) > 0))
      {
      	if($ownerid == 0)
      	{
	      	$sql = " Insert into partners_aiowner (count) values (0) ";
	        @mysqli_query($con,$sql);

	        $ownerid = mysqli_insert_id($con);
    	  }

      	$sql = " Insert into partners_ipstats (ipaddress, ownerid) values ('$ipaddress', '$ownerid')";
        @mysqli_query($con,$sql);

        $ipid = mysqli_insert_id($con);
      }
      else
      {
      	$row = @mysqli_fetch_assoc($result) ;
      	$ipid = $row["id"];
      }
      
      $sql = " select * from partners_owner_auid where ownerid = '$ownerid' and auidid = '$auidid' ";
 	  $result  = @mysqli_query($con,$sql);

      if(!(mysqli_num_rows($result) > 0))
      {
	      $sql = " Insert into partners_owner_auid (ownerid,auidid) values ('$ownerid','$auidid') ";
	      @mysqli_query($con,$sql);
	  }

     
      $sql = " Select * from partners_aiowner where id = '$ownerid' ";
     
      $result  = @mysqli_query($con,$sql);
    
      if(mysqli_num_rows($result) > 0)
      {
        $aiowner = @mysqli_fetch_assoc($result) ;

        $sql = " Select count(ipaddress) as totalips from partners_ipstats where ownerid = '$ownerid' ";

        $result  = @mysqli_query($con,$sql);

        $ipstatsCount = @mysqli_fetch_assoc($result) ;

        $newcount =  $ipstatsCount["totalips"]  ;
        $sql = " Update partners_aiowner set count = '$newcount' where id = '$ownerid' ";
      
        @mysqli_query($con,$sql);


        $sql = " Insert into partners_owner_auid_ip (ownerid, auidid, ipid ) values ($ownerid, $auidid,  $ipid) ";
		 @mysqli_query($con,$sql);

      }


     

   }


  echo $auidid."<br/>";
  echo $auid."<br/>";
  echo $trafficSource."<br/>";
  echo $redirectURL."<br/>";

  


#------------------------------------------------------------------------
# getting redirecting url
# getting ad status
#------------------------------------------------------------------------
 switch($link) //
      {
        case 'H':    //link is  Html

                $sql        = "select * from partners_html where html_id='$id'";
                $result     = @mysqli_query($con,$sql);
                $row        = @mysqli_fetch_object($result) ;

                if(@mysqli_num_rows($result)>0) {
                 $status    = $row->html_status; //linkid exist under given pgm
                 $url       = $row->html_url;
                 $pgmid     = $row->html_programid;
                }
                break;

        case 'N':   //link is  text

                $sql        = "select * from partners_text_old where text_id='$id'";
                $result     = @mysqli_query($con,$sql);
                $row        = @mysqli_fetch_object($result) ;

                if(@mysqli_num_rows($result)>0){
                 $status    = $row->text_status;  //linkid exist under given pgm
                 $url       = $row->text_url;
                 $pgmid     = $row->text_programid;
                }
                break;

        case 'T':   //link is New text Ad

                $sql        = "select * from partners_text where text_id='$id'";
                $result     = @mysqli_query($con,$sql);
                $row        = @mysqli_fetch_object($result) ;

                if(@mysqli_num_rows($result)>0){
                 $status    = $row->text_status;  //linkid exist under given pgm
                 $url       = $row->text_url;
                 $pgmid     = $row->text_programid;
                }
                break;

        case 'B':  //link is  banner

                $sql        ="select * from partners_banner where banner_id='$id'";
                $result     = @mysqli_query($con,$sql);
                $row        = @mysqli_fetch_object($result);
                 if(mysqli_num_rows($result)>0)
                {
                 $status    =$row->banner_status;   //linkid exist under given pgm
                 $url       =$row->banner_url;
                 $pgmid     =$row->banner_programid;
                }
                break;

         case 'P':   //link is  popup

                $sql        ="select * from partners_popup where popup_id='$id'";
                $result     = @mysqli_query($con,$sql);
                $row        = @mysqli_fetch_object($result);
                 if(@mysqli_num_rows($result)>0)
                {
                 $status    =$row->popup_status; //linkid exist under given pgm
                 $url       =$row->popup_url;
                 $pgmid     =$row->popup_programid;
                }
                break;

         case 'F':   //link is  flash

                $sql        ="select * from partners_flash where flash_id='$id'";
                $result     = @mysqli_query($con,$sql);
                $row        = @mysqli_fetch_object($result);
                 if(@mysqli_num_rows($result)>0)
                {
                 $status    =$row->flash_status; //linkid exist under given pgm
                 $url       =$row->flash_url;
                 $pgmid     =$row->flash_programid;
                }
                break;

           case 'R':   //link is PRODUCT

                $sql        ="select * from partners_product where prd_id='$id'";
                $result     = @mysqli_query($con,$sql);
                $row        = @mysqli_fetch_object($result);
                if(@mysqli_num_rows($result)>0)
                {
                  $status    =$row->prd_status; //linkid exist under given pgm

                 if($type==1) {

                 	$url       = trim($row->prd_image);
                    $url       = trim($row->prd_image,'"');

                    }
                 else		    {
                 	$url       = trim($row->prd_url);
                    $url       = trim($row->prd_url,'"');
                    }

                 $pgmid     =$row->prd_programid;
                }
                break;

      }
	  
//Modified by SMA to validate the url
        # if the 1st part of the URL not contain http:/
		// obsolete now 2019 ANDY
		/*
        $url_test = substr($url, 0, 7);
        if($url_test!="http://")
        {
            $url   =    "http://".$url;
        }*/
//End modify
 
#------------------------------------------------------------------------
# getting redirecting url  ends here
#-----------------------------------------------------------------


#------------------------------------------------------------------------
# Checking whether the request comes from rotator
# gets joinid, join status and merchant id
#------------------------------------------------------------------------

# requests is from rotator
	if($Act=="Rotator") {

              #getting the joinid and merchant id
              $sql	=	"select * from partners_joinpgm where joinpgm_affiliateid='$aid' and joinpgm_programid='$pgmid'";
    	      $ret	=	@mysqli_query($con,$sql);
              if(@mysqli_num_rows($ret)>0) {
                         $row		=	@mysqli_fetch_object($ret);
                         $joinid	=	$row->joinpgm_id;
                         $mid		=	$row->joinpgm_merchantid;
              }

              # getting the rotaor status
              $sql	=	"select rotatorsta_status,(rotator_id) from partners_rotatorsta,partners_rotator where rotatorsta_merid='$mid' and rotator_affilid='$aid' and rotator_id=rotatorsta_roid";
              $ret	=	@mysqli_query($con,$sql);
   			  if(@mysqli_num_rows($ret)>0)  {
          	   		   $row			=	@mysqli_fetch_object($ret);
	                   $joinstatus	=	trim($row->rotatorsta_status);

    		 }
    }else{
    		# getting join status, merchantid, joinid
            $sql	=	"select * from partners_joinpgm where joinpgm_affiliateid='$aid' and joinpgm_programid='$pgmid'";
            $ret	=	@mysqli_query($con,$sql);
         	if(@mysqli_num_rows($ret)>0) {
                $row		=	@mysqli_fetch_object($ret);
                $joinstatus	=	trim($row->joinpgm_status);
                $joinid		=	$row->joinpgm_id;
                $mid		=	$row->joinpgm_merchantid;
           }
    }




#------------------------------------------------------------------------------
# getting affiliate status
#------------------------------------------------------------------------------
    $sql	=	"select * from partners_affiliate where affiliate_id='$aid'";
    $ret	=	@mysqli_query($con,$sql);
    if(@mysqli_num_rows($ret)>0){
             $row		=	@mysqli_fetch_object($ret);
             $affstatus =	trim($row->affiliate_status);
    }


#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------
    $sql	=	"select * from partners_merchant where merchant_id='$mid'";
    $ret	=	@mysqli_query($con,$sql);
    if(@mysqli_num_rows($ret)>0) {
             $row		= @mysqli_fetch_object($ret);
             $merstatus = trim($row->merchant_status);
             $randNo	= trim($row->merchant_randNo);

    }

#------------------------------------------------------------------------------
# getting program status
#------------------------------------------------------------------------------
    $sql="select * from partners_program where program_id='$pgmid'";
    $ret=@mysqli_query($con,$sql);
    if(@mysqli_num_rows($ret)>0)
    {
             $row			=	@mysqli_fetch_object($ret);
             $pgmstatus		=	trim($row->program_status);
             $ipblocking	=	$row->program_ipblocking;

            list($cookieTime,$cookiePeriod)		=   explode(" ",trim($row->program_cookie));
			
			$approval        =   $row->program_clickapproval;
			# getting click approval type
			if($approval=="automatic")  
				$approvalstatus="approved";
			else 
				$approvalstatus = "pending";

   }
   



#----------------------------------------------------------------------------
# Adding raw clicks
#----------------------------------------------------------------------------

    $today  	   	=   date("Y-m-d");
#----------------------------------------------------------------------------
# Adding/updating raw click count  into partners_rawtrans_daily added on 17-JUNE-2006
#----------------------------------------------------------------------------

   InsertRawTrans_daily($pgmid, $aid,$mid, $linkid, $today);


#------------------------------------------------------------------------------
# Checking whether all the status are approved
#------------------------------------------------------------------------------
  //echo $affstatus.$merstatus.$joinstatus.$pgmstatus.strtolower($status);



  if(($affstatus=='approved') and ($merstatus=='approved') and ($joinstatus=='approved') and ($pgmstatus=='active') and (strtolower($status)=='active'))
  {
	  
       # getting current time
        $currenttime  =   date("Y-m-d  H:i:s");
        $currenttime1 =   date("d-m-Y  H:i:s");

      //////////////////////////////////////////////////////////////////////////
      ///////// Cookie Tracking	////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////////////

      if($cookieTime==0) $cookieTime = "";

      # if mercahnt has set cookie
       if(!empty($cookieTime)) 
       {
		      // Added by Ankit 23rd March 2019
          //die("has cookie");
		   
            /////////////////////// getting cookie values ///////////////////

            # get cookie value
            $TRACKCOOKIE_VALUE	= $_COOKIE["USERCOOKIE_FOR_TRACKING"];
			



            # get cookie value
    	    	if (empty($TRACKCOOKIE_VALUE))
                    $TRACKCOOKIE_VALUE = $HTTP_COOKIE_VARS["USERCOOKIE_FOR_TRACKING"];

           ////////////////////// getting cookie values///////////////////////



           # get all the avialabe pgms cookie
           $pgmCookies = explode(",",$TRACKCOOKIE_VALUE);
		   


           # get  c0okie expire time for each pgm
           for($cookieIndex=0;$cookieIndex<count($pgmCookies);$cookieIndex++){
             list($pgmList[$cookieIndex],$timeLimit[$cookieIndex]) = explode(":",$pgmCookies[$cookieIndex]);
           }
		     
          # checking wether the cookie already set for pgm
          $currTime = mktime(date("h"),date("i"),date("s"),date("m"),date("d"),date("y"));



           if(in_array($pgmid,$pgmList)) {
             # index
             $pos 	   = array_search($pgmid,$pgmList);

             # cookie already exists
             if($timeLimit[$pos]>$currTime)
      			 {
      			 
                   /// needs to change join id for program  id (Currently ussing join association) DONE...!
                   // need to overright cookie if already present with new link
                   //update cookie
  	              $sql	=	"select * FROM partners_joinpgm WHERE joinpgm_id ='$joinid'";
      			      $ret	=	@mysqli_query($con,$sql);
      	     		  $row	=	@mysqli_fetch_object($ret);
      			      # get transaction details
      			      $joinpgm_programid 	=	$row->joinpgm_programid;
                   
                   $data_to_collect = $subid.":".$joinid;
                   $cookiename = "AVAZ_USERCOOKIE_FOR_TRACKING_".$joinpgm_programid;
                   setcookie ($cookiename,$data_to_collect,time()+3600);
  			 
                  //--------------Added By DPT on July/28/07----------
                  # store the click as a transaction and direct the user to the url
                  # merchant need not pay for this click
                  // add transaction
                  $sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_dateofpayment ,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_country,transaction_subid,transaction_transactiontime) values ($joinid,'click','$approvalstatus','$today',0,'$today','$linkid',0,'".addslashes($referer)."','".addslashes($ipaddress)."','".addslashes($name)."','".addslashes($subid)."','$presenttime') ";

  		            @mysqli_query($con,$sql);

                  // Added by Ankit on 23rd March 2019
                  $transactionId = mysqli_insert_id($con);
                  InsertAiInfo($transactionId);

                  //Added by Ankit Kedia on 25th May 2019 to use RedirectUrl parameter from QueryString
                  if($redirectURL != "")
                  {
                    $url = $redirectURL;
                  }

                  if($transactionId > 0)
                  {
                    if (strpos($url, "?") !== false)
                    {
                      $url.="&tid=".$transactionId;
                    }
                    else
                    {
                      $url.="?tid=".$transactionId;
                    }
                  }

				          // Changed by Ankit on 14th May 2022 - Replace {CLICKID} with tid here
                  $url = str_replace("{CLICKID}", $transactionId, $url);
                 

                  // redirecting to given url
        			    header("location:$url");
        			    exit;
  			           //--------------End of Addition By DPT---------------
                  //header("Location:admin/error.htm");
              	 //exit;
              }

            }    
             else 
            {
                $pos = count($pgmCookies);
		        }



                  ////////// update cookie values /////////////////////////////

                  # set new time

                   # checking cookie time


                  switch ($cookiePeriod){

               	  		case 'minute':
                        	 $newCookieTime 	= mktime(date("h"),date("i")+$cookieTime,date("s"),date("m"),date("d"),date("y"));
                             break;

	                    case 'hour':
                           	 $newCookieTime 	= mktime(date("h")+$cookieTime,date("i"),date("s"),date("m"),date("d"),date("y"));
                              break;

	                    case 'day':
	                          $newCookieTime 	= mktime(date("h"),date("i"),date("s"),date("m"),date("d")+$cookieTime,date("y"));
	                          break;

	                    case 'year':
	                         $newCookieTime 	= mktime(date("h"),date("i"),date("s"),date("m"),date("d"),date("y")+$cookieTime);
	                          break;
                  }

				
                  $pgmCookies[$pos] = $pgmid.":".$newCookieTime;
                  $cookieValue 		= implode(",",$pgmCookies);
				  
				 

                 # update cookie value
                 
                 /// needs to change join id for program  id (Currently ussing join association) DONE...!
                 // need to overright cookie if already present with new link
                 
	              $sql	=	"select * FROM partners_joinpgm WHERE joinpgm_id ='$joinid'";
			      $ret	=	@mysqli_query($con,$sql);
	     		  $row	=	@mysqli_fetch_object($ret);
			      # get transaction details
			      $joinpgm_programid 	=	$row->joinpgm_programid;
                 
                 $data_to_collect = $subid.":".$joinid;
                 $cookiename = "AVAZ_USERCOOKIE_FOR_TRACKING_".$joinpgm_programid;
                 setcookie ($cookiename,$data_to_collect,time()+3600);
				

               	setcookie ("USERCOOKIE_FOR_TRACKING",$cookieValue,time()+3600);



                 ////////// update ends here     /////////////////////////////
        }
        else
        {
          // Added by Ankit 23rd March 2019
          //echo "no cookie";
          //die();
        }

       //////////////////////////////////////////////////////////////////////////
       ///////// End Cookie Tracking  ///////////////////////////////////////////
       //////////////////////////////////////////////////////////////////////////



        # adding currenttime+ipblocking time
        $sql      =   "select DATE_ADD('$currenttime',INTERVAL $ipblocking MINUTE) d " ;
        $ret      =   @mysqli_query($con,$sql);

        # getting  currenttime+ipblocking
        $row      =   @mysqli_fetch_object($ret);
        $iptime   =   $row->d;


       # getting last click time for checking ip is blocked for the time being
       $sql   =   "select *,date_format(ipblocking_time,'%H/%i/%s/%d/%m/%y') as d from partners_ipblocking  where ipblocking_ipaddress='$ipaddress' and ipblocking_programid='$pgmid' " ;
	   
	   
       $ret   =   @mysqli_query($con,$sql);
	   


       # ip is present in the database
       if(@mysqli_num_rows($ret)>0) 
       { 
	       // Added by Ankit 23rd March 2019 
	       //die("IP is present in database");
	   
	   
            $row      =   @mysqli_fetch_object($ret);
            $ipblock  =   $row->d;
            $ipid     =   $row->ipblocking_id;
			
			

            # comparing last click and current click time
            if(CompareTime($ipblock)) 
            {
               //Added by Ankit 23 March 2019
               //die("No pay");
	
                # click is wthin the ip block time
                //--------------Added By DPT on June/01/05----------
                # store the click as a transaction and direct the user to the url
                # merchant need not pay for this click

                $sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_dateofpayment ,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_country,transaction_subid,transaction_transactiontime) values ('$joinid','click','$approvalstatus','$today',0,'$today','$linkid',0,'".addslashes($referer)."','".addslashes($ipaddress)."','".addslashes($name)."','".addslashes($subid)."','$presenttime') ";
    		        @mysqli_query($con,$sql);

                // Added by Ankit on 23rd March 2019
                  $transactionId = mysqli_insert_id($con);
                  InsertAiInfo($transactionId);

                  //Added by Ankit Kedia on 25th May 2019 to use RedirectUrl parameter from QueryString
                  if($redirectURL != "")
                  {
                    $url = $redirectURL;
                  }

                  if($transactionId > 0)
                  {
                    if (strpos($url, "?") !== false)
                    {
                      $url.="&tid=".$transactionId;
                    }
                    else
                    {
                      $url.="?tid=".$transactionId;
                    }
                  }

                  // Changed by Ankit on 14th May 2022 - Replace {CLICKID} with tid here
                  $url = str_replace("{CLICKID}", $transactionId, $url);

     
                    // redirecting to given url
      			    header("location:$url");
      			    exit;
			    //--------------End of Addition By DPT---------------

                //header("Location:admin/error.htm");
                //exit;
            }else{

                //Added by Ankit 23 March 2019
                //die("Merchant will pay");

                #
                # record entry
                $pgmstatus    =   GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$admin_clickrate,$minimum_amount,$subid, $fraudsettings_clickseconds, $fraudsettings_recentclick, $fraudsettings_clickaction, $admin_clickrate_type) ;      // added a parameter by pramod
                $pgmstatus    =   explode("~",$pgmstatus);

                # updating last click time
                $sql  ="update partners_ipblocking set ipblocking_time='$iptime',ipblocking_affiliateid='$aid',ipblocking_merchantid='$mid',ipblocking_programid='$pgmid',ipblocking_joinpgmid='$joinid',ipblocking_linkid='".addslashes($linkid)."',ipblocking_click='$pgmstatus[0]',ipblocking_lead='$pgmstatus[1]',ipblocking_sale='$pgmstatus[2]',ipblocking_saletype='$pgmstatus[3]',ipblocking_statusid='$pgmstatus[4]',ipblocking_randNo='$randNo'  where ipblocking_id='$ipid'";
                @mysqli_query($con,$sql);

           }
      }
      # ip address is not present in database.........firsttime login
      else{

          // Added by Ankit 23rd March 2019 
         //die("IP is not present in database");

          # genuine click
          # record entry
          $pgmstatus  =   GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$admin_clickrate,$minimum_amount,$subid, $fraudsettings_clickseconds, $fraudsettings_recentclick, $fraudsettings_clickaction, $admin_clickrate_type) ;       // added a parameter by pramod
          $pgmstatus  =   explode("~",$pgmstatus);
		  

           # updating last click time
          $sql    =   "insert into partners_ipblocking(ipblocking_ipaddress,ipblocking_time,ipblocking_affiliateid,ipblocking_merchantid,ipblocking_programid,ipblocking_joinpgmid,ipblocking_linkid,ipblocking_click,ipblocking_sale,ipblocking_lead,ipblocking_saletype,ipblocking_statusid,ipblocking_randNo)values('".addslashes($ipaddress)."','$iptime','$aid','$mid','$pgmid','$joinid','".addslashes($linkid)."','$pgmstatus[0]','$pgmstatus[2]','$pgmstatus[1]','$pgmstatus[3]','$pgmstatus[4]','$randNo') ";
          @mysqli_query($con,$sql);
 
      }
	  
      $transactionId = $GLOBALS["tid"];

      //Added by Ankit Kedia on 25th May 2019 to use RedirectUrl parameter from QueryString
        if($redirectURL != "")
        {
          $url = $redirectURL;
        }

       if($transactionId > 0)
        {
          if (strpos($url, "?") !== false)
          {
            $url.="&tid=".$transactionId;
          }
          else
          {
            $url.="?tid=".$transactionId;
          }
        }
	  
        // Changed by Ankit on 14th May 2022 - Replace {CLICKID} with tid here
        $url = str_replace("{CLICKID}", $transactionId, $url);


  	 # redirecting to given url
     header("location:$url");
     exit;
	
  }
  else
  {
	  
       # not a genuine click
	   header("Location:admin/error.htm");
       exit;
  }
	

#------------------------------------------------------------------------------
# Checking whether all the status are approved  ends here
#------------------------------------------------------------------------------




# inserting value into transaction table
 function GetTransaction($mid,$pgmid,$joinid,$aid,$linkid,$admin_clickrate,$minimum_amount,$subid, $clickseconds, $recentclick, $clickaction, $admin_clickrate_type)
 {

 		$con = $GLOBALS["con"];
		$ipaddress				=   $HTTP_SERVER_VARS['REMOTE_ADDR'];     //getting ip address  
		if(empty($ipaddress)) $ipaddress = $_SERVER['REMOTE_ADDR'];
		$presenttime  			=   date("Y-m-d  H:i:s");

        $referer = getenv('HTTP_REFERER');


		# GEts the Click Commision for Programs
		$sql_click = "SELECT * FROM partners_program WHERE program_id = '$pgmid' ";
		$res_click = @mysqli_query($con,$sql_click);
		if(@mysqli_num_rows($res_click) > 0)
		{
			$row_click = mysqli_fetch_object($res_click);
	
			$clickrate			=	$row_click->program_clickrate;
			$pgm_admin_click	= $row_click->program_admin_click;
			$pgm_admin_clicktype= $row_click->program_admin_clicktype;
			$admin_default		= $row_click->program_admin_default;
			
			$approval		=	$row_click->program_clickapproval;
			$mailmerchant 	=	$row_click->program_mailmerchant;
			$mailaffiliate 	=	$row_click->program_mailaffiliate;
		}	

		# To get the sale and lead commissions for the affiliate based on the leads and sales made  by them
			$sql_joinpgm = "SELECT * FROM partners_joinpgm WHERE joinpgm_id='$joinid' ";
			$res_joinpgm = mysqli_query($con,$sql_joinpgm);
			$row_joinpgm = mysqli_fetch_object($res_joinpgm);
			
			$salesMade	= $row_joinpgm->joinpgm_sale_count;
			$leadsMade	= $row_joinpgm->joinpgm_lead_count;
			if(!$salesMade)	$salesMade	= 1;
			if(!$leadsMade) $leadsMade	= 1;
			
			# Commission for Lead
			$sql_lead_comm = "SELECT commission_leadrate FROM partners_pgm_commission WHERE commission_programid='$pgmid' 
				AND commission_lead_from <= '$leadsMade' AND commission_lead_to >=  '$leadsMade' ";
			$res_lead_comm = mysqli_query($con,$sql_lead_comm);
			if(mysqli_num_rows($res_lead_comm) > 0) 
			{
				list($leadrate)	= mysqli_fetch_row($res_lead_comm);
			} else { 
				$leadrate	=	0;
			}
			
			# Commission for Sale
			$sql_sale_comm = "SELECT commission_salerate, commission_saletype FROM partners_pgm_commission 
			WHERE commission_programid='$pgmid' AND commission_sale_from <= '$salesMade' AND commission_sale_to >=  '$salesMade' ";
			$res_sale_comm = mysqli_query($con,$sql_sale_comm);  
			if(mysqli_num_rows($res_sale_comm) > 0) 
			{
				list($salerate,$saletype) = mysqli_fetch_row($res_sale_comm);
			} else { 
				$salerate	=	0;
				$saletype	=	"$";
			}
		 
			
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~s	
				 
		
        #checking whether any group exist for this program
        $sql	=	"select * from partners_group where  group_programid='$pgmid'";
        $ret	=	@mysqli_query($con,$sql);

        # group exists
        if(@mysqli_num_rows($ret)>0) {
          	       $row				=	@mysqli_fetch_object($ret);
	               $group			=	$row->group_id;
	               $clickgroup		=	$row->group_clickrate;
                   $salegroup		=	$row->group_salerate;
                   $leadgroup		=	$row->group_leadrate;
                   $saletypegroup	=	$row->group_saletype;

	               # checking whether member of any group
	               $sql1	=	"select * from partners_joinpgm where  joinpgm_id='$joinid' and joinpgm_group='$group'";
	               $ret1	=	@mysqli_query($con,$sql1);

	               if(@mysqli_num_rows($ret1)>0) {
	                     $clickrate	=	$clickgroup;
                         $salerate	=	$salegroup;
                         $leadrate	=	$leadgroup;
                         $saletype	=	$saletypegroup;
	               }

       }
      # close   checking whether any group exist for this program
	  
	  	# Checks if Admin has assigned special Commission STructure for the affiliate
			$sql_def_comm = "SELECT * FROM partners_joinpgm, partners_pgm_commission 
				WHERE joinpgm_id='$joinid' AND joinpgm_commissionid != '0'
				AND joinpgm_commissionid = commission_id ";
			$res_def_comm = mysqli_query($con,$sql_def_comm);
			if(mysqli_num_rows($res_def_comm) > 0) {
				$row_def_comm = mysqli_fetch_object($res_def_comm);
				
				 $salerate	=	$row_def_comm->commission_salerate;
				 $leadrate	=	$row_def_comm->commission_leadrate;
				 $saletype	=	$row_def_comm->commission_saletype;
			}
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~s	
	  

		# admin Click commission Rate
		if($admin_default)
		{
			if($admin_clickrate_type == "percentage") {
				$admin_click_rate  = ($clickrate * $admin_clickrate)/100;
			}
			else {
			 	$admin_click_rate  =  $admin_clickrate;  
			}
		}
		else  //If Admin has set Trans comm for the Program
		{
			if($pgm_admin_clicktype == "%") {
				$admin_click_rate  = ($clickrate * $pgm_admin_click)/100;
			}
			else {
				$admin_click_rate  =  $pgm_admin_click;
			}
		}		

		#*******************************************************

		

       if($approval=="automatic")  
	   {

			$approvalstatus="approved";          // automatic approval
			
			$today         = date("Y-m-d");
			//$admin_amount  = $admin_clickrate;
			$admin_amount  = $admin_click_rate;
			
			/////////// getting country /////////////////////
			$ip 			= $GLOBALS['REMOTE_ADDR'];
			/////////////////////////////////////////////////
		   
			//--------Geo Targeting--------------
			//checking ip of user against offer available countries
	      $user_ip = (ip2long($ip) < 0 ? -1 * ip2long($ip) : ip2long($ip));
	      $temp_con = "OUT";

	      $selq = "SELECT `program_countries`,`program_geotargeting_click` FROM `partners_program` WHERE `program_id` = '$pgmid'";
	      $row  = mysqli_fetch_object(mysqli_query($con,$selq));
	      $offer_in = explode(",",$row->program_countries);
		  
		  //if geo-targeting feature is enabled for click, then check whether the click is from allowed list of countries
		  if($row->program_geotargeting_click)
		  {
			  for($cind=0;$cind<count($offer_in);$cind++){
			  $selq = "SELECT `ip_from`,`ip_to` FROM `partners_countryFlag` WHERE `country_name` = '".$offer_in[$cind]."'"
					  ." AND ip_from <=".$user_ip." AND `ip_to` >=".$user_ip."";
					if(mysqli_num_rows(mysqli_query($con,$selq))) $temp_con = "IN";
			  }
		   }
		   else $temp_con = "IN";

	      // add transaction
	      if($temp_con == "OUT")
        {
	      	$sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_country,transaction_subid,transaction_transactiontime) values ('$joinid','click','$approvalstatus','$today',0,'$linkid',0,'".addslashes($referer)."','".addslashes($ipaddress)."','".addslashes($name)."','".addslashes($subid)."','$presenttime') ";
        }
	      else
        {
           	$sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_dateofpayment ,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_country,transaction_subid,transaction_transactiontime) values ('$joinid','click','$approvalstatus','$today',$clickrate,'$today','$linkid','$admin_amount','".addslashes($referer)."','".addslashes($ipaddress)."','".addslashes($name)."','".addslashes($subid)."','$presenttime') ";
        }


	//Modified on 19-JUNE-2006 by SMA
			$validclick = 0;
		   if(CheckMultipleRepeatingClicks($joinid, $linkid, $today,$clickseconds, $recentclick, $clickaction))  {
			   $validclick = 1;

			   @mysqli_query($con,$sql);
         // Added by Ankit on 23rd March 2019
          $transactionId = mysqli_insert_id($con);
          InsertAiInfo($transactionId);

          $GLOBALS["tid"] =  $transactionId;
			}
			else
			{
				if($clickaction == "save as click") 
				{
					
					$validclick = 1;
					@mysqli_query($con,$sql);
          // Added by Ankit on 23rd March 2019
          $transactionId = mysqli_insert_id($con);
          InsertAiInfo($transactionId);
          $GLOBALS["tid"] =  $transactionId;
				}
			}
			
			if($validclick == 1)   //Updates Amount to Merchnat, Admin & Affiliate balance if Automatic Approval
			{
				
				
				
					 #  get merchant account
		
					 $sql        = "SELECT *  FROM `merchant_pay`  WHERE pay_merchantid='$mid' ";
					 $res        = @mysqli_query($con,$sql);
					 //echo @mysqli_error($con);
		
					 $num		=	@mysqli_num_rows($res);
					 $cut_off   =	$minimum_amount;
					 

		
					 if($num>0)
					 {
						 $row1   			 =   @mysqli_fetch_object($res);
						 $merchant_balance   = $row1->pay_amount;
		

		
						 //if(($merchant_balance-($clickrate + $admin_clickrate) )<=$cut_off)  
						if(($merchant_balance-($clickrate + $admin_click_rate) )<=$cut_off) 
						{  
							header("Location:money_empty_error.php");
							  exit;
						 }
						 else{
		
							# Update Account info of admin,affil,merchant
		
							# Adding money to affiliate account
							//$merchant_balance = $merchant_balance-($clickrate+$admin_clickrate);
							$merchant_balance = $merchant_balance-($clickrate + $admin_click_rate);
							
							$sql1       = "SELECT *  FROM `affiliate_pay` where pay_affiliateid='$aid' ";
							$res1       = @mysqli_query($con,$sql1);
							//echo @mysqli_error($con);
		
							$num=@mysqli_num_rows($res1);
							if($num>0){
								$row1   	=  @mysqli_fetch_object($res1);
								$curamount  =  $row1->pay_amount;
								$curamount  =  $curamount + $clickrate;
		
								$sql2 = "update affiliate_pay set pay_amount='$curamount' where pay_affiliateid='$aid'";
								$ret2 = @mysqli_query($con,$sql2);
							 }else{
								$sql2 = "INSERT INTO  affiliate_pay set pay_affiliateid='$aid' , pay_amount='$clickrate'";
								$ret2 = @mysqli_query($con,$sql2);
							 }
		
							# affiliate account editing Ends here
		
							# Subtract Money From Merchant Account
							$sql        = "UPDATE  `merchant_pay` SET  pay_amount=$merchant_balance  WHERE pay_merchantid='$mid' ";
							$res        = @mysqli_query($con,$sql);
							# END OF  Subtract Money From Merchant Account
		
							# Adding To Admins Account
							$sql1      = "SELECT *  FROM `admin_pay`  ";
							$res1      = @mysqli_query($con,$sql1);
							//echo @mysqli_error($con);
		
							$num	=	@mysqli_num_rows($res1);
		
							if($num>0){
							   $row1   			   =  @mysqli_fetch_object($res1);
							   $admin_curamount    = $row1->pay_amount;
							   //$admin_curamount    = $admin_curamount + $admin_clickrate;
							   $admin_curamount    = $admin_curamount + $admin_click_rate;
							}
		
							$sql  = "UPDATE `admin_pay` SET `pay_amount` = '$admin_curamount'";
							$res  = @mysqli_query($con,$sql);
		
						# END OF Adding to admin's account
						}
				   }
			}
	//End Modified on 19-JUNE-2006			



	       #$status=$clickrate."~".$salerate."~".$leadrate."~".$saletype."~".$statusid;
		   $status=$clickrate."~".$leadrate."~".$salerate."~".$saletype."~".$statusid;

      }
      else  # manuall approval
      {
          $approvalstatus = "pending";
	      $today          = date("Y-m-d");
	      //$admin_amount   = $admin_clickrate;
		  $admin_amount   = $admin_click_rate;
		  
          /////////// getting country /////////////////////
              $ip 		 = $GLOBALS['REMOTE_ADDR'];
           /////////////////////////////////////////////////

          //checking ip of user against offer available countries
	      $user_ip = (ip2long($ip) < 0 ? -1 * ip2long($ip) : ip2long($ip));
	      $temp_con = "OUT";

	      $selq = "SELECT `program_countries`,`program_geotargeting_click` FROM `partners_program` WHERE `program_id` = '$pgmid'";
	      $row  = mysqli_fetch_object(mysqli_query($con,$selq));
	      $offer_in = explode(",",$row->program_countries);

		  //if geo-targeting feature is enabled for click, then check whether the click is from allowed list of countries
		  if($row->program_geotargeting_click)
		  {
			  for($cind=0;$cind<count($offer_in);$cind++){
			  $selq = "SELECT `ip_from`,`ip_to` FROM `partners_countryFlag` WHERE `country_name` = '".$offer_in[$cind]."'"
					  ." AND ip_from <=".$user_ip." AND `ip_to` >=".$user_ip."";
					if(mysqli_num_rows(mysqli_query($con,$selq))) $temp_con = "IN";
			  }
		   }
		   else $temp_con = "IN";

	      // add transaction
	      if($temp_con == "OUT")
	      	$sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_country,transaction_subid,transaction_transactiontime) values ('$joinid','click','$approvalstatus','$today',0,'$linkid',0,'".addslashes($referer)."','".addslashes($ipaddress)."','".addslashes($name)."','".addslashes($subid)."','$presenttime') ";
	      else
            $sql = "INSERT into partners_transaction(transaction_joinpgmid,transaction_type,transaction_status,transaction_dateoftransaction,transaction_amttobepaid,transaction_linkid,transaction_admin_amount,transaction_referer,transaction_ip,transaction_country,transaction_subid,transaction_transactiontime) values ('$joinid','click','$approvalstatus','$today',$clickrate,'$linkid','$admin_amount','".addslashes($referer)."','".addslashes($ipaddress)."','".addslashes($name)."','".addslashes($subid)."','$presenttime') ";

	//Modified on 19-JUNE-2006 by SMA
		  if(CheckMultipleRepeatingClicks($joinid, $linkid, $today,$clickseconds, $recentclick, $clickaction))
      {
			   @mysqli_query($con,$sql);
      
          // Added by Ankit on 23rd March 2019
          $transactionId = mysqli_insert_id($con);
          InsertAiInfo($transactionId);
          $GLOBALS["tid"] =  $transactionId;
        }
		  else
			{
				if($clickaction == "save as click") {
					@mysqli_query($con,$sql);
          // Added by Ankit on 23rd March 2019
          $transactionId = mysqli_insert_id($con);
          InsertAiInfo($transactionId);
          $GLOBALS["tid"] =  $transactionId;
				}
			}
	//Modified on 19-JUNE-2006	  

	      #$status=$clickrate."~".$salerate."~".$leadrate."~".$saletype."~".$statusid;
		   $status=$clickrate."~".$leadrate."~".$salerate."~".$saletype."~".$statusid;
     }

     if ($mailmerchant=="yes") {
         //MailMerchant($aid,$mid,$pgmid,$clickrate,$admin_clickrate,"click");
		 MailMerchant($aid,$mid,$pgmid,$clickrate,$admin_click_rate,"click");
     }

     if($mailaffiliate=="yes"){
		 MailAffilaite($aid,$mid,$pgmid,$clickrate,"click");
     }

 return($status);
}
 # end function

 # comparing date (last login,current login)
function CompareTime($ipblock)
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



 //------------------------------------------------------------------------------------
    # This function is used to insert/update the  raw click count into
    # the table partners_rawtrans_daily
    #Created on 17-JUNE-2006
    //------------------------------------------------------------------------------------
    function InsertRawTrans_daily($programid, $aid,$mid, $linkid, $today)
    {
		            $con = $GLOBALS["con"];

                $daily_click        = 1;
                $sql           = "SELECT * FROM partners_rawtrans_daily";
                $sql_where = "  WHERE  transdaily_affiliateid='$aid' AND transdaily_programid='$programid'
                              AND  transdaily_merchantid='$mid' AND transdaily_date ='$today'
                              AND transdaily_linkid = '$linkid'";
                            $res        = mysqli_query($con,$sql.$sql_where);
                if(mysqli_num_rows($res)>0)
                {
                    #get the existing impression count
                    $row        = mysqli_fetch_object($res);
                    $daily_click += $row->{transdaily_click};

                    #update
                    $sql         = "UPDATE partners_rawtrans_daily SET ";
                    $sql.= " transdaily_click = '$daily_click' ".$sql_where;

                }
                else
                {
                        #insert record
                    $sql = "INSERT INTO `partners_rawtrans_daily` SET
                            transdaily_affiliateid='$aid' , transdaily_programid='$programid',
                            transdaily_merchantid='$mid' , transdaily_date ='$today' ,
                            transdaily_linkid = '$linkid' , transdaily_click = '$daily_click' ";

                }

                $ret =@mysqli_query($con,$sql) ;
                return true;
    }// end function InsertRawTrans_daily
	
	
	//************************************************************************************	
	//  Created BY	: SMA
	//	Created On	: 19-JUNE-2006
	//  This function is used to check the fraud protection for recent clicks within the specified click seconds.
	//  The function directs to the aaction as specified by the admin in the fraud settings if the click is within the time specified.
	//************************************************************************************
	function CheckMultipleRepeatingClicks($joinid, $linkid, $today, $clickseconds, $recentclick, $clickaction)
	{
	 	$con = $GLOBALS["con"];

		if($recentclick == 1)
		{
			$ipaddress				=   $HTTP_SERVER_VARS['REMOTE_ADDR'];     //getting ip address
			if(empty($ipaddress)) $ipaddress = $_SERVER['REMOTE_ADDR'];
		
			$sql_click = "SELECT *,date_format(transaction_transactiontime,'%H/%i/%s/%d/%m/%y') as transtime FROM partners_transaction WHERE ".
			" transaction_joinpgmid = '$joinid' AND ".
			" transaction_type = 'click' AND ".
			" transaction_linkid = '$linkid' AND ".
			" transaction_ip = '$ipaddress' ORDER BY transaction_id DESC";
			
			
			$res_click = mysqli_query($con,$sql_click);
			if(mysqli_num_rows($res_click) > 0)
			{
				$row_click = mysqli_fetch_object($res_click);
				$lasttime = $row_click->transaction_transactiontime;
					
				# adding currenttime + clickseconds time
				$sql_delay      =   "select date_format(DATE_ADD('$lasttime',INTERVAL $clickseconds SECOND),'%H/%i/%s/%d/%m/%y') d " ;
				$ret_delay      =   @mysqli_query($con,$sql_delay);
				# getting  currenttime + clickseconds
				$row_delay     =   @mysqli_fetch_object($ret_delay);
				$nextclicktime =   $row_delay->d;
	
				//die("time = " .$nextclicktime);
				if(CompareTime($nextclicktime))
				{ 
					 return false;
				} 
				else
				{
					return true;
				}
			}
			else
				return true;
		}
		else
			return true;
	}

  function InsertAiInfo($transactionId)
  {
    $con = $GLOBALS["con"];

    $querystring = mysqli_real_escape_string($con,$_SERVER["QUERY_STRING"]);
    $remoteaddr = mysqli_real_escape_string($con,$_SERVER["REMOTE_ADDR"]);
    $serveraddr = mysqli_real_escape_string($con,$_SERVER["SERVER_ADDR"]);
    $cookie = mysqli_real_escape_string($con,$_SERVER["HTTP_COOKIE"]);
    $language = mysqli_real_escape_string($con,$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
    $referrer = mysqli_real_escape_string($con,$_SERVER["HTTP_REFERER"]);
    $useragent = mysqli_real_escape_string($con,$_SERVER["HTTP_USER_AGENT"]);


    $sql = " Insert into partners_aitrackinginfo (transactionid, querystring, remoteaddr, serveraddr, cookie, language, referrer, useragent) ";
    $sql.= " values ($transactionId, '$querystring', '$remoteaddr', '$serveraddr', '$cookie', '$language', '$referrer', '$useragent' ) "; 

    mysqli_query($con,$sql) ;

  }

?>