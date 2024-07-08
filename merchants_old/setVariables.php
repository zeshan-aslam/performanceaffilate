<?php
	$Err 		= $_GET['Err'];
	if($Err==1) 
		$msg 	= $getcode_err;
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
	<p align="center" >
    	<b><a href="../docs/IntegrationMethods.php" target="_blank" ><?=$lang_shoppingCartIntegration?></a></b>
    </p>
	<form name="FormName" action="setVariables_validate.php" method="post">
	<table border="0" cellpadding="0"  width="60%" class="tablebdr" align="center">
		<tr>
			<td  height="26" colspan="4" class="tdhead" align="center"><b><?=$getcode_title?></b></td>
		</tr>
		<tr>
			<td  height="25" colspan="4" align="center" class="textred"> <?=$msg?></td>
		</tr>
		<tr>
			<td colspan="4" align="center" ><span class="textred"><?=$getcode_note?></span> : <?=$getcode_title1?></td>
		</tr>
		<tr>
			<td  height="6" colspan="2" >&nbsp;</td>
		</tr>
		<tr>
			<td  height="26" colspan="2" align="right" width="50%"><?=$getcode_orderamt?> 
			<span class="textred">*</span></td>
			<td  height="26" colspan="2" align="left" width="50%">&nbsp;&nbsp;&nbsp; 
			<input name="saleAmt" type="text" value="<?=$saleAmt?>"/> &nbsp; 
			<a href="" title="<?=$toolTip?>"><?=$getcode_example?></a>
			</td>
		</tr>
		<tr>
			<td  height="26" colspan="2" align="right"><?=$getcode_orderid?> <span class="textred">*</span></td>
			<td  height="26" colspan="2" align="left">&nbsp;&nbsp;&nbsp; 
			<input name="orderId" type="text" value="<?=$orderId?>"/> &nbsp;  
			<a href="" title="<?=$toolTip2?>"><?=$getcode_example?></a>
			</td>
		</tr>
		<tr>
			<td  height="36" colspan="4" align="center">
			<input type="submit" name="UpdateandMove" value="<?=$getcode_update?>"/></td>
		</tr>
	</table>
	</form>