<?php
session_start();
ob_start();

include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';
include_once '../includes/allstripslashes.php';

$partners = new partners;
$partners->connection($host, $user, $pass, $db);
include_once 'language_include.php';



function cleanData($value)
{
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}

if (isset($_REQUEST['confNew']) && $_REQUEST['confNew'] !=  '') {

    $host       = 'localhost';
    $user       = 'afdbuser';
    $pass       = 'tnf-@840L';
    $db         = 'db_per_aff_clone';


    // $vich    = new partners;
    // $vichNew = $vich->connection($host,$user,$pass,$db);


    $mysqli = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }


    $sql = "SELECT merchant_firstname, merchant_lastname FROM partners_merchant ORDER BY merchant_firstname";

    // if ($result = $mysqli -> query($sql)) {
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_row()) {
            printf("%s (%s)\n", $row[0], $row[1]);
        }
        $result->free_result();
    }



    $today = date('Y-m-d');
    $firstname        = cleanData($_POST['firstnametxt']);
    $lastname         = cleanData($_POST['lastnametxt']);
    $company          = cleanData($_POST['companytxt']);
    $url              = cleanData($_POST['urltxt']);
    $address          = cleanData($_POST['addresstxt']);
    $city             = cleanData($_POST['citytxt']);
    $category         = cleanData($_POST['categorylst']);
    $country          = cleanData($_POST['countrylst']);
    $phone            = cleanData($_POST['phonetxt']);
    $fax              = cleanData($_POST['faxtxt']);
    $mailid           = cleanData($_POST['mailidtxt']);
    $type             = cleanData($_POST['typelst']);
    $state            = cleanData($_POST['statetxt']);
    $zip              = cleanData($_POST['ziptxt']);
    $taxId            = cleanData($_POST['taxIdtxt']);
    $Countrypromotion            = cleanData($_POST['Countrypromotion']);




    //================= array_unique() => this function removes the duplicate values from the array ==================//

    if (!(in_array(2, array_unique($Countrypromotion)))) {
        echo "Match Not found";

        $sql1 = "DELETE FROM mer_cop WHERE `client_id` = '" . $MERCHANTID . "'";
        mysqli_query($mysqli, $sql1);

        foreach (array_unique($Countrypromotion) as $CountryPromo) {

            $sql = "INSERT INTO `mer_cop` (`client_id` , `cop_id` )
            VALUES ('$MERCHANTID', '$CountryPromo')";
            mysqli_query($mysqli, $sql);
        }
    } else {
        echo "Match found";
        $Worldwide = 2;

        $sql1 = "DELETE FROM mer_cop WHERE `client_id` = '" . $MERCHANTID . "'";
        mysqli_query($mysqli, $sql1);

        $sql = "INSERT INTO `mer_cop` (`client_id` , `cop_id` )
        VALUES ('$MERCHANTID', '$Worldwide')";
        mysqli_query($mysqli, $sql);
    }
    





    if (!(in_array(2, array_unique($Countrypromotion)))) {
        echo "Match Not found";
        foreach (array_unique($Countrypromotion) as $CountryPromo) {
            $newString .= $CountryPromo . ',';
            $countryPromoString = rtrim($newString, ',');
        }
    } else {
        echo "Match found";
        $countryPromoString = 2;
    }


    if($countryPromoString != "")
    {
        //

        $countryIds = explode(",", $countryPromoString);

        $sql    = " Delete from partners_merchant_countries where merchantid = $MERCHANTID ";
        $result = mysqli_query($mysqli, $sql);
        
        foreach($countryIds as $countryId)
        {
            $sql    = " Insert Into partners_merchant_countries (merchantid, countryid) values ($MERCHANTID, $countryId) ";
            $result    = mysqli_query($mysqli, $sql);
        }
    }


    $sql1 = "UPDATE `partners_merchant` SET `merchant_firstname` = '" . $firstname . "',
                        `merchant_lastname` = '" . $lastname . "',
                        `merchant_company` = '" . $company . "',
                        `merchant_address` = '" . $address . "',
                        `merchant_city` = '" . $city . "',
                        `merchant_country` = '" . $country . "',
                        `merchant_phone` = '" . $phone . "',
                        `merchant_url` = '" . $url . "',
                        `merchant_category` = '" . $category . "',
                        `merchant_date` = '" . $today . "',
                        `merchant_fax` = '" . $fax . "',
                        `merchant_state` = '" . $state . "',
                        `merchant_zip` = '" . $zip . "',
                        `merchant_taxId` = '" . $taxId . "',
                        `merchant_type` = '" . $type . "',
                        `country_permotion` = '" . $countryPromoString . "' WHERE `merchant_id` = '" . $MERCHANTID . "'";

    mysqli_query($mysqli, $sql1);

    $msg = $lang_success_message;
    header("Location:index.php?Act=accounts&suc_msg=$msg");
} else {





    $mode        = $_GET['mode'];
    $firstname            = $_POST['firstnametxt'];
    $lastname           = $_POST['lastnametxt'];
    $company            = $_POST['companytxt'];
    $url                = $_POST['urltxt'];
    $address            = $_POST['addresstxt'];
    $city               = $_POST['citytxt'];
    $category            = $_POST['categorylst'];
    $phone              = $_POST['phonetxt'];
    $fax                = $_POST['faxtxt'];
    $mailid             = $_POST['emailidtxt'];
    $type               = $_POST['typelst'];
    $country            = $_POST['countrylst'];
    $state              = stripslashes(trim($_POST['statetxt']));
    $zip            = stripslashes(trim($_POST['ziptxt']));
    $taxId              = stripslashes(trim($_POST['taxIdtxt']));
    $status               = $_POST['status'];
    $today = date("Y-m-d");



    if ($_POST["Upgrade"]) {
        // UPgrading

        $id     = $_SESSION['MERCHANTID'];
        //Added By DPT on July/10/05
        //If advanced amount is 0 then the user need not be taken to the payment gateway
        if ($advanced_user == 0) {
            //update user account status
            $sql        = "UPDATE `partners_merchant` SET merchant_type='advance' where `merchant_id` = '$id'";
            mysqli_query($con, $sql);
            $msg1    = "Upgraded Successfully";
            header("Location:index.php?Act=accounts&msg1=$msg1");
            exit;
        } else {

            $amount    = $advanced_user - $normal_user;
            Header("Location:index.php?Act=upgrade&id=$id&amount=$amount");
            exit;
        }
    }


    if (empty($firstname))
        $err = "1";
    else
        $err = "0";


    if (empty($lastname))
        $err .= ".1";

    else
        $err .= ".0";


    if (empty($company))
        $err .= ".1";

    else
        $err .= ".0";

    if (empty($url))
        $err .= ".1";

    else
        $err .= ".0";

    if (empty($address))
        $err .= ".1";

    else
        $err .= ".0";

    if (empty($city))
        $err .= ".1";

    else
        $err .= ".0";

    if (empty($phone))
        $err .= ".1";

    else
        $err .= ".0";

    if (empty($fax))
        $err .= ".1";

    else
        $err .= ".0";


    if ($category == "nill" || $type == "nill" || $country == "nill")

        $err .= ".1";

    else
        $err .= ".0";


    if (empty($taxId))
        $err .= ".1";
    else
        $err .= ".0";

    if (empty($zip))
        $err .= ".1";
    else
        $err .= ".0";

    if (empty($state))
        $err .= ".1";
    else
        $err .= ".0";


    $_SESSION['MER_ADDRESS'] = $address;
    if ($err != "0.0.0.0.0.0.0.0.0.0.0.0") {

        $msg = $lang_invalid;
        // $_SESSION['MERADD']=$address;
        $sub = "submitted";


        $firstname        = stripslashes(trim($_POST['firstnametxt']));
        $lastname         = stripslashes(trim($_POST['lastnametxt']));
        $company          = stripslashes(trim($_POST['companytxt']));
        $url              = stripslashes(trim($_POST['urltxt']));
        $address          = stripslashes(trim($_POST['addresstxt']));
        $city             = stripslashes(trim($_POST['citytxt']));
        $category         = stripslashes(trim($_POST['categorylst']));
        $phone            = stripslashes(trim($_POST['phonetxt']));
        $fax              = stripslashes(trim($_POST['faxtxt']));
        $mailid           = stripslashes(trim($_POST['mailidtxt']));
        $type             = stripslashes(trim($_POST['typelst']));
        $state            = stripslashes(trim($_POST['statetxt']));
        $zip              = stripslashes(trim($_POST['ziptxt']));
        $taxId            = stripslashes(trim($_POST['taxIdtxt']));

        // header("Location:index.php?Act=accounts&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&address=$address&mailid=$mailid&type=$type&country=$country&state=$state&zip=$zip&taxId=$taxId&sub=$sub");
        //exit;
    }


    $firstname        = addslashes(trim($_POST['firstnametxt']));
    $lastname         = addslashes(trim($_POST['lastnametxt']));
    $company          = addslashes(trim($_POST['companytxt']));
    $url              = addslashes(trim($_POST['urltxt']));
    $address          = addslashes(trim($_POST['addresstxt']));
    $city             = addslashes(trim($_POST['citytxt']));
    $category         = addslashes(trim($_POST['categorylst']));
    $phone            = addslashes(trim($_POST['phonetxt']));
    $fax              = addslashes(trim($_POST['faxtxt']));
    $mailid           = addslashes(trim($_POST['mailidtxt']));
    $type             = addslashes(trim($_POST['typelst']));
    $state            = addslashes(trim($_POST['statetxt']));
    $zip              = addslashes(trim($_POST['ziptxt']));
    $taxId            = addslashes(trim($_POST['taxIdtxt']));


    echo $sql1 = "UPDATE `partners_merchant` SET `merchant_firstname` = '$firstname',
          `merchant_lastname` = '$lastname',
          `merchant_company` = '$company',
          `merchant_address` = '$address',
          `merchant_city` = '$city',
          `merchant_country` = '$country',
          `merchant_phone` = '$phone',
          `merchant_url` = '$url',
          `merchant_category` = '$category',
          `merchant_date` = '$today',
          `merchant_fax` = '$fax',
          `merchant_state` = '$state',
          `merchant_zip` = '$zip',
          `merchant_taxId` = '$taxId',
          `merchant_type` = '$type' WHERE `merchant_id` = '$MERCHANTID'";
    $result = mysqli_query($con, $sql1);
    mysqli_error($con);
    $msg = $lang_success_message;


    //     $firstname        = stripslashes(trim($_POST['firstnametxt']));
    //     $lastname         = stripslashes(trim($_POST['lastnametxt']));
    //     $company          = stripslashes(trim($_POST['companytxt']));
    //     $url              = stripslashes(trim($_POST['urltxt']));
    //     $address          = stripslashes(trim($_POST['addresstxt']));
    //     $city             = stripslashes(trim($_POST['citytxt']));
    //     $category         = stripslashes(trim($_POST['categorylst']));
    //     $phone            = stripslashes(trim($_POST['phonetxt']));
    //     $fax              = stripslashes(trim($_POST['faxtxt']));
    //     $mailid           = stripslashes(trim($_POST['mailidtxt']));
    //     $type             = stripslashes(trim($_POST['typelst']));
    //     $state            = stripslashes(trim($_POST['statetxt']));
    //     $zip              = stripslashes(trim($_POST['ziptxt']));
    //     $taxId            = stripslashes(trim($_POST['taxIdtxt']));

    $sub = "submitted";
    //$_SESSION['MER_ADDRESS'] = "";

    header("Location:index.php?Act=accounts&suc_msg=$msg");
    exit;
}
