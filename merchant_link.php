<?php		
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  merchant_link.php  		            	    */
/*     CREATED ON     :  25/JULY/2006                                   */

/*	Display the Affiliate Registration page with the merchant header & footer */
/************************************************************************/

	include_once 'includes/db-connect.php';
   include_once 'includes/session.php';
    header("Cache-control: private"); 
   include_once 'includes/constants.php';
   include_once 'includes/functions.php';
   include_once 'includes/allstripslashes.php';
   include_once 'includes/function1.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

  $Act        = $_GET['Act'];
  if(!empty($_POST['languageid'])) $_SESSION['LANGUAGE'] = intval($_POST['languageid']);

// include 'language_include.php';

// For language*****************************************************

    $language=$_SESSION['LANGUAGE'];
    if (empty($language)) $lang = "english";
	else
	{
        //get langauge
		$sqllang = "select * from partners_languages where languages_id = '$language'"; 
		$reslang = mysqli_query($con,$sqllang);
		if($rowlang = mysqli_fetch_object($reslang)) $lang = strtolower(trim(stripslashes($rowlang->languages_name)));

		//langauge file name
	   	$filename = "lang/".$lang.".php";

		//check whether file exists
		if(!file_exists($filename))
		{
			$lang = "english";
			$language = "";
		}
	}
	require ("lang/".$lang.".php");


// LANGUAGE CLOSE

 # daily procedures

 include_once 'dailyroutine.php';
 ChangeStaus($minimum_amount);
 getProgramFee();
 setPending();
 payMembership();
 setMemPending();
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$site_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="main.css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--

.nowrap {
	white-space: nowrap;
}
.lftnav {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-top-color: #8D8D8D;
	border-right-color: #8D8D8D;
	border-bottom-color: #8D8D8D;
	border-left-color: #8D8D8D;
}
.outtbl {
	border-right-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-right-color: #8D8D8D;
	border-left-color: #8D8D8D;
	border-left-style: solid;
	border-top-style: none;
	border-bottom-style: none;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.navbg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
	text-decoration: none;
	background-repeat: no-repeat;
	background-image: url(images/navbg_03.jpg);
}
.headbg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
	text-decoration: none;
	background-repeat: repeat-x;
	background-image: url(images/head_bg.jpg);
	white-space: nowrap;
}
.headimg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
	text-decoration: none;
	background-repeat: no-repeat;
	background-image: url(images/index_03.jpg);
	white-space: nowrap;
}
.topbg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
	text-decoration: none;
	background-repeat: repeat-x;
	background-image: url(images/top_bg.jpg);
	white-space: nowrap;
}
.enter {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #666666;
	text-decoration: none;
	background-repeat: no-repeat;
	background-image: url(images/logi_enter.gif);
	white-space: nowrap;
	font-weight: bold;
}
.lftnavbg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
	text-decoration: none;
	background-repeat: repeat-y;
	background-image: url(images/nav_bg.gif);
}
.footbg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
	text-decoration: none;
	background-repeat: repeat-x;
	background-image: url(images/foot_bg.jpg);
	white-space: nowrap;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #666666;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
	color: #000000;
}
a:active {
	text-decoration: none;
}
.ab {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FFFFFF;
}
.ab:link {
	text-decoration: none;
}
.ab:visited {
	text-decoration: none;
}
.ab:hover {
	text-decoration: none;
	color: #000000;
}
.ab:active {
	text-decoration: none;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
.style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #666666;
	font-size: 9px;
	font-weight: normal;
}
input { font-family: Verdana; color: #000000; border: 1px solid #848484; font-size:10pt; background-color:#FFFFFF

       }
.lftborder {	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-color: #D2D2D2;
	border-right-color: #D2D2D2;
	border-bottom-color: #D2D2D2;
	border-left-color: #D2D2D2;
	border-left-style: solid;
}
.rtborder {	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-top-color: #D2D2D2;
	border-right-color: #D2D2D2;
	border-bottom-color: #D2D2D2;
	border-left-color: #D2D2D2;
}
.ltrtbrdr {	background-color: #F4F4F4;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #D2D2D2;
	border-right-color: #D2D2D2;
	border-bottom-color: #D2D2D2;
	border-left-color: #D2D2D2;
}
.style4 {
	font-size: 10px;
	color: #FFFFFF;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style5 {
	color: #2676D1;
	font-weight: bold;
}
.lanbg {
	background-image: url(images/index_07.jpg);
	background-repeat: no-repeat;
}
.style6 {color: #FF0000}
.ltrtbrdrw {border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #D2D2D2;
	border-right-color: #D2D2D2;
	border-bottom-color: #D2D2D2;
	border-left-color: #D2D2D2;
}
.ltrtbrdr1 {border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-right-style: solid;
	border-left-style: solid;
	border-top-color: #D2D2D2;
	border-right-color: #D2D2D2;
	border-bottom-color: #D2D2D2;
	border-left-color: #D2D2D2;
}
.sbt { CURSOR: hand; }
-->
</style>
</head>

<body>

<!--<table width="775"  border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >-->
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" >
<tr>
<td align="center" colspan="3" >
<?php
	$merid	= intval($_REQUEST['mid']);
	
	$linkobj	= new merchantLink();

	$linkobj->merchantSignUpLink($merid);
	$mer_header = stripslashes(trim(html_entity_decode($linkobj->mer_header)));
	$mer_footer = stripslashes(trim(html_entity_decode($linkobj->mer_footer)));
	echo $mer_header;
 //include "header.php";
?></td></tr>
<tr >

 <td width="20%" valign="top">&nbsp;</td>
 <td width="60%" valign="top" align="center"><?php
 //include "affiliate_signup.php";
 include "new_affil_regi.php";
 //include "affil_regi.php";
?></td>
<td width="20%" valign="top">&nbsp;</td>
</tr>
<tr><td align="center" colspan="3" >
<?php
	echo $mer_footer;
//      include "footer.php";
?>
</td></tr>
</table>
</body>
</html>
