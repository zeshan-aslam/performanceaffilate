<?php

/***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES (PROCESSING PAGE)
      VARIABLES          :  	page          =page no
   							 	action        = elements selected
  							  	joinstatus    =join pgm status
    							count1        =elements selected
    							today         =tdaydate("Y-m-d");
    							temp          =counter;
   								cmd           =action selected

  //*************************************************************************************************/

include_once '../includes/db-connect.php';

include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';
include_once '../includes/allstripslashes.php';


$partners = new partners;
$partners->connection($host, $user, $pass, $db);



//$elements      =trim($_POST['elements[]']);
/*******************************variables**********************************/
$page          = intval(trim($_GET['page']));                  //page no
$action        = trim($_GET['id']);                    // elements selected
$action        = explode("~", $action);
$joinstatus    = trim($_GET['joinstatus']);            //join pgm status
$count1        = count($_POST['elements']);                     //elements selected
$today         = date("Y-m-d");
$temp          = 0;
$cmd           = trim($_POST['sub']);                  //action selected
if (empty($cmd))
  $cmd      = trim($_GET['sub']);

//Added by DPT on Aug/09/05
//get action selected from the hidden variable
$cmd      = $_POST['hidden_choice'];
$choice      = $_GET['choice'];
$pgmid      = intval($_GET['pgmid']);
$status    = trim($_GET['status']);

if ($status == "sus") {
  //update new status
  $sql  =  "update partners_joinpgm set joinpgm_status='suspend' where joinpgm_programid='$pgmid' and joinpgm_affiliateid='" . $_SESSION['AFFILIATEID'] . "' ";
  mysqli_query($con, $sql);

  //redirect back
  header("location:index.php?Act=Affiliates&page=$page&joinstatus=$joinstatus");

  exit;
}
//Rejoin after blocking programs
if ($choice == "rejoin") {
  //-----------getting affiliate approval type---------
  # GEts the affiliate approval type for Programs
  $sql_pgm = "SELECT * FROM partners_program WHERE program_id = '$pgmid' ";
  $res_pgm = @mysqli_query($con, $sql_pgm);
  if (@mysqli_num_rows($res_pgm) > 0) {
    $row_pgm   = mysqli_fetch_object($res_pgm);
    $approval   = $row_pgm->program_affiliateapproval;
  }

  if ($approval == "automatic")
    $approvalstatus  =  "approved";          // automatic approval
  else
    $approvalstatus  =  "waiting";          //manuall approval

  //update new status
  $sql  =  "update partners_joinpgm set joinpgm_status='$approvalstatus' where joinpgm_programid='$pgmid' and joinpgm_affiliateid='" . $_SESSION['AFFILIATEID'] . "' ";
  mysqli_query($con, $sql);

  //redirect back
  header("location:index.php?Act=Affiliates&page=$page&joinstatus=$joinstatus");
  exit;
}
//Added by DPT on Aug/09/05

/***************************************************************************/



/****************************actions***************************************/

switch ($cmd) {
  case 'Join Selected':     //join pgm(through check all)

    while ($temp < $count1) //all selected pgms
    {

      $id = explode("~", $_POST['elements'][$temp]);     //joinid+pgmid+status



      /********getting affilaite approval type*************/
      $sql_pgm = "SELECT * FROM partners_program WHERE program_id = '$id[2]' ";
      $res_pgm = @mysqli_query($con, $sql_pgm);
      if (@mysqli_num_rows($res_pgm) > 0) {
        $row_pgm   = mysqli_fetch_object($res_pgm);
        $approval   = $row_pgm->program_affiliateapproval;
      }

      if ($approval == "automatic")
        $approvalstatus = "approved";          // automatic approval
      else
        $approvalstatus = "waiting";          //manuall approval
      /****************************************************/



      /*******checking for not joined pgms*****************/
      if ($id[1] == 'notjoined') {
        $sql = "insert into  partners_joinpgm(joinpgm_programid,joinpgm_merchantid,joinpgm_affiliateid,joinpgm_status,joinpgm_date) values ('$id[2]','$id[3]','$AFFILIATEID','$approvalstatus','$today')  ";
        mysqli_query($con, $sql);
      }
      /******************************************************/


      $temp++;   //next element
    }

    break;

  case 'Suspend Selected':                  //suspend(check all)
    while ($temp < $count1)               //all elements
    {
      $id = explode("~", $_POST['elements'][$temp]); //joinid+pgmid+status

      /**********checking for approval*********************/
      if ($id[1] == 'approved') {
        $sql = "update partners_joinpgm set joinpgm_status='suspend' where joinpgm_programid='$id[2]' and joinpgm_affiliateid='$AFFILIATEID' ";
        #echo $sql;
        mysqli_query($con, $sql);
      }
      /****************************************************/


      $temp++;         //next element
    }
    break;

  default:    //join selected pgm

    /********checking for not joined pgm********************/
    if ($action[1] == 'notjoined') {

      /************getting approval type********************/
      $sql_pgm = "SELECT * FROM partners_program WHERE program_id = '$action[2]' ";
      $res_pgm = @mysqli_query($con, $sql_pgm);
      if (@mysqli_num_rows($res_pgm) > 0) {
        $row_pgm   = mysqli_fetch_object($res_pgm);
        $approval   = $row_pgm->program_affiliateapproval;
      }

      if ($approval == "automatic")
        $approvalstatus = "approved";         //automatic approval
      else
        $approvalstatus = "waiting";         //manual approval
      /*****************************************************/


      $sql = "insert into  partners_joinpgm(joinpgm_programid,joinpgm_merchantid,joinpgm_affiliateid,joinpgm_status,joinpgm_date) values ('$action[2]','$action[3]','$AFFILIATEID','$approvalstatus','$today')  ";
      mysqli_query($con, $sql);
    }
    /********close checking for not joined pgm************/


    break;
}
/*********************************************************************/

header("location:index.php?Act=Affiliates&page=$page&joinstatus=$joinstatus");  //redirecting
