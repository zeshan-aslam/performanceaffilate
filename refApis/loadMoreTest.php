
<?php
header("Access-Control-Allow-Origin: *");
include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';
include_once '../includes/oneTime_dataFetch.php';
// include_once '../locate.php';
$affiliate_id = $_REQUEST['MADKAI']; # affiliate id
$id = MultipleTimeDecode($affiliate_id);
$consLimit  = $_GET['consLimit'];


// $_contents .= '<input id="consLimit" value="11" style="display:none;"/>';

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
    // $consLimit = 30;
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
    AND partners_program.program_id NOT IN ($values)
    AND FIND_IN_SET('$selectedCountryID', partners_merchant.country_permotion) LIMIT $consLimit";


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
            $dataitem["merchant_profileimage"] =  'PerformanceAffiliateLogo.png';
        }
        else{$dataitem["merchant_profileimage"] = cleanData($data['merchant_profileimage']);}

        if ($cop_matched) {


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
        }
    }

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

?>
