<?
    /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AFFILIATE REPORTS
      VARIABLES          :    	$page                     =page no
  							  	$MERCHANTID               =mercahnt id
        						$from                     =from date
                                $to                       =to date
                                $sub                      =submit button
                                $msg                      =errmsg
                                $affiliate                =affilaite name
                                $total                    =statistics
  //*************************************************************************************************/
?>
<script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.report.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.report.txtto,Date);
        }
</script>

  <?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/function1.php';
  include_once '../includes/session.php';
  include_once 'affiliate_payments.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    /************************variables*****************************************/
    $page                                =$partners->getpage();                 //page no
    $MERCHANTID                          =$_SESSION['MERCHANTID'];              //mercahnt id
    $from                                =trim($_POST['txtfrom']);              //from date
    $to                                  =trim($_POST['txtto']);                //to date
    $sub                                 =trim($_POST['sub']);                  //submit button
    $msg                                 =trim($_GET['msg']);                   //errmsg
    $affiliate                           =stripslashes(trim($_POST['search'])); //affilaite name

    $saletype		= trim($_POST['saletype']);
    $leadtype		= trim($_POST['leadtype']);
    $clicktype		= trim($_POST['clicktype']);

    /*************************************************************************/

    /**************************initialisation*********************************/
    if (empty($from))
        $from =trim($_GET['txtfrom']);

    if (empty($to))
        $to=trim($_GET['txtto']);

    if (empty($sub))
        $sub=trim($_GET['sub']);

     if (empty($affiliate))
        $affiliate=stripslashes(trim($_GET['search']));

     if(!empty($sub))   {

                  if(!$partners->is_date($from) || !$partners->is_date($to) )
                   {
                    $Err=$lang_report_err;

                   }
                   }
    /*************************************************************************/

 ?>


 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe>
<form name="report" method="post" action="index.php?Act=AffiliateReport&amp;page=1"> 
	<div class="card stacked-form">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-6">
					<p><?=$lang_report_stat?></p>
					<span class="textred"><?=$Err?></span>
					<h4 class="card-title"><?=$lang_report_forperiod?></h4>
					<div class="form-group">
						<label><?=$lang_report_from?></label>
						<input type="text" class="form-control" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" />
					</div>
					<div class="form-group">
						<label><?=$lang_report_to?></label>
						<input type="text" class="form-control" name="txtto" size="18" value="<?=$to?>" onfocus="javascript:to_date();return false;" />
					</div>
					
					<h4 class="card-title"><?=$lang_report_searchaff?></h4>
					
					<div class="form-group">
						<input type="text" name="search" class="form-control" size="30" value="<?=$affiliate?>" />
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

   if(!empty($sub))   {

                if(!$partners->is_date($from) || !$partners->is_date($to) )
                {
                $Err                        ="Please Enter Valid Date" ;
                }

                else
                {
               $cFrom                        =$partners->date2mysql($from);  //change date format
               $cTo                          =$partners->date2mysql($to);
               //echo $affiliate;
               $search						=addslashes($affiliate);
               $sql                          ="SELECT * from partners_joinpgm j,partners_program p,partners_affiliate where program_merchantid='$MERCHANTID' and joinpgm_status not like ('waiting') and affiliate_company like('%$search%') and j.joinpgm_programid=p.program_id and affiliate_id=joinpgm_affiliateid ";
               $sql                         .="LIMIT ".($page-1)*$lines.",".$lines;
               $result                       =mysqli_query($con,$sql);
              // echo $sql;
               if (mysqli_num_rows($result)>0)
               {
               ?>
	<div class="card strpied-tabled-with-hover">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">	   
					<p align="right"><a href="#" onClick="window.open('../print_affiliates.php?mid=<?=$MERCHANTID?>&search=<?=$affiliate?>&from=<?=$cFrom?>&to=<?=$cTo?>&currency=<?=$currSymbol?>&currValue=<?=$currValue?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_affiliates.php?mid=<?=$MERCHANTID?>&search=<?=$affiliate?>&from=<?=$cFrom?>&to=<?=$cTo?>&currency=<?=$currSymbol?>&currValue=<?=$currValue?>"><b>Export as CSV</b></a> &nbsp;&nbsp;&nbsp;</p>
					 <div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>                   
								<tr>
									<th><?=$lang_report_affiliate?></th>
									<th><?=$lang_report_pgm?></th>
									<th><?=$lpgm_Impression?></th>
									<th><?=$lang_report_click?></th>
									<th><?=$lang_report_lead?></th>
									<th><?=$lang_report_sale?></th>
									<th><?=$lang_report_commission?></th>
								</tr>
							</thead>
							<?
							while($row=mysqli_fetch_object($result)){

								$total =GetPaymentDetails1($row->joinpgm_id,$cTo,$cFrom,$currValue,$default_currency_caption);   //getting pending,approved,paid amnts from GetPayments.php
								$total =explode('~',$total);

								$imp_count =   get_impression_count($row->joinpgm_programid,$row->joinpgm_merchantid,$row->joinpgm_affiliateid,$cFrom,$cTo);
							 ?>
							<tbody>
							   <tr class="grid1">
									<td><?=stripslashes(trim($row->affiliate_company))?></td>
									<td><a href='index.php?Act=programs&mode=editprogram&programId=<?=$row->joinpgm_programid?>'><?=stripslashes($row->program_url)?></a></td>
									<td><?=$imp_count?></td>
									<td><?=$total[0]?></td>
									<td><?=$total[1]?></td>
									<td><?=$total[2]?></td>
									<td><?=$currSymbol?><?=number_format($total[3],2)?></td>
								</tr>
							</tbody>
							<?php
							  }
							?>
						</table>	
					</div>	
				</div>	
			</div>	
		</div>  
	</div>
			<div class="custom_pagination">
				<? $pgsql ="SELECT * from partners_joinpgm j,partners_program p,partners_affiliate where program_merchantid='$MERCHANTID' and joinpgm_status not like ('waiting') and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$search%') and j.joinpgm_programid=p.program_id and affiliate_id=joinpgm_affiliateid ";
			  $url ="index.php?Act=AffiliateReport&amp;sub=$sub&amp;txtfrom=$from&amp;txtto=$to&amp;search=$affiliate";    //adding page nos
			include '../includes/show_pagenos.php'; ?>
			</div>	
              <? 
               }
			else { ?>
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
			}
      }
  ?>