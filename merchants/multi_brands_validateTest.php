<?php
session_start();
require_once('../custom-emd/init.php');
$MERCHANTID =  $_SESSION['MERCHANTID'];

function cleanData($value)
{
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}

if(isset($_POST['UpdatedBrands']))

foreach($_POST['UpdatedBrands'] as $brand)
{
   
    $org_val .= $brand . '|';
    $new_array = rtrim($org_val, '|');
}

{

    foreach ($_POST['UpdatedBrands'] as $key => $valBrand) {
        $consData = array('cons_mer_id'     =>  $MERCHANTID, 
                          'cons_brand_name' => $valBrand,
                         );
        $findDup = "SELECT COUNT(id) AS fRec FROM ".PREFIX."cons_mer_brands WHERE  cons_mer_id = '".$MERCHANTID."'  AND cons_brand_name = '".$valBrand."' ";
        if($db->fetch_single_row($findDup)['fRec'] < 1 ){
            $db->insert_values($consData, 'cons_mer_brands' );                 
        }                
        
    }
    
    

    $upSQL = "UPDATE `partners_merchant` SET `brands` = '" . cleanData($new_array) . "' WHERE `merchant_id` = '" . $MERCHANTID . "'";
    $db->run_query($upSQL);
    echo "Data Saved Successfully.";

}
