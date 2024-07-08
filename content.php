	<?php
	switch ($Act){
		case 'Merchants' :
			include "section_merchantsignup.php";
		break;
		
		case 'Affiliates' :
			include "section_affiliatesignup.php";
		break;
			default :
			require_once("section_carousel.php"); 
			include "section_home.php";
		break;
	}
	?>
