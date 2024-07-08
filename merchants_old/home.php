<?php
	include "transactions.php";


	
	$MERCHANTID		= $_SESSION['MERCHANTID']; # merchantid
	$programs		= intval(trim($_POST['programs'])); #  programid
	$rawClick		= 0; 
	$rawImp			= 0;
	
	if (empty($programs))
		$programs	= "All";
	else
	$_SESSION['PGMID']	= $programs;

	# data to add to dropdown box
	$sql        = " SELECT * FROM partners_program WHERE program_merchantid = '$MERCHANTID'";
	$result     = mysqli_query($con,$sql);


	# sql depending on pgm selected
	switch ($programs){
		case 'All';    # all pgm
			#$sql		= " SELECT * FROM partners_joinpgm WHERE joinpgm_merchantid = '$MERCHANTID' " ;
			$sql		= " SELECT * FROM partners_joinpgm, partners_affiliate   WHERE joinpgm_merchantid = '$MERCHANTID' 
				AND affiliate_id = joinpgm_affiliateid " ;
			$pgmid		= 0;
			
			# calculate impressions
			$impSql 	= " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily 
							WHERE imp_merchantid = '$MERCHANTID' ";
			
			$rawClick 	= GetRawTrans('click', $MERCHANTID, 0, 0, 0,  0,0, 0)   ;
			$rawImp   	= GetRawTrans('impression', $MERCHANTID, 0, 0, 0,  0,0, 0) ;
		
		break;
		default: 
			#$sql		= " SELECT * FROM partners_joinpgm WHERE joinpgm_programid = '$programs'";
			$sql		= " SELECT * FROM partners_joinpgm, partners_affiliate   WHERE joinpgm_programid = '$programs' 
					AND affiliate_id = joinpgm_affiliateid ";
			$pgmid		= $programs;
			
			# calculate impressions
			$impSql 	= " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_programid = '$programs' ";
			
			$rawClick = GetRawTrans('click', 0, 0, $programs, 0,  0,0, 0) ;
			$rawImp   = GetRawTrans('impression', 0, 0, $programs, 0,  0,0, 0) ;
		break;
	}
	
	# getting statistics for selected program
	# getting payments from transaction.php(click,sale,lead) values
	$total		= GetPaymentDetails($sql,$currValue,$default_currency_caption); 
	$total		= explode('~',$total);
	# getting total affiliates,waiting affiliates,transactions from transaction.php
	$afftotal	= GetTotalAffiliates($sql); 



	$afftotal	= explode('~',$afftotal);
	# getting advertising links from transaction.php
	$totallink	= GetLinks($pgmid,$MERCHANTID);
	$totallink  = explode('~',$totallink);

	$impRet		= mysqli_query($con,$impSql);
	$row_impr 	= mysqli_fetch_object($impRet);
	$numRec 	= $row_impr->impr_count;
	if($numRec == '') 
		$numRec = 0;
	if($currSymbol=="&pound") 
		$currSymbol = "&pound;";
	?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" class="tablewbdr">
<?php
	# check whether the balance for this merchant has reached the maximum amount set up by the admin
	$merchant_sql = "SELECT pay_amount FROM  merchant_pay  WHERE pay_merchantid = '$MERCHANTID'";
    $merchant_ret = mysqli_query($con,$merchant_sql);
	if($merchant_row = mysqli_fetch_object($merchant_ret)) 
		$merchant_balance = $merchant_row->pay_amount;

	# if maximum limit (from constants.php) is reached
	if($merchant_balance>$merchant_maximum_amount){
		/*get message from file
		$filename			= "../admin/merchant_maximum_balance_msg.htm";
		$fp 				= fopen($filename,'r');
		$merchant_message 	= fread ($fp, filesize ($filename));
		fclose($fp);	*/
?>
   <tr>
      <td width="100%" colspan="3" align="center" height="30" class="textred"><?=$lhome_maximum_limit_reached?></td>
  </tr>
<?php
	}
?>
	<tr>
		<td width="100%" colspan="3" align="center" class="red" >
		<a href="index.php?Act=GetCode"><img src="../images/Get track code.gif" border="0" alt="" /></a>
		<center><a href="index.php?Act=GetCode"><?=$lhome_GetTrackingCode?></a> </center><br/> </td>
	</tr>
	<tr>
		<td width="70%">
		<form name="Getprogram" method="post" action="">
		<table border="0" cellpadding="0" cellspacing="2" width="90%"  align="center" class="tablebdr">
			<tr>
				<td width="100%"  colspan="3" align="center" class="tdhead"><B><?=$lhome_ProgramStaistics?></B></td>
			</tr>
			<tr>
				<td width="100%" align="right"height="40" colspan="3"  ><b><?=$lhome_Programs?></b>
				<select name="programs" onchange="document.Getprogram.submit()">
					<option value="All" ><?=$lhome_AllPrograms?></option>
				<?  
					while($row=mysqli_fetch_object($result)){
						if($programs=="$row->program_id")
							$programName="selected = \"selected\"";
						else
							$programName="";
				?>
					<option <?=$programName?> value="<?=$row->program_id?>">
						<?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> 
					</option>
				<?
					}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<td width="100%" height="130" colspan="3" >
					<table border="0" cellpadding="0" cellspacing="0"width="90%" align="center">
					<tr >
						<td width="50%" height="20" align="center" ><?=$lhome_TotalAffiliates?> - 
						<a href="index.php?Act=listaffiliate&amp;pgmid=<?=$pgmid?>"><?=$afftotal[0]?> </a></td>
						<td width="50%" height="20" align="center" ><?=$lhome_Transactions?> -  
						<a href="index.php?Act=waitingpgm&amp;pgmid=<?=$pgmid?>"><?=$afftotal[2]?></a></td>
					</tr>
					<tr >
						<td width="50%" height="20" align="center" ><?=$lhome_RotatorApplications?> - 
						<a href="index.php?Act=waitrotator&amp;pgmid=<?=$pgmid?>"> <?=$afftotal[3]?></a></td>
						<td width="50%" height="20" align="center" ><?=$lhome_ProgramApplications?> -  
						<a href="index.php?Act=waitingaff&amp;pgmid=<?=$pgmid?>"><?=$afftotal[1]?></a></td>
					</tr>
					</table>
				<br/>
				
				<table border="0" cellpadding="0" cellspacing="3" width="70%" class="tablebdr" align="center"> 
					<tr>
						<td width="34%" class="tdhead"><b><?=$lhome_Transaction?></b></td>
						<td width="26%" align="center" class="tdhead"><b><?=$lhome_Number?></b></td>
						<td width="40%" align="center"class="tdhead"><b><?=$lhome_Commission?></b> </td>
					</tr>
					<tr>
						<td width="35%" class="grid1"><?=$lhome_Imp?></td>
						<td width="26%" align="center" class="grid1"><?=$numRec?></td>
						<td width="39%" align="center" class="grid1" ><?=$currSymbol?><?=number_format($total[12],2)?> </td>
					</tr>
					<tr>
						<td width="35%"  class="grid1"><?=$lhome_Click?>&nbsp;
						<img alt="" border="0" height="10" src="../images/click.gif" width="10"/></td>
						<td width="26%" align="center" class="grid1" ><?=$total[0]?></td>
						<td width="39%" align="center"  class="grid1" ><?=$currSymbol?><?=number_format($total[1],2)?> </td>
					</tr>
					<tr>
						<td width="35%"  class="grid1" ><?=$lhome_Lead?>&nbsp;
						<img alt="" border="0" height="10" src="../images/lead.gif" width="10"/></td>
						<td width="26%" align="center" class="grid1"><?=$total[2]?></td>
						<td width="39%" align="center" class="grid1"><?=$currSymbol?><?=number_format($total[3],2)?> </td>
					</tr>
					<tr>
						<td width="35%" class="grid1"><?=$lhome_Sale?>&nbsp;
						<img alt="" border="0" height="10" src="../images/sale.gif" width="10"/></td>
						<td width="26%" align="center"  class="grid1"><?=$total[4]?></td>
						<td width="39%" align="center"  class="grid1"><?=$currSymbol?><?=number_format($total[5],2)?> </td>
					</tr>
				</table>
				<? viewRawTrans($rawClick, $rawImp) ?>
				<br/>
				<table border="0" cellpadding="0" cellspacing="0"width="99%" class="tablewbdr" align="center">
				<?
				if ($programs<>'All'){
					$tot=$totallink[1]+$totallink[2]+$totallink[3]+$totallink[4]+$totallink[0];
					if($tot==0){
				?>
						<tr>
							<td width="25%" class="tdhead" align="center" colspan="5"><?=$lhome_AdvertisingLinks?></td>
						</tr>
						<tr>
							<td width="20%" height="20" align="center" class="textred" colspan="5"><?=$no_links?></td>
						</tr>
						<tr>
							<td width="20%" align="center" colspan="5" >
							<a href="index.php?Act=addlinks" ><?=$lhome_ClickHereToAddLinks?></a></td>
						</tr>
				<?
					}
					else{
				?>
						<tr>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_text"><?=$lhome_Text?> - <?=$totallink[1]?></a></td>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_html"><?=$lhome_HTML?> - <?=$totallink[4]?></a></td>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_banner"><?=$lhome_Banner?> -<?=$totallink[0]?></a></td>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_popup"><?=$lhome_Popup?> - <?=$totallink[2]?></a></td>
						<td width="20%" align="center"  >
						<a href="index.php?Act=add_flash"><?=$lhome_Flash?> - <?=$totallink[3]?></a></td>
						</tr>
				<?
					}
				}
				?>
				
				</table>
				</td>
			</tr>
		</table>
		</form>
		</td>
		<td width="1%">&nbsp;</td>
		<td width="30%" valign="top">
		<form  name="report" method="post" action="#">
		<table border="0" cellpadding="0" cellspacing="3" align="left" width="80%" class="tablebdr">
			<tr>
			<td width="100%" class="tdhead" colspan="2" align="center"><b><?=$lhome_Statistics?></b></td>
			</tr>
			<tr>
				<td width="50%" class="grid1">
				<img border="0" height="12" src="../images/suspend.gif" width="12" alt=""/>&nbsp;<?=$lhome_Reversed?>&nbsp;</td>
				<td width="50%" align="center" class="grid1"><?=$currSymbol?><?=number_format($total[9],2)?> </td>
			</tr>
			<tr>
				<td width="50%" class="grid1">
				<img alt="" border="0" height="12" src="../images/waiting.gif" width="12"/>&nbsp;<?=$lhome_Pending?>&nbsp;</td>
				<td width="50%" align="center" class="grid1"><?=$currSymbol?><?=number_format($total[7],2)?> </td>
			</tr>
			<tr>
				<td width="100%" colspan="2" align="center">
				<a href="index.php?Act=reversesale&amp;pgmid=<?=$pgmid?>"><?=$lhome_ReverseSale?> </a></td>
			</tr>
			<tr>
			<td width="100%" colspan="2" align="center" class="tdhead" height="15"><?=$lhome_Report?></td>
			</tr>
			<tr>
				<td width="50%" align="center" ><?=$lhome_Search?></td>
				<td width="50%" align="center"  height="40"><select name="reportRE" onchange="getpage()">
				<option value="#"><?=$lhome_SelectReport?></option>
				<option value="daily"><?=$lhome_Daily?></option>
				<option value="forperiod"><?=$lhome_ForPeriod?></option>
				<option value="LinkReport"><?=$lhome_Links?></option>
				<option value="ProgramReport"><?=$lhome_Programs?></option>
				<option value="AffiliateReport"><?=$lhome_Affiliates?></option>
				</select></td>
			</tr>
		</table>
		</form>
	</td>
	</tr>
</table>
<br />
<script language="javascript" type="text/javascript">
   function getpage(){
	   var Action		= (document.report.reportRE.value);
	   var url			= "index.php?Act="+Action; 
	   document.report.action	= url ;
	   document.report.submit();
   }
</script>