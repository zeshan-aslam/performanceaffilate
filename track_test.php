<?php
$test_type = $_REQUEST['testtype'];
// $test_type = 1;
$tid = $_REQUEST['tid'];
// $tid = 1;

//generate random order number
$orderid = rand();
$order_value = rand(1, 60);
////********Get tracking details LEAD.
$mid_lead = "2";
$secid_lead = "M_29nH9aL2uO5yL";
////********Get tracking details SALE.
$mid_sale = "3";
$secid_sale = "M_32iZ5hJ4bS0fR";

$products = array( "p001" => array( "name" => "Product 001", "price" => 100), 
				   "p002" => array( "name" => "Product 002", "price" => 150), 
				   "p003" => array( "name" => "Product 003", "price" => 200),
				   "p004" => array( "name" => "Product 004", "price" => 250)
				);

$productIds = "";

$productCounter = 0;
$productIndex = rand(0, 3);

foreach($products as $key => $product)
{
	if($productCounter == $productIndex)
	{
		$productIds = $key;
		break;
	}
	$productCounter++;
}


$aiQueryString = "";

$postage = rand(5, 20);
$tax = rand(10, 15);
$cartid = rand(100, 200);
$trafficsource = "google";
$auid = "16363";
$keyword = "keyword";

$aiQueryString = "&products=".$productIds."&postage=".$postage."&tax=".$tax."&cartid=".$cartid."&trafficsource=".$trafficsource."&auid=".$auid."&keyword=".$keyword;

//Tracking Lead IMAGE TEST-TYPE 1
if ($test_type == "1"){
	$display_tracking = '<img src="https://avaz.co.uk/trackingcode_lead.php?mid='.$mid_lead.'&sec_id='.$secid_lead.'&orderId='.$orderid.'&tid='.$tid.'" height="1" width="1" alt="">';
	$test_type_name = 'Lead - Image';
	}
//Tracking Lead JAVASCRIPT TEST-TYPE 2
if ($test_type == "2"){
	$display_tracking = '<script language="JavaScript" type="text/javascript" src="https://avaz.co.uk/trackingcode_lead.php?mid='.$mid_lead.'&sec_id='.$secid_lead.'&orderId='.$orderid.'&tid='.$tid.'"></script>';
	$test_type_name = 'Lead - JavaScript';
	}
//Tracking Sale IMAGE TEST-TYPE 3
if ($test_type == "3"){
	$display_tracking = '<img src="https://avaz.co.uk/trackingcode_sale.php?mid='.$mid_sale.'&sec_id='.$secid_sale.'&sale='.$order_value.'&orderId='.$orderid.'&tid='.$tid.$aiQueryString.'" height="1" width="1" alt="">';
	$test_type_name = 'Sale - Image';
	}
//Tracking Sale JAVASCRIPT TEST-TYPE 4
if ($test_type == "4"){
	$display_tracking = '<script language="JavaScript" type="text/javascript" src="https://avaz.co.uk/trackingcode_sale.php?mid='.$mid_sale.'&sec_id='.$secid_sale.'&sale='.$order_value.'&orderId='.$orderid.'&tid='.$tid.'"></script>';
	$test_type_name = 'Sale - JavaScript';
	}
//$display_tracking = '1';



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>AVAZ Tracking System Test Kit Part 3</title>
</head>

<body>
Avaz Tracking Test<br>
Test Type: <?php echo   $test_type_name; ?> <br>
Order Id: <?php echo   $orderid; ?><br>
Order Value: <?php echo   $order_value; ?><br>

<?php echo htmlentities($display_tracking); ?>

</body>

</html>
