<?php
$comaign = unserialize(get_user_info($leadgenid,'av_campaign',true));
/* Daily Records*/
$nimpress = countaffilatesdaily($leadgenid, 'impression');
$nsubmission = countaffilatesdaily($leadgenid, 'submissions');
$nconfirlead = countaffilatesdaily($leadgenid, 'confirm_leads');

/*Monthly Count*/

$cmimpress = countaffilatesmonthly($leadgenid, 'impression');
$cmsubmission = countaffilatesmonthly($leadgenid, 'submissions');
$cmconfirlead = countaffilatesmonthly($leadgenid, 'confirm_leads');
/*-----------------*/

/*Yearly Count*/

$cysubmission = countaffilatesyearly($leadgenid, 'submissions');
$cyconfirlead = countaffilatesyearly($leadgenid, 'confirm_leads');
$countconfirmleadsyearly_db = countconfirmleadsyearly($leadgenid, 'confirm_leads');
$countsubmissionsyearly = countconfirmleadsyearly($leadgenid, 'submissions');
/*-----------------*/

$totaltoday = $nimpress + $nsubmission + $nconfirlead;
$pimpress = $nimpress / $totaltoday * 100;
$psubmission = $nsubmission / $totaltoday * 100;
$pconfirlead = $nconfirlead / $totaltoday * 100;

/*Yearly*/
$submissionyearly = yearlyaffilates($leadgenid,'submissions');
$leadsyearly =  yearlyaffilates($leadgenid,'confirm_leads');



//$leadsyearly =  countusa($leadgenid,'confirm_leads',$month);
//$submissionyearly = countusa($leadgenid,'submissions','4','apr');



/* Monthly */

$mimpress = monthlyaffilates($leadgenid, 'impression');
$msubmission = monthlyaffilates($leadgenid, 'submissions');
$mconfirlead = monthlyaffilates($leadgenid, 'confirm_leads');

/*Today Spend*/
$totaltodaycharge = 0;
foreach($comaign as $l){
	$companydatas = unserialize(base64_decode(get_config_meta('company_data', $l, true)));
	$companydata  = unserialize($companydatas['config']);

	$impressionval = $companydata['impression_amt'];
	$subval = $companydata['submission_amt'];
	$qlval = $companydata['qualified_lead_amt'];
	$simpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'impression' and campagin_id = '$l'");
					
	$ssimpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'submissions' and campagin_id = '$l'");
	$climpression = mysqli_query($con,"select * from av_affilates_charges where DATE(date) = CURDATE() and lead_type = 'confirm_leads' and campagin_id = '$l'");

	$countimpre1 = mysqli_num_rows($simpression);
	$countsub1 = mysqli_num_rows($ssimpression);
	$countsale1 = mysqli_num_rows($climpression);


	$totaltodaycharge += ($impressionval * $countimpre1) + ($subval * $countsub1) + ($qlval * $countsale1);
}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-4 col-sm-6">
			<div class="card card-stats">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center icon-warning">
								<i class="nc-icon nc-money-coins text-warning"></i>
							</div>
						</div>
						<div class="col-7">
							<div class="numbers">
								<p class="card-category">Account Balance </p>
								<h4 class="card-title"><?=$currSymbol?><?=number_format(leaduserinfo('balance'),2)?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa "></i> <a href="index.php?Act=add_money">Add Money To Account</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-sm-6">
			<div class="card card-stats">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center icon-warning">
								<i class="nc-icon nc-bank text-success"></i>
							</div>
						</div>
						<div class="col-7">
							<div class="numbers">
								<p class="card-category">Today's Spend</p>
								
						
								<h4 class="card-title"><?=$currSymbol?><?=number_format($totaltodaycharge,2)?></h4>
							</div>
						</div> 
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa "></i> <?php echo date('d/m/Y'); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-4 col-sm-6">
			<div class="card card-stats">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center icon-warning">
								<i class="nc-icon nc-paper-2 text-primary"></i>
							</div>
						</div>
						<div class="col-7">
							<div class="numbers">
								<p class="card-category">Campaigns</p>
								<h4 class="card-title"><?=count($comaign)?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa "></i> <a href="index.php?Act=campaign">View</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row"> 
		<div class="col-md-4">
			<div class="card ">
				<div class="card-header ">
					<h4 class="card-title">Daily</h4>
					<p class="card-category">Impressions Vs Submissions Vs Qualified/Confirm Leads</p>
				</div>
				<div class="card-body ">
					<div id=chartEmail class="ct-chart ct-perfect-fourth"></div>
				</div>
				<div class="card-footer ">
				<div class="legend">
					<i class="fa fa-circle text-info chatclicks"></i> Impressions (<?= $nimpress ?>)
					<i class="fa fa-circle text-danger chatleads"></i> Submissions (<?= $nsubmission ?>)
					<i class="fa fa-circle text-warning chatsale"></i> Qualified/Confirm Leads (<?= $nconfirlead ?>)
				</div>
				<hr>
				<div class="stats">
					<i class="fa fa-clock-o"></i> <?php echo date('d/m/Y'); ?>
				</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card ">
				<div class="card-header ">
					<h4 class="card-title">Monthly</h4>
					<p class="card-category">Impressions Vs Qualified/Confirm Leads Vs Leads</p>
				</div>
				<div class="card-body ">
					<div id=chartHours class="ct-chart"></div>
				</div>
				<div class="card-footer ">
					<div class="legend">
						<i class="fa fa-circle text-info chatclicks"></i> Impressions (<?= $cmimpress ?>)
						<i class="fa fa-circle text-warning chatleads"></i> Submissions (<?= $cmsubmission ?>)
						<i class="fa fa-circle text-danger chatsale"></i> Qualified/Confirm Leads (<?= $cmconfirlead ?>)
						
					</div>
					<hr>
					<div class="stats">
						<i class="fa fa-history"></i> <?php echo date('F'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="card ">
				<div class="card-header ">
					<h4 class="card-title">Yearly</h4>
					<p class="card-category">Submissions Vs Qualified/Confirm Leads Affilate Charges detail monthly Wise</p>
				</div>
				<div class="card-body ">
					<div id="chartActivity" class="ct-chart"></div>
				</div>
				<div class="card-footer ">
					<div class="legend">
						<i class="fa fa-circle text-info chatleads"></i> Submissions (<?= $countsubmissionsyearly ?>)
						<i class="fa fa-circle text-danger chatsale"></i> Qualified/Confirm Leads (<?= $countconfirmleadsyearly_db ?>)
					</div>
					<hr>
					<div class="stats">
						<i class="fa fa-check"></i> Data Last Updated: <?php echo date('Y'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card  card-tasks">
				<div class="card-header ">
					<?php 
					$lastloginsql = select("user_log","user_id = '$leadgenid'order by date DESC limit 1"); 
					$lastlogrow = mysqli_fetch_array($lastloginsql)
					?>
					<h4 class="card-title">Login History</h4>
					<p class="card-category">Last Login ip: <?php echo $lastlogrow['ip']; ?></p>
				</div>
				<div class="card-body ">
					<div class="table-full-width">
					<?php $loginsql = select("user_log","user_id = '$leadgenid'order by date DESC limit 7"); ?>
						<table class="table">
							<tbody>
							<?php while($logrow = mysqli_fetch_array($loginsql)){ 
							
							$logrow['date'];
							
							?>
								<tr>
									<td>
										<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" value="">
												<span class="form-check-sign"></span>
											</label>
										</div>
									</td>
									<td><?php echo $logrow['ip']; ?> - <?php echo date('d/m/Y',strtotime($logrow['date'])); ?> @ <?php echo date('h:i',strtotime($logrow['date'])); ?></td>
									<td class="td-actions text-right">
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="now-ui-icons loader_refresh spin"></i> Last Succesful Login: <?php echo date('d/m/Y',strtotime($lastlogrow['date'])); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
if(is_nan($pimpress) == 1){
	$pimpress = 0; 
}
if(is_nan($psubmission) == 1){
	$psubmission = 0; 
}
if(is_nan($pconfirlead) == 1){
	$pconfirlead = 0; 
}
?>
<script language="javascript" type="text/javascript">
	var pclick = <?php echo round($pimpress); ?>;
	var plead = <?php echo round($psubmission); ?>;
	var psale = <?php echo round($pconfirlead); ?>;
	var yearclick = '<?php echo json_encode($submissionyearly); ?>';
	var yearsale = '<?php echo json_encode($leadsyearly); ?>';
	var saledate = <?php echo '['.rtrim($mimpress['weekvalue'],',').']'; ?>;
	var yearMsale = <?php echo '['.rtrim($mconfirlead['wsale'],',').']'; ?>;
	var yearMclicks = <?php echo '['.rtrim($mimpress['wsale'],',').']'; ?>;
	var yearMleads = <?php echo '['.rtrim($msubmission['wsale'],',').']'; ?>;
	//alert(yearclick);
	//alert(pclick + ", " + plead + ", " + psale + ", " + yearclick + ", " + yearsale + ", "+ saledate + "," + yearMsale + ", " + yearMclicks + ", " + yearMleads);
</script> 