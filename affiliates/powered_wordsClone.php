<?php
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
$aff_id       = $_SESSION['AFFILIATEID'];
#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------
$AFFILIATEID;

$sql_pgm = "SELECT * FROM partners_program";
$result = mysqli_query($con, $sql_pgm);

$row = mysqli_num_rows($result);
echo  "pgm" . $row;
//  echo$Person_logged_In;

$sql	=	"SELECT * FROM partners_affiliate WHERE affiliate_id='$AFFILIATEID'";
$ret	=	mysqli_query($con, $sql);
if ($ret) {
	while ($row = mysqli_fetch_array($ret)) {
		$key = $row['affiliate_secretkey'];
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
	echo "Countries" . $country . "</br>";
}
$selected_countries_no = rtrim($selected_countries_id, ',');

foreach ($categoryArray as $category) {
	echo "Categories" . $category . "</br>";
}
$sql    = "SELECT * FROM partners_country";
$result = mysqli_query($con, $sql);
foreach ($result as $data) {
	$newarr[] = $data;
}
$json_data = json_encode($newarr);
file_put_contents('file.json', $json_data);
function select_options($selected = array())
{
	$output = '';
	foreach (json_decode(file_get_contents('file.json'), true) as $item) {
		$output .= '<option value="' . $item['country_no'] . '"' . (in_array($item['country_no'], $selected) ? ' selected' : '') . '>' . $item['country_name'] . '</option>';
	}
	return $output;
}

?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<style>
	.toggle-on.btn {
		color: aliceblue;
		font-weight: 900;
	}

	.toggle-off.btn {
		color: aliceblue;
		font-weight: 900;
	}

	.loader {
		border: 16px solid #f3f3f3;
		/* Light grey */
		border-top: 16px solid #3498db;
		/* Blue */
		border-radius: 50%;
		width: 60px;
		height: 60px;
		animation: spin 2s linear infinite;
		/* display: none; */
	}

	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	.swal2-html-container {
		text-align: -webkit-center;
		height: 70px;
	}
</style>



<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form trackcode_form">
			<div class="card-body">
				<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><? //=$lang_shoppingCartIntegration
																				?></a>-->
				<h3 class="card-title"><strong>How to use the Code for Powered Words</strong> </h3>
				<p>Our code is so efficient you can be up and running in seconds and you will not need to update it!<br>
					To insert the code simply follow the instructions below.</p>
				<div class="container">
					<div class="row">
						<div class="col-md-7">
							<ol>
								<li>Click the button "Join All Programs" Below.
									<p style="font-weight: 600; font-size:9px;">By clicking on the Join All Programs button you will be instantly approved to all the programs on the network!</p>
								</li>
								<li>Turn the "Link Override " button "Off" or "On".
									<p style="font-weight: 600; font-size:9px;">If you have old links in your website/blog this feature will replace them with new updated links that match keywords daily! No more lost revenue!</p>
								</li>
								<li>Copy your unique code "CTRL + C" </li>
								<li>Paste the code between the "< head>" tags on your website </li>
								<li>Thats it you're ready to go!!!</li>

							</ol>
						</div>
						<div class="col-md-5">
							<iframe controls id="myvideo" src="https://www.youtube.com/embed/as2GrTjELEk" title="PoweredWords how To Guide" width="350" height="250">
							</iframe>
							<button onclick="openFullscreen();">Open Video in Fullscreen Mode</button>
							<p><strong>Tip:</strong> Press the "Esc" key to exit full screen.</p>

						</div>

					</div>

				</div>
				<p>The more pages that have the code the more revenue you will generate!</P>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form trackcode_form">
			<div class="card-body">
				<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><? //=$lang_shoppingCartIntegration
																				?></a>-->
				<!-- <h3 class="card-title"><strong>How to use the Code for Powered Words</strong> </h3> -->
				<div class="container">
					<div class="row">
						<div class="col col-md-4">
							<label style="font-weight: 900; font-size:12px;">All Programs :</label>
							<button type="button" class="btn btn-fill btn-info" onclick=" return validatejoin()">Join</button>&nbsp;&nbsp;&nbsp;

						</div>


						<!-- <button type="button" class="btn btn-fill btn-success" id="override_value" onclick="return link_override()">Link Override(<?= $value ?>)</button>&nbsp;&nbsp;&nbsp; -->
						<div class="col col-md-8">
							<label style="font-weight: 900; font-size:12px;">Link Override :</label>
							<?php if ($value == 'ON') { ?>

								<input type="checkbox" id="checkbox" checked data-toggle="toggle" data-onstyle="success">
							<?php } else { ?>
								<input type="checkbox" id="checkbox" data-toggle="toggle" data-onstyle="success">
							<?php } ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>





<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form trackcode_form">
			<div class="card-body">
				<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><? //=$lang_shoppingCartIntegration
																				?></a>-->
				<!-- <h3 class="card-title"><strong>How to use the Code for Powered Words</strong> </h3> -->
				<div class="container">
					<div class="row">

						<div class="col col-md-6">

							<!-- id="contrySubmitBtn-move" is required for moving submit button when country list is opened -->
							<form method="post" id="contrySubmitBtn-move" name="reg" action="poweredWords_ValidateClone.php?action=multi_Country">

								<label for="pwd" class="form-label">Select Your Main Country Of Promotion</label>
								<select multiple id=Country name="countrylist[]" data-placeholder="Select a Category" name="categorylst" class="custom-select form-control" required="required">
									<!-- <option selected='selected' value="nill"><?= $selectacategory ?></option> -->
									<?php
									// $sql1    = "SELECT * FROM partners_category WHERE cat_name NOT IN ($finalCattVal)";
									$sql    = "SELECT * FROM partners_country";
									$result2 = mysqli_query($con, $sql);
									?>
									<?php
									while ($row = mysqli_fetch_object($result2)) {

										$key = array_search($row->country_no, $countryArray);

										if ($key !== false) {
									?>
											<option value="<?= $row->country_no ?>" selected><?= $row->country_name ?></option>
										<?php
										} else{
										?>
											<option value="<?= $row->country_no ?>"><?= $row->country_name ?></option>
									<?php

										}
									} ?>
								</select></<br>
								<button type="submit" class="btn btn-fill btn-info">submit</button>
							</form>
						</div>
						<div class="col col-md-6">
							<!-- id="categorySubmitBtn-move" is required for moving submit button when country list is opened -->
							<form method="post" id="categorySubmitBtn-move" name="reg" action="poweredWords_ValidateClone.php?action=multi_Category">
								<label for="Category" class="form-label">Categories You Want To Work With</label>

								<select multiple id=Category name="categorylist[]" data-placeholder="Select a Category" name="categorylst" class="custom-select form-control" required="required">
									<!-- <option selected='selected' value="nill"><?= $selectacategory ?></option> -->
									<?php
									// $sql1    = "SELECT * FROM partners_category WHERE cat_name NOT IN ($finalCattVal)";
									$sql1    = "SELECT * FROM partners_category";
									$result1 = mysqli_query($con, $sql1);
									?>
									<?php
									while ($row = mysqli_fetch_object($result1)) {

										$key = array_search($row->cat_id, $categoryArray);

										if ($key !== false) {
									?>
											<option value="<?= $row->cat_id ?>" selected><?= $row->cat_name ?></option>
										<?php
										} else{
										?>
											<option value="<?= $row->cat_id ?>"><?= $row->cat_name ?></option>
									<?php

										}
									} ?>
								</select></<br>
								<button type="submit" class="btn btn-fill btn-info">submit</button>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form trackcode_form">
			<div class="card-body">
				<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><? //=$lang_shoppingCartIntegration
																				?></a>-->
				<h4 class="card-title">Code for Powered Words</h4>
				<div class="form-group">
					<textarea rows="10" name="headertxt" class="form-control"><script type="text/javascript">var levenshteinKey="<?php echo $key; ?>";</script>
<script id="script" type="text/javascript" src="https://performanceaffiliate.com/powered-words/advance-encrypt-searlco.js"></script></textarea>
				</div>
				<!--<p class="text-center"><b>OR</b></p>
				<div class="form-group">	 				
					<textarea rows="10" name="headertxt" class="form-control">
	                <?  //$code = "\n<!--START $title CODE--> \n\n<script language=\"JavaScript\" type=\"text/javascript\" \n src=\"$track_site_url/trackingcode_lead.php?mid=$mid&amp;sec_id=$randNo&amp;orderId=$orderid\">\n</script>\n\n<!-- END $title CODE -->";
					// echo $code; 
					?>
	                </textarea>
				</div>-->
			</div>
		</div>
	</div>
</div>





<!-- Script to play powered words video instruction on Full Screen -->
<script>
	//=========Script to play powered words video instruction on Full Screen=========//
	var elem = document.getElementById("myvideo");

	function openFullscreen() {
		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.webkitRequestFullscreen) {
			/ Safari /
			elem.webkitRequestFullscreen();
		} else if (elem.msRequestFullscreen) {
			/ IE11 /
			elem.msRequestFullscreen();
		}
	}

	//============Validation using Sweet Alert for joining All Programes by Affiliate =============//
	function validatejoin() {
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				// padding: 2,
				confirmButton: 'btn btn-success',
				cancelButton: 'btn btn-danger'
			},
			buttonsStyling: false
		})
		swalWithBootstrapButtons.fire({
			title: 'Are you sure?',
			text: "You want to join All programs?",
			icon: 'warning',
			showCancelButton: true,
			cancelButtonText: 'No, cancel!',
			confirmButtonText: 'Yes, Join All!',
			reverseButtons: false
		}).then((result) => {

			if (result.isConfirmed) {
				swalWithBootstrapButtons.fire({
					text: "All Programs joined successfully",
					icon: 'success',
					//showCancelButton: true,
					cancelButtonText: 'OK',

				});

			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire(
					'Cancelled',
					'Programes joining Cancelled...!',
					'error'
				)
			}
		})
		$.ajax({
			type: "GET",
			url: "joinall_programs.php",
			success: function(text) {
				console.log(text);
				//alert(text);
				// swalWithBootstrapButtons.fire({
				// 	text: text,
				// 	icon: 'success',
				// 	//showCancelButton: true,
				// 	cancelButtonText: 'OK',

				// });
			}
		});
	}

	// function validatejoin()
	// {
	// 		const swalWithBootstrapButtons = Swal.mixin({
	// 		customClass: {
	// 			// padding: 2,
	// 			confirmButton: 'btn btn-success',
	// 			cancelButton: 'btn btn-danger'
	// 		},
	// 		buttonsStyling: false
	// 	})
	// 	swalWithBootstrapButtons.fire({
	// 		title: 'Processing...',
	// 		html: "<div class='loader'></div>",
	// 		showConfirmButton: false
	// 		// icon: 'warning',
	// 		// showCancelButton: true,
	// 		// cancelButtonText: 'No, cancel!',
	// 		// confirmButtonText: 'Yes, Join All!',
	// 		//  reverseButtons: false
	// 	});
	// 	$.ajax({
	// 				type: "GET",
	// 				url: "joinall_programs.php",
	// 				success: function(text) {
	// 					console.log(text);
	// 					//alert(text);
	// 					swalWithBootstrapButtons.fire({
	// 						text: text,
	// 						icon: 'success',
	// 						//showCancelButton: true,
	// 						cancelButtonText: 'OK',

	// 					});
	// 				}
	// 			});
	// }
	// function validatejoin() {
	//    $(".loader").css('display','block');
	// 	$.ajax({
	// 		type: "GET",
	// 		url: "joinall_programs.php",
	// 		// async:false,
	// 		success: function(text) {
	// 			console.log(text);
	// 			//alert(text);
	// 			$(".loader").css('display','none');
	// 			swal({
	// 				text: text,
	// 				icon: 'success',
	// 				//showCancelButton: true,
	// 				cancelButtonText: 'OK',

	// 			});
	// 		}
	// 	});


	// }
	$("#checkbox").change(function() {
		if ($(this).prop("checked") == true) {
			value = '1';
		} else {
			console.log('this is toggle false');
			value = '0';
		}
		$.ajax({
			type: "GET",
			url: "linkOverride_Value.php?value=" + value,
			success: function(response) {
				console.log(response);
				$('#override_value').html('Link Override(' + response + ')');
			}
		});
	});



	function link_override() {
		// const value =  document.querySelector['input[name=checkbox_override]:checked'];
		console.log('this is toggle =>', value);
		console.log('override function called');

	}
	$('.tokenize-override-demo1').tokenize2();
	$.extend($('.tokenize-override-demo1').tokenize2(), {
		dropdownItemFormat: function(v) {
			return $('<a />').html(v.text).attr({
				'data-value': v.value,
				'data-text': v.text
			})
		}
	});
</script>