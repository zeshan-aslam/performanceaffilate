<?php

    include_once 'includes/db-connect.php';
    include_once 'includes/session.php';
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';
    use PHPMailer\PHPMailer\PHPMailer;

    function cleanData($value)
    {
        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }
    function send_smtp_mail($to,$msg,$Subject,$from)
    {
       require_once "PHPMailer2/PHPMailer.php";
       require_once "PHPMailer2/SMTP.php";
       require_once "PHPMailer2/Exception.php";
 
       $mail = new PHPMailer();
 
       //SMTP Settings
       $mail->isSMTP();
       $mail->Host = "smtp.gmail.com";
       $mail->SMTPAuth = true;
       $mail->Username = "searlco.co@gmail.com"; //enter you email address
       $mail->Password = 'giuffisowopirwwv'; //enter you email password
       $mail->Port = 465;
       $mail->SMTPSecure = "ssl";
 
       //Email Settings
       $mail->isHTML(true);
       $mail->setfrom("searlco6@gmail.com");
       $mail->FromName = $from;
       $mail->addAddress($to); //enter you email address
       $mail->isHTML(true);
       $mail->Subject = $Subject;
       $mail->Body = $msg;
       $mail->AltBody = "This is the plain text version of the email content";
       try {
          $mail->send();
          $SM = TRUE;
      } catch (Exception $e) {
          echo "Mailer Error: " . $mail->ErrorInfo;
      }
      return true;
 
    }
    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

    /**************************variables***************************************/
    $login		=trim($_POST['login']);       //login email id
    $flag		=trim($_POST['flag']);         //differentiate merchant and affiliate
	$today            = date("Y-m-d");
    /**************************************************************************/



    /***********************checking type of login*****************************/
    if  ($flag=='affiliate')
          $type='a';                          //affilaite login
    else
         $type='m';                           //merchant login
    /**************************************************************************/

     $sql        ="SELECT * FROM partners_login where login_email='$login'  and login_flag='$type'";
     $result     =mysqli_query($con, $sql);
     echo mysqli_error($con);     
    if(mysqli_num_rows($result)>0)
    { 
        
            $row    =mysqli_fetch_object($result);
            $mailid	=$login;
            $pwd	=$row->login_password;
			$loginId = $row->login_id;
			
			if($type == 'a')
			{
				$sql_aff="select * from partners_affiliate where affiliate_id='$loginId'";
				$res_aff=mysqli_query($con, $sql_aff);
				// echo $sql1;
				if(mysqli_num_rows($res_aff)>0)
				{
					$rows             =mysqli_fetch_object($res_aff);
					$firstname        =stripslashes($rows->affiliate_firstname);
					$lastname         =stripslashes($rows->affiliate_lastname);
					$company          =stripslashes($rows->affiliate_company);
					$loginlink        =stripslashes($rows->affiliate_url);
                    
				}
			} 
			else if($type == 'm')
			{
				$sql_mer1 = "SELECT * FROM partners_merchant WHERE merchant_id='$loginId'";
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
			
             
			        $sql="select * from partners_admin";
                    $ret1=mysqli_query($con,$sql);
                    $row=mysqli_fetch_object($ret1);  //common header and footer
                    $adminheader=stripslashes($row->admin_mailheader);
                    $adminfooter=stripslashes($row->admin_mailfooter);
					$admin_email	 =    stripslashes($row->admin_email);

					if($type == 'a')
					{
					   $sql_event="select * from partners_adminmail where adminmail_eventname='Affiliate Remember Password' ";
					} 
					else if($type == 'm'){
						$sql_event="select * from partners_adminmail where adminmail_eventname='Merchant Remember Password' ";
					}
                    $result1=mysqli_query($con,$sql_event);

                   if(mysqli_num_rows($result1)>0)
                   {

                      $row=mysqli_fetch_object($result1);
                      $sub           =stripslashes($row->adminmail_subject);
                      $message       =stripslashes($row->adminmail_message);
                      $head          =stripslashes($row->adminmail_header);
                      $footer        =stripslashes($row->adminmail_footer);
                      $from          =stripslashes($row->adminmail_from);
                      //$toaddress  = $to;
                      $subject        = $sub;
                  }



                    $to=$mailid;
                    //$sub="Password Change Notification Mail";

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
                    $body.="<td width='100%' align='left'>Your Password is $pwd";
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
                     $body=str_replace("[aff_password]",$pwd,$body);
                     
                     $body=str_replace("[mer_firstname]",$mer_firstname,$body);
                     $body=str_replace("[mer_lastname]",$mer_lastname,$body);
                     $body=str_replace("[mer_company]",$mer_company,$body);
                     $body=str_replace("[mer_email]",$mer_mail,$body);
                     $body=str_replace("[mer_loginlink]",$mer_loginlink,$body);
                     $body=str_replace("[mer_password]",$pwd,$body);
					 
					 $body=str_replace("[from]",$admin_email,$body);
                     $body=str_replace("[today]",$today,$body);

					 send_smtp_mail($to,$body,$subject,$from);
                //       mail($to,$subject,$body,$headers);
                 $mailok="Password Change Notification Mail Has been Send \n";
                 $mailok .= " To :".$to." \n";
                 $mailok.=" From :".$from;

                $Err="Your password has been sent to your email!";
                $ErrrType ="Success";
            }
    else
           {
            $Err="Invalid Email";
            $ErrType ="Error";
           }
       header("location:forgotpass.php?Err=$Err&ErrType=$ErrType&Action=$flag");
