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
	
	if(!$btnsub=="View"){   
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

 <br/>

 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<form method="post" name="trans" id="trans" action="index.php?Act=TransReport">
  <table border="0" class="tablebdr" cellpadding="0" cellspacing="0" align="center" width="60%" id="AutoNumber1" >
    <tr>
      <td colspan="6" height="19" class="tdhead" align="center"><b> <?=$lang_report_stat?></b></td>
    </tr>
    <tr>
      <td colspan="6" height="19" align="center" class="textred"><?=$_SESSION['$msg']?></td>
    </tr>

    <tr>
      <td height="13" colspan="6" >&nbsp;&nbsp;&nbsp;&nbsp;<b><?=$lang_report_forperiod?></b></td>
    </tr>
    <tr>
      <td width="12%" height="30">&nbsp;</td>
      <td width="18%" height="30"><?=$lang_report_from?></td>
      <td width="30%" height="30"><input type="text" name="fromtxt" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /></td>
      <td width="17%" height="30">&nbsp;</td>
      <td width="13%" height="30"><b><?=$lang_home_pgms?> </b></td>
        <td width="10%" height="30"><select name="programs" ><option value="All" ><?=$lang_home_all_pgms?></option>
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
      </select></td>
    </tr>
    <tr>
      <td width="12%" height="27">&nbsp;&nbsp; </td>
      <td width="18%" height="27"><?=$lang_report_to?></td>
      <td width="30%" height="27"><input type="text" name="totxt" size="18" value="<?=$to?>"  onfocus="javascript:to_date();return false;" /></td>
      <td width="17%" height="27">&nbsp;</td>
      <td width="13%" height="27"> </td>
      <td width="10%" height="27"></td>
    </tr>

    <tr>
      <td width="12%" height="11"></td>
      <td height="11" colspan="5" align="center"></td>
    </tr>

    <tr align="center">
      <td height="21" colspan="6" >
	  <input type="checkbox" name="impr_cb" value="impr_cb" <?=$mchk?> />
	  <?=$lang_affiliate_head_impr?>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="checkbox" name="salecb" value="salecb" <?=$schk?> /> 
	  <?=$lang_affiliate_head_sale?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="checkbox" name="leadcb" value="leadcb" <?=$lchk?> /> 
	  <?=$lang_affiliate_head_lead?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="checkbox" name="clickcb" value="clickcb" <?=$cchk?> />  <?=$lang_affiliate_head_click?>&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="center" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="center" height="26" >
      <input type="submit" value="<?=$lang_report_view?>"  name="btnsub" /></td>
    </tr>
  </table>
</form>
<br />
	<?php
	if(isset($btnsub)){
		$programs	= trim($_POST['programs']);
		$From		= trim($_POST['fromtxt']);
		$To			= trim($_POST['totxt']);
		$sale		= trim($_POST['salecb']);
		$click		= trim($_POST['clickcb']);
		$lead		= trim($_POST['leadcb']);
		$impr		= trim($_POST['impr_cb']);
	
		$fdate		= trim($_POST['fromtxt']);
		$tdate		= trim($_POST['totxt']);
	
		if (($From==!"")||($To ==!"")){
			if(!$partners->is_date($From) || !$partners->is_date($To) ){
	?>
				<table width="100%" align="center">
					<tr>
						<td align="center" class="error"><?=$lang_report_err?></td>
					</tr>
				</table>
	<?
				exit;
			}
		}
		
		if ($sale=="" and $click=="" and $lead =="" and $impr==""){
	?>
			<table width="100%" align="center">
				<tr>
					<td align="center" class="error"><?=$lang_trans_empty_msg?></td>
				</tr>
			</table>
	<?
			exit;
		}
	$From	= $partners->date2mysql($From);
	$To		= $partners->date2mysql($To);
	
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
		<table class="tablebdr" cellspacing="1" width="95%"  align="center">
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
		<tr>
			<td colspan="5" align="center" class="textred"><?=$_SESSION['$res']?></td>
		</tr>
		
		<tr>
			<td width="15%" align="center" class="tdhead"><?=$lang_trans_type?></td>
			<td width="34%" align="center" class="tdhead"><?=$lang_affiliate_head_merchant?></td>
			<td width="21%" align="center" class="tdhead"><?=$lang_trans_commission?></td>
			<td width="16%" align="center" class="tdhead"><?=$lang_trans_date?></td>
			<td width="14%" align="center" colspan="2" class="tdhead"><?=$lang_trans_status?></td>
		</tr>
		
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
		
		
		<tr>
		<td width="15%" align="center" class="tdhead"><?=$lang_trans_type?></td>
		<td width="34%" align="center" class="tdhead"><?=$lang_affiliate_head_merchant?></td>
		<td width="21%" align="center" class="tdhead"><?=$lang_trans_commission?>- (Subid)</td>
		<td width="16%" align="center" class="tdhead"><?=$lang_trans_date?></td>
		<td width="14%" align="center"  class="tdhead"><?=$lang_trans_status?></td>
		</tr>
		
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
		<td width="15%" align="center"  ><?=$type?>&nbsp;<img
		alt="" border="0" height="10" src="../images/<?=$type?>.gif"
		width="10" /></td>
		<td width="34%" align="center"  >
		
		<a href="index.php?Act=viewprofile&amp;id=<?=$merchantid?>&amp;pgmid=<?=$pgmid?>&amp;status=<?=$stat?>"   >
		<?=stripslashes(ucwords($merchantname))?>
		</a></td>
		
		
		
		<td width="21%" align="center"  ><?=$currSymbol?><?=number_format($commission,2)?> (<?php echo $subid ; ?>)</td>
		<td width="16%" align="center" ><?=$dateoftransaction?></td>
		
		<td width="14%" align="left" >
		&nbsp;<img alt="" border="0" height="15" src="../images/<?=$tstatus?>.gif"
		width="15" />&nbsp;<?=$tstatus?></td>
		
		
		</tr>
		
		<?
		
		$gridcounter=$gridcounter+1; ;
		
		
		
		
		
		} // outer while closing
		
		}  // if checking the value of 3 chbox closing
		
		} // inner while close
		
		
		if($nocol=="0")
		{
		
		?>
		<!--  table  4-->
		<table width="100%" align="center">
		<tr>
		<td align="center" class="error"><?=$lang_no_rec?>
		</td>
		</tr>
		</table>
		
		<!-- close table 4-->
		
		<?
		
		}
		
		?>
		</table>
       <?
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