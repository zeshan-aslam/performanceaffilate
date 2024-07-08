 <?
#------------------------------------------------------------------------------
# getting mercahnt status
#------------------------------------------------------------------------------

    $mid = $_SESSION['MERCHANTID'] ;

    $sql	=	"select * from partners_merchant where merchant_id='$mid'";
    $ret	=	mysqli_query($con,$sql);
    if(mysqli_num_rows($ret)>0) {
             $row		= mysqli_fetch_object($ret);
             $randNo	= trim($row->merchant_randNo);
             $orderId	= trim($row->merchant_orderId);
             $saleAmt	= trim($row->merchant_saleAmt);
    }

	 $orderid = "<?=$".$orderId."?>";
     $saleamt = "<?=$".$saleAmt."?>";
 ?>
	<p align="center" >
    	<b><a href="../docs/IntegrationMethods.php" target="_blank" ><?=$lang_shoppingCartIntegration?></a></b>
    </p>
  <br/>
  <table border="0" cellpadding="0"   width="80%" class="tablebdr"  align="center">
      <tr>
          <td width="100%" height="26" colspan="2" class="tdhead" align="center"><b><?=$lgetcode_TrackingCodeforLead?></b></td>
     </tr>
     <tr>
    	 <td width="100%" height="26"  >
	          <table border="0" cellpadding="0"   width="90%" class="tablewbdr"  align="center">
              	  <tr>
	                  <td width="100%" height="26" colspan="4" >&nbsp;</td>
	              </tr>
	              <tr>
	                <td width="100%" align="center" height="40" colspan="3"> <textarea rows="10" name="headertxt" cols="100" >
	                <?

	                $code =  "\n<!--START $title CODE-->\n\n<img src=\"$track_site_url/trackingcode_lead.php?mid=$mid&amp;sec_id=$randNo&amp;orderId=$orderid\" height=\"1\" width=\"1\" alt=\"\"> \n\n<!-- END $title CODE -->";
	                echo $code;
	                ?>
	                </textarea></td>

	              </tr> 
	              <tr>
	                <td width="100%" align="center" height="40" colspan="3"> <b>OR</b> <br/> <textarea rows="12" name="headertxt" cols="100" >
	                <?  $code = "\n<!--START $title CODE--> \n\n<script language=\"JavaScript\" type=\"text/javascript\" \n src=\"$track_site_url/trackingcode_lead.php?mid=$mid&amp;sec_id=$randNo&amp;orderId=$orderid\">\n</script>\n\n<!-- END $title CODE -->";
	                    echo $code;
	                    ?></textarea>
                    </td>
           	      </tr>
	              <tr>
	                  <td width="100%" height="26" colspan="4" >&nbsp;</td>
	             </tr>
	        </table>
	     </td>
	     <td valign="top">&nbsp;   </td>
		 </tr>
	  <tr>
	         <td width="100%" height="26" colspan="2" class="tdhead" align="center"><b><?=$lgetcode_TrackingCodeforSale?></b></td>
	  </tr>
      <tr>
	        <td width="100%" height="26"  >
          	    <table border="0" cellpadding="0"   width="99%" class="tablewbdr"  align="center">
	               <tr>
	                  <td width="100%" height="26" colspan="4" >&nbsp;</td>
	             </tr>
	              <tr>
	                <td width="100%" align="center" height="40" colspan="3"> <textarea rows="10" name="headertxt" cols="100" >
	                <?
	                $code =  "\n<!--START $title CODE-->\n\n<img src=\"$track_site_url/trackingcode_sale.php?mid=$mid&amp;sec_id=$randNo&amp;sale=$saleamt&amp;orderId=$orderid\" height=\"1\" width=\"1\" alt=\"\"> \n\n<!-- END $title CODE -->";
	                echo $code;
	                ?>
	                </textarea></td>
	            </tr>
	             <tr >
	                <td width="100%" align="center" height="40" colspan="3"> <b>OR</b> <br/> <textarea rows="12" name="headertxt" cols="100" >
	                <?  $code = "\n<!--START $title CODE--> \n\n<script language=\"JavaScript\" type=\"text/javascript\"   \n src=\"$track_site_url/trackingcode_sale.php?mid=$mid&amp;sec_id=$randNo&amp;sale=$saleamt&amp;orderId=$orderid\">\n</script>\n\n<!-- END $title CODE -->";
	                    echo $code;
	                    ?></textarea></td>
           	       </tr>
	               <tr>
	                  <td width="100%" colspan="4">&nbsp;</td>
	             </tr>
	           </table>
	       </td>
	       <td valign="top">&nbsp; </td>
 </tr>
 </table>
<br />