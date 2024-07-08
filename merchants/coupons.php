<?php   global $con;
$MERCHANTID   =$_SESSION['MERCHANTID'];  
?> 
<div class="card stacked-form">
	<div class="card-body">
		<div class="row"> 
			<div class="col-md-6"><a class="btn btn-fill btn-info" href="index.php?Act=add_coupon">Add Coupon</a></div>	
			<div class="col-md-6"></div>	
		</div>
	</div>
 </div>
<div class="card strpied-tabled-with-hover">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
					<?php
				if(isset($_SESSION['successcoupon'])){
					?>
					<p class="alert alert-success"><?php echo $_SESSION['successcoupon']; ?></p>
					<?php
					unset($_SESSION['successcoupon']);
				}else if(isset($_SESSION['faliurecoupon'])){
					?>
					<p class="alert alert-danger"><?php echo $_SESSION['faliurecoupon']; ?></p>
					<?php
					unset($_SESSION['faliurecoupon']);
				}
			?>
						<div class="table-full-width table-responsive">
							<table class="table table-hover table-striped coupon_table">
								<thead> 
									<tr>
										<th><?=$coupon_Name?></th>
										<th><?=$coupon_Coupon?></th>
										<th>Discount Amount</th>
										<th>Discount Type</th>
										<th><?=$coupon_valid_from?></th>
										<th><?=$coupon_valid_to?></th>
										<th></th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$sql = mysqli_query($con,"select * from affilate_coupon where merchant_id = '$MERCHANTID' order by date DESC");
								while($row = mysqli_fetch_array($sql)){
								?>
								<tr>
									<td><?php echo $row['name']; ?></td>
									<td ><?php echo $row['coupon']; ?></td>
									<td ><?php echo $row['discount_amount']; ?></td>
									<td ><?php echo $row['discount_type']; ?></td>
									<td><?php echo $row['valid_from']; ?></td>
									<td><?php echo $row['valid_to']; ?></td>
									<td class="popup_effect">
									<i class="nc-icon nc-zoom-split icon-bold"></i>
									<div class="popup_hover">   
										<div class="popup_desc">
											<div class="req_mockup">
												<p><?php echo $row['coupon_detail']; ?></p>
											</div> 	
										</div>
									</div>
									</td>
								<td><a href="index.php?Act=add_coupon&action=edit&coupon_id=<?php echo $row['id']; ?>">Edit</a> | <a href="javascript:;" onClick="deletetablerow(<?php echo $row['id']; ?>,'Are you sure you like to delete coupon <?php echo $row['name']; ?>','affilate_coupon','index.php?Act=coupons')">Delete</a></td>
								</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div> 
				</div> 
			</div> 
		</div>