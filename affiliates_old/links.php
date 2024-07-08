
<?php
$header_bg1 = $header_bg2 = $header_bg3 = $header_bg4 = $header_bg5 = $header_bg6 = $header_bg7 = $header_bg8 = "header_bg_white";
	switch($Act){
		case "Home":
			$header_bg1 = "header_bg_blue";
			$header_bg11 = "headeractive";
		break;
		
		case "Account":
			$header_bg2 = "header_bg_blue";
			$header_bg21 = "headeractive";
		break;
		
		case "Affiliates":
		case "cat":
		case "MyAffiliates":
			$header_bg3 = "header_bg_blue";
			$header_bg31 = "headeractive";
		break;
		
		case "rotator":
			$header_bg4 = "header_bg_blue";
			$header_bg41 = "headeractive";
		break;
		
		case "Getlinks":
		case "getpopup":
		case "gethtml":
		case "getflash":
		case "getbanner":
		case "gettext":
			$header_bg5 = "header_bg_blue";
			$header_bg51 = "headeractive";
		break;
		
		//for all these 5 options highlight same menu
		case "daily":
		case "forperiod":
		case "AffiliateReport":
		case "ProgramReport":
		case "LinkReport":
		case "TransReport":
			$header_bg6 = "header_bg_blue";
			$header_bg61 = "headeractive";
		break;
		
		case "merchants":
			$header_bg7 = "header_bg_blue";
			$header_bg71 = "headeractive";
		break;
		
		case "Programs":
		case "cat":
		case "MyAffiliates":
			$header_bg8 = "header_bg_blue";
			$header_bg81 = "headeractive";
		break;
		
	}
?>

	
		<table border="0" align="center" cellpadding="0" cellspacing="0" width="900" >
      <tr>
        <td height="25" colspan="3" >
			<div style="width:18px; float:right; position:relative;">&nbsp;</div>
			<div class="<?=$header_bg7?>" >
			<a href="../affiliate_quit.php" ><?=$menu_quit?></a></div>
			  
          	<div class="<?=$header_bg6?>">
		  	<a href="index.php?Act=daily" class="<?=$header_bg61?>"><?=$menu_reports?></a></div>
		  
          	<div class="<?=$header_bg5?>">
		   	<a href="index.php?Act=Getlinks" class="<?=$header_bg51?>"><?=$menu_getlinks?></a></div>
			
          	<div class="<?=$header_bg4?>">
		  	<a href="index.php?Act=rotator" class="<?=$header_bg41?>"><?=$menu_rotator?></a></div>
			
          <?php /*?>	<div class="<?=$header_bg8?>">
		  	<a href="index.php?Act=Programs&joinstatus=All" class="<?=$header_bg81?>">New<?=$menu_programs?></a></div><?php */?>
			
          	<div class="<?=$header_bg3?>">
		  	<a href="index.php?Act=Affiliates&joinstatus=All" class="<?=$header_bg31?>"><?=$menu_programs?></a></div>
			
          	<div class="<?=$header_bg2?>">
		  	<a href="index.php?Act=Account" class="<?=$header_bg21?>"><?=$menu_accounts?></a></div>
			
          	<div class="<?=$header_bg1?>">
			<a href="index.php?Act=Home" class="<?=$header_bg11?>"><?=$menu_home?></a></div></td>
      </tr>
	</table>	