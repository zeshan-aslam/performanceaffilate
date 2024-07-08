<?php
header("Access-Control-Allow-Origin: *");
include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';

$affiliate_id =$_REQUEST['MADKAI'];

$id = MultipleTimeDecode($affiliate_id);

// Get the current date
$current_date = date('Y-m-d');

// Subtract one day from the current date
$previous_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

// emhyyt20i3kkoaqwmsdfniwxci
// PGM

// $start_date = $_REQUEST['start_date'];

// $end_date = $_REQUEST['end_date'];

#Function For Getting Multiple Countries Name Based on Multiple Countries Ids

function getCountryOfPromotionName($merchant_id)
{
      $conn = $GLOBALS['con'];

     $country_pro_query = "SELECT partners_country.country_name FROM mer_cop 
      join partners_country on mer_cop.cop_id = partners_country.country_no
      WHERE mer_cop.client_id='$merchant_id'";
      $country_pro="";
      $data = mysqli_query($conn,$country_pro_query);
     
    foreach($data as $c_promotion)
    {
       $country_pro .= $c_promotion['country_name'] .',';
    }
    $final_pro_country = rtrim($country_pro, ',');
    return $final_pro_country;
}
function getCategoryName($merchant_id)
    { 
      $conn = $GLOBALS['con'];
      $merchant_cat = "SELECT partners_category.cat_name FROM partners_merchant 
      join partners_category on partners_merchant.merchant_category = partners_category.cat_id
      WHERE partners_merchant.merchant_id='$merchant_id'";
      $category="";
      $data = mysqli_query($conn,$merchant_cat);
        
        // $category=array();
        foreach($data as $mer_cat)
        {
            $category=$mer_cat['cat_name'];
        }
        return $category;
    }
  function getLinkUrl($text_id,$aid)
   {
     //&redirectURL={redirecturl}
        $subidurl = "&amp;subid=1";
        if(!empty($subid)) $subidurl = "&amp;subid=$subid";
        $targetUrl = 'https://performanceaffiliate.com/trackingcode.php?aid='.$aid.'&linkid=N'.$text_id .''.$subidurl;
        $targetUrl.="&auid={auid}&trafficSource={trafficsource}";
       return $targetUrl;
   } 

$currentDate  = date('Y-m-d'); 
$consFileName = "dateFile-".$id."-".$currentDate.".json";    

#Delete file 
$current_date  = date('Y-m-d');
$previous_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

// Set the file name to be deleted
$previousDayFile = "dateFile-".$id."-".$previous_date.".json"; 
  // If it does, delete the file if it exists
  if(file_exists($previousDayFile)) {
    // delete the file with the previous date
    unlink($previousDayFile);
  }
#End Delete file 


if( $id != "" )
{

#check if the json file exists for this affiliate 
#then get data from that file

if(file_exists($consFileName)){
	$_data = file_get_contents($consFileName); //data read from json file
  echo $_data; 
}
else{
# Query For Get Single Affiliate Details
$SqlQuery = "SELECT partners_pgm_commission.* , partners_text_old.text_id,partners_joinpgm.joinpgm_id,partners_joinpgm.joinpgm_programid,partners_joinpgm.joinpgm_merchantid,
             partners_joinpgm.joinpgm_affiliateid,partners_joinpgm.joinpgm_date,partners_program.program_id,partners_program.program_status,
             partners_program.program_merchantid,partners_program.program_url,partners_program.program_description,
             partners_program.program_cookie,partners_merchant.merchant_id,partners_merchant.merchant_company,
             partners_merchant.merchant_category,partners_merchant.merchant_currency,partners_merchant.merchant_profileimage,partners_merchant.brands,
             partners_merchant.brand_power,partners_merchant.country_permotion,partners_merchant.merchant_url
             FROM partners_merchant 
             JOIN partners_joinpgm ON partners_merchant.merchant_id = partners_joinpgm.joinpgm_merchantid
             LEFT JOIN partners_program ON partners_joinpgm.joinpgm_programid = partners_program.program_id 
             LEFT JOIN partners_text_old ON partners_joinpgm.joinpgm_programid=partners_text_old.text_programid
             LEFT JOIN partners_pgm_commission ON partners_pgm_commission.commission_programid=partners_program.program_id
             WHERE partners_merchant.merchant_status='approved'
             AND partners_program.program_status='active'
             AND partners_joinpgm.joinpgm_affiliateid='$id' ";

   $details    = mysqli_query($con,$SqlQuery);
   $dataToSend = array();
   foreach($details as $data)
   {
    $AffiliateDetails = array(
       'joinpgm_id' =>  $data['joinpgm_id'],
       'joinpgm_programid' =>  $data['joinpgm_programid'],
       'joinpgm_merchantid' =>  $data['joinpgm_merchantid'],
       'joinpgm_affiliateid' =>  $data['joinpgm_affiliateid'],
       'joinpgm_date' =>  $data['joinpgm_date'],
       'program_id' => $data['program_id'],
       'program_url' => $data['program_url'],
       'program_status' => $data['program_status'],
       'program_merchantid' =>  $data['program_merchantid'],
       'program_description' =>  $data['program_description'],
       'program_cookie' =>  $data['program_cookie'],
       'merchant_id' => $data['merchant_id'],
       'merchant_company' =>  $data['merchant_company'],
       'merchant_url' =>  $data['merchant_url'],
       'merchant_category' => getCategoryName($data['merchant_id']),
       'merchant_currency' =>  $data['merchant_currency'],
       'brands' =>  $data['brands'],
       'brand_power' =>  $data['brand_power'],
       'payment' => $data['commission_salerate'],
       'payment_sale_type' => $data['commission_saletype'],
       'country_of_promotion' => getCountryOfPromotionName($data['merchant_id']),
       'image_url' => 'https://performanceaffiliate.com/merchants/uploadedimage/'.$data['merchant_profileimage'],
       'link_url' => getLinkUrl($data['text_id'],$id)
    );
    $dataToSend[] = $AffiliateDetails;      
   }   

echo $json_data = json_encode($dataToSend);;
file_put_contents($consFileName, $json_data);
}

}



