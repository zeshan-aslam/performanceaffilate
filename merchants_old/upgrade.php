<?

      $sql ="select * from partners_paymentgateway where pay_status like 'Active' ";
	  $ret =mysqli_query($con,$sql);

      $date	   = date("Y-m-d");

      if($currValue != $default_currency_caption ){
          $amount1  = getCurrencyValue($date, $currValue, $amount);
      }
      else $amount1 = $amount;
?>
<form name="f1" method="post" action="upgrade_validate.php?id=<?=$id?>&amp;amount=<?=$amount?>">
  <table width="80%" border="0" align="center" class="tablebdr">
    <tr class="tdhead" >
      <td colspan="3"><div align="center"><?=$lang_PleaseSelectPaymentGateway?></div></td>
    </tr>
    <tr>
      <td width="1%">&nbsp;</td>
      <td width="44%"><?=$lang_Amount?></td>
      <td width="55%"><?=$currSymbol?> <?=$amount1?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?=$lang_PaymentGateways?> </td>
      <td><select class="dropdown" name="modofpay">
          <?php
		  //checking for each records
               if(mysqli_num_rows($ret)>0)
               {
                       while($row=mysqli_fetch_object($ret))
                       {     if($modofpay==$row->pay_name) $sel="selected='selected'";
                             else                          $sel ="";
                             ?>
          <option  <?=$sel?>  value="<?=$row->pay_name?>">
          <?=$row->pay_name?>
          </option>
          <?

                        }
               }  ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" align="center">
            <input name="currValue" type="hidden" value="<?=$currValue?>" />
          <input type="submit" name="Submit" value="Pay Now" />
     </td>
    </tr>
  </table>
</form>