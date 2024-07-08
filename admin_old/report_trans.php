	<?
	$nocol	= "0";
	$msg	= "";
	$sql 	= "SELECT * FROM partners_merchant ";
	$ret	= mysqli_query($con,$sql);
	
	$sql 	= "SELECT * FROM partners_affiliate ";
	$ret1	= mysqli_query($con,$sql) or die("cant exe");
	
	if(!$btnsub=="View"){   
		$_SESSION['$msg']	= "";
		$_SESSION['$res']	= "";
		$schk="checked = 'checked'";
		$cchk="checked = 'checked'";
		$lchk="checked = 'checked'";
		$mchk="checked = 'checked'";
	}
    if(isset($btnsub)){
		$Merchant	= trim($_POST['Mname']);
		$Affiliate	= trim($_POST['Aname']);
		$From		= trim($_POST['fromtxt']);
		$To			= trim($_POST['totxt']);

		$sale		= trim($_POST['salecb']);
		$click		= trim($_POST['clickcb']);
		$lead		= trim($_POST['leadcb']);
		$impr		= trim($_POST['impr_cb']);

		$fdate		= trim($_POST['fromtxt']);
		$tdate		= trim($_POST['totxt']);
	}
	
	if(isset($btnsub)){	
		$Merchant	= trim($_POST['Mname']);
		$Affiliate	= trim($_POST['Aname']);
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
				$msg = "Please Enter a Valid Date";
			}
		}
		if ($sale=="" and $click=="" and $lead =="" and $impr==""){
			$msg = "Please select Sale,Click,Lead,Impression or all";
		}
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
	
<form method="post" name="trans" id="trans" action="index.php?Act=transaction">
<table border='0' cellpadding="0" cellspacing="0" class="tablebdr" >
    <tr>
      	<td colspan="8" height="19" class="tdhead" align="center"><b>Statistics For Custom Period</b></td>
    </tr>
    <tr>
      	<td colspan="8" height="19" >
      		<p align="center" class="textred"><?= $msg?></p></td>
    </tr>
    <tr>
      <td width="2%" height="13">&nbsp;</td>
      <td height="40" colspan="3" align="center"><b>For Period</b></td>
      <td colspan="4" height="13">&nbsp;</td>
    </tr>
    <tr>
      <td width="2%" height="22">&nbsp;</td>
      <td width="9%" height="22" align="right">From</td>
      <td width="2%">&nbsp;</td>
      <td width="24%" height="22" align="left">
	  <input type="text" name="fromtxt" size="18" value="<?=$From?>" onfocus="javascript:from_date();return false;" /></td>
      <td width="12%" height="22">&nbsp;</td>
      <td width="11%" height="22" align="right">Merchant&nbsp; </td>
      <td width="3%">&nbsp;</td>
      <td width="37%" height="22" align="left">
	  <select size="1" name="Mname">
        <option value="All">All Merchants</option>
			
			<?  
			while($row=mysqli_fetch_object($ret)){
				if($Merchant==$row->merchant_id)
					$MerchantName="selected = 'selected'";
				else
					$MerchantName="";
			?>
				<option <?=$MerchantName?> value="<?=$row->merchant_id?>"> <?=stripslashes($row->merchant_company)?> </option>
			<?
			}    // while close
			?>
      </select></td>
    </tr>
	<tr><td colspan="8" height="10"></td></tr>
    <tr>
      <td width="2%" height="22">&nbsp;&nbsp; </td>
      <td width="9%" height="22" align="right">To</td>
      <td width="2%">&nbsp;</td>
      <td width="24%" height="22" align="left">
	  	<input type="text" name="totxt" size="18" value="<?=$To?>"  onfocus="javascript:to_date();return false;" /></td>
      <td width="12%" height="22">&nbsp;</td>
      <td width="11%" height="22" align="right">Affiliate </td>
      <td width="3%">&nbsp;</td>
      <td width="37%" height="22" align="left">
	  <select size="1" name="Aname">
      <option  value="All">All  Affiliate</option>
		<?  while($row=mysqli_fetch_object($ret1))
		   {
		   if($Affiliate== $row->affiliate_id)
				 $AffiliateName="selected = 'selected'";
		   else
				 $AffiliateName="";
		?>
			 <option <?=$AffiliateName?> value="<?=$row->affiliate_id?>"><?=stripslashes($row->affiliate_company)?></option>
		   <?
		   } /// while close
		   ?>
      </select></td>
    </tr>
    <tr>
      <td width="2%" height="11"></td>
      <td height="11" colspan="7" align="center"></td>
    </tr>
    <tr>
      <td width="2%" height="21" >&nbsp;</td>
      <td height="21" colspan="7" align="center" ><input type="checkbox" name="impr_cb" value="impr_cb" <?=$mchk?> /> 
      Impression
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="checkbox" name="salecb" value="salecb" <?=$schk?> /> 
      Sale&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="leadcb" value="leadcb" <?=$lchk?> />
      Lead&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="clickcb" value="clickcb" <?=$cchk?> />
      Click&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" align="center" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" align="center" height="26" ><input type="submit" value="View" name="btnsub" /></td>
    </tr>
</table><br />
</form>
<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>

<?php
if(!$msg){
    if(isset($btnsub)){
		$From	= $partners->date2mysql($From);
		$To		= $partners->date2mysql($To);

		switch($Merchant){
			case 'All': {
				switch ($Affiliate){
					case 'All':
						$sql	= "SELECT * FROM partners_joinpgm ";
					break;
					
					default:
						$sql	= "SELECT * FROM partners_joinpgm WHERE joinpgm_affiliateid = '$Affiliate'";
					break;
				}
			break;
			}
			
			default:{
				switch ($Affiliate){
					case 'All':
						$sql	= " SELECT * FROM partners_joinpgm,partners_program 
									WHERE program_merchantid = '$Merchant' AND joinpgm_programid = program_id ";
					break;
					default:
						$sql	= " SELECT * FROM partners_joinpgm, partners_program WHERE program_merchantid = '$Merchant' 
									AND joinpgm_affiliateid = '$Affiliate' AND joinpgm_programid = program_id ";
					break;
				}
			}
		}

	$result1	= mysqli_query($con,$sql);
	$count		= "0";  // for  result table  head
	$querytype	= "";
	if ($click=="clickcb" || $sale=="salecb" || $lead=="leadcb" || $impr =="impr_cb"){
		if($click=="clickcb"){
			$querytype=" transaction_type= 'click'";
		}
		if($sale=="salecb"){
			if(empty($querytype))	  
				$querytype	= " transaction_type='sale'";
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
			?>
			<table class="tablebdr" cellspacing="1" width="85%" border="0">
			<?php

			while($rows=mysqli_fetch_object($result1)){
				$joinid	= $rows->joinpgm_id;
				$sql	= " SELECT * FROM partners_transaction AS t, partners_joinpgm AS j, 
							partners_merchant as m, partners_affiliate AS a";
				$sql   .= " WHERE transaction_dateoftransaction between '$From' AND '$To'";
				if(!empty( $querytype)){
					$sql.=" AND ($querytype)";
				}
				$sql   .= " AND transaction_joinpgmid = '$joinid' AND t.transaction_joinpgmid = j.joinpgm_id 
							AND j.joinpgm_merchantid=m.merchant_id AND j.joinpgm_affiliateid=a.affiliate_id";
			
				if ((trim($From)=="0000-00-00") AND (trim($To)=="0000-00-00")){
				
					$sql = " SELECT * FROM partners_transaction AS t, partners_joinpgm AS j, partners_merchant as m,  
							 partners_affiliate AS a";
					if(!empty( $querytype))		
						$sql.=" WHERE ($querytype)";
					else 
						$sql.=" WHERE 1";
					$sql    .= " AND transaction_joinpgmid = '$joinid' AND t.transaction_joinpgmid = j.joinpgm_id 
								 AND j.joinpgm_merchantid=m.merchant_id AND j.joinpgm_affiliateid=a.affiliate_id";
				}
				$result	= mysqli_query($con,$sql) or die("cant exe"); 
				$nclick	= mysqli_num_rows($result);
				
				if ($nclick=="0"){
					$count = "1";
				}
				
				if ($count=="0"){
					$table = "ok";
					$_SESSION['$res']="Report Between ".$From." and ".$To;
			
					if ((trim($From)=="0000-00-00") and (trim($To)=="0000-00-00")){
						$_SESSION['$res']="Complete Report ";
					}
			?>
			
				<p align="right">
				<a href="#" onClick="window.open('../print_transaction.php?mid=<?=$Merchant?>&aid=<?=$Affiliate?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$sale?>&lead=<?=$lead?>&impr=<?=$impr?>&click=<?=$click?>&mode=admin','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="../csv_transaction.php?mid=<?=$Merchant?>&aid=<?=$Affiliate?>&from=<?=$From?>&to=<?=$To?>&sale=<?=$sale?>&lead=<?=$lead?>&impr=<?=$impr?>&click=<?=$click?>&mode=admin"><b>Export as CSV</b></a>&nbsp;&nbsp;&nbsp;&nbsp;</p>
			<!--<table class="tablebdr" cellspacing="1" width="75%" border="0">-->
			<tr>
				<td colspan="7" class="tdhead" align="center"><b><?=$_SESSION['$res']?></b></td>
			</tr>		
			<tr>
			<td  align="center" class="tdhead"><b>Type</b></td>
			<td  align="center" class="tdhead"><b>Merchant</b></td>
			<td  align="center" class="tdhead"><b>Affiliate ID</b></td>
			<td  align="center" class="tdhead"><b>Commission</b></td>
			<td  align="center" class="tdhead"><b>Date</b></td>
			<td  align="center" class="tdhead"><b>Referer</b></td>
			<td  align="center" class="tdhead"><b>Status</b></td>
			</tr>
			<?
			}   // closing of if count
			
				$count		= "1";
				$gridcounter= 0;
				while($rows=mysqli_fetch_object($result)){ 
					if ($table!="ok"){
						$_SESSION['$res']="Report Between ".$From." and ".$To;
						if ((trim($From)=="0000-00-00") and (trim($To)=="0000-00-00")){
							$_SESSION['$res']="Complete Report ";
						}
						$table	= "ok";
			
					}
					else{
						$table	= "ok";
					}
					$nocol			= "1";
					$type			= $rows->transaction_type ;
					$merchantid		= $rows->joinpgm_merchantid ;
					$merchantname	= stripslashes($rows->merchant_company);
					$affiliateid 	= $rows->joinpgm_affiliateid ;
					$affiliatename 	= stripslashes($rows->affiliate_company) ;
					$tstatus 		= $rows->transaction_status ;
					$commission		= $rows->transaction_amttobepaid ;
					$date			= date('Y-m-d');
					
					$dateoftransaction 	= $rows->transaction_dateoftransaction ;
					$astatus			= $rows->joinpgm_status;
					$referer_url		= trim($rows->transaction_referer);
			
					if ($gridcounter%2==1){
						$classid	= "grid1";
					}else{
						$classid	= "grid2";
					}
					?>
					<tr class="<?=$classid?>">
					<td align="center" ><?=$type?>
					<img alt="" border='0' height="10" src="../images/<?=$type?>.gif" width="10" /></td>
					<td  align="center"><a href="#" onclick="help(<?=$merchantid?>)"><?=$merchantname?></a></td>
					<td  align="center"><a href="#"  onclick="help1(<?=$affiliateid?>)"> <?=$affiliatename?></a></td>
					<td  align="center"><?=$currSymbol?><?=round($commission,2)?></td>
					<td  align="center"><?=$dateoftransaction?></td>
					<td  align="center"><?php  if(!$referer_url) echo " "; else echo "<a href='$referer_url' title='$referer_url' target='new'>".substr($referer_url,0,30)."...</a>";?></td>
					<td  align="left" >&nbsp;
					<img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/<?=$tstatus?>.gif"/>&nbsp;
					<?=$tstatus?></td>
					</tr>
			<?
			$gridcounter=$gridcounter+1; ;
		}	
		}		
		?>
	</table>
		<?php
			if($nocol=="0"){?>
		<table cellspacing="1" width="75%" border="0" align="center">
			<tr>
				<td align="center" class="error"><b>No record Found Between <?=$From?> And <?=$To;?></b></td>
			</tr>		
		</table>
		<? } ?>
	<?
		}  // if checking the value of 3 chbox closing
		?>
		
	<?

	} // closing of if of submit check
}?>
<br />
	<script language="javascript" type="text/javascript">
	function help(merchantid){
		url="viewprofile_merchant.php?id="+merchantid;
		nw = open(url,'new','height=500,width=500,scrollbars=yes');
		nw.focus();
	}
	
	function help1(afiliateid){
		url="viewprofile_affiliate.php?id="+afiliateid;
		nw = open(url,'new','height=500,width=500,scrollbars=yes');
		nw.focus();
	}
	</script>