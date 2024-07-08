<?php
//get the TID
//$TID = $_REQUEST['tid'];
//generate random data for fields
$AMMOUNT = rand(1, 150);
$ORDERID = rand(1, 15000000);
$CARTID = rand(5, 15000000);
$AUID = 'TT'.rand(5, 15);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tracking Test LEAD</title>
</head>
<h1>Tracking Test LEAD</h1>
<!--START Searlco Affiliate Network CODE-->
<img src="https://searlco.net/trackingcode_lead.php?mid=1&sec_id=M_14pR5gG0rM4rR&orderId=<?php echo $ORDERID ; ?>&tid=<?php echo $TID  ; ?>&productids=1&postage=0&taxcosts=0&cartid=0&auid=<?php echo $AUID ; ?>&trafficsource=&keyword=" height="1" width="1" alt=""> 
<!-- END Searlco Affiliate Network CODE --> 	
	link:~<br>
https://searlco.net/trackingcode_lead.php?mid=1&sec_id=M_14pR5gG0rM4rR&orderId=<?php echo $ORDERID ; ?>&tid=<?php echo $TID  ; ?>&productids=1&postage=0&taxcosts=0&cartid=0&auid=<?php echo $AUID ; ?>&trafficsource=&keyword=
<body>
</body>
</html>