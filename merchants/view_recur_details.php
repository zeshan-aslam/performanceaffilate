<?php
  	include  "../mail.php";
  
	$id 		= $_REQUEST['id'];
	$recurobj	= new recur();
	$mode 		= $_REQUEST['mode'];  
	$MERCHANT	= $_SESSION['MERCHANTID'];

if($mode == 'Approve')
{
	$recurobj->getRecurDetails($id,$_SESSION['MERCHANTID']);
	$status 	= $recurobj->recur_status;   
	if($status == 'pending')
	{
		 
		$res_pay = $recurobj->RecurCommissionPayment($id,$_SESSION['MERCHANTID'],$minimum_amount);
		if($res_pay)
		{  
				$today	= date("Y-m-d");
				$sql    = "UPDATE partners_recurpayments SET ".
				" recurpayments_status = 'approved' WHERE recurpayments_id = '$id' ";
				mysqli_query($con,$sql);
	
			   $sql		=	"select * from partners_login L, partners_joinpgm J ,  ".
			   " partners_transaction T, partners_recur R, partners_recurpayments P ".
			   " WHERE P.recurpayments_id = '$id' AND P.recurpayments_recurid = R.recur_id AND ".
			   " R.recur_transactionid = T.transaction_id AND T.transaction_joinpgmid = J.joinpgm_id AND ".
			   " L.login_flag='a' AND J.joinpgm_affiliateid = L.login_id ";
			   $ret1    = mysqli_query($con,$sql);
			   $row     = mysqli_fetch_object($ret1);
			   $to      = $row->login_email;
			   $joinId	= $row->joinpgm_id;
			   $transactionId = $row->transaction_id;
			   $recur_balance = $row->recur_balanceamt;
	
			   MailEvent("Approve Transaction",$_SESSION['MERCHANTID'],$joinId,$to,$id);
			   
			   if( $recur_balance == 0)
			   {
			   		$sql_trans_approve = "UPDATE partners_transaction SET transaction_status='approved' WHERE transaction_id='$transactionId' ";
			   		$res_trans_approve = mysqli_query($con,$sql_trans_approve);
			   }
			   $note = $msg_recur_trans_approved;
		}
		else
		{
			$note = $money_empty_err;
		}
	}
}
else if($mode == 'Reverse')
{
		$sql    = "UPDATE partners_recurpayments SET ".
		" recurpayments_status = 'reverserequest' WHERE recurpayments_id = '$id' ";
		mysqli_query($con,$sql);
}

$result = $recurobj->getRecurDetails($id,$_SESSION['MERCHANTID']);
if(!$result) $note = $msg_no_records;

if($result) { ?><p align="right"><a href="#" onClick="window.open('../print_recur_details.php?mid=<?=$MERCHANT?>&display=commission&id=<?=$id?>&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_recur_details.php?mid=<?=$MERCHANT?>&display=commission&id=<?=$id?>&mode=merchant&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>"><b><?=$lang_export_csv_head?></b></a></p> <? } 
?>
<form name="frm_view" method="post" >
	<table border="0" cellpadding="0" cellspacing="2"  class="tablebdr"  width="50%" align="center">
		 <tr>
			 <td  height="19" class="tdhead" colspan="2"  align="center">
			 <?=$recur_commission_details?></td>
		 </tr>
		 <tr >
			<td  height="19" colspan="2"  align="center" class="textred"><? if($note) echo $note; ?></td>
		 </tr>
		 <?
		 if($result) 
		 { 
				$recurDate 		= $recurobj->recur_date;
				$recurComm		= $recurobj->recur_amount;
				$recurSubsale	= $recurobj->recur_subsale;
				$totalComm		= $recurobj->total_comm;
				$totalSubsale	= $recurobj->total_subsale;
				$saleAmt		= $recurobj->sale_amount;
			 	if($currValue != $default_currency_caption){
		       		$recurComm   	=   getCurrencyValue($recurDate, $currValue, $recurComm);
					$recurSubsale	= 	getCurrencyValue($recurDate, $currValue, $recurSubsale);
					$totalComm		= 	getCurrencyValue($recurDate, $currValue, $totalComm);
					$totalSubsale	= 	getCurrencyValue($recurDate, $currValue, $totalSubsale);
					$saleAmt		= 	getCurrencyValue($recurDate, $currValue, $saleAmt);
       			}
		 
		 ?>
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
			 <tr>
				<td align="left" class="grid1" height="20"><?=$recur_Commission?></td>
				<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=$recurComm?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20"><?=$recur_Date?></td>
				<td align="left" class="grid1" height="20"><?=$recurobj->recur_date?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20"><?=$recur_commStatus?></td>
				<td align="left" class="grid1" height="20"><?=$recurobj->recur_status?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20"><?=$recuring_every?></td>
				<td align="left" class="grid1" height="20"><?=$recurobj->recur_period?>&nbsp;<?=$recur_months_head?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20"><?=$recur_OrderId?></td>
				<td align="left" class="grid1" height="20"><?=$recurobj->trans_orderid?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20"><?=$recur_total_comm?></td>
				<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=$totalComm?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20"><?=$recur_saleAmount?></td>
				<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=$saleAmt?></td>
			 </tr>
			 <? if($recurobj->recur_status=='pending' || $recurobj->recur_status=='approved') 
			 { ?>
				 <tr><td colspan="2" class="grid1"  height="20" >&nbsp;</td></tr>
				 <tr>
					<td colspan="2" class="grid1" height="20" align="center">
					<? if($recurobj->recur_status=='pending') { ?> <a href="#" onclick="document.frm_view.action='index.php?Act=ViewRecurringDetails&id=<?=$id?>&mode=Approve'; document.frm_view.submit();" ><?=$approveThisCommission?></a>
					<? } else if($recurobj->recur_status=='approved') { ?> <a href="#"  onclick="document.frm_view.action='index.php?Act=ViewRecurringDetails&id=<?=$id?>&mode=Reverse'; document.frm_view.submit();" ><?=$reverseThisCommission?></a><? }  ?>
					</td>
				 </tr>
		 <? }
		 } ?>
		 <tr><td colspan="2"   height="20" >&nbsp;</td></tr>
		 <!-- <tr><td colspan="2" class="grid1"  height="20" align="center" ><input type="button" onclick="history.go(-1);" name="btn_back" value="<?=$common_back?>" /></td></tr> -->
	</table>
</form>
<?
?>