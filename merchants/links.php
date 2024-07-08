<?php
$merchentid  =   $_SESSION['MERCHANTID'];
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
		$header_bg1  = $header_bg2 = $header_bg3 = $header_bg4 = $header_bg5 = $header_bg6 = $header_bg7 = $header_bg8 =  $header_bg9 = "header_bg_white";
	switch($Act)
	{
		case "home":
        case "waitrotator":
        case "waitingpgm":
        case "listaffiliate":
        case "GetCode":
			$header_bg1 = "header_bg_blue";
			$header_bg11 = "headeractive";
			break;

		case "accounts":
			$header_bg2 = "header_bg_blue";
			$header_bg21 = "headeractive";
			break;

		case "programs":
        case "programedit":
        case "uploadProducts":
        case "waitingaff":
		case "newprogram":
		case "add_text":
		case "add_textnew":
		case "add_html":
		case "add_flash":
		case "add_banner":
		case "add_popup":
			$header_bg3 = "header_bg_blue";
			$header_bg31 = "headeractive";
			break;

		case "affiliates":
			$header_bg4 = "header_bg_blue";
			$header_bg41 = "headeractive";
			break;

		case "emails":
        case "paidmail":
			$header_bg5 = "header_bg_blue";
			$header_bg51 = "headeractive";
			break;

		//for all these 5 options highlight same menu
		case "daily":
		case "forperiod":
		case "AffiliateReport":
		case "ProgramReport":
		case "LinkReport":
        case "transaction_merchant":
        case "revenues":
        case "ProductReport":
			$header_bg6 = "header_bg_blue";
			$header_bg61 = "headeractive";
			break;

		case "group":
        case "add_group":
			$header_bg7 = "header_bg_blue";
			$header_bg71 = "headeractive";
			break;

		case "merchants":
			$header_bg8 = "header_bg_blue";
			$header_bg81 = "headeractive";
			break;
			
        case "programs1":
			$header_bg9 = "header_bg_blue";
			$header_bg91 = "headeractive";
			break;

	}
$sql =	" SELECT *,date_format(transaction_dateoftransaction,'%d, %m %Y') AS DATE FROM partners_transaction AS t, partners_joinpgm AS j,partners_merchant as a where merchant_id='$merchentid'";
$sql .=	" AND  t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_merchantid=a.merchant_id ";
$sql.= " AND transaction_status = 'pending' AND transaction_type != 'click' ";
 $ret 	=	mysqli_query($con,$sql);
 $counttransaction = mysqli_num_rows($ret);
 
 $sqliu 	= "SELECT * from partners_program where program_merchantid='$MERCHANTID'";
  $results	= mysqli_query($con,$sqliu);
  $is = 0;
 while($rowd = mysqli_fetch_object($results)){
	 if($is == 0){
		 $program = $rowd->program_id;
	 }
	 $is++;
 }
?>
<li class="nav-item">
	<a class="nav-link" href="index.php?Act=home" >
		<i class="nc-icon nc-chart-pie-35"></i>
		<p><?=$lang_Dashboard?></p>
	</a>
</li>
<li class="nav-item">
	<a class="nav-link"  href="index.php?Act=GetCode">
		<i class="nc-icon nc-app"></i>
		<p>
			<?=$lang_Tracking?>
		</p>
	</a>
</li>
<li class="nav-item">
	<a class="nav-link"  href="index.php?Act=accounts">
		<i class="nc-icon nc-notes"></i>
		<p>
			<?=$lang_Profile?>
		</p>
	</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="index.php?Act=programs&programId=<?=$program?>">
		<i class="nc-icon nc-paper-2"></i>
		<p>
			<?=$lang_Programs?>
		</p>
	</a>
</li>
<li class="nav-item ">
	<a class="nav-link" href="index.php?Act=daily">
		<i class="nc-icon nc-chart-bar-32"></i>
		<p><?=$lang_Reports?></p>
	</a>
</li>
<li class="nav-item ">
	<a class="nav-link" href="index.php?Act=affiliates&amp;status=all">
		<i class="nc-icon nc-single-copy-04"></i>
		<p><?=$lang_Affiliates?></p>
	</a>
</li>
<li class="nav-item ">
	<a class="nav-link" href="index.php?Act=all_transaction">
		<i class="nc-icon nc-money-coins"></i>
		<p><?=$lang_Transaction?> (<?=$counttransaction?>)</p>
	</a>
</li>
<li class="nav-item ">
	<a class="nav-link" href="index.php?Act=coupons">
		<i class="nc-icon nc-tag-content"></i>
		<p><?=$lang_Coupon?></p>
	</a>
</li>
<!--<li class="nav-item">
	<a class="nav-link" href="index.php?Act=emails">
		<i class="nc-icon nc-email-85"></i>
		<p>
			<?=$lang_Emails?>
		</p>
	</a>
</li>-->
   