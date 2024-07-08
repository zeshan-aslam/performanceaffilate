<?php
include "transactions.php";
include "../mail.php";

$MERCHANTID    = $_SESSION['MERCHANTID'];   //merchantid
$joinid        = intval(trim($_POST['joinid'])); //joinpgmid
$pgmid         = intval(trim($_GET['pgmid']));   //programid
$mode          = ($_SERVER['REQUEST_METHOD'] == "POST" ? 1 : "");

# Perform selected action
# Reverse Sale
if ($mode && isset($_POST['affilate_status'])) {
	$affilate_status = $_POST['affilate_status'];
	$sql	= " update partners_joinpgm set joinpgm_status='$affilate_status' where joinpgm_id='$joinid '";
	@mysqli_query($con, $sql);

	$sql	= " select * from partners_login, partners_joinpgm where joinpgm_id='$joinid' and login_flag='a' 
					and joinpgm_affiliateid=login_id";
	$ret1	= @mysqli_query($con, $sql);

	$row	= @mysqli_fetch_object($ret1);
	$to   	= $row->login_email;

	MailEvent(ucfirst($affilate_status) . " AffiliateProgram", $MERCHANTID, $joinid, $to, 0);
	$pgmid        = 0;
}

# select programs
switch ($pgmid) {
	case '0':
		$sql	= " select * from partners_joinpgm, partners_affiliate where joinpgm_merchantid = '$MERCHANTID' 
						and joinpgm_status not like ('waiting') and joinpgm_affiliateid = affiliate_id ";
		break;

	default:       //selected pgm
		$sql	= " select * from partners_joinpgm, partners_affiliate where joinpgm_programid='$pgmid'
						and joinpgm_status not like ('waiting') and joinpgm_affiliateid=affiliate_id ";
		break;
}

$result   = @mysqli_query($con, $sql);
$result1  = @mysqli_query($con, $sql);

if (@mysqli_num_rows($result1) > 0) //checking for records
{
	$rows   = @mysqli_fetch_object($result1);
	$id     = $rows->joinpgm_id;  //for first time
	if (empty($joinid))  $joinid = $id;

	# getting affiliates information
	$status      = GetAffiliateStatus($joinid);
	$status      = explode('~', $status);
	# getting program payment information
	$details     = GetAffiliateDetails($joinid);
	$details     = explode('~', $details);

	# getting affiliates paayment information
	$total       = GetPaymentDetails1($joinid, $currValue, $default_currency_caption);
	$total       = explode('~', $total);

	# getting affiliates paymentstatus
	$payStatus   = GetPaymentStaus($joinid, $currValue, $default_currency_caption);
	$payStatus   = explode('~', $payStatus);

	$sql         	= " select * from partners_joinpgm,partners_program 
			  					where joinpgm_id='$joinid' and program_id = joinpgm_programid";
	$ret         = @mysqli_query($con, $sql);
	$field       = @mysqli_fetch_object($ret);
	$pgmname     = stripslashes($field->program_url); //getting page url
	$cate_ids = explode(",", $details[4]);
	$fetchCategories  = "SELECT cat_name FROM `partners_category` WHERE cat_id IN ($details[4])";
	$response  = mysqli_query($con,$fetchCategories);
	$allCategories =""; 
	while($data = mysqli_fetch_array($response))
		{
		   $allCategories.= $data['cat_name']." | ";
		}
		
	

?>
	<!-- Table 1-->
	<form name="GetAffiliate" method="post" action="index.php?Act=listaffiliate&amp;pgmid=<?= $pgmid ?>">
		<div class="card stacked-form">
			<div class="card-header">
				<h5 style="display: inline-block;" class="card-title"><?= $ltotaff_AffiliateStaistics ?></h5>
				<a style="float:right;" href="index.php?Act=programs">Back</a>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?= $ltotaff_Program ?>: <b><?= $pgmname ?></b></label>
						</div>
					</div>
					<div class="col-md-6">
						<label><?= $ltotaff_Affiliate ?></label>
						<select name="joinid" onchange="document.GetAffiliate.submit()" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
							<? while ($row = mysqli_fetch_object($result)) {
								if ($joinid == "$row->joinpgm_id")
									$AffiliateName = "selected = 'selected'";
								else
									$AffiliateName = "";
							?>
								<option <?= $AffiliateName ?> value="<?= $row->joinpgm_id ?>"> <?= stripslashes($row->affiliate_company) ?> </option>
							<?  }  ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="card strpied-tabled-with-hover">
			<div class="row">
				<div class="col-md-6">
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th colspan="2"><?= $ltotaff_PersonalDetails ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?= $ltotaff_Name ?></td>
									<td><?= $details[0] ?></td>
								</tr>
								<tr>
									<td><?= $ltotaff_Status ?></td>
									<td><?= $status[0] ?></td>
								</tr>
								<tr>
									<td><?= $ltotaff_JoiningDate ?></td>
									<td><?= $status[1] ?></td>
								</tr>
								<tr>
									<td><?= $ltotaff_Category ?></td>
									<!-- <td><?= $details[4] ?></td> -->
									<td>
									<?=rtrim($allCategories," | ")?>
									</td>

								</tr>
								<tr>
									<td><?= $ltotaff_Company ?></td>
									<td><?= $details[1] ?></td>
								</tr>
								<tr>
									<td><?= $ltotaff_SiteUrl ?></td>
									<td><?= $details[2] ?></td>
								</tr>
								<tr>
									<td><?= $ltotaff_SiteTraffic ?></td>
									<td><?= $details[3] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th><?= $ltotaff_Transaction ?></th>
									<th><?= $ltotaff_Commission ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?= $ltotaff_Click ?>&nbsp;<img alt="" border="0" height="10" src="../images/click.gif" width="10" /></td>
									<td><?= $currSymbol ?> <?= number_format($total[1], 2) ?> </td>
								</tr>
								<tr>
									<td><?= $ltotaff_Lead ?>&nbsp;<img alt="" border="0" height="10" src="../images/lead.gif" width="10" /></td>
									<td><?= $currSymbol ?> <?= number_format($total[3], 2) ?> </td>
								</tr>
								<tr>
									<td><?= $ltotaff_Sale ?>&nbsp;<img alt="" border="0" height="10" src="../images/sale.gif" width="10" /></td>
									<td><?= $currSymbol ?> <?= number_format($total[5], 2) ?> </td>
								</tr>
								<tr>
									<td><?= $ltotaff_Reversed ?></td>
									<td><?= $currSymbol ?> <?= number_format($payStatus[3], 2) ?> </td>
								</tr>
								<tr>
									<td><?= $ltotaff_Pending ?></td>
									<td><?= $currSymbol ?> <?= number_format($payStatus[1], 2) ?> </td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-12 text-center">
					<div class="form-group">
						<?php if ($status[0] == 'suspend') {
						?>
							<button type="submit" class="btn btn-info" name="affilate_status" value="approved" title="<?= $ltotaff_Approved ?>"><?= $common_approve ?></button>
						<?php
						} else if ($status[0] == 'approved') {
						?>
							<button type="submit" class="btn btn-danger" name="affilate_status" value="suspend" title="<?= $ltotaff_Suspend ?>"><?= $common_suspend ?></button>
						<?php
						} ?>

					</div>
				</div>
			</div>
		</div>
	</form>

<?php
} else {
?>
	<div class="card strpied-tabled-with-hover">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="card-body table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<tr>
							<td><?= $norec ?></td>
						<tr>
					</table>
				</div>
			</div>
		</div>
	</div>
<?
}
?>