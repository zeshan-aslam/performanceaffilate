<?php	

    include_once '../includes/db-connect.php';
    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
     include_once '../includes/allstripslashes.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);


    $mid=trim($_GET['mid']);
    $sql="select * from partners_merchant where merchant_id=$mid  ";
    $ret=mysqli_query($con,$sql);
    $row=mysqli_fetch_object($ret);
    $_SESSION['MERCHANTID']=$mid;
    $_SESSION['MERCHANTNAME'] =stripslashes($row->merchant_firstname)." ".stripslashes($row->merchant_lastname );

    $sql="select * from merchant_pay where pay_merchantid=$mid  ";
    $ret=mysqli_query($con,$sql);
    $row=mysqli_fetch_object($ret);
    $_SESSION['MERCHANTBALANCE']=$row->pay_amount;
   //  echo "$MERCHANTID";
    header("location:../merchants/index.php?Act=home");
    exit;
?>