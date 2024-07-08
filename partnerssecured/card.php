<html>
<head>
<title>Affiliate Network Pro</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--

.table-bg {
	background-image:url(../images/table-bg.jpg);
	background-repeat:repeat-x;
	background-color:#adc7e1;
}
.footer-bg {
	background-image:url(../images/footer-bg.jpg);
	background-repeat:repeat-x;
	height:92px;
}
.tablebdr{
	font-family: Verdana; 
	color: #000000; 
	border: 1px solid #000000;
	font-size:10px;
}
body {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	margin-top:0px;
	margin-left:0px;
	margin-right:0px;
	margin-bottom:25px;
	background-image:url(images/body-bg.jpg);
	background-repeat:repeat-x;
	background-color:#d5e7f9;
	color: #666666;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
}
input{ 
	font-family: Verdana; 
	color: #000000; 
	border: 1px solid #848484; 
	font-size:10pt; 
	background-color:#FFFFFF;
}

-->
</style>
</head>

<body>

<table width="970" border="0" align="center" cellpadding="0" cellspacing="0">	
	<tr>
		<td class="table-bg">
		<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr>
				<td>
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr><td><img src="../images/header.jpg" width="960" height="105" /></td></tr>
						<tr><td>&nbsp;</td>	</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="7">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr><td colspan="2">&nbsp;</td></tr>
								<tr>
									<td colspan="2" height="300">
									<form name="form1" method="POST" action="cardvalidate.php">
									<?
									foreach ($_POST as $key => $value){ //to stripslash all posted variables
										$value	= trim($value);
										$value	= stripslashes($value);
										$$key	= $value;
										echo "<input type='hidden' name='$key' value='$value'>";
									}
									?>
									
									<table width="50%" class="tablebdr" cellspacing="0" cellpadding="0" align="center">
										<tr align="center">
											<td height="22" colspan="3" class="tdhead"><b>Credit Card Details</b></td>
										</tr>
										<tr align="center"><td colspan="3">&nbsp;</td></tr>
										<tr>
											<td align="right">Credit Card No</td>
											<td align="right">&nbsp;</td>
											<td width="66%" align="left">
											<input name="creditcardno" type="text" id="creditcardno" value ="" size="30"></td>
										</tr>
										<tr align="center"><td colspan="3">&nbsp;</td></tr>
										<tr>
											<td align="right">Expiry Date </td>
											<td align="right">&nbsp;</td>
											<td align="left">
											<input name="expirydate" type="text" id="creditcardno2" value ="" size="30"></td>
										</tr>
										<tr align="center"><td colspan="3">&nbsp;</td></tr>
										<tr>
											<td width="32%" align="right">Amount</td>
											<td width="2%" align="right">&nbsp;</td>
											<td align="left"><b>&nbsp;$<?=$amount?></b></td>
										</tr>
										<tr>
											<td  height="19" colspan="3">&nbsp;</td>
										</tr>
										<tr align="center">
											<td colspan="3"><input type="submit" name="Submit" value="Transfer Amount"></td>
										</tr>
										<tr >
											<td colspan="3" height="10">&nbsp;</td>
										</tr>

									</table>
									</form>
									</td>
								</tr>
								<tr>
									<td colspan="2" valign="top" class="footer-bg">
									<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr><td height="30">&nbsp;</td></tr>
									<tr>
									<td height="30" align="center" class="footer_sep">Copyright 2009 &copy; Affiliate Network Pro</td>
									</tr>
								</table>
								
								</td>
								</tr>
							</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		<tr><td>&nbsp;</td></tr>
		</table></td>
	</tr>
	<tr>
		<td height="5" bgcolor="#ADC7E1"></td>
	</tr>
</table>
</body>
</html>
