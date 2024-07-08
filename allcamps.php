<?php 
 include 'includes/db-connect.php';
$chk_merID = $_REQUEST['chk'];
$ops = $_REQUEST['ops'];
$today = date("Y-m-d");
$days_ago = date('Y-m-d', strtotime('-30 days'));
echo $days_ago;

if ($ops == "1"){
	//update the checked date
	$sql_chk = "UPDATE partners_merchant SET last_check='$today' WHERE merchant_id='$chk_merID'";
	$res_chk = mysqli_query($con,$sql_chk);
	echo $today;
}

 $sql="SELECT * FROM partners_text_old
  left JOIN partners_program
 ON partners_text_old.text_programid = partners_program.program_id
 left JOIN partners_banner
 ON partners_banner.banner_programid = partners_program.program_id
 left JOIN partners_merchant 
 ON partners_program.program_merchantid = partners_merchant.merchant_id WHERE partners_merchant.last_check < $days_ago AND partners_merchant.merchant_status = 'approved' LIMIT 50";

  $res=mysqli_query($con,$sql);
$count_ads = mysqli_num_rows($res);


 ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container m-5">
 <h1>Details - Adverts (<?= $count_ads; ?>)</h1>
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        
        <th>Program Id</th>
        <th>Merchant Id</th>
        <th>Merchant Company</th>
        <th>Text Url</th>
        <th>Banner Url</th>
     
      </tr>
    </thead>
    <tbody>
    <?php 
		$error_text_url = 0;
		$error_ban_url = 0;
		$error_brand_power = 0;
		$error_cat = 0;
		$error_promo_area = 0;
		$error_no_ban_url = 0;
		$error_no_text_url = 0;
		
		while($row=mysqli_fetch_array($res))
  {
			$merchantid = $row['merchant_id'];
			$status = $row['merchant_status'];
			if ($status =="approved"){
			$advert_error = "0";
		$brand_power = $row['brand_power'];
		if ($brand_power != "1"){
			if ($brand_power != "3"){
				$brand_status = '<p style="color:red"><b>BRAND NUMBER ERROR.</b></p>';
				$error_brand_power = $error_brand_power + "1";
				$advert_error = "1";
				}
			}
		//check to see if they have a promo area
			$promo_area = $row['country_permotion'];
				//echo $merchantid;
			$ct_cp = "";
				$merchantid = $row['merchant_id'];
			$sql_cp = "SELECT * FROM partners_merchant_countries WHERE merchantid = $merchantid";
			$res_cp = mysqli_query($con,$sql_cp);
			$ct_cp = mysqli_num_rows($res_cp);
				//echo $ct_cp.'<br>';
			if ($ct_cp > 0){
				    $row_cp = mysqli_fetch_array($res_cp);
					$countryid = $row_cp['countryid'];
					$sql_hc = "SELECT * FROM partners_country WHERE country_no = $countryid";
					$res_hc = mysqli_query($con,$sql_hc);	
					$row_hc = mysqli_fetch_array($res_hc);
					$display_countries = $row_hc['country_name'].'<br>';
					//echo $row_hc['country_name'];
					//echo "<br>";
			}else{
				//echo $ct_cp.'<br>'; 
				$promo_status = '<p style="color:red"><b>PROMO AREA MISSING</b></p>';
				$error_promo_area = $error_promo_area + "1";
				$advert_error = "1";
				
			}

		//check to make sure that category doesnt equal other
		$category_area = $row['merchant_category'];
			$sql_c = "SELECT * FROM partners_category WHERE cat_id = $category_area";
			$res_c = mysqli_query($con,$sql_c);	
			$row_c = mysqli_fetch_array($res_c);
			$category_area_name = $row_c['cat_name'];
				
		if($category_area_name == "Other" || $category_area_name == "Retail"){
			$cat_status = '<p style="color:red"><b>CATEGORY = OTHER/RETAIL Change it!</b></p>';
			$error_cat = $error_cat +1;
			$advert_error = "1";
		}
		
		//check the banner & text links for the {CLICKID}
			if ($row['text_url'] !=""){
				if (preg_match("{CLICKID}", $row['text_url'])) {
					$text_url_status = "";
				} else {
					$text_url_status = "ERROR NO {CLICKID} IN TEXT URL.";
					$error_text_url = $error_text_url + "1";
					$advert_error = "1";
				}
			}
			if ($row['text_url'] ==""){
				$text_url_status = "ERROR NO TEXT URL.";
				$error_no_text_url = $error_no_text_url + "1";
				$advert_error = "1";				
			}

			if ($row['banner_url'] !=""){
				if (preg_match("{CLICKID}", $row['banner_url'])) {
					$ban_url_status = "";
				} else {
					$ban_url_status = "ERROR NO {CLICKID} IN BANNER URL.";
					$error_ban_url = $error_ban_url + "1";
					$advert_error = "1";
				}
			}
			if ($row['banner_url'] ==""){
					$ban_url_status = "ERROR NO BANNER URL.";
					$error_no_ban_url = $error_no_ban_url + "1";
					$advert_error = "1";				
			}

			}
	if ($status =="approved"){
		
		$advert_count = $advert_count + "1";

		?>
     <tr>
        <td>
  <span><?=$row['text_programid']?></span></td>
        <td>
  <span><?=$row['program_merchantid']?></span></td>
        <td>
  <span><?=$row['merchant_company']?></span></td> 
  <td>
  <span><?=$row['text_url']?> <br>  <a href="<?=$row['text_url']?>" target="_blank"><b>[Check] <?php echo $text_url_status; ?></b></a> </span></td> 
  <td>
  <span><?=$row['banner_url']?> <br>  <a href="<?=$row['banner_url']?>" target="_blank"><b>[Check] <?php echo $ban_url_status; ?></b></a><br><b>Brands:</b> <?=$row['brands']?>
	  <br><b>Brand Power:</b> <?=$row['brand_power']?> <?php echo $brand_status; ?>
	  <br><b>Category:</b> <?=$category_area_name?><?php echo $cat_status; ?>
	  <br><b>Promotional Area:</b><br><?=$display_countries; ?><?php echo $promo_status; ?>
	  <p><button onclick="location.href='allcamps.php?chk=<?=$merchantid; ?>&ops=1'" type="button">
         MARK AS CHECKED</button></p>
	  </span></td> 
      </tr>
    
  
  
 <?php  
	}
		$brand_status = "";
		$promo_status = "";
		$cat_status = "";
		$ban_url_status = "";
		$text_url_status = "";
		$display_countries = "";
		$ct_cp = "";			
} ?>
     
    </tbody>
  </table>
	  <h1>ERROR REPORT (Adverts: <?php echo $advert_count; ?>)</h1><BR>
	  	Text URL Errors = <?php echo $error_text_url; ?> - Search: <b>"ERROR NO {CLICKID} IN TEXT URL"</b><br>
		Banner URL Errors = <?php echo $error_ban_url; ?> - Search: <b>"ERROR NO {CLICKID} IN BANNER URL"</b><br>
		Brand Power Errors = <?php echo $error_brand_power; ?> - Search: <b>"BRAND NUMBER ERROR"</b><br>
		Category Errors = <?php echo $error_cat; ?> - Search: <b>"CATEGORY = OTHER/RETAIL Change it!"</b><br>
		Promo Area Errors = <?php echo $error_promo_area; ?> - Search: <b>"PROMO AREA MISSING"</b><br>
	    No TEXT URLs Errors = <?php echo $error_no_text_url; ?> - Search: <b>"ERROR NO TEXT URL."</b><br>
	    No BANNER URLs Errors = <?php echo $error_no_ban_url; ?> - Search: <b>"ERROR NO BANNER URL."</b><br>
	  <br>
	  <br>
	  TOTAL ERRORS = 
	  <?php
	  $total_errors = $error_text_url + $error_ban_url + $error_brand_power + $error_cat + $error_promo_area + $error_no_text_url + $error_no_ban_url;
	  echo $total_errors;
	  ?>
	  
	  <br>
	  <br>
	  <br>
	  <br>
	  
  </div>
</div>

</body>
</html>
 <div>
 
  </div>