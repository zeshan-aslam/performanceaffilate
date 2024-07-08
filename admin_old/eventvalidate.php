<?php	ob_start();
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/allstripslashes.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$name=trim($nametxt);
	$$status=trim($status);
	# remove an evemt

	  if(empty($name))
	  {
			 $msg = "Please Enter a Valid Event !!";
			 header("Location:index.php?Act=event&name=$name&amp;status=$status&msg=$msg");
			 exit;
	  }

	 // for checking unique event

	 $sql ="SELECT event_name FROM partners_event WHERE event_name = '$name'";
	 $res=mysql_query($sql)or die("cant exe on first");

	 $row=mysql_num_rows($res);

	 if ($row>0)

	 {

	 $msg="Event alredy Exist";
	 header("Location:index.php?Act=event&name=$name&amp;status=$status&msg=$msg");
			 exit;
	 }
	 else {

	 if ($status=="active") {

			 $st="yes";
	 }else {
			  $st="no";
			 }


	  $sql1="insert into partners_event values('$name','$st',0)";
	  $res1=mysql_query($sql1) or die ("cant insert this event");

	  $sql2="INSERT INTO partners_adminmail(adminmail_eventname) VALUES ('$name')";
	  $res2=mysql_query($sql2) or die ("cant insert this event 2");

	  $msg="Event Entered successfully !!";
	 header("Location:index.php?Act=event&name=$name&amp;status=$status&msg=$msg");

	 }

?>