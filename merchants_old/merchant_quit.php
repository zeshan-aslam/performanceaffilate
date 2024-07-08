<?php

    include '../includes/session.php';
        session_destroy();
    //$Err        ="Merchant Session closed!";
        header("Location:index.php?Err=$Err");
    exit;
?>