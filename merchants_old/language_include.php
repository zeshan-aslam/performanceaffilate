<?php



    $language=$_SESSION['LANGUAGE'];
    if (empty($language)) $lang = "english";
	else
	{
        //get langauge
		$sqllang = "select * from partners_languages where languages_id = '$language'"; 
		$reslang = mysqli_query($con,$sqllang);
		if($rowlang = mysqli_fetch_object($reslang))
        	$lang = strtolower(trim(stripslashes($rowlang->languages_name)));

		//langauge file name
	   	$filename = "lang/".$lang.".php";

		//check whether file exists
		if(!file_exists($filename))
		{
			$lang = "english";
			$language = "";
		}
	}
	require ("lang/".$lang.".php");
?>