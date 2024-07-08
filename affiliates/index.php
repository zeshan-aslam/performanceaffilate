<?php
session_start();
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
header("Cache-control: private");
include_once '../includes/constants.php';
include_once '../includes/functions.php';

$Act	= $_GET['Act'];
if (!empty($_POST['languageid']))
	$_SESSION['LANGUAGE'] 	= $_POST['languageid'];

$partners	= new partners;
$partners->connection($host, $user, $pass, $db);
if (!$partners->isAffiliatelogin()) {
	header("Location:../index.php?Act=affiliate");
	exit;
}
$AFFILIATEID 	= $aid	= $_SESSION['AFFILIATEID'];

$currency_code	= $default_currency_code;

# get currency values
$currSql 	= " SELECT * FROM partners_currency, partners_affiliate 
					WHERE affiliate_id = '$aid' and currency_caption = affiliate_currency";
$currRet 	= @mysqli_query($con, $currSql);

if (@mysqli_num_rows($currRet) > 0) {
	$currRow 	= @mysqli_fetch_object($currRet);
	$currSymbol = stripslashes($currRow->currency_symbol);
	$currValue 	= stripslashes($currRow->currency_caption);
	$currCode =	$currency_code = stripslashes($currRow->currency_code);
}

$sql_affiliate	= "SELECT * FROM affiliate_pay WHERE pay_affiliateid = '$aid'  ";
$ret_affiliate	= mysqli_query($con, $sql_affiliate);
$row_affiliate	= mysqli_fetch_object($ret_affiliate);
$_SESSION['AFFILIATEBALANCE'] = $row_affiliate->pay_amount;

# get currency values

$cur_sql 		= " SELECT * FROM partners_currency WHERE currency_code = '$currency_code' ";
$res_cur = mysqli_query($con, $cur_sql);
if (mysqli_num_rows($res_cur) > 0) {
	$row_cur 	= mysqli_fetch_object($res_cur);
	$currSymbol = stripslashes($row_cur->currency_symbol);
	$_SESSION['DEFAULTCURRENCYSYMBOL'] = $currSymbol;
	$currValue 	= stripslashes($row_cur->currency_caption);
	$currCode 	= stripslashes($row_cur->currency_code);
}

$date	 		= date("Y-m-d");
//$currBalance 	= $row_affiliate->pay_amount;   

$currBalance = getCurrencyValue($date, $currValue, $row_affiliate->pay_amount);


include 'language_include.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Performance Affiliate Network</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
	<!-- CSS Files -->
	<link href="../public/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../public/assets/css/light-bootstrap-dashboard.css.css" rel="stylesheet" />
	<link href="../public/assets/css/demo.css" rel="stylesheet" />
	<!--<link rel="stylesheet" type="text/css" href="style.css"/>-->
	<script>
		var is_show_welcome = '<?php echo $welcomeflag; ?>';
	</script>
	<script src="../public/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
	<!--End To add multiple tags for brand names at merchant dashboard/profile  -->
	<script>
		var is_show_welcome = '<?php echo $welcomeflag; ?>';
	</script>

	<!-- Start For animatedTags for multi_Country on merchants/dashboard/accounts.php -->
	<link href="../animatedTags/dist/style.css" rel="stylesheet" />
	<script src="../animatedTags/dist/script.js" type="text/javascript"></script>
	<!-- End For animatedTags for multi_Country on merchants/dashboard/accounts.php  -->


</head>

<body>
	<div class="wrapper">
		<!-- Sidebar -->
		<?php include 'affiliates_sidebar.php'; ?>
		<div class="main-panel">
			<!-- Start Navbar -->
			<?php include 'affiliates_header.php'; ?>
			<!-- End Navbar -->
			<div class="content" style="min-height:500px;">
				<?php include "process.php"; ?>
			</div>
			<div>
				<?php include "footer.php"; ?>
			</div>

		</div>
	</div>

</body>

</html>