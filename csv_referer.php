<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_referer.php     		           	        */
/*     CREATED ON     :  21/JULY/2006                                   */

/*		Exporting Referer Report to CSV Format	   						*/
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

	$merchant	= $_REQUEST['mid'];
	$From		= $_REQUEST['from'];
	$To			= $_REQUEST['to'];
	$programs	= $_REQUEST['program'];
	
	$sale		= trim($_REQUEST['sale']);
	$click		= trim($_REQUEST['click']);
	$lead		= trim($_REQUEST['lead']);
	$impr		= trim($_REQUEST['impr']);

	
	if($merchant == 'All' || empty($merchant)) $merchantName = $lang_report_allmerchant;
	else {
		$merchantName	= $reportobj->FindMerchantName($merchant);
	}

	if($programs == 'All' || $programs == 'AllPgms') $programName = $lang_report_AllProgram;
	else {
		$programName = $reportobj->FindProgramName($programs);
	}


	if($click) { $sql_type = "  transaction_type = 'click' "; }
	if($sale) 
	{ 
		if(empty($sql_type)) $sql_type = "  transaction_type = 'sale' ";
		else $sql_type .= " OR  transaction_type = 'sale' ";
	}
	if($lead)
	{
		if(empty($sql_type)) $sql_type = "  transaction_type = 'lead' ";
		else $sql_type .= " OR  transaction_type = 'lead' ";
	}
	if($impr)
	{
		if(empty($sql_type)) $sql_type = "  transaction_type = 'impression' ";
		else $sql_type .= " OR  transaction_type = 'impression' ";
	}


   switch($programs)
   {
      case 'AllPgms':
			$sql  = " SELECT DISTINCT T.transaction_ip,T.transaction_country,T.transaction_type, T.transaction_status, T.transaction_referer, ";
			$sql .= " A.affiliate_company, A.affiliate_lastname, A.affiliate_id, ";
			$sql .= " date_format(transaction_dateoftransaction,'%b %d, %Y') As transDate ";
			$sql .= " from partners_program As P, partners_transaction As T, partners_joinpgm As J, partners_affiliate As A ";
			$sql .= " WHERE ( T.transaction_dateoftransaction BETWEEN '$From' AND '$To' )";
			$sql .= " AND T.transaction_joinpgmid = J.joinpgm_id ";
			$sql .= " AND J.joinpgm_programid = P.program_id ";
			$sql .= " AND J.joinpgm_affiliateid = A.affiliate_id ";
	
			if($sql_type) $sql .= " AND ( ".$sql_type." ) ";
			
			break;

     case 'All':
			$sql  = " SELECT DISTINCT T.transaction_ip,T.transaction_country,T.transaction_type, T.transaction_status, T.transaction_referer, ";
			$sql .= " A.affiliate_company, A.affiliate_lastname, A.affiliate_id, ";
			$sql .= " date_format(transaction_dateoftransaction,'%b %d, %Y') As transDate ";
			$sql .= " from partners_program As P, partners_transaction As T, partners_joinpgm As J, partners_affiliate As A  ";
			$sql .= " WHERE P.program_merchantid=$merchant ";
			$sql .= " AND ( transaction_dateoftransaction BETWEEN '$From' AND '$To' )";
	
			if($sql_type) $sql .= " AND ( ".$sql_type." ) ";
			break;

     default:
			$sql  = " SELECT Distinct T.transaction_ip,T.transaction_country,T.transaction_type, T.transaction_status, T.transaction_referer, ";
			$sql .= " A.affiliate_company, A.affiliate_lastname, A.affiliate_id, ";
			$sql .= " date_format(transaction_dateoftransaction,'%b %d, %Y') As transDate ";
			$sql .= " from partners_program As P, partners_transaction As T, partners_joinpgm As J, partners_affiliate As A  ";
			$sql .= " WHERE P.program_id=$programs ";
			$sql .= " AND ( transaction_dateoftransaction BETWEEN '$From' AND '$To' )";
			$sql .= " AND T.transaction_joinpgmid = J.joinpgm_id ";
			$sql .= " AND J.joinpgm_programid = P.program_id ";
			$sql .= " AND J.joinpgm_affiliateid = A.affiliate_id ";
			
			if($sql_type) $sql .= " AND ( ".$sql_type." ) ";
			break;
   }


   $result    = mysqli_query($con,$sql);

	$csv_trans = $lang_report_stat." ".$From." - ".$To."\r\n";
	$csv_trans .=  $lang_report_merchant." : ".$merchantName."\r\n";
	$csv_trans .=  $lang_pgm." : ".$programName."\r\n";
	
	$csv_trans .=  "Type,Affiliate,HTTP_REFERER,IP,Date,Status\r\n";
	
	
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_object($result))
			{
				$transType      = $row->transaction_type;
				$transStatus    = $row->transaction_status;
				$transReferer   = $row->transaction_referer;
				$transIp   		= $row->transaction_ip;
				$transAff       = ucwords(strtolower(stripslashes($row->affiliate_company)));
				$date			= $row->transaction_dateoftransaction;
				$transAffid     = $row->affiliate_id;
			
				$csv_trans .=  $transType.",".$transAff.",".$transReferer.",".$transIp.",".$date.",".$transStatus."\r\n";
			}
		}

//Creating file	
	$fileName =$_SESSION['ADMINUSERID']."_admin_referer.csv";
	
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

