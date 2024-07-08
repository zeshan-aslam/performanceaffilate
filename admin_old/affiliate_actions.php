<?php	

  /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES (PROCESSING PAGE)
      VARIABLES          : page    		= page no
                           selaction 	= getting action SELECTED + affiliate id
                           to           = mail to address

  //*************************************************************************************************/
  
  include_once '../includes/db-connect.php';
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include "../mail.php";
  include_once '../includes/allstripslashes.php';  

  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);

  /****************getting variables***********/
  $page            =intval(trim($_GET['page']));       //getting page no
  $selaction       =trim($_POST['selaction']); //getting action + affiliate id
  $aff             =explode('~',$selaction);
  $sortby		   =$_GET['sortby'];


  /********************************************/

  /***************getting to mailid from login table*********************/
  $sql             ="select * from partners_login where login_id='$aff[0]' and login_flag='a'";
  $ret1            =mysqli_query($con,$sql);
  $row             =mysqli_fetch_object($ret1);
  $to              =$row->login_email;
  /*********************************************************************/


  /*******************checking selected actions****************************************/
  switch ($aff[1])
          {
            case  'ViewProfile':        //view affiliate profile
                  header("Location:index.php?Act=affiliates&mode=ViewProfile&affid=$aff[0]&page=$page&sortby=$sortby");
                  exit;
                  break;


            case  'ChangePassword':    //change affiliate password
                  header("Location:index.php?Act=affiliates&mode=ChangePassword&affid=$aff[0]&loginflag=a&page=$page&sortby=$sortby");
                  exit;
                  break;


            case 'Reject':            //reject affiliate
                  header("Location:index.php?Act=affiliates&mode=Reject&affid=$aff[0]&loginflag=a&page=$page&sortby=$sortby");
                  exit;
                  break;

                                       //approve affiliate
            case 'Approve':
				  header("Location:index.php?Act=affiliates&mode=Approve&affid=$aff[0]&loginflag=a&page=$page&sortby=$sortby");
				  exit;
                  /*$sql="update partners_affiliate set affiliate_status='approved' where affiliate_id=$aff[0]";
                  MailEvent("Approve Affiliate",0,0,$to,0 )  ;  //send mail (../mail.php)*/
                  break;


            case 'Remove':            //remove affiliate
                  header("Location:index.php?Act=affiliates&mode=Remove&affid=$aff[0]&loginflag=a&page=$page&sortby=$sortby");
                  exit;
                  break;


            case 'Suspend':           //suspend affiliate
                  $sql="update partners_affiliate set affiliate_status='suspend' where affiliate_id=$aff[0]";
                  MailEvent("Suspend Affiliate",0,0,$to,0 )  ; //send mail (../mail.php)
                  break;

            case 'adjust':           //suspend affiliate
                  header("Location:index.php?Act=adjust_affiliate&affid=$aff[0]");
                  exit;
                  break;

             case 'payment':           //suspend affiliate
                  header("Location:index.php?Act=payment_affiliate&affid=$aff[0]");
                  exit;
                  break;


             case 'transaction':           //suspend affiliate
                  header("Location:index.php?Act=transaction_affiliate&affid=$aff[0]");
                  exit;
                  break;
         
		                              
           # Set TierGroup for Affiliate
		    case 'TierGroup':
				  header("Location:index.php?Act=affiliates&mode=TierGroup&affid=$aff[0]&loginflag=a&page=$page&sortby=$sortby");
				  exit;
                  break;


          }

       /************************end selecet action**************************************/

          $ret=mysqli_query($con,$sql);

          echo mysqli_error($con);

          header("location:index.php?Act=affiliates&page=$page");
?>