<?php
include_once '../includes/session.php';
include_once '../includes/constants.php';
include_once '../includes/functions.php';




#Custom part for tags

// function select_options($selected = array())
// {
//     $output = '';
//     foreach (json_decode(file_get_contents('names.json'), true) as $item) {
//         $output .= '<option value="' . $item['value'] . '"' . (in_array($item['value'], $selected) ? ' selected' : '') . '>' . $item['text'] . '</option>';
//     }
//     return $output;
// }


$partners = new partners;
$partners->connection($host, $user, $pass, $db);
//https://searlco.net/merchants/index.php?Act=accounts&msg=Invalid%20Entry.%20Please%20fill%20in%20all%20required%20fields%20&firstname=Andy&lastname=Reeve&company=Searlco%20TEST%20Merchant&url=www.searlco.net&city=ulceby&category=Entertainment&phone=07590124248&fax=&mailid=&type=normal&country=United%20Kingdom&state=Lincolnshire&zip=DN39%206UQ&taxId=1235467489&sub=submitted
$err = $_GET['msg'];
$note = $_REQUEST['suc_msg'];

if (!empty($err)) {

    $firstname        = stripslashes(trim($_GET['firstname']));
    $lastname         = stripslashes(trim($_GET['lastname']));
    $company          = stripslashes(trim($_GET['company']));
    $url              = stripslashes(trim($_GET['url']));
    $address          = stripslashes(trim($_GET['address']));
    $city             = stripslashes(trim($_GET['city']));
    $category         = stripslashes(trim($_GET['category']));
    $phone            = stripslashes(trim($_GET['phone']));
    $fax              = stripslashes(trim($_GET['fax']));
    $mailid           = stripslashes(trim($_GET['mailid']));
    $type             = stripslashes(trim($_GET['type']));
    $state            = stripslashes(trim($_GET['state']));
    $zip              = stripslashes(trim($_GET['zip']));
    $taxId            = stripslashes(trim($_GET['taxId']));
    $country          = $_GET['country'];

    //$address          =stripslashes(trim($_GET['address']));
    //$address          = $_SESSION['MER_ADDRESS'];
}

$sql    = "select * from partners_login where login_id ='$MERCHANTID' and login_flag='m'";
$result = mysqli_query($con, $sql);



while ($row = mysqli_fetch_object($result)) {
    $emailid = $row->login_email;
    $origin = $row->login_email;
    $oldpassword = $row->login_password;
}

if ($err == "") {

    $sql = "select * from partners_merchant where merchant_id='$MERCHANTID'";
    $res = mysqli_query($con, $sql);
    echo mysqli_error($sql);

    while ($row = mysqli_fetch_object($res)) {
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
    }
}  //closing of err if

// echo $brand . "</br>";
// echo "Country of permotions from Partner_Country:" . $countryPermotion . "</br>";
$brandArray = explode('|', $brand);

$sql1    =    "SELECT * FROM partners_affiliate WHERE affiliate_id='$AFFILIATEID'";
$ret1    =    mysqli_query($con, $sql1);
if ($ret) {
    while ($row = mysqli_fetch_array($ret1)) {
        $countryNo = $row['affiliate_country'];
        $categoryNames = $row['affiliate_category'];
    }
} else {
    echo "error";
}
$countryArray = [];
$countryArray = explode(",", $countryNo);


//========================Start For Multiple tags for Country of promotion========================//
if ($err == "") {

    $sqlCop = "select * from mer_cop where client_id='$MERCHANTID'";
    $res = mysqli_query($con, $sqlCop);
    echo mysqli_error($sqlCop);
    $cops = [];
    while ($row = mysqli_fetch_object($res)) {

        array_push($cops, stripslashes(trim($row->cop_id)));
    }
}  //closing of err if

// $selected_countries_id = "";
// foreach ($cops as $countrypromo) {
//     $selected_countries_id .= $countrypromo . ",";
//     //echo "Countries" . $country . "</br>";
// }
// $selected_countries_no = rtrim($selected_countries_id, ',');

// $sql    = "SELECT * FROM partners_country";
// $result = mysqli_query($con, $sql);
// foreach ($result as $data) {
//     $newarr[] = $data;
// }
// $json_data = json_encode($newarr);
// file_put_contents('file.json', $json_data);

// function country($selected = array())
// {
//     $output = '';
//     // foreach(json_decode(file_get_contents('file.json'), true) as $item){
//     foreach (json_decode(file_get_contents('file.json'), true) as $item) {
//         $output .= '<option value="' . $item['country_no'] . '"' . (in_array($item['country_no'], $selected) ? ' selected' : '') . '>' . $item['country_name'] . '</option>';
//     }
//     return $output;
// }
//========================End For Multiple tags for Country of promotion========================//



foreach ($cops as $countrypromo) {
    // echo "Country of permotions from mer_cop:" . $countrypromo . "</br>";
}




?>

<script id="clientEventHandlersJS" language="javascript" type="text/javascript">
    function a1_onclick(id) {
        console.log(id);
        //window.open("login_edit.php",200,100);
        window.open("login_edit.php?merchant=" + id, 'new', 'height=250,width=500,scrollbars=no');

    }

    //-->
</script>



<div class="row">
    <div class="col-md-6">
        <div class="card stacked-form">
            <div class="card-header">
                <span class="textred"><?= stripslashes($fromprg) ?>&nbsp;</span>
                <h4 class="card-title"><?= $lang_MerchantLoginInfo ?></h4>
                <p><b><?= stripslashes($_GET['msg1']) ?></b></p>
                <span class="textred"><?= $Err ?></span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label><?= $lang_EmailId ?></label>
                    <input type="text" name="login" class="form-control" size="25" value="<?= $emailid ?>" />
                </div>
                <div class="form-group">
                    <label><?= $lang_Password ?></label>
                    <input type="password" name="password" class="form-control" size="25" value="<?= $oldpassword ?>" />
                </div>
                <div class="form_editlink">
                    <a href="#" id="a1" onclick="return a1_onclick(<?= $MERCHANTID ?>)" class="btn btn-fill btn-info"><?= $lang_Edit ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card stacked-form">
            <div class="card-header">
                <span class="textred">&nbsp;</span>
                <h4 class="card-title">Merchant Logo</h4>
                <span class="textred"></span>
            </div>
            <div class="card-body">
                <form id="Ajaxform">
                    <?php if ($merchant_profileimage != '') {
                    ?>
                        <div class="addimg_preview">
                            <img src="<?php echo 'uploadedimage/' . $merchant_profileimage; ?>" id="" height="150" width="150">
                        </div>
                    <?php
                    } ?>
                    <div class="img_preview" style="display:none;">
                        <div class="im_progress">
                            <!--<img class="loader_img" src="ajax-loader.gif">-->
                            Loading.....
                        </div>
                        <img src="" id="img_preview" height="150" width="150">
                    </div>
                    <div class="All_images"></div>
                    <label for="logo" style="font-size:16px;">Select Logo:</label>
                    <input type="file" name="ajax_file" id="Fileinput" onchange="readURL(this);">
                </form>
                <div class="img_upload_err">
                    <span class="textred">Please Note: Logo's Must be 150*150 Pixels. Only JPEG, GIF, PNG</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card stacked-form">
            <div class="card-header">
                
                <h4 class="card-title">BRANDS YOU SELL</h4>
                
                <span class="textred"></span>
            </div>
            <div class="card-body wrappers">
                <div class="contents">
                    <ul class="example"><input type="text" class="input_example" spellcheck="false"></ul>
                </div>
                
                <div class="message_box" style="margin:10px 0px;">

                </div>

            </div>
        </div>
        <script src="../tagsAssets/script.js" type="text/javascript"></script>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card stacked-form">
            <!-- <form method="post" name="reg" action="accounts_validate.php?mode=update"> -->
            <form method="post" id="signup-affiliate" name="reg" action="accounts_validate.php?confNew=vich">
                <div class="card-header">
                    <h4 class="card-title"><?= $lang_MerchantContactInfo ?></h4>
                    <p><b><?= $err ?>&nbsp;<?= $note ?></b></p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= $lang_FirstName ?></label>
                                <input type="text" name="firstnametxt" class="form-control" size="20" value="<?= $firstname ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_LastName ?></label>
                                <input type="text" name="lastnametxt" class="form-control" size="20" value="<?= $lastname ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_Company ?></label>
                                <input type="text" name="companytxt" class="form-control" size="20" value="<?= $company ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_URL ?></label>
                                <input type="text" name="urltxt" class="form-control" size="20" value="<?= $url ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_Address ?></label>
                                <textarea rows="2" name="addresstxt" class="form-control textarea_contrl"><?= $address ?></textarea>
                            </div>
                            <div class="form-group">
                                <label><?= $lang_state ?></label>
                                <input type="text" name="statetxt" class="form-control" size="20" value="<?= $state ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_Type ?></label>
                                <input name="typelst" type="hidden" value="<?= trim($type) ?>" />
                                <select size="1" class="form-control" name="typelst" disabled="disabled">
                                    <?
                                    if (trim($type) == "nill") {
                                        $nill = "selected = 'selected'";
                                    }
                                    if (trim($type) == "advance") {
                                        $adv = "selected = 'selected'";
                                    }
                                    if (trim($type) == "normal") {
                                        $nor = "selected = 'selected'";
                                    }
                                    ?>
                                    <option value="nill"><?= $account_selecttype ?></option>
                                    <option value="advance" <?= $adv ?>><?= $account_advance ?></option>
                                    <option value="normal" <?= $nor ?>><?= $account_normal ?></option>
                                </select>
                            </div>

                            

                            <div class="form-group">
                                <label> Select Your Main Country of promotion </label>

                                <select multiple id=Country name="Countrypromotion[]" data-placeholder="Select a Country" name="categorylst" class="custom-select form-control">
                                    <!-- <option selected='selected' value="nill"><?= $selectacategory ?></option> -->
                                    <?php
                                    // $sql1    = "SELECT * FROM partners_category WHERE cat_name NOT IN ($finalCattVal)";
                                    $sql    = "SELECT * FROM partners_country";
                                    $result2 = mysqli_query($con, $sql);
                                    ?>
                                    <?php
                                    while ($row = mysqli_fetch_object($result2)) {

                                        foreach ($cops as $countrycop) {
                                            if ($countrycop === $row->country_no) {

                                    ?>
                                                <option value="<?= $row->country_no ?>" selected><?= $row->country_name ?></option>
                                        <?php }
                                        } ?>

                                        <option value="<?= $row->country_no ?>"><?= $row->country_name ?></option>
                                    <?php } ?>
                                </select></<br>


                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= $lang_Category ?></label>
                                <select size="1" class="form-control" name="categorylst">
                                    <option value="nill">----<?= $selectacategory ?>----</option>
                                    <?php
                                    $sql    = "select * from partners_category";
                                    $result = mysqli_query($con, $sql);
                                    ?>
                                    <?php
                                    while ($row = mysqli_fetch_object($result)) {
                                        if (trim($category) == trim($row->cat_id) || trim($category) == trim($row->cat_name)) {
                                    ?>
                                            <option value="<?= $row->cat_id ?>" selected="selected"><?= $row->cat_name ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $row->cat_id ?>"><?= $row->cat_name ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?= $lang_Phone ?></label>
                                <input type="text" name="phonetxt" class="form-control" size="20" value="<?= $phone ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_Fax ?></label>
                                <input type="text" name="faxtxt" class="form-control" size="20" value="<?= $fax ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_zip ?></label>
                                <input type="text" name="ziptxt" class="form-control" size="20" value="<?= $zip ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_City ?></label>
                                <input type="text" name="citytxt" class="form-control" size="20" value="<?= $city ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $lang_Country ?></label>
                                <select class="form-control" size="1" name="countrylst">
                                    <option value="nill">----<?= $lang_SelectaCountry ?>----</option>
                                    <?php
                                    $sql    = "select * from partners_country";
                                    $result = mysqli_query($con, $sql);
                                    ?>
                                    <?php
                                    while ($row = mysqli_fetch_object($result)) {
                                        if ($mer_country == $row->country_no || $mer_country == $row->country_name) {
                                    ?>
                                            <option value="<?= $row->country_no ?>" selected="selected"><?= $row->country_name ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $row->country_no ?>"><?= $row->country_name ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?= $lang_taxId ?></label>
                                <input type="text" name="taxIdtxt" class="form-control" size="20" value="<?= $taxId ?>" />
                            </div>


                            <!-- <div class="form-group">
							<label>Brand-Power</label> -->
                            <!-- <input type="text" name="brandpower" class="form-control" value="" /> -->
                            <!-- <select class="form-control" size="1" name="brandpower">
								<option value="<?= $brandpower ?>"><?= $brandpower ?></option> -->
                            <!-- <option value="nill">.........................</option> -->
                            <!-- <option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							
							</select>
						</div> -->


                        </div>
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-fill btn-info" value="<?= $account_editcont ?>" name="B1" alt="<?= $lang_Edit ?>" />&nbsp;
                                <?
                                if ($type == "normal") {
                                ?>

                                <?
                                }
                                ?>
                                <input name="status" type="hidden" value="<?= $status ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>





<!-- Added on 25-July-2006 for merchants Sign Up lik for the Merchant  -->
<?
$linkobj    = new merchantLink();

$linkobj->merchantSignUpLink($MERCHANTID);
$mer_header    = $linkobj->mer_header;
$mer_footer    = $linkobj->mer_footer;

?>
<div class="row">
    <div class="col-md-12">
        <div class="card stacked-form">
            <form method="post" name="signup" action="" onSubmit="return ValidateSignUp();">
                <div class="card-header text-center">
                    <h4 class="card-title"><?= $lang_merchantSignUpLink ?></h4>
                    <!--<p><b><? //=$lang_merchantSignUpHelp
                                ?></b></p>-->
                </div>
                <div class="card-body">
                    <!--<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><? //=$lang_MerchantHeader
                                        ?></label>
								<textarea name="txt_header" class="form-control textarea_contrl" rows="5"></textarea>
								<a href="#" onClick="window.open('viewlink.php?merid=<? //=$MERCHANTID
                                                                                        ?>&disp=header','new','100,400,scrollbars=1,resizable=1')" ><? //if($mer_header){ echo $lang_viewheader; } 
                                                                                                                                                    ?></a>
							</div>
						</div> 
						<div class="col-md-6">
							<div class="form-group">
								<label><? //=$lang_MerchantFooter
                                        ?></label>
								<textarea name="txt_footer" class="form-control textarea_contrl" rows="5"></textarea>
								<a href="#" onClick="window.open('viewlink.php?merid=<? //=$MERCHANTID
                                                                                        ?>&disp=footer','new','100,400,scrollbars=1,resizable=1')" ><? //if($mer_footer){ echo $lang_viewfooter; } 
                                                                                                                                                    ?></a>
							</div>
						</div>  
						<div class="col-md-12">
							<div class="form-group text-center">
								<input type="submit" class="btn btn-fill btn-info" name="Signup" value="<? //=$common_submit
                                                                                                        ?>" />&nbsp;&nbsp;
								<input type="reset" class="btn btn-fill btn-default" name="cancel" value="<? //=$common_cancel
                                                                                                            ?>" />
							</div>
						</div>				
					</div>	-->
                    <div class="text-center">
                        <p><?= $lang_affiliateLinkHelp ?></p>
                        <p><b><a href="<?= $track_site_url . "/index.php?Act=Affiliates" ?>"><? echo $track_site_url . "/index.php?Act=Affiliates"; ?></a></b></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="js/tokenize2.min.js"></script>
<script language="javascript">
    function ValidateSignUp() {
        if (document.signup.txt_header.value == '') {
            alert('<?= $err_nullheader ?>');
            document.signup.txt_header.focus();
            return false;
        }
        if (document.signup.txt_footer.value == '') {
            alert('<?= $err_nullfooter ?>');
            document.signup.txt_footer.focus();
            return false;
        }
        document.signup.action = 'signuplink_validate.php?mid=<?= $MERCHANTID ?>';
        document.signup.submit();
    }


    //===============To stop refreshing page with Enter Key =================//
    document.getElementById("signup-affiliate").onkeypress = function(e) {
        var key = e.charCode || e.keyCode || 0;

        if (key == 13) {
            // alert("No Enter!");
            e.preventDefault();
        }
    }

    $('.tokenize-custom-demo1').tokenize2({
        tokensAllowCustom: true
    });
</script>
<script language="javascript">
    $("#brands_form").submit(function(e) {
        e.preventDefault();
        // Get input field values
        var UpdatedBrands = [];
        var UpdatedBrands = $('#UpdatedBrands').val();

        // Simple validation at client's end
        // We simply change border color to red if empty field using .css()
        var proceed = true;

        if (UpdatedBrands == "") {
            $('#UpdatedBrands').addClass('border-danger');
            console.log('error updating');
            proceed = false;
        }

        if (proceed) {
            // Insert the AJAX here.
            console.log("Brands names are showing with enter key pressed:", UpdatedBrands);
            for (updated of UpdatedBrands) {
                console.log(updated);
            }

            $.ajax({
                type: "POST",
                url: "multi_brands_validateTest.php",
                data: {
                    UpdatedBrands: UpdatedBrands
                },

                success: function(data) {
                    console.log(data)

                    $('.message_box').html(data);
                    $('.message_box').addClass("alert alert-success");
                    $('.message_box').show();
                    setTimeout(function() {
                        // alert(data);
                        $('.message_box').hide();
                    }, 3000);
                }
            });

        }
    });
</script>
