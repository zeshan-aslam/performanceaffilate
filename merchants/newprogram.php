<?php
include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';

//Modify on 17-JUNE-06

        //if any retvalues exists  modified on 24-Feb-06
        if($_SESSION['SESS_RETVALUE'])
        {
                //get the return values from session
                $ret_values                = $_SESSION['SESS_RETVALUE'];

                //explode the ret_values to get each values
                $new_ret                = explode("&",$ret_values);

                $url_arr                 = explode("=",$new_ret[1]);
                $url                         = urldecode($url_arr[1]);

                $click_arr                 = explode("=",$new_ret[2]);
                $click                         = urldecode($click_arr[1]);

                $lead_arr                 = explode("=",$new_ret[3]);
                $lead                         = urldecode($lead_arr[1]);

                $sale_arr                 = explode("=",$new_ret[4]);
                $sale                         = urldecode($sale_arr[1]);

                $saletype1_arr                 = explode("=",$new_ret[5]);
                $saletype1                         = urldecode($saletype1_arr[1]);

                $clickr_arr                 = explode("=",$new_ret[6]);
                $clickr                         = urldecode($clickr_arr[1]);

                $leadr_arr                 = explode("=",$new_ret[7]);
                $leadr                         = urldecode($leadr_arr[1]);

                $saler_arr                 = explode("=",$new_ret[8]);
                $saler                         = urldecode($saler_arr[1]);

                $clicke_arr                 = explode("=",$new_ret[9]);
                $clicke                         = urldecode($clicke_arr[1]);


                $leade_arr                 = explode("=",$new_ret[10]);
                $leade                         = urldecode($leade_arr[1]);


                $salee_arr                 = explode("=",$new_ret[11]);
                $salee                         = urldecode($salee_arr[1]);


                $second_arr                 = explode("=",$new_ret[12]);
                $second                         = urldecode($second_arr[1]);


                $secondtype_arr                 = explode("=",$new_ret[13]);
                $secondtype                         = urldecode($secondtype_arr[1]);



                $secondtxt_arr                 = explode("=",$new_ret[14]);
                $secondtxt                         = urldecode($secondtxt_arr[1]);


                $mailaffil_arr                 = explode("=",$new_ret[15]);
                $mailaffil                         = urldecode($mailaffil_arr[1]);


                $mailme_arr                 = explode("=",$new_ret[16]);
                $mailme                         = urldecode($mailme_arr[1]);


                $affiliater_arr                 = explode("=",$new_ret[17]);
                $affiliater                         = urldecode($affiliater_arr[1]);


                $ip_arr                 = explode("=",$new_ret[18]);
                $ip                         = urldecode($ip_arr[1]);

                $cookie_arr                 = explode("=",$new_ret[19]);
                $cookie                         = urldecode($cookie_arr[1]);

                $status_arr                 = explode("=",$new_ret[20]);
                $status                         = urldecode($status_arr[1]);

                $geo_click_arr                 = explode("=",$new_ret[21]);
                $geo_click                         = urldecode($geo_click_arr[1]);


                $geo_lead_arr                 = explode("=",$new_ret[22]);
                $geo_lead                         = urldecode($geo_lead_arr[1]);


                $geo_sale_arr                 = explode("=",$new_ret[23]);
                $geo_sale                         = urldecode($geo_sale_arr[1]);

                $impression_arr                 = explode("=",$new_ret[24]);
                $impression_rate                         = urldecode($impression_arr[1]);

                $geo_impression_arr                 = explode("=",$new_ret[25]);
                $geo_impression                         = urldecode($geo_impression_arr[1]);


                $impressionr_arr                 = explode("=",$new_ret[26]);
                $impression_approval                         = urldecode($impressionr_arr[1]);


                $impressione_arr                 = explode("=",$new_ret[27]);
                $impression_mail                         = urldecode($impressione_arr[1]);


                $impressionunit_arr                 = explode("=",$new_ret[28]);
                $impression_unit                         = urldecode($impressionunit_arr[1]);

                $geo_impression_arr                 = explode("=",$new_ret[29]);
                $geo_impression                         = urldecode($geo_impression_arr[1]);

				$recur_sale_arr				= explode("=",$new_ret[30]);
				$recur_sale					= urldecode($recur_sale_arr[1]);
				
				$recur_percentage_arr		= explode("=",$new_ret[31]);
				$recur_percentage			= urldecode($recur_percentage_arr[1]);
				
				$recur_period_arr			= explode("=",$new_ret[32]);
				$recur_period				= urldecode($recur_period_arr[1]);

				$msg_arr                                         = explode("=",$new_ret[33]);
                $msg                         = urldecode($msg_arr[1]);
				
        }//end of checking session for return values
         $_SESSION['SESS_RETVALUE']="" ;//empty session

//End Modify on 17-JUNE-06

                  echo "<p  align='center'><span class='textred'>$msg</span></p>";



	            if($saler=="automatic"){
	              	$sr="checked = 'checked'";
	            }else{
	                $nsr="checked = 'checked'";
	            }

	            if($clickr=="automatic"){
	              	$cr="checked = 'checked'";
	            }else{
	                $ncr="checked = 'checked'";
	            }

	            if($leadr=="automatic"){
		            $lr="checked = 'checked'";
	            }else{
	            	$nlr="checked = 'checked'";
	            }

	            if($salee=="automatic")
	            {
	            $se="checked = 'checked'";
	            }
	            else
	            {
	            $nse="checked = 'checked'";
	            }

	            if($leade=="automatic")
	            {
	            $le="checked = 'checked'";
	            }
	            else
	            {
	            $nle="checked = 'checked'";
	            }

	            if($clicke=="automatic")
	            {
	            $ce="checked = 'checked'";
	            }
	            else
	            {
	            $nce="checked = 'checked'";
	            }

	            if($second=="YES")
	            {
	            $sec="checked = 'checked'";
	            }
	            else
	            {
	            $sec="";            //   $secondtype mailaffil mailme
	            }

	            if($mailaffil=="mailaffil")
	            {
	            $maf="checked = 'checked'";
	            }
	            else
	            {
	            $maf="";            //   $secondtype mailaffil mailme
	            }

	            if($mailme=="mailme")
	            {
	            $mme="checked = 'checked'";
	            }
	            else
	            {
	            $mme="";            //   $secondtype mailaffil mailme  affiliater=automatic
	            }

	            if($affiliater=="automatic")
	            {
	            $aa="checked = 'checked'";
	            }
	            else
	            {
	            $naa="checked = 'checked'";
	            }

	            if($secondtype=="$")
	            {
	            $ds="selected = 'selected'";
	            }
	            else
	            {
	            $ps="selected = 'selected'";
	            }

	            if($saletype1=="%")
	            {
	            $ps1="selected = 'selected'";
	            }
	            else
	            {
	            $ds1="selected = 'selected'";
	            }

	            if($status=="active")
	            {
	              $ssl="selected = 'selected'";
	            }
	            else
	            {
	             $nssl="selected = 'selected'";
	            }

	            //Enable/Disable Geo-Targeting
	            $geo_click_checked = $geo_lead_checked = $geo_sale_checked = "";
	            if($_GET['geo_click']=="1") $geo_click_checked = "checked = 'checked'";
	            if($_GET['geo_lead']=="1") $geo_lead_checked = "checked = 'checked'";
	            if($_GET['geo_sale']=="1") $geo_sale_checked = "checked = 'checked'";

       //modified by SMA on 17-JUNE-06
			   //finds status of impression approval
			   if($impression_approval=="automatic")
			   {
				  $impapp_automatic="checked = 'checked'";
			   }
			   else
			   {
					$impapp_mannual="checked = 'checked'";
			   }

			   //finds status of impression mail sending
			   if($impression_mail=="automatic")
			   {
				  $impemail_automatic="checked = 'checked'";
			   }
			   else
			   {
					$impemail_mannual="checked = 'checked'";
			   }

			   //finds if geo targeting checked for impression
			   if($geo_impression=="1")
			   {
				   $geo_imp = "checked = 'checked'";
			   }
			   else
			   {
					$geo_imp = "";
			   }
       //End Modify

?>

<form method="post" action="" name="f1" id="f1">
<table border="0" cellpadding="0" cellspacing="0" width="70%" id="AutoNumber1" class="tablebdr" align="center">
    <tr>
      <td width="100%" colspan="3" height="19" class="tdhead" align="center"><b> <?= $lpgm_NewProgram?></b></td>
    </tr>
    <tr>
      <td width="100%" colspan="3" height="19" ></td>
    </tr>
 <tr>
      <td width="1%" height="161">&nbsp;</td>
      <td width="98%" align="center" valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="72%" id="AutoNumber1" class="tablebdr">
        <tr>
          <td height="17" colspan="5" >&nbsp;</td>
        </tr>
        <tr>
          <td width="1%" height="39">&nbsp;</td>
          <td width="24%" height="39" align="left"><?= $lpgm_ProgramURL?> </td>
          <td width="58%" height="39" align="left">
          <input type="text" name="url" size="48" id="url" value="<?=$url?>" /></td>
          <td width="16%" height="39">
		  </td>
          <td width="1%" height="39">&nbsp;</td>
        </tr>
        <tr>
          <td width="1%" height="19">&nbsp;</td>
          <td width="24%" height="19"  align="left" valign="top"><?= $lpgm_Description?></td>
          <td height="19" colspan="2"  align="left">
          <textarea rows="3" name="description" cols="47"><?=$_SESSION['DES']?></textarea></td>
          <td width="1%" height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="5" >&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="5" >&nbsp;</td>
        </tr>
      </table>
      </td>
      <td width="1%" align="center" height="161">&nbsp;</td>
    </tr>
    <tr>
      <td width="1%" align="center" height="348">&nbsp;</td>
      <td width="98%" align="center" valign="top">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  width="638"  class="tablebdr">
        <tr>
          <td colspan="10" height="19" align="center" class="tdhead"><b><?=$lpgm_Commissions?></b></td>
        </tr>
        <tr>
          <td colspan="10" height="19" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td width="5" height="19" align="center" class="tdhead">&nbsp;</td>
          <td width="58" height="19" align="left" class="tdhead"><b><?=$lpgm_Type?></b></td>
          <td width="163" align="left" class="tdhead"><b><?=$lpgm_Commissions?></b></td>
          <td width="107" height="19" align="center" class="tdhead"><b><?=$lpgm_Geo_Targeting?></b></td>
          <td height="19" colspan="3" align="center" class="tdhead"><b><?=$lpgm_Approval?></b></td>
          <td height="19" align="center" class="tdhead" colspan="3"><b><?=$lpgm_EmailSettings?></b></td>
        </tr>

        <!-- Modified by SMA 22-FEb-06  -->
        <tr>
          <td width="5" height="21" align="center" rowspan="2" >&nbsp;</td>
          <td width="58" height="21" align="left" rowspan="2" ><?=$lpgm_Impression?></td>
          <td width="163" align="left" rowspan="2" ><input type="text" name="impression" size="8" value="<?=$impression_rate?>" />
              <?=$currSymbol?>&nbsp;<?=$lpgm_perImpression?>&nbsp;<input type="text" name="impressionunit" size="4" value="<? if($impression_unit!=''){echo $impression_unit;}else{ echo '1000';}?>" /></td>
          <td width="107" height="21" align="center" rowspan="2" ><input name="chk_geo_impression" type="checkbox" <?=$geo_imp?> /></td>
          <td width="35" height="7" align="right" >&nbsp;</td>
          <td width="83" align="left" ><?=$lpgm_Automatic?></td>
          <td width="44" height="18" align="left" >
            <input type="radio" value="automatic" name="impressionr" <?=$impapp_automatic?> /></td>
          <td width="58" height="19" align="right" ><?=$lpgm_Automatic?></td>
          <td width="35" align="center" >&nbsp;</td>
          <td width="50" height="19" align="left" >
            <input type="radio" value="automatic" name="impressione" <?=$impemail_automatic?> /></td>
        </tr>
        <tr>
          <td width="35" height="15" align="right"  >&nbsp;</td>
          <td width="83" align="left" ><?=$lpgm_Manually?></td>
          <td width="44" height="20" align="left" >
            <input type="radio" name="impressionr" value="manual" <?=$impapp_mannual?> /></td>
          <td width="58" height="21" align="right" ><?=$lpgm_Manually?></td>
          <td width="35" align="center" class="grid1">&nbsp;</td>
          <td width="50" height="21" align="left" >
            <input type="radio" value="manual" name="impressione" <?=$impemail_mannual?>  /></td>
        </tr>
        <!-- End Modify   -->
		
        <tr>
          <td width="5" height="21" align="center" rowspan="2" class="grid1">&nbsp;</td>
          <td width="58" height="21" align="left" rowspan="2" class="grid1"><?=$lpgm_Click?></td>
          <td width="163" align="left" rowspan="2" class="grid1"><input type="text" name="click" size="8" value="<?=$click?>" />
              <?=$currSymbol?></td>
          <td width="107" height="21" align="center" rowspan="2" class="grid1"><input name="chk_geo_click" type="checkbox" <?=$geo_click_checked?> /></td>
          <td width="35" height="7" align="right" class="grid1">&nbsp;</td>
          <td width="83" align="left" class="grid1"><?=$lpgm_Automatic?></td>
          <td width="44" height="18" align="left" class="grid1">
            <input type="radio" value="automatic" name="clickr" <?=$cr?> /></td>
          <td width="58" height="19" align="right" class="grid1"><?=$lpgm_Automatic?></td>
          <td width="35" align="center" class="grid1">&nbsp;</td>
          <td width="50" height="19" align="left" class="grid1">
            <input type="radio" value="automatic" name="clicke" <?=$ce?> /></td>
        </tr>
        <tr>
          <td width="35" height="15" align="right" class="grid1">&nbsp;</td>
          <td width="83" align="left" class="grid1"><?=$lpgm_Manually?></td>
          <td width="44" height="20" align="left" class="grid1">
            <input type="radio" name="clickr" value="manual" <?=$ncr?> /></td>
          <td width="58" height="21" align="right" class="grid1"><?=$lpgm_Manually?></td>
          <td width="35" align="center" class="grid1">&nbsp;</td>
          <td width="50" height="21" align="left" class="grid1">
            <input type="radio" value="manual" name="clicke" <?=$nce?>  /></td>
        </tr>
        <tr>
          <td width="5" height="22" align="center" rowspan="2">&nbsp;</td>
          <td width="58" height="22" align="left" rowspan="2"><?=$lpgm_Lead?></td>
          <td width="163" align="left" rowspan="2"><input type="text" name="lead" size="8" value="<?=$lead?>" />
              <?=$currSymbol?></td>
          <td width="107" height="22" align="center" rowspan="2"><span class="grid1">
            <input name="chk_geo_lead" type="checkbox"  <?=$geo_lead_checked?> />
          </span> </td>
          <td width="35" height="8" align="right">&nbsp;</td>
          <td width="83" align="left"><?=$lpgm_Automatic?></td>
          <td width="44" height="8" align="left">
            <input type="radio" name="leadr" value="automatic" <?=$lr?> /></td>
          <td width="58" height="19" align="right"><?=$lpgm_Automatic?></td>
          <td width="35" align="center">&nbsp;</td>
          <td width="50" height="19" align="left">
            <input type="radio" value="automatic" name="leade" <?=$le?> /></td>
        </tr>
        <tr>
          <td width="35" height="14" align="right">&nbsp;</td>
          <td width="83" align="left"><?=$lpgm_Manually?></td>
          <td width="44" height="14" align="left">
            <input type="radio" name="leadr" value="manual" <?=$nlr?> /></td>
          <td width="58" height="21" align="right"><?=$lpgm_Manually?></td>
          <td width="35" align="center">&nbsp;</td>
          <td width="50" height="21" align="left">
            <input type="radio" value="manual" name="leade" <?=$nle?>  /></td>
        </tr>
        <tr>
          <td width="5" height="26" align="center" rowspan="2" class="grid1">&nbsp;</td>
          <td width="58" height="26" align="left" rowspan="2" class="grid1"><?=$lpgm_Sale?></td>
          <td width="163" align="left" rowspan="2" class="grid1"><input type="text" name="sale" size="8" value="<?=$sale?>" />
              <select size="1" name="saletype1" >
                <option value="$" <?=$ds1?> >
                <?=$currSymbol?>
                </option>
                <option value="%" <?=$ps1?> >%</option>
            </select></td>
          <td width="107" height="26" align="center" rowspan="2" class="grid1"><input name="chk_geo_sale" type="checkbox" <?=$geo_sale_checked?> /></td>
          <td width="35" height="6" align="right" class="grid1">&nbsp;</td>
          <td width="83" align="left" class="grid1"><?=$lpgm_Automatic?></td>
          <td width="44" height="6" align="left" class="grid1">
            <input type="radio" name="saler" value="automatic" <?=$sr?> /></td>
          <td width="58" height="19" align="right" class="grid1"><?=$lpgm_Automatic?></td>
          <td width="35" align="center" class="grid1">&nbsp;</td>
          <td width="50" height="19" align="left" class="grid1">
            <input type="radio" value="automatic" name="salee" <?=$se?> /></td>
        </tr>
        <tr>
          <td width="35" height="19" align="right" class="grid1">&nbsp;</td>
          <td width="83" align="left" class="grid1"><?=$lpgm_Manually?></td>
          <td width="44" height="19" align="left" class="grid1">
            <input type="radio" name="saler" value="manual" <?=$nsr?> /></td>
          <td width="58" height="25" align="right" class="grid1"><?=$lpgm_Manually?></td>
          <td width="35" align="center" class="grid1">&nbsp;</td>
          <td width="50" height="25" align="left" class="grid1">
            <input type="radio" value="manual" name="salee" <?=$nse?>  /></td>
        </tr>

	<!-- Added by SMA on 20-JUNE-2006 for recurring comission  -->
        <tr>
          <td height="20" align="center" colspan="10">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="10" width="638">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="5" height="26" align="center" >&nbsp;</td>
						<td align="left">&nbsp;<b><?=$recur_commission_head?></b></td>
					</tr>
					<tr>
						<td width="5" height="26" align="center" >&nbsp;</td>
						<td align="left">&nbsp;
							<input type="checkbox" <? if($recur_sale) echo "checked='checked'"; ?> name="chk_recursale" />&nbsp;<?=$recur_sale_head?>
							<input type="text" name="txt_recurpercent" value="<?=$recur_percentage?>" maxlength="3" onKeyPress="CheckNumeric();" style="width:40px;" />&nbsp;<?=$recur_percent_month_head?>&nbsp;
							<input type="text" name="cmb_recurperiod" value="<?=$recur_period?>" maxlength="2"  onKeyPress="CheckNumeric();" style="width:40px;" />&nbsp;<?=$recur_months_head?>
<!--							<select name="cmb_recurperiod" >
								<option value="1"><?=$recur_period_1?></option>
								<option value="2"><?=$recur_period_2?></option>
								<option value="3"><?=$recur_period_3?></option>
								<option value="4"><?=$recur_period_4?></option>
								<option value="5"><?=$recur_period_5?></option>
								<option value="6"><?=$recur_period_6?></option>
								<option value="7"><?=$recur_period_7?></option>
								<option value="8"><?=$recur_period_8?></option>
								<option value="9"><?=$recur_period_9?></option>
								<option value="10"><?=$recur_period_10?></option>
								<option value="11"><?=$recur_period_11?></option>
								<option value="12"><?=$recur_period_12?></option>
							</select>
-->							
						</td>
					</tr>
				</table>
			</td>
		</tr>	
	<!-- End Added by SMA on 20-JUNE-2006 -->

        <tr>
          <td height="20" align="center" colspan="10"></td>
        </tr>
        <tr>
          <td height="19" align="center" class="grid1" colspan="2" >&nbsp;</td>
          <td height="19" align="left" class="grid1" colspan="6">
            <input type="checkbox" name="mailaffil" value="mailaffil" <?=$maf?> />
      &nbsp;&nbsp;&nbsp;
            <?= $lpgm_Sendemailtoaffiliatewhentransactionappears ?>          </td>
          <td width="15" align="center" class="grid1">&nbsp;</td>
          <td width="70" height="19" align="center" class="grid1">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="grid1" colspan="2" > </td>
          <td height="19" align="left" class="grid1" colspan="6">
            <input type="checkbox" name="mailme" value="mailme" <?=$mme?> />
      &nbsp;&nbsp;&nbsp;
            <?=$lpgm_Sendemailtomewhentransactionappears?>
            .</td>
          <td width="15" align="center" class="grid1">&nbsp;</td>
          <td width="70" height="19" align="center" class="grid1">&nbsp;</td>
        </tr>
        <tr>
          <td height="20" align="center" colspan="10" >&nbsp;</td>
        </tr>
        <tr>
          <td height="20" align="right" colspan="4" class="grid1">
            <?= $lpgm_AffiliateApproval?>
      &nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td height="20" align="left" colspan="6" class="grid1">&nbsp;
              <input type="radio" name="affiliater" value="automatic" <?=$aa?> />
              <?= $lpgm_Automatic?>
        &nbsp;
              <input type="radio" name="affiliater" value="manual" <?=$naa?> />
              <?=$lpgm_Manually?></td>
        </tr>
        <tr>
          <td height="30" align="right" colspan="4" class="grid1">
            <?= $lpgm_IPBlocking?>
      &nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td height="20" align="left" colspan="6" class="grid1"> &nbsp;
              <input name="ip" size="6" value='<?=$ip?>' />
        &nbsp;
              <?= $lpgm_minutes ?>          </td>
        </tr>
        <!-- added by jin on 6th Jul -->
        <?
        	//selecting countries and their ips
            $selq = "SELECT DISTINCT `country_name` FROM `partners_countryFlag` ORDER BY `country_name`";
            $res = mysqli_query($con,$selq);
        ?>
        <tr>
          <td height="30" align="right" colspan="4" class="grid1" valign="top">
            <?= $lpgm_OfferAvailable?>
      &nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td height="20" align="left" colspan="6" class="grid1"> &nbsp;
              <select name="sel_countries[]" multiple size="5"  style="font-size:11px; min-height:75px;" class="selectMulti">
                <? while($row = mysqli_fetch_object($res)){?>
                <option value="<?=$row->country_name?>" >
                <?=$row->country_name?>
                </option>
                <? }?>
              </select>          </td>
        </tr>
        <tr>
          <td height="30" align="right" colspan="4" class="grid1">
            <?= $lpgm_Cookie?>
      &nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td height="20" align="left" colspan="6" class="grid1"> &nbsp;
              <input name="cookieTime" size="6" value="<?=$cookie?>" />
        &nbsp;
              <select size="1" name="cookiePeriod" >
                <option value="minute" <?=($cookiePeriod=="minute"?"selected='selected'":"")?>><?=$common_min?></option>
                <option value="hour"   <?=($cookiePeriod=="hour"?"selected='selected'":"")?>><?=$common_hr?></option>
                <option value="day"    <?=($cookiePeriod=="day"?"selected='selected'":"")?>><?=$common_day?></option>
                <option value="year"   <?=($cookiePeriod=="year"?"selected='selected'":"")?>><?=$common_year?></option>
              </select>          </td>
        </tr>
		<tr>
          <td align="center" colspan="10" >&nbsp;</td>
        </tr>
        <tr>
          <td height="20" align="center" colspan="10" >
            <input name="currValue" type="hidden" value="<?=$currValue?>" />
            <input type="button" onclick="CheckRecurringPeriod();"  name="B1" value=" <?= $lpgm_Submit?>" />
            <input type="reset"  name="B2"  value=" <?= $lpgm_Reset?>" /></td>
        </tr>
		<tr>
          <td align="center" colspan="10" >&nbsp;</td>
        </tr>
      </table></td>
      <td width="1%" align="center" height="348">&nbsp;</td>
    </tr>
	
    <tr>
      <td  colspan="3" >&nbsp;</td>
    </tr>
  </table>
</form>
<br /> 
<script language="javascript" >
    /*--------------------------------------------------------------------------
    Description   :- function to allow only Numeric values in a textbox.
        Called in the onKeyPress event.
    Programmer    :- SMA
    Last Modified :- 18/MAY/2006
    --------------------------------------------------------------------------*/
        function CheckNumeric()
        {	 
                if((window.event.keyCode>57 || window.event.keyCode<48) && (window.event.keyCode!=8))
                {
                        alert('<?=$js_numeric_value?>');
                        window.event.returnValue = null;
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
			if(document.f1.chk_recursale.checked == true)
			{
				if(document.f1.cmb_recurperiod.value == '')
				{
					alert('<?=$err_enterRecurperiod?>');
					document.f1.cmb_recurperiod.focus();
					return false;
				}
				if(document.f1.cmb_recurperiod.value == '0')
				{
					alert('<?=$err_validRecurPeriod?>');
					document.f1.cmb_recurperiod.focus();
					return false;
				}
			}
			document.f1.action='program_validate.php';
			document.f1.submit(); 
		}
</script>
