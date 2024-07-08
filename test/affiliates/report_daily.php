<?
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$AFFILIATEID	= trim($_SESSION['AFFILIATEID']);
	 $programs       = intval(trim($_POST['programs']));
	
	$d                =$_GET['d'];
	$m                =$_GET['m'];
	$y                =$_GET['y'];
	
	if (empty($_SESSION['PROGRAMID']) || $programs == 0)
		$_SESSION['PROGRAMID']='All';
	if (!empty($programs))
		$_SESSION['PROGRAMID']=$programs;
	
	 $PROGRAMID		= $_SESSION['PROGRAMID'];               //setting program id to session
	$sql			= " SELECT * from partners_joinpgm,partners_program where joinpgm_affiliateid='$AFFILIATEID' 
						AND joinpgm_status not like ('waiting') and joinpgm_programid=program_id "; //adding to drop down box
	$result2		= mysqli_query($con,$sql);                     //adding     to dropdown box

    if (empty($d)){
		$today		= getdate();
		$d			= $today['mday'];
		$m			= date("m");  //setting as todays
		$y          = $today['year'];
	}
	$dateoftrans	= $y."-".$m."-".$d;
	
	switch($PROGRAMID){
		case 'All':
			$sql	= " SELECT * from partners_joinpgm,partners_program where joinpgm_affiliateid='$AFFILIATEID' 
						and joinpgm_programid=program_id   ";
			
			# calculate impressions
			$impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_affiliateid='$AFFILIATEID' ";
			
			$rawClick = GetRawTrans('click',  0, $AFFILIATEID, 0, 0,  0,0, $dateoftrans)   ;
			$rawImp   = GetRawTrans('impression', 0, $AFFILIATEID, 0, 0, 0, 0,$dateoftrans)   ;
		break;
		
		default:
			$sql	= " SELECT * from partners_joinpgm,partners_program where joinpgm_affiliateid='$AFFILIATEID' 
						and joinpgm_programid = program_id and program_id = '$PROGRAMID'";
			
			# calculate impressions
			$impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_affiliateid='$AFFILIATEID' 
						and imp_programid = '$PROGRAMID'";
			
			$rawClick = GetRawTrans('click',  0, $AFFILIATEID, $PROGRAMID, 0,  0,0, $dateoftrans)   ;
			$rawImp   = GetRawTrans('impression', 0, $AFFILIATEID, $PROGRAMID, 0, 0, 0,$dateoftrans)   ;
		break;
	}
	$result1		= mysqli_query($con,$sql);

	$impression		= 0;
    $click          = 0;
    $lead           = 0;
    $sale           = 0;
    $nclick         = 0;
    $nlead        	= 0;
    $nsale       	= 0;

	$impSql    .= " and imp_date = '$dateoftrans'";
	$impRet		= mysqli_query($con,$impSql);
	$row_impr	= mysqli_fetch_object($impRet);
	$numRec		= $row_impr->impr_count;
	if($numRec == '') 
		$numRec = 0;

    while( $rows=mysqli_fetch_object($result1)){
		 $joinid = $rows->joinpgm_id; //getting affiliates joined pgms for aprticular merchant
		$sql    = " SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' 
					and transaction_type='impression' and transaction_joinpgmid = $joinid";
		$result = mysqli_query($con,$sql);
		while($row=mysqli_fetch_object($result))
		{
		$date		 =   $row->transaction_dateoftransaction;
		$imp_amt	= $row->transaction_amttobepaid;
		$impression = $imp_amt + $impression;
		
		}
		//End add on 17-JUNE-06
		

	    $sql      ="SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='click' and transaction_joinpgmid='$joinid'";
	    $result   =mysqli_query($con,$sql);
	    $nclick   =mysqli_num_rows($result)+$nclick;   //no of click
	    while($row=mysqli_fetch_object($result))
	    {
				$date		 =   $row->transaction_dateoftransaction;
	    		$click_amt	= $row->transaction_amttobepaid;
				
				$click    = $click_amt + $click;  //click amnt
	    }

	    $sql      ="SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='lead' and transaction_joinpgmid='$joinid'";
	    $result   =mysqli_query($con,$sql);
	    $nlead    =mysqli_num_rows($result)+$nlead;  //no of lead

	    while($row=mysqli_fetch_object($result))
	    {
				$date		 =   $row->transaction_dateoftransaction;
	    		$lead_amt	= $row->transaction_amttobepaid;
	    		
				$lead     = $lead_amt + $lead;  //lead amnt
	    }

	    $sql      ="SELECT *  from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid='$joinid'";
	    $result   =mysqli_query($con,$sql);
	    $nsale    =mysqli_num_rows($result)+$nsale;  //no of sales
	    while($row=mysqli_fetch_object($result))
	    {
	//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
			 $transactionId	= $row->transaction_id;
			 $recur 	 = 	$row->transaction_recur;
	
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
						$date		 =   $row_recurpay->recurpayments_date;
						$sale_amt	= $row_recurpay->recurpayments_amount;
						
						$sale 	 = $sale_amt  + $sale; 
					}
				}
			 }
			 else
			 {	 
	// END Modified on 23-JUNE-06
				$date		 =   $row->transaction_dateoftransaction;
	    		$sale_amt	= $row->transaction_amttobepaid;
	
			    $sale    = $sale_amt + $sale;  //sale amnt
			 }
	    }
    }
    /**************************************************************************/
 ?>  
	
<form name="Getprogram"  method="post" action="">
	<div class="card stacked-form">
		<div class="card-body"> 
			<div class="row"> 
				<div class="col-md-8">
					<div class="row"> 
						<div class="col-md-8">
							<div class="form-group">
								<label><?=$lang_home_pgms?></label>		
								<select name="programs" onchange="document.Getprogram.submit()" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
									<option value="All" <?php if($PROGRAMID == 0){ echo "selected = 'selected'"; }?> ><?=$lang_home_all_pgms?></option>
									<?  
									while($row=mysqli_fetch_object($result2)){
										if($PROGRAMID=="$row->program_id")
											$programName="selected = 'selected'";
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
							</div>
							<?
							$selDate = $d.".".$m.".".$y;	
							$values	= $numRec."~".$impression."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale."~".$nsubsale."~".$subsale."~".$currSymbol;	
							?>
						</div>
					</div>	
					<p><?=$lang_report?> <? echo "$d.$m.$y" ?></p>
					<div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<th><?=$lang_home_transaction?></th>
								<th><?=$lang_home_number?></th>
								<th><?=$lang_home_commission?></th>
							</thead>
							<tbody>
								<tr>
									<td><?=$lang_affiliate_imp?></td>
									<td><?=$numRec?></td>
									<td><?=$currSymbol?><?=number_format((float)$impression,2)?></td>
								</tr>
								<tr>
									<td><?=$lang_affiliate_head_click?>&nbsp;<img
					  alt="" border="0" height="10" src="../images/click.gif"
					 width="10"/></td>
									<td><?=$nclick?></td>
									<td><?=$currSymbol?><?=number_format((float)$click,2)?></td>
								</tr>
								<tr>
									<td><?=$lang_affiliate_head_lead?>&nbsp;<img
					 alt="" border="0"   height="10" src="../images/lead.gif"
					 width="10"/></td>
									<td><?=$nlead?></td>
									<td><?=$currSymbol?><?=number_format((float)$lead,2)?></td>
								</tr>
								<tr>
									<td><?=$lang_affiliate_head_sale?>&nbsp;<img
					  alt="" border="0" height="10" src="../images/sale.gif"
					  width="10"/></td>
									<td><?=$nsale?></td>
									<td><?=$currSymbol?><?=number_format((float)$sale,2)?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-4">
					<div class="export_link">
						<a href="#" onClick="window.open('../print_daily.php?aid=<?=$AFFILIATEID?>&mode=affiliate&date=<?=$selDate?>&values=<?=$values?>&program=<?=$PROGRAMID?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_daily.php?aid=<?=$AFFILIATEID?>&mode=affiliate&date=<?=$selDate?>&values=<?=$values?>&program=<?=$PROGRAMID?>"><b><?=$lang_export_csv_head?></b></a>
					</div>
				<?php				
				include 'calender.php';
				$d 			= $_GET['d'];
				$m 			= $_GET['m'];
				$y          = $_GET['y'];				
				class MyCalendar1 extends Calendar{				
					function getCalendarLink($month, $year){
						$s		= getenv('SCRIPT_NAME');
						$act    = $_GET['Action'];
						$qry    = "?";
						$sep    = "" ;
						foreach($_GET as $k => $v) {
							if($k=="month" or $k=="year") 
								continue;
							$qry.=$sep.$k."=".$v;
							$sep="&";
						}
						return "$s$qry&amp;month=$month&amp;year=$year";
					}
				
					function getDateLink($day, $month, $year){
						// Only link the first day of every month
						$link = "";
						return $link;
					}				
				}				
				
				if ($month == ""){
					$month = date("m");
				}
				if ($year == ""){
					$year = date("Y");
				}				
				$cal1 = new MyCalendar1($id);
				echo $cal1->getMonthView($month, $year);
				?>
				<? viewRawTrans($rawClick, $rawImp) ?>
				</div>
			</div>
		</div>
	</div>
</form> 