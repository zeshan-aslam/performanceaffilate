<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_recurring.php     		                    */
/*     CREATED ON     :  17/JULY/2006                                   */

/*		Exporting Recurring Report to CSV Format						*/
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

	$affiliate		= $_REQUEST['aid'];
	$date		= $_REQUEST['date'];
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
	$currsymbol	= $values[8];
	$subid		= $values[9];
	if($currsymbol == '') $currsymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];

	$affiliateName = $reportobj->FindAffiliateName($affiliate);

	$csv_trans = $lang_report_stat." ".$date."\r\n";
	$csv_trans .= $lang_report_affiliate." : ".$affiliateName."\r\n";
	$csv_trans .= $lang_report_subid." : ".$subid."\r\n";
	
	$csv_trans .= $lang_report_transaction.",".$lang_report_number.",".$lang_report_commission."\r\n";
	$csv_trans .= $lang_impression.",".$nimpr.",".$currsymbol.$impr."\r\n";
	$csv_trans .= $lang_click.",".$nclick.",".$currsymbol.$click."\r\n";
	$csv_trans .= $lang_lead.",".$nlead.",".$currsymbol.$lead."\r\n";
	$csv_trans .= $lang_sale.",".$nsale.",".$currsymbol.$sale."\r\n";


//Creating file	
	$fileName = $_SESSION['AFFILIATEID']."_affiliate_subid.csv";
	
	
	$fp = fopen( "reports/".$fileName,"w");
	fwrite($fp,$csv_trans);
	fclose($fp);


//Download file
	$newFile	= 	$fileName;
	$path		=	"reports/".$newFile;
/*
	header('Content-Type: application/force-download; filename="'.$newFile.'"');
	header('Content-Disposition: attachment; filename="'.$newFile.'"');
	readfile($path);
	
	unlink($path);
	exit;	
*/

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
