<?php	ob_start();

//############################################################################//
/*  Last Modfd          : 23/Oct/2004                                         */
/*  Script Name         : crm_validate.php                                    */
//============================================================================//

//============================================================================//
// Add customer relationship module between merchant and affiliates           //
// List customer relationship module between merchant and affiliates          //
//============================================================================//
//############################################################################//


//including all files
    include '../includes/session.php';
    include '../includes/constants.php';
    include '../includes/functions.php';
    include '../includes/allstripslashes.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

//getting back form variables
    $crm_affiliate_id  = intval(trim(stripslashes($_POST['crm_affiliate_list'])));
    $crm_cat_id        = trim(stripslashes($_POST['crm_cat_id']));
    $crm_date          = trim(stripslashes($_POST['crm_date']));
    $crm_crdate        = trim(stripslashes($_POST['crm_crdate']));
    $crm_type          = trim(stripslashes($_POST['crm_type']));
    $crm_subject       = trim(stripslashes($_POST['crm_subject']));
    $crm_note          = trim(stripslashes($_POST['crm_note']));
    $crm_flag          = trim(stripslashes($_POST['crm_flag']));
    $crm_action        = trim(stripslashes($_POST['crm_action']));
    $crm_merchant_id   = intval(trim(stripslashes($_POST['crm_merchant_id'])));
    $crm_id            = trim($_POST['crm_id']);


//return url
    $url = "index.php?Act=list_crm&mode=$crm_action&crm_merchant_id=$crm_merchant_id&id=$crm_id&crm_affiliate_id=$crm_affiliate_id&crm_cat_id=$crm_cat_id&crm_date=$crm_date&crm_subject=$crm_subject&crm_note=$crm_note&crm_flag=$crm_flag";


#-------------------------------------------------------------------------------
# Checking whether any required field is empty
# if any filed is found emty redirecting to the main page
# with err message

#checking is the field is empty

   if(empty($crm_affiliate_id)) $err = "1";
   else                         $err = "0";

   if(empty($crm_cat_id))       $err .= ".1";
   else                         $err .= ".0";

   if(empty($crm_date))         $err .= ".1";
   else                         $err .= ".0";

   if(empty($crm_subject))      $err .= ".1";
   else                         $err .= ".0";

   if(empty($crm_crdate))       $err .= ".1";
   else                         $err .= ".0";

   if(empty($crm_type))      	$err .= ".1";
   else                         $err .= ".0";

   if(empty($crm_note))         $err .= ".1";
   else                         $err .= ".0";

   if(empty($crm_flag))         $err .= ".1";
   else                         $err .= ".0";


#if empty dredirecting
   if($err != "0.0.0.0.0.0.0.0") {
        $errMsg =1;
        header("Location:$url&errMsg=$errMsg");
        exit;
   }

# emty chcking ends herre
#-------------------------------------------------------------------------------


#-------------------------------------------------------------------------------
# Checking whether the date format is correct
# if any filed is found  redirecting to the main page
# with err message

# changing to mysql date format
  $crm_date   = $partners->date2mysql($crm_date);
  $crm_crdate = $partners->date2mysql($crm_crdate);

# checking date format and if found incorrect redirecting with err msg
  if($partners->is_date($crm_date) || $partners->is_date($crm_crdate)) {
        $errMsg =2;
        header("Location:$url&errMsg=$errMsg");
        exit;
  }

# date format checking endes here
#-------------------------------------------------------------------------------

    $crm_affiliate_id  = trim(addslashes($_POST['crm_affiliate_list']));
    $crm_cat_id        = trim(addslashes($_POST['crm_cat_id']));
    $crm_type          = trim(addslashes($_POST['crm_type']));
    $crm_subject       = trim(addslashes($_POST['crm_subject']));
    $crm_note          = trim(addslashes($_POST['crm_note']));
    $crm_flag          = trim(addslashes($_POST['crm_flag']));
    $crm_action        = trim(addslashes($_POST['crm_action']));
    $crm_merchant_id   = trim(addslashes($_POST['crm_merchant_id']));


#-------------------------------------------------------------------------------
# checking whether the entry already exists
/*  $sql  =" SELECT * FROM partners_crm ";
  $sql .=" WHERE  crm_merchantid = $crm_merchant_id ";
  $sql .=" AND crm_affiliateid = $crm_affiliate_id ";
  if($crm_id)$sql .=" AND crm_id <> $crm_id ";

  $ret = mysql_query($sql) or die($sql.mysql_error()) ;

# if entry already exists send err message
  if(mysql_num_rows($ret)>0){
        $errMsg =3;
        header("Location:$url&errMsg=$errMsg");
        exit;
  }  */
#-------------------------------------------------------------------------------

switch($crm_action) {

        # Inserting into table
        case "Add New":

                           $sql  = " INSERT INTO partners_crm  ";
                           $sql .= " (crm_merchantid ,crm_affiliateid,crm_catid,crm_date,crm_flag ,crm_subject ,crm_note,crm_crdate,crm_type) ";
                           $sql .= " VALUES ($crm_merchant_id ,$crm_affiliate_id,'$crm_cat_id','$crm_date','$crm_flag' ,'$crm_subject' ,'$crm_note', '$crm_crdate','$crm_type') ";
                           $ret = mysql_query($sql) or die ($sql.mysql_error());
                           $errMsg =4;

          break;
          # Insertion ends here

          case 'Edit':
                           $sql  = " UPDATE  partners_crm  ";
                           $sql .= " SET crm_merchantid ='$crm_merchant_id'  ,";
                           $sql .= " crm_affiliateid = '$crm_affiliate_id',";
                           $sql .= " crm_catid= '$crm_cat_id',";
                           $sql .= " crm_date = '$crm_date',";
                           $sql .= " crm_flag = '$crm_flag',";
                           $sql .= " crm_crdate = '$crm_crdate',";
                           $sql .= " crm_type = '$crm_type',";
                           $sql .= " crm_subject = '$crm_subject'  ,";
                           $sql .= " crm_note = '$crm_note' ";
                           $sql .= " WHERE crm_id = '$crm_id' ";
                           $ret = mysql_query($sql) or die ($sql.mysql_error());
                           $errMsg =5;

         break;
         # Edit ends here
}

header("Location:index.php?Act=list_crm&errMsg=$errMsg");
exit;

?>