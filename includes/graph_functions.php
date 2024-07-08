<?php

class shapes
{
	/*----------------------------------------------------------------------------------
	Function to draw a line in the co-ordinates specified
	Created By	: SMA
	Created On	: 6-JULY-2006
	----------------------------------------------------------------------------------*/
	function drawLine($image, $x1, $x2, $y1, $y2, $color)
	{ 
		imageline($image, $x1, $x2, $y1, $y2,$color);
		return $image;
	}
	
	


	
}

?>