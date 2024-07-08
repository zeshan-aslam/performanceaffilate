<?php 
include('config.php');


$ifvalcheck = $_GET['from'];
if ($ifvalcheck == '')
{
	
	$leadgenid = isset($_GET['leadgenid']) ? $_GET['leadgenid'] : '';
	$campagin = isset($_GET['campagin']) ? $_GET['campagin'] : '';
	$from = isset($_GET['from']) ? $_GET['from'] : '';
	$to = isset($_GET['to']) ? $_GET['to'] : '';
	$currSymbol = isset($_GET['currsymbol']) ? $_GET['currsymbol'] : '';
	$impr_type = isset($_GET['impr_type']) ? $_GET['impr_type'] : '';
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
	$currSymbol = isset($_GET['currsymbol']) ? $_GET['currsymbol'] : '';
	$impr_type = isset($_GET['impr_type']) ? $_GET['impr_type'] : '';
	$submission = isset($_GET['submission']) ? $_GET['submission'] : '';
	$quali_lead = isset($_GET['quali_lead']) ? $_GET['quali_lead'] : '';
	$daily_charges = isset($_GET['daily_charges']) ? $_GET['daily_charges'] : '';


	$tblname = $prefix."affilates_charges";
	$sql = "select * from $tblname where user_id = '$leadgenid'";
	$sql .= ($campagin != "All" and !empty($campagin))?" AND campagin_id = '$campagin'":"";
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
	$sql .= " order by date desc";
	$ret 	=	mysqli_query($con,$sql);
		
}
	





//if(is_date($from) && is_date($to)){
	//$To   = date2mysql($to);
	//$From = date2mysql($from);
	//$sql.= " AND Date(date) BETWEEN '$From' AND '$To' ";
//}


$csv_trans = "Transaction Report, ,In (".$currSymbol.") \r\n";
$csv_trans .= "Type,Campagin Name,Charges,Date \r\n";
while($rows=mysqli_fetch_object($ret)){
	$campid = $rows->campagin_id;
	$sqlss = select("company", "id = '$campid'");
	$comss = fetch($sqlss); 
	$csv_trans .= $rows->lead_type.",".$comss['company_name'].",".number_format($rows->affilate_charges, 2).",".date('d/m/Y',strtotime($rows->date))."\r\n";
}

$fileName =	$leadgenid."_leadgen_submissions.csv";
$fp = fopen( ROOT."/reports/".$fileName,"w");
fwrite($fp,$csv_trans);
fclose($fp);
$newFile	= 	$fileName;
$path		=	ROOT."/reports/".$newFile;

header("Pragma: public");
header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: application/force-download");
header('Content-Disposition: attachment; filename="'.$newFile.'"');
header("Content-Transfer-Encoding: binary");
header('Content-Length: '.@filesize($path));
set_time_limit(0);
@readfile($path) OR die("file not found");

	unlink($path);

	exit;
?>