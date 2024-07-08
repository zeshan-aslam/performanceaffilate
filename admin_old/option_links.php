<?php
//Added by SMA on 14-JUly-2006 for Admin Users
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
//End Add on 14-July-2006

?> 

 <table cellpadding="0" cellspacing="0" width="95%" >
   <tr><td width="100%" >&nbsp;</td></tr>
  <tr>
    <td width="100%" align="center">

	<? if($userobj->GetAdminUserLink('Gateways',$adminUserId,6)) { ?>
      [<a href="index.php?Act=payments">Gateways</a>]
	<? }
	if($userobj->GetAdminUserLink('Set Payments',$adminUserId,6)) { ?>
      [<a href="index.php?Act=setpayments">Set Payments</a>]
	<? } 
	if($userobj->GetAdminUserLink('Affiliates Generic Terms & Conditions',$adminUserId,6)) { ?>
      [<a href="index.php?Act=terms">Affiliates Generic T&amp;C</a>]
	<? } 
	if($userobj->GetAdminUserLink('Merchant Generic Terms & Conditions',$adminUserId,6)) { ?>
      [<a href="index.php?Act=terms&amp;type=merchant">Merchant Generic T&amp;C</a>]
	<? }
	if($userobj->GetAdminUserLink('Add or Remove Category',$adminUserId,6)) { ?>
      [<a href="index.php?Act=category">Add or Remove Category</a>]
	<? } 
	if($userobj->GetAdminUserLink('Email Setup',$adminUserId,6)) { ?>
      [<a href="index.php?Act=email">Email Setup</a>]
	<? }if($userobj->GetAdminUserLink('Events Enabled For Merchants',$adminUserId,6)) { ?>
      [<a href="index.php?Act=merchantevent">Events Enabled For Merchants</a>]
	<? } 	?>
	<br/>
	<? 
	if($userobj->GetAdminUserLink('Admin Mail',$adminUserId,6)) { ?>
      [<a href="index.php?Act=mailsettings">Admin Mail</a>]
	<? }
	if($userobj->GetAdminUserLink('Bulk Mail',$adminUserId,6)) { ?>
      [<a href="index.php?Act=bulkmail">Bulk Mail</a>]
	<? }
	if($userobj->GetAdminUserLink('Languages',$adminUserId,6)) { ?>
      [<a href="index.php?Act=languages&amp;mode=add">Languages</a>]
	<? }
	if($userobj->GetAdminUserLink('Currencies',$adminUserId,6)) { ?>
      [<a href="index.php?Act=currency&amp;mode=add">Currencies</a>]
	<? }
	if($userobj->GetAdminUserLink('IP-Country DB',$adminUserId,6)) { ?>
      [<a href="index.php?Act=ip_country">IP-Country DB</a>]	  
    <? }
	if($userobj->GetAdminUserLink('Back up',$adminUserId,6)) {  ?>
	  [<a href="#" onclick="window.open('backupstart.php')">Back Up</a>]
	<? } 
	if($userobj->GetAdminUserLink('Fraud Settings',$adminUserId,6)) { ?>
	  [<a href="index.php?Act=fraudsettings">Fraud Settings</a>]	
	<?  }
	if($_SESSION['ADMINUSERID'] == '1') { ?>
	  [<a href="index.php?Act=adminusers">Admin Users</a>]	
	<? }  
	if($userobj->GetAdminUserLink('Affiliate Group Management',$adminUserId,6)) { ?>
	  [<a href="index.php?Act=AffiliateGroup">Affiliate Group Management</a>]	
	<?  } ?>
	 </td>	  
  </tr>
</table>
<br/>