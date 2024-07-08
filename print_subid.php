<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_subid.php       		                    */
/*     CREATED ON     :  19/JULY/2006                                   */

/*		Printable version of the subid Report of Affiliates				*/
/************************************************************************/
include_once 'includes/db-connect.php';
	include 'includes/session.php';
	include 'includes/constants.php';
	include 'includes/functions.php';
	include 'includes/allstripslashes.php';
	include 'includes/function1.php';
    include_once 'merchants/affiliate_payments.php';


	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	include_once 'language_include.php';
	
	$reportobj	= new report();

	$affiliate		= intval($_REQUEST['aid']);
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
	$currsymbol	= $values[8];
	$subid		= $values[9];
	if($currsymbol == '') $currsymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];

	$affiliateName = $reportobj->FindAffiliateName($affiliate);

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
		<tr><td colspan="3" align="center"><b><?=$lang_report_stat?>&nbsp;<?=$date?></b></td></tr>
		<tr><td colspan="3" align="center"><b><?=$lang_report_affiliate?>&nbsp;:&nbsp;<?=$affiliateName?></b></td></tr>
		<tr><td colspan="3" align="center"><b><?=$lang_report_subid?>&nbsp;<?=$subid?></b></td></tr>

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
