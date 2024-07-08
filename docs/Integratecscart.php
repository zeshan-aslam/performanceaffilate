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

        <title>CS-Cart Integration for Lead and Sale</title>

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
                        	<td align="center" class="MainHead" >CS-Cart</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
						<tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 1 Login
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Login and go to: Admin panel &gt; Look and feel &gt; Template editor<br />
</b>
                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>         
						<tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 2 Edit template
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Open file: /skins/[your_skin]/customer/orders_pages/order_details.tpl

                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr> 
						<tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 3 Integration                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left"> Add following code before last {/if}:
                                    </tr>
									<tr>
										<td align="left">
                                    	<textarea ><?php echo '<img src="'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=$orderAmount&orderId=$orderId" height="1" width="1" alt="" />'; ?>
                                    	</textarea>
										</td>
									</tr>
                               </table>
                        	</td>
                        </tr>
						<tr>
                        	<td align="center" > 
                        		This is all that is required. Now whenever there's sale, the sale tracking script sale.php is called, and it will generate commission for the affiliate.
                            </td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                    </table>
                </td>
			</tr>            
            <tr>
            <td height="30" align="center" class="footer_sep">Copyright 2009 &copy; Affiliate Network Pro</td>
            </tr>
        </table>


    </body>
</html>