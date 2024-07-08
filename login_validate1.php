<?php		ob_start();

    include_once 'includes//session.php';
    include_once 'includes//constants.php';
    include_once 'includes//functions.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

    include_once 'language_include.php'; 

    //==========================variables=======================================//
        $login                =trim($_POST['login']);       ////login email id
        $passwd               =trim($_POST['password']);    ////password
        $flag                 =trim($_POST['flag']);         ////differentiate merchant and affiliate
    //==========================================================================//



    //=======================checking type of login=============================//
         if  ($flag=='affiliate')  $type='a';        ////affilaite login
         else   $type='m';                           ////merchant login
    //==========================================================================//


     //======================login checking===================================//
        $sql        ="SELECT * FROM partners_login where login_email='".addslashes($login)."' AND login_password='".addslashes($passwd."' and login_flag='$type'";
        $result     =mysql_query($sql);
        echo mysql_error();

        if(mysql_num_rows($result))
            {
             $row    =mysql_fetch_object($result);

            //==========affiliate login=========================================//
            if($flag=='affiliate')
            {
               $_SESSION['AFFILIATEID'] =  $AFFILIATEID       =$row->login_id;

               $sql     ="select * from partners_affiliate where affiliate_id='$AFFILIATEID' ";
               $ret     =mysql_query($sql);
               $row     =mysql_fetch_object($ret);
               $_SESSION['AFFILIATENAME'] =stripslashes($row->affiliate_firstname)." ".stripslashes($row->affiliate_lastname);
               if($row->affiliate_status<>'approved')                           ////not approved
                    {
                        $Err =$lang_notauth;
                        header("Location:index.php?Act=Affiliates&Err=$Err");
                        exit;
                    }
               else
                   {
                         header("Location:affiliates//index.php?Act=Home");            ////approved suceessful login
                         exit;
                   }

             }//=========================close afffiliate login=================//

             //========== merchant login========================================//
             else
             {
                    $_SESSION['MERCHANTID']= $MERCHANTID       =$row->login_id;

                    $sql="select * from partners_merchant where merchant_id='$MERCHANTID'  ";
                    $ret=mysql_query($sql);
                    $row=mysql_fetch_object($ret);

                    $_SESSION['MERCHANTNAME'] =stripslashes($row->merchant_firstname)." ".stripslashes($row->merchant_lastname );
                    if($row->merchant_status<>'approved')                            ////not approved
                    {
                        $Err =$lang_notauth;;
                        header("Location:index.php?Act=Merchants&Err=$Err");
                        exit;
                    }
                   else
                    {
                         header("Location:merchants/index.php?Act=home");           ////approved suceessful login
                         exit;
                   }

             }
            }//==============close merchant login==============================//

         //============invalid login===========================================//
        else

        {
        if($flag=='affiliate')                                                  ////invalid login
            {
                    $Err =$lang_notauth;;
                    header("Location:index.php?Act=Affiliates&Err=$Err");
                           exit;
            }
           else
           {
                    $Err =$lang_notauth;;
                    header("Location:index.php?Act=Merchants&Err=$Err");
                    exit;
           }
       }
       //=============================invalid login close=======================//

       //======================end checking======================================//
?>
