<?php
header("Access-Control-Allow-Origin: *");
include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';

$affiliate_id =$_REQUEST['MADKAI'];

$id = MultipleTimeDecode($affiliate_id);

//Color
$sql_color = "SELECT * FROM color_picks WHERE affiliate_id ='$affiliate_id' ";
$res    = mysqli_query($con,$sql_color);
foreach ($res as $row) {
    $ser_color =$row['search_color'];
    $name_color=$row['name_color'];
    $btn_color =$row['button_color'];
}

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
        $targetUrl = 'https://performanceaffiliate.com/trackingcode.php?aid='.$aid.'&linkid=N'.$text_id .'';
       // $targetUrl.="&auid={auid}&trafficSource={trafficsource}";
       return $targetUrl;
   } 
   function cleanData($value)
{
  $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
  $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

  return str_replace($search, $replace, $value);
}
function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$currentDate  = date('Y-m-d');
$consFileName = "dateFile-" . $id . "-" . $currentDate . ".json";

#Delete file 
$current_date  = date('Y-m-d');
$previous_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

// Set the file name to be deleted
$previousDayFile = "dateFile-" . $id . "-" . $previous_date . ".json";
// If it does, delete the file if it exists
if (file_exists($previousDayFile)) {
    // delete the file with the previous date
    unlink($previousDayFile);
}
#End Delete file 


if( $id != "" )
{

   #check if the json file exists for this affiliate 
    #then get data from that file
    $_contents =
        '<div id="PerAff_histoFrec"></div>
        <section class="PerAff_partner_info" id="PerAff_eskd_srch"><br><br>
        <div class="container">
            <div class="row">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="search">
                            <form class="search-container frmSearch" method="POST">
                                <input type="text" id="search-bar" onkeyup="searchResult()" name="Keyword" class="search-input" placeholder="Search A Retailer">
                                <a href="#">
                                    <div class="search-icon" style="background-color:'.$ser_color.'"><i class="fas fa-search"></i></div>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="view-text text-start" id="livesearch">
                        <h4>Our Partnered Retailers</h4>
                    </div>
                </div>
              
            </div>
        </div>
        </section>';

# Coupon Code for discount PerAff 
$api_url = "https://performanceaffiliate.com/affiliates/couponApi.php?_token=ecnrtp45jade&CONSAFF=VmtjeGQxVnNRbEpRVkRBOQ==";
// Read JSON file
$json_data = file_get_contents($api_url);
// Decode JSON data into PHP array 
$response_data = json_decode($json_data, true);

$unique_data = array_unique($response_data, SORT_REGULAR); // Remove duplicate rows
$single_row = reset($unique_data); // Get the first (and only) row

$programIds = array();
foreach ($unique_data as $apiRow) {
 $coupon_details=$apiRow['coupon_detail'];
 $valid_to=$apiRow['valid_to'];
 $valid_from=$apiRow['valid_from'];
 $programIds[] = $apiRow['program_id'];
}
 $values = implode(",", $programIds);

$_contents .='<div class="partner-name pt-35" id="PerAff_elefRec">
<div class="main">
    <div class="container bg-gry">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex justify-content-around" id="PerAff_suggesstion-box">';
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
 WHERE partners_program.program_id IN ($values) AND partners_merchant.merchant_status='approved'
 AND partners_program.program_status='active'
 AND partners_joinpgm.joinpgm_affiliateid='$id' LIMIT 50";

   $details    = mysqli_query($con,$SqlQuery);
   $dataToSend = array();
  
   foreach ($details as $data) {
    // Companyname
    if (strlen($data['merchant_company']) > 10) {
        // Limit the string to 10 characters
        $companyname = substr($data['merchant_company'], 0, 10);
        // Add ellipsis to the truncated string
        $companyname .= "...";
    } else {
        $companyname = $data['merchant_company'];
    }
    $link_url  =  getLinkUrl($data['text_id'], $id);
    $consPGM    = $data['program_id'];
    $_contents .= '<div class="col"> <div class="partner-card" >';

    //Coupon  
       foreach ($response_data as $apiRow) {
        if ($data['program_id'] == $apiRow['program_id']) {
            if ($apiRow['discount_type'] == 'Pound') {
                $discType = '£';
            }
            if ($apiRow['discount_type'] == 'Dollar') {
                $discType = '$';
            }
            if ($apiRow['discount_type'] == 'Euro') {
                $discType = '€';
            }
            $caption = NULL;
            if ($apiRow['discount_type'] == '%') {
                $caption = "%";
                $discType = NULL;
            }
            $coupon_details=cleanData($apiRow['coupon_detail']);
            $valid_to      =$apiRow['valid_to'];
            $valid_from    =$apiRow['valid_from']; 

    $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"><span class="off" style=" background-color:'.$name_color.'; color:#fff;">Discount ' . $discType . '' . $apiRow['discount_amount'] . '' . $caption . ' </span></div><br>';
}}
    $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"></div><br><br>';
    $_contents .= '<div><div class="partner-img"><img src="' .'https://performanceaffiliate.com/merchants/uploadedimage/'.$data['merchant_profileimage'].'" alt="" height="65px"></div><br><div><b style="color:'.$name_color.';">' .  $companyname . '</b><button type="button" class="btn btn-outline-chashback title" style="height:78px">' . preg_replace('/[^a-z0-9]/i', ' ', substr($data['program_description'], 0, 96)) . '<i class="fas fa-caret-right"></i></button>';
    $_contents .= '<span style="cursor:pointer; color:'.$name_color.';" onclick="PerAff_s_Brand_Disc(' . "'" .cleanData($data['merchant_profileimage']) . "'" . ','."'". $coupon_details ."'".','."'". $valid_to ."'".','."'". $valid_from ."'".',' . "'" . cleanData($data['program_description']) . "'" . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" class="PerAffterms">View</span></div></div></div></div>'; 
   }
$_contents .='</div></div></div></div>';

$consLimit  = 20; 

$_contents .='<div class="partner-name pt-35" id="PerAff_elefRectwo">
    <div class="main">
        <div class="container bg-gry">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex justify-content-around record" id="PerAff_suggesstion-box">';
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
    AND partners_joinpgm.joinpgm_affiliateid='$id' AND partners_program.program_id NOT IN ($values) LIMIT $consLimit";

$details    = mysqli_query($con,$SqlQuery);
$dataToSend = array();

foreach ($details as $data) {
    // Companyname
    if (strlen($data['merchant_company']) > 10) {
        // Limit the string to 10 characters
        $companyname = substr($data['merchant_company'], 0, 10);
        // Add ellipsis to the truncated string
        $companyname .= "...";
    } else {
        $companyname = $data['merchant_company'];
    }
    $link_url   =  getLinkUrl($data['text_id'], $id);
    $consPGM    =  $data['program_id'];
    $_contents .= '<div class="col"> <div class="partner-card" >';
    $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"></div><br>';
    $_contents .= '<div><div class="partner-img"><br><img src="' . 'https://performanceaffiliate.com/merchants/uploadedimage/'.$data['merchant_profileimage'].'" alt="" height="65px"></div><br><div><b style="color:'.$name_color.';">' .  $companyname . '</b><button type="button" class="btn btn-outline-chashback title" style="height:78px">' . preg_replace('/[^a-z0-9]/i', ' ', substr($data['program_description'], 0, 96)) . '<i class="fas fa-caret-right"></i></button><span style="cursor:pointer; color:'.$name_color.';" onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . "'" . $data['program_description'] . "'" . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" class="PerAffterms">View</span></div></div></div></div>';
}
    $_contents .= '</div></div></div><span id="consLimit" style="display:none;">'.$consLimit.'</span><center><button class="btn btn-view" onclick="loadMore('.$consLimit.')">Show More</button></center></div>';

$dataToSend[] = $_contents;
$json_data = json_encode($dataToSend);
file_put_contents($consFileName, $json_data);
$_data = array('resData' => $_contents);
echo json_encode($_data);
}

