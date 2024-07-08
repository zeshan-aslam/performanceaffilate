<?
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

    $msg = "";

    if((empty($txtto)) and (empty($txtfrom))){
    }else {
       if((!$partners->is_date($txtto)) || (!$partners->is_date($txtfrom))){
           		$msg = "Please Enter Valid Dates";
       }
    }

   # getting page no
   $page		=   (empty($page))? $partners->getpage(): trim($_GET['page']);

   # geting records from table
   $sql		=	" SELECT *,date_format(transaction_dateoftransaction,'%d, %m %Y') AS DATE FROM partners_transaction AS t, partners_joinpgm AS j,partners_merchant as a where merchant_id='$id'";
   $sql	   .=	" AND  t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_merchantid=a.merchant_id ";
   $sql    .=   (!empty($trans_id)) ? " AND transaction_id = '$trans_id' " :"";

   $sql    .=   ($programs != "All" and !empty($programs))?" AND joinpgm_programid = '$programs'":"";

   if($partners->is_date($txtto) && $partners->is_date($txtfrom)){
           $To   = $partners->date2mysql($txtto);
           $From = $partners->date2mysql($txtfrom);

          $sql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
    }

    if($saletype==1 or $leadtype==1 or $clicktype==1  or $impr_type==1){
     $tsql  .= ($saletype==1)  ? "  OR  t.transaction_type = 'sale' " : "";
     $tsql  .= ($leadtype==1)  ? "  OR  t.transaction_type = 'lead' " : "";
     $tsql  .= ($clicktype==1) ? "  OR  t.transaction_type = 'click' " : "";
	 $tsql  .= ($impr_type==1) ? "  OR  t.transaction_type = 'impression' " : "";

     $tsql = trim($tsql);
     $tsql = trim($tsql,"OR");
     $tsql = " AND (".$tsql.")";
     $sql .= $tsql;
    }


   $pgsql	= 	$sql;
   $sql    .=	" LIMIT ".($page-1)*$lines.",".$lines; //adding page no

   $ret 	=	mysqli_query($con,$sql);


   # getting all programs
    $sql1      = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2  = mysqli_query($con,$sql1);
 ?>
 <script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.trans.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.trans.txtto,Date);
        }
</script>
<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
 <form name="trans" method="post" action="#">
	 <div class="card stacked-form">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-6">
					<p><?=$lang_report_stat?></p>
					<span class="textred"><?=$msg?></span>
					<h4 class="card-title"><?=$lang_report_forperiod?></h4>
					<div class="form-group">
						<label><?=$lang_report_from?></label>
						<input type="text" class="form-control" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" />
					</div>
					<div class="form-group">
						<label><?=$lang_report_to?></label>
						<input type="text" class="form-control" name="txtto" size="18" value="<?=$txtto?>" onfocus="javascript:to_date();return false;" />
					</div>
					
					<h4 class="card-title"><?=$lang_report_SearchProgram?></h4>
					
					<div class="form-group">
						<label></label>
						<select name="programs" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue" onchange="document.Getprogram.submit()">
							<option value="All" ><?=$lang_report_AllProgram?></option>
							 <?
                               while($row=mysqli_fetch_object($result2))
                               {
                               if($programs=="$row->program_id")
                                      $programName="selected = 'selected'";
                               else
                                $programName="";
                               ?>
							 <option <?=$programName?> value="<?=$row->program_id?>"><?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> </option>
                               <?
                               }
                               ?>
						</select>
					</div>
					<div class="form-group">						
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="impr_type" value="1" <?=($impr_type)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								Impression
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="clicktype" value="1" <?=$schk?> <?=($clicktype)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								Click
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input"  type="checkbox" name="saletype" value="1" <?=($saletype)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								Sale
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="leadtype" value="1" <?=($leadtype)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								Lead
							</label>
						</div>						
					</div>
					
					<div class="form-group">
						<input name="currValue" type="hidden" value="<?=$currValue?>" />
						<input class="btn btn-fill btn-info" type="submit" name="sub" value="<?=$lang_report_view?>"  />
					</div>
				</div>
			</div>
		</div>
	</div>
    
  </form>
  <?

  # checking for each records
  if(mysqli_num_rows($ret)>0){
  ?>
 
	<div class="card strpied-tabled-with-hover">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<p align="right"><a href="#" onClick="window.open('../print_transaction.php?mid=<?=$id?>&programs=<?=$programs?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$saletype?>&lead=<?=$leadtype?>&impr=<?=$impr_type?>&click=<?=$clicktype?>&mode=merchant&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_transaction.php?mid=<?=$id?>&programs=<?=$programs?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$saletype?>&lead=<?=$leadtype?>&impr=<?=$impr_type?>&click=<?=$clicktype?>&mode=merchant&currsymbol=<?=$currSymbol?>&currValue=<?=$currValue?>"><b><?=$lang_export_csv_head?></b></a>&nbsp;&nbsp;&nbsp;</p>
					
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
							<?
							  while($rows=mysqli_fetch_object($ret))
							  {
								$type		   		=	$rows->transaction_type ;
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
								$date				=	$rows->transaction_dateoftransaction ;
								$dateoftransaction  =	$rows->DATE ;
								$astatus			=	$rows->joinpgm_status;
								$adminComm			=   $rows->transaction_admin_amount;
								 # converting to user currency
								 if($currValue != $default_currency_caption){
									   $commission     =   getCurrencyValue($date, $currValue, $commission);
									   $adminComm     =   getCurrencyValue($date, $currValue, $adminComm);
								  }
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
										<td><?=$dateoftransaction?></td>
										<td>&nbsp;<img alt="" border="0" height="15" src="../images/<?=$tstatus?>.gif" width="15" />&nbsp;<?=$tstatus?></td>
									</tr>
							   </tbody>
							    <?
								$gridcounter	 =	$gridcounter+1;
								}
								$classid		 = ($gridcounter%2==1)? "grid1" : "grid2" ;
								?>
						</table>
					</div>
				</div>	
				
			<div class="custom_pagination">
				<?
				$url    ="index.php?Act=transaction_merchant&amp;merid=$id&amp;trans_id=$trans_id";    //adding page nos
				include '../includes/show_pagenos.php';
				?>
	       </div> 
    <?
     } // outer if closing
    else{
    ?>
	<div class="card strpied-tabled-with-hover">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="card-body table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<tbody> 
							<tr>
								<td><?=$norec?></td>
							</tr>
						</tbody>
					</table>
				</div>	
			</div>	 
		</div>
	</div>	
   	<?
    }
    ?>

	<script language="javascript" type="text/javascript">
		function help(merchantid)
		{
			url="viewprofile_merchant.php?id="+merchantid;
			nw = open(url,'new','height=400,width=400,scrollbars=yes');
			nw.focus();
		}
		
		function help1(afiliateid)
		{
			url="viewprofile_affiliate.php?id="+afiliateid;
			nw = open(url,'new','height=400,width=400,scrollbars=yes');
			nw.focus();
		}
	</script> 