<?php
// Start To get the current location
$ip = $_SERVER['REMOTE_ADDR'];

$apiUrl = "http://ip-api.com/json/{$ip}";
$response = file_get_contents($apiUrl);
$data = json_decode($response);

$curr_country = $data->country;

// End To get the current location


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

$countryIdQuery = "SELECT * FROM partners_country WHERE country_name = '$selectedCountry'";
$CountryNamesID = mysqli_query($con, $countryIdQuery);
while ($row = mysqli_fetch_assoc($CountryNamesID)) {
    $selectedCountryID = $row['country_no'];
}

// $current_location = "";
//Color
$sql_color = "SELECT * FROM color_picks WHERE affiliate_id ='$id' ";
$res       = mysqli_query($con, $sql_color);
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
?>
