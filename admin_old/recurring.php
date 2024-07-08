<?
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  recurring.php                                  */
/*     CREATED ON     :  08/JULY/2006                                   */
/*		Generates Reports for Recurring Commissions						*/

/*		Modified By	  : SMA												*/
/*		Modified On	  : 17/JULY/2006									*/
/*		For generating Printable reports and to export report as CSV	*/
 
/************************************************************************/

	$MERCHANTID     = trim($_REQUEST['merchants']);    //merchantid
	$display 	= $_REQUEST['cmb_status'];

	$recurobj	= new recur();
	
	$graphobj 	= new graphs();
	$result 	= $graphobj->GetAllMerchants();
	
?>
<br/>
<form name="frm_recur" method="post" action="">
	<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
		 <tr>
			 <td  height="19" class="tdhead" colspan="2"  align="center"><b>
			 Recurring Sale Commission</b></td>
		 </tr>
		 <tr><td colspan="2">&nbsp;</td></tr>
		 <tr>
		 	<td align="right" width="25%" >Merchants&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="left" width="75%" >
				<select name="merchants" onchange="document.frm_recur.submit()">
					<option value="" >Select One Merchant</option>
				<?	
				if($result)
				{	
					for($i=0; $i<count($graphobj->merId); $i++)
					{
				?>
					<option <? if($MERCHANTID == $graphobj->merId[$i]) echo "selected='selected'"; ?> value="<?=$graphobj->merId[$i]?>"><?=$graphobj->merCompany[$i]?></option>
				<? 
					}
				}	
				?>
				</select>
			</td>
		 </tr>
		 <tr><td colspan="2">&nbsp;</td></tr>
		 <tr>
		 	<td align="right" width="25%"  >Display&nbsp;&nbsp;&nbsp;&nbsp;</td>
		 	<td align="left" width="75%" >
				<select name="cmb_status" onchange="document.frm_recur.submit();" >
					<option value="Transaction" <? if($display == 'Transaction') echo "selected='selected'"; ?> >Recurring Transactions</option>
					<option value="Approved" <? if($display == 'Approved') echo "selected='selected'"; ?> >Approved Recurring Commission</option>
					<option value="Pending" <? if($display == 'Pending') echo "selected='selected'"; ?> >Pending Recurring Commission</option>
				</select>
			</td>
		 </tr>
		 <tr><td colspan="2" height="25" >&nbsp;</td></tr>
	</table>
</form>
<br />
<?php
if($display == '' || $display == 'Transaction')
{
	$trans		= $recurobj->getRecurringTransactions($MERCHANTID);
?>
	 <? if($trans) { ?><p align="right"><a href="#" onClick="window.open('../print_recurring.php?mid=<?=$MERCHANTID?>&display=Transaction','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_recurring.php?mid=<?=$MERCHANTID?>&display=Transaction&mode=admin"><b>Export as CSV</b></a></p> <? } ?>
	 <table class="tablebdr" cellspacing="1" width="95%"  align="center">
	 	<tr><td colspan="6" class="heading-2" style="text-align:center" height="25" ><b>Recurring Transactions</b></td></tr>
		<tr><td colspan="6" align="center"  >&nbsp;</td></tr>
		<tr>
			<td width="30%" align="center" class="tdhead">Affiliate</td>
			<td width="10%" align="center" class="tdhead">Date</td>
			<td width="15%" align="center" class="tdhead">Commission</td>
			<td width="15%" align="center" class="tdhead">Order Id</td>
			<td width="10%" align="center" class="tdhead">Status</td>
			<td width="25%" align="center"  class="tdhead">Action</td>
	  	</tr>
<?		
		if(!$trans)
		{	?>
			<tr><td colspan="6" align="center" class="textred" >No records of this type</td></tr>
		<?
		}
		else
		{	
			for($i=0; $i<count($recurobj->trans_id); $i++)
			{	
				$classid = ($gridcounter%2==1)? "grid1" : "grid2" ;
				
				$viewTrans	= $recurobj->trans_id[$i]."~ViewTransaction";
			?>	
				<tr class="<?=$classid?>">
					<td align="left"><a href="#" onclick="popAff(<?=$recurobj->aff_id[$i]?>);" ><b><?=$recurobj->aff_name[$i]?></b></a></td>
					<td align="center"><?=$recurobj->trans_date[$i]?></td>
					<td align="center"><?=$currSymbol?>&nbsp;<?=round($recurobj->trans_amount[$i],2)?></td>
					<td align="center"><?=$recurobj->trans_orderid[$i]?></td>
					<td align="center"><?=$recurobj->recur_status[$i]?></td>
					<td align="center">
						 <form name="frm_report_<?=$recurobj->trans_id[$i]?>" method="post" action="recurring_process.php" >
							<select name="cmb_action" onchange="document.frm_report_<?=$recurobj->trans_id[$i]?>.submit();" >
								<option value="Select Action">Select Action</option>
								<option value="<?=$viewTrans?>">View Transaction</option>
							</select>
							<input type="hidden" name="hid_Merchant" value="<?=$MERCHANTID?>" />
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
		$result 	= $recurobj->getRecurringCommissions($display,$MERCHANTID);
	?>
	
	 <? if($result) { ?><p align="right"><a href="#" onClick="window.open('../print_recurring.php?mid=<?=$MERCHANTID?>&display=<?=$display?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_recurring.php?mid=<?=$MERCHANTID?>&display=<?=$display?>&mode=admin"><b>Export as CSV</b></a></p> <? } ?>
		 <table class="tablebdr" cellspacing="1" width="95%"  align="center">
		 	<tr><td colspan="5" class="heading-2" style="text-align:center" height="25" ><b><?=(($display=='Approved') ? "Approved Recurring Commission" : "Pending Recurring Commission")?></b></td></tr>
			<tr><td colspan="5" align="center"  >&nbsp;</td></tr>
			<tr>
				<td width="30%" align="center" class="tdhead">Affiliate</td>
				<td width="15%" align="center" class="tdhead">Date</td>
				<td width="20%" align="center" class="tdhead">Commission</td>
				<td width="20%" align="center" class="tdhead">Order Id</td>
				<td width="15%" align="center"  class="tdhead">Action</td>
			</tr>
	<? 
		
		if(!$result)
		{	?>
			<tr><td colspan="5" align="center" class="textred" >No records of this type</td></tr>
		<?
		}
		else
		{	
			for($i=0; $i<count($recurobj->payment_id); $i++)
			{	
				$classid = ($gridcounter%2==1)? "grid1" : "grid2" ;
				
				$viewDetails	= $recurobj->payment_id[$i]."~ViewDetails";
			?>	
				<tr class="<?=$classid?>">
					<td align="left"><a href="#" onclick="popAff(<?=$recurobj->aff_id[$i]?>);" ><b><?=$recurobj->aff_name[$i]?></b></a></td>
					<td align="center"><?=$recurobj->recur_date[$i]?></td>
					<td align="center"><?=$currSymbol?>&nbsp;<?=round($recurobj->recur_amount[$i],2)?></td>
					<td align="center"><?=$recurobj->trans_orderid[$i]?></td>
					<td align="center">
						 <form name="frm_report_<?=$recurobj->payment_id[$i]?>" method="post" action="recurring_process.php" >
							<select name="cmb_action" onchange="document.frm_report_<?=$recurobj->payment_id[$i]?>.submit();" >
								<option value="Select Action">Select Action</option>
								<option value="<?=$viewDetails?>">View Details</option>
							</select>
							<input type="hidden" name="hid_Merchant" value="<?=$MERCHANTID?>" />
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
<br />
<script language="javascript" type="text/javascript">

function popAff(afiliateid)
{
	url="viewprofile_affiliate.php?id="+afiliateid;

	nw = open(url,'new','height=400,width=400,scrollbars=yes');

	nw.focus();
}


</script>