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
					<a href="forget.php"><span>Forget Password</span></a>
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
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
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
			jQuery(document).ready(function($){
						var width = $(window).width();
						var height = $(window).height();
						var widthscreen = width + ' X ' + height;
						$('.getsizexpost').val(widthscreen);
						
						<?php
						$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
						 $leadgenid = leaduserinfo('id');
						  $sql = select("company","company_slug='$slug'");
						 $fetchpost = fetch($sql);
						
						$comid = $fetchpost['id'];
						if($slug != '' && leaduserinfo('type') == 3 && $leadgenid != ''){
						
						?>
						var width = $(window).width();
						var height = $(window).height();
						$.ajax({

						url: '<?php echo SITEURL; ?>ajaxfile.php',
						data: {width:width,height:height,campid:<?php echo $comid; ?>},
						type: 'POST',
						
						success: function(response){
						
						}
				});
			<?php } ?>
						
						  });
						  
	</script>
  </body>
</html>