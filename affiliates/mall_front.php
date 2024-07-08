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
$affEcrptid=MultipleTimeEncode($AFFILIATEID);

$selectedAffCats = [];
$selectedAffPages = [];

$sql	=	"SELECT * FROM partners_affiliate_pages WHERE affiliateid = '$AFFILIATEID'";
$ret	=	mysqli_query($con, $sql);
if ($ret) {
	while ($row = mysqli_fetch_array($ret)) {
		$selectedAffPages[] = $row;
	}
}

#Approved 
// $approved_status="SELECT * FROM `partners_joinpgm` WHERE joinpgm_affiliateid=$aff_id";
// $statusApproved=mysqli_query($con,$approved_status);
// $approved = mysqli_num_rows($statusApproved);

//=================getting total no of approved programs joined by affiliate
$sql_approved   = "SELECT * FROM partners_program, partners_joinpgm, partners_merchant
    WHERE joinpgm_status='approved'  AND joinpgm_affiliateid='$aff_id' 
 AND program_status = 'active' AND merchant_status LIKE ('approved') AND joinpgm_programid = program_id AND program_merchantid = merchant_id";
$ret_approved     = mysqli_query($con, $sql_approved);
// print_r($ret_approved);
$approved = mysqli_num_rows($ret_approved);
// =================end===========================//
$sql	=	"SELECT * FROM partners_affiliate WHERE affiliate_id='$AFFILIATEID'";
$ret	=	mysqli_query($con, $sql);
if ($ret) {
	while ($row = mysqli_fetch_array($ret)) {
		$key = $affiliateSecretKey = $row['affiliate_secretkey'];
	}
} else {
	echo "error";
}

$sql_pgm = "SELECT link_override_value FROM partners_affiliate WHERE affiliate_id = $aff_id";
$result = mysqli_query($con, $sql_pgm);
$override_value = mysqli_fetch_assoc($result);
if ($override_value['link_override_value'] == 0) {
	$value = 'OFF';
} else {
	$value = 'ON';
}


$sql1	=	"SELECT * FROM partners_affiliate WHERE affiliate_id='$AFFILIATEID'";
$ret1	=	mysqli_query($con, $sql1);
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
$categoryArray = [];
$categoryArray = explode(",", $categoryNames);

$selected_countries_id = "";
foreach ($countryArray as $country) {
	$selected_countries_id .= $country . ",";
	// echo "Countries" . $country . "</br>";
}
$selected_countries_no = rtrim($selected_countries_id, ',');

foreach ($categoryArray as $category) {
	// echo "Categories" . $category . "</br>";
}
$sql    = "SELECT * FROM partners_country";
$result = mysqli_query($con, $sql);
foreach ($result as $data) {
	$newarr[] = $data;
}

$sql = "SELECT * FROM color_picks WHERE affiliate_id = '$aff_id'";
$result = mysqli_query($con, $sql);
foreach($result as $row){
	$lastsercolor =$row['search_color'];
	$lastNamecolor=$row['name_color'];
	$lastbtncolor =$row['button_color'];
}
if ($lastsercolor == '') {
  $lastsercolor = "#000";
}
if ($lastNamecolor == '') {
  $lastNamecolor = "#000";
}
if ($lastbtncolor == '') {
  $lastbtncolor = "#000";
}
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
	<h4 class="card-title"><strong>How to use the Code for Mall Front</strong> </h4>
	<p>Our code is so efficient you can be up and running in seconds and you will not need to update it!<br>
		To insert the code simply follow the instructions below.</p>
		<ol>
			<li>Copy your unique code "CTRL + C".</li>
			<li>Paste the code between the "< head>" tags on your website.</li>
			<li>Change the colours of the Search Bar, Card and Button to match the theme of the rest of your website.</li>
			<li>That's it you're ready to go!!</li>
		</ol>
			<p>The more pages that have the code the more revenue you will generate!</P>
    </div>
	</div>
    <div class="col card stacked-form trackcode_form p-5 mb-4">
	<div class="card-body">
    <!-- <iframe controls id="myvideo" src="https://www.youtube.com/embed/as2GrTjELEk" title="PoweredWords how To Guide" width="400" height="250"> -->
      <iframe width="400" height="250" src="https://www.youtube.com/embed/EnUQ94qJUWg" title="MallFront how To Guide" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
	</iframe>
	<button onclick="openFullscreen();" >Open Video in Fullscreen Mode</button>
	<p><strong>Tip:</strong> Press the "Esc" key to exit full screen.</p>
    </div>
	</div>
  </div>
</div>
<!-- Live Demo Block -->
<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form trackcode_form">
			<div class="card-body">
				<h4 class="card-title">Live Demo Websites</h4>
        <p>Check out these 3 demo sites!</p>
        <a href="https://performanceaffiliate.com/performanceAffiliateClone/refApis/wedding/mall_front.html" target="_blank" class="btn btn-info">Visit Demo</a>
        <a href="https://performanceaffiliate.com/performanceAffiliateClone/refApis/agency/mall_front.html"  target="_blank" class="btn btn-info">Visit Demo</a>
        <a href="https://performanceaffiliate.com/performanceAffiliateClone/refApis/constra/mall_front.html" target="_blank" class="btn btn-info">Visit Demo</a><br>
       
      </div></div></div></div>
<!-- End Live demo Block -->
<!-- Color Change Block  -->
<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form trackcode_form">
			<div class="card-body">
				<h4 class="card-title">Colour Change</h4>
				<div class="">
					<form  id="color-form" method="post">
						<b style="margin-right: 20px;">Select your search colour:</b>
				    	<input type="text" id="color-input1" name="color" onchange="searchColor()" class="color-input " value="<?= $lastsercolor ?>"> <br> <br>
					  <!-- Search -->
            <div class="col-md-5" style="float: right; margin-top:-60px">
    <form class="xt-blog-form" role="search">
        <div class="input-group add-on">
          <input class="form-control" placeholder="Search A Retailer" name="srch-term" id="srch-term" type="text" disabled>
          <div class="input-group-btn">
            <span class="btn btn-default search-btn" type="submit" id="search_color">
                <i class="fa fa-search"></i>
            </span>
           
          </div>
        </div>
       
    </form>
  </div> 
  <!-- <i class="fa fa-long-arrow-up fa-4x"></i><br><br><br> -->
  <hr>
  <!-- Search -->
	<!-- card -->
        <b style="margin-right: 36px;">Select your card colour:</b> 
        <input type="text" id="color-input2" onchange="cardColor()" class="color-input"  value="<?= $lastNamecolor ?>" required><br><br>     

        <div class="perAffcard">
  <div class="perAffdiscount-label labelDiv">Discount 10%</div><br>
  <center><img src="https://www.awin1.com/cshow.php?s=2402949&amp;v=12590&amp;q=364258&amp;r=37293" alt="Product Image" class="perAffpro-img"><br>
  <strong class="perAffproduct-name textDiv">Acer UK</strong><br>
  <p class="perAffproduct-description">Explore the Official Acer
  Store UK. Free Shipping &amp; Returns Save now on the latest Acer tech product</p>
  <a href="#" style="text-decoration: none; color:<?= $lastNamecolor ?>" class="viewDiv">View</a></center>
</div>
        <!-- <i class="fa fa-long-arrow-right fa-5x right-arrow" style="margin-top:-80px;"></i><br>
        <i class="fa fa-long-arrow-right fa-5x right-arrow" style="margin-top:30px;"></i><br>
        <i class="fa fa-long-arrow-right fa-5x right-arrow" style="margin-top:40px;"></i><br> -->
        <br><br><br><br><br><br><br><br><br><br> <hr>
					<!-- card -->
					<!-- visit button -->
						<b style="margin-right: 22px;" >Select your button colour:</b>
						<input type="text" id="color-input3" onchange="btnColor()" class="color-input"  value="<?= $lastbtncolor ?>" > <br><br><br>
						<button type="button" style="float: right; color:#fff; margin-top: -86px; background-color:<?= $lastbtncolor ?>" class="btn" id="visitbtn"> Visit Now </button>
            <!-- <i class="fa fa-long-arrow-right fa-5x visit-arrow"></i> -->
            <br>

					</form>
				</div>
			</div>
		</div>
	</div>
</div> 

<!-- Code For Mall Front -->
<div class="row">
	<div class="col-md-8">
		<div class="card stacked-form trackcode_form">
			<div class="card-body">
				
				<h4 class="card-title">Code for Mall Front</h4>
				<div class="form-group">
					<textarea rows="6" cols="5" name="headertxt"  class="form-control"><div id="sfPerAff"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script> var PerAffconToken ='<?= $affEcrptid ?>';</script>
<script src="https://performanceaffiliate.com/performanceAffiliateClone/affiliates/shop_Front_Apis/js/mainShopFrontPerAff.js"></script></textarea>
				</div>
      
			</div>
		</div>
	</div>
        <div class="col-md-4">
        <div class="card stacked-form ">
        <div class="card-body">
				
				<p class="card-title">Programmes that have you joined:<b><?= $approved ?></b></p><br>
				<div class="form-group">
        <p >Here you can check out what your mall front will look like once you have installed the code on your website, simply click the button below.</p>
        <a href="https://performanceaffiliate.com/performanceAffiliateClone/refApis/test.php?PerAffconToken=<?=$affEcrptid?>" target="_blank" class="btn btn-info">Check Your Own</a>
        </div></div>  
      </div>
        </div>
</div>



<!-- Script -->
<script>
function searchColor() {
  var colorInput = document.querySelector("input[type=text]");
  var colorDiv = document.querySelector("#search_color");
  colorDiv.style.backgroundColor = colorInput.value;
}
function cardColor() {
  var colorInput = document.getElementById("color-input2");
  var labelDiv = document.querySelector(".labelDiv");
  var textDiv = document.querySelector(".textDiv");
  var viewDiv = document.querySelector(".viewDiv");
  labelDiv.style.backgroundColor = colorInput.value;
  textDiv.style.color = colorInput.value;
  viewDiv.style.color = colorInput.value;
}
function btnColor() {
  var colorInput = document.getElementById("color-input3");
  var colorDiv = document.querySelector("#visitbtn");
  colorDiv.style.backgroundColor = colorInput.value;
}

</script>

<script>
	
	$(document).ready(function() {
	// Color 1
	$ser_color=$('#color-input1').val();
	$namecolor=$('#color-input2').val();
	$btnColor=$('#color-input3').val();
	$('#color-input1').on('change', function() {
		// Get the selected color
    var ser_color = $(this).val();
	var namecolor= $('#color-input2').val();;
	var btnColor = $('#color-input3').val();;
    
    // Send an AJAX request to store the color selection
    $.ajax({
      url: 'https://performanceaffiliate.com/performanceAffiliateClone/affiliates/store_color.php',
      type: 'POST',
      data: { searchcolor: ser_color, namecolor: namecolor, btnColor: btnColor},
      success: function(data) {
        // Handle the response from the server
        console.log(data);
      }
    });
  });
// Color 2
  $('#color-input2').on('change', function() {
	var namecolor = $(this).val();
	var btnColor = $('#color-input3').val();;
	var ser_color = $('#color-input1').val();
	$.ajax({
      url: 'https://performanceaffiliate.com/performanceAffiliateClone/affiliates/store_color.php',
      type: 'POST',
      data: {namecolor: namecolor, searchcolor: ser_color, btnColor: btnColor},
      success: function(data) {
        // Handle the response from the server
        console.log(data);
      }
    });
});

// Color 3
$('#color-input3').on('change', function() {
	var btnColor   = $(this).val();
	var namecolor  = $('#color-input2').val();
	var ser_color=$('#color-input1').val();
	$.ajax({
      url: 'https://performanceaffiliate.com/performanceAffiliateClone/affiliates/store_color.php',
      type: 'POST',
      data: {btnColor: btnColor, namecolor: namecolor, searchcolor: ser_color},
      success: function(data) {
        // Handle the response from the server
        console.log(data);
      }
    });
});


});

</script>
<!-- color script -->
<script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>

<script>
	let colorIndicator = document.getElementById('color-indicator');
	const colorPicker = new iro.ColorPicker("#color-picker", {
		width:180, color: "#fff"
	});
	colorPicker.on('color:change', function(color) {
		colorIndicator.style.backgroundColor = color.hexString;
	});
</script>
<!-- Color script-->
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
.fa-long-arrow-up{
	float: right;
	color: red;
  margin-right: 32px;
}
.visit-arrow{
  color: #ff0000;
  margin-left: 81%;
  margin-top:-11%;
}
.right-arrow{
  color: #ff0000;
  margin-left: 70%;
}

/* arrow */
.search-btn {
background: <?= $lastsercolor ?>;
  color: #fff;
}
.btn-info{
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
  border-radius:12px 0 0;
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
  border-radius:12px 0 0;
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