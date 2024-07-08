<?php include('includes/header.php'); 
$id = $_REQUEST['id'];


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
		
			<form action="controller/confirmlink.php" class="" method="post">
		
			<div class="form-group">
				<label class="col-md-6">Please Enter your new Password</label>
				<div class="col-md-6">
				<input id="password" type="password" class="form-control" name="new_password" placeholder="Password">
				<input type="hidden"  name="uid" value="<?php echo $id; ?>">
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="form-group">
				<label class="col-md-6">Please confirm your new Password</label>
				<div class="col-md-6">
					<input id="conpassword" type="password" class="form-control" name="con_password" placeholder="Password">
				</div>
			</div>
			
			<div class="clearfix"></div>
			
			
			
			<div class="form-group">
			<div class="col-md-10">
				<button type="submit" name="passwordreset" class="register_btn btn-center">Submit</button>
			</div>
		</div>
			<div class="clearfix"></div>
		</form> 
	</div>
	
	<div class="clearfix"></div>
</div>	
</div>	
<div class="container">
<?php include('includes/footer.php'); ?>