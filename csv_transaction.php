<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_transaction.php     		                */
/*     CREATED ON     :  18/JULY/2006                                   */

/*		Exporting Transaction Report to CSV Format						*/
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

		if($currsymbol == '') $currsymbol = html_entity_decode($_SESSION['DEFAULTCURRENCYSYMBOL']);

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

//To display heading
$csv_trans = $trans_report_head."\r\n";

if($mode == 'admin')
{
	$csv_trans .= $trans_type.",".$trans_merchant.",".$trans_affiliate.",".$trans_commission.",".$trans_date.",".$trans_status."\r\n";

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

					$csv_trans .= $type.",".$merchant.",".$affiliate.",".$currsymbol.number_format($aff_amt,2).",".$date.",".$status."\r\n";
				}
			}
		}
	}
} //End if mode is admin
else if($mode == 'merchant')
{
		$csv_trans .= $trans_type.",".$trans_orderId.",".$trans_affiliate.",".$trans_comm.",".$trans_date.",".$trans_status."\r\n";

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

					$csv_trans .= $type.",".$OrderId.",".$affiliate.",".$currsymbol.number_format($aff_amt,2)." + ".$currsymbol.number_format($admin_amt,2).",".$date.",".$status."\r\n";
				}
			}

}
else if($mode == 'affiliate')
{
		$csv_trans .= $trans_type.",".$trans_orderId.",".$lang_report_merchant.",".$trans_commission.",".$trans_date.",".$trans_status."\r\n";

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


					$csv_trans .= $type.",".$OrderId.",".$merchant.",".$currsymbol.number_format($aff_amt,2).",".$date.",".$status."\r\n";
				}
			}
}

//Creating file
	if($mode == 'admin')
		$fileName =$_SESSION['ADMINUSERID']."_admin_transaction.csv";
	else if($mode == 'merchant')
		$fileName = $_SESSION['MERCHANTID']."_merchant_transaction.csv";
	else if($mode == 'affiliate')
		$fileName = $_SESSION['AFFILIATEID']."_affiliate_transaction.csv";


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
