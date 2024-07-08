<?php

$programs    = trim($_POST['programs']);        //programid

if (empty($_SESSION['PROGRAMID']))
	$_SESSION['PROGRAMID'] = 'All';

$d                = $_GET['d'];
$m                = $_GET['m'];
$y                = $_GET['y'];

if (!empty($programs))
	$_SESSION['PROGRAMID'] = $programs;

$PROGRAMID       = $_SESSION['PROGRAMID'];
$MERCHANTID      = $_SESSION['MERCHANTID'];    //merchantid

if (empty($d)) {
	$today  = getdate();
	$d      = $today['mday'];
	$m      = date("m");     //setting as todays
	$y      = $today['year'];
}

//adding programs to dropdown
$sql      = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
$result2  = mysqli_query($con, $sql);

$dateoftrans  = $y . "-" . $m . "-" . $d;

//getting statistics based on seacrh
switch ($PROGRAMID) {
	case 'All':
		$sql = "SELECT * from partners_joinpgm,partners_program where program_merchantid='$MERCHANTID' and  joinpgm_programid=program_id   ";

		# calculate impressions
		$impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid = '$MERCHANTID' and imp_date ='$dateoftrans' ";


		$rawClick = GetRawTrans('click', $MERCHANTID, 0, 0, 0,  0, 0, $dateoftrans);
		$rawImp   = GetRawTrans('impression', $MERCHANTID, 0, 0, 0,  0, 0, $dateoftrans);

		break;
	default:
		$sql = "SELECT * from partners_joinpgm,partners_program where program_id='$PROGRAMID' and  joinpgm_programid=program_id   ";

		# calculate impressions
		$impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_programid = $PROGRAMID  and imp_date ='$dateoftrans' ";

		$rawClick = GetRawTrans('click',  0, 0, $PROGRAMID, 0,  0, 0, $dateoftrans);
		$rawImp   = GetRawTrans('impression', 0, 0, $PROGRAMID, 0, 0, 0, $dateoftrans);


		break;
}
//   echo "this is a test after query to test";

$impRet	= mysqli_query($con, $impSql);
$row_impr = mysqli_fetch_object($impRet);
$numRec	= $row_impr->impr_count;
if ($numRec == '') $numRec = 0;

//  if (!$numRec) echo "Error1".mysqli_error($con);

// echo "this is a test after query 11";
//  exit;

$result1                  = mysqli_query($con, $sql) or die($sql . mysqli_error($con));

$click                    = 0;
$lead                     = 0;
$sale                     = 0;
$nclick                   = 0;
$nlead                    = 0;
$nsale                    = 0;
$impression               = 0;
$impression_counts		  = 0;


//   echo "this is a test after query 1";
while ($rows = mysqli_fetch_object($result1)) {
	$joinid   = $rows->joinpgm_id; //getting affiliates joined pgms for aprticular merchant

	$sql      = "SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='click' and transaction_joinpgmid='$joinid'";
	$result   = mysqli_query($con, $sql);
	$nclick   = mysqli_num_rows($result) + $nclick;   //no of click
	// echo "this is a test after query2";
	while ($row = mysqli_fetch_object($result)) {
		# get transaction details
		$date		 =   $row->transaction_dateoftransaction;
		$affAmnt 	 =   $row->transaction_amttobepaid;
		$adminAmnt    =   $row->transaction_admin_amount;

		# converting to user currency
		if ($currValue != $default_currency_caption) {
			$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
			$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
		}

		$click                 = $affAmnt + $adminAmnt + $click;  //click amnt
	}

	$sql                  = "SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='lead' and transaction_joinpgmid='$joinid'";
	$result               = mysqli_query($con, $sql);
	$nlead                = mysqli_num_rows($result) + $nlead;  //no of lead
	//   echo "this is a test after query3";
	while ($row = mysqli_fetch_object($result)) {
		# get transaction details
		$date		 =   $row->transaction_dateoftransaction;
		$affAmnt 	 =   $row->transaction_amttobepaid;
		$adminAmnt    =   $row->transaction_admin_amount;

		# converting to user currency
		if ($currValue != $default_currency_caption) {
			$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
			$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
		}
		$lead                = $affAmnt + $adminAmnt + $lead;  //lead amnt
	}

	// $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
	$sql                 = "SELECT *  from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid='$joinid'";
	$result              = mysqli_query($con, $sql);
	$nsale               = mysqli_num_rows($result) + $nsale;  //no of sales
	//  echo "this is a test after query4";
	while ($row = mysqli_fetch_object($result)) {
		# get transaction details
		$date		 =   $row->transaction_dateoftransaction;
		$adminAmnt    =   $row->transaction_admin_amount;
		//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
		$transactionId	= $row->transaction_id;
		$recur 	 = 	$row->transaction_recur;

		// If the sale commission is of recurring type
		if ($recur == '1') {
			$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
			$res_Recur	= mysqli_query($con, $sql_Recur);
			if (mysqli_num_rows($res_Recur) > 0) {
				$row_recur	= mysqli_fetch_object($res_Recur);
				$recurId	= $row_recur->recur_id;

				$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
				$res_recurpay	= mysqli_query($con, $sql_recurpay);
				if (mysqli_num_rows($res_recurpay) > 0) {
					$row_recurpay 	= mysqli_fetch_object($res_recurpay);
					$affAmnt 	 =  $row_recurpay->recurpayments_amount;
				}
			}
		}
		// END Modified on 23-JUNE-06
		else {
			$affAmnt 	 =   $row->transaction_amttobepaid;
		}

		# converting to user currency
		if ($currValue != $default_currency_caption) {
			$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
			$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
		}
		$sale                = $affAmnt + $adminAmnt + $sale;  //sale amnt
	}




	#== Modified on JuNE.17.06 by SMA to get the impression commission
	$sql      		= "SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='impression' and transaction_joinpgmid='$joinid'";
	$result   		= mysqli_query($con, $sql);

	while ($row = mysqli_fetch_object($result)) {
		# get transaction details
		$date         =   $row->transaction_dateoftransaction;
		$affAmnt      =   $row->transaction_amttobepaid;
		$adminAmnt    =   $row->transaction_admin_amount;
		$trans_id     =   $row->transaction_id;

		# converting to user currency
		if ($currValue != $default_currency_caption) {
			$affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
			$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
		}

		$impression   = $affAmnt + $adminAmnt + $impression;  //impression amnt
	}
	#== End of Modification on  JuNE.17.06 by SMA  to get the impression commission

}

if ($currSymbol == "&pound") $currSymbol = "&pound;";
?>

<form name="Getprogram" method="post" action="">
	<!-- <div class="card stacked-form"> -->
	<!-- <div class="card-body">  -->
	<div class="row">
		<div class="col-md-8">
			<div class="card stacked-form">
				<div class="row mt-2 ml-1">
					<div class="col-md-8">
						<div class="form-group">
							<label><?= $lang_report_pgm ?></label>
							<select name="programs" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue" onchange="document.Getprogram.submit()">
								<option value="All"><?= $lang_report_AllProgram ?></option>
								<? while ($row = mysqli_fetch_object($result2)) {
									if ($PROGRAMID == "$row->program_id")
										$programName = "selected";
									else
										$programName = "";
								?>
									<option <?= $programName ?> value="<?= $row->program_id ?>">
										<?= $common_id ?>:<?= $row->program_id ?>...<?= stripslashes($row->program_url) ?> </option>
								<?
								}
								?>
							</select>
						</div>
						<? $selDate		= $d . "." . $m . "." . $y;
						$values	= $numRec . "~" . $impression . "~" . $nclick . "~" . $click . "~" . $nlead . "~" . $lead . "~" . $nsale . "~" . $sale . "~" . $nsubsale . "~" . $subsale . "~" . $currSymbol;
						?>
					</div>
				</div>
				<p class="ml-2"><?= $lang_report_stat ?> <? echo "$d.$m.$y" ?></p>
				<div class="table-responsive border">
					<table class="table table-hover table-striped">
						<thead>
							<th><?= $lang_report_transaction ?></th>
							<th><?= $lang_report_number ?></th>
							<th><?= $lang_report_commission ?></th>
						</thead>
						<tbody>
							<tr>
								<td><?= $lhome_Imp ?></td>
								<td><?= $numRec ?></td>
								<td><?= $currSymbol ?> <?= number_format($impression, 2) ?></td>
							</tr>
							<tr>
								<td><?= $lang_report_click ?>&nbsp;<img alt="" border="0" height="10" src="../images/click.gif" width="10" /></td>
								<td><?= $nclick ?></td>
								<td><?= $currSymbol ?> <?= number_format($click, 2) ?></td>
							</tr>
							<tr>
								<td><?= $lang_report_lead ?>&nbsp;<img alt="" border="0" height="10" src="../images/lead.gif" width="10" /></td>
								<td><?= $nlead ?></td>
								<td><?= $currSymbol ?> <?= number_format($lead, 2) ?></td>
							</tr>
							<tr>
								<td><?= $lang_report_sale ?>&nbsp;<img alt="" border="0" height="10" src="../images/sale.gif" width="10" /></td>
								<td><?= $nsale ?></td>
								<td><?= $currSymbol ?> <?= number_format($sale, 2) ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

		</div>
		<div class="col-md-4">
			<div class="card stacked-form">
				<div class="export_link mt-3 text-center">
					<a class="btn btn-primary" href="#" onClick="window.open('../print_daily.php?mid=<?= $MERCHANTID ?>&mode=merchant&date=<?= $selDate ?>&values=<?= $values ?>&program=<?= $PROGRAMID ?>','new','400,400,scrollbars=1,resizable=1');"><b><?= $lang_print_report_head ?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="../csv_daily.php?mid=<?= $MERCHANTID ?>&mode=merchant&date=<?= $selDate ?>&values=<?= $values ?>&program=<?= $PROGRAMID ?>"><b><?= $lang_export_csv_head ?></b></a>
				</div>
				<?php
				include 'calender.php';
				$d                = $_GET['d'];
				$m                = $_GET['m'];
				$y                = $_GET['y'];

				//adding calender

				class MyCalendar1 extends Calendar
				{
					function getCalendarLink($month, $year)
					{
						$s                         = getenv('SCRIPT_NAME');
						$act        = $_GET['Action'];

						$qry                = "?";
						$sep                = "";

						foreach ($_GET as $k => $v) {
							if ($k == "month" or $k == "year") continue;
							$qry .= $sep . $k . "=" . $v;
							$sep = "&";
						}
						return "$s$qry&amp;month=$month&amp;year=$year";
					}

					function getDateLink($day, $month, $year)
					{
						// Only link the first day of every month
						$link = "";
						return $link;
					}
				}
				if ($month == "") {
					$month = date("m");
				}
				if ($year == "") {
					$year = date("Y");
				}
				$cal1 = new MyCalendar1($id);
				echo $cal1->getMonthView($month, $year);
				?>
				<? viewRawTrans($rawClick, $rawImp) ?>
			</div>

		</div>
	</div>
	<!-- </div> -->
	<!-- </div> -->
</form>