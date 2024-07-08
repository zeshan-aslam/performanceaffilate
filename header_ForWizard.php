<?php
include_once 'includes/db-connect.php';
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
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/x-icon" href="newAssets/images/favicon.png">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css"> -->
  <link rel="stylesheet" href="newAssets/owl/owl.carousel.min.css?v=2">
  <link rel="stylesheet" href="newAssets/owl/owl.theme.default.min.css">
  <link rel="stylesheet" href="newAssets/css/bootstrap.min.css">


  <link rel="stylesheet" href="newAssets/css/style.css">
  <link rel="stylesheet" href="newAssets/css/responsive.css">
  <title><?= $site_title["title"] ?></title>




  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <!-- Latest compiled and minified CSS -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>


  <!--Start To add multiple tags for brand names at merchant dashboard/profile  -->
  <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
  <link href="checkToken/dist/tokenize2.min.css" rel="stylesheet" />
  <!-- <link href="checkToken/demo/demo.css" rel="stylesheet" /> -->
  <script src="checkToken/dist/tokenize2.min.js"></script>
  <!--End To add multiple tags for brand names at merchant dashboard/profile  -->


  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background-color: #f1f1f1;
    }

    #regForm {
      background-color: #ffffff;
      margin: 100px auto;
      font-family: Raleway;
      padding: 40px;
      width: 50%;
      min-width: 300px;
      border: 1px solid;
      box-shadow: 5px 10px #888888;
    }

    h1 {
      text-align: center;
      background-color: MediumSeaGreen;
      color: white;
      padding: 20px;
    }

    input {
      padding: 10px;
      width: 100%;
      font-size: 17px;
      font-family: Raleway;
      border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
      background-color: #ffdddd;
    }

    textarea.invalid {
      background-color: #ffdddd;
    }

    select.invalid {
      background-color: #ffdddd;
    }

    ul.invalid {
      background-color: #ffdddd;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }


    /* Hide all steps by default: */
    .tab {
      display: none;
    }

    button {
      background-color: #04AA6D;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      font-size: 17px;
      font-family: Raleway;
      cursor: pointer;
    }

    button:hover {
      opacity: 0.8;
    }

    #prevBtn {
      background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
      font-size: 10px;
      font-family: 'Times New Roman';
      height: 10px;
      width: 60px;
      margin: 0 2px;
      background-color: MediumSeaGreen;
      border: none;
      /* border-radius: 10%; */
      display: inline-block;
      opacity: 0.5;
    }

    .step.active {
      opacity: 2;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
      background-color: #04AA6D;
    }

    /* mouse over  */
    div.test_pgm:hover {
      background: MediumSeaGreen;
    }

    div.test_pgm:hover h2 {
      color: white;
    }

    h4,
    p {
      padding: 5px;
    }

    a {
      color: #5898e7;
    }

    /* To show an information icon with the Response message */
    .icon {
      font-size: 120px;
      text-align: center;
      margin: 0 auto;
      display: block;
      color: #00e676;

    }
  </style>







  <style>
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
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light nav-sticky" style="background:#000">
    <div class="container">
      <!-- <a class="navbar-brand logo" href="index.php"><img src="newAssets/images/logo.png" alt=""></a> -->
      <a class="navbar-brand logo" href="index.php"><img src="https://performanceaffiliate.com/Admin/public/testimg/<?= $header_rows["logo"] ?>" alt=""></a>
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
                <a class="nav-link nav-link-cus" aria-current="page" href="index.php"><?= strtoupper($nav_row["menu_name"]) ?></a>
              </li>
          <?php
            }
          } ?>

        </ul>
        <form class="nav-btn d-flex">
          <button type="button" class="btn bnt-common me-3" data-bs-toggle="modal" data-bs-target="#loginModal"><?= strtoupper($header_rows["login"]) ?></button>
          <a class="btn bnt-common2" href="signup.php"><?= strtoupper($header_rows["signup"]) ?></a>
        </form>
      </div>
    </div>
  </nav>