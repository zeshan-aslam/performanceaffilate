<?php

# including all needed files
include_once 'includes/db-connect.php';
include_once 'includes/constants.php';
include_once 'includes/functions.php';
include_once 'includes/session.php';

use PHPMailer\PHPMailer\PHPMailer;

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
    $mail->Password = 'giuffisowopirwwv'; //enter you email password
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
# estabilshing connection
$partners = new partners;
$partners->connection($host, $user, $pass, $db);

# including multilingual option
include_once 'language_include.php';

# -------------------------------------------------------------------------
# getting form variables
# -------------------------------------------------------------------------
$MID             = $_GET['MID'];
$PID             = $_GET['PID'];
$mode             = $_GET['mode'];
if (isset($_REQUEST['referer'])) {
    $referer_id = $_REQUEST['referer'];
}

# personal information
$firstname        = stripslashes(trim($_POST['firstnametxt']));
$lastname         = stripslashes(trim($_POST['lastnametxt']));
$company          = stripslashes(trim($_POST['companytxt']));
$url              = stripslashes(trim($_POST['urltxt']));
$address          = stripslashes(trim($_POST['addresstxt']));
$city             = stripslashes(trim($_POST['citytxt']));
$zip             = stripslashes(trim($_POST['ziptxt']));
$category         = stripslashes(trim($_POST['categorylst']));
$phone            = stripslashes(trim($_POST['phonetxt']));
// $fax              = stripslashes(trim($_POST['faxtxt']));
$mailid           = stripslashes(trim($_POST['emailidtxt']));
$country          = stripslashes(trim($_POST['countrylst']));
$today            = date("Y-m-d");
$modofpay         = stripslashes(trim($_POST['modofpay']));
$affiliateid      = intval(stripslashes(trim($_POST['affiliateid'])));
$taxId            = stripslashes(trim($_POST['taxIdtxt']));

$currency        = stripslashes(trim($_REQUEST['currency']));


$_SESSION['PAYMODE'] = "";
# paypal email
$_SESSION['PAYMODE']  =    $payapalemail     = stripslashes(trim($_POST['paypalemail']));
$_SESSION['PAYMODE'] .=  "`~`";
# storm pay email
$_SESSION['PAYMODE'] .= $stormemail       = stripslashes(trim($_POST['stormemail']));
$_SESSION['PAYMODE'] .=  "`~`";
# egold information
$_SESSION['PAYMODE'] .= $payeename        = stripslashes(trim($_POST['payeename']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $acno             = stripslashes(trim($_POST['acno']));
$_SESSION['PAYMODE'] .=  "`~`";
# checkout information
$_SESSION['PAYMODE'] .= $productid        = stripslashes(trim($_POST['productid']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $checkoutid       = stripslashes(trim($_POST['checkoutid']));
$_SESSION['PAYMODE'] .=  "`~`";
# authorize.net information.
$_SESSION['PAYMODE'] .= $version          = stripslashes(trim($_POST['version']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $delimdata        = stripslashes(trim($_POST['delimdata']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $relayresponse    = stripslashes(trim($_POST['relayresponse']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $login            = stripslashes(trim($_POST['login']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $trankey          = stripslashes(trim($_POST['trankey']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $cctype           = stripslashes(trim($_POST['cctype']));
$_SESSION['PAYMODE'] .=  "`~`";

#-------------------------------------------------------------------------
# Aditional informations added
#-------------------------------------------------------------------------
$_SESSION['PAYMODE'] .= $zipcode            = trim(stripslashes($_POST['zipcode']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $state              = trim(stripslashes($_POST['state']));
$_SESSION['PAYMODE'] .=  "`~`";

$_SESSION['PAYMODE'] .= $timezone           = trim(stripslashes($_POST['timezone']));
$_SESSION['PAYMODE'] .=  "`~`";
$terms              = trim($_POST['Terms']);

# Neteller account
$_SESSION['PAYMODE'] .= $neteller_email     = trim(stripslashes($_POST['neteller_email']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $neteller_accnt         = trim(stripslashes($_POST['neteller_accnt']));
$_SESSION['PAYMODE'] .=  "`~`";

# check by Mail
$_SESSION['PAYMODE'] .= $checkpayee         = trim(stripslashes($_POST['checkpayee']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $checkcurr          = trim(stripslashes($_POST['checkcurr']));
$_SESSION['PAYMODE'] .=  "`~`";


# Wire Transfer
$_SESSION['PAYMODE'] .= $wire_AccountName   = trim(stripslashes($_POST['wire_AccountName']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_AccountNumber = trim(stripslashes($_POST['wire_AccountNumber']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_BankName      = trim(stripslashes($_POST['wire_BankName']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_BankAddress   = trim(stripslashes($_POST['wire_BankAddress']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_BankCity      = trim(stripslashes($_POST['wire_BankCity']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_BankState     = trim(stripslashes($_POST['wire_BankState']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_BankZip       = trim(stripslashes($_POST['wire_BankZip']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_BankCountry   = trim(stripslashes($_POST['wire_BankCountry']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_BankAddressNumber = trim(stripslashes($_POST['wire_BankAddressNumber']));
$_SESSION['PAYMODE'] .=  "`~`";
$_SESSION['PAYMODE'] .= $wire_Nominate      = trim(stripslashes($_POST['wire_Nominate']));
$_SESSION['PAYMODE'] .=  "`~`";



#-------------------------------------------------------------------------
# Aditional informations added Ends Here
#-------------------------------------------------------------------------

#
$bankno           = stripslashes(trim($_POST['bankno']));
$bankname         = stripslashes(trim($_POST['bankname']));
$bankemail        = stripslashes(trim($_POST['bankemail']));
$bankaccount      = stripslashes(trim($_POST['bankaccount']));
$payableto        = stripslashes(trim($_POST['payableto']));
$minimumcheck     = stripslashes(trim($_POST['minimumcheck']));

# -------------------------------------------------------------------------
# valiadtion
# -------------------------------------------------------------------------
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
    $err .= ".1";
    $msg = "Address is required";
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

if (empty($mailid)) {
    $err .= ".1";
    $msg = "Email is required";
} else {
    $err .= ".0";
}

if ($category == "nill" || $country == "nill") {
    $err .= ".1";
    $msg = "Category or Country is missing now";
} else {
    $err .= ".0";
}

if (empty($zip)) {
    $err .= ".1";
    $msg = "Zip is missing";
} else {
    $err .= ".0";
}

#-------------------------------------------------------------------------
# Aditional informations added
#-------------------------------------------------------------------------
//   if(empty($zip) || empty($state) || ($timezone ==""))
//   {
//             $err .= ".1";
//             $msg = "Zip/City/Timezone is missing";
//   }
//   else    
//     { 
//       $err .= ".0" ;
//     }

#-------------------------------------------------------------------------
# Aditional informations added Ends Here
#-------------------------------------------------------------------------



# -------------------------------------------------------------------------
# redirecting i valiadtion fails
# -------------------------------------------------------------------------
$_SESSION['AFF_ADDRESS'] = $address;
$address = urlencode($address);
# empty feilds
if ($err != "0.0.0.0.0.0.0.0.0.0") {
    $msg = $lang_blank;
    if (isset($_GET['MID']) || isset($_GET['PID'])) {
        header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
    } else {
        header("Location:signup.php?msg=$msg&err=2");
    }
    exit;
}

# Accept terms and conditions
if (!$terms == 1) {
    $msg = $lang_termserr;

    if (isset($_GET['MID']) || isset($_GET['PID'])) {
        header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
    } else {
        header("Location:signup.php?msg=$msg&err=2");
    }
    exit;
}

if (preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['firstnametxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['lastnametxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['companytxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['faxtxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['phonetxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['addresstxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['ziptxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['citytxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['statetxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['taxIdtxt']) || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['checkpayee'])  || preg_match("/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['checkcurr'])) {
    $msg = "Please remove urls from fields. except URL field.";
    // prevent form from saving code goes here
    if (isset($_GET['MID']) || isset($_GET['PID'])) {
        header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
    } else {
        header("Location:signup.php?msg=$msg&err=2");
    }
    exit;
} else {
    // Insertion in Db
}

//Validate reCAPTCHA box 
if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
    $secretKey = '6Le5c1IiAAAAAJ8CP9hb3BtG2Lg3FcXPUaQgc0Cu';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        $msg = 'Robot verification failed, please try again.';
        if (isset($_GET['MID']) || isset($_GET['PID'])) {
            header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$statusMsg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
        } else {
            header("Location:signup.php?msg=$msg&err=2");
        }
        exit;
    }
} else {
    $msg = 'Please check on the reCAPTCHA box.';
    if (isset($_GET['MID']) || isset($_GET['PID'])) {
        header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$statusMsg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
    } else {
        header("Location:signup.php?msg=$msg&err=2");
    }
    exit;
}

// 

# checking whether payment gateway infmn are valid
switch ($modofpay) {
        //  case 'Paypal':
        /*
                          if($partners->is_email($payapalemail)==0) {
                             $msg = $lang_payerr;
                             header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&payapalemail=$payapalemail&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
                             exit;
                          }
                          */
        //   break;

        /*  case 'Stormpay':
                          if($partners->is_email($stormemail)==0){
                             $msg = $lang_stormerr;
                             header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&stormemail=$stormemail&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
                             exit;
                          }*/
        //  break;

        /*
              case 'Authorize.net':
                           if(empty($version) ||     (empty($login)) ||  (empty($trankey) )) {
                             $msg=$lang_autherr;
                             header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
                             exit;
                           }*/
        //   break;

    case '2checkout':
        if ((empty($checkoutid)) ||  (empty($productid))) {
            $msg = $lang_chkerr;
            if (isset($_GET['MID']) || isset($_GET['PID'])) {
                header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateidcheckoutid=$checkoutid&productid=$productid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
            } else {
                header("Location:signup.php?msg=$msg&err=2");
            }
            exit;
        }
        break;

        /*case 'CheckByMail':
                          if((empty($checkpayee)) ||  (empty($checkcurr))) {
                             $msg=$lang_checkerr;
                             header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateidcheckoutid=$checkoutid&productid=$productid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency")           ;
                             exit;
                          }
                          break;*/

        /* case "NETeller":
                         if($partners->is_email($neteller_email)==0){
                             $msg = $lang_netellererr;
                             header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&stormemail=$stormemail&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
                             exit;
                          }
                          if((empty($neteller_accnt))) {
                             $msg=$lang_checkerr;
                             header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateidcheckoutid=$checkoutid&productid=$productid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency")           ;
                             exit;
                          } 
                          break;*/
        /* case 'E-Gold':
                          if((empty($payeename)) ||  (empty($acno))){
                             $msg = $lang_egolderr;
                             header("Location:index.php?Act=Affiliate&MID=$MID&PID=$PIDs&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&payeename=$payeename&acno=$acno&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
                             exit;
                         // }
                          break;*/

    case "WireTransfer":
        if ((empty($wire_AccountName)) ||  (empty($wire_AccountNumber)) ||  (empty($wire_BankName)) ||  (empty($wire_BankAddress)) ||  (empty($wire_BankCity)) ||  (empty($wire_BankState)) ||  (empty($wire_BankZip)) ||  (empty($wire_BankCountry)) ||  (empty($wire_BankAddressNumber)) ||  (empty($wire_Nominate))) {
            $msg = $lang_checkerr;
            if (isset($_GET['MID']) || isset($_GET['PID'])) {
                header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateidcheckoutid=$checkoutid&productid=$productid&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId&currency=$currency");
            } else {
                header("Location:signup.php?msg=$msg&err=2");
            }
            exit;
        }
        break;
}


# checking mail id is existing
$sql    = "select * from partners_login where login_email='$mailid'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $msg = $lang_email1;;        //$emailexist;
    if ($MID != "" || $PID != "") {
        header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&err=2&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&taxIdtxt=$taxId&currency=$currency");
    } else {
        header("Location:signup.php?msg=$msg&err=2");
    }
    exit;
} else {
    $firstname        = addslashes(trim($_POST['firstnametxt']));
    $lastname         = addslashes(trim($_POST['lastnametxt']));
    $company          = addslashes(trim($_POST['companytxt']));
    $url              = addslashes(trim($_POST['urltxt']));
    $address          = addslashes(trim($_POST['addresstxt']));
    $city             = addslashes(trim($_POST['citytxt']));
    $category         = addslashes(trim($_POST['categorylst']));
    $phone            = addslashes(trim($_POST['phonetxt']));
    //  $fax              = addslashes(trim($_POST['faxtxt']));
    $mailid           = addslashes(trim($_POST['emailidtxt']));
    $country          = addslashes(trim($_POST['countrylst']));
    $today            = date("Y-m-d");
    $modofpay         = addslashes(trim($_POST['modofpay']));
    $bankno           = addslashes(trim($_POST['bankno']));
    $bankname         = addslashes(trim($_POST['bankname']));
    $bankemail        = addslashes(trim($_POST['bankemail']));
    $bankaccount      = addslashes(trim($_POST['bankaccount']));
    $payableto        = addslashes(trim($_POST['payableto']));
    $minimumcheck     = addslashes(trim($_POST['minimumcheck']));
    $affiliateid      = intval(addslashes(trim($_POST['affiliateid'])));
    $payapalemail     = addslashes(trim($_POST['paypalemail']));
    $stormemail       = addslashes(trim($_POST['stormemail']));
    $payeename        = addslashes(trim($_POST['payeename']));
    $acno             = addslashes(trim($_POST['acno']));
    $productid        = addslashes(trim($_POST['productid']));
    $checkoutid       = addslashes(trim($_POST['checkoutid']));
    $version          = addslashes(trim($_POST['version']));
    $delimdata        = addslashes(trim($_POST['delimdata']));
    $relayresponse    = addslashes(trim($_POST['relayresponse']));
    $login            = addslashes(trim($_POST['login']));
    $trankey          = addslashes(trim($_POST['trankey']));
    $cctype           = addslashes(trim($_POST['cctype']));
    $taxId            = addslashes(trim($_POST['taxIdtxt']));
    $currency        = addslashes(trim($_REQUEST['currency']));

    #-------------------------------------------------------------------------
    # Aditional informations added
    #-------------------------------------------------------------------------
    $zipcode        = trim(addslashes($_POST['ziptxt']));
    $state          = trim(addslashes($_POST['statetxt']));
    $timezone       = trim(addslashes($_POST['timezone']));

    # Neteller account
    $neteller_email     = trim(addslashes($_POST['neteller_email']));
    $neteller_accnt     = trim(addslashes($_POST['neteller_accnt']));

    # check by Mail
    $checkpayee         = trim(addslashes($_POST['checkpayee']));
    $checkcurr          = trim(addslashes($_POST['checkcurr']));

    # Wire Transfer
    $wire_AccountName   = trim(addslashes($_POST['wire_AccountName']));
    $wire_AccountNumber = trim(addslashes($_POST['wire_AccountNumber']));
    $wire_BankName      = trim(addslashes($_POST['wire_BankName']));
    $wire_BankAddress   = trim(addslashes($_POST['wire_BankAddress']));
    $wire_BankCity      = trim(addslashes($_POST['wire_BankCity']));
    $wire_BankState     = trim(addslashes($_POST['wire_BankState']));
    $wire_BankZip       = trim(addslashes($_POST['wire_BankZip']));
    $wire_BankCountry   = trim(addslashes($_POST['wire_BankCountry']));
    $wire_BankAddressNumber = trim(addslashes($_POST['wire_BankAddressNumber']));
    $wire_Nominate      = trim(addslashes($_POST['wire_Nominate']));
    #-------------------------------------------------------------------------
    # Aditional informations added Ends Here
    #-------------------------------------------------------------------------



    #-------------------------------------------------------------------------
    # Inserting to Affiliate table
    #-------------------------------------------------------------------------
    if (isset($_POST['referer_id'])) {
        $Parent_Id = $_POST['referer_id'];
    } else {
        $Parent_Id = $_SESSION['AFFILIATE_REFERER_ID'];
    }
    //====generating unique secretKey with prefix affi and storing it in partners_affiliate table=====BY RANA//
    $secretKey = uniqid('affi');

    $sql1      = "INSERT INTO `partners_affiliate` ( `affiliate_id` , `affiliate_firstname` , `affiliate_lastname` , `affiliate_company` , `affiliate_address` , `affiliate_city` , `affiliate_country` , `affiliate_url` , `affiliate_category` , `affiliate_status` , `affiliate_date` , `affiliate_parentid` , `affiliate_fax` , `affiliate_phone` ,`affiliate_state` ,`affiliate_timezone` , `affiliate_zipcode`, affiliate_taxId, affiliate_currency, affiliate_secretkey)
                            VALUES ('', '$firstname', '$lastname', '$company', '$address', '$city', '$country', '$url', '$category', 'waiting', '$today', '$Parent_Id', '$fax', '$phone' , '$state', '$timezone' ,'$zipcode','$taxId', '$currency', '$secretKey')";
    $result    = mysqli_query($con, $sql1);

    $_SESSION['AFFILIATE_REFERER_ID'] = "";

    #-------------------------------------------------------------------------
    # Assigning random Password
    #-------------------------------------------------------------------------
    $curid     = mysqli_insert_id($con);
    $rand      = rand(0, 10000);
    $pass      = $firstname . $rand;

    #-------------------------------------------------------------------------
    # Insering Password& Login name
    #-------------------------------------------------------------------------
    $sql2      = "INSERT INTO `partners_login` ( `login_email` , `login_password` , `login_flag` , `login_id` )
                            VALUES ('$mailid', '$pass', 'a', '$curid')";
    $result    = mysqli_query($con, $sql2);


    #-------------------------------------------------------------------------
    # Inserting Payment gateway information
    #-------------------------------------------------------------------------
    $sql3      = "INSERT INTO `partners_bankinfo` ( `bankinfo_id` , `bankinfo_affiliateid` , `bankinfo_modeofpay` , `bankinfo_paypalemail` , `bankinfo_stormemail` , `bankinfo_payeename` , `bankinfo_acno` , `bankinfo_checkoutid` , `bankinfo_productid` , `bankinfo_version` , `bankinfo_delimdata` , `bankinfo_relayresponse` , `bankinfo_login` , `bankinfo_trankey` , `bankinfo_cctype` ,`bankinfo_neteller_email` , `bankinfo_neteller_accnt` , `bankinfo_checkpayee` , `bankinfo_checkcurr` , `bankinfo_wire_AccountName` , `bankinfo_wire_AccountNumber` , `bankinfo_wire_BankName` , `bankinfo_wire_BankAddress` , `bankinfo_wire_BankCity` , `bankinfo_wire_BankState` , `bankinfo_wire_BankZip` , `bankinfo_wire_BankCountry` , `bankinfo_wire_BankAddressNumber` , `bankinfo_wire_Nominate` )    ";
    $sql3     .= " VALUES ('', '$curid', '$modofpay', '$payapalemail', '$stormemail', '$payeename', '$acno', '$checkoutid', '$productid', '$version', '$delimdata', '$relayresponse', '$login', '$trankey', '$cctype','$neteller_email', '$neteller_accnt', '$checkpayee', '$checkcurr', '$wire_AccountName', '$wire_AccountNumber', '$wire_BankName', '$wire_BankAddress', '$wire_BankCity', '$wire_BankState', '$wire_BankZip', '$wire_BankCountry', '$wire_BankAddressNumber', '$wire_Nominate')";
    $result    = mysqli_query($con, $sql3);

    #-------------------------------------------------------------------------
    # inseting default payment record for affiliate
    #-------------------------------------------------------------------------
    $sql2      = "INSERT INTO `affiliate_pay` ( `pay_affiliateid` , `pay_amount`  )
                           VALUES ('$curid', 0)";
    $result    = mysqli_query($con, $sql2);


    #-------------------------------------------------------------------------
    # Getting Mail PARAMETRS from table
    #-------------------------------------------------------------------------
    $sql            =   "select * from partners_admin";
    $ret1           =   mysqli_query($con, $sql);
    $row            =   mysqli_fetch_object($ret1);  //common header and footer
    $adminheader    =   stripslashes($row->admin_mailheader);
    $adminfooter    =   stripslashes($row->admin_mailfooter);
    $admin_email     =    stripslashes($row->admin_email);


    $sql       =  "select * from partners_adminmail where adminmail_eventname='Affiliate Registration' ";
    $result    =  mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row           =  mysqli_fetch_object($result);
        $sub           =  stripslashes($row->adminmail_subject);
        $message       =  stripslashes($row->adminmail_message);
        $head          =  stripslashes($row->adminmail_header);
        $footer        =  stripslashes($row->adminmail_footer);
        $from          =  stripslashes($row->adminmail_from);
        $subject       = $sub;
    }

    #-------------------------------------------------------------------------
    # Sending Mail
    #-------------------------------------------------------------------------
    $to     =    $mailid;

    // $to = "somebody@example.com";
    $headers   =  "Content-Type: text/html; charset=iso-8859-1\n";
    $headers .= "From: $from\n";
    // $headers		=str_replace("[from]",$admin_email,$headers); 
    $body = "<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
    $body .= "<tr>";
    $body .= "<td width='100%' align='center' valign='top'><br/>";
    $body .= "<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";

    $body .= "<tr>";
    $body .= "<td  width='100%' align='left'>$message</td>";
    $body .= "</tr>";
    // $body.="<tr>";


    // $body.="<tr>";
    // $body.="<td  width='100%' align='left'>$footer</td>";
    //$body.="</tr>";
    //$body.="<tr>";
    // $body.="<td  width='100%' align='center'>$adminfooter</td>";
    //$body.="</tr>";

    $body .= "</table>";
    $body .= "</td>";
    $body .= "</tr>";
    $body .= "</table>";
    //Replace variable in the content with values
    $body = str_replace("[aff_firstname]", $firstname, $body);
    $body = str_replace("[aff_lastname]", $lastname, $body);
    $body = str_replace("[aff_company]", $company, $body);
    $body = str_replace("[aff_email]", $mailid, $body);
    $body = str_replace("[aff_loginlink]", $url, $body);
    $body = str_replace("[aff_password]", $pass, $body);

    $body = str_replace("[from]", $admin_email, $body);
    $body = str_replace("[today]", $today, $body);


    // mail($to,$subject,$body,$headers);
    // $mailok="Password Change Notification Mail Has been Send \n";
    // $mailok .= " To :".$to." \n";
    // $mailok.=" From :".$from;




    $_SESSION['AFF_ADDRESS'] = "";


    // header("Location:index.php?Act=Affiliates&msg=$msg&success=true");
    // $msg       = $lang_success;
    // header("Location:signup.php?msg=$msg&success=true");


    $mail =  send_smtp_mail($to, $body, $subject, $from);

    if ($mail) {
        $msg = $lang_success;
        if (isset($_GET['MID']) || isset($_GET['PID'])) {
            header("Location:index.php?Act=Affiliates&MID=$MID&PID=$PID&msg=$msg&success=true");
        } else {
            header("Location:signup.php?msg=$msg&success=true");
        }
        exit;
    }
    exit;
}
