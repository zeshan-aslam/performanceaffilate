<?php
$comaign = unserialize(get_user_info($leadgenid,'av_campaign',true));
?>

<li class="nav-item">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=home" >
		<i class="nc-icon nc-chart-pie-35"></i>
		<p>Dashboard</p>
	</a>
</li>
<li class="nav-item">
	<a class="nav-link"  href="<?php echo LEADURL; ?>index.php?Act=accounts">
		<i class="nc-icon nc-notes"></i>
		<p>Profile</p>
	</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=campaign">
		<i class="nc-icon nc-paper-2"></i>
			<?php
		$mobile_os = array($comaign);
  if (in_array("0", $mobile_os)) {
	  ?>
	  <p>Campaigns (0)</p>
	  <?php      
   }
   else
   {
	   ?>
	   <p>Campaigns (<?=count($comaign)?>)</p>
	   <?php	   
	   
   } 
		?>
	</a>
</li>
<li class="nav-item ">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=reports">
		<i class="nc-icon nc-chart-bar-32"></i>
		<p>Reports</p>
	</a>
</li>
<li class="nav-item ">
	<a class="nav-link" href="<?php echo LEADURL; ?>index.php?Act=all_submissions">
		<i class="nc-icon nc-money-coins"></i>
		<p>Submissions</p>
	</a>
</li>
