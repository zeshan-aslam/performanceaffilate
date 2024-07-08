<?php	ob_start();

   	include_once '../includes/constants.php';
   	include_once '../includes/functions.php';
   //	include_once '../includes/session.php';
    include_once '../includes/allstripslashes.php';
	  include_once '../includes/db-connect.php';
 $AFFILIATEID	= $_SESSION['AFFILIATEID'] ;
    $partners=new partners;
  	$partners->connection($host,$user,$pass,$db);

    include_once 'language_include.php';

    $mode	=	$_GET['mode'];


	//////Affiliate Login Info EDIT code
    $emailid             =	stripslashes(trim($_POST['login']));
	$password             =	stripslashes(trim($_POST['password']));
	$logininfoform             =	stripslashes(trim($_POST['logininfoform']));
	
	
	if($logininfoform == "logininfoform")
	{		
		$updateinfo_val	= " UPDATE partners_login SET login_email = '$emailid',	login_password = '$password' where login_id ='$_SESSION[AFFILIATEID]' AND login_flag='a'";
	$result_val	= mysqli_query($con,$updateinfo_val);	
	if ( false===$result_val ) {
		   header("Location:index.php?Act=Account&suc_msgInfo=fail");
			exit;
	}
	else {
		  header("Location:index.php?Act=Account&suc_msgInfo=Affiliate Login Info updated successfully");
			exit;
	}
	}
	
		


    $firstname            =	stripslashes(trim($_POST['firstnametxt']));
    $lastname             =	stripslashes(trim($_POST['lastnametxt']));
    $company              =	stripslashes(trim($_POST['companytxt']));
    $url                  =	stripslashes(trim($_POST['urltxt']));
    $address              =	stripslashes(trim($_POST['addresstxt']));
    $city                 =	stripslashes(trim($_POST['citytxt']));
    $category             =	stripslashes(trim($_POST['categorylst']));
    $phone                =	stripslashes(trim($_POST['phonetxt']));
    $fax                  =	stripslashes(trim($_POST['faxtxt']));
    $mailid               =	stripslashes(trim($_POST['emailidtxt']));
    $type                 =	stripslashes(trim($_POST['typelst']));
    $country              =	stripslashes(trim($_POST['countrylst']));
    $taxId                = stripslashes(trim($_POST['taxIdtxt']));
    $status               =	stripslashes(trim($_POST['status']));

    $today =date("Y-m-d");

    $modofpay             =	stripslashes(trim($_POST['modofpay']));
    $bankname             =	stripslashes(trim($_POST['bankname']));
    $bankno               =	stripslashes(trim($_POST['bankno']));
    $bankemail            =	stripslashes(trim($_POST['bankemail']));
    $bankaccount          =	stripslashes(trim($_POST['bankaccount']));
    $payableto            =	stripslashes(trim($_POST['payableto']));
    $minimumcheck         =	stripslashes(trim($_POST['minimumcheck']));
    $payapalemail         =	stripslashes(trim($_POST['paypalemail']));

    $stormemail           = stripslashes(trim($_POST['stormemail']));

    $payeename            = stripslashes(trim($_POST['payeename']));
    $acno                 = stripslashes(trim($_POST['acno']));
    $productid            = stripslashes(trim($_POST['productid']));
    $checkoutid           = stripslashes(trim($_POST['checkoutid']));
    $version              = stripslashes(trim($_POST['version']));
    $delimdata            = stripslashes(trim($_POST['delimdata']));
    $relayresponse        = stripslashes(trim($_POST['relayresponse']));
    $login                = stripslashes(trim($_POST['login']));
    $trankey              = stripslashes(trim($_POST['trankey']));
    $cctype               = stripslashes(trim($_POST['cctype']));

#-------------------------------------------------------------------------
# Aditional informations added
#-------------------------------------------------------------------------
    $zipcode        	= trim(stripslashes($_POST['zipcode']));
    $state              = trim(stripslashes($_POST['state']));
    $timezone        	= trim(stripslashes($_POST['timezone']));

 # Neteller account
    $neteller_email 	= trim(stripslashes($_POST['neteller_email']));
    $neteller_accnt	 	= trim(stripslashes($_POST['neteller_accnt']));

# check by Mail
    $checkpayee     	= trim(stripslashes($_POST['checkpayee']));
    $checkcurr      	= trim(stripslashes($_POST['checkcurr']));


# Wire Transfer
    $wire_AccountName   = trim(stripslashes($_POST['wire_AccountName']));
    $wire_AccountNumber = trim(stripslashes($_POST['wire_AccountNumber']));
    $wire_BankName      = trim(stripslashes($_POST['wire_BankName']));
    $wire_BankAddress   = trim(stripslashes($_POST['wire_BankAddress']));
    $wire_BankCity      = trim(stripslashes($_POST['wire_BankCity']));
    $wire_BankState     = trim(stripslashes($_POST['wire_BankState']));
    $wire_BankZip       = trim(stripslashes($_POST['wire_BankZip']));
    $wire_BankCountry   = trim(stripslashes($_POST['wire_BankCountry']));
    $wire_BankAddressNumber= trim(stripslashes($_POST['wire_BankAddressNumber']));
    $wire_Nominate      = trim(stripslashes($_POST['wire_Nominate']));
#-------------------------------------------------------------------------
# Aditional informations added Ends Here
#-------------------------------------------------------------------------

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


#-------------------------------------------------------------------------
# Aditional informations added
#-------------------------------------------------------------------------
      if(empty($zipcode) || empty($state) || ($timezone=="")){
                $err .= ".1";
      }else     $err .= ".0";

#-------------------------------------------------------------------------
# Aditional informations added Ends Here
#-------------------------------------------------------------------------


if($category=="nill" || $type=="nill" || $country=="nill")
	 $err .= ".1";
else
     $err .= ".0";


$_SESSION['AFF_ADDRESS'] = $address ;

if($err!="0.0.0.0.0.0.0.0.0") {
    $msg	=	$lang_account_blank;
    $sub	=	"submitted";
    header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
    exit;
}

switch($modofpay) {
	case 'Paypal':
	      if($partners->is_email($payapalemail)==0)
	      {
	         $msg=$lang_payerr;
	         header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	         exit;
	      }
	      break;

	case 'Stormpay':
	      if($partners->is_email($stormemail)==0)
	      {
	         $msg=$lang_stormerr;
	         header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	         exit;
	      }
	      break;

	case 'E-Gold':
	      if((empty($payeename)) ||  (empty($acno)))
	      {
	         $msg=$lang_egolderr;
	         header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	         exit;
	      }
	      break;

	case 'Authorize.net':
	       if(empty($version) ||     (empty($login)) ||  (empty($trankey) ))
	       {
	         $msg=$lang_autherr;
	         header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	         exit;
	       }
	      break;

	case '2checkout':
	      if((empty($checkoutid)) ||  (empty($productid)))
	      {
	         $msg=$lang_chkerr;
	         header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	         exit;
	      }
	      break;

    case 'CheckByMail':
	
	 $sql2="UPDATE `partners_bankinfo` SET
	`bankinfo_modeofpay` = '$modofpay',
	`bankinfo_paypalemail` = '$payapalemail',
	`bankinfo_stormemail` = '$stormemail',
	`bankinfo_payeename` = '$payeename',
	`bankinfo_acno` = '$acno',
	`bankinfo_checkoutid` = '$checkoutid',
	`bankinfo_productid` = '$productid',
	`bankinfo_version` = '$version',
	`bankinfo_delimdata` = '$delimdata',
	`bankinfo_relayresponse` = '$relayresponse',
	`bankinfo_login` = '$login',
	`bankinfo_trankey` = '$trankey',
	`bankinfo_cctype` = '$cctype',
      `bankinfo_neteller_email` = '$neteller_email',
	`bankinfo_neteller_accnt` = '$neteller_accnt',
	`bankinfo_checkpayee` = '$checkpayee',
	`bankinfo_checkcurr` = '$checkcurr',
	`bankinfo_wire_AccountName` = '$wire_AccountName',
	`bankinfo_wire_AccountNumber` = '$wire_AccountNumber',
	`bankinfo_wire_BankName` = '$wire_BankName',
	`bankinfo_wire_BankAddress` = '$wire_BankAddress',
	`bankinfo_wire_BankCity` = '$wire_BankCity',
	`bankinfo_wire_BankState` = '$wire_BankState',
	`bankinfo_wire_BankZip` = '$wire_BankZip',
	`bankinfo_wire_BankCountry` = '$wire_BankCountry',
	`bankinfo_wire_BankAddressNumber` = '$wire_BankAddressNumber',
	`bankinfo_wire_Nominate` = '$wire_Nominate'
     WHERE 	`bankinfo_affiliateid` = '$AFFILIATEID' ";
	 $result = mysqli_query($con,$sql2);
      	 if((empty($checkpayee)) ||  (empty($checkcurr))) {
          	$msg=$lang_checkerr;
             header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	         exit;
       	}
       	break;

     case "NETeller":
         if($partners->is_email($neteller_email)==0){
             $msg = $lang_netellererr;
             header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	         exit;
         }
        if((empty($neteller_accnt))) {
            $msg=$lang_checkerr;
            header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	        exit;
         }
       break;

     case "WireTransfer":
	 $sql2="UPDATE `partners_bankinfo` SET
	`bankinfo_modeofpay` = '$modofpay',
	`bankinfo_paypalemail` = '$payapalemail',
	`bankinfo_stormemail` = '$stormemail',
	`bankinfo_payeename` = '$payeename',
	`bankinfo_acno` = '$acno',
	`bankinfo_checkoutid` = '$checkoutid',
	`bankinfo_productid` = '$productid',
	`bankinfo_version` = '$version',
	`bankinfo_delimdata` = '$delimdata',
	`bankinfo_relayresponse` = '$relayresponse',
	`bankinfo_login` = '$login',
	`bankinfo_trankey` = '$trankey',
	`bankinfo_cctype` = '$cctype',
    `bankinfo_neteller_email` = '$neteller_email',
	`bankinfo_neteller_accnt` = '$neteller_accnt',
	`bankinfo_checkpayee` = '$checkpayee',
	`bankinfo_checkcurr` = '$checkcurr',
	`bankinfo_wire_AccountName` = '$wire_AccountName',
	`bankinfo_wire_AccountNumber` = '$wire_AccountNumber',
	`bankinfo_wire_BankName` = '$wire_BankName',
	`bankinfo_wire_BankAddress` = '$wire_BankAddress',
	`bankinfo_wire_BankCity` = '$wire_BankCity',
	`bankinfo_wire_BankState` = '$wire_BankState',
	`bankinfo_wire_BankZip` = '$wire_BankZip',
	`bankinfo_wire_BankCountry` = '$wire_BankCountry',
	`bankinfo_wire_BankAddressNumber` = '$wire_BankAddressNumber',
	`bankinfo_wire_Nominate` = '$wire_Nominate'
     WHERE 	`bankinfo_affiliateid` = '$AFFILIATEID' ";
	 $result = mysqli_query($con,$sql2);
        if((empty($wire_AccountName)) ||  (empty($wire_AccountNumber)) ||  (empty($wire_BankName)) ||  (empty($wire_BankAddress)) ||  (empty($wire_BankCity)) ||  (empty($wire_BankState)) ||  (empty($wire_BankZip)) ||  (empty($wire_BankCountry)) ||  (empty($wire_BankAddressNumber)) ||  (empty($wire_Nominate))) {
           $msg=$lang_checkerr;
           header("Location:index.php?Act=Account&msg=$msg&firstname=$firstname&lastname=$lastname&company=$company&url=$url&city=$city&category=$category&phone=$phone&fax=$fax&mailid=$mailid&type=$type&country=$country&sub=$sub&modofpay=$modofpay&minimumcheck=$minimumcheck&bankemail=$bankemail&bankno=$bankno&bankname=$bankname&payableto=$payableto&bankaccount=$bankaccount&zipcode=$zipcode&state=$state&timezone=$timezone&taxIdtxt=$taxId");
	       exit;
       }
}

    $firstname            =	addslashes(trim($_POST['firstnametxt']));
    $lastname             =	addslashes(trim($_POST['lastnametxt']));
    $company              =	addslashes(trim($_POST['companytxt']));
    $url                  =	addslashes(trim($_POST['urltxt']));
    $address              =	addslashes(trim($_POST['addresstxt']));
    $city                 =	addslashes(trim($_POST['citytxt']));
    $category             =	addslashes(trim($_POST['categorylst']));
    $phone                =	addslashes(trim($_POST['phonetxt']));
    $fax                  =	addslashes(trim($_POST['faxtxt']));
    $mailid               =	addslashes(trim($_POST['emailidtxt']));
    $type                 =	addslashes(trim($_POST['typelst']));
    $country              =	addslashes(trim($_POST['countrylst']));

    $status               =	addslashes(trim($_POST['status']));

    $today =date("Y-m-d");

    $modofpay             =	addslashes(trim($_POST['modofpay']));
    $bankname             =	addslashes(trim($_POST['bankname']));
    $bankno               =	addslashes(trim($_POST['bankno']));
    $bankemail            =	addslashes(trim($_POST['bankemail']));
    $bankaccount          =	addslashes(trim($_POST['bankaccount']));
    $payableto            =	addslashes(trim($_POST['payableto']));
    $minimumcheck         =	addslashes(trim($_POST['minimumcheck']));
    $payapalemail         =	addslashes(trim($_POST['paypalemail']));

    $stormemail           = addslashes(trim($_POST['stormemail']));

    $payeename            = addslashes(trim($_POST['payeename']));
    $acno                 = addslashes(trim($_POST['acno']));
    $productid            = addslashes(trim($_POST['productid']));
    $checkoutid           = addslashes(trim($_POST['checkoutid']));
    $version              = addslashes(trim($_POST['version']));
    $delimdata            = addslashes(trim($_POST['delimdata']));
    $relayresponse        = addslashes(trim($_POST['relayresponse']));
    $login                = addslashes(trim($_POST['login']));
    $trankey              = addslashes(trim($_POST['trankey']));
    $cctype               = addslashes(trim($_POST['cctype']));
    $taxId            	  = addslashes(trim($_POST['taxIdtxt']));
     #-------------------------------------------------------------------------
     # Aditional informations added
     #-------------------------------------------------------------------------
             $zipcode        = trim(addslashes($_POST['zipcode']));
             $state          = trim(addslashes($_POST['state']));
             $timezone       = trim(addslashes($_POST['timezone']));

    # Neteller account
   	   		$neteller_email     = trim(addslashes($_POST['neteller_email']));
	        $neteller_accnt     = trim(addslashes($_POST['neteller_accnt']));

 	# check by Mail
    		$checkpayee     	= trim(addslashes($_POST['checkpayee']));
    		$checkcurr      	= trim(addslashes($_POST['checkcurr']));

	# Wire Transfer
    		$wire_AccountName   = trim(addslashes($_POST['wire_AccountName']));
    		$wire_AccountNumber = trim(addslashes($_POST['wire_AccountNumber']));
    		$wire_BankName      = trim(addslashes($_POST['wire_BankName']));
    		$wire_BankAddress   = trim(addslashes($_POST['wire_BankAddress']));
    		$wire_BankCity      = trim(addslashes($_POST['wire_BankCity']));
    		$wire_BankState     = trim(addslashes($_POST['wire_BankState']));
    		$wire_BankZip       = trim(addslashes($_POST['wire_BankZip']));
    		$wire_BankCountry   = trim(addslashes($_POST['wire_BankCountry']));
    		$wire_BankAddressNumber= trim(addslashes($_POST['wire_BankAddressNumber']));
    		$wire_Nominate      = trim(addslashes($_POST['wire_Nominate']));
     #-------------------------------------------------------------------------
     # Aditional informations added Ends Here
     #-------------------------------------------------------------------------

$sql1="UPDATE `partners_affiliate` SET
	`affiliate_firstname` = '$firstname',
	`affiliate_lastname` = '$lastname',
	`affiliate_company` = '$company',
	`affiliate_address` = '$address',
	`affiliate_city` = '$city',
	`affiliate_country` = '$country',
	`affiliate_url` = '$url',
	`affiliate_category` = '$category',
	`affiliate_fax` = '$fax',
	`affiliate_state` = '$state',
	`affiliate_zipcode` = '$zipcode',
	`affiliate_timezone` = '$timezone',
    `affiliate_taxId` = '$taxId',
	`affiliate_phone` = '$phone' WHERE `affiliate_id` = '$AFFILIATEID' ";





 $result = mysqli_query($con,$sql1);
 

 $msg	 = $lang_account_success        ;
 $sub	 = "submitted";
  $firstname            =	stripslashes(trim($_POST['firstnametxt']));
    $lastname             =	stripslashes(trim($_POST['lastnametxt']));
    $company              =	stripslashes(trim($_POST['companytxt']));
    $url                  =	stripslashes(trim($_POST['urltxt']));
    $address              =	stripslashes(trim($_POST['addresstxt']));
    $city                 =	stripslashes(trim($_POST['citytxt']));
    $category             =	stripslashes(trim($_POST['categorylst']));
    $phone                =	stripslashes(trim($_POST['phonetxt']));
    $fax                  =	stripslashes(trim($_POST['faxtxt']));
    $mailid               =	stripslashes(trim($_POST['emailidtxt']));
    $type                 =	stripslashes(trim($_POST['typelst']));
    $country              =	stripslashes(trim($_POST['countrylst']));
     $taxId               = stripslashes(trim($_POST['taxIdtxt']));
    $status               =	stripslashes(trim($_POST['status']));

    $today =date("Y-m-d");

    $modofpay             =	stripslashes(trim($_POST['modofpay']));
    $bankname             =	stripslashes(trim($_POST['bankname']));
    $bankno               =	stripslashes(trim($_POST['bankno']));
    $bankemail            =	stripslashes(trim($_POST['bankemail']));
    $bankaccount          =	stripslashes(trim($_POST['bankaccount']));
    $payableto            =	stripslashes(trim($_POST['payableto']));
    $minimumcheck         =	stripslashes(trim($_POST['minimumcheck']));
    $payapalemail         =	stripslashes(trim($_POST['paypalemail']));

    $stormemail           = stripslashes(trim($_POST['stormemail']));

    $payeename            = stripslashes(trim($_POST['payeename']));
    $acno                 = stripslashes(trim($_POST['acno']));
    $productid            = stripslashes(trim($_POST['productid']));
    $checkoutid           = stripslashes(trim($_POST['checkoutid']));
    $version              = stripslashes(trim($_POST['version']));
    $delimdata            = stripslashes(trim($_POST['delimdata']));
    $relayresponse        = stripslashes(trim($_POST['relayresponse']));
    $login                = stripslashes(trim($_POST['login']));
    $trankey              = stripslashes(trim($_POST['trankey']));
    $cctype               = stripslashes(trim($_POST['cctype']));

#-------------------------------------------------------------------------
# Aditional informations added
#-------------------------------------------------------------------------
    $zipcode        	= trim(stripslashes($_POST['zipcode']));
    $state              = trim(stripslashes($_POST['state']));
    $timezone        	= trim(stripslashes($_POST['timezone']));

 # Neteller account
    $neteller_email 	= trim(stripslashes($_POST['neteller_email']));
    $neteller_accnt	 	= trim(stripslashes($_POST['neteller_accnt']));

# check by Mail
    $checkpayee     	= trim(stripslashes($_POST['checkpayee']));
    $checkcurr      	= trim(stripslashes($_POST['checkcurr']));


# Wire Transfer
    $wire_AccountName   = trim(stripslashes($_POST['wire_AccountName']));
    $wire_AccountNumber = trim(stripslashes($_POST['wire_AccountNumber']));
    $wire_BankName      = trim(stripslashes($_POST['wire_BankName']));
    $wire_BankAddress   = trim(stripslashes($_POST['wire_BankAddress']));
    $wire_BankCity      = trim(stripslashes($_POST['wire_BankCity']));
    $wire_BankState     = trim(stripslashes($_POST['wire_BankState']));
    $wire_BankZip       = trim(stripslashes($_POST['wire_BankZip']));
    $wire_BankCountry   = trim(stripslashes($_POST['wire_BankCountry']));
    $wire_BankAddressNumber= trim(stripslashes($_POST['wire_BankAddressNumber']));
    $wire_Nominate      = trim(stripslashes($_POST['wire_Nominate']));
	
	$_SESSION['AFF_ADDRESS'] = "";
	
 header("Location:index.php?Act=Account&suc_msg=$msg");
 exit;

?>