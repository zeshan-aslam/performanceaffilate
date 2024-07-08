<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_recurring.php                        	*/
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
	$currValue	= $_REQUEST['currValue'];
	$currsymbol	= trim($_REQUEST['currsymbol']);

	if($currsymbol == '') $currsymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];
	
	if($currValue == '') $currValue = $default_currency_caption;
	
	include_once 'language_include.php';

?>
<html>
<title></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>

<?
//Display the report for Recurring Transactions
	if($display == '' || $display == 'Transaction')
	{
		$trans		= $recurobj->getRecurringTransactions($merchant);
				
?>
	 <table class="tableNew" cellspacing="1" width="70%"  align="center">
	 	<tr><td colspan="5" align="center" ><b><?=$lang_recur_transaction?></b></td></tr>
		<tr><td colspan="5" align="center"  >&nbsp;</td></tr>
		<tr>
			<td width="45%" align="left" ><b><?=$recur_affiliate?></b></td>
			<td width="15%" align="center" ><b><?=$recur_Date?></b></td>
			<td width="15%" align="center" ><b><?=$recur_Commission?></b></td>
			<td width="15%" align="center" ><b><?=$recur_OrderId?></b></td>
			<td width="15%" align="center" ><b><?=$recur_Status?></b></td>
	  	</tr>
		<tr><td colspan="5" valign="top" height="1" ><hr /></td></tr>
		<tr><td colspan="5" valign="top" height="1" >&nbsp;</td></tr>
<?		
		for($i=0; $i<count($recurobj->trans_id); $i++)
		{	
		
			$recurDate 	= $recurobj->trans_date[$i];
			$recurAmt	= $recurobj->trans_amount[$i];
			if($currValue != $default_currency_caption){
				$recurAmt   =   getCurrencyValue($recurDate, $currValue, $recurAmt);
			}
		
		?>	
			<tr class="<?=$classid?>">
				<td align="left"><?=$recurobj->aff_name[$i]?></td>
				<td align="center"><?=$recurobj->trans_date[$i]?></td>
				<td align="center"><?=$currsymbol?>&nbsp;<?=round($recurAmt,2)?></td>
				<td align="center"><?=$recurobj->trans_orderid[$i]?></td>
				<td align="center"><?=$recurobj->recur_status[$i]?></td>
			</tr>
	<?
		}
?>		
		<tr><td colspan="5" valign="top" height="1" ><hr /></td></tr>
		<tr><td align="right" colspan="5"><img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a></td></tr>
	 </table>
<?	 
	}

// Display report for approved and pending recurring commissions depending on the option selected
	if($display != 'Transaction')
	{
		$result 	= $recurobj->getRecurringCommissions($display,$merchant);
	?>
		 <table class="tableNew" cellspacing="1" width="70%"  align="center">
		 	<tr><td colspan="5" align="center"  ><b><?=(($display=='Approved') ? $lang_recur_approved : $lang_recur_pending)?></b></td></tr>
			<tr><td colspan="5" align="center"  >&nbsp;</td></tr>
			<tr>
				<td width="30%" align="left" ><b><?=$recur_affiliate?></b></td>
				<td width="15%" align="center" ><b><?=$recur_Date?></b></td>
				<td width="20%" align="center" ><b><?=$recur_Commission?></b></td>
				<td width="20%" align="center" ><b><?=$recur_OrderId?></b></td>
				<td width="15%" align="center" ><b><?=$recur_Status?></b></td>
			</tr>
			<tr><td colspan="5" valign="top" height="1" ><hr /></td></tr>
			<tr><td colspan="5" valign="top" height="1" >&nbsp;</td></tr>
			
	<? 
		for($i=0; $i<count($recurobj->payment_id); $i++)
		{	
				$recurDate 	= $recurobj->recur_date[$i];
				$recurAmt	= $recurobj->recur_amount[$i];
			 	if($currValue != $default_currency_caption){
		       		$recurAmt   =   getCurrencyValue($recurDate, $currValue, $recurAmt);
       			}
		
		?>	
			<tr >
				<td align="left"><?=$recurobj->aff_name[$i]?></td>
				<td align="center"><?=$recurobj->recur_date[$i]?></td>
				<td align="center"><?=$currsymbol?>&nbsp;<?=round($recurAmt,2)?></td>
				<td align="center"><?=$recurobj->trans_orderid[$i]?></td>
				<td align="center"><?=$recurobj->recur_status[$i]?></td>
			</tr>
	<?
		}
		?>
			<tr><td colspan="5" valign="top" height="1" ><hr /></td></tr>
			<tr><td align="right" colspan="5"><img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a></td></tr>
		</table>
	<?
	}
	
?>
</body>
</html>
