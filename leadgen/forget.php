<?php include('includes/header.php'); 



?> 



<div class="container"> 
<div class=" custom_regiser inner_content cus_zindex pw-form">
	<div class="col-md-10 col-sm-8 col-xs-12">
		
			<?php
			if(isset($_SESSION['successr'])){
				echo '<p class="alert alert-success">'.$_SESSION['successr'].'</p>';
				unset($_SESSION['successr']);
			}else if(isset($_SESSION['failurer'])){
				echo '<p class="alert alert-danger">'.$_SESSION['failurer'].'</p>';
				unset($_SESSION['failurer']);
			}
			?>
			
			
		<form action="controller/forget.php" class="" method="post">
			<div class="form-group">
				<label class="col-md-6">Please Enter your E-mail Address</label>
				<div class="col-md-6">
					<input type="email" name="av_email" required placeholder="Email Address" class="form-control" />
				</div>
			</div>
			
			<div class="form-group">
				<button type="submit" name="sign_in" class="register_btn btn-center">Submit</button>
			</div>
			<div class="clearfix"></div>
		</form> 
	</div>
	
	<div class="clearfix"></div>
</div>	
</div>	
<div class="container">
<?php include('includes/footer.php'); ?>