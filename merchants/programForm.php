<?php

/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  programForm.php                            	*/
/*     CREATED ON     :  04/SEP/2009                                    */

/* 	Program Form for Add and Edit.			 							*/
/************************************************************************/

if ($message == "empty")
	$msg = $lpgm_error1;
else if ($message == "amount")
	$msg = $lpgm_error8;
else if ($message == "recurpercent")
	$msg = $err_enterRecurPercent;
else if ($message == "recurPeriod")
	$msg = $err_enterRecurperiod;
else if ($message == "invalidrecurPeriod")
	$msg = $err_validRecurPeriod;
else if ($message == "empty_lead")
	$msg = $lang_commission_lead_allvalues;
else if ($message == "invalid_range")
	$msg = $lang_commission_enter_valid_rage;
else if ($message == "empty_sale")
	$msg = $lang_commission_sale_allvalues;
else if ($message == "atleast_one")
	$msg = $lang_commission_atleast_one_amount;

?>

<?php if ($msg) {
	echo "<p align='center' > <span class='textred'>$msg</span></p>";
} ?>

<script language="javascript">
	/*--------------------------------------------------------------------------
    Description   :- function to allow only Numeric values in a textbox.
        Called in the onKeyPress event.
    Programmer    :- SMA
    Last Modified :- 18/MAY/2006
    --------------------------------------------------------------------------*/
	function CheckNumeric(e) {
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

		if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27))
			return true;
		else if ((("0123456789.").indexOf(keychar) > -1))
			return true;
		else {
			alert('<?= $js_numeric_value ?>');
			return false;
		}
		return true;
	}

	/*--------------------------------------------------------------------------
	Description   :- function to validate the Recurring Period.
	Programmer    :- SMA
	Last Modified :- 27/JUNE/2006
	--------------------------------------------------------------------------*/
	function CheckRecurringPeriod() {
		var count = document.frm_program.commissionCount.value;
		for (i = 1; i <= count; i++) {
			var recursale = 'chk_recursale_' + i;
			var recurpercent = 'txt_recurpercent_' + i;
			var recurperiod = 'cmb_recurperiod_' + i;

			if (document.getElementById(recursale).checked == true) {
				if (document.getElementById(recurpercent).value == '' || document.getElementById(recurpercent).value == '0') {
					alert('<?= $err_enterRecurPercent ?>');
					document.getElementById(recurpercent).focus();
					return false;
				}
				if (document.getElementById(recurperiod).value == '') {
					alert('<?= $err_enterRecurperiod ?>');
					document.getElementById(recurperiod).focus();
					return false;
				}
				if (document.getElementById(recurperiod).value == '0') {
					alert('<?= $err_validRecurPeriod ?>');
					document.getElementById(recurperiod).focus();
					return false;
				}
			}
		}
		document.frm_program.submit();
	}


	// Set the next From Value for Sale or Leas Commission
	function setNextFromValue(source, destination) {
		var quantity = document.getElementById(source).value;
		if (document.getElementById(destination) && quantity)
			document.getElementById(destination).value = parseInt(quantity) + 1;
		return true;
	}


	function deleteCommission() {
		if (confirm('<?= $lang_Confirm_delete_Commission ?>')) {
			document.frm_program.action = 'index.php?Act=programs&mode=DeleteCommission#TBL_Commission';
			document.frm_program.submit();
		} else
			return false;
	}
</script>

<form method="post" action="index.php?Act=programs&mode=submitprogram" name="frm_program" id="frm_program">
	<input type="hidden" name="programId" id="programId" value="<?= $programId ?>" />
	<div class="row">
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<h5 class="card-title"><?= ($programId) ? $lpgm_ProgramEditor : $lpgm_NewProgram ?></h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?= $lpgm_ProgramURL ?></label>
								<input type="text" class="form-control" name="url" size="48" id="url" value="<?= $programDetails['url'] ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?= $lpgm_Description ?></label>
								<textarea style=" height: auto;" rows="3" class="form-control" name="description"><?= $programDetails['description'] ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- <div class="card strpied-tabled-with-hover">
			<div class="card-header">				
				<h4 class="card-title"><?= $lpgm_Commissions ?></h4>
			</div>
			<div class="card-body table-full-width table-responsive">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th><?= $lpgm_Type ?></th>
							<th><?= $lpgm_Commissions ?></th>
							<th><?= $lpgm_Geo_Targeting ?></th>
							<th><?= $lpgm_Approval ?></th>
							<th><?= $lpgm_EmailSettings ?></th>
						</tr>
					</thead>
					<tbody>
						  <tr>
                    <td>&nbsp;<?= $lpgm_Impression ?></td>
                    <td class="input_td"><label><?= $currSymbol ?>&nbsp;<?= $lpgm_perImpression ?>&nbsp;</label>
                    	<input class="form-control" type="text" name="impression" size="8" value="<?= ($programDetails['impression_rate']) ? $programDetails['impression_rate'] : 0 ?>" onkeypress="return CheckNumeric(event);"  />
                    </td>
                    <td class="text-center" >
                    	<input name="chk_geo_impression" type="checkbox" value="1" <?= ($programDetails['geo_impression']) ? "checked='checked'" : "" ?> />
                    </td>
                    <td  ><?= $lpgm_Automatic ?></td>
                    <td  >
                    	<input type="radio" value="automatic" name="impr_approval" <?= ($programDetails['imprapproval'] == "automatic") ? "checked='checked'" : "" ?> />
                    </td>
                    <td  ><?= $lpgm_Automatic ?></td>
                    <td  >
                    	<input type="radio" value="automatic" name="impr_email" <?= ($programDetails['imprmail'] == "automatic") ? "checked='checked'" : "" ?> />
                    </td>
                </tr>
                <tr>
					<td></td>
					<td> <input class="form-control" type="text" name="impressionunit" size="4" value="<? if ($programDetails['impression_unit'] != '') {
																											echo $programDetails['impression_unit'];
																										} else {
																											echo '1000';
																										} ?>" onkeypress="return CheckNumeric(event);"  /></td>
					<td></td>
                    <td  ><?= $lpgm_Manually ?></td>
                    <td  >
                    	<input type="radio" name="impr_approval" value="manual" <?= ($programDetails['imprapproval'] != "automatic") ? "checked='checked'" : "" ?> />
                    </td>
                    <td  ><?= $lpgm_Manually ?></td>
                    <td  >
                    	<input  type="radio" value="manual" name="impr_email" <?= ($programDetails['imprmail'] != "automatic") ? "checked='checked'" : "" ?>  />
                    </td>
                </tr>
				<tr>
                    <td    >&nbsp;<?= $lpgm_Click ?></td>
                    <td  class="input_td"><label><?= $currSymbol ?>&nbsp;</label>
                    	<input class="form-control" type="text" name="click" size="8" value="<?= ($programDetails['click']) ? $programDetails['click'] : 0 ?>" onkeypress="return CheckNumeric(event);"  /> 
                    </td>
                    <td class="text-center" >
                    	<input  name="chk_geo_click" type="checkbox" value="1" <?= ($programDetails['geo_click']) ? "checked='checked'" : "" ?>  />
                    </td>
                    <td  ><?= $lpgm_Automatic ?></td>
                    <td  >
                    	<input  type="radio" value="automatic" name="click_approval" <?= ($programDetails['clickapproval'] == "automatic") ? "checked='checked'" : "" ?> />
                    </td>
                    <td  ><?= $lpgm_Automatic ?></td>
                    <td  >
                    	<input  type="radio" value="automatic" name="click_email" <?= ($programDetails['clickmail'] == "automatic") ? "checked='checked'" : "" ?> />
                    </td>
                </tr>
                <tr>
					<td colspan="3"></td>
                    <td  ><?= $lpgm_Manually ?></td>
                    <td >
                    	<input type="radio" name="click_approval" value="manual" <?= ($programDetails['clickapproval'] != "automatic") ? "checked='checked'" : "" ?>  />
                    </td>
                    <td  ><?= $lpgm_Manually ?></td>
                    <td  >
                    	<input type="radio" value="manual" name="click_email" <?= ($programDetails['clickmail'] != "automatic") ? "checked='checked'" : "" ?>  />
                    </td>
                </tr>
					</tbody>
				</table>
			</div>
		</div> -->
		</div>
	</div>
	<!-- Multiple Commission Structure for Lead and Sale -->
	<?php $commissionCount = ($commissionCount) ? $commissionCount : 1;      ?>
	<input type="hidden" name="commissionCount" value="<?= $commissionCount ?>" />
	<!-- <div class="row">
		<div class="col-md-6 mr-auto ml-auto">
			<div class="card">
				<div class="card-body text-center">
					
				</div>
			</div>
		</div>
	</div> -->

	<div class="row">
		<div class="col-md-12">
			<div class="card strpied-tabled-with-hover">
				<div class="card-header">

					<a id="TBL_Commission"></a>
					<?php if ($commissionCount < 5) { ?>
						<input type="button" name="AddCommission" value="Add New Flexible Commission" onclick="javascript: document.frm_program.commissionCount.value=<?= $commissionCount + 1 ?>; document.frm_program.action='index.php?Act=programs&mode=addcommission#TBL_Commission_<?= $commissionCount ?>'; document.frm_program.submit();" class="btn btn-primary btn-wd" />
					<?php } ?>

				</div>
				<div class="card-body table-full-width table-responsive p-3">


					<?php
					for ($i = 1; $i <= $commissionCount; $i++) {
					?><div class="loop m-3 p-3 card bg-light">
							<input type="hidden" name="commissionId_<?= $i ?>" id="commissionId_<?= $i ?>" value="<?= $commissionDetails[$i]['commissionId'] ?>" />

							<div class="row">
								<div class="col-md-9">
									<h4 class="card-title"><b><?= $lang_commission_structure . $i ?></b></h4>
								</div>
								<div class="col-md-3">
									<?php if ($i == $commissionCount and $i > 1) { ?>

										<button class="btn btn-danger " type="button" name="DeleteCommission" onclick="javascript: deleteCommission();">Delete Commission</button>

									<?php } ?>
								</div>
							</div>
							<select id="commission_type" name="comm_type" class="form-control col-md-4">
								<option value="sale">Commission For Sale</option>
								<option value="lead">Commission For Lead</option>
							</select>

							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?= $lang_report_from ?></th>
										<th><?= $lang_report_to ?></th>
										<th><?= $lpgm_Type ?></th>
										<th><?= $lpgm_Commissions ?></th>
										<th><?= $lpgm_Geo_Targeting ?></th>
										<th colspan="2"><?= $lpgm_Approval ?></th>
										<th colspan="2"><?= $lpgm_EmailSettings ?></th>
									</tr>
								</thead>
								<!-- Lead Commission -->
								<tbody>

									<tr id="lead_comm">
										<td rowspan="2">
											<input class="form-control" type="text" name="lead_from_<?= $i ?>" id="lead_from_<?= $i ?>" size="8" value="<?= ($i == 1) ? "1" : $commissionDetails[$i]['lead_from'] ?>" onkeypress="return CheckNumeric(event);" readonly="readonly" />
										</td>
										<td rowspan="2">
											<input class="form-control" type="text" name="lead_to_<?= $i ?>" id="lead_to_<?= $i ?>" size="8" value="<?= $commissionDetails[$i]['lead_to'] ?>" onkeypress="return CheckNumeric(event);" <?php if ($i < $commissionCount) { ?> onchange="javscript: return setNextFromValue('lead_to_<?= $i ?>', 'lead_from_<?= $i + 1 ?>');" <?php } ?> />
										</td>
										<td rowspan="2"><?= $lpgm_Lead ?></td>
										<td class="input_td" rowspan="2"><label><?= $currSymbol ?></label>
											<input class="form-control" type="text" name="lead_<?= $i ?>" size="3" value="<?= ($commissionDetails[$i]['leadrate']) ? number_format((float)$commissionDetails[$i]['leadrate'], 2, '.', '') : 0.00 ?>" onkeypress="return CheckNumeric(event);" />
										</td>
										<td rowspan="2">
											<input name="chk_geo_lead_<?= $i ?>" type="checkbox" value="1" <?= ($commissionDetails[$i]['geo_lead']) ? "checked='checked'" : "" ?> />
										</td>
										<td><?= $lpgm_Automatic ?></td>
										<td>
											<input type="radio" name="lead_approval_<?= $i ?>" value="automatic" <?= ($commissionDetails[$i]['leadapproval'] == "automatic") ? "checked='checked'" : "" ?> />
										</td>
										<td><?= $lpgm_Automatic ?></td>
										<td>
											<input type="radio" name="lead_email_<?= $i ?>" value="automatic" <?= ($commissionDetails[$i]['leadmail'] == "automatic") ? "checked='checked'" : "" ?> />
										</td>
									</tr>
									<tr id="lead">
										<td><?= $lpgm_Manually ?></td>
										<td>
											<input type="radio" name="lead_approval_<?= $i ?>" value="manual" <?= ($commissionDetails[$i]['leadapproval'] != "automatic") ? "checked='checked'" : "" ?> />
										</td>
										<td><?= $lpgm_Manually ?></td>
										<td>
											<input type="radio" name="lead_email_<?= $i ?>" value="manual" <?= ($commissionDetails[$i]['leadmail'] != "automatic") ? "checked='checked'" : "" ?> />
										</td>
									</tr>

									<!-- Sale Commission -->
									<tr id="comm_sale">
										<td rowspan="2">
											<input class="form-control" type="text" name="sale_from_<?= $i ?>" id="sale_from_<?= $i ?>" size="8" value="<?= ($i == 1) ? "1" : $commissionDetails[$i]['sale_from'] ?>" onkeypress="return CheckNumeric(event);" readonly="readonly" />
										</td>
										<td rowspan="2">
											<input class="form-control" type="text" name="sale_to_<?= $i ?>" id="sale_to_<?= $i ?>" size="8" value="<?= $commissionDetails[$i]['sale_to'] ?>" onkeypress="return CheckNumeric(event);" <?php if ($i < $commissionCount) { ?> onchange="javscript: return setNextFromValue('sale_to_<?= $i ?>', 'sale_from_<?= $i + 1 ?>');" <?php } ?> />
										</td>
										<td rowspan="2"><?= $lpgm_Sale ?></td>
										<td rowspan="2">
											<?php
											if ($commissionDetails[$i]['saletype'] == "%") {
												$comsale = $commissionDetails[$i]['salerate'];
												$comdefaultsale = 0;
											} else {
												$comsale = number_format((float)$commissionDetails[$i]['salerate'], 2, '.', '');
												$comdefaultsale = 0.00;
											}
											?>

											<input class="form-control" size="1" type="number" name="sale_<?= $i ?>" size="8" value="<?= ($commissionDetails[$i]['salerate']) ? $comsale : $comdefaultsale ?>" onkeypress="return CheckNumeric(event);" />



											<select class="form-control" size="1" name="saletype1_<?= $i ?>">
												<option value="$" <?= ($commissionDetails[$i]['saletype'] != "%") ? "selected='selected'" : "" ?>><?= $currSymbol ?></option>
												<option value="%" <?= ($commissionDetails[$i]['saletype'] == "%") ? "selected='selected'" : "" ?>>%</option>
											</select>


						</div>


						</td>
						<td rowspan="2">
							<input name="chk_geo_sale_<?= $i ?>" type="checkbox" value="1" <?= ($commissionDetails[$i]['geo_sale']) ? "checked='checked'" : "" ?> />
						</td>
						<td><?= $lpgm_Automatic ?></td>
						<td>
							<input type="radio" name="sale_approval_<?= $i ?>" value="automatic" <?= ($commissionDetails[$i]['saleapproval'] == "automatic") ? "checked='checked'" : "" ?> />
						</td>
						<td><?= $lpgm_Automatic ?></td>
						<td>
							<input type="radio" name="sale_email_<?= $i ?>" value="automatic" <?= ($commissionDetails[$i]['salemail'] == "automatic") ? "checked='checked'" : "" ?> />
						</td>
						</tr>
						<tr id="sale">
							<td><?= $lpgm_Manually ?></td>
							<td>
								<input type="radio" name="sale_approval_<?= $i ?>" value="manual" <?= ($commissionDetails[$i]['saleapproval'] != "automatic") ? "checked='checked'" : "" ?> />
							</td>
							<td><?= $lpgm_Manually ?></td>
							<td>
								<input type="radio" name="sale_email_<?= $i ?>" value="manual" <?= ($commissionDetails[$i]['salemail'] != "automatic") ? "checked='checked'" : "" ?> />
							</td>
						</tr>
						</tbody>
						</table>
						<div>
							<h4 class="card-title"><b><?= $recur_commission_head . " " . $i ?></b></h4>
							<div class="form-group">
								<label><input type="checkbox" name="chk_recursale_<?= $i ?>" id="chk_recursale_<?= $i ?>" <? if ($commissionDetails[$i]['recur_sale']) echo "checked='checked'"; ?> value="1" />&nbsp;<?= $recur_sale_head ?></label>
								<label><input type="text" name="txt_recurpercent_<?= $i ?>" id="txt_recurpercent_<?= $i ?>" value="<?= $commissionDetails[$i]['recur_percentage'] ?>" maxlength="3" onkeypress="return CheckNumeric(event);" style="width:40px;" />&nbsp;&nbsp;<?= $recur_percent_month_head ?></label>
								<label><input type="text" name="cmb_recurperiod_<?= $i ?>" id="cmb_recurperiod_<?= $i ?>" value="<?= $commissionDetails[$i]['recur_period'] ?>" maxlength="2" onkeypress="return CheckNumeric(event);" style="width:40px;" />&nbsp;&nbsp;<?= $recur_months_head ?></label>
							</div>
							<a id="TBL_Commission_<?= $i ?>"></a>

						</div>
				</div>
				<?php
						if ($i > 1) {
				?>

					<script language="javascript">
						setNextFromValue('lead_to_<?= $i - 1 ?>', 'lead_from_<?= $i ?>');
						setNextFromValue('sale_to_<?= $i - 1 ?>', 'sale_from_<?= $i ?>');
					</script>

			<?php }
					}
			?>


			</div>
		</div>
		<!-- Recurring Sale Commission -->
		<!-- <div class="card stacked-form">
					<div class="card-header">
						<h4 class="card-title"><?= $recur_commission_head ?></h4>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label><input type="checkbox" name="chk_recursale_<?= $i ?>" id="chk_recursale_<?= $i ?>" <? if ($commissionDetails[$i]['recur_sale']) echo "checked='checked'"; ?> value="1" />&nbsp;<?= $recur_sale_head ?></label>
							<label><input type="text" name="txt_recurpercent_<?= $i ?>" id="txt_recurpercent_<?= $i ?>" value="<?= $commissionDetails[$i]['recur_percentage'] ?>" maxlength="3" onkeypress="return CheckNumeric(event);" style="width:40px;" />&nbsp;<?= $recur_percent_month_head ?></label>
							<label><input type="text" name="cmb_recurperiod_<?= $i ?>" id="cmb_recurperiod_<?= $i ?>" value="<?= $commissionDetails[$i]['recur_period'] ?>" maxlength="2" onkeypress="return CheckNumeric(event);" style="width:40px;" />&nbsp;<?= $recur_months_head ?></label>
						</div>
					</div>
				</div> -->
	</div>


	</div>
	<div class="row">
		<div class="col-md-12">
			<!-- Email Settings for Affiliate and Merchant -->
			<div class="card stacked-form">
				<div class="card-body">
					<!--<div class="form-group">
						<label><input type="checkbox" name="mailaffil" value="yes" <?/*=($programDetails['mailaffiliate']=="yes")?"checked='checked'":""?> />                    
                        <?= $lpgm_Sendemailtoaffiliatewhentransactionappears */ ?></label>
					</div>-->

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?= $lpgm_AffiliateApproval ?></label>
							</div>
							<div class="form-group">
								<label><input type="radio" name="affil_approval" value="automatic" <?= ($programDetails['affiliateapproval'] == "automatic") ? "checked='checked'" : "" ?> />&nbsp;<?= $lpgm_Automatic ?></label>
								<label><input type="radio" name="affil_approval" value="manual" <?= ($programDetails['affiliateapproval'] != "automatic") ? "checked='checked'" : "" ?> />&nbsp;<?= $lpgm_Manually ?></label>
							</div>
						</div>
						<!--<div class="col-md-6">
							<div class="form-group">
								<label><?/*= $lpgm_IPBlocking?></label>
								<div class="custom_label"><input class=" form-control" name="ip" size="6" value='<?=$programDetails['ip']?>' onkeypress="return CheckNumeric(event);" /><span>&nbsp;<?= $lpgm_minutes*/ ?></span></div> 
							</div>
						</div> 
						<div class="clearfix"></div>-->
						<!--<div class="col-md-6">
							<div class="form-group">
								<? //selecting countries and their ips
								/*	$selq = "SELECT DISTINCT `country_name` FROM `partners_countryFlag` ORDER BY `country_name`";
									$res = mysqli_query($con,$selq);
								?>
								<label><?= $lpgm_OfferAvailable?></label>
								 <select name="sel_countries[]" multiple style="font-size:11px; min-height:75px;" data-style="btn-info btn-fill btn-block" data-menu-style="dropdown-blue" class="selectpicker">
									<? while($row = mysqli_fetch_object($res)){?>
									<option value="<?=$row->country_name?>" ><?=$row->country_name?></option>
									<? }*/ ?> 
								</select>
							</div>
						</div> -->
						<div class="col-md-6">
							<div class="form-group">
								<!-- <label class="label_float"><?= $lpgm_Cookie ?></label> -->
								<label class="label_float"> Referral Period </label>
								<!-- cookies value <?= $programDetails['cookieTime'] . $programDetails['cookiePeriod'] ?> -->
								<input class="input_wd48 mr_rgt2 input_float inputclear form-control" name="cookieTime" size="6" value="<?= $programDetails['cookieTime'] ?>" onkeypress="return CheckNumeric(event);" />
								<select class="input_wd48 input_float selectpicker" size="1" name="cookiePeriod" data-style="btn-primary btn-outline" data-menu-style="dropdown-blue">
									<option value="Day(s)" <?= ($programDetails['cookiePeriod'] == "day" ? "selected='selected'" : "") ?>><?= $common_day ?></option>
									<option value="Minute(s)" <?= ($programDetails['cookiePeriod'] == "minute" ? "selected='selected'" : "") ?>><?= $common_min ?></option>
									<option value="Hour(s)" <?= ($programDetails['cookiePeriod'] == "hour" ? "selected='selected'" : "") ?>><?= $common_hr ?></option>
									<option value="Year(s)" <?= ($programDetails['cookiePeriod'] == "year" ? "selected='selected'" : "") ?>><?= $common_year ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="text-danger"><input type="checkbox" name="mailme" value="yes" <?= ($programDetails['mailmerchant'] == "yes") ? "checked" : "" ?> />
							&nbsp;<?= $lpgm_Sendemailtomewhentransactionappears ?></label>
					</div>
					<br />
					<div class="form-group float-left">
						<input name="currValue" type="hidden" value="<?= $currValue ?>" />
						<input class="btn btn-success btn-wd" type="button" onclick="CheckRecurringPeriod();" name="B1" value=" <?= $lpgm_Submit ?>" class="button" />
						<input class="btn btn-outline btn-default btn-wd" type="reset" name="B2" value=" <?= $lpgm_Reset ?>" class="button" />
					</div>
				</div>
			</div>
			<!--Affiliate Approval, Ip Blocking, geo countries and Cookie settings -->
		</div>
	</div>
</form>
<script language="javascript" type="text/javascript">
	var lead = document.getElementById("lead");
	lead.style.display = "none";
	var lead_com = document.getElementById("lead_comm");
	lead_com.style.display = "none";
	var sale = document.getElementById("sale");
	sale.style.display = "";
	var sale_com = document.getElementById("comm_sale");
	sale_com.style.display = "";

	//......................Onchange function...............................
	var element = document.getElementById("commission_type");
	element.addEventListener("change", myFunction);

	function myFunction() {
		var x = document.getElementById("commission_type").value;
		console.log(x);
		if (x == 'sale') {
			var lead = document.getElementById("lead");
			lead.style.display = "none";
			var lead_com = document.getElementById("lead_comm");
			lead_com.style.display = "none";
			var sale = document.getElementById("sale");
			sale.style.display = "";
			var sale_com = document.getElementById("comm_sale");
			sale_com.style.display = "";
		}
		if (x == 'lead') {
			var lead = document.getElementById("lead");
			lead.style.display = "";
			var lead_com = document.getElementById("lead_comm");
			lead_com.style.display = "";
			var sale = document.getElementById("sale");
			sale.style.display = "none";
			var sale_com = document.getElementById("comm_sale");
			sale_com.style.display = "none";
		}


	}
</script>