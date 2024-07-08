<?php

 //*****************************************************************************/

   include_once '../includes/session.php';
   include_once '../includes/functions.php';
   include_once  '../includes/constants.php';


    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

		$acno 	= $_GET['acno'];
		$nname 	= $_GET['nname'];
	   //$no		= $_GET['no'];
		$ret	= $_GET['ret'];
        if ($ret != "T")
		{
			//finding details from ecom_egold table
			$sql	= "select * from partners_egold where egold_user_id=0";
			$ret 	= mysql_query($sql);

            echo mysql_error();
			if (mysql_num_rows($ret)>0)
			{
				$row 	= mysql_fetch_object($ret);
				$acno 	= stripslashes($row->egold_accno);
				$nname 	= stripslashes($row->egold_payeename);
			}
		}

?>
<form method="POST" action="egold_validate.php">

  <table width="70%" class="tablebdr" cellspacing="0" cellpadding="0">
    <tr align="center">
      <td height="22" colspan="3" class="tdhead">Egold Details</td>
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
      <td align="right"> Account No </td>
      <td align="right">&nbsp;</td>
      <td width="66%" align="left"><input name="txtacno" type="text" id="txtacno" value ="<?=$acno?>" size="30"></td>
    </tr>

    <tr>
      <td width="32%" align="right">Payee Name </td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left"><input name="txtpayeename" type="text" id="txtpayeename" value ="<?=$nname?>" size="30"> </td>
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