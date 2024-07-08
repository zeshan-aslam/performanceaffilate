

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
      <td colspan="3"><font color="#008040"></font></td>
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