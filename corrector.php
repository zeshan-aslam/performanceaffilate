<?php 
 include 'includes/db-connect.php';

$sql_2 = "SELCT * FROM  partners_merchant";
$res2=mysqli_query($con,$sql_2);
while($row2=mysqli_fetch_array($res2)){
	$brands = $row2['brands'];
	$merid = $row2['merchant_id'];
	if (preg_match("|", $row2['brands'])) {
		$sql3 = "UPDATE partners_merchant SET brand_power = 3 WHERE merchant_id ='.$merid.'";
		$res3=mysqli_query($con,$sql3);
		}else{
		$sql3 = "UPDATE partners_merchant SET brand_power = 1 WHERE merchant_id ='.$merid.'";
		$res3=mysqli_query($con,$sql3);

	}
}
 ?>