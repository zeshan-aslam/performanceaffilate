<?php
$tid = $_REQUEST['tid'];
$mid = $_REQUEST['mid'];

$randOID = rand(1000,6789);
$randVal = rand(1000,6789);
$randAUID = rand(1000,6789);
$wordstring = 'https://performanceaffiliate.com/performanceAffiliateClone/trackingcode_sale.php?mid='.$mid.'&sec_id=M_186lZ3xM3hR4kH&sale='.$randVal.'&orderId='.$randOID.'&tid='.$tid.'&productids={productids}&postage=5.00&taxcosts=2.99&auid='.$randAUID;
//    $data ="<img id='track_sale' src='".$wordstring."' height='1' width='1' alt=''/>";
//    $data1.="<p> TID ='".$tid."'</p>"; 
//    $data1 ="Tracking Successfull with TID : ".$tid;
//     echo json_encode($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Tracking Test</title>
</head>
<body>
    <img src="<?php echo $wordstring?>" alt="">
</body>
</html>
