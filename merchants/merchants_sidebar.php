<div class="sidebar" data-color="blue" data-image="../public/assets/img/sidebar-4.jpg">
	<div class="sidebar-wrapper">
	
	<?php 
	  $sql="select * from partners_merchant where merchant_id='$MERCHANTID'";
	   $result = mysqli_query($con,$sql);
	    while($row=mysqli_fetch_object($result))
	                 {
					   $merchant_profileimage                        = stripslashes(trim($row->merchant_profileimage));
					 }
	
								?>
		<div class="logo">
			<a href="#" class="simple-text logo-mini">
				PA
			</a>
			<a href="#" class="simple-text logo-normal">
				Searlco LTD
			</a>
		</div>
		<div class="user">
			<div class="photo">
				<?php
					if($merchant_profileimage != ''){
				?>
				<img src="<?php echo 'uploadedimage/'.$merchant_profileimage; ?>" />
					<?php }else{
						?>
						<img src="https://www.slaterheelis.co.uk/wp-content/uploads/2014/10/avatar-man-no-text-grey.jpg" />
						<?php
					} ?>
				
			</div>
			<div class="info ">
				<a data-toggle="collapse" href="#" class="collapsed">
					<span><?=$_SESSION['MERCHANTNAME']?>
					</span>
				</a>
				<div class="collapse" id="collapseExample">
				</div>
			</div>
		</div>
		<ul class="nav">
			<?php include"links.php";?>
		</ul>
	</div>
</div>