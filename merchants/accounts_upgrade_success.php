<?php

include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';
 include_once '../includes/allstripslashes.php';


  $partners = new partners;
  $partners->connection($host,$user,$pass,$db);
  $id		= intval($_GET['id']);
  
              $sql1="UPDATE  partners_merchant  SET  merchant_type = 'advance' WHERE `merchant_id` = '$id'";

                $result = mysqli_query($con,$sql1);
        	    echo mysqli_error($con);
				$msg1	="UpGraded Successfully";

                header("Location:index.php?Act=accounts&msg1=$msg1");

                exit;

?>