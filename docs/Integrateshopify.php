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

        <title>Shopify Integration for Lead and Sale</title>

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
                        	<td align="center" class="MainHead" >Shopify</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >This integration method enables you to track sales. It is set through Shopify admin panel. You do not need to edit any templates.
                        	</td>
                        </tr>
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	 
                    	<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 1 Login and navigation
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Login to your admin panel. Go to Preferences> Checkout & Payment. Scroll down to Additional Content & Scripts
										</td>
                                    </tr>
                               </table>
                        	</td>
                        </tr> 
                        <tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 2 Code
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">
											Shopify allows you to use these variables:<br />
											
												<ul>
                                    				<li>{{total_price|money_without_currency}}</li>
													<li>{{subtotal_price|money_without_currency}}</li>
													<li>{{order_number}}</li>
												</ul>
											For additional variables please contact Shopify support.<br /><br />
											So the tracking code to track total cost and order ID is this:
										</td>
                                    </tr>
                        <tr>
                        	<td align="left" class="subHead">
                        		Javascript Code
                        	</td>
                        </tr>
                        <tr>
                        	<td align="left">
<textarea ><?php echo '<script language="JavaScript" type="text/javascript"   
src="'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale={{total_price|money_without_currency}}&orderId={{order_number}}">
</script>'; ?>
</textarea> 
                        	</td>
                        </tr>
                        <tr><td height="10" align="left" valign="middle" >&nbsp;OR</td></tr>
                        <tr>
                        	<td align="left" class="subHead">
                        		Image Code
                        	</td>
                        </tr>
                        <tr>
                        	<td align="left">
<textarea ><?php echo '<img src="'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale={{total_price|money_without_currency}}&orderId={{order_number}}" height="1" width="1" alt="" />'; ?>
</textarea> 
                        	</td>
                        </tr>
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >
								Please take care to replace <?php highlight_string('<?=$orderId?>')?> and <?php highlight_string('<?=$orderAmount?>')?> in the sale code with your server side script notations for the orderid and total amount variable used in your website.</li>
                        	</td>
                        </tr>
									<tr>
										<td align="left" >And now just save it and you are ready to track the sales now.
										</td>
									</tr>			
                               </table>
                        	</td>
                        </tr>   
                    	
                        
                        
                                    
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	
                        
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