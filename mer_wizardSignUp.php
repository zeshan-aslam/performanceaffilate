<?php
// header("Access-Control-Allow-Origin: *");


include('header_ForWizard.php');
include_once 'includes/encode_decodeFunction.php';

?>
<?php
// $mid = 18;
// $aid = 61;
$encrypted_mid = $_GET['mid'];
$decrypted_mid = MultipleTimeDecode($encrypted_mid);

$mid = $decrypted_mid;
// $mid = 18;
$aid = 7;

// echo "Merchant decoded id".$mid;


$mer_sql     = "select *  from partners_merchant where merchant_id ='$mid'";
$mer_data = mysqli_query($con, $mer_sql);
while ($row = mysqli_fetch_object($mer_data)) {
    $firstname                        = stripslashes(trim($row->merchant_firstname));
    $merchant_profileimage            = stripslashes(trim($row->merchant_profileimage));
    $lastname                         = stripslashes(trim($row->merchant_lastname));
    $company                          = stripslashes(trim($row->merchant_company));
    $url                              = stripslashes(trim($row->merchant_url));
    $address                          = stripslashes(trim($row->merchant_address));
    $category                         = stripslashes(trim($row->merchant_category));
    $phone                            = stripslashes(trim($row->merchant_phone));
    $fax                              = stripslashes(trim($row->merchant_fax));
    $type                             = stripslashes(trim($row->merchant_type));
    $city                             = stripslashes(trim($row->merchant_city));
    $mer_country                      = stripslashes(trim($row->merchant_country));
    $status                           = stripslashes(trim($row->merchant_status));
    $state                            = stripslashes(trim($row->merchant_state));
    $zip                              = stripslashes(trim($row->merchant_zip));
    $taxId                            = stripslashes(trim($row->merchant_taxId));
    $brand                            = stripslashes(trim($row->brands));
    $brandpower                       = stripslashes(trim($row->brand_power));
    $countryPermotion                 = stripslashes(trim($row->country_permotion));
    $merchant_currency                = stripslashes(trim($row->merchant_currency));
    $randNo                           = trim($row->merchant_randNo);
    $orderid                          = trim($row->merchant_orderId);
    $saleamt                          = trim($row->merchant_saleAmt);
}
$brandArray = explode('|', $brand);


$sql = "SELECT * FROM partners_text_old,partners_joinpgm  where	text_status ='active' and joinpgm_affiliateid = $aid AND joinpgm_status = 'approved' AND joinpgm_programid=text_programid  AND joinpgm_merchantid=$mid";
$link_data = mysqli_query($con, $sql);
while ($row = mysqli_fetch_object($link_data)) {

    $linkid                 = stripslashes(trim($row->text_id));
}
?>
<!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
<?php
if ($mid !== '') {
?>


    <form id="regForm" enctype="multipart/form-data" method="post">
        <!-- One "tab" for each step in the form: -->
        <div class="tab">
            <h1>Step 1 : Commissions</h1>
            <ul class="nav nav-tabs nav-justified m-1">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Your Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#"></a>
                </li>
            </ul>
            <!-- <hr /> -->
            <div class="row">
                <div class="col-md-12">
                    <div id="sales_commission" class="container p-2 my-3 border text-black rounded test_pgm">
                        <div class="row">
                            <div class="col-6 border-right">
                                <h2 class="p-4">Sales Program</h2>
                            </div>
                            <div class="col-6 text-black p-2">I'm accepting and taking customer orders online through my e-commerce platform.</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="lead_commission" class="container p-2 my-3 border text-black rounded test_pgm">
                        <div class="row">
                            <div class="col-6 border-right">
                                <h2 class="p-4">Lead Program</h2>
                            </div>
                            <div class="col-6 text-black p-2">I have a trial signup, newsletter subscription, qoute request or other free user information collection.</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="sales_detail" style="display:none;">
                    <h4 style="color:dodgerblue"><b>Select your program's commission payout:</b></h4>
                    <h4><b>Sale Commission</b></h4>
                    <p>A Sale Commission is one paid to your Affiliate when they send you actual completed sale on your e-commerce website. </p>
                    <p>Please state your commission percentage in whole numbers (i.e. 10 = 10%) or select the flat amount button and enter the amount of money to be given per sale.</p>

                    <div class="col-md-12">
                        <h4 style="color:dodgerblue;display:inline;">Per Sale Amount:</h4>
                        <h4 style="color:dodgerblue;display: none;" name="sale_currency" id="sale_currency" value="<?php echo $merchant_currency ?>">
                            <?php

                            if ($merchant_currency == "Dollar") {
                                echo "$";
                            } elseif ($merchant_currency == "Pound") {
                                echo "£";
                            } elseif ($merchant_currency == "Euro") {
                                echo "€";
                            }

                            ?>
                        </h4>
                        <input class="form-control" style="width:20%; display: inline;" type="number" oninput="this.classList.remove('invalid')= ''" id="sales_amount" name="sales_amount" min="0" value="0" onkeypress="return CheckNumeric(event);">
                        <h4 style="color:dodgerblue;display: inline;" name="sale_percentageAmount" id="sale_percentage" value="%">%</h4>
                    </div>

                    <div class="col-md-12 p-4">
                        <div class="form-check p-1">
                            <input class="form-check-input" type="radio" name="SaleAmountType" id="Sale_percentageType" value="%" checked>
                            <label class="form-check-label" for="percentageRate">
                                This is a percentage value.
                            </label>
                        </div>
                        <div class="form-check p-1">
                            <input class="form-check-input" type="radio" name="SaleAmountType" id="Sale_flatType" value="<?php if ($merchant_currency == "Dollar") {
                                                                                                                                echo "$";
                                                                                                                            } elseif ($merchant_currency == "Pound") {
                                                                                                                                echo "£";
                                                                                                                            } elseif ($merchant_currency == "Euro") {
                                                                                                                                echo "€";
                                                                                                                            } ?>">
                            <label class="form-check-label" for="flatRate">
                                This is a flat amount to be given per sale.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="lead_detail" style="display:none;">
                    <h4 style="color:dodgerblue"><b>Lead Commission</b></h4>
                    <p>Lead Commission programs are common when your site is collecting information from your user but no purchase is being made. </p>
                    <p>This number is expressed as a flat amount.</p>
                    <div class="col-md-12">
                        <h4 style="color:dodgerblue;display:inline;">Per Lead Amount:</h4>
                        <h4 style="color:dodgerblue;display:inline;">
                            <?php
                            if ($merchant_currency == "Dollar") {
                                echo "$";
                            } elseif ($merchant_currency == "Pound") {
                                echo "£";
                            } elseif ($merchant_currency == "Euro") {
                                echo "€";
                            }
                            ?>
                        </h4>
                        <input type="text" style="display: none;" name="leadAmountType" id="leadAmountType" value="<?php
                                                                                                                    if ($merchant_currency == "Dollar") {
                                                                                                                        echo "$";
                                                                                                                    } elseif ($merchant_currency == "Pound") {
                                                                                                                        echo "£";
                                                                                                                    } elseif ($merchant_currency == "Euro") {
                                                                                                                        echo "€";
                                                                                                                    }
                                                                                                                    ?>">
                        <input class="form-control" style="width:20%;display:inline;" type="number" oninput="this.classList.remove('invalid')= ''" id="lead_amount" name="lead_amount" min="0" value="0" onkeypress="return CheckNumeric(event);">
                    </div>
                </div>

                <div class="col-md-12">
                    <a href="#" data-toggle="modal" data-target="#programInstructions">I don't know which program to choose.</a>
                    <!-- <a href="#" style="color:dodgerblue;text-decoration: none;"  >Preview Bio</a> -->

                    <!-- Modal -->
                    <div class="modal fade" id="programInstructions" tabindex="-1" role="dialog" aria-labelledby="programInstructionsTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Program to choose:</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="bio_body">
                                    <h4><b>Sale Program</b></h4>
                                    <p>With a Sales Program commission gets paid out to the Affiliate whenever they send you any completed sales via your website.</p>
                                    <h4><b>Lead Program</b></h4>
                                    <p>Program is common for when your website is collecting information, but no actual sales take place. </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-12" id="tracking_gap" style="display:none;">
                    <hr />
                    <h4 style="color:dodgerblue"><b>Tracking Gap</b></h4>
                    <div class="row">
                        <div class="col-md-5">
                            <!-- <input class="form-control" type="number" min="0" value="0" style="width:40%;display: inline;" oninput="this.classList.remove('invalid')= ''" name="Tracking_Period" onkeypress="return CheckNumeric(event);" /> -->
                            <select style="width:100%;display: inline;" class="form-control" id="Tracking_Period" name="Tracking_Period" oninput="this.classList.remove('invalid')= ''">
                                <!-- <option value="">---Select a Tracking Gap---</option> -->
                                <option value="15 Day(s)" selected>15 Day(s)</option>
                                <option value="30 Day(s)">30 Day(s)</option>
                                <option value="45 Day(s)">45 Day(s)</option>
                                <option value="60 Day(s)">60 Day(s)</option>
                                <option value="90 Day(s)">90 Day(s)</option>

                            </select>
                        </div>
                        <div class="col-md-7">
                            <p>Choose the amount of time allowed from the original click through to the time of the sale.</p>
                            <p>
                                When a buyer returns to your site within the <b>Tracking Gap</b> and makes a purchase, the affiliate is still awarded for that transaction.
                            </p>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="custom-select form-control form-select-sm mt-3" name="shopingCart_Currency">
                                <?php
                                if ($merchant_currency != "") {
                                ?>
                                    <option value="<?php echo $merchant_currency ?>" selected><?php echo $merchant_currency ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <p>You've selected your shoping cart's default currency.</p>
                        </div>

                    </div>
                </div>

            </div>

            <div id="preNext1" style="overflow:auto;display:none;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
            </div>

        </div>
        <div class="tab">
            <h1>Step 2 : Attract Affiliates</h1>
            <ul class="nav nav-tabs nav-justified m-1" id="bio_Nav">
                <li class="nav-item">
                    <a class="nav-link active" id="bio" href="#">Program Bio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="brands" href="#">Brands/Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="logo" href="#">Company Logo</a>
                </li>
            </ul>
            <div class="p-4" id="program_bio">
                <div class="p-2" style="display:none;">
                    <h6 style="color:dodgerblue"><b>Program Title</b></h6>
                    <input type="text" name="program_title" id="program_title" class="form-control" value="<?= $company ?>">
                </div>
                <h4 style="color:dodgerblue"><b>Bio</b></h4>
                <p>Give a general description of your affiliate program products, commissions offered and average sale amount. This description allows affiliates to learn more about you as a merchant. Your bio may be updated at any time during setup and once registration is complete. </p>
                <div>
                    <textarea class="form-control" name="bio" id="bio" cols="65" rows="7" oninput="this.classList.remove('invalid')= ''"></textarea>

                </div>
                <a href="#" style="color:dodgerblue;text-decoration: none;" data-toggle="modal" data-target="#bioModalCenter" id="preview_bio">Preview Bio</a>

                <!-- Modal -->
                <div class="modal fade" id="bioModalCenter" tabindex="-1" role="dialog" aria-labelledby="bioModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Bio</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="bio_body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4" id="program_brands" style="display:none;">
                <h4 style="color:dodgerblue"><b>Brands</b></h4>
                <p>Brands allow affiliates to search for your merchant account and products. Please add as many descriptive terms (at least three) as possible (up to the maximum of 255 characters). The more Brands you have, the more likely an affiliate will find you quickly and easily. Brands can be changed/updated at anytime. Multiple Brands can be added at once in a comma separated list.</p>
                <p><b>example: brand 1, brand 2, brand 3</b></p>

                <div>
                    <label for="pwd" class="form-label">Brands that you sell</label>
                    <select id="brandName" name="brands[]" class="tokenize-custom-demo1" onselect="this.className = ''" required multiple>

                        <?php
                        foreach ($brandArray as $brandName) {
                            if ($brandName !== "") {


                        ?>

                                <option value="<?php echo $brandName ?>" selected><?php echo $brandName ?></option>
                        <?php
                            }
                        }
                        ?>

                    </select>
                    <div class="message_box"></div>
                </div>
                <h4 style="color:dodgerblue"><b>Category (required)</b></h4>
                <p>Please choose one (1) category from the popup window that best matches your program. Additional categories may be purchased after completing the setup wizard. This is to ensure that the technical portions of the setup wizard are completed before Performanceaffiliate accepts funds.</p>

                <div class="mb-1 mt-1 col-md-12">
                    <label for="Category" class="form-label" style="color:dodgerblue">Category</label>
                    <select id="category" name="categorylst" class="custom-select form-control" oninput="this.removeClass = 'invalid'">
                        <!-- <option selected='selected' value="">----Select a Category----</option> -->
                        <?php
                        $sql    = "SELECT * FROM partners_category";
                        $result = mysqli_query($con, $sql);
                        ?>
                        <?php
                        while ($row = mysqli_fetch_object($result)) {
                            if ($category == $row->cat_id) {
                        ?>
                                <option id="cat_selected" value="<?= $row->cat_id ?>" selected="selected"><?= $row->cat_name ?></option>
                            <?php
                            } else {
                            ?>
                                <!-- <option value="<?= $row->cat_id ?>"><?= $row->cat_name ?></option> -->
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="p-4" id="program_logo" style="display:none;">
                <p>Your logo is used on various pages in the interface to promote your program. Please create your logo in the sizes listed below and then <b>drag them to the drop zone</b> below.</p>
                <div class="col-md-12 p-4">
                    <div class="card stacked-form">
                        <div class="card-header">
                            <span class="textred">&nbsp;</span>
                            <h4 class="card-title">Merchant Logo</h4>
                            <span class="textred"></span>
                        </div>
                        <div class="card-body">
                            <!-- <form id="Ajaxform"> -->
                            <?php if ($merchant_profileimage != '') {
                            ?>
                                <div class="addimg_preview text-center" id="image-container">
                                    <img class="mx-auto d-block" src="<?php echo 'merchants/uploadedimage/' . $merchant_profileimage; ?>" id="" style="width:150px;height:150px">
                                </div>
                            <?php
                            } ?>
                            <div class="img_preview text-center" style="display:none;">
                                <div class="im_progress">
                                    <!--<img class="loader_img" src="ajax-loader.gif">-->
                                    Loading.....
                                </div>
                                <img class="mx-auto d-block" src="" id="img_preview" style="width:150px;height:150px;">
                            </div>
                            <div class="All_images"></div>
                            <label for="logo" style="font-size:16px;">Select Logo:</label>
                            <input type="file" name="mer_logo" id="mer_logo" onchange="readURL(this);">
                            <!-- </form> -->
                            <div class="img_upload_err">
                                <span class="textred">Please Note: Logo's Must be 150*150 Pixels. Only JPEG, GIF, PNG</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="preNext2" style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
            </div>
        </div>
        <div class="tab">
            <h1>Step 3 : Manage Affiliates</h1>
            <ul class="nav nav-tabs nav-justified m-1" id="bio_Nav">
                <li class="nav-item">
                    <a class="nav-link active" id="agreement" href="#">Program Agreement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="approval" href="#">Auto Approval</a>
                </li>
            </ul>
            <div class="p-4" id="program_agreement">
                <h4 style="color:dodgerblue"><b>Program Agreement</b></h4>
                <p>The program agreement is the legal foundation for your Affiliate Program. Here you are able to add any activities that you do not allow in your Affiliate Program. If you have any other restrictions or regulations please list them here. </p>
                <div>
                    <textarea class="form-control" name="progAgreement" id="progAgreement" cols="70" rows="7" oninput="this.classList.remove('invalid')= ''"></textarea>

                </div>
            </div>
            <div class="p-4" id="program_approval" style="display: none;">
                <h4 style="color:dodgerblue"><b>Auto Approval</b></h4>
                <p>When choosing the "Automatic" option it allows your affiliate applications to be approved automatically, the affiliates can then start using your links immediately. When selecting the "Manual" option, you will have to approve every individual affiliate application. </p>
                <div class="col-md-12 p-4">
                    <div class="form-check p-1">
                        <input class="form-check-input" type="radio" name="Approval" id="approval_automatic" value="automatic" checked>
                        <label class="form-check-label" for="percentageRate">
                            AUTOMATIC
                        </label>
                    </div>
                    <div class="form-check p-1">
                        <input class="form-check-input" type="radio" name="Approval" id="approval_manually" value="manual">
                        <label class="form-check-label" for="flatRate">
                            MANUALLY
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-4" id="preNext3" style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
            </div>
        </div>
        <div class="tab">
            <h1>Step 4 : Tracking Code</h1>
            <ul class="nav nav-tabs nav-justified m-1" id="bio_Nav">
                <li class="nav-item">
                    <a class="nav-link active" id="tracking_code" href="#">Tracking Code</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>
            <div class="p-4" id="program_tracking">
                <h4 style="color:dodgerblue"><b>Tracking Code</b></h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            In order for us to track your sale/lead this MUST be placed on the confirmation page / completed sale page.<br>
                            All transactions will then be recorded and available within the reports.<br>
                            If you are using variables for Order ID &amp; Sale Value please make sure these fields are populated.<br>
                            Please note all transactions are validated automatically within 7 days.<br><br>

                            <b>(tid) = Tracking Identifying Code [?]</b><br>
                            Everytime a user is sent through an affiliate link we provide you with a (TID) this is for cookieless tracking. You must store this (TID) and provide it back to us on the event of a sale that has been generated from us.<br>
                            <br>
                            <b>Other Variables [?]</b><br>
                            productids = List all product ids of items within the transaction using a seperator eg 112233-223344<br>
                            postage = Put all details of any postage costs eg 3.99<br>
                            taxcosts = Place any tax costs such as VAT eg = 12.20<br>
                            cartid = If you have multiple cart/countries you can place them here eg = UK or 14556.

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card stacked-form trackcode_form">
                            <div class="card-body">
                                <div class="col-md-12" id="sale_code">
                                    <h4 class="card-title" style="color:dodgerblue">Tracking Code for Sale</h4>
                                    <div class="form-group">
                                        <textarea rows="10" name="headertxt" class="form-control" readonly>
                                    <?
                                    $code =  "\n<!--START Performance Affiliate Network CODE-->\n<img src=\"https://performanceaffiliate.com/trackingcode_sale.php?mid=$mid&amp;sec_id=$randNo&amp;sale=$saleamt&amp;orderId=$orderid&amp;tid={tid}&amp;productids={productids}&amp;postage={postage}&amp;taxcosts={taxcost}&amp;cartid={cartid}&amp;auid={auid}&amp;trafficsource={trafficsource}&amp;keyword={keyword}\" height=\"1\" width=\"1\" alt=\"\"> \n<!-- END Performance Affiliate Network CODE -->";
                                    echo $code;
                                    ?>
                                </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" id="lead_code">
                                    <h4 class="card-title" style="color:dodgerblue">Tracking Code for Lead</h4>
                                    <div class="form-group">
                                        <textarea rows="10" name="headertxt" class="form-control" readonly>
                                        <?
                                        $code =  "\n<!--START Performance Affiliate Network CODE-->\n<img src=\"https://performanceaffiliate.com/trackingcode_lead.php?mid=$mid&amp;sec_id=$randNo&amp;orderId=$orderid&amp;tid={tid}&amp;productids={productids}&amp;postage={postage}&amp;taxcosts={taxcost}&amp;cartid={cartid}&amp;auid={auid}&amp;trafficsource={trafficsource}&amp;keyword={keyword}\" height=\"1\" width=\"1\" alt=\"\"> \n<!-- END Performance Affiliate Network CODE -->";
                                        echo $code;
                                        ?> 
                                    </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="preNext4" style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
            </div>
        </div>
        <div class="tab">
            <h1>Step 5 : Testing Tracking Code</h1>
            <ul class="nav nav-tabs nav-justified m-1" id="bio_Nav">
                <li class="nav-item">
                    <a class="nav-link active" id="tracking_testing" href="#">Testing Tracking Code</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>
            <div class="col-md-12 p-4" id="prog_trackingTest">
                <div class="row">
                    <div class="col-md-12 p-4">
                        <div class="card stacked-form">
                            <div class="card-header">
                                <h4 class="card-title">Text Ad</h4>
                                <p><b>To create a Text ad you must fill the following fields</b></p>
                            </div>
                            <div class="card-body">
                                <ul style="list-style-type:none;padding-left: 15px;">
                                    <li><b>URL -</b>&nbsp;This is the Destination URL to which the text add will lead.</li>
                                    <li><b>Example -</b>&nbsp;http://www.yoursite.com/</li>
                                    <li><b>Text -</b>&nbspThis text will be the link</li>
                                    <li><b>Example -</b>&nbsp;Buy The Latest Nokia 8080</li>
                                    <li><b>Description -</b>&nbsp;This is the long description about the Link.</li>
                                    <li><b>Example -</b>&nbsp;This is the link to Home Page of Nokia</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-4">
                        <div class="card stacked-form">
                            <div class="card-header">
                                <h4 class="card-title">Settings</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>URL </label>
                                    <input type="text" name="tracking_url" id="tracking_url" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Text </label>
                                    <input type="text" name="tracking_text" id="tracking_text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea rows="3" name="tracking_description" id="tracking_description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <a id="trackingTest_link" class="btn btn-lg btn-info" href="https://performanceaffiliate.com/trackingcode.php?aid=<?php echo $aid ?>&linkid=<?php echo "N" . $linkid ?>" target="_blank">Test Tracking with link</a> -->
            </div>
            <div id="preNext4" style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
            </div>
        </div>
        <div class="tab">
            <h1>Step 6 : Perform Test Tracking</h1>
            <ul class="nav nav-tabs nav-justified m-1" id="bio_Nav">
                <li class="nav-item">
                    <a class="nav-link active" id="tracking_testing" href="#">Perform Tracking Test</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>
            <div class="row">
                <div class="col-md-12 p-4">
                    <div class="card stacked-form">
                        <div class="card-header">
                            <span class="textred">&nbsp;</span>
                            <h4 class="card-title">How to Perform Tracking Test</h4>
                            <span class="textred"></span>
                        </div>
                        <div class="card-body">

                            <b> 1. Ensure the code has been inserted on your website.</br>
                                2. Click the "Test Tracking Here" button below.</br>
                                3. Make a purchase of at least $1.</br>
                                4. Press next for us to review the test tracking to see if it is working.
                            </b>

                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4" id="preNext5" style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn_Submit" onclick="nextPrev(1)">Next</button>
                </div>
            </div>
        </div>


        <!-- <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
        </div> -->

        <!-- Circles which indicates the steps of the form: -->
        <div class="col-md-12 p-4" id="response_msg" style="display:none;">
            <!-- <i class="fas fa-info-circle p-4 icon text-center"></i> -->
            <div class="card bg-info">
                <div class="card-body text-center">
                    <i class="bi bi-info-circle p-4"></i>
                    <span class="card-text">Some text inside the fifth card</span>
                </div>
            </div>

        </div>
        <div class="col-md-12 p-4" id="done_transaction" style="display:none;">
            <h1>Add Payment</h1>
            <div class="card p-4" id="account">
                <select class="form-control" name="account_type" id="account_type" style="background-color: lightgrey;">
                    <option value="">---Select an Account Type---</option>
                    <option value="Free Self Managed Account">Free Self Managed Account</option>
                    <option value="Account Assitance (199)">Account Assitance (199)</option>
                    <option value="Account Management (450)">Account Management (450)</option>
                </select>
            </div>
            <div class="card p-2" id="payment_method" style="display:none;">
                <div class="row">
                    <!-- <div class="col-md-6"><button class="btn btn-md btn-success" style="width:100%;">Paypal</button></div>
                    <div class="col-md-6"><button class="btn btn-md btn-info" style="width:100%;">Bank Transfer</button></div> -->
                    <div class="">
                        <div class="container">
                            <br>
                            <p class="text-center"><b>Add Payment</b></p>
                            <hr>

                            <div class="row">
                                <aside class="col-sm-12">
                                    <p> Add funds via (PayPal OR Bank Transfer)</p>

                                    <article class="card">
                                        <div class="card-body p-5">

                                            <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                                                <!-- <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="pill" href="#nav-tab-card">
                                                        <i class="fa fa-credit-card"></i> Credit Card</a>
                                                </li> -->
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="pill" href="#nav-tab-paypal">
                                                        <i class="fab fa-paypal"></i> Paypal</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="pill" href="#nav-tab-bank">
                                                        <i class="fa fa-university"></i> Bank Transfer</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content">
                                                <!-- <div class="tab-pane fade show active" id="nav-tab-card">
                                                    <p class="alert alert-success">Some text success or error</p>
                                                    <form role="form">
                                                        <div class="form-group">
                                                            <label for="username">Full name (on the card)</label>
                                                            <input type="text" class="form-control" name="username" placeholder="" required="">
                                                        </div> 

                                                        <div class="form-group">
                                                            <label for="cardNumber">Card number</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="cardNumber" placeholder="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text text-muted">
                                                                        <i class="fab fa-cc-visa"></i>   <i class="fab fa-cc-amex"></i>  
                                                                        <i class="fab fa-cc-mastercard"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div> 

                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <div class="form-group">
                                                                    <label><span class="hidden-xs">Expiration</span> </label>
                                                                    <div class="input-group">
                                                                        <input type="number" class="form-control" placeholder="MM" name="">
                                                                        <input type="number" class="form-control" placeholder="YY" name="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                                                    <input type="number" class="form-control" required="">
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary btn-block" type="button"> Confirm </button>
                                                    </form>
                                                </div> -->
                                                <div class="tab-pane fade show active" id="nav-tab-paypal">
                                                    <p>Paypal is easiest way to pay online</p>
                                                    <p>
                                                        <button type="button" class="btn btn-primary"> <i class="fab fa-paypal"></i> Log in my Paypal </button>
                                                    </p>
                                                    <p><strong>Note:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                        tempor incididunt ut labore et dolore magna aliqua. </p>
                                                </div>
                                                <div class="tab-pane fade" id="nav-tab-bank">
                                                    <p>Bank accaunt details</p>
                                                    <dl class="param">
                                                        <dt>BANK: </dt>
                                                        <dd> THE WORLD BANK</dd>
                                                    </dl>
                                                    <dl class="param">
                                                        <dt>Accaunt number: </dt>
                                                        <dd> 12345678912345</dd>
                                                    </dl>
                                                    <dl class="param">
                                                        <dt>IBAN: </dt>
                                                        <dd> 123456789</dd>
                                                    </dl>
                                                    <p><strong>Note:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                        tempor incididunt ut labore et dolore magna aliqua. </p>
                                                </div> <!-- tab-pane.// -->
                                            </div> <!-- tab-content .// -->

                                        </div> <!-- card-body.// -->
                                    </article> <!-- card.// -->


                                </aside> <!-- col.// -->
                            </div> <!-- row.// -->

                        </div>
                        <!--container end.//-->
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-md-12 p4" style="display:none;">
            <span class="alert"></span>
        </div> -->
        <div class="col-md-12 p-4" id="tracking_loader" style="display:none;">
            <div class="text-center p-4">
                <div class="spinner-grow text-muted"></div>
                <div class="spinner-grow text-primary"></div>
                <div class="spinner-grow text-success"></div>
                <div class="spinner-grow text-info"></div>
                <div class="spinner-grow text-warning"></div>
                <div class="spinner-grow text-danger"></div>
                <div class="spinner-grow text-secondary"></div>
                <div class="spinner-grow text-dark"></div>
                <div class="spinner-grow text-light"></div>
            </div>
        </div>
        <hr />
        <div style="text-align:center;margin-top:20px;">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <!-- <span class="step"></span>
        <span class="step"></span> -->
        </div>
    </form>
<?php
} else {
    header("Location: https://performanceaffiliate.com/performanceAffiliateClone/signup.php");
}
?>
<script>
    function CheckNumeric(e) {
        var key;
        var keychar;

        if (window.event) {
            key = window.event.keyCode;
        } else if (e) {
            key = e.which;
        } else {
            return true;
        }

        keychar = String.fromCharCode(key);
        keychar = keychar.toLowerCase();

        if (key == null || key == 0 || key == 8 || key == 9 || key == 13 || key == 27) {
            return true;
        } else if ("0123456789.".indexOf(keychar) > -1) {
            return true;
        } else {
            alert("Enter a numeric value");
            return false;
        }
        return true;
    }




    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        var x = $(".tab");
        x.eq(n).show();
        if (n == 0) {
            $("#prevBtn").hide();
        } else {
            $("#prevBtn").show();
        }
        if (n == (x.length - 1)) {
            $("#nextBtn_Submit").text("Click Here To Test Tracking");
        } else {
            $("#nextBtn").text("Next");
        }
        fixStepIndicator(n);
    }


    function nextPrev(n) {
        // To scroll the page at the Top with every next or previous click
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
        var x = $(".tab");
        if (n == 1 && !validateForm()) {
            return false;
        }
        x.eq(currentTab).hide();
        currentTab = currentTab + n;
        if (currentTab >= x.length) {

            var SaleAmountType = $("input[name='SaleAmountType']:checked").val();
            console.log("SaleAmountType: ", SaleAmountType);

            var sales_amount = $('#sales_amount').val();
            console.log("sales_amount: ", sales_amount);

            var leadAmountType = $('#leadAmountType').val();
            console.log("leadAmountType:", leadAmountType);

            var lead_amount = $('#lead_amount').val();
            console.log("lead_amount: ", lead_amount);

            var Tracking_Period = $('#Tracking_Period').find(":selected").val();
            console.log("Tracking_Period: ", Tracking_Period);

            var program_title = $('#program_title').val();
            console.log("program_title: ", program_title);

            var bio = $('textarea#bio').val();
            console.log("bio: ", bio);

            var progAgreement = $('textarea#progAgreement').val();
            console.log("progAgreement: ", progAgreement);

            var approval = $("input[name='Approval']:checked").val();
            console.log("Approval: ", approval);

            var tracking_url = $('#tracking_url').val();
            console.log("tracking_url:", tracking_url);

            var tracking_text = $('#tracking_text').val();
            console.log("tracking_text:", tracking_text);

            var tracking_description = $('#tracking_description').val();
            console.log("tracking_description:", tracking_description);







            var formData = new FormData();
            formData.append('mid', '<?php echo $mid; ?>');
            formData.append('aid', '<?php echo $aid; ?>');
            formData.append('SaleAmountType', SaleAmountType);
            formData.append('sales_amount', sales_amount);
            formData.append('leadAmountType', leadAmountType);
            formData.append('lead_amount', lead_amount);
            formData.append('Tracking_Period', Tracking_Period);
            formData.append('program_title', program_title);
            formData.append('bio', bio);
            formData.append('mer_logo', $('#mer_logo')[0].files[0]);
            formData.append('progAgreement', progAgreement);
            formData.append('approval', approval);
            formData.append('tracking_url', tracking_url);
            formData.append('tracking_text', tracking_text);
            formData.append('tracking_description', tracking_description);




            $.ajax({
                type: "POST",
                url: "wizardValidate.php",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {
                    if (data) {
                        console.log("Wizard Validation Success.... ", data);
                        console.log(data.tracking_link);
                        if (data.tracking_link != null) {
                            $('#response_msg span').text('Please do not close the page...!');
                            // $('#response_msg span').addClass('alert-success');
                            // $('#response_msg span').removeClass('alert-danger');
                            $('#response_msg').show();
                            // $('#tracking_loader').show();

                            // window.location.href = data.tracking_link;

                            // set the URL of the page you want to redirect to
                            var url = data.tracking_link;

                            // open a new window and redirect to the URL
                            var newWindow = window.open(url, "_blank");
                            newWindow.location.href = url;

                            // set the function to be executed after 60 seconds
                            var myFunction = function() {
                                // code to be executed after 60 seconds
                                alert("60 seconds have passed!");
                                // call the location.reload() method to refresh the page
                                // location.reload();
                                $('#response_msg').hide();
                                $('#tracking_loader').hide();
                                $('#done_transaction').show();

                            };

                            // call the setTimeout() function to execute the function after 60 seconds
                            setTimeout(myFunction, 60000); // 60000 milliseconds = 60 seconds





                        } else {
                            console.log(data);
                            $('#response_msg span').text(data);
                            // $('#response_msg span').addClass('alert-danger');
                            // $('#response_msg span').removeClass('alert-success');
                            $('#response_msg').show();
                        }

                        // window.location.href = '/success-page';
                    } else {
                        // Handllead_amount
                    }
                },
                error: function() {
                    // Handle AJAX errors here
                }
            });
            return false;
        }
        showTab(currentTab);
    }

    function validateForm() {

        var valid = true;
        var $tab = $(".tab").eq(currentTab);
        var $inputs = $tab.find("input.form-control");
        var $textareas = $tab.find("textarea");
        var $selects = $tab.find("select");

        $inputs.each(function() {
            var $input = $(this);
            // ignore: "#toIgnore";

            if ($input.val() == "") {
                $input.addClass("invalid");
                alert("Field is empty!", );
                // console.log("Input empty!", $input);
                valid = false;
            }
        });

        $textareas.each(function() {
            var $textarea = $(this);

            if ($textarea.val() == "") {
                $textarea.addClass("invalid");
                alert("Field is empty!");
                valid = false;
                // return valid;
            }
        });

        $selects.each(function() {
            var $select = $(this);

            if ($select.val() == "") {
                $select.addClass("invalid");
                alert("Field is empty!");
                valid = false;
            }
        });

        if (valid) {
            $(".step").eq(currentTab).addClass("finish");
        }

        return valid;
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }
</script>


<script>
    $("#sales_commission").click(function() {
        $(this).css("background-color", "MediumSeaGreen");
        // nextPrev(true);
        $("#lead_commission").css("background-color", "");

        let saleAmount = $("#sales_detail input").val();
        // alert("This is sales_commission.");
        $("#preNext1").show();
        $("#sales_detail").show();
        $("#lead_detail").hide();
        $("#lead_code").hide();
        $("#sale_code").show();

        if (saleAmount > 0) {
            $("#tracking_gap").show();

        } else {
            $("#tracking_gap").hide();
        }

    });
    $("#lead_commission").click(function() {
        $(this).css("background-color", "MediumSeaGreen");
        $("#sales_commission").css("background-color", "");

        let leadAmount = $("#lead_detail input").val();
        // alert("This is lead_commission.");
        $("#preNext1").show();
        $("#lead_detail").show();
        $("#sales_detail").hide();
        $("#tracking_gap").hide();
        $("#sale_code").hide();
        $("#lead_code").show();


        if (leadAmount > 0) {
            $("#tracking_gap").show();
        } else {
            $("#tracking_gap").hide();
        }
    });


    $("#sales_detail input").keyup(function() {
        let saleAmount = $(this).val();
        console.log("Sale keyup completed with current value: ", saleAmount);
        if (saleAmount > 0) {
            $("#lead_amount").val(0);
            $("#tracking_gap").show();
        } else {
            $("#tracking_gap").hide();
        }
    });
    $("#lead_detail input").keyup(function() {
        let leadAmount = $(this).val();
        console.log("Lead keyup completed with value: ", leadAmount);
        if (leadAmount > 0) {
            $("#sales_amount").val(0);
            $("#tracking_gap").show();
        } else {
            $("#tracking_gap").hide();
        }
    });

    $('#sales_detail input[type="radio"]').change(function() {
        if ($(this).is(':checked')) {
            console.log($(this).val(), ' is checked');
            //============For Sales Detail============//
            if ($(this).val() == 'Sale_percentageType') {
                $('#sale_percentage').css('display', 'inline');
                $('#sale_currency').hide();
            } else {
                $('#sale_currency').css('display', 'inline');
                $('#sale_percentage').hide();
            }
        }
    });
    //============Step 2==============//
    $('#bio').click(function() {
        $(this).addClass('active');
        $('#brands').removeClass('active');
        $('#logo').removeClass('active');

        $('#program_bio').show();
        $('#program_brands').hide();
        $('#program_logo').hide();
        // $('#preNext2').hide();
    });
    $('#brands').click(function() {
        $(this).addClass('active');
        $('#bio').removeClass('active');
        $('#logo').removeClass('active');

        $('#program_bio').hide();
        $('#program_brands').show();
        $('#program_logo').hide();
        // $('#preNext2').hide();
    });
    $('#logo').click(function() {
        $(this).addClass('active');
        $('#bio').removeClass('active');
        $('#brands').removeClass('active');

        $('#program_bio').hide();
        $('#program_brands').hide();
        $('#program_logo').show();
        // $('#preNext2').show();
    });
    //============Step 3==============//
    $('#agreement').click(function() {
        $(this).addClass('active');
        $('#approval').removeClass('active');

        $('#program_agreement').show();
        $('#program_approval').hide();
        // $('#preNext2').hide();
    });
    $('#approval').click(function() {
        $(this).addClass('active');
        $('#agreement').removeClass('active');

        $('#program_approval').show();
        $('#program_agreement').hide();
        // $('#preNext2').hide();
    });


    $('.tokenize-custom-demo1').tokenize2({

        tokensAllowCustom: true
    });

    //====================Start Script For merchant logo =================//
    function readURL(input) {
        console.log("onchange function is called", input);
        imageValidation(input);
        // if (imageValidation() !== false) {
        //     DisplayImagePreview(input);
        //     $(".img_preview").show();
        //     $(".addimg_preview").hide();
        //     $('.im_progress').fadeOut();
        // } else {
        //     alert("Something went wrong.Please try again.");
        //     $(".img_preview").hide();
        //     $(".addimg_preview").show();
        // }
    }

    function DisplayImagePreview(input) {
        console.log(input.files);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function imageValidation(input) {
        //Get reference of FileUpload.
        var fileUpload = $("#mer_logo")[0];

        //Check whether the file is valid Image.
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        if (regex.test(fileUpload.value.toLowerCase())) {
            //Check whether HTML5 is supported.
            if (typeof(fileUpload.files) != "undefined") {
                //Initiate the FileReader object.
                var reader = new FileReader();
                //Read the contents of Image File.
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function(e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    image.onload = function() {
                        //Determine the Height and Width.
                        var height = this.height;
                        var width = this.width;
                        if (height > 150 || width > 150) {
                            alert("Height and Width must not exceed 150px.");
                            console.log("File name before: ", $("#mer_logo").val());
                            $("#mer_logo").val('');
                            $(".img_preview").hide();
                            $(".addimg_preview").show();
                            console.log("File name after: ", $("#mer_logo").val());

                            return false;
                        } else {
                            alert("Uploaded image has valid Height and Width.");
                            // readURL(input);
                            DisplayImagePreview(input);
                            $(".img_preview").show();
                            $(".addimg_preview").hide();
                            $('.im_progress').fadeOut();
                            return true;
                        }

                    };
                }
            } else {
                alert("This browser does not support HTML5.");
                $("#mer_logo").val('');
                return false;
            }
        } else {
            alert("Please select a valid Image file.");
            $("#mer_logo").val('');
            return false;
        }
    }
    //====================End Script For merchant logo =================//


    $('#preview_bio').click(function() {
        let bio = $('textarea#bio').val();
        if (bio != '') {
            $('div#bio_body').text(bio);

        } else {
            $('div#bio_body').text('Your bio is empty!');
        }
        // console.log('preview bio: ', bio,'preview body: ', preview_body);
    });

    $('#trackingTest_link').click(function() {

        let site_link = $(this).attr('href');
        console.log("This is merchant site ling: ", site_link);
    });

    $('#account_type').change(function() {
        var selectedValue = $(this).val();

        if (selectedValue !== '') {
            // Do something if Option 2 is selected
            $('#payment_method').show();
        } else {
            // Do something if Option 2 is not selected
            $('#payment_method').hide();
        }
    });
</script>

<?php
include('includes/footer.php');
?>
</body>

</html>