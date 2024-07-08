<?php

include_once '../includes/db-connect.php';
include_once '../includes/session.php';
header("Cache-control: private");
include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/function1.php';
include '../includes/allstripslashes.php';

$Act	= $_GET['Act'];

//if(!empty(intval($_POST['languageid']))) 
if (!empty($_POST['languageid']))
	$_SESSION['LANGUAGE'] = intval($_POST['languageid']);
$language	= $_SESSION['LANGUAGE'];

$partners	= new partners;
$partners->connection($host, $user, $pass, $db);

if (!$partners->isMerchantlogin()) {
	header("Location:../index.php?Act=merchant");
	exit;
}

$MERCHANTID = $mid 	= $_SESSION['MERCHANTID'];

$currency_code	= $default_currency_code;

$sql_merchant	=	"select * from merchant_pay where pay_merchantid='$mid'  ";
$ret_merchant	=	@mysqli_query($con, $sql_merchant);
$row_merchant	=	@mysqli_fetch_object($ret_merchant);

# get currency values
$currSql 	= " SELECT * FROM partners_currency, partners_merchant 
					WHERE merchant_id = '$mid' and currency_caption = merchant_currency";
$currRet 	= @mysqli_query($con, $currSql);

if (@mysqli_num_rows($currRet) > 0) {
	$currRow 	= @mysqli_fetch_object($currRet);
	$currSymbol = stripslashes($currRow->currency_symbol);
	$currValue 	= stripslashes($currRow->currency_caption);
	$currCode 	= $currency_code = stripslashes($currRow->currency_code);
}
$_SESSION['MERCHANTBALANCE'] = $row_merchant->pay_amount;

# Added for base Currency
$cur_sql 	= "SELECT * FROM partners_currency WHERE currency_code='$currency_code' ";
$res_cur 	= mysqli_query($con, $cur_sql);

if (mysqli_num_rows($res_cur) > 0) {
	$row_cur 	= mysqli_fetch_object($res_cur);
	$currSymbol = $basecurrSymbol = stripslashes($row_cur->currency_symbol);
	$_SESSION['DEFAULTCURRENCYSYMBOL'] = $currSymbol;
	$currValue 	= stripslashes($row_cur->currency_caption);
	$currCode 	= stripslashes($row_cur->currency_code);

	$_SESSION['CURRVALUE'] = $currValue;
}


$date 	= date("Y-m-d");

if ($currValue != $default_currency_caption) {
	$currBalance = $row_merchant->pay_amount;
}

include 'language_include.php';

$welcomeflag = 0;
if (isset($_SESSION['show_message'])) {
	$welcomeflag = 1;
	unset($_SESSION['show_message']);
}
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
	<script src="../public/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

	<!--Start To add multiple tags for brand names at merchant dashboard/profile  -->
	<!-- <script src="//code.jquery.com/jquery-3.3.1.min.js"></script> -->
	<link href="../checkToken/dist/tokenize2.min.css" rel="stylesheet" />
	<!-- <link href="../checkToken/demo/demo.css" rel="stylesheet" /> -->
	<link href="../checkToken/dist/tokenize2.min.css" rel="stylesheet" />
	<link href="../tagsAssets/style.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
	<!--End To add multiple tags for brand names at merchant dashboard/profile  -->
       

	<script>
		var is_show_welcome = '<?php echo $welcomeflag; ?>';
	</script>

	<!-- Start For animatedTags for multi_Country on merchants/dashboard/accounts.php -->
	<link href="../animatedTags/dist/style.css" rel="stylesheet" />
	<script src="../animatedTags/dist/script.js" type="text/javascript"></script>
	<!-- End For animatedTags for multi_Country on merchants/dashboard/accounts.php  -->

	<!-- Start For New Multiple tags used in https://performanceaffiliate.com/merchants/index.php?Act=accountsClone  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
	<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
	<!-- End For New Multiple tags used in https://performanceaffiliate.com/merchants/index.php?Act=accountsClone  -->


</head>

<body>
	<div class="wrapper">
		<!-- Sidebar -->
		<?php include 'merchants_sidebar.php'; ?>
		<div class="main-panel">
			<!-- Start Navbar -->
			<?php include 'merchants_header.php'; ?>
			<!-- End Navbar -->
			<div class="content">
				<?php include "process.php"; ?>
			</div>
			<?php include "footer.php"; ?>
		</div>
	</div>
	

</body>

</html>