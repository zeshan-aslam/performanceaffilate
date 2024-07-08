<?php $postid = isset($_GET['cid']) ? $_GET['cid'] : -1; ?>

<?php

session_start();
$width = " <script>document.write(screen.width); </script>";
$height = " <script>document.write(screen.height); </script>";
$_SESSION["widthscreen"] = $width.'x'.$height;


?>
<style>
.campaign .sweet-alert.show-sweet-alert{height: 100%;width: 1100px!important;margin-top: 0!important;
    transform: translate(-50%, -50%);    -webkit-transform: translate(-50%, -50%);    -moz-transform: translate(-50%, -50%);margin-left:0!important;position:absolute;}
.campaign .sweet-content{    height: 100%;}
.campaign .sweet-content iframe{width: 100%;height: 100%;}
</style>
<div class="card strpied-tabled-with-hover">
	<div class="card-body"> 
		<div class="row">
			<div class="col-md-12">
				<?php if(isset($_SESSION['faliureerror'])){ ?>
					<p class="alert alert-danger"><?php echo $_SESSION['faliureerror']; ?></p>
				<?php unset($_SESSION['faliureerror']);	 } ?>
				<p align="left">
					<a href="<?php echo LEADURL;?>index.php/?Act=campaign_type&campid=<?=$postid?>"><b class="btn btn-primary btn-wd">Add Campaign</b></a>&nbsp;&nbsp;&nbsp;
				</p>	
				<div class="table-full-width table-responsive">
					<table class="table table-hover table-striped coupon_table">
						<thead> 
							<tr>
								<th>Campaign Name</th>
								<th>Campaign Type</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead> 
						<tbody>
						<?php

						$usercamp = array();
						if(get_user_info($leadgenid,'av_campaign_status',true) == 'approve' ){
							$comaign = unserialize(get_user_info($leadgenid,'av_campaign',true));
							$sql = select("company","user_id = '$leadgenid'");
							
							while($row = fetch($sql)){
								$usercamp[] = $row['id'];
								
								
							}
								$newarray = array_merge($comaign,$usercamp);
								$newarray = array_unique($newarray);
								foreach($newarray as $value){
									$sql = select("company", "id = '$value'");
									$com = fetch($sql);
									
									$comiddb = base64_encode(serialize($com['id']));
									$vat = SITEURL.$com['company_slug'].'&cmid='. $comiddb
								?>
									<tr>
										<td><?php echo $com['company_name']; ?></td>
										<td><?=$com['compaign_type']?></td>
										<td><?php if($com['status'] == 1){ echo 'Active'; }else if($com['status'] == 2){ echo 'suspended'; }else{ echo 'Waiting Approval';	} ?></td>
										<td>
										<?php if($com['status'] == 1){ ?><a target="_blank" href="<?php echo SITEURL.$com['company_slug']; ?>&cmid=<?php echo $comiddb;  ?>">View</a>
										<?php }else if($com['status'] == 2){ ?>
											<a onclick="showcustomSwal('<?php echo $com['company_slug']; ?>)" href="javascript:;">View</a>
										<?php }else{ ?>
											<a onclick="showcustomSwal('<?php echo $com['company_slug']; ?>)" href="javascript:;">View</a>
										<?php } ?>
										
										 <?php if($leadgenid == $com['user_id']){ ?> | <a href="<?php echo LEADURL;?>index.php/?Act=<?=$com['compaign_type']?>&action=edit&campid=<?=$com['id']?>">Edit</a> <?php } ?><input type="text" value="<?php echo $vat ?>" ><button onclick="myFunction(this.id)" id="<?php echo $vat; ?>">Copy URL</button><div>
										 <?php if($com['status'] == 1 && $com['compaign_type'] == 'slide_up'){ ?>
										 <a href="javascript:;" data-toggle="modal" data-target="#myModal<?php echo $com['company_slug']; ?>"></a>
										 <!-- Modal -->
											<div id="myModal<?php echo $com['company_slug']; ?>" class="modal fade" role="dialog">
											  <div class="modal-dialog">
														<!-- Modal content-->
											

											  </div>
											</div>
										 <?php } ?>
										 </div></td>  
									</tr>
								<?php 
								} 
							}else{
							?>
							<tr><td colspan="2">No Record Found</td></tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div> 
		</div> 
	</div>
</div>



<script>
function myFunction(copyText) {
 
  alert(copyText); 
  var copyText = document.getElementById('copyText');
  copyText.select();
  
  document.execCommand("copy"); 
}
</script>


