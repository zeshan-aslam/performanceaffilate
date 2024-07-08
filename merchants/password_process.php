<?php

    include_once 'includes/session.php';
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

    /**************************variables***************************************/
    $login		=trim($_POST['login']);       //login email id     
    $flag		=trim($_POST['flag']);         //differentiate merchant and affiliate
    /**************************************************************************/



    /***********************checking type of login*****************************/
    if  ($flag=='affiliate')
          $type='a';                          //affilaite login
    else
         $type='m';                           //merchant login
    /**************************************************************************/

     $sql        ="SELECT * FROM partners_login where login_email='$login'  and login_flag='$type'";
     $result     =mysqli_query($con,$sql);
     echo mysqli_error($con);

    if(mysqli_num_rows($result)>0)
            {
            $row    =mysqli_fetch_object($result);
            $Err="Your Password has been send to your Email Id!!!! ";
            }
    else
           {
            $Err="Invalid Id";
           }
       header("location:index2.php?Err=$Err$action=forgotpass");
?>

