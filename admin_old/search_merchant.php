<?php        
	//check whether the balance for admin has reached the maximum amount set up by the admin
	$admin_sql = "SELECT pay_amount FROM  admin_pay  WHERE pay_id = 1";
    $admin_ret = mysqli_query($con, $admin_sql);
	if($admin_row = mysqli_fetch_object($admin_ret)) $admin_balance = $admin_row->pay_amount;

	//if maximum limit (from constants.php) is reached
	if($admin_balance>$admin_maximum_amount)
	{
		/*get message from file
		$filename			= "../admin/admin_maximum_balance_msg.htm";
		$fp 				= fopen($filename,'r');
		$admin_message 		= fread ($fp, filesize ($filename));
		fclose($fp);	*/
?>
   <table cellpadding="0" cellspacing="0" width="100%" align="center">
   <tr>
      <td width="100%" colspan="3" align="center" height="30" class="textred">Your account balance has reached the maximum balance amount limit.</td>
  </tr>
  
  </table>
<?php
	}

$merchantname	=trim(stripslashes($_POST['merchant']));
$searchbut		=trim($_POST['search'])  ;
if(empty($merchantname))  	$merchantname	  = trim(stripslashes($_GET['merchant']));
if($searchbut=="Search")    $_SESSION['SESSIONSTATUS']="all";
?>
<?php /*?>echo    "<br/>";
echo    "<form name=\"searchmerchantform\" method=\"post\" action=\"index.php?Act=merchants\"> ";
echo    "<table width=\"50%\" class=\"tablebdr\" align=\"center\">\n ";
echo    "<tr>";
echo    "<td class =\"tdhead\" height=\"25\" align=\"center\" colspan=\"3\">Search Merchant</td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\" colspan=\"3\"></td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\">Merchant</td>\n";
echo    "<td  height=\"25\" align=\"center\"><input type=\"text\" name=\"merchant\" value=\"$merchant\" /></td>\n";
echo    "<td  height=\"25\" align=\"center\"><input type=\"submit\" name=\"search\" value=\"Search\" /></td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\" colspan=\"3\"></td>\n";
echo    "</tr>";
echo    "</table>";
echo    "</form>";
<?php */?>

  <form name="searchmerchantform" method="post" action="index.php?Act=merchants">
  <table>
  <tr>
    <td align="center"><div style="width:880px;">
      <div style="width:9px; float:left; position:relative;"><img src="images/m-searchbox-left.jpg" width="9" height="109" /></div>
      <div style="width:862px; float:left; position:relative;" class="search-box-tile">
        <div style="height:45px;">&nbsp;</div>
        <div style="width:350px; float:left; position:relative; text-align:right; vertical-align:bottom; height:28px;" class="heading1">Search Merchant&nbsp;&nbsp; </div>
        <div style="width:200px; float:left; position:relative;">
          <input name="merchant" type="text" value="<? echo $merchant?>" style="border:#b0c0d2 thin solid; background-color:#ffffff; height:25px;" size="30" />
        </div>
        <div style="width:100px; float:left; position:relative;"><a href="#"><img src="images/search-btn.jpg" width="67" height="28" border="0" onclick="document.searchmerchantform.submit()" /></a></div>
      </div>
      <div style="width:9px; float:left; position:relative;"><img src="images/m-searchbox-right.jpg" width="9" height="109" /></div>
    </div></td>
  </tr>
  </table>
  </form>


