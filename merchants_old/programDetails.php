<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  programDetails.php                             */
/*     CREATED ON     :  04/SEP/2009                                    */

/* 	Program Details Page.			 									*/
#	 
# 	 
#	
/************************************************************************/


	$sql 	= "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //To add to drop down box
	$result	= mysqli_query($con,$sql);


	switch ($programId) 
	{
		case '';    //all pgm
		   $sql =	"SELECT * from partners_joinpgm where joinpgm_merchantid='$MERCHANTID' " ;
		break;
		   
		default:    //selected pgm
			$sql = "SELECT * from partners_joinpgm where joinpgm_programid='$programId'";
			$_SESSION['PGMID'] = $programId;
		break;
	}
	
  $afftotal	=	GetTotalAffiliates($sql); //getting total affiliates,waiting affiliates,transactions
  $afftotal =	explode('~',$afftotal);

  $totallink =	GetLinks($programId,$MERCHANTID);       //getting advertising links
  $totallink =	explode('~',$totallink);


	if($msg == "saved")
		$msg = $lang_program_saved_successfully;
?>

<table border="0" cellpadding="0" cellspacing="0" width="70%" class="tablewbdr" align="center">
    <tr>
        <td align="center" height="1"><a href="index.php?Act=programs&mode=newprogram"> <b><?= $lpgm_CREATEPROGRAME ?></b></a></td>
    </tr>
    <tr>
        <td align="center" height="1"><? echo "<p align='center' > <span class='textred'>$msg</span></p>";?></td>
    </tr>
</table>

<form name="frm_program" method="post" action="" >
<table align="center" border="0" cellpadding="0" cellspacing="0" width="80%">
	<tr>
        <td>
        	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tablebdr" >
				<tr class="tdhead" height="19">
					<td width="60%" >
                    	<b><?=$lpgm_AffiliateProgram?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
                            <select name="programId" onchange="document.frm_program.action='index.php?Act=programs';document.frm_program.submit()">
                                <option value="" ><?=$lpgm_AllPrograms?></option>
                            	<? 
                            	while($row=mysqli_fetch_object($result)){
                                	if($programId=="$row->program_id")
                                    	$programName = "selected = 'selected'";
                                	else
                                    	$programName = "";
                            	?>
                                	<option <?=$programName?> value="<?=$row->program_id?>">
                                    <?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> 
                                	</option>
                            	<? } ?>
                            </select>
                  	</td>
					<td align="right" width="40%" class="textred" >					
						<? if($programId){ 
						 	echo $lang_Status." : ".ucwords($programDetails['status']);
						} ?>
					</td>
				</tr>
				<? if($programId){ ?>
                <tr class="grid1">
                  	<td colspan="2" align="right">
					 	<a href='index.php?Act=programs&amp;mode=editprogram&amp;programId=<?=$programId?>'><?=$lpgm_Edit?>&raquo;</a> 
                        <br/>
						<a href="index.php?Act=uploadProducts&amp;pgmid=<?=$programId?>"><?=$lang_upload_prd?>&raquo;</a>
						<br/>
						<a href='index.php?Act=programs&amp;mode=deleteprogram&amp;programId=<?=$programId?>' id="del" onclick="return del_onclick()"><?=$lpgm_Delete?>&raquo;</a>
					</td>
				</tr>
				<?php } ?>


                <tr>
                	<td colspan="2" >
                		<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
							<tr>
                                <td  height="45" width="50%" class="grid1" align="left">
                                	<b><a href="index.php?Act=listaffiliate&amp;pgmid=<?=($programId)?$programId:0?>">
                                	<?=$lpgm_RegisteredAffiliates?>&nbsp; -<?=$afftotal[0]?></a></b>
                                </td>
                                <td  height="45" width="50%" class="grid1" align="right">
                                    <b><a href="index.php?Act=waitingaff&amp;pgmid=<?=($programId)?$programId:0?>">
                                    <?=$lpgm_WaitingAffiliates?> -<?=$afftotal[1]?> </a></b>
                                </td>
							</tr>
                            
 							<tr>
                                <td colspan="2" height="45" align="center">
                                	<b><?=$lpgm_ProgramURL?></b>
                                    <br/><?=$programDetails['url']?><br/>
                                </td>
							</tr>
 
                            <tr>
                                <td align="center" colspan="2" height="15" class="grid1">
                                <b><?=$lpgm_Description?></b><br/></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2" height="81" class="grid1">
                                	<div style="width:50%; background:#FFFFFF; height:70px; text-align:left; border:thin solid #d9d9d9; overflow:auto;" align="center" >&nbsp;<?=nl2br($programDetails['description'])?></div>
                                </td>
                            </tr> 
						</table>
              		</td>
				</tr>
                
                <tr>
                	<td colspan="2" >
                    	<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
							<tr>
								<td align="center" colspan="6" height="25" valign="middle" ><b><?=$lpgm_Commissions?></b></td>
							</tr>  
                            <tr >
								<td align="center" class="tdhead" width="20%"><?=$lpgm_Type?></td>
								<td align="center" class="tdhead" width="20%"><?=$lpgm_Commissions?></td>
								<td align="center" class="tdhead" width="30%"><?=$lpgm_Approval?></td>
								<td align="center" class="tdhead" width="30%"><?=$lpgm_EmailSettings?></td>
							</tr>  
                            <tr>
                                <td align="left" >
                                <img alt="" border='0' height="10" src="../images/impression.gif" width="10" />&nbsp;-&nbsp;
                                <?=$lpgm_Impression?></td>
                                <td align="center" >
								<?=$currSymbol.$programDetails['impression_rate']?>&nbsp;/&nbsp;<?=($programDetails['impression_unit'])?$programDetails['impression_unit']:"1000"?>
                                </td>
                                <td align="center" >
									<?=($programDetails['imprapproval'])?$programDetails['imprapproval']:"manual"?>
                                </td>
                                <td align="center" >
									<?=($programDetails['imprmail'])?$programDetails['imprmail']:"manual"?>
                                </td>
                            </tr>                  
                            <tr>
                                <td class="grid1" align="left">
                                    <img border="0" height="10" src="../images/click.gif" width="10" alt="" />- <?=$lpgm_click?></td>
                                <td align="center"  class="grid1"><?=$currSymbol.$programDetails['click']?></td>
                                <td align="center"  class="grid1">
									<?=($programDetails['clickapproval'])?$programDetails['clickapproval']:"manual"?>
                                </td>
                                <td align="center"  class="grid1">
									<?=($programDetails['clickmail'])?$programDetails['clickmail']:"manual"?>
                                </td>
                            </tr>  
						</table>
              		</td>
				</tr>
                <tr><td colspan="2" >&nbsp;</td></tr>
                
			<?php
 			#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            #   For multiple Commission structure 
				$count = ($commissionDetails)?count($commissionDetails):1;
					for($i=1; $i<=$count; $i++) { 
						#$j = $i+1;
					?>
					<tr><td colspan="2" align="left" height="25" valign="middle" ><b><?=$lang_commission_structure.$i?></b></td></tr>
					<tr>
						<td colspan="2"  class="commissionTable" >
							<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
								<tr >
									<td align="center" class="tdhead" width="20%"><?=$lpgm_Type?></td>
									<td align="center" class="tdhead" width="10%"><?=$lang_report_from?></td>
									<td align="center" class="tdhead" width="10%"><?=$lang_report_to?></td>
									<td align="center" class="tdhead" width="20%"><?=$lpgm_Commissions?></td>
									<td align="center" class="tdhead" width="20%"><?=$lpgm_Approval?></td>
									<td align="center" class="tdhead" width="20%"><?=$lpgm_EmailSettings?></td>
								</tr>  
								<tr>
									<td  align="left" width="20%">
										<img border="0" height="10" src="../images/lead.gif" width="10" alt="" /> - <?=$lpgm_lead?></td>
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
										<img border="0" height="10" src="../images/sale.gif" width="10" alt="" /> - <?=$lpgm_sale?></td>
									<td align="center" class="grid1" ><?=$commissionDetails[$i]['sale_from']?></td>
									<td align="center" class="grid1" ><?=($commissionDetails[$i]['sale_to'])?$commissionDetails[$i]['sale_to']:$lang_value_above?></td>
									<td align="center"  class="grid1">
										<?=($commissionDetails[$i]['saletype']=="%")?$commissionDetails[$i]['saletype']:$currSymbol?><?=$commissionDetails[$i]['salerate']?>
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
										<b><?=$recur_commission_head?></b>
									</td>
								</tr>
								<tr>
									<td colspan="6" align="left" height="25">
										<? if($commissionDetails[$i]['recur_sale'] == '1') {  
										 echo $recur_sale_head." ".$commissionDetails[$i]['recur_percentage']." ".$recur_percent_month_head." ".$commissionDetails[$i]['recur_period']." ".$recur_months_head;
										} else { echo $recur_no_msg; } ?>
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

				   
				if(($programDetails['prgm_type'] == "0")){
					 $programDetails['prgm_fee']	= $program_fee;
					 $programDetails['prgm_value']	= $program_value;
					 $programDetails['prgm_type']	= $program_type;
				}
                if($programId and $programDetails['prgm_fee']){
                ?>
                <tr>
                    <td colspan="2" class="tdhead" align="center" height="25" valign="middle" ><b><?=$lpgm_programfees?></b></td>
                </tr>
                <tr>
                    <td  class="grid1" height="25" valign="middle"><?=$lpgm_programfees?> </td>
                    <td align="center" class="grid1"><?php echo $currSymbol.$programDetails['prgm_fee']?>	</td>
                </tr>
                <tr>
                    <td  class="grid1" height="25" valign="middle"><?=$lpgm_programtype?> </td>
                    <td align="center" class="grid1">
                        <?php
                        if($programDetails['prgm_type']==2){
                            echo "Recurring ( ".$programDetails['prgm_value'].") ";
                        }else echo "One-Time";
                        ?>					
                    </td>
                </tr> 
                <? } ?>

                <tr>
                	<td colspan="2" class="tdhead" align="center" height="25" valign="middle">
                    	<b><?=$lpgm_EmailandProgramSettings?></b>					
                	</td>
                </tr> 
                <tr>
                    <td colspan="2" height="22">						
                        <table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr" >
                            <tr>
                                <td class="2text" height="25" width="60%" align="left">
                                <?=$lpgm_Sendemailtoaffiliatewhentransactionappears?></td>
                                <td  class="2text" height="25" width="40%" align="left"> <?=$programDetails['mailaffiliate']?></td>
                        	</tr>
                            <tr>
                                <td  class="2text" height="25" ><?=$lpgm_Sendemailtomewhentransactionappears?></td>
                                <td  class="2text" height="25" ><?=$programDetails['mailmerchant']?></td>
                            </tr>
                            <tr>
                                <td  class="2text" height="25" ><?=$lpgm_AffiliateApproval?></td>
                                <td  class="2text" height="25" ><?=$programDetails['affiliateapproval']?></td>
                            </tr>
                            <tr>
                                <td  class="2text" height="25" ><?=$lpgm_OfferAvailable?></td>
                                <td  class="2text" height="25" >
                                <?=ucwords(strtolower(str_replace(",",", ",$programDetails['prgm_avail'])))?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
 
			<?php
			#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			# Display Advertising Links for the selected program
                if($programId){  	
				?>  
 				<tr>
                    <td width="25%" class="tdhead" align="center" colspan="2">
                    <b><?=$lpgm_AdvertisingLinks?></b>
                    </td>
                </tr>   
                
                <tr>
                    <td height="57" colspan="2" >
                        <table border="0" cellpadding="0"  width="100%" class="tablewbdr" cellspacing="0" align="center">
                        	<?php
                            $tot=$totallink[0]+$totallink[1]+$totallink[2]+$totallink[3]+$totallink[4];
                        
							if($tot==0){ ?>
								<tr>
                                    <td width="20%" align="center" class="textred"  colspan="6"  height="20">
										<?=$lpgm_NoLinksAddedtoThisProgram?>
                                        <br/>
                                        <a href="index.php?Act=addlinks" ><?=$lpgm_ClickHereToAddLinks?></a>
                                    </td>
								</tr>
								
							<?php } else { ?>
                                <tr>
                                    <td width="16%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_text"><?=$lpgm_Text?>-<?=$totallink[1]?></a>
                                    </td>
                                	<td width="24%" align="center" class="grid1" >
                                		<a href="index.php?Act=add_textnew"><?=$lpgm_temptext?>-<?=$totallink[5]?></a>
                                	</td>
                                    <td width="14%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_html"> <?=$lpgm_HTML?> -<?=$totallink[4]?></a>
                                    </td>
                                    <td width="18%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_banner"><?=$lpgm_Banner?>-<?=$totallink[0]?></a>
                                    </td>
                                    <td width="15%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_popup"><?=$lpgm_Popup?>-<?=$totallink[2]?></a>
                                    </td>
                                    <td width="13%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_flash"><?=$lpgm_Flash?>-<?=$totallink[3]?></a>
                                    </td>
                                </tr>
							<?
							}   
                        ?>
                        </table>
                    </td>
                </tr>
                <?php    
				}   
			# END Of Displaying Advertising Links for the selected program
			#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			?>        
                        
                        
                                        
			</table>
		</td>
	</tr>        
</table>
</form>

<script language="javascript" type="text/javascript">
	function del_onclick() {
		if(confirm("<?=$lpgm_DoyouWanttoDeleteThisProgram?>")){
			return true;
		}
		else{
			return false;
		}
	}
</script>