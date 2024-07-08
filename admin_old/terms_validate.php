<?php 	ob_start();  

  $type 					= trim($_GET['type']);
  if($type=="merchant"){
      $filename                 = "mer_terms.htm";
  }
  else{
      $filename                 = "terms.htm";
  }

	    $fp = fopen($filename,'w');
	    $content=stripslashes($_POST['error']);
	    fwrite($fp,$content);
	    fclose($fp);
	    $msg =urlencode("Terms & Conditions Changed");
	    header("Location:index.php?Act=terms&type=$type&msg=$msg");
	    exit;
 ?>