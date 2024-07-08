<?php	
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_transaction.php                          */
/*     CREATED ON     :  17/JULY/2006                                   */

/*		Printable version of the Transaction Reports					*/
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

		$mode		= trim($_REQUEST['mode']);
		$Merchant 	= trim($_REQUEST['mid']);
		$Affiliate	= trim($_REQUEST['aid']);
		$From		= trim($_REQUEST['from']);
		$To			= trim($_REQUEST['to']);

		$sale		= trim($_REQUEST['sale']);
		$click		= trim($_REQUEST['click']);
		$lead		= trim($_REQUEST['lead']);
		$impr		= trim($_REQUEST['impr']);
		$programs	= trim($_REQUEST['programs']);
		$currValue	= $_REQUEST['currValue'];
		$currsymbol	= trim($_REQUEST['currsymbol']);

		if($currsymbol == '') $currsymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];

		if($currValue == '') $currValue = $default_currency_caption;

	if($click) { $sql_type = "  T.transaction_type = 'click' "; }
	if($sale)
	{
		if(empty($sql_type)) $sql_type = "  T.transaction_type = 'sale' ";
		else $sql_type .= " OR  T.transaction_type = 'sale' ";
	}
	if($lead)
	{
		if(empty($sql_type)) $sql_type = "  T.transaction_type = 'lead' ";
		else $sql_type .= " OR  T.transaction_type = 'lead' ";
	}
	if($impr)
	{
		if(empty($sql_type)) $sql_type = "  T.transaction_type = 'impression' ";
		else $sql_type .= " OR  T.transaction_type = 'impression' ";
	}



?>
<html>
<title><?=$title?></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
	<table class="tableNew" cellspacing="1" width="80%" align="center" >
		<tr><td colspan="6" align="center"><b><?=$trans_report_head?></b></td></tr>
		<tr><td colspan="6">&nbsp;</td></tr>
<?
if($mode == 'admin')
{
?>
		<tr>
			<td width="10%" align="left" ><b><?=$trans_type?></b></td>
			<td width="25%" align="left" ><b><?=$trans_merchant?></b></td>
			<td width="25%" align="left" ><b><?=$trans_affiliate?></b></td>
			<td width="10%" align="center" ><b><?=$trans_commission?></b></td>
			<td width="15%" align="center" ><b><?=$trans_date?></b></td>
			<td width="15%" align="center" ><b><?=$trans_status?></b></td>
		</tr>
		<tr><td colspan="6" ><hr /></td></tr>
		<tr><td colspan="6">&nbsp;</td></tr>

<?

    switch($Merchant)
    {
      case 'All':
            {
            switch ($Affiliate)
            {
               case 'All':
                   {
                   $sql_join="SELECT * from partners_joinpgm ";
                   break;
                   }
                  default:
                   {
                   $sql_join="SELECT * from partners_joinpgm where joinpgm_affiliateid='$Affiliate'";
                   break;
                   }
            }
            break;
            }

         default:
         {
           switch ($Affiliate)
            {
               case 'All':
                   {
                   $sql_join="SELECT * from partners_joinpgm,partners_program where program_merchantid='$Merchant' and  joinpgm_programid=program_id   ";
                   break;
                   }
                  default:
                   {
                    $sql_join="SELECT * from partners_joinpgm,partners_program where program_merchantid='$Merchant' and joinpgm_affiliateid='$Affiliate' and joinpgm_programid=program_id   ";
                   break;
                   }
            }
         }
    }
	$res_join = mysqli_query($con,$sql_join);
	if(mysqli_num_rows($res_join) > 0)
	{
		while($row_join = mysqli_fetch_object($res_join))
		{
			$joinId = $row_join->joinpgm_id;
			$sql = "SELECT * FROM partners_transaction T, partners_joinpgm J, partners_merchant M, partners_affiliate A WHERE ".
			" transaction_joinpgmid = '$joinId' AND T.transaction_joinpgmid = J.joinpgm_id  AND ".
			" J.joinpgm_merchantid=M.merchant_id AND J.joinpgm_affiliateid=A.affiliate_id ";

			if($from!='' && $to!='' && trim($From)!="0000-00-00" and trim($To)!="0000-00-00")
			{
				$sql .= " AND T.transaction_dateoftransaction between '$From' and '$To' ";
			}
			if($sql_type) $sql .= " AND ( ".$sql_type." ) ";

			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$type 			= $row->transaction_type;
					$OrderId		= $row->transaction_orderid;
					$affiliate		= $row->affiliate_company;
					$aff_id			= $row->affiliate_id;
					$admin_amt		= $row->transaction_admin_amount;
					$aff_amt		= $row->transaction_amttobepaid;
					$date			= $row->transaction_dateoftransaction;
					$status			= $row->transaction_status;
					$merchant		= $row->merchant_company;
					$Comm			= $aff_amt + $admin_amt;
					?>
					<tr>
						<td width="10%" align="left" ><?=$type?></td>
						<td width="25%" align="left" ><?=$merchant?></td>
						<td width="25%" align="left" ><?=$affiliate?></td>
						<td width="10%" align="center" ><?=$currsymbol?>&nbsp;<?=number_format($aff_amt,2)?></td>
						<td width="15%" align="center" ><?=$date?></td>
						<td width="15%" align="center" ><?=$status?></td>
					</tr>
				<?
				}
			}
		}
	}
} //End if mode is admin
else if($mode == 'merchant')
{
?>
		<tr>
			<td width="10%" align="left" ><b><?=$trans_type?></b></td>
			<td width="10%" align="left" ><b><?=$trans_orderId?></b></td>
			<td width="25%" align="left" ><b><?=$trans_affiliate?></b></td>
			<td width="30%" align="center" ><b><?=$trans_comm?></b></td>
			<td width="15%" align="left" ><b><?=$trans_date?></b></td>
			<td width="15%" align="center" ><b><?=$trans_status?></b></td>
		</tr>
		<tr><td colspan="6" ><hr /></td></tr>
		<tr><td colspan="6">&nbsp;</td></tr>


<?
			$sql = "SELECT * FROM partners_transaction T, partners_joinpgm J, partners_merchant M, partners_affiliate A WHERE ".
			" M.merchant_id='$Merchant' AND T.transaction_joinpgmid = J.joinpgm_id  AND ".
			" J.joinpgm_merchantid=M.merchant_id AND J.joinpgm_affiliateid=A.affiliate_id ";

			if($from!='' && $to!='' && trim($From)!="0000-00-00" and trim($To)!="0000-00-00")
			{
				$sql .= " AND T.transaction_dateoftransaction between '$From' and '$To' ";
			}
			if($sql_type) $sql .= " AND ( ".$sql_type." ) ";
			$sql    .=   ($programs != "All" and !empty($programs))?" AND J.joinpgm_programid = '$programs' ":" ";

			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$type 			= $row->transaction_type;
					$OrderId		= $row->transaction_orderid;
					$affiliate		= $row->affiliate_company;
					$aff_id			= $row->affiliate_id;
					$admin_amt		= $row->transaction_admin_amount;
					$aff_amt		= $row->transaction_amttobepaid;
					$date			= $row->transaction_dateoftransaction;
					$status			= $row->transaction_status;
					$merchant		= $row->merchant_company;
					$Comm			= $aff_amt + $admin_amt;

					 # converting to user currency
					 if($currValue != $default_currency_caption){
						   $aff_amt     =   getCurrencyValue($date, $currValue, $aff_amt);
						   $admin_amt     =   getCurrencyValue($date, $currValue, $admin_amt);
					  }

					?>
					<tr>
						<td width="10%" align="left" ><?=$type?></td>
						<td width="10%" align="left" ><?=$OrderId?></td>
						<td width="25%" align="left" ><?=$affiliate?></td>
						<td width="30%" align="center" ><?=$currsymbol?><?=number_format($aff_amt,2)." + ".$currsymbol.number_format($admin_amt,2)?></td>
						<td width="15%" align="left" ><?=$date?></td>
						<td width="15%" align="center" ><?=$status?></td>
					</tr>
				<?
				}
			}

}
else if($mode == 'affiliate')
{
?>
		<tr>
			<td width="10%" align="left" ><b><?=$trans_type?></b></td>
			<td width="10%" align="left" ><b><?=$trans_orderId?></b></td>
			<td width="25%" align="left" ><b><?=$lang_report_merchant?></b></td>
			<td width="30%" align="center" ><b><?=$trans_commission?></b></td>
			<td width="15%" align="left" ><b><?=$trans_date?></b></td>
			<td width="15%" align="center" ><b><?=$trans_status?></b></td>
		</tr>
		<tr><td colspan="6" ><hr /></td></tr>
		<tr><td colspan="6">&nbsp;</td></tr>


<?
			$sql = "SELECT * FROM partners_transaction T, partners_joinpgm J, partners_merchant M, partners_affiliate A WHERE ".
			" A.affiliate_id='$Affiliate' AND T.transaction_joinpgmid = J.joinpgm_id  AND ".
			" J.joinpgm_merchantid=M.merchant_id AND J.joinpgm_affiliateid=A.affiliate_id ";

			if($from!='' && $to!='' && trim($From)!="0000-00-00" and trim($To)!="0000-00-00")
			{
				$sql .= " AND T.transaction_dateoftransaction between '$From' and '$To' ";
			}
			if($sql_type) $sql .= " AND ( ".$sql_type." ) ";
			$sql    .=   ($programs != "All" and !empty($programs))?" AND J.joinpgm_id = '$programs' ":" ";

			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$type 			= $row->transaction_type;
					$OrderId		= $row->transaction_orderid;
					$affiliate		= $row->affiliate_company;
					$aff_id			= $row->affiliate_id;
					$admin_amt		= $row->transaction_admin_amount;
					$aff_amt		= $row->transaction_amttobepaid;
					$date			= $row->transaction_dateoftransaction;
					$status			= $row->transaction_status;
					$merchant		= $row->merchant_company;
					$Comm			= $aff_amt + $admin_amt;

					 # converting to user currency
					 if($currValue != $default_currency_caption){
						   $aff_amt     =   getCurrencyValue($date, $currValue, $aff_amt);
					  }

					?>
					<tr>
						<td width="10%" align="left" ><?=$type?></td>
						<td width="10%" align="left" ><?=$OrderId?></td>
						<td width="25%" align="left" ><?=$merchant?></td>
						<td width="30%" align="center" ><?=$currsymbol?><?=number_format($aff_amt,2)?></td>
						<td width="15%" align="left" ><?=$date?></td>
						<td width="15%" align="center" ><?=$status?></td>
					</tr>
				<?
				}
			}

}

?>
	<tr><td colspan="6"><hr /></td></tr>
	<tr><td colspan="6" align="right">
		<img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a>
	</td></tr>
	</table>
</body>
</html>