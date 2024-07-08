<?php	ob_start();

		include_once '../includes/constants.php';
		include_once '../includes/functions.php';
		include_once '../includes/session.php';
		include_once '../includes/allstripslashes.php';
		
		$partners=new partners;
		$partners->connection($host,$user,$pass,$db);
		include_once 'language_include.php';
		
		
		
	    $mode				= $_GET['mode'];

	    $firstname        	= $_POST['firstnametxt'];
	    $lastname       	= $_POST['lastnametxt'];
	    $company        	= $_POST['companytxt'];
	    $url                = $_POST['urltxt'];
	    $address        	= $_POST['addresstxt'];
	    $city               = $_POST['citytxt'];
	    $category        	= $_POST['categorylst'];
	    $phone              = $_POST['phonetxt'];
	    $fax                = $_POST['faxtxt'];
	    $mailid             = $_POST['emailidtxt'];
	    $type       		= $_POST['typelst'];
	    $country        	= $_POST['countrylst'];
        $state              = stripslashes(trim($_POST['statetxt']));
	    $zip	            = stripslashes(trim($_POST['ziptxt']));
	    $taxId              = stripslashes(trim($_POST['taxIdtxt']));
	    $status           	= $_POST['status'];

	    $today =date("Y-m-d");


        if($_POST["Upgrade"])
		{
			// UPgrading
			
			$id 	= $_SESSION['MERCHANTID'];
				//Added By DPT on July/10/05
				//If advanced amount is 0 then the user need not be taken to the payment gateway
				if($advanced_user==0)
				{
					//update user account status
					$sql        = "UPDATE `partners_merchant` SET merchant_type='advance' where `merchant_id` = '$id'";
					mysqli_query($con,$sql);
					$msg1	="Upgraded Successfully";
					header("Location:index.php?Act=accounts&msg1=$msg1");
					exit;
				}
				else
				{
					
					$amount	=$advanced_user - $normal_user;
					Header("Location:index.php?Act=upgrade&id=$id&amount=$amount");
					exit;
				}
		}


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


if($category=="nill" || $type=="nill" || $country=="nill")

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


	$_SESSION['MER_ADDRESS'] = $address;

     if($err!="0.0.0.0.0.0.0.0.0.0.0.0")
        {

        $msg=$lang_invalid;
           // $_SESSION['MERADD']=$address;
                   $sub="submitted";


        $firstname        = stripslashes(trim($_POST['firstnametxt']));
        $lastname         = stripslashes(trim($_POST['lastnametxt']));
        $company          = stripslashes(trim($_POST['companytxt']));
        $url              = stripslashes(trim($_POST['urltxt']));
        $address          = urlencode(stripslashes(trim($_POST['addresstxt'])));
        $city             = stripslashes(trim($_POST['citytxt']));
        $category         = stripslashes(trim($_POST['categorylst']));
        $phone            = stripslashes(trim($_POST['phonetxt']));
        $fax              = stripslashes(trim($_POST['faxtxt']));
        $mailid           = stripslashes(trim($_POST['mailidtxt']));
        $type             = stripslashes(trim($_POST['typelst']));
        $state            = stripslashes(trim($_POST['statetxt']));
        $zip              = stripslashes(trim($_POST['ziptxt']));
        $taxId            = stripslashes(trim($_POST['taxIdtxt']));




        header("Location:index.php?Act=accounts&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&state=$state&zip=$zip&taxId=$taxId&sub=$sub");
                        exit;
        }


		$firstname        = addslashes(trim($_POST['firstnametxt']));
		$lastname         = addslashes(trim($_POST['lastnametxt']));
		$company          = addslashes(trim($_POST['companytxt']));
		$url              = addslashes(trim($_POST['urltxt']));
		$address          = addslashes(trim($_POST['addresstxt']));
		$city             = addslashes(trim($_POST['citytxt']));
		$category         = addslashes(trim($_POST['categorylst']));
		$phone            = addslashes(trim($_POST['phonetxt']));
		$fax              = addslashes(trim($_POST['faxtxt']));
		$mailid           = addslashes(trim($_POST['mailidtxt']));
		$type             = addslashes(trim($_POST['typelst']));
		$state            = addslashes(trim($_POST['statetxt']));
		$zip              = addslashes(trim($_POST['ziptxt']));
		$taxId            = addslashes(trim($_POST['taxIdtxt']));


   $sql1="UPDATE `partners_merchant` SET `merchant_firstname` = '$firstname',
          `merchant_lastname` = '$lastname',
          `merchant_company` = '$company',
          `merchant_address` = '$address',
          `merchant_city` = '$city',
          `merchant_country` = '$country',
          `merchant_phone` = '$phone',
          `merchant_url` = '$url',
          `merchant_category` = '$category',
          `merchant_date` = '$today',
          `merchant_fax` = '$fax',
          `merchant_state` = '$state',
          `merchant_zip` = '$zip',
          `merchant_taxId` = '$taxId',
          `merchant_type` = '$type' WHERE `merchant_id` = '$MERCHANTID'";
          $result = mysqli_query($con,$sql1);
          echo mysqli_error($con);
          $msg= $lang_success_message ;


    $firstname        = stripslashes(trim($_POST['firstnametxt']));
    $lastname         = stripslashes(trim($_POST['lastnametxt']));
    $company          = stripslashes(trim($_POST['companytxt']));
    $url              = stripslashes(trim($_POST['urltxt']));
    $address          = urlencode(stripslashes(trim($_POST['addresstxt'])));
    $city             = stripslashes(trim($_POST['citytxt']));
    $category         = stripslashes(trim($_POST['categorylst']));
    $phone            = stripslashes(trim($_POST['phonetxt']));
    $fax              = stripslashes(trim($_POST['faxtxt']));
    $mailid           = stripslashes(trim($_POST['mailidtxt']));
    $type             = stripslashes(trim($_POST['typelst']));
    $state            = stripslashes(trim($_POST['statetxt']));
    $zip              = stripslashes(trim($_POST['ziptxt']));
    $taxId            = stripslashes(trim($_POST['taxIdtxt']));

    $sub="submitted";
	$_SESSION['MER_ADDRESS'] = "";
	
    header("Location:index.php?Act=accounts&suc_msg=$msg");
    exit;

?>