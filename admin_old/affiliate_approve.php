<?php	

	include_once '../includes/db-connect.php';
	include '../includes/session.php';
	include '../includes/constants.php';
	include_once '../includes/functions.php';
	include '../includes/allstripslashes.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	if(!$partners->islogin()){
		include "admin_login.php";
		exit;
	}

	$affiliateId	= intval($_REQUEST['id']);
	$page			= intval($_REQUEST['page']);
	$status			= $_REQUEST['status']; 
	$sortby			= $_REQUEST['sortby'];    
	$mode			= $_REQUEST['mode'];
	
	$msg 			= $message = $_REQUEST['msg'];
	if($msg == "approved")
		$msg = "Affiliate Account Approved and Tier Commission Group Assigned";
	elseif($msg == "assigned")
		$msg = "Tier Commission Group Assigned to Affiliate";
 
	
	$sql 	= " SELECT * FROM partners_affiliate WHERE affiliate_id='$affiliateId' ";
	$res 	= mysqli_query($con,$sql);     
	if(mysqli_num_rows($res) > 0)
	{
		$row 		= mysqli_fetch_object($res);
		$group		= $row->affiliate_group;
		$affiliate	= stripslashes($row->affiliate_company);
	} 

	switch($mode)
	{
		# Assign a group to the affiliate and Approve affiliate
		case "submit":
			$group	= $_REQUEST['group'];
			if(AssignAffiliateToGroup($affiliateId, $group)) {
			
				# Gets Affiliate Mail Details
				$to 	= getAffiliateMail($affiliateId);
				
				//Approves the Affiliate Status
				ApproveAffiliate($affiliateId);
				
				# Send Approval mail to affiliate
				include "../mail.php"; 
				MailEvent("Approve Affiliate",0,0,$to,0 )  ;  
				 
				header("Location: affiliate_approve.php?msg=approved&id=$affiliateId&page=$page");
				exit;
			} 
			else 
			{
				$msg = "Unknown Error.  Operation Failed!.";
				$groupList = ListAllAffiliateGroups();
				include "affiliate_approve_form.php";
			}							
		break;	
		
		# Assign a group to the affiliate
		case "setCommission":
			$group	= $_REQUEST['group'];
			if(AssignAffiliateToGroup($affiliateId, $group)) {
			
				header("Location: affiliate_approve.php?msg=assigned&id=$affiliateId&page=$page&mode=TierGroup");
				exit;
			} 
			else 
			{
				$msg = "Unknown Error.  Operation Failed!.";
				$groupList = ListAllAffiliateGroups();
				include "affiliate_approve_form.php";
			}							
		break;	
		
		
		case "TierGroup":
			$groupList = ListAllAffiliateGroups();
			include "affiliate_approve_form.php";
		break;
		
	
		# Display the Set Commission form for Affiiate
		default:
			$groupList = ListAllAffiliateGroups();
			include "affiliate_approve_form.php";
		break;
	}


#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
#	FUNCTIONS
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 	function ListAllAffiliateGroups()
	{
		$con = $GLOBALS["con"];
		$sql_list = "SELECT * FROM partners_affiliategroup WHERE 1 ";
		$res_list = mysqli_query($con,$sql_list);
		if(mysqli_num_rows($res_list) > 0)
		{
			$i = 0;
			while($row_list = mysqli_fetch_object($res_list))
			{
				$rows_list[$i]['groupId']		= $row_list->affiliategroup_id;
				$rows_list[$i]['groupTitle']	= stripslashes($row_list->affiliategroup_title);
				$rows_list[$i]['groupLevels']	= $row_list->affiliategroup_levels;
				$i++;
			}
			return $rows_list;
		}
		else
			return false;
	}
	
	
	# Assign a group to the affiliate
	function AssignAffiliateToGroup($affiliateId, $group)
	{
		$con = $GLOBALS["con"];
		$sql_assign = "UPDATE partners_affiliate SET affiliate_group='$group' WHERE affiliate_id='$affiliateId' ";
		$res_assign = mysqli_query($con,$sql_assign);     
		if($res_assign)
			return true;
		else
			return false;
	}
	
	
	# Gets Affiliate Mail Details
	function getAffiliateMail($affiliateId)
	{
		$con = $GLOBALS["con"];
		$sql_login		= " SELECT * FROM partners_login WHERE login_id = '$affiliateId' AND login_flag='a'";
		$ret_login		= mysqli_query($con,$sql_login);
		$row_login		= mysqli_fetch_object($ret_login);
		$affiliateEmail	= $row_login->login_email;
		return $affiliateEmail;
	}
	
	
	# Approves the affiliate
	function ApproveAffiliate($affiliateId){
		$con = $GLOBALS["con"];
		$sql_approve	= " UPDATE partners_affiliate SET affiliate_status = 'approved' WHERE affiliate_id = '$affiliateId'";
		$res_approve 	= mysqli_query($con,$sql_approve);
	
	}
	
?>	
