<?php

    include_once 'includes/db-connect.php';
	include_once 'includes/session.php';
    include 'lang/english.php';

        session_destroy();
        $Err        = $merchant_quit;
        header("Location:index.php");
    exit;
?>