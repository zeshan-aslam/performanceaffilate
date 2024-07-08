<?
	switch ($Act){
	
		case 'setpayments':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Set Payments',$adminUserId,6)) { 
				include 'setpayments.php';
			} else {
				include 'permission_denied.php';
			}			
		break;
		
		case 'terms':
			include 'option_links.php';
			include 'admin_terms.php';
		break;
		
		case 'payment_list':
			if($userobj->GetAdminUserLink('Payment History',$adminUserId,0)) { 
				include 'payment_list.php';
			} else {
				include 'permission_denied.php';
			}			
		break;
		
		case 'payment_adminlist':
			include 'payment_newlink.php';
			include 'payment_adminlist.php';
		break;
		
		case 'payment_2ndlist':
			include 'payment_newlink.php';
			include 'payment_2ndlist.php';
		break;
		
		case 'payment_reverselist':
			include 'payment_newlink.php';
			include 'payment_reverselist.php';
		break;
		
		case 'payments':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Gateways',$adminUserId,6)) { 
				include 'payment_gateways.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'manual_payments':
			include 'payment_newlink.php';
			include 'manual_payments.php';
		break;
		
		case 'paid_mails':
			include 'payment_newlink.php';
			include 'paid_mail.php';
		break;
		
		case 'dopayments':
			include 'payment_link.php';
			include 'newpayments.php';
		break;
		
		case 'admin_payments':
			include 'payment_link.php';
			include 'admin_payments.php';
		break;
		
		case 'reverse_payments':
			include 'payment_link.php';
			if($userobj->GetAdminUserLink('View Reverse Sales',$adminUserId,4)) { 
				include 'reverse_payment.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case '2nd_payments':
			include 'payment_link.php';
			include 'new2nd_payment.php';
		break;
		
		case 'view_trans':
			include 'payment_link.php';
			include 'view_trans.php';
		break;
		
		case 'linkpayment':
			include 'payment_link.php';
			include 'linkpayment.php';
		break;
		
		case 'mer_requests':
			include 'payment_link.php';
			if($userobj->GetAdminUserLink('View Merchant Requests',$adminUserId,4)) { 
				include 'mer_requests.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'request':
			include 'payment_link.php';
			if($userobj->GetAdminUserLink('View Affiliate Requests',$adminUserId,4)) { 
				include 'request.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'adjust_affiliate':
			if($userobj->GetAdminUserLink('Adjust Money',$adminUserId,2)) {
				include 'adjust_affiliate.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'adjust_merchant':
			if($userobj->GetAdminUserLink('Adjust Money',$adminUserId,1)) {
				include 'adjust_merchant.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'paypal':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Gateways',$adminUserId,6)) { 
				include 'paypal.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'stormpay':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Gateways',$adminUserId,6)) { 
				include 'stormpay.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'creditcard':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Gateways',$adminUserId,6)) { 
				include 'creditcard.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'egold':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Gateways',$adminUserId,6)) { 
				include 'egold.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'checkout':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Gateways',$adminUserId,6)) { 
				include 'checkout.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'worldpay':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Gateways',$adminUserId,6)) { 
				include 'worldpay.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'options':
			include 'option_links.php';
			include 'admin_options.php';
		break;
		
		case "ip_country_update":
			include("option_links.php");
			include("ip_country_update.php");
		break;
		
		case 'merchants':
			if($userobj->GetAdminUserLink('Merchants',$adminUserId,0)) {
				include 'search_merchant.php';
				include 'merchants_help.php';
				include 'merchants1.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'payment_merchant':
			if($userobj->GetAdminUserLink('Payment History',$adminUserId,1)) {
				include 'payment_merchant.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'payment_affiliate':
			if($userobj->GetAdminUserLink('Payment History',$adminUserId,2)) {
				include 'payment_affiliate.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'transaction_affiliate':
			if($userobj->GetAdminUserLink('Transaction',$adminUserId,2)) {
				include 'transaction_affiliate.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'transaction_merchant':
			if($userobj->GetAdminUserLink('Transaction',$adminUserId,1)) {
				include "transaction_menu.php";
				include 'transaction_mercahnt.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'revenues':
			include "transaction_menu.php";
			include 'revenues.php';
		break;
		
		case 'languages':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Languages',$adminUserId,6)) { 
				include 'languages.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'programs':
			if($userobj->GetAdminUserLink('Programs',$adminUserId,0)) {
				include 'programs.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'programs1':
			if($userobj->GetAdminUserLink('Programs',$adminUserId,0)) {
				include 'programs.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'status':
			if($userobj->GetAdminUserLink('PGM Status',$adminUserId,0)) {
				include "programstatus_help.php";
				include "waiting_help1.php";
				include 'programstatus.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'waiting_affiliates':
			include "waiting_help1.php";
			include 'waiting_affiliates.php';
		break;
		
		case  'waiting_merchants':
			include "waiting_help1.php";
			include 'waiting_merchants.php';
		break;
		
		case  'programs_edit':
			include 'programs_edit.php';
		break;
		
		case 'affiliates':
			if($userobj->GetAdminUserLink('Affiliates',$adminUserId,0)) {
				include 'search_affiliate.php';
				include 'affiliates_help.php';
				include 'affiliates.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'reports':
			include 'report_links.php';
			include 'reports.php';
		break;
		
		case 'daily':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Daily',$adminUserId,5)) { 
				include 'daily.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'forperiod':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('For Period',$adminUserId,5)) { 
				include 'forperiod.php';
			} else {
				include 'permission_denied.php';
			}  
		break;
		
		case 'transaction':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Transaction',$adminUserId,5)) { 
				include 'report_trans.php';
			} else {
				include 'permission_denied.php';
			}  
		break;
		
		case 'email':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Email Setup',$adminUserId,6)) { 
				include 'admin_email.php';
			} else {
				include 'permission_denied.php';
			}  
		break;
		
		case 'add_banner':
			include 'add_banner.php';
		break;
		
		case 'add_text1':
			include 'add_text1.php';
		break;
		
		case 'add_text':
			include 'add_text.php';
		break;
		
		case 'add_popup':
			include 'add_popup.php';
		break;
		
		case 'add_flash':
			include 'add_flash.php';
		break;
		
		case 'add_html':
			include 'add_html.php';
		break;
		
		case 'event':
			include 'option_links.php';
			include 'email_event.php';
		break;
		
		case 'category':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Add or Remove Category',$adminUserId,6)) { 
				include 'category.php';
			} else {
				include 'permission_denied.php';
			}  
		break;
		
		case 'viewpro':
			include 'viewpro.php';
		break;
		
		case 'mailsettings':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Admin Mail',$adminUserId,6)) { 
				include 'admin_mail_options.php';
			} else {
				include 'permission_denied.php';
			}  
		break;
		
		case 'merchantevent':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Events Enabled For Merchants',$adminUserId,6)) { 
				include 'enable_merchantevent.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'bulkmail':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Bulk Mail',$adminUserId,6)) { 
				include 'bulkmail.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'crm':
			$_SESSION['CRMMERCHANT'] = $_GET['merchant_id'];
			include 'list_crm.php';
		break;
		
		case  'list_crm':
			include 'list_crm.php';
		break;
		
		case  'link_report':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Link',$adminUserId,5)) { 
				include 'link_report.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'referer_report':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Referer',$adminUserId,5)) { 
				include 'report_referer.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'product_report':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Products',$adminUserId,5)) { 
				include 'report_product.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'currency':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Currencies',$adminUserId,6)) { 
				include 'admin_currency.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'setDefault':
			include 'option_links.php';
			include 'setdefault.php';
		break;
		
		case  'products':
			if($userobj->GetAdminUserLink('Change Product Status',$adminUserId,3)) { 
				include 'upload_product.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'invoice':
			include 'payment_link.php';
			if($userobj->GetAdminUserLink('View Invoices',$adminUserId,4)) { 
				include 'invoice_format.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		# show transactions under an invoice
		case "view_transactions":
			include 'payment_link.php';
			if($userobj->GetAdminUserLink('View Invoices',$adminUserId,4)) {
				include("view_transactions.php");
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case "export_invoice":
			include 'payment_link.php';
			if($userobj->GetAdminUserLink('View Invoices',$adminUserId,4)) {
				include("export_invoice.php");
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case "ip_country":
			include("option_links.php");
			if($userobj->GetAdminUserLink('IP-Country DB',$adminUserId,6)) { 
				include("ip_country.php");
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case "fraudsettings":
			include("option_links.php");
			if($userobj->GetAdminUserLink('Fraud Settings',$adminUserId,6)) { 
				include("fraudsettings.php");
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'reverse_recur_payments':
			include 'payment_link.php';
			if($userobj->GetAdminUserLink('View Reverse Recurring Sales',$adminUserId,4)) { 
				include 'reverse_recur_payments.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case 'graph':
			include 'report_links.php';
			include 'graph_menu.php';
			include 'graphs.php';
		break;
		
		case  'graph_return':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Graphs',$adminUserId,5)) { 
				include 'graph_menu.php';
				include 'graph_returndays.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'graph_affiliate':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Graphs',$adminUserId,5)) { 
				include 'graph_menu.php';
				include 'graph_affiliate.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'graph_distribution':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Graphs',$adminUserId,5)) { 
				include 'graph_menu.php';
				include 'graph_distribution.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'graph_bubble':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Graphs',$adminUserId,5)) { 
				include 'graph_menu.php';
				include 'graph_bubble.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'recurring':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Recurring Commission',$adminUserId,5)) { 
				include 'recurring.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'ViewRecurringDetails':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Recurring Commission',$adminUserId,5)) { 
				include 'view_recur_details.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'ViewTransactionDetails':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Recurring Commission',$adminUserId,5)) { 
				include 'view_trans_details.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'adminusers':
			include 'option_links.php';
			if($_SESSION['ADMINUSERID'] == '1') {		
				include 'adminusers.php';
			} else {
				include 'permission_denied.php';
			} 
		break;
		
		case  'adminuser_edit':
			include 'option_links.php';
			if($_SESSION['ADMINUSERID'] == '1') {		
				include 'adminuser_edit.php';
			} else {
				include 'permission_denied.php';
			} 
		break;	 
		
		case  'adminuser_privilege':
			include 'option_links.php';
			if($_SESSION['ADMINUSERID'] == '1') {		
				include 'adminuser_privilege.php';
			} else {
				include 'permission_denied.php';
			} 
		break;
		
		case 'welcome':
			include 'adminuser_welcome.php';
		break;
		
		case 'denied':
			include 'permission_denied.php';
		break;
		
		# Affiliate Group Management
		case  'AffiliateGroup':
			include 'option_links.php';
			if($userobj->GetAdminUserLink('Affiliate Group Management',$adminUserId,6)) { 
				include 'AffiliateGroup.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'referral':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Referral Commission',$adminUserId,5)) { 
				include 'referral.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		
		case  'referral_details':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Referral Commission',$adminUserId,5)) { 
				include 'affiliateReferral_details.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		case  'affiliateReferrals':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Affiliate Refferals',$adminUserId,5)) { 
				include 'affiliateReferrals.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		
		case  'referralDetails':
			include 'report_links.php';
			if($userobj->GetAdminUserLink('Affiliate Refferals',$adminUserId,5)) { 
				include 'referralDetails.php';
			} else {
				include 'permission_denied.php';
			}
		break;
		
		}
?>