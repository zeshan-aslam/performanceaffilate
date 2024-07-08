<?php


    foreach ($_POST as $key => $value)//to stripslash all posted variables
            {

          $value=trim($value);
          $value=stripslashes($value);
          $$key=$value;

        //  echo "$key=>$value <br/>";
        }

        // exit;


   //----------------------------------------------------------------//

    $credit 	=$creditcardno;
	$expiry		=$expirydate;
	$grandtotal	=$amount;



			$version 	= $version;
			$delim		= $delimdata;
			$relay		= $relayresponse;
			$mylogin	= $login;
			$trankey	= $trankey;
			$ttype		= $type;




	  	$fields="x_Version=$version&x_Login=$mylogin&x_Delim_Data=$delim&x_Delim_Char=,";
	  	$fields.="&x_Type=$ttype&x_Amount=$grandtotal";
		$fields.="&x_Card_Num=$credit&x_Exp_Date=$expiry&x_ADC_Relay_Response=$relay";

      //  echo $fields;

		#
		# Start CURL session
		#
		$agent  = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";

        $domain = "http://".$_SERVER['SERVER_NAME'];

//		$ref = "https://www.mydomainname.com/ccprocess.php"; // Replace this URL with the URL of this script
		$ref = $domain."authorize.net.php";
		//echo $ref."<br/>";
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://secure.authorize.net/gateway/transact.dll");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_NOPROGRESS, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_REFERER, $ref);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$buffer = curl_exec($ch);
		curl_close($ch);

		$details = substr($buffer, 0, 1);


       // echo  	$details."message <br/> ";
      //  echo 	$surl	."surl <br/>";
      //  echo 	$furl	."furl<br/>";


		switch ($details)
		{
		    case "1": // Credit Card Successfully Charged
        	   	header ("Location:$sul");

	        break;

    		default: // Credit Card Not Successfully Charged
                   //	header ("Location:payment_success.php?userid=$userid&id=$curid&stat=success");
                header ("Location:$furl&msg=Card Validation Failed Please Try Again");
        	break;
       }
?>