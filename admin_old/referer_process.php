<?php    ob_start();
#-------------------------------------------------------------------------------
# Admin Panel Refrer Report
# Gets date range, merchnat id and corresponding programs

# Pgmmr        : RR
# Date Created :   28-10-2004
# Date Modfd   :   29-10-2004
#-------------------------------------------------------------------------------

# includes all header files
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once '../includes/allstripslashes.php';

# estalshing connection

   $partners = new partners;
   $partners->connection($host,$user,$pass,$db);


# getting all form variables
   $cfrom             = trim($_POST['txtfrom']);  //from date
   $cto               = trim($_POST['txtto']);    //to date
   $sub               = trim($_POST['sub']);      //submit button
   $programs          = intval(trim($_POST['programs'])); //program id
   $MERCHANTID        = intval($_POST['merchants']);      //merchantid


# setting default values for merchnatid
   if($MERCHANTID=='All')
          $MERCHANTID = "0";

# validating date firlds
# if incorrect format rediraects to main page
# with err msg
   if(!$partners->is_date($cfrom) || !$partners->is_date($cto)){
        $Err="Please Enter Vlaid Date" ;
        header("location:index.php?Act=referer_report&programs=$programs&merchants=$MERCHANTID&msg=$Err");
        exit;
   }


#change to sql formats
   $From      = $partners->date2mysql($cfrom);
   $To        = $partners->date2mysql($cto);

# getiing all programs
   switch($programs)
   {
      case 'AllPgms':
        $sql = "SELECT * from partners_program ";
        break;

     case 'All':
        $sql = "SELECT * from partners_program  where program_merchantid='$MERCHANTID' ";
        break;

     default:
        $sql = "SELECT * from partners_program where program_id='$programs' ";
        break;
   }

   $result    = mysql_query($sql);

   ?>