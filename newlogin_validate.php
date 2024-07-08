<?php	

	include_once 'includes/db-connect.php';
    include_once 'includes/session.php';
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';

    

    include_once 'language_include.php';

    $response["status"] = false;
    $response["message"] = "";

    $partners = new partners;

    //==========================variables=======================================/
	$login                =trim(addslashes($_POST['login']));       //login email id
	$passwd               =trim(addslashes($_POST['password']));    //password
	$flag                 =trim($_POST['optradio']);        //differentiate merchant and affiliate
 
	//Validate Fields
	$valid = 1;
	if($flag != 'affiliate' and $flag != 'merchant')
	{  
		$valid  = 0;
		$response["message"] = "Invalid login request";
	}
	else if($login == "") {
		$valid 	= 0;
		$Err	= "err1002";
		$response["message"] = "Username is required";
	}
	else if($passwd == "")  {
		$valid 	= 0;
		$Err	= "err1002";
		$response["message"] = "Password is required";
	}
	else if(!$partners->is_email($login)) {
		$valid 	= 0;
		$Err	= "err1000";
		$response["message"] = "Invalid username";
	}
	 
	

    //=======================checking type of login=============================/
	if  ($flag=='affiliate') $type='a';        //affilaite login
	else $type='m';                           //merchant login
    //==========================================================================/


	//LoGIN PROTECTION Checking Added on 19-JUNE BY SMA
	$proceed = 1;

	$retry_limit = $fraudsettings_login_retry;
	$login_delay = $fraudsettings_login_delay;
	
	$currenttime  	=   date("Y-m-d  H:i:s");
	# adding currenttime + login_delay time
	$sql_delay      =   "select DATE_ADD('$currenttime',INTERVAL $login_delay SECOND) d " ;
	$ret_delay      =   @mysqli_query($con,$sql_delay);
	# getting  currenttime+login_delay
	$row_delay     =   @mysqli_fetch_object($ret_delay);
	$nextlogintime =   $row_delay->d;
	
	if($retry_limit > 0)
	{
		$sql_retry = "SELECT login_retry_limit, date_format(login_next_login,'%H/%i/%s/%d/%m/%y') as delay FROM partners_login WHERE login_email = '$login'";
		$res_retry = mysqli_query($con,$sql_retry);
		if(mysqli_num_rows($res_retry) > 0)
		{
			$row_retry = mysqli_fetch_object($res_retry);
			$user_retry = $row_retry->login_retry_limit;
			$user_delay	= $row_retry->delay;

			
			if($user_retry >= $retry_limit)
			{
				if(CompareTime($user_delay))
				{ 
					$proceed = 0;
				} else
				{	 
					//updates the retry limit to 0
					$sql_update = "UPDATE partners_login SET login_retry_limit = '0' WHERE login_email = '$login'";
					@mysqli_query($con,$sql_update);
					$proceed = 1;
				}
			} else
			{
				$proceed = 1;
			}
		}
	}
	
	if($proceed == 1)
	{
//End add LOGIN PROTECTion

    //======================login checking===================================/
        $sql        ="SELECT * FROM partners_login where login_email='$login' AND login_password='$passwd' and login_flag='$type'";
        
		//echo $sql;

        $result     =mysqli_query($con,$sql); 
        echo mysqli_error($con);


		

        if(mysqli_num_rows($result)) 
		{
		// Added by SMA on 19-JUNE-2006 for updating retry limit if login is correct
			$sql_update = "UPDATE partners_login SET login_retry_limit = '0' WHERE login_email = '$login' AND login_password='$passwd' and login_flag='$type'";
			
			@mysqli_query($con,$sql_update);			
		// End Add by SMA on 19-JUNE-2006 

             $row    =mysqli_fetch_object($result);



            //==========affiliate login=========================================/
            if($flag=='affiliate')  {
                 $_SESSION['AFFILIATEID']   = $AFFILIATEID       =$row->login_id;

                 


                 $sql   ="select * from affiliate_pay where pay_affiliateid='$AFFILIATEID'  ";
                 $ret   =mysqli_query($con,$sql);
                 $row   =mysqli_fetch_object($ret);

                 $_SESSION['AFFILIATEBALANCE']=$row->pay_amount;

                 $sql   ="select * from partners_affiliate where affiliate_id='$AFFILIATEID' ";


                 $ret   =mysqli_query($con,$sql);
                 $row   =mysqli_fetch_object($ret);

                 $_SESSION['AFFILIATENAME'] =stripslashes($row->affiliate_firstname)." ".stripslashes($row->affiliate_lastname );

                 
                
                $response["affiliate"] = $row;

				 $ip = $_SERVER['REMOTE_ADDR'];
				  $insertlog = "insert into user_log (ip,user_id,date,type) values ('$ip','$AFFILIATEID',Now(),'a')";

                 if($row->affiliate_status<>'approved') {                             //not approved
                    
                    $Err = "err1003";
                    $response["message"] = "Your account is under review, please check back soon.";

                 }
                 else{
					mysqli_query($con,$insertlog);
                    $response["status"] = true;
					$response["message"] = "Affiliate login successful";
					$_SESSION["show_message"] = "Merchant login successful";
					$response["redirect"] = "https://performanceaffiliate.com/affiliates/index.php?Act=Home";            //approved suceessful login

                }

             }
             //=========================close afffiliate login=================/

             //========== merchant login========================================/
             else
             {
				  $_SESSION['MERCHANTID']= $MERCHANTID       =$row->login_id;
	
				  $sql1 ="select * from merchant_pay where pay_merchantid='$MERCHANTID'  ";
				  $ret1 =mysqli_query($con,$sql1);
				  $row1 =mysqli_fetch_object($ret1);
	
				  $_SESSION['MERCHANTBALANCE']=$row1->pay_amount;
	
				  $sql  ="select * from partners_merchant where merchant_id='$MERCHANTID'  ";
				  $ret  =mysqli_query($con,$sql);
				  $row  =mysqli_fetch_object($ret);
	
				  $_SESSION['MERCHANTNAME'] =stripslashes($row->merchant_firstname)." ".stripslashes($row->merchant_lastname );
					
				  $ip = $_SERVER['REMOTE_ADDR'];
				  $insertlog = "insert into user_log (ip,user_id,date,type) values ('$ip','$MERCHANTID',Now(),'m')";
	
				  if($row->merchant_status=='NP' || $row->merchant_status=='empty')
				  {                            //not approved
						mysqli_query($con,$insertlog);
						$response["message"] = "Affiliate login successful";
						$_SESSION["show_message"] = "Merchant login successful";
						$response["redirect"] = "/index.php?Act=Payment&id='$MERCHANTID'";

				  }
				  elseif($row->merchant_status=='approved'){
						mysqli_query($con,$insertlog);
					   	$response["status"] = true;
						$response["message"] = "Merchant login successful";
						$_SESSION["show_message"] = "Merchant login successful";
						$response["redirect"] = "https://performanceaffiliate.com/merchants/index.php?Act=home";

				  }
				  else{                            //not approved
	
						$response["message"] = "Merchant login failed";
				  }

             }
        }
        else
        {
		// Added by SMA on 19-JUNE-2006 for LOGIN PROTECTION to block login after n logins
			if($retry_limit > 0)
			{
				
				$sql_retry = "SELECT login_retry_limit FROM partners_login WHERE login_email = '$login'";
				//die($sql_retry);

				$res_retry = mysqli_query($con,$sql_retry);
				if(mysqli_num_rows($res_retry) > 0)
				{
					$row = mysqli_fetch_object($res_retry);
					$retry = $row->login_retry_limit + 1;
					$_SESSION['USERRETRIEDCOUNT'] = $retry;
					
					$sql_newretry = "UPDATE partners_login SET ".
					" login_retry_limit = '$retry' ";
					
					if($retry >= $retry_limit)
					{	
						$sql_newretry .= " , login_next_login = '$nextlogintime' ";
					}
					
					$sql_newretry .= " WHERE login_email = '$login'";
					$res_newretry = @mysqli_query($con,$sql_newretry);
					
					$retry_msg = $logincompleted.$retry.$loginsoutof.$retry_limit.$allowedlogins;
				}
			}
		//End Add on 19-JUNE-2006 
		
			if($retry_msg)
			{ 
				$response["message"] = "Your account is under review, please check back soon.";
			}
			else  
			{
				$response["message"] = "Incorrect username/password";
           	}
       }
       //=============================invalid login close=======================/

       //======================end checking======================================/
	} 
	else
	{
			$response["message"] = "Your account has been temporary locked, please contact administrator";
	}	   

echo json_encode($response);


//*********************************************************************************
//~~~~~~~~~~~~~~~~  FUNCTIONS  ~~~~~~~~~~~~~~~~~~~~~~~
//*********************************************************************************
	   
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
# ends fn CompareTime
	   
?>
