<?php	ob_start();


   /***************************************************************************************************
                    PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT EXISTING PROGRAMS(PROCESS)
                     VARIABLES          :  pgmstatus    =program status
                                           pgmid    =programid
     ************************************************************************************************/


   include "../merchants/transactions.php";
   include_once '../includes/constants.php';
   include_once '../includes/functions.php';
   include_once '../includes/session.php';
   include_once '../includes/allstripslashes.php';

  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);


  /***********variables********************************************************/
  $pgmstatus		=trim($_GET['pgmstatus']);   //program status
  $pgmid			=intval(trim($_GET['programs']));    //id
  /****************************************************************************/



  /***************perform selected action**************************************/
  switch ($pgmstatus)
  {
    case 'Approve':   //approve pgm
         $sql="update partners_program set program_status='active' where program_id='$pgmid'";
         break;

    case 'Reject':    //reject pgm
         $sql="update partners_program set program_status='inactive' where program_id='$pgmid'";
         break;

  }
   mysql_query($sql)or die($sql."<br/>".mysql_error());
 /*****************************************************************************/


 header("location:index.php?Act=programs&programs=$pgmid");
 exit;

?>