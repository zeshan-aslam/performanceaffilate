<?php include('config.php');
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
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
 
 if($leadgenid == '' && userinfo('type') == 1){
	 
 }else{
	 if($slug != '' && $fetchpost['status'] != 1){
	redirect(SITEURL);
		exit;
	}
 }
 
$av_campaign_status = get_user_info($leadgenid, 'av_campaign_status', true);
if($slug != '' && $av_campaign_status != 'approve'  && $leadgenid != '' && leaduserinfo('type') == 3){
	$av_campaign = unserialize(get_user_info($leadgenid, 'av_campaign', true));
		redirect(SITEURL);
		exit;

}else if($slug != '' && $av_campaign_status == 'approve' && $av_campaign_status != '' && $leadgenid != '' && leaduserinfo('type') == 3){
	$av_campaign = unserialize(get_user_info($leadgenid, 'av_campaign', true));
	if(!in_array($comid,$av_campaign)){
		redirect(SITEURL);
		exit;
	}
}else{} 

if($slug != '' && leaduserinfo('type') == 3 && $leadgenid != ''){
	$tableaff = $prefix."affilates_charges";
	if(!isset($_SESSION['successf'])){
		$companydatas = unserialize(base64_decode(get_config_meta('company_data', $comid, true)));
		$companydata  = unserialize($companydatas['config']);
		$impressionval = $companydata['impression_amt'];
	$balance = leaduserinfo('balance');
	 if($balance > 0){
	mysqli_query($con, "insert into $tableaff (user_id, lead_type, date, campagin_id,affilate_charges) values ('$leadgenid', 'impression', Now(), '$comid','$impressionval')");
	$balace = $balance - $impressionval;
		check_transaction($balace);
		mysqli_query($con, "update av_users set balance = '$balace' where id='$leadgenid'");

		
	
	 }else{
		 redirect(SITEURL);
		exit;
	 }
	}
}
$companydatas = unserialize(base64_decode(get_config_meta('company_data', $comid, true)));
$companydata  = unserialize($companydatas['config']);

$companyquestiondata  = unserialize($companydatas['questions']);
$companyquestionoptiondata  = unserialize($companydatas['questionoption']);
if($fetchpost['compaign_type'] == 'standard' || $slug == ''){
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>AvazAI – Lead Generation With Power!</title>
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
							<?php if(!isset($_GET['slug'])){ ?>
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
<?php } ?>