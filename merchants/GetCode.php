 <?
	#------------------------------------------------------------------------------
	# getting mercahnt status
	#------------------------------------------------------------------------------

	$mid = $_SESSION['MERCHANTID'];

	$sql	=	"select * from partners_merchant where merchant_id='$mid'";
	$ret	=	mysqli_query($con, $sql);
	if (mysqli_num_rows($ret) > 0) {
		$row		= mysqli_fetch_object($ret);
		$randNo	= trim($row->merchant_randNo);
		$orderId	= trim($row->merchant_orderId);
		$saleAmt	= trim($row->merchant_saleAmt);
	}

	$orderid = $orderId;
	$saleamt = $saleAmt;

	?>
 <div class="row">
 	<div class="col-md-12">
 		<div class="card-body">
 			In order for us to track your sale/lead this MUST be placed on the confirmation page / completed sale page.<br>
 			All transactions will then be recorded and available within the reports.<br>
 			If you are using variables for Order ID &amp; Sale Value please make sure these fields are populated.<br>
 			Please note all transactions are validated automatically within 7 days.<br><br>

 			<b>(tid) = Tracking Identifying Code [?]</b><br>
 			Everytime a user is sent through an affiliate link we provide you with a (TID) this is for cookieless tracking. You must store this (TID) and provide it back to us on the event of a sale that has been generated from us.<br>
 			<br>
 			<b>Other Variables [?]</b><br>
			Sale amount = the total value of the sale <b>DO NOT INCLUDE CURRENCY SYMBOL </b><br>  
 			productids = List all product ids of items within the transaction using a seperator eg 112233-223344<br>
 			postage = Put all details of any postage costs eg 3.99<br>
 			taxcosts = Place any tax costs such as VAT eg = 12.20<br>
 			cartid = If you have multiple cart/countries you can place them here eg = UK or 14556.

 		</div>
 	</div>
 </div>
 <div class="row">
 	<div class="col-md-12">
 		<div class="card stacked-form trackcode_form">
 			<div class="card-body">
 				<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><? //=$lang_shoppingCartIntegration
																				?></a>-->
 				<h4 class="card-title"><?= $lgetcode_TrackingCodeforLead ?></h4>
 				<div class="form-group">
 					<textarea rows="10" name="headertxt" class="form-control">
	                <?
					$code =  "\n<!--START $title CODE-->\n<img src=\"$track_site_url/trackingcode_lead.php?mid=$mid&amp;sec_id=$randNo&amp;orderId=$orderid&amp;tid={tid}&amp;productids={productids}&amp;postage={postage}&amp;taxcosts={taxcost}&amp;cartid={cartid}&amp;auid={auid}&amp;trafficsource={trafficsource}&amp;keyword={keyword}\" height=\"1\" width=\"1\" alt=\"\"> \n<!-- END $title CODE -->";
					echo $code;
					?> 
	                </textarea>
 				</div>
 				<!--<p class="text-center"><b>OR</b></p>
				<div class="form-group">	 				
					<textarea rows="10" name="headertxt" class="form-control">
	                <?  //$code = "\n<!--START $title CODE--> \n\n<script language=\"JavaScript\" type=\"text/javascript\" \n src=\"$track_site_url/trackingcode_lead.php?mid=$mid&amp;sec_id=$randNo&amp;orderId=$orderid\">\n</script>\n\n<!-- END $title CODE -->";
					// echo $code; 
					?>
	                </textarea>
				</div>-->

 				<h4 class="card-title"><?= $lgetcode_TrackingCodeforSale ?></h4>
 				<div class="form-group">
 					<textarea rows="10" name="headertxt" class="form-control">
	                <?
					$code =  "\n<!--START $title CODE-->\n<img src=\"$track_site_url/trackingcode_sale.php?mid=$mid&amp;sec_id=$randNo&amp;sale={Sale Amount}&amp;orderId=$orderid&amp;tid={tid}&amp;productids={productids}&amp;postage={postage}&amp;taxcosts={taxcost}&amp;cartid={cartid}&amp;auid={auid}&amp;trafficsource={trafficsource}&amp;keyword={keyword}\" height=\"1\" width=\"1\" alt=\"\"> \n<!-- END $title CODE -->";
					echo $code;
					?>
	                </textarea>
 				</div>
 				<!--<p class="text-center"><b>OR</b></p>
				<div class="form-group">					
					<textarea rows="10" name="headertxt" class="form-control">
	                <? // $code = "\n<!--START $title CODE--> \n\n<script language=\"JavaScript\" type=\"text/javascript\"   \n src=\"$track_site_url/trackingcode_sale.php?mid=$mid&amp;sec_id=$randNo&amp;sale=$saleamt&amp;orderId=$orderid\">\n</script>\n\n<!-- END $title CODE -->";
					//echo $code;
					?>
	                </textarea>
				</div>-->
 			</div>
 		</div>
 	</div>
 </div>