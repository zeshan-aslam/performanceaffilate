<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  program_viewAffiliates.php                     */
/*     CREATED ON     :  09/SEP/2009                                    */

# View all affiliates registered for a selected program	 
# 	 
#	
/************************************************************************/

	if(empty($page)) $page	= $partners->getpage();	   # getting page no

	$sql_affiliates = "SELECT * FROM partners_joinpgm , partners_affiliate 
		WHERE joinpgm_programid='$programId' AND joinpgm_status not like('waiting') 
		AND affiliate_id = joinpgm_affiliateid ";
	$res_page = mysqli_query($con,$sql_affiliates);

	$_SESSION['SESS_TOTALCOUNT'] = mysqli_num_rows($res_page);
	$sql_affiliates .= " LIMIT ".($page-1)*$lines.",".$lines;
	$res_affiliates = mysqli_query($con,$sql_affiliates);
	$recordCount = mysqli_num_rows($res_affiliates);
	

?>

<table border="0" cellpadding="0" cellspacing="0" width="95%" class="tablewbdr" align="center">
	<tr>
		<td  align="right"  height="30" valign="middle"> 
			<b>Back to <a href="index.php?Act=programs&programId=<?=$programId?>" >program <?=$programDetails['url']?></a></b> 
		</td>
	</tr>
</table>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="60%" class="tablebdr">
    <tr class="tdhead" height="19">
        <td align="center"><b>Registered Affiliates for the program <?=$programDetails['url']?></b></td>
    </tr>
    <tr><td height="20" >&nbsp;</td></tr>
	<tr>
        <td width="100%" align="center">
        	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" >
				<?php
				if($recordCount > 0) {	?>
					<tr>
                    	<td align="left" class="tdhead" width="70%">&nbsp;&nbsp;Affiliate</td>
                        <td align="left" class="tdhead" width="30%">&nbsp;</td> 
                    </tr>
				<?php
					$i = 0;
					while($row_affiliates = mysqli_fetch_object($res_affiliates)) 
					{ 
						#$rowClass = ($i%2==0)?"":"grid1";
						?>
						<tr>
							<td align="left" class="<?=$rowClass?>" height="25" >&nbsp;&nbsp;
								<a href="#" onclick="viewAffiliateDetails(<?=$row_affiliates->affiliate_id?>)"><?=stripslashes($row_affiliates->affiliate_company)?></a>
                            </td>
							<td align="left" class="<?=$rowClass?>" height="25" >
                            	<a href="index.php?Act=programs&mode=ChangeCommission&amp;programId=<?=$programId?>&affiliateId=<?=$row_affiliates->affiliate_id?>" >Change Commission</a>
                            </td> 
						</tr>
						<?php
						$i++;
					}	?>
                    
                    <tr>
                        <td colspan="2" align="center" >
                            <? include '../includes/paging.php';  ?>	
                        </td>
                    </tr>
                                
                <?
				} else { ?>
                    <tr>
                        <td  align="center"  height="50" class='textred' valign="middle"> 
                            No Affiliates found!!!
                        </td>
                    </tr>
				<?php 
				}
				?>
			</table>
		</td>
	</tr>
    <!--<tr><td height="20" >&nbsp;</td></tr>-->
</table>     
<br/><br/>                   