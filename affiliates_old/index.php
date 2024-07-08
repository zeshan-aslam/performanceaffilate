<?php		
	
	include_once '../includes/db-connect.php';
	include_once '../includes/session.php';
	header("Cache-control: private"); 
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	
	$Act	= $_GET['Act'];
	if(!empty($_POST['languageid'])) 
		$_SESSION['LANGUAGE'] 	= $_POST['languageid'];
	
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	if(!$partners->isAffiliatelogin()){
		header("Location:../index.php?Act=affiliate");
		exit;
	}
	$AFFILIATEID 	= $aid	= $_SESSION['AFFILIATEID'] ;
	
	$sql_affiliate	= "SELECT * FROM affiliate_pay WHERE pay_affiliateid = '$aid'  ";
	$ret_affiliate	= mysqli_query($con,$sql_affiliate);
	$row_affiliate	= mysqli_fetch_object($ret_affiliate);
	$_SESSION['AFFILIATEBALANCE']=$row_affiliate->pay_amount;

    # get currency values
	$currency_code	= $default_currency_code;
	$cur_sql 		= " SELECT * FROM partners_currency WHERE currency_code = '$currency_code' ";
	$res_cur = mysqli_query($con,$cur_sql);
	if(mysqli_num_rows($res_cur) > 0){
		$row_cur 	= mysqli_fetch_object($res_cur);
		$currSymbol = stripslashes($row_cur->currency_symbol);
		$_SESSION['DEFAULTCURRENCYSYMBOL'] = $currSymbol;
		$currValue 	= stripslashes($row_cur->currency_caption);
		$currCode 	= stripslashes($row_cur->currency_code);
	}
	
	$date	 		= date("Y-m-d");  
	$currBalance 	= $row_affiliate->pay_amount;   
	include 'language_include.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Avaz Affiliate Network</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body bgcolor="#ffffff">
	<a id="displayBox" ></a>
	<table width="914" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
		<tr>
			<td valign="top" class="logo-bg"><?php	include 'affiliates_header.php';?></td>
		</tr>
		<tr>
			<td>
			<table width="97%" align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="right" width="4"><img src="images/topbar-left.jpg" width="4" height="22" /></td>
					<td class="top-bar-tile">&nbsp;</td>
					<td align="left" width="4"><img src="images/topbar-right.jpg" width="4" height="22" /></td>
				</tr>
			</table>
		</td>
		</tr>
		<tr><td height="20" >
			<table width="97%" valign="middle" align="center" border="0" cellspacing="10" cellpadding="0">
				<tr>
					<td align="right">
						<?
						# get all languages
						$sqllang = "select * from partners_languages where languages_status = 'active'";
						$reslang = mysqli_query($con,$sqllang);
						if(mysqli_num_rows($reslang)>0){
							?>
							<b>Language :</b> 
							<select name="languageid" onchange="javascript:langform.submit();">
							<?
							while($rowlang = mysqli_fetch_object($reslang)){
								$langsel 	= "";
								if($language==$rowlang->languages_id) 
									$langsel = "selected";
							?>
									<option value="<?=$rowlang->languages_id?>" <?=$langsel?>>
										<?=stripslashes($rowlang->languages_name)?>
									</option>
								<?
								}
								?>
							</select>
						<?
						}
						?>
					</td>
				</tr>
			</table>
		</td>
		</tr>
		<tr>
			<td align="center" height="280" valign="top"> <?php include "process.php"; ?> </td>
		</tr>
		<tr>
			<td align="center" class="footer-bg"> <?php include "footer.php";?> </td>
		</tr>
	</table>
</body>
</html>