<?php $leadgenid = leaduserinfo('id'); ?>
<div class="sidebar" data-color="blue" data-image="<?php echo LEADURL; ?>public/assets/img/sidebar-4.jpg">
	<div class="sidebar-wrapper">
	
		<div class="logo">
			<a href="#" class="simple-text logo-mini">
				A
			</a>
			<a href="#" class="simple-text logo-normal">
				AVAZ
			</a>
		</div>
		<div class="user"> 
			<div class="photo">
			<?php if(get_user_info($leadgenid,'av_profile_image',true) != ''){ ?>
			
				<img style="height: 100%;" src="<?php echo SITEURL.'upload/leadgen/'.get_user_info($leadgenid,'av_profile_image',true); ?>" />
				<?php }else{ ?>
					<img src="https://www.slaterheelis.co.uk/wp-content/uploads/2014/10/avatar-man-no-text-grey.jpg" />
				<?php } ?>
			</div>
			<div class="info ">
				<a data-toggle="collapse" href="#" class="collapsed">
					<span><?php echo get_user_info($leadgenid,'first_name',true).' '.get_user_info($leadgenid,'last_name',true); ?></span>
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