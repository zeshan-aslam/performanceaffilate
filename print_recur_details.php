<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_recur_details.php                        */
/*     CREATED ON     :  17/JULY/2006                                   */

/*		Printable version of the recurring Commission Reports			*/
/************************************************************************/
include_once 'includes/db-connect.php';
  include 'includes/session.php';
  include 'includes/constants.php';
  include 'includes/functions.php';
  include 'includes/allstripslashes.php';
  include 'includes/function1.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$recurobj	= new recur();
	
	$merchant  	= intval($_REQUEST['mid']);
	$display	= $_REQUEST['display'];
	$id 		= $_REQUEST['id'];
	$currValue	= $_REQUEST['currValue'];
	$currsymbol	= $_REQUEST['currsymbol'];

	if($currsymbol == '') $currsymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];
	
	if($currValue == '') $currValue = $default_currency_caption;
	
	
	include_once 'language_include.php';
	

?>
<html>
<title><?=$title?></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<?
if($display == 'commission')
{
	$result 		= $recurobj->getRecurDetails($id,$merchant);
	$recurDate		= $recurobj->recur_date;
	
	$recurAmt		= $recurobj->recur_amount; 
	$totalComm		= $recurobj->total_comm;
	$saleAmt		= $recurobj->sale_amount;
	
	 if($currValue != $default_currency_caption){
			  $recurAmt    	 	=   getCurrencyValue($recurDate, $currValue, $recurAmt);
			  $totalComm    	=   getCurrencyValue($recurDate, $currValue, $totalComm);
			  $saleAmt	    	=   getCurrencyValue($recurDate, $currValue, $saleAmt);
	 }
?>
	<table border="0" cellpadding="0" cellspacing="2"  class="tableNew"  width="50%" align="center">
		 <tr>
			 <td  height="19"  colspan="2"  align="center">
			 <b><?=$recur_commission_details?></b></td>
		 </tr>
		 <tr><td colspan="2"><hr /></td></tr>
		 <tr>
			<td align="left" height="20"><?=$recur_affiliate?></td>
			<td align="left" height="20"><?=$recurobj->aff_name?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_aff_company?></td>
			<td align="left" height="20"><?=$recurobj->aff_company?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_aff_url?></td>
			<td align="left"  height="20"><?=$recurobj->aff_url?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_Commission?></td>
			<td align="left" height="20"><?=$currsymbol?>&nbsp;<?=round($recurAmt,2)?></td>
		 </tr>
		 <tr>
			<td align="left"  height="20"><?=$recur_Date?></td>
			<td align="left" height="20"><?=$recurobj->recur_date?></td>
		 </tr>
		 <tr>
			<td align="left"  height="20"><?=$recur_commStatus?></td>
			<td align="left"  height="20"><?=$recurobj->recur_status?></td>
		 </tr>
		 <tr>
			<td align="left"  height="20"><?=$recuring_every?></td>
			<td align="left" height="20"><?=$recurobj->recur_period?>&nbsp;<?=$recur_months_head?></td>
		 </tr>
		 <tr>
			<td align="left"  height="20"><?=$recur_OrderId?></td>
			<td align="left"  height="20"><?=$recurobj->trans_orderid?></td>
		 </tr>
		 <tr>
			<td align="left"  height="20"><?=$recur_total_comm?></td>
			<td align="left" height="20"><?=$currsymbol?>&nbsp;<?=round($totalComm,2)?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_saleAmount?></td>
			<td align="left"  height="20"><?=$currsymbol?>&nbsp;<?=round($saleAmt,2)?></td>
		 </tr>
		 <tr><td colspan="2"   height="20" >&nbsp;</td></tr>
		 <tr><td colspan="2"><hr /></td></tr>
		 <tr><td align="right" colspan="2"><img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a></td></tr>
	</table>
<?
}
if($display == 'transaction')
{
	$result = $recurobj->getRecurTransDetails($id,$merchant);
	$transDate		= $recurobj->trans_date;
	
	$totalComm		= $recurobj->total_comm;
	$saleAmt	    = $recurobj->sale_amount;
	$recurBal		= $recurobj->recur_balance;
	
	if($currValue != $default_currency_caption){
			  $recurBal    	 	=   getCurrencyValue($transDate, $currValue, $recurBal);
			  $totalComm    	=   getCurrencyValue($transDate, $currValue, $totalComm);
			  $saleAmt	    	=   getCurrencyValue($transDate, $currValue, $saleAmt);
	 }

?>
	<table border="0" cellpadding="0" cellspacing="3"  class="tableNew"  width="50%" align="center">
		 <tr valign="top">
			 <td  height="19" colspan="2"  align="center" valign="top">
			 <b><?=$recur_trans_details?></b></td>
		 </tr>
		 <tr><td colspan="2"><hr /></td></tr>
		 <tr>
			<td align="left" height="20"><?=$recur_affiliate?></td>
			<td align="left" height="20"><?=$recurobj->aff_name?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_aff_company?></td>
			<td align="left" height="20"><?=$recurobj->aff_company?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_aff_url?></td>
			<td align="left" height="20"><?=$recurobj->aff_url?></td>
		 </tr>
					
		 <tr>
			<td align="left" height="20"><?=$recur_total_comm?></td>
			<td align="left" height="20"><?=$currsymbol?>&nbsp;<?=round($totalComm,2)?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_Date?></td>
			<td align="left" height="20"><?=$recurobj->trans_date?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_commStatus?></td>
			<td align="left" height="20"><?=$recurobj->recur_status?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_OrderId?></td>
			<td align="left" height="20"><?=$recurobj->trans_orderid?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_saleAmount?></td>
			<td align="left" height="20"><?=$currsymbol?>&nbsp;<?=round($saleAmt,2)?></td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recuring_every?></td>
			<td align="left" height="20"><?=$recurobj->recur_period?>&nbsp;<?=$recur_months_head?>
			</td>
		 </tr>
		 <tr>
			<td align="left" height="20"><?=$recur_balance?></td>
			<td align="left" height="20"><?=$currsymbol?>&nbsp;<?=round($recurBal,2)?></td>
		 </tr>
		 <? if($recurobj->recur_status == 'Active' && $recurobj->recur_balance > 0) { ?> 
		 <tr>
			<td align="left" height="20"><?=$recur_nextdate?></td>
			<td align="left" height="20"><?=$recurobj->recur_nextpay?></td>
		 </tr>
		 <? } ?>
		 <tr><td colspan="2"  height="20" >&nbsp;</td></tr>
		 <tr><td colspan="2"><hr /></td></tr>
		 <tr><td align="right" colspan="2"><img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a></td></tr>
	</table>

<?
}
?>
</body>
</html>