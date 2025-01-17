<?
	include "doTransaction.php";
	include "transactions.php";
	include  "../mail.php";

  # Merchant Id
   $id 			   =   $_SESSION['MERCHANTID'];
	
   $saletype       = trim($_POST['saletype']);
   $leadtype       = trim($_POST['leadtype']);
   $clicktype      = trim($_POST['clicktype']);
   $programs	   = trim($_POST['programs']);
   $txtfrom        = trim($_POST['txtfrom']);    //from date
   $txtto          = trim($_POST['txtto']);      //to date
   $trans_id	   = $_GET['trans_id'];
   ##modified on 01.mar.06 to add impressions
   $impr_type         = trim($_POST['impr_type']);
   $gridcounter	=	0;
   /*15-2-2019*/
   $transid       = trim($_POST['transid']);   //transactionid
	$transid       = explode('~',$transid);
	$pgmid         = intval(trim($_GET['pgmid']));   
	 $mode          = ($_POST['Reject'] ? trim($_POST['Reject']) : trim($_POST['Approve']));      //select input type
	$msg			 = "";

	switch($mode){
		case 'Approve': 
			$returnvalue	=	doPayment($MERCHANTID,$transid[0],$minimum_amount);
			if($returnvalue){
				$today	= date("Y-m-d");
				$sql    = " update partners_transaction  set transaction_status='approved',transaction_dateofpayment='$today' 
							where transaction_id='$transid[0]'  ";
				mysqli_query($con,$sql);
				
				$sql	= " select * from partners_login, partners_joinpgm where joinpgm_id='$transid[2]' 
							and login_flag='a' and joinpgm_affiliateid=login_id";
				$ret1   = mysqli_query($con,$sql);
				$row    = mysqli_fetch_object($ret1);
				$to     = $row->login_email;
				
				MailEvent("Approve Transaction",$MERCHANTID,$transid[2],$to,$transid[0]);
				$pgmid    = 0;
			}
			else
			{
				$msg=$money_empty_err;
			}
		break;
		
		case 'Reject':   //Rejection
		
			$sql	= " select * from partners_login,partners_joinpgm where joinpgm_id='$transid[2]' 
						and login_flag='a' and joinpgm_affiliateid=login_id";
			$ret1	= mysqli_query($con,$sql);
			$row	= mysqli_fetch_object($ret1);
			$to		= $row->login_email;
			MailEvent("Reject Transaction",$MERCHANTID,$transid[2],$to,$transid[0]);
			
			 $sqli    = "INSERT INTO partners_transaction_rejected SELECT * FROM partners_transaction WHERE transaction_id = '$transid[0]'";
			 mysqli_query($con,$sqli);
			$sqlup    = " update partners_transaction_rejected  set transaction_status='rejected' where transaction_id='$transid[0]'  ";
				mysqli_query($con,$sqlup);
				
			
			$sql    = " delete from partners_transaction where transaction_id='$transid[0]'";
			mysqli_query($con,$sql);
			
			$pgmid  = 0;
		break;
	}
	
    if((empty($txtto)) and (empty($txtfrom))){
    }else {
       if((!$partners->is_date($txtto)) || (!$partners->is_date($txtfrom))){
           		$msg = "Please Enter Valid Dates";
       }
    }

   # getting page no
   $page		=   (empty($page))? $partners->getpage(): trim($_GET['page']);
	
	$status = isset($_GET['status']) ? $_GET['status'] : 'pending';
	if($status == 'rejected'){
		$table = 'partners_transaction_rejected';
	}else{
		$table = 'partners_transaction';
	}
   # geting records from table
   $sql		=	" SELECT *,date_format(transaction_dateoftransaction,'%d, %m %Y') AS DATE FROM $table AS t, partners_joinpgm AS j,partners_merchant as a where merchant_id='$id'";
   $sql	   .=	" AND  t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_merchantid=a.merchant_id AND transaction_type != 'click' ";
   $sql    .=   (!empty($trans_id)) ? " AND transaction_id = '$trans_id' " :"";

   $sql    .=   ($programs != "All" and !empty($programs))?" AND joinpgm_programid = '$programs'":"";

   if($partners->is_date($txtto) && $partners->is_date($txtfrom)){
           $To   = $partners->date2mysql($txtto);
           $From = $partners->date2mysql($txtfrom);

          $sql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
    }
		

	if(isset($_GET['orderbyid']) && $_GET['orderbyid'] != ''){
		$orderid =$_GET['orderbyid'];
		$sql.= " AND transaction_orderid = '$orderid' ";
	}else{
		$sql.= " AND transaction_status = '$status' ";
	}


   $pgsql	= 	$sql;
      $sql    .=	" LIMIT ".($page-1)*$lines.",".$lines; //adding page no


     

   $ret 	=	mysqli_query($con,$sql);


   # getting all programs
    $sql1      = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2  = mysqli_query($con,$sql1);
	
	
	if(mysqli_num_rows($ret) > 0){
		
	}else{
		if(isset($_GET['orderbyid']) && $_GET['orderbyid'] != ''){
		 $sqlq		=	" SELECT *,date_format(transaction_dateoftransaction,'%d, %m %Y') AS DATE FROM partners_transaction_rejected AS t, partners_joinpgm AS j,partners_merchant as a where merchant_id='$id'";
		$sqlq	   .=	" AND  t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_merchantid=a.merchant_id  AND transaction_type != 'click' ";
		$sqlq    .=   ($programs != "All" and !empty($programs))?" AND joinpgm_programid = '$programs'":"";
		$orderid =$_GET['orderbyid'];
		$sqlq .= " AND transaction_orderid = '$orderid'   ";
		 $pgsql	= 	$sqlq;
		$sqlq    .=	" LIMIT ".($page-1)*$lines.",".$lines;

		 $ret 	=	mysqli_query($con,$sqlq);
		}
	}

 ?>
 <div class="card stacked-form">
	<div class="card-body">
		<div class="row"> 
			<div class="col-md-6">				
				<div class="form-group">
					<label>Status</label>
					<select class="form-control" name="status" onChange="status_change(this.value)">
						<option value="pending" <?php if($status == 'pending'){ echo 'selected'; } ?>>Pending</option>
						<option value="approved" <?php if($status == 'approved'){ echo 'selected'; } ?>>Approved</option>
						<option value="rejected" <?php if($status == 'rejected'){ echo 'selected'; } ?>>Rejected</option>
					</select>
				</div>				
				<form action="" method="get">
					<input type="hidden" name="Act" value="all_transaction">
					<div class="row"> 
						<div class="col-md-6">	
							<div class="form-group">
								<input type="text" id="orderbyid" name="orderbyid" value="<?php echo isset($_GET['orderbyid']) ? $_GET['orderbyid'] : ''; ?>" class="form-control">						
							</div>
						</div>
						<div class="col-md-6">	
							<div class="form-group">
								<button type="submit" class="btn btn-info btn-fill btn-wd" name="search">Search by order ID</button>
							</div>
						</div>   
						<div class="col-md-12">
							<span style="font-size:12px;" class="textred">Please note you can only search for Approved / Pending Transactions</span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
 </div>
  <?  
  # checking for each records
  if(mysqli_num_rows($ret)>0){
  ?> 
  <div class="card strpied-tabled-with-hover custom_transaction">
	<div class="card-body">
		<div class="row"> 
			<div class="col-md-12 ">
				<div class="table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<thead>
								<tr>
									<th><?=$trans_type?></th>
									<th><?=$trans_orderId?></th>
									<th><?=$trans_affiliate?></th>
									<th><?=$trans_comm?></th>
									<th>Action</th>
									<th><?=$trans_date?></th>
									<th><?=$trans_status?></th>
								</tr>
							</thead>
							<?
							$is = 0;
							  while($rows=mysqli_fetch_object($ret))
							  {
								$type		   		=	$rows->transaction_type ;
								$transaction_id 	=	$rows->transaction_id  ;
								$transaction_orderid 	=	$rows->transaction_orderid;
								$merchantid	   		=	$rows->joinpgm_merchantid ;
								$merchantname  		=	stripslashes($rows->merchant_compnay);
								$affiliateid   		=	$rows->joinpgm_affiliateid ;

								$sql2 =	"select * from partners_affiliate where affiliate_id='$affiliateid' ";
								$ret2 =	mysqli_query($con,$sql2);

								if(mysqli_num_rows($ret2)>0){
									$row2		=	mysqli_fetch_object($ret2);
									$affiliate	=	stripslashes($row2->affiliate_company);
								}

								$tstatus 	  		=	$rows->transaction_status ;
								$commission			=	$rows->transaction_amttobepaid ;
								$date				=	$rows->transaction_dateoftransaction;
								$dateoftransaction  =	$rows->transaction_dateoftransaction;
								$astatus			=	$rows->joinpgm_status;
								$adminComm			=   $rows->transaction_admin_amount;
								 # converting to user currency
								 
								
								$classid = ($gridcounter%2==1)? "grid1" : "grid2" ;
							   ?>
							   <tbody>
									<tr class="<?=$classid?>">
										<td><?=$type?>&nbsp;<img alt="" border="0" height="10" src="../images/<?=$type?>.gif" width="10" /></td>
										<td><?=$rows->transaction_orderid?></td>
										<td><a href="#" onclick="help1(<?=$affiliateid?>)"> <?=$affiliate?></a></td>
										<td>
											<table>
												<tr>
												   <td><?=$currSymbol?> <?=number_format($commission,2)?></td>
												   <td><img src="../images/add.gif" width="10" height="10" alt="" border="0" /></td>
												   <td><?=$currSymbol?> <?=number_format($adminComm,2)?></td>
												</tr>
											</table>
										</td>
										<?php
										
											$sqls	= " select * from partners_joinpgm,partners_transaction,partners_program, partners_affiliate  
					where joinpgm_merchantid='$MERCHANTID'  
					and joinpgm_id=transaction_joinpgmid and program_id=joinpgm_programid  
					AND affiliate_id = joinpgm_affiliateid and transaction_id = '$transaction_id' and transaction_type != 'click' ";
					$result1   = mysqli_query($con,$sqls);
					 $rows    = mysqli_fetch_object($result1);  
					$joinid   = $rows->joinpgm_id;	
					$pgmid        = $rows->program_id;					
					$pgmname  = stripslashes($rows->program_url);
					$tranStat    = GetTransaction($transaction_id, $currValue, $default_currency_caption);
			
					$sqlaa	=	"select * FROM partners_track_revenue WHERE revenue_transaction_id='$transaction_id'";
				  $rets	=	@mysqli_query($con,$sqlaa);
				  $rowss	=	@mysqli_fetch_object($rets);
				  # get transaction details
				  $revenue_amount	=	$rowss->revenue_amount;
				   $tranStat    = explode('~',$tranStat);
					   $details     = GetAffiliateDetails($joinid);
					    $details     = explode('~',$details);
											?>
											<td>
											<a class="btn btn-info btn-fill btn-wd" data-toggle="modal" data-target="#myModal<?php echo $is; ?>" href="notifications.html#pablo">
											View
											</a>
											<!-- Mini Modal -->
                    <div class="modal fade modal-primary main_modal" id="myModal<?php echo $is; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal_transaction modal_style">
                            <div class="modal-content">
                                <div class="modal-header justify-content-center">
                                    <div class="modal-title">
									<?php if($tstatus == 'pending'){ ?>
										<?=$lang_PendingTransactions?>
									<?php }else if($tstatus == 'approved'){ ?>
										<?=$lang_ApprovedTransactions?>
									<?php }else { ?> <?=$lang_RejectedTransactions?> <?php } ?>
                                        
                                    </div> 
									<button type="button" class="close modal_close" data-dismiss="modal">&times;</button>
                                </div>
								<form name="GetTransaction" method="post" action="index.php?Act=all_transaction&amp;pgmid=<?=$pgmid?>">
                                <div class="modal-body text-center">
								<input type="hidden" name="transid" value="<?php echo $transaction_id."~".stripslashes($rows->program_url)."~".$rows->joinpgm_id; ?>">
									<div class="card strpied-tabled-with-hover">
										<div class="card-body">
											<div class="row"> 
												<div class="col-md-6">
													<div class="form-group">
														<label><?=$lang_Program?></label> :<?=$pgmname?>
													</div>
												</div>			
												<div class="col-md-6"></div>
												<div class="col-md-6">
													<p><b><?=$lang_AffiliateDetails?></b></p>
													<div class="form-group">
														<label><?=$lang_Name?></label> :<?=$details[0]?>
													</div>
													<div class="form-group">
														<label><?=$lang_Company?></label> :<?=$details[1]?>
													</div>
													<div class="form-group">
														<label><?=$lang_SiteUrl?></label> :<?=$details[2]?>
													</div>
												</div>
												<div class="col-md-6">
													<p><b><?=$lang_Transaction?></b></p>
													<div class="form-group">
														<label><?=$lang_Type?></label> :<?=$tranStat[0]?>
													</div>
													<div class="form-group">
														<label><?=$lang_Commission?></label> :<?=$currSymbol?><?=number_format($tranStat[1],2)?>
													</div>
													<div class="form-group">
														<label><?=$lang_Date?></label> :<?=$tranStat[2]?>
													</div>
													<div class="form-group">
														<label>Order Value</label> :<?=$currSymbol?><?php echo number_format($revenue_amount,2); ?>
													</div>
													<div class="form-group">
														<label>Order ID</label> :<?php echo $transaction_orderid; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
                                </div>
								<?php if($tstatus == 'pending'){ ?>
									<div style="text-align: center;"><p>APPROVED TRANSACTIONS CAN NOT BE CANCELLED LATER</p></div>
                                <div class="modal-footer">
                                	
                                    <button type="submit" name="Reject" class="btn btn-danger btn-wd" value="<?=$common_reject?>" ><?=$common_reject?></button>
                                    <button type="submit" name="Approve" class="btn btn-success btn-wd" value="<?=$common_approve?>"><?=$common_approve?></button>
                                   <!-- <button type="button" class="btn btn-link btn-simple" data-dismiss="modal">Close</button>-->
                                </div>
								<?php } ?>
								</form>
                            </div>
                        </div>
                    </div>
                    <!--  End Modal -->
											</td>
										<td><?=$dateoftransaction?></td>
										<td>&nbsp;<img alt="" border="0" height="15" src="../images/<?=$tstatus?>.gif" width="15" />&nbsp;<?=$tstatus?></td>
									</tr>
							   </tbody>
							    <?
								$gridcounter	 =	$gridcounter+1;
								$is++;
								}
								$classid		 = ($gridcounter%2==1)? "grid1" : "grid2" ;
								?>
					</table>
				</div>
			</div>
			<div class="custom_pagination">
				<?
				$url    ="index.php?Act=all_transaction&amp;merid=$id&amp;trans_id=$trans_id&status=$status";    //adding page nos
				include '../includes/show_pagenos.php';
				?>
	       </div>
		</div>
	</div>
  </div>
  <?php }else{
	  ?>
		<div class="card strpied-tabled-with-hover">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-full-width table-responsive">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?=$trans_type?></th>
										<th><?=$trans_orderId?></th>
										<th><?=$trans_affiliate?></th>
										<th><?=$trans_comm?></th>
										<th><?=$trans_date?></th>
										<th><?=$trans_status?></th>
									</tr>
								</thead>
								<tbody>
								<tr>
									<td></td>
									<td colspan="4" style="text-align:center">Transaction not found</td>
									<td></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div> 
				</div> 
			</div> 
		</div>
	  <?php
  } ?>
<script>
	function status_change(val){
		var orderbyid = $('#orderbyid').val();
		$('#orderbyid').val('');
		window.location.href= "index.php?Act=all_transaction&merid=<?php echo $id; ?>&status="+val;
	}
</script>