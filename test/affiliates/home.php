<?php
  include "transaction.php";

  $AFFILIATEID  =$_SESSION['AFFILIATEID'];
  $programs     =trim($_POST['programs']);

  ##Modified on 18.JUNE.06
  $rawClick1	=0;
  $rawImp1      =0;

  if (empty($programs))
       $programs="All";

  $sql="SELECT * from partners_joinpgm,partners_program where joinpgm_affiliateid=$AFFILIATEID and joinpgm_status not like('waiting') and program_id=joinpgm_programid"; //adding to drop down box

  $result=mysqli_query($con,$sql);
  switch ($programs)//checking program
      {
       case 'All';    //all pgm
           $sql			=	"SELECT * from partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID " ;
           $joinpgmid	=	0;

           # impression tracking
           $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE  imp_affiliateid = $AFFILIATEID ";

			 ##Modified on 18.JUNE.06
            $rawClick = GetRawTrans('click',  0, $AFFILIATEID, 0, 0,  $From,$To, 0)   ;
    		$rawImp   = GetRawTrans('impression', 0, $AFFILIATEID, 0, 0,  $From,$To, 0)   ;
           break;

       default:    //selected pgm
           $sql			=	"SELECT * from partners_joinpgm where joinpgm_id=$programs ";
           $joinpgmid	=	$programs;

	   ##Modified on 18.JUNE.06
		   # impression tracking
           $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily,partners_joinpgm WHERE  imp_affiliateid = $AFFILIATEID  and joinpgm_id =$programs AND joinpgm_programid = imp_programid";

           # impression tracking
           $rawCSql = " SELECT sum(transdaily_click) as rawclick_count FROM partners_rawtrans_daily,partners_joinpgm WHERE  transdaily_affiliateid = $AFFILIATEID   AND transdaily_programid = joinpgm_programid and joinpgm_id =$programs";

            # impression tracking
           $rawISql = " SELECT sum(transdaily_impression) as rawimpression_count FROM partners_rawtrans_daily,partners_joinpgm WHERE  transdaily_affiliateid = $AFFILIATEID   AND transdaily_programid = joinpgm_programid and joinpgm_id =$programs";
			/*
            $rawCRet	= mysqli_query($con,$rawCSql);
   			$rawClick	= mysqli_num_rows($rawCRet);

            $rawIRet	= mysqli_query($con,$rawISql);
   			$rawImp 	= mysqli_num_rows($rawIRet);
			*/
            $rawCRet        = mysqli_query($con,$rawCSql);

            $cRow           = mysqli_fetch_object($rawCRet);
            $rawClick        = $cRow->{rawclick_count};

            $rawIRet        = mysqli_query($con,$rawISql);

            $iRow           = mysqli_fetch_object($rawIRet);
            $rawImp         = $iRow->{rawimpression_count};
	   ### End Modified on 18.JUNE.06
           break;
      }

   $impRet	= mysqli_query($con,$impSql);
        $row_impr = mysqli_fetch_object($impRet);
        $numRec = $row_impr->impr_count;
        if($numRec == '') $numRec = 0;

 
  $total=GetPaymentDetails($sql,$currValue,$default_currency_caption); //getting payments (click,sale,lead) values
  $total =explode('~',$total);


  $totallink=GetLinks($joinpgmid,$AFFILIATEID);       //getting advertising links
  $totallink =explode('~',$totallink);

  $sql="select * from partners_joinpgm where joinpgm_id=$joinpgmid";
  $ret1=mysqli_query($con,$sql);
  $field=mysqli_fetch_object($ret1);
  $pgmid=$field->joinpgm_programid;


    $sqlpgm	= " SELECT * from partners_joinpgm, partners_program where joinpgm_affiliateid = '$AFFILIATEID' 
						and joinpgm_status not like('waiting') and joinpgm_programid = program_id   ";
			
   $retpgm1 = mysqli_query($con,$sqlpgm);
  $fieldpgm = mysqli_fetch_object($retpgm1);
 
  $pgmids = $fieldpgm->joinpgm_id;
  
  
/*Count Programs*/
/*  $sqlprogram 	= "SELECT count(*) as scount from partners_program where program_merchantid='$AFFILIATEID'";  */
 $sqlprogram = "SELECT count(*) as scount FROM partners_program, partners_merchant WHERE program_status LIKE ('active')
						AND program_merchantid=merchant_id ";
$resultprogram	= mysqli_query($con,$sqlprogram);
$countprogram	= mysqli_fetch_object($resultprogram);
/*End Count Programs*/

$affiliatename	= trim(stripslashes($_POST['affiliate']));

$sql        =" SELECT  distinct( c.joinpgm_id) ,a.affiliate_id, a.affiliate_firstname, a.affiliate_lastname, c.joinpgm_status,c.joinpgm_programid" ;
$sql        =$sql." FROM partners_affiliate a, partners_joinpgm c, partners_transaction e";
$sql        =$sql." WHERE e.transaction_status =  'pending' and c.joinpgm_merchantid='$AFFILIATEID' AND e.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_affiliateid = a.affiliate_id " ;
if(!empty($affiliatename)){
	$affiliatename1		 =addslashes($affiliatename);
	$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
}

$ret         =mysqli_query($con,$sql);
$pending     =mysqli_num_rows($ret) ;
/*Start Daily Record*/ 
$ids = array();
$sqlpgms	= " SELECT * from partners_joinpgm, partners_program where joinpgm_affiliateid = '$AFFILIATEID' 
						and joinpgm_status not like('waiting') and joinpgm_programid = program_id   ";
			
   $retpgm1 = mysqli_query($con,$sqlpgms);
 while($rows=mysqli_fetch_array($retpgm1)){
	  $joinid	= $rows['joinpgm_id'];
	  $ids[] = $joinid;
  $sqlcountclick = "select SUM(transaction_amttobepaid) clicktrans, count(*) as countclick from partners_transaction where transaction_joinpgmid = '$joinid' and DATE(transaction_dateoftransaction) = DATE(NOW()) and transaction_type = 'click'";
$resultclick   = mysqli_query($con,$sqlcountclick);
$nclick   = mysqli_num_rows($resultclick);
$transclick = mysqli_fetch_array($resultclick);
  $sqlcountlead = "select SUM(transaction_amttobepaid)  as leadtrans, count(*) as countlead from partners_transaction where transaction_joinpgmid = '$joinid' and DATE(transaction_dateoftransaction) = DATE(NOW()) and transaction_type = 'lead'";
$resultlead   = mysqli_query($con,$sqlcountlead);
$nlead   = mysqli_num_rows($resultlead);
$translead = mysqli_fetch_array($resultlead);
  $sqlcountsale = "select SUM(transaction_amttobepaid) as saletrans, count(*) as countsale from partners_transaction where transaction_joinpgmid = '$joinid' and DATE(transaction_dateoftransaction) = DATE(NOW()) and transaction_type = 'sale'";
$resultsale   = mysqli_query($con,$sqlcountsale);
$nsale  = mysqli_num_rows($resultsale);
$transsale = mysqli_fetch_array($resultsale);
 $sqlcountimpre = "select SUM(transaction_amttobepaid) as impresstrans, count(*) as countimpression from partners_transaction where transaction_joinpgmid = '$joinid' and DATE(transaction_dateoftransaction) = DATE(NOW()) and transaction_type = 'impression'";
$resultimpre   = mysqli_query($con,$sqlcountimpre);
$transimpre = mysqli_fetch_array($resultimpre);
$totalsales += $transsale['saletrans'];
$totallead += $translead['leadtrans'];
$totalclick += $transclick['clicktrans'];
$totalimpres += $transimpre['impresstrans'];

$totalcountclick += $transclick['countclick'];
$totalcountlead += $translead['countlead'];
$totalcountsale+= $transsale['countsale'];
$totalcountimpression += $transimpre['countimpression'];

}

$totaltransaction1 = $totalcountclick + $totalcountlead + $totalcountsale + $totalcountimpression;
$totaltransaction = $totalsales + $totallead + $totalclick;
$pclick = $totaltransaction1 ? ($totalcountclick * 100) / $totaltransaction1 : 0;
$plead = $totaltransaction1 ? ($totalcountlead * 100) / $totaltransaction1 : 0;
$psale = $totaltransaction1 ? ($totalcountsale * 100) / $totaltransaction1 : 0; 

/*End Daily Record*/ 

/*Start Monthly Record*/ 
$year = date('Y');
$month = date('m');
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
  $resultmsale   = mysqli_query($con,$sqlcountmsale);
/*End Monthly Record*/
 while($rowsale = mysqli_fetch_array($resultmsale)){
	  $yearsale = $rowsale;
  }
  
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
	//$weekvalue .= "'".$dayweek."',"; 
	 $mno = date('d M', strtotime($dayweek));
	$sqlmsale .="SUM(if( WEEK(transaction_dateoftransaction)= WEEK('".$dayweek."'), transaction_amttobepaid,0)) as '".$mno."',";
	//$sqlmsale .="SUM(if( YEARWEEK(transaction_dateoftransaction)= YEARWEEK('".$dayweek."'), transaction_amttobepaid,0)) as '".$mno."',";
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
/* echo $sqlcountmsale = "SELECT $sqlmsale FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) and transaction_dateoftransaction > DATE_SUB(now(), INTERVAL 1 WEEK) AND transaction_type = 'sale'"; */
for($date = $start_date; $date <= $end_date; $date = date('Y-m-d', strtotime($date. ' + 7 days'))) {
    $month = getWeekDates($date, $start_date, $end_date, $i);

	$weekvalue .= "'".$month['to']."',"; 
	
	$From = $month['from'];
	$To = $month['to'];
       $sqlcountmsale = "SELECT  SUM(transaction_amttobepaid) AS reports_in_week,transaction_joinpgmid
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

 $sqlcountmlead = "SELECT  SUM(transaction_amttobepaid) AS reports_in_week,transaction_joinpgmid
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

 $sqlcountmclick = "SELECT  SUM(transaction_amttobepaid) AS reports_in_week,transaction_joinpgmid
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




 /* $value = mysqli_fetch_assoc($resultmsale);
foreach($value as $key => $val){
	$wsale .= "".$val.","; 
}  */


  /*  $sqlcountmlead = "SELECT  SUM(transaction_amttobepaid) AS reports_in_week,
    DATE_ADD(transaction_dateoftransaction, INTERVAL(7-DAYOFWEEK(transaction_dateoftransaction)) DAY) FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) AND YEAR(transaction_dateoftransaction) = '$year' AND MONTH(transaction_dateoftransaction) = '$month' and transaction_type = 'lead' GROUP BY WEEK(transaction_dateoftransaction)";  */
/* $sqlcountmlead = "SELECT $sqlmsale FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) and transaction_dateoftransaction > DATE_SUB(now(), INTERVAL 1 WEEK) AND transaction_type = 'lead'"; */
/* $resultmlead  = mysqli_query($con,$sqlcountmlead);
 while($rowwl=mysqli_fetch_object($resultmlead))
{
	$wlead .= "".$rowwl->reports_in_week.","; 
}  */

/*  $value1 = mysqli_fetch_assoc($resultmlead);
foreach($value1 as $key1 => $val1){
	$wlead .= "".$val1.","; 
}  */

/* $sqlcountmclick = "SELECT $sqlmsale FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids) and transaction_dateoftransaction > DATE_SUB(now(), INTERVAL 1 WEEK) AND transaction_type = 'click'"; */
 /*  $sqlcountmclick = "SELECT  SUM(transaction_amttobepaid) AS reports_in_week,
    DATE_ADD(transaction_dateoftransaction, INTERVAL(7-DAYOFWEEK(transaction_dateoftransaction)) DAY) FROM partners_transaction 
WHERE transaction_joinpgmid IN ($psids') AND YEAR(transaction_dateoftransaction) = '$year' and transaction_type = 'click' AND MONTH(transaction_dateoftransaction) = '$month' GROUP BY WEEK(transaction_dateoftransaction)"; 
$wclicks = 0;
$wclick = '';
$resultmclick  = mysqli_query($con,$sqlcountmclick); */
/* $value2 = mysqli_fetch_assoc($resultmclick);
 foreach($value2 as $key2 => $val2){
	$wclick .= "".$val2.","; 
} */ 
 /* while($rowwc=mysqli_fetch_object($resultmclick))
{
	$wclick .= "".$rowwc->reports_in_week.","; 
}  */
 

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
								<p class="card-category"><?=$lang_AccountBalance?> </p>
								<h4 class="card-title"><?=$currSymbol?><?$value =$_SESSION['AFFILIATEBALANCE'];								
								echo $mainval= number_format((float)$value, 2, '.', '');  // Outputs -> 105.00?>
                          </h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa "></i> <a href="index.php?Act=request"> <?=$affiliate_request?></a>
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
								<p class="card-category"><?=$lhome_TodaySpend?></p>
								<?php
								$todayspendtotal = $totaltransaction;
								?>
								<h4 class="card-title"><?=$currSymbol?><?=number_format($todayspendtotal,2)?></h4>
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
								<i class="nc-icon nc-vector text-danger"></i>
							</div>
						</div>
						<div class="col-7">
							<div class="numbers">
								<p class="card-category"><?=$lhome_LiveAffiliates?></p>
								<h4 class="card-title"><?=$countprogram->scount?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer ">
					<hr>
					<div class="stats">
						<i class="fa "></i> <a href="index.php?Act=Affiliates&joinstatus=All">View</a>
					</div>
				</div>
			</div>
		</div>
		<!--<div class="col-lg-3 col-sm-6">
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
						<i class="fa "></i> <a href="index.php?Act=Affiliates&joinstatus=All">View</a>
					</div>
				</div>
			</div>
		</div>-->
	</div>
	<div class="row">
	<div class="col-md-4">
			<div class="card ">
				<div class="card-header ">
					<h4 class="card-title">Daily Totals</h4>
					<p class="card-category">Clicks Vs Sales Vs Leads</p>
				</div>
				<div class="card-body ">
					<div id=chartEmail class="ct-chart ct-perfect-fourth"></div>
				</div>
				<div class="card-footer ">
				<div class="legend">
					<i class="fa fa-circle text-info chatclicks"></i> Clicks (<?php echo $totalcountclick; ?>)
					<i class="fa fa-circle text-danger chatleads"></i> Leads (<?php echo $totalcountlead; ?>)
					<i class="fa fa-circle text-warning chatsale"></i> Sales (<?php echo $totalcountsale; ?>)
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
					<h4 class="card-title">Monthly Commissions (By Week)</h4>
					<p class="card-category">Clicks Vs Sales Vs Leads</p>
				</div>
				<div class="card-body ">
					<div id=chartHours class="ct-chart"></div>
				</div>
				<div class="card-footer ">
					<div class="legend">
						<!--<i class="fa fa-circle text-info chatclicks"></i> Clicks-->
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
					<h4 class="card-title">Yearly Commissions</h4>
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
					$lastloginsql = mysqli_query($con,"select * from user_log where user_id = '$AFFILIATEID' and type='a' order by date DESC limit 1"); 
					$lastlogrow = mysqli_fetch_array($lastloginsql);
					?>
					<h4 class="card-title">Login History</h4>
					<p class="card-category">Last Login ip: <?php echo $lastlogrow['ip']; ?></p>
				</div>
				<div class="card-body ">
					<div class="table-full-width">
					<?php $loginsql = mysqli_query($con,"select * from user_log where user_id = '$AFFILIATEID' and type='a' order by date DESC limit 7"); ?>
						<table class="table">
							<tbody>
							<?php while($logrow = mysqli_fetch_array($loginsql)){


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
									
									
									<td><?php echo $logrow['ip']; ?> - <?php echo date('d/m/Y',strtotime($logrow['date'])); ?> @ <?php echo date('H:i',strtotime($logrow['date'])); ?></td>
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
<script language="javascript" type="text/javascript">

	var pclick = '<?php echo ceil($pclick); ?>';
	var plead = '<?php echo ceil($plead); ?>';
	var psale = '<?php echo ceil($psale); ?>';
	var yearclick = '<?php echo json_encode($yearclick); ?>';
	var yearsale = '<?php echo json_encode($yearsale); ?>';
	var saledate = <?php echo '['.rtrim($weekvalue,',').']'; ?>;
	var yearMsale = <?php echo '['.rtrim($wsale,',').']'; ?>;
	var yearMclicks = <?php echo '[0,0,0,0,0]'; ?>;
	var yearMleads = <?php echo '['.rtrim($wlead,',').']'; ?>;
   function getpage(){
	   var Action		= (document.report.reportRE.value);
	   var url			= "index.php?Act="+Action; 
	   document.report.action	= url ;
	   document.report.submit();
   }
</script>
