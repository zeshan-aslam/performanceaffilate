
<?php
require_once('init.php');

//echo "Same Page...";
# For chaning merchant_country
// $allMer = $db->baseSelect("partners_merchant");
// $number = null;
// foreach ($allMer as $key => $valMer) {
//     $getRelIdSql = "SELECT country_no FROM ".PREFIX."partners_country WHERE country_name = '".$valMer['merchant_country']."' ";
//     $getRelId    = $db->fetch_single_row($getRelIdSql)['country_no']; 

    
//     if(!is_numeric($valMer['merchant_country'])){

//         $upCountSql = "UPDATE ".PREFIX."partners_merchant SET merchant_country = '".$getRelId."' WHERE merchant_id = '".$valMer['merchant_id']."' ";
//         $db->run_query($upCountSql);
//     }

// }
// echo "Done";


# For chaning merchant_category
// $allMer = $db->baseSelect("partners_merchant");
// $number = null;
// foreach ($allMer as $key => $valMer) {
//     $getRelIdSql = "SELECT cat_id FROM ".PREFIX."partners_category WHERE cat_name = '".$valMer['merchant_category']."' ";
//     $getRelId    = $db->fetch_single_row($getRelIdSql)['cat_id']; 

    
//     if(!is_numeric($valMer['merchant_category'])){
        
//         if($valMer['merchant_category'] != 'nill'){

//             $upCountSql = "UPDATE ".PREFIX."partners_merchant SET merchant_category = '".$getRelId."' WHERE merchant_id = '".$valMer['merchant_id']."' ";
//             $db->run_query($upCountSql);

//         }


//     }

// }
// echo "Cates Done";


# For chaning country of promotion
// $allMer = $db->baseSelect("partners_merchant");
// $number = null;
// foreach ($allMer as $key => $valMer) {
//     $getRelIdSql = "SELECT country_no FROM ".PREFIX."partners_country WHERE country_name = '".$valMer['country_permotion']."' ";
//     $getRelId    = $db->fetch_single_row($getRelIdSql)['country_no']; 

    
//     if(!is_numeric($valMer['country_permotion'])){

//         if (strpos($valMer['country_permotion'], ",") !== false) {
//             echo 'true';
//         }else{
//             $upCountSql = "UPDATE ".PREFIX."partners_merchant SET country_permotion = '".$getRelId."' WHERE merchant_id = '".$valMer['merchant_id']."' ";
//             $db->run_query($upCountSql);
//         }
        
//     }

// }
// echo "COP Done";


# For insertion of country_permotion
// $allMer = $db->baseSelect("partners_merchant");
// $number = null;
// foreach ($allMer as $key => $valMer) {



//         if (strpos($valMer['country_permotion'], ",") !== false) {
//             $innerProm = explode(",", $valMer['country_permotion']);
//             foreach ($innerProm as $key => $valProm) {
//                 $copData = array('client_id' => $valMer['merchant_id'], 'cop_id' => $valProm  ); 
//                 $db->insert_values($copData,"mer_cop");
//             }
//         }else{
//             $copData = array('client_id' => $valMer['merchant_id'], 'cop_id' => $valMer['country_permotion']  ); 
//             $db->insert_values($copData,"mer_cop");
//         }

// }

// echo "Entries Done";



# For insertion of Brands from partners_merchant to cons_mer_brands table
// $allMer = $db->baseSelect("partners_merchant");
// $number = null;
// foreach ($allMer as $key => $valMer) {


//     $trimed_value = trim($valMer['brands'], "|");
//     if (strpos($trimed_value, "|") !== false) {
//         $innerProm = explode("|", $trimed_value);
//         foreach ($innerProm as $key => $valProm) {
//             if ($valProm != '') {
//                 $copData = array('cons_mer_id' => $valMer['merchant_id'], 'cons_brand_name' => $valProm);
//                 $db->insert_values($copData, "cons_mer_brands");
//             }
//         }
//     } elseif ($valMer['brands'] != '' && strpos($trimed_value, "|") !== true) {
//         $copData = array('cons_mer_id' => $valMer['merchant_id'], 'cons_brand_name' => $valMer['brands']);
//         $db->insert_values($copData, "cons_mer_brands");
//     }
// }

// echo "Entries Done in cons_mer_brands Table";







?>