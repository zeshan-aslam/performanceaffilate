<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #333333;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>

<body>
<table width="775"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="bottom" bgcolor="#000000"><img src="images/admin_01.gif" width="216" height="69"></td>
  </tr>
  <tr>
    <td>
	

<form name="form1" method="POST" action="cardvalidate.php">


<?

    foreach ($_POST as $key => $value)//to stripslash all posted variables
            {
          $value=trim($value);
          $value=stripslashes($value);
          $$key=$value;

         // echo "$key=>$value <br/>";


          echo "<input type='hidden' name='$key' value='$value'>";
        }
?>

  <table width="98%" class="tablebdr" cellspacing="0" cellpadding="0">
    <tr align="center">
      <td height="22" colspan="3" class="tdhead">Credit Card Details</td>
    </tr>
    <tr align="center">
      <td colspan="3"><font color="#008040">
                </font></td>
    </tr>
    <tr align="center">
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Credit Card No</td>
      <td align="right">&nbsp;</td>
      <td width="66%" align="left"><input name="creditcardno" type="text" id="creditcardno" value ="" size="30"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Expiry Date </td>
      <td align="right">&nbsp;</td>
      <td align="left"><input name="expirydate" type="text" id="creditcardno2" value ="" size="30"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="32%" align="right">Amount</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left"><b>&nbsp;$<?=$amount?></b></td>
    </tr>
    <tr>
      <td  height="19" colspan="3">&nbsp;</td>
    </tr>
    <tr align="center">
      <td colspan="3">
        <input type="submit" name="Submit" value="Transfer Amount">
      </td>
    </tr>
  </table>
      </form>
	</td>
  </tr>
  <tr>
    <td height="20" bgcolor="#ffcc66"><div align="center"><SPAN class=style1>Copyright 2004 &copy; AlstraSoft All Rights Reserved.</SPAN></div></td>
  </tr>
</table>
</body>
</html>
