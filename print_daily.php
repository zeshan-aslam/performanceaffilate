<?php	
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_daily.php                                */
/*     CREATED ON     :  18/JULY/2006                                   */

/*		Printable version of the daily Report							*/
/************************************************************************/
	include_once 'includes/db-connect.php';
	include 'includes/session.php';
	include 'includes/constants.php';
	include 'includes/functions.php';
	include 'includes/allstripslashes.php';
	include 'includes/function1.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$reportobj	= new report();

	include_once 'language_include.php';

	$merchant  	= $_REQUEST['mid'];
	if($merchant == 'All') $merchantName = $lang_report_allmerchant;
	else {
		$merchantName	= $reportobj->FindMerchantName($merchant);
	}
	
	$affiliate	= $_REQUEST['aid'];
	if($affiliate == 'All') $affiliateName = $lang_report_allaffiliate;
	else {
		$affiliateName = $reportobj->FindAffiliateName($affiliate);
	}
	
	$mode		= $_REQUEST['mode'];
	$date		= $_REQUEST['date'];
	$values		= $_REQUEST['values'];
	$values		= explode("~",$values);
	$nimpr		= $values[0];
	$impr		= $values[1];
	$nclick		= $values[2];
	$click		= $values[3];
	$nlead		= $values[4];
	$lead		= $values[5];
	$nsale		= $values[6];
	$sale		= $values[7];
	
	$currsymbol	= $values[10];
	if($currsymbol == '') 
	{ 
		$currsymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];
	}
	
	
	$program	= $_REQUEST['program'];  
	if($program == 'All') $program = $lang_report_AllProgram;
	else {
		$program = $reportobj->FindProgramName($program);
	}
	

?>
<html>
<title><?=$title?></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<?

?>
	<table border="0" cellpadding="0" cellspacing="3"  class="tableNew"  width="50%" align="center">
		<tr valign="top">
			 <td  height="19" colspan="3"  align="center" valign="top">
			 <b><?=$lang_report_daily?></b></td>
		</tr>
		<tr><td colspan="3" align="center"><b><?=$lang_report_stat?>&nbsp;<?=$date?></b></td></tr>
		<? if($mode != 'affiliate') { ?>
		<tr><td colspan="3" align="center"><b><?=$lang_report_merchant?>&nbsp;:&nbsp;<?=$merchantName?></b></td></tr>
		<? } 
		if($mode == 'admin' || $mode == 'affiliate') { ?>
			<tr><td colspan="3" align="center"><b><?=$lang_report_affiliate?>&nbsp;:&nbsp;<?=$affiliateName?></b></td></tr>
		<? } 
		if($mode == 'merchant' || $mode == 'affiliate') { ?>
			<tr><td colspan="3" align="center"><b><?=$lang_pgm?>&nbsp;:&nbsp;<?=$program?></b></td></tr>
		<? } ?>
		<tr><td colspan="3"><hr /></td></tr>
		<tr>
			 <td width="40%" ><b><?=$lang_report_transaction?></b></td>
			 <td width="30%" ><b><?=$lang_report_number?></b></td>
			 <td width="30%" ><b><?=$lang_report_commission?></b></td>
		</tr>
		<tr><td colspan="3"><hr /></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td><?=$lang_impression?></td>
			<td><?=$nimpr?></td>
			<td><?=$currsymbol?>&nbsp;<?=$impr?></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td><?=$lang_click?></td>
			<td><?=$nclick?></td>
			<td><?=$currsymbol?>&nbsp;<?=$click?></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td><?=$lang_lead?></td>
			<td><?=$nlead?></td>
			<td><?=$currsymbol?>&nbsp;<?=$lead?></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td><?=$lang_sale?></td>
			<td><?=$nsale?></td>
			<td><?=$currsymbol?>&nbsp;<?=$sale?></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3"><hr /></td></tr>
		<tr><td align="right" colspan="3">
			<img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a>
		</td></tr>
		
	</table>
 	
<?
?>
</body>
</html>
