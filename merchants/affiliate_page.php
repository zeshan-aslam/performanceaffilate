<?php

  include "transactions.php";

  /**********************variables********************************************/
  $aid                     = $_GET['aid'];                                       //affiliateid

  $AFFILIATEID             =  $aid;

  $MERCHANTID			   = $_SESSION['MERCHANTID'];
  /***************************************************************************/


  $sql		=	"SELECT * from partners_joinpgm where joinpgm_affiliateid='$AFFILIATEID' " ;

  $total	= GetAffPaymentDetails($sql, $AFFILIATEID,$currValue,$default_currency_caption); //getting payments (click,sale,lead) values
  $total    = explode('~',$total);


   # calculate impressions
   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid='$MERCHANTID' and imp_affiliateid='$AFFILIATEID'";
   $impRet	= mysqli_query($con,$impSql);
	$row_impr	= mysqli_fetch_object($impRet);
	$numRec	= $row_impr->impr_count;
	if($numRec == '') $numRec = 0; 

 $result=mysqli_query($con,$sql);
 if(mysqli_num_rows($result)>0)
  { 
          $row       = mysqli_fetch_object($result);
          $joinid    = $row->joinpgm_id;
          $status    = GetAffiliateStatus($joinid);//getting affiliates information
          $status    = explode('~',$status);

          $details   = GetAffiliateDetails($joinid);//getting program payment information
          $details   = explode('~',$details);

  ?> 
      <div class="card strpied-tabled-with-hover"> 
		<div class="row"> 				
			<div class="col-md-6">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_rtr_AffiliatesStaistics?></h4>
				</div>			
			</div>
		</div>   
		<div class="clearfix"></div>
		<div class="row" style="margin-top:10px;"> 
			<div class="col-md-6">
				<div class="card regular-table-with-color">
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover">
							<thead>
								<tr colspan="2">
									<th><?=$lang_rtr_PersonalDetails?></th>
								</tr>
							</thead>
							<tbody> 
								<tr>
									<td><?=$lang_rtr_Name?></td>
									<td><?=$details[0]?></td>
								  </tr>
								  <tr>
									<td><?=$lang_rtr_status?></td>
									<td><?=$status[0]?></td>
								  </tr>
								  <tr>
									<td><?=$lang_rtr_joindate?></td>
									<td><?=$status[1]?></td>
								  </tr>
								  <tr>
									<td><?=$lang_rtr_Category ?></td>
									<td><?=$details[4]?></td>
								  </tr>
								  <tr>
									<td><?=$lang_rtr_Company?></td>
									<td><?=$details[1]?></td>
								  </tr>
								   <tr>
									<td><?=$lang_rtr_SiteUrl?></td>
									<td><?=$details[2]?></td>
								  </tr>
							</tbody>
						</table>
					</div> 
				</div>  
			</div>
			<div class="col-md-6"> 
				<div class="card regular-table-with-color">
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover">
							<thead>
								<tr colspan="2">
									<th><?=$lang_Transaction?></th>
									<th><?=$lhome_Number?></th>
									<th><?=$lhome_Commission?></th>
								</tr>
							</thead> 
							<tbody> 
								<tr>
								  <td><?=$lang_report_click?>&nbsp;<img alt="" border="0" height="8" src="../images/click.gif" width="8" /></td>
								  <td><?=$total[0]?></td>
								  <td><?=$currSymbol?>&nbsp;<?=number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$total[1]), 2, '.', '')?></td>
								</tr>
								<tr>
								  <td><?=$lang_report_lead?>&nbsp;<img alt="" border="0" height="10" src="../images/lead.gif" width="10" /></td>
								  <td><?=$total[2]?></td>
								  <td><?=$currSymbol?>&nbsp;<?=number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$total[3]), 2, '.', '')?></td>
								</tr>
								<tr> 
								  <td><?=$lang_report_sale?>&nbsp;<img alt="" border="0" height="10" src="../images/sale.gif" width="10" /></td>
								 <td><?=$total[4]?></td>
								 <td><?=$currSymbol?>&nbsp;<?=number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$total[5]), 2, '.', '')?></td>
								</tr>
								<tr>
								  <td><?=$lhome_Imp?></td>
								  <td><?=$numRec?></td>
								  <td><?=$currSymbol?>&nbsp;<?=number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$total[14]), 2, '.', '')?></td>
								</tr>
								<tr>
								  <td><?=$lhome_Approved?></td>
								  <td><?=$total[13]?></td>
								  <td><?=$currSymbol?>&nbsp;<?=number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$total[6]), 2, '.', '')?></td>
								</tr> 
								<tr>
								  <td><?=$lhome_Reversed?></td>
								  <td><?=$total[12]?></td>
								  <td><?=$currSymbol?>&nbsp;<?=number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],(float)$total[9]), 2, '.', '')?></td> 
								</tr>								  
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>	 
	</div>

	<?
		} 
	?>