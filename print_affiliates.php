<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_affiliates.php                           */
/*     CREATED ON     :  19/JULY/2006                                   */

/*		Printable version of the Affiliate Report of Merchant			*/
/************************************************************************/
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

	$merchant	= intval($_REQUEST['mid']);
	$search		= trim(addslashes($_REQUEST['search']));
	$From		= $_REQUEST['from'];
	$To			= $_REQUEST['to'];
	$currency	= $_REQUEST['currency'];
	$currValue	= $_REQUEST['currValue'];

	$merchantName	= $reportobj->FindMerchantName($merchant);	
?>
<html>
<title><?=$title?></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>

	<table border="0" cellpadding="0" cellspacing="3"  class="tableNew"  width="80%" align="center">
		<tr><td colspan="7" align="center"><b><?=$lang_report_affiliate_head?>&nbsp;<?=$From?>&nbsp;-&nbsp;<?=$To?></b></td></tr>
		<tr><td align="center" colspan="7"><b><?=$lang_report_merchant?>&nbsp;:&nbsp;<?=$merchantName?></b></td></tr>

		<tr><td colspan="7" align="center"><hr /></td></tr>
		<tr>
		<td width="20%" align="left"><b><?=$lang_report_affiliate?></b></td>
		<td width="10%" align="left"><b><?=$lang_pgm?></b></td>
		<td width="15%" align="center"><b><?=$lang_impression?></b></td>
		<td width="10%" align="center"><b><?=$lang_click?></b></td>
		<td width="15%" align="center"><b><?=$lang_lead?></b></td>
		<td width="15%" align="center"><b><?=$lang_sale?></b></td>
		<td width="15%" align="center"><b><?=$lang_report_commission?></b></td>
		</tr>
		
		<tr><td colspan="7" align="center"><hr /></td></tr>
		<tr><td colspan="7" align="center">&nbsp;</td></tr>
		
<?
	$sql = "SELECT * from partners_joinpgm j,partners_program p,partners_affiliate where program_merchantid='$merchant' and ".
	" joinpgm_status not like ('waiting') and affiliate_company like('%$search%') and j.joinpgm_programid=p.program_id and ".
	" affiliate_id=joinpgm_affiliateid ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res ) > 0)
	{
		while($row = mysql_fetch_object($res))
		{
			
			$total 	= GetPaymentDetails1($row->joinpgm_id,$To,$From,$currValue,$default_currency_caption);   //getting pending,approved,paid amnts from GetPayments.php
			$total	= explode('~',$total);

			$imp_count = get_impression_count($row->joinpgm_programid,$row->joinpgm_merchantid,$row->joinpgm_affiliateid,$From,$To);
	 ?>
			<tr>
				<td width="20%" align="left"><?=stripslashes(trim($row->affiliate_company))?></td>
				<td width="10%" align="left"><?=stripslashes($row->program_url)?></td>
				<td width="15%" align="center"><?=$imp_count?></td>
				<td width="10%" align="center"><?=$total[0]?></td>
				<td width="15%" align="center"><?=$total[1]?></td>
				<td width="15%" align="center"><?=$total[2]?></td>
				<td width="15%" align="center"><?=$currency?>&nbsp;<?=$total[3]?></td>
			</tr>
			<?
		}
	}

?>		
		<tr><td colspan="7">&nbsp;</td></tr>
		<tr><td colspan="7"><hr /></td></tr>
		<tr><td align="right" colspan="7">
			<img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a>
		</td></tr>

	</table>	
	