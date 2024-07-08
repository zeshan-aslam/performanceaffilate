<?php

    include_once 'includes/session.php';
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

    $login			=trim($_POST['login']);
    $passwd			=trim($_POST['password']);


        $sql        ="SELECT * FROM partners_login where login_email='".addslashes($login)."' AND login_password='".addslashes($passwd)."'";
        $result        =mysql_query($sql);
        echo mysql_error();

        if(mysql_num_rows($result))
            {
            $row    =mysql_fetch_object($result);
            $MERCHANTID        =$row->login_id;
            header("Location:merchants/index.php");
            exit;
            }
        else
            {
            $Err = $regval_msg;
            header("Location:index.php?Act=merchant&Err=$Err");
            exit;
            }
?>