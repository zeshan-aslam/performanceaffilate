<?
 /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW LINK REPORTS
      VARIABLES          :  $MERCHANTID                                     =MERCHANTid
	                        $txtfrom                                        =from date
	                        $txtto                                          =to date
	                        $sub                                            =submit button
	                        $msg                                            =errmsg
	                        $LINKS                                          =getting statstics
	                        $i                                              =count(next record)
	                        $programs                                       =program id
	                        $TOTALREC                                       =total records
                            $heading										=subject
                            $id												=linkid
  //*************************************************************************************************/
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

  <?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';



    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    /************************variables****************************************/
    $MERCHANTID										=$_SESSION['MERCHANTID'];   //merchantid
    $txtfrom                                        =trim($_GET['txtfrom']);    //from date
    $txtto                                          =trim($_GET['txtto']);      //to date
    $sub                                            =trim($_GET['sub']);        //submit button
    $msg                                            =trim($_GET['msg']);        //err msg
    $LINKS                                          =trim($_SESSION['LINKS']);  //all reqired infmn
    $i                                              =trim($_GET['i']);          //counter
    $programs                                       =intval(trim($_GET['programs']));   //programid
    $Link                                           =explode("^",$LINKS);
    $TOTALREC										=count($Link)-1;
    /*************************************************************************/


     if(!empty($txtto) && !empty($txtfrom))
    {
     $heading=$txtfrom. " - ".$txtto;
    }

    $sql                                            ="SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2                                        =mysqli_query($con,$sql);
 ?>

  <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
 </iframe>

<form name="trans" method="post" action="link_process.php">
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
						<input name="currValue" type="hidden" value="<?=$currValue?>" />
						<input class="btn btn-fill btn-info" type="submit" name="sub" value="<?=$common_view?>" title="<?=$lang_report_view?>" />
					</div>
				</div>
			</div>
		</div>
	</div>
  </form>
<?
 if(!empty($sub))
  {
       $total=explode("~",$Link[$i]);
      if(!empty($_SESSION['LINKS']))
      {
  
       $To   = $partners->date2mysql($txtto);
       $From = $partners->date2mysql($txtfrom);
        # calculate impressions
       $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_linkid= '$total[6]'";
       $impSql .= " And imp_date between '$From' AND '$To' ";

       $impRet	= mysqli_query($con,$impSql);
	   $row_impr	= mysqli_fetch_object($impRet);
	   $numRec	= $row_impr->impr_count;
		if($numRec == '') $numRec = 0; 

       $rawClick = GetRawTrans('click', 0, 0,0, $total[6], $From, $To, 0);
       $rawImp   = GetRawTrans('impression',0, 0, 0,$total[6],$From, $To, 0);
       
	   $selDate		= $heading ;

	   ?> 
	   <div class="card stacked-form">
		<div class="card-body"> 
			<p align="right"><a href="#" onClick="window.open('../print_link.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&from=<?=$From?>&to=<?=$To?>&program=<?=$programs?>&currValue=<?=$currValue?>&currsymbol=<?=$currSymbol?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_link.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&from=<?=$From?>&to=<?=$To?>&program=<?=$programs?>&currValue=<?=$currValue?>&currsymbol=<?=$currSymbol?>"><b><?=$lang_export_csv_head?></b></a> &nbsp;&nbsp;&nbsp;</p>
		</div>	
	</div>
	  <div class="card stacked-form">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<p><b><?=$lang_report?><br/><?=$heading?></b></p>
						<div class="table-full-width table-responsive">
							<table class="table table-hover table-striped">
								<tbody>
									<tr>
										<td colspan="4">
											<?
										  if (  substr($total[6],0,1)=='H' )
										 {
											$id=substr($total[6],1,strlen($total[6])-1);
										 ?>
										   <a href='temp.php?rowid=<?=$id ?>' target="new">
										   <?=$lang_report_Click?>  </a>
										 <?
										 }

										  if (  substr($total[6],0,1)=='T' )
										 {
											$id          =substr($total[6],1,strlen($total[6])-1);
										 ?>
										   <a href='../admin/text.php?id=<?=$id ?>' target="new">
										   <?=$lang_report_Click_text?> </a>

										 <?
										 }
										  if (  substr($total[6],0,1)=='P' )
										 {

											$id         =substr($total[6],1,strlen($total[6])-1);
											$sql        ="select * from partners_popup where popup_id='$id'";
											$result     =mysqli_query($con,$sql);
											$row        =mysqli_fetch_object($result)
										 ?>
										   <a href="#" onclick="window.open('<?=stripslashes($row->popup_url)?>',<?=$row->popup_width?>,<?=$row->popup_height?>)" ><?=$lang_report_Click_pop?>
										   </a>
										 <?
										 }
										 if (substr($total[6],0,1)=='B')
										 {
										  $id             =substr($total[6],1,strlen($total[6])-1);
										  $sql            ="select * from partners_banner where banner_id='$id'";
										  $result         =mysqli_query($con,$sql);
										  $row            =mysqli_fetch_object($result);
										  //echo $row->banner_name;
										 ?>
										 <img border="0" src="<?=stripslashes($row->banner_name)?>" width="300" height="70">
										 <?
										 }

										 if  (substr($total[6],0,1)=='F')
										 {
										  $id            =substr($total[6],1,strlen($total[6])-1);
										  $sql           ="select * from partners_flash where flash_id='$id'";
										  $result        =mysqli_query($con,$sql);
										  $row           =mysqli_fetch_object($result);

										 ?>
										 <embed border="0" src="<?=stripslashes($row->flash_url)?>" width="300" height="70">
										 <?
										 }
										 ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
					 <? viewRawTrans($rawClick, $rawImp) ?>
						<div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
								<thead><tr >
								<td   ><b><?=$lang_report_transaction?></b></td>
								<td   ><b><?=$lang_report_number?></b></td>
								<td ><?=$lang_report_commision?></td>
								</tr></thead>
							<tbody>
							<tr>
								<td ><?=$lhome_Imp?></td>
								<td  ><?=$numRec?></td>
								<td ><?=$total[12]?> <?=$currSymbol?></td>
	                         </tr>
							  <tr>
								   <td><?=$lang_report_click?>&nbsp;
								   <img alt="" border="0" height="10" src="../images/click.gif" width="10" /></td>
								   <td  ><?=$total[1]?></td>
								   <td ><?=$total[0]?> <?=$currSymbol?></td>
							  </tr>
							  <tr>
								   <td ><?=$lang_report_lead?>&nbsp;
								   <img alt="" border="0" class="grid1" height="10" src="../images/lead.gif" width="10" /></td>
								   <td ><?=$total[3]?></td>
								   <td ><?=$total[2]?> <?=$currSymbol?></td>
							  </tr>
							  <tr>
								   <td ><?=$lang_report_sale?>&nbsp;
								   <img alt="" border="0" class="grid1" height="10" src="../images/sale.gif" width="10" /></td>
								   <td ><?=$total[5]?></td>
								   <td><?=$total[4]?> <?=$currSymbol?></td>
							  </tr>
								<tr>
								   <td ><b><?=$lang_report_pending?></b></td>
								   <td ><b><?=$lang_report_reversed?></b></td>
							  </tr>
						  <tr>
							  <td><?=$total[8]?> <?=$currSymbol?></td>
							  <td ><?=$total[10]?> <?=$currSymbol?></td>
						  </tr>
							</tbody>
							</table>
						</div>
						<div class="table-full-width table-responsive">
							<table class="table table-hover table-striped">
								<tbody> <tr>
										  <td   >
										  <?
											if($i!=1){
										  ?>
											   <a href="index.php?Act=LinkReport&amp;i=<?=($i-1)?>&amp;sub=$sub&amp;txtto=<?=$txtto?>&amp;txtfrom=<?=$txtfrom?>&amp;programs=<?=$programs?>"><?=$lang_report_previous?></a>
										   <?
										   }
										   else
										   {
												echo "$lang_report_previous";
										   }
										   ?>
										   </td>
										   <td    class="tdhead" colspan="2" ><?=$lang_report_totalrec?> - <?=$TOTALREC?></td>
										  <td   >
											 <?
											if($i!=(count($Link)-1))
											{
											?>
										   <a href="index.php?Act=LinkReport&amp;i=<?=($i+1)?>&amp;sub=$sub&amp;txtto=<?=$txtto?>&amp;txtfrom=<?=$txtfrom?>&amp;programs=<?=$programs?>"><?=$lang_report_next?></a>
										   <?
										   }
										   else
										   {
											 echo "$lang_report_next";
											}
										   ?>
										   </td>
								 </tr></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>		
                 
				 
           
    <?  
     }
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
     }
    ?>