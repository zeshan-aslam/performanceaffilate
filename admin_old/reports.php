<?php	 
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  reports.php             			            */
/*     CREATED ON     :  15/JULY/2006                                   */

/*	 Page to acces the reports section 	based on the privileges granted */
/************************************************************************/
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];


	if($userobj->GetAdminUserLink('Daily',$adminUserId,5)) 
	{ 
		header("Location: index.php?Act=daily");
		exit;
	} else if($userobj->GetAdminUserLink('For Period',$adminUserId,5)) 
	{
		header("Location: index.php?Act=forperiod");
		exit;
	} else if($userobj->GetAdminUserLink('Transaction',$adminUserId,5)) 
	{
		header("Location: index.php?Act=transaction");
		exit;
	} else if($userobj->GetAdminUserLink('Link',$adminUserId,5)) 
	{
		header("Location: index.php?Act=link_report");
		exit;
	} else if($userobj->GetAdminUserLink('Referer',$adminUserId,5)) 
	{
		header("Location: index.php?Act=referer_report");
		exit;
	} else if($userobj->GetAdminUserLink('Products',$adminUserId,5)) 
	{
		header("Location: index.php?Act=product_report");
		exit;
	} else if($userobj->GetAdminUserLink('Recurring Commission',$adminUserId,5)) 
	{
		header("Location: index.php?Act=recurring");
		exit;
	} else if($userobj->GetAdminUserLink('Graphs',$adminUserId,5)) 
	{
		header("Location: index.php?Act=graph_return");
		exit;
	} else
	{
		include 'permission_denied.php';
	}
		
	 
?>

