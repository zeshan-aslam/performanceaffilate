<?php
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
include_once '../includes/encode_decodeFunction.php';
$aff_id       = $_SESSION['AFFILIATEID'];
#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------
$AFFILIATEID;
//  echo$Person_logged_In;
$affEcrptid = MultipleTimeEncode($AFFILIATEID);

?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<!-- Instruction of Use Code Mall Front -->
<div class="container">
  <div class="row">
    <div class="col card stacked-form trackcode_form mb-4">
      <div class="card-body">
        <h4 class="card-title"><strong>How to use the Discount Hunter Extension:</strong> </h4>
        <ol>
          <li>Download and install the extension using the link provided below.</li>
          <li>Browse as you normally would.</li>
          <li>If Discount Hunter recognizes the URL you are on it will provide you with discounts and offers that are currently available.</li>
          <li>Use the "Get Deal" button to get the offer that is available. If there is a coupon available it will get copied to your Clipboard.</li>
          <li>Share your URL with other affiliates or add it to your website.</li>
        </ol>
      </div>
    </div>
    <div class="col card stacked-form trackcode_form p-5 mb-4">
      <div class="card-body">
        <!-- <iframe controls id="myvideo" src="https://www.youtube.com/embed/as2GrTjELEk" title="PoweredWords how To Guide" width="400" height="250"> -->
        <iframe width="400" height="250" src="https://www.youtube.com/embed/EnUQ94qJUWg" title="MallFront how To Guide" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </iframe>
        <button onclick="openFullscreen();">Open Video in Fullscreen Mode</button>
        <p><strong>Tip:</strong> Press the "Esc" key to exit full screen.</p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card stacked-form trackcode_form">
      <div class="card-body">
        <h3 class="card-title" style="padding-bottom: 18px;"><strong>Discount Hunter Extension Link</strong></h3>
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <div class="form-group text-center">
              Copy this link and share it with other affiliates or add it to your website
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group text-center">
              <a href="https://chrome.google.com/webstore/detail/performance-affiliate/hghginboiiiddkhelfolmkamlngjhpcm?&ets=<?= $aff_id ?>">https://chrome.google.com/webstore/detail/performance-affiliate/hghginboiiiddkhelfolmkamlngjhpcm?&ets=<?= $aff_id ?></a>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>





<!-- Script -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
<script>
  $(document).ready(function() {
    $('.color-input').spectrum({
      showInitial: true,
      showPalette: false,
      preferredFormat: "hex",
      showInput: true,
    });
  });
</script>
<!-- Script to play Mall Front video instruction on Full Screen -->
<style>
  /* arrow */
  .fa-long-arrow-up {
    float: right;
    color: red;
    margin-right: 32px;
  }

  .visit-arrow {
    color: #ff0000;
    margin-left: 81%;
    margin-top: -11%;
  }

  .right-arrow {
    color: #ff0000;
    margin-left: 70%;
  }

  /* arrow */
  .search-btn {
    background: <?= $lastsercolor ?>;
    color: #fff;
  }

  .btn-info {
    color: #fff;
  }

  .xt-blog-form {
    margin-top: 50px;
  }

  .input-group-btn .btn {
    border-width: 1px;
    padding: 12px 13px;
  }

  .perAffcard {
    width: 200px;
    height: 280px;
    border: 1px solid #ddd;
    box-shadow: 2px 2px 5px #ddd;
    padding: 20px;
    border-radius: 12px 0 0;
    box-sizing: border-box;
    position: relative;
    float: right;
    margin-top: -55px;
  }

  .perAffdiscount-label {
    position: absolute;
    top: 0px;
    left: 0px;
    background-color: <?= $lastNamecolor ?>;
    color: #fff;
    font-size: 12px;
    padding: 2px 10px;
    border-radius: 12px 0 0;
  }

  .perAffpro-img {
    /* width: 50%;
  height: 100px; */
    object-fit: cover;

  }

  .perAffproduct-name {
    margin-top: 10px;
    font-size: 20px;
    font-weight: bold;
    color: <?= $lastNamecolor ?>;
  }

  .perAffproduct-description {
    margin-top: 10px;
    font-size: 12px;
  }

  .perAffview-button {
    margin-top: 20px;
    color: <?= $lastNamecolor ?>;
    text-decoration: none;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    cursor: pointer;
  }
</style>