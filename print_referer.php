<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_referer.php     		                    */
/*     CREATED ON     :  21/JULY/2006                                   */

/*		Printable version of the Referer Report of Administrator		*/
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
			$sql .= " WHERE P.program_merchantid='$merchant' ";
			$sql .= " AND ( transaction_dateoftransaction BETWEEN '$From' AND '$To' )";
	
			if($sql_type) $sql .= " AND ( ".$sql_type." ) ";
			break;

     default:
			$sql  = " SELECT Distinct T.transaction_ip,T.transaction_country,T.transaction_type, T.transaction_status, T.transaction_referer, ";
			$sql .= " A.affiliate_company, A.affiliate_lastname, A.affiliate_id, ";
			$sql .= " date_format(transaction_dateoftransaction,'%b %d, %Y') As transDate ";
			$sql .= " from partners_program As P, partners_transaction As T, partners_joinpgm As J, partners_affiliate As A  ";
			$sql .= " WHERE P.program_id='$programs' ";
			$sql .= " AND ( transaction_dateoftransaction BETWEEN '$From' AND '$To' )";
			$sql .= " AND T.transaction_joinpgmid = J.joinpgm_id ";
			$sql .= " AND J.joinpgm_programid = P.program_id ";
			$sql .= " AND J.joinpgm_affiliateid = A.affiliate_id ";
			
			if($sql_type) $sql .= " AND ( ".$sql_type." ) ";
			break;
   }


   $result    = mysql_query($sql);

?>
<html>
<title><?=$title?></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>

	<table border="0" cellpadding="0" cellspacing="3"  class="tableNew"  width="80%" align="center">
		<tr><td colspan="6" align="center"><b><?=$lang_report_stat?>&nbsp;<?=$From." - ".$To?></b></td></tr>
		<tr><td colspan="6" align="center"><b><?=$lang_report_merchant?>&nbsp;:&nbsp;<?=$merchantName?></b></td></tr>
		<tr><td colspan="6" align="center"><b><?=$lang_pgm?>&nbsp;:&nbsp;<?=$programName?></b></td></tr>

		<tr><td colspan="6"><hr /></td></tr>

		<tr>
			<td width="10%" align="center" ><b>Type</b></td>
			<td width="20%" align="center" ><b>Affiliate</b></td>
			<td width="35%" align="center" ><b>HTTP_REFERER</b></td>
			<td width="15%" align="center" ><b>IP</b></td>
			<td width="20%" align="center" ><b>Date</b></td>
			<td width="15%" align="center" ><b>Status</b></td>
		</tr>
		<tr><td colspan="6"><hr /></td></tr>
		<?
		if(mysql_num_rows($result) > 0)
		{
			while($row = mysql_fetch_object($result))
			{
				$transType      = $row->transaction_type;
				$transStatus    = $row->transaction_status;
				$transReferer   = $row->transaction_referer;
				$transIp   		= $row->transaction_ip;
				$transAff       = ucwords(strtolower(stripslashes($row->affiliate_company)));
				$date			= $row->transaction_dateoftransaction;
				$transAffid     = $row->affiliate_id;
			?>
				<tr>
					<td width="10%" align="center" ><?=$transType?></td>
					<td width="20%" align="center" ><?=$transAff?></td>
					<td width="35%" align="center" ><?=$transReferer?></td>
					<td width="15%" align="center" ><?=$transIp?></td>
					<td width="20%" align="center" ><?=$date?></td>
					<td width="15%" align="center" ><?=$transStatus?></td>
				</tr>
			
			<?
			}
		}
		?>

		<tr><td colspan="6">&nbsp;</td></tr>
		<tr><td colspan="6"><hr /></td></tr>
		<tr><td align="right" colspan="6">
			<img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a>
		</td></tr>
	</table>
