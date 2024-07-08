<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  programs.php                            	    */
/*     CREATED ON     :  04/SEP/2009                                    */

/* 	Program Management for Merchants. 									*/
#	List all programs created by Merchants
# 	Add new program.
#	
/************************************************************************/

	$mode		= $_REQUEST['mode'];
	$msg		= $_REQUEST['msg'];
	$programId	= $_REQUEST['programId'];
	
	include "transactions.php";


	switch($mode) 
	{
		case "editprogram":
		case "newprogram":
			if($programId) {
				$programDetails		= getProgramDetails($programId, $currValue, $default_currency_caption);
				$commissionDetails 	= getCommissionDetails($programId, $currValue, $default_currency_caption, $programDetails['pgmDate']);
				$commissionCount	= count($commissionDetails); 
			}  
			include "programForm.php";
		break;
	
		case "submitprogram":
			$con = $GLOBALS["con"];
			$sql="SELECT * FROM partners_program  WHERE program_merchantid = '$MERCHANTID'";
			$res = mysqli_query($con,$sql); 
			// if(mysqli_num_rows($res) > 0){
			// 	header("Location: index.php?Act=programs&programId=$programId&msg=hasProgram");
			// 	exit;
			// } else {
			$programDetails		= AssignProgramValues($_REQUEST);
			$commissionCount	= $_REQUEST['commissionCount']; 
			$commissionDetails 	= AssignCommissionValues($_REQUEST, $commissionCount);
			$message			= ValidateProgram($programDetails, $commissionDetails ,$commissionCount);

			if($message == "success") {
				$programId = SaveProgramDetails($programDetails, $MERCHANTID, $currValue, $default_currency_caption, $programId);
				if($programId) {
					SaveCommissionDetails($programId, $commissionDetails, $commissionCount, $currValue, $default_currency_caption);
					header("Location: index.php?Act=programs&programId=$programId&msg=saved");
					exit;
				}
				else {
					include "programForm.php";
				}
			} else { 
				include "programForm.php";
			}
		// }
		break;
		
		case "addcommission";
			$programDetails		= AssignProgramValues($_REQUEST);
			$commissionCount	= $_REQUEST['commissionCount']; 
			$commissionDetails 	= AssignCommissionValues($_REQUEST, $commissionCount);
			include "programForm.php";
		break;
		
		case "DeleteCommission";
			$programDetails		= AssignProgramValues($_REQUEST);
			$commissionCount	= $_REQUEST['commissionCount']; 
			$deleteCommissionId = $_REQUEST['commissionId_'.$commissionCount]; 
			if($deleteCommissionId)
				deleteCommissionValues($deleteCommissionId);
			$commissionCount	= $commissionCount-1;
			$commissionDetails 	= AssignCommissionValues($_REQUEST, $commissionCount);
			include "programForm.php";
		break;
		
		case "deleteprogram":
		
			$sql_trans = "SELECT * FROM partners_joinpgm  WHERE joinpgm_programid = '$programId'";
			$total=GetPaymentDetails($sql_trans,$currValue,$default_currency_caption); //getting payments (click,sale,lead) values
			$total =explode('~',$total);
			$tot=$total[1]+$total[2]+$total[3]+$total[4];
		
			if($tot==0)
			{  
				DeleteProgramDetails($programId);

				$msg = $lpgm_error4;
				header("Location:index.php?Act=programs&msg=$msg&del=del");
			}
			else
			{ 
				$msg = $lpgm_error5;
				header("Location:index.php?Act=programs&msg=$msg&programId='$programId'");
			}

		break;
	
		default:
			if($programId) {
				$programDetails		= getProgramDetails($programId, $currValue, $default_currency_caption);
				$commissionDetails 	= getCommissionDetails($programId, $currValue, $default_currency_caption, $programDetails['pgmDate']);
			} 

			include "programDetails.php";
		break;
	}


#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
#	FUNCTIONS
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function getProgramDetails($programId, $currValue, $default_currency_caption)
{
	$con = $GLOBALS["con"];

	$sql = "SELECT * FROM partners_program WHERE program_id='$programId' ";
	$res = mysqli_query($con,$sql);
	if(mysqli_num_rows($res) > 0)
	{
		$row = mysqli_fetch_object($res);
		
		$result['pgmDate'] 			= stripslashes(trim($row->program_date));
		
		$result['url'] 				= stripslashes(trim($row->program_url));
		$result['description'] 		= stripslashes(trim($row->program_description));
		$result['impression_rate'] 	= $row->program_impressionrate;
		$result['impression_unit'] 	= $row->program_unitimpression;
		$result['imprapproval'] 	= $row->program_impressionapproval;
		$result['imprmail'] 		= $row->program_impressionmail;
		$result['geo_impression'] 	= $row->program_geotargeting_impression;
		$result['click'] 			= $row->program_clickrate;
		
		// $cookieArray  = explode($row->program_cookie,"");
		$cookieArray  = preg_split('/\s+/', $row->program_cookie);
		
		$result['cookieTime']	= $cookieArray;
		
		// foreach($cookieArray as $key => $value )
		// {
		// 	$result['cookieTime']	= $cookie;
		// }
		$i = 0;
		foreach($cookieArray as $key => $value )
		{
			if($key=== $i)
			{
				$result['cookieTime'] = $value;
			}
			else 
			{
				$result['cookiePeriod'] = $value;
			}
		}

		
		$result['mailmerchant']	= $row->mailmerchant;

		if($currValue != $default_currency_caption ){ 
			$result['click']     		=   getCurrencyValue(date("Y-m-d"), $currValue, $row->program_clickrate);
			$result['impression_rate'] 	= getCurrencyValue(date("Y-m-d"), $currValue, $row->program_impressionrate);
		}
		
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
		return $result;
	}
}


function AssignProgramValues(&$result)
{
		$result['url'] 				= stripslashes(trim($result['url']));
		$result['description'] 		= stripslashes(trim($result['description']));

		$result['impression_rate'] 	= $result['impression'];
		$result['impression_unit'] 	= $result['impressionunit'];
		$result['geo_impression'] 	= $result['chk_geo_impression'];
		$result['imprapproval'] 	= $result['impr_approval'];
		$result['imprmail'] 		= $result['impr_email'];
		$result['click'] 			= $result['click'];
		$result['geo_click'] 		= $result['chk_geo_click'];
		$result['clickapproval'] 	= $result['click_approval'];
		$result['clickmail'] 		= $result['click_email'];
		
		$result['mailaffiliate'] 	= $result['mailaffil'];
		$result['mailmerchant'] 	= $result['mailme'];
		$result['affiliateapproval']= $result['affil_approval'];
		$result['ip'] 				= trim($result['ip']);
		$result['prgm_avail'] 		= $result['sel_countries'];
		$result['cookieTime'] 		= $result['cookieTime'];
		$result['cookiePeriod'] 	= $result['cookiePeriod'];
		return $result;
}
						

function getCommissionDetails($programId, $currValue, $default_currency_caption, $pgmDate)
{
	$con = $GLOBALS["con"];

	$sql = "SELECT * FROM partners_pgm_commission WHERE commission_programid ='$programId' ORDER BY commission_id ";
	$res = mysqli_query($con,$sql);  
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
			
		 	if($currValue != $default_currency_caption ){
				$rows[$i]['leadrate']      	= getCurrencyValue(date("Y-m-d"), $currValue, $row->commission_leadrate);
				if($rows[$i]['saletype']!="%") {
					$rows[$i]['salerate']	= getCurrencyValue(date("Y-m-d"), $currValue, $row->commission_salerate);
					$rows[$i]['saletype'] 	=  $currSymbol;
				}
			}

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

function AssignCommissionValues($rows, $commissionCount)
{
	for($i=1; $i<=$commissionCount; $i++) {
			$result[$i]['commissionId']		= trim($rows['commissionId_'.$i]);
			$result[$i]['lead_from']		= trim($rows['lead_from_'.$i]);
			$result[$i]['lead_to']			= trim($rows['lead_to_'.$i]);
			$result[$i]['leadrate']			= trim($rows['lead_'.$i]);
			$result[$i]['geo_lead']			= trim($rows['chk_geo_lead_'.$i]);
			$result[$i]['leadapproval']		= trim($rows['lead_approval_'.$i]);
			$result[$i]['leadmail']			= trim($rows['lead_email_'.$i]);
			$result[$i]['sale_from']		= trim($rows['sale_from_'.$i]);
			$result[$i]['sale_to']			= trim($rows['sale_to_'.$i]);
			$result[$i]['salerate']			= trim($rows['sale_'.$i]);
			$result[$i]['saletype']			= trim($rows['saletype1_'.$i]); 
			$result[$i]['geo_sale']			= trim($rows['chk_geo_sale_'.$i]);
			$result[$i]['saleapproval']		= trim($rows['sale_approval_'.$i]);
			$result[$i]['salemail']			= trim($rows['sale_email_'.$i]);
			$result[$i]['recur_sale']		= trim($rows['chk_recursale_'.$i]);
			$result[$i]['recur_percentage']	= trim($rows['txt_recurpercent_'.$i]);
			$result[$i]['recur_period']		= trim($rows['cmb_recurperiod_'.$i]);
	}
	return $result;
}


function ValidateProgram($programDetails, $commissionDetails ,$commissionCount)
{

	if(empty($programDetails['url']) || empty($programDetails['description']) )
	{
		return "empty";
	} 
	if(!empty($programDetails['impression_rate']) and (!is_numeric($programDetails['impression_rate'])) )
	{
		return "amount";
	}
	if(!empty($programDetails['click']) and (!is_numeric($programDetails['click'])) )
	{
		return "amount";
	}
	if(!empty($commissionDetails[1]['leadrate']) and (!is_numeric($commissionDetails[1]['leadrate'])) )
	{
		return "amount";
	}
	if(!empty($commissionDetails[1]['salerate']) and (!is_numeric($commissionDetails[1]['salerate'])) )
	{
		return "amount";
	}
	if($commissionCount == 1){
		if(empty($programDetails['impression_rate']) and empty($programDetails['click']) and empty($commissionDetails[1]['salerate']) and empty($commissionDetails[1]['leadrate']) )
		{
			return "atleast_one";
		}
	}
	

	$CommissionAmounts = 0;
	for($i=1; $i<=$commissionCount; $i++) 
	{
			#Validating recuring Sale commissions
			if($commissionDetails[$i]['recur_sale'])
			{
				if(empty($commissionDetails[$i]['recur_percentage'])) {  
					return "recurpercent";
				} else {
					if((!is_numeric($commissionDetails[$i]['recur_percentage']))) {
						return "amount";
					}
				}
				if(empty($commissionDetails[$i]['recur_period'])) {
					return "recurPeriod";
				} else {
					if((!is_numeric($commissionDetails[$i]['recur_period'])) || ($commissionDetails[$i]['recur_period'] == 0)) {
						return "invalidrecurPeriod";
					}
				}
			}
			
			#Validating lead values
			if($commissionCount > 1){
					if(empty($commissionDetails[$i]['lead_from']) || empty($commissionDetails[$i]['lead_to']) || !is_numeric($commissionDetails[$i]['leadrate'])) {
						return "empty_lead";
					}
			} else {
					if(!is_numeric($commissionDetails[$i]['leadrate'])) {
						return "empty_lead";
					}
			}
			if(!empty($commissionDetails[$i]['lead_to']) and ($commissionDetails[$i]['lead_from'] > $commissionDetails[$i]['lead_to'])) {
				return "invalid_range";
			}
			
			#Validating Sale values
			if($commissionCount > 1){
					if(empty($commissionDetails[$i]['sale_from']) || empty($commissionDetails[$i]['sale_to']) || !is_numeric($commissionDetails[$i]['salerate'])) {
						return "empty_sale";
					}
			} else {
					if(!is_numeric($commissionDetails[$i]['salerate'])) {
						return "empty_sale";
					}
			}
			if(!empty($commissionDetails[$i]['sale_to']) and ($commissionDetails[$i]['sale_from'] > $commissionDetails[$i]['sale_to'])) {
				return "invalid_range";
			}
			
			# Checking if atleast one comission is set for the program			
			if($commissionDetails[$i]['leadrate'] or $commissionDetails[$i]['salerate']) {
				$CommissionAmounts = 1;
			}
			
	}
	
	# Checking if atleast one comission is set for the program			
		if($programDetails['impression_rate'] or $programDetails['click']) {
				$CommissionAmounts = 1;
		}
		if($CommissionAmounts == 0)
			return "atleast_one";

	# If all cases valid then return true
	return "success";

}

# Save the Program Details
function SaveProgramDetails($programDetails, $MERCHANTID, $currValue, $default_currency_caption, $programId='')
{
	$con = $GLOBALS["con"];

		if($programDetails['mailaffiliate'])
			$mailaffiliate = $programDetails['mailaffiliate'];
		else $mailaffiliate = "no";
		if($programDetails['mailmerchant'])
			$mailmerchant = $programDetails['mailmerchant'];
		else $mailmerchant = "no";
		
		if(!$programDetails['geo_click']) $geo_click = "0";
		if(!$programDetails['geo_impression']) $geo_impression = "0";
		
		if(count($programDetails['prgm_avail'])>0) 
			$program_country = implode(",",$programDetails['prgm_avail']);
		else
			$program_country = "";
	
		$pgmDate = date("Y-m-d");
		



		if($currValue != $default_currency_caption)   {
			
			$click 		= getDefaultCurrencyValue($pgmDate, $currValue, $programDetails['click'])  ;
			$impression = getDefaultCurrencyValue($pgmDate, $currValue, $programDetails['impression_rate'])  ;
		} else {
			
			$click 		= $programDetails['click'];
			$impression = $programDetails['impression_rate'];
		}

			
		$sql_common = "program_merchantid = '$MERCHANTID', program_url = '".addslashes($programDetails['url'])."', 
			program_description = '".addslashes($programDetails['description'])."', 
			program_impressionrate = '".$impression."', 
			program_unitimpression = '".$programDetails['impression_unit']."', 
			program_geotargeting_impression = '".$geo_impression."', 
			program_impressionapproval = '".$programDetails['imprapproval']."', 
			program_impressionmail = '".$programDetails['imprmail']."', 
			program_clickrate = '".$click."', 
			program_geotargeting_click = '".$geo_click."', 
			program_clickapproval = '".$programDetails['clickapproval']."', 
			program_clickmail = '".$programDetails['clickmail']."',
			program_mailaffiliate = '".$mailaffiliate."' , 
			program_mailmerchant = '".$mailmerchant."' , 
			program_affiliateapproval = '".$programDetails['affiliateapproval']."', 
			program_ipblocking = '".$programDetails['ip']."', 
			program_countries = '".$program_country."', 
			program_cookie = '".$programDetails['cookieTime']." ".$programDetails['cookiePeriod']."' 
			";
		
		if($programId) {
			$sql = "UPDATE partners_program SET program_status = 'active', ".$sql_common." WHERE program_id = '$programId' ";
		} else {
			$sql = "INSERT INTO partners_program SET 
				program_date = '".date("Y-m-d")."', program_status = 'active', ".$sql_common;
		}
		$res = mysqli_query($con,$sql);  
		
		if($programId) 
			return $programId;
		else
			return mysqli_insert_id($con);
}

# Save the commission structure details
function SaveCommissionDetails($programId, $commissionDetails, $commissionCount, $currValue, $default_currency_caption) 
{
	$con = $GLOBALS["con"];

	for($i=1; $i<=$commissionCount; $i++) 
	{
		if(!$commissionDetails[$i]['geo_lead']) $geo_lead = "0";
		if(!$commissionDetails[$i]['geo_sale']) $geo_sale = "0";
		
		$pgmDate = date("Y-m-d");
		$lead  		= $commissionDetails[$i]['leadrate'];
		$sale 		= $commissionDetails[$i]['salerate'];
		if($currValue 	!= $default_currency_caption)   {
			$lead  		= getDefaultCurrencyValue($pgmDate, $currValue, $lead)  ;
			if($commissionDetails[$i]['saletype'] != "%") 
				$sale 	=  getDefaultCurrencyValue($pgmDate, $currValue, $sale)  ;
		}

		$sql_common = "commission_programid = '$programId' , 
		commission_lead_from = '".$commissionDetails[$i]['lead_from']."' , 
		commission_lead_to = '".$commissionDetails[$i]['lead_to']."' , 
		commission_leadrate = '".$lead."' , 
		commission_geotargeting_lead = '".$geo_lead."' , 
		commission_leadapproval = '".$commissionDetails[$i]['leadapproval']."' , 
		commission_leadmail = '".$commissionDetails[$i]['leadmail']."' , 
		commission_sale_from = '".$commissionDetails[$i]['sale_from']."' , 
		commission_sale_to = '".$commissionDetails[$i]['sale_to']."' , 
		commission_salerate = '".$sale."' ,
		commission_saletype  = '".$commissionDetails[$i]['saletype']."' , 
		commission_geotargeting_sale = '".$geo_sale."' , 
		commission_saleapproval = '".$commissionDetails[$i]['saleapproval']."' , 
		commission_salemail = '".$commissionDetails[$i]['salemail']."' , 
		commission_recur_sale = '".$commissionDetails[$i]['recur_sale']."' , 
		commission_recur_percentage = '".$commissionDetails[$i]['recur_percentage']."' , 
		commission_recur_period = '".$commissionDetails[$i]['recur_period']."'  	";
	
		if($commissionDetails[$i]['commissionId']) {
			$sql = "UPDATE partners_pgm_commission SET ".$sql_common." WHERE commission_id = '".$commissionDetails[$i]['commissionId']."' ";
		} else {
			$sql = "INSERT INTO partners_pgm_commission SET ".$sql_common;
		}
		$res = mysqli_query($con,$sql);
	}
}


# Deletes the selected Commission
function deleteCommissionValues($deleteCommissionId)
{
	$con = $GLOBALS["con"];

	$sql = "DELETE FROM partners_pgm_commission WHERE commission_id = '$deleteCommissionId' ";
	$res = mysqli_query($con,$sql);
	if($res) {
		$sql_joinIds = "SELECT joinpgm_id from partners_joinpgm WHERE joinpgm_commissionid='$deleteCommissionId' ";
		$res_joinIds = mysqli_query($con,$sql_joinIds);
		if(mysqli_num_rows($res_joinIds) > 0) {
			while($row_joinIds = mysqli_fetch_object($res_joinIds)) {
				$joinIds .= $row_joinIds->joinpgm_id.",";
			}
			$joinIds = trim($joinIds,",");
			$sql_del = "UPDATE partners_joinpgm SET joinpgm_commissionid='0' WHERE joinpgm_id IN($joinIds) ";
			$res_del = mysqli_query($con,$sql_del);
		}
	}
}
 
 
function DeleteProgramDetails($programId)
{
	$con = $GLOBALS["con"];

			$sql1 	= "DELETE FROM partners_program WHERE program_id='$programId'";
			
			$sql4	= "DELETE FROM partners_html WHERE html_programid='$programId'";
			$sql5	= "DELETE FROM partners_popup WHERE popup_programid='$programId'";
			$sql6	= "DELETE FROM partners_flash WHERE flash_programid='$programId'";
			$sql7	= "DELETE FROM partners_banner WHERE banner_programid='$programId'";
			$sql8	= "DELETE FROM partners_text WHERE text_programid='$programId'";
			$sql10	= "DELETE FROM partners_group WHERE group_programid='$programId'";
			$sql11	= "DELETE FROM partners_text_old WHERE text_programid='$programId'";
			
			mysqli_query($con,$sql1);
			mysqli_query($con,$sql2);
			mysqli_query($con,$sql3);
			mysqli_query($con,$sql4);
			mysqli_query($con,$sql5);
			mysqli_query($con,$sql6);
			mysqli_query($con,$sql7);
			mysqli_query($con,$sql8);
			mysqli_query($con,$sql9);
			mysqli_query($con,$sql10);  
			mysqli_query($con,$sql11);
			
			#Added for the Multiple program Commission
			$sql_commission="DELETE from partners_pgm_commission WHERE commission_programid='$programId'";
			mysqli_query($con,$sql_commission);  

} 
 
?>