<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_referral.php                               */
/*     CREATED ON     :  19/AUG/2009                                    */

/*		CSV version of the Affiliate referral Report				    */
/************************************************************************/
include_once 'includes/db-connect.php';
	include 'includes/session.php';
	include 'includes/constants.php';
	include 'includes/functions.php';
	include 'includes/allstripslashes.php';
	include 'includes/function1.php';


	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$reportobj	= new report();

	include_once 'language_include.php';

	$affiliate	= intval($_REQUEST['aid']);
	$txtfrom	= $_REQUEST['txtfrom'];
	$txtto		= $_REQUEST['txtto'];
	$heading	= $_REQUEST['heading'];
	$mode		= $_REQUEST['mode'];
	
	if($affiliate) $affiliateName = $reportobj->FindAffiliateName($affiliate);
	
	$From 	= $partners->date2mysql($txtfrom);  
	$To 	= $partners->date2mysql($txtto);
	
	if($mode == 'admin') 
	{
		$sql_referal = "SELECT COUNT(subsale_id) AS Cnt, SUM(subsale_amount) AS Sum, affiliate_company, affiliate_id 
				FROM partners_transaction_subsale, partners_affiliate 
				WHERE subsale_date BETWEEN '$From' AND '$To' 
				AND affiliate_id = subsale_affiliateid  
				GROUP BY subsale_affiliateid ";
	} 
	else 
	{
		$sql_referal = "SELECT COUNT(subsale_id) AS Cnt, SUM(subsale_amount) AS Sum, affiliate_company, subsale_childaffiliateid 
				FROM partners_transaction_subsale, partners_affiliate 
				WHERE subsale_affiliateid='$affiliate' AND subsale_date BETWEEN '$From' AND '$To' 
				AND affiliate_id = subsale_childaffiliateid 
				GROUP BY subsale_childaffiliateid "; 
	}
	$res_referal = mysqli_query($con,$sql_referal);  

	
	$csv_referal = $lang_referral_report." ".$lang_report_forperiod." ".$heading."\r\n";
	if($mode != 'admin') {
		$csv_referal .= $lang_report_affiliate." ".$affiliateName."\r\n\r\n";
	}
	$csv_referal .= $lang_referral_downlines.",".$lang_referral_salesMade.",".$trans_commission."\r\n";

	$total = 0;
	while($row_referal = mysqli_fetch_object($res_referal)){
		$total += $row_referal->Sum;
		$csv_referal .= $row_referal->affiliate_company.",".$row_referal->Cnt.",$".$row_referal->Sum."\r\n";
	}
	$csv_referal .= $lang_total_commission.",,$".$total."\r\n";


	
	$fileName = $_SESSION['AFFILIATEID']."_affiliate_referral.csv";
	
	$fp = fopen( "reports/".$fileName,"w");
	fwrite($fp,$csv_referal);
	fclose($fp);

//Download file
	$newFile	= 	$fileName;
	$path		=	"reports/".$newFile;

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



 