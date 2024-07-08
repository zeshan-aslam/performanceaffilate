<?php

  $sql	=	"SELECT * FROM partners_paymentgateway ";
  $ret	=	mysqli_query($con,$sql);

  $msg	=	$_GET['msg'];

?>
<br/>
<br/>
<table class="tablewbdr" width="65%" align="center" cellpadding="0" cellspacing="0">
  <?php
  if(!empty($msg))
  {
?>
  <tr>
    <td colspan="3" align="center" valign="top" ><font color="#FF0000">
      <?=ucwords(strtolower(stripslashes($msg)))?>
      </font></td>
  </tr>
<?php
   }
?>
  <tr>
    <td width="44%" align="left" valign="top">
    <table class="tablebdr" width="100%" cellspacing="0" cellpadding="0">
    <tr align="center" valign="middle">
    	<td class="tdhead" height="16" colspan="3" valign="top" align="left">&nbsp;Payment Gateways</td>
    </tr>
    <tr align="center" valign="middle">
    	<td colspan="3" valign="top">&nbsp;</td>
    </tr>
<?php

	if(!mysqli_num_rows($ret))
    {
?>
    <tr align="center" valign="middle">
    	<td height="22" colspan="3" valign="top"><font color="#ff0000">No Payments Gateways to Show.</font></td>
    </tr>
    <?php
    	 echo"<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
    }
    else
    {
?>
        <!--tr align="center" valign="middle">
          <td width="13" class="tdhead">&nbsp;</td>
          <td width="325" height="16" align="left">&nbsp;</td>
          <td width="309" align="left" class="tdhead" height="16"></td>
        </tr-->
<?php
		$srno = 1;
		while($row=mysqli_fetch_object($ret))
        {
?>
        <tr align="center" valign="middle">
          <td width="13" >&nbsp;</td>
          <td width="325" height="19" align="left">
            <?
            echo ($row->pay_flag=="a")? "<b>$srno.&nbsp;".stripslashes($row->pay_name)."</b>": "<b>$srno.&nbsp;<a href='gatewayredirect.php?id=$row->pay_id'>".stripslashes($row->pay_name)."</a></b>"?>
          </td>
          <td width="309" height="19" align="left" >
<?php
		if($row->pay_status=="Inactive")
        	$linkss="<a href='payment_validate.php?act=rempay&amp;payid=".$row->pay_id."&amp;paynam=".stripslashes($row->pay_name)."&amp;dome=Active'>Activate?</a>";
		else
        	$linkss="<a href='payment_validate.php?act=rempay&amp;payid=".$row->pay_id."&amp;paynam=".stripslashes($row->pay_name)."&amp;dome=Inactive'>Suspend?</a>";?>
            <?=$linkss?>
          </td>
        </tr>
<?php
			$srno ++;
        }
?>
      <tr align="center" valign="middle">
    	<td colspan="3" valign="top">&nbsp;</td>
      </tr>
	  <tr>
      <td width ="100%" align="center" valign="top" class="tdhead" colspan="3">&nbsp;</td>
      </tr>
      </table>
      </td>
  </tr>
</table>
<?php	}	?>