<?php
	$id		= $_SESSION['AFFILIATEID'];
	
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
?>
			<form name="req" method="post" action="request_process.php?balance=<?=$balance?>">
			  <table width="60%" border="0" align="center" class="tablebdr">
				<tr>
				  <td height="33%" colspan="4" class="tdhead" align="center"><b><?=$req1_awr?></b></td>
				</tr>
				<tr>
				  <td height="29" colspan="4" class="textred" align="center"><?=stripslashes($_GET['msg'])?></td>
				</tr>
				<tr>
				  <td width="1%" height="29">&nbsp;</td>
				  <td width="48%"><?=$req1_aba?></td>
				  <td width="50%"><strong><?=$currSymbol?>&nbsp;<?=$balance?></strong></td>
				  <td width="1%">&nbsp;</td>
				</tr>
				<tr>
				  <td height="29">&nbsp;</td>
				  <td><?=$req1_mwa?></td>
				  <td><strong><?=$currSymbol?>&nbsp;<?=$minimum_withdraw?></strong></td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td height="29">&nbsp;</td>
				  <td> <?=$req1_rwa?> </td>
				  <td><strong><?=$currSymbol?>&nbsp;</strong> <input name="amount" type="text" size="30" value= "<?=$_GET['amount']?>"></input></td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td height="29">&nbsp;</td>
				  <td colspan="2" ><div align="center">
					<input type="submit" name="Submit" value="<?=$req1_but?>"></input>
				  </div></td>
				  <td>&nbsp;</td>
				</tr>
			  </table>
			  </form>
	<?
		}
	}
	else{
		echo "<div align='center' class='textred'>$affiliate_ucant</div>";
	}
	?>