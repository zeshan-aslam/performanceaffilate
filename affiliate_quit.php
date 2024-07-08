<?php

    include_once 'includes/db-connect.php';
	include_once 'includes/session.php';
        
       $PoweredUrl = $_SESSION['url'] ;
        session_destroy();
        $Err        = $aff_quit;
        if($PoweredUrl)
            {
                header("Location:https://poweredwords.com/login.php");
            }
            else{
                header("Location:index.php?Act=Affiliates&Err=$Err");
            }
       
       

    exit;
?>