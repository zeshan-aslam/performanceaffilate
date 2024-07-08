<?php	ob_start();

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/allstripslashes.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    $name=trim($nametxt);
    $$status=trim($status);
    ///////////// remove an evemt

	$eventcompo=trim($eventcompo);
	
	if ($eventcompo=="ChooseEvent")
	{
		$msg = "Please select an event to Delete !!";
		header("Location:index.php?Act=event&msg=$msg");
	}
	else {
		$sql1="Delete from partners_event where event_name='$eventcompo'";
		$res1=mysql_query($sql1) or die ("cant delete this event");
		
		$sql2="Delete from partners_adminmail where adminmail_eventname='$eventcompo'";
		$res2=mysql_query($sql2) or die ("cant delete this event");
		
		$msg =  "Event ".$eventcompo." Deleted !!";
		header("Location:index.php?Act=event&msg=$msg");
		
		exit;
	}

?>