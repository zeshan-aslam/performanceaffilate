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
<div class="row"> 
	<div class="col-md-12">
		<div class="card stacked-form">
			<div class="row"> 
				<div class="col-md-6">
					<div class="card-header">
						<h4 class="card-title"><?=$lang_AffiliateLoginInfo?></h4>
						<span class="textred"><?=$Err?></span>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label><?=$lang_EmailId?></label>
							<input type="text" name="login" class="form-control" size="25" value="<?=$emailid?>"/>
						</div>
						<div class="form-group">
							<label><?=$lang_Password?></label>
							<input type="password" class="form-control" name="password" size="25" value="<?=$oldpassword?>" />
						</div>
						<div class="form_editlink">
							<a href="#" id="a1" class="btn btn-fill btn-info" onclick="return a1_onclick()"><?=$lang_Edit?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
</div>
<form method="post" name="reg" action="affil_accounts_validate.php?mode=update">
<div class="row"> 
	<div class="col-md-12">
		<div class="card stacked-form">
					<div class="card-header">
						<h4 class="card-title"><?=$lang_AffiliateContactInfo?></h4>
						<p><b><?=$err?>&nbsp;<?=$note?></b></p>
					</div>
					<div class="card-body">
						<div class="row"> 
							<div class="col-md-6">
								<div class="form-group">
									<label><?=$lang_FirstName?></label>
									<input type="text" name="firstnametxt" class="form-control" size="20" value="<?=$firstname?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_LastName?></label>
									<input type="text" name="lastnametxt" class="form-control" size="20" value="<?=$lastname?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_Company?></label>
									<input type="text" name="companytxt" class="form-control" size="20" value="<?=$company?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_URL?></label>
									<input type="text" name="urltxt" class="form-control" size="20" value="<?=$url?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_Address?></label>
									 <textarea rows="6" class="form-control textarea_contrl" name="addresstxt" cols="20"><?=$address ?></textarea>
								</div>
								<div class="form-group">
									<label><?=$lang_zip?></label>
									 <input type="text" name="zipcode" class="form-control" size="20" value="<?=$zipcode?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_Country?></label>
									<select size="1" class="form-control" name="countrylst">
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
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label><?=$lang_Category?></label>
									<select size="1" class="form-control" name="categorylst">
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
									</select>
								</div>
								<div class="form-group">
									<label><?=$lang_Phone?></label>
									<input type="text" name="phonetxt" class="form-control" size="20" value="<?=$phone?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_Fax?></label>
									<input type="text" name="faxtxt" class="form-control" size="20" value="<?=$fax?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_ParentId?></label>
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
           <input type="text" name="parentid" class="form-control" size="20" value="No Parent ID" readonly="readonly" />
         <?
         }
        while($row=mysqli_fetch_object($result))
    	{
     	?>
           <input type="text" name="parentid" class="form-control" size="20" value="<?=stripslashes($row->affiliate_firstname)?>" readonly="readonly" />
        <?php
    	}
		?>
								</div>
								<div class="form-group">
									<label><?=$lang_City?></label>
									<input type="text" name="citytxt" class="form-control" size="20" value="<?=$city?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_state?></label>
									<input type="text" name="state" class="form-control" size="20" value="<?=$state?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_taxId?></label>
									<input type="text" name="taxIdtxt" class="form-control" size="20" value="<?=$taxIdtxt?>" />
								</div>
								<div class="form-group">
									<label><?=$lang_timezone?></label>
									<select class="form-control" name="timezone">
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
        </select>
								</div>
							</div>
						</div>
					</div>
		</div>
	</div>
</div>
<? include 'edit_banking2.php'; ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group text-center">
			<input type="submit" value="<?=$lang_Edit?>" name="B12" class="btn btn-fill btn-info" />
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card stacked-form">
			<div class="card-header">
				<h4 class="card-title"><?=$lang_affiliateSignUpLink?></h4>
			</div>
			<div class="card-body">
				<div class="form-group text-center">
					<?=$lang_affiliateSignUpHelp?>
				</div>
			</div>
			<div class="card-body">
				<div class="form-group text-center">
					<a href="<?=$track_site_url."/index.php?Act=affil_regi&referer=$AFFILIATEID"?>"><? echo $track_site_url."/index.php?Act=affil_regi&referer=$AFFILIATEID"; ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
  <input name="status" type="hidden" value="<?=$status?>" />
</form>