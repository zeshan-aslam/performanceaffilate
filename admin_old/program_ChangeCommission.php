<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  program_viewAffiliates.php                     */
/*     CREATED ON     :  09/SEP/2009                                    */

# View all affiliates registered for a selected program	 
# 	 
#	
/************************************************************************/

	$affiliateId 	= intval($_REQUEST['affiliateId']);
	

	$sql_joinpgm = "SELECT * FROM partners_joinpgm 
		WHERE joinpgm_programid='$programId'  AND joinpgm_affiliateid = '$affiliateId' ";
	$res_joinpgm = mysqli_query($con,$sql_joinpgm);
	$joinpgmCount = mysqli_num_rows($res_joinpgm);

?>	
<script language="javascript" >
	
	function deleteCommission()
	{
		if(confirm('Are you sure to remove the default commission set for this Affiliate')) 
		{
			document.frm_affComm.action='index.php?Act=programs&mode=deleteCommission'; 
			document.frm_affComm.submit(); 
		}
		else
			return false;
	}	
		
	function setCommission(commissionId)
	{
		if(confirm('Are you sure to set this as the default commission for this Affiliate')) 
		{
			document.frm_affComm.affiliateCommission.value=commissionId;
			document.frm_affComm.action='index.php?Act=programs&mode=setCommission'; 
			document.frm_affComm.submit(); 
		}
		else
			return false;
	}	

</script>

<table border="0" cellpadding="0" cellspacing="0" width="95%" class="tablewbdr" align="center">
	<tr>
		<td  align="right"  height="30" valign="middle"> 
			<b>Back to 
            <a href="index.php?Act=programs&mode=viewAffiliates&programId=<?=$programId?>" >Registered Affiliates</a>&nbsp;for&nbsp;
            <a href="index.php?Act=programs&programId=<?=$programId?>" >program <?=$programDetails['url']?></a>
            </b> 
		</td>
	</tr>
</table>
<?php if($msg) { 
	if($msg == "updated")
		$msg = "Default Commission set for the affiliate";
	else if($msg == "failed")
		$msg = "Default Commission setting failed";
	else if($msg == "removed")
		$msg = "Removed the Default Commission for the affiliate";
?>
<table border="0" cellpadding="0" cellspacing="0" width="95%" class="tablewbdr" align="center">
	<tr>
		<td  align="center"  height="30" class='textred' valign="bottom"> 
			<?=$msg?>
		</td>
	</tr>
</table>

<?php } 


if($joinpgmCount > 0) {
	$joinpgmRow = mysqli_fetch_object($res_joinpgm);
	$affiliateCommission = $joinpgmRow->joinpgm_commissionid;  
?>
<form name="frm_affComm" method="post" action="" >

<input type="hidden" name="affiliateId" value="<?=$affiliateId?>" />
<input type="hidden" name="programId" value="<?=$programId?>" />
<input type="hidden" name="affiliateCommission" value="<?=$affiliateCommission?>"  />

<table align="center" border="0" cellpadding="0" cellspacing="0" width="80%" class="tablebdr">
    <tr class="tdhead" height="19">
        <td align="center"><b>Commission Structures for the program <?=$programDetails['url']?></b></td>
    </tr>
    <tr><td height="20" >&nbsp;</td></tr>
	<tr>
        <td width="100%" align="center">
        	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" >
			<?php
 			#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            #   For multiple Commission structure 
				$count = ($commissionDetails)?count($commissionDetails):1;
					for($i=1; $i<=$count; $i++) { 
					?>
					<tr>
                    	<td width="30%" align="left" height="30" valign="middle" ><b>Commission Structure&nbsp;<?=$i?></b></td>
                        <td width="70%" align="right" valign="middle" class="greenText">
                        	<?php if($affiliateCommission == $commissionDetails[$i]['commissionId']) { ?>
                            	<b>Default commission for this Affiliate 
                                <input type="button" value="Remove Default Commission" name="remove" class="button" onclick="javascript: deleteCommission();" />
                            <?php } else { ?>
                        		<input type="button" value="Set this as default for Affiliate" name="set_<?=$i?>" class="button" onclick="javascript: setCommission('<?=$commissionDetails[$i]['commissionId']?>');" />
                            <?php } ?>
                        &nbsp;&nbsp;</td>
                    </tr>
					<tr>
						<td colspan="2"  class="commissionTable" >
							<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
								<tr >
									<td align="center" class="tdhead" width="20%">Type</td>
									<td align="center" class="tdhead" width="10%">From</td>
									<td align="center" class="tdhead" width="10%">To</td>
									<td align="center" class="tdhead" width="20%">Commissions</td>
									<td align="center" class="tdhead" width="20%">Approval</td>
									<td align="center" class="tdhead" width="20%">Email Settings</td>
								</tr>  
								<tr>
									<td  align="left" width="20%">
										<img border="0" height="10" src="../images/lead.gif" width="10" alt="" /> - Lead
                                    </td>
									<td align="center" ><?=$commissionDetails[$i]['lead_from']?></td>
									<td align="center" ><?=($commissionDetails[$i]['lead_to'])?$commissionDetails[$i]['lead_to']:$lang_value_above?></td>
									<td align="center" ><?=$currSymbol.$commissionDetails[$i]['leadrate']?></td>
									<td align="center" >
										<?=($commissionDetails[$i]['leadapproval'])?$commissionDetails[$i]['leadapproval']:"manual"?>
                                    </td>
									<td align="center" >
										<?=($commissionDetails[$i]['leadmail'])?$commissionDetails[$i]['leadmail']:"manual"?>
                                    </td>
								</tr>
								<tr>
									<td  class="grid1" align="left">
										<img border="0" height="10" src="../images/sale.gif" width="10" alt="" /> - Sale
                                    </td>
									<td align="center" class="grid1" ><?=$commissionDetails[$i]['sale_from']?></td>
									<td align="center" class="grid1" ><?=($commissionDetails[$i]['sale_to'])?$commissionDetails[$i]['sale_to']:$lang_value_above?></td>
									<td align="center"  class="grid1">
										<?=($commissionDetails[$i]['saletype'])?$commissionDetails[$i]['saletype']:$currSymbol?><?=$commissionDetails[$i]['salerate']?>
                                    </td>
									<td align="center"  class="grid1">
										<?=($commissionDetails[$i]['saleapproval'])?$commissionDetails[$i]['saleapproval']:"manual"?>
                                    </td>
									<td align="center" class="grid1">
										<?=($commissionDetails[$i]['salemail'])?$commissionDetails[$i]['salemail']:"manual"?>
                                    </td>
								   
								</tr>
								<tr><td colspan="6">&nbsp;</td></tr>
								
								<tr>
									<td colspan="6" class="tdhead" align="center" height="25" valign="middle" >
										<b>Recurring Sale Commission</b>
									</td>
								</tr>
								<tr>
									<td colspan="6" align="left" height="25">
										<? if($commissionDetails[$i]['recur_sale'] == '1') {  
										 echo "Recur Sale Commission by  ".$commissionDetails[$i]['recur_percentage']."&nbsp;percentage.&nbsp;&nbsp;&nbsp;&nbsp;Recur Every &nbsp;".$recur_percent_month_head." ".$commissionDetails[$i]['recur_period']." &nbsp;Month";
										} else { echo "Sale Commission is not Recurring"; } ?>
									</td>
								</tr>
								 <tr><td colspan="6" >&nbsp;</td></tr>
							</table>
						</td>
					</tr>
				   
					<?
					}  
			# END Multiple Commission Structure
			#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  				   
				?>
			</table>
		</td>
	</tr>
    <!--<tr><td height="20" >&nbsp;</td></tr>-->
</table>     
</form>
<?php
} else { ?>

<table border="0" cellpadding="0" cellspacing="0" width="95%" class="tablewbdr" align="center">
	<tr>
		<td  align="center"  height="50" class='textred' valign="bottom"> 
			Affiliate has not joined this Program 
		</td>
	</tr>
</table>

<?php } ?>
<br/><br/>                   
