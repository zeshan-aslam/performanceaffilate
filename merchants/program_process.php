
<?php

   include "../merchants/transactions.php";
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
 include_once '../includes/session.php';




 // $msg=trim($_GET['msg']);
  $pgmstatus=trim($_GET['pgmstatus']);
  $programs=trim($_POST['programs']);

  switch ($pgmstatus)
  {
    case 'Approve':
         $sql="update partners_program set program_status='active' where program_id='$pgmid'";
         mysqli_query($con,$sql);
         break;
    case 'Reject':
         $sql="update partners_program set program_status='inactive' where program_id='$pgmid'";
         mysqli_query($con,$sql);
         break;

  }
  

?>
