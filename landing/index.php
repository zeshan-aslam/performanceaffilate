<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>AVAZ - Affiliate Network</title>
	<link href="https://fonts.googleapis.com/css?family=Oswald:400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="wrapper">
		<div class="wrap_opacity"></div>
		 <div class="container"> 
			<header class="header cus_zindex">
				 <div class="col-md-4 col-sm-4 col-xs-12 logo">
					<a href="index.html"><img src="img/logo.png" alt="Logo"/></a>
				 </div>
				 <div class="col-md-8 col-sm-8 col-xs-12">
					<nav class="navbar custom_navbar">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>
						  <a class="navbar-brand visible-xs" href="#"><img src="img/logo.png" alt="Logo"/></a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						  <ul class="nav navbar-nav">
							<li class="active"><a href="#" data-toggle="modal" data-target="#privacy_policy">Privacy Policy</a></li>
							<li><a href="#" data-toggle="modal" data-target="#abount_us">About Us</a></li>
							<li><a href="#" data-toggle="modal" data-target="#term_condition">Terms & Conditions</a></li>
						  </ul>						
						</div><!-- /.navbar-collapse -->
					</nav>
				 </div>
				 <div class="clearfix"></div>
			</header>
			<div class="clearfix"></div>
			<div class="inner_content cus_zindex">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="inner_easy_left">
						<div class="text-center">
							<h4>It's As Easy As 1 - 2 - 3</h4>
						</div>	
						<div class="row common_easyway">
							<div class="col-md-5">
								<div class="easy_left_img">
									<img src="img/simply_img.jpg" alt=""/>
								</div>
							</div>
							<div class="col-md-7">
								<div class="easy_left_img">
									<span>1</span>
									<h3>Simply</h3>
									<p>Browse as usual nd see our deals appear </p>
								</div>
							</div>
						</div>
						<div class="row common_easyway">
							<div class="col-md-5">
								<div class="easy_left_img">
									<img src="img/more_img.jpg" alt=""/>
								</div>
							</div>
							<div class="col-md-7">
								<div class="easy_left_img">
									<span>2</span>
									<h3>More</h3>
									<p>Your favourite brands with great savings</p>
								</div>
							</div>
						</div>
						<div class="row common_easyway"> 
							<div class="col-md-5">
								<div class="easy_left_img">
									<img src="img/rewarding_img.jpg" alt=""/>
								</div>
							</div>
							<div class="col-md-7">
								<div class="easy_left_img">
									<span>3</span>
									<h3>Rewarding</h3>
									<p>Get Cashback</p>
								</div>
							</div>
						</div>
					</div> 
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 border_line">
					<div class="inner_form_rgt">
						<div class="text-center">
							<h4>Join Avaz Today</h4>
							<p>The Most Advanced Cashback Service</p>
						</div>
						<form class="" action="<?php echo SITEURL.'controller/signup.php'; ?>" method="post">
						<?php
							if(isset($_SESSION['success'])){
								echo '<p class="alert alert-success">'.$_SESSION['success'].'</p>';
								unset($_SESSION['success']);
							}else if(isset($_SESSION['failure'])){
								echo '<p class="alert alert-danger">'.$_SESSION['failure'].'</p>';
								unset($_SESSION['failure']);
							}
						?>
							<div class="form-group">
								<input required type="text" name="first_name" class="form-control" placeholder="Please Enter Your First Name" />
							</div>
							<div class="form-group">
								<input type="text" name="sur_name" class="form-control" placeholder="Please Enter Your Surname" />
							</div>
							<div class="form-group">
								<input required type="email" name="av_email" class="form-control" placeholder="Please Enter Your Email" />
							</div>
							<div class="form-group">
								<input required type="tel" name="av_phone" class="form-control" placeholder="Please Enter Your Phone Number" />
							</div>
							<div class="form-group">
								<input required type="text" name="av_post_code" class="form-control" placeholder="Please Enter Your Post Code" />
							</div>
							<div class="form-group">
								<select required class="form-control" name="av_question">
									<option value="">Please Select Unique Question</option>
									<?php 
									$sql = select('question');
									while($row = fetch($sql)){
									?>
									<option value="<?php echo $row['question_name']; ?>"><?php echo $row['question_name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<input required type="text" name="av_answer" class="form-control" placeholder="Please Enter Your Answer" />
							</div>
							<div class="form-group text-center">
								<input type="submit" name="join_avaz" class="submit_btn" Value="Submit" />
							</div>
						</form>
					</div>	
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<footer class="footer text-center cus_zindex">
			 <div class="container"> 
				<div class="footer_txt">
					<a href="#">Visit Main Site</a>
				</div>
				<div class="copyright_txt">
					<p>&copy; 2019 AVAZ Affiliate Network | All Rights Reserved.</p>
				</div>
			 </div>
		</footer>			
	</div>
	<!-- Privacy Policy -->
<div id="privacy_policy" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <h3>Frootfal Privacy and Cookie Policy</h3>
		<p>This Privacy and Cookie Policy (<strong>"Policy"</strong>) governs the collection, storage and use of personal information collected by Frootfal Media Limited, company number 07832917, whose registered address is at Highlands House, Basingstoke Road, Spencers Wood, Reading, Berks RG7 1NT together with our group companies (<strong>"we"</strong>, <strong>"us"</strong> or <strong>"our"</strong>) in connection with our website at www.frootfal.com (<strong>"Website"</strong>), our application available to download onto PCs, tablets and mobile phones (<strong>"App"</strong>), and other products or services offered by us through the Website and/or the App (collectively, the <strong>"Frootfal Service"</strong>).  </p>
		<p>Your personal information is very important to us and we do all we can to protect it.  This Policy provides you with details about the personal information we collect from you, how we use your personal information and your rights to control the personal information we hold about you.  Please read this Policy carefully.  Once you use the Website, the App or register for the Frootfal Service you will be deemed to have read and consented to this Policy in its entirety.  If you do not agree to this Policy in its entirety, you must not use the Website, the App or the Frootfal Service.</p>
		<p>This Policy was last updated on 30<sup>th</sup> April 2012.  Please check back regularly to keep informed of updates to this Policy.</p>
		<h3>The personal information we collect about you</h3><br>
		<p>When you access and browse the Website or the App, including when sign-up for the Frootfal Service, we may collect such personal information from you as your name and email address, your IP address and your choice of payment method which may be in the form of BACS details or a registered PayPal account details.  You may also choose to provide some other optional information about you.</p>
		<h3>How we may store and use your information</h3><br>
		<p>We (or third party data processors acting on our behalf) may collect, store and use your personal information listed above to: (i) make the Frootfal Service available to you and to provide you with content which is tailored to your individual tastes; (ii) complete any transactions you make through the Frootfal Service (including passing on your personal information to retailers party to such transactions); (iii) provide you with services that you request; (iv) where you have given us your consent, contact you with products and services which we think may interest you; and (v) where you have given us your consent, disclose your personal information to carefully chosen third parties so that they may contact you with products and services which they think may interest you.</p>
		<p>We will not disclose, sell or rent your personal information to any third party unless you have consented to this, except: (i) to the extent that we are required to do so by applicable law, by a governmental body or by a law enforcement agency, or for crime prevention purposes; (ii) in connection with any legal proceedings (including prospective legal proceedings); (iii) in order to establish or defend our legal rights; (iv) in the event that we buy or sell any business or assets, in which case we may disclose your personal data to the prospective sellers or buyer of such business or assets; or (v) if a third party acquires all (or substantially all) of our business and/or assets, we may disclose your personal information to that third party in connection with the acquisition.</p>
		<p>We may also collect anonymised details about users of the Frootfal Service for the purposes of aggregate statistics or reporting purposes.  However, no single individual will be identifiable from the anonymised details we collect for these purposes.  We use these details for internal management purposes and for sharing with prospective retailers whilst negotiating cashback rates.</p>
		<p>Any information provided by you to us, which is not personal information including but not limited to market information, feedback, questions or comments, shall be deemed to be non-confidential.  We shall have no obligation of any kind with respect to such information and shall be free to reproduce, use, disclose and distribute the information to others without limitation.</p>
		<h3>International transfers</h3><br>
		<p>We may transfer personal information that we collect from you to third party data processors located in countries that are outside of the European Economic Area in connection with the above purposes.  Please be aware that countries which are outside the European Economic Area may not offer the same level of data protection as the United Kingdom, although our collection, storage and use of your personal data will continue to be governed by this Policy. </p>
		<h3>Cookies</h3><br>
		<p>The Website uses cookies to collect information about you.  Cookies are small data files which are placed on your computer by the Website and which collect certain information about you.  Cookies are placed on the Website by us and by third parties authorised by us to do so.  This enables us to tailor our service offering (including the Website) to provide you with the Frootfal Service.</p>
		<p>We may include cookies on the Website that allow third party advertisers to present you with advertising on the Website based on interests collected from your web browsing activity and your use of the Frootfal Service.  We believe that the cookies used on the Website are necessary to perform the functions you require to enable you to use the Frootfal Service; or are non-intrusive.</p>
		<p>Where you are a registered account holder of the Frootfal Service the cookies used on the Website:</p>
		<ul id="privacy">
			<li>Track your transactions (including details of the retailer's site, the time you make a transaction and the cashback amount);</li>
			<li>Keep you logged in to your account on the Website for a period of time;</li>
			<li>Allow us to comply with your choices about the display of information in your account;</li>
			<li>Remember the options you select (such as favourite retailers and merchants);</li>
			<li>Allow integration with social media sites (such as the ability to "like" Frootfal on Facebook);</li>
			<li>Provide you with recommended offers, based on your use of the Frootfal Service and the transactions you enter into through it; and</li>
			<li>Enable you to redeem your cashback with redemption partners (merchants that will transform cashback to their own redemption currency).</li>
		</ul>
		<p>Where you are not a registered account holder of the Frootfal Service the cookies used on the Website tell us the route (such as a web search or an online advertisement) by which you came to the Website.  If you visit the Website and do not register as an account holder, a cookie-like technology also allows you to be presented with advertising for the Frootfal Service on other sites that you visit, intended to prompt you to return to the Website to register as an account holder.</p>
		<p>For more information about cookies, including how to manage and remove cookies, please visit <a href="http://allaboutcookies.org">www.allaboutcookies.org</a>. </p>
		<p>If you wish to do so, you can change your browser settings to reject cookies.  As the means by which you can do this varies from browser to browser, please visit your web browser's "Help" menu for further details.  Please note, however, that if you set your browser to refuse cookies, this might impair some of the functionality of the Website and you may not be able to use certain aspects of the Frootfal Service (including not being able to earn cashback or other member benefits).</p>
		<h3>Security</h3><br>
		<p>We take reasonable precautions to prevent the loss, misuse or alteration of your personal information.  Our employees, contractors and agents may be given access to your personal information which we collect, but their use shall be limited to the performance of their duties in relation to facilitating your use of the Website, the App and the Frootfal Service.  Our employees, contractors and agents who have access to your personal information are required to keep that information confidential and are not permitted to use it for any purposes other than those listed above or to deal with requests which you submit to us.</p>
		<p>Whilst we take appropriate technical and organisational measures to safeguard the personal information that you provide to us, no transmission over the Internet can ever be guaranteed to be totally secure and therefore we cannot ensure or warrant the security of any personal information that you transfer over the Internet to us.</p>
		<h3>Third party sites</h3><br>
		<p>The Website, the App and the Frootfal Service may contain links to other websites operated and services provided by third parties, including those retailers you enter into a transaction with.  Please note that this Policy applies only to the personal information that we collect through the Website, the App and the Frootfal Service and we cannot be responsible for personal information that third parties may collect, store and use through their websites or their services.  You should always read the privacy policy of each website you visit carefully.</p>
		<h3>Your rights</h3><br>
		<p>You have the following rights:</p>
		<ul id="privacy">
			<li>the right to ask us to provide you with copies of personal information that we hold about you at any time, subject to a fee specified by law; </li>
			<li>the right to ask us to update and correct any out-of-date or incorrect personal information that we hold about you free of charge; and</li>
			<li>the right to opt out of any marketing communications that we (or any third party to whom we have disclosed your personal information with your consent) may send you.</li>
			
		</ul>
		<p>If you wish to exercise any of the above rights, please contact us at the address specified below.</p><br>
		<h3>Questions</h3><br>
		<p>If you have any questions about how we collect, store and use personal information, or if you have any other privacy-related questions, please contact us by e-mail at <a href="mailto:info@frootfal.com">info@frootfal.com</a>.</p>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
      </div>
    </div>

  </div>
</div>

<!-- About Us -->
<div id="abount_us" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <h3>About Frootfal</h3>
		<p>Frootfal is a new Anglo/American company providing a fast, safe
		and secure shopping experience by bringing you on-line deals that
		offer cash back.You no longer have to wonder, "Is there cash back
		available on this?" - We do the searching for you.Â We pop up
		ONLY if there are offers.</p>
		<p>At Frootfal we manually check the thousands of merchants and
		connect you only to those that provide legitimate goods and
		services and ensure the safety of your confidential information.</p>
		<p>We will not "pop-up" with offers if the merchant does not
		validate its products' authenticity.</p>

		<p>We are currently beta testing in the UK and adding new
		functionality at the request of users prior to a planned full
		release in July.</p>

		<p>Frootfal Holdings Limited is the holding company for Frootfal
		Media Limited (UK) and Frootfal Media Inc. (US).</p>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
      </div>
    </div>

  </div>
</div>

<!-- About Us -->
<div id="term_condition" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <h3>Terms and Conditions</h3>
		<h6>Please be sure to read the terms and conditions below. You
must indicate your agreement by checking the "I Agree" box to
complete your member registration.</h6>
<p>By using the Frootfal Application ("App") or accessing any of
the Frootfal web sites - www.frootfal.com, www.frootfal.co.uk,
www.frootfal.net, www.frootfamedia.com, www.frootfalmedia.co.uk,
www.frootfalmedia.net, or frootfal.xxx site you agree to abide by
the Terms and Conditions of use for the App or web site. Failure
to adhere to these terms may result in suspension of your
account, forfeiture of funds accumulated on the site, possible
legal action and other remedies available under law.</p>
<p>Frootfal Media Limited and Frootfal Media Inc are subsidiary
companies of Frootfal Holdings Limited a UK limited company whose
registered address is Highlands House, Basingstoke Road, Spencers
Wood, Reading, Berkshire, RG7 1NT with company number 07632037.
Frootfal is the trademarked brand of Frootfal Holdings Limited.
All of the above are hereinafter combined under the term
"Frootfal".</p>
<h3>Site Membership and Termination of Accounts</h3><br>
<p>Frootfal allows only one account per person. We also allow a
maximum of four (4) accounts per household to prevent fraudulent
activity. We reserve the right to refuse membership to anyone at
any time and to terminate an account with Frootfal without notice
at any time, for any reason.</p>
<p>By accepting these Terms and Conditions, conducting a
transaction (any purchase through the App or web site) and
registering to enable us to track your cash and to make payments,
you become a member of the Frootfal community.</p>
<h3>Earning Cashback</h3><br>
<p>You will earn cash back by "clicking" on a link from within the
Frootfal App or from a Frootfal web site and subsequently
purchasing a product for which a cash-back offer is provided from
a vendor of the products, which we refer to as the Merchant. At
Frootfal we want to ensure that cash-back offers are correctly
illustrated.</p>
<p>Any transaction you make is conducted with the merchant site
providing the offer to which our click-through link connects.
Frootfal is not responsible for any defects or short falls or
lack of availability of the products or services offered by
merchants through the Frootfal App or web site. The merchants of
the goods you purchase will confirm to us your pending
transactions, at which point they will appear in your account in
the "Approved section" and on your statement. Although we
encourage all merchants to be efficient in making approval
decisions, Frootfal is not responsible for any aspect of a
merchant's decision regarding any purchase.</p>
<p>Nor is Frootfal responsible for slow or cancelled transactions
between any buyer and any merchant. If the value of goods or
services are refunded by a merchant for whatever reason or if a
sale is reversed or cancelled, then the cash-back is not
applicable to that event and a cash-back payment will not be
made; Frootfal only awards cash-back for a completed transaction;
that is, when a Frootfal member goes to a merchant's site via the
Frootfal App, or logs into www.Frootfal.com, clicks on the
merchant's link and completes a purchase.</p>
<p>If you visit a merchant to make a purchase but not via the
Frootfal App or from www.frootfal.com, no eligible transaction
can occur and therefore no cash-back is accumulated in your
account. Frootfal accepts no responsibility for incomplete,
cancelled, lost or deleted transactions. All transactions are
electronically logged and reported to Frootfal by the merchant.
Frootfal makes every effort to ensure that merchants are
correctly reporting every transaction; however Frootfal is not
responsible for the failure of any merchant to report back your
purchase. (If Frootfal were to become aware of such a failure, it
will make every effort to negotiate the applicable cash-back from
the merchant on your behalf; however the merchant alone makes
that decision and the merchant's decision is final).</p>
<h3>Payment</h3><br>
<p>A member can instigate a payment at any time through the web
site where they registered providing your approved balance
exceeds Â£20 n the UK or $25 in the US. Account balances below
this amount will be carried forward until they reach this
threshold and the member then may withdraw the accumulated
cash-back balance. If a merchant delays payment or ceases
conducting transactions while cash-back is due a member, we will
make every effort to recover the balance for the member. In fact
Frootfal makes all reasonable efforts to ensure that every
merchant affiliated with Frootfal has a track record of prompt,
timely and accurate payments. We accept no responsibility for
merchants' successes or failures and make no guarantee of payment
until funds have been received by Frootfal from the merchant.
PLEASE NOTE: FROOTFAL PAYS CASH-BACK TO ITS MEMBERS AFTER IT HAS
RECEIVED DUE PAYMENT FROM THE MERCHANT!</p>
<h3>Newsletters</h3><br>
<p>Members will receive a regular newsletter, providing
information on the latest offers and site updates. A member is
under no obligation to receive email from Frootfal and may change
account settings or terminate the account at any time. Any member
may opt out at any time, including during registration or at a
later time simply by changing user settings.</p>
<h3>Change of Terms &amp; Conditions</h3><br>
<p>Frootfal may modify/change any of the terms and conditions
contained in this Agreement at any time and in our sole
discretion. Frootfal will notify members by email when/if this
happens.</p>
<h3>Miscellaneous</h3><br>
<p>This Agreement is governed by the laws of England, without
reference to rules governing choice of laws. Failure to enforce
strict performance under any provision of this Agreement does not
constitute a waiver of Frootfal's right to subsequently enforce
such provision or any other provision of this Agreement.</p>
<h3>Fraudulent Transactions</h3><br>
<p>Providing false information to any of our Merchants, or
attempting to fraudulently obtain monies from any merchants is a
violation of law and of this agreement and will immediately
trigger suspension of the account in violation and the event may
be reported to the relevant authorities.</p>
<h3>App or Site Misuse</h3><br>
<p>In the event a site user attempts to defraud Frootfal or its
merchants in any way, Frootfal reserves the right to terminate
the user's account without notice and pass the details to the
relevant authorities.</p>
<h3>Anti Spam Policy</h3><br>
<p>Frootfal allows members to "refer a friend" by using the
Facebook â„¢ recommendation engine or by sending email messages to
friends and family promoting our App/web site to them and it
rewards members though cash incentives. However, Frootfal does
not allow or encourage any spamming activity and reserves the
right to delete and/or suspend any account without notice if such
activity is detected.</p>
<h3>Deleting / Suspension</h3><br>
<p>If Frootfal deletes or suspends a user's account for improper
activity, that user will automatically forfeit cash-back balances
on the site, both pending and approved. Frootfal will only
suspend/delete an account suspected of fraudulent activity or of
violating the site's terms and conditions. Frootfal's decision is
final.</p>
<h3>Visiting Merchants</h3><br>
<p>Frootfal invites all consumers to use Frootfal as their main
portal for shopping online and encourages them to make full and
regular use of its services. However Frootfal does not allow an
individual member to make several applications to the same
merchant company to seek improper financial reward. Frootfal's
merchants have invested in software that will notify them of
duplicate loan/finance applications. We also do not allow
applications made in the name of third parties such as
applications under the names of family members or friends. Such
activity is a violation of this agreement and will result in the
improper accounts being deleted and all pending and approved
transactions forfeited.</p>
<h3>Payments</h3><br>
<p>By signing up with Frootfal you agree that you are responsible
for paying any tax due on any payments made to you by Frootfal.</p>
<h3>Unapproved Accounts</h3><br>
<p>In order to cut down on inactive accounts on Frootfal, all new
accounts must be validated within 14 days of use. If you have not
approved your account within 7 days of joining, you will be sent
a notification email together with a link notifying you that your
account will be deleted within seven (7) days. A deleted account
forfeits any outstanding balance remaining on that account.</p>
<h3>Unused Accounts</h3><br>
<p>Frootfal will delete any account that is dormant for a period
of 6 months. A warning email will be sent 30 days prior to
deletion and again 5 days prior. Upon deletion the registered
holder of the dormant account will forfeit the remaining account
balance. The Frootfal App will maintain the account as active
unless it is turned off or uninstalled. In this event, the
account will be considered dormant for 6 months after
de-installation allowing the member to re-install the App (e.g.
on another device) before being deleted.</p>
<h3>Once You Leave</h3><br>
<p>If you leave or de-register all personal and account
information will be remove from Frootfal's databases and mailing
lists. We will not pass your information to 3rd party companies
who may have offers we believe may interest you unless you
request that Frootfal take this action in the de-registration
process.</p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
      </div>
    </div>

  </div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>