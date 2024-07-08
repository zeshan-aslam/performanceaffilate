<?php 
include 'includes/db-connect.php';
// grab all the merchant data
$sql="SELECT * FROM partners_merchant";
$res=mysqli_query($con,$sql);
$added_records = 0;
while($row=mysqli_fetch_array($res)){
	$merchantid = $row['merchant_id'];
	//grab the countries of promotion
	$country_promo = $row['country_permotion'];
	//check to see if they are already in the DB
	$sql2 = "SELECT * FROM partners_merchant_countries WHERE merchantid = $merchantid";
	$res2 = mysqli_query($con,$sql2);
	$count2 = mysqli_num_rows($res2);
	//if no results add some
	if($count2 < 1){
		$sql3 = "INSERT INTO partners_merchant_countries (merchantid, countryid)
		VALUES 
		($merchantid, $country_promo)";	
		$res3 = mysqli_query($con,$sql3);
		$added_records = $added_records + 1;
	}
}
echo 'Total records added: '.$added_records;

 ?>