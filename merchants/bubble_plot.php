<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  bubble_plot.php                                */
/*     CREATED ON     :  06/JULY/2006                                    */

/*	File is used to create the bubble graph with the values obtained 	*/
/*  The graph will have affiliate number of rows						*/
/************************************************************************/

	// set the HTTP header type to PNG
	header("Content-type: image/png"); 

	//getting values
	$rows			= intval($_REQUEST['rows']);
	$maxComm		= intval($_REQUEST['maxComm']);
	$type			= $_REQUEST['type']; 

	$totalValue = ($maxComm > 0)?$maxComm : 20;
	$leftValue	= $totalValue / 2;
	// set the width and height of the new image in pixels
	$width 	= 500 + $totalValue;
	$height = 440;
	$start 	= $leftValue + 100;
	$end 	= 400 + $leftValue + 100;
	$top_start 	= 10;
	$top_end	= 410;
	$row_height		= (400) / $rows;

	// create a pointer to a new true colour image
	$im = imagecreatetruecolor($width, $height); 
	
	// switch on image antialising if it is available
	imageantialias($im, true);


	// define  colours
	$black = imagecolorallocate($im, 0, 0, 0);
	$blue = imagecolorallocate($im, 0, 0, 255);
	$gray	= imagecolorallocate($im,0xC0,0xC0,0xC0);  
	$aqua	= imagecolorallocate($im,0xEF,0xEF,0xFF);  
	$white = imagecolorallocate($im, 255, 255, 255); 

	// sets background to white
	imagefilltoborder($im, 0, 0, $blue, $aqua);

	//draw lines for the axis of the graph
	//Outer Box of the Axis
	imageline($im, $start, $top_start, $start, $top_end, $gray);
	imageline($im, $start, $top_end, $end, $top_end, $gray);
	imageline($im, $start, $top_start, $end, $top_start, $gray);
	imageline($im, $end, $top_start, $end, $top_end, $gray);

	//10 Vertical Grid lines
	for($i=$start+40; $i<$end; $i+=40)
	{
		imageline($im, $i, $top_start, $i, $top_end, $gray);
	}

	//Horizontal Grid Lines depemding on the number of Affiliates
	for($i=$top_start+$row_height; $i<$top_end; $i+=$row_height)
	{
		imageline($im, $start, $i, $end, $i, $gray);
	}
 
 	//gettings values for the graph to be plotted
		$affiliateClick = $_REQUEST['click'];
		$affiliateCompany	= $_REQUEST['name'];
		$affiliateComision	= $_REQUEST['comm'];

		$affiliateClick = explode(",",$affiliateClick);
		$affiliateCompany	= explode(",",$affiliateCompany);
		$affiliateComision	= explode(",",$affiliateComision);
		
		$center_y	= $row_height/2 + 10;
		
	//gets the font
	$font = '../fonts/nimbus_roman.pfb';
	
	//Drawing the bubbles		
	for($x=0; $x<count($affiliateClick); $x++)
	{
		$diameter	= ($row_height * $affiliateComision[$x]) / 100;
		$center_x	= ((($width-100) * $affiliateClick[$x]) / 100) - ($diameter/2) + 100;
		
		imageellipse($im, $center_x, $center_y, $diameter, $diameter, $black);
		//writes the Affiliate Company
		imagettftext($im, 10, 0, 0, $center_y, $grey, $font, $affiliateCompany[$x]);
		$center_y	= $center_y + $row_height;
	}
	
	//Writes the Legend for x-axis
	$xAxis	= $type;
	imagettftext($im, 10, 0, $start, 430, $grey, $font, $xAxis);
	imagettftext($im, 10, 0, 0, 10, $grey, $font, "Affiliates");
	
	// send the new PNG image to the browser
	imagepng($im); 
	
	// destroy the reference pointer to the image in memory to free up resources
	imagedestroy($im); 

?>