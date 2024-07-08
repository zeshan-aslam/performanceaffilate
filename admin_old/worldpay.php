<?php

	$acno 	= $_GET['acno'];
	$ret	= $_GET['ret'];
	
	if ($ret != "T")
	{
		//finding details from ecom_egold table
		$sql	= "select * from partners_worldpay ";
		$ret 	= mysql_query($sql);
		
		if (mysql_num_rows($ret)>0)
		{
			$row 	= mysql_fetch_object($ret);
			$acno 	= stripslashes($row->worldpay_accno);
		}
	}

?>
	<form method="POST" action="worldpay_validate.php">
	
		<table width="70%" class="tablebdr" cellspacing="0" cellpadding="0">
			<tr align="center">
				<td height="22" colspan="3" class="tdhead">WorldPay Details</td>
			</tr>
			<tr align="center">
				<td colspan="3"><font color="#FF0000"><?=$_GET['msg']?></font></td>
			</tr>
			<tr align="center">
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td align="right"> Account No </td>
				<td align="right">&nbsp;</td>
				<td width="66%" align="left"><input name="txtacno" type="text" id="txtacno" value ="<?=$acno?>" size="30"></td>
			</tr>
			<tr>
				<td  height="19" colspan="3">&nbsp;</td>
			</tr>
			<tr align="center">
				<td colspan="3"> <input type="submit" name="Submit" value="Update"></td>
			</tr>
			<tr>
				<td  height="19" colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td class="tdhead" height="22" colspan="3">&nbsp;</td>
			</tr>
		</table>
	</form>