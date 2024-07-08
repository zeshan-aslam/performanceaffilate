<?php
header("Access-Control-Allow-Origin: *");
require_once('../custom-emd/init.php');
include_once '../includes/encode_decodeFunction.php';

$defPublicToken = $db->baseSelect("esApiSettings", "apiCode = 'COUP' " )['authToken']; 
//   echo $defPublicToken;
$today = date('Y-m-d');
// echo $today;
if ($defPublicToken === $_REQUEST['_token'] ) {
   $coupDetSql = "SELECT * FROM partners_merchant AS PM 
                  JOIN partners_joinpgm AS PJP  ON PM.merchant_id = PJP.joinpgm_merchantid
                  JOIN affilate_coupon  AS AC ON AC.merchant_id   = PJP.joinpgm_merchantid
                  JOIN partners_program  AS PP ON PP.program_merchantid  = PM.merchant_id
                  WHERE AC.etfDte > '$today'
                  AND PJP.joinpgm_affiliateid = '" . MultipleTimeDecode($_REQUEST['CONSAFF']) . "' ";
   $coupDet    =  $db->fetch_all($coupDetSql);

   $dataToSend = array();
   foreach ($coupDet as $coupVal) {
      $couponsDetails = array(
         'merchant_id'           =>  $coupVal['merchant_id'],
         'program_id'            =>  $coupVal['program_id'],
         'merchant_company'      =>  $coupVal['merchant_company'],
         'coupon_id'             =>  $coupVal['id'],
         'name'                  =>  $coupVal['name'],
         'valid_from'            =>  $coupVal['valid_from'],
         'valid_to'              =>  $coupVal['valid_to'],
         'coupon'                =>  $coupVal['coupon'],
         'coupon_detail'         =>  $coupVal['coupon_detail'],
         'discount_amount'       =>  $coupVal['discount_amount'],
         'discount_type'         =>  $coupVal['discount_type']
      );
      $dataToSend[] = $couponsDetails;
   }
 echo json_encode($dataToSend);
}
else{
   echo "Request _token is not valid";
}
