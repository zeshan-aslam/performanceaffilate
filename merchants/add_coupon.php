 <?php
	global $con;
	$coupon_id = isset($_GET['coupon_id']) ? $_GET['coupon_id'] : -1;
	$sql = mysqli_query($con, "select * from affilate_coupon where id = '$coupon_id'");
	$rows = mysqli_fetch_array($sql);

	?>
 <script language="javascript" type="text/javascript">
 	function from_date() {
 		gfPop.fStartPop(document.trans.coupon_valid_from, Date);
 	}

 	function to_date() {
 		gfPop.fStartPop(document.trans.coupon_valid_to, Date);
 	}
 </script>
 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
 </iframe>
 <div class="card stacked-form">
 	<div class="card-body">
 		<div class="row">
 			<div class="col-md-6 mrauto">
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
 				<form name="trans" action="save_coupon.php?coupon_id=<?php echo $coupon_id; ?>" method="post">
 					<div class="form-group">
 						<label><?= $coupon_Name ?></label>
 						<input required name="coupon_name" class="form-control" type="text" value="<?php echo isset($rows['name']) ? $rows['name'] : ''; ?>">
 					</div>
 					<div class="form-group">
 						<label><?= $coupon_Coupon ?></label>
 						<input required name="coupon_coupon" class="form-control" type="text" value="<?php echo isset($rows['coupon']) ? $rows['coupon'] : ''; ?>">
 					</div>
 					<div class="form-group">
 						<label>Discount Amount</label>
 						<input name="discount_amount" class="form-control" type="text" placeholder="0.00" value="<?php echo isset($rows['discount_amount']) ? $rows['discount_amount'] : ''; ?>">
 					</div>
 					<div class="form-group">
 						<label>Discount Type</label>
 						<select name="discount_type" class="form-control" type="text" value="">
 							<option value="%" <?php  echo ($rows['discount_type']==='%') ? 'selected' : ''; ?>>%</option>
 							<option value="Dollar" <?php echo ($rows['discount_type']==='Dollar') ? 'selected' : ''; ?>>Dollar</option>
 							<option value="Pound" <?php echo ($rows['discount_type']==='Pound') ? 'selected' : ''; ?>>Pound</option>
 							<option value="Euro" <?php echo ($rows['discount_type']==='Euro') ? 'selected' : ''; ?>>Euro</option>
 						</select>
 					</div>
 					<div class="form-group">
 						<label><?= $coupon_valid_from ?></label>
 						<input name="coupon_valid_from" onfocus="javascript:from_date();return false;" class="form-control" type="text" value="<?php echo isset($rows['valid_from']) ? $rows['valid_from'] : ''; ?>">
 					</div>

 					<div class="form-group">
 						<label><?= $coupon_valid_to ?></label>
 						<input name="coupon_valid_to" onfocus="javascript:to_date();return false;" class="form-control" type="text" value="<?php echo isset($rows['valid_to']) ? $rows['valid_to'] : ''; ?>">
 					</div>


 					<div class="form-group">
 						<label><?= $coupon_detail ?></label>
 						<textarea style="height:100px;" class="form-control" name="coupon_detail"><?php echo isset($rows['coupon_detail']) ? $rows['coupon_detail'] : ''; ?></textarea>
 					</div>
 					<div class="form-group">
 						<button type="submit" class="btn btn-fill btn-info" name="coupon_save">Save Coupon</button>
 					</div>
 				</form>
 			</div>
 		</div>
 	</div>
 </div>