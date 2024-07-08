<?php	ob_start();

  /***************************************************************************************************
                    PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT EXISTING PROGRAMS SECOND TIRE RATE
                     VARIABLES          :  programs		=programid
 										   mode    		=action selected
  										   msg     		=err msg
                                           pGmid        =programid
                                           saletype		=subsale rate
 										   sale			=subsale type($,%)
     ************************************************************************************************/

   include_once '../includes/constants.php';
   include_once '../includes/functions.php';
   include_once '../includes/session.php';
    include_once '../includes/allstripslashes.php';



  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);

  /********************variables***********************************************/
  $mode			=trim($_POST['mode']);          //action selected
  $pgmid		=trim($_GET['programs']);       //programid
  $saletype		=trim($_POST['txtsaletype']);   //subsale rate
  $sale			=trim($_POST['txtsale']);       //subsale type($,%)
  /****************************************************************************/




  /********************validate secondtire sales*******************************/
  if(!is_numeric($sale))
  {
   $msg="Enter Valid Amount!!!";
   header("location:index.php?Act=programs&programs=$pgmid&msg=$msg");
   exit();

  }/***************************************************************************/




  /**********************************actions*********************************/

  switch ($mode)
  {
    case 'Edit':     //edit second tire
          $sql="UPDATE  `partners_secondlevel` SET  `secondlevel_salerate`='$sale', `secondlevel_saletype`='$saletype' where secondlevel_programid='$pgmid' ";
         break;

    case 'Delete':  //delecte second tire
          $sql="DELETE  FROM   `partners_secondlevel` where secondlevel_programid='$pgmid' ";
         break;

    case 'Addnew':  //add second tire
         $sql="INSERT INTO `partners_secondlevel` (  `secondlevel_programid` , `secondlevel_clickrate` , `secondlevel_leadrate` , `secondlevel_salerate` , `secondlevel_saletype` )
                        VALUES ( '$pgmid', '0', '0', '$sale', '$saletype')";
         break;

  }
 /*****************************************************************************/



 mysql_query($sql)or die($sql."<br/>".mysql_error());
 $msg="";
 header("location:index.php?Act=programs&programs=$pgmid&msg=$msg");
 exit;

?>