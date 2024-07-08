<?php 	ob_start();

	include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
    include_once '../includes/function1.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);
    include_once 'language_include.php';

	$mid		= intval($_REQUEST['mid']);
	$header		= trim(stripslashes(htmlspecialchars($_REQUEST['txt_header'])));
	$footer		= trim(stripslashes(htmlspecialchars($_REQUEST['txt_footer'])));
/*	
	$header		= htmlspecialchars($header);
	$footer		= htmlspecialchars($footer);
*/	
	$linkobj	= new merchantLink();
	$result = $linkobj->UpdateLinks($mid,$header,$footer);

	if($result)
		$msg1 = $msg_link_updated;
	else
		$msg1 = $msg_link_failed;
		
	header("Location: index.php?Act=accounts&msg1=$msg1");
	exit;
?>