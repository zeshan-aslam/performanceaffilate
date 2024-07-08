<?

$affiliatename	= trim(stripslashes($_POST['affiliate']));
$searchbut		= trim($_POST['search'])  ;
if(empty($affiliatename))  	$affiliatename	  = trim(stripslashes($_GET['affiliate']));
if($searchbut=="Search")    $_SESSION['SESSIONSTATUS']="all";

echo    "<br/>";
echo    "<form name=\"searchaffiliateform\" method=\"post\" action=\"index.php?Act=affiliates\"> ";
echo    "<table width=\"50%\" class=\"tablebdr\" align=\"center\">\n ";
echo    "<tr>";
echo    "<td class =\"tdhead\" height=\"25\" align=\"center\" colspan=\"3\">$lang_report_searchaff</td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\" colspan=\"3\"></td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\">$laff_Affiliate</td>\n";
echo    "<td  height=\"25\" align=\"center\"><input type=\"text\" name=\"affiliate\" value=\"$affiliate\" /></td>\n";
echo    "<td  height=\"25\" align=\"center\"><input type=\"submit\" name=\"search\" value=\"$affl_search\" /></td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\" colspan=\"3\"></td>\n";
echo    "</tr>";
echo    "</table>";
echo    "</form>";

?>