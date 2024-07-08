<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_programs.php     		            	    */
/*     CREATED ON     :  19/JULY/2006                                   */

/*		Exporting Programs Report of Merchant to CSV Format				*/
/************************************************************************/
include_once 'includes/db-connect.php';
  include 'includes/session.php';
  include 'includes/constants.php';
  include 'includes/functions.php';
  include 'includes/allstripslashes.php';
  include 'includes/function1.php';
  

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	include_once 'language_include.php';
	
	$reportobj	= new report();

	$date		= $_REQUEST['date'];
	$merchant	= $_REQUEST['mid'];
	$program	= $_REQUEST['program'];
	$values		= $_REQUEST['values'];
	$values		= explode("~",$values);
	$nimpr		= $values[0];
	$impr		= $values[1];
	$nclick		= $values[2];
	$click		= $values[3];
	$nlead		= $values[4];
	$lead		= $values[5];
	$nsale		= $values[6];
	$sale		= $values[7];
	$pending	= $values[10];
	$reversed	= $values[11];
	$currsymbol	= $values[12];
	
	
	$merchantName	= $reportobj->FindMerchantName($merchant);	

	if($program == 'All') $programName = $lang_report_AllProgram;
	else {
		$programName = $reportobj->FindProgramName($program);
	}

	$csv_trans = $lang_report_stat." ".$date."\r\n";
	$csv_trans .= $lang_report_merchant." : ".$merchantName."\r\n";
	$csv_trans .= $lang_pgm." : ".$programName."\r\n";
	$csv_trans .= $lang_report_transaction.",".$lang_report_number.",".$lang_report_commission."\r\n";
	$csv_trans .= $lang_impression.",".$nimpr.",".$currsymbol.$impr."\r\n";
	$csv_trans .= $lang_click.",".$nclick.",".$currsymbol.$click."\r\n";
	$csv_trans .= $lang_lead.",".$nlead.",".$currsymbol.$lead."\r\n";
	$csv_trans .= $lang_sale.",".$nsale.",".$currsymbol.$sale."\r\n";
	$csv_trans .= $lang_report_reversed_amt." : ".$currsymbol.$reversed."\r\n";
	$csv_trans .= $lang_report_pending_amt." : ".$currsymbol.$pending."\r\n";

//Creating file	
	$fileName = $_SESSION['MERCHANTID']."_merchant_programs.csv";
	
	$fp = fopen( "reports/".$fileName,"w");
	fwrite($fp,$csv_trans);
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
	