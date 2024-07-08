<?php
 
  include_once '../includes/db-connect.php';
	include_once '../includes/session.php';
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	$affid		= intval($_GET['id']);
	$sql		= "select * from partners_affiliate where affiliate_id='$affid'";
	$res		= mysqli_query($con,$sql);

	while($row=mysqli_fetch_object($res)){
		 $affiliate_id			=	$row->	affiliate_id;
		 $affiliate_firstname	=	stripslashes($row->affiliate_firstname);
		 $affiliate_lastname	=	stripslashes($row->affiliate_lastname);
		 $affiliate_company		=	stripslashes($row->affiliate_company);
		 $affiliate_address		=	stripslashes($row->affiliate_address);
		 $affiliate_city		=	stripslashes($row->affiliate_city);
		 $affiliate_country		=	stripslashes($row->affiliate_country);
		 $affiliate_phone		=	stripslashes($row->affiliate_phone);
		 $affiliate_url			=	stripslashes($row->affiliate_url);
		 $affiliate_category	=	stripslashes($row->affiliate_category);
		 $affiliate_status		=	stripslashes($row->affiliate_status);
		 $affiliate_date		=	stripslashes($row->affiliate_date);
		 $affiliate_fax			=	stripslashes($row->affiliate_fax);
		 $affiliate_state		=	stripslashes($row->affiliate_state);
		 $affiliate_zip			=	stripslashes($row->affiliate_zipcode);
		 $affiliate_taxId		=	stripslashes($row->affiliate_taxId);
		 $affiliate_timezone  	=	stripslashes($row->affiliate_timezone);
		 $affiliate_timezone    =   $timeZoneArray[$affiliate_timezone + 12];
	
		 $emailQuery 	= " SELECT login_email FROM partners_login WHERE login_id = '$affiliate_id' AND login_flag='a'";
		 $emailResult	= mysqli_query($con,$emailQuery);
	
		 if(mysqli_num_rows($emailResult)){
			$emailRow 		 = mysqli_fetch_object($emailResult);
			$affiliate_email = $emailRow->login_email;
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
<SCRIPT type="text/javascript" LANGUAGE="javascript">
	function button1_onclick() {
		window.close();
	}
</SCRIPT>
<body style="background-color:#FFFFFF; background-image:url(../images/white.jpg); background-repeat:repeat; ">

<table border='0' cellpadding="0" cellspacing="0" width="90%" id="AutoNumber1" class="tablebdr" align="center" >
  <tr height="20">
    <td width="100%" colspan="5" class="tdhead heading-3" style="text-align:center" > Affiliate's Profile </td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >ID</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_id?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Email</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_email?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Company Name</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_company?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >First Name</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_firstname?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >
    Last Name</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_lastname?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Address</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_address?>
    </td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >City</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_city?></td>
    <td width="1%" ></td>
  </tr>
 <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >State</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_state?></td>
    <td width="1%" ></td>
  </tr>
   <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Zip</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_zip?></td>
    <td width="1%" ></td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Country</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_country?> </td>
    <td width="1%" ></td>
  </tr>
   <tr height="20">
    <td width="2%" ></td>
    <td width="38%" >Tax Id</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_taxId?></td>
    <td width="1%" ></td>
  </tr>
   <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Time Zone</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_timezone?></td>
    <td width="1%" ></td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Phone</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_phone?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >URL</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_url?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Category</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_category?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Status</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_status?></td>
    <td width="1%" >&nbsp;</td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Date of Join</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_date ?></td>
    <td width="1%" ></td>
  </tr>
  <tr height="20">
    <td width="2%" >&nbsp;</td>
    <td width="38%" >Fax</td>
    <td width="1%" ><b>:</b></td>
    <td width="60%" ><?=$affiliate_fax?></td>
    <td width="1%" ></td>
  </tr>
  <tr >
    <td width="100%" height="10" colspan="5">&nbsp;</td>
  </tr>  
  <tr >
    <td width="100%" height="10" colspan="5" align="center">
	<INPUT id=button1 type=button align=middle value=close name=button1 onclick="return button1_onclick()"></td>
  </tr>
</table>

</body>
</html>
