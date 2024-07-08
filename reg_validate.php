<?php	

# include all files
  include_once 'includes/db-connect.php';
	include_once 'includes/constants.php';
	include_once 'includes/functions.php';
	include_once 'includes/session.php';

# establishing connection
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

# language including
	include_once 'language_include.php';

# get personal details
	$mode			 = $_GET['mode'];
	$firstname        = stripslashes(trim($_POST['firstnametxt']));
	$lastname         = stripslashes(trim($_POST['lastnametxt']));
	$company          = stripslashes(trim($_POST['companytxt']));
	$url              = stripslashes(trim($_POST['urltxt']));
	$address          = stripslashes(trim($_POST['addresstxt']));
	$city             = stripslashes(trim($_POST['citytxt']));
    $state            = stripslashes(trim($_POST['statetxt']));
	$zip	          = stripslashes(trim($_POST['ziptxt']));
	$taxId            = stripslashes(trim($_POST['taxIdtxt']));
	$category         = stripslashes(trim($_POST['categorylst']));
	$phone            = stripslashes(trim($_POST['phonetxt']));
	$fax              = stripslashes(trim($_POST['faxtxt']));
	$mailid           = stripslashes(trim($_POST['emailidtxt']));
	$type             = stripslashes(trim($_POST['typelst']));
	$country          = stripslashes(trim($_POST['countrylst']));
	$modofpay         = stripslashes(trim($_POST['modofpay']));
    $merchant_currency  = stripslashes(trim($_POST['merchant_currency']));
	$terms              = trim($_POST['terms']);
    $merchant_isInvoice = trim($_POST['merchant_isInvoice']);
  	$today 			    = date("Y-m-d");

    if($merchant_isInvoice!="Yes") $merchant_isInvoice ="No";
# validation

 if(empty($firstname))
            $err = "1";
  else
            $err = "0";


 if(empty($lastname))
            $err .= ".1";

    else
            $err .= ".0";


if(empty($company))
    $err .= ".1";

else
    $err .= ".0";

if(empty($url))
    $err .= ".1";

else
    $err .= ".0";

if(empty($address))
    $err .= ".1";

else
    $err .= ".0";

if(empty($city))
    $err .= ".1";

else
    $err .= ".0";

if(empty($phone))
    $err .= ".1";

else
    $err .= ".0";

if(empty($fax))
    $err .= ".1";

else
    $err .= ".0";

if(empty($mailid))
    $err .= ".1";
else
    $err .= ".0";

if(empty($taxId))
    $err .= ".1";
else
    $err .= ".0";

if(empty($zip))
    $err .= ".1";
else
    $err .= ".0";

if(empty($state))
    $err .= ".1";
else
    $err .= ".0";

if($category=="nill" || $type=="nill" || $country=="nill")
    $err .= ".1";
else
    $err .= ".0";


$_SESSION['MER_ADDRESS'] = $address;
$address = urlencode($address);
# empty fileds
if($err!="0.0.0.0.0.0.0.0.0.0.0.0.0")
	{
	$msg	=urlencode($lang_blank);
	header("Location:index.php?Act=register&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg");
    exit;
	}
# email valiadtion
if($partners->is_email($mailid)==0)
	{
	$msg	=$lang_emailerr;
	header("Location:index.php?Act=register&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg");
	exit;
}

# Accept terms and conditions
if($terms<>1){
     $msg = $lang_termserr;
     header("Location:index.php?Act=register&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg");
     exit;
}

# checkin mail id is existing

$sql    = "select * from partners_login where login_email='$mailid'";
$result = mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0)
   {
   $msg=$lang_email1;    //$emailexist;
   // $_SESSION['MERADD']=$address;
   header("Location:index.php?Act=register&err=2&firstname=$firstname&lastname=$lastname&company=$company&state=$state&zip=$zip&taxId=$taxId&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&msg=$msg");
   exit;
}

else
{

	 $firstname        =        addslashes(trim($_POST['firstnametxt']));
	 $lastname         =        addslashes(trim($_POST['lastnametxt']));
	 $company          =        addslashes(trim($_POST['companytxt']));
	 $url              =        addslashes(trim($_POST['urltxt']));
	 $address          =        addslashes(trim($_POST['addresstxt']));
	 $city             =        addslashes(trim($_POST['citytxt']));
	 $category         =        addslashes(trim($_POST['categorylst']));
	 $phone            =        addslashes(trim($_POST['phonetxt']));
	 $fax              =        addslashes(trim($_POST['faxtxt']));
	 $mailid           =        addslashes(trim($_POST['emailidtxt']));
	 $type             =        addslashes(trim($_POST['typelst']));
	 $country          =        addslashes(trim($_POST['countrylst']));
     $state            = 		addslashes(trim($_POST['statetxt']));
	 $zip	           = 		addslashes(trim($_POST['ziptxt']));
	 $taxId            = 		addslashes(trim($_POST['taxIdtxt']));


      #--------------------------------------------------------------
      # inserting personal details
      #--------------------------------------------------------------
      $sql1 = "INSERT INTO partners_merchant( `merchant_id` , `merchant_firstname` , `merchant_lastname` , `merchant_company` , `merchant_address` , `merchant_city` , `merchant_country` , `merchant_phone` , `merchant_url` , `merchant_category` , `merchant_status` , `merchant_date` , `merchant_fax` , `merchant_type`, `merchant_currency`, `merchant_state`,`merchant_zip`,`merchant_taxId`,`merchant_isInvoice`)
               VALUES ('', '$firstname', '$lastname', '$company', '$address', '$city', '$country', '$phone', '$url', '$category', 'NP', '$today', '$fax', '$type','$merchant_currency','$state','$zip','$taxId','$merchant_isInvoice')";
      $result = mysqli_query($con,$sql1);

      $curid=mysqli_insert_id($con);

       #--------------------------------------------------------------
       # generating a random number.
       #--------------------------------------------------------------

       $newRandom  = "M_".$curid.$partners->RandomNumber(4);

       $updatesql = "update partners_merchant set merchant_randNo = '$newRandom' where merchant_id='$curid' ";
       mysqli_query($con,$updatesql);

       #--------------------------------------------------------------
       # generating a random number.
       # inserting login info
       #--------------------------------------------------------------

    	$rand	=	rand(0,10000);

    	$pass	=	$firstname.$rand;

    	$sql2	=	"INSERT INTO `partners_login` ( `login_email` , `login_password` , `login_flag` , `login_id` )
            		VALUES ('$mailid', '$pass', 'm', '$curid')";
    	$result = mysqli_query($con,$sql2);

       #--------------------------------------------------------------
       # setting mode of pay so that user is redirected to payment page
       #--------------------------------------------------------------

        $payment_method = $modofpay;
        $type   = trim(strtolower($type));
        if($type=="normal") {
           $amount	= $normal_user;
           $payment = $normal_user;
        }else{
           $amount  = $advanced_user;
           $payment = $advanced_user;
        }

      #--------------------------------------------------------------
      # entering payment record for usr
      #--------------------------------------------------------------

      $sql2		= "INSERT INTO `merchant_pay` ( `pay_merchantid` , `pay_amount`  )
            		VALUES ('$curid', '0')";
      $result 	= mysqli_query($con,$sql2);

       #--------------------------------------------------------------
       # setting mode of pay so that user is redirected to payment page
       #--------------------------------------------------------------


        $sql	=	"select * from partners_admin";
        $ret1	=	mysqli_query($con,$sql);
        $row	=	mysqli_fetch_object($ret1);

        //common header and footer
        $adminheader	=	stripslashes($row->admin_mailheader);
        $adminfooter	=	stripslashes($row->admin_mailfooter);
		$admin_email	 =    stripslashes($row->admin_email);


       $sql		=	"select * from partners_adminmail where adminmail_eventname='Merchant Registration' ";
       $result	=	mysqli_query($con,$sql);

       if(mysqli_num_rows($result)>0)
       {
          $row           = mysqli_fetch_object($result);
          $sub           = stripslashes($row->adminmail_subject);
          $message       = stripslashes($row->adminmail_message);
          $head          = stripslashes($row->adminmail_header);
          $footer        = stripslashes($row->adminmail_footer);
          $from          = stripslashes($row->adminmail_from);
          $subject       = $sub;
       }

        //$message .= " password= ".$pass;
        $to		  =$mailid;


        $headers    =  "Content-Type: text/html; charset=iso-8859-1\n";
        $headers   .=  "From: $from\n";
		$headers		=str_replace("[from]",$admin_email,$headers); 
        $body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
        $body.="<tr>";
        $body.="<td width='100%' align='center' valign='top'><br/>";
        $body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";

        $body.="<tr>";
        $body.="<td  width='100%' align='center'> $adminheader</td>";
        $body.="</tr>";
        $body.="<tr>";
        $body.="<td  width='100%' align='left'> $head</td>";
        $body.="</tr>";

        $body.="<tr>";
        $body.="<td  width='100%' align='left'>&nbsp;</td>";
        $body.="</tr>";
        $body.="<tr>";
        $body.="<td width='100%' align='left'>$message";
        $body.="</td></tr>";
        $body.="<tr>";
        $body.="<td width='100%' align='left'>"."Your Password Is =".$pass;
        $body.="</td></tr>";
        $body.="<tr>";
        $body.="<td  width='100%' align='left'>&nbsp;</td>";
        $body.="</tr>";
        $body.="<tr>";
        $body.="<td  width='100%' align='left'>$footer</td>";
        $body.="</tr>";
        $body.="<tr>";
        $body.="<td  width='100%' align='center'>$adminfooter</td>";
        $body.="</tr>";

        $body.="</table>";
        $body.="</td>";
        $body.="</tr>";
        $body.="</table>";
 
					//Replace variable in the content with values
                     $body=str_replace("[mer_firstname]",$firstname,$body);
                     $body=str_replace("[mer_lastname]",$lastname,$body);
                     $body=str_replace("[mer_company]",$company,$body);
                     $body=str_replace("[mer_email]",$mailid,$body);
                     $body=str_replace("[mer_loginlink]",$url,$body);
                     $body=str_replace("[mer_password]",$pass,$body);
					 
					 $body=str_replace("[from]",$admin_email,$body);
                     $body=str_replace("[today]",$today,$body);

     	mail($to,$subject,$body,$headers);

		//Added by DPT on 27/June/05
		//Only if the fee is greater than 0 the user should be directed to payment page	   
		if($amount>0)
		{
			include_once "togateway.php";
			exit;
		}
		else
		{
			//register the user 
			 $getmoney = " select `pay_amount` from `merchant_pay` WHERE `pay_merchantid` = '$curid'";
			 $getret   = mysqli_query($con,$getmoney);
			
			 if(mysqli_num_rows($getret)>0){
				 $getrow      = mysqli_fetch_object($getret);
				 $pay_amount = $getrow->pay_amount;			
				 $changamount =   $amount +  $pay_amount;			
				 $sql2		=	"UPDATE  `merchant_pay` set `pay_amount` ='$changamount'    Where  `pay_merchantid` = '$curid'";
				 $result 	= 	mysqli_query($con,$sql2);
			 }
			 else{
				 $sql2		=	"INSERT INTO `merchant_pay` ( `pay_merchantid` , `pay_amount`  )
								VALUES ('$curid', '$amount')";
				 $result 	= mysqli_query($con,$sql2);
			 }	
			
			 $today     = date("Y-m-d");
			 $sql22  	= "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag` , `adjust_amount` , `adjust_date` , `adjust_no` )
							VALUES ('', '$curid', 'deposit', 'm', '$amount', '$today', '0')";
			 $result22  = mysqli_query($con,$sql22);			
			 $sql3  = "INSERT INTO `partners_fee` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
							$sql3 .= "VALUES ('', '$curid', 'register', 'closed','$amount','$today')";
							mysqli_query($con,$sql3);			
			 $updatestat= "UPDATE partners_merchant SET merchant_status= 'approved' WHERE merchant_id = '$curid'";
			 $updateret = mysqli_query($con,$updatestat);
			 $msg		=	$lang_success;			
			 
		     header("Location:index.php?Act=register&msg=$msg");
		     exit;			 
		}//end of checking for amount 


}







?>