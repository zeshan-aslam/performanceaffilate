<?php
function MailEvent($event,$mid,$joinid,$to,$tid)
{   
	$con = $GLOBALS["con"];
	$toaddress  = stripslashes($to);
	
	$sql  = "select * from partners_admin";
	$ret1 = mysqli_query($con,$sql);
	$row  = mysqli_fetch_object($ret1);  
	
	//common header and footer
	$adminheader	= stripslashes($row->admin_mailheader);
	$adminfooter	= stripslashes($row->admin_mailfooter);
	$admin_email 	= stripslashes($row->admin_email);
	$today         	= date("Y-m-d");

	//Get Merchant Details
	if(!empty($mid))
	{   
		$sql_mer  =  "SELECT * FROM partners_login WHERE login_id='$mid' AND login_flag='m'";
		$res_mer  =  mysqli_query($con,$sql_mer);
		if(mysqli_num_rows($res_mer) > 0)
		{
			$row_mer = mysqli_fetch_object($res_mer);
			$mer_mail = stripslashes($row_mer->login_email);
			$mer_password     =stripslashes($row_mer->login_password);
		}
		
		$sql_mer1 = "SELECT * FROM partners_merchant WHERE merchant_id='$mid'";
		$res_mer1 = mysqli_query($con,$sql_mer1);
		if(mysqli_num_rows($res_mer1) > 0)
		{
			$row_mer1 = mysqli_fetch_object($res_mer1);
			$mer_firstname        =stripslashes($row_mer1->merchant_firstname);
			$mer_lastname         =stripslashes($row_mer1->merchant_lastname);
			$mer_company          =stripslashes($row_mer1->merchant_company);
			$mer_loginlink        =stripslashes($row_mer1->merchant_url);
		}
	}

	//get Details of the Join Pgm
	if(!empty($joinid))
	{
		   $sql_join = "select * from partners_joinpgm where joinpgm_id='$joinid' ";
           $res_join = mysqli_query($con,$sql_join);

           if(mysqli_num_rows($res_join)>0)
           {
			   $row_join = mysqli_fetch_object($res_join);
			   $aid = $row_join->joinpgm_affiliateid;
			   $pid = $row_join->joinpgm_programid;
           }
	}
	
	//Get details of the Program
	if(!empty($pid))
	{
/*
		   $sql1="select * from partners_affiliate where affiliate_id=$aid";
           $result1=mysqli_query($con,$sql1);
           
           if(mysqli_num_rows($result1)>0)
		   {
                $rows             =mysqli_fetch_object($result1);
                $firstname        =stripslashes($rows->affiliate_firstname);
                $lastname         =stripslashes($rows->affiliate_lastname);
                $company          =stripslashes($rows->affiliate_company);
                $loginlink        =stripslashes($rows->affiliate_url);
		   }
           
		   $sql1="select * from partners_login where login_id=$aid and login_flag='a'";
           $result1=mysqli_query($con,$sql1);  
           if(mysqli_num_rows($result1)>0)
		   {
                $rows         =mysqli_fetch_object($result1);
                $password     =stripslashes($rows->login_password);
                $affemail     =stripslashes($rows->login_email);
		   }
*/		   
           $sql_pgm ="select * from partners_program where program_id='$pid' ";
           $res_pgm=mysqli_query($con,$sql_pgm);   
           if(mysqli_num_rows($res_pgm)>0)
		   {
                $row_pgm        =mysqli_fetch_object($res_pgm);
                $program     =stripslashes($row_pgm->program_url);
		   }
	} //End checking for Program
	
	//get detrails of Transaction
	if(!empty($tid))
	{
          $sql_trans="select * from partners_transaction where transaction_id='$tid' ";
          $res_trans=mysqli_query($con,$sql_trans);
          if(mysqli_num_rows($res_trans)>0)
		  {
                $row_trans         =mysqli_fetch_object($res_trans);
                $type         =stripslashes($row_trans->transaction_type);
                $date         =stripslashes($row_trans->transaction_dateoftransaction);
                $commission   =stripslashes($row_trans->transaction_amttobepaid);
		   }
	}
	
	
	//Get the details of the to address
	$sql_rec = "SELECT * FROM partners_login WHERE login_email='$to' ";
	$res_rec = mysqli_query($con,$sql_rec);
	if(mysqli_num_rows($res_rec) > 0)
	{
		//Gets the details of the Email Receiver
		$row_rec 			= mysqli_fetch_object($res_rec);
		$receiver_type		= $row_rec->login_flag;
		$receiver_id		= $row_rec->login_id;
		$receiver_password 	= $row_rec->login_password;
		
		if($receiver_type == 'a')
		{
			$sql_aff = "SELECT * FROM partners_affiliate where affiliate_id='$receiver_id' ";
			$res_aff = mysqli_query($con,$sql_aff);
			if(mysqli_num_rows($res_aff) > 0)
			{
				$row_aff = mysqli_fetch_object($res_aff);
				$aff_firstname        = stripslashes($row_aff->affiliate_firstname);
				$aff_lastname         = stripslashes($row_aff->affiliate_lastname);
				$aff_company          = stripslashes($row_aff->affiliate_company);
				$aff_loginlink        = stripslashes($row_aff->affiliate_url);
			}
		}
		else if($receiver_type == 'm')
		{
			$mer_mail 		= stripslashes($to);
			$mer_password   = stripslashes($receiver_password);
			
			$sql_mer = "SELECT * FROM partners_merchant WHERE merchant_id='$receiver_id'";
			$res_mer = mysqli_query($con,$sql_mer);
			if(mysqli_num_rows($res_mer) > 0)
			{
				$row_mer = mysqli_fetch_object($res_mer);
				$mer_firstname        = stripslashes($row_mer ->merchant_firstname);
				$mer_lastname         = stripslashes($row_mer ->merchant_lastname);
				$mer_company          = stripslashes($row_mer ->merchant_company);
				$mer_loginlink        = stripslashes($row_mer ->merchant_url);
			}
		}
		

	//Gets the details of the mail content FROM Merchant mail
		$sql_event = "select * from partners_mermail where mermail_eventname='$event' and mermail_merchantid='$mid' ";
     	$res_event = mysqli_query($con,$sql_event); 
		//die("mer sql = ".$sql_event);
		if(mysqli_num_rows($res_event) > 0)
		{   
			$row_event 		= mysqli_fetch_object($res_event);
			$subject        = stripslashes($row_event->mermail_subject);
			$message       	= stripslashes($row_event->mermail_message);
			$head          	= stripslashes($row_event->mermail_header);
			$footer        	= stripslashes($row_event->mermail_footer);
			$from          	= stripslashes($row_event->mermail_from);

                    $headers        =  "Content-Type: text/html; charset=windows-1255\n";
                    $headers       .=  "From: $from\n";
				 	$headers=str_replace("[from]",$mer_mail,$headers);
                    
					$body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
                    $body.="<tr>";
                    $body.="<td width='100%' align='center' valign='top'><br/>";
                    $body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";

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

                    $body.="</table>";
                    $body.="</td>";
                    $body.="</tr>";
                    $body.="</table>";
					
                     $body=str_replace("[firstname]",$aff_firstname,$body);
                     $body=str_replace("[lastname]",$aff_lastname,$body);
                     $body=str_replace("[company]",$aff_company,$body);
                     $body=str_replace("[affemail]",$to,$body);
                     $body=str_replace("[loginlink]",$aff_loginlink,$body);
					 $body=str_replace("[from]",$mer_mail,$body);
                     $body=str_replace("[password]",$receiver_password,$body);
                     
					 $body=str_replace("[commission]",$commission,$body);
                     $body=str_replace("[program]",$program,$body);
                     $body=str_replace("[type]",$type,$body);
                     $body=str_replace("[date]",$date,$body);
                     $body=str_replace("[today]",$today,$body);

		
		}
		else //Gets the details of the mail content FROM Admin mail
		{
			$sql_adminEvent = "select * from partners_adminmail where adminmail_eventname='$event' "; 
			$res_adminEvent = mysqli_query($con,$sql_adminEvent); 
			//echo("ad qry = ".$sql_adminEvent);
			if(mysqli_num_rows($res_adminEvent) > 0)
			{
				$row_adminEvent = mysqli_fetch_object($res_adminEvent);
				$subject        = stripslashes($row_adminEvent->adminmail_subject);
				$message        = stripslashes($row_adminEvent->adminmail_message);
				$head           = stripslashes($row_adminEvent->adminmail_header);
				$footer         = stripslashes($row_adminEvent->adminmail_footer);
				$from           = stripslashes($row_adminEvent->adminmail_from);
				
                    $headers        =  "Content-Type: text/html; charset=windows-1255\n";
                    $headers       .=  "From: $from\n";
				 	$headers	= str_replace("[from]",$admin_email,$headers);
					
                    $body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
                    $body.="<tr>";
                    $body.="<td width='100%' align='center' valign='top'><br/>";
                    $body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";
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

                    $body.="</table>";
                    $body.="</td>";
                    $body.="</tr>";
                    $body.="</table>";

					//Replace variable in the content with values
                     $body=str_replace("[aff_firstname]",$aff_firstname,$body);
                     $body=str_replace("[aff_lastname]",$aff_lastname,$body);
                     $body=str_replace("[aff_company]",$aff_company,$body);
                     $body=str_replace("[aff_email]",$to,$body);
                     $body=str_replace("[aff_loginlink]",$aff_loginlink,$body);
                     $body=str_replace("[aff_password]",$receiver_password,$body);
                     
                     $body=str_replace("[mer_firstname]",$mer_firstname,$body);
                     $body=str_replace("[mer_lastname]",$mer_lastname,$body);
                     $body=str_replace("[mer_company]",$mer_company,$body);
                     $body=str_replace("[mer_email]",$mer_mail,$body);
                     $body=str_replace("[mer_loginlink]",$mer_loginlink,$body);
                     $body=str_replace("[mer_password]",$mer_password,$body);
					 
					 $body=str_replace("[from]",$admin_email,$body);
                     $body=str_replace("[commission]",$commission,$body);
                     $body=str_replace("[program]",$program,$body);
                     $body=str_replace("[type]",$type,$body);
                     $body=str_replace("[date]",$date,$body);
                     $body=str_replace("[today]",$today,$body);
					 
					// die( "<br/> to = ".$toaddress."  sub = ".$subject."  body = ".$body."   head  = ".$headers);
			}
		}
	}	
	
	mail($toaddress,$subject,$body,$headers);
	
}
?>