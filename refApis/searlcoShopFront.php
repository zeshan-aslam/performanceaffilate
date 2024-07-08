
<?php
header("Access-Control-Allow-Origin: *");
include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';

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

$partnerCountries = null;

// Prepare the options HTML
$optionsHTML = '<option value="0" selected="selected">Select a Country</option>';
if ($CountryNameRes && mysqli_num_rows($CountryNameRes) > 0) {
    while ($row = mysqli_fetch_assoc($CountryNameRes)) {
        $countryName = $row['country_name'];
        // Add each country as an option in the dropdown
        // $optionsHTML .= '<option value="' . $countryName . '" selected="'.($selectedCountry == $countryName) ? 'selected':''.'">' . $countryName . '</option>';
        $optionsHTML .= '<option value="' . $countryName . '" ' . (($selectedCountry == $countryName) ? 'selected' : '') . '>' . $countryName . '</option>';

        $partnerCountries[] = $row;
    }
}

$countryIdQuery = "SELECT * FROM partners_country WHERE country_name = '$selectedCountry'";
$CountryNamesID = mysqli_query($con, $countryIdQuery);
while ($row = mysqli_fetch_assoc($CountryNamesID)) {
    $selectedCountryID = $row['country_no'];
}

$id = MultipleTimeDecode($affiliate_id);
// $consLimit = isset($_GET['consLimit']);
// echo "Limit:"$consLimit;
// echo $consLimit;


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


// Get the current date
$current_date = date('Y-m-d');

// Subtract one day from the current date
$previous_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));



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
$consFileName = "jsonFiles/dateFile-" . $id . "-" . $currentDate . ".json";

#With discount
// $currentDate  = date('Y-m-d');
// $consCouponFileName = "dateFileCoupon-" . $id . "-" . $currentDate . ".json";


#Delete file without discount json
$current_date  = date('Y-m-d');
$previous_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));

// Set the file name to be deleted
$previousDayFile = "jsonFiles/dateFile-" . $id . "-" . $previous_date . ".json";
// If it does, delete the file if it exists
if (file_exists($previousDayFile)) {
    // delete the file with the previous date
    unlink($previousDayFile);
}
#End Delete file 
#Delete file with Coupon json
// $current_date  = date('Y-m-d');
// $previous_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
// // Set the file name to be deleted
// $previousDayFile = "dateFileCoupon-" . $id . "-" . $previous_date . ".json";
// // If it does, delete the file if it exists
// if (file_exists($previousDayFile)) {
//     // delete the file with the previous date
//     unlink($previousDayFile);
// }
#End Delete file 

if ($id != "" && isset($_GET['initialize'])) 
{

    $_data["partnercountries"] = $partnerCountries;
    $_data["ser_color"] = $ser_color;
    $_data["name_color"] = $name_color;
    $_data["btn_color"] = $btn_color;
    $_data["consLimit"] = $consLimit;
    $_data["id"] = $id;
    echo json_encode($_data);

    die();
}

// if ($id != "" && !(isset($_GET['consLimit']))) 
// {
    #check if the json file exists for this affiliate 
    #then get data from that file
    // $_contents =
        '<div id="PerAff_histoFrec"></div>
        <section class="PerAff_partner_info" id="PerAff_eskd_srch"><br><br>
            <div class="container">
                <div class="row">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                        <div class="search">
                        <div class="search-container frmSearch">
                            <input type="text" id="search-bar"  name="Keyword" class="search-input" placeholder="Search A Retailer">
                            <a href="#">
                                <div class="search-icon" onclick="searchResult(event)" style="background-color:' . $ser_color . '"><i class="fas fa-search"></i></div>
                            </a>
                        </div>
                    </div>
                    
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="view-text text-start" id="livesearch">
                            <h4>Our Partnered Retailers</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Please Select a Country</label>
                        <select class="form-select form-select-sm" id="countrySelect" onchange="handleCountryChange()">
                        ' . $optionsHTML . '
                        </select>
                    </div>
                </div>
            </div>
            
        </section>
        
        ';

    # Coupon Code for discount PerAff 
    $api_url = "https://performanceaffiliate.com/performanceAffiliateClone/affiliates/couponApi.php?_token=ecnrtp45jade&CONSAFF='$affiliate_id'";
    // Read JSON file 
    $json_data = file_get_contents($api_url);
    //Save the file json 
    $json_datas = json_encode($json_data);
    file_put_contents($consCouponFileName, $json_datas);
    // Decode JSON data into PHP array 
    $response_data = json_decode($json_data, true);
    $unique_data = array_unique($response_data, SORT_REGULAR); // Remove duplicate rows
    $single_row = reset($unique_data); // Get the first (and only) row

    $programIds = array();
    foreach ($unique_data as $apiRow) {
        $coupon_details = $apiRow['coupon_detail'];
        $valid_to      = $apiRow['valid_to'];
        $valid_from    = $apiRow['valid_from'];
        $programIds[]  = $apiRow['program_id'];
    }
    $values = implode(",", $programIds);

    $_contents .= '<div class="partner-name pt-35" id="PerAff_elefRec">
    <div class="main">
        <div class="container bg-gry">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex record" id="PerAff_suggesstion-box"><br style="display: contents;">';


    # Query For Get Single Affiliate Details
    # Query For Get Single Affiliate Details
    //  if ($selected_curr_country !== null) {
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
    AND partners_program.program_id IN ($values)";


    $details    = mysqli_query($con, $SqlQuery);
    $dataToSend = array();

    // $flag = false;
    $count_showmore = 0;
    foreach ($details as $data) 
    {
        if ($count_showmore < 30) 
        {
            $dataitem = null;

            $companyname = $data['merchant_company'];
            $link_url   =  getLinkUrl($data['text_id'], $id);
            $url_link   = cleanData($link_url);
            $merchantID = $data['merchant_id'];
            $country    = $data['merchant_city'];
            $consPGM    = $data['program_id'];
            $discount_mer_cop_string  = getCountryOfPromotionName($merchantID);
            $encodedDescription = json_encode($data['program_description']);
            $_contents .= '<div class="col"> <div class="partner-card" >';

            $dataitem["companyname"] = $companyname;
            $dataitem["link_url"] = $link_url;
            $dataitem["url_link"] = $url_link;
            $dataitem["merchantID"] = $merchantID;
            $dataitem["country"] = $country;
            $dataitem["consPGM"] = $consPGM;
            $dataitem["discount_mer_cop_string"] = $discount_mer_cop_string;
            $dataitem["encodedDescription"] = htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8');
            $dataitem["program_description"] = substr(clean($data['program_description']), 0, 96);
            
            

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
                    $coupon_details = cleanData($apiRow['coupon_detail']);
                    $valid_to      = $apiRow['valid_to'];
                    $valid_from    = $apiRow['valid_from'];
                    $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"><span class="off" style=" background-color:' . $name_color . '; color:#fff;">Discount ' . $discType . '' . $apiRow['discount_amount'] . '' . $caption . ' </span></div><br>';

                    $dataitem["caption"] = $caption;
                    $dataitem["discType"] = $discType;
                    $dataitem["coupon_details"] = $coupon_details;
                    $dataitem["valid_to"] = $valid_to;
                    $dataitem["valid_from"] = $valid_from;
                    $dataitem["discount"] = "discount";
                    $dataitem["discount_amount"] = $apiRow['discount_amount'];
                    
                    break;
                }
            }

            if ($data['merchant_profileimage'] == '') {
                $data['merchant_profileimage'] = 'PerformanceAffiliateLogo.png';
                $dataitem["merchant_profileimage"] =  'PerformanceAffiliateLogo.png';
            }
            else
            {
                $dataitem["merchant_profileimage"] = cleanData($data['merchant_profileimage']);
            }
  
            // $_contents .= '<a href="#top" style="text-decoration:none;"><div class="partner-img" style="width: 100px; margin-bottom: 0px; margin-top: 50px; margin-left: 40;"><img src="' . 'https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' . $data['merchant_profileimage'] . '" style="cursor:pointer;" alt="" height="65px"></div></a><br>';
            $_contents .= '<div><a href="#top" style="text-decoration:none; color:' . $name_color . ';" onclick="PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')"><div class="partner-img" style="width: 100px; margin-bottom: 0px; margin-top: 50px; margin-left: 40;"><img src="' . 'https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' . cleanData($data['merchant_profileimage']) . '" style="cursor:pointer;" alt="" height="65px"></div><div class="partner-name" style="background-color: white; color:' . $name_color . '; white-space: pre-wrap; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;"><b>' .  $companyname . '</b></div></a>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><button onclick="PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ','.  htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8')  . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" type="button" class="btn btn-outline-chashback title" style="height:78px">' . preg_replace('/[^a-z0-9]/i', ' ', substr(clean($data['program_description']), 0, 96)) . '<i class="fas fa-caret-right"></i></button>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:' . $name_color . ';" onclick="PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8')  . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" class="PerAffterms">View</a></div></div></div>';

            $dataToSend[] = $dataitem;
         }
        $count_showmore++;
    }



    $consLimit = $consLimit - $count_showmore; // Number of records to fetch

    // # Query For Get Single Affiliate Details
    $SqlQuery = "SELECT partners_pgm_commission.* , partners_text_old.text_id,partners_joinpgm.joinpgm_id,partners_joinpgm.joinpgm_programid,partners_joinpgm.joinpgm_merchantid,
    partners_joinpgm.joinpgm_affiliateid,partners_joinpgm.joinpgm_date,partners_program.program_id,partners_program.program_status,
    partners_program.program_merchantid,partners_program.program_url,partners_program.program_description,
    partners_program.program_cookie,partners_merchant.merchant_id,partners_merchant.merchant_company,
    partners_merchant.merchant_category, partners_merchant.country_permotion,partners_merchant.merchant_currency,partners_merchant.merchant_profileimage,partners_merchant.brands,
    partners_merchant.brand_power,partners_merchant.country_permotion,partners_merchant.merchant_url
    FROM partners_merchant 
    JOIN partners_joinpgm ON partners_merchant.merchant_id = partners_joinpgm.joinpgm_merchantid
    LEFT JOIN partners_program ON partners_joinpgm.joinpgm_programid = partners_program.program_id 
    LEFT JOIN partners_text_old ON partners_joinpgm.joinpgm_programid=partners_text_old.text_programid
    LEFT JOIN partners_pgm_commission ON partners_pgm_commission.commission_programid=partners_program.program_id
    WHERE partners_merchant.merchant_status='approved'
    AND partners_program.program_status='active'
    AND partners_joinpgm.joinpgm_affiliateid='$id'
    AND partners_program.program_id NOT IN ($values)";


    $details    = mysqli_query($con, $SqlQuery);
    //$dataToSend = array();
    $hasMoreData = false;
    foreach ($details as $data) {
        $companyname = $data['merchant_company'];
        $link_url   =  getLinkUrl($data['text_id'], $id);
        $consPGM    = $data['program_id'];
        $merchantID = $data['merchant_id'];
        $country = $data['merchant_city'];
        $mer_cop_string  = getCountryOfPromotionName($merchantID);
        $encodedDescription = json_encode($data['program_description']);
        // $singleAff_curr_country = $curr_country;



        // if ($selected_curr_country !== null) {
        //     $singleAff_curr_country = $selected_curr_country;
        // }

        // $cop_matched = matchCountryOfPromotion($mer_cop_string, $singleAff_curr_country);

        // if (!$cop_matched) {
        //     $cop_matched = matchCountryOfPromotion($discount_mer_cop_string, $defaultCountry);
        // }
        if ($data['merchant_profileimage'] == '') {
            $data['merchant_profileimage'] = 'PerformanceAffiliateLogo.png';
            $dataitem["merchant_profileimage"] =  'PerformanceAffiliateLogo.png';
        }
        else{$dataitem["merchant_profileimage"] = cleanData($data['merchant_profileimage']);}

        // if ($cop_matched) {


            $dataitem["companyname"] = $companyname;
            $dataitem["link_url"] = $link_url;
            $dataitem["url_link"] = cleanData($link_url);;
            $dataitem["merchantID"] = $merchantID;
            $dataitem["country"] = $country;
            $dataitem["consPGM"] = $consPGM;
            $dataitem["discount_mer_cop_string"] = $mer_cop_string;
            $dataitem["encodedDescription"] = $encodedDescription;
            $dataitem["consLimit"] = $consLimit;
            $dataitem["without_disc"] = "without_disc";
            $dataitem["program_description"] = substr(clean($data['program_description']), 0, 96);
            
            // $dataitem["caption"] = null;
            // $dataitem["discType"] = null;
            // $dataitem["coupon_details"] = null;
            // $dataitem["valid_to"] = null;
            // $dataitem["valid_from"] = null;

            $_contents .= '<div class="col"><div class="partner-card">';
            $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"> </div><br>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><div onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer;"><div class="partner-img" style="width: 100px; margin-bottom: 0px; margin-top: 50px; margin-left: 40;"><img src="' . 'https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' . $data['merchant_profileimage'] . '" style="cursor:pointer;" alt="" height="65px"></div></div><br>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><div onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer;"><div class="partner-name" style="background-color: white; color:' . $name_color . '; white-space: pre-wrap; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;"><b>' .  $companyname . '</b></div></div>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><button onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" type="button" class="btn btn-outline-chashback title" style="height:78px">' . preg_replace('/[^a-z0-9]/i', ' ', substr(clean($data['program_description']), 0, 96)) . '<i class="fas fa-caret-right"></i></button>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><span onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer; color:' . $name_color . ';" class="PerAffterms">View</a></span>';
            $_contents .= '</div></div><span id="" style="display:none;"></span><span id="consLimit" style="display:none;">' . $consLimit . '</span>';
            $hasMoreData = true;

            $dataToSend[] = $dataitem;
        // }
    }
    $json_data = json_encode($dataToSend);
    file_put_contents($consFileName, $json_data);
    echo json_encode($dataToSend);
    die();

    //    if ($hasMoreData==true) {
    $_contents .= '<span id="consLimit" style="display:none;">' . $consLimit . '</span></div></div><center><button id="btn_showmore" class="btn PerAff-btn-view" style="background:' . $btn_color . ';" onclick="loadMore()">Show More</button></center>';
    // }

    $dataToSend["countries"] = $partnerCountries;
    $dataToSend[] = $_contents;
    $json_data = json_encode($dataToSend);
    file_put_contents($consFileName, $json_data);
    $_data = array('resData' => $_contents);
    echo json_encode($_data);
// }

?>
