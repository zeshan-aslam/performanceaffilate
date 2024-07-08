<?php	 
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  linkpayment.php             			        */
/*     CREATED ON     :  15/JULY/2006                                   */

/*	 Page to acces the reports section 	based on the privileges granted */
/************************************************************************/
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];

	if($userobj->GetAdminUserLink('View Affiliate Requests',$adminUserId,4)) {  
		header("Location: index.php?Act=request");
		exit;
	} else if($userobj->GetAdminUserLink('View Merchant Requests',$adminUserId,4)) 	{  
		header("Location: index.php?Act=mer_requests");
		exit;
	} else if($userobj->GetAdminUserLink('View Reverse Sales',$adminUserId,4)) 	{  
		header("Location: index.php?Act=reverse_payments");
		exit;	
	} else if($userobj->GetAdminUserLink('View Reverse Recurring Sales',$adminUserId,4)) 	{  
		header("Location: index.php?Act=reverse_recur_payments");
		exit;
	} else if($userobj->GetAdminUserLink('View Invoices',$adminUserId,4)) 	{  
		header("Location: index.php?Act=invoice");
		exit;	
	} else
	{
		include 'permission_denied.php';
	}
?>