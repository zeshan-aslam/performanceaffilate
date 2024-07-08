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

        <title>XtCommerce Integration for Lead and Sale</title>

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
                        	<td align="center" class="MainHead" >XtCommerce</td>
                        </tr>
                        <tr><td height="10" >&nbsp;</td></tr>
                        
                    	<tr>
                    	  	<td align="left" >Integration with XtCommerce is made by changing checkout_success.php file.
                        	</td>
                        </tr>
                        
                        <tr><td height="10" >&nbsp;</td></tr>
                        
						<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 1 Edit template
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Find and open checkout_success.php file.
										</td>
                                    </tr>
                               </table>
                        	</td>
                        </tr>
						
						<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 2 Integration
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Put the following code right before line "if (DOWNLOAD_ENABLED == 'true')".
										</td>
                                    </tr>
									<tr>
										<td align="left">
<textarea >
//--------------------------------------------------------------------------
 // Affiliate Network Pro code
 // The code below will get the order_id and total value of recent order
 // from the database and displays invisible image that registers the sale
 // for affiliate (if some affiliate referred this visitor)
 //--------------------------------------------------------------------------
   $sql = "select orders_id from ".TABLE_ORDERS." where customers_id='".$_SESSION['customer_id']."' order by orders_id desc limit 1";
   $pap_orders_query = xtc_db_query($sql);
   $pap_orders = xtc_db_fetch_array($pap_orders_query);
   $order_id = $pap_orders['orders_id'];
 
   // get total amount of order
   $sql = "select value from ".TABLE_ORDERS_TOTAL.
          " where orders_id='".(int)$order_id."'";
   $pap_orders_total_query = xtc_db_query($sql);
   $pap_orders_total = xtc_db_fetch_array($pap_orders_total_query);
   $total_value = $pap_orders_total['value'];
 
   // draw sale tracking code to register sale
   if($total_value != "" && $order_id != "")
   { 
      $smarty->assign('ANP_sale_tracking',"<script language=\"JavaScript\" type=\"text/javascript\"   
src=\"<?=$track_site_url?>/trackingcode_sale.php?mid=xxx&sec_id=xxx&sale=<?=$total_value?>&orderId=<?=$order_id?>\">
</script>");
   }
 //--------------------------------------------------------------------------
 // END of Affiliate Network Pro code
 //------------------------------------------------------------------

</textarea> 
										</td>
									</tr>
                               </table>
                        	</td>
                        </tr>
						
						<tr>
                        	<td align="center" class="subHead" >
                        		<img src="images/step.png" border="0" alt="LEAD Code Integration" /> 3 Edit template 
                        	</td>
                        </tr>
                        <tr>
                    	  	<td align="left" class="leftPad" >
                            	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
									<tr>
                                    	<td align="left">Find and open /templates/xtc4/module/checkout_success.html file.
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
                                    	<td align="left"> Put the following code right before line " {if $downloads_content neq '}".
										</td>
                                    </tr>
									<tr>
										<td align="left">
<textarea ><!-- START of Post Affiliate Pro code -->
 {$ANP_sale_tracking}
 <!-- END of Post Affiliate Pro code -->
</textarea> 
										</td>
									</tr>
                               </table>
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