<?php
  include  "../mail.php";

$id 			= $_REQUEST['id'];
$recurobj		= new recur();
$recur_sel 		= "selected = 'selected'";
$mode 			= $_REQUEST['mode'];  
$recur_period	= $_REQUEST['cmb_recurperiod'];
$MERCHANT	= $_SESSION['MERCHANTID'];

if($mode == 'Update')
{
	if($recur_period > 1)
	{
		$res_update = $recurobj->UpdateRecurPeriod($id,$recur_period);
		if($res_update) { 
			$note = $msg_recur_period_updated;
		} 
	}
}
else if($mode == 'Reject')
{
	$recurobj->getRecurTransDetails($id,$_SESSION['MERCHANTID']);
	$status 	= $recurobj->recur_status;
	$recurId 	= $recurobj->recur_id;
	if($status == 'Active')
	{
		$res_status = $recurobj->rejectRecurTransaction($recurId);
		if($res_status) 
		{ 
			   $sql		=	"select * from partners_login L, partners_joinpgm J ,  ".
			   " partners_transaction T  ".
			   " WHERE T.transaction_id='$id' AND T.transaction_joinpgmid = J.joinpgm_id AND ".
			   " L.login_flag='a' AND J.joinpgm_affiliateid = L.login_id ";  
			   $ret1    = mysqli_query($con,$sql);
			   $row     = mysqli_fetch_object($ret1);
			   $to      = $row->login_email;
			   $joinId	= $row->joinpgm_id;
		
			MailEvent("Reject Transaction",$_SESSION['MERCHANTID'],$joinId,$to,$id);
			$note = $msg_recur_trans_rejected;
		}
	}
}

$result = $recurobj->getRecurTransDetails($id,$_SESSION['MERCHANTID']);
if(!$result) $note = $msg_no_records;

if($result) { ?><p align="right"><a href="#" onClick="window.open('../print_recur_details.php?mid=<?=$MERCHANT?>&display=transaction&id=<?=$id?>&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_recur_details.php?mid=<?=$MERCHANT?>&display=transaction&id=<?=$id?>&mode=merchant&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>"><b><?=$lang_export_csv_head?></b></a></p> <? } 
?>
<form name="frm_trans" method="post">
	<table border="0" cellpadding="0" cellspacing="3"  class="tablebdr"  width="95%" align="center">
		 <tr valign="top">
			 <td  height="19" class="tdhead" colspan="3"  align="center" valign="top">
			 <?=$recur_trans_details?></td>
		 </tr>
			 <tr>
				<td  height="19" colspan="3"  align="center" class="textred"><? if($note) echo $note; ?></td>
			 </tr>
		 <?  
		 if($result)
		 { 
				$recurDate 		= $recurobj->trans_date;
				$totalComm		= $recurobj->total_comm;
				$totalSubsale	= $recurobj->recur_subsale;
				$saleAmt		= $recurobj->sale_amount;
				$recurBalance	= $recurobj->recur_balance;
				$subsaleBalance	= $recurobj->recur_bal_subsale;
				if($currValue != $default_currency_caption){
					$totalComm   	=   getCurrencyValue($recurDate, $currValue, $totalComm);
					$totalSubsale	=   getCurrencyValue($recurDate, $currValue, $totalSubsale);
					$saleAmt		=   getCurrencyValue($recurDate, $currValue, $saleAmt);
					$recurBalance	=   getCurrencyValue($recurDate, $currValue, $recurBalance);
					$subsaleBalance	=   getCurrencyValue($recurDate, $currValue, $subsaleBalance);
				}
		 
		 ?>
		 	<tr>
				<td valign="top" width="40%">
					<table border="0" cellpadding="0" cellspacing="2"  class="tablebdr"  width="100%" align="center">
						 <tr>
							 <td  height="19" class="tdhead" colspan="2"  align="center"><b>
							 <?=$lang_reverse_details?></b></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_affiliate?></td>
							<td align="left" class="grid1" height="20"><?=$recurobj->aff_name?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_aff_company?></td>
							<td align="left" class="grid1" height="20"><?=$recurobj->aff_company?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_aff_url?></td>
							<td align="left" class="grid1" height="20"><?=$recurobj->aff_url?></td>
						 </tr>
					
					</table>
				</td>
				<td width="5%">&nbsp;</td>
				<td width="55%" align="right" valign="top">
					<table border="0" cellpadding="0" cellspacing="2"  class="tablebdr"  width="100%" align="center">
						 <tr>
							 <td  height="19" class="tdhead" colspan="2"  align="center">
							 <?=$trans_details_head?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_total_comm?></td>
							<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=$totalComm?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_total_sub_comm?></td>
							<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=$totalSubsale?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$transaction_date?></td>
							<td align="left" class="grid1" height="20"><?=$recurobj->trans_date?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_commStatus?></td>
							<td align="left" class="grid1" height="20"><?=$recurobj->recur_status?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_OrderId?></td>
							<td align="left" class="grid1" height="20"><?=$recurobj->trans_orderid?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_saleAmount?></td>
							<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=$saleAmt?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recuring_every?></td>
							<td align="left" class="grid1" height="20">
								<input type="text" name="cmb_recurperiod"  onKeyPress="CheckNumeric();" value="<?=$recurobj->recur_period?>" style="width:40px;"  />&nbsp;<?=$recur_months_head?>
							</td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_balance?></td>
							<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=$recurBalance?></td>
						 </tr>
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_bal_subsale?></td>
							<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=$subsaleBalance?></td>
						 </tr>
						 <? if($recurobj->recur_status == 'Active' && $recurobj->recur_balance > 0) { ?> 
						 <tr>
							<td align="left" class="grid1" height="20"><?=$recur_nextdate?></td>
							<td align="left" class="grid1" height="20"><?=$recurobj->recur_nextpay?></td>
						 </tr>
						 <? } ?>
						 <tr><td colspan="2" class="grid1"  height="20" >&nbsp;</td></tr>
						 <tr>
							<td class="grid1" height="20" align="center" colspan="2">
								<? if($recurobj->recur_status == 'Active' && $recurobj->recur_balance > 0) { ?> 
									<a href="#" onclick="CheckRecurringPeriod(); document.frm_trans.action='index.php?Act=ViewTransactionDetails&id=<?=$id?>&mode=Update'; document.frm_trans.submit();" ><?=$lemail_Update?></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<? } ?>
								<? if($recurobj->recur_status == 'Active') { ?> 
									<a href="#" onclick="document.frm_trans.action='index.php?Act=ViewTransactionDetails&id=<?=$id?>&mode=Reject'; document.frm_trans.submit();" ><?=$rejectThisTransaction?></a> 
								<? } else echo "<b>$recurobj->recur_status</b>"; ?>
							</td>
						 </tr>
						 
					</table>
				</td>
			</tr>

		 <? 
		 } ?>
		 <tr><td colspan="3"  height="20" >&nbsp;</td></tr>
		 <!-- <tr><td colspan="3" class="grid1"  height="20" align="center" ><input type="button" onclick="history.go(-1);" name="btn_back" value="<?=$common_back?>" /></td></tr> -->
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
