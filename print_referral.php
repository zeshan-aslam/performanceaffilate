<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_referral.php                             */
/*     CREATED ON     :  19/AUG/2009                                    */

/*		Printable version of the Affiliate referral Report				*/
/************************************************************************/
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
	$res_referal = mysql_query($sql_referal);  



?>
<html>
<title><?=$title?></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<?

?>
	<table border="0" cellpadding="0" cellspacing="3"  class="tableNew"  width="50%" align="center">
		<tr><td colspan="3" align="center"><b><?=$lang_referral_report." ".$lang_report_forperiod?>&nbsp;<?=$heading?></b></td></tr>
	
		<?php if($mode != 'admin') { ?>
        <tr><td colspan="3" align="center"><b><?=$lang_report_affiliate?>&nbsp;:&nbsp;<?=$affiliateName?></b></td></tr>
		<?php } ?>
        
		<tr><td colspan="3"><hr /></td></tr>
        <tr >
            <td width="40%" ><b><?=$lang_referral_downlines?></b></td>
            <td width="30%" ><b><?=$lang_referral_salesMade?></b></td>
            <td width="30%" ><b><?=$trans_commission?></b></td>
        </tr>
        <?php
		$total = 0;
		while($row_referal = mysql_fetch_object($res_referal)){
			$total += $row_referal->Sum;
		?>
        <tr >
            <td height="25" ><?=$row_referal->affiliate_company?></td>
            <td height="25" ><?=$row_referal->Cnt?></td>
            <td height="25" >$<?=$row_referal->Sum?></td>
        </tr>
		<?php
		}
		?>
		<tr><td colspan="3"><hr /></td></tr>
        <tr>
        	<td colspan="2" align="left" ><b><?=$lang_total_commission?></b></td>
            <td  align="left" ><b>$<?=$total?></b></td>
        </tr>

		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3"><hr /></td></tr>
		<tr><td align="right" colspan="3">
			<img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a>
		</td></tr>
		
	</table>

</body>
</html>
