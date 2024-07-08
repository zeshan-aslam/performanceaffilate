<?php

include_once 'includes/db-connect.php';
	/*  
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	*/
	#------------------------------------------------------------------------------
	# opens terms file
	# reads all contents
	#------------------------------------------------------------------------------
	$filename                = "admin/mer_terms.htm";
	$fp                      = fopen($filename,'r');
	$contents                = fread ($fp, filesize ($filename));
	fclose($fp);
	
	# geting records from table
	$sql 	= " SELECT * FROM partners_paymentgateway WHERE pay_status LIKE 'Active' ";
	$ret 	= mysqli_query($con, $sql);
	
	# getting all currency from admin Panel
	$crnysql 	= " SELECT DISTINCT(currency_caption) FROM partners_currency ";
	$crnyret 	= mysqli_query($con, $crnysql) or die("You have an error while processing sql query ");
	
	
	$msg		= $_GET['msg'];
	$Action		= $_GET['Action'];
	
	if ($Action=="affiliate")     
		$aff	= "selected = 'selected' ";
	else                          
		$mer	= "selected = 'selected' ";
?>

<table width="661" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <!--<td><img src="images/merchants-top.jpg" width="348" height="26" /></td>-->
                <td class="merchants-reg-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;<?=$MerchantRegistration?></div></td>
              </tr>
              <tr>
                <td class="merchants-reg-content-bg"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="100%" rowspan="2" align="left" valign="top">
		<form method="post" name="reg" action="reg_validate.php?mode=insert">     
		<table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">

			<tr>
			<td height="280" colspan="2" >
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="AutoNumber1" style="border-collapse: collapse">
				<tr>
				<td colspan="6" height="19" class="textred" align="center">
				<span class="error"><?=$msg?> &nbsp;</span></td>
				</tr>
			<tr>
			<td width="1%" height="26">&nbsp;</td>
			<td width="14%" height="26"><span class="error">*</span> <?=$lang_FirstName?></td>
			<td width="35%" height="26">
			<input type="text" name="firstnametxt" size="20" value="<?=stripslashes($_GET['firstname'])?>" /></td>
			<td width="14%" height="29"><span class="error">*</span> <?=$lang_LastName?></td>
			<td width="35%" height="29">
			<input type="text" name="lastnametxt" size="20" value="<?=stripslashes($_GET['lastname'])?>"/></td>
			<td width="1%" height="26">&nbsp;</td>
			</tr>
			<tr>
			<td width="1%" height="29">&nbsp;</td>
			<td width="18%" height="26"><span class="error">*</span> <?=$lang_Category?></td>
			<td width="31%" height="26">
			<select size="1" name="categorylst">
			<option selected='selected' value="nill"><?=$selectacategory?></option>
			<?php
			$sql    = "SELECT * FROM partners_category";
			$result = mysqli_query($con, $sql);
			?>
			<?php
			while($row=mysqli_fetch_object($result)){
				if($category==$row->cat_name){
			?>
					<option value="<?=$row->cat_name?>" selected="selected" ><?=$row->cat_name?></option>
			<?php
				}
				else{
			?>
					<option value="<?=$row->cat_name?>" ><?=$row->cat_name?></option>
			<?php
				}
			}
			?>
			</select></td>
			<td width="14%" height="31"><span class="error">*</span> <?=$lang_Company?></td>
			<td width="35%" height="31">
			<input type="text" name="companytxt" size="20" value="<?=stripslashes($_GET['company']) ?>"/></td>
			<td width="1%" height="29">&nbsp;</td>
			</tr>
			<tr>
			<td width="1%" height="31">&nbsp;</td>
			<td width="14%" height="28"><span class="error">*</span> <?=$lang_URL?></td>
			<td width="35%" height="28"><input type="text" name="urltxt" size="20" value="<?=stripslashes($_GET['url']) ?>" /></td>
			
			<td width="18%" height="31"><span class="error">*</span> <?=$lang_Fax?></td>
			<td height="31"><input type="text" name="faxtxt" size="20" value="<?=stripslashes($_GET['fax'])?>"/></td>
			<td width="1%" height="31">&nbsp;</td>
			</tr>
			<tr>
			<td width="1%" height="28">&nbsp;</td>
			<td width="18%" height="29"><span class="error">*</span> <?=$lang_Phone?></td>
			<td height="29"><input type="text" name="phonetxt" size="20" value="<?=stripslashes($_GET['phone'])?>"/></td>
			
			<td width="18%" height="28"><span class="error">*</span> <?=$lang_EmailId?></td>
			<td height="28" ><input type="text" name="emailidtxt" size="20" value="<?=stripslashes($_GET['mailid'])?>" />
			</td>
			<td width="1%" height="28" valign="bottom">&nbsp;</td>
			</tr>
			<tr>
			<td width="1%" height="20">&nbsp;</td>
			<td width="14%" height="42" rowspan="2"><span class="error">*</span> <?=$lang_Address?></td>
			<td width="35%" height="42" rowspan="2">
			<textarea rows="2" name="addresstxt" cols="20"><?=$_SESSION['MER_ADDRESS']?></textarea></td>
			<td width="18%" height="28"><span class="error">*</span> <?=$lang_zip?></td>
			<td height="28" ><input type="text" name="ziptxt" size="20" value="<?=stripslashes($_GET['zip'])?>" /></td>
			<td width="1%" height="20">&nbsp;</td>
			</tr>
			<tr>
				<td width="1%" height="31">&nbsp;</td>
				<td width="17%" height="31"><span class="error">*</span> <?=$lang_City?></td>
				<td width="32%" height="31" colspan="3">
				<input type="text" name="citytxt" size="20" value="<?=stripslashes($_GET['city'])?>" /></td>
				<td width="1%" height="31">&nbsp;</td>
			</tr>
			<tr>
			<td width="1%" height="28">&nbsp;</td>
			<td width="14%" height="28"><span class="error">*</span> <?=$lang_state?></td>
			<td width="35%" height="28">
			<input type="text" name="statetxt" size="20" value="<?=stripslashes($_GET['state']) ?>" /></td>
			<td width="14%" height="28"><span class="error">*</span> <?=$lang_Country?></td>
			<td width="35%" height="28"><select size="1" name="countrylst">
			<option value="nill" ><?=$lang_SelectaCountry?></option>
			<?php
			$sql    = "SELECT * FROM partners_country";
			$result = mysqli_query($con, $sql);
			?>
			<?php
			while($row=mysqli_fetch_object($result)){
				if($country==$row->country_name){
			?>
					<option value="<?=$row->country_name?>" selected ><?=$row->country_name?></option>
			<?php
				}
				else{
			?>
					<option value="<?=$row->country_name?>" ><?=$row->country_name?></option>
			<?php
				}
			}
			?>
			</select></td>
			<td width="1%" height="28">&nbsp;</td>
			</tr>
			<tr>
			<td width="1%" height="28">&nbsp;</td>
			<td width="18%" height="28"><span class="error">* </span><?=$lang_taxId?></td>
			<td height="28"><input type="text" name="taxIdtxt" size="20" value="<?=stripslashes($_GET['taxId']) ?>" />
			</td>
			<td width="14%" height="19"><span class="error">*</span> <?=$lang_Type?></td>
			<td width="35%" height="19"><select size="1" name="typelst">
			<?
			if (trim($type)=="nill") {
				$nill	= "selected = 'selected'";
			}	
			if (trim($type)==$lang_Advance) {
				$adv	= "selected = 'selected'";
			}
			if (trim($type)==$lang_Normal) {
				$nor	= "selected = 'selected'";
			}
			?>
			<option value="nill" <?= ($type=="nill" ? "selected" : "" ) ?>><?=$selectatype?></option>
			<option value="advance" <?= ($type=="advance" ? "selected" : "" ) ?> ><?=$lang_Advance?></option>
			<option value="normal"<?= ($type=="normal" ? "selected" : "" ) ?> ><?=$lang_Normal?></option>
			</select></td>
			
			<td width="1%" height="28" valign="bottom">&nbsp;</td>
			</tr>
			<tr>
			<td width="1%" height="19">&nbsp;</td>
			
			<td width="14%" height="19"><span class="error">* </span><?=$lang_Payment?></td>
			<td width="35%" height="19">
			<select class="dropdown" name="modofpay">
			<? //checking for each records
			if(mysqli_num_rows($ret)>0){
				while($row=mysqli_fetch_object($ret)){     
					if($modofpay==$row->pay_name) 
						$sel	= "selected = 'selected'";
					else 
						$sel 	= "";
			?>
				<option  <?=$sel?>  value="<?=$row->pay_name?>"><?=$row->pay_name?></option>
			<?
				}
			}  
			?>
			</select></td>
			
			<td width="18%" height="19"><?=$merreg_method?></td>
			<td height="28" valign="middle"> 
			<input name="merchant_isInvoice" type="checkbox" value="Yes" class="bdrless" <?php echo ($merchant_isInvoice=="Yes")?"checked='checked'":"" ?> /> &nbsp;&nbsp;<?=$merreg_pay?>
			</td>
			<td width="1%" height="19"></td>
			</tr>
			<tr>
			<td width="1%" height="19"></td>
			
			<td width="18%" height="19"><?=$lang_merchant_currency?> </td>
			<td width="1%" height="19"><select name="merchant_currency">
			<?
			# POPULATE currency
			
			if(mysqli_num_rows($crnyret)>0){
				while($crnyrow = mysqli_fetch_object($crnyret)){
			?>
			<option value="<?=$crnyrow->currency_caption?>" <?=($crnyrow->currency_id==$merchant_currency)?"selected='selected'":""?>><?=trim(stripslashes($crnyrow->currency_caption))?></option>
			<?
				}
			}
			?>
			</select>&nbsp;</td>
			</tr>
			<tr>
			<td height="9"  colspan="6">&nbsp;</td>
			</tr>
			
			<tr>
			<td height="9"  colspan="6">
			<table width="100%">
			<tr>
			<td height="20" bgcolor="#F1CA6F" align="center"><strong><?=$lang_terms_condn?></strong>
			</td>
			</tr>
			<tr>
			<td height="19">&nbsp;
			
			</td>
			</tr>
			<tr>
			<td height="19" align="center"><textarea name="termsCondn" cols="80" rows="5"><?=stripslashes($contents)?></textarea>
			</td>
			</tr>
			<tr>
			<td height="19">&nbsp;
			
			</td>
			</tr>
			<tr>
			<td height="19" align="center"><input name="terms" type="checkbox" value="1" /> <?=$lang_terms?>
			</td>
			</tr>
			</table></td>
			</tr>
			
			<tr>
			<td height="9"  colspan="6"><div align="center"><input type="submit" value="Register" name="B1"/></div></td>
			</tr>
			</table>
			</td>
			</tr>
			</table></form></td>
	</tr>
	</table></td>
              </tr>
              <tr>
                <td><img src="images/merchant-reg-bottom.jpg" width="661" height="12" /></td>
              </tr>
          </table></td>
        </tr>
      </table>
