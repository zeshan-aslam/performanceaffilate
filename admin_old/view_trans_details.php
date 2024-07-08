<?php
	include  "../mail.php";
	
	$id 			= intval($_REQUEST['id']);
	$recurobj		= new recur();
	$recur_sel 		= "selected = 'selected'";
	$mode 			= $_REQUEST['mode'];  
	$recur_period	= $_REQUEST['cmb_recurperiod'];
	$merchantId		= intval($_REQUEST['merchants']);
	
	$result 		= $recurobj->getRecurTransDetails($id,$merchantId);
	if(!$result) 
		$note 		= "No records of this type";
	
	if($result) { ?><p align="right"><a href="#" onClick="window.open('../print_recur_details.php?mid=<?=$merchantId?>&display=transaction&id=<?=$id?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_recur_details.php?mid=<?=$merchantId?>&display=transaction&id=<?=$id?>&mode=admin"><b>Export as CSV</b></a></p> <? }
?>
<form name="frm_trans" method="post">
	<table border="0" cellpadding="0" cellspacing="3"  class="tablebdr"  width="95%" align="center">
		 <tr valign="top">
			 <td  height="19" class="tdhead" colspan="3"  align="center" valign="top">
			 Recurring Transaction Details</td>
		 </tr>
			 <tr>
				<td  height="19" colspan="3"  align="center" class="textred"><? if($note) echo $note; ?></td>
			 </tr>
		 <?  
		 if($result)
		 { 	?>
		 	
			<tr>
				<td valign="top" width="40%">
					<table border="0" cellpadding="0" cellspacing="2"  class="tablebdr"  width="100%" align="center">
						 <tr>
							 <td  height="19" class="tdhead" colspan="2"  align="center">
							 Affiliate Details</td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Affiliate</td>
							<td align="left" class="grid1" height="20"><?=$recurobj->aff_name?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Company</td>
							<td align="left" class="grid1" height="20"><?=$recurobj->aff_company?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">URL</td>
							<td align="left" class="grid1" height="20"><?=$recurobj->aff_url?></td>
						 </tr>
					
					</table>
				</td>
				<td width="5%">&nbsp;</td>
				<td width="55%" align="right" valign="top">
					<table border="0" cellpadding="0" cellspacing="2"  class="tablebdr"  width="100%" align="center">
						 <tr>
							 <td  height="19" class="tdhead" colspan="2"  align="center">
							 Transaction Details</td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Total Commission</td>
							<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=round($recurobj->total_comm,2)?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Date of Transaction</td>
							<td align="left" class="grid1" height="20"><?=$recurobj->trans_date?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Commission Status</td>
							<td align="left" class="grid1" height="20"><?=$recurobj->recur_status?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Order Id</td>
							<td align="left" class="grid1" height="20"><?=$recurobj->trans_orderid?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Sale Amount</td>
							<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=round($recurobj->sale_amount,2)?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Recurring Every</td>
							<td align="left" class="grid1" height="20">
								<?=$recurobj->recur_period?>&nbsp;Month 
							</td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20">Balance Commission</td>
							<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=round($recurobj->recur_balance,2)?></td>
						 </tr>
						 <? if($recurobj->recur_status == 'Active' && $recurobj->recur_balance > 0) { ?> 
						 <tr>
							<td align="left" class="grid1" height="20">Next Recurring Payment On</td>
							<td align="left" class="grid1" height="20"><?=$recurobj->recur_nextpay?></td>
						 </tr>
						 <? } ?>
						 <tr><td colspan="2" class="grid1"  height="20" >&nbsp;</td></tr>
					</table>
				</td>
			</tr>

		 <? 
		 } ?>
		 <tr><td colspan="3"  height="20" >&nbsp;</td></tr>
	</table>
</form>
<?
?>
<script language="javascript" >
    /*--------------------------------------------------------------------------
    Description   :- function to allow only Numeric values in a textbox.
        Called in the onKeyPress event.
    Programmer    :- SMA
    Last Modified :- 18/MAY/2006
    --------------------------------------------------------------------------*/
        function CheckNumeric()
        {	 
                if((window.event.keyCode>57 || window.event.keyCode<48) && (window.event.keyCode!=8))
                {
                        alert('<?=$js_numeric_value?>');
                        window.event.returnValue = null;
                        return false;
                }
                return true;
        }

    /*--------------------------------------------------------------------------
    Description   :- function to validate the Recurring Period.
    Programmer    :- SMA
    Last Modified :- 27/JUNE/2006
    --------------------------------------------------------------------------*/
		function CheckRecurringPeriod()
		{
			if(document.frm_trans.cmb_recurperiod.value == '')
			{
				alert('<?=$err_enterRecurperiod?>');
				document.frm_trans.cmb_recurperiod.focus();
				return false;
			}
			else
			{
				if(document.frm_trans.cmb_recurperiod.value == '0')
				{
					alert('<?=$err_validRecurPeriod?>');
					document.frm_trans.cmb_recurperiod.focus();
					return false;
				}
			}
			return true;
		}
</script>
