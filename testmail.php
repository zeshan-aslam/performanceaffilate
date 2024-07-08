<?php
			  /*****************mail affilaite during transaction**********/
			   function MailAffilaite($aid,$mid,$pgmid,$clickrate,$trans)
			   {
                $con = $GLOBALS["con"];

                    $sql_mer		="select * from partners_merchant where merchant_id='$mid'";
                    $res_mer		=mysqli_query($con,$sql_mer);
                    $row_mer		=mysqli_fetch_object($res_mer);
                    $merchantname=stripslashes($row_mer->merchant_firstname)." ".stripslashes($row_mer->merchant_lastname);
					$mer_firstname	=  stripslashes($row_mer->merchant_firstname);
					$mer_lastname	=  stripslashes($row_mer->merchant_lastname);
					$mer_company	=  stripslashes($row_mer->merchant_company);
					$mer_loginlink	=  stripslashes($row_mer->merchant_url);
					
                    $sql_mer1="select * from partners_login where login_id=$mid and login_flag='m'";
                    $res_mer1=mysqli_query($con,$sql_mer1);
                    $row_mer1=mysqli_fetch_object($res_mer1);
					$mer_mail		=  stripslashes($row_mer1->login_email);
					$mer_password	=  stripslashes($row_mer1->login_password);
                    
					
					$sql	="select * from partners_program where program_id='$pgmid'";
                    $result	=mysqli_query($con,$sql);
                    $row	=mysqli_fetch_object($result);
                    $pgmname=stripslashes($row->program_url);


					$sql_aff="select * from partners_affiliate where affiliate_id='$aid'";
					$res_aff=mysqli_query($con,$sql_aff);
					// echo $sql1;
					if(mysqli_num_rows($res_aff)>0)
					{
						$row_aff          =mysqli_fetch_object($res_aff);
						$firstname        =stripslashes($row_aff->affiliate_firstname);
						$lastname         =stripslashes($row_aff->affiliate_lastname);
						$company          =stripslashes($row_aff->affiliate_company);
						$loginlink        =stripslashes($row_aff->affiliate_url);
					}                    
					
					$sql		="select * from partners_login where login_id='$aid' and login_flag='a'";
                    $result		=mysqli_query($con,$sql);
                    $row		=mysqli_fetch_object($result);
                    $mailid		=$row->login_email;
					$password	=stripslashes($row->login_password);
					$affemail	=stripslashes($row->login_email);

                    $mailtosend="Transaction Type=$trans\n" ;
                    $mailtosend1=" Amount=$clickrate\n";
                    $mailtosend2="Pogram=$pgmname\n" ;
                    $mailtosend3=" Merchant=$merchantname\n";

                    $sql		="select * from partners_admin";
                    $ret1		=mysqli_query($con,$sql);
                    $row		=mysqli_fetch_object($ret1);  //common header and footer
                    $adminheader=stripslashes($row->admin_mailheader);
                    $adminfooter=stripslashes($row->admin_mailfooter);
					$admin_email	 =    stripslashes($row->admin_email);


                   $sql="select * from partners_adminmail where adminmail_eventname='MailAffiliate' ";
                   $result=mysqli_query($con,$sql) or die(mysqli_error($con));

                   if(mysqli_num_rows($result)>0)
                   {
                      $row			 =mysqli_fetch_object($result);
                      $sub           =stripslashes($row->adminmail_subject);
                      $message       =stripslashes($row->adminmail_message);
                      $head          =stripslashes($row->adminmail_header);
                      $footer        =stripslashes($row->adminmail_footer);
                      $from          =stripslashes($row->adminmail_from);
                      //$toaddress  = $to;
                      $subject        = $sub;
                  }


                    $to=$mailid;
					$today            = date("Y-m-d");
                  //  $sub="Password Change Notification Mail";

                    $headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
                    $headers       .=  "From: $from\n";
					$headers		=str_replace("[from]",$admin_email,$headers); 
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
                    $body.="<td  width='100%' align='left'>$mailtosend</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$mailtosend1</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$mailtosend2</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$mailtosend3</td>";
                    $body.="</tr>";
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
                     $body=str_replace("[commission]",$clickrate,$body);
                     $body=str_replace("[program]",$pgmname,$body);
                     $body=str_replace("[type]",$trans,$body);
                     $body=str_replace("[date]",$today,$body);
                     $body=str_replace("[today]",$today,$body);

                 mail($to,$subject,$body,$headers);
                 $mailok="Password Change Notification Mail Has been Send \n";
                 $mailok .= " To :".$to." \n";
                 $mailok.=" From :".$from;

		   }
		   /***************************************************************/

		   /**********mail merchant during transaction*********************/
			function MailMerchant($aid,$mid,$pgmid,$clickrate,$adminclick,$trans)
			{
                $con = $GLOBALS["con"];
                
                    $sql_aff		="select * from partners_affiliate where affiliate_id='$aid'";
                    $res_aff		=mysqli_query($con,$sql_aff);
                    $row_aff		=mysqli_fetch_object($res_aff);
                    $name			=stripslashes($row_aff->affiliate_firstname)." ".stripslashes($row_aff->affiliate_lastname);
					$firstname        =stripslashes($row_aff->affiliate_firstname);
					$lastname         =stripslashes($row_aff->affiliate_lastname);
					$company          =stripslashes($row_aff->affiliate_company);
					$loginlink        =stripslashes($row_aff->affiliate_url);

					$sql_aff1		="select * from partners_login where login_id='$aid' and login_flag='a'";
                    $res_aff1		=mysqli_query($con,$sql_aff1);
                    $row_aff1		=mysqli_fetch_object($res_aff1);
					$password	=stripslashes($row_aff1->login_password);
					$affemail	=stripslashes($row_aff1->login_email);

                    $sql="select * from partners_program where program_id='$pgmid'";
                    $result=mysqli_query($con,$sql);
                    $row=mysqli_fetch_object($result);
                    $pgmname=stripslashes($row->program_url);

                    $sql_mer		="select * from partners_merchant where merchant_id='$mid'";
                    $res_mer		=mysqli_query($con,$sql_mer);
                    $row_mer		=mysqli_fetch_object($res_mer);
                    $merchantname=stripslashes($row_mer->merchant_firstname)." ".stripslashes($row_mer->merchant_lastname);
					$mer_firstname	=  stripslashes($row_mer->merchant_firstname);
					$mer_lastname	=  stripslashes($row_mer->merchant_lastname);
					$mer_company	=  stripslashes($row_mer->merchant_company);
					$mer_loginlink	=  stripslashes($row_mer->merchant_url);

                    $sql="select * from partners_login where login_id='$mid' and login_flag='m'";
                    $result=mysqli_query($con,$sql);
                    $row=mysqli_fetch_object($result);
                    $mailid=$row->login_email;
					$mer_mail		=  stripslashes($row->login_email);
					$mer_password	=  stripslashes($row->login_password);

                    $mailtosend="Transaction Type=$trans\n" ;
                    $mailtosend1=" Affiliate Commisssion=$clickrate\n  Admin Commission=$adminclick";
                    $mailtosend2="Pogram=$pgmname\n" ;
                    $mailtosend3="Affiliate=$name\n";


                    $sql="select * from partners_admin";
                    $ret1=mysqli_query($con,$sql);
                    $row=mysqli_fetch_object($ret1);  //common header and footer
                    $adminheader=stripslashes($row->admin_mailheader);
                    $adminfooter=stripslashes($row->admin_mailfooter);
					$admin_email	 =    stripslashes($row->admin_email);


                   $sql="select * from partners_adminmail where adminmail_eventname='MailMerchant' ";
                   $result=mysqli_query($con,$sql) or die(mysqli_error($con));

                   if(mysqli_num_rows($result)>0)
                   {
                      $row			 =mysqli_fetch_object($result);
                      $sub           =stripslashes($row->adminmail_subject);
                      $message       =stripslashes($row->adminmail_message);
                      $head          =stripslashes($row->adminmail_header);
                      $footer        =stripslashes($row->adminmail_footer);
                      $from          =stripslashes($row->adminmail_from);
                      //$toaddress  = $to;
                      $subject        = $sub;
                  }


                    $to=$mailid;
					$today         =date("Y-m-d");
                  //  $sub="Password Change Notification Mail";

                    $headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
                    $headers       .=  "From: $from\n";
					$headers		=str_replace("[from]",$mer_mail,$headers);
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
                    $body.="<td  width='100%' align='left'>$mailtosend</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$mailtosend1</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$mailtosend2</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$mailtosend3</td>";
                    $body.="</tr>";
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
                     $body=str_replace("[commission]",$clickrate,$body);
                     $body=str_replace("[program]",$pgmname,$body);
                     $body=str_replace("[type]",$trans,$body);
                     $body=str_replace("[date]",$today,$body);
                     $body=str_replace("[today]",$today,$body);
					

                 mail($to,$subject,$body,$headers);
                 $mailok="Password Change Notification Mail Has been Send \n";
                 $mailok .= " To :".$to." \n";
                 $mailok.=" From :".$from;

               }
               /***************************************************************/
?>