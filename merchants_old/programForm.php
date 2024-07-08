<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  programForm.php                            	*/
/*     CREATED ON     :  04/SEP/2009                                    */

/* 	Program Form for Add and Edit.			 							*/
/************************************************************************/

	if($message == "empty")
		$msg = $lpgm_error1;
	else if($message == "amount")
		$msg = $lpgm_error8;
	else if($message == "recurpercent")	
		$msg = $err_enterRecurPercent;
	else if($message == "recurPeriod")
		$msg = $err_enterRecurperiod;
	else if($message == "invalidrecurPeriod")	
		$msg = $err_validRecurPeriod;
	else if($message == "empty_lead")
		$msg = $lang_commission_lead_allvalues;
	else if($message == "invalid_range")	
		$msg = $lang_commission_enter_valid_rage;
	else if($message == "empty_sale")
		$msg = $lang_commission_sale_allvalues;
	else if($message == "atleast_one")	
		$msg = $lang_commission_atleast_one_amount;

?>

<?php if($msg) { 
	echo "<p align='center' > <span class='textred'>$msg</span></p>";
} ?>

<script language="javascript" >
    /*--------------------------------------------------------------------------
    Description   :- function to allow only Numeric values in a textbox.
        Called in the onKeyPress event.
    Programmer    :- SMA
    Last Modified :- 18/MAY/2006
    --------------------------------------------------------------------------*/
 	function CheckNumeric(e)
	{
		var key;
		var keychar;
	
		if (window.event)
		key = window.event.keyCode;
		else if (e)
			key = e.which;
		else
			return true;
	
		keychar = String.fromCharCode(key);
		keychar = keychar.toLowerCase();
	
		if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
			return true;
		else if ((("0123456789.").indexOf(keychar) > -1))
			return true;
		else {
			alert('<?=$js_numeric_value?>');
			return false;
		}
		return true;
	}
 
    /*--------------------------------------------------------------------------
    Description   :- function to validate the Recurring Period.
    Programmer    :- SMA
    Last Modified :- 27/JUNE/2006
    --------------------------------------------------------------------------*/
		function CheckRecurringPeriod()
		{
			var count = document.frm_program.commissionCount.value;
			for(i=1; i<=count; i++) {
				var recursale = 'chk_recursale_'+i;  
				var recurpercent = 'txt_recurpercent_'+i;
				var recurperiod = 'cmb_recurperiod_'+i;
				
				if(document.getElementById(recursale).checked == true)
				{
					if(document.getElementById(recurpercent).value == '' || document.getElementById(recurpercent).value == '0')
					{
						alert('<?=$err_enterRecurPercent?>');
						document.getElementById(recurpercent).focus();
						return false;
					}
					if(document.getElementById(recurperiod).value == '')
					{
						alert('<?=$err_enterRecurperiod?>');
						document.getElementById(recurperiod).focus();
						return false;
					}
					if(document.getElementById(recurperiod).value == '0')
					{
						alert('<?=$err_validRecurPeriod?>');
						document.getElementById(recurperiod).focus();
						return false;
					}
				}
			}
			document.frm_program.submit(); 
		}
		

// Set the next From Value for Sale or Leas Commission
	function setNextFromValue(source, destination)
	{   
		var quantity = document.getElementById(source).value;
		if(document.getElementById(destination) && quantity)
			document.getElementById(destination).value = parseInt(quantity)+1;
		return true;
	}
		
	
	function deleteCommission()
	{
		if(confirm('<?=$lang_Confirm_delete_Commission?>')) 
		{
			document.frm_program.action='index.php?Act=programs&mode=DeleteCommission#TBL_Commission'; 
			document.frm_program.submit(); 
		}
		else
			return false;
	}	
		
</script>

<form method="post" action="index.php?Act=programs&mode=submitprogram" name="frm_program" id="frm_program">

<input type="hidden" name="programId" id="programId" value="<?=$programId?>" />
<table border="0" cellpadding="0" cellspacing="0" width="90%" class="tablebdr" align="center">
    <tr>
      	<td width="100%"  height="19" class="tdhead" align="center"><b> <?=($programId)?$lpgm_ProgramEditor:$lpgm_NewProgram?></b></td>
    </tr>
    <tr>
      	<td width="100%" height="19" ></td>
    </tr>
	
    <!-- Program Name, Description -->
    <tr>
    	<td align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="72%" id="AutoNumber1" class="tablebdr">
                <tr>
                	<td height="17" colspan="5" >&nbsp;</td>
                </tr>
                <tr>
                    <td width="24%" height="39" align="right"><?= $lpgm_ProgramURL?> </td>
                    <td width="5%" >&nbsp;</td>
                    <td width="58%" height="39" align="left">
                    	<input type="text" name="url" size="48" id="url" value="<?=$programDetails['url']?>" /></td>
                </tr>
                <tr>
                    <td width="24%" height="19"  align="right" valign="top"><?= $lpgm_Description?></td>
                    <td width="5%" >&nbsp;</td>
                    <td height="19" colspan="2"  align="left">
                    	<textarea rows="3" name="description" cols="47"><?=$programDetails['description']?></textarea>
                   	</td>
                </tr>
            	<tr><td  colspan="5" >&nbsp;</td></tr>
            </table>        
        </td>
    </tr>
	
   <!-- Commission and Settings for Impression and Click --> 
    <tr>
    	<td align="center">
      		<table border="0" cellpadding="0" cellspacing="0"  width="100%"  class="tablebdr">
                <tr>
                    <td colspan="7" height="19" align="center" class="tdhead"><b><?=$lpgm_Commissions?></b></td>
                </tr>
                <tr>
                    <td width="35%" height="19" align="left" class="tdhead">&nbsp;<b><?=$lpgm_Type?></b></td>
                    <td width="20%" align="left" class="tdhead"><b><?=$lpgm_Commissions?></b></td>
                    <td width="15%" height="19" align="center" class="tdhead"><b><?=$lpgm_Geo_Targeting?></b></td>
                    <td height="15%" align="center" class="tdhead" colspan="2"><b><?=$lpgm_Approval?></b></td>
                    <td height="15%" align="center" class="tdhead" colspan="2" ><b><?=$lpgm_EmailSettings?></b></td>
                </tr>

                <tr>
                    <td height="21" align="left" rowspan="2" >&nbsp;<?=$lpgm_Impression?></td>
                    <td align="left" rowspan="2" >
                    	<input type="text" name="impression" size="8" value="<?=($programDetails['impression_rate'])?$programDetails['impression_rate']:0?>" onkeypress="return CheckNumeric(event);"  />
                     	<?=$currSymbol?>&nbsp;<?=$lpgm_perImpression?>&nbsp;
                        <input type="text" name="impressionunit" size="4" value="<? if($programDetails['impression_unit']!=''){echo $programDetails['impression_unit'];}else{ echo '1000';}?>" onkeypress="return CheckNumeric(event);"  />
                    </td>
                    <td height="21" align="center" rowspan="2" >
                    	<input name="chk_geo_impression" type="checkbox" value="1" <?=($programDetails['geo_impression'])?"checked='checked'":""?> />
                    </td>
                    <td align="left" ><?=$lpgm_Automatic?></td>
                    <td height="18" align="left" >
                    	<input type="radio" value="automatic" name="impr_approval" <?=($programDetails['imprapproval']=="automatic")?"checked='checked'":""?> />
                    </td>
                    <td height="19" align="left" ><?=$lpgm_Automatic?></td>
                    <td height="19" align="left" >
                    	<input type="radio" value="automatic" name="impr_email" <?=($programDetails['imprmail']=="automatic")?"checked='checked'":""?> />
                    </td>
                </tr>
                <tr>
                    <td align="left" ><?=$lpgm_Manually?></td>
                    <td height="20" align="left" >
                    	<input type="radio" name="impr_approval" value="manual" <?=($programDetails['imprapproval']!="automatic")?"checked='checked'":""?> />
                    </td>
                    <td height="21" align="left" ><?=$lpgm_Manually?></td>
                    <td height="21" align="left" >
                    	<input type="radio" value="manual" name="impr_email" <?=($programDetails['imprmail']!="automatic")?"checked='checked'":""?>  />
                    </td>
                </tr>

                <tr>
                    <td height="21" align="left" rowspan="2" class="grid1" >&nbsp;<?=$lpgm_Click?></td>
                    <td align="left" rowspan="2" class="grid1" >
                    	<input type="text" name="click" size="8" value="<?=($programDetails['click'])?$programDetails['click']:0?>" onkeypress="return CheckNumeric(event);"  /> <?=$currSymbol?>
                    </td>
                    <td height="21" align="center" rowspan="2" class="grid1" >
                    	<input name="chk_geo_click" type="checkbox" value="1" <?=($programDetails['geo_click'])?"checked='checked'":""?>  />
                    </td>
                    <td align="left" class="grid1" ><?=$lpgm_Automatic?></td>
                    <td height="18" align="left" class="grid1" >
                    	<input type="radio" value="automatic" name="click_approval" <?=($programDetails['clickapproval']=="automatic")?"checked='checked'":""?> />
                    </td>
                    <td height="19" align="left" class="grid1" ><?=$lpgm_Automatic?></td>
                    <td height="19" align="left" class="grid1" >
                    	<input type="radio" value="automatic" name="click_email" <?=($programDetails['clickmail']=="automatic")?"checked='checked'":""?> />
                    </td>
                </tr>
                <tr>
                    <td align="left" class="grid1" ><?=$lpgm_Manually?></td>
                    <td height="20" align="left" class="grid1" >
                    	<input type="radio" name="click_approval" value="manual" <?=($programDetails['clickapproval']!="automatic")?"checked='checked'":""?>  />
                    </td>
                    <td height="21" align="left" class="grid1" ><?=$lpgm_Manually?></td>
                    <td height="21" align="left" class="grid1" >
                    	<input type="radio" value="manual" name="click_email" <?=($programDetails['clickmail']!="automatic")?"checked='checked'":""?>  />
                    </td>
                </tr>
			</table>
		</td>
	</tr>                  
    
   <!-- Multiple Commission Structure for Lead and Sale --> 
    <?php
    $commissionCount = ($commissionCount)?$commissionCount:1;      

	?>

    <input type="hidden" name="commissionCount" value="<?=$commissionCount?>" />
    <tr>
    	<td align="center" height="30" valign="middle" >
        	<a id="TBL_Commission"></a>
        	<?php if($commissionCount < 5) { ?>
                <input type="button" name="AddCommission" value="Add New Flexible Commission" onclick="javascript: document.frm_program.commissionCount.value=<?=$commissionCount+1?>; document.frm_program.action='index.php?Act=programs&mode=addcommission#TBL_Commission_<?=$commissionCount?>'; document.frm_program.submit();" class="button" />
            <?php } ?>
        </td>
    </tr>
    <?php
	for($i=1; $i<=$commissionCount; $i++) { 
	?>        
    <tr>
    	<td align="center"  class="commissionTable" >
      		<table border="0" cellpadding="0" cellspacing="0"  width="100%"  class="tablebdr">
                <input type="hidden" name="commissionId_<?=$i?>" id="commissionId_<?=$i?>" value="<?=$commissionDetails[$i]['commissionId']?>" />
                <tr>
                    <td colspan="9" height="19" align="left" class="tdhead">
                    	<table cellpadding="0" cellspacing="0" width="100%" align="center" >
                        	<tr>
                            	<td align="left" width="50%" ><b><?=$lang_commission_structure.$i?></b></td>
                                <td align="right" width="50%" style="padding-right:20px;" >
                                	<?php if($i==$commissionCount and $i>1) { ?>
                                    	<input type="button" name="DeleteCommission" value="Delete Commission" onclick="javascript: deleteCommission();" class="button"  />
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="10%" height="19" align="center" class="tdhead"><b><?=$lang_report_from?></b></td>
                    <td width="10%" height="19" align="center" class="tdhead"><b><?=$lang_report_to?></b></td>
                    <td width="15%" height="19" align="left" class="tdhead"><b><?=$lpgm_Type?></b></td>
                    <td width="20%" align="left" class="tdhead"><b><?=$lpgm_Commissions?></b></td>
                    <td width="15%" height="19" align="center" class="tdhead"><b><?=$lpgm_Geo_Targeting?></b></td>
                    <td height="15%" align="center" class="tdhead" colspan="2"><b><?=$lpgm_Approval?></b></td>
                    <td height="15%" align="center" class="tdhead" colspan="2" ><b><?=$lpgm_EmailSettings?></b></td>
                </tr>

                <!-- Lead Commission -->
                <tr>
                    <td height="19" align="center" rowspan="2" >
                    	<input type="text" name="lead_from_<?=$i?>" id="lead_from_<?=$i?>" size="8" value="<?=($i==1)?"1":$commissionDetails[$i]['lead_from']?>" onkeypress="return CheckNumeric(event);" readonly="readonly"  />
                    </td>
                    <td height="19" align="center" rowspan="2" >
                    	<input type="text" name="lead_to_<?=$i?>" id="lead_to_<?=$i?>" size="8" value="<?=$commissionDetails[$i]['lead_to']?>" onkeypress="return CheckNumeric(event);" <?php if($i<$commissionCount) { ?> onchange="javscript: return setNextFromValue('lead_to_<?=$i?>', 'lead_from_<?=$i+1?>');" <?php } ?> />
                    </td>
                    <td height="21" align="left" rowspan="2" ><?=$lpgm_Lead?></td>
                    <td align="left" rowspan="2" >
                    	<input type="text" name="lead_<?=$i?>" size="8" value="<?=($commissionDetails[$i]['leadrate'])?$commissionDetails[$i]['leadrate']:0?>" onkeypress="return CheckNumeric(event);"  /><?=$currSymbol?>
                    </td>
                    <td height="21" align="center" rowspan="2" >
                    	<input name="chk_geo_lead_<?=$i?>" type="checkbox" value="1" <?=($commissionDetails[$i]['geo_lead'])?"checked='checked'":""?>   />
                    </td>
                    <td align="left" ><?=$lpgm_Automatic?></td>
                    <td height="18" align="left" >
                    	<input type="radio" name="lead_approval_<?=$i?>" value="automatic" <?=($commissionDetails[$i]['leadapproval']=="automatic")?"checked='checked'":""?>  />
                    </td>
                    <td height="19" align="left" ><?=$lpgm_Automatic?></td>
                    <td height="19" align="left" >
                    	<input type="radio" name="lead_email_<?=$i?>" value="automatic" <?=($commissionDetails[$i]['leadmail']=="automatic")?"checked='checked'":""?> />
                    </td>
                </tr>
                <tr>
                    <td align="left" ><?=$lpgm_Manually?></td>
                    <td height="20" align="left" >
                    	<input type="radio" name="lead_approval_<?=$i?>" value="manual" <?=($commissionDetails[$i]['leadapproval']!="automatic")?"checked='checked'":""?> />
                    </td>
                    <td height="21" align="left" ><?=$lpgm_Manually?></td>
                    <td height="21" align="left" >
                    	<input type="radio" name="lead_email_<?=$i?>" value="manual" <?=($commissionDetails[$i]['leadmail']!="automatic")?"checked='checked'":""?>  />
                    </td>
                </tr>
                
                <!-- Sale Commission -->
                <tr>
                    <td height="19" align="center" rowspan="2" class="grid1" >
                    	<input type="text" name="sale_from_<?=$i?>" id="sale_from_<?=$i?>" size="8" value="<?=($i==1)?"1":$commissionDetails[$i]['sale_from']?>" onkeypress="return CheckNumeric(event);" readonly="readonly"  />
                    </td>
                    <td height="19" align="center" rowspan="2" class="grid1" >
                    	<input type="text" name="sale_to_<?=$i?>" id="sale_to_<?=$i?>" size="8" value="<?=$commissionDetails[$i]['sale_to']?>" onkeypress="return CheckNumeric(event);" <?php if($i<$commissionCount) { ?> onchange="javscript: return setNextFromValue('sale_to_<?=$i?>', 'sale_from_<?=$i+1?>');" <?php } ?>  />
                    </td>
                    <td height="21" align="left" rowspan="2" class="grid1" ><?=$lpgm_Sale?></td>
                    <td align="left" rowspan="2" class="grid1" >
                    	<input type="text" name="sale_<?=$i?>" size="8" value="<?=($commissionDetails[$i]['salerate'])?$commissionDetails[$i]['salerate']:0?>" onkeypress="return CheckNumeric(event);"  /> 
                         
                        <select size="1" name="saletype1_<?=$i?>" >
                            <option value="$" <?=($commissionDetails[$i]['saletype']!="%")?"selected='selected'":""?> ><?=$currSymbol?></option>
                            <option value="%" <?=($commissionDetails[$i]['saletype']=="%")?"selected='selected'":""?> >%</option>
                        </select>
                    </td>
                    <td height="21" align="center" rowspan="2" class="grid1" >
                    	<input name="chk_geo_sale_<?=$i?>" type="checkbox" value="1" <?=($commissionDetails[$i]['geo_sale'])?"checked='checked'":""?>  />
                    </td>
                    <td align="left" class="grid1" ><?=$lpgm_Automatic?></td>
                    <td height="18" align="left" class="grid1" >
                    	<input type="radio" name="sale_approval_<?=$i?>" value="automatic" <?=($commissionDetails[$i]['saleapproval']=="automatic")?"checked='checked'":""?> />
                    </td>
                    <td height="19" align="left" class="grid1" ><?=$lpgm_Automatic?></td>
                    <td height="19" align="left" class="grid1" >
                    	<input type="radio" name="sale_email_<?=$i?>" value="automatic" <?=($commissionDetails[$i]['salemail']=="automatic")?"checked='checked'":""?> />
                    </td>
                </tr>
                <tr>
                    <td align="left" class="grid1" ><?=$lpgm_Manually?></td>
                    <td height="20" align="left" class="grid1" >
                    	<input type="radio" name="sale_approval_<?=$i?>" value="manual" <?=($commissionDetails[$i]['saleapproval']!="automatic")?"checked='checked'":""?> />
                    </td>
                    <td height="21" align="left" class="grid1" ><?=$lpgm_Manually?></td>
                    <td height="21" align="left" class="grid1" >
                    	<input type="radio" name="sale_email_<?=$i?>" value="manual" <?=($commissionDetails[$i]['salemail']!="automatic")?"checked='checked'":""?> />
                    </td>
                </tr>
                
				<!-- Recurring Sale Commission -->
                <tr>
                  	<td height="10" align="center" colspan="9">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="9" >
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="5" height="26" align="center" >&nbsp;</td>
                                <td align="left">&nbsp;<b><?=$recur_commission_head?></b></td>
                            </tr>
                            <tr>
                                <td width="5" height="26" align="center" >&nbsp;</td>
                                <td align="left">&nbsp;
                                    <input type="checkbox" name="chk_recursale_<?=$i?>" id="chk_recursale_<?=$i?>" <? if($commissionDetails[$i]['recur_sale']) echo "checked='checked'"; ?> value="1" />&nbsp;<?=$recur_sale_head?>
                                    
                                    <input type="text" name="txt_recurpercent_<?=$i?>" id="txt_recurpercent_<?=$i?>" value="<?=$commissionDetails[$i]['recur_percentage']?>" maxlength="3" onkeypress="return CheckNumeric(event);"   style="width:40px;" />&nbsp;<?=$recur_percent_month_head?>&nbsp;
                                    
                                    <input type="text" name="cmb_recurperiod_<?=$i?>" id="cmb_recurperiod_<?=$i?>" value="<?=$commissionDetails[$i]['recur_period']?>" maxlength="2" onkeypress="return CheckNumeric(event);" style="width:40px;" />&nbsp;<?=$recur_months_head?>
                                </td><!-- onKeyPress="CheckNumeric();"onkeydown="CheckNumeric(event); onkeydown="CheckNumeric(event);" onkeyup="CheckNumeric(event);"" onkeyup="CheckNumeric(event);" -->
                            </tr>
                        </table>
                    </td>
                </tr>	

			</table>
		</td>
	</tr> 
    <tr><td height="10" ><a id="TBL_Commission_<?=$i?>"></a></td></tr>                 
	<?php
		if($i>1){ 
	?>
		<script language="javascript">
			setNextFromValue('lead_to_<?=$i-1?>', 'lead_from_<?=$i?>');
			setNextFromValue('sale_to_<?=$i-1?>', 'sale_from_<?=$i?>');
        </script>
	<?php } 
	}
	?>


    <tr>
    	<td height="20" align="center" ></td>
    </tr>
    
    <!-- Email Settings for Affiliate and Merchant -->
    <tr>
    	<td >
       		<table border="0" cellpadding="0" cellspacing="0"  width="100%" >
                <tr>
                    <td height="19" align="center" class="grid1" width="10%" >&nbsp;</td>
                    <td height="19" align="left" class="grid1" width="90%" >
                    	<input type="checkbox" name="mailaffil" value="yes" <?=($programDetails['mailaffiliate']=="yes")?"checked='checked'":""?> />
                        &nbsp;&nbsp;&nbsp;
                        <?= $lpgm_Sendemailtoaffiliatewhentransactionappears ?>          
                    </td>
                </tr>
                <tr>
                    <td height="19" align="center" class="grid1" >&nbsp;</td>
                    <td height="19" align="left" class="grid1" >
                        <input type="checkbox" name="mailme" value="yes" <?=($programDetails['mailmerchant']=="yes")?"checked='checked'":""?> />
                        &nbsp;&nbsp;&nbsp;
                        <?=$lpgm_Sendemailtomewhentransactionappears?>
                    </td>
                </tr>
                <tr>
                	<td height="20" align="center" colspan="2" >&nbsp;</td>
                </tr>
			</table>
		</td>
	</tr>                  
                
    <!--Affiliate Approval, Ip Blocking, geo countries and Cookie settings -->
    <tr>
    	<td >
       		<table border="0" cellpadding="0" cellspacing="0"  width="100%"  >
                <tr>
                    <td height="20" align="right" class="grid1" width="50%">
						<?= $lpgm_AffiliateApproval?>&nbsp;&nbsp;&nbsp;&nbsp; 
                    </td>
                    <td height="20" align="left" class="grid1" width="50%">&nbsp;
                        <input type="radio" name="affil_approval" value="automatic" <?=($programDetails['affiliateapproval']=="automatic")?"checked='checked'":""?> /><?= $lpgm_Automatic?>
                        &nbsp;
                        <input type="radio" name="affil_approval" value="manual" <?=($programDetails['affiliateapproval']!="automatic")?"checked='checked'":""?>  /><?=$lpgm_Manually?>
                  	</td>
                </tr>
                <tr>
                    <td height="30" align="right" class="grid1">
                        <?= $lpgm_IPBlocking?> &nbsp;&nbsp;&nbsp;&nbsp; 
                    </td>
                    <td height="20" align="left" class="grid1"> &nbsp;
                        <input name="ip" size="6" value='<?=$programDetails['ip']?>' onkeypress="return CheckNumeric(event);"   />&nbsp;<?= $lpgm_minutes ?> 
                    </td>
                </tr>
                
				<? //selecting countries and their ips
                    $selq = "SELECT DISTINCT `country_name` FROM `partners_countryFlag` ORDER BY `country_name`";
                    $res = mysqli_query($con,$selq);
                ?>
                <tr>
                    <td height="30" align="right" class="grid1" valign="top">
                        <?= $lpgm_OfferAvailable?>&nbsp;&nbsp;&nbsp;&nbsp; 
                    </td>
                    <td height="20" align="left" class="grid1"> &nbsp;
                        <select name="sel_countries[]" multiple size="5"  style="font-size:11px; min-height:75px;" class="selectMulti">
                            <? while($row = mysqli_fetch_object($res)){?>
                            <option value="<?=$row->country_name?>" ><?=$row->country_name?></option>
                            <? }?>
                        </select>          
                    </td>
                </tr>
                
                <tr>
                    <td height="30" align="right" class="grid1">
                        <?= $lpgm_Cookie?>
                        &nbsp;&nbsp;&nbsp;&nbsp; 
                    </td>
                    <td height="20" align="left" class="grid1"> &nbsp;
                        <input name="cookieTime" size="6" value="<?=$programDetails['cookieTime']?>" onkeypress="return CheckNumeric(event);"   />
                        &nbsp;
                        <select size="1" name="cookiePeriod" >
                            <option value="minute" <?=($programDetails['cookiePeriod']=="minute"?"selected='selected'":"")?>><?=$common_min?></option>
                            <option value="hour"   <?=($programDetails['cookiePeriod']=="hour"?"selected='selected'":"")?>><?=$common_hr?></option>
                            <option value="day"    <?=($programDetails['cookiePeriod']=="day"?"selected='selected'":"")?>><?=$common_day?></option>
                            <option value="year"   <?=($programDetails['cookiePeriod']=="year"?"selected='selected'":"")?>><?=$common_year?></option>
                        </select>          
                    </td>
                </tr>
                
			</table>
		</td>
	</tr>   
                   
    <tr>
    	<td align="center">&nbsp;</td>
    </tr>
    <tr>
        <td height="20" align="center"  >
            <input name="currValue" type="hidden" value="<?=$currValue?>" />
            <input type="button" onclick="CheckRecurringPeriod();"  name="B1" value=" <?= $lpgm_Submit?>" class="button" />
            <input type="reset"  name="B2"  value=" <?= $lpgm_Reset?>" class="button" />
        </td>
    </tr>
    <tr>
    	<td align="center">&nbsp;</td>
    </tr>


</table>
</form>
<br />
