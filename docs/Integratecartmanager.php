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

        <title>Cart Manager Integration for Lead and Sale</title>

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
                        	<td align="center" class="MainHead" >Cart Manager</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" > Integration with Cart Manager can be made using the Approval URL supported by them.                        	</td>
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
                                    	<td align="left">Login to your CartManager admin center and click <b> Advanced Settings</b>.
                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>
                          
                        <tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 2 Locate integration place
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Find the box labeled: <b>HTML For Bottom of Receipt.</b>
                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>
                        <tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 3 Integration
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Place the following code into the box.
                                        </td>
                                    </tr>
									<tr>
										<td align="left">
                                    	<textarea ><?php echo '<script language="JavaScript" type="text/javascript"   
 src="'.$track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=<?=$orderAmount?>&orderId=<?=$orderId?>">
</script>'; ?>
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
                               </table>
                        	</td>
                        </tr>
                        <tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 4 Finished
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">It is now integrated. Every time customer enters the order confirmation page the tracking code is called and it will register a sale for referring affiliate.

                                        </td>
                                    </tr>
                               </table>
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