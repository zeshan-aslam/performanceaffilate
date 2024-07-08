<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <meta http-Equiv="Cache-Control" Content="no-cache"/>
        <meta http-Equiv="Pragma" Content="no-cache"/>
        <meta http-Equiv="Expires" Content="0"/>
        <meta name="robots" content="none"/>
		<meta name="description" content="Affiliate Newtwork Pro - Merchant Integration Methods" />
		<meta name="keywords" content="Affiliate Newtwork Pro - Merchant Integration Methods" />

        <title>AlertPay Integration for Lead and Sale</title>

		<link type="text/css" href="style.css" rel="stylesheet"  />
        
    </head>

    <body >
    
<?php 	include_once '../includes/constants.php'; ?>

    	<table align="center" cellpadding="0" cellspacing="0" border="0" width="960"  >
        	<tr><td ><img src="images/logo.jpg" width="960" height="105" /></td></tr>
            <tr>
            	<td  class="MainTD" height="400" >
                	<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" >
                    	<tr>
                        	<td align="center" class="MainHead" >AlertPay</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >
AlertPay integrates using IPN callback. <br />
Note! This is description of integration with AlertPay if you use AlertPay buttons on your web pages. If you use AlertPay as a processing system in your shopping cart, use the method for integrating with shopping cart, not these steps. <br />
Also, make sure you don't already use AlertPay IPN for another purpose, such as some kind of digital delivery or membership registration. <br /> <br />

To integrate with AlertPay, you need AlertPay plugin.
                        	</td>
                        </tr>
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 1 Activate IPN in AlertPay
                        	</td>
                        </tr>
                       <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
                                	<tr>
                                    	<td align="left">
                                    	Activate IPN in AlertPay: <a href="http://helpdesk.alertpay.com/index.php?_m=knowledgebase&_a=viewarticle&kbarticleid=132" target="_blank" > http://helpdesk.alertpay.com/index.php?_m=knowledgebase&_a=viewarticle&kbarticleid=132 </a> <br /> <br />
Remember the security code and use following Alert URL:
<?=$track_site_url?>/affiliate/plugins/AlertPay/alertpay.php
                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>
						   
                    	<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 2 Activate AlertPay plugin
                        	</td>
                        </tr>
                       <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
                                	<tr>
                                    	<td align="left">
                                    	1. Go to Plugins<br />
2. Find AlertPay integration plugin and click Activate<br />
3. After activation, find this plugin again and click Configure<br />
4. Select number of custom field (default is 1)<br />
5. Enter Security code you have remembered when activating IPN in AlertPay<br /><br />
                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>
						
                    	<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 3 Add code to every button
                        	</td>
                        </tr>
                       <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Add this code to every alertpay button. If you have choosen another custom field than 1, replace apc_1 with apc_YOUR_NUMBER in all places.
                                        </td>
                                    </tr>
									<tr>
										<td align="left">
<textarea ><?php echo '<script src="'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=<?=$orderAmount?>&orderId=<?=$orderId?>" type="text/javascript"></script>'; ?>
</textarea> 
										</td>
									</tr>
									<tr>
                                    	<td align="left">Example of modified button:<br /><br />

							&lt;form method="post" action="https://www.alertpay.com/PayProcess.aspx" &gt;<br />
							&lt;input type="hidden" name="ap_purchasetype" value="item" &gt;<br />
							&lt;input type="hidden" name="ap_merchant" value="163899@gmail.com"&gt;<br />
							&lt;input type="hidden" name="ap_itemname" value="gdfgdf"&gt;<br />
							&lt;input type="hidden" name="ap_currency" value="USD"&gt;<br />
							&lt;input type="hidden" name="ap_returnurl" value=""&gt;<br />
							&lt;input type="hidden" name="ap_itemcode" value="dfg"&gt;<br />
							&lt;input type="hidden" name="ap_quantity" value="1"&gt;<br />
							&lt;input type="hidden" name="ap_description" value="dfg"&gt;<br />
							&lt;input type="hidden" name="ap_amount" value="456"&gt;<br />
							&lt;input type="image" name="ap_image" src="https://www.alertpay.com//PayNow/B410C80C841042BE90080C349815932Dg.gif"&gt;<br />
							&lt;input type="hidden" name="apc_1" value="" id="pap_dx8vc2s5"&gt;<br />
							&lt;script id="pap_x2s6df8d" src="<?=$track_site_url?>/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=&lt;?=$orderAmount?&gt;&orderId=&lt;?=$orderId?&gt;" type="text/javascript"&gt;<br />
							&lt;/script&gt;<br />
							&lt;/form&gt;<br />
                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>                    	
                       
                        <tr><td height="10" >&nbsp;</td></tr>
                    	<tr>
                    	  	<td align="left" >
								Please take care to replace <?php highlight_string('<?=$orderId?>')?> and <?php highlight_string('<?=$orderAmount?>')?> in the sale code with your server side script notations for the orderid and total amount variable used in your website.</li>
                        	</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                        
                    	<tr>
                    	  	<td align="left" >
								This is all that is required. Now whenever there's sale, AlertPay will use its IPN function to call our sale tracking script, and system will generate commission for the affiliate
                        	</td>
                        </tr>
                        
                        <tr><td height="25">&nbsp;</td></tr>
                        
                    </table>
                </td>
			</tr>            
            <tr>
            <td height="30" align="center" class="footer_sep">Copyright 2009 &copy; Affiliate Network Pro</td>
            </tr>
        </table>


    </body>
</html>