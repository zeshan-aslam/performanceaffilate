<?php
ob_start();

include_once '../includes/constants.php';
include_once '../includes/functions.php';
//	include_once '../includes/session.php';
include_once '../includes/allstripslashes.php';
include_once '../includes/db-connect.php';
$AFFILIATEID    = $_SESSION['AFFILIATEID'];
// $partners = new partners;
// $partners->connection($host, $user, $pass, $db);

include_once 'language_include.php';


//==================To Update Multiple Countries from Affiliates=====================//
if ($_GET['action'] === 'multi_Country') {
    $countrylist = $_POST['countrylist'];

    //================= array_unique() => this function removes the duplicate values from the array ==================//
    if (!(in_array(2, array_unique($countrylist)))) {
        echo "Match Not found";

        $sqlDel = "DELETE FROM aff_cop WHERE `client_id` = '" . $AFFILIATEID . "'";
       $result = mysqli_query($con, $sqlDel);
       
        foreach (array_unique($countrylist) as $CountryPromo) {

            $sqlCop = "INSERT INTO `aff_cop` (`client_id` , `cop_id` )
            VALUES ('$AFFILIATEID', '$CountryPromo')";
              $res= mysqli_query($con,$sqlCop);
        }
    } else {
        echo "Match found";
        $Worldwide = 2;

        $sqlDel = "DELETE FROM aff_cop WHERE `client_id` = '" . $AFFILIATEID . "'";
        mysqli_query($con, $sqlDel);

        $sqlCop = "INSERT INTO `aff_cop` (`client_id` , `cop_id` )
        VALUES ('$AFFILIATEID', '$Worldwide')";
          $resultsec= mysqli_query($con,$sqlCop);
         
    }

    if (!(in_array(2, array_unique($countrylist)))) {
        echo "Match Not found";
        foreach (array_unique($countrylist) as $country) {
            $org_val .= $country . ',';
            $finalOrgVal = rtrim($org_val, ',');
        }
    } else {
        echo "Match found";
        $finalOrgVal = 2;
    }


    echo "<span>The country selected are :" . $finalOrgVal . "</span>";
    $sql    = " UPDATE partners_affiliate SET affiliate_country = '$finalOrgVal' where affiliate_id =$AFFILIATEID";
    $result    = mysqli_query($con, $sql);
    header("Location:index.php?Act=powered_wordsClone");
    exit;
}



//==================To Update Multiple Categories from Affiliates=====================//
if ($_GET['action'] === 'multi_Category') {
    $categorylist = $_POST['categorylist'];

    //================= array_unique() => this function removes the duplicate values from the array ==================//
    
    $sqlDel1 = "DELETE FROM aff_cates WHERE `client_id` = '" . $AFFILIATEID . "'";
    mysqli_query($con, $sqlDel1);

    foreach (array_unique($categorylist) as $category) {

        $sqlCop1 = "INSERT INTO `aff_cates` (`client_id` , `cates_id` )
        VALUES ('$AFFILIATEID', '$category')";
        $result = mysqli_query($con, $sqlCop1);
    }
    





    foreach (array_unique($categorylist) as $category) {
        $org_val .= $category . ',';
        $finalOrgVal = rtrim($org_val, ',');
    }
    echo "<span>The country selected are :" . $finalOrgVal . "</span>";
    $sql    = " UPDATE partners_affiliate SET affiliate_category = '$finalOrgVal' where affiliate_id =$AFFILIATEID";
    $result    = mysqli_query($con, $sql);
    header("Location:index.php?Act=powered_wordsClone");
    exit;
}
