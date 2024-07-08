<?php		ob_start();

    /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO delete merchant gorups
      VARIABLES          :    $count1		=no of groups selected
       						 $programs		=programid
        					 $temp			=counter
  //*************************************************************************************************/

    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
     include_once '../includes/allstripslashes.php';


    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

        /**********************variables*************************************/
        $elements	= $_POST['elements'];
        $count1		= count($elements);                         //no of groups selected
        $programs	= intval(trim($_GET['programs']));                //programid
        $temp=0;                                //counter
        /*******************************************************************/

       /******************deleteing*******************************************/
        while ($temp<$count1)
            {
                $query=("DELETE  FROM partners_group WHERE group_id ='$elements[$temp]'");
                mysqli_query($con,$query); //deleting

                $query=("update   partners_joinpgm set joinpgm_group ='0' WHERE joinpgm_group='".addslashes($elements[$temp])."'");
                mysqli_query($con,$query); //updating joined pgms
                $temp++;

            }
        mysqli_error($con);
        /********************************************************************/

        header("location:index.php?Act=add_group&programs=$programs"); //redirection



?>