<?php
     $err=$_GET['msg'];
	 $note = $_REQUEST['suc_msg'];

      if(isset($err)){

                $firstname        =	stripslashes($_GET['firstname']);
                $lastname         =	stripslashes($_GET['lastname']);
                $company          =	stripslashes($_GET['company']);
                $url              =	stripslashes($_GET['url']);
                //$address          =	stripslashes($_GET['address']);
                $city             =	stripslashes($_GET['city']);
                $category         =	stripslashes($_GET['category']);
                $phone            =	stripslashes($_GET['phone']);
                $fax              =	stripslashes($_GET['fax']);
                $mailid           =	stripslashes($_GET['mailid']);
                $type             =	stripslashes($_GET['type']);
                $country          =	stripslashes($_GET['country']);
                //$address          =	stripslashes($_GET['address']);
				$address          =	$_SESSION['AFF_ADDRESS'];

				#-------------------------------------------------------------------------
				# Aditional informations added
				#-------------------------------------------------------------------------
					$zipcode	= trim(stripslashes($_GET['zipcode']));
					$state		= trim(stripslashes($_GET['state']));
					$timezone	= trim(stripslashes($_GET['timezone']));
                    $taxIdtxt   = stripslashes(trim($_GET['taxIdtxt']));
				#-------------------------------------------------------------------------
				# Aditional informations added Ends Here
				#-------------------------------------------------------------------------


               $sql    = "select * from partners_login where login_id ='$AFFILIATEID' and login_flag='a'";
        	   $result = mysqli_query($con,$sql);

               while($row=mysqli_fetch_object($result)){
                $emailid	=	$row->login_email;
                $origin		=	$row->login_email;
                $oldpassword=	$row->login_password;
              }

      }  // if closing
      else
      {
         	$sql    = "select * from partners_login where login_id ='$AFFILIATEID' and login_flag='a'";
         	$result = mysqli_query($con,$sql);

         	while($row=mysqli_fetch_object($result)) {
                $emailid	=	$row->login_email;
                $origin		=	$row->login_email;
                $oldpassword=	$row->login_password;
           }

          $sql	= "select * from partners_affiliate where affiliate_id='$AFFILIATEID'";
          $res	= mysqli_query($con,$sql);

           while($row=mysqli_fetch_object($res)) {
                        $firstname	=	stripslashes($row->affiliate_firstname);
                        $lastname	=	stripslashes($row->affiliate_lastname);
                        $company	=	stripslashes($row->affiliate_company);
                        $url		=	stripslashes($row->affiliate_url);
                        $address	=	stripslashes($row->affiliate_address);
                        $category	=	stripslashes($row->affiliate_category);
                        $phone		=	stripslashes($row->affiliate_phone);
                        $fax		=	stripslashes($row->affiliate_fax);
                        $type		=	stripslashes($row->affiliate_type);
                        $city		=	stripslashes($row->affiliate_city);
                        $country	=	stripslashes($row->affiliate_country);
                        $status		=	stripslashes($row->affiliate_status);
						$state		=	stripslashes($row->affiliate_state);
                        $timezone	=	stripslashes($row->affiliate_timezone);
                        $zipcode	=   stripslashes($row->affiliate_zipcode);
                        $taxIdtxt   =   stripslashes($row->affiliate_taxId);
         }
      } //is set  else closing
    				$j=-12;
                      for($i=0 ;$i<=24 ;$i++)
                          {
                          if($timezone==$j) $sel[$i] ="selected = 'selected'" ;
                          else  $sel[$i] =" " ;
                          $j++;
                     }
?>
<script  language="javascript" type="text/javascript">
	function a1_onclick() {
		window.open("login_edit.php",'new','height=250,width=500,scrollbars=no');
	}
</script>
  <table border="0" cellpadding="0" cellspacing="0" width="85%" class="tablebwdr" align="center">
    <tr>
      <td width="99%" colspan="2">
		<table border="0" cellspacing="1" align="center" width="57%" class="tablebdr">
		  <tr>
			<td colspan="3" align="center" height="19" class="tdhead"> <b> <?=$lang_AffiliateLoginInfo?> </b></td>
		  </tr>
		   <tr>
			<td colspan="3" align="center" height="25" class="error" ><?=$Err?></td>
		  </tr>
		  <tr>
			<td width="16%" height="28">&nbsp;</td>
			<td width="34%" height="28"><?=$lang_EmailId?></td>
			<td width="50%" height="28"><input type="text" name="login" size="25" value="<?=$emailid?>" /></td>
		  </tr>
		  <tr>
			<td width="16%" height="28">&nbsp;</td>
			<td width="34%" height="28"><?=$lang_Password?></td>
			<td width="50%" height="28">
			<input type="password" name="password" size="25" value="<?=$oldpassword?>" /></td>
		  </tr>
		  <tr>
			<td height="13" colspan="3" align="center">
			<a href="#" onclick="return a1_onclick()"><input type="submit" value="<?=$lang_Edit?>" name="B1" /></a></td>
		  </tr>
		</table>
<br />

<form method="post" name="reg" action="affil_accounts_validate.php?mode=update">
<table border="0" cellpadding="0" align="center" cellspacing="0" width="90%" id="AutoNumber2" class="tablebdr">
    <tr>
      <td colspan="6" height="19" class="tdhead" align="center"> <b> <?=$lang_AffiliateContactInfo?> </b></td>
    </tr>
    <tr>
      <td colspan="6" height="25" class="textred" align="center"><?=$err?>&nbsp;<?=$note?></td>
    </tr>
    <tr>
      <td width="11%" height="26">&nbsp;</td>
      <td width="14%" height="26"><?=$lang_FirstName?></td>
      <td width="28%" height="26">
      <input type="text" name="firstnametxt" size="20" value="<?=$firstname?>" /></td>
      <td width="14%" height="26"><?=$lang_Category?></td>
      <td width="31%" height="26">
      <select size="1" name="categorylst">
      <?php

    	$sql    = "select * from partners_category";
    	$result = mysqli_query($con,$sql);

         while($row=mysqli_fetch_object($result))  {
    		if(trim($category)==trim($row->cat_name)){
            ?>
                <option value="<?=$row->cat_name?>" selected="selected" ><?=$row->cat_name?></option>
		    <?php
            }else{
			?>
                <option value="<?=$row->cat_name?>" ><?=$row->cat_name?></option>
			<?php
             }
   		 }
	   ?>
      </select></td>
      <td width="2%" height="26">&nbsp;</td>
    </tr>
    <tr>
      <td width="11%" height="29">&nbsp;</td>
      <td width="14%" height="29"><?=$lang_LastName?></td>
      <td width="28%" height="29">
      <input type="text" name="lastnametxt" size="20" value="<?=$lastname?>" /></td>
      <td width="14%" height="29"><?=$lang_Phone?></td>
      <td width="31%" height="29"><input type="text" name="phonetxt" size="20" value="<?=$phone?>" /></td>
      <td width="2%" height="29">&nbsp;</td>
    </tr>
    <tr>
      <td width="11%" height="31">&nbsp;</td>
      <td width="14%" height="31"><?=$lang_Company?></td>
      <td width="28%" height="31">
      <input type="text" name="companytxt" size="20" value="<?=$company?>" /></td>
      <td width="14%" height="31"><?=$lang_Fax?></td>
      <td width="31%" height="31"><input type="text" name="faxtxt" size="20" value="<?=$fax?>" /></td>

      <td width="2%" height="31">&nbsp;</td>
    </tr>
    <tr>
      <td width="11%" height="28">&nbsp;</td>
      <td width="14%" height="28"><?=$lang_URL?></td>
      <td width="28%" height="28"><input type="text" name="urltxt" size="20" value="<?=$url?>" /></td>
      <td width="14%" height="17"><?=$lang_ParentId?></td>
      <td width="31%" height="17"  >
    <?php

    	$sql    = "SELECT affiliate_parentid FROM `partners_affiliate`WHERE affiliate_id = '$_SESSION[AFFILIATEID]' and affiliate_parentid <> '0' ";
    	$result = mysqli_query($con,$sql);

   		if(mysqli_num_rows($result)) {
     		$row	=	mysqli_fetch_object($result);
     		$pid	=	$row->affiliate_parentid;

            $sqlin	=  "SELECT affiliate_firstname FROM `partners_affiliate`WHERE affiliate_id='$pid'";
     		$result = mysqli_query($con,$sqlin);
    	}else{
        ?>
           <input type="text" name="parentid" size="20" value="No Parent ID" readonly="readonly" />
         <?
         }
        while($row=mysqli_fetch_object($result))
    	{
     	?>
           <input type="text" name="parentid" size="20" value="<?=stripslashes($row->affiliate_firstname)?>" readonly="readonly" />
        <?php
    	}
		?>	</td>

     <td width="2%" height="31">&nbsp;</td>
    </tr>
    <tr>
      <td width="11%" height="35">&nbsp;</td>
      <td width="14%" height="66" rowspan="2"><?=$lang_Address?></td>
      <td width="28%" height="66" rowspan="2">
      <textarea rows="3" name="addresstxt" cols="20"><?=$address ?></textarea></td>
      <td width="14%" height="35"><?=$lang_City?></td>
      <td width="31%" height="35"><input type="text" name="citytxt" size="20" value="<?=$city?>" /></td>
      <td width="2%" height="35">&nbsp;</td>
    </tr>
	 <tr>
      <td width="11%" height="31">&nbsp;</td>
      <td width="14%" height="31"><?=$lang_state?></td>
      <td width="31%" height="31">
      <input type="text" name="state" size="20" value="<?=$state?>" /></td>
		<td></td>
    </tr>
    <tr>
	   <td width="11%" height="31">&nbsp;</td>
      <td width="14%" height="31"><?=$lang_zip?></td>
      <td width="28%" height="31">
      <input type="text" name="zipcode" size="20" value="<?=$zipcode?>" /></td>
      <td width="14%" height="35"><?=$lang_taxId?></td>
      <td width="31%" height="35"><input type="text" name="taxIdtxt" size="20" value="<?=$taxIdtxt?>" /></td>
      <td width="2%" height="35">&nbsp;</td>
   </tr>
   <tr>
	 <td width="11%" height="35">&nbsp;</td>
      <td width="14%" height="31"><?=$lang_Country?></td>
      <td width="28%" height="31">
      <select size="1" name="countrylst">
      <?php
    	$sql    = "select * from partners_country";
    	$result = mysqli_query($con,$sql);
        while($row=mysqli_fetch_object($result)) {
    		if($country==$row->country_name)
    		{
			?>
                <option value="<?=$row->country_name?>" selected="selected" ><?=$row->country_name?></option>
			<?php
        	}
    	   else{
			?>
                <option value="<?=$row->country_name?>" ><?=$row->country_name?></option>
			<?php
             }
    		}
	 	?>
      </select></td> <td width="14%" height="31"><?=$lang_timezone?></td>
      <td width="31%" height="31"> <select name="timezone">
        <option <?=$sel[0]?>    value="-12">Newzealand Time(-12)</option>
        <option <?=$sel[1]?>    value="-11">Midway Isles, Samoa (-11)</option>
        <option <?=$sel[2]?>    value="-10">Hawaii (-10)</option>
        <option <?=$sel[3]?>    value="-9">AKST - Alaska Standard Time (-9)</option>
        <option <?=$sel[4]?>    value="-8">PST - Pacific Standard Time (-8)</option>
        <option <?=$sel[5]?>    value="-7">MST - Mountain Standard Time (-7)</option>
        <option <?=$sel[6]?>    value="-6">CST - Central Standard Time (-6)</option>
        <option <?=$sel[7]?>    value="-5">EST - Eastern Standard Time (-5)</option>
        <option <?=$sel[8]?>    value="-4">SA West - Atlantic Time (-4)</option>
        <option <?=$sel[9]?>    value="-3">SA East - East Brasil Time (-3)</option>
        <option <?=$sel[10]?>   value="-2">Middle Atlantic (-2)</option>
        <option <?=$sel[11]?>   value="-1">Island Time (-1)</option>
        <option <?=$sel[12]?>   value="0">GMT - Greenwitch Meridian Time (0)</option>
        <option <?=$sel[13]?>   value="1">CET - Central European Time (+1)</option>
        <option <?=$sel[14]?>   value="2" >EET - East European Time (+2)</option>
        <option <?=$sel[15]?>   value="3">Irak, Kuwait, Russia(+3)</option>
        <option <?=$sel[16]?>   value="4">Mauritius, Kazachstan (+4)</option>
        <option <?=$sel[17]?>   value="5">West Asia (+5)</option>
        <option <?=$sel[18]?>   value="6">Central Asia  (+6)</option>
        <option <?=$sel[19]?>   value="7">Indo China Time (+7)</option>
        <option <?=$sel[20]?>   value="8">Chinese Shore Time (+8)</option>
        <option <?=$sel[21]?>   value="9">JST - Japan  Standard Time (+9)</option>
        <option <?=$sel[22]?>   value="10">AUS - Australian Time(+10)</option>
        <option <?=$sel[23]?>   value="11">Central Pacifik (+11)</option>
        <option <?=$sel[24]?>   value="12">Newzealand Time (12)</option>
        </select></td>
      <td width="2%" height="31">&nbsp;</td>
    </tr>
<!-- Added for Affiliate Currency -->
<?	/*
   $crnysql = " SELECT DISTINCT(currency_caption) FROM partners_currency ";
   $crnyret = mysqli_query($con,$crnysql) or die("You have an error while processing sql query ");

?>	
	 <tr>
      <td width="1%" height="31">&nbsp;</td>
      <td width="11%" height="31"><?=$lang_check_curr?></td>
      <td width="40%" height="31">
      		<select name="affiliate_currency">
                    <?
                    # POPULATE currency

                    if(mysqli_num_rows($crnyret)>0){
                      while($crnyrow = mysqli_fetch_object($crnyret))
                      {
						  ?><option value="<?=$crnyrow->currency_caption?>" <?=($crnyrow->currency_caption==$currency)?"selected='selected'":""?>><?=trim(stripslashes($crnyrow->currency_caption))?></option><?
                      }
                    }

                    ?>
            </select>&nbsp;
		</td>
		<td></td>
    </tr>
<? */ ?>	
<!-- End Add --> 
	
    <tr>
      <td height="19" colspan="6">&nbsp;</td>
    </tr>
    <tr>
     <td colspan="6"><? include 'edit_banking2.php'; ?></td>
    </tr>
    <tr>
     <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
      <td height="18" colspan="6" align="center" class="tdhead">  <input type="submit" value="<?=$lang_Edit?>" name="B12" /></td>
    </tr>
		<tr><td colspan="6" height="30" >&nbsp;</td></tr>
		<tr>
		  <td colspan="6" height="19" class="tdhead" align="center"><b><?=$lang_affiliateSignUpLink?></b></td>
		</tr>
		<tr><td colspan="6" height="10" >&nbsp;</td></tr>
		<tr>
			<td colspan="6" align="center" ><b><?=$lang_affiliateSignUpHelp?></b></td>
		</tr>
		<tr>
			<td colspan="6" align="center" height="30"><a href="<?=$track_site_url."/index.php?Act=affil_regi&referer=$AFFILIATEID"?>"><? echo $track_site_url."/index.php?Act=affil_regi&referer=$AFFILIATEID"; ?></a></td>
		</tr>
  </table>
   <input name="status" type="hidden" value="<?=$status?>" />

</form>	</td>
	</tr>
    <tr>
      <td width="49%">&nbsp;</td>
      <td width="50%">&nbsp;</td>
    </tr>
  </table>