<?php

    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);
    $id	= $_GET['rowid'];

    $sql3 = "select * from partners_text where text_id='$id'";
    $res=mysqli_query($con,$sql3);
    echo mysqli_error($con);

   	while($row=mysqli_fetch_object($res))
	{
		echo stripslashes($row->text_description);
	}


?>