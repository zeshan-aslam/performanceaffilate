<?php
include_once 'includes/db-connect.php';
include_once 'includes/session.php';
header("Cache-control: private");
include_once 'includes/constants.php';
include_once 'includes/functions.php';
include_once 'includes/allstripslashes.php';

$msg = $_REQUEST['msg'];
$partners   = new partners;

$Act = isset($_GET['Act']) ? $_GET['Act'] : "";
if (!empty($_POST['languageid'])) $_SESSION['LANGUAGE'] = intval($_POST['languageid']);

# For language
$language   = $_SESSION['LANGUAGE'];
if (empty($language))
  $lang   = "english";
else {
  # Get langauge
  $sqllang    = " SELECT * FROM partners_languages WHERE languages_id = '$language'";
  $reslang    = mysqli_query($con, $sqllang);
  if ($rowlang = mysqli_fetch_object($reslang))
    $lang   = strtolower(trim(stripslashes($rowlang->languages_name)));

  # langauge file name
  $filename   = "lang/" . $lang . ".php";

  # check whether file exists
  if (!file_exists($filename)) {
    $lang   = "english";
    $language = "";
  }
}
require("lang/" . $lang . ".php");

# Getting Default currency Details
$currency_code  = $default_currency_code;
$cur_sql        = " SELECT * FROM partners_currency WHERE currency_code = '$currency_code' ";
$res_cur        = mysqli_query($con, $cur_sql);

if (mysqli_num_rows($res_cur) > 0) {
  $row_cur = mysqli_fetch_object($res_cur);
  $currSymbol = stripslashes($row_cur->currency_symbol);
  $_SESSION['DEFAULTCURRENCYSYMBOL'] = $currSymbol;
  $currValue  = stripslashes($row_cur->currency_caption);
  $currCode   = stripslashes($row_cur->currency_code);
}
//...............................Fetch Title.................................
$title_query = " SELECT * FROM site_title where status='active'";
$title_content = mysqli_query($con, $title_query);
$site_title = mysqli_fetch_assoc($title_content);
//...........................................................................
$header_query = "SELECT * FROM  header_content where haeder_status='active'";
$header = mysqli_query($con, $header_query);
$header_rows = mysqli_fetch_assoc($header);
/*................... For Fetch Navbar Content.............................*/

$navbar_query = " SELECT * FROM  navbar_content";
$navbar = mysqli_query($con, $navbar_query);
/*.....................End Navbar Content................................*/


/*................... For Fetch Slider Content.............................*/

$silder_query = " SELECT * FROM  slider_content";
$slider_result = mysqli_query($con, $silder_query);
$silder_content = " SELECT * FROM  slider_content";
$slider_new = mysqli_query($con, $silder_content);
/*.....................End Slider Content................................*/

/*................... For Fetch Services Content.............................*/
$service_query = "SELECT * FROM  services_content where services_status='active'";
$services = mysqli_query($con, $service_query);
$services_row = mysqli_fetch_assoc($services);
$services_query = " SELECT * FROM  services_card";
$services_result = mysqli_query($con, $services_query);

/*.....................End Services Content................................*/

/*................... For Fetch Searlco_Network Content.............................*/

$network_query = "SELECT * FROM  searlco_network_content where network_status='active'";
$network = mysqli_query($con, $network_query);
$network_row = mysqli_fetch_assoc($network);
$searlco_query = " SELECT * FROM searlco_network_card";
$searlco_result = mysqli_query($con, $searlco_query);

/*.....................End Searlco_Network Content................................*/

/*................... For Fetch Features Content.............................*/

$features_content = " SELECT * FROM features_content where features_status='active'";
$features_content = mysqli_query($con, $features_content);
$features_row = mysqli_fetch_assoc($features_content);
$features_query = " SELECT * FROM features_card";
$features_result = mysqli_query($con, $features_query);

/*.....................End Features Content................................*/

/*................... For Fetch Standard Content.............................*/

$standard = " SELECT * FROM benefits_content where benefits_status='active'";
$standar_content = mysqli_query($con, $standard);
$stand_row = mysqli_fetch_assoc($standar_content);
$standard_query = " SELECT * FROM benefits_card";
$standard_result = mysqli_query($con, $standard_query);

/*.....................End Standard Content................................*/

/*................... For Fetch TRUSTED BRANDS Content.............................*/

$trusted_brands = " SELECT * FROM trusted_brands_content where trusted_status='active'";
$trusted_brands = mysqli_query($con, $trusted_brands);
$trusted_row = mysqli_fetch_assoc($trusted_brands);
$trusted_query = " SELECT * FROM trusted_brands_card";
$trusted_result = mysqli_query($con, $trusted_query);

/*.....................End TRUSTED BY BRANDS Content................................*/
/*................... For Fetch Contact Us Content.............................*/

$contact_brands = " SELECT * FROM contact_us_content where contact_status='active'";
$contact_brands = mysqli_query($con, $contact_brands);
$contact_row = mysqli_fetch_assoc($contact_brands);
//  $contact_query = " SELECT * FROM contact_content";
//  $contact_result = mysqli_query($con, $contact_query);

/*.....................End Contact Us Content................................*/
//  /*................... For Fetch Footer Content.............................*/

//  $footer_brands = " SELECT * FROM footer_content ORDER BY id DESC LIMIT 1";
//  $footer_brands = mysqli_query($con, $footer_brands);
//  $footer_row = mysqli_fetch_assoc($footer_brands);
//  /*.....................End Footer Content................................*/


# daily procedures
include_once 'dailyroutine.php';
ChangeStaus($minimum_amount);
getProgramFee();
setPending();
payMembership();
setMemPending();

# Remove this when cron job is set for this file
# include_once "cron/dailyjobs_anp.php";
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="icon" type="image/x-icon" href="newAssets/images/favicon.png">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
  <link rel="stylesheet" href="newAssets/owl/owl.carousel.min.css?v=2">
  <link rel="stylesheet" href="newAssets/owl/owl.theme.default.min.css">
  <link rel="stylesheet" href="newAssets/css/bootstrap.min.css">
  <link rel="stylesheet" href="newAssets/css/style.css">
  <link rel="stylesheet" href="newAssets/css/responsive.css">




  <!--Start To add multiple tags for brand names at merchant dashboard/profile  -->
  <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
  <link href="checkToken/dist/tokenize2.min.css" rel="stylesheet" />
  <link href="checkToken/demo/demo.css" rel="stylesheet" />
  <script src="checkToken/dist/tokenize2.min.js"></script>
  <!--End To add multiple tags for brand names at merchant dashboard/profile  -->



  <title><?= $site_title["title"] ?></title>
  <style>
    .error {
      color: red !important;
    }

    #login-error {
      color: red !important;
    }

    #password-error {
      color: red !important;
    }

    #optradio-error {
      color: red !important;
    }
  </style>
  <meta name='ir-site-verification-token' value='1922220574'>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light nav-sticky">
    <div class="container">

      <!-- <a class="navbar-brand logo" href="index.php"><img src="newAssets/images/logo.png" alt=""></a> -->
      <a class="navbar-brand logo" href="index.php"><img src="https://www.performanceaffiliate.com/Admin/public/testimg/<?= $header_rows["logo"] ?>" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php while ($nav_row = mysqli_fetch_array($navbar)) {
            if ($nav_row["menu_name"] === 'GDPR') {
          ?>
              <li class="nav-item nav-item-cus">
                <a class="nav-link nav-link-cus" href="#" data-bs-toggle="modal" data-bs-target="#gdprModal">GDPR</a>
              </li>
            <?php
            } else {
            ?>
              <li class="nav-item nav-item-cus">
                <a class="nav-link nav-link-cus" aria-current="page" href="<?= ($nav_row["href"]) ?>"><?= strtoupper($nav_row["menu_name"]) ?></a>
              </li>
          <?php
            }
          } ?>

        </ul>
        <form class="nav-btn d-flex">
          <button type="button" class="btn bnt-common me-3" data-bs-toggle="modal" data-bs-target="#loginModal"><?= strtoupper($header_rows["login"]) ?></button>
          <a class="btn bnt-common2" href="signup.php"><?= strtoupper($header_rows["signup"]) ?></a>
          <a class="btn bnt-common2" href="mer_wizardSignUp.php">Setup Begin</a>
        </form>
      </div>
    </div>
  </nav>

  <main id="home" role="main">