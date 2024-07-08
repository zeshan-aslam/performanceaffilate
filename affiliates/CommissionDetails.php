<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  CommissionDetails.php        	                */
/*     CREATED ON     :  11/SEP/2009                                    */

# View Commission Details 
# 	 
#	
/************************************************************************/
	
	include_once '../includes/db-connect.php';
	include '../includes/session.php';
	include '../includes/constants.php';
	include_once '../includes/functions.php';
	include '../includes/allstripslashes.php';
	include 'language_include.php'; 
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	$programId 		= intval($_REQUEST['programId']);
	$affiliateId 	= intval($_REQUEST['affiliateId']);
	$currSymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];
	#echo "pgmId = ".$programId."   aff = ".$affiliateId;
 
	if($programId) {
		$programDetails		= getProgramDetails($programId);
		if($affiliateId) {
			$sql_joinPgm = "SELECT joinpgm_commissionid FROM partners_joinpgm WHERE joinpgm_programid='$programId' 
			AND joinpgm_affiliateid='$affiliateId' AND joinpgm_commissionid != '0' ";
			$res_joinpgm = mysqli_query($con,$sql_joinPgm);
			if(mysqli_num_rows($res_joinpgm) > 0) {
				list($commissionId) = mysqli_fetch_row($res_joinpgm);  
				$commissionDetails 	= getCommissionDetails($programId, $commissionId);
			} else {
				$commissionDetails 	= getCommissionDetails($programId);
			}
		} 
	} 
?>
<button class="sweet-cancel btn btn-danger btn-fill modal_close1" onClick="javascript: CloseCommissionDetails();" style="display: inline-block;">×</button>
	<h3>Commission Details for the program <?=$programDetails['url']?></h3>
	<div class="sweet-content">
<?php
	if($programDetails)
	{ ?>
		<table class="table table-hover table-striped">
                 <tr>
                    <td  >
                        <img alt="" border='0' height="10" src="../images/impression.gif" width="10" />&nbsp;-&nbsp;
                        <?=$lang_affiliate_imp?>
                    </td>
                    <td>
                    	<?=$currSymbol.number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$programDetails['impression_rate']), 2, '.', '')?>&nbsp;/&nbsp;<?=$programDetails['impression_unit']?>
                    </td>
                </tr>  
                                
                <tr>
                    <td  >
                        <img border="0" height="10" src="../images/click.gif" width="10" alt="" />&nbsp;-&nbsp;
						<?=$lang_affiliate_head_click?>
                    </td>
                    <td  ><?=$currSymbol.number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$programDetails['click']), 2, '.', '')?></td>
                </tr>  
           	
        	</table>
			<table class="table table-hover table-striped">
            	<?php
				if($commissionId) { ?>
                    <tr>
                        <td >
                            <img alt="" border='0' height="10" src="../images/lead.gif" width="10" />&nbsp;-&nbsp;
                            <?=$lang_affiliate_head_lead?>
                        </td>
                        <td  >
                            <?=$currSymbol.number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$commissionDetails[1]['leadrate']), 2, '.', '')?>
                        </td>
                    </tr>  
                                    
                    <tr>
                        <td  >
                            <img border="0" height="10" src="../images/sale.gif" width="10" alt="" />&nbsp;-&nbsp;
                            <?=$lang_affiliate_head_sale?>
                        </td>
                        <td  >
						<?php 
							if($commissionDetails[1]['saletype']=="%"){
									echo $commissionDetails[1]['saletype'].$commissionDetails[1]['salerate'];
								}else{
									echo $currSymbol.number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$commissionDetails[1]['salerate']), 2, '.', '');
								} 
								?>
                        </td>
                    </tr>  
				<?php
				} else { ?>
                   	<tr>
                        <th><?=$lang_trans_type?></th>
                        <th><?=$lang_report_from?></th>
                        <th><?=$lang_report_to?></th>
                        <th><?=$lang_home_commission?></th>
                    </tr>  
                    <?php
                    #~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                    #   For multiple Commission structure 
                    $count = ($commissionDetails)?count($commissionDetails):1;
                    for($i=1; $i<=$count; $i++) { 
                    ?>
						<tr><!-- class="grid1"-->
							<td colspan="4" >
								<b><?=$lang_commission_structure?>&nbsp;<?=($count>1)?$i:""?></b>
							</td>
						</tr>
						<tr>
							<td>
							 <img alt="" border='0' height="10" src="../images/lead.gif" width="10" />&nbsp;-&nbsp;
								<?=$lang_affiliate_head_lead?>
							</td>
							<td><?=$commissionDetails[$i]['lead_from']?></td>
							<td><?=($commissionDetails[$i]['lead_to'])?$commissionDetails[$i]['lead_to']:$lang_value_above?></td>
							<td>
								<?=$currSymbol.number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$commissionDetails[$i]['leadrate']), 2, '.', '')?>
							</td>
						</tr>  
						<tr>
							<td>
								<img border="0" height="10" src="../images/sale.gif" width="10" alt="" />&nbsp;-&nbsp;
								<?=$lang_affiliate_head_sale?>
							</td>
							<td ><?=$commissionDetails[$i]['sale_from']?></td>
							<td ><?=($commissionDetails[$i]['sale_to'])?$commissionDetails[$i]['sale_to']:$lang_value_above?></td>
							<td >
							<?php 
								if($commissionDetails[$i]['saletype']=="%"){
									echo $commissionDetails[$i]['saletype'].$commissionDetails[$i]['salerate'];
								}else{
									echo $currSymbol.number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$commissionDetails[$i]['salerate']), 2, '.', '');
								} 
							?>
							 </td>
						</tr>  
					<?php
					}	
				}	?>
        	</table>
	<?php } ?>      
	</div>
	<button class="sweet-cancel btn btn-danger btn-fill" onClick="javascript: CloseCommissionDetails();" style="display: inline-block;">Cancel</button>
<?php
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
#	FUNCTIONS
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	function getProgramDetails($programId)
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
	

	function getCommissionDetails($programId, $commissionId='')
	{
		$con = $GLOBALS["con"];
		
		$sql = "SELECT * FROM partners_pgm_commission 
			WHERE commission_programid ='$programId'  ";
		if($commissionId) $sql .= "	AND commission_id = '$commissionId' ";
		$sql .= "	ORDER BY commission_id ";
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