<?php	
   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE MERCAHNTS
      VARIABLES          :     merchant         =merchantid
	                           statUS			=searchstatus
	                           page             =page no
	                           selaction        =getting action + merchantid
                               to				=TO email;
  //*************************************************************************************************/
                               
  include_once '../includes/db-connect.php';
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/allstripslashes.php';

  include '../mail.php';

  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);

  /**************************************************************************/
  $merchant			= intval(trim($_GET['merchant']));         //merchantid
  $id				= intval(trim($_GET['id']));
  $status			= trim($_GET['status']);             //searchstatus
  $page				= intval(trim($_GET['page']));                 //page no
  $selaction		= trim($_POST['selaction']);      //getting action + merchantid
  $mer				= explode('~',$selaction);
  $sortby		    = trim($_GET['sortby']);  
  $today            = date("Y-m-d");
  /****************************************************************************/


  /******************getting to email id**************************************/
  $sql	="select * from partners_login where login_id='$mer[0]' and login_flag='m'";
  $ret1	=mysqli_query($con,$sql);
  $row	=mysqli_fetch_object($ret1);
  $to	=$row->login_email;
  /****************************************************************************/


  /***************actions depending on action value****************************/

  switch ($mer[1])  //checking action
          {
            case  'ViewProfile':   //view profile of merchant
                  header("Location:index.php?Act=merchants&mode=ViewProfile&merid=$mer[0]&status=$status&page=$page&sortby=$sortby");
                  exit;
                  break;

            case  'ChangePassword':  //cahnge passwd of merchant
                  header("Location:index.php?Act=merchants&mode=ChangePassword&merid=$mer[0]&loginflag=m&page=$page&sortby=$sortby");
                  exit;
                  break;

           case  'invoiceActivate':
					//Modified By DPT on may/21 to set status as 'active'
                   $invoiceSql = "INSERT INTO partners_invoiceStat (invoice_merchantid,invoice_date,invoice_status) VALUES ('$mer[0]','$today','active')";
                   mysqli_query($con,$invoiceSql);
                   $sql=("update partners_merchant set merchant_isInvoice='Yes',merchant_invoiceStatus='active' where merchant_id='$mer[0]'");

                  break;

            case  'invoiceInactivate' :
					//Modified By DPT on may/21 to set status as 'inactive'
                  $invoiceSql = "INSERT INTO partners_invoiceStat (invoice_merchantid,invoice_date,invoice_status) VALUES ($mer[0],'$today','inactive')";
                   mysqli_query($con,$invoiceSql);

                   $sql=("update partners_merchant set merchant_isInvoice='Yes',merchant_invoiceStatus='inactive' where merchant_id='$mer[0]'");
                   break;

            case 'Suspend':         //suspend merchant
                  $sql=("update partners_merchant set merchant_status='suspend' where merchant_id='$mer[0]'");
                  MailEvent("Suspend Merchant",0,0,$to,0 )  ; //mail(mail.php)
                  break;

            case 'Approve':       //approve merchant
                  $sql="update partners_merchant set merchant_status='approved' where merchant_id='$mer[0]'";
                  MailEvent("Approve Merchant",0,0,$to,0 )  ; //mail(mail.php)
                  break;

            case 'Reject':        //reject merchant
                  header("Location:index.php?Act=merchants&mode=Reject&merid=$mer[0]&loginflag=m&page=$page");
                  exit;
                  break;

            case 'pgmapproval':
                  if ($mer[2]=='manual') $stat = "automatic";
                  else $stat = "manual";
                  $sql="update partners_merchant set merchant_pgmapproval='$stat' where merchant_id='$mer[0]'";
                  MailEvent("Approve Merchant",0,0,$to,0 )  ;
                  break;

            case 'Remove':        //remove merchant
                  header("Location:index.php?Act=merchants&mode=Remove&merid=$mer[0]&loginflag=m&page=$page");
                  exit;
                  break;

             case 'adjust':           //suspend affiliate
                  header("Location:index.php?Act=adjust_merchant&merid=$mer[0]");
                  exit;
                  break;

             case 'payment':           //suspend affiliate
                  header("Location:index.php?Act=payment_merchant&merid=$mer[0]");
                  exit;
                  break;

            case 'transaction':           //suspend affiliate
            	  $_SESSION['TRANS_MERCHANTID'] = $mer[0];
                  header("Location:index.php?Act=transaction_merchant&merid=$mer[0]");
                  exit;
                  break;

          }
      /************************************************************************/
          $ret=mysqli_query($con,$sql);
          header("location:index.php?Act=merchants&status=$status&page=$page");
?>