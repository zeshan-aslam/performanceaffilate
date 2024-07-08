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

        <title>Merchant Integration</title>

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
                        	<td align="center" class="MainHead" >Merchant Integration Methods</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                    	<tr>
                    	  <td align="left" >
                          Affiliate Network Pro is compatible with most shopping carts, signup forms and online ordering systems. Affiliate Network Pro is a 100% web-based affiliate tracking software solution.
                        	</td>
                        </tr>
                        
                    	<tr>
                        	<td align="center" class="subHead" >
                        		What integration means
                        	</td>
                        </tr>
                          
                    	<tr>
                    	  	<td align="left" >
                    	    Integration is a way to connect the affiliate system to the Merchant's website, shopping cart or   payment gateway in a way that affiliate system will be notified about registration or purchases.&nbsp;&nbsp;When notified, affiliate system registers the lead or sale, finds referring affiliate(if any) and provides appropriate commission for them. <br />
                    	    <br />
                   	      The general method of integration is putting an invisible JavaScript code or image anywhere in the   &quot;Registration Confirmation&quot; or &quot;Order Confirmation&quot; page that is displayed to the customer after the payment is processed(if any).
                          	</td>
                  	  </tr>
                        
                    	<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" />&nbsp;LEAD Code Integration
                        	</td>
                        </tr>
                          
                    	<tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
                                	<tr>
                                    	<td align="left">
                                    	Leads are registrations at the Merchant's website that are referred by Affiliates.&nbsp;&nbsp;Affiliate Network Pro tracks those registrations referred by Affiliates and provides appropriate commissions to them.&nbsp;&nbsp;Merchants can get the Lead Tracking code by performing following steps:
                                        </td>
                                    </tr>
                                    <tr><td align="left">
                                    <ul>
                                    	<li>Login to your Merchant Control Panel at Affiliate Network Pro</li>
                                        <li>Click on the link "Get Tracking Code" in the "Home" page of your Merchant Control Panel</li>
                                        <li>You need to set the "Order Amount Variable Name" and the "Order Id Variable Name" used in your shopping cart or registration page.&nbsp;&nbsp;This step is needed to get the actual shopping amount and the order id for the shopping performed, OR the user id for the registration that was done.</li>
                                        <li>Click &quot;Update &amp; move to Next Page&quot; button to get the tracking codes</li>
                                        <li>You can use either the &quot;Image&quot; or the &quot;Javascript&quot; code under the &quot;Tracking Code for Lead&quot; section.</li>
                                        <li>Please take care to replace <?php highlight_string('<?=$orderId?>')?> in the lead code with your server side script notations for the orderid variable used in your website.</li>
                                    </ul>
                                    </td></tr>
                                    
                                    <tr><td align="left" class="subHead">
                                    Sample Image Lead Code
                                    </td></tr>
                                    <tr><td align="left">
                                    	<textarea ><?php echo '<img src="'.$track_site_url.'/trackingcode_lead.php?mid=xxx&sec_id=xxx&orderId=<?=$orderId?>" height="1" width="1" alt="" /> ';?>
                                    	</textarea>
                                    </td></tr>
                                    
                                     <tr><td align="left" class="subHead">
                                    Sample Javascript Lead Code
                                    </td></tr>
                                    <tr><td align="left">
                                    	<textarea ><?php echo '<script language="JavaScript" type="text/javascript" 
 src="'.$track_site_url.'/trackingcode_lead.php?mid=xxx&sec_id=xxx&orderId=<?=$orderId?>">
</script> ';?>
                                    	</textarea>
                                    </td></tr>
                               </table>
                        	</td>
                        </tr>
                          
                        
                    	<tr><td align="center" class="subHead" >
                        <img src="images/step.png" border="0" alt="LEAD Code Integration" />&nbsp;SALE Code Integration
                        </td></tr>
                          
                    	<tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
                                	<tr>
                                    	<td align="left">
                                        	Sales are purchases made at the Merchant's website referred by Affiliates.&nbsp;&nbsp;Affiliate Network Pro tracks purchases that are referred by the Affiliates and provides appropriate commissions to them.&nbsp;&nbsp;Merchants can get the Sale Tracking code by performing the following steps:
                                       	</td>
                                    </tr>
                                    <tr>
                                    	<td align="left">
                                            <ul>
                                                <li>Login to your Merchant Control Panel at Affiliate Network Pro</li>
                                                <li>Click on the link "Get Tracking Code" in the "Home" page of your Merchant Control Panel</li>
                                                <li>You need to set the "Order Amount Variable Name" and the "Order Id Variable Name" used in your shopping cart or registration page.&nbsp;&nbsp;This step is needed to get the actual shopping amount and the order id for the shopping performed, OR the user id for the registration that was done.</li>
                                                <li>Click &quot;Update &amp; move to Next Page&quot; button to get the tracking codes</li>
                                                <li>You can use either the &quot;Image&quot; or the &quot;Javascript&quot; code under the &quot;Tracking Code for Sale&quot; section.</li>
                                                <li>Please take care to replace <?php highlight_string('<?=$orderId?>')?> and <?php highlight_string('<?=$orderAmount?>')?> in the sale code with your server side script notations for the orderid and total amount variable used in your website.</li>
                                            </ul>
                                    	</td>
                                    </tr>
                                    
                                    <tr><td align="left" class="subHead">
                                    Sample Image Sale Code
                                    </td></tr>
                                    <tr><td align="left">
                                    	<textarea ><?php echo '<img src="'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=<?=$orderAmount?>&orderId=<?=$orderId?>" height="1" width="1" alt="" />'; ?>
                                    	</textarea>
                                    </td></tr>
                                    
                                     <tr><td align="left" class="subHead">
                                    Sample Javascript Sale Code
                                    </td></tr>
                                    <tr><td align="left">
                                    	<textarea ><?php echo '<script language="JavaScript" type="text/javascript"   
 src="'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=<?=$orderAmount?>&orderId=<?=$orderId?>">
</script>'; ?>
                                    	</textarea>
                                    </td></tr>
                               </table>
                        	</td>
                        </tr>
                        
                        <tr>
                        	<td align="left">
                            This is it!!.&nbsp;&nbsp;Now whenever there's sale or lead the tracking codes placed in your web page is called, and it will generate commission for the affiliate. 
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