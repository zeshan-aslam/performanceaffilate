<?php

require_once("includes/header.php");

?>  
  
  
  <?php
  include_once 'includes/db-connect.php';
  include_once 'includes/session.php';
  header("Cache-control: private");
  include_once 'includes/constants.php';
  include_once 'includes/functions.php';
  include_once 'includes/allstripslashes.php';
  include('header_two.php');
  $sql = "select * from partners_paymentgateway where pay_status like 'Active' and pay_name NOT LIKE 'WorldPay'";
  $ret = mysqli_query($con, $sql);
  $msg = $_REQUEST['msg'];
  $referer_id = $_REQUEST['referer'];
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
    echo "this is file name:" . $filename;
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
  <!-- <div class="form-check mb-3">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" name="Terms" value="1">Affilates Account 
                        </label>
                      </div>
                      <div class="form-check mb-3">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" name="Terms" value="1">Affilates Account 
                        </label>
                      </div> -->
  <section class="signuppage">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="Signupform">
            <form id="signup-affiliate" method="post" name="reg" action="#">
              <div class="form-title">
                <h3> Create new Account </h3>
                <p>Create partnerships with Performance Affiliate and drive growth.</p>
              </div>
              <?php
              if ($msg != "") {
                $alertClass = $err == "2" ? "alert-danger" : "alert-success";
              ?>
                <div class="form-group row">
                  <div class="col-12">
                    <div class="alert <?= $alertClass ?>" role="alert"><?= $msg ?> </div>
                  </div>
                </div>
              <?php
              }
              ?>
              <div class="mb-1 mt-1 col-md-12">
                <label for="name" class="form-label">Please Select Account Type:</label>
                <select id="accounttype" name="accounttype" class="custom-select form-control" required="required">
                  <option value="#">Select Account Type</option>
                  <option value="Affiliates">Affiliate</option>
                  <option value="Merchants">Merchant</option>
                </select>
              </div>
              <div class="row">
                <input type="hidden" name="referer_id" value="<?= $referer_id ?>">
                <div class="mb-1 mt-1 col-md-6">
                  <label for="name" class="form-label">First Name:</label>
                  <input type="text" class="form-control" id="name" placeholder="Enter name" id="firstnametxt" required="required" name="firstnametxt">
                </div>
                <div class="mb-1 mt-1 col-md-6">
                  <label for="name" class="form-label">Last Name:</label>
                  <input type="text" class="form-control" placeholder="Enter last name" required="required" id="lastnametxt" name="lastnametxt">
                </div>
                <div class="mb-1 mt-1 col-md-6">
                  <label for="email" class="form-label">E_mail:</label>
                  <input type="text" class="form-control" id="emailidtxt" name="emailidtxt" size="20" placeholder="Enter email">
                </div>
                <div class="mb-1 mt-1 col-md-6">
                  <label for="pwd" class="form-label">Company:</label>
                  <input type="text" class="form-control" id="companytxt" name="companytxt" size="20" placeholder="">
                </div>
                <div class="mb-1 mt-1 col-md-4">
                  <label for="email" class="form-label">Phone Number:</label>
                  <input type="text" class="form-control" id="phone" name="phonetxt" placeholder="Enter Phone number">
                </div>
                <div class="mb-1 mt-1 col-md-4">
                  <label for="pwd" class="form-label">Url:</label>
                  <input type="text" class="form-control" id="url" name="urltxt" size="20" placeholder="">
                </div>
                <div class="mb-1 mt-1 col-md-4">
                  <label for="email" class="form-label">City/Town:</label>
                  <input type="text" class="form-control" id="city" name="citytxt" placeholder="City/Town:">
                </div>

                <!-- <div class="mb-1 mt-1 col-md-6">
                            <label for="email" class="form-label">Phone Number:</label>
                            <input type="number" class="form-control"  id="phone" name="phonetxt" size="20" placeholder="Enter Phone number">
                          </div> -->
                <div class="mb-1 mt-1 col-md-12">
                  <label for="pwd" class="form-label">Address:</label>
                  <textarea id="address" name="addresstxt" cols="40" rows="3" name="addresstxt" cols="40" rows="3" class="form-control" required="required"></textarea>
                </div>
                <div class="mb-1 mt-1 col-md-6" id="brands">
                  <label for="pwd" class="form-label">Brands that you sell</label>
                  <!-- <input type="text" class="form-control" id="state" name="brands" placeholder="Brands"> -->
                  <select  name="brands[]" class="tokenize-custom-demo1" multiple>



                  </select>
                </div>
                <!-- <div class="mb-1 mt-1 col-md-6" id="brandspower">
                  <label for="pwd" class="form-label">Brands Power</label>
                  <input type="number" class="form-control" id="state" name="brandspower" min="1" max="3" placeholder="Brands Power">
                </div> -->
                <div class="mb-1 mt-1 col-md-4">
                  <label for="pwd" class="form-label">State/County</label>
                  <input type="text" class="form-control" id="state" name="statetxt" placeholder="State/County">
                </div>
                <div class="mb-1 mt-1 col-md-4">
                  <label for="pwd" class="form-label">Select a Country</label>
                  <select id="country" name="countrylst" class="custom-select form-control" required="required">
                    <option value="nill"><?= $lang_SelectaCountry ?></option>
                    <?php
                    $sql    = "SELECT * FROM partners_country";
                    $result = mysqli_query($con, $sql);
                    ?>
                    <?php
                    while ($row = mysqli_fetch_object($result)) {
                      if ($country == $row->country_name) {
                    ?>
                        <option value="<?= $row->country_name ?>" selected><?= $row->country_name ?></option>
                      <?php
                      } else {
                      ?>
                        <option value="<?= $row->country_name ?>"><?= $row->country_name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>

                </div>

                <div class="mb-1 mt-1 col-md-4">
                  <label for="pwd" class="form-label">Select a Curency</label>
                  <select id="currency" name="currency" class="custom-select form-control" required="required">
                    <option value="Dollar">Dollar</option>
                    <option value="Pound">Pound</option>
                    <option value="Euro">Euro</option>
                  </select>

                </div>
                <div class="mb-1 mt-1 col-md-4">
                  <label for="Zip/Post Code" class="form-label">Zip/Post Code</label>
                  <input type="text" class="form-control" id="zip-code" name="ziptxt" placeholder="Zip/Post Code">
                </div>

                <div class="mb-1 mt-1 col-md-4">
                  <label for="Tax/VAT Id" class="form-label">Tax/VAT Id</label>
                  <input type="text" class="form-control" placeholder="Tax/VAT Id" id="tax-id" name="taxIdtxt" size="20">
                </div>

                <!-- <div class="mb-1 mt-1 col-md-4">
                            <label for="faxtxt" class="form-label">Fax:</label>
                            <input type="text" class="form-control"  placeholder="fax" id="faxtxt" name="faxtxt" size="20">
                          </div> -->
                <div class="mb-1 mt-1 col-md-4">
                  <label for="Category" class="form-label">Category</label>
                  <select id="category" name="categorylst" class="custom-select form-control" required="required">
                    <option selected='selected' value="nill"><?= $selectacategory ?></option>
                    <?php
                    $sql    = "SELECT * FROM partners_category";
                    $result = mysqli_query($con, $sql);
                    ?>
                    <?php
                    while ($row = mysqli_fetch_object($result)) {
                      if ($category == $row->cat_name) {
                    ?>
                        <option value="<?= $row->cat_name ?>" selected="selected"><?= $row->cat_name ?></option>
                      <?php
                      } else {
                      ?>
                        <option value="<?= $row->cat_name ?>"><?= $row->cat_name ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>

                <div class="mb-1 mt-1 col-md-3">
                  <label for="Tax/VAT Id" class="form-label">Time Zone</label>
                  <select id="timezone" name="timezone" class="custom-select form-control" required="required">
                    <option value="-12">Newzealand Time(-12)</option>
                    <option value="-11">Midway Isles, Samoa (-11)</option>
                    <option value="-10">Hawaii (-10)</option>
                    <option value="-9">AKST - Alaska Standard Time(-9)</option>
                    <option value="-8">PST - Pacific Standard Time(-8)</option>
                    <option value="-7">MST - Mountain Standard Time(-7)</option>
                    <option value="-6">CST - Central Standard Time(-6)</option>
                    <option value="-5">EST - Eastern Standard Time(-5)</option>
                    <option value="-4">SA West - Atlantic Time(-4)</option>
                    <option value="-3">SA East - East Brasil Time (-3)</option>
                    <option value="-2">Middle Atlantic (-2)</option>
                    <option value="-1">Island Time (-1)</option>
                    <option selected="selected" value="0">GMT - Greenwitch Meridian Time (0)</option>
                    <option value="1">CET - Central European Time (+1)</option>
                    <option value="2">EET - East European Time (+2)</option>
                    <option value="3">Irak, Kuwait, Russia(+3)</option>
                    <option value="4">Mauritius, Kazachstan (+4)</option>
                    <option value="5">West Asia (+5)</option>
                    <option value="6">Central Asia (+6)</option>
                    <option value="7">Indo China Time (+7)</option>
                    <option value="8">Chinese Shore Time (+8)</option>
                    <option value="9">JST - Japan Standard Time (+9)</option>
                    <option value="10">AUS - Australian Time(+10)</option>
                    <option value="11">Central Pacifik (+11)</option>
                    <option value="12">Newzealand Time (12)</option>
                  </select>

                </div>
                <div class="mb-1 mt-1 col-md-6 mer_type" style="display: none;">
                  <label for="" class="form-label">Merchant Account Type</label>

                  <select id="typelst" name="typelst" class="custom-select form-control" required="required">
                    <option value="nill">....Select Merchant Account Type....</option>
                    <option value="normal">Self Managed (£0)</option>
                    <option value="advance">Managed (£100p/m)</option>
                  </select>
                </div>
                <div class="mb-1 mt-1 col-md-6 payment" style="display: none;">
                  <label for="Tax/VAT Id" class="form-label">Mode of Payment</label>
                  <select onchange="getpayment()" id="drpPaymetMethod" name="modofpay" class="form-control" aria-describedby="paymet-methodHelpBlock" required="required">
                    <? //checking for each records
                    if (mysqli_num_rows($ret) > 0) {
                      while ($row = mysqli_fetch_object($ret)) {
                        if ($modofpay == $row->pay_name) $sel = "selected = 'selected'";
                        else                          $sel = "";
                    ?>
                        <option value="<?= $row->pay_name ?>" <?= $sel ?>><?= $row->pay_name ?> </option>
                    <?
                      }
                    }  ?>
                  </select>
                  <span id="paymet-methodHelpBlock" class="form-text text-muted">* All Fields Are Required</span>
                </div>
                <div class="mb-1 mt-1 col-md-12 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label"><?= $lang_wire_caption ?></label>
                </div>

                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_AccountName ?></label>

                  <input type='text' class="form-control" name='wire_AccountName' size='20' value='<?= $wire_AccountName ?>' />

                </div>

                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_AccountNumber ?></label>

                  <input type='text' class="form-control" name='wire_AccountNumber' size='20' value='<?= $wire_AccountNumber ?>' />

                </div>

                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_BankName ?></label>

                  <input type='text' class="form-control" name='wire_BankName' size='20' value='<?= $wire_BankName ?>' />

                </div>

                <div class="mb-1 mt-1 col-md-12 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_BankAddress ?></label>

                  <textarea name='wire_BankAddress' class="form-control" rows='5' cols='27'><?= $wire_BankAddress ?></textarea>

                </div>

                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_BankCity ?></label>
                  <input type='text' class="form-control" name='wire_BankCity' size='20' value='<?= $wire_BankCity ?>' />
                </div>

                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_BankState ?></label>
                  <input type='text' class="form-control" name='wire_BankState' size='20' value='<?= $wire_BankState ?>' />
                </div>

                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_BankZip ?></label>
                  <input type='text' class="form-control" name='wire_BankZip' size='20' value='<?= $wire_BankZip ?>' />
                </div>

                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_BankCountry ?></label>
                  <input type='text' class="form-control" name='wire_BankCountry' size='20' value='<?= $wire_BankCountry ?>' />
                </div>

                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_BankAddressNumber ?></label>
                  <input type='text' class="form-control" name='wire_BankAddressNumber' size='20' value='<?= $wire_BankAddressNumber ?>' />
                </div>
                <div class="mb-1 mt-1 col-md-4 wiretransfer modeofpayment" style="display: none;">
                  <label class="form-label" for="tax-id"><?= $lang_wire_Nominate ?></label>
                  <input type='text' class="form-control" name='wire_Nominate' size='20' value='<?= $wire_Nominate ?>' />
                </div>



                <div class="mb-1 mt-1 col-md-12">
                  <textarea name="termsCondn" class="form-control" cols="40" rows="5">1. INTRODUCTION
1.1 This is an agreement between Performance Affiliate Network (Searlco LTD) of Earl House, Gradene, Station Road, Ulceby, Lincolnshire, DN39 6UQ (“the Company”) and the entity using the Services (“Affiliate”).
2. DEFINITIONS
2.1 In this agreement, the following definitions apply:
Advertisements
Any form of advertisement or promotion placed by the Advertiser in connection with their Services including banner advertisements, text links, video content or any other form of online advertising.
Affiliate/Publisher
An operator of a site which is part of the Performance Affiliate Network who places adverts/links/promotions on behalf of any Merchant/Agency on the Network.
Affiliate Network
The network of third party affiliate sites.
Event
Any click, Impression, sale, Lead or other event for which payment has been promised to an Affiliate.
Impression
A single instance of an Advertisement being displayed.
Intellectual Property Rights.
Patents, trademarks, service marks, design rights, copyright, database rights (all whether registered or not), applications for any of the foregoing, know-how, trade or business names and other similar rights or obligations whether registered or not in any country in the world and whether now existing or in the future created.
3. Changes
3.1 The Company may change this agreement (including Fees, payment procedures and rules) by posting the revised information on its website for at least 21 days before they become effective. The Affiliate undertakes to check the website from time to time. If it does not wish to accept the changes, the Affiliate may terminate the agreement by giving notice in Writing before the effective date. The Affiliate will be bound by the revised agreement it fails to give such notice.
4. Services generally
4.1 In consideration of the mutual covenants contained in this agreement, the Company agrees to supply the Services subject to the terms of this agreement.
4.2 The Company reserves the right to reject any application to become an Affiliate. Affiliates must be 18 years or over.
4.3 The Affiliate shall not display or distribute any Advertisement unless the relevant Medium has been approved by the Company in Writing. Any such approval by the Company does not constitute an endorsement of any kind and the Company is not liable for any such approval. No fees will be paid in respect of Advertisements displayed or distributed via a Medium which has not been approved by the Company. The Affiliate must promptly notify the Company in Writing if it makes any material change to an Affiliate Website after approval by the Company.
4.4 The Affiliate agrees:
4.4.1 not to alter any Advertisement;
4.4.2 not to create its own advertisements in respect of any Advertiser or create its own link to an Advertiser website without the prior approval of the Company in Writing;
4.4.3 not during the term of this agreement and for a period of 6 months after termination independently of the Company to display or distribute Advertisements or otherwise conduct any advertising-related business with any Advertiser whose Advertisements the Affiliate has displayed or distributed in connection with this agreement;
4.4.4 not do anything which in any way alters an Advertiser website;
4.4.5 not to procure, or attempt to procure, clicks, Leads or other Events by means of:
4.4.a) open encouragement to users or incentives (except that if the Advertiser Offer Page does not state “no incentives” or similar, the Affiliate may provide incentives which comply with any Advertiser requirements and which are reasonable, non-deceptive and in accordance with industry standards);
4.4.b) deception; or
4.4.c) any other means which the Company considers inappropriate;
4.4.6 not to use “spam” or unsolicited email marketing;
4.4.7 not to display any information (including prices) relating to the Advertiser’s goods and services on any Medium unless such information is accurate, up to date and non-misleading; and
4.4.8 not to use any information gained through the Service to solicit any Advertiser without the Company’s prior approval.
4.5 The Affiliate agrees to comply with (1) any guidelines, rules or terms and conditions specified by relevant Advertisers on the “Advertiser Offer” Page or elsewhere on the Company’s website and (2) any other applicable rules or guidelines, which are shown on the Company’s website from time to time.
4.6 The Affiliate warrants that in respect of this agreement (including in relation to every Medium):
4.6.1 it shall comply with all Applicable Laws;
4.6.2 it shall not infringe any third party intellectual property or other rights;
4.6.3 it shall not breach the published policies of Google or other major search engines;
4.6.4 it shall not display or distribute any information which is defamatory, discriminatory, offensive, vulgar, racist, abusive, invasive of another’s privacy or otherwise inappropriate; and
4.6.5 it shall comply with the highest industry standards.
4.7 The Affiliate warrants that it has sole control of the Affiliate Website.
4.8 The Affiliate acknowledges that the Advertisements include cookies and similar technologies as set out on the privacy policy from time to time on the Company’s website. It is the Affiliate’s responsibility to frequently monitor the privacy policy and to comply with all legal requirements concerning the use of such technologies on the Affiliate Website including the procuring of any necessary consents from users.
4.9 The Affiliate shall promptly notify the Company if it becomes aware of any abuse of the Service.
4.10 The Affiliate:
4.10.1 shall provide reasonable co-operation to the Company in supplying the Services and shall comply with the Company’s reasonable requirements;
4.10.2 shall promptly provide the Company with such information and documents as it may reasonably request for the proper performance of the Services; and
4.10.3 shall not take any step which may interfere with or obstruct the proper performance of the Services.
4.11 The Affiliate must promptly inform the Company if any Affiliate Website becomes inactive or is no longer owned or operated by the Affiliate.
4.12 The Company does not guarantee that use of the Services will generate any particular level of revenues.
4.13 The Affiliate warrants that it will not use the Services in a manner which imposes or may impose a disproportionately large load on the Company’s systems or which constitutes spamming, phishing or improper, malicious or fraudulent activity or which is liable to damage the reputation of the Company, all as determined by the Company in its sole discretion.
4.14 The Affiliate agrees that the Company may disclose the Affiliate’s name and contact details to the Advertiser on request.
4.15 The Company does not guarantee that the Services will be error-free or uninterrupted. The Company is not liable for such interruptions or errors provided that they are not deliberate acts of the Company and provided that the Company uses reasonable endeavours to procure that any errors or interruptions of which it becomes aware are corrected as soon as reasonably practicable.
4.16 The Company is entitled, without notice and without liability, to suspend the Services for repair, maintenance, improvement or other technical reason.
5. Payment
5.1 Subject to the terms of this agreement, the Company shall pay the Fees to the Affiliate.
5.2 In the case of Non-Prepaid Fees, the Company shall make payment by the later of:
5.2.1 the end of the Month following the Month in which the relevant Event occurs; and
5.2.2 the end of the Month following the Month in which the Company receives payment in full of the fee due to the Company from the Advertiser in respect of the relevant Event.
For the avoidance of doubt, the Company shall have no liability to pay the Affiliate for the relevant Event if full payment of Non-Prepaid Fees for the relevant Event is not received by the Company for whatever reason. For the further avoidance of doubt, the Company is not liable to the Affiliate if the Advertiser fails to make payment of Non-Prepaid Fees for any reason (excluding any deliberate act or omission by the Company).
5.3 In the case of Prepaid Fees, the Company shall make payment by the end of the Month following the Month in which the relevant Event occurs. The Affiliate acknowledges that in respect of Prepaid Offers the Company will not be liable to make any payment to the Affiliate in excess of the amount of the Prepaid Fees irrespective of the number or nature of the Events which arise after the Prepaid Fees have been exceeded. The Company will take reasonable steps to email the Affiliate warning if the amount of any Prepaid Fees has been, or is close to being, reached but cannot guarantee that the Affiliate will receive such email. It is the Affiliate’s responsibility to check the level of Prepaid Fees within its account within the Services if it wishes to determine whether Prepaid Fees have been used up, or are close to being used up, in respect of any particular Prepaid Offer. The Affiliate acknowledges the Prepaid Fees shown in the account are not in real-time and that it may take up to three hours before the Prepaid Fees shown within its account are updated.
5.4 Any Fees under £50 will be held over until the next Month’s payment.
5.5 No Fees shall be payable to the Affiliate in respect of any Event which is not a Genuine Event.
5.6 No Fees shall be payable to the Affiliate in respect of any Medium which has not been approved in Writing by the Company in accordance with clause 4.3 of this Agreement.
5.7 If the Affiliate breaches clauses 4.4, 4.5 or 4.6 of this agreement:
5.7.1 no further Fees shall be payable by the Company to the Affiliate under this agreement;
5.7.2 the Affiliate shall promptly repay to the Company all Fees previously paid by the Affiliate to the Company relating to the Advertiser(s) concerned.
5.8 No Fees shall be due to the Affiliate in respect of terminated / paused campaigns. If the Affiliate continues to send traffic after a campaign has been terminated / paused, or after any Prepaid Fees have been used up on any particular Prepaid Offer, the Company reserves the right (but does not undertake) to redirect the traffic to any alternative campaign by any advertiser, in which case the Company shall pay the Affiliate whatever are its standard fees for that alternative campaign.
5.9 No Fees shall be due to the Affiliate in respect of Events involving users with IP addresses located in countries other than those specified on the Advertiser Offer Page as recorded by the Company.
5.10 The Affiliate acknowledges that the Company’s records and statistics shall be conclusive as to any payment issue relating to this agreement.
5.11 The Company will use reasonable endeavours to provide accurate and up to date campaign payment information but the Affiliate acknowledges the possibility that the information may be incorrect or out of date. If so, the amount payable will be the standard fees which are payable by the Company in respect of the campaign concerned.
5.12 Any payments referred to in this agreement are net of VAT which shall be payable in addition where legally due.
5.13 If the Affiliate is VAT-registered, then it agrees to a self-billing arrangement as follows:
5.13.1 The Company shall issue self-billed invoices for all supplies made to it by the Affiliate during the period of this agreement including the Affiliate’s name, address and VAT registration number, together with all the other details required for a valid VAT invoice.
5.13.2 The Affiliate agrees to accept all self-billed invoices issued by the Company during the period of this agreement and that it will not raise any sales invoices for transactions covered by this agreement.
5.13.3 Each party will notify the other promptly in Writing if it changes its VAT number, ceases to be VAT registered or sells all or part of its business.
5.13.4 Any queries in respect of the amount of the invoice must be raised within 7 days of the date the invoice is issued.
5.14 If the Affiliate (a) fails to log into the Affiliate’s account on the Service at least once in any 12-month period and (b) the Affiliate fails to generate at least one Event during that period, then any earnings of the Affiliate held in the Affiliate’s account are forfeited to the Company and the Affiliate’s account balance is reset to zero.
6. Support
6.1 The Company has no responsibility to provide any form of support. The Company may in its discretion decide to provide support and, if so, it is entitled to make such support conditional upon payment of its standard fees for such services.
7. Affiliate’s Account
7.1 The Affiliate’s online account for use of the Service is for the Affiliate’s personal use only and is non-transferable. The Affiliate must not authorise or permit any other person to use its account. The Affiliate must take reasonable care to protect and keep confidential its password and other account or identity information. The Affiliate must notify the Company immediately of any apparent breach of security such as loss, theft, misuse or unauthorised disclosure or use of a password. The Affiliate is responsible for third parties who use its account or identity (unless and to the extent that the Company is at fault). 
7.2 The Company reserves the right in its discretion, including if the Affiliate opts for Paypal as a payment method or if the Company suspects that there may have been illicit activity relating to the account, to request by letter, email or otherwise that the Affiliate verify its postal or other contact details and/or its identity and/or to provide information about its methods of generating traffic and/or to provide other information. If the Affiliate fails within the time specified to respond appropriately or at all to any such request, the Company reserves the right to close the Affiliate’s account, in which case any earnings of the Affiliate held in the Affiliate’s account are forfeited to the Company. If the Affiliate asks the Company to reissue any verification request and the Company decides in its discretion to do so, the Company is entitled to require payment of a £10 administration fee. 
8. Termination
8.1 Either party may terminate this agreement immediately at any time for any reason by giving notice in Writing.
8.2 Any right of termination referred to in this agreement is without prejudice to any other remedy that may otherwise be available to the terminating party.
8.3 In the event of termination of this agreement:
8.3.1 accrued rights and liabilities shall be unaffected;
8.3.2 the Company shall continue to pay outstanding Fees relating to Genuine Events which occurred before termination and there will be an administration fee of £10 in respect of any payment due under £25; and
8.3.3 all provisions which are intended or expressed to survive termination of this agreement will survive together with any other provision necessary for the interpretation or enforcement of this agreement.
9. Mutual Warranties
9.1 Each party represents and warrants to the other party that:
9.1.1 it has authority to enter into and be bound by this agreement; and
9.1.2 the execution of this agreement and the performance of its obligations hereunder do not and will not violate any other agreement by which the party is bound.
9.2 During and for one year after the end of this Agreement, the Affiliate promises that it will not encourage, seek to persuade, influence, employ, seek to employ, offer or conclude any contract for services with anybody who was a director or employed by the Company at any time during the term of this Agreement. The Affiliate also agrees that it will not carry out any such actions on behalf of somebody else or facilitate such actions on behalf of somebody else during the same period.
10. Liability
10.1 Any provisions in this agreement excluding or limiting liability will apply regardless of the form of action, whether under statute, in contract or tort including negligence or otherwise. Nothing in this agreement in any way excludes or restricts either party’s liability for negligence causing death or personal injury or for fraudulent misrepresentation or for any liability which may not legally be excluded or limited.
10.2 The Company shall not be liable for breach of this agreement unless the Affiliate has given the Company prompt notice of the breach in Writing and a reasonable opportunity thereafter to rectify the breach at the Company’s expense.
10.3 The liability of the Company under or in connection with this agreement for any one event or series of related events is limited to the total fees payable to the Affiliate under this agreement in the 12 months before the event(s) complained of.
10.4 In no event (including the Company’s own negligence) will the Company be liable for any:
10.4.1 economic losses (including, without limit, loss of revenues, profits, contracts, business or anticipated savings);
10.4.2 loss of goodwill or reputation;
10.4.3 special, indirect or consequential losses; or
10.4.4 damage to or loss of data
(even if the Company has been advised of the possibility of such losses).
10.5 Both parties exclude all terms that are not expressly stated herein, including but not limited to any implied warranties as to quality, fitness for purpose or ability to achieve a particular result.
11. Indemnity
11.1 The Affiliate will indemnify and hold harmless the Company and its successors, assigns, parent, subsidiaries and affiliates, and its directors, officers, employees, and agents against all losses, damages, liabilities, and expenses (including reasonable legal fees) arising from (1) any Medium or (2) any breach by the Affiliate of this agreement. The Company shall have the right to withhold its reasonable estimate of the total damages and costs from sums otherwise payable to the Affiliate pursuant to this or any other agreement between the parties, and to apply such sums to payment of such damages and expenses. The Company shall have the sole right to control the defence and settlement of any such claim save that the Company shall consult with the Affiliate prior to any settlement. The Affiliate agrees to provide reasonable assistance to the Company at the Affiliate’s expense in the defence of same.
12. Confidentiality
12.1 The Affiliate shall during the period of this agreement and indefinitely thereafter keep secure and confidential and not disclose to any other person or use other than for the purposes of this agreement any Confidential Information and shall not through any failure to exercise all due care and diligence cause or permit any unauthorised disclosure of any Confidential Information.
12.2 This clause shall not apply to:
12.2.1 information which becomes public knowledge or has been published other than through a breach of this agreement;
12.2.2 information lawfully in the possession of the recipient before the disclosure took place;
12.2.3 information obtained from a third party who is free to disclose it; and
12.2.4 information which a party is requested to disclose and if it did not could be required by law or regulation or competent authority to do so.
13. Intellectual Property Rights
13.1 The Company shall retain ownership of all Intellectual Property Rights in the Data used to supply the Services. The Company grants the Contractor a licence to use the Services for the purpose of and subject to this agreement.
14. Data Protection
14.1 Both parties will comply with all applicable requirements of the Data Protection Legislation. This clause 14.1 is in addition to, and does not relieve, remove or replace, a party’s obligations under the Data Protection Legislation.
14.2 The parties acknowledge that for the purposes of the Data Protection Legislation, the Affiliate is the data controller and the Company is the data processor (where Data Controller and Data Processor have the meanings as defined in the Data Protection Legislation). The Privacy Policy sets out the scope, nature and purpose of processing by the Company, the duration of the processing and the types of personal data (as defined in the Data Protection Legislation, Personal Data).
14.3 By accepting these Terms and Conditions, the Affiliate agrees to the Company processing Personal Data on its behalf in accordance with the Privacy Policy.
14.4 Without prejudice to the generality of clause 14.1, the Affiliate will ensure that it has all necessary appropriate consents and notices in place to enable lawful transfer of the Personal Data to the Company for the duration and purposes of this agreement.
14.5 The Affiliate undertakes and agrees to not pass any Personal Data when passing information through Sub ID, Unique ID, Click ID and/or Source ID data fields when using or customising tracking links. If any Personal Data is passed in this way in error, this will be retained in accordance with the Company’s Data Retention Policy.
14.6 Without prejudice to the generality of clause 14.1, the Company shall, in relation to any Personal Data processed in connection with the performance by the Company of its obligations under this agreement:
14.6.1 ensure that it has in place appropriate technical and organisational measures to protect against unauthorised or unlawful processing of Personal Data and against accidental loss or destruction of, or damage to, Personal Data, appropriate to the harm that might result from the unauthorised or unlawful processing or accidental loss, destruction or damage and the nature of the data to be protected, having regard to the state of technological development and the cost of implementing any measures (those measures may include, where appropriate, pseudonymising and encrypting Personal Data, ensuring confidentiality, integrity, availability and resilience of its systems and services, ensuring that availability of and access to Personal Data can be restored in a timely manner after an incident, and regularly assessing and evaluating the effectiveness of the technical and organisational measures adopted by it);
14.6.2 ensure that all personnel who have access to and/or process Personal Data are obliged to keep the Personal Data confidential;
14.6.3 only transfer Personal Data outside of the European Economic Area if the following conditions have been fulfilled:
(a) the Affiliate or the Company has provided appropriate safeguards in relation to the transfer;
(b) the data subject has enforceable rights and effective legal remedies;
(c) the Affiliate complies with its obligations under the Data Protection Legislation by providing an adequate level of protection to any Personal Data that is transferred;
(d) and the Affiliate complies with reasonable instructions notified to it in advance by the Visitor with respect to the processing of the Personal Data;
14.6.4 assist the Affiliate, at the Affiliate’s cost, in responding to any request from a Data Subject and in ensuring compliance with its obligations under the Data Protection Legislation with respect to security, breach notifications, impact assessments and consultations with supervisory authorities or regulators;
14.6.5 notify the Affiliate without undue delay on becoming aware of a Personal Data breach;
14.6.6 at the written direction of the Affiliate, delete or return Personal Data and copies thereof to the Affiliate on termination of the agreement unless:
(a) required by Applicable Laws to store the Personal Data, or
(b) the Personal Data relates to Visitors of the Affiliate Website, which will be retained in accordance with the Company’s Data Retention Policy, a copy of which is available upon request; and
14.6.7 maintain complete and accurate records and information to demonstrate its compliance with this clause 14.6.
14.7 The Affiliate consents to the Company appointing third party processors of Personal Data under this agreement, the details of which are found in the Privacy Policy.
14.8 The Company confirms that it will retain any Personal Data it processes on behalf of the Affiliate in accordance with the Company’s Data Retention Policy, a copy of which can be provided upon request.
14.9 The Affiliate may, from time to time, be required to process Personal Data on behalf of the Company. The Affiliate must retain any Personal Data in accordance with the Company’s Data Retention Policy and agrees to the same obligations placed upon the Company by virtue of clauses 14.4 above.
15. Force Majeure
15.1 Neither party is liable for failure to perform or delay in performing any obligation under this agreement if the failure or delay is caused by any circumstances beyond that party’s reasonable control including third party telecommunication failures.
16. Notices
16.1 Any notice or other information required or authorised by this agreement to be given by any party may be given by hand or sent (by recorded / special / international signed-for delivery) to another party at its registered office or at the address shown on this agreement or such other address as that party may notify to the other party for this purpose from time to time or, unless stated otherwise, by email.
16.2 Any notice or other information given by post which is not returned to the sender as undelivered shall be deemed to have been given on the second day after the envelope containing the same was so posted and proof that the envelope containing any such notice or information was properly addressed pre-paid, registered and posted, and that it has not been so returned to the sender, shall be sufficient evidence that such notice or information has been duly given.
16.3 Any email shall be deemed to have been received on the date of transmission provided that the email has not been returned.
17. General
17.1 In this agreement the word “including”, unless the context otherwise requires, shall mean “including without limitation”. The headings in this agreement are for convenience only and shall not affect its interpretation.
17.2 This agreement and any document incorporated herein by reference constitute the entire agreement between the parties with respect to its subject matter and supercedes any previous communications or agreements between the parties. Both parties acknowledge that there have been no misrepresentations and that neither party has relied on any pre-contractual statements. Liability for misrepresentation (excluding fraudulent misrepresentation) relating to the terms of this agreement is excluded.
17.3 Except insofar as provided otherwise in this agreement, nothing in this agreement will constitute or be deemed to constitute a partnership or joint venture between the parties and neither party has express or implied authority to bind the other in any manner whatsoever and neither party will purport to do so.
17.4 The Affiliate shall not assign or subcontract any part of its obligations under this agreement without the prior consent in Writing of the Company.
17.5 The failure of a party to exercise or enforce any right under this agreement shall not be deemed to be a waiver of that right nor operate to bar the exercise or enforcement of it at any time or times thereafter.
17.6 If any provision of this agreement is held to be unlawful, void or unenforceable in whole or in part, this agreement shall continue in force in relation to the unaffected provisions and the remainder of the provision in question, and the parties will renegotiate the offending provision in good faith to achieve the same objects.
17.7 Save insofar as expressly provided otherwise in this agreement, no third party may enforce any clause in this agreement under the Contracts (Rights of Third parties) Act 1999.
17.8 This agreement shall be governed by and construed in all respects in accordance with the laws of England and Wales and each party hereby submits to the exclusive jurisdiction of the courts of England and Wales.
</textarea>
                </div>

                <div class="mb-1 mt-1 col-md-12">
                  <div class="form-check mb-3">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" name="Terms" value="1">Terms & Conditions
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 mb-4">
                    <div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="6Le5c1IiAAAAAHxPwO5TPt_BCHqQ9g1vokiJBJFy"></div>
                  </div>
                </div>
                <button type="submit" id="btn-submit" class="btn btn-primary">Create New Account</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-4">



        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    function getpayment() {

      var paymentMethod = $("#drpPaymetMethod").val();

      $(".modeofpayment").hide();
      $("." + paymentMethod.toLowerCase()).show();

    }

    //===============To stop refreshing page with Enter Key =================//
    document.getElementById("signup-affiliate").onkeypress = function(e) {
      var key = e.charCode || e.keyCode || 0;

      if (key == 13) {
        // alert("No Enter!");
        e.preventDefault();
      }
    }

    //===============Concatenating | operator with brand names with Enter buttons =================//
    // var brandName = document.getElementById("state");
    // brandName.addEventListener("keyup", function(e) {

    //   if (e.keyCode == 13) {
    //     e.target.value += " | ";
    //     console.log("This is targeted value", e.target.value);
    //   }
    // });

    $('.tokenize-custom-demo1').tokenize2({
      tokensAllowCustom: true
    });
  </script>
  <?php
  include('includes/footer.php');
  ?>