<?php include('config.php'); ?>
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
<style>
.custom_navbar ul.nav li a{color: #<?php  if(get_config_meta('link_color', true) != ''){ echo get_config_meta('link_color', true); }else{ echo 'f7931e'; } ?>;}
.custom_navbar ul.nav li a:hover, .custom_navbar ul.nav li a:focus{color: #<?php  if(get_config_meta('link_color', true) != ''){ echo get_config_meta('link_color', true); }else{ echo 'f7931e'; } ?>;}
.inner_content .inner_form_rgt form input[type="submit"]{background: #<?php  if(get_config_meta('form_button_color', true) != ''){ echo get_config_meta('form_button_color', true); }else{ echo 'D3D3D3'; } ?>;}
.inner_content .inner_form_rgt form input[type="submit"]:hover{border: 1px solid #<?php  if(get_config_meta('form_button_color', true) != ''){ echo get_config_meta('form_button_color', true); }else{ echo 'f7931e'; } ?>;background: #<?php  if(get_config_meta('form_button_hover_color', true) != ''){ echo get_config_meta('form_button_hover_color', true); }else{ echo 'f7931e'; } ?>;}

.border_line:before {background: #<?php if(get_config_meta('border_color', true) != ''){ echo get_config_meta('border_color', true); }else{ echo 'f7931e'; } ?> url(img/border_trans_line.png) no-repeat;}
</style>
  </head> 
  <body>
    <div class="wrapper">
		<div class="wrap_opacity"></div>
		 <div class="container"> 
			<header class="header cus_zindex">
				 <?php $logoname =  get_config_meta('logo_name', true); ?>
				 <div class="col-md-4 col-sm-4 col-xs-12 logo hidden-xs">
					<a href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL.'img/'.$logoname; ?>" class="img-responsive" alt="Logo"/></a>
				 </div>
				 <div class="col-md-8 col-sm-8 col-xs-12">
					<nav class="navbar custom_navbar">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>
						 
						  <a class="navbar-brand visible-xs logo" href="#"><img src="<?php echo SITEURL.'img/'.$logoname; ?>" class="img-responsive" alt="Logo"/></a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						  <ul class="nav navbar-nav link">
							<li class="active"><a href="#" data-toggle="modal" data-target="#privacy_policy">Privacy Policy</a></li>
							<li><a href="#" data-toggle="modal" data-target="#about_us">About Us</a></li>
							<li><a href="#" data-toggle="modal" data-target="#term_condition">Terms & Conditions</a></li>
						  </ul>						
						</div><!-- /.navbar-collapse -->
					</nav>
				 </div>
				 <div class="clearfix"></div>
			</header>
			<div class="clearfix"></div>
			<div class="inner_content cus_zindex">
				<div class="col-md-6 col-sm-12 col-xs-12">
					  <?php echo htmlspecialchars_decode(stripslashes(get_config_meta('description', true))); ?>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 border_line">
					<div class="inner_form_rgt">
						<div class="text-center">
							<h4><?php echo get_config_meta('form_title', true); ?></h4>
							<p><?php echo get_config_meta('form_description', true); ?></p>
						</div>
						<form class="" action="<?php echo SITEURL.'controller/signup.php'; ?>" method="post">
						<?php
							if(isset($_SESSION['success'])){
								echo '<p class="alert alert-success">'.$_SESSION['success'].'</p>';
								unset($_SESSION['success']);
							}else if(isset($_SESSION['failure'])){
								echo '<p class="alert alert-danger">'.$_SESSION['failure'].'</p>';
								unset($_SESSION['failure']);
							}
						?>
							<div class="form-group">
								<label>First Name</label>
								<input required type="text" name="first_name" class="form-control" placeholder="Please Enter Your First Name" />
							</div>
							<div class="form-group">
								<label>Last Name</label>
								<input type="text" name="sur_name" class="form-control" placeholder="Please Enter Your Surname" />
							</div>
							<div class="form-group">
								<label>Email</label>
								<input required type="email" name="av_email" class="form-control" placeholder="Please Enter Your Email" />
							</div>
							<div class="form-group">
								<label>Phone Number</label>
								<input required type="tel" name="av_phone" class="form-control" placeholder="Please Enter Your Phone Number" />
							</div>
							<div class="form-group">
								<label>Post Code</label>
								<input required type="text" name="av_post_code" class="form-control" placeholder="Please Enter Your Post Code" />
							</div>
							<div class="form-group">
								<label>Unique Question</label>
								<select required class="form-control" name="av_question">
									<option value="">Please Select Unique Question</option>
									<?php 
									$sql = select('question');
									while($row = fetch($sql)){
									?>
									<option value="<?php echo $row['question_name']; ?>"><?php echo $row['question_name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Answer</label>
								<input required type="text" name="av_answer" class="form-control" placeholder="Please Enter Your Answer" />
							</div>
							<div class="form-group text-center">
								<input type="submit" name="join_avaz" class="submit_btn" Value="Submit" />
							</div>
						</form>
					</div>	
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<footer class="footer text-center cus_zindex">
			 <div class="container"> 
				<div class="footer_txt">
					<a href="<?php echo get_config_meta('main_site_link', true); ?>">Visit Main Site</a>
				</div>
				<div class="copyright_txt">
					<p>&copy; 2019 AVAZ Affiliate Network | All Rights Reserved.</p>
				</div>
			 </div>
		</footer>			
	</div>
<?php 
$sql = select("posts limit 3"); 
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
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>