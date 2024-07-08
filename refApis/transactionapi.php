<?php
header("Access-Control-Allow-Origin: *");
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';

$affiliate_id =$_REQUEST['MADKAI'];

$id = MultipleTimeDecode($affiliate_id);

$start_date = $_REQUEST['start_date'];

$end_date = $_REQUEST['end_date'];

# Query For Get Single Affiliate Details
//start_date=2021-05-27&end_date=2022-12-21
/*

*/
if($id!="")
{
  $SqlQuery = "SELECT partners_affiliate.affiliate_company,partners_merchant.merchant_company,partners_merchant.merchant_currency,
  partners_merchant.merchant_state,partners_merchant.merchant_orderId,partners_merchant.merchant_saleAmt,
  partners_program.program_id,partners_transaction.transaction_id,partners_transaction.transaction_joinpgmid,
  partners_transaction.transaction_type,partners_transaction.transaction_status,partners_transaction.transaction_dateoftransaction,
  partners_transaction.transaction_referer,
  partners_transaction.transaction_orderid,partners_transaction.transaction_ip,partners_transaction.transaction_country,
  partners_transaction.transaction_subid,partners_transaction.transaction_transactiontime,
  partners_joinpgm.joinpgm_id,partners_joinpgm.joinpgm_merchantid
  FROM partners_transaction 
  join partners_joinpgm on partners_transaction.transaction_joinpgmid = partners_joinpgm.joinpgm_id 
  join partners_program on partners_program.program_id = partners_joinpgm.joinpgm_programid 
  join partners_merchant on partners_merchant.merchant_id = partners_joinpgm.joinpgm_merchantid 
  join partners_affiliate on partners_affiliate.affiliate_id = partners_joinpgm.joinpgm_affiliateid 
  WHERE (partners_transaction.transaction_dateoftransaction BETWEEN '$start_date' AND '$end_date') 
  AND partners_joinpgm.joinpgm_affiliateid='$id'";

 $details = mysqli_query($con,$SqlQuery);

   foreach($details as $data)
   {
    $TransactionDetails[]=$data;
   }
    echo json_encode($TransactionDetails);
  }
