	<script language="javascript" type="text/javascript">
		function from_date(){
			gfPop.fStartPop(document.trans.txtfrom,Date);
		}
		function to_date(){
			gfPop.fStartPop(document.trans.txtto,Date);
		}
	</script>

	<?

    $total                        =trim($_GET['total']);         //statistics
    $click                        =trim($_GET['click']);         //total click amnt
    $nclick                       =trim($_GET['nclick']);        //total click
    $lead                         =trim($_GET['lead']);          //total lead amnt
    $nlead                        =trim($_GET['nlead']);         //total lead
    $sale                         =trim($_GET['sale']);          //total sale amnt
    $nsale                        =trim($_GET['nsale']);         //total sale
    $from                         =trim($_GET['from']);          //from date
    $to                           =trim($_GET['to']);            //to date
    $merchant                     =intval(trim($_GET['merchant']));      //merchant id
    $affiliate                    =intval(trim($_GET['affiliate']));     //affiliateid
    $msg                          =trim($_GET['err']);           //err msg
    $sub                          =trim($_GET['sub']);           //submit button
    $sale                         =explode("~",$sale);
    $total                        =explode('~',$total);
	$impression						=trim($_REQUEST['impression']);      //impression_amt

	if(!empty($to) && !empty($to)){
		$heading=$from. " - ".$to;
	}
 ?>
 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe>

<form name="trans" method="post" action="forperiod_process.php?currCaption=<?=$currValue?>" >
<input type="hidden" name="AFFILIATEID" value="<?php echo $_SESSION['AFFILIATEID'];  ?>">
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
					<input class="btn btn-fill btn-info" type="submit" name="sub"  value="<?=$lang_report_view?>" />
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
	$values	= $sale[3]."~".$impression."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale[0]."~".$sale[2]."~".$sale[1]."~".$currSymbol;
   
   ?>
   <div class="card stacked-form">
		<div class="card-body">
			<p align="right"><a href="#" onClick="window.open('../print_forperiod.php?aid=<?=$AFFILIATEID?>&mode=affiliate&date=<?=$selDate?>&values=<?=$values?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_forperiod.php?aid=<?=$AFFILIATEID?>&mode=affiliate&date=<?=$selDate?>&values=<?=$values?>"><b><?=$lang_export_csv_head?></b></a></p>
		</div>	
	</div>
	<div class="card stacked-form">
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-6">	
					<p><b><?=$lang_report?><br/><?=$heading?></b></p>	
					<div class="table-full-width table-responsive">
							<table class="table table-hover table-striped">
								<thead>
									<th><?=$lang_home_transaction?></th>
									<th><?=$lang_home_number?></th>
									<th><?=$lang_home_commission?></th>
								</thead>
								<tbody>
								<!--	<td><?=$lang_affiliate_imp?>&nbsp;
									 <img alt="" border="0" height="10" src="../images/impression.gif" width="10"/></td>
									<td><?=$sale[3]?></td>
									<td><?=$currSymbol?><?=number_format((float)$impression,2)?></td>-->
							
              <tr>
               <td ><?=$lang_affiliate_imp?>&nbsp;<img alt="" border='0' height="10" src="../images/impression.gif" width="10" /></td>
               <td ><?=$sale[3]?></td>
               <td ><?=$currSymbol?><?=number_format((float)$impression,2)?></td>
              </tr> 
              <tr>
              <td><?=$lang_affiliate_head_click?>&nbsp;<img
              alt="" border="0" height="10" src="../images/click.gif"
              width="10" /></td>
              <td ><?=$nclick?></td>
              <td ><?=$currSymbol?><?=number_format((float)$click,2)?></td>
              </tr>
              <tr>
              <td ><?=$lang_affiliate_head_lead?>&nbsp;<img
              alt="" border="0" class="grid1" height="10" src="../images/lead.gif"
              width="10" /></td>
              <td ><?=$nlead?></td>
              <td ><?=$currSymbol?><?=number_format((float)$lead,2)?></td>
              </tr>
              <tr>
              <td ><?=$lang_affiliate_head_sale?>&nbsp;<img
              alt="" border="0" class="grid1" height="10" src="../images/sale.gif"
              width="10" /></td>
              <td ><?=$nsale?></td>
              <td ><?=$currSymbol?><?=number_format((float)$sale[0],2)?></td>
              </tr>
	</tbody>
        </table>
       <br/>
       <? viewRawTrans($sale[4], $sale[5]) ?>
        <br/>
			<div class="table-full-width table-responsive">
				<table class="table table-hover table-striped">
				<tr>
					<td ><b><?=$lang_home_pending?></b></td>
					<td ><?=$currSymbol?><?=number_format((float)$total[1],2)?></td>
				</tr>
				
				</table>
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>

  <?
  }
  ?>
  <br />