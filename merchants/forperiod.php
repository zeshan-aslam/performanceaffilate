
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

  <?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);


    /***********************variabels*****************************************/

    $total                        =trim($_GET['total']);   //total pending,reversed etc transactions
    $click                        =trim($_GET['click']);   //click amnt
    $nclick                       =trim($_GET['nclick']);  //no of clicks
    $lead                         =trim($_GET['lead']);    //lead amnt
    $nlead                        =trim($_GET['nlead']);   //no of leads
    $sale                         =trim($_GET['sale']);    //sale amnt
    $nsale                        =trim($_GET['nsale']);   //no of sales
    $subsale                      =trim($_GET['subsale']); //subsale amnt
    $nsubsale                     =trim($_GET['nsubsale']);//no of subsale
    $from                         =trim($_GET['from']);    //from date
    $to                           =trim($_GET['to']);      //to date
    $merchant                     =trim($_GET['merchant']);//mercahnt id
    $affiliate                    =trim($_GET['affiliate']);//affuiliateid
    $msg                          =trim($_GET['err']);      //err msg
    $sub                          =trim($_GET['sub']);      //submit button
    /*************************************************************************/

    $sale                         =explode("~",$sale);
    $total                        =explode('~',$total);

    if(!empty($to) && !empty($to))
                    {
            $heading=$from. " - ".$to;
            }



 ?>
<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>
 
  <form name="trans" method="post" action="forperiod_process.php">
	  <div class="card stacked-form">
			<div class="card-body"> 
				<div class="row"> 
					<div class="col-md-6">
						<p><?=$lang_report_stat?></p>
						<span class="textred"><?=$msg?></span>
						<h4 class="card-title"><?=$lang_report_forperiod?></h4>
						<div class="form-group">
							<label><?=$lang_report_from?></label>
							<input type="text" class="form-control" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" />
						</div>
						<div class="form-group">
							<label><?=$lang_report_to?></label>
							<input type="text" class="form-control" name="txtto" size="18" value="<?=$to?>" onfocus="javascript:to_date();return false;" />
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

  if(!empty($sub))
   {
   
	$selDate		= $heading ;//$d.".".$m.".".$y;	
	$values	= $sale[3]."~".$sale[6]."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale[0]."~".$sale[2]."~".$sale[1]."~".$currSymbol;
   
   ?>
   <div class="card stacked-form">
		<div class="card-body"> 
			<p align="right">
			<a href="#" onClick="window.open('../print_forperiod.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&values=<?=$values?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_forperiod.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&values=<?=$values?>"><b><?=$lang_export_csv_head?></b></a>&nbsp;&nbsp; </p>
		</div>	
	</div>
	
	<div class="card stacked-form">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-6"> 
					<p><b><?=$lang_report?><br/><?=$heading?></b></p>
					<form name="showreport" method="post">
						<div class="table-full-width table-responsive">
							<table class="table table-hover table-striped">
								<thead>
									<th><?=$lang_report_transaction?></th>
									<th><?=$lang_report_number?></th>
									<th><?=$lang_report_commission?></th>
								</thead>
								<tbody>
									<tr>
										<td><?=$lhome_Imp?></td>
										<td><?=$sale[3]?></td>
										<td><?=$currSymbol?> <?=$sale[6]?></td>
									</tr>
									<tr>
										<td><?=$lang_report_click?>&nbsp;<img
						  alt="" border="0" height="10" src="../images/click.gif"
						 width="10"/></td>
										<td><?=$nclick?></td>
										<td><?=$currSymbol?> <?=$click?></td>
									</tr>
									<tr>
										<td><?=$lang_report_lead?>&nbsp;<img
						 alt="" border="0"   height="10" src="../images/lead.gif"
						 width="10"/></td>
										<td><?=$nlead?></td>
										<td><?=$currSymbol?> <?=$lead?></td>
									</tr>
									<tr>
										<td><?=$lang_report_sale?>&nbsp;<img
						  alt="" border="0" height="10" src="../images/sale.gif"
						  width="10"/></td>
										<td><?=$nsale?></td>
										<td><?=$currSymbol?> <?=$sale[0]?></td>
									</tr>
								</tbody>
							</table>
						</div>	
					</form>	
					<? viewRawTrans($sale[4], $sale[5]) ?>
					<div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<th><?=$lang_report_pending?></th>
								<th><?=$lang_report_reversed?></th>
							</thead>
							<tbody>								
								<tr>									
									<td><?=$currSymbol?> <?=$total[1]?></td>
									<td><?=$currSymbol?> <?=$total[3]?></td>
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