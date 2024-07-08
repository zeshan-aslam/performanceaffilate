<?php
  include_once 'includes/db-connect.php';
# secutry
     $amount           = round($amount,2);
	include_once "random_tableinsert.php";
   //	Header("Location:pay_paymentsuccess.php?curid=$curid&amount=$amount&secid=$secid&secpass=$secpass");
  	//exit;

    $Errmsg = $pay_fail;
    if($payment_method=="Paypal") {

        $sql    = "SELECT * FROM `partners_paypal` ";
        $res    = mysqli_query($con,$sql);

        while ($row=mysqli_fetch_object($res)) {
              $paypal_email     =   stripslashes(trim($row->paypal_email ));
        }

        $paypalid   =   $paypal_email;
        $grandtotal =   $amount;


        $mydomain   =   "http://".$_SERVER['SERVER_NAME'];
        $successurl =   $track_site_url."/pay_paymentsuccess.php?type=$type&curid=$curid&amount=$amount&secid=$secid&secpass=$secpass";
        $failurl    =   $track_site_url."/index.php?Act=Payment&id=$curid&Errmsg=$Errmsg";
        $notifyurl  =   $track_site_url."/ipn_notify.php";

?>

         <!--*******************************************************PAYPAL FORM*********************************************-->
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypal" id="paypal">
             <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
             <input type="hidden" name="cmd" value="_xclick">
        	 <input type="hidden" name="business" value="<?=$paypalid?>">
	         <input type="hidden" name="item_name" value="Registration Fee Amount Will Be Deposited to Your System Account">
	         <input type="hidden" name="amount" value="<?=$grandtotal?>">
	         <input type="hidden" name="currency_code" value="USD">
	         <input type="hidden" name="return" value="<?=$successurl?>">
	         <input type="hidden" name="notify_url" value="<?=$notifyurl?>">
	         <input name="successurl" type="hidden" value="<?=$successurl?>">
	         <input name="failurl"  type="hidden" value="<?=$failurl?>">
          </form>

         <script>
                document.paypal.submit();
         </script>

  		<!-- ********************************************* pay pal info ENDS HERE*********************** -->

 <?
  }


  if($payment_method=="Stormpay")  {

	$stormpayid   =  $stormpayurl;
	$grandtotal   =  $amount;

	$sql  = "SELECT * FROM `partners_stormpay`";
	$res  = mysqli_query($con,$sql);

	while ($row=mysqli_fetch_object($res)){
		 $storm_email      =        stripslashes(trim($row->storm_email  ));
    }

	$mydomain   ="http://".$_SERVER['SERVER_NAME'];
    $successurl =   $track_site_url."/pay_paymentsuccess.php?type=$type&curid=$curid&amount=$amount&secid=$secid&secpass=$secpass";
    $failurl    =   $track_site_url."/index.php?Act=Payment&id=$curid&Errmsg=$Errmsg";


	$stormpayid = $storm_email;
	$grandtotal = $amount;

?>

        <form method="post" action="https://www.stormpay.com/stormpay/handle_gen.php" target="_blank" name="stormpay">
          <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
              <input type=hidden name=generic value="1">
              <input type=hidden name=payee_email value="<?=$stormpayid?>">
              <input type=hidden name=product_name value="ANP">
              <input type=hidden name=category value="test">
              <input type=hidden name=description value="Registration Fee">
              <input type=hidden name=amount value="<?=$grandtotal?>">
              <input type=hidden name=quantity value="1">
              <input type=hidden name=tax value="0">
              <input type=hidden name=shipping value="0">
              <input type=hidden name=require_IPN value="0">
              <input type=hidden name=return_URL value="<?=$successurl?>">
              <input type=hidden name=cancel_URL value="<?=$failurl?>">
              <input type=hidden name=subject_matter value="nothing">
             <!-- <input type=image src="https://www.stormpay.com/stormpay/images/BuyWithSP1.gif"> -->
            </form>
            <script>
                  document.stormpay.submit();
           </script>

<?

   }
   if($payment_method=="E-Gold") {

	    $mydomain   = "http://".$_SERVER['SERVER_NAME'];
        $successurl =   $track_site_url."/pay_paymentsuccess.php?type=$type&curid=$curid&amount=$amount&secid=$secid&secpass=$secpass";
        $failurl    =   $track_site_url."/index.php?Act=Payment&id=$curid&Errmsg=$Errmsg";

	    $sql       = "SELECT * FROM `partners_egold";
	    $res       = mysqli_query($con,$sql);

	    while ($row=mysqli_fetch_object($res)){
	      $egold_payeename   = stripslashes(trim($row->egold_payeename   ));
        }

	    $stormpayid   =        $egold_payeename;
	    $grandtotal   =   $amount;
?>

      <form action="https://www.e-gold.com/sci_asp/payments.asp" method="POST" target=_top name="egold">
          <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
            <input type="hidden" name="PAYEE_ACCOUNT" value="100998">
            <input type="hidden" name="PAYEE_NAME" value="<?=$stormpayid?>">
            <input type="hidden" name="PAYMENT_AMOUNT" size=4 value="<?=$grandtotal?>">
            <input type="hidden" name="PAYMENT_UNITS" value=1>
            <input type="hidden" name="PAYMENT_METAL_ID" value=1>
            <input type="hidden" name="STATUS_URL" value="mailto:sci@e-gold.com">
            <input type="hidden" name="NOPAYMENT_URL" value="<?=$failurl?>">
            <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK">
            <input type="hidden" name="PAYMENT_URL"  value="<?=$successurl?>">
            <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK">
            <input type="hidden" name="BAGGAGE_FIELDS" value="CUSTOMERID">
            <input type="hidden" name="CUSTOMERID" value="0">
            <input type="hidden" name="SUGGESTED_MEMO" value='Thank You'>
            </form>
	        <script>
            	document.egold.submit();
	        </script>
<?
  }
  if($payment_method=="Authorize.net")   {

            $mydomain   = "http://".$_SERVER['SERVER_NAME'];
            $successurl =   $track_site_url."/pay_paymentsuccess.php?type=$type&curid=$curid&amount=$amount&secid=$secid&secpass=$secpass";
            $failurl    =   $track_site_url."/index.php?Act=Payment&id=$curid&Errmsg=$Errmsg";

            $sql        = "SELECT * FROM `partners_creditcard` ";
            $res        = mysqli_query($con,$sql);

            while ($row=mysqli_fetch_object($res))   {

	        $version         =        stripslashes(trim($row->cc_version ));
	        $delimdata       =        stripslashes(trim($row->cc_delimdata));
	        $relayresponse   =        stripslashes(trim($row->cc_relayresponse));
	        $login           =        stripslashes(trim($row->cc_login));

	        $trankey         =        stripslashes(trim($row->cc_trankey));
	        $type            =        stripslashes(trim($row->cc_type));
            }
?>
         <form action="<?=$secured_site_url?>/partnerssecured/merchantcard.php" method="POST" target=_top name="ath">
         <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
           <input type="hidden" name="version" value="<?=$version?>">
           <input type="hidden" name="delimdata" value="<?=$delimdata?>">
           <input type="hidden" name="relayresponse" value="<?=$relayresponse?>">
           <input type="hidden" name="login" value="<?=$login?>">
           <input type="hidden" name="trankey" value="<?=$trankey?>">
           <input type="hidden" name="cctype" value="<?=$cctype?>">
           <input type="hidden" name="amount" value="<?=$amount?>">
           <input type="hidden" name="surl" value="<?=$successurl?>">
          <input type="hidden" name="furl" value="<?=$failurl?>">
       </form>
       <script>
           document.ath.submit();
       </script>
<?
    }

 if($payment_method=="WorldPay")
   {

       $mydomain   = "http://".$_SERVER['SERVER_NAME'];
       $successurl = $track_site_url."/return_world_np.php?type=$type&curid=$curid&amount=$amount&secid=$secid&secpass=$secpass";
       $failurl    = $track_site_url."/index.php?Act=Payment&id=$curid&Errmsg=$Errmsg";

       $sql        = "SELECT * FROM `partners_worldpay` ";
       $res        = mysqli_query($con,$sql);

        while ($row=mysqli_fetch_object($res))
        {

              $accno  =  stripslashes(trim($row->worldpay_accno));

        }
?>

        <FORM ACTION="https://select.worldpay.com/wcc/purchase" METHOD="POST" name="worldpay">
         <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
        <INPUT TYPE=HIDDEN NAME=cartId VALUE="Merchant Payment">
		<INPUT TYPE=HIDDEN NAME=instId VALUE=<?=$accno?>>
		<INPUT TYPE=HIDDEN NAME=currency VALUE="USD">
		<INPUT TYPE=HIDDEN NAME=amount VALUE="<?=$amount?>">
        <INPUT TYPE=HIDDEN NAME="MC_callback" VALUE="<?=$successurl?>">
         </form>
        <script>
                  document.worldpay.submit();
        </script>

<?
 }
?>