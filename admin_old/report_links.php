<?php
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];

?>
<table cellpadding="0" cellspacing="0"  width="95%" >
  <tr>
    <td width="100%" >&nbsp;</td>
     </tr>

  <tr>
    <td width="100%" align="right">
     <? if($userobj->GetAdminUserLink('Daily',$adminUserId,5)) { ?>
	 [<a href="index.php?Act=daily">Daily</a>]
	 <? } 
	 if($userobj->GetAdminUserLink('For Period',$adminUserId,5)) { ?>
     [<a href="index.php?Act=forperiod">For Period</a>]
	 <? } 
	 if($userobj->GetAdminUserLink('Transaction',$adminUserId,5)) { ?>
     [<a href="index.php?Act=transaction">Transaction</a>]
	 <? } 
	 if($userobj->GetAdminUserLink('Link',$adminUserId,5)) { ?>
     [<a href="index.php?Act=link_report">Link</a>]
	 <? } 
	 if($userobj->GetAdminUserLink('Referer',$adminUserId,5)) { ?>
     [<a href="index.php?Act=referer_report">Referer</a>]
	 <? } 
	 if($userobj->GetAdminUserLink('Products',$adminUserId,5)) { ?>
     [<a href="index.php?Act=product_report">Products</a>]
	 <? }
	 if($userobj->GetAdminUserLink('Recurring Commission',$adminUserId,5)) { ?>
	 [<a href="index.php?Act=recurring">Recurring Commission</a>]	
	 <? }
	 if($userobj->GetAdminUserLink('Graphs',$adminUserId,5)) { ?>
	 [<a href="index.php?Act=graph_return">Graphs</a>]	 
	 <? } 
	 if($userobj->GetAdminUserLink('Affiliate Refferals',$adminUserId,5)) { ?>
	 [<a href="index.php?Act=affiliateReferrals">Affiliate Referrals</a>]	
	 <? }	
	 if($userobj->GetAdminUserLink('Referral Commission',$adminUserId,5)) { ?>
	 [<a href="index.php?Act=referral">Referral Commission</a>]	
	 <? }	  ?>
	 </td>
     </tr>
  <tr>
    <td width="100%" >&nbsp;</td>
     </tr>
</table>
