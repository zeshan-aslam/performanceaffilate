<?
/*include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';

   	$partners=new partners;
   	$partners->connection($host,$user,$pass,$db);
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	
*/
	$nocol="0";
	
	
	$sql	= "SELECT * from partners_joinpgm,partners_program where joinpgm_affiliateid='$AFFILIATEID'  and joinpgm_status not like('waiting') and  program_id=joinpgm_programid"; //adding to drop down box
	$ret=mysqli_query($con,$sql);
	
	if(!$_POST['btnsub']=="View"){   
		$_SESSION['$msg']="";
		$_SESSION['$res']="";
		$schk="checked = 'checked'";
		$cchk="checked = 'checked'";
		$lchk="checked = 'checked'";
		$mchk="checked = 'checked'";
	}
	
	?>
	<script language="javascript" type="text/javascript">
		function from_date(){
			gfPop.fStartPop(document.trans.fromtxt,Date);
		}
		
		function to_date(){
			gfPop.fStartPop(document.trans.totxt,Date);
		}
	</script>
	
 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<form method="post" name="trans" id="trans" action="index.php?Act=TransReport">
	<div class="card stacked-form">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-6">
					<p><?=$lang_report_stat?></p>
					<span class="textred"><?=$_SESSION['$msg']?></span>
					<h4 class="card-title"><?=$lang_report_forperiod?></h4>
					<div class="form-group">
						<label><?=$lang_report_from?></label>
						<!-- <input type="text" class="form-control" name="fromtxt" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /> -->
						<input type="date" class="form-control" name="fromtxt" size="18"  />
					</div>
					<div class="form-group">
						<label><?=$lang_report_to?></label>
						<input type="date" class="form-control" name="totxt" size="18" />
					</div>
					
					<h4 class="card-title"><?=$lang_home_pgms?></h4>
					
					<div class="form-group">
						<label></label>
						<select name="programs" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
							<option value="All" ><?=$lang_home_all_pgms?></option>
							<?  
							while($row=mysqli_fetch_object($ret)){
								if($programs=="$row->joinpgm_id")
									$programName="selected = 'selected'";
								else
									$programName="";
							?>
							<option <?=$programName?> value="<?=$row->joinpgm_id?>">
								<?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?>
							</option>
							<?
							}
							?>
					  </select>
					</div>
					<div class="form-group">						
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								 <input class="form-check-input" type="checkbox" name="impr_cb" value="impr_cb" <?=$mchk?> />
								 <span class="form-check-sign"></span>
								<?=$lang_affiliate_head_impr?>
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="salecb" value="salecb" <?=$schk?> /> 
								<span class="form-check-sign"></span>
								<?=$lang_affiliate_head_sale?>
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								 <input class="form-check-input" type="checkbox" name="leadcb" value="leadcb" <?=$lchk?> />
								 <span class="form-check-sign"></span>
								 <?=$lang_affiliate_head_lead?>
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="clickcb" value="clickcb" <?=$cchk?> />
								<span class="form-check-sign"></span>	
								<?=$lang_affiliate_head_click?>
							</label>
						</div>
					</div>

					<div class="form-group">
						<input class="btn btn-fill btn-info" type="submit" name="btnsub" value="<?=$lang_report_view?>"  />
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
	<?php
	if(isset($_POST['btnsub'])){
		$programs	= trim($_POST['programs']);
		$From		= trim($_POST['fromtxt']);
		$To			= trim($_POST['totxt']);
		$sale		= trim($_POST['salecb']);
		$click		= trim($_POST['clickcb']);
		$lead		= trim($_POST['leadcb']);
		$impr		= trim($_POST['impr_cb']);
	
		$fdate		= trim($_POST['fromtxt']);
		$tdate		= trim($_POST['totxt']);
	
		if (($From=="")||($To =="")){
			
			// if(!$partners->is_date($From) || !$partners->is_date($To) ){
	?>	
		<div class="card stacked-form">
			<div class="card-body">
				<div class="row"> 
					<div class="col-md-12">	
						<span class="error textred"><?=$lang_report_err?></span>
					</div>
				</div>
			</div>
		</div>
	<?
				exit;
			// }
		}
		
		if ($sale=="" and $click=="" and $lead =="" and $impr==""){
	?>
			<div class="card stacked-form">
			<div class="card-body">
				<div class="row"> 
					<div class="col-md-12">	
						<span class="error textred"><?=$lang_trans_empty_msg?></span>
					</div>
				</div>
			</div>
		</div>
	<?
			exit;
		}
		// $From ="2021-06-06";
		// $To ="2022-06-14";
		$From	= $From;
	    $To		= $To;
	// $From	= $partners->date2mysql($From);
	// $To		= $partners->date2mysql($To);
	
	switch($programs){
		case 'All':
			$sql	= " SELECT * from partners_joinpgm, partners_program where joinpgm_affiliateid = '$AFFILIATEID' 
						and joinpgm_status not like('waiting') and joinpgm_programid = program_id   ";
		break;
		
		default:
			$sql	= " SELECT * from partners_joinpgm where joinpgm_id = '$programs' ";
		break;
	}

    $result1	= mysqli_query($con,$sql);
    $count		= "0";  // for  result table  head

	if ($click=="clickcb" || $sale=="salecb" || $lead=="leadcb" || $impr=="impr_cb"){

		if($click=="clickcb"){
			$querytype	= " transaction_type= 'click'";
		}
		
		if($sale=="salecb"){
			if(empty($querytype))	  
				$querytype	= "transaction_type = 'sale'";
			else   
				$querytype .= "OR transaction_type='sale'";
		}
		
		if($lead=="leadcb"){
			if(empty($querytype))	  
				$querytype 	= " transaction_type='lead'";
			else   
				$querytype .= "OR transaction_type='lead'";
		}
		
		if($impr =="impr_cb"){
			if(empty($querytype))	  
				$querytype=" transaction_type='impression'";
			else   
				$querytype .="OR transaction_type='impression'";
		} 
		/*if($click=="clickcb")
		{
		$querytype="'click'";
		}
		
		if($sale=="salecb")
		{
		$querytype="'sale'";
		}
		
		if($lead=="leadcb")
		{
		$querytype="'lead'";
		}
		
		if($click=="clickcb" and $sale=="salecb")
		{
		
		$querytype= "'click' or transaction_type = 'sale'";
		
		}
		
		if($lead=="leadcb" and $sale=="salecb")
		{
		$querytype= "'lead' or transaction_type = 'sale'";
		
		}
		
		if($lead=="leadcb" and $click=="clickcb")
		{
		
		$querytype= "'lead' or transaction_type = 'click'";
		
		}
		if($lead=="leadcb" and $sale=="salecb" and $click=="clickcb")
		{
		
		$querytype= "'lead' or transaction_type = 'sale' or transaction_type = 'click'";
		
		}
		*/
		
		?> 
		<div class="card stacked-form">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-12">
				<div class="table-full-width table-responsive">	
			<table class="table table-hover table-striped">
		<?php
		while($rows=mysqli_fetch_object($result1)){
			$joinid	= $rows->joinpgm_id;
			$sql	= "SELECT * FROM partners_transaction AS t, partners_joinpgm AS j,partners_merchant as m";
			$sql   .= " WHERE transaction_dateoftransaction between '$From' and '$To'";
			if(!empty( $querytype)){
				$sql.=" AND ($querytype)";
			}
			$sql.=" AND transaction_joinpgmid = '$joinid' AND t.transaction_joinpgmid = j.joinpgm_id 
					AND j.joinpgm_merchantid = m.merchant_id";
					
			if ((trim($From)=="0000-00-00") and (trim($To)=="0000-00-00")){
				$sql	= " SELECT * FROM partners_transaction AS t, partners_joinpgm AS j,partners_merchant as m";
				
				if(!empty( $querytype))		
					$sql.=" where ($querytype)";
				else 
					$sql.=" where 1";
	
				$sql .= " AND transaction_joinpgmid = '$joinid' AND t.transaction_joinpgmid = j.joinpgm_id 
							AND j.joinpgm_merchantid=m.merchant_id";
			}
		$result	= mysqli_query($con,$sql) or die("cant exe");
		$nclick	= mysqli_num_rows($result);
		if ($nclick=="0"){
			$count	= "1";
		}
		if ($count=="0"){
			$table	= "ok";
			$_SESSION['$res']=$lang_report." ".$From."-".$To;
			if ((trim($From)=="0000-00-00") and (trim($To)=="0000-00-00")){
				$_SESSION['$res']=$lang_trans_completereport;
			}
		?>
		
		<p align="right"><a href="#" onClick="window.open('../print_transaction.php?aid=<?=$AFFILIATEID?>&programs=<?=$programs?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$sale?>&lead=<?=$lead?>&impr=<?=$impr?>&click=<?=$click?>&mode=affiliate&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_transaction.php?aid=<?=$AFFILIATEID?>&programs=<?=$programs?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$sale?>&lead=<?=$lead?>&impr=<?=$impr?>&click=<?=$click?>&mode=affiliate&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>"><b><?=$lang_export_csv_head?></b></a></p>
		<p align="center" class="textred"><?=$_SESSION['$res']?></p>

		<thead>
		<tr>
			<th><?=$lang_trans_type?></th>
			<th><?=$lang_affiliate_head_merchant?></th>
			<th ><?=$lang_trans_commission?></th>
			<th ><?=$lang_trans_date?></th>
			<th><?=$lang_trans_status?></th>
		</tr>
		</thead>
		
		<?
		}   // closing of if count
		
		$count="1";
		$gridcounter=0;
		
		while($rows=mysqli_fetch_object($result))
				  {                 //////// column creation
				  if ($table!="ok")  //// checking table head is set
				  {
						$_SESSION['$res']=$lang_report." ".$From."-".$To;
		
						if ((trim($From)=="0000-00-00") and (trim($To)=="0000-00-00"))
							 {
								   $_SESSION['$res']=$lang_trans_completereport;
							  }
		
					?>
		<p align="right"><a href="#" onClick="window.open('../print_transaction.php?aid=<?=$AFFILIATEID?>&programs=<?=$programs?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$sale?>&lead=<?=$lead?>&impr=<?=$impr?>&click=<?=$click?>&mode=affiliate&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_transaction.php?aid=<?=$AFFILIATEID?>&programs=<?=$programs?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$sale?>&lead=<?=$lead?>&impr=<?=$impr?>&click=<?=$click?>&mode=affiliate&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>"><b><?=$lang_export_csv_head?></b></a></p>
		<p align="center" class="textred"><?=$_SESSION['$res']?></p>
		<thead>
		<tr>
			<th><?=$lang_trans_type?></th>
			<th><?=$lang_affiliate_head_merchant?></th>
			<th ><?=$lang_trans_commission?>- (Subid)</th>
			<th ><?=$lang_trans_date?></th>
			<th ><?=$lang_trans_status?></th>
		</tr>
		</thead>
		<?
		
				   $table="ok";
		
				   }  // closing if of table haed check;
		
				   else
				   {
				   $table="ok";
				   }
		
		
		
								   $nocol="1";
								   $type=$rows->transaction_type ;
								   $merchantid=$rows->joinpgm_merchantid ;
								   $merchantname=stripslashes($rows->merchant_company);
								   $affiliateid =$rows->joinpgm_affiliateid ;
								   $tstatus =$rows->transaction_status ;
								   $subid = $rows->transaction_subid ;
		
								   $comm = $rows->transaction_amttobepaid ;
								   $dateoftransaction = $rows->transaction_dateoftransaction ;
								   $commission = $comm ;
		
								   $astatus=$rows->joinpgm_status;
								   $pgmid   =$rows->joinpgm_programid ;
								   $stat   =$rows->joinpgm_status ;
		
					if ($gridcounter%2==1)
					{
										$classid="grid1";
					}
					 else
					 {
		
										$classid="grid2";
		
					 }
		
		
		?>
		
		<tr class="<?=$classid?>" >
		<td ><?=$type?>&nbsp;<img
		alt="" border="0" height="10" src="../images/<?=$type?>.gif"
		width="10" /></td>
		<td  >
		
		<a href="index.php?Act=viewprofile&amp;id=<?=$merchantid?>&amp;pgmid=<?=$pgmid?>&amp;status=<?=$stat?>"   >
		<?=stripslashes(ucwords($merchantname))?>
		</a></td>
		
		
		
		<td  ><?=$currSymbol?><?=number_format($commission,2)?> (<?php echo $subid ; ?>)</td>
		<td  ><?=$dateoftransaction?></td>
		
		<td  >
		&nbsp;<img alt="" border="0" height="15" src="../images/<?=$tstatus?>.gif"
		width="15" />&nbsp;<?=$tstatus?></td>
		
		
		</tr>
		
		<?
		
		$gridcounter=$gridcounter+1;
		
		} // outer while closing
		
		}  // if checking the value of 3 chbox closing
		
			}		// inner while close
		
		
		
		
		?>
		</table>
		</div>
		</div>
		</div>
		</div>
		</div>
		<?	

	
		if($nocol=="0")
		{
		
		?>
		<!--  table  4-->
		<div class="card strpied-tabled-with-hover">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<tbody> 
								<tr>
									<td><?=$lang_no_rec?></td>
								</tr>
							</tbody>
						</table>
					</div>	
				</div>	 
			</div>
		</div>
				
		<!-- close table 4-->
		
		<?
		
		}	
	} // closing of if of submit check

?>
	<script language='javascript'  type='text/javascript'>
	function help(merchantid,pgmid){
		url	= "viewprofile_merchant.php?id="+merchantid+"&amp;pgmid="+pgmid;
		nw 	= open(url,'new','height=0,width=400,scrollbars=yes');
		nw.focus();
	}
	
	function help1(afiliateid){
		url	= "viewprofile_affiliate.php?id="+afiliateid;
		nw 	= open(url,'new','height=0,width=400,scrollbars=yes');
		nw.focus();
	}
	</script> 