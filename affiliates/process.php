<?php
   $Act	= $_GET['Act'];
   
	switch($Act){
		case 'Home':
			include 'home.php';
		break;
		
		case 'paymentlist':
			include  "payment_list.php" ;
		break;
		
		case 'manual_payments':
			include  "payment_link.php" ;
			include  "manual_payments.php" ;
		break;
		
		case 'request':
			include  "request1.php" ;
		break;
		
		case 'reversesale':
			include 'reverse_sales.php';
		break;
		
		case 'Account':
			include 'affilaccounts.php';
		break;
		
		case 'Report':
			include 'report_links.php';
		break;
		
		case 'coupons':
			include 'coupons.php';
		break;
		
		case 'powered_words': 
			include 'powered_words.php';
		break;	
		
		case 'mall_front': 
			include 'mall_front.php';
		break;
		case 'discountHunter': 
			include 'extensionLink.php';
		break;

		case 'powered_wordsClone': 
			include 'powered_wordsClone.php';
		break;	

		case 'daily':
			include 'report_links.php';
			include 'report_daily.php';
		break;
		
		case 'forperiod':
			include 'report_links.php';
			include 'forperiod.php';
		break;
		
		case 'LinkReport':
			include 'report_links.php';
			include 'link_report3.php';
		break;
		
		case "subid_report":
			include 'report_links.php';
			include("subid_report.php");
		break;

		case 'TransReport':
			include 'report_links.php';
			include 'report_trans.php';
		break;
		
		case 'productReport':
			include 'report_links.php';
			include 'product_report.php';
		break;
		
		case 'Affiliates':
			include 'affiliateprograms_link.php';
			include 'affiliate_help.php';
			include 'programs.php';
		break;
		
		case 'Programs':
			include 'affiliateprograms_link.php';
			include 'affiliate_help.php';
			include 'programs.php';
		break;
		
		case 'cat':
			include 'affiliateprograms_link.php';
			include 'bycategory.php';
			// include 'programs.php';
		break;
		case 'catWise':
			include 'programs.php';
		break;
		case 'programWise':
			include 'programs.php';
		break;
		
		case 'MyAffiliates':
			include 'affiliateprograms_link.php';
			include 'affiliate_help.php';
			include 'programs.php';
		break;
		
		case 'Getlinks':
			include 'get_all_links.php';
		break;
		
		case 'getbanner':
			include 'getbanner.php';
		break;
		
		case 'gettext':
			include 'gettext.php';
		break;
		
		case 'gettextnew':
			include 'gettext_new.php';
		break;
		
		case 'getflash':
			include 'getflash.php';
		break;
		
		case 'gethtml':
			include 'gethtml.php';
		break;
		
		case 'getpopup':
			include 'getpopup.php';
		break;
		
		case 'viewprofile':
			include 'viewprofile_merchant.php';
		break;
		
		case 'rotator':
			include 'rotator.php';
		break;
		
		case 'getrotator':
			include 'banner_rotator.php';
		break;
		
		case 'gen_banner':
			include 'gen_banner.php';
		break;
		
		case 'getflash_rotator':
			include 'getflash_rotator.php';
		break;
		
		case 'gen_flash':
			include 'gen_flash.php';
		break;
		
		case 'products':
			include 'products.php';
		break;
		
		case "sub_id_list":
			include("sub_id_list.php");
		break;
		
		case "referral":
			include 'report_links.php';
			include("referral.php");
		break;
		
		case "transactionhistory":			
			include("transactionhistory.php");
		break;
		
		case "Paymenthistory":			
			include("Paymenthistory.php");
		break;
		

   }

?>