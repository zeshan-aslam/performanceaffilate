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

        <title>ClickCartPro Integration for Lead and Sale</title>

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
                        	<td align="center" class="MainHead" >ClickCartPro</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" > Integration with ccBill can be made using the Approval URL supported by them. Go to Account Maintenance -&gt; Account Admin.                         	</td>
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
                                    	<td align="left">Login to your ClickCartPro <b>Admin Center</b> and go to the <b>Main Menu.</b>


                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>                          
                        <tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 2 Manage Site Elements
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">go to <b>HTML Pages and Elements -&gt; Manage Site Elements.</b>
                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>
						 <tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 3 Update template
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Open and update this template: Order Confirmation - Third Party Affiliate Program Placeholder.

                                        </td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>
						
						<tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 4 Integration
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left"> Place the following code anywhere in the box (all in one line) and click submit:
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
                               </table>
                        	</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >
								This is all that is required. Now whenever there's sale, ClickCartPro will call our sale tracking script, and system will generate commission for the affiliate.
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