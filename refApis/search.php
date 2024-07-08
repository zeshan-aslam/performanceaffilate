<?php
header("Access-Control-Allow-Origin: *");
// require_once('../custom-emd/init.php');
include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';


$ip = $_SERVER['REMOTE_ADDR'];

$apiUrl = "http://ip-api.com/json/{$ip}";
$response = file_get_contents($apiUrl);
$data = json_decode($response);

$curr_country = $data->country;

$selected_curr_country = null;
$affiliate_id = $_REQUEST['MADKAI']; # affiliate id
$selectedCountry = $_REQUEST['selectedCountry'];
$defaultCountry = $_REQUEST['defaultCountry'];

if (isset($_REQUEST['selectedCountry']) && $_REQUEST['selectedCountry'] !== '') {
    $selected_curr_country = $_REQUEST['selectedCountry'];
}

$CountryNameSql = "SELECT * FROM partners_country";
// Execute the query and retrieve the results
// Assuming you are using MySQLi
$CountryNameRes = mysqli_query($con, $CountryNameSql);
// Prepare an array to store the country names
if ($result && $result->num_rows > 0) {
    // Fetch the data from the result
    $row = $result->fetch_assoc();

    // Store the country_no in a variable
    $selectedCountryID = $row["country_no"];
}


// Free the result set

// Prepare the options HTML
$optionsHTML = '<option value="0" selected="selected">Select a Country</option>';
if ($CountryNameRes && mysqli_num_rows($CountryNameRes) > 0) {
    while ($row = mysqli_fetch_assoc($CountryNameRes)) {
        $countryName = $row['country_name'];
        // Add each country as an option in the dropdown
        // $optionsHTML .= '<option value="' . $countryName . '" selected="'.($selectedCountry == $countryName) ? 'selected':''.'">' . $countryName . '</option>';
        $optionsHTML .= '<option value="' . $countryName . '" ' . (($selectedCountry == $countryName) ? 'selected' : '') . '>' . $countryName . '</option>';
    }
}

// if ($selectedCountry == null) {
//     $selectedCountry_name = $defaultCountry;
// } else {
//     $selectedCountry_name = $selectedCountry;
// }
$countryIdQuery = "SELECT * FROM partners_country WHERE country_name = '$selectedCountry'";
$CountryNamesID = mysqli_query($con, $countryIdQuery);
while ($row = mysqli_fetch_assoc($CountryNamesID)) {
    $selectedCountryID = $row['country_no'];
}


$getSearch = $_GET['query'];
// echo "Working Fine Page ".$getSearch;
$affiliate_id = $_REQUEST['MADKAI'];
$id           = MultipleTimeDecode($affiliate_id);

//Color
$sql_color = "SELECT * FROM color_picks WHERE affiliate_id ='$id' ";
$res    = mysqli_query($con, $sql_color);
foreach ($res as $row) {
    $ser_color = $row['search_color'];
    $name_color = $row['name_color'];
    $btn_color = $row['button_color'];
}
if ($ser_color == '') {
    $ser_color = "#000";
}
if ($name_color == '') {
    $name_color = "#000";
}
if ($btn_color == '') {
    $btn_color = "#000";
}
// emhyyt20i3kkoaqwmsdfniwxci
#Function For Getting Multiple Countries Name Based on Multiple Countries Ids

function getCountryOfPromotionName($merchant_id)
{
    $conn = $GLOBALS['con'];

    $country_pro_query = "SELECT partners_country.country_name FROM mer_cop 
      join partners_country on mer_cop.cop_id = partners_country.country_no
      WHERE mer_cop.client_id='$merchant_id'";
    $country_pro = "";
    $data = mysqli_query($conn, $country_pro_query);

    foreach ($data as $c_promotion) {
        $country_pro .= $c_promotion['country_name'] . ',';
    }
    $final_pro_country = rtrim($country_pro, ',');
    return $final_pro_country;
}
function matchCountryOfPromotion($mer_cop_string, $curr_country)
{
    $matching_flag = false;
    $mer_cop_array = explode(',', $mer_cop_string);
    foreach ($mer_cop_array as $cop) {
        if ($cop == $curr_country) {
            $matching_flag = true;
            break;
        } else {
            $matching_flag = false;
        }
    }
    return $matching_flag;
}
function getCategoryName($merchant_id)
{
    $conn = $GLOBALS['con'];
    $merchant_cat = "SELECT partners_category.cat_name FROM partners_merchant 
      join partners_category on partners_merchant.merchant_category = partners_category.cat_id
      WHERE partners_merchant.merchant_id='$merchant_id'";
    $category = "";
    $data = mysqli_query($conn, $merchant_cat);

    // $category=array();
    foreach ($data as $mer_cat) {
        $category = $mer_cat['cat_name'];
    }
    return $category;
}
function getLinkUrl($text_id, $aid)
{
    //&redirectURL={redirecturl}
    $subidurl = "&amp;subid=1";
    if (!empty($subid)) $subidurl = "&amp;subid=$subid";
    $targetUrl = 'https://performanceaffiliate.com/performanceAffiliateClone/trackingcode.php?aid=' . $aid . '&linkid=N' . $text_id . '';
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
    $string = str_replace('-', ' ', $string); // Replaces all hyphens with spaces.
    return preg_replace('/[^A-Za-z0-9\s]/', '', $string); // Removes special chars.
}


# Coupon Code for discount PerAff 
$api_url = "https://performanceaffiliate.com/performanceAffiliateClone/affiliates/couponApi.php?_token=ecnrtp45jade&CONSAFF='$affiliate_id'";
// Read JSON file VmtjeGQxVnNRbEpRVkRBOQ==
$json_data = file_get_contents($api_url);
// Decode JSON data into PHP array 
$response_data = json_decode($json_data, true);

$unique_data = array_unique($response_data, SORT_REGULAR); // Remove duplicate rows
$single_row  = reset($unique_data); // Get the first (and only) row

$programIds = array();
foreach ($unique_data as $apiRow) {
    $coupon_details = $apiRow['coupon_detail'];
    $valid_to      = $apiRow['valid_to'];
    $valid_from    = $apiRow['valid_from'];
    $programIds[]  = $apiRow['program_id'];
}
$values = implode(",", $programIds);

if ($id != "") {

    # Query For Get Single Affiliate Details
    if (empty($selectedCountryID)) {
        $selectedCountryID = 1;
    }
    $SqlQuery = "SELECT partners_pgm_commission.*, partners_text_old.text_id, partners_joinpgm.joinpgm_id, partners_joinpgm.joinpgm_programid,
                    partners_joinpgm.joinpgm_merchantid, partners_joinpgm.joinpgm_affiliateid, partners_joinpgm.joinpgm_date,
                    partners_program.program_id, partners_program.program_status, partners_program.program_merchantid,
                    partners_program.program_url, partners_program.program_description, partners_program.program_cookie,
                    partners_merchant.merchant_id, partners_merchant.merchant_company, partners_merchant.merchant_category,
                    partners_merchant.merchant_currency, partners_merchant.merchant_profileimage, partners_merchant.brands,
                    partners_merchant.brand_power, partners_merchant.country_permotion, partners_merchant.merchant_url
                FROM partners_merchant 
                JOIN partners_joinpgm ON partners_merchant.merchant_id = partners_joinpgm.joinpgm_merchantid
                LEFT JOIN partners_program ON partners_joinpgm.joinpgm_programid = partners_program.program_id 
                LEFT JOIN partners_text_old ON partners_joinpgm.joinpgm_programid = partners_text_old.text_programid
                LEFT JOIN partners_pgm_commission ON partners_pgm_commission.commission_programid = partners_program.program_id
                WHERE partners_merchant.merchant_status = 'approved' AND partners_merchant.merchant_company LIKE '$getSearch%'
                AND partners_program.program_status = 'active' 
                AND partners_joinpgm.joinpgm_affiliateid = '$id'
                AND FIND_IN_SET('$selectedCountryID', partners_merchant.country_permotion)
                ORDER BY partners_pgm_commission.commission_programid DESC";



    $details = mysqli_query($con, $SqlQuery);
    $dataWithCoupons = array(); // Array to store data with coupons
    $dataWithoutCoupons = array(); // Array to store data without coupons

    foreach ($details as $data) {
        // Companyname
        // if (strlen($data['merchant_company']) > 10) {
        //     // Limit the string to 10 characters
        //     $companyname = substr($data['merchant_company'], 0, 10);
        //     // Add ellipsis to the truncated string
        //     $companyname .= "...";
        // } else {
            $companyname = $data['merchant_company'];
        // }

        $link_url  = getLinkUrl($data['text_id'], $id);
        $url_link   = cleanData($link_url);
        $merchantID = $data['merchant_id'];
        $consPGM    = $data['program_id'];
        $discount_mer_cop_string  = getCountryOfPromotionName($merchantID);
        $encodedDescription = json_encode($data['program_description']);
        $discount_curr_country = $curr_country;
        if (!empty($selected_curr_country)) {
            $discount_curr_country = $selected_curr_country;
        }

        $cop_matched = matchCountryOfPromotion($discount_mer_cop_string, $discount_curr_country);
        if (!$cop_matched) {
            // $defaultCountry
            $cop_matched = matchCountryOfPromotion($discount_mer_cop_string, $defaultCountry);
        }

        if ($cop_matched) {
            $_contents = '<div class="col"> <div class="partner-card">';

            $flag = false;
            foreach ($response_data as $apiRow) {
                if ($data['program_id'] == $apiRow['program_id']) {
                    $discType = '';
                    if ($apiRow['discount_type'] == 'Pound') {
                        $discType = '£';
                    } elseif ($apiRow['discount_type'] == 'Dollar') {
                        $discType = '$';
                    } elseif ($apiRow['discount_type'] == 'Euro') {
                        $discType = '€';
                    } elseif ($apiRow['discount_type'] == '%') {
                        $discType = '';
                    }

                    $caption = '';
                    if ($apiRow['discount_type'] == '%') {
                        $caption = '%';
                        $discType = '';
                    }

                    $coupon_details = cleanData($apiRow['coupon_detail']);
                    $valid_to      = $apiRow['valid_to'];
                    $valid_from    = $apiRow['valid_from'];

                    $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"><span class="off" style=" background-color:' . $name_color . '; color:#fff;">Discount ' . $discType . '' . $apiRow['discount_amount'] . '' . $caption . ' </span><span></span></div><br>';
                    $flag = true;
                }
            }
            if ($data['merchant_profileimage'] == '') {
                $data['merchant_profileimage'] = 'PerformanceAffiliateLogo.png';
            }
            if ($flag == true) {
                // $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"></div><br><br>';
                $_contents .= '<div><a href="#top" style="text-decoration:none; color:' . $name_color . ';" onclick="mf.PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')"><div class="partner-img"><img src="' . 'https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' . cleanData($data['merchant_profileimage']) . '" style="cursor:pointer;"></div><div class="partner-name" style="background-color: white; color:' . $name_color . '; white-space: pre-wrap; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;"><b>' .  $companyname . '</b></div></a>';
                $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><button onclick="mf.PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ','.  htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8')  . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" type="button" class="btn btn-outline-chashback title" style="height:78px">' . preg_replace('/[^a-z0-9]/i', ' ', substr(clean($data['program_description']), 0, 96)) . '<i class="fas fa-caret-right"></i></button>';
                $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:' . $name_color . ';" onclick="mf.PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8')  . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" class="PerAffterms">View</a></div></div></div>';                $dataWithCoupons[] = $_contents; // Add content to the array with coupons
            } else {
                // $_contents .= '<div class="col"><div class="partner-card">';
                if($data['merchant_profileimage'] != 'PerformanceAffiliateLogo.png'){
                    $_contents .= '<div class="flat-code" style="margin-top: -45px;margin-bottom:-23px;"> </div><br>';}
                    else{$_contents .= '<div class="flat-code" style="margin-top:40px;margin-bottom:-23px;"></div><br>';}
                $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><div onclick="mf.PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer;"><div class="partner-img" style="margin-top: 25px;margin-bottom: -25px;"><img src="' . 'https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' . $data['merchant_profileimage'] . '" style="cursor:pointer;"></div></div><br>';
                $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><div onclick="mf.PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer;"><div class="partner-name" style="background-color: white; color:' . $name_color . '; white-space: pre-wrap; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;"><b>' .  $companyname . '</b></div></div>';
                $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><button onclick="mf.PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" type="button" class="btn btn-outline-chashback title" style="height:78px">' . preg_replace('/[^a-z0-9]/i', ' ', substr(clean($data['program_description']), 0, 96)) . '<i class="fas fa-caret-right"></i></button>';
                $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><span onclick="mf.PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer; color:' . $name_color . ';" class="PerAffterms">View</a></span>';
                $_contents .= '</div></div><span id="" style="display:none;"></span><span id="consLimit" style="display:none;">' . $consLimit . '</span>';
        
                $dataWithoutCoupons[] = $_contents; // Add content to the array without coupons
            }
        }
    }

    // Output the contents with coupons first, followed by contents without coupons
    foreach ($dataWithCoupons as $_data) {
        echo $_data;
    }

    foreach ($dataWithoutCoupons as $_data) {
        echo $_data;
    }


    //echo json_encode($_data);
}
