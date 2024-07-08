<?php
require_once('init.php');
$allMer = $db->baseSelect("partners_merchant_clone");
$number = null;
foreach ($allMer as $key => $valMer) {
    $getRelIdSql = "SELECT country_no FROM ".PREFIX."partners_country WHERE country_name = '".$valMer['country_promotion']."' ";
    $getRelId    = $db->fetch_single_row($getRelIdSql)['country_no']; 

    
    //$upCountSql = "UPDATE ".PREFIX."partners_merchant_clone SET merchant_country = '".$getRelId."' WHERE merchant_id = '".$valMer['merchant_id']."' ";
    if(!is_numeric($valMer['country_promotion'])){
        $number++;
        echo $number.": Number Found.<br>";
        $upCountSql = "UPDATE ".PREFIX."partners_merchant_clone SET merchant_country = '".$getRelId."' WHERE merchant_id = '".$valMer['merchant_id']."' ";
        $db->run_query($upCountSql);
    }

}



?>