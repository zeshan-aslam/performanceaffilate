<?php	

include_once 'includes/db-connect.php';

#-------------------------------------------------------------------------------
# Affilaite Registration Page
# Payment Gateways supported Are
# Paypal, Authorize.net, StormPay, eGold, check by mail, wire Transfer, Neteller

# Pgmmr        : RR
# Date Created :   28-10-2004
# Date Modfd   :   29-10-2004
# Last Modified:   DPT on May/17/05 to add quotes to all value attributes on form
# Last Modified:   DPT on May/28/05 to fix issues with HTML tags
#-------------------------------------------------------------------------------

//Getiing Referer Affiliate Id if any
	$referer 	= $_REQUEST['referer'];
	if(!empty($referer))
	{
		$_SESSION['AFFILIATE_REFERER_ID'] = $referer;
	}
# geting all payments gateways supported
# and its associated parametrs
  $sql ="select * from partners_paymentgateway where pay_status like 'Active' and pay_name NOT LIKE 'WorldPay'";
  $ret =mysqli_query($con, $sql);

# getting back form variable

# Err mgs
    $msg                 = trim(stripslashes($_GET['msg']));
    $err				 = $_GET['err'];
# Personal Information
    $firstname           = stripslashes($_GET['firstname']);
    $lastname            = stripslashes($_GET['lastname']);
    $company             = stripslashes($_GET['company']);
    $url                 = stripslashes($_GET['url']);
    $address             = stripslashes($_GET['address']);
    $city                = stripslashes($_GET['city']);
    $category            = stripslashes($_GET['category']);
    $phone               = stripslashes($_GET['phone']);
    $fax                 = stripslashes($_GET['fax']);
    $mailid              = stripslashes($_GET['mailid']);
    $country             = stripslashes($_GET['country']);
    //$address             = stripslashes($_GET['address']);
	$address             = $_SESSION['AFF_ADDRESS'];
    $minimumcheck        = stripslashes($_GET['minmumcheck']);
    $affiliateid         = intval(stripslashes($_GET['affiliateid']));
    $modofpay            = stripslashes($_GET['modofpay']);
   	$taxIdtxt            = stripslashes(trim($_GET['taxIdtxt']));
	
	$currency			= stripslashes(trim($_REQUEST['currency']));   

  if($err=='2'){
     $paymodes            = explode("`~`",$_SESSION['PAYMODE']);


# paypal email
   	$payapalemail     	  =   $paymodes[0];

# storm pay email
    $stormmail       = $paymodes[1];

# egold information
    $payeename        = $paymodes[2];
    $acno             = $paymodes[3];

# checkout information
    $productid        = $paymodes[4];

    $checkoutid       = $paymodes[5];

# authorize.net information.
    $version          = $paymodes[6];

    $delimdata        = $paymodes[7];

    $relayresponse    = $paymodes[8];

    $login            = $paymodes[9];

    $trankey          = $paymodes[10];

    $cctype           = $paymodes[11];


#-------------------------------------------------------------------------
# Aditional informations added
#-------------------------------------------------------------------------
    $zipcode            = $paymodes[12];

    $state              = $paymodes[13];


    $timezone       	= $paymodes[14];



# Neteller account
    $neteller_email 	= $paymodes[15];

    $neteller_accnt	 	= $paymodes[16];


# check by Mail
    $checkpayee     	= $paymodes[17];

    $checkcurr      	= $paymodes[18];



# Wire Transfer
    $wire_AccountName   = $paymodes[19];

    $wire_AccountNumber = $paymodes[20];

    $wire_BankName      = $paymodes[21];

    $wire_BankAddress   = $paymodes[22];

    $wire_BankCity      = $paymodes[23];

    $wire_BankState     = $paymodes[24];

    $wire_BankZip       = $paymodes[25];

    $wire_BankCountry   = $paymodes[26];

    $wire_BankAddressNumber= $paymodes[27];

    $wire_Nominate      = $paymodes[28];


      if($relayresponse=="True")          $relayresponseselected1 = "selected = 'selected'";
      else                                $relayresponseselected2 = "selected = 'selected'";
      if($delimdata=="True")              $delimdataselected1     = "selected = 'selected'";
      else                                $delimdataselected2     = "selected = 'selected'";
      if($cctype=="AUTH_CAPTURE")         $cctypesel1             = "selected = 'selected'" ;
      if($cctype=="AUTH_ONLY")            $cctypesel2             = "selected = 'selected'" ;
      if($cctype=="CAPTURE_ONLY")         $cctypesel3             = "selected = 'selected'" ;
      if($cctype=="CREDIT")               $cctypesel4             = "selected = 'selected'" ;
      if($cctype=="VOID")                 $cctypesel5             = "selected = 'selected'" ;
      if($cctype=="PRIOR_AUTH_CAPTURE")   $cctypesel6             = "selected = 'selected'" ;


   }
    $bankno               = stripslashes($_GET['bankno']);
    $bankname             = stripslashes($_GET['bankname']);
    $bankemail            = stripslashes($_GET['bankemail']);
    $bankaccount          = stripslashes($_GET['bankaccount']);
    $payableto            = stripslashes($_GET['payableto']);


#-------------------------------------------------------------------------
# Aditional informations added
#-------------------------------------------------------------------------
        $zipcode        = trim(stripslashes($_GET['zipcode']));
        $state          = trim(stripslashes($_GET['state']));
        $timezone       = trim(stripslashes($_GET['timezone']));
        $j=-12;
        for($i=0 ;$i<=24 ;$i++)
    		{
     		if($timezone==$j) $sel[$i] ="selected = 'selected'" ;
     		else  $sel[$i] =" " ;
     		$j++;
       }
#-------------------------------------------------------------------------
# Aditional informations added Ends Here
#-------------------------------------------------------------------------

?>

<form method="post" name="reg" action="affil_reg_validate.php?mode=insert" >
<table width="100%"  border="0" cellspacing="1" cellpadding="1">
       	<tr>

			<td  class="error" colspan="3">* <?=$reqd?></td>

		</tr>
		<tr>

			<td align="center" class="error" colspan="3"><?=stripslashes($_GET['msg'])?></td>

		</tr>
        	<tr>

			<td align="center" class="error" colspan="3">&nbsp;</td>

		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td width="20%"><?=$lang_firstname?></td>
    		<td>

				<input type="text" name="firstnametxt" size="20" value="<?=$firstname?>" />

   			</td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td><?=$lang_Last?></td>
    		<td><input type="text" name="lastnametxt" size="20" value="<?=$lastname?>"/></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td><?=$lang_EmailId?></td>
    		<td><input type="text" name="emailidtxt" size="20" value="<?=$mailid?>" /></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td width="20%"><span >
    			<?=$lang_Phone?>
    		</span></td>
    		<td><input type="text" name="phonetxt" size="20" value="<?=$phone?>"/> <span >
    		</span></td>
   		</tr>
    	<tr>
    		<td>&nbsp;</td>
    		<td><?=$lang_Fax?></td>
    		<td><input type="text" name="faxtxt" size="20" value="<?=$fax?>"/></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td width="20%"><?=$lang_Company?></td>
    		<td><input type="text" name="companytxt" size="20" value="<?=$company?>"/></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td width="20%"><?=$lang_URL?></td>
    		<td><input type="text" name="urltxt" size="20" value="<?=$url?>" /></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td><?=$lang_Address?></td>
    		<td><textarea rows="2" name="addresstxt" cols="20"><?=$address ?></textarea></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td width="20%"><?=$lang_City?></td>
    		<td><input type="text" name="citytxt" size="20" value="<?=$city?>" /></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td><?=$lang_state?></td>
    		<td><input type="text" name="state" size="20" value="<?=$state?>" /></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td width="20%"><?=$lang_Country?></td>
    		<td><select size="1" name="countrylst">
            	<option value="nill" >
            	<?=$lang_SelectaCountry?>
            	</option>
            	<?php
        # getting all country from the table
        $sql    = "select * from partners_country";
        $result = mysqli_query($con, $sql);
        while($row=mysqli_fetch_object($result)){
           if($country==$row->country_name){
           ?>
            	<option value="<?=$row->country_name?>" selected='selected' >
            	<?=$row->country_name?>
            	</option>
            	<?php
           }else{
           ?>
            	<option value="<?=$row->country_name?>" >
            	<?=$row->country_name?>
            	</option>
            	<?php
             }
        }
       ?>
            	</select></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td width="20%"><?=$lang_zip?></td>
    		<td><input type="text" name="zipcode" size="20" value="<?=$zipcode?>" /></td>
   		</tr>
        <tr>
    		<td align="right" class="error"></td>
    		<td><?=$lang_taxId?></td>
    		<td><input type="text" name="taxIdtxt" size="20" value="<?=$taxIdtxt?>" /></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td><?=$lang_timezone?></td>
    		<td><select name="timezone">
            	<option <?=$sel[0]?>  	value="-12">Newzealand Time(-12)</option>
            	<option <?=$sel[1]?>	value="-11">Midway Isles, Samoa (-11)</option>
            	<option <?=$sel[2]?>	value="-10">Hawaii (-10)</option>
            	<option <?=$sel[3]?>	value="-9">AKST - Alaska Standard Time(-9)</option>
            	<option <?=$sel[4]?>	value="-8">PST - Pacific Standard Time(-8)</option>
            	<option <?=$sel[5]?>	value="-7">MST - Mountain Standard Time(-7)</option>
            	<option <?=$sel[6]?>	value="-6">CST - Central Standard Time(-6)</option>
            	<option <?=$sel[7]?>	value="-5">EST - Eastern Standard Time(-5)</option>
            	<option <?=$sel[8]?>	value="-4">SA West - Atlantic Time(-4)</option>
            	<option <?=$sel[9]?>	value="-3">SA East - East Brasil Time (-3)</option>
            	<option <?=$sel[10]?>	value="-2">Middle Atlantic (-2)</option>
            	<option <?=$sel[11]?>	value="-1">Island Time (-1)</option>
            	<option <?=$sel[12]?>	value="0">GMT - Greenwitch Meridian Time (0)</option>
            	<option <?=$sel[13]?>	value="1">CET - Central European Time (+1)</option>
            	<option <?=$sel[14]?>	value="2" >EET - East European Time (+2)</option>
            	<option <?=$sel[15]?>	value="3">Irak, Kuwait, Russia(+3)</option>
            	<option <?=$sel[16]?>	value="4">Mauritius, Kazachstan (+4)</option>
            	<option <?=$sel[17]?>	value="5">West Asia (+5)</option>
            	<option <?=$sel[18]?>	value="6">Central Asia (+6)</option>
            	<option <?=$sel[19]?>	value="7">Indo China Time (+7)</option>
            	<option <?=$sel[20]?>	value="8">Chinese Shore Time (+8)</option>
            	<option <?=$sel[21]?>	value="9">JST - Japan Standard Time (+9)</option>
            	<option <?=$sel[22]?>	value="10">AUS - Australian Time(+10)</option>
            	<option <?=$sel[23]?>	value="11">Central Pacifik (+11)</option>
            	<option <?=$sel[24]?>	value="12">Newzealand Time (12)</option>
            	</select></td>
    		<td></td>
   		</tr>
    	<tr>
    		<td align="right" class="error">*</td>
    		<td><?=$lang_Category?></td>
    		<td><select size="1" name="categorylst">
            	<option selected='selected' value="nill">
            	<?=$lang_category?>
            	</option>
            	<?php
           # getting all categories available
             $sql    = "select * from partners_category";
             $result = mysqli_query($con, $sql);
             while($row=mysqli_fetch_object($result)){
                if($category==$row->cat_name) {
                ?>
            	<option value=<?=$row->cat_name?> selected='selected' >
            	<?=$row->cat_name?>
            	</option>
            	<?php
                }else{
                ?>
            	<option value="<?=$row->cat_name?>" >
            	<?=$row->cat_name?>
            	</option>
            	<?php
                }
       }
         ?>
            	</select></td>
    		<td></td>
   		</tr>
<?php
	$refAfId = $_SESSION['AFFILIATE_REFERER_ID'] ;
	$sql    = "SELECT affiliate_id, affiliate_firstname, affiliate_lastname FROM `partners_affiliate`WHERE affiliate_id = '$refAfId' ";
	$result = mysqli_query($con, $sql);
	if(mysqli_num_rows($result) > 0)
	{
	 	$row=mysqli_fetch_object($result);
		$refAffFirstName = ucwords(stripslashes($row->affiliate_firstname));
		$refAffLastname = ucwords(stripslashes($row->affiliate_lastname));
?>
        <tr>
    		<td align="right" class="error"></td>
    		<td><?=$lang_ParentID?></td>
    		<td><?=$refAffFirstName." ".$refAffLastname?></td>
   		</tr>

<?	
	}
		 
/*	
<!--		
  Removed as per Client Request on 21-Sept-2006
    	<tr>
    		<td width="20%">&nbsp;</td>
    		<td width="20%"><?=$lang_ParentID?></td>
    		<td><select size="1" name="affiliateid">
    	<option selected="selected" value="nill">
    	<?=$parentselect?>
    	</option>
    	<?php
                    $sql    = "SELECT affiliate_id, affiliate_firstname, affiliate_lastname FROM `partners_affiliate`WHERE affiliate_status = 'approved' ";
                    $result = mysql_query($sql);
                     while($row=mysql_fetch_object($result)){
                         if($affiliateid==$row->affiliate_id){
                         ?>
    						<option value="<?=$row->affiliate_id?>" selected='selected' >
    						<?=ucwords(stripslashes($row->affiliate_firstname))?>  <?=ucwords(stripslashes($row->affiliate_lastname))?>
       						</option>
    					<?php
                         }else{
                         ?>
    						<option value="<?=$row->affiliate_id?>" >
    						<?=ucwords(stripslashes($row->affiliate_firstname))?>  <?=ucwords(stripslashes($row->affiliate_lastname))?>
    						</option>
    					<?php
                         }
                      }
                     ?>
    	</select></td>
    		<td></td>

   		</tr>
-->
*/
?>		
<!-- Added for Affiliate Currency -->
<?  /*
   $crnysql = " SELECT * FROM partners_currency ";
   $crnyret = mysql_query($crnysql) or die("You have an error while processing sql query ");

?>
    	<tr>
    		<td align="right" class="textred">*</td>
    		<td width="20%"><?=$lang_merchant_currency?></td>
    		<td>
				<select name="affiliate_currency">
                    <?
                    # POPULATE currency

                    if(mysql_num_rows($crnyret)>0){
                      while($crnyrow = mysql_fetch_object($crnyret))
                      {
						  ?><option value="<?=$crnyrow->currency_caption?>" <?=($crnyrow->currency_caption==$currency)?"selected='selected'":""?>><?=trim(stripslashes($crnyrow->currency_caption))?></option><?
                      }
                    }

                    ?>
              	</select>&nbsp;				
			</td>
   		</tr>
<?  */   ?>		
<!-- End Add -->
         <tr>
            <td height="15" colspan="3" ></td>
          </tr>
         <tr>
            <td height="5" colspan="3" ></td>
          </tr>
		  
         <tr>
            <td height="5" colspan="3" align="center" >
			
				<? include_once "reg_banking.php"; ?>
			
			</td>
          </tr>
		  
   	</table>


</form>