<?php 
include('config.php'); 

$ifvalcheck = $_GET['from'];
if ($ifvalcheck == '')
{
	
	$leadgenid = isset($_GET['leadgenid']) ? $_GET['leadgenid'] : '';
	$campagin = isset($_GET['campagin']) ? $_GET['campagin'] : '';
	$from = isset($_GET['from']) ? $_GET['from'] : '';


	$to = isset($_GET['to']) ? $_GET['to'] : '';
	$impr_type = isset($_GET['impr_type']) ? $_GET['impr_type'] : '';
	$currSymbol = isset($_GET['currsymbol']) ? $_GET['currsymbol'] : '';
	$submission = isset($_GET['submission']) ? $_GET['submission'] : '';
	$quali_lead = isset($_GET['quali_lead']) ? $_GET['quali_lead'] : '';
	$daily_charges = isset($_GET['daily_charges']) ? $_GET['daily_charges'] : '';

	$tblname = $prefix."affilates_charges";
	$sql = "select * from $tblname where user_id = '$leadgenid'";

	$sql .= " order by date desc";

	$ret 	=	mysqli_query($con,$sql);
}
else
{
	$leadgenid = isset($_GET['leadgenid']) ? $_GET['leadgenid'] : '';
	$campagin = isset($_GET['campagin']) ? $_GET['campagin'] : '';
	$from = isset($_GET['from']) ? $_GET['from'] : '';


	$to = isset($_GET['to']) ? $_GET['to'] : '';
	$impr_type = isset($_GET['impr_type']) ? $_GET['impr_type'] : '';
	$currSymbol = isset($_GET['currsymbol']) ? $_GET['currsymbol'] : '';
	$submission = isset($_GET['submission']) ? $_GET['submission'] : '';
	$quali_lead = isset($_GET['quali_lead']) ? $_GET['quali_lead'] : '';
	$daily_charges = isset($_GET['daily_charges']) ? $_GET['daily_charges'] : '';

	$tblname = $prefix."affilates_charges";
	$sql = "select * from $tblname where user_id = '$leadgenid'";
	$sql .= ($campagin != "All" and !empty($campagin))?" AND campagin_id = '$campagin'":"";



//if(is_date($from) && is_date($to)){
//	$To   = date2mysql($to);
	//$From = date2mysql($from);
	//$sql.= " AND Date(date) BETWEEN '$From' AND '$To' ";
//}


if ($impr_type== '' or $impr_type==1 or $submission==1 or $quali_lead==1)
{
	$To   = date2mysql($to);
	$Fromdate = date2mysql($from);
	$sql.= " AND Date BETWEEN '$from' AND '$to' ";
	
}
if($impr_type==1 or $submission==1 or $quali_lead==1){
	$tsql  .= ($impr_type==1)  ? "  OR  lead_type = 'impression' " : "";
	$tsql  .= ($submission==1)  ? "  OR  lead_type = 'submissions' " : "";
	$tsql  .= ($quali_lead==1) ? "  OR  lead_type = 'confirm_leads' " : "";
	$tsql  .= ($daily_charges==1) ? "  OR  lead_type = 'daily_charges' " : "";
	$tsql = trim($tsql);
	$tsql = trim($tsql,"OR");
	$tsql = " AND (".$tsql.")";
	$sql .= $tsql;
}
else
{
	
	
}

$sql .= " order by date desc";

$ret 	=	mysqli_query($con,$sql);
	
}


?>
<html>
<title>Avaz Affilate Network</title>
<head></head>
<body>
	<table class="tableNew" cellspacing="1" width="80%" align="center" >
		<tr><td colspan="2" align=""><b>Transaction Report </b></td><td colspan="1" align="">In (<?=$currSymbol?>)</b></td></tr>
		<tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td width="10%" align="left" ><b>Type</b></td>
			<td width="10%" align="left" ><b>Campagin Name</b></td>
			<td width="10%" align="left" ><b>Charges</b></td>
			<td width="25%" align="left" ><b>Date</b></td>
		</tr>
		<tr><td colspan="6" ><hr /></td></tr>
		<tr><td colspan="6">&nbsp;</td></tr>
		
		<? while($rows=mysqli_fetch_object($ret)){ 
		
				$campid = $rows->campagin_id;
									$sqlss = select("company", "id = '$campid'");
									$comss = fetch($sqlss); 
		?>
		<tr class="">
			<td width="10%" align="left"><?=$rows->lead_type?></td>
			<td width="10%" align="left"><?=$comss['company_name']?></td>
			<td width="10%" align="left"><?=number_format($rows->affilate_charges, 2)?></td>
			<td width="25%" align="left"><?=date('d, m Y',strtotime($rows->date))?></td>
		</tr>
		<?php } ?>
	<tr><td colspan="6"><hr /></td></tr>
	<tr><td colspan="6" align="right">
		<img src="img/printer.png" /><a href="#" onClick="javascript: window.print();" >Print Report</a>
	</td></tr>
	</table>
</body>
</html>