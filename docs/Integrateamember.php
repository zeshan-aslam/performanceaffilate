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

        <title>aMember Integration for Lead and Sale</title>

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
                        	<td align="center" class="MainHead" >aMember</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >
								aMember uses a variation of General solution, it tracks sales by invoking hidden script from "thank you" page.
                        	</td>
                        </tr>
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 1 Integration
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Put the following code to the aMember thanks.html page
                                        </td>
                                    </tr>
									<tr>
										<td align="left">
                                            <textarea ><?php echo '<img src="'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=<?=$orderAmount?>&orderId=<?=$orderId?>" height="1" width="1" alt="" />'; ?>
                                            </textarea> 
										</td>
									</tr>
									
                               </table>
                        	</td>
                        </tr>  
                        
                    	<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 2 Integration of recurring sales with PayPal
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">If you want to integrate amember with PayPal recurring payments then follow these instructions. You will have to find the paypal_r.inc.php on your server /amember/plugins/payment/paypal_r<br /><br />
Insert next code right after this line: function paypal_validate_ipn($vars){
                                        </td>
                                    </tr>
									
									<tr>
										<td align="left">
<textarea ><?php echo '$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=<?=$orderAmount?>&orderId=<?=$orderId?>");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
curl_exec($ch);'; ?>
</textarea> 
										</td>
									</tr>
                                    
                                    <tr><td height="10" >&nbsp;</td></tr>
                                    
                                    <tr>
                                        <td align="left" >
                                            Please take care to replace <?php highlight_string('<?=$orderId?>')?> and <?php highlight_string('<?=$orderAmount?>')?> in the sale code with your server side script notations for the orderid and total amount variable used in your website.</li>
                                        </td>
                                    </tr>
                                    
                                    <tr><td height="10" >&nbsp;</td></tr>
                        
									<?php /*?><tr>
                                    	<td align="left">Now find this line (2x times):      'custom'      => '', <br />
and change them to:                   'custom'      => $_COOKIE['PAPCookie_Sale'],<br /><br />
Notice, that your cookies must be available at the domain where amember in order to track sales.
                                        </td>
                                    </tr><?php */?>
                               </table>
                        	</td>
                        </tr>  
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >
								This is all that is required. Now whenever there's sale, aMember will call our sale tracking script, and system will generate commission for the affiliate.
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