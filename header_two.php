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
  <link rel="stylesheet" href="newAssets/owl/owl.carousel.min.css?v=2">
  <link rel="stylesheet" href="newAssets/owl/owl.theme.default.min.css">
  <link rel="stylesheet" href="newAssets/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->

  <link rel="stylesheet" href="newAssets/css/style.css">
  <link rel="stylesheet" href="newAssets/css/responsive.css">
  <title><?= $site_title["title"] ?></title>
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