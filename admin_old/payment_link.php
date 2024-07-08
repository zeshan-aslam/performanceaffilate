 <?php
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];

?>

 <table cellpadding="0" cellspacing="0" width="95%" >
	<tr>
		<td width="100%" >&nbsp;</td>
	</tr>

	<tr>
		<td width="100%" align="right">
				<? if($userobj->GetAdminUserLink('View Affiliate Requests',$adminUserId,4)) { ?>
				[<a href="index.php?Act=request">Affiliate Requests</a>]
				<? } 
				if($userobj->GetAdminUserLink('View Merchant Requests',$adminUserId,4)) { ?>
				[<a href="index.php?Act=mer_requests">Merchant Requests</a>]
				<? }
				if($userobj->GetAdminUserLink('View Reverse Sales',$adminUserId,4)) { ?>
				[<a href="index.php?Act=reverse_payments">Reverse Sale</a>]
				<? } 
				if($userobj->GetAdminUserLink('View Reverse Recurring Sales',$adminUserId,4)) { ?>
				[<a href="index.php?Act=reverse_recur_payments">Reverse Recurring Sale</a>]
				<? } 
				if($userobj->GetAdminUserLink('View Invoices',$adminUserId,4)) { ?>
				[<a href="index.php?Act=invoice">Invoice</a>]
				<? } ?>
		</td>
	</tr>

	<tr>
		<td width="100%" >&nbsp;</td>
	</tr>
</table>
