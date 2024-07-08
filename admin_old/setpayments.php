<?php
	//Last Modified by DPT on June/1/05 to add provision for updating maximum amount limits for merchants/affiliates/admin

	/*get messages from files	
	$filename			= "merchant_maximum_balance_msg.htm";
	$fp 				= fopen($filename,'r');
	$merchant_message 	= fread ($fp, filesize ($filename));
	fclose($fp);
	$filename			= "affiliate_maximum_balance_msg.htm";
	$fp 				= fopen($filename,'r');
	$affiliate_message 	= fread ($fp, filesize ($filename));
	fclose($fp);
	$filename			= "admin_maximum_balance_msg.htm";
	$fp 				= fopen($filename,'r');
	$admin_message 		= fread ($fp, filesize ($filename));
	fclose($fp);*/
?>
<div align="center">
<table border='0' cellpadding="2" cellspacing="1" width="90%" class="tablebdr">
	<tr>
		<td colspan="4" height="18" class="tdhead"><b>Change Subscription Amounts For Merchant</b></td>
	</tr>
 	<tr>
    	<td colspan="4" height="18" align="center" class="textred"><small><?=$_GET['msg']?></small></td>
  	</tr>
  	<tr><td height="18" colspan="4">&nbsp;</td></tr>
    <tr>
      <td height="26">&nbsp;</td>
      <td height="26" colspan="3">
	  	  <form name="normalupdate" action="admin_payments_manage.php" method="post">
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="44%" height="26" align="center">Normal</td>
			  <td width="20%" align="left"><input type="text" name="normal" size="6" value="<?=$normal_user?>" tabindex="1" /></td>
			  <td width="36%" align="center"><input type="submit" value="Modify Normal Amount" name="action" tabindex="2" /></td>
			</tr>
		  </table>
		  </form>
	  </td>
    </tr>
	<tr>
    	<td height="26">&nbsp;</td>
    	<td height="26" colspan="3" valign="top">
			<form name="advancedupdate" action="admin_payments_manage.php" method="post">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="44%" height="26" align="center">Advanced</td>
				<td width="20%" align="left"><input type="text" name="advanced" size="6" value="<?=$advanced_user?>"  tabindex="1" /></td>
				<td width="36%" align="center"><input type="submit" value="Modify Advanced Amount" name="action" tabindex="2" /></td>
			  </tr>
			</table></form>
		</td>
  	</tr>
  	<tr>
    <td height="26">&nbsp;</td>
    <td height="26" colspan="3" valign="top">
	<form name="Memtypeupdate" action="admin_payments_manage.php" method="post">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="44%" height="26" align="center" valign="top">Membership Payment Type</td>
        <td width="20%" align="left">
			<input name="membershiptype" type="radio" value="1" class="bdrless" <?php echo ($membership_type==1)? "checked='checked'":''?> onclick="displayMemDiv()" />
            <b>One-Time</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br /><input name="membershiptype" type="radio" value="2" class="bdrless" <?php echo ($membership_type==2)? "checked='checked'":''?> onclick="displayMemDiv()" />&nbsp;<b>Recurring</b>
            <div style="visibility:hidden" id="RecurMem">
              <?
                list($recurMem_value,$recurMem_period) =explode(" ",trim($membership_value))
              ?>
              <br /><b> Recurring Period</b><br/> <input name="recurMem_value" type="text" value="<?php echo $recurMem_value?>" size="3" />
              					<select size="1" name="recurMem_period">
                                <option value="day" <?php echo ($recurMem_period=="day")? "selected='selected'":''?>>Day(s)</option>
                                <option value="month" <?php echo ($recurMem_period=="month")? "selected='selected'":''?>>Month(s)</option>
                                <option value="year"  <?php echo ($recurMem_period=="year")? "selected='selected'":''?>>Year(s)</option>
								</select>
            </div>
			<script language="javascript" type="text/javascript">
				for (i=0; i < document.Memtypeupdate.elements.length; i++)
         		{
           			if(document.Memtypeupdate.elements[i].checked == true){
            			if((document.Memtypeupdate.elements[i].value)==2)
                   			document.getElementById("RecurMem").style.visibility = "visible";
            			else   document.getElementById("RecurMem").style.visibility = "hidden";
           			}
         		}
			</script>
			</td>
        <td width="36%" align="center"><input type="submit" value="Membership Type" name="action" tabindex="2" /></td>
      </tr>
    </table></form>
	</td>
  </tr>
  <tr>
    <td height="18" colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="4" height="18" class="tdhead"><b>Change Minimum Balance</b></td>
  </tr>
   <tr>
    <td height="18" colspan="4">&nbsp;</td>
  </tr>
  <tr>
     <td height="26">&nbsp;</td>
     <td height="26" colspan="3">
		 <form name="advancedupdate" action="admin_payments_manage.php" method="post">
		 <table width="100%"  border="0" cellspacing="0" cellpadding="0">
		   <tr>
			 <td height="26" align="center" width="44%">Minimum Amount</td>
			 <td align="left" width="20%"><input type="text" name="minimumamount" size="6" value="<?=$minimum_amount?>"  tabindex="1" /></td>
			 <td align="center" width="36%"><input type="submit" value="Modify Minimum Amount" name="action" tabindex="2" /></td>
		   </tr>
		 </table></form>
	 </td>
  </tr>
  <tr><td height="26" colspan="4">&nbsp;</td></tr>
  <tr>
    <td colspan="4" height="18" class="tdhead"><b>Change Program Settings</b></td>
  </tr>
  <tr><td height="18" colspan="4">&nbsp;</td></tr>
    <tr>
      <td height="26">&nbsp;</td>
      <td height="26" colspan="3">
	  	  <form name="saleupdate" action="admin_payments_manage.php" method="post">
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="44%" align="center">Program Fee</td>
			  <td width="20%" align="left"><input type="text" name="program" size="6" value="<?=$program_fee?>" tabindex="1" /></td>
			  <td width="36%" align="center"><input type="submit" value="Program Fee" name="action" tabindex="2" /></td>
			</tr>
		  </table></form>
	  </td>
    </tr>
    <tr>
      <td height="26">&nbsp;</td>
      <td height="18" colspan="3" valign="top">
		  <form name="typeupdate" action="admin_payments_manage.php" method="post">
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="44%" align="center" valign="top">Program Payment Type</td>
			  <td width="20%" align="left">
			  	<input name="programtype" type="radio" value="1" class="bdrless" <?php echo ($program_type==1)? "checked='checked'":''?> onclick="displayDiv()" />
            	<b>One-Time</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	<br /><input name="programtype" type="radio" value="2" class="bdrless" <?php echo ($program_type==2)? "checked='checked'":''?> onclick="displayDiv()" />&nbsp;<b>Recurring</b>
            	<div style="visibility:hidden" id="Recur">
				<?
					list($recur_value,$recur_period) =explode(" ",trim($program_value))
				?>
              	<br /><b> Recurring Period</b><br/> <input name="recur_value" type="text" value="<?php echo $recur_value?>" size="3" />
					<select size="1" name="recur_period">
					<option value="day" <?php echo ($recur_period=="day")? "selected='selected'":''?>>Day(s)</option>
					<option value="month" <?php echo ($recur_period=="month")? "selected='selected'":''?>>Month(s)</option>
					<option value="year"  <?php echo ($recur_period=="year")? "selected='selected'":''?>>Year(s)</option>

					</select>
            	</div>
				<script language="javascript" type="text/javascript">
        		for (i=0; i < document.typeupdate.elements.length; i++)
         		{
           			if(document.typeupdate.elements[i].checked == true){
            			if((document.typeupdate.elements[i].value)==2)
                   			document.getElementById("Recur").style.visibility = "visible";
            			else   document.getElementById("Recur").style.visibility = "hidden";
           			}
         		}
  				</script>
			  </td>
			  <td width="36%" align="center"><input type="submit" value="Program Type" name="action" tabindex="2" /></td>
			</tr>
		  </table>
		  </form>
	  </td>
    </tr>
  <tr><td height="18" colspan="4">&nbsp;</td></tr>
  <tr><td colspan="4" height="18" class="tdhead"><b>Change Transaction Amounts</b></td></tr>
  <tr><td height="18" colspan="4">&nbsp;</td></tr>
<?php
	//by default click and lead will be in flat rate and sale will be in percentage
	//$click_type1 = $lead_type1 = $sale_type2 = "checked = 'checked'";
	//mark the selected one
	if($admin_clickrate_type=="percentage") $click_type2 = "checked = 'checked'";
	if($admin_clickrate_type=="flatrate") $click_type1 = "checked = 'checked'";
	if($admin_leadrate_type=="percentage") $lead_type2 = "checked = 'checked'";
	if($admin_leadrate_type=="flatrate") $lead_type1 = "checked = 'checked'";
	if($admin_salerate_type=="percentage") $sale_type2 = "checked = 'checked'";
	if($admin_salerate_type=="flatrate") $sale_type1 = "checked = 'checked'";
?>  

<!-- Modified on 16-JUNE-06 -->
  <tr>
    <td height="26">&nbsp;</td>
    <td height="26" colspan="3">
                <form name="impupdate" action="admin_payments_manage.php" method="post">
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                        <td width="44%" align="center">Impression Rate</td>
                        <td width="26%" align="left"><input type="text" name="imprate" size="6" value="<?=$const_imp_rate?>" tabindex="1" />&nbsp;<?=$currSymbol?></td>
                        <td width="30%" align="left"><input type="submit" value="Modify Impression" width="60" name="action" tabindex="2" /></td>
                  </tr>
                </table></form>
        </td>
  </tr>
  <!-- End Modify -->

  <tr>
    <td height="26">&nbsp;</td>
    <td height="26" colspan="3">
		<form name="clickupdate" action="admin_payments_manage.php" method="post">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="44%" align="center">Click Rate</td>
			<td width="20%" align="left" valign="bottom">
			<input type="text" name="click" size="6" value="<?=$admin_clickrate?>" tabindex="1" />
			<input name="rad_click_type" type="radio" value="flatrate" <?=$click_type1?> /><?=$currSymbol?>
			<input name="rad_click_type" type="radio" value="percentage" <?=$click_type2?> />%</td>
			<td width="36%" align="center"><input type="submit" value="Modify Click Amount" name="action" tabindex="2" /></td>
		  </tr>
		</table></form>
	</td>
  </tr>
  <tr>
    <td height="26">&nbsp;</td>
    <td height="26" colspan="3">
		<form name="leadupdate" action="admin_payments_manage.php" method="post">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="44%" align="center">Lead Rate</td>
			<td width="20%" align="left"><input type="text" name="lead" size="6" value="<?=$admin_leadrate?>" tabindex="1" />
              <input name="rad_lead_type" type="radio" value="flatrate" <?=$lead_type1?> />
<?=$currSymbol?>
<input name="rad_lead_type" type="radio" value="percentage" <?=$lead_type2?> />
%</td>
			<td width="36%" align="center"><input type="submit" value="Modify Lead Amount" name="action" tabindex="2" /></td>
		  </tr>
		</table></form>
	</td>
  </tr>
  <tr>
    <td height="26">&nbsp;</td>
    <td height="26" colspan="3">
		<form name="saleupdate" action="admin_payments_manage.php" method="post">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="44%" align="center">Sale Rate&nbsp;</td>
			<td width="20%" align="left"><input type="text" name="sale" size="6" value="<?=$admin_salerate?>" tabindex="1" />
              <input name="rad_sale_type" type="radio" value="flatrate" <?=$sale_type1?>  />
<?=$currSymbol?>
<input name="rad_sale_type" type="radio" value="percentage" <?=$sale_type2?> />
%</td>
			<td width="36%" align="center"><input type="submit" value="Modify Sale Amount" name="action" tabindex="2" /></td>
		  </tr>
		</table></form>
	</td>
  </tr>
  <tr><td height="18" colspan="4">&nbsp;</td></tr>
  <tr>
    <td colspan="4" height="18" class="tdhead"><b>Change Minimum Withdraw Amount Of Affiliates</b></td>
  </tr>
  <tr><td height="18" colspan="4">&nbsp;</td></tr>
  <tr>
      <td height="26">&nbsp;</td>
      <td height="26" colspan="3">
	  	  <form name="saleupdate" action="admin_payments_manage.php" method="post">
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="44%"  height="26" align="center">Minimum Withdraw Amount</td>
			  <td width="20%" align="left"><input type="text" name="withdraw" size="6" value="<?=$minimum_withdraw?>" tabindex="1" /></td>
			  <td width="36%" align="center"><input type="submit" value="Minimum Withdraw Amount" name="action" tabindex="2" /></td>
			</tr>
		  </table></form>
	  </td>
  </tr>
  <tr><td height="18" colspan="4">&nbsp;</td></tr>
  <tr>
    <td colspan="4" height="18" class="tdhead"><b>Change Maximum Amount Limit</b></td>
  </tr>
  <tr><td height="18" colspan="4">&nbsp;</td></tr>
  <tr><td height="18">&nbsp;</td>
    <td height="18" colspan="3">
	<form name="saleupdate" action="admin_payments_manage.php" method="post">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="44%"  height="26"align="center" >For Merchants</td>
        <td width="20%" align="left" ><input type="text" name="maximum_merchant" size="6" value="<?=$merchant_maximum_amount?>" tabindex="1" /></td>
        <td width="36%" align="center" > <input type="submit" value="Modify For Merchants" name="action" tabindex="2" /></td>
      </tr>
    </table></form></td>
  </tr>
  <tr><td height="6" colspan="4"></td></tr>
  <tr><td height="18">&nbsp;</td>
    <td height="18" colspan="3">
	<form name="saleupdate" action="admin_payments_manage.php" method="post">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="26" width="44%" align="center">For Affiliates</td>
        <td width="20%" align="left"><input type="text" name="maximum_affiliate" size="6" value="<?=$affiliate_maximum_amount?>" tabindex="1" /></td>
        <td width="36%" align="center"><input type="submit" value="Modify For Affiliates" name="action" tabindex="2" /></td>
      </tr>
    </table></form></td>
  </tr>
  <tr><td height="6" colspan="4"></td></tr>
  <tr><td height="18">&nbsp;</td>
    <td height="18" colspan="3">
	<form name="saleupdate" action="admin_payments_manage.php" method="post">	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="26"  width="44%" align="center">For Admin</td>
        <td width="20%"align="left"><input type="text" name="maximum_admin" size="6" value="<?=$admin_maximum_amount?>" tabindex="1" /></td>
        <td width="36%" align="center"><input type="submit" value="Modify For Admin" name="action" tabindex="2" /></td>
      </tr>
    </table></form></td>
  </tr>
  <tr>
    <td height="26" colspan="4">&nbsp;</td>
  </tr>
  </table>
 </div><br />
  <script language="javascript" type="text/javascript">
    	function displayDiv(){
        for (i=0; i < document.typeupdate.elements.length; i++){
           if(document.typeupdate.elements[i].checked == true){
            	if((document.typeupdate.elements[i].value)==2)
                   	   document.getElementById("Recur").style.visibility = "visible";
            	else   document.getElementById("Recur").style.visibility = "hidden";
           }
         }

        }
       	function displayMemDiv(){
     	  for (i=0; i < document.Memtypeupdate.elements.length; i++)  {
           	if(document.Memtypeupdate.elements[i].checked == true) {
            	if((document.Memtypeupdate.elements[i].value)==2)
                   document.getElementById("RecurMem").style.visibility = "visible";
            	else   document.getElementById("RecurMem").style.visibility = "hidden";
           }
         }
        }
  </script>