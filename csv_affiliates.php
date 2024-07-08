<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_forperiod.php     		            	    */
/*     CREATED ON     :  19/JULY/2006                                   */

/*		Exporting Affiliate Report of Merchant to CSV Format			*/
/************************************************************************/
include_once 'includes/db-connect.php';
  include 'includes/session.php';
  include 'includes/constants.php';
  include 'includes/functions.php';
  include 'includes/allstripslashes.php';
  include 'includes/function1.php';
  include_once 'merchants/affiliate_payments.php';
  

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	include_once 'language_include.php';
	
	$reportobj	= new report();

	$merchant	= $_REQUEST['mid'];
	$search		= trim(addslashes($_REQUEST['search']));
	$From		= $_REQUEST['from'];
	$To			= $_REQUEST['to'];
	$currency	= $_REQUEST['currency'];
	$currValue	= $_REQUEST['currValue'];

	$merchantName	= $reportobj->FindMerchantName($merchant);	

	$csv_trans = $lang_report_affiliate_head." ".$From." - ".$To."\r\n";
	$csv_trans .= $lang_report_merchant." : ".$merchantName."\r\n";
	$csv_trans .= $lang_report_affiliate.",".$lang_pgm.",".$lang_impression.",".$lang_click.",".$lang_lead.",".$lang_sale.",".$lang_report_commission."\r\n";
	
	$sql = "SELECT * from partners_joinpgm j,partners_program p,partners_affiliate where program_merchantid='$merchant' and ".
	" joinpgm_status not like ('waiting') and affiliate_company like('%$search%') and j.joinpgm_programid=p.program_id and ".
	" affiliate_id=joinpgm_affiliateid ";
	$res = mysqli_query($con,$sql);
	if(mysqli_num_rows($res ) > 0)
	{
		while($row = mysqli_fetch_object($res))
		{
			
			$total 	= GetPaymentDetails1($row->joinpgm_id,$To,$From,$currValue,$default_currency_caption);   //getting pending,approved,paid amnts from GetPayments.php
			$total	= explode('~',$total);

			$imp_count = get_impression_count($row->joinpgm_programid,$row->joinpgm_merchantid,$row->joinpgm_affiliateid,$From,$To);
			
			$csv_trans .= stripslashes(trim($row->affiliate_company)).",".stripslashes($row->program_url).",".$imp_count.",".$total[0].",".$total[1].",".$total[2].",".$currency.$total[3]."\r\n";
		}
	}


//Creating file	
	$fileName = $_SESSION['MERCHANTID']."_merchant_affiliates.csv";
	
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
	