<?php	
  
  include_once '../includes/db-connect.php';
  include '../includes/session.php';
 	include '../includes/constants.php';
 	include '../includes/functions.php';
  include_once '../includes/allstripslashes.php';

 	include "../mail.php";

	//include"header.php";
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$affid		= intval($_GET['id']);
	$actionflag	= $_GET['mode'];
	
	$sql	= "select * from partners_affiliate where affiliate_id='$affid'";
	$res	= mysqli_query($con,$sql);

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
<body style="background-color:#FFFFFF; "  <?=$body_onload?>>
<!-- ImageReady Slices (admin.psd) -->
<table width="600" border='0' align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="69" bgcolor="#FFFFFF">
	<SCRIPT LANGUAGE="javascript" type="text/javascript">
		function button1_onclick() {
			window.opener.location = 'index.php?Act=affiliates&status=all';
			window.close();
		}
	</SCRIPT>
<?

if($rbtn=="Remove" || $rbtn=="Reject")
        {
                $sql="select * from partners_login where login_id='$toremove' and login_flag='a'";
                $ret1=mysqli_query($con,$sql);
                $row=mysqli_fetch_object($ret1);
                $to=$row->login_email;
                 //$sql="delete from partners_affiliate where affiliate_id='$toremove'";
                 //mysqli_query($con,$sql) or die('cant exe');
        ?>
                <div align="center">
             <P>&nbsp;&nbsp;</p>
            <P>&nbsp;&nbsp;</p>

                <big><? if($rbtn=="Remove")
            {
				$sql="SELECT  * FROM partners_affiliate a, partners_joinpgm c, partners_transaction d" ;
				$sql =$sql." WHERE affiliate_id = '$toremove' and d.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_affiliateid = a.affiliate_id";
				$result=mysqli_query($con,$sql);
			   // echo "$sql";
				if(mysqli_num_rows($result))
					echo "Can't Remove This Affiliate";
				else
				{
					$sql="delete from partners_affiliate where affiliate_id='$toremove'";
						 mysqli_query($con,$sql) or die('cant exe');
					$sql="delete from partners_login where login_id='$toremove' and login_flag='a'";
						 mysqli_query($con,$sql) or die('cant exe');
					 MailEvent("Remove Affiliate",0,0,$to,0 )  ;
					echo "Affiliate Removed From This Site !!!";
				}
			}
            else
            {
				$sql="delete from partners_affiliate where affiliate_id='$toremove'";
					 mysqli_query($con,$sql) or die('cant exe');
				$sql="delete from partners_login where login_id='$toremove' and login_flag='a'";
					 mysqli_query($con,$sql) or die('cant exe');
				 MailEvent("Reject Affiliate",0,0,$to,0 )  ;
				echo "Affiliate Rejected From This Site !!!";
            }
            ?></big><br/>


            <P>&nbsp;&nbsp;</p>
                         <INPUT id=button1  type=button value=CLOSE name=button1 LANGUAGE=javascript onclick="return button1_onclick()">
                    </div>
        <?
       exit;
}

 while($row=mysqli_fetch_object($res)){
         $affiliate_id=$row->        affiliate_id;
         $affiliate_firstname=$row->affiliate_firstname;
         $affiliate_lastname=$row->affiliate_lastname;
         $affiliate_company=$row->affiliate_company;
         $affiliate_address=$row->affiliate_address;
         $affiliate_city=$row->affiliate_city;
         $affiliate_country=$row->affiliate_country;
         $affiliate_phone=$row->affiliate_phone;
         $affiliate_url=$row->affiliate_url;
         $affiliate_category=$row->affiliate_category;
         $affiliate_status=$row->affiliate_status;
         $affiliate_date=$row->affiliate_date;
         $affiliate_fax=$row->affiliate_fax;

                }

?>

<div align="center">

<table border='0' class="tablehdbdr" cellpadding="0" cellspacing="0"  width="100%" id="AutoNumber1">
  <tr>
    <td width="100%" colspan="5" height="19">
    <p align="center" class="textred">Do You Realy Want To <?=$actionflag?> This affiliate ?</td>
  </tr>
  <tr>
    <td width="100%" height="10" colspan="5" class="tdhead" align="center">
    <form name="FormName" action="remove_affiliate.php" method="post">
	    <INPUT type=submit name="rbtn" align=middle value="<?=$actionflag?>">
    	<input name="toremove" type="hidden" value="<?=$affid?>" >
    	<INPUT id="button1"  type=button value="Close" name="button1" onclick="return button1_onclick()">
    </form>
    </td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">ID</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=$affiliate_id?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Company Name</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=$affiliate_company?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">First Name</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=$affiliate_firstname?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Last Name</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=$affiliate_lastname?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Address</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=nl2br($affiliate_address)?>
    </td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="17"></td>
    <td width="38%" height="17">&nbsp;City</td>
    <td width="1%" height="17" align="left"><b>:</b></td>
    <td width="60%" height="17" align="left"><?=$affiliate_city?></td>
    <td width="1%" height="17"></td>
  </tr>
  <tr>
    <td width="2%" height="17"></td>
    <td width="38%" height="17">Country</td>
    <td width="1%" height="17" align="left"><b>:</b></td>
    <td width="60%" height="17" align="left"><?=$affiliate_country?> </td>
    <td width="1%" height="17"></td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Phone</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=$affiliate_phone?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">URL</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=$affiliate_url?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Category</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=$affiliate_category?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19">Status</td>
    <td width="1%" height="19" align="left"><b>:</b></td>
    <td width="60%" height="19" align="left"><?=$affiliate_status?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="11"></td>
    <td width="38%" height="11">Date of Joining</td>
    <td width="1%" height="11" align="left"><b>:</b></td>
    <td width="60%" height="11" align="left"><?=$affiliate_date ?></td>
    <td width="1%" height="11"></td>
  </tr>
  <tr>
    <td width="2%" height="15"></td>
    <td width="38%" height="15">Fax</td>
    <td width="1%" height="15" align="left"><b>:</b></td>
    <td width="60%" height="15" align="left"><?=$affiliate_fax?></td>
    <td width="1%" height="15"></td>
</table></div>
          <tr>
            <td height="20" class="tdhead" ><div align="center">Copyright 2004 &copy; AlstraSoft Affiliate Network Pro. All Rights Reserved.</div></td>
          </tr>
        </table>
</BODY>
</HTML>

 <? /* include 'footer.php'; */?>