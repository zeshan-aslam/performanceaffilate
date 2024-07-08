<?php	ob_start();

	extract($_POST);
	$zipname = $_GET['fl'];
	function compress($zip) {
	// compress a file without using shell
	$zip=rtrim($zip);
	$fp = @fopen("dump/$zip","rb");
	if (file_exists("dump/zip/".$zip.".gz")) unlink("dump/zip/".$zip.".gz");
	$zp = @gzopen("dump/zip/".$zip.".gz", "wb9");
	if (!$fp) {
	   die("No sql file found");
	}
	if(!$zp) {
	   die("Cannot create zip file");
	}

	while(!feof($fp)){
	    $data=fgets($fp, 8192); // buffer php
	    gzwrite($zp,$data);
	}
	fclose($fp);
	gzclose($zp);
	return true;
	}
	//  if (compress($zipname)==true) header("location: dump/zip/".$zipname.".gz");
	//  compress($zipname);
	    //$filname = "$zipname.gz";
	    header('Content-Type: application/download; filename="'.$zipname.'"');
	    header('Content-Disposition: attachment; filename="'.$zipname.'"');
	    readfile("./dump/$zipname");
	    exit;
	?>



