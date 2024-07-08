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

        <title>2Checkout Integration for Lead and Sale</title>

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
                        	<td align="center" class="MainHead" >2Checkout</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >
								2Checkout system has two versions (1 and 2).&nbsp;&nbsp;Affiliate Network Pro can be easily integrated with both of them.&nbsp;&nbsp;The way of integration is the same, the versions differ only in structure of menu in 2checkout control panel.&nbsp;&nbsp;2Checkout directly supports putting the hidden image tag on the sales confirmation page.
                        	</td>
                        </tr>
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                        	<td align="center" class="subHead" >
                        		Integrate with 2CO
                        	</td>
                        </tr>
                          
                    	<tr>
                    	  	<td align="left" >
								Log-in to 2Checkout vendor panel, go to Look and Feel and put the following URL to the Affiliate URL field:
                        	</td>
                        </tr>
                        
                        <tr>
                        	<td align="left">
                                <textarea ><?php echo $track_site_url.'/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=$a_total&orderId=$a_order" '; ?>
                                </textarea> 
                        	</td>
                        </tr>
                                    
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >
								This is it!!.&nbsp;&nbsp;Now whenever there's sale, 2checkout will call our sale tracking script, and system will generate commission for the affiliate.
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