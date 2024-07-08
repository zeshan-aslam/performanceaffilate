<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_product.php     		                    */
/*     CREATED ON     :  21/JULY/2006                                   */

/*		Printable version of the Product Report of Mer, Aff & Admin		*/
/************************************************************************/
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
	$affiliate	= intval($_REQUEST['aid']);
	$From		= $_REQUEST['from'];
	$To			= $_REQUEST['to'];
	$program	= $_REQUEST['program'];
	$currValue	= $_REQUEST['currValue'];
	$currsymbol	= $_REQUEST['currsymbol'];
	
	$sale		= trim($_REQUEST['sale']);
	$click		= trim($_REQUEST['click']);
	$lead		= trim($_REQUEST['lead']);
	$impr		= trim($_REQUEST['impr']);

	
	if($currsymbol == '') $currsymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];
	
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


?>
<html>
<title><?=$title?></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>

	<table border="0" cellpadding="0" cellspacing="3"  class="tableNew"  width="80%" align="center">
		<tr><td colspan="6" align="center"><b><?=$lang_report_stat?>&nbsp;<?=$From." - ".$To?></b></td></tr>
		<? if($mode == 'admin' || $mode == 'merchant') { ?>
		<tr><td colspan="6" align="center"><b><?=$lang_report_merchant?>&nbsp;:&nbsp;<?=$merchantName?></b></td></tr>
		<? }  
		if($mode == 'affiliate') { ?>
			<tr><td colspan="6" align="center"><b><?=$lang_report_affiliate?>&nbsp;:&nbsp;<?=$affiliateName?></b></td></tr>
		<? } ?>
		<tr><td colspan="6" align="center"><b><?=$lang_pgm?>&nbsp;:&nbsp;<?=$programName?></b></td></tr>

		<tr><td colspan="6"><hr /></td></tr>
	<?
	if($mode == 'merchant') { 
	?>
		<tr>
			<td width="10%" align="left" ><b><?=$lang_product_Type?></b></td>
			<td width="30%" align="left" ><b><?=$lang_product_Product?></b></td>
			<td width="20%" align="center" ><b><?=$lang_product_Affiliate?></b></td>
			<td width="20%" align="center" ><b><?=$trans_comm?></b></td>
			<td width="10%" align="center" ><b><?=$lang_product_Date?></b></td>
			<td width="10%" align="center" ><b><?=$lang_product_Status?></b></td>
		</tr>
		<tr><td colspan="6"><hr /></td></tr>
<?
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
		
       $res_product = mysql_query($transSql);
	   
	   if(mysql_num_rows($res_product) > 0)
	   {
		   	while($row_product = mysql_fetch_object($res_product))
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
			?>
				<tr>
					<td width="10%" align="left" ><?=$type?></td>
					<td width="30%" align="left" ><?=$product?></td>
					<td width="20%" align="center" ><?=$affiliate?></td>
					<td width="20%" align="center" ><?=$currsymbol.$affAmnt." + ".$currsymbol.$adminAmnt?></td>
					<td width="10%" align="center" ><?=$transDate?></td>
					<td width="10%" align="center" ><?=$tstatus?></td>
				</tr>
			<?
			}
	   }
	} //end mode == merchant
	else if($mode == 'affiliate')
	{	?>
		<tr>
			<td width="10%" align="left" ><b><?=$lang_product_Type?></b></td>
			<td width="30%" align="left" ><b><?=$lang_product_Product?></b></td>
			<td width="20%" align="center" ><b><?=$lang_product_Merchant?></b></td>
			<td width="20%" align="center" ><b><?=$lang_product_Commission?></b></td>
			<td width="10%" align="center" ><b><?=$lang_product_Date?></b></td>
			<td width="10%" align="center" ><b><?=$lang_product_Status?></b></td>
		</tr>
		<tr><td colspan="6"><hr /></td></tr>
		
	<?
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
		
       $res_product = mysql_query($transSql);  
	   
	   if(mysql_num_rows($res_product) > 0)
	   {
		   	while($row_product = mysql_fetch_object($res_product))
			{
				 $type       = trim(stripslashes($row_product->transaction_type));
				 $tstatus    = trim(stripslashes($row_product->transaction_status));
				 $commission = trim(stripslashes($row_product->transaction_amttobepaid ));
				
				 $date		 = trim(stripslashes($row_product->transaction_dateoftransaction));
				 $product	 = trim(stripslashes($row_product->prd_product));
				 $merchant  = trim(stripslashes($row_product->merchant_company));
			?>
				<tr>
					<td width="10%" align="left" ><?=$type?></td>
					<td width="30%" align="left" ><?=$product?></td>
					<td width="20%" align="center" ><?=$merchant?></td>
					<td width="20%" align="center" ><?=$currsymbol.$commission?></td>
					<td width="10%" align="center" ><?=$date?></td>
					<td width="10%" align="center" ><?=$tstatus?></td>
				</tr>
			<?
			}
		}
	}
	else if($mode == 'admin')
	{	?>
		<tr>
			<td width="10%" align="left" ><B>Type</B></td>
			<td width="30%" align="left" ><B>Product</B></td>
			<td width="20%" align="center" ><B>Affiliate</B></td>
			<td width="20%" align="center" ><B>Commission</B></td>
			<td width="10%" align="center" ><B>Date</B></td>
			<td width="10%" align="center" ><B>Status</B></td>
		</tr>
		<tr><td colspan="6"><hr /></td></tr>
		
	<?
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
		
		$res_product = mysql_query($transSql);  
		
		if(mysql_num_rows($res_product) > 0)
		{
			while($row_product = mysql_fetch_object($res_product))
			{	
				 $type       = trim(stripslashes($row_product->transaction_type));
				 $tstatus    = trim(stripslashes($row_product->transaction_status));
				 $commission = trim(stripslashes($row_product->transaction_admin_amount));
				 $date		 = trim(stripslashes($row_product->transaction_dateoftransaction));
				 $product	 = trim(stripslashes($row_product->prd_product));
				 $affiliate  = trim(stripslashes($row_product->affiliate_firstname))." ".trim(stripslashes($transRow->affiliate_lastname));
			
			?>
				<tr>
					<td width="10%" align="left" ><?=$type?></td>
					<td width="30%" align="left" ><?=$product?></td>
					<td width="20%" align="center" ><?=$affiliate?></td>
					<td width="20%" align="center" ><?=$currsymbol?><?=$commission?></td>
					<td width="10%" align="center" ><?=$date?></td>
					<td width="10%" align="center" ><?=$tstatus?></td>
				</tr>
			<?
			}
		}
	
	}
?>
		<tr><td colspan="6">&nbsp;</td></tr>
		<tr><td colspan="6"><hr /></td></tr>
		<tr><td align="right" colspan="6">
			<img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a>
		</td></tr>
	</table>
