<?php

/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  programDetails.php                             */
/*     CREATED ON     :  09/SEP/2009                                    */

/* 	Program Details Page.			 									*/
#	 
# 	 
#	
/************************************************************************/



?>


<table border="0" cellpadding="0" cellspacing="0" width="70%" class="tablewbdr" align="center">
    <tr>
        <td align="center" height="1"><? echo "<p align='center' > <span class='textred'>$msg</span></p>";?></td>
    </tr>
	<?php if(!empty($trans_msg)) { ?>
	<tr>
		<td  align="center"  height="20" class='textred'> 
			<b><?=$trans_msg?></b> 
		</td>
	</tr>
	<? } ?>
</table>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="80%">
	<tr>
        <td>
        	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tablebdr" >
            	<tr class="tdhead" height="19">
					<td width="60%" >
                    	<form name="frm_program" method="post" action="" >
                    		<b>Programs&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
                            <select name="programId" onchange="document.frm_program.action='index.php?Act=programs';document.frm_program.submit()">
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
                        </form>
                  	</td>
					<td align="right" width="40%"  >					
							<? if($userobj->GetAdminUserLink('Approve/Reject Programs',$adminUserId,3)) { ?> 
                                &laquo;&nbsp;<?
                                if($programDetails['status']=="active"){
                               ?>
                                    <a href="index.php?Act=programs&mode=changeStatus&pgmstatus=Reject&amp;programId=<?=$programId?>">Reject</a>
                               <?
                               }else{
                               ?>
                                    <a href="index.php?Act=programs&mode=changeStatus&pgmstatus=Approve&amp;programId=<?=$programId?>">Approve</a>
                               <?
                               }  ?>  &raquo;&nbsp; <?
                            }  
                            if($userobj->GetAdminUserLink('Change Product Status',$adminUserId,3)) { 
                                ?>
                                &laquo;&nbsp;<a href="index.php?Act=products&amp;pgmid=<?=$programId?>">Products</a>
                                &raquo;&nbsp;
                            <? }  ?>		 
					</td>
				</tr>



				<tr>
                	<td colspan="2" >
                		<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
							<tr>
                                <td  height="45" width="50%" class="grid1" align="left">&nbsp;
                                	<b><?php if($afftotal[0]){?><a href="index.php?Act=programs&mode=viewAffiliates&amp;programId=<?=$programId?>" ><?php } ?>
                                    	Registered Affiliates&nbsp;-&nbsp;<?=$afftotal[0]?>
                                    <?php if($afftotal[0]){?></a><?php } ?></b>
                                </td>
                                <td  height="45" width="50%" class="grid1" align="right">
                                    <b><a href="#" onclick="viewLink('<?=$programDetails['merchantId']?>')">Merchant Details </a>&nbsp;</b>
                                </td>
							</tr>
                            
 							<tr>
                                <td colspan="2" height="45" align="center">
                                	<b>Program Title</b>
                                    <br/><?=$programDetails['url']?><br/>
                                </td>
							</tr>
 
                            <tr>
                                <td align="center" colspan="2" height="15" class="grid1">
                                <b>Description</b><br/></td>
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
								<td align="center" colspan="6" height="25" valign="middle" ><b>Commissions</b></td>
							</tr>  
                            <tr >
								<td align="center" class="tdhead" width="20%">Type</td>
								<td align="center" class="tdhead" width="20%">Commissions</td>
								<td align="center" class="tdhead" width="30%">Approval</td>
								<td align="center" class="tdhead" width="30%">Email Settings</td>
							</tr>  
                            <tr>
                                <td align="left" >
                                <img alt="" border='0' height="10" src="../images/impression.gif" width="10" />&nbsp;-&nbsp;Impression</td>
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
                                    <img border="0" height="10" src="../images/click.gif" width="10" alt="" />- Click</td>
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
					<tr><td colspan="2" align="left" height="25" valign="middle" ><b>Commission Structure&nbsp;<?=$i?></b></td></tr>
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
										<img border="0" height="10" src="../images/lead.gif" width="10" alt="" /> - Lead</td>
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
										<img border="0" height="10" src="../images/sale.gif" width="10" alt="" /> - Sale</td>
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
  				   
				if(($programDetails['prgm_type'] == "0")){
					 $programDetails['prgm_fee']	= $program_fee;
					 $programDetails['prgm_value']	= $program_value;
					 $programDetails['prgm_type']	= $program_type;
				}
                  
					?>
                    <tr>
                        <td colspan="2" class="tdhead" ><p align="center"><b>Program Fee</b></p></td>
                    </tr>
                    <tr>
                      	<td colspan="2">&nbsp;</td>
                    </tr>
					<tr>
						<td colspan="2">
                        
                            <form name="typeupdate" method="post" action="index.php?Act=programs&mode=program_fee&programId=<?=$programId?>">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" colspan="2" >Program Fee</td>
                                    <td width="48%"  colspan="1" align="left" bgcolor="#ffffff" >
                                        <b><?=$currSymbol?></b>
                                        <input type="text" name="prgm_fee" size="6" value="<?=$programDetails['prgm_fee']?>" tabindex="1" />																
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff" colspan="2" >Program Type</td>
                                    <td  colspan="1" align="left" bgcolor="#ffffff" >
                                        <input name="programtype" type="radio" value="1" class="bdrless" <?php echo ($programDetails['prgm_type']==1)? "checked='checked'":''?> onclick="displayDiv()" /><b>One-Time</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff" colspan="2" ></td>
                                    <td colspan="1" align="left" bgcolor="#ffffff" >
                                        <input name="programtype" type="radio" value="2" class="bdrless" <?php echo ($programDetails['prgm_type']==2)? "checked='checked'":''?> onclick="displayDiv()" /><b>Recurring</b>
                                        <?  list($recur_value,$recur_period) =explode(" ",trim($programDetails['prgm_value']))  ?>
                                        <div style="visibility:hidden" id="Recur">																	<b> Recurring Period</b>
                                            <input name="recur_value" type="text" value="<?php echo $recur_value?>" size="3" />
                                            &nbsp;
                                            <select size="1" name="recur_period">
                                                <option value="day" <?php echo ($recur_period=="day")? "selected='selected'":''?>>Day(s)</option>
                                                <option value="month" <?php echo ($recur_period=="month")? "selected='selected'":''?>>Month(s)</option>
                                                <option value="year"  <?php echo ($recur_period=="year")? "selected='selected'":''?>>Year(s)</option>
                                            </select>
                                        </div>
                                        <script language="javascript" type="text/javascript">
                                          for (i=0; i < document.typeupdate.elements.length; i++){
                                            if(document.typeupdate.elements[i].checked == true){
                                                if((document.typeupdate.elements[i].value)==2)
                                                   document.getElementById("Recur").style.visibility = "visible";
                                                else
                                                    document.getElementById("Recur").style.visibility = "hidden";
                                            }
                                          }
                                        </script>														      
                                    </td>
                                    <td width="23%" rowspan="2" align="center" valign="top">
                                       <? if($userobj->GetAdminUserLink('Edit Program Fee',$adminUserId,3)) { ?> 
                                        <input type="submit" value="Edit Program Fee" />
                                       <? } ?>
                                    </td>
                                </tr>
                            </table>
                            </form>
                    	</td>
                  	</tr> 
                    <tr>
                      	<td colspan="2">&nbsp;</td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td colspan="2" class="tdhead" ><p align="center"><b>Email and Program Settings</b></p></td>
                    </tr>
                    <tr>
                      	<td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" height="85">
                            <div align="center">
                                <center>
                                <table border='0' cellpadding="2" cellspacing="0" width="100%" class="hdbdr" >
                                    <tr>
                                        <td bgcolor="#ffffff" class="2text" height="19" width="358" align="left">
                                                 <span class="2text">Send email to affiliate when transaction appears
                                                 </span><font face="Arial, Helvetica, sans-serif">
                                                 <span class="2text">: </span></font></td>
                                        <td bgcolor="#ffffff" class="2text" height="19"  width="242" align="left">
                                                <div align="left"><span class="2text"><b><?=$programDetails['mailaffiliate']?></b></span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                            <td bgcolor="#ffffff" class="2text" height="19" width="358" align="left">
                                                <span class="2text">Send email to me when transaction appears</span></td>
                                            <td bgcolor="#ffffff" class="2text" height="19" width="242" align="left">
                                                <span class="2text"><b><?=$programDetails['mailmerchant']?></b></span></td>
                                    </tr>
                                    <tr>
                                            <td bgcolor="#ffffff" class="2text" height="19"  align="left">Affiliate Approval</td>
                                            <td bgcolor="#ffffff" class="2text" height="19"  align="left">
                                            <font face="Arial, Helvetica, sans-serif"><span class="2text"><b><?=$programDetails['affiliateapproval']?></b></span></font>
                                            </td>
                                    </tr>
                                </table>
                                </center>
                            </div>
                        </td>
                    </tr>                                      
                    <tr>
                      	<td colspan="2">&nbsp;</td>
                    </tr>
                    
 
                    <tr>
                        <td colspan="2" height="12" class="tdhead"><b>Change Transaction Amounts</b></td>
                    </tr>
                    
                    <form name="adminTrans" action="index.php?Act=programs&mode=admin_payments" method="post">
                    <input type="hidden" name="programId" value="<?=$programId?>" />
                    <?php
                    ?>
                    <tr>
                        <td height="26" colspan="2" width="100%" >
                            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="4%" >&nbsp;</td>
                                    <td width="30%" align="left">Impression Rate</td>
                                    <td width="16%" align="left">
                                        <input type="text" name="imprate" size="6" value="<?=$programDetails['admin_impr']?>"  />&nbsp;<?=$currSymbol?>
                                    </td>
                                    <td width="50%" align="left">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                   
                    <tr>
                        <td height="26"  colspan="3" width="100%" >
                            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="4%" >&nbsp;</td>
                                    <td width="30%" align="left"  >Click Rate</td>
                                    <td width="16%" align="left" >
                                        <input type="text" name="click" size="6" value="<?=$programDetails['admin_click']?>" />
                                    </td>
                                    <td width="50%" align="left"   >
                                        <input name="rad_click_type" type="radio" value="$" <?=($programDetails['admin_clicktype']!="%")?"checked='checked'":""?> /><?=$currSymbol?>
                                        <input name="rad_click_type" type="radio" value="%" <?=($programDetails['admin_clicktype']=="%")?"checked='checked'":""?> />%
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td height="26" colspan="3" width="100%">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="4%" >&nbsp;</td>
                                    <td width="30%" align="left">Lead Rate</td>
                                    <td width="16%" align="left">
                                        <input type="text" name="lead" size="6" value="<?=$programDetails['admin_lead']?>"  />
                                    </td>
                                    <td width="50%" align="left">
                                        <input name="rad_lead_type" type="radio" value="$" <?=($programDetails['admin_leadtype']!="%")?"checked='checked'":""?> /><?=$currSymbol?>
                                        <input name="rad_lead_type" type="radio" value="%" <?=($programDetails['admin_leadtype']=="%")?"checked='checked'":""?> />%
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td height="26" colspan="3" width="100%">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="4%" >&nbsp;</td>
                                    <td width="30%" align="left">Sale Rate&nbsp;</td>
                                    <td width="16%" align="left">
                                        <input type="text" name="sale" size="6" value="<?=$programDetails['admin_sale']?>"  />
                                    </td>
                                    <td width="50%" align="left">
                                        <input name="rad_sale_type" type="radio" value="$" <?=($programDetails['admin_saletype']!="%")?"checked='checked'":""?>  /><?=$currSymbol?>
                                        <input name="rad_sale_type" type="radio" value="%" <?=($programDetails['admin_saletype']=="%")?"checked='checked'":""?> />%
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="4" height="30" valign="bottom" >
                            <input type="submit" name="action" value="Modify Transaction Rates" />
                        </td>
                    </tr>
                    </form>
                    <tr>
                        <td colspan="2" height="12">&nbsp;</td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td colspan="2" height="57">
                            <table border='0' cellpadding="2" cellspacing="0" width="100%"  class="hdbdr" >
                                 <tr>
                                    <td bgcolor="#ffffff" height="15">
                                        <div align="center">&nbsp;
                                        <table border='0' cellpadding="0"  width="100%" class="hdbdr" cellspacing="0">
                                            <tr>
                                                <td width="100%" class="tdhead " align="center" colspan="6"><p align="center"><b>Advertising Links</b></p></td>
                                            </tr>
                        
											<?
                                            $tot=$totallink[0]+$totallink[1]+$totallink[2]+$totallink[3]+$totallink[4];
                                            if($tot==0){
                                            ?>  
                                            <tr>
                                                <td height="20" width="20%" align="center" class="textred"  colspan="6" >No Links Added to This Program</td>
                                            </tr>
											<?
                                            }else{
                                            ?>
                                            <tr>
                                                <td width="15%" align="center" class="grid1" ><a href="index.php?Act=add_text1&amp;programid=<?=$programId?>">Text - <?=$totallink[1]?></a></td>
                                                <td width="27%" align="center" class="grid1" ><a href="index.php?Act=add_text&amp;programid=<?=$programId?>">Template Text - <?=$totallink[5]?></a></td>
                                                <td width="14%" align="center"class="grid1"  ><a href="index.php?Act=add_html&amp;programid=<?=$programId?>">HTML - <?=$totallink[4]?></a></td>
                                                <td width="16%" align="center" class="grid1" ><a href="index.php?Act=add_banner&amp;programid=<?=$programId?>">Banner -<?=$totallink[0]?></a></td>
                                                <td width="15%" align="center" class="grid1" ><a href="index.php?Act=add_popup&amp;programid=<?=$programId?>">Popup - <?=$totallink[2]?></a></td>
                                                <td width="15%" align="center" class="grid1" ><a href="index.php?Act=add_flash&amp;programid=<?=$programId?>">Flash - <?=$totallink[3]?></a></td>
                                            </tr>																
											<?
                                             }  //// else close
                                            ?>
                        
                                        </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" height="12">&nbsp;</td>
                    </tr>
                    
			</table>
		</td>
	</tr>        
</table>

    
