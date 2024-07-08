<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_product.php     		            	        */
/*     CREATED ON     :  21/JULY/2006                                   */

/*		Exporting Products Report to CSV Format	   						*/
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

	$mode		= $_REQUEST['mode'];
	$date		= $_REQUEST['date'];
	$merchant	= $_REQUEST['mid'];
	$affiliate	= $_REQUEST['aid'];
	$From		= $_REQUEST['from'];
	$To			= $_REQUEST['to'];
	$program	= $_REQUEST['program'];
	$currValue	= $_REQUEST['currValue'];
	$currsymbol	= $_REQUEST['currsymbol'];
	
	$sale		= trim($_REQUEST['sale']);
	$click		= trim($_REQUEST['click']);
	$lead		= trim($_REQUEST['lead']);
	$impr		= trim($_REQUEST['impr']);

	
	if($currsymbol == '') $currsymbol = html_entity_decode($_SESSION['DEFAULTCURRENCYSYMBOL']);
	
	if($currValue == '') $currValue = $default_currency_caption;

	if($merchant == 'All' || empty($merchant)) $merchantName = $lang_report_allmerchant;
	else {
		$merchantName	= $reportobj->FindMerchantName($merchant);
	}

	if($program == 'All' || $program == 'AllPgms') $programName = $lang_report_AllProgram;
	else {
		$programName = $reportobj->FindProgramName($program);
	}

	$affiliateName = $reportobj->FindAffiliateName($affiliate);

	
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


	$csv_trans = $lang_report_stat." ".$From." - ".$To."\r\n";
	if($mode == 'admin' || $mode == 'merchant') {  
		$csv_trans .= $lang_report_merchant." : ".$merchantName."\r\n";
	}
	if($mode == 'affiliate') { 
		$csv_trans .= $lang_report_affiliate." : ".$affiliateName."\r\n";
	}
	$csv_trans .= $lang_pgm." : ".$programName."\r\n";
	
	if($mode == 'merchant') 
	{ 
		$csv_trans .= $lang_product_Type.",".$lang_product_Product.",".$lang_product_Affiliate.",".$trans_comm.",".$lang_product_Date.",".$lang_product_Status."\r\n";

       $transSql = "SELECT * FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
       $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";

       if($program != "All"){
       	    $transSql.= " AND joinpgm_programid = '$program' ";
       }else  $transSql.= " AND joinpgm_merchantid = '$merchant'";
       
	   if(!empty($From) && !empty($To)){
          $transSql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
       }
       $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
       $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
      
	   $transSql.= " AND affiliate_id = joinpgm_affiliateid ";
      
	   if($sql_type) $transSql .= " AND ( ".$sql_type." ) ";
		
       $res_product = mysqli_query($con,$transSql);
	   
	   if(mysqli_num_rows($res_product) > 0)
	   {
		   	while($row_product = mysqli_fetch_object($res_product))
			{
				 $type       = trim(stripslashes($row_product->transaction_type));
				 $tstatus    = trim(stripslashes($row_product->transaction_status));
				 $transDate  = trim(stripslashes($row_product->transaction_dateoftransaction));
				 $affAmnt    =   $row_product->transaction_amttobepaid;
				 $adminAmnt  =   $row_product->transaction_admin_amount;
			
				 if($currValue != $default_currency_caption){
						  $affAmnt     =   getCurrencyValue($transDate, $currValue, $affAmnt);
						  $adminAmnt   =   getCurrencyValue($transDate, $currValue, $adminAmnt);
				 }
				 $commission = trim(stripslashes($affAmnt)) + trim(stripslashes($adminAmnt));
			
				 $product	 = trim(stripslashes($row_product->prd_product));
				 $affiliate  = trim(stripslashes($row_product->affiliate_company));
			
				$csv_trans .= $type.",".$product.",".$affiliate.",".$currsymbol.$affAmnt." + ".$currsymbol.$adminAmnt.",".$transDate.",".$tstatus."\r\n";

			}
	   }
	} //end mode == merchant
	else if($mode == 'affiliate')
	{	
		$csv_trans .= $lang_product_Type.",".$lang_product_Product.",".$lang_product_Merchant.",".$lang_product_Commission.",".$lang_product_Date.",".$lang_product_Status."\r\n";
	
       $transSql = "SELECT * FROM partners_transaction, partners_joinpgm, partners_product, partners_merchant ";
       $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";

       if($program != "All"){
       	    $transSql.= " AND joinpgm_programid = '$program' ";
       }
       else
       	    $transSql.= " AND joinpgm_affiliateid = '$affiliate' ";

	   if(!empty($From) && !empty($To)){
          $transSql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
       }
       $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
       $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
       $transSql.= " AND merchant_id = joinpgm_merchantid ";
       
	   if($sql_type) $transSql .= " AND ( ".$sql_type." ) ";
		
       $res_product = mysqli_query($con,$transSql);  
	   
	   if(mysqli_num_rows($res_product) > 0)
	   {
		   	while($row_product = mysqli_fetch_object($res_product))
			{
				 $type       = trim(stripslashes($row_product->transaction_type));
				 $tstatus    = trim(stripslashes($row_product->transaction_status));
				 $commission = trim(stripslashes($row_product->transaction_amttobepaid ));
				
				 $date		 = trim(stripslashes($row_product->transaction_dateoftransaction));
				 $product	 = trim(stripslashes($row_product->prd_product));
				 $merchant  = trim(stripslashes($row_product->merchant_company));
			
				$csv_trans .= $type.",".$product.",".$merchant.",".$currsymbol.$commission.",".$date.",".$tstatus."\r\n";
				
			}
		}
	}
	else if($mode == 'admin')
	{	
		$csv_trans .= "Type".","."Product".","."Affiliate".","."Commission".","."Date".","."Status"."\r\n";

       switch($program)
       {
         	case 'AllPgms':
			   $transSql = "SELECT * FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
			   $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
	
			   $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
			   $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
			   $transSql.= " AND affiliate_id = joinpgm_affiliateid ";
            break;

      		case 'All':
			   $transSql = "SELECT * FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
			   $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
			   $transSql.= " AND joinpgm_merchantid = '$merchant' ";
		
			   $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
			   $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
			   $transSql.= " AND affiliate_id = joinpgm_affiliateid ";
			   break;

     		default:
			   $transSql = "SELECT * FROM partners_transaction, partners_joinpgm, partners_product, partners_affiliate ";
			   $transSql.= " WHERE SUBSTRING(transaction_linkid,1,1) = 'R'";
			   $transSql.= " AND joinpgm_programid = '$program' ";
		
			   $transSql.= " AND joinpgm_id = transaction_joinpgmid ";
			   $transSql.= " AND prd_id = SUBSTRING(transaction_linkid,2) ";
			   $transSql.= " AND affiliate_id = joinpgm_affiliateid ";
				break;
   		}
		
		if(!empty($From) && !empty($To)){
		  $transSql.= " AND transaction_dateoftransaction BETWEEN '$From' AND '$To' ";
		}
		
		if($sql_type) $transSql .= " AND ( ".$sql_type." ) ";
		
		$res_product = mysqli_query($con,$transSql);  
		
		if(mysqli_num_rows($res_product) > 0)
		{
			while($row_product = mysqli_fetch_object($res_product))
			{	
				 $type       = trim(stripslashes($row_product->transaction_type));
				 $tstatus    = trim(stripslashes($row_product->transaction_status));
				 $commission = trim(stripslashes($row_product->transaction_admin_amount));
				 $date		 = trim(stripslashes($row_product->transaction_dateoftransaction));
				 $product	 = trim(stripslashes($row_product->prd_product));
				 $affiliate  = trim(stripslashes($row_product->affiliate_firstname))." ".trim(stripslashes($transRow->affiliate_lastname));
		
				$csv_trans .= $type.",".$product.",".$affiliate.",".$currsymbol.$commission.",".$date.",".$tstatus."\r\n";
			
			}
		}
	
	}

//Creating file	
	if($mode == 'admin')
		$fileName =$_SESSION['ADMINUSERID']."_admin_product.csv";
	else if($mode == 'merchant')
		$fileName = $_SESSION['MERCHANTID']."_merchant_product.csv";
	else if($mode == 'affiliate')
		$fileName = $_SESSION['AFFILIATEID']."_affiliate_product.csv";
	
	
	$fp = fopen( ROOT."reports/".$fileName,"w");
	fwrite($fp,$csv_trans);
	fclose($fp);

//Download file
	$newFile	= 	$fileName;
	$path		=	ROOT."reports/".$newFile;

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
