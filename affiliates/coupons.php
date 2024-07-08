<?php global $con;
//$MERCHANTID   =$_SESSION['MERCHANTID'];  

// $date=date_create("2022-09-15");
//   $day = date_format($date,"d/m/Y");
//   echo $day;
// $today2 = date('d/m/Y');
// //  $date ="'.$today.'";
//  $today1."and".$today2;
$date1 = date('d/m/Y');
$today = explode('/', $date1);

?>
<div class="card strpied-tabled-with-hover">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<?php
				if (isset($_SESSION['successcoupon'])) {
				?>
					<p class="alert alert-success"><?php echo $_SESSION['successcoupon']; ?></p>
				<?php
					unset($_SESSION['successcoupon']);
				} else if (isset($_SESSION['faliurecoupon'])) {
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
								<th><?= $Merchant_name ?></th>
								<th><?= $coupon_Coupon ?></th>
								<th>Offers</th>
								<th><?= $coupon_valid_from ?></th>
								<th><?= $coupon_valid_to ?></th>
								<th></th>

							</tr>
						</thead>
						<tbody>
							<?php
							$sql = mysqli_query($con, "select c.*, m.merchant_company from affilate_coupon c left join partners_merchant m on c.merchant_id = m.merchant_id order by date DESC");
							while ($row = mysqli_fetch_array($sql)) {

								$date2 = $row['valid_to'];
								$validTo = explode('/', $date2);

								if ($validTo[0] >= $today[0] && $validTo[1] >= $today[1] && $validTo[2] >= $today[2]) {


									$merchant_id = $row['merchant_id'];



							?>
									<tr>
										<td><?php echo $row['merchant_company']; ?></td>
										<td><?php echo $row['coupon']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['valid_from']; ?></td>
										<td><?php echo $row['valid_to']; ?></td>
										<td class="popup_effect">
											<i class="nc-icon nc-zoom-split icon-bold"></i>
											<div class="popup_hover affiliate_popuphover">
												<div class="popup_desc">
													<div class="req_mockup">
														<p><?php echo $row['coupon_detail']; ?></p>
													</div>
												</div>
											</div>
										</td>

									</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>