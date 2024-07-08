<?php 
require_once('custom-emd/init.php');  

$today = date('Y-m-d');

 $delExpCoup = "DELETE FROM affilate_coupon WHERE etfDte < '$today'";

 $delExp = $db->run_query($delExpCoup);

if($delExp)
{
    echo "expired coupons deleted";

}else{
    echo "failed";

}

?>