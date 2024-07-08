<?php	
  
  include_once '../includes/db-connect.php';
	include '../includes/session.php';
	include '../includes/constants.php';
	include '../includes/functions.php';
	
	if(!empty($_POST['languageid'])) $_SESSION['LANGUAGE'] = $_POST['languageid'];
	$language=$_SESSION['LANGUAGE'];
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	include 'language_include.php';    
	
	$affid		= intval($_GET['id']);
	$sql        = "select * from partners_affiliate where affiliate_id='$affid'";
	$res        = mysqli_query($con,$sql);
	while($row=mysqli_fetch_object($res)){
		$affiliate_id                                =$row->affiliate_id;
		$affiliate_firstname              			  =stripslashes($row->affiliate_firstname);
		$affiliate_lastname               			  =stripslashes($row->affiliate_lastname);
		$affiliate_company                           =stripslashes($row->affiliate_company);
		$affiliate_address                           =stripslashes($row->affiliate_address);
		$affiliate_city                              =stripslashes($row->affiliate_city);
		$affiliate_country                           =stripslashes($row->affiliate_country);
		$affiliate_phone                             =stripslashes($row->affiliate_phone);
		$affiliate_url                               =stripslashes(trim($row->affiliate_url));
		$affiliate_category                		  =stripslashes($row->affiliate_category);
		$affiliate_status                        	  =stripslashes($row->affiliate_status);
		$affiliate_date                              =stripslashes($row->affiliate_date);
		$affiliate_fax                               =stripslashes($row->affiliate_fax);
	}

	include '../lang/english.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$vproaff_head?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="main.css"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
<script  language="javascript" type="text/javascript">
function button1_onclick() {
window.close();
}
</script>
</head>
<body bgcolor="#ffffff"  style="background-color:#FFFFFF; ">
<table border="0"  class="tablebdr" cellpadding="0" cellspacing="0"  width="100%">
  <tr>
    <td width="100%" align="center" colspan="5" class="tdhead" height="19"><?=$vproaff_prof?>
     </td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$common_id?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_id?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_company?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_company?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_fname?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_firstname?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19" align="left"><?=$vproaff_lname?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_lastname?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_addr?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_address?>
    </td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="17"></td>
    <td width="38%" height="17"><?=$vproaff_city?></td>
    <td width="1%" height="17"><b>:</b></td>
    <td width="60%" height="17"><?=$affiliate_city?></td>
    <td width="1%" height="17"></td>
  </tr>
  <tr>
    <td width="2%" height="17"></td>
    <td width="38%" height="17"><?=$vproaff_contry?></td>
    <td width="1%" height="17"><b>:</b></td>
    <td width="60%" height="17"><?=$affiliate_country?> </td>
    <td width="1%" height="17"></td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_phone?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_phone?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_url?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_url?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_category?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_category?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="19">&nbsp;</td>
    <td width="38%" height="19"><?=$vproaff_status?></td>
    <td width="1%" height="19"><b>:</b></td>
    <td width="60%" height="19"><?=$affiliate_status?></td>
    <td width="1%" height="19">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%" height="11"></td>
    <td width="38%" height="11"><?=$vproaff_jdate?></td>
    <td width="1%" height="11"><b>:</b></td>
    <td width="60%" height="11"><?=$affiliate_date ?></td>
    <td width="1%" height="11"></td>
  </tr>
  <tr>
    <td width="2%" height="15"></td>
    <td width="38%" height="15"><?=$vproaff_fax?></td>
    <td width="1%" height="15"><b>:</b></td>
    <td width="60%" height="15"><?=$affiliate_fax?></td>
    <td width="1%" height="15"></td>
  </tr>
	<tr>
    <td width="100%" height="10" colspan="5" class="tdhead" align="center">
	<input class="textred" type="button" align="middle" value="<?=$common_close?>"   onclick="return button1_onclick()" /></td>
  </tr>
</table>

 </body>
 </html>