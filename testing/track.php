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
<title>Tracking Test SALE</title>
</head>
<h1>Tracking Test SALE</h1>
<!--START Searlco Affiliate Network CODE-->
<img src="https://searlco.net/trackingcode_sale.php?mid=2&sec_id=M_20rF3sG6kC3hV&sale=<?php echo $AMMOUNT ; ?>&orderId=<?php echo $ORDERID ; ?>&tid=<?php echo $TID  ; ?>&productids=123-456-789&postage=4.99&taxcosts=1.99&cartid=<?php echo $CARTID ; ?>&auid=<?php echo $AUID ; ?>&trafficsource=testsource&keyword=testkeyword" height="1" width="1" alt=""> 
<!-- END Searlco Affiliate Network CODE -->	
	link:~<br>
https://searlco.net/trackingcode_sale.php?mid=2&sec_id=M_20rF3sG6kC3hV&sale=<?php echo $AMMOUNT ; ?>&orderId=<?php echo $ORDERID ; ?>&tid=<?php echo $TID  ; ?>&productids=123-456-789&postage=4.99&taxcosts=1.99&cartid=<?php echo $CARTID ; ?>&auid=<?php echo $AUID ; ?>&trafficsource=testsource&keyword=testkeyword
<body>
</body>
</html>
