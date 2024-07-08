<?php 	ob_start();

   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES DETAILS (processing )
      VARIABLES          :      $MERCHANTID       =merchantid
              					$page             =page no
                                $aff              =affilaite id+status
                                $pgmname          =program url
  //*************************************************************************************************/

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
   include_once '../includes/allstripslashes.php';

  include "../mail.php";

  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);

  /************************************variables********************************/
  $MERCHANTID   =$_SESSION['MERCHANTID'];       // merchantid
  $page         =trim($_GET['page']);           //page no
  $selaction    =trim($_POST['selaction']);     //getting action + join id
  $aff          =explode('~',$selaction);

  /****************************************************************************/


  /********************getting program name ***********************************/
  $sql          ="select * from partners_program,partners_joinpgm where joinpgm_id ='$aff[0]' and joinpgm_programid=program_id";
  $result       =mysqli_query($con,$sql);
  $row          =mysqli_fetch_object($result);
  $pgmname      =$row->program_url;
  $pgmname      =$pgmname."~".$aff[0];
  /*****************************************************************************/



  /****************************getting to email id*****************************/
  $sql="select * from partners_login,partners_joinpgm where joinpgm_id='$aff[0]' and login_flag='a' and joinpgm_affiliateid=login_id";
  $ret1=mysqli_query($con,$sql);
  $row=mysqli_fetch_object($ret1);
  $to=$row->login_email;
  /****************************************************************************/


  /******************  actions selected****************************************/
  switch ($aff[1]) // cahecking action
          {
            case  'ViewProfile':  //view profile of affilaite
                  header("Location:index.php?Act=affiliates&mode=ViewProfile&affid=$aff[2]&page=$page");
                  exit;
                  break;
            case 'Reject':        //reject affilaite (joinpgm)
                  header("Location:index.php?Act=affiliates&mode=Reject&affid=$aff[2]&loginflag=a&page=$page&pgmname=$pgmname");
                  exit;
                  break;
            case 'Approve':      //reject affilaite (joinpgm)
                  $sql="update partners_joinpgm set joinpgm_status='approved' where joinpgm_id='$aff[0]'";
                  MailEvent("Approve AffiliateProgram",$MERCHANTID,$aff[0],$to,0);
                  break;
            case 'Suspend':
                  $sql="update partners_joinpgm set joinpgm_status='suspend' where joinpgm_id='$aff[0]'";
                  MailEvent("Suspend AffiliateProgram",$MERCHANTID,$aff[0],$to,0);
                  break;
          }

   /***************************************************************************/
        $ret   =mysqli_query($con,$sql);
        header("location:index.php?Act=affiliates&page=$page&affiliate=$affiliatename");
?>