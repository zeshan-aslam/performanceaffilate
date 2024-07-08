<?php        

		//$name 	= $_GET['name'];
		$email 	= $_GET['email'];
	   //$no		= $_GET['no'];
		$ret	= $_GET['ret'];
        if ($ret != "T")
		{
			//finding details from ecom_checkout table
			$sql="select * from partners_checkout where checkout_user_id=0";
			$ret = mysql_query($sql);
			if (mysql_num_rows($ret)>0)
			{
				$row = mysql_fetch_object($ret);
				//$name = stripslashes($row->checkout_itemname);
				$email = stripslashes($row->checkout_email);
				//$no	= stripslashes($row->checkout_itemnumber);
			}
		}
         echo "";
?>
<form method="POST" action="checkout_validate.php">

  <table width="70%" class="tablebdr" cellspacing="0" cellpadding="0">
    <tr align="center">
      <td height="22" colspan="3" class="tdhead">Paypal Details</td>
    </tr>
    <tr align="center">
      <td colspan="3"><font color="#FF0000">
<!--        <?=$msg?>  -->
        </font></td>
    </tr>
    <tr align="center">
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"> Email</td>
      <td align="right">&nbsp;</td>
      <td width="66%" align="left"><input name="txtemail" type="text" id="txtemail" value ="<?=$email?>" size="30"></td>
    </tr>
    <!--tr>
      <td align="right"> Item Name</td>
      <td align="right">&nbsp;</td>
      <td align="left"><input name="txtname" type="text" value ="<?=$name?>" size="30"></td>
    </tr>
    <tr>
      <td align="right">Item Number</td>
      <td align="right">&nbsp;</td>
      <td align="left"><input name="txtno" type=text value="<?=$no?>" size="30"></td>
    </tr-->
    <tr>
      <td width="32%" align="right">&nbsp;</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">&nbsp; </td>
    </tr>
    <tr>
      <td  height="19" colspan="3">&nbsp;</td>
    </tr>
    <tr align="center">
      <td colspan="3"> <input type="submit" name="Submit" value="Update">
      </td>
    </tr>
    <tr>
      <td  height="19" colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td class="tdhead" height="22" colspan="3">&nbsp;</td>
    </tr>
  </table>
      </form>