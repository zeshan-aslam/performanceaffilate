<?php

   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO CHANGE PASSWORD OF AFFILAITE AND MERCHANT
      VARIABLES          :  merid				=MERCHANT ID OR AFFILAITE ID
 							loginflag			= 'a' for affiliate and 'm' for merchant
                            tick				=whethr to send mail or not (check box)
  //*************************************************************************************************/

 include_once '../includes/db-connect.php';
 include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include_once '../includes/allstripslashes.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);

 /************************variables*******************************************/
 $merid				= intval($_REQUEST['id']);         //MERCHANT ID OR AFFILAITE ID
 $loginflag			= $_REQUEST['loginflag'];         // 'a' for affiliate and 'm' for merchant
 $tick				= "checked";                  //whethr to send mail or not
 /**************************************************************************/


	/*************************validation***********************************/
	if(isset($B1))
	{
		$err			= "";
		$mailid			= $_POST['mailid'];
		$pwd			= $t1;
		$conpass		= $t2;
		$cb				= $_POST['C1'];
		if ($cb=$_POST['C1']=="ON")
		{
			$tick		= "checked";
		}else{
			$tick		= "";
		}
        if($pwd=="" or $conpass=="")
        {
			#$merid			= $_POST['merid'];
			$loginflag		= $_POST['loginflag'];
			$ok				= "Please Dont leave any Field as Blank";
        }
        else if ($pwd!=$conpass) {
			#$merid			= $_POST['merid'];
			$loginflag		= $_POST['loginflag'];
			$ok				= "Password and Confirm Password Should Be Same";
        }
		else
		{
			#$merid			= $_POST['merid'];
			$loginflag		= $_POST['loginflag'];
			$updatesql		= "UPDATE partners_login SET login_password = '$pwd' WHERE login_id = '$merid' and login_flag='$loginflag' ";
			$res	= mysqli_query($con,$updatesql) or die("dasda");
			$ok				="Your Password has been Changed !!";
			$mailok			="Didn't send any mail now";

            ////////////// notification mail
               if ($cb=$_POST['C1']=="ON")  /// mail sending
               {

                    $sql="select * from partners_admin";
                    $ret1=mysqli_query($con,$sql);
                    $row=mysqli_fetch_object($ret1);  //common header and footer
                    $adminheader=stripslashes($row->admin_mailheader);
                    $adminfooter=stripslashes($row->admin_mailfooter);
					$admin_email	 =    stripslashes($row->admin_email);
					
					if($loginflag == 'a')
					{
						$sql_aff		="select * from partners_affiliate where affiliate_id='$merid'";
						$res_aff		=mysqli_query($con,$sql_aff);
						$row_aff		=mysqli_fetch_object($res_aff);
						$firstname        =stripslashes($row_aff->affiliate_firstname);
						$lastname         =stripslashes($row_aff->affiliate_lastname);
						$company          =stripslashes($row_aff->affiliate_company);
						$loginlink        =stripslashes($row_aff->affiliate_url);
	
						$sql_aff1		="select * from partners_login where login_id='$merid' and login_flag='a'";
						$res_aff1		=mysqli_query($con,$sql_aff1);
						$row_aff1		=mysqli_fetch_object($res_aff1);
						$password	=stripslashes($row_aff1->login_password);
						$affemail	=stripslashes($row_aff1->login_email);
						
	                    $sql="select * from partners_adminmail where adminmail_eventname='Change Affiliate Password' ";
					}
					else if($loginflag == 'm')
					{
						$sql_mer		="select * from partners_merchant where merchant_id='$merid'";
						$res_mer		=mysqli_query($con,$sql_mer);
						$row_mer		=mysqli_fetch_object($res_mer);
						$mer_firstname	=  stripslashes($row_mer->merchant_firstname);
						$mer_lastname	=  stripslashes($row_mer->merchant_lastname);
						$mer_company	=  stripslashes($row_mer->merchant_company);
						$mer_loginlink	=  stripslashes($row_mer->merchant_url);
						
						$sql_mer1="select * from partners_login where login_id='$merid' and login_flag='m'";
						$res_mer1=mysqli_query($con,$sql_mer1);
						$row_mer1=mysqli_fetch_object($res_mer1);
						$mer_mail		=  stripslashes($row_mer1->login_email);
						$mer_password	=  stripslashes($row_mer1->login_password);
						
						$sql="select * from partners_adminmail where adminmail_eventname='Change Merchant Password' ";
					}
                    $result=mysqli_query($con,$sql);

                   if(mysqli_num_rows($result)>0)
                   {

                      $row=mysqli_fetch_object($result);
                      $sub           =stripslashes($row->adminmail_subject);
                      $message       =stripslashes($row->adminmail_message);
                      $head          =stripslashes($row->adminmail_header);
                      $footer        =stripslashes($row->adminmail_footer);
                      $from          =stripslashes($row->adminmail_from);
                      //$toaddress  = $to;
                      $subject        = $sub;
                  }


                   // $message .= " password= ".$pwd;
                    $to=$mailid;
					$today         =date("Y-m-d");
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
                    $body.="<td width='100%' align='left'>Your New Password is $pwd";
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
                     $body=str_replace("[today]",$today,$body);

                 mail($to,$subject,$body,$headers);
                 $mailok="Password Change Notification Mail Has been Send \n";
                 $mailok .= " To :".$to." \n";
				 $sender = $from;
				  $sender = str_replace("[from]",$admin_email,$sender);
                 $mailok.=" From :".$sender;

            }

		}

    }
        ///////////// sub mitted form pross end



//echo "$loginflag,$merid";

$sql="select * from partners_login where login_id='$merid' and login_flag='$loginflag'";

$res=mysqli_query($con,$sql);  

while($row=mysqli_fetch_object($res))
{
         $lid=$row->login_email ;
        // echo "$lid";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Affiliate Network Pro - Admin Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="admin.css" />
</head>
<body style="background-color:#FFFFFF;" bgcolor="#FFFFFF" <?=$body_onload?>>


<!-- ImageReady Slices (admin.psd) -->
<table width="400" border='0' align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="69">

<?/* include "header.php"; */?>


<script language="javascript" type="text/javascript">

function button1_onclick() {
window.close();
}

</script>

	<form method="post" action="change_pass.php " id="f1">
	 <table border='0' cellpadding="0" cellspacing="0" width="385" id="tbl" class="tablebdr">
	    <tr>
	      <td colspan="3" height="19" class="tdhead">
	      <p align="center">Change Password</p> </td>
	    </tr>
	    <tr>
	      <td colspan="3" height="19" >
	      <p align="center" class="textred"><?=$ok?></p> </td>
	    </tr>

	    <tr>
	      <td width="2%" height="25">&nbsp;</td>
	      <td width="48%" height="25">Email ID </td>
	      <td width="50%" height="25"><?= $lid?></td>
	    </tr>
	    <tr>
	      <td width="2%" height="22">&nbsp;</td>
	      <td width="48%" height="22">Password</td>
	      <td width="50%" height="22"><input name="t1" id="t1" value="<?=$pwd?>" /></td>
	    </tr>
	    <tr>
	      <td width="2%" height="27">&nbsp;</td>
	      <td width="48%" height="27">Confirm Password</td>
	      <td width="50%" height="27" align="left"><input name="t2" id="t2" value="<?=$conpass?>" /></td>
	    </tr>
	    <tr>
	      <td colspan="3" height="29">
	      <p align="center"><input type="checkbox" name="C1" value="ON" id="chk1" <?="checked=\"".$tick."\""?> /> Send a Notification Mail  with new Password</p>
	      </td>
	    </tr>
	    <tr>
	      <td  colspan="2" height="23" class="tdhead">
	      <p align="center">
	      <input type="submit" value="Change " name ="B1" /></p></td>
	    <td class="tdhead" height="23">
	      <p align="center"><input id="button1" type="button" value="close" name="button1" onclick="return button1_onclick()"/></p></td>
	    </tr>
        <?if(!empty($mailok)){?>
	    <tr>
	      <td  colspan="3" height="19" >
	      <p align="center" class="textred"><?=$mailok?></p> </td>
	    </tr>
        <? }?>
	  </table>

	  <p> <input type="hidden" name="merid" value='<?=$merid?>' />
	  <input type="hidden" name="loginflag" value='<?=$loginflag?>' />
	  <input type="hidden" name="mailid" value='<?= $lid?>' />
	  </p>
	</form>
</td></tr>
</table>

</body>

</html>