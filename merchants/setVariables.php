<?php
	$Err 		= $_GET['Err'];
	if($Err==1) 
		// $msg 	= $getcode_err;
		$msg 	= "Please Don't Leave Any Fields Blank"; 
	$mid  		= $_SESSION['MERCHANTID'] ;
	$sql		= " select * from partners_merchant where merchant_id = '$mid'";
	$ret		= mysqli_query($con,$sql);
	if(mysqli_num_rows($ret)>0) {
		$row		= mysqli_fetch_object($ret);
		$randNo		= trim($row->merchant_randNo);
		$orderId	= trim($row->merchant_orderId);
		$saleAmt	= trim($row->merchant_saleAmt);
	}
?>
<div class="row">  
	<div class="col-md-6 mrauto">
		<div class="card stacked-form"> 
			<form name="FormName" action="setVariables_validate.php" method="post">
				<div class="card-header">
					<!--<a href="../docs/IntegrationMethods.php" target="_blank" ><?//=$lang_shoppingCartIntegration?></a>-->
					<h4 class="card-title"><?=$getcode_title?></h4>
					<strong class="text-warning"><?=$msg?></strong>
					<p><b><?=$getcode_note?></b> : <?=$getcode_title1?></p>
				</div> 
				<div class="card-body"> 
					<div class="form-group">
						<label><?=$getcode_orderamt?>&nbsp;<span class="textred">*</span></label>
						<input name="saleAmt" class="form-control" type="text" value="<?=$saleAmt?>"/> &nbsp; 
						<a href="" title="<?=$toolTip?>"><?=$getcode_example?></a>
					</div>
					<div class="form-group">
						<label><?=$getcode_orderid?>&nbsp;<span class="textred">*</span></label>
						<input name="orderId" class="form-control" type="text" value="<?=$orderId?>"/> &nbsp;  
						<a href="" title="<?=$toolTip2?>"><?=$getcode_example?></a>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-fill btn-info" name="UpdateandMove" value="<?=$getcode_update?>"/>
					</div>				
				</div>     
			</form>
		</div>	
	</div>	
</div>	
	
	