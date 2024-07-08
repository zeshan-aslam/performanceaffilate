<?php

      

      $amount  = round($amount,2);

	  include_once "../random_tableinsert.php";


    if($payment_method=="WireTransfer" || $payment_method=="CheckByMail") {
        $successurl =$track_site_url."/merchants/newpay_success.php?paytype=$payment_method&amount=$amount&secid=$secid&secpass=$secpass";

        ?>
       <form action="<?=$successurl?>" method="post"  name="manual">
        <div align="center"> Payment Processing. Please Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
        </form>
        <script language="JavaScript" type="text/javascript">
         	   document.manual.submit();
        </script>
       <?

   }
	if($payment_method=="Paypal")
    {

        $sql		="SELECT * FROM `partners_paypal` ";
        $res		=mysqli_query($con,$sql);

                    while ($row=mysqli_fetch_object($res))

                    {
                     			$paypal_email     =	stripslashes(trim($row->paypal_email ));

                    }


     //********************************************************** PAY PAL FORM ***************************************//


	    $paypalid   =	$paypal_email;
	    $grandtotal =	$amount;


        $mydomain 	=	"http://".$_SERVER['SERVER_NAME'];
	    $successurl =	$track_site_url."/merchants/add_money_success.php?amount=$amount&secid=$secid&secpass=$secpass";
	    $failurl    =	$track_site_url."/merchants/index.php?Act=add_money";
        $notifyurl	=   $track_site_url."/merchants/ipn_notify.php";



	    ?>

		<!--*******************************************************PAYPAL FORM*********************************************-->
	      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypal" id="paypal">
           <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
<? /*  // OLD FORM
			<input type="hidden" name="cmd" value="_xclick">
	        <input type="hidden" name="business" value="<?=$paypalid?>">
	        <!--input type="hidden" name="item_name" value="<?=$payname?>">
	        <input type="hidden" name="item_number" value="<?=$payno?>"-->
	        <input type="hidden" name="amount" value="<?=$grandtotal?>">
	        <input type="hidden" name="no_note" value="1">
	        <input type="hidden" name="currency_code" value="USD">
	        <input type="hidden" name="lc" value="ENG">
	        <input name="return" type="hidden" value="<?=$successurl?>">
	        <input name="cancel_return" type="hidden" value="<?=$failurl?>">
	        <!--input type="image" src="https://www..paypal.com/en_US/i/btn/x-click-butcc.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"-->
			<!--input type="submit" name="submit" value="PayPal  !"-->



  */  ?>

  	<input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?=$paypalid?>">
	<input type="hidden" name="item_name" value="Upgredation  Fee This Amount Will Be added to Your System Account">
    <input type="hidden" name="amount" value="<?=$grandtotal?>">
    <input type="hidden" name="currency_code" value="USD">

    <input type="hidden" name="return" value="<?=$successurl?>">
    <input type="hidden" name="notify_url" value="<?=$notifyurl?>">

    <input name="successurl" type="hidden" value="<?=$successurl?>">
    <input name="failurl"  type="hidden" value="<?=$failurl?>">

  			</form>
        <script language="javascript" type="text/javascript">

            	   document.paypal.submit();

            </script>


  <!-- ********************************************* pay pal info ENDS HERE*********************** -->

  <?
  		}
        if($payment_method=="2checkout")
        {

    ?>

 <!-- ******************************************** CHECKOUT FORM ***************************************** -->

	    <form action=https://www.2checkout.com/cgi-bin/sbuyers/cartpurchase.2c method=post name="checkout">
          <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
	    <input type=hidden name=sid value=100495>
	    <input type=hidden name=cart_order_id value=Donation>
	    <input type=hidden name=total value=40.00 size=10>





       <?
	            reset($_GET);
	            foreach ($_GET as $key => $value)//to stripslash all posted variables
	            {

	            $value=stripslashes(trim($value));
	            $$key=$value;
	            //echo "$key=>$value <br/>";
	            echo"<input type=hidden name=$key value='$value'><br/>";

	            }



       ?>



     </form>


		<script language="javascript">
		   	            	   document.checkout.submit();
		</script>


<?
		//*****************************************************  Storm pay Payment area Starts here ********************//

        }

        if($payment_method=="Stormpay")
        {

   	    $stormpayid   =			$stormpayurl;
	    $grandtotal	  =			$amount;

                $sql		="SELECT * FROM `partners_stormpay`";
        		$res		=mysqli_query($con,$sql);

                    while ($row=mysqli_fetch_object($res))

                    {
                     			$storm_email      =	stripslashes(trim($row->storm_email  ));

                    }



        $mydomain 	=	"http://".$_SERVER['SERVER_NAME'];
	    $successurl =	$track_site_url."/merchants/add_money_success.php?amount=$amount&secid=$secid&secpass=$secpass";
	    $failurl    =	$track_site_url."/merchants/index.php?Act=add_money";


        $stormpayid	=	$storm_email;
        $grandtotal	=   $amount;





?>

	    <form method="post" action="https://www.stormpay.com/stormpay/handle_gen.php" target="_blank" name="stormpay">
          <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>
	      <input type=hidden name=generic value="1">
	      <input type=hidden name=payee_email value="<?=$stormpayid?>">
	      <input type=hidden name=product_name value="Payment">
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

			<script language="javascript" type="text/javascript">

            	               	   document.stormpay.submit();

            </script>



<?
	//*****************************************************  Storm pay Payment area END here ********************//


    // ***************************************************  E-GOLD STARTS HERE ***********************************//

        }
        if($payment_method=="E-Gold")
        {


        $mydomain 	=	"http://".$_SERVER['SERVER_NAME'];
	    $successurl =	$track_site_url."/merchants/add_money_success.php?amount=$amount&secid=$secid&secpass=$secpass";
	    $failurl    =	$track_site_url."/merchants/index.php?Act=add_money";

                $sql		="SELECT * FROM `partners_egold";
        		$res		=mysqli_query($con,$sql);

                    while ($row=mysqli_fetch_object($res))

                    {
                     			$egold_payeename       =	stripslashes(trim($row->egold_payeename   ));

                    }

        $stormpayid	=	$egold_payeename;
        $grandtotal	=   $amount;

      //  echo  $successurl;
      //  exit;
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
	    <input type="hidden" name="SUGGESTED_MEMO" value='Thanks'>
	    </form>


   			<script language="javascript" type="text/javascript">

            	               	   document.egold.submit();

            </script>



<?
        }


                 if($payment_method=="Authorize.net")
        {

	   //	Header("https://www.alstrasoft.com/anp/partnerssecured/card.php");


        $mydomain 	=	"http://".$_SERVER['SERVER_NAME'];
	    $successurl =	$track_site_url."/merchants/add_money_success.php?amount=$amount&secid=$secid&secpass=$secpass";
	    $failurl    =	$track_site_url."/merchants/index.php?Act=add_money";

        $sql		="SELECT * FROM `partners_creditcard` ";
        $res		=mysqli_query($con,$sql);

            echo mysqli_error($con);

                    while ($row=mysqli_fetch_object($res))

                    {


                     			$version     	=	stripslashes(trim($row->cc_version ));
                       			$delimdata   	=	stripslashes(trim($row->cc_delimdata));
                     			$relayresponse  =	stripslashes(trim($row->cc_relayresponse));
                       			$login   		=	stripslashes(trim($row->cc_login));

                       			$trankey   		=	stripslashes(trim($row->cc_trankey));
                       			$type  			=	stripslashes(trim($row->cc_type));


                    }





?>


	    <form action="<?=$secured_site_url?>/partnerssecured/card.php" method="POST" target=_top name="ath">
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


   			<script language="javascript" type="text/javascript">

            	               	   document.ath.submit();

            </script>






<?

  		}


    if($payment_method=="WorldPay")
   {

       $mydomain   = "http://".$_SERVER['SERVER_NAME'];

       $successurl =	$track_site_url."/merchants/return_world.php?amount=$amount&secid=$secid&secpass=$secpass";
	    $failurl    =	$track_site_url."/merchants/index.php?Act=add_money";

       $sql        = "SELECT * FROM `partners_worldpay` ";
       $res        = mysqli_query($con,$sql);

        while ($row=mysqli_fetch_object($res))
        {

              $accno  =  stripslashes(trim($row->worldpay_accno));

        }
?>

        <FORM ACTION="https://select.worldpay.com/wcc/purchase" METHOD=POST name="worldpay">
         <div align="center"> Connecting to Payment Gateway Please  Wait.....<input type="image" src="images/wait.gif"  name="test" value="22"> </div>

        <INPUT TYPE=HIDDEN NAME=cartId VALUE="Merchant Payment">
		<INPUT TYPE=HIDDEN NAME=instId VALUE=<?=$accno?>>
		<INPUT TYPE=HIDDEN NAME=currency VALUE="USD">
		<INPUT TYPE=HIDDEN NAME=amount VALUE="<?=$amount?>">
        <INPUT TYPE=HIDDEN NAME="MC_callback" VALUE="<?=$successurl?>">
         </form>
        <script language="javascript" type="text/javascript">
                  document.worldpay.submit();
        </script>

<?
 }
?>