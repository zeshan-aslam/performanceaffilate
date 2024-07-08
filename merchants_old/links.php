<?php
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

?>

    <table border="0" align="center" cellpadding="0" cellspacing="0" width="900" >
      <tr>
        <td height="25" colspan="3" >
			<div style="width:18px; float:right; position:relative;">&nbsp;</div>
			<div class="<?=$header_bg8?>" >
			<a href="../merchant_quit.php" class="<?=$header_bg81?>"><?=$lang_Quit?></a></div>
			  
          	<div class="<?=$header_bg7?>">
		  	<a href="index.php?Act=group" class="<?=$header_bg71?>"><?=$lang_Groups?></a></div>
		  
          	<div class="<?=$header_bg6?>">
		  	<a href="index.php?Act=daily" class="<?=$header_bg61?>"><?=$lang_Reports?></a></div>
		  
          	<div class="<?=$header_bg5?>">
		   	<a href="index.php?Act=emails" class="<?=$header_bg51?>"><?=$lang_Emails?></a></div>
			
          	<div class="<?=$header_bg4?>">
		  	<a href="index.php?Act=affiliates&amp;status=all" class="<?=$header_bg41?>"><?=$lang_Affiliates?></a></div>
			
          	<?php /*?><div class="<?=$header_bg9?>">
		  	<a href="index.php?Act=programs1" class="<?=$header_bg91?>">New<?=$lang_Programs?></a></div><?php */?>
			
          	<div class="<?=$header_bg3?>">
		  	<a href="index.php?Act=programs" class="<?=$header_bg31?>"><?=$lang_Programs?></a></div>
			
          	<div class="<?=$header_bg2?>">
		  	<a href="index.php?Act=accounts" class="<?=$header_bg21?>"><?=$lang_Accounts?></a></div>
			
          	<div class="<?=$header_bg1?>">
			<a href="index.php?Act=home" class="<?=$header_bg11?>"><?=$lang_Home?></a></div></td>
      </tr>
	</table>	