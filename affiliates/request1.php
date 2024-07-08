<?php
	$id		= $_SESSION['AFFILIATEID'];
	//echo $id;
	$sql	= " SELECT * FROM affiliate_pay where pay_affiliateid=  '$id' ";
	$res	= mysqli_query($con,$sql);
	//echo mysql_error();
	if($num = mysqli_num_rows($res)>0){
		while ($row=mysqli_fetch_object($res)){
			$balance	= stripslashes(trim($row->pay_amount));
		}
		if($balance<=$minimum_withdraw){
			echo "<div align='center' class='textred'>$affiliate_ucant</div>";
		}
		else{
			$balance2    = number_format($balance, 2);
?>
<div class="row"> 
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?=$req1_awr?></h4>
				<span class="textred"><?=stripslashes($_GET['msg'])?></span>
			</div> 
			<div class="card-body request_withdraw">
				<form name="req" method="post" action="request_process.php?balance=<?=$balance?>">
					<label><span><?=$req1_aba?>:</span><strong><?=$currSymbol?>&nbsp;<?=getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],$balance2) ?></strong></label>	 
					<label><span><?=$req1_mwa?>:</span><strong><?=$currSymbol?>&nbsp;<?=getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'],$minimum_withdraw)?></strong></label>
					<label><span style="float:left;"><?=$req1_rwa?>:</span><strong style="float:left;"><?=$currSymbol?>&nbsp;</strong><input class="form-control" name="amount" type="text" size="30" value= "<?=$_GET['amount']?>" />
					<input type="hidden" id="affid" name="affid" value="<?php echo $id; ?>">
					<div class="clearfix"></div>
					</label>  
					<div class="clearfix"></div>
					<div class="">
						<input class="btn btn-fill btn-info" type="submit" name="Submit" value="<?=$req1_but?>" />	
					</div>	
					
				</form>
			</div>	
		</div>	 
	</div>	
</div>  
	<?
		}
	}
	else{
		?>
	<div class="row"> 
		<div class="col-md-12">
			<div class="card">	
				<div class="card-body">
					<?php
						echo "<span class='textred'>$affiliate_ucant</span>";
					}
					?>
				</div>	
			</div>	 
		</div>	
	</div>