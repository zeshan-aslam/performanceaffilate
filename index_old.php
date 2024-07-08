<?php 

	include_once 'includes/db-connect.php';
	include_once 'includes/session.php';
	header("Cache-control: private"); 
	include_once 'includes/constants.php';
	include_once 'includes/functions.php';
	include_once 'includes/allstripslashes.php';

	
	$partners	= new partners;
	
	$Act = isset($_GET['Act']) ? $_GET['Act'] : "";
	if(!empty($_POST['languageid'])) $_SESSION['LANGUAGE'] = intval($_POST['languageid']);

	# For language
    $language	= $_SESSION['LANGUAGE'];
    if (empty($language)) 
		$lang 	= "english";
	else{
        # Get langauge
		$sqllang 	= " SELECT * FROM partners_languages WHERE languages_id = '$language'"; 
		$reslang 	= mysqli_query($con,$sqllang);
		if($rowlang = mysql_fetch_object($reslang)) 
			$lang 	= strtolower(trim(stripslashes($rowlang->languages_name)));
		
		# langauge file name
		$filename 	= "lang/".$lang.".php";
		
		# check whether file exists
		if(!file_exists($filename)){
			$lang 	= "english";
			$language = "";
		}
	}
	require ("lang/".$lang.".php");

	# Getting Default currency Details
	$currency_code  = $default_currency_code;
	$cur_sql 		= " SELECT * FROM partners_currency WHERE currency_code = '$currency_code' ";
	$res_cur 		= mysqli_query($con, $cur_sql);

	if(mysqli_num_rows($res_cur) > 0){
		$row_cur = mysqli_fetch_object($res_cur);
		$currSymbol = stripslashes($row_cur->currency_symbol);
		$_SESSION['DEFAULTCURRENCYSYMBOL'] = $currSymbol;
		$currValue 	= stripslashes($row_cur->currency_caption);
		$currCode 	= stripslashes($row_cur->currency_code);
	}
	
	# daily procedures

	include_once 'dailyroutine.php';
	ChangeStaus($minimum_amount);
	getProgramFee();
	setPending();
	payMembership();
	setMemPending();
 
	# Remove this when cron job is set for this file
	# include_once "cron/dailyjobs_anp.php";
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title><?=$site_title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="main.css" /><!---->
	<link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
	<a id="displayBox" ></a>

<table width="970" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="table-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td><?php include "header.php";?></td>
      </tr>
	  
      <tr>
        <td><table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
         
          <tr>
            <td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2">&nbsp;</td>
                </tr>
              <tr>
                <td width="237" valign="top">
				<?php 
				if($Act=='login'){
					include "features.php";
				} 
				else{
					include "login.php";
				}
				?>				</td>
                <td width="713" valign="top">
				
				<?php include "process.php";?>				</td>
              </tr>
	  <tr>
	    <td colspan="2">&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="2" valign="top" class="footer-bg"><?php include "footer.php"; ?>
	
		</td>
	    </tr>
            </table></td>
          </tr>
		  
        </table></td>
      </tr>
	  <tr>
	    <td>&nbsp;</td>
	    </tr>
    </table></td>
  </tr>
  <tr>
    <td height="5" bgcolor="#ADC7E1"></td>
  </tr>
</table>	
	
	
	</body>
	</html>