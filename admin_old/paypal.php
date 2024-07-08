<?php

/*
        include_once 'includes/admin_session.php';
        include_once 'includes/constants.php';
        include_once 'includes/functions.php';
        connect($host,$dbuser,$dbpass,$db);
        $handle = new traffic;
*/

		//$name 	= $_GET['name'];
		$email 	= $_GET['email'];
	   //$no		= $_GET['no'];
		$ret	= $_GET['ret'];
        if ($ret != "T")
		{
			//finding details from ecom_paypal table
			$sql="select * from partners_paypal where paypal_user_id=0";
			$ret = mysqli_query($con,$sql);
			if (mysqli_num_rows($ret)>0)
			{
				$row = mysqli_fetch_object($ret);
				//$name = stripslashes($row->paypal_itemname);
				$email = stripslashes($row->paypal_email);
				//$no	= stripslashes($row->paypal_itemnumber);
			}
		}
         echo "";
?>
<form method="POST" action="paypal_validate.php">

  <table width="70%" class="tablebdr" cellspacing="0" cellpadding="0">
    <tr align="center">
      <td height="22" colspan="3" class="tdhead">Paypal Details</td>
    </tr>
    <tr align="center">
      <td colspan="3"><font color="#FF0000">
        <?=$_GET['msg']?>
        </font></td>
    </tr>
    <tr align="center">
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td align="right"> Email</td>
      <td align="right">&nbsp;</td>
      <td width="66%" align="left"><input name="txtemail" type="text" id="txtemail" value ="<?=stripslashes($email)?>" size="30"></td>
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