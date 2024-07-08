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
  include_once '../includes/session.php';


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    /****************************variables************************************/
    $MERCHANTID                   =$_SESSION['MERCHANTID'];//merchantid
    $total                        =trim($_GET['total']);   //total pending,reversed etc transactions
    $click                        =trim($_GET['click']);   //click amnt
    $nclick                       =trim($_GET['nclick']);  //no of clicks
    $lead                         =trim($_GET['lead']);    //lead amnt
    $nlead                        =trim($_GET['nlead']);   //no of leads
    $sale                         =trim($_GET['sale']);    //sale amnt
    $nsale                        =trim($_GET['nsale']);   //no of sales
    $from                         =trim($_GET['from']);    //from date
    $to                           =trim($_GET['to']);      //to date
    $msg                          =trim($_GET['err']);     //err msg
    $sub                          =trim($_GET['sub']);     //submit button
    $programs                     =intval(trim($_GET['programs']));//programid

    $sale                         =explode("~",$sale);
    $total                        =explode('~',$total);
    /**************************************************************************/


    if(!empty($to) && !empty($to))
    {
     $heading=$from. " - ".$to;
    }
  //  echo "$programs";
    $sql        = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2    = mysqli_query($con,$sql);

 ?>
  <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe> 
<form name="report" method="post" action="programs_process.php">
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
   	$selDate	= $heading ;
	$values 	= $sale[7]."~".$sale[10]."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale[0]."~".$sale[2]."~".$sale[1]."~".$total[1]."~".$total[3]."~".$currSymbol;
   ?>	
	<div class="card strpied-tabled-with-hover">
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					 <p align="right"><a href="#" onClick="window.open('../print_programs.php?mid=<?=$MERCHANTID?>&date=<?=$selDate?>&program=<?=$programs?>&values=<?=$values?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_programs.php?mid=<?=$MERCHANTID?>&date=<?=$selDate?>&program=<?=$programs?>&values=<?=$values?>"><b>Export as CSV</b></a> &nbsp;&nbsp;&nbsp;</p>
					
				<form name="showreport" method="post" action="" >
					 <p><b><?=$lang_report?><br/><?=$heading?></b></p>
					 <p><?=$lang_report_AllAffil?> :<?=$sale[3]?></p>
					<div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead> 
								<tr>
									<th><?=$lang_report_transaction?></th>
									<th><?=$lang_report_mumber?></th>
									<th><?=$lang_report_commision?></th>
								</tr>
							</thead>
							<tbody>	
								<tr>
									<td><?=$lhome_Imp?></td>
									<td><?=$sale[7]?></td>
									<td><?=$sale[10]?> <?=$currSymbol?></td>
								</tr>
								<tr>
									<td><?=$lang_report_click?>&nbsp;<img alt="" border="0" height="10" src="../images/click.gif"
									  width="10" /></td>
									<td><?=$nclick?></td>
									<td><?=$currSymbol?>&nbsp;<?=$click?></td>
								</tr>
								<tr>
								  <td><?=$lang_report_lead?>&nbsp;<img alt="" border="0" class="grid1" height="10" src="../images/lead.gif"
								  width="10" /></td>
								  <td><?=$nlead?></td>
								  <td><?=$currSymbol?>&nbsp;<?=$lead?></td>
								</tr>
							  <tr>
								  <td><?=$lang_report_sale?>&nbsp;<img alt="" border="0" class="grid1" height="10" src="../images/sale.gif"
								  width="10" /></td>
								  <td><?=$nsale?></td>
								  <td><?=$currSymbol?>&nbsp;<?=$sale[0]?></td>
							  </tr>
							</tbody>
						</table>
					</div>	 
					<? viewRawTrans($sale[8], $sale[9]) ?>
					<div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th><?=$lang_report_pending?></th>
									<th><?=$lang_report_reversed?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?=$currSymbol?>&nbsp;<?=$total[1]?></td>
									<td><?=$currSymbol?>&nbsp;<?=$total[3]?></td>
								</tr>
							</tbody>       
						</table>
					</div>
				</form>
			</div>	
		</div>	
	</div>	
</div>	
  <?
  }
  ?>