<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  CommissionDetails.php        	                */
/*     CREATED ON     :  11/SEP/2009                                    */

# View Commission Details 
# 	 
#	
/************************************************************************/
	
	include 'includes/session.php';
	include 'includes/constants.php';
	include_once 'includes/functions.php';
	include 'includes/allstripslashes.php';
	include 'language_include.php'; 
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	$programId 		= intval($_REQUEST['programId']);
	$currSymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];
 
	if($programId) {
		$programDetails		= getProgramDetails($programId);
		$commissionDetails 	= getCommissionDetails($programId);
	} 
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" >
	<tr>
    	<td align="center" height="40" valign="middle" ><b>Commission Details for the program <?=$programDetails['url']?></b></td>
    </tr> 
<?php
	if($programDetails)
	{ ?>

    <tr>
    	<td >
        	<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
                 <tr>
                    <td align="left" width="85%"  >
                        <img alt="" border='0' height="10" src="images/impression.gif" width="10" />&nbsp;-&nbsp;
                        <?=$lang_impression?>
                    </td>
                    <td align="left" width="15%"  >
                    	<?=$currSymbol.$programDetails['impression_rate']?>&nbsp;/&nbsp;<?=$programDetails['impression_unit']?>
                    </td>
                </tr>  
                                
                <tr>
                    <td align="left" width="85%" >
                        <img border="0" height="10" src="images/click.gif" width="10" alt="" />&nbsp;-&nbsp;
						<?=$lang_click?>
                    </td>
                    <td align="left" width="15%"  ><?=$currSymbol.$programDetails['click']?></td>
                </tr>  
           	
        	</table>
        </td>
    </tr>
    <tr>
    	<td valign="top" >
        	<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
            	<?php
				if($commissionId) { ?>
                    <tr>
                        <td align="left" width="85%" >
                            <img alt="" border='0' height="10" src="images/lead.gif" width="10" />&nbsp;-&nbsp;
                            <?=$lang_lead?>
                        </td>
                        <td align="left" width="15%" >
                            <?=$currSymbol.$commissionDetails[1]['leadrate']?>
                        </td>
                    </tr>  
                                    
                    <tr>
                        <td align="left" >
                            <img border="0" height="10" src="images/sale.gif" width="10" alt="" />&nbsp;-&nbsp;
                            <?=$lang_sale?>
                        </td>
                        <td align="left" >
                            <?=$commissionDetails[1]['saletype']?><?=$commissionDetails[1]['salerate']?>
                        </td>
                    </tr>  
                    <tr><td colspan="2" ><hr/></td></tr>
                <?php
				} else { ?>
     			 	<!--<tr><td height="10" valign="bottom" colspan="4" >&nbsp;</td></tr>-->
                   	<tr>
                        <td align="left" width="55%" class="bluehead" ><?=$lang_Type?></td>
                        <td align="left" width="15%" class="bluehead"><?=$lang_report_from?></td>
                        <td align="left" width="15%" class="bluehead"><?=$lang_report_to?></td>
                        <td align="left" width="15%" class="bluehead" ><?=$lang_value_Commision?></td>
                    </tr>  
                    <?php
                    #~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                    #   For multiple Commission structure 
                    $count = ($commissionDetails)?count($commissionDetails):1;
                    for($i=1; $i<=$count; $i++) { 
                    ?>
                    <tr><!-- class="grid1"-->
                        <td align="left" height="25" valign="middle" colspan="4" >
                            <b><?=$lang_commission_structure?>&nbsp;<?=($count>1)?$i:""?></b>
                        </td>
                    </tr>
                
                    <tr>
                        <td align="left" width="55%" >
                            <img alt="" border='0' height="10" src="images/lead.gif" width="10" />&nbsp;-&nbsp;
                            <?=$lang_lead?>
                        </td>
                        <td align="left" width="15%"><?=$commissionDetails[$i]['lead_from']?></td>
                        <td align="left" width="15%"><?=($commissionDetails[$i]['lead_to'])?$commissionDetails[$i]['lead_to']:$lang_value_above?></td>
                        <td align="left" width="15%" >
                            <?=$currSymbol.$commissionDetails[$i]['leadrate']?>
                        </td>
                    </tr>  
                                    
                    <tr>
                        <td align="left" width="55%">
                            <img border="0" height="10" src="images/sale.gif" width="10" alt="" />&nbsp;-&nbsp;
                            <?=$lang_sale?>
                        </td>
                        <td align="left" width="15%"><?=$commissionDetails[$i]['sale_from']?></td>
                        <td align="left" width="15%"><?=($commissionDetails[$i]['sale_to'])?$commissionDetails[$i]['sale_to']:$lang_value_above?></td>
                        <td align="left" width="15%" >
                            <?=$commissionDetails[$i]['saletype']?><?=$commissionDetails[$i]['salerate']?>
                        </td>
                    </tr>  
                    <tr><td colspan="4" ><hr/></td></tr>
    <?php			}	
				}	?>
        	</table>
        </td>
    </tr>
<?php	
	}
?>
           	
	<tr><td height="10" >&nbsp;</td></tr>
    <tr>
    	<td align="center" ><input type="button" name="Close" value="Close" onClick="javascript: CloseCommissionDetails();" class="button" /></td>
    </tr>
</table>
<?php
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
#	FUNCTIONS
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	function getProgramDetails($programId)
	{
		$sql = "SELECT * FROM partners_program WHERE program_id='$programId' ";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0)
		{
			$row = mysql_fetch_object($res);
			
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
		$sql = "SELECT * FROM partners_pgm_commission 
			WHERE commission_programid ='$programId'  ";
		if($commissionId) $sql .= "	AND commission_id = '$commissionId' ";
		$sql .= "	ORDER BY commission_id ";
		$res = mysql_query($sql);  
		if(mysql_num_rows($res) > 0)
		{
			$i = 1;
			while($row = mysql_fetch_object($res))
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