<?php
header("Access-Control-Allow-Origin: *");
include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';

$ip = $_SERVER['REMOTE_ADDR'];

$apiUrl = "http://ip-api.com/json/{$ip}";
$response = file_get_contents($apiUrl);
$data = json_decode($response);

$curr_country = $data->country;

// End To get the current location


$selected_curr_country = null;
$affiliate_id = $_GET['PerAffconToken']; # affiliate id
// echo "affiliate id: " . $affiliate_id;
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

$id = MultipleTimeDecode($affiliate_id);
// echo"id: ".$id;
$consLimit  = $_GET['consLimit'];
// $current_location = "";
//Color
$sql_color = "SELECT * FROM color_picks WHERE affiliate_id ='$id' ";
$res       = mysqli_query($con, $sql_color);
if ($ser_color == '') {
    $ser_color = "#000";
    $btn_color = "#000";
}
foreach ($res as $row) {
    $ser_color = $row['search_color'];
    $name_color = $row['name_color'];
    $btn_color = $row['button_color'];
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
    $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}
#with out discount
$currentDate  = date('Y-m-d');
$consFileName = "dateFile-" . $id . "-" . $currentDate . ".json";




#Delete file without discount json
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
#Delete file with Coupon json
$current_date  = date('Y-m-d');
$previous_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
// Set the file name to be deleted
$previousDayFile = "dateFileCoupon-" . $id . "-" . $previous_date . ".json";
// If it does, delete the file if it exists
if (file_exists($previousDayFile)) {
    // delete the file with the previous date
    unlink($previousDayFile);
}

$api_url = "https://performanceaffiliate.com/performanceAffiliateClone/affiliates/couponApi.php?_token=ecnrtp45jade&CONSAFF='$affiliate_id'";
$json_data = file_get_contents($api_url);
$response_data = json_decode($json_data, true);
$unique_data = array_unique($response_data, SORT_REGULAR);
$single_row = reset($unique_data);

$programIds = array();
foreach ($unique_data as $apiRow) {
    $coupon_details = $apiRow['coupon_detail'];
    $valid_to      = $apiRow['valid_to'];
    $valid_from    = $apiRow['valid_from'];
    $programIds[]  = $apiRow['program_id'];
}
$values = implode(",", $programIds);

if (empty($selectedCountryID)) {
    $selectedCountryID = 1;
}
$consLimit = 30;
$SqlQuery = "SELECT partners_pgm_commission.* , partners_text_old.text_id, partners_joinpgm.joinpgm_id, partners_joinpgm.joinpgm_programid, partners_joinpgm.joinpgm_merchantid,
partners_joinpgm.joinpgm_affiliateid, partners_joinpgm.joinpgm_date, partners_program.program_id, partners_program.program_status,
partners_program.program_merchantid, partners_program.program_url, partners_program.program_description,
partners_program.program_cookie, partners_merchant.merchant_id, partners_merchant.merchant_company,
partners_merchant.merchant_category, partners_merchant.merchant_currency, partners_merchant.merchant_profileimage, partners_merchant.brands,
partners_merchant.brand_power, partners_merchant.country_permotion, partners_merchant.merchant_city, partners_merchant.merchant_url
FROM partners_merchant 
JOIN partners_joinpgm ON partners_merchant.merchant_id = partners_joinpgm.joinpgm_merchantid
LEFT JOIN partners_program ON partners_joinpgm.joinpgm_programid = partners_program.program_id 
LEFT JOIN partners_text_old ON partners_joinpgm.joinpgm_programid=partners_text_old.text_programid
LEFT JOIN partners_pgm_commission ON partners_pgm_commission.commission_programid=partners_program.program_id
WHERE partners_merchant.merchant_status = 'approved'
AND partners_program.program_status = 'active'
AND partners_joinpgm.joinpgm_affiliateid = '$id'
AND partners_program.program_id IN ($values)
";

$details = mysqli_query($con, $SqlQuery);
$count_showmore = 0;
foreach ($details as $data) {
    // if ($count_showmore < 30) {
    if (strlen($data['merchant_company']) > 10) {
        // Limit the string to 10 characters
        $companyname = substr($data['merchant_company'], 0, 10);
        // Add ellipsis to the truncated string
        $companyname .= "...";
    } else {
        $companyname = $data['merchant_company'];
    }
    $merchantID = $data['merchant_id'];
    $program_id = $data['program_id'];
    $coupon_details = $apiRow['coupon_detail'];
    $valid_to      = $apiRow['valid_to'];
    $valid_from    = $apiRow['valid_from'];
    // $programIds[]  = $apiRow['program_id'];

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

            if ($apiRow['discount_type'] == '%') {

                $discType = "%";
            }
            // $discount_amount = $apiRow['discount_amount'];
            $coupon_details = cleanData($apiRow['coupon_detail']);
            $disc_amount = $apiRow['discount_amount'];
            // $valid_to      = $apiRow['valid_to'];
            // $valid_from    = $apiRow['valid_from'];
        }
        // echo json_encode($apiRow);
    }
    $link_url   =  getLinkUrl($data['text_id'], $id);
    $url_link   = cleanData($link_url);

    $dataToSend[] = array(
        "type" => "discount",
        "program_id" => $program_id,
        "merchant_profileimage" => cleanData($data['merchant_profileimage']),
        "merchant_company" => $companyname,
        "program_description" => substr(clean($data['program_description']), 0, 96),
        "program_url" => $url_link,
        "btn_color" => $btn_color,
        "name_color" => $name_color,
        "discount_type" => $discType,
        "discount_amount" => $disc_amount,
        "coupon_details" => $coupon_details,
        "valid_to" => $valid_to,
        "valid_from" => $valid_from,
        "country_permotion" => getCountryOfPromotionName($merchantID),
    );
    // }
    $count_showmore++;
}
$consLimit = 30 - $count_showmore;
$SqlQuery = "SELECT partners_pgm_commission.* , partners_text_old.text_id,partners_joinpgm.joinpgm_id,partners_joinpgm.joinpgm_programid,partners_joinpgm.joinpgm_merchantid,
    partners_joinpgm.joinpgm_affiliateid,partners_joinpgm.joinpgm_date,partners_program.program_id,partners_program.program_status,
    partners_program.program_merchantid,partners_program.program_url,partners_program.program_description,
    partners_program.program_cookie,partners_merchant.merchant_id,partners_merchant.merchant_company,
    partners_merchant.merchant_category, partners_merchant.merchant_currency,partners_merchant.merchant_profileimage,partners_merchant.brands,
    partners_merchant.brand_power,partners_merchant.merchant_url
    FROM partners_merchant 
    JOIN partners_joinpgm ON partners_merchant.merchant_id = partners_joinpgm.joinpgm_merchantid
    LEFT JOIN partners_program ON partners_joinpgm.joinpgm_programid = partners_program.program_id 
    LEFT JOIN partners_text_old ON partners_joinpgm.joinpgm_programid=partners_text_old.text_programid
    LEFT JOIN partners_pgm_commission ON partners_pgm_commission.commission_programid=partners_program.program_id
    WHERE partners_merchant.merchant_status='approved'
    AND partners_program.program_status='active'
    AND partners_joinpgm.joinpgm_affiliateid='$id'
    AND partners_program.program_id NOT IN ($values)
    ";

$details    = mysqli_query($con, $SqlQuery);
foreach ($details as $data) {
    // $companyname = $data['merchant_company'];
    if (strlen($data['merchant_company']) > 10) {
        // Limit the string to 10 characters
        $companyname = substr($data['merchant_company'], 0, 10);
        // Add ellipsis to the truncated string
        $companyname .= "...";
    } else {
        $companyname = $data['merchant_company'];
    }
    $consPGM = $data['program_id'];
    $merchantID = $data['merchant_id'];

    $link_url   =  getLinkUrl($data['text_id'], $id);
    $url_link   = cleanData($link_url);
    $dataToSend[] = array(
        "type" => "withoutDiscount",
        "merchant_company" => $companyname,
        "program_url" => $url_link,
        "btn_color" => $btn_color,
        "name_color" => $name_color,
        'program_id' => $consPGM,
        "merchant_profileimage" => cleanData($data['merchant_profileimage']),
        "program_description" => substr(clean($data['program_description']), 0, 96),
        "country_permotion" => getCountryOfPromotionName($merchantID),
        'merchant_id' => $merchantID
    );
}

$json_data = json_encode($dataToSend);
file_put_contents($consFileName, $json_data);
echo json_encode($dataToSend);
// if (file_put_contents($consFileName, $json_data) === false) {
//     echo "Error creating file: " . $consFileName;
// }
// else{echo "Successfully created:" . $consFileName;}
// $json_response = [
//     "consFileName" => $consFileName
// ];
