<?php	

 include_once '../includes/db-connect.php';
	include_once '../includes/session.php';
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	$merid 		= intval($_GET['id']);
	$sql		= "SELECT * FROM partners_merchant WHERE merchant_id = '$merid'";
	$res		= mysqli_query($con,$sql);

 	while($row=mysqli_fetch_object($res)){
         $merchant_id			=	$row->merchant_id;
         $merchant_firstname	=	stripslashes($row->merchant_firstname);
         $merchant_lastname		=	stripslashes($row->merchant_lastname);
         $merchant_company		=	stripslashes($row->merchant_company);
         $merchant_address		=	stripslashes($row->merchant_address);
         $merchant_city			=	stripslashes($row->merchant_city);
         $merchant_country		=	stripslashes($row->merchant_country);
         $merchant_phone		=	stripslashes($row->merchant_phone);
         $merchant_url			=	stripslashes($row->merchant_url);
         $merchant_category		=	stripslashes($row->merchant_category);
         $merchant_status		=	stripslashes($row->merchant_status);
         $merchant_date			=	stripslashes($row->merchant_date);
         $merchant_fax			=	stripslashes($row->merchant_fax);
         $merchant_state		=	stripslashes($row->merchant_state);
         $merchant_zip			=	stripslashes($row->merchant_zip);
         $merchant_taxId		=	stripslashes($row->merchant_taxId);
         $merchant_type			=	stripslashes($row->merchant_type);
         $merchant_currency		=	stripslashes($row->merchant_currency);

         $emailQuery 	= " SELECT login_email FROM partners_login WHERE login_id = '$merchant_id' AND login_flag='m'";
         $emailResult	= mysqli_query($con,$emailQuery);

         if(mysqli_num_rows($emailResult)){
         	$emailRow 		 	= mysqli_fetch_object($emailResult);
            $merchant_email 	= $emailRow->login_email;
         }
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
<HEAD>
<TITLE>Affiliate Network Pro - Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<meta name="generator" content="Namo WebEditor v5.0(Trial)">
<link rel="stylesheet" type="text/css" href="admin.css">
</HEAD>
<body style="background-color:#FFFFFF; background-image:url(../images/white.jpg); background-repeat:repeat; ">
<script language="javascript" type="text/javascript">
	function button1_onclick() {
		window.close();
	}
</script>
<table border='0' cellpadding="0" cellspacing="0" width="90%" id="AutoNumber1" class="tablebdr" align="center" >
  <tr>
    <td colspan="4" class="tdhead heading-3" height="20" style="text-align:center">Merchant's Profile </td>
  </tr>
  <tr height="20">
    <td width="1%">&nbsp;</td>
    <td width="25%" >ID</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_id?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Email</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_email?></td>
  </tr>
   <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Type</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=ucwords($merchant_type)?></td>
  </tr>
   <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Currency</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_currency?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Company Name</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_company?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >First Name</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_firstname?></td>
  </tr>
  <tr>
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Last Name</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_lastname?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Address</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_address?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >City</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_city?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >State</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_state?></td>
  </tr>
   <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Zip</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_zip?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Country</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_country?> </td>
  </tr>
   <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Tax Id</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_taxId?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Phone</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_phone?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >URL</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_url?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Category</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_category?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Status</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_status?></td>
  </tr>
  <tr height="20">
    <td width="1%" >&nbsp;</td>
    <td width="25%" >Date of Join</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_date ?></td>
  </tr>
  <tr height="20">
    <td width="1%">&nbsp;</td>
    <td width="25%" >Fax</td>
    <td width="2%" ><b>:</b></td>
    <td width="65%" ><?=$merchant_fax?></td>
  </tr>
  <tr>
    <td height="20" colspan="4" align="center">
	<INPUT id=button1 type=button align=middle value=close name=button1 onclick="return button1_onclick()"></td>
  </tr>
</table>
</body>
</html>
