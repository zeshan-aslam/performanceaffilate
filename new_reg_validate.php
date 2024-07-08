<?php

# include all files
include_once 'includes/db-connect.php';
include_once 'includes/constants.php';
include_once 'includes/functions.php';
include_once 'includes/session.php';
include_once 'includes/encode_decodeFunction.php';

use PHPMailer\PHPMailer\PHPMailer;

function cleanData($value)
{
  $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
  $replace = array("", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

  return str_replace($search, $replace, $value);
}

function send_smtp_mail($to, $msg, $Subject, $from)
{
  require_once "PHPMailer2/PHPMailer.php";
  require_once "PHPMailer2/SMTP.php";
  require_once "PHPMailer2/Exception.php";

  $mail = new PHPMailer();

  //SMTP Settings
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username = "searlco.co@gmail.com"; //enter you email address
  $mail->Password = 'vcjsowvqsivewish'; //enter you email password
  $mail->Port = 465;
  $mail->SMTPSecure = "ssl";

  //Email Settings
  $mail->isHTML(true);
  $mail->setfrom("searlco6@gmail.com");
  $mail->FromName = $from;
  $mail->addAddress($to); //enter you email address
  $mail->isHTML(true);
  $mail->Subject = $Subject;
  $mail->Body = $msg;
  $mail->AltBody = "This is the plain text version of the email content";
  try {
    $mail->send();
    $SM = TRUE;
  } catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  }
  return true;
}
# establishing connection
$partners = new partners;
$partners->connection($host, $user, $pass, $db);

# language including
include_once 'language_include.php';


/*
  echo "<pre>";
  var_dump($_POST);
  die();
*/
$com  = stripslashes(trim($_POST['companytxt']));
# get personal details
$mode       = $_GET['mode'];
$firstname         = stripslashes(trim($_POST['firstnametxt']));
$lastname        = stripslashes(trim($_POST['lastnametxt']));
$company = cleanData($com);
//$company          = stripslashes(trim($_POST['companytxt']));
$url              = stripslashes(trim($_POST['urltxt']));
$address          = stripslashes(trim($_POST['addresstxt']));
$city             = stripslashes(trim($_POST['citytxt']));
$state            = stripslashes(trim($_POST['statetxt']));
$zip            = stripslashes(trim($_POST['ziptxt']));
$taxId            = stripslashes(trim($_POST['taxIdtxt']));
$category         = stripslashes(trim($_POST['categorylst']));
$phone            = stripslashes(trim($_POST['phonetxt']));
//$fax              = stripslashes(trim($_POST['faxtxt']));
$mailid           = stripslashes(trim($_POST['emailidtxt']));
//$type             = stripslashes(trim($_POST['typelst']));
$country          = stripslashes(trim($_POST['countrylst']));
$currency          = stripslashes(trim($_POST['currency']));
$modofpay         = stripslashes(trim($_POST['modofpay']));
// $brands           = stripslashes(trim($_POST['brands']));   
$brands            = cleanData($_POST['brands']);
// $brandspower         = stripslashes(trim($_POST['brandspower'])); 

$merchant_currency  = stripslashes(trim($_POST['merchant_currency']));

$terms              = trim($_POST['Terms']);

$merchant_isInvoice = trim($_POST['merchant_isInvoice']);
$today           = date("Y-m-d");

if ($merchant_isInvoice != "Yes") $merchant_isInvoice = "No";
# validation

if (empty($firstname)) {
  $err = "1";
  $msg = "Firstname is required";
} else {
  $err = "0";
}


if (empty($lastname)) {
  $err .= ".1";
  $msg = "Lastname is required";
} else {
  $err .= ".0";
}


if (empty($company)) {
  $err .= ".1";
  $msg = "Company is required";
} else {
  $err .= ".0";
}

if (empty($url)) {
  $err .= ".1";
  $msg = "URL is required";
} else {
  $err .= ".0";
}

if (empty($address)) {
  $msg = "Address is required";
  $err .= ".1";
} else {
  $err .= ".0";
}

if (empty($city)) {
  $err .= ".1";
  $msg = "City is required";
} else {
  $err .= ".0";
}

if (empty($phone)) {
  $err .= ".1";
  $msg = "Phone is required";
} else {
  $err .= ".0";
}
if (empty($brands)) {
  $err .= ".1";
  $msg = "Brands is required";
} else {
  $err .= ".0";
}
//    if(empty($brandspower))
//  {
//    $err .= ".1";
//    $msg = "Brands Power is required";
//  }
//  else
//  {
//      $err .= ".0";
//    }
/*if(empty($fax))
 {
     $err .= ".1"; 
     $msg = "Fax is required";
 }
 else
 {
   $err .= ".0";
 }
*/
if (empty($mailid)) {
  $err .= ".1";
  $msg = "Email is required";
} else {
  $err .= ".0";
}

if (empty($taxId)) {
  $err .= ".1";
  $msg = "Tax ID is required";
} else {
  $err .= ".0";
}

if (empty($zip)) {
  $err .= ".1";
  $msg = "Zip is required";
} else {
  $err .= ".0";
}

if (empty($state)) {
  $err .= ".1";
  $msg = "State is required";
} else {
  $err .= ".0";
}
if (empty($currency)) {
  $err .= ".1";
  $msg = "Currency is required";
} else {
  $err .= ".0";
}

if ($category == "nill" || $type == "nill" || $country == "nill") {
  $err .= ".1";
  $msg = "Category/Type or Country is missing";
} else {
  $err .= ".0";
}


$_SESSION['MER_ADDRESS'] = $address;
$address = urlencode($address);
# empty fileds
if ($err != "0.0.0.0.0.0.0.0.0.0.0.0.0.0") {
  $msg  = urlencode($lang_blank);
  header("Location:signup.php?msg=$msg&err=2");
  // header("Location:index.php?Act=Merchants&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&err=2");
  exit;
}
//# email valiadtion
if ($partners->is_email($mailid) == 0) {
  $msg  = $lang_emailerr;
  header("Location:signup.php?msg=$msg&err=2");

  // header("Location:index.php?Act=Merchants&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg");
  exit;
}

# Accept terms and conditions
// $status = $_POST['Terms'];
// if ($status == 1) {
// $status = 1;
// } else {
// $status = 0;
// }
if (!$terms == 1) {
  $msg = $lang_termserr;
  header("Location:signup.php?msg=$msg&err=2");
  //  header("Location:index.php?Act=Merchants&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg");
  exit;
}

// if(preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['firstnametxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['lastnametxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['companytxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['faxtxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['phonetxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['addresstxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['ziptxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['citytxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['statetxt'])|| preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['taxIdtxt']))

//==================Restriction removed from the First_Name ,Last_Name and Company_Name BY RANA =================//
if (preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['faxtxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['phonetxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['addresstxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['ziptxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['citytxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['statetxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['taxIdtxt'])) {
  $msg = "Please remove urls from fields. Except URL field.";
  header("Location:signup.php?msg=$msg&err=2");
  // prevent form from saving code goes here
  //  header("Location:index.php?Act=Merchants&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg");
  exit;
} else {
  // Insertion in Db
}

// // Validate reCAPTCHA box 
if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
  $secretKey = '6Le5c1IiAAAAAJ8CP9hb3BtG2Lg3FcXPUaQgc0Cu';
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);
  if (!$responseData->success) {
    $msg = 'Robot verification failed, please try again.';
    header("Location:signup.php?msg=$msg&err=2");
    //  header("Location:index.php?Act=Merchants&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$statusMsg");
    exit;
  }
} else {
  $msg = 'Please check on the reCAPTCHA box.';
  header("Location:signup.php?msg=$msg&err=2");
  //  header("Location:index.php?Act=Merchants&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$statusMsg");
  exit;
}

# checkin mail id is existing

$sql    = "select * from partners_login where login_email='$mailid'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
  $msg = $lang_email1;    //$emailexist;
  // $_SESSION['MERADD']=$address;
  header("Location:signup.php?msg=$msg&err=2");
  //  header("Location:index.php?Act=Merchants&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg");
  exit;
} else {
  $first       = addslashes(trim(mysqli_real_escape_string($con, $_POST['firstnametxt'])));
  $last        = addslashes(trim(mysqli_real_escape_string($con, $_POST['lastnametxt'])));
  $firstname = cleanData($first);
  $lastname = cleanData($last);

  // $firstname        =        addslashes(trim(mysqli_real_escape_string($con,$_POST['firstnametxt'])));
  // $lastname         =        addslashes(trim(mysqli_real_escape_string($con,$_POST['lastnametxt'])));
  $com  = stripslashes(trim($_POST['companytxt']));
  $company = cleanData($com);
  // $company          =        addslashes(trim(mysqli_real_escape_string($con,$_POST['companytxt'])));
  $url              =        addslashes(trim(mysqli_real_escape_string($con, $_POST['urltxt'])));
  $address          =        addslashes(trim(mysqli_real_escape_string($con, $_POST['addresstxt'])));
  $city             =        addslashes(trim(mysqli_real_escape_string($con, $_POST['citytxt'])));
  $category         =        addslashes(trim(mysqli_real_escape_string($con, $_POST['categorylst'])));
  $phone            =        addslashes(trim(mysqli_real_escape_string($con, $_POST['phonetxt'])));
  //  $fax              =        addslashes(trim(mysqli_real_escape_string($con,$_POST['faxtxt'])));
  $mailid           =        addslashes(trim(mysqli_real_escape_string($con, $_POST['emailidtxt'])));
  $type             =        addslashes(trim(mysqli_real_escape_string($con, $_POST['typelst'])));
  $country          =        addslashes(trim(mysqli_real_escape_string($con, $_POST['countrylst'])));
  $state            =     addslashes(trim(mysqli_real_escape_string($con, $_POST['statetxt'])));
  $zip             =     addslashes(trim(mysqli_real_escape_string($con, $_POST['ziptxt'])));
  $taxId            =     addslashes(trim(mysqli_real_escape_string($con, $_POST['taxIdtxt'])));
  $currency       = addslashes(trim(mysqli_real_escape_string($con, $_POST['currency'])));
  // $brands           = stripslashes(trim($_POST['brands']));   
  $brands            = cleanData($_POST['brands']);
  // $brandspower         = stripslashes(trim($_POST['brandspower'])); 

  foreach ($brands as $brand) {
    $org_val .= $brand . '|';
    $brandString = rtrim($org_val, '|');
  }

  #--------------------------------------------------------------
  # inserting personal details
  #--------------------------------------------------------------
  $sql1 = "INSERT INTO partners_merchant( `merchant_id` , `merchant_firstname` , `merchant_lastname` , `merchant_company` , `merchant_address` , `merchant_city` , `merchant_country` , `merchant_phone` , `merchant_url` , `merchant_category` , `merchant_status` , `merchant_date` , `merchant_fax` , `merchant_type`, `merchant_currency`, `merchant_state`,`merchant_zip`,`merchant_taxId`,`merchant_isInvoice`,`brands`)
              VALUES ('', '$firstname', '$lastname', '$company', '$address', '$city', '$country', '$phone', '$url', '$category', 'NP', '$today', '$fax', '$type','$currency','$state','$zip','$taxId','$merchant_isInvoice','$brandString')";


  $result = mysqli_query($con, $sql1);
  $curid = mysqli_insert_id($con);

  #--------------------------------------------------------------
  # inserting merchant_id and brands into cons_mer_brands table 
  #--------------------------------------------------------------
  $sql2 = "INSERT INTO cons_mer_brands( `cons_mer_id` , `cons_brand_name`)
              VALUES ('$curid','$brandString')";


  $result = mysqli_query($con, $sql2);



  #--------------------------------------------------------------
  # generating a random number.
  #--------------------------------------------------------------

  $newRandom  = "M_" . $curid . $partners->RandomNumber(4);

  $updatesql = "update partners_merchant set merchant_randNo = '$newRandom' where merchant_id='$curid' ";
  mysqli_query($con, $updatesql);

  #--------------------------------------------------------------
  # generating a random number.
  # inserting login info
  #--------------------------------------------------------------

  $rand  =  rand(0, 10000);

  $pass  =  $firstname . $rand;

  $sql2  =  "INSERT INTO `partners_login` ( `login_email` , `login_password` , `login_flag` , `login_id` )
               VALUES ('$mailid', '$pass', 'm', '$curid')";
  $result = mysqli_query($con, $sql2);

  #--------------------------------------------------------------
  # setting mode of pay so that user is redirected to payment page
  #--------------------------------------------------------------

  $payment_method = $modofpay;
  $type   = trim(strtolower($type));
  if ($type == "normal") {
    $amount  = $normal_user;
    $payment = $normal_user;
  } else {
    $amount  = $advanced_user;
    $payment = $advanced_user;
  }

  #--------------------------------------------------------------
  # entering payment record for usr
  #--------------------------------------------------------------

  $sql2    = "INSERT INTO `merchant_pay` ( `pay_merchantid` , `pay_amount`  )
               VALUES ('$curid', '0')";
  $result   = mysqli_query($con, $sql2);

  #--------------------------------------------------------------
  # setting mode of pay so that user is redirected to payment page
  #--------------------------------------------------------------


  $sql  =  "select * from partners_admin";
  $ret1  =  mysqli_query($con, $sql);
  $row  =  mysqli_fetch_object($ret1);

  //common header and footer
  $adminheader  =  stripslashes($row->admin_mailheader);
  $adminfooter  =  stripslashes($row->admin_mailfooter);
  $admin_email   =    stripslashes($row->admin_email);

  #------------------------------------------------------------------------------------------------
  # Getting Encrypted Merchant_ID who is signing up to send through email in the setup Wizard link
  #------------------------------------------------------------------------------------------------
  $encrypted_merID = MultipleTimeEncode($curid);

  $prog_setting = "<button class='btn btn-sm btn-warning'><a href='https://performanceaffiliate.com/performanceAffiliateClone/mer_wizardSignUp.php?mid=$encrypted_merID' target='_blank' style='background-color:Green;
  font-family: sans-serif; font-size: 15px; line-height: 15px;
 text-decoration: none; padding: 6px 17px; color: #ffffff; display: block; border-radius: 4px;'>Set Your Program</a></button>";

  $sql    =  "select * from partners_adminmail where adminmail_eventname='Merchant Registration' ";
  $result  =  mysqli_query($con, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row           = mysqli_fetch_object($result);
    $sub           = stripslashes($row->adminmail_subject);
    $message       = stripslashes($row->adminmail_message);
    $head          = stripslashes($row->adminmail_header);
    $footer        = stripslashes($row->adminmail_footer);
    $from          = stripslashes($row->adminmail_from);
    $subject       = $sub;
  }
  //$message .= " password= ".$pass;
  $to      = $mailid;


  $headers    =  "Content-Type: text/html; charset=iso-8859-1\n";
  $headers   .=  "From: $from\n";
  //	$headers		=str_replace("[from]",$admin_email,$headers); 
  $body = "<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
  $body .= "<tr>";
  $body .= "<td width='100%' align='center' valign='top'><br/>";
  $body .= "<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";

  $body .= "<tr>";
  $body .= "<td  width='100%' align='center'> $adminheader</td>";
  $body .= "</tr>";
  $body .= "<tr>";
  $body .= "<td  width='100%' align='left'>";
  $body .= "</td></tr>";
  $body .= "<tr>";
  $body .= "<td  width='100%' align='left'>&nbsp;</td>";
  $body .= "</tr>";
  $body .= "<tr>";
  $body .= "<td width='100%' align='left'>$message";
  $body .= "</td></tr>";
  // $body .= "<tr>";

  // $body .= "</td></tr>";


  //  $body.="<tr>";
  //  $body.="<td width='100%' align='left'>";
  //  $body.="</td></tr>";
  //  $body.="<tr>";
  //  $body.="<td  width='100%' align='left'>&nbsp;</td>";
  //  $body.="</tr>";
  //  $body.="<tr>";
  //  $body.="<td  width='100%' align='left'>$footer</td>";
  //  $body.="</tr>";
  //  $body.="<tr>";
  //  $body.="<td  width='100%' align='center'>$adminfooter</td>";
  // $body.="</tr>";

  $body .= "</table>";
  $body .= "</td>";
  $body .= "</tr>";
  $body .= "</table>";

  //Replace variable in the content with values
  $body = str_replace("[mer_firstname]", $firstname, $body);
  $body = str_replace("[mer_lastname]", $lastname, $body);
  $body = str_replace("[mer_company]", $company, $body);
  $body = str_replace("[mer_email]", $mailid, $body);
  $body = str_replace("[prog_setting]", $prog_setting, $body);
  $body = str_replace("[mer_loginlink]", $url, $body);
  $body = str_replace("[mer_password]", $pass, $body);

  $body = str_replace("[from]", $admin_email, $body);
  $body = str_replace("[today]", $today, $body);

  // mail($to, $subject, $body, $headers);
  send_smtp_mail($to, $body, $subject, $from);
  //Added by DPT on 27/June/05
  //Only if the fee is greater than 0 the user should be directed to payment page	   
  if ($amount > 10000) {
    include_once "togateway.php";
    exit;
  } else {
    //register the user 
    $getmoney = " select `pay_amount` from `merchant_pay` WHERE `pay_merchantid` = '$curid'";
    $getret   = mysqli_query($con, $getmoney);

    if (mysqli_num_rows($getret) > 0) {
      $getrow      = mysqli_fetch_object($getret);
      $pay_amount = $getrow->pay_amount;
      $changamount =   $amount +  $pay_amount;
      $sql2    =  "UPDATE  `merchant_pay` set `pay_amount` ='$changamount'    Where  `pay_merchantid` = '$curid'";
      $result   =   mysqli_query($con, $sql2);
    } else {
      $sql2    =  "INSERT INTO `merchant_pay` ( `pay_merchantid` , `pay_amount`  )
               VALUES ('$curid', '$amount')";
      $result   = mysqli_query($con, $sql2);
    }

    $today     = date("Y-m-d");
    $sql22    = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag` , `adjust_amount` , `adjust_date` , `adjust_no` )
             VALUES ('', '$curid', 'deposit', 'm', '$amount', '$today', '0')";
    $result22  = mysqli_query($con, $sql22);
    $sql3  = "INSERT INTO `partners_fee` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
    $sql3 .= "VALUES ('', '$curid', 'register', 'closed','$amount','$today')";
    mysqli_query($con, $sql3);
    $updatestat = "UPDATE partners_merchant SET merchant_status= 'approved' WHERE merchant_id = '$curid'";
    $updateret = mysqli_query($con, $updatestat);
    $msg    =  $lang_success;

    header("Location:signup.php?msg=$msg");
    exit;
  } //end of checking for amount 

}
