<?php
//generate random order number
$orderid = rand();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-gb" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>AVAZ Tracking System Test Kit Part 1</title>
</head>

<body>
AVAZ Tracking System Test Kit Part 1
<p>Program ID: Lead <a href="https://avaz.co.uk/trackingcode.php?aid=4&linkid=N4&subid=<?php echo $orderid  ;?>" target="_blank">[GO]</a></p>
<p>Program ID: Sale <a href="https://avaz.co.uk/trackingcode.php?aid=4&linkid=N5&subid=<?php echo $orderid  ;?>" target="_blank">[GO]</a></p>

<p>REMEMBER TO CLEAR COOKIES EACH TIME TO CREATE SALE.</p>

</body>

</html>
