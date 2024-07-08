	<?php
	switch ($Act){
		case 'Merchants' :
			include "newmerchant.php";
		break;
		
		case 'Affiliates' :
			include "newaffiliate.php";
		break;
	
		case 'directory' :
			include "newdirectory.php";
		break;
		
		case 'login' :
			include "newlogin.php";
		break;
		
		case 'aboutus' :
			include "newabout.php";
		break;
		
		case 'contactus' :
			include "newcontact.php";
		break;
		
		case 'register' :
			include "new_merchant_regi.php";
		break;
		
		case  "affil_regi"  :
			include "new_affil_regi.php";
		break;
		
		case 'payments':
			include 'payment_gateways.php';
		break;
	
		case 'paypal':
			include 'paypal.php';
		break;
		
		case 'Payment':
			include 'balancepay.php';
		break;
		
		case 'stormpay':
			include 'stormpay.php';
		break;
		
		case 'authorize':
			include 'authorize.php';
		break;
		
		case 'egold':
			include 'egold.php';
		break;
		
		case 'checkout':
			include 'checkout.php';
		break;
		
		default :
			include "body.php";
		break;
	}
	?>
