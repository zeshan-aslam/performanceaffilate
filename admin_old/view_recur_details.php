<?php
  include  "../mail.php";
  
$id 		= intval($_REQUEST['id']);
$recurobj	= new recur();
$mode 		= $_REQUEST['mode'];  
$merchantId	= intval($_REQUEST['merchants']);


$result = $recurobj->getRecurDetails($id,$merchantId);
if(!$result) $note = "No records of this type";

if($result) { ?><p align="right"><a href="#" onClick="window.open('../print_recur_details.php?mid=<?=$merchantId?>&display=commission&id=<?=$id?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_recur_details.php?mid=<?=$merchantId?>&display=commission&id=<?=$id?>&mode=admin"><b>Export as CSV</b></a></p> <? }
?>
<form name="frm_view" method="post" >
	<table border="0" cellpadding="0" cellspacing="2"  class="tablebdr"  width="50%" align="center">
		 <tr>
			 <td  height="19" class="tdhead" colspan="2"  align="center">
			 Recurring Commission Details</td>
		 </tr>
		 <tr >
			<td  height="19" colspan="2"  align="center" class="textred"><? if($note) echo $note; ?></td>
		 </tr>
		 <?
		 if($result) 
		 { ?>
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
			 <tr>
				<td align="left" class="grid1" height="20">Commission</td>
				<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=round($recurobj->recur_amount,2)?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20">Date</td>
				<td align="left" class="grid1" height="20"><?=$recurobj->recur_date?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20">Commission Status</td>
				<td align="left" class="grid1" height="20"><?=$recurobj->recur_status?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20">Recurring Every</td>
				<td align="left" class="grid1" height="20"><?=$recurobj->recur_period?>&nbsp;Month</td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20">Order Id</td>
				<td align="left" class="grid1" height="20"><?=$recurobj->trans_orderid?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20">Total Commission</td>
				<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=round($recurobj->total_comm,2)?></td>
			 </tr>
			 <tr>
				<td align="left" class="grid1" height="20">Sale Amount</td>
				<td align="left" class="grid1" height="20"><?=$currSymbol?>&nbsp;<?=round($recurobj->sale_amount,2)?></td>
			 </tr>
		<?  } ?>
		 <tr><td colspan="2"   height="20" >&nbsp;</td></tr>
	</table>
</form>
<?
?>