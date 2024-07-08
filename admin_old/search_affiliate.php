<?
  
$affiliatename	=trim(stripslashes($_POST['affiliate']));
$searchbut		=trim($_POST['search'])  ;
if(empty($affiliatename))  	$affiliatename	  = trim(stripslashes($_GET['affiliate']));
if($searchbut=="Search")    $_SESSION['SESSIONSTATUS']="all";

/*echo    "<br/>";
echo    "<form name=\"searchaffiliateform\" method=\"post\" action=\"index.php?Act=affiliates\"> ";
echo    "<table width=\"50%\" class=\"tablebdr\" align=\"center\">\n ";
echo    "<tr>";
echo    "<td class =\"tdhead\" height=\"25\" align=\"center\" colspan=\"3\">Search Affiliate</td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\" colspan=\"3\"></td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\">Affiliate</td>\n";
echo    "<td  height=\"25\" align=\"center\"><input type=\"text\" name=\"affiliate\" value=\"$affiliate\" /></td>\n";
echo    "<td  height=\"25\" align=\"center\"><input type=\"submit\" name=\"search\" value=\"Search\" /></td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\" colspan=\"3\"></td>\n";
echo    "</tr>";
echo    "</table>";
echo    "</form>";
*/
?>
  <form name="searchmerchantform" method="post" action="index.php?Act=affiliates">
  <table>
  <tr>
    <td align="center"><div style="width:880px;">
      <div style="width:9px; float:left; position:relative;"><img src="images/m-searchbox-left.jpg" width="9" height="109" /></div>
      <div style="width:862px; float:left; position:relative;" class="search-box-tile">
        <div style="height:45px;">&nbsp;</div>
        <div style="width:350px; float:left; position:relative; text-align:right; vertical-align:bottom; height:28px;" class="heading1">Search Affiliate&nbsp;&nbsp; </div>
        <div style="width:200px; float:left; position:relative;">
          <input name="affiliate" type="text" value="<? echo $merchant?>" style="border:#b0c0d2 thin solid; background-color:#ffffff; height:25px;" size="30" />
        </div>
        <div style="width:100px; float:left; position:relative;"><a href="#"><img src="images/search-btn.jpg" width="67" height="28" border="0" onclick="document.searchmerchantform.submit()" /></a></div>
      </div>
      <div style="width:9px; float:left; position:relative;"><img src="images/m-searchbox-right.jpg" width="9" height="109" /></div>
    </div></td>
  </tr>
  </table>
  </form>

