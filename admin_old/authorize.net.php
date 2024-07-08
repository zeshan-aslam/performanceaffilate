<?php
   //----------------------------------------------------------------//
    $credit 	=$_GET['cardno'];
	$expiry		=$_GET['cardexp'];
	$grandtotal	=$_GET['grandtotal'];

	//finding details from date_creditcard table
		$sql 		= "SELECT * FROM `partners_bankinfo where bankinfo_affiliateid='$affiliateid'` ";
		$retgate 	= mysql_query($sql);
		if (mysql_num_rows($retgate)>0)
		{
			$rowgate 	= mysql_fetch_object($retgate);

			$version 	= stripslashes($rowgate->bankinfo_version);
			$delim		= stripslashes($rowgate->bankinfo_delimdata);
			$relay		= stripslashes($rowgate->bankinfo_relayresponse);
			$mylogin	= stripslashes($rowgate->bankinfo_login);
			$trankey	= stripslashes($rowgate->bankinfo_trankey);
			$ttype		= stripslashes($rowgate->bankinfo_type);
		}
      //---------------//

      echo mysql_error();

    //  echo $version;


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

		switch ($details)
		{
		    case "1": // Credit Card Successfully Charged
        	   	header ("Location:payment_success.php");

	        break;

    		default: // Credit Card Not Successfully Charged
                   //	header ("Location:payment_success.php?userid=$userid&id=$curid&stat=success");
                header ("Location:payment_fail.php");
        	break;
       }
?>