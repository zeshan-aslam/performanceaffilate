<?
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  recurring.php                                  */
/*     CREATED ON     :  20/JUNE/2006                                   */
/*		Generates Reports for Recurring Commissions						*/

/*		Modified By	  : SMA												*/
/*		Modified On	  : 17/JULY/2006									*/
/*		For generating Printable reports and to export report as CSV	*/

/************************************************************************/

	$display 	= $_REQUEST['cmb_status'];
	$recurobj	= new recur();
	$MERCHANTID	= $_SESSION['MERCHANTID'];
?>
<br/>
<form name="frm_recur" method="post" action="">
	<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
		 <tr>
			 <td  height="19" class="tdhead" colspan="2" align="center"><b> <?=$recur_commission_head?></b></td>
		 </tr>
		 <tr><td colspan="2" height="25">&nbsp;</td></tr>
		 <tr>
		 	<td align="right" ><?=$lang_recur_display?></td>
		 	<td align="center">
				<select name="cmb_status" onchange="document.frm_recur.submit();" >
					<option value="Transaction" <? if($display == 'Transaction') echo "selected='selected'"; ?> ><?=$lang_recur_transaction?></option>
					<option value="Approved" <? if($display == 'Approved') echo "selected='selected'"; ?> ><?=$lang_recur_approved?></option>
					<option value="Pending" <? if($display == 'Pending') echo "selected='selected'"; ?> ><?=$lang_recur_pending?></option>
				</select>
			</td>
			<!-- <td width="50" align="center"><input type="submit" name="btn_View" value="<?=$common_view?>" /></td>   -->
		 </tr>
		 <tr><td colspan="2" height="25" >&nbsp;</td></tr>
	</table>
</form>
<br/>
<?php
if($display == '' || $display == 'Transaction')
{
	$trans		= $recurobj->getRecurringTransactions($_SESSION['MERCHANTID']);
?>

	 <? if($trans) { ?><p align="right"><a href="#" onClick="window.open('../print_recurring.php?mid=<?=$MERCHANTID?>&display=Transaction&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_recurring.php?mid=<?=$MERCHANTID?>&display=Transaction&mode=merchant&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>"><b><?=$lang_export_csv_head?></b></a></p> <? } ?>
	 <table class="tablebdr" cellspacing="1" width="95%"  align="center">
	 	<tr><td colspan="6" class="heading-2" style="text-align:center" ><b><?=$lang_recur_transaction?></b></td></tr>
		<tr>
			<td width="30%" align="center" class="tdhead"><b><?=$recur_affiliate?></b></td>
			<td width="10%" align="center" class="tdhead"><b><?=$recur_Date?></b></td>
			<td width="15%" align="center" class="tdhead"><b><?=$recur_Commission?></b></td>
			<td width="15%" align="center" class="tdhead"><b><?=$recur_OrderId?></b></td>
			<td width="10%" align="center" class="tdhead"><b><?=$recur_Status?></b></td>
			<td width="25%" align="center"  class="tdhead"><b><?=$recur_Action?></b></td>
	  	</tr>
<?		
		if(!$trans)
		{	?>
			<tr><td colspan="6" align="center" class="textred" ><?=$msg_no_records?></td></tr>
		<?
		}
		else
		{	
			for($i=0; $i<count($recurobj->trans_id); $i++)
			{	
				$classid = ($gridcounter%2==1)? "grid1" : "grid2" ;
				
				$viewTrans	= $recurobj->trans_id[$i]."~ViewTransaction";
				$recurDate 	= $recurobj->trans_date[$i];
				$recurAmt	= $recurobj->trans_amount[$i];
			 	if($currValue != $default_currency_caption){
		       		$recurAmt   =   getCurrencyValue($recurDate, $currValue, $recurAmt);
       			}
			?>	
				<tr class="<?=$classid?>">
					<td align="left"><a href="#" onclick="popAff(<?=$recurobj->aff_id[$i]?>);" ><b><?=$recurobj->aff_name[$i]?></b></a></td>
					<td align="center"><?=$recurobj->trans_date[$i]?></td>
					<td align="center"><?=$currSymbol?>&nbsp;<?=$recurAmt?></td>
					<td align="center"><?=$recurobj->trans_orderid[$i]?></td>
					<td align="center"><?=$recurobj->recur_status[$i]?></td>
					<td align="center">
						 <form name="frm_report_<?=$recurobj->trans_id[$i]?>" method="post" action="recurring_process.php" >
							<select name="cmb_action" onchange="document.frm_report_<?=$recurobj->trans_id[$i]?>.submit();" >
								<option value="Select Action"><?=$recur_selectaction?></option>
								<option value="<?=$viewTrans?>"><?=$recur_ViewTrans?></option>
							</select>
						</form>
					</td>
				</tr>
		<?
			}
		}
?>		
	 </table>
<? 

}


if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if($display != 'Transaction')
	{
		$result 	= $recurobj->getRecurringCommissions($display,$_SESSION['MERCHANTID']);
	?>
	
	 <? if($result) { ?><p align="right"><a href="#" onClick="window.open('../print_recurring.php?mid=<?=$MERCHANTID?>&display=<?=$display?>&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_recurring.php?mid=<?=$MERCHANTID?>&display=<?=$display?>&mode=merchant&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>"><b><?=$lang_export_csv_head?></b></a></p> <? } ?>
		 <table class="tablebdr" cellspacing="1" width="95%"  align="center">
		 	<tr><td colspan="5" class="heading-2" style="text-align:center" ><b><?=(($display=='Approved') ? $lang_recur_approved : $lang_recur_pending)?></b></td></tr>
			<tr>
				<td width="30%" align="center" class="tdhead"><b><?=$recur_affiliate?></b></td>
				<td width="15%" align="center" class="tdhead"><b><?=$recur_Date?></b></td>
				<td width="20%" align="center" class="tdhead"><b><?=$recur_Commission?></b></td>
				<td width="20%" align="center" class="tdhead"><b><?=$recur_OrderId?></b></td>
				<td width="15%" align="center"  class="tdhead"><b><?=$recur_Action?></b></td>
			</tr>
	<? 
		
		if(!$result)
		{	?>
			<tr><td colspan="5" align="center" class="textred" ><?=$msg_no_records?></td></tr>
		<?
		}
		else
		{	
			for($i=0; $i<count($recurobj->payment_id); $i++)
			{	
				$classid = ($gridcounter%2==1)? "grid1" : "grid2" ;
				
				$viewDetails	= $recurobj->payment_id[$i]."~ViewDetails";
				
				$recurDate 	= $recurobj->recur_date[$i];
				$recurAmt	= $recurobj->recur_amount[$i];
			 	if($currValue != $default_currency_caption){
		       		$recurAmt   =   getCurrencyValue($recurDate, $currValue, $recurAmt);
       			}
			?>	
				<tr class="<?=$classid?>">
					<td align="left"><a href="#" onclick="popAff(<?=$recurobj->aff_id[$i]?>);" ><b><?=$recurobj->aff_name[$i]?></b></a></td>
					<td align="center"><?=$recurobj->recur_date[$i]?></td>
					<td align="center"><?=$currSymbol?>&nbsp;<?=$recurobj->recur_amount[$i]?></td>
					<td align="center"><?=$recurobj->trans_orderid[$i]?></td>
					<td align="center">
						 <form name="frm_report_<?=$recurobj->payment_id[$i]?>" method="post" action="recurring_process.php" >
							<select name="cmb_action" onchange="document.frm_report_<?=$recurobj->payment_id[$i]?>.submit();" >
								<option value="Select Action"><?=$recur_selectaction?></option>
								<option value="<?=$viewDetails?>"><?=$recur_ViewDetails?></option>
							</select>
						</form>
					</td>
				</tr>
		<?
			}
		}
	?>
	</table>
<?
	}
}
?>
<script language="javascript" type="text/javascript">

function popAff(afiliateid)
{
	url="viewprofile_affiliate.php?id="+afiliateid;

	nw = open(url,'new','height=400,width=400,scrollbars=yes');

	nw.focus();
}


</script>