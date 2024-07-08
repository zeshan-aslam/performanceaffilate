<?php
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
?>
 
		
<table border="0" align="center" cellpadding="0" cellspacing="0" width="900" >
	<tr>
        <td height="25" colspan="3">

        	<div style="width:18px; float:right; position:relative;">&nbsp;</div>
            
          	<div style="width:86px; float:right; position:relative; text-align:center;"><a href="admin_quit.php"><img src="images/quit.jpg" width="84" height="25" border="0" /></a></div>
              
            <div style="width:86px; float:right; position:relative; text-align:center;">
            <? if($userobj->GetAdminUserLink('PGM Status',$adminUserId,0)) { ?> <a href="index.php?Act=status"><img src="<?= ($Act=="status" ? "images/pgmstatus-h.jpg":"images/pgmstatus.jpg" )?>" width="84" height="25" border="0" /></a> <? } else { ?><img src="images/pgmstatus.jpg" width="84" height="25" border="0" /><? } ?></div>
            
            <div style="width:86px; float:right; position:relative; text-align:center;">
            <? if($userobj->GetAdminUserLink('Options',$adminUserId,0)) { ?> <a href="index.php?Act=options"><img src="<?= (($Act=="options"  or $Act=="payments" or $Act=="setpayments" or $Act=="terms" or $Act=="bulkmail" or $Act=="languages" or $Act=="currency" or $Act=="ip_country" or $Act=="ip_country_update" or   $Act=="event" or $Act=="category" or $Act==mailsettings or $Act=="email" or $Act=="merchantevent"   or $Act=="setpayments" or $Act=="fraudsettings" or $Act=="adminusers" or $Act=="adminuser_privilege" or $Act=="adminuser_edit" )  ? "images/options-h.jpg":"images/options.jpg" )?>" width="84" height="25" border="0" /></a> <? } else { ?><img src="images/options.jpg" width="84" height="25" border="0" /><? } ?></div>
            
            <div style="width:86px; float:right; position:relative; text-align:center;">
            <? if($userobj->GetAdminUserLink('Reports',$adminUserId,0)) { ?> <a href="index.php?Act=reports"><img src="<?= (($Act=="daily" or $Act=="forperiod" or $Act=="transaction" or $Act=="product_report" or $Act=="link_report" or $Act=="referer_report" or $Act=="recurring" or $Act=="ViewRecurringDetails" or $Act=="ViewTransactionDetails" or $Act=="graph_return" or $Act=="graph_affiliate" or $Act=="graph_distribution" or $Act=="graph_bubble" or $Act=="AffiliateGroup" ) ? "images/reports-h.jpg":"images/reports.jpg" )?>" width="84" height="25" border="0" /></a> <? } else { ?><img src="images/reports.jpg" width="84" height="25" border="0" /><? } ?></div>
            
            <div style="width:86px; float:right; position:relative; text-align:center;">
            <? if($userobj->GetAdminUserLink('Payments',$adminUserId,0)) { ?> <a href="index.php?Act=linkpayment"><img src="<?= (($Act=="request" or $Act=="mer_requests" or $Act=="reverse_payments" or $Act=="invoice" or $Act=="view_transactions" or $Act=="export_invoice") ? "images/payments-h.jpg":"images/payments.jpg" )?>" width="84" height="25" border="0" /></a> <? } else { ?><img src="images/payments.jpg" width="84" height="25" border="0" /><? } ?></div>
            
            <div style="width:86px; float:right; position:relative; text-align:center;">
            <? if($userobj->GetAdminUserLink('Programs',$adminUserId,0)) { ?> <a href="index.php?Act=programs&amp;status=all"><img src="<?=(($Act=="programs" or $Act=="products" or $Act=="add_text" or $Act=="add_text1" or $Act=="add_html" or $Act=="add_banner" or $Act=="add_popup" or $Act=="add_flash") ? "images/programs-h.jpg":"images/programs.jpg" )?>" width="84" height="25" border="0" /></a> <? } else { ?><img src="images/programs.jpg" width="84" height="25" border="0" /><? } ?></div>
            
           <?php /*?> <div style="width:86px; float:right; position:relative; text-align:center;">
            <? if($userobj->GetAdminUserLink('Programs',$adminUserId,0)) { ?> <a href="index.php?Act=programs&amp;status=all"><img src="<?=(($Act=="programs" or $Act=="products" or $Act=="add_text" or $Act=="add_text1" or $Act=="add_html" or $Act=="add_banner" or $Act=="add_popup" or $Act=="add_flash") ? "images/programs-h.jpg":"images/programs.jpg" )?>" width="84" height="25" border="0" /></a> <? } else { ?><img src="images/programs.jpg" width="84" height="25" border="0" /><? } ?></div><?php */?>
            
            <div style="width:86px; float:right; position:relative; text-align:center;">
            <? if($userobj->GetAdminUserLink('Affiliates',$adminUserId,0)) { ?> <a href="index.php?Act=affiliates&amp;status=all"><img src="<?=(($Act=="affiliates" or $Act=="payment_affiliate" or $Act=="transaction_affiliate" or $Act=="adjust_affiliate") ? "images/affiliates-h.jpg":"images/affiliates.jpg" )?>" width="84" height="25" border="0" /></a> <? } else { ?><img src="images/affiliates.jpg" width="84" height="25" border="0" /><? } ?></div>
            
            <div style="width:86px; float:right; position:relative; text-align:center;">
            <? if($userobj->GetAdminUserLink('Merchants',$adminUserId,0)) { ?> <a href="index.php?Act=merchants&amp;status=all"><img src="<?=(($Act=="merchants" or $Act=="adjust_merchant" or $Act=="payment_merchant" or $Act=="transaction_merchant") ? "images/merchants-h.jpg":"images/merchants.jpg" )?>" width="84" height="25" border="0" /></a> <? } else { ?><img src="images/merchants.jpg" width="84" height="25" border="0" /><? } ?>
            
            </div>
    	</td>
    </tr>
</table>
	