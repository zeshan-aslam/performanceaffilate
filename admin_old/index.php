<?php	

	include_once '../includes/db-connect.php';
	include '../includes/session.php';
	header("Cache-control: private"); 
	include '../includes/constants.php';
	include '../includes/functions.php';
	include '../includes/allstripslashes.php';
	include '../lang/admin_english.php';
	include '../includes/function1.php';
	
	$Act		= $_GET['Act'];
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
 
	# For Admin Users
	$userobj 		= new adminuser();
	$adminUserId 	= $_SESSION['ADMINUSERID'];
	
	# Added for base Currency
	$currency_code  = $default_currency_code;
	$cur_sql 		= " SELECT * FROM partners_currency WHERE currency_code = '$currency_code' ";
	$res_cur 		= mysqli_query($con, $cur_sql);
	if(mysqli_num_rows($res_cur) > 0){
		$row_cur 	= mysqli_fetch_object($res_cur);
		$currSymbol = stripslashes($row_cur->currency_symbol);
		$_SESSION['DEFAULTCURRENCYSYMBOL'] = $currSymbol;
		$currValue 	= stripslashes($row_cur->currency_caption);
		$currCode 	= stripslashes($row_cur->currency_code);
	}

	$body_onload 	= "";
	if($Act=="link_report") {
		if($userobj->GetAdminUserLink('Link',$adminUserId,5)) {  
			$body_onload = "onload='LoadPrgms();'";
		}
	}
	if($Act=="referer_report") {
		if($userobj->GetAdminUserLink('Referer',$adminUserId,5)) {  
			$body_onload = "onload='LoadPrgms();'";
		}
	}
	if($Act=="product_report") {
		if($userobj->GetAdminUserLink('Products',$adminUserId,5)) {  
			$body_onload = "onload='LoadPrgms();'";
		}
	}

	if($Act=="crm") 
		$body_onload = "onload='loadCat();'";
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AVAZ Affiliate Network - Admin Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="admin.css" />
</head>

<body <?=$body_onload?>>
<table width="914" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:#d4d4d4 thin solid;">
  <tr>
    <td valign="top" class="logo-bg"><?php include"header.php";?></td>
  </tr>
   <tr>
    <td align="right">
	<?php
			if(!$partners->islogin()){
				include "admin_login.php";
				exit;
			}
			
			# Added for admin session update
			$ip		= $_SERVER['REMOTE_ADDR'];
			if($_SESSION['ADMINUSERID'] == '1'){
				$sql 	= " UPDATE partners_admin SET admin_ip = '$ip',";
				$sql   .= " admin_lastLogin = now()";
				mysqli_query ($con, $sql);
			}  
			$sql 	= " UPDATE partners_adminusers SET adminusers_ip = '$ip',";
			$sql   .= " adminusers_lastLogin = now() WHERE adminusers_id='".$_SESSION['ADMINUSERID']."' ";
			mysqli_query ($con, $sql);
			
			/*include "links.php";*/
			?>
	
	 </td>
  </tr>
  <tr>
    <td><table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" width="4"><img src="images/topbar-left.jpg" width="4" height="22" /></td>
    <td class="top-bar-tile">&nbsp;</td>
    <td align="left" width="4"><img src="images/topbar-right.jpg" width="4" height="22" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="center" height="5"></td>
  </tr>

  <tr>
    <td align="center" height="315" valign="top" width="100%" ><?php
		if($Act!="merchants" and  $Act!="affiliates"){
			include "heap_remove.php";
		}
		include "process.php";
		?>
	</td>
  </tr>	 
  <tr>
    <td align="center" class="footer-bg"><?php include "footer.php"; ?></td>
  </tr>
</table>
</body>
</html>
