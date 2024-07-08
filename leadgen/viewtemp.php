<?php include('config.php');
 $slug = isset($_GET['aslug']) ? $_GET['aslug'] : '';
$sql = select("company","company_slug='$slug'");
if($slug != ''){
	 if(mysqli_num_rows($sql) == 0){
		redirect(SITEURL);
		exit;
	}  
}
 
$fetchpost = fetch($sql);

$comid = $fetchpost['id'];
  $leadgenid = leaduserinfo('id');
 
$av_campaign_status = get_user_info($leadgenid, 'av_campaign_status', true);
if($slug != '' && $av_campaign_status != 'approve'  && $leadgenid != '' && leaduserinfo('type') == 3){
	$av_campaign = unserialize(get_user_info($leadgenid, 'av_campaign', true));
		redirect(SITEURL);
		exit;

}

$companydatas = unserialize(base64_decode(get_config_meta('company_data', $comid, true)));
$companydata  = unserialize($companydatas['config']);

$companyquestiondata  = unserialize($companydatas['questions']);
$companyquestionoptiondata  = unserialize($companydatas['questionoption']);
if($fetchpost['compaign_type'] == 'standard'){
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>AVAZ - Affiliate Network</title>
	<link href="https://fonts.googleapis.com/css?family=Oswald:400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
<style>
.custom_navbar ul.nav li a{color: #<?php  if($companydata['link_color'] != ''){ echo $companydata['link_color']; }else{ echo 'f7931e'; } ?>;}
.custom_navbar ul.nav li a:hover, .custom_navbar ul.nav li a:focus{color: #<?php  if($companydata['link_color'] != ''){ echo $companydata['link_color']; }else{ echo 'f7931e'; } ?>;}
.inner_content .inner_form_rgt form input[type="submit"]{background: #<?php  if($companydata['form_button_color'] != ''){ echo $companydata['form_button_color']; }else{ echo 'D3D3D3'; } ?>;border: 1px solid #<?php  if($companydata['form_button_color'] != ''){ echo $companydata['form_button_color']; }else{ echo 'f7931e'; } ?>;}
.inner_content .inner_form_rgt form input[type="submit"]:hover{border: 1px solid #<?php  if($companydata['form_button_hover_color'] != ''){ echo $companydata['form_button_hover_color']; }else{ echo 'f7931e'; } ?>;background: #<?php  if($companydata['form_button_hover_color'] != ''){ echo $companydata['form_button_hover_color']; }else{ echo 'f7931e'; } ?>;}

.border_line:before {background: #<?php if($companydata['border_color'] != ''){ echo $companydata['border_color']; }else{ echo 'f7931e'; } ?> url(img/border_trans_line.png) no-repeat;}
<?php
if($companydata['background_image'] != ''){
	$imagesback = 'img/backimg/'.$companydata['background_image'];
}else{
	$imagesback = "img/joinnow-back.jpg";
}
?>

	.wrapper{background:url(<?php echo SITEURL.$imagesback; ?>) no-repeat;position:relative;background-size: cover;background-position: center;}

</style>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
if($companydata['google_analytics'] != ''){ 
	echo htmlspecialchars_decode(stripslashes($companydata['google_analytics']));
}
?>
  </head> 
  <body>
  <?php if($slug == ''){ ?>
	<div class="top-bar">
        <div class="container">
            <p class="help-text"> Have A Question? <b><span>+44 (0)20 3287 2232</span></b></p>
            <ul class="social-links">
              <!--  <li><a href="https://www.linkedin.com/company/#" target="_blank" title="Avaz LinkedIn " alt="Avaz LinkedIn "><i class="fa fa-linkedin"></i></a></li>-->
                <li><a href="https://twitter.com/AvazNetwork" target="_blank" title="Avaz Twitter" alt="Avaz Twitter"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://www.facebook.com/Avaz-Affiliate-Network-1637388159698131/" target="_blank" title="Avaz Facebook" alt="Avaz Facebook"><i class="fa fa-facebook"></i></a></li>
            </ul>
        </div>
        <!--container-->
    </div>
	<?php } ?>
    <div class="wrapper">
		<div class="wrap_opacity"></div>
		 <div class="container"> 
			<header class="header cus_zindex"> 				 
				 <div class="col-md-3 col-sm-3 col-xs-12 logo hidden-xs">
					<?php if($companydata['logo_name'] != ''){ $logoname = $companydata['logo_name']; }else{ $logoname = 'logo.png'; } ?>
					<a href="<?php echo SITEURL; ?>"><img style="width: 278px; height: 100px;" src="<?php echo SITEURL.'img/'.$logoname; ?>" class="img-responsive" alt="Logo"/></a>
				 </div>
				 <div class="col-md-9 col-sm-9 col-xs-12">					
					<nav class="navbar custom_navbar">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>
						 
						  <a class="navbar-brand visible-xs logo" href="#"><img src="<?php echo SITEURL.'img/logo.png'; ?>" class="img-responsive" alt="Logo"/></a>
						</div> 
						<div class="collapse navbar-collapse" style="padding-right:0px;" id="bs-example-navbar-collapse-1">
						  <ul class="nav navbar-nav link">
							<li class="active"><a href="#" data-toggle="modal" data-target="#privacy_policy">Privacy Policy</a></li>
							<li><a href="#" data-toggle="modal" data-target="#about_us">About Us</a></li>
							<li><a href="#" data-toggle="modal" data-target="#term_condition">Terms & Conditions</a></li>
							<?php if(!isset($_GET['aslug'])){ ?>
							<li class="cus_btn signin_btn"><a href="#" data-toggle="modal" data-target="#sign_in">Sign In</a></li> 
							<li class="cus_btn signup_btn"><a href="<?php echo SITEURL .'signup.php'; ?>" >Sign Up</a></li>
							<?php } ?>
						  </ul>						
						</div><!-- /.navbar-collapse -->
					</nav>
				 </div>
				 <div class="clearfix"></div>
			</header>
			<div class="clearfix"></div>
	</div>
<style>.msgred{color:red;}</style>
<?php if(isset($_GET['aslug'])){ ?>
<div class="container">
<div class="inner_content cus_zindex"> 
	<div class="col-md-6 col-sm-12 col-xs-12">
		<?php 
		if($companydata['description'] != ''){ 
			echo htmlspecialchars_decode(stripslashes($companydata['description']));
		}else{ ?>
			<div class="inner_easy_left">
			<div class="text-center">
				<h4>It's As Easy As 1 - 2 - 3</h4>
			</div>	
				<div class="row common_easyway">
					<div class="col-md-5 col-sm-5 col-xs-5 wd100_xs">
						<div class="easy_left_img">
							<img src="img/simply_img.jpg" alt="">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-7 wd100_xs">
						<div class="easy_rgt_txt">
							<span>1</span>
							<h3>Simply</h3>
							<p>Browse as usual nd see our deals appear </p>
						</div>
					</div>  
				</div>
				<div class="row common_easyway">
					<div class="col-md-5 col-sm-5 col-xs-5 wd100_xs">
						<div class="easy_left_img">
							<img src="img/more_img.jpg" alt="">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-7 wd100_xs">
						<div class="easy_rgt_txt">
							<span>2</span>
							<h3>More</h3>
							<p>Your favourite brands with great savings</p>
						</div>
					</div>
				</div>
				<div class="row common_easyway"> 
					<div class="col-md-5 col-sm-5 col-xs-5 wd100_xs">
							<div class="easy_left_img">
							<img src="img/rewarding_img.jpg" alt="">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-7 wd100_xs">
						<div class="easy_rgt_txt">
							<span>3</span>
							<h3>Rewarding</h3>
							<p>Get Cashback</p>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12 border_line">
		<div class="inner_form_rgt">
			<div class="text-center">
				<h4><?php if($companydata['form_title'] != ''){ echo $companydata['form_title']; } else{ ?>JOIN AVAZ TODAY <?php } ?></h4>
				<p><?php if($companydata['form_description'] != ''){ echo $companydata['form_description']; } else{ ?>JOIN AVAZ TODAY <?php } ?></p>
			</div>
			<form class="" id="join_avaj" action="#" method="post">
			<input type="hidden" value="<?php echo $slug; ?>" name="companyid">
			<?php
				if(isset($_SESSION['successf'])){
					echo '<p class="alert alert-success">'.$_SESSION['successf'].'</p>';
					unset($_SESSION['successf']);
				}else if(isset($_SESSION['failuref'])){
					echo '<p class="alert alert-danger">'.$_SESSION['failuref'].'</p>';
					unset($_SESSION['failuref']);
				}
			?>
				<div class="form-group">
					<label>First Nameaa</label>
					<input type="text" name="first_name" class="form-control" placeholder="Please Enter Your First Name" />
				</div>
				<div class="form-group">
					<label>Last Name</label>
					<input type="text" name="sur_name" class="form-control" placeholder="Please Enter Your Surname" />
				</div>
				<div class="form-group">
					<label>Email</label>
					<input required type="email" name="av_email" class="form-control" placeholder="Please Enter Your Email" id="av_email" />
					<span class="showmsg"></span>
				</div>
				<div class="form-group">
					<label>Phone Number</label>
					<input required type="text" id="av_phone" name="av_phone" class="form-control" size="20" placeholder="Please Enter Your Phone Number" />
				</div>
				<div class="form-group">
					<label>Post Code</label>
					<input required type="text" name="av_post_code" class="form-control" placeholder="Please Enter Your Post Code" />
				</div>
				<?php if(!empty($companyquestiondata)){ for($is =0; $is< count($companyquestiondata); $is++){?>
				<div class="form-group">
					<label><?php echo $companyquestiondata[$is]['question_name']; ?></label>
					<select required class="form-control" name="av_question1[<?php echo $companyquestiondata[$is]['question_name']; ?>]">
						<option value="">Please Select</option>
						<?php for($i =0; $i< count($companyquestionoptiondata[$is]); $i++){ ?>
						<option value="<?php echo $companyquestionoptiondata[$is][$i]['question_option']; ?>"><?php echo $companyquestionoptiondata[$is][$i]['question_value']; ?></option>
						<?php } ?>
					</select>
				</div>
				<?php } } ?>
				<?php for($i =0; $i< count($companydata['question_info']); $i++){?>
					<div class="form-group">
					<label><?php echo $companydata['question_info'][$i]['question_name']; ?></label>
					<input required type="text" name="av_question2[<?php echo $companydata['question_info'][$i]['question_name']; ?>]" class="form-control" placeholder="Please Enter Your Answer" />
				</div>
				<?php } ?>
				 
				<div class="form-group text-center">
					<input disabled type="submit" name="join_avaz" class="submit_btn" Value="Submit" />
				</div>
			</form> 
		</div>	
	</div>
	<div class="clearfix"></div>
	</div> 
	</div>	
<?php }else{
	?> 
	<div class="container-fluid pad0">
			<div class="inner_content cus_zindex full-slider"> 
			<?php include('includes/section_carousel.php'); ?>
		</div>
	</div>
	<?php
} ?>

<div class="container"> 	
		</div>
		<footer class="footer text-center cus_zindex">
			 <div class="container"> 
				<div class="footer_txt">
					<?php if($companydata['main_site_link'] != ''){ ?><a href="<?php echo $companydata['main_site_link']; ?>">Visit Main Site</a><?php } else{ ?><a href="https://avaz.co.uk">Visit Main Site</a> <?php } ?>					
				</div> 
				<div class="copyright_txt">
					<p>&copy; 2019 AVAZ Affiliate Network | All Rights Reserved.</p>
				</div>
			 </div>
		</footer>			
	</div>
<?php 
$sql = select("posts"," user_id = '$comid' limit 3"); 
while($row = fetch($sql)){
	$slug = str_replace('-','_', $row['post_slug']);
?>
	<div id="<?php echo strtolower($slug); ?>" class="modal fade custom_avaz_modal" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
		  </div>
		  <div class="modal-body">
		   <div class="">
				<?php echo htmlspecialchars_decode(stripslashes($row['post_description'])); ?>
			</div>
				
		  </div>     
		</div>

	  </div>
	</div>
<?php } ?>
<div id="sign_in" class="modal fade custom_sign_in" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Sign in</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>
		  <div class="modal-body">
		  <div id="myDiv">
			<div class="loader" style="display:none;">
				Please wait
				</div>
			</div>
		   <div class="sign_in_form">
				<form action="" id="signin" method="post">
					<span id="show_error_message"></span>
					<div class="form-group">
						<input id="username" type="text" class="form-control" name="username" placeholder="Username">
					</div>
					<div class="form-group">
						<input id="password" type="password" class="form-control" name="password" placeholder="Password">
					</div>
					<div class="form-group">
						<button type="button" id="sign_in_btn" class="submit_btn">LOGIN</button>
					</div>
				</form>
			</div>
				
		  </div>     
		</div>
	</div>
</div>
<?php
$slug = isset($_GET['aslug']) ? $_GET['aslug'] : '';
$sql = select("company","company_slug='$slug'");
$fetchpost = fetch($sql);
$comid = $fetchpost['id'];
$companydatas = unserialize(base64_decode(get_config_meta('company_data', $comid, true)));
$companydata  = unserialize($companydatas['config']);
?>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script>
		jQuery(document).ready(function($){
			$('#sign_in_btn').on('click', function(){
				if($('#username').val() == ''){
					$('#show_error_message').html('<p class="alert alert-danger">Username is required</p>');
					return;
				}
				if($('#password').val() == ''){
					$('#show_error_message').html('<p class="alert alert-danger">Password is required</p>');
					return;
				}
				$("#loader").show();
				var x = document.getElementById("signin");
				var formdata = new FormData(x);
				formdata.append('action', 'sign_in');
					$.ajax({
						dataType: 'json',
						url: '<?php echo SITEURL; ?>controller/login.php',
						data: formdata,
						type: 'POST',
						contentType: false,
						processData: false,
						
						success: function(response){
							var obj = JSON.parse(JSON.stringify(response));
							$("#loader").hide();
							if(obj.success){
								$('#reply_msg').val('');
								$('#show_error_message').html('<p class="alert alert-success">'+obj.message+'</p>')	
								window.location.href = obj.url
							}else{
								$('#show_error_message').html('<p class="alert alert-danger">'+obj.message+'</p>')				
							}
						}
				});
			});
			
			jQuery("#join_avaj").validate({
				rules: {
					first_name: {
						required: true,
						lettersonly: true
					},
					sur_name: {
						required: true,
						lettersonly: true
					},
					av_phone: {
						required: true,
						digits: true,
						maxlength: 20,
					},
					av_post_code: 'required',
					av_email: { 
						required: true,
						email: true,
						maxlength: 255,
						<?php if($companydata['multisubmission'] == 'no'){ ?>
						remote: 
							{ 
								url: ' <?php echo SITEURL?>/controller/signup.php', 
								type: "post",
							}
						<?php } ?>
					},
				},
				messages: {
					first_name: {
						required : 'This field is required',
						lettersonly : 'Letters only please',
					},
					sur_name: {
						required : 'This field is required',
						lettersonly : 'Letters only please',
					},
					av_email: {
						required : 'This field is required',
						email : 'Enter a valid email',
						<?php if($companydata['multisubmission'] == 'no'){ ?>
						remote: "Email already Exists",	
						<?php } ?>
					},
					av_phone:{
						required : 'This field is required',
						
					},
					av_post_code: 'This field is required',

				},
				submitHandler: function(form) {
					form.submit();
				}
			});
			jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please"); 



		});
	</script>
  </body>
</html>
<?php }else if($fetchpost['compaign_type'] == 'custom'){
	if($companydata['description'] != ''){ 
			echo str_replace('{AVAZ-FORM}',avaj_form($slug),htmlspecialchars_decode(stripslashes($companydata['description'])));
	}
} else if($fetchpost['compaign_type'] == 'slide_up'){
?>
<html>
	<head>
	<title>Avaz Affilate Network</title>
	<link href="<?php echo SITEURL; ?>css/slide_up.css" rel="stylesheet">
	<link href="<?php echo SITEURL; ?>css/animate.css" rel="stylesheet">
	<style>
		#ulp-layer-555 { background-image: url(<?=SITEURL.'img/backimg/'.$companydata['background_image']?>);}
	</style>
	<style>
 form input[type="submit"]{background: #<?php  if($companydata['form_button_color'] != ''){ echo $companydata['form_button_color']; }else{ echo 'D3D3D3'; } ?>;border: 1px solid #<?php  if($companydata['form_button_color'] != ''){ echo $companydata['form_button_color']; }else{ echo 'f7931e'; } ?>;}
 form input[type="submit"]:hover{border: 1px solid #<?php  if($companydata['form_button_hover_color'] != ''){ echo $companydata['form_button_hover_color']; }else{ echo 'f7931e'; } ?>;background: #<?php  if($companydata['form_button_hover_color'] != ''){ echo $companydata['form_button_hover_color']; }else{ echo 'f7931e'; } ?>;}

.border_line:before {background: #<?php if($companydata['border_color'] != ''){ echo $companydata['border_color']; }else{ echo 'f7931e'; } ?> url(img/border_trans_line.png) no-repeat;}
<?php
if($companydata['background_image'] != ''){
	$imagesback = 'img/backimg/'.$companydata['background_image'];
}else{
	$imagesback = "img/joinnow-back.jpg";
}
?>

	.wrapper{background:url(<?php echo SITEURL.$imagesback; ?>) no-repeat;position:relative;background-size: cover;background-position: center;}

</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
	<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
	</head>
	<body>
		<div class="ulp-overlay ulp-animated ulp-fadeIn" id="ulp-dST25dQgDqXbdYlY-overlay" style="display: block;"></div>
		<div class="ulp-window-container" onclick="jQuery('#ulp-dST25dQgDqXbdYlY-overlay').click();">
				<div class="ulp-window ulp-window-middle-center" id="ulp-dST25dQgDqXbdYlY" data-title="Popup # 24728" data-width="720" data-height="500" data-position="middle-center" data-close="on" data-enter="on" onclick="event.stopPropagation();" style="transform: translate(-50%, -50%) scale(0.824); display: block;">
					<div class="ulp-content" style="">
						<div class="ulp-layer" id="ulp-layer-555" data-left="0" data-top="40" data-appearance="fade-in" data-appearance-speed="1000" data-appearance-delay="0" data-scrollbar="off" data-confirmation="off" style="left: 0px; top: 40px; display: block;"></div>
						<div class="ulp-layer poprigth" style="animation-duration: 1000ms; opacity: 0; left: 365px;     bottom: -138%;display: block;">
						
						<div id="ulp-layer-557" ><?php echo $companydata['form_title']; ?></div>
						<div  id="ulp-layer-559" ><i class="fa fa-bar-chart"></i></div>
						<div  id="ulp-layer-560"><?php echo $companydata['form_description']; ?></div>
						<div class="ulp-layer" id="ulp-layer-560" ><?php echo avaj_form($slug) ?></div>
						
						</div>
					</div>
				</div>
			</div>
		<script>
														jQuery(document).ready(function() {
														$('.poprigth').animate({ opacity: 1, top: "-10px" }, 1500);
														});

														</script>
	</body>
</html>

<?php
}	?>  