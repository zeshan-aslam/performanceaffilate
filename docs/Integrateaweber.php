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

        <title>AWeber Integration for Lead and Sale</title>

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
                        	<td align="center" class="MainHead" >AWeber</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >
								This integration method is for AWeber application by www.aweber.com
The integration can create unique lead commission after verification of the email address of the customer. You can also use part of this integration to automatically create affiliate after customer confirms his email address.
                        	</td>
                        </tr>
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
						<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 1 Necessary settings
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">First, you have to setup AWeber. Navigate to My Lists tab and to Confirmed Opt-In. Here, you should setup email text but the most important part is to define <b>Confirmation Success Page</b>. Insert the link to your "after confirmation" page here - the page will contain lead tracking code and API code for adding new affiliate. This page have to be PHP. Lets say we will create the page named lead.php
                                        </td>
                                    </tr>
									<tr>
										<td align="left">
											<textarea ><?php echo $track_site_url.'/lead.php'; ?></textarea> 
										</td>
									</tr>
                               </table>
                        	</td>
                        </tr>
						  
						<tr>
                        	<td align="center" class="subHead" > 
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 2 Adding the code for lead tracking
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">In our file lead.php there is already some code with message "Thank you for .......". This is a page where only approved customer can come, so this is the best place to insert lead tracking code. Please, insert it to the end of the page code, over the &lt;/body&gt; tag.
                                        </td>
                                    </tr>
									<tr>
										<td align="left">
                                    	<textarea ><?php echo '<script language="JavaScript" type="text/javascript" src="'.$track_site_url.'/trackingcode_lead.php?mid=xxx&sec_id=xxx&orderId=<?=$orderId?>"></script> ';?>
                                    	</textarea>
										</td>
									</tr>
                               </table>
                        	</td>
                        </tr>
                                    
                        
                        <tr><td height="25" >&nbsp;</td></tr>
                        
                        
                    </table>
                </td>
			</tr>            
            <tr>
            <td height="30" align="center" class="footer_sep">Copyright 2009 &copy; Affiliate Network Pro</td>
            </tr>
        </table>


    </body>
</html>