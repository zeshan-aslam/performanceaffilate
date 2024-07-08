<?php
$get_Token = $_GET['PerAffconToken'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Front</title>

</head>
<body>
    <div id="sfPerAff"></div>
    <script> 
    	var PerAffconToken = '<?= $get_Token ?>'; 
    	
	</script>
    <script src="https://performanceaffiliate.com/performanceAffiliateClone/affiliates/shop_Front_Apis/js/mainShopFrontPerAff.js"></script>
</body>
</html>
