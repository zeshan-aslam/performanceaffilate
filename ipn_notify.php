<?php

    include_once 'includes/session.php';
    include_once 'includes/constants.php';
    include_once 'includes/functions.php';

    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);


 	 reset ($_GET);
     foreach ($_GET as $key => $value)//to stripslash all get variables
    	{
           $value=stripslashes(trim($value));
           $_GET[$key]=$value;
           $key;
        }

	reset ($_POST);

    foreach ($_POST as $key => $value)//to stripslash all posted variables
    	{
          $value=stripslashes(trim($value));
          $$key=$value;
           $key;
        }

    reset ($_GET);
    reset ($_POST);





$notify_debug = 0;   // ********************** changed BY Pramod 1 to 0


$accept_unverified = 'no';

// accept money from PayPal user's that have an unconfirmed PayPal account address
// yes or no
$accept_unconfirmed = 'yes';


// paypal ip address 65.206.229.140
// NetRange:   65.206.228.0 - 65.206.231.255
// 216.113.188.202 216.113.188.203 216.113.188.204
//NetRange: 216.113.128.0 - 216.113.191.255


$date = date("D, j M Y H:i:s O");
$crlf = "\n";
$debug_headers = "From: $site_email" .$crlf;
$debug_headers .= "Reply-To: $site_email" .$crlf;
$debug_headers .= "Return-Path: $site_email" .$crlf;
$debug_headers .= "X-Mailer: Perl-Studio" .$crlf;
$debug_headers .= "Date: $date" .$crlf;
$debug_headers .= "X-Sender-IP: $REMOTE_ADDR" .$crlf;
//========================================================================================
// end user configuration

$error = 0;
$post_string = '';
$output = '';
$valid_post = '';

$workString = 'cmd=_notify-validate';
/* Get PayPal Payment Notification variables including the encrypted code */
reset($_POST);
while(list($key, $val) = each($_POST)) {
$post_string .= $key.'='.$val.'&';
$val = stripslashes($val);
$val = urlencode($val);
$workString .= '&' .$key .'=' .$val;
}

//   *********************** commmented by pramod ****************************




/* assign posted variables to local variables
1)note: some of these posted variables will be empty
2)note: the following is not a complete list of the posted variables
*/

//*********************** commmented by pramod ****************************





	if($paypal_receiver_email != "$receiver_email")
	{
	    header("Location:".$failurl."&msg=Payment Failed Possible fraud. Error with receiver_email. receiver_email");
	    exit;

	  //  $error_message .= "Error code 501. Possible fraud. Error with receiver_email. receiver_email = $receiver_email\n";
	   // $error++;
	}
	if ((!preg_match("/^65.206/", $REMOTE_ADDR)) || (!preg_match("/^64.4/", $REMOTE_ADDR))
	|| (!preg_match("/^216.113/", $REMOTE_ADDR))){

	    header("Location:".$failurl."&msg=Payment Failed Possible fraud. Error with REMOTE IP ADDRESS");
	    exit;

	//       $error_message .= "Error code 506. Possible fraud. Error with REMOTE IP ADDRESS = $REMOTE_ADDR . The remote address of the script posting to this notify script does not match a valid PayPal ip address\n";
	//       $error++;

	}



// ******************************** RESUBMITTING  TO PAY PAL COMMENTED BY PRAMOD *********************//

// post back to PayPal system to validate
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen ($workString) . "\r\n\r\n";
$fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);


if (!$fp) {
// HTTP ERROR
echo "$errstr ($errno)";
} else {
   fputs ($fp, $header . $workString);
   while (!feof($fp)) {
     $output .= fgets ($fp, 1024);
   }
   fclose ($fp);
}


// remove post headers if present.
$output = preg_replace("'Content-type: text/plain'si","",$output);


$error_lines = split("\n", $error_message);
$i=0;
while($i <= sizeof($error_lines)) {
  $error_message_html .= "<p>" .$error_lines[$i];
  $i++;
}

// logic for handling the INVALID or VERIFIED responses.
/* valid response from PayPal, update paypal table with  response message*/

if (ereg('VERIFIED',$output)) {
    $valid_post = 'VERIFIED POST';
    if (eregi('failed',$payment_status))
    {

// ********************************* FAILED Commented By PRAMOD **********************//

	    header("Location:".$failurl."&msg=Payment Failed ...");
	    exit;

/* invalid - update paypal table with 'invalid' response message*/
/*      $debug_status = "updated paypal table with VERIFIED-failed response";
      update_paypal_ipn_table();
*/
    }
    else if (eregi('denied',$payment_status))
    {
// ********************************* FAILED Commented By PRAMOD **********************//

	    header("Location:".$failurl."&msg=Payment Failed ...");
	    exit;

    /* invalid - update paypal table with 'invalid' response message*/
/*      $debug_status = "updated paypal table with VERIFIED-denied";
      update_paypal_ipn_table();
*/
    }

     else if (eregi('pending',$payment_status))
     {

// ********************************* FAILED Commented By PRAMOD **********************//

	    header("Location:".$failurl."&msg=Payment Failed ...");
	    exit;

    /* invalid - update paypal table with 'invalid' response message*/
    //  $debug_status = "updated paypal table with VERIFIED-pending";
     //  update_paypal_ipn_table();

    }

    else if ((eregi('Completed',$payment_status)) && ($error == 0)){

      if (eregi('unverified',$payer_status)){
      /* update paypal table with 'VERIFIED-unverified' response message*/
        if($accept_unverified == 'yes')
        {

// ********************************* FAILED Commented By PRAMOD **********************//
	    header("Location:".$failurl."&msg=Payment Failed ...");
	    exit;

            // set paid = 'yes'
            // $debug_status = "updated paypal table with VERIFIED-completed response with unverified payer status";
             // update_paypal_ipn_table();

           }
        else
        {

// ********************************* FAILED Commented By PRAMOD **********************//
	    header("Location:".$failurl."&msg=Payment Failed ...");
	    exit;

           // $debug_status = "updated paypal table with VERIFIED-unverified response";
           //  update_paypal_ipn_table();
        }
     }
     else if (eregi('unconfirmed',$address_status)) {
      /* valid - update paypal table with 'unconfirmed' response message*/
      if($accept_unconfirmed == 'yes')
      {
             // set paid = 'yes'
// ********************************* FAILED Commented By PRAMOD **********************//
	    header("Location:".$failurl."&msg=Payment Failed ...");
	    exit;

         //   $debug_status = "updated paypal table with VERIFIED-completed response with unconfirmed address status";
        //  update_paypal_ipn_table();
      }
      else{

// ********************************* FAILED Commented By PRAMOD **********************//
	    header("Location:".$failurl."&msg=Payment Failed ...");
	    exit;

        //    $debug_status = "updated paypal table with VERIFIED-unconfirmed response";
        //     update_paypal_ipn_table();

        }
      }
      else
      {

// ********************************* SUCCCESS Commented By PRAMOD **********************//
          /* valid-verified , update paypal table with verified response */

	    header("Location:".$successurl."&msg=Payment Completed Success fully ...");
	    exit;


      }
    }   // end payment status complete
}   // end VERIFIED response from paypal

else if (ereg('INVALID',$output))
{
// ********************************* FAILED Commented By PRAMOD **********************//
	    header("Location:".$failurl."&msg=Payment Failed ...");
	    exit;

}

?>