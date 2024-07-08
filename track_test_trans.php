<?php
$test_type = $_REQUEST['testtype'];
//generate random order number
$orderid = rand();
$order_value = rand(1, 4000);

//Tracking Lead IMAGE TEST-TYPE 1
if ($test_type == "1"){
	$display_tracking = '<img src="http://avaz.co.uk/trackingcode_lead.php?mid=2&sec_id=M_29nH9aL2uO5yL&orderId='.$orderid.'" height="1" width="1" alt="">';
	$test_type_name = 'Lead - Image';
	}
//Tracking Lead JAVASCRIPT TEST-TYPE 2
if ($test_type == "2"){
	$display_tracking = '<script language="JavaScript" type="text/javascript" src="http://avaz.co.uk/trackingcode_lead.php?mid=2&sec_id=M_29nH9aL2uO5yL&orderId='.$orderid.'"></script>';
	$test_type_name = 'Lead - JavaScript';
	}
//Tracking Sale IMAGE TEST-TYPE 3
if ($test_type == "3"){
	$display_tracking = '<img src="http://avaz.co.uk/trackingcode_sale.php?mid=1&sec_id=M_29nH9aL2uO5yL&sale='.$order_value.'&orderId='.$orderid.'" height="1" width="1" alt=""> ';
	$test_type_name = 'Sale - Image';
	}
//Tracking Sale JAVASCRIPT TEST-TYPE 4
if ($test_type == "4"){
	$display_tracking = '<script language="JavaScript" type="text/javascript" src="http://avaz.co.uk/trackingcode_sale.php?mid=1&sec_id=M_29nH9aL2uO5yL&sale='.$order_value.'&orderId='.$orderid.'"></script>';
	$test_type_name = 'Sale - JavaScript';
	}
//$display_tracking = '1';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Avaz Tracking Test</title>
</head>

<body>
Avaz Tracking Test<br>
Test Type: <?php echo   $test_type_name; ?> <br>
Order Id: <?php echo   $orderid; ?><br>
Order Value: <?php echo   $order_value; ?><br>

<?php echo $display_tracking; ?>


</body>

</html>
