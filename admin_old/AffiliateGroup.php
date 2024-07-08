<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  AffiliateGroup.php                             */
/*     CREATED ON     :  27/JULY/2009                                   */

/*	 	AffiliateGroup Management section. 								*/
# Administrator can manage different groups for the affiliates based on the number of levels or tiers they will have.
# Admin can specify a name and the number of levels (1 to 5) that the group will have.
# Admin can set the commission for each level in each group 
# and set if the commission is provided in flat rate or in percentage of the original sale amount made.

/************************************************************************/

	$mode		= $_REQUEST['mode'];
	$groupId	= $_REQUEST['groupId'];
	$msg		= $_REQUEST['msg'];
	
	if($msg == "saved") 
		$msg = "Group Details Saved successfully!";
	else if($msg == "invalidId") 
		$msg 	= "Affiliate Group Id does not exist";
	else if($msg == "deleted") 
		$msg 	= "Affiliate Group deleted successfully!";
	else if($msg == "commissionSaved") 
		$msg = "Commission details saved successfully";	
	
?>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="95%"  class="tablebdr" >
	<tr><td height="30" valign="middle"><b>&nbsp;&raquo;&raquo;&nbsp;&nbsp;Affiliate Group Management</b></td></tr>
    
    <tr>
    	<td>
    
<?php
	
	switch($mode) {
		# Add new Affiliate Group
		case "submit":
			$grouptitle	= trim(strip_tags($_REQUEST['grouptitle']));
			$level		= $_REQUEST['level'];
			
			if(empty($grouptitle)) {
				$msg 	= "Please enter the title";
				include "AffiliateGroupForm.php";
				include "AffiliateGroupList.php";
			} else {
				if(ifGroupExists($grouptitle,$groupId)) {
					$msg 	= "Group Title already exists";
					include "AffiliateGroupForm.php";
					include "AffiliateGroupList.php";
				}else{
					if(saveAffiliateGroup($grouptitle,$level,$groupId)) {
						$msg 	= "saved";
						header("Location: index.php?Act=AffiliateGroup&msg=$msg");
						exit;
					} else {
						$msg 	= "Unknown Error.  Operation Failed!!";
						include "AffiliateGroupForm.php";
						include "AffiliateGroupList.php";
					}
				}
			}
		break;
		
		
		
		# Edit  Affiliate Group
		case "edit":
			if($groupId) {
				$groupDetails	= getGroupDetails($groupId);
				if($groupDetails) { 
					$grouptitle		= $groupDetails['grouptitle'];
					$level			= $groupDetails['level'];
				} else {
					$msg 	= "invalidId";
					header("Location: index.php?Act=AffiliateGroup&msg=$msg");
					exit;
				}
			}
			include "AffiliateGroupForm.php";
			include "AffiliateGroupList.php";
		break;
		
		
		
		# Delete Affiliate Group
		case "delete":
			if($groupId) {
				if(groupAlreadyUsed($groupId)){
					$msg 	= "The group is already assigned to Affiliates.  Deletion not possible!!";
					include "AffiliateGroupForm.php";
					include "AffiliateGroupList.php";
				} else {
					if(deleteGroup($groupId)) { 
						$msg 	= "deleted";
						header("Location: index.php?Act=AffiliateGroup&msg=$msg");
						exit;
					} else {
						$msg 	= "Unknown Error.  Operation Failed!!";
						include "AffiliateGroupForm.php";
						include "AffiliateGroupList.php";
					}
				}
			} else {
				include "AffiliateGroupForm.php";
				include "AffiliateGroupList.php";
			}
		break;
		
		
		
		# Display Commission settings form for the Group
		case "setCommission";
			$groupDetails		= getGroupDetails($groupId);
			$commisionDetails	= GetGroupCommission($groupId);   
			include "AffiliateGroupCommission.php";
		break;
		
		
		
		# Set the Commission for the Group
		case "submitCommission";
			$groupDetails		= getGroupDetails($groupId);
			$error	= 0;
			for($i=1; $i<=$groupDetails['level']; $i++) {
				$commisionDetails[$i]['commission']	= $_REQUEST['txt_commission_'.$i];
				$commisionDetails[$i]['type']		= $_REQUEST['radio_type_'.$i];
				
				//Validate
				if(empty($commisionDetails[$i]['commission'])  or !is_numeric($commisionDetails[$i]['commission']))	{ 
					$error	= 1;
				} else {
					if($commisionDetails[$i]['type']=="percentage" and $commisionDetails[$i]['commission']>100)
						$error	= 2;
				}
			} 
			if($error != 0) {
				$msg = "Please enter a valid amount for commission";
				include "AffiliateGroupCommission.php";
			} else {
				# Save the commission details for eeach levels of the group
				if(SaveGroupCommission($groupId,$commisionDetails)) {
					$msg = "commissionSaved";
					header("Location: index.php?Act=AffiliateGroup&msg=$msg");
					exit;
				} else {
					include "AffiliateGroupCommission.php";
				}
			}
			
		break;
		
		
		# List all Affiliate Groups
		default:
			include "AffiliateGroupForm.php";
			include "AffiliateGroupList.php";
		break;
	}

?>
        
        </td>
    </tr>
     <tr><td height="30"></td></tr>
	
</table>


<?php 
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
#	FUNCTIONS
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	# Checks if the group exists
 	function ifGroupExists($grouptitle,$groupId='')
	{
		$sql_title = "SELECT * FROM partners_affiliategroup WHERE affiliategroup_title='".addslashes($grouptitle)."' ";
		if($groupId) $sql_title .= " AND affiliategroup_id != '$groupId' ";
		$res_title = mysql_query($sql_title); 
		if(mysql_num_rows($res_title) > 0)
			return true;
		else
			return false;
	}
	
	# Saves the Affiliate Group Details
	function saveAffiliateGroup($grouptitle,$level,$groupId='')
	{
		$sql_common = " affiliategroup_title='".addslashes($grouptitle)."' , affiliategroup_levels = '$level' ";
		if($groupId)
			$sql_save = "UPDATE partners_affiliategroup SET ".$sql_common." WHERE  affiliategroup_id = '$groupId' ";
		else
			$sql_save = "INSERT INTO partners_affiliategroup SET ".$sql_common;
		$res_save = mysql_query($sql_save);
		if($res_save)
			return true;
		else
			return false;
	}
	
	# Gets the details of the selected Affiliate Group
	function getGroupDetails($groupId)
	{
		$sql_details = "SELECT * FROM partners_affiliategroup WHERE  affiliategroup_id = '$groupId' ";
		$res_details = mysql_query($sql_details);
		if(mysql_num_rows($res_details) > 0){
			$row_details 	= mysql_fetch_object($res_details);
			$result_group['grouptitle'] 	= $row_details->affiliategroup_title;
			$result_group['level'] 	= $row_details->affiliategroup_levels;
			
			return $result_group;
		}
		else
			return false;
	}
	
	# Delete selecte Affiliate Group
	function deleteGroup($groupId)
	{
		$sql_del = "DELETE FROM partners_affiliategroup WHERE  affiliategroup_id = '$groupId' ";
		$res_del = mysql_query($sql_del);
		if($res_del)
			return true;
		else
			return false;
	}
	
	# Save the commission details for a group
	function SaveGroupCommission($groupId,$commisionDetails)
	{  
		for($i=1; $i<=count($commisionDetails); $i++) {
			$sql_sel = "SELECT * FROM partners_affiliategroup_commission WHERE commission_groupid='$groupId' AND commission_level='$i' ";
			$res_sel = mysql_query($sql_sel);
			if(mysql_num_rows($res_sel) > 0) {
				$sql_comm = "UPDATE partners_affiliategroup_commission SET commission_amount='".$commisionDetails[$i]['commission']."', commission_type='".$commisionDetails[$i]['type']."'  WHERE commission_groupid='$groupId' AND commission_level='$i' ";
			} else {
				$sql_comm = "INSERT INTO partners_affiliategroup_commission SET commission_amount='".$commisionDetails[$i]['commission']."', commission_type='".$commisionDetails[$i]['type']."',  commission_groupid='$groupId' , commission_level='$i'  ";
			}  
			$res_comm = mysql_query($sql_comm); echo "<br/>qry = ".$sql_comm;
		} 
		return true;
	}

	
	# Get the commission details set for a group
	function GetGroupCommission($groupId) {
		$sql_get = "SELECT * FROM partners_affiliategroup_commission WHERE commission_groupid='$groupId' ";
		$res_get = mysql_query($sql_get);
		if(mysql_num_rows($res_get) > 0)
		{
			$i = 1;
			while($row_get = mysql_fetch_object($res_get)) {
				$rows[$i]['commission'] = $row_get->commission_amount;
				$rows[$i]['type'] 		= $row_get->commission_type;
				$i++;
			}
			return $rows;
		}
	}
	
	# Checks if the group is already used
	function groupAlreadyUsed($groupId)
	{
		$sql = "SELECT * FROM partners_affiliate  WHERE affiliate_group = '$groupId' ";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0) 
			return true;
		else
			return false;
	}
	
?>	