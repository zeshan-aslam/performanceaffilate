<?php
$height = (isset($_GET['height'])) ? $_GET['height'] : 300;
$alt = (isset($_GET['alt'])) ? $_GET['alt'] : 0;

$day1	= (isset($_REQUEST['day1'])) ? $_REQUEST['day1'] : 30;
$day15	= (isset($_REQUEST['day15'])) ? $_REQUEST['day15'] : 60;
$month1	= (isset($_REQUEST['month1'])) ? $_REQUEST['month1'] : 90;
$month2	= (isset($_REQUEST['month2'])) ? $_REQUEST['month2'] : 120;
$total	= $_REQUEST['total'];

$center = intval ($height/2);
$radius = $center -1 ;
$image 	= imagecreate ($height, $height);


$angle_day1		= intval ($day1/100 * 360 );
$angle_day15	= intval ($day15/100 * 360 );
$angle_month1	= intval ($month1/100 * 360 );
$angle_month2	= intval ($month2/100 * 360 );

imagealphablending ($image, true);
imageantialias($image,true);

//if ($alt==0) $background = imagecolorallocate ($image, 247,247,222);
if ($alt==0) $background = imagecolorallocate ($image, 255,255,255);
else $background = imagecolorallocate ($image, 247,247,222);

$color_day1		= imagecolorallocate($image,0xCC,0x00,0x33); 
$color_day15	= imagecolorallocate($image,0xFF,0xCC,0x00); 
$color_month1	= imagecolorallocate($image,0x33, 0x00, 0xFF); 
$color_month2	= imagecolorallocate($image,0x00, 0x99, 0x00);  
$color_after	= imagecolorallocate($image,0x00,0xCC,0xFF);  

//Colors for Shades
$shade_day1		= imagecolorallocate($image,0x99,0x00,0x00);
$shade_day15	= imagecolorallocate($image,0xFF,0xAA,0x00);
$shade_month1	= imagecolorallocate($image,0x33,0x00,0xCC); 
$shade_month2	= imagecolorallocate($image,0x33,0x66,0x33);
$shade_after	= imagecolorallocate($image,0x00,0x99,0xFF);

if($total==0)
{
	$color_after	= imagecolorallocate($image,0xC0,0xC0,0xC0);  
	$shade_after	= imagecolorallocate($image,0x90,0x90,0x90);
}

$newcenter = $center - 15;
$radius_new = $radius-25;
for($i=$center; $i>$newcenter; $i--)
{
	imagefilledarc ($image, $center, $i, $radius, $radius_new, 0, $day1, $shade_day1, IMG_ARC_PIE );
	imagefilledarc ($image, $center, $i, $radius, $radius_new, $day1, $day15, $shade_day15, IMG_ARC_PIE );
	imagefilledarc ($image, $center, $i, $radius, $radius_new, $day15, $month1, $shade_month1, IMG_ARC_PIE );
	imagefilledarc ($image, $center, $i, $radius, $radius_new, $month1, $month2, $shade_month2, IMG_ARC_PIE );
	imagefilledarc ($image, $center, $i, $radius, $radius_new, $month2, 360, $shade_after, IMG_ARC_PIE );
}
imagefilledarc ($image, $center, $newcenter, $radius, $radius_new, 0, $day1, $color_day1, IMG_ARC_PIE );
imagefilledarc ($image, $center, $newcenter, $radius, $radius_new, $day1, $day15, $color_day15, IMG_ARC_PIE );
imagefilledarc ($image, $center, $newcenter, $radius, $radius_new, $day15, $month1, $color_month1, IMG_ARC_PIE );
imagefilledarc ($image, $center, $newcenter, $radius, $radius_new, $month1, $month2, $color_month2, IMG_ARC_PIE );
imagefilledarc ($image, $center, $newcenter, $radius, $radius_new, $month2, 360, $color_after, IMG_ARC_PIE );


header("Content-type: image/png");
imagepng($image);
imagedestroy($image);

?>