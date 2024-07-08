<?php		
  
   include_once '../includes/db-connect.php';
   include_once '../includes/constants.php';
   include_once '../includes/functions.php';
   include_once '../includes/session.php';
   include_once '../includes/allstripslashes.php';


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';


            $modofpay         = trim($_POST['modofpay']);
            $bankno           = trim($_POST['bankno']);
            $bankname         = trim($_POST['bankname']);
            $bankemail        = trim($_POST['bankemail']);
            $bankaccount      = trim($_POST['bankaccount']);
            $payableto        = trim($_POST['payableto']);
            $minimumcheck     = trim($_POST['minimumcheck']);
            $affiliateid      = trim($_POST['affiliateid']);
            $payapalemail     = trim($_POST['payapalemail']);
            $stormemail       = trim($_POST['stormemail']);

       //echo $modofpay;

            $payeename         		= trim($_POST['payeename']);
            $acno              		= trim($_POST['acno']);
            $productid        		= trim($_POST['productid']);
            $checkoutid       		= trim($_POST['checkoutid']);
            $version				= trim($_POST['version']);
			$delimdata 				= trim($_POST['delimdata']);
			$relayresponse	  		= trim($_POST['relayresponse']);
			$login 					= trim($_POST['login']);
			$trankey 				= trim($_POST['trankey']);
			$cctype	 	  			= trim($_POST['cctype']);
			$amount					= trim($_POST['amount']);
            $currValue              = $_POST['currValue'];



            //get id (in the case of editing)
            $id						= intval($_POST['id']);
            if(!empty($id))
            {

	            if($amount=="" or $amount<=0)
	            {
	                            $msg    =   "Please Enter A valid amount";
	                            header("Location:index.php?Act=add_money&msg=$msg&modofpay=$modofpay&amount=$amount&id=$id");
	                            exit;
	            }

                $date	   = date("Y-m-d");
                if($currValue != $default_currency_caption)
	                $amount  = getDefaultCurrencyValue($date, $currValue, $amount);
                //update new amount
            	mysqli_query($con,"UPDATE partners_addmoney SET addmoney_amount = '".$amount."' WHERE addmoney_id = '".$id."'");

                //direct back to listing page
                header("location:index.php?Act=add_money");
                exit;
            }

           // echo $amount."dfssfsd";

          $payment_method	=	$modofpay;


            /*switch($modofpay)
            {
              case 'paypal':
                          if($partners->is_email($payapalemail)==0)
                          {
                             $msg=$lang_payerr;
                             header("Location:index.php?Act=add_money&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&payapalemail=$payapalemail");
                             exit;
                          }
                          break;
              case 'stormpay':
                          if($partners->is_email($stormemail)==0)
                          {
                             $msg=$lang_stormerr;
                             header("Location:index.php?Act=add_money&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&stormemail=$stormemail");
                             exit;
                          }
                          break;
              case 'E-Gold':
                          if((empty($payeename)) ||  (empty($acno)))
                          {
                             $msg=$lang_egolderr;
                             header("Location:index.php?Act=add_money&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid&payeename=$payeename&acno=$acno");
                             exit;
                          }
                          break;
              case 'Authorize.net':
                           if(empty($version) ||     (empty($login)) ||  (empty($trankey) ))
                           {
                             $msg=$lang_autherr;
                             header("Location:index.php?Act=add_money&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid");
                             exit;
                           }
                          break;
              case '2checkout':
                          if((empty($checkoutid)) ||  (empty($productid)))
                          {
                             $msg=$lang_chkerr;
                             header("Location:index.php?Act=add_money&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateidcheckoutid=$checkoutid&productid=$productid")
                             ;
                             exit;
                          }
                          break;
            }*/


            if($amount=="" or $amount<=0)
            {
            				$msg	=	"Please Enter A valid amount";
                            header("Location:index.php?Act=add_money&msg=$msg&modofpay=$modofpay&bankname=$bankname&bankno=$bankno&bankemail=$bankemail&bankaccount=$bankaccount&payableto=$payableto&minimumcheck=$minimumcheck&affiliateid=$affiliateid");
                            exit;
            }

            $date	   = date("Y-m-d");

            if($currValue != $default_currency_caption){
                $amount  = getDefaultCurrencyValue($date, $currValue, $amount);
            }


            

/*          Header("Location:add_money_success.php?amount=$amount");
            exit;

        $mydomain   =   "http://".$_SERVER['SERVER_NAME'];
        $successurl =   $track_site_url."/merchants/add_money_success.php?amount=$amount";
        $failurl    =   $track_site_url."/merchants/index.php?Act=add_money";*/


        include_once "togateway.php";





?>