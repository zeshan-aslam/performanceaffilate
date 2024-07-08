
<?php
header("Access-Control-Allow-Origin: *");
include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';
include_once '../includes/oneTime_dataFetch.php';
// include_once '../locate.php';

$id = MultipleTimeDecode($affiliate_id);
$consLimit  = $_GET['consLimit'];

if ($id != "" && isset($_GET['consLimit']) && $_GET['consLimit'] != '') {
    $recordCounter = 0;
    # Coupon Code for discount PerAff 
    $api_url = "https://performanceaffiliate.com/performanceAffiliateClone/affiliates/couponApi.php?_token=ecnrtp45jade&CONSAFF=VmtjeGQxVnNRbEpRVkRBOQ==";
    // Read JSON file
    $json_data = file_get_contents($api_url);
    // Decode JSON data into PHP array 
    $response_data = json_decode($json_data, true);

    $unique_data = array_unique($response_data, SORT_REGULAR); // Remove duplicate rows
    $single_row = reset($unique_data); // Get the first (and only) row

    $programIds = array();
    foreach ($unique_data as $apiRow) {
        $coupon_details = $apiRow['coupon_detail'];
        $valid_to = $apiRow['valid_to'];
        $valid_from = $apiRow['valid_from'];
        $programIds[] = $apiRow['program_id'];
    }
    $values = implode(",", $programIds);

    if (empty($selectedCountryID)) {
        $selectedCountryID = 1;
    }
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
    AND FIND_IN_SET('$selectedCountryID', partners_merchant.country_permotion) LIMIT $consLimit";


    $details    = mysqli_query($con, $SqlQuery);
    $dataToSend = array();
    $greatestDiscount = 0;
    // $flag = false;
    $count_showmore = 0;
    foreach ($details as $data) {
        if ($count_showmore < 30) {
            $companyname = $data['merchant_company'];
            $link_url   =  getLinkUrl($data['text_id'], $id);
            $url_link   = cleanData($link_url);
            $merchantID = $data['merchant_id'];
            $country    = $data['merchant_city'];
            $consPGM    = $data['program_id'];
            $discount_mer_cop_string  = getCountryOfPromotionName($merchantID);
            $encodedDescription = json_encode($data['program_description']);
            $_contents .= '<div class="col"> <div class="partner-card" style="display: grid;">';

            foreach ($response_data as $apiRow) {
                $discountAmount = $apiRow['discount_amount'];
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
                    $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"><span class="off" style=" background-color:' . $name_color . '; color:#fff;">Discount ' . $discType . '' . $apiRow['discount_amount'] . '' . $caption . ' </span><span></span></div><br>';
                    break;
                }
            }
            if ($data['merchant_profileimage'] == '') {
                $data['merchant_profileimage'] = 'PerformanceAffiliateLogo.png';
            }
            
            $_contents .= '<div><a href="#top" style="text-decoration:none; color:' . $name_color . ';" onclick="PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ','.  htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8')  . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')"><div class="partner-img"><img src="' . 'https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' . cleanData($data['merchant_profileimage']) . '" style="cursor:pointer;"></div><div class="partner-name" style="background-color: white; color:' . $name_color . '; white-space: pre-wrap; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;"><b>' .  $companyname . '</b></div></a>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><button onclick="PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ','.  htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8')  . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" type="button" class="btn btn-outline-chashback title" style="height:78px">' . preg_replace('/[^a-z0-9]/i', ' ', substr(clean($data['program_description']), 0, 96)) . '<i class="fas fa-caret-right"></i></button>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:' . $name_color . ';" onclick="PerAff_s_Brand_Disc(' . "'" . cleanData($data['merchant_profileimage']) . "'" . ',' . "'" . $coupon_details . "'" . ',' . "'" . $valid_to . "'" . ',' . "'" . $valid_from . "'" . ','.  htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8')  . ',' . "'" . $url_link . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" class="PerAffterms">View</a></div></div></div>';
         }
        $recordCounter++;
    }

    // #check if the json file exists for this affiliate 
    $consLimit = $consLimit - $recordCounter;
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
    AND partners_program.program_id NOT IN ($values)
    AND FIND_IN_SET('$selectedCountryID', partners_merchant.country_permotion) LIMIT $consLimit";


    $details    = mysqli_query($con, $SqlQuery);
    $dataToSend = array();

    foreach ($details as $data) {
        $companyname = $data['merchant_company'];
        $link_url   =  getLinkUrl($data['text_id'], $id);
        $consPGM    = $data['program_id'];
        $merchantID = $data['merchant_id'];
        $country = $data['merchant_city'];
        $mer_cop_string  = getCountryOfPromotionName($merchantID);
        $encodedDescription = json_encode($data['program_description']);
        $singleAff_curr_country = $curr_country;

        if ($selected_curr_country !== null) {
            $singleAff_curr_country = $selected_curr_country;
        }

        $cop_matched = matchCountryOfPromotion($mer_cop_string, $singleAff_curr_country);

        if (!$cop_matched) {
            $cop_matched = matchCountryOfPromotion($discount_mer_cop_string, $defaultCountry);
        }
        if ($data['merchant_profileimage'] == '') {
            $data['merchant_profileimage'] = 'PerformanceAffiliateLogo.png';
        }
        if ($cop_matched) {
            $_contents .= '<div class="col"><div class="partner-card">';
            if($data['merchant_profileimage'] != 'PerformanceAffiliateLogo.png'){
                $_contents .= '<div class="flat-code" style="margin-bottom:-23px;"> </div><br>';}
                else{$_contents .= '<div class="flat-code" style="margin-top:63px;margin-bottom:-23px;"></div><br>';}
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><div onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer;"><div class="partner-img" style="margin-top: 25px;margin-bottom: -25px;"><img src="' . 'https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' . $data['merchant_profileimage'] . '" style="cursor:pointer;"></div></div><br>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><div onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer;"><div class="partner-name" style="background-color: white; color:' . $name_color . '; white-space: pre-wrap; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;"><b>' .  $companyname . '</b></div></div>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><button onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" type="button" class="btn btn-outline-chashback title" style="height:78px">' . preg_replace('/[^a-z0-9]/i', ' ', substr(clean($data['program_description']), 0, 96)) . '<i class="fas fa-caret-right"></i></button>';
            $_contents .= '<a href="#top" style="cursor:pointer; text-decoration:none; color:#b57bc0;"><span onclick="PerAff_s_Brand(' . "'" . $data['merchant_profileimage'] . "'" . ',' . "'" . $data['merchant_company'] . "'" . ',' . htmlspecialchars($encodedDescription, ENT_QUOTES, 'UTF-8') . ',' . "'" . $link_url . "'" . ',' . "'" . $btn_color . "'" . ',' . "'" . $name_color . "'" . ')" style="cursor: pointer; color:' . $name_color . ';" class="PerAffterms">View</a></span>';
            $_contents .= '</div></div><span id="" style="display:none;"></span><span id="consLimit" style="display:none;">' . $consLimit . '</span>';
        }

        $recordCounter++;
    }

    $dataToSend[] = $_contents;
    $json_data = json_encode($dataToSend);
    file_put_contents($consFileName, $json_data);

    if ($_contents == null) {
        $_contents = "Sorry no results found, Please select a different country";
    }

    $_data = array(
        'resData' => $_contents,
        'limitReturned' => intval($consLimit),
        'recordCounted' => intval($recordCounter)
    );
    echo json_encode($_data);
}
?>
