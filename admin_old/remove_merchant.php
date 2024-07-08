<?php	

  include_once '../includes/db-connect.php';

	include '../includes/session.php';
	include '../includes/constants.php';
	include '../includes/functions.php';
	include_once '../includes/allstripslashes.php';
	
	include '../mail.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$merid		= intval($_GET['id']);
	$actionflag	= $_GET['mode'];
	//echo "$actionflag";
	$sql		= "select * from partners_merchant where merchant_id = '$merid'";
	$res		= mysqli_query($con, $sql);

/// check is submitted to remove;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Affiliate Network Pro - Admin Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="admin.css" />
</head>
<body style="background-color:#FFFFFF; "  <?=$body_onload?> >
<!-- ImageReady Slices (admin.psd) -->
<table width="600" border='0' align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="69" bgcolor="#FFFFFF">
<script language="javascript" type="text/javascript">



function button1_onclick() {
window.opener.location = 'index.php?Act=merchants&status=all';
window.close();
}

</script>
<?

if($rbtn=="Remove" || $rbtn=="Reject")
        {
                  $sql="select * from partners_login where login_id='$toremove' and login_flag='m'";
                  $ret1=mysqli_query($con, $sql);
                  $row=mysqli_fetch_object($ret1);
                  $to=$row->login_email;   

                 //$sql="delete from partners_merchant where merchant_id='$toremove'";
                 //mysqli_query($con,$sql) or die('cant exe');
        ?>
                <div align="center">
             <P>&nbsp;&nbsp;</p>
            <P>&nbsp;&nbsp;</p>

            <big><? if($rbtn=="Remove")
            {
            $sql="SELECT  * FROM partners_merchant a, partners_joinpgm c, partners_transaction d" ;
            $sql =$sql." WHERE merchant_id ='$toremove' and d.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_merchantid = a.merchant_id";
            $result=mysqli_query($con,$sql);
            if(mysqli_num_rows($result))
                echo "Can't Remove This Merchant";
            else
               {
					MailEvent("Remove Merchant",0,0,$to,0 )  ;
					//SendMerMail("Remove Merchant",$to);
					/**/
                	$sql="delete from partners_merchant where merchant_id='$toremove'";
                     mysqli_query($con,$sql) or die('cant exe');
                	$sql="delete from partners_login where login_id='$toremove' and login_flag='m'";
                     mysqli_query($con,$sql) or die('cant exe');
                	
					$sql_pay = "DELETE FROM merchant_pay WHERE pay_merchantid='$toremove' ";
					@mysqli_query($con,$sql_pay) or die('cant exe');
					
					$sql_adj = "DELETE FROM partners_adjustment WHERE adjust_memberid='$toremove' AND adjust_flag='m' ";
					@mysqli_query($con,$sql_adj) or die('cant exe');
					
					$sql_fee = "DELETE FROM partners_fee WHERE adjust_memberid='$toremove' ";
					@mysqli_query($con,$sql_fee) or die('cant exe');
					
               		 echo "Merchant Removed From This Site !!!";
              }
            }
            else
            {
				MailEvent("Remove Merchant",0,0,$to,0 )  ;
				//MailEvent("Reject Merchant",0,0,$to,0 )  ;
				//SendMerMail("Remove Merchant",$to);
				 
				$sql="delete from partners_merchant where merchant_id='$toremove'";
				mysqli_query($con,$sql) or die('cant exe');
	
				$sql_log="delete from partners_login where login_id='$toremove' and login_flag='m'";
				mysqli_query($con,$sql_log) or die('cant exe');
				
				$sql_pay = "DELETE FROM merchant_pay WHERE pay_merchantid='$toremove' ";
				@mysqli_query($con,$sql_pay) or die('cant exe');
				
				$sql_adj = "DELETE FROM partners_adjustment WHERE adjust_memberid='$toremove' AND adjust_flag='m' ";
				@mysqli_query($con,$sql_adj) or die('cant exe');
				
				$sql_fee = "DELETE FROM partners_fee WHERE adjust_memberid='$toremove' ";
				@mysqli_query($con,$sql_fee) or die('cant exe');
				 
				echo "Merchant Rejected From This Site !!!";
            }
            ?></big><br/>


		<P>&nbsp;&nbsp;</p>
		<input id="button1" type="button" align="center" value="CLOSE" name="button1" onclick="return button1_onclick()" />
		</div>
		<?
		exit;
}

	while($row=mysqli_fetch_object($res)){
		$merchant_id		= $row->merchant_id;
		$merchant_firstname	= $row->merchant_firstname;
		$merchant_lastname	= $row->merchant_lastname;
		$merchant_company	= $row->merchant_company;
		$merchant_address	= $row->merchant_address;
		$merchant_city		= $row->merchant_city;
		$merchant_country	= $row->merchant_country;
		$merchant_phone		= $row->merchant_phone;
		$merchant_url		= $row->merchant_url;
		$merchant_category	= $row->merchant_category;
		$merchant_status	= $row->merchant_status;
		$merchant_date		= $row->merchant_date;
		$merchant_fax		=$row->merchant_fax;
	}
?>


<table border='0' class="tablebdr" cellpadding="0" cellspacing="5" width="100%" id="AutoNumber1">
  <tr>
    <td colspan="5" height="19">
    <p align="center" class="textred">Do You Really Want To <?=$actionflag?> This Merchant ?</p></td>
  </tr>
  <tr>
  	<td align="center" colspan="5" >
    	<form name="FormName" action="remove_merchant.php" method="post">
        <table border='0'  cellpadding="0" cellspacing="0" width="100%">
           <tr>
            <td width="100%" height="10" colspan="5" class="tdhead" align="center">
	            <input type="submit" name="rbtn" value="<?=$actionflag?>"/>
	            <input name="toremove" type="hidden" value="<?=$merid?>" />
	            <input id="button1"  type="button" value="Close" name="button1" onclick="return button1_onclick()"/>
	        </td>
           </tr>
        </table>
        </form>
    </td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">ID</td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$merchant_id?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Company Name</td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$merchant_company?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">First Name</td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$merchant_firstname?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">
    <p align="left">Last Name</p></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$merchant_lastname?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Address</td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19">
    <p>
      <textarea rows="2" name="add" cols="20"><?=$merchant_address?></textarea></p>
    </td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="17"></td>
    <td width="38%" height="17">&nbsp;City</td>
    <td width="1%" height="17"><b>:</b></td>
    <td width="60%" height="17"><?=$merchant_city?></td>
    <td width="1%" height="17"></td>
  </tr>
  <tr>
    <td width="2%" height="17"></td>
    <td width="38%" height="17">Country</td>
    <td width="1%" height="17"><b>:</b></td>
    <td width="60%" height="17"><?=$merchant_country?> </td>
    <td width="1%" height="17"></td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Phone</td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$merchant_phone?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">URL</td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$merchant_url?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Category</td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$merchant_category?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Status</td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$merchant_status?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="11"></td>
    <td width="38%" height="11">Date of Joining</td>
    <td width="1%" height="11"><b>:</b></td>
    <td width="60%" height="11"><?=$merchant_date ?></td>
    <td width="1%" height="11"></td>
  </tr>
  <tr>
    <td width="2%" height="15"></td>
    <td width="38%" height="15">Fax</td>
    <td width="1%" height="15"><b>:</b></td>
    <td width="60%" height="15"><?=$merchant_fax?></td>
    <td width="1%" height="15"></td>
  </tr>
</table>
</td></tr>
          <tr>
            <td height="20" class="tdhead" ><div align="center">Copyright 2004 &copy; AlstraSoft Affiliate Network Pro. All Rights Reserved.</div></td>
          </tr>
</table>

</body>

</html>

<?php
	function SendMerMail($event,$to)
	{   
           $sql="select * from partners_adminmail where adminmail_eventname='$event' "; 
           $result             =mysqli_query($con,$sql);
           $row                =mysqli_fetch_object($result);
           $sub                =stripslashes($row->adminmail_subject);
           $message            =stripslashes($row->adminmail_message);
           $head               =stripslashes($row->adminmail_header);
           $footer             =stripslashes($row->adminmail_footer);
           $from               =stripslashes($row->adminmail_from);
           $toaddress          =stripslashes($to);
           $subject            =stripslashes($sub);  //die("to = ".$toaddress."<br/>sql = ".$sql);

                     $headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
                    $headers       .=  "From: $from\n";
                    $body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
                    $body.="<tr>";
                    $body.="<td width='100%' align='center' valign='top'><br>";
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
                mail($toaddress,$subject,$body,$headers);

           }

 

	
?>