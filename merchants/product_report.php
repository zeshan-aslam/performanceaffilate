<?
 # getting back form variables

    $MERCHANTID		= $_SESSION['MERCHANTID'];   //merchantid

    $txtfrom        = trim($_POST['txtfrom']);    //from date
    $txtto          = trim($_POST['txtto']);      //to date
    $sub            = trim($_POST['sub']);        //submit button
    $msg            = trim($_POST['msg']);        //err msg
    $programs       = trim($_POST['programs']);

    $saletype		  = trim($_POST['saletype']);
    $leadtype		  = trim($_POST['leadtype']);
    $clicktype		  = trim($_POST['clicktype']);
	$impr_type		  = trim($_POST['impr_type']);
    if(!empty($txtto) || !empty($txtfrom))
    {
         if((!$partners->is_date($txtto)) || (!$partners->is_date($txtfrom))){
           	$msg = $lang_report_err;
         }
    }

  # getting all programs
    $sql      = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2  = mysqli_query($con,$sql);
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
								<?=$lpgm_Impression?>
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="clicktype" value="1" <?=$schk?> <?=($clicktype)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								<?=$lhome_Click?>
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input"  type="checkbox" name="saletype" value="1" <?=($saletype)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								<?=$lhome_Sale?>
							</label>
						</div>
						<div class="form-check checkbox-inline">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="leadtype" value="1" <?=($leadtype)?"checked='checked'":""?> />
								<span class="form-check-sign"></span>
								<?=$lhome_Lead?>
							</label>
						</div>						
					</div>					
					<div class="form-group">
						<input class="btn btn-fill btn-info" type="submit" name="sub" value="<?=$lang_report_view?>"  />
					</div>
				</div>
			</div>
		</div>
	</div>					
</form>
  <? 
  # get records od seleted values

  if(($sub=="view") and empty($msg)){
       $To   = $partners->date2mysql($txtto);
       $From = $partners->date2mysql($txtfrom);

       $transSql = "SELECT *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
       $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
       if($programs != "All"){
       	    $transSql.= " AND joinpgm_programid = '$programs' ";
       }else  $transSql.= " AND joinpgm_merchantid = $MERCHANTID";
       if($partners->is_date($txtto) && $partners->is_date($txtfrom)){
          $transSql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
       }
       $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
       $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
       $transSql.= " AND affiliate_id = joinpgm_affiliateid ";
       if($saletype==1 or $leadtype==1 or $clicktype==1 or $impr_type==1){
           $tsql  .= ($saletype==1) ? "OR transaction_type = 'sale' " : "";
           $tsql  .= ($leadtype==1) ? "OR  transaction_type = 'lead' " : "";
           $tsql  .= ($clicktype==1) ? "OR transaction_type = 'click' " : "";
			$tsql  .= ($impr_type==1) ? "OR transaction_type = 'impression' " : "";
           $tsql = trim($tsql);
           $tsql = trim($tsql,"OR");
           $tsql = " AND (".$tsql.")";
           $transSql .= $tsql;
        }
		//echo $transSql;
       $transRet = mysqli_query($con,$transSql);
  ?>
   
  <?
  if(mysqli_num_rows($transRet)>0){
   ?>
   
   <div class="card strpied-tabled-with-hover">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<p align="right"><a href="#" onClick="window.open('../print_product.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&from=<?=$From?>&to=<?=$To?>&program=<?=$programs?>&currValue=<?=$currValue?>&currsymbol=<?=$currSymbol?>&sale=<?=$saletype?>&lead=<?=$leadtype?>&impr=<?=$impr_type?>&click=<?=$clicktype?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_product.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&from=<?=$From?>&to=<?=$To?>&program=<?=$programs?>&currValue=<?=$currValue?>&currsymbol=<?=$currSymbol?>&sale=<?=$saletype?>&lead=<?=$leadtype?>&impr=<?=$impr_type?>&click=<?=$clicktype?>"><b><?=$lang_export_csv_head?></b></a></p>
					
					<div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<tr><th colspan="6"><?=$trans_existing?></th></tr>
								<tr>
									<th><?=$lang_product_Type?></th>
									<th><?=$lang_product_Product?></th>
									<th><?=$lang_product_Affiliate?></th>
									<th><?=$lang_product_Commission?></th>
									<th><?=$lang_product_Date?></th>
									<th><?=$lang_product_Status?></th>
								</tr>
							</thead>
						   <?
						   $i  = 0;
							while($transRow = mysqli_fetch_object($transRet)){

							 $type       = trim(stripslashes($transRow->transaction_type));
							 $tstatus    = trim(stripslashes($transRow->transaction_status));
							 $transDate  = trim(stripslashes($transRow->transaction_dateoftransaction));
							 $affAmnt    =   $transRow->transaction_amttobepaid;
							 $adminAmnt  =   $transRow->transaction_admin_amount;

							 if($currValue != $default_currency_caption){
									  $affAmnt     =   getCurrencyValue($transDate, $currValue, $affAmnt);
									  $adminAmnt   =   getCurrencyValue($transDate, $currValue, $adminAmnt);
							 }
							 $commission = trim(stripslashes($affAmnt)) + trim(stripslashes($adminAmnt));

							 $date		 = trim(stripslashes($transRow->DATE));
							 $product	 = trim(stripslashes($transRow->prd_product));
							 $productid	 = trim(stripslashes($transRow->prd_id));
							 $affiliateid= trim(stripslashes($transRow->affiliate_id));
							 $affiliate  = trim(stripslashes($transRow->affiliate_company));
							 $classid    = ($i%2==0)?"grid1":"grid2";
						  ?>
						   <tbody>
								<tr class="<?=$classid?>" >
									<td><b><?=$i+1?></b>. <?=$type?>&nbsp;<img alt="" border="0" height="10" src="../images/<?=$type?>.gif" width="10" /></td>
									<td><?=$product?></td>
									<td><a href="index.php?Act=affiliate_page&amp;aid=<?=$affiliateid?>" id="show" > <?=$affiliate?></a></td>
									<!-- onclick="help1(<?=$affiliateid?>)"-->
									<td><?=$commission?> <?=$currSymbol?></td>
									<td><?=$date?></td>
									<td>&nbsp;<img alt="" border="0" height="15" src="../images/<?=$tstatus?>.gif" width="15" />&nbsp;<?=$tstatus?></td>
								  </tr>
								  <?
								   $i++;
								   }
								   ?>
							</tbody>  
						</table>
					</div>
				</div>	
			</div>	
		</div>
	</div>	
		 <?  
		  }else{
		   ?>
		   <div class="card strpied-tabled-with-hover">
			 <div class="row">
				<div class="col-md-12 text-center">
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<tbody> 
								<tr>
									<td><?=$lang_report_no_rec?></td>
								</tr>
							</tbody>
						</table>
					</div>	
				</div>	 
			</div>
		</div>					  
		   <?
		   }
		 }?>