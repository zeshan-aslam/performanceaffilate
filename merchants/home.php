<?php
	include "transactions.php";
error_reporting(0);

	
	$MERCHANTID		= $_SESSION['MERCHANTID']; # merchantid



	$programs		= intval(trim($_POST['programs'])); #  programid
	$rawClick		= 0; 
	$rawImp			= 0;
	
	if (empty($programs))
		$programs	= "All";
	else
	$_SESSION['PGMID']	= $programs;

	# data to add to dropdown box
	$sql        = " SELECT * FROM partners_program WHERE program_merchantid = '$MERCHANTID'";
	$result     = mysqli_query($con,$sql);


	# sql depending on pgm selected
	switch ($programs){
		case 'All';    # all pgm
			#$sql		= " SELECT * FROM partners_joinpgm WHERE joinpgm_merchantid = '$MERCHANTID' " ;
			$sql		= " SELECT * FROM partners_joinpgm, partners_affiliate   WHERE joinpgm_merchantid = '$MERCHANTID' 
				AND affiliate_id = joinpgm_affiliateid " ;
			$pgmid		= 0;
			
			# calculate impressions
			$impSql 	= " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily 
							WHERE imp_merchantid = '$MERCHANTID' ";
			
			$rawClick 	= GetRawTrans('click', $MERCHANTID, 0, 0, 0,  0,0, 0)   ;
			$rawImp   	= GetRawTrans('impression', $MERCHANTID, 0, 0, 0,  0,0, 0) ;
		
		break;
		default: 
			#$sql		= " SELECT * FROM partners_joinpgm WHERE joinpgm_programid = '$programs'";
			$sql		= " SELECT * FROM partners_joinpgm, partners_affiliate   WHERE joinpgm_programid = '$programs' 
					AND affiliate_id = joinpgm_affiliateid ";
			$pgmid		= $programs;
			
			# calculate impressions
			$impSql 	= " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_programid = '$programs' ";
			
			$rawClick = GetRawTrans('click', 0, 0, $programs, 0,  0,0, 0) ;
			$rawImp   = GetRawTrans('impression', 0, 0, $programs, 0,  0,0, 0) ;
		break;
	}
	
	# getting statistics for selected program
	# getting payments from transaction.php(click,sale,lead) values
	$total		= GetPaymentDetails($sql,$currValue,$default_currency_caption); 
	$total		= explode('~',$total);
	# getting total affiliates,waiting affiliates,transactions from transaction.php
	$afftotal	= GetTotalAffiliates($sql); 



	$afftotal	= explode('~',$afftotal);
	# getting advertising links from transaction.php
	$totallink	= GetLinks($pgmid,$MERCHANTID);
	$totallink  = explode('~',$totallink);

	$impRet		= mysqli_query($con,$impSql);
	$row_impr 	= mysqli_fetch_object($impRet);
	$numRec 	= $row_impr->impr_count;
	if($numRec == '') 
		$numRec = 0;
	if($currSymbol=="&pound") 
		$currSymbol = "&pound;";

/*Count Programs*/
 $MERCHANTID  = $_SESSION['MERCHANTID'];
 $sqlprogram 	= "SELECT count(*) as scount from partners_program where program_merchantid='$MERCHANTID'"; 
$resultprogram	= mysqli_query($con,$sqlprogram);
$countprogram	= mysqli_fetch_object($resultprogram);
/*End Count Programs*/

$affiliatename	= trim(stripslashes($_POST['affiliate']));

$sql        =" SELECT  distinct( c.joinpgm_id) ,a.affiliate_id, a.affiliate_firstname, a.affiliate_lastname, c.joinpgm_status,c.joinpgm_programid" ;
$sql        =$sql." FROM partners_affiliate a, partners_joinpgm c, partners_transaction e";
$sql        =$sql." WHERE e.transaction_status =  'pending' and c.joinpgm_merchantid='$MERCHANTID' AND e.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_affiliateid = a.affiliate_id " ;
if(!empty($affiliatename)){
	$affiliatename1		 =addslashes($affiliatename);
	$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
}
$ret         =mysqli_query($con,$sql);
$pending     =mysqli_num_rows($ret) ;
/*Start Daily Record*/ 
$ids = array();
$getprogramid = mysqli_query($con,"select * from partners_joinpgm where joinpgm_merchantid = '$MERCHANTID'");
	while($getprogramidrow = mysqli_fetch_array($getprogramid)){
		
		 $joinid	= $getprogramidrow['joinpgm_id'];
	     $ids[] = $joinid;

		$sqlcountclick = "select * from partners_transaction where transaction_joinpgmid = '$joinid' and DATE(transaction_dateoftransaction) = DATE(NOW()) and transaction_type = 'click'";
		$resultclick   = mysqli_query($con,$sqlcountclick);
		$nclick   += mysqli_num_rows($resultclick);
		
		$sqlcountlead = "select * from partners_transaction where transaction_joinpgmid = '$joinid' and DATE(transaction_dateoftransaction) = DATE(NOW()) and transaction_type = 'lead'";
		$resultlead   = mysqli_query($con,$sqlcountlead);
		$nlead   += mysqli_num_rows($resultlead);
		
		$sqlcountsale = "select * from partners_transaction where transaction_joinpgmid = '$joinid' and DATE(transaction_dateoftransaction) = DATE(NOW()) and transaction_type = 'sale'";
		$resultsale   = mysqli_query($con,$sqlcountsale);
		$nsale  += mysqli_num_rows($resultsale);

		$todays_date = date('Y-m-d');	

		$sqlsumsale = "SELECT SUM(transaction_amttobepaid)+SUM(transaction_admin_amount) Total, count(*)  AS clicksales from partners_transaction WHERE transaction_joinpgmid = '$joinid' and transaction_dateoftransaction = '$todays_date' and transaction_type = 'sale'";
		
		$resultsale   = mysqli_query($con,$sqlsumsale);
		$rowsale = mysqli_fetch_array($resultsale);		
		$addedtogetherslaes = $rowsale['Total'];

		$totalsalescount += $rowsale['clicksales'];
		///// check zero sum in database
			if($addedtogetherslaes==''){
			
			$addedtogetherslaes = '0';
			
		} 
		$sqlsumclick = "SELECT SUM(transaction_amttobepaid)+SUM(transaction_admin_amount) Total, count(*)  AS clickclick from partners_transaction WHERE transaction_joinpgmid = '$joinid' and transaction_dateoftransaction = '$todays_date' and transaction_type = 'click'";
		
		$resultclick   = mysqli_query($con,$sqlsumclick);
		$rowclick = mysqli_fetch_array($resultclick);		
		$addedtogetherclick = $rowclick['Total'];

		$totalclickcount += $rowclick['clickclick'];
		 if($addedtogetherclick==''){   
			
			$addedtogetherclick = '0';
			
		} 
		$sqlsumlead = "SELECT SUM(transaction_amttobepaid)+SUM(transaction_admin_amount) Total, count(*)  AS clicklead from partners_transaction WHERE transaction_joinpgmid = '$joinid' and transaction_dateoftransaction = '$todays_date' and transaction_type = 'lead'";
		
		$resultlead = mysqli_query($con,$sqlsumlead);
		$rowlead = mysqli_fetch_array($resultlead);		
		$addedtogetherlead = $rowlead['Total'];
		///// get total count of click
		$totalclickleadcount += $rowlead['clicklead'];
		 if($addedtogetherlead==''){
			
			$addedtogetherlead = '0';
			
		} 
		
		$total_daily_payment_show = $addedtogetherclick + $addedtogetherlead + $addedtogetherslaes; //counting todays spend
		
		
}

$totaltoday = $nclick + $nlead + $nsale;
$pclick = $nclick / $totaltoday * 100;
$plead = $nlead / $totaltoday * 100;
$psale = $nsale / $totaltoday * 100;

/*End Daily Record*/ 

/*Start Yearly Record*/ 
$year = date('Y');
for($is = 0; $is < count($ids); $is++){
	$isd = $ids[$is]; 
	$psids .= "'$isd',";
  }
 $psids = rtrim($psids,',');
 $sqlcountmlead = "SELECT 
    SUM(if(MONTH(transaction_dateoftransaction) = 1, transaction_amttobepaid,0)) as Jan,
    SUM(if(MONTH(transaction_dateoftransaction) = 2, transaction_amttobepaid,0)) as Feb,
    SUM(if(MONTH(transaction_dateoftransaction) = 3, transaction_amttobepaid,0)) as Mar,
    SUM(if(MONTH(transaction_dateoftransaction) = 4, transaction_amttobepaid,0)) as Apr,
    SUM(if(MONTH(transaction_dateoftransaction) = 5, transaction_amttobepaid,0)) as May,
    SUM(if(MONTH(transaction_dateoftransaction) = 6, transaction_amttobepaid,0)) as Jun,
    SUM(if(MONTH(transaction_dateoftransaction) = 7, transaction_amttobepaid,0)) as Jul,
    SUM(if(MONTH(transaction_dateoftransaction) = 8, transaction_amttobepaid,0)) as Aug,
    SUM(if(MONTH(transaction_dateoftransaction) = 9, transaction_amttobepaid,0)) as Sep,
    SUM(if(MONTH(transaction_dateoftransaction) = 10, transaction_amttobepaid,0)) as Oct,
    SUM(if(MONTH(transaction_dateoftransaction) = 11, transaction_amttobepaid,0)) as Nov,
    SUM(if(MONTH(transaction_dateoftransaction) = 12, transaction_amttobepaid,0)) as `Dec`
FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) and YEAR(transaction_dateoftransaction) = '$year' 
  AND transaction_type = 'lead'";
  $resultmlead   = mysqli_query($con,$sqlcountmlead);
  while($rowlead = mysqli_fetch_array($resultmlead)){
	  $yearclick = $rowlead;
  }

  $sqlcountmsale = "SELECT 
    SUM(if(MONTH(transaction_dateoftransaction) = 1, transaction_amttobepaid,0)) as Jan,
    SUM(if(MONTH(transaction_dateoftransaction) = 2, transaction_amttobepaid,0)) as Feb,
    SUM(if(MONTH(transaction_dateoftransaction) = 3, transaction_amttobepaid,0)) as Mar,
    SUM(if(MONTH(transaction_dateoftransaction) = 4, transaction_amttobepaid,0)) as Apr,
    SUM(if(MONTH(transaction_dateoftransaction) = 5, transaction_amttobepaid,0)) as May,
    SUM(if(MONTH(transaction_dateoftransaction) = 6, transaction_amttobepaid,0)) as Jun,
    SUM(if(MONTH(transaction_dateoftransaction) = 7, transaction_amttobepaid,0)) as Jul,
    SUM(if(MONTH(transaction_dateoftransaction) = 8, transaction_amttobepaid,0)) as Aug,
    SUM(if(MONTH(transaction_dateoftransaction) = 9, transaction_amttobepaid,0)) as Sep,
    SUM(if(MONTH(transaction_dateoftransaction) = 10, transaction_amttobepaid,0)) as Oct,
    SUM(if(MONTH(transaction_dateoftransaction) = 11, transaction_amttobepaid,0)) as Nov,
    SUM(if(MONTH(transaction_dateoftransaction) = 12, transaction_amttobepaid,0)) as `Dec`
FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) and YEAR(transaction_dateoftransaction) = '$year' 
  AND transaction_type = 'sale'";
  $resultmlead   = mysqli_query($con,$sqlcountmsale);
  while($rowlead = mysqli_fetch_array($resultmlead)){
	  $yearsale = $rowlead;
  }
 /*Start End Record*/ 
/* Today Spend*/
$sqlclicks = "SELECT * from partners_transaction where DATE(transaction_dateoftransaction)=DATE(NOW()) and transaction_type='click' and transaction_joinpgmid='$MERCHANTID'";
$resultcli   = mysqli_query($con,$sqlclicks);
while($rowcl =mysqli_fetch_object($resultcli))
{
	# get transaction details
	$date		 =   $rowcl->transaction_dateoftransaction;
	$affAmnt 	 =   $rowcl->transaction_amttobepaid;
	$adminAmnt    =   $rowcl->transaction_admin_amount;
	
	# converting to user currency
	if($currValue != $default_currency_caption){
		$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
		$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
	}
	
	$click = $affAmnt + $adminAmnt + $click; 
}

$sqlleads  ="SELECT * from partners_transaction where DATE(transaction_dateoftransaction)=DATE(NOW()) and transaction_type='lead' and transaction_joinpgmid='$MERCHANTID'";
$resultll = mysqli_query($con,$sqlleads);
while($rowll=mysqli_fetch_object($resultll))
{
	# get transaction details
	$date		 =   $rowll->transaction_dateoftransaction;
	$affAmnt 	 =   $rowll->transaction_amttobepaid;
	$adminAmnt    =   $rowll->transaction_admin_amount;
	
	# converting to user currency
	if($currValue != $default_currency_caption){
		$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
		$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
	}
	$lead =$affAmnt + $adminAmnt + $lead;  //lead amnt
}

$sqlsale  ="SELECT *  from partners_transaction where DATE(transaction_dateoftransaction)=DATE(NOW()) and transaction_type='sale' and transaction_joinpgmid='$MERCHANTID'";
$resultss = mysqli_query($con,$sqlsale);  //no of sales
//  echo "this is a test after query4";
while($rowss=mysqli_fetch_object($resultss))
{
	# get transaction details
	$date		 =   $rowss->transaction_dateoftransaction;
	$adminAmnt    =   $rowss->transaction_admin_amount;
//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
	 $transactionId	= $rowss->transaction_id;
	 $recur 	 = 	$rowss->transaction_recur;

	  // If the sale commission is of recurring type
	 if($recur == '1') 
	 {
		$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
		$res_Recur	= mysqli_query($con,$sql_Recur);
		if(mysqli_num_rows($res_Recur) > 0)
		{
			$row_recur	= mysqli_fetch_object($res_Recur);
			$recurId	= $row_recur->recur_id;
			
			$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
			$res_recurpay	= mysqli_query($con,$sql_recurpay);
			if(mysqli_num_rows($res_recurpay) > 0)
			{
				$row_recurpay 	= mysqli_fetch_object($res_recurpay);
				$affAmnt 	 =  $row_recurpay->recurpayments_amount; 
			}
		}
	 }
// END Modified on 23-JUNE-06
	 else
	 {	 
		$affAmnt 	 =   $rowss->transaction_amttobepaid;
	 }
	
	# converting to user currency
	if($currValue != $default_currency_caption){
		$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
		$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
	}
	$sale  =$affAmnt + $adminAmnt + $sale;  //sale amnt
}

 $sqlimp = "SELECT * from partners_transaction where DATE(transaction_dateoftransaction)=DATE(NOW()) and transaction_type='impression' and transaction_joinpgmid='$MERCHANTID'";
$resultimp  = mysqli_query($con,$sqlimp);

while($rowimp =mysqli_fetch_object($resultimp))
{
	# get transaction details
	$date         =   $rowimp->transaction_dateoftransaction;
	$affAmnt      =   $rowimp->transaction_amttobepaid;
	$adminAmnt    =   $rowimp->transaction_admin_amount;
	$trans_id     =   $rowimp->transaction_id;

	# converting to user currency
	if($currValue != $default_currency_caption)
	{
		$affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
		$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
	}

	$impression   =$affAmnt + $adminAmnt + $impression;  //impression amnt
}

/*Start Monthly Record*/ 
$ids = array();
$sqlpgms	= " SELECT * from partners_joinpgm, partners_program where joinpgm_merchantid = '$MERCHANTID' and joinpgm_status not like('waiting') and joinpgm_programid = program_id";
			
   $retpgm1 = mysqli_query($con,$sqlpgms);
 while($rows=mysqli_fetch_array($retpgm1)){
	  $joinid	= $rows['joinpgm_id'];
	  $ids[] = $joinid;
 }
$year = date('Y');
$month = date('m');
  for($is = 0; $is < count($ids); $is++){
	$isd = $ids[$is]; 
	$psids .= "'$isd',";
  }
  $psids = rtrim($psids,',');
  
$lastmonthday = date('t');
$m = date('m');
$y = date('Y');

$sqlmsale = '';
$saledate = '';
$date = new DateTime('first Monday of this month');
$thisMonth = $date->format('m');
$weekvalue = '';
while ($date->format('m') === $thisMonth) {
    $dayweek = $date->format('Y-m-d');
	 $mno = date('d M', strtotime($dayweek));
	$sqlmsale .="SUM(if( WEEK(transaction_dateoftransaction)= WEEK('".$dayweek."'), transaction_amttobepaid,0)) as '".$mno."',";
    $date->modify('next Monday');
}
$month_ini = new DateTime("first day of this month");
$month_end = new DateTime("last day of this month");
$start_date = $month_ini->format('Y-m-d');
$end_date = $month_end->format('Y-m-d');
$i=1;


function getWeekDates($date, $start_date, $end_date, $i) {
    $week =  date('W', strtotime($date));
    $year =  date('Y', strtotime($date));
    $from = date("Y-m-d", strtotime("{$year}-W{$week}+1")); 
    if($from < $start_date) $from = $start_date;
    $to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   
    if($to > $end_date) $to = $end_date;
	$data = array(
		'from' => $from,
		'to' => $to,
	);
    return $data;
} 
$sqlmsale = rtrim($sqlmsale,',');
$wsale = '';
$wlead = '';
$wclick = '';

for($date = $start_date; $date <= $end_date; $date = date('Y-m-d', strtotime($date. ' + 7 days'))) {
    $month = getWeekDates($date, $start_date, $end_date, $i);

	$weekvalue .= "'".$month['to']."',"; 
	
	$From = $month['from'];
	$To = $month['to'];
       $sqlcountmsale = "SELECT  count(*) AS reports_in_week,transaction_joinpgmid
     FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) and transaction_dateoftransaction between '$From' and '$To' AND transaction_type = 'sale'";  
$resultmsale   = mysqli_query($con,$sqlcountmsale);
while($rowws=mysqli_fetch_object($resultmsale))
{
	if($rowws->reports_in_week == ''){
		$sales = 0;
	}else{
		$sales = $rowws->reports_in_week;
	}
	$wsale .= "".$sales.","; 
} 

 $sqlcountmlead = "SELECT  count(*) AS reports_in_week,transaction_joinpgmid
     FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) and transaction_dateoftransaction between '$From' and '$To' AND transaction_type = 'lead'";  
$resultmlead   = mysqli_query($con,$sqlcountmlead);
while($rowwl=mysqli_fetch_object($resultmlead))
{
	if($rowwl->reports_in_week == ''){
		$leads = 0;
	}else{
		$leads = $rowwl->reports_in_week;
	}
	$wlead .= "".$leads.","; 
} 

 $sqlcountmclick = "SELECT  count(*) AS reports_in_week,transaction_joinpgmid
     FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) and transaction_dateoftransaction between '$From' and '$To' AND transaction_type = 'click'";  
$resultmclick   = mysqli_query($con,$sqlcountmclick);
while($rowwc=mysqli_fetch_object($resultmclick))
{
	if($rowwc->reports_in_week == ''){
		$clicks = 0;
	}else{
		$clicks = $rowwc->reports_in_week;
	}
	$wclick .= "".$clicks.","; 
} 
    $i++;
}

$sqliu 	= "SELECT * from partners_program where program_merchantid='$MERCHANTID'";
  $results	= mysqli_query($con,$sqliu);
  $is = 0;
 while($rowd = mysqli_fetch_object($results)){
	 if($is == 0){
		 $program = $rowd->program_id;
	 }
	 $is++;
 }
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-3 col-sm-6">
			<div class="card card-stats">
				<div class="card-body ">
					<div class="row">
						<div class="col-3">
							<div class="icon-big text-center icon-warning">
								<i class="nc-icon nc-money-coins text-warning"></i>
							</div>
						</div>
						<div class="col-9">
							<div class="numbers">
								<p class="card-category"><?=$lang_AccountBalance?> </p>
								<h4 class="card-title"><?=$basecurrSymbol?><?=number_format($_SESSION['MERCHANTBALANCE'],2)?> </h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa "></i> <a  href="index.php?Act=add_money"> <?=$lang_AddMoneyToAccount?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-6">
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
								<p class="card-category"><?=$lhome_TodaySpend?></p>
								
						
								<h4 class="card-title"><?=$currSymbol.number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],$total_daily_payment_show),2)?></h4>
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
		<div class="col-lg-3 col-sm-6">
			<div class="card card-stats">
				<div class="card-body ">
					<div class="row">
						<div class="col-5">
							<div class="icon-big text-center icon-warning">
								<i class="nc-icon nc-vector text-danger"></i>
							</div>
						</div>
						<div class="col-7">
							<div class="numbers">
								<p class="card-category"><?=$lhome_LiveAffiliates?></p>
								<h4 class="card-title"><?=$afftotal[0]?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats text-center">
						<i class="fa "></i> <a  href="index.php?Act=affiliates&status=all">Pending
							 (<?php echo $pending; ?>)</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-sm-6">
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
								<p class="card-category"><?=$lhome_Program?></p>
								<h4 class="card-title"><?=$countprogram->scount?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa "></i> <a href="index.php?Act=programs&programId=<?=$program?>">View</a>
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
					<p class="card-category">Clicks Vs Sales Vs Leads</p>
				</div>
				<div class="card-body ">
					<div id=chartEmail class="ct-chart ct-perfect-fourth"></div>
				</div>
				<div class="card-footer ">
				<div class="legend">
					<i class="fa fa-circle text-info chatclicks"></i> Clicks (<?=$nclick?>)
					<i class="fa fa-circle text-danger chatleads"></i> Leads (<?=$nlead?>)
					<i class="fa fa-circle text-warning chatsale"></i> Sales (<?=$nsale?>)
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
					<p class="card-category">Clicks Vs Sales Vs Leads</p>
				</div>
				<div class="card-body ">
					<div id=chartHours class="ct-chart"></div>
				</div>
				<div class="card-footer ">
					<div class="legend">
						<i class="fa fa-circle text-info chatclicks"></i> Clicks
						<i class="fa fa-circle text-warning chatleads"></i> Leads
						<i class="fa fa-circle text-danger chatsale"></i> Sales
						
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
					<p class="card-category">Leads Vs Sales</p>
				</div>
				<div class="card-body ">
					<div id="chartActivity" class="ct-chart"></div>
				</div>
				<div class="card-footer ">
					<div class="legend">
						<i class="fa fa-circle text-info chatleads"></i> Leads
						<i class="fa fa-circle text-danger chatsale"></i> Sales
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
					$lastloginsql = mysqli_query($con,"select * from user_log where user_id = '$MERCHANTID' and type='m' order by date DESC limit 1"); 
					$lastlogrow = mysqli_fetch_array($lastloginsql)
					?>
					<h4 class="card-title">Login History</h4>
					<p class="card-category">Last Login ip: <?php echo $lastlogrow['ip']; ?></p>
				</div>
				<div class="card-body ">
					<div class="table-full-width">
					<?php $loginsql = mysqli_query($con,"select * from user_log where user_id = '$MERCHANTID' and type='m' order by date DESC limit 7"); ?>
						<table class="table">
							<tbody>
							<?php while($logrow = mysqli_fetch_array($loginsql)){ ?>
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
<?php /*
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" class="tablewbdr">
<?php
	# check whether the balance for this merchant has reached the maximum amount set up by the admin
	$merchant_sql = "SELECT pay_amount FROM  merchant_pay  WHERE pay_merchantid = '$MERCHANTID'";
    $merchant_ret = mysqli_query($con,$merchant_sql);
	if($merchant_row = mysqli_fetch_object($merchant_ret)) 
		$merchant_balance = $merchant_row->pay_amount;

	# if maximum limit (from constants.php) is reached
	if($merchant_balance>$merchant_maximum_amount){
		
		get message from file
		$filename			= "../admin/merchant_maximum_balance_msg.htm";
		$fp 				= fopen($filename,'r');
		$merchant_message 	= fread ($fp, filesize ($filename));
		fclose($fp);	
?>
   <tr>
      <td width="100%" colspan="3" align="center" height="30" class="textred"><?=$lhome_maximum_limit_reached?></td>
  </tr>
<?php
	}
?>
	<tr>
		<td width="100%" colspan="3" align="center" class="red" >
		<a href="index.php?Act=GetCode"><img src="../images/Get track code.gif" border="0" alt="" /></a>
		<center><a href="index.php?Act=GetCode"><?=$lhome_GetTrackingCode?></a> </center><br/> </td>
	</tr>
	<tr>
		<td width="70%">
		<form name="Getprogram" method="post" action="">
		<table border="0" cellpadding="0" cellspacing="2" width="90%"  align="center" class="tablebdr">
			<tr>
				<td width="100%"  colspan="3" align="center" class="tdhead"><B><?=$lhome_ProgramStaistics?></B></td>
			</tr>
			<tr>
				<td width="100%" align="right"height="40" colspan="3"  ><b><?=$lhome_Programs?></b>
				<select name="programs" onchange="document.Getprogram.submit()">
					<option value="All" ><?=$lhome_AllPrograms?></option>
				<?  
					while($row=mysqli_fetch_object($result)){
						if($programs=="$row->program_id")
							$programName="selected = \"selected\"";
						else
							$programName="";
				?>
					<option <?=$programName?> value="<?=$row->program_id?>">
						<?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> 
					</option>
				<?
					}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<td width="100%" height="130" colspan="3" >
					<table border="0" cellpadding="0" cellspacing="0"width="90%" align="center">
					<tr >
						<td width="50%" height="20" align="center" ><?=$lhome_TotalAffiliates?> - 
						<a href="index.php?Act=listaffiliate&amp;pgmid=<?=$pgmid?>"><?=$afftotal[0]?> </a></td>
						<td width="50%" height="20" align="center" ><?=$lhome_Transactions?> -  
						<a href="index.php?Act=waitingpgm&amp;pgmid=<?=$pgmid?>"><?=$afftotal[2]?></a></td>
					</tr>
					<tr >
						<td width="50%" height="20" align="center" ><?=$lhome_RotatorApplications?> - 
						<a href="index.php?Act=waitrotator&amp;pgmid=<?=$pgmid?>"> <?=$afftotal[3]?></a></td>
						<td width="50%" height="20" align="center" ><?=$lhome_ProgramApplications?> -  
						<a href="index.php?Act=waitingaff&amp;pgmid=<?=$pgmid?>"><?=$afftotal[1]?></a></td>
					</tr>
					</table>
				<br/>
				
				<table border="0" cellpadding="0" cellspacing="3" width="70%" class="tablebdr" align="center"> 
					<tr>
						<td width="34%" class="tdhead"><b><?=$lhome_Transaction?></b></td>
						<td width="26%" align="center" class="tdhead"><b><?=$lhome_Number?></b></td>
						<td width="40%" align="center"class="tdhead"><b><?=$lhome_Commission?></b> </td>
					</tr>
					<tr>
						<td width="35%" class="grid1"><?=$lhome_Imp?></td>
						<td width="26%" align="center" class="grid1"><?=$numRec?></td>
						<td width="39%" align="center" class="grid1" ><?=$currSymbol?><?=number_format($total[12],2)?> </td>
					</tr>
					<tr>
						<td width="35%"  class="grid1"><?=$lhome_Click?>&nbsp;
						<img alt="" border="0" height="10" src="../images/click.gif" width="10"/></td>
						<td width="26%" align="center" class="grid1" ><?=$total[0]?></td>
						<td width="39%" align="center"  class="grid1" ><?=$currSymbol?><?=number_format($total[1],2)?> </td>
					</tr>
					<tr>
						<td width="35%"  class="grid1" ><?=$lhome_Lead?>&nbsp;
						<img alt="" border="0" height="10" src="../images/lead.gif" width="10"/></td>
						<td width="26%" align="center" class="grid1"><?=$total[2]?></td>
						<td width="39%" align="center" class="grid1"><?=$currSymbol?><?=number_format($total[3],2)?> </td>
					</tr>
					<tr>
						<td width="35%" class="grid1"><?=$lhome_Sale?>&nbsp;
						<img alt="" border="0" height="10" src="../images/sale.gif" width="10"/></td>
						<td width="26%" align="center"  class="grid1"><?=$total[4]?></td>
						<td width="39%" align="center"  class="grid1"><?=$currSymbol?><?=number_format($total[5],2)?> </td>
					</tr>
				</table>
				<? viewRawTrans($rawClick, $rawImp) ?>
				<br/>
				<table border="0" cellpadding="0" cellspacing="0"width="99%" class="tablewbdr" align="center">
				<?
				if ($programs<>'All'){
					$tot=$totallink[1]+$totallink[2]+$totallink[3]+$totallink[4]+$totallink[0];
					if($tot==0){
				?>
						<tr>
							<td width="25%" class="tdhead" align="center" colspan="5"><?=$lhome_AdvertisingLinks?></td>
						</tr>
						<tr>
							<td width="20%" height="20" align="center" class="textred" colspan="5"><?=$no_links?></td>
						</tr>
						<tr>
							<td width="20%" align="center" colspan="5" >
							<a href="index.php?Act=addlinks" ><?=$lhome_ClickHereToAddLinks?></a></td>
						</tr>
				<?
					}
					else{
				?>
						<tr>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_text"><?=$lhome_Text?> - <?=$totallink[1]?></a></td>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_html"><?=$lhome_HTML?> - <?=$totallink[4]?></a></td>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_banner"><?=$lhome_Banner?> -<?=$totallink[0]?></a></td>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_popup"><?=$lhome_Popup?> - <?=$totallink[2]?></a></td>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_flash"><?=$lhome_Flash?> - <?=$totallink[3]?></a></td>
						</tr>
				<?
					}
				}
				?>
				
				</table>
				</td>
			</tr>
		</table>
		</form>
		</td>
		<td width="1%">&nbsp;</td>
		<td width="30%" valign="top">
		<form  name="report" method="post" action="#">
		<table border="0" cellpadding="0" cellspacing="3" align="left" width="80%" class="tablebdr">
			<tr>
			<td width="100%" class="tdhead" colspan="2" align="center"><b><?=$lhome_Statistics?></b></td>
			</tr>
			<tr>
				<td width="50%" class="grid1">
				<img border="0" height="12" src="../images/suspend.gif" width="12" alt=""/>&nbsp;<?=$lhome_Reversed?>&nbsp;</td>
				<td width="50%" align="center" class="grid1"><?=$currSymbol?><?=number_format($total[9],2)?> </td>
			</tr>
			<tr>
				<td width="50%" class="grid1">
				<img alt="" border="0" height="12" src="../images/waiting.gif" width="12"/>&nbsp;<?=$lhome_Pending?>&nbsp;</td>
				<td width="50%" align="center" class="grid1"><?=$currSymbol?><?=number_format($total[7],2)?> </td>
			</tr>
			<tr>
				<td width="100%" colspan="2" align="center">
				<a href="index.php?Act=reversesale&amp;pgmid=<?=$pgmid?>"><?=$lhome_ReverseSale?> </a></td>
			</tr>
			<tr>
			<td width="100%" colspan="2" align="center" class="tdhead" height="15"><?=$lhome_Report?></td>
			</tr>
			<tr>
				<td width="50%" align="center" ><?=$lhome_Search?></td>
				<td width="50%" align="center"  height="40"><select name="reportRE" onchange="getpage()">
				<option value="#"><?=$lhome_SelectReport?></option>
				<option value="daily"><?=$lhome_Daily?></option>
				<option value="forperiod"><?=$lhome_ForPeriod?></option>
				<option value="LinkReport"><?=$lhome_Links?></option>
				<option value="ProgramReport"><?=$lhome_Programs?></option>
				<option value="AffiliateReport"><?=$lhome_Affiliates?></option>
				</select></td>
			</tr>
		</table>
		</form>
	</td>
	</tr>
</table>
*/?>
<?php
if(is_nan($pclick) == 1){
	$pclick = 0; 
}
if(is_nan($plead) == 1){
	$plead = 0; 
}
if(is_nan($psale) == 1){
	$psale = 0; 
}
?>
<script language="javascript" type="text/javascript">

	var pclick = <?php echo ceil($pclick); ?>;
	var plead = <?php echo ceil($plead); ?>;
	var psale = <?php echo ceil($psale); ?>;
	var yearclick = '<?php echo json_encode($yearclick); ?>';
	var yearsale = '<?php echo json_encode($yearsale); ?>';
	var saledate = <?php echo '['.rtrim($weekvalue,',').']'; ?>;
	var yearMsale = <?php echo '['.rtrim($wsale,',').']'; ?>;
	var yearMclicks = <?php echo '['.rtrim($wclick,',').']'; ?>;
	var yearMleads = <?php echo '['.rtrim($wlead,',').']'; ?>;
   function getpage(){
	   var Action		= (document.report.reportRE.value);
	   var url			= "index.php?Act="+Action; 
	   document.report.action	= url ;
	   document.report.submit();
   } 
</script> 