<?
# Random identifieer
	include_once "../random_tableinsert.php";

   //Header("Location:newpayment_success.php?affiliateid=$affiliateid&request_id=$request_id&amount=$amount&secid=$secid&secpass=$secpass");
   // exit;

   #-------------------------------------------------------------------------------
   # getting default currency
   #-------------------------------------------------------------------------------
   	 /*	$dftsql =  "SELECT currency_code FROM partners_currency WHERE currency_default = 'yes' ";
   		$dftret = @mysql_query($dftsql);

   		if(mysql_num_rows($dftret)>0){
      		$dftrow           = @mysql_fetch_object($dftret);            $
      		$currency_code    = trim(stripslashes($dftrow->currency_code));
  		}
       */
      $currency_code    = "USD";
      $amount           = round($amount,2);
   #-------------------------------------------------------------------------------
   #  getting affilaite money details
   #-------------------------------------------------------------------------------
   $sql       = "SELECT * FROM `partners_bankinfo` where bankinfo_affiliateid = '$affiliateid'";
   $res       = @mysql_query($sql);
   while ($row=@mysql_fetch_object($res))
   {
    $payment_method              =   stripslashes(trim($row->bankinfo_modeofpay));
    # paypal
    $bankinfo_paypalemail        =   stripslashes(trim($row->bankinfo_paypalemail));
    #stormpay
    $bankinfo_stormemail         =   stripslashes(trim($row->bankinfo_stormemail));
    $bankinfo_payeename          =   stripslashes(trim($row->bankinfo_payeename));
    $bankinfo_acno               =   stripslashes(trim($row->bankinfo_acno));
    $bankinfo_checkoutid         =   stripslashes(trim($row->bankinfo_checkoutid));
    $bankinfo_productid          =   stripslashes(trim($row->bankinfo_productid));
    # autheroze.net
    $version              =   stripslashes(trim($row->bankinfo_version));
    $delimdata            =   stripslashes(trim($row->bankinfo_delimdata));
    $relayresponse        =   stripslashes(trim($row->bankinfo_relayresponse));
    $login                =   stripslashes(trim($row->bankinfo_login));
    $trankey              =   stripslashes(trim($row->bankinfo_trankey));
    $cctype               =   stripslashes(trim($row->bankinfo_cctype));
  }

#-------------------------------------------------------------------------------
#   WireTransfer & CheckByMail
#-------------------------------------------------------------------------------
    if($payment_method=="WireTransfer" || $payment_method=="CheckByMail") {
        $successurl =$track_site_url."/admin/newpayment_success.php?affiliateid=$affiliateid&request_id=$request_id&amount=$amount&secid=$secid&secpass=$secpass";

        ?>
       <form action="<?=$successurl?>" method="post"  name="manual">
        <div align="center"> Payment Processing. Please Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"/> </div>
        </form>
        <script language="JavaScript" type="text/javascript">
         	   document.manual.submit();
        </script>
       <?

    }

#---------------------------------------------------------------------------------------#
# Netteller
#---------------------------------------------------------------------------------------#
if($payment_method=="NETeller"){
      ?>
      <h1>Coming Soon..........</h1>

     <?

   }

#-------------------------------------------------------------------------------
#  Paypal
#-------------------------------------------------------------------------------
    if($payment_method=="Paypal"){

        $mydomain 	=   "http://".$_SERVER['SERVER_NAME'];
  	    $successurl =   $track_site_url."/admin/newpayment_success.php?affiliateid=$affiliateid&request_id=$request_id&amount=$amount&secid=$secid&secpass=$secpass";
	    $failurl    =   $track_site_url."/admin/index.php?Act=request";
        $notifyurl	=   $track_site_url."/admin/ipn_notify.php";
        $paypalid	=	$bankinfo_paypalemail;
        $grandtotal	=   $amount;

	    ?>
		<!--*******************************************************PAYPAL FORM*********************************************-->
	      <form action="https://www.paypal.com/cgi-bin/webscr" method="post"  name="paypal">
          <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"/> </div>
            <input type="hidden" name="cmd" value="_xclick"/>
	        <input type="hidden" name="business" value="<?=$paypalid?>"/>
	        <input type="hidden" name="item_name" value="Send Money to Affiliate"/>
	        <input type="hidden" name="amount" value="<?=$grandtotal?>"/>
	        <input type="hidden" name="currency_code" value="<?=$currency_code?>"/>
	        <input type="hidden" name="return" value="<?=$successurl?>"/>
	        <input type="hidden" name="notify_url" value="<?=$notifyurl?>"/>
	        <input name="successurl" type="hidden" value="<?=$successurl?>"/>
	        <input name="failurl"  type="hidden" value="<?=$failurl?>"/>
  			</form>
           <script language="JavaScript" type="text/javascript">
            	   document.paypal.submit();
            </script>
  <?
  }

  #-------------------------------------------------------------------------------
  #   2checkout
  #-------------------------------------------------------------------------------
  if($payment_method=="2checkout")
  {

    ?>

    <form action="https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c" method="post" name="checkout">
        <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"/> </div>
	    <input type="hidden" name="sid" value="100495"/>
	    <input type="hidden" name="cart_order_id" value="Donation"/>
	    <input type="hidden" name="total" value="40.00" size="10"/>
     <?
	            reset($_GET);
	            foreach ($_GET as $key => $value)//to stripslash all posted variables
	            {

	            $value=stripslashes(trim($value));
	            $$key=$value;
	            //echo "$key=>$value <br/>";
	            echo"<input type='hidden' name='$key' value='$value'/><br/>";

	            }
    ?>
    </form>
     <script language="javascript" type="text/javascript">
		   	 document.checkout.submit();
	</script>


<?
  }

  #-------------------------------------------------------------------------------
  #   Stormpay
  #-------------------------------------------------------------------------------

  if($payment_method=="Stormpay")
   {
        $mydomain	 = "http://".$_SERVER['SERVER_NAME'];
  	    $successurl  = $track_site_url."/admin/newpayment_success.php?affiliateid=$affiliateid&request_id=$request_id&amount=$amount&secid=$secid&secpass=$secpass";
	    $failurl     = $track_site_url."/admin/index.php?Act=request";
        $stormpayid	 =	$bankinfo_stormemail;
        $grandtotal	 =   $amount;

?>

	    <form method="post" action="https://www.stormpay.com/stormpay/handle_gen.php" target="_blank" name="stormpay">
        <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
	      <input type="hidden" name="generic" value="1"/>
	      <input type="hidden" name="payee_email" value="<?=$bankinfo_stormemail?>"/>
	      <input type="hidden" name="product_name" value="test"/>
	      <input type="hidden" name="category" value="test"/>
	      <input type="hidden" name="description" value="commission Amount Transfer"/>
	      <input type="hidden" name="amount" value="<?=$grandtotal?>"/>
	      <input type="hidden" name="quantity" value="1"/>
	      <input type="hidden" name="tax" value="0"/>
	      <input type="hidden" name="shipping" value="0"/>
	      <input type="hidden" name="require_IPN" value="0"/>
	      <input type="hidden" name="return_URL" value="<?=$successurl?>"/>
	      <input type="hidden" name="cancel_URL" value="<?=$failurl?>"/>
	      <input type="hidden" name="subject_matter" value="nothing"/>
	     <!-- <input type=image src="https://www.stormpay.com/stormpay/images/BuyWithSP1.gif"> -->
	    </form>

	  	<SCRIPT language="JavaScript" type="text/javascript">
                document.stormpay.submit();
        </script>

<?
   }
   #-------------------------------------------------------------------------------
   #  E-Gold
   #-------------------------------------------------------------------------------

   if($payment_method=="E-Gold")
   {
        $mydomain   =  "http://".$_SERVER['SERVER_NAME'];
  	    $successurl =  $track_site_url."/admin/newpayment_success.php?affiliateid=$affiliateid&request_id=$request_id&amount=$amount&secid=$secid&secpass=$secpass";
	    $failurl    =  $track_site_url."/admin/index.php?Act=request";
        $grandtotal	=  $amount;

?>

	   <!-- <form action="https://www.e-gold.com/sci_asp/payments.asp" method="POST" target=_top name="egold"> -->
        <form name="egold" action="https://www.e-gold.com/sci_asp/payments.asp" method="POST" target=_top >
       <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>

        <input type="hidden" name="PAYEE_ACCOUNT" value="<?=$bankinfo_acno?>"/>
	    <input type="hidden" name="PAYEE_NAME" value="<?=$bankinfo_payeename?>"/>
	    <input type="hidden" name="PAYMENT_AMOUNT" size="4" value="<?=$grandtotal?>"/>
	    <input type="hidden" name="PAYMENT_UNITS" value="1"/>
	    <input type="hidden" name="PAYMENT_METAL_ID" value="1"/>
	    <input type="hidden" name="STATUS_URL" value="mailto:sci@e-gold.com"/>
	    <input type="hidden" name="NOPAYMENT_URL" value="<?=$failurl?>"/>
	    <input type="hidden" name="NOPAYMENT_URL_METHOD" value="LINK"/>
	    <input type="hidden" name="PAYMENT_URL"  value="<?=$successurl?>"/>
	    <input type="hidden" name="PAYMENT_URL_METHOD" value="LINK"/>
	    <input type="hidden" name="BAGGAGE_FIELDS" value="CUSTOMERID"/>
	    <input type="hidden" name="CUSTOMERID" value="0"/>
	    <input type="hidden" name="SUGGESTED_MEMO" value='Commission Amount Transfer'/>
	    </form>


        <SCRIPT language="JavaScript" type="text/javascript">

          document.egold.submit();

        </SCRIPT>


<?
   }
   #-------------------------------------------------------------------------------
   #  Authorize.net
   #-------------------------------------------------------------------------------

   if($payment_method=="Authorize.net")
   {
      $mydomain ="http://".$_SERVER['SERVER_NAME'];
      $successurl =$track_site_url."/admin/newpayment_success.php?affiliateid=$affiliateid&request_id=$request_id&amount=$amount&secid=$secid&secpass=$secpass";
      $failurl    =$track_site_url."/admin/index.php?Act=request";

?>
      <form action="<?=$secured_site_url?>/partnerssecured/card.php" method="POST" target=_top name="ath">

                <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
	            <input type="hidden" name="version" value="<?=$version?>"/>
	            <input type="hidden" name="delimdata" value="<?=$delimdata?>"/>
	            <input type="hidden" name="relayresponse" value="<?=$relayresponse?>"/>
	            <input type="hidden" name="login" value="<?=$login?>"/>
	            <input type="hidden" name="trankey" value="<?=$trankey?>"/>
	            <input type="hidden" name="cctype" value="<?=$cctype?>"/>
   	            <input type="hidden" name="amount" value="<?=$amount?>"/>
                <input type="hidden" name="surl" value="<?=$successurl?>"/>
                <input type="hidden" name="furl" value="<?=$failurl?>"/>


	    </form>
   			<SCRIPT language="JavaScript" type="text/javascript">
            	    document.ath.submit();
            </script>

 <?
 }
 ?>