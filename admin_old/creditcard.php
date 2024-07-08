<?php


		//$name 	= $_GET['name'];
		$email 	= $_GET['email'];
	   //$no		= $_GET['no'];
		$ret	= $_GET['ret'];
        if ($ret != "T")
		{
			//finding details from  table
			$sql="select * from partners_creditcard";
			$ret = mysql_query($sql);
			if (mysql_num_rows($ret)>0)
			{
				$row = mysql_fetch_object($ret);
				$version = stripslashes($row->cc_version);
				$delimdata = stripslashes($row->cc_delimdata);
				$relayresponse	= stripslashes($row->cc_relayresponse);
				$login = stripslashes($row->cc_login);
				$trankey = stripslashes($row->cc_trankey);
				$cctype	= stripslashes($row->cc_type);

				if($delimdata=="True")
				{
					$delimdataselected1 = "selected";
					$delimdataselected2 = "";
				}
				else
				{
					$delimdataselected1 =  "";
					$delimdataselected2 = "selected";
				}

				if($relayresponse=="True")
				{
					$relayresponseselected1 = "selected";
					$relayresponseselected2 = "";
				}
				else
				{
					$relayresponseselected1 =  "";
					$relayresponseselected2 = "selected";
				}


			}
		}
         echo "";
?>
<form name="form1" method="POST" action="creditcard_validate.php">

  <table width="98%" class="tablebdr" cellspacing="0" cellpadding="0">
    <tr align="center">
      <td height="22" colspan="3" class="tdhead">Credit Card Details</td>
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
      <td align="right"> Version</td>
      <td align="right">&nbsp;</td>
      <td width="66%" align="left">
        <input name="version" type="text" id="txtemail" value ="<?=$version?>" size="30">
      </td>
    </tr>
    <tr>
      <td width="32%" align="right">&nbsp;</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="32%" align="right">Delimit Response Data</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">
        <select name="delimdata">
          <option value="True" <?=$delimdataselected1?>>True</option>
          <option value="False" <?=$delimdataselected2?>>False</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="32%" align="right">&nbsp;</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="32%" align="right">Relay Response</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">
        <select name="relayresponse">
          <option value="True"  <?=$relayresponseselected1?>>True</option>
          <option value="False"  <?=$relayresponseselected2?>>False</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="32%" align="right">&nbsp;</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="32%" align="right">Login</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">
        <input name="login" type="text" id="txtlogin" value ="<?=$login?>" size="30">
      </td>
    </tr>
    <tr>
      <td width="32%" align="right">&nbsp;</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="32%" align="right">Transaction Key</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">
        <input name="trankey" type="text" id="trankey" value ="<?=$trankey?>" size="30">
      </td>
    </tr>
    <tr>
      <td width="32%" align="right">&nbsp;</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="32%" align="right">Credit Card Type</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">
        <select name="cctype">
          <option value='AUTH_CAPTURE'>AUTH_CAPTURE</option>
          <option value='AUTH_ONLY'>AUTH_ONLY</option>
          <option value='CAPTURE_ONLY'>CAPTURE_ONLY</option>
          <option value='CREDIT'>CREDIT</option>
          <option value='VOID'>VOID</option>
          <option value='PRIOR_AUTH_CAPTURE'>PRIOR_AUTH_CAPTURE</option>
        </select>
<?
	if(!empty($cctype))
	{
?>
		<script language="JavaScript">
			document.form1.cctype.value = "<?=$cctype?>";
		</script>
<?
	}
?>
      </td>
    </tr>
    <tr>
      <td width="32%" align="right">&nbsp;</td>
      <td width="2%" align="right">&nbsp;</td>
      <td align="left">&nbsp; </td>
    </tr>
    <tr>
      <td  height="19" colspan="3">&nbsp;</td>
    </tr>
    <tr align="center">
      <td colspan="3">
        <input type="submit" name="Submit" value="Update">
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