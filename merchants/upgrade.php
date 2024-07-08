<?

      $sql ="select * from partners_paymentgateway where pay_status like 'Active' ";
	  $ret =mysqli_query($con,$sql);

      $date	   = date("Y-m-d");

      if($currValue != $default_currency_caption ){
          $amount1  = getCurrencyValue($date, $currValue, $amount);
      }
      else $amount1 = $amount;
?>
<div class="row"> 
	<div class="col-md-12">
		<div class="card stacked-form">
			<form name="f1" method="post" action="upgrade_validate.php?id=<?=$id?>&amp;amount=<?=$amount?>"> 
				<div class="card-header">
					<h4 class="card-title"><?=$lang_PleaseSelectPaymentGateway?></h4>
				</div> 
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6">
							<div class="form-group">
								<label><?=$lang_Amount?>:&nbsp;
								<b><?=$currSymbol?> <?=$amount1?></b></label>
							</div>
							<div class="form-group">
								<label><?=$lang_PaymentGateways?></label>
								<select class="dropdown form-control" name="modofpay">
								  <?php
								  //checking for each records
									   if(mysqli_num_rows($ret)>0)
									   {
									   while($row=mysqli_fetch_object($ret))
									   {     if($modofpay==$row->pay_name) $sel="selected='selected'";
											 else  $sel ="";
											 ?>
									  <option  <?=$sel?>  value="<?=$row->pay_name?>">
									  <?=$row->pay_name?>
									  </option>
									  <?
											}
									   }  ?>
							  </select>
							</div>
							<div class="form-group">
								<input name="currValue" type="hidden" value="<?=$currValue?>" />
								<input type="submit" class="btn btn-fill btn-info" name="Submit" value="Pay Now" />
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>