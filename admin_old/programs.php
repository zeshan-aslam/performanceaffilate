<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  programs1.php                            	    */
/*     CREATED ON     :  09/SEP/2009                                    */

/* 	Program Management for Administrator. 								*/
#	List all programs created by Merchants
#	
/************************************************************************/

include "../merchants/transactions.php";

$mode		= $_REQUEST['mode'];
$msg		= $_REQUEST['msg'];
$programId	= intval($_REQUEST['programId']);


$sql			= "SELECT * FROM partners_program "; //adding to drop down box
$result			= mysqli_query($con, $sql);

if(mysqli_num_rows($result)==0)
{
	echo "<div align='center' class='textred'><b>No Programs Found</b></div>";
}
else # If Programs Exists
{

	$ret			= mysqli_query($con, $sql);
	$row			= mysqli_fetch_object($ret);
	
	if(empty($programId)) $programId = $row->program_id;
	

	$sql  	= "SELECT * FROM partners_joinpgm WHERE joinpgm_programid='$programId'";
 
	$programDetails		= getProgramDetails($programId);
	$commissionDetails 	= getCommissionDetails($programId);

	$afftotal	= GetTotalAffiliates1($sql);             //getting total affiliates,waiting affiliates,transactions
	$afftotal 	= explode('~',$afftotal);
	
	$totallink	= GetLinks($programId,$MERCHANTID);       //getting advertising links
	$totallink 	= explode('~',$totallink);

	# Assign the admin default commissions if specific rates are not set for the program
	if($programDetails['admin_default'] == '1')
	{
		$programDetails['admin_impr'] 		= $const_imp_rate;
		$programDetails['admin_click']  	= $admin_clickrate;
		$programDetails['admin_clicktype']	= ($admin_clickrate_type=="percentage")?"%":"$";
		$programDetails['admin_lead']		= $admin_leadrate;
		$programDetails['admin_leadtype']	= ($admin_leadrate_type=="percentage")?"%":"$";
		$programDetails['admin_sale']		= $admin_salerate;
		$programDetails['admin_saletype']	= ($admin_salerate_type=="percentage")?"%":"$";
	}

	switch($mode)
	{
		# update the program Fee
		case "program_fee":
		
				$prgmType		= trim($_POST['programtype']);
				$prgmFee		= trim($_POST['prgm_fee']);
				$prgmValue	= intval(trim($_POST['recur_value']))." ".trim($_POST['recur_period']);
			
				if(!is_numeric($prgmFee)) {
					$msg="Enter Valid Amount!!!";
					include "programDetails.php";
				}
				else {
					$sql_pgmFee = "UPDATE partners_program 
						SET program_fee = $prgmFee , program_type ='$prgmType', program_value = '$prgmValue'  
						WHERE program_id = '$programId'";
					mysqli_query($con, $sql_pgmFee);
					
					$msg  = "Program Fee Updated";
					header("location:index.php?Act=programs&programId=$programId&msg=$msg");
					exit;
				}
		break;
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		
		# Change the status of the program
		case "changeStatus":

  			$pgmstatus		=trim($_REQUEST['pgmstatus']);   //program status
			if($pgmstatus == "Approve") 
					$status	= "active";
			else
					$status	= "inactive";

			$sql_status = "UPDATE partners_program SET program_status='$status' WHERE program_id='$programId'";
			mysqli_query($con, $sql_status);

			header("location:index.php?Act=programs&programId=$programId&msg=Status modified successfully");
			exit;
		
		break;
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

		
		# Set the admin commission for the program
		case "admin_payments":

				$impression = $programDetails['admin_impr'] 		= trim($_REQUEST['imprate']);
				$click		= $programDetails['admin_click'] 		= trim($_REQUEST['click']);
				$lead		= $programDetails['admin_lead'] 		= trim($_REQUEST['lead']);
				$sale		= $programDetails['admin_sale'] 		= trim($_REQUEST['sale']);
				$clicktype	= $programDetails['admin_clicktype'] 	= $_REQUEST['rad_click_type'];  
				$leadtype 	= $programDetails['admin_leadtype'] 	= $_REQUEST['rad_lead_type'];
				$saletype	= $programDetails['admin_saletype'] 	= $_REQUEST['rad_sale_type'];
		
				$err_msg = "";
				if(empty($impression) or !is_numeric($impression)){
					 $err_msg = "Impression Rate";
				} else if(empty($click) or !is_numeric($click)){
					$err_msg .= "Click Rate ";
				} else if(empty($lead) or !is_numeric($lead)) {
					$err_msg .= "Lead rate ";
				} else if(empty($sale) or !is_numeric($sale)) {
					$err_msg .= " Sale Rate";
				}
			
				if($err_msg) {
					$trans_msg 	= "Enter a valid amount for Admin ";
					$trans_msg	.= $err_msg;
					include "programDetails.php";
				}
				else
				{
					$sql_admin = " UPDATE partners_program SET ".
					" program_admin_impr = '".$impression."' , ".
					" program_admin_click = '".$click."' , ".
					" program_admin_clicktype = '".$clicktype."' , ".
					" program_admin_lead = '".$lead."' , ".
					" program_admin_leadtype = '".$leadtype."' ,".
					" program_admin_sale = '".$sale."' , ".
					" program_admin_saletype = '".$saletype."' , ".
					" program_admin_default = '0'  WHERE program_id='$programId' ";
					$res_admin = mysqli_query($con, $sql_admin);
					
					if($res_admin) { 
						$msg = "Admin Transaction Rates Updated";
						header ("Location: index.php?Act=programs&programId=$programId&msg=$msg");
						exit;
					}
					else {
						$msg = "Unknown Error!.  Updation Failed";
						include "programDetails.php";
					}
				}
		
		break;
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

		
		# View all the affiliates registered for the program
		case "viewAffiliates":
			include "program_viewAffiliates.php";
		break;
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

		
		# Set a specific commission for the selected affiliate for the program so that the commission structure will be applied irrespective of considering the quantity of leads or sales that the affiliate has made
		case "ChangeCommission":
			include "program_ChangeCommission.php";
		break;
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

		
		# Sets a commission structure as default for the affiliate
		case "setCommission":
			$affiliateId 			= $_REQUEST['affiliateId'];
			$affiliateCommission 	= $_REQUEST['affiliateCommission'];
			
			$sql_defaultComm = "UPDATE partners_joinpgm SET joinpgm_commissionid='$affiliateCommission' 
				WHERE joinpgm_affiliateid='$affiliateId' AND joinpgm_programid='$programId' ";
			$res_defaultComm = mysqli_query($con, $sql_defaultComm);  
			if($res_defaultComm) 
				$msg = "updated";
			else
				$msg = "failed";
			header("Location: index.php?Act=programs&mode=ChangeCommission&programId=$programId&affiliateId=$affiliateId&msg=$msg");
			exit;
		break;
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		
		
		# Removes the default commission structure set for the affiliate
		case "deleteCommission":
			$affiliateId 			= $_REQUEST['affiliateId'];
			
			$sql_removeDefault = "UPDATE partners_joinpgm SET joinpgm_commissionid='0' 
				WHERE joinpgm_affiliateid='$affiliateId' AND joinpgm_programid='$programId' ";
			$res_removeDefault = mysqli_query($con, $sql_removeDefault);  
			if($res_removeDefault) 
				$msg = "removed";
			else
				$msg = "failed";
			header("Location: index.php?Act=programs&mode=ChangeCommission&programId=$programId&affiliateId=$affiliateId&msg=$msg");
			exit;
		break;
		#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		

		# Display the program details
		default:
			include "programDetails.php";
		break;
	
 	}

} # End If Programs Exists


#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
#	FUNCTIONS
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	function getProgramDetails($programId)
	{

		$con = $GLOBALS["con"];

		$sql = "SELECT * FROM partners_program WHERE program_id='$programId' ";
		$res = mysqli_query($con, $sql);
		if(mysqli_num_rows($res) > 0)
		{
			$row = mysqli_fetch_object($res);
			
			$result['pgmDate'] 			= stripslashes(trim($row->program_date));
			
			$result['merchantId'] 		= stripslashes(trim($row->program_merchantid));
			$result['url'] 				= stripslashes(trim($row->program_url));
			$result['description'] 		= stripslashes(trim($row->program_description));
			$result['impression_rate'] 	= $row->program_impressionrate;
			$result['impression_unit'] 	= $row->program_unitimpression;
			$result['imprapproval'] 	= $row->program_impressionapproval;
			$result['imprmail'] 		= $row->program_impressionmail;
			$result['geo_impression'] 	= $row->program_geotargeting_impression;
			$result['click'] 			= $row->program_clickrate;
			$result['clickapproval'] 	= $row->program_clickapproval;
			$result['clickmail'] 		= $row->program_clickmail;
			$result['geo_click'] 		= $row->program_geotargeting_click;
			
			$result['ip'] 				= stripslashes(trim($row->program_ipblocking));
			$result['prgm_avail'] 		= $row->program_countries;
			$result['mailaffiliate'] 	= $row->program_mailaffiliate;
			$result['mailmerchant'] 	= $row->program_mailmerchant;
			$result['affiliateapproval']= $row->program_affiliateapproval;
			$result['status'] 			= stripslashes(trim($row->program_status));
			$result['prgm_fee'] 		= trim($row->program_fee);
			$result['prgm_value'] 		= $row->program_value;
			$result['prgm_type'] 		= $row->program_type;
			
			$result['admin_impr'] 		= $row->program_admin_impr;
			$result['admin_click'] 		= $row->program_admin_click;
			$result['admin_clicktype']	= $row->program_admin_clicktype;
			$result['admin_lead'] 		= $row->program_admin_lead;
			$result['admin_leadtype']	= $row->program_admin_leadtype;
			$result['admin_sale'] 		= $row->program_admin_sale;
			$result['admin_saletype'] 	= $row->program_admin_saletype;
			$result['admin_default'] 	= $row->program_admin_default;
			
			
			return $result;
		}
	}
	#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	
	function getCommissionDetails($programId)
	{
		$con = $GLOBALS["con"];

		$sql = "SELECT * FROM partners_pgm_commission WHERE commission_programid ='$programId' ORDER BY commission_id ";
		$res = mysqli_query($con, $sql);  
		if(mysqli_num_rows($res) > 0)
		{
			$i = 1;
			while($row = mysqli_fetch_object($res))
			{
				$rows[$i]['commissionId']		= $row->commission_id;
				$rows[$i]['lead_from']			= $row->commission_lead_from;
				$rows[$i]['lead_to']			= $row->commission_lead_to;
				$rows[$i]['leadrate']			= $row->commission_leadrate;
	
				$rows[$i]['geo_lead']			= $row->commission_geotargeting_lead;
				$rows[$i]['leadapproval']		= $row->commission_leadapproval;
				$rows[$i]['leadmail']			= $row->commission_leadmail;
				$rows[$i]['sale_from']			= $row->commission_sale_from;
				$rows[$i]['sale_to']			= $row->commission_sale_to;
				$rows[$i]['salerate']			= $row->commission_salerate;
				$rows[$i]['saletype']			= $row->commission_saletype;
	
				$rows[$i]['geo_sale']			= $row->commission_geotargeting_sale;
				$rows[$i]['saleapproval']		= $row->commission_saleapproval;
				$rows[$i]['salemail']			= $row->commission_salemail;
				$rows[$i]['recur_sale']			= $row->commission_recur_sale;
				$rows[$i]['recur_percentage']	= $row->commission_recur_percentage;
				$rows[$i]['recur_period']		= $row->commission_recur_period;
				
				$i++;
			}
			return $rows;
		}
		else
			return false;
	} 
	
		
?>

<script language="javascript" >
	
	function viewLink(merchantid){
		url	= "viewprofile_merchant.php?&id="+merchantid;
		nw 	= open(url,'new','height=470,width=400,scrollbars=yes');
		nw.focus();
	}
	
	
	function displayDiv(){
		for (i=0; i < document.typeupdate.elements.length; i++){
			if(document.typeupdate.elements[i].checked == true){
				if((document.typeupdate.elements[i].value)==2)
					document.getElementById("Recur").style.visibility = "visible";
				else   
					document.getElementById("Recur").style.visibility = "hidden";
			}
		}
	}

	function viewAffiliateDetails(affiliateid)
	{
	   url="viewprofile_affiliate.php?id="+affiliateid;
	   nw = open(url,'new','height=450,width=450,scrollbars=yes');
	}
	
</script>