<?php	ob_start();

 	include '../includes/session.php';
 	include '../includes/constants.php';
 	include '../includes/functions.php';
 	include '../includes/allstripslashes.php';


 	$partners=new partners;
 	$partners->connection($host,$user,$pass,$db);

	$affiliate_id        =intval($_GET['affiliateid']);
    $merchant_id	     =intval($_GET['merchantid']);
	$amount   			 =$_GET['amount'];
	$transid  			 =$_GET['transid'];
    $today	   			 =date("Y-m-d");
	
//getting details to send Mail
	if($affiliate_id) 
	{	//Affiliate details
			$sql_aff		="select * from partners_affiliate where affiliate_id='$affiliate_id'";
			$res_aff		=mysql_query($sql_aff);
			$row_aff		=mysql_fetch_object($res_aff);
			$firstname        =stripslashes($row_aff->affiliate_firstname);
			$lastname         =stripslashes($row_aff->affiliate_lastname);
			$company          =stripslashes($row_aff->affiliate_company);
			$loginlink        =stripslashes($row_aff->affiliate_url);

			$sql_aff1		="select * from partners_login where login_id='$affiliate_id' and login_flag='a'";
			$res_aff1		=mysql_query($sql_aff1);
			$row_aff1		=mysql_fetch_object($res_aff1);
			$password	=stripslashes($row_aff1->login_password);
			$affemail	=stripslashes($row_aff1->login_email);
	}

	if($merchant_id)
	{	//Merchant Details
			$sql_mer		="select * from partners_merchant where merchant_id='$merchant_id'";
			$res_mer		=mysql_query($sql_mer);
			$row_mer		=mysql_fetch_object($res_mer);
			$mer_firstname	=  stripslashes($row_mer->merchant_firstname);
			$mer_lastname	=  stripslashes($row_mer->merchant_lastname);
			$mer_company	=  stripslashes($row_mer->merchant_company);
			$mer_loginlink	=  stripslashes($row_mer->merchant_url);
			
			$sql_mer1="select * from partners_login where login_id='$merchant_id' and login_flag='m'";
			$res_mer1=mysql_query($sql_mer1);
			$row_mer1=mysql_fetch_object($res_mer1);
			$mer_mail		=  stripslashes($row_mer1->login_email);
			$mer_password	=  stripslashes($row_mer1->login_password);
	}
	
	if($transid)
	{	//Transaction Details
		$sql_trans = "SELECT * FROM partners_transaction, partners_joinpgm, partners_program WHERE transaction_id='$transid' ".
		" AND joinpgm_id=transaction_joinpgmid AND program_id=joinpgm_programid ";
		$res_trans = mysql_query($sql_trans);
		if(mysql_num_rows($res_trans) > 0)
		{
			$row_trans = mysql_fetch_object($res_trans);
			$admin_commission	= $row_trans->transaction_admin_amount;
			$trans_type			= $row_trans->transaction_type;
			$trans_date			= $row_trans->transaction_dateoftransaction;
			$program_Name		= $row_trans->program_url;		
		}
	}
//end getting details	

    //geting records from table
     $admin_sql ="SELECT * FROM   admin_pay ";
     $admin_ret =mysql_query($admin_sql);

     //checking for each records
     if(mysql_num_rows($admin_ret)>0)
     {
             $row                  =mysql_fetch_object($admin_ret);
             $admin_pay_amount     =$row->pay_amount;
     }

    if($admin_pay_amount-$amount>=0){
   	 //updating record if paynebt success
	    $sql ="update partners_transaction set transaction_status='reversed' where transaction_id='$transid' ";
	    $ret =mysql_query($sql);

	      //geting records from table
	     $merchant_sql ="SELECT * FROM   merchant_pay  WHERE pay_merchantid='$merchant_id'";
	     $merchant_ret =mysql_query($merchant_sql);

	     //checking for each records
	     if(mysql_num_rows($merchant_ret)>0)
	     {
	             $row                  =mysql_fetch_object($merchant_ret);
	             $merchant_pay_amount  =$row->pay_amount;
	     }

	    $merchant_pay_amount    =  $merchant_pay_amount + $amount;
	    $admin_pay_amount       =  $admin_pay_amount -  $amount;

	     //paying for merchant
	    $sql ="update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$merchant_id'";
	    $ret =mysql_query($sql);

	     //paying for admin
	    $sql ="update admin_pay set pay_amount='$admin_pay_amount' ";
	    $ret =mysql_query($sql);

        $msg="Payment Successfull!!!";
	    $msg=urlencode($msg);

       //   MailEvent("Reverse Sale",$merchant_id,$transid[2],$to,$transid[0]);

                    $sql="select * from partners_admin";
                    $ret1=mysql_query($sql);
                    $row=mysql_fetch_object($ret1);  //common header and footer
                    $adminheader=stripslashes($row->admin_mailheader);
                    $adminfooter=stripslashes($row->admin_mailfooter);
					$admin_email	 =    stripslashes($row->admin_email);

                    $sql="select * from partners_adminmail where adminmail_eventname='Reverse Transaction' ";
                    $result=mysql_query($sql);

                   if(mysql_num_rows($result)>0)
                   {

                      $row=mysql_fetch_object($result);
                      $sub           =stripslashes($row->adminmail_subject);
                      $message       =stripslashes($row->adminmail_message);
                      $head          =stripslashes($row->adminmail_header);
                      $footer        =stripslashes($row->adminmail_footer);
                      $from          =stripslashes($row->adminmail_from);
                      //$toaddress  = $to;
                      $subject        = $sub;
                  }

                   $sql       ="select * from partners_login where login_id ='$merchant_id' and login_flag='m'";
                   $ret 	  =mysql_query($sql);
                   if(mysql_num_rows($ret)>0)
                   {
                     $row 	=mysql_fetch_object($ret);
                     $to  	=$row->login_email;

                   }


                    $headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
                    $headers       .=  "From: $from\n";
					$headers		=str_replace("[from]",$admin_email,$headers); 
                    $body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
                    $body.="<tr>";
                    $body.="<td width='100%' align='center' valign='top'><br/>";
                    $body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='center' bgcolor='#000000'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='center'> $adminheader</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'> $head</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td width='100%' align='left'>$message";
                    $body.="</td></tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$footer</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='center'>$adminfooter</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'  bgcolor='#000000'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="</table>";
                    $body.="</td>";
                    $body.="</tr>";
                    $body.="</table>";
					
					//Replace variable in the content with values
                     $body=str_replace("[aff_firstname]",$firstname,$body);
                     $body=str_replace("[aff_lastname]",$lastname,$body);
                     $body=str_replace("[aff_company]",$company,$body);
                     $body=str_replace("[aff_email]",$affemail,$body);
                     $body=str_replace("[aff_loginlink]",$loginlink,$body);
                     $body=str_replace("[aff_password]",$password,$body);
                     
                     $body=str_replace("[mer_firstname]",$mer_firstname,$body);
                     $body=str_replace("[mer_lastname]",$mer_lastname,$body);
                     $body=str_replace("[mer_company]",$mer_company,$body);
                     $body=str_replace("[mer_email]",$mer_mail,$body);
                     $body=str_replace("[mer_loginlink]",$mer_loginlink,$body);
                     $body=str_replace("[mer_password]",$mer_password,$body);
					 
					 $body=str_replace("[from]",$admin_email,$body);
                     $body=str_replace("[commission]",$admin_commission,$body);
                     $body=str_replace("[program]",$program_Name,$body);
                     $body=str_replace("[type]",$trans_type,$body);
                     $body=str_replace("[date]",$trans_date,$body);
                     $body=str_replace("[today]",$today,$body);
					
                 mail($to,$subject,$body,$headers);
                 $mailok="Password Change Notification Mail Has been Send \n";
                 $mailok .= " To :".$to." \n";
                 $mailok.=" From :".$from;

       /////////////////////////////////////////////////////////////////////////


    }
   else{
        $msg="Payment Failure.Admin has no money in his account!!!";
	    $msg=urlencode($msg);
   }
    header("location:index.php?Act=reverse_payments&msg=$msg");
    exit;

?>