<?php

	include_once '../includes/db-connect.php';
	include_once '../includes/session.php';
	header("Cache-control: private"); 
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/function1.php';
	include '../includes/allstripslashes.php';
	
	$Act	= $_GET['Act'];
	
	//if(!empty(intval($_POST['languageid']))) 
	if(!empty($_POST['languageid'])) 
		$_SESSION['LANGUAGE'] = intval($_POST['languageid']);
	$language	= $_SESSION['LANGUAGE'];
	
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	
	if(!$partners->isMerchantlogin()){
		header("Location:../index.php?Act=merchant");
		exit;
	}

    $MERCHANTID = $mid 	= $_SESSION['MERCHANTID'] ;

    $sql_merchant	=	"select * from merchant_pay where pay_merchantid='$mid'  ";
    $ret_merchant	=	@mysqli_query($con,$sql_merchant);
    $row_merchant	=	@mysqli_fetch_object($ret_merchant);

    # get currency values
    $currSql 	= " SELECT * FROM partners_currency, partners_merchant 
					WHERE merchant_id = '$mid' and currency_caption = merchant_currency";
    $currRet 	= @mysqli_query($con,$currSql);

    if(@mysqli_num_rows($currRet)>0){
     	$currRow 	= @mysqli_fetch_object($currRet);
        $currSymbol = stripslashes($currRow->currency_symbol);
        $currValue 	= stripslashes($currRow->currency_caption);
		$currCode 	= stripslashes($currRow->currency_code);
    }
    $_SESSION['MERCHANTBALANCE'] = $row_merchant->pay_amount;

	# Added for base Currency
	$cur_sql 	= "SELECT * FROM partners_currency WHERE currency_code='$default_currency_code' ";
	$res_cur 	= mysqli_query($con,$cur_sql);
	if(mysqli_num_rows($res_cur) > 0){
		$row_cur = mysqli_fetch_object($res_cur);
		$basecurrSymbol = stripslashes($row_cur->currency_symbol);
		$_SESSION['DEFAULTCURRENCYSYMBOL'] = $basecurrSymbol;
	}

    $date 	= date("Y-m-d");

    if($currValue != $default_currency_caption) 
		$currBalance = getCurrencyValue($date, $currValue, $row_merchant->pay_amount);

    include 'language_include.php';
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AVAZ Affiliate Network</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css"/>

</head>
<body bgcolor="#ffffff">
	<table width="914"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
		<tr>
			<td valign="top" class="logo-bg" ><?php	include 'merchants_header.php';?></td>
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
		<tr>
			<td height="20" >
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
									$langsel = "";
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
			<td height="280" valign="top"><?php include "process.php";?> </td>
		</tr>
		<tr>
			<td align="center" class="footer-bg"><?php include "footer.php";?> </td>
		</tr>
	</table>
</body>
</html>