<?php	
  /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO CAHNGE AND VALIDATE THE EXISTING MAIL SETTINGS
      VARIABLES          : footertxt       = COMMON MAIL FOOTER
                           headertxt       = COMMON MAIL HEADER
                           mailamnt        = COST PER PAID MAIL
                           action		   = SELECTED ACTION(CHANGE COST PER MAIL,HERADER OR F0OTTER
  //*************************************************************************************************/

  include_once '../includes/db-connect.php';
  include '../includes/session.php';
  include '../includes/constants.php';
  include '../includes/functions.php';
  include_once '../includes/allstripslashes.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);

 /*****************************************************************************/
  $footertxt  =$_POST['footertxt'];                    //COMMON MAIL FOOTER
  $headertxt  =$_POST['headertxt'];                    //COMMON MAIL HEADER
  $mailamnt   =$_POST['mailamnt'];                     // COST PER PAID MAIL
  $action     =$_POST['action'];                       //SELECTED ACTION
  /****************************************************************************/


/************************PROCESS ACTIONS***************************************/
	switch($action){
		case 'Modify Amount':    //CHANGE COST PER MAIL
		
			if(!is_numeric($mailamnt) or empty($mailamnt))  //CHEKING FOR NUMERIC
			{
				$msg    ="Error In Data : Invalid Amount Entry";
			}
			else //CAHNGE
			{
				$sql    ="UPDATE partners_admin SET admin_mailamnt='$mailamnt'";
				$ret    =mysqli_query($con,$sql);
			if($ret){
				$msg       ="Amount Per Mail changed";
				$MAILAMNT  =$mailamnt;
			}
			else  
				$msg           ="Unknown Error! Please Try Again";
			}
		break;
	
	
	
	case 'Modify  Options':       //MODIFY HEADER AND FOOTER
	
	//CHANGE
	{
	$headertxt1=addslashes($headertxt);
	$footertxt1=addslashes($footertxt);
	$sql    ="UPDATE partners_admin SET admin_mailheader='$headertxt1',admin_mailfooter='$footertxt1' ";
	$ret    =mysqli_query($con,$sql);
	if($ret){
	$msg             ="Header and Footer changed";
	$MAILHEADER      =stripslashes($headertxt);
	$_SESSION['MAILHEADER']=stripslashes($headertxt);
	$MAILFOOTER      =stripslashes($footertxt);
	$_SESSION['MAILFOOTER']=stripslashes($footertxt);
	}
	else  $msg           ="Unknown Error! Please Try Again";
	}
	break;
	}
   /***************************************************************************/
   header("location:index.php?Act=mailsettings&msg=$msg");
?>