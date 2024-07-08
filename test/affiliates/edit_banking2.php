 <?

	//geting records from table
  	$sql ="select * from partners_paymentgateway where pay_status like 'Active'  and pay_name NOT LIKE 'WorldPay'";
  $ret =mysqli_query($con,$sql);

   $sql1="select * from partners_bankinfo where bankinfo_affiliateid='$AFFILIATEID'";
   $res1=mysqli_query($con,$sql1);

         while($row1=mysqli_fetch_object($res1)) {

	            $modofpay             = $row1->bankinfo_modeofpay;
	            $paypalemail          = trim(stripslashes($row1->bankinfo_paypalemail));
	            $stormmail            = trim(stripslashes($row1->bankinfo_stormemail));
	            $payeename            = trim(stripslashes($row1->bankinfo_payeename));
	            $acno                 = trim(stripslashes($row1->bankinfo_acno));
	            $productid            = trim(stripslashes($row1->bankinfo_productid));
	            $checkoutid           = trim(stripslashes($row1->bankinfo_checkoutid));
	            $version              = trim(stripslashes($row1->bankinfo_version));
	            $delimdata            = trim(stripslashes($row1->bankinfo_delimdata));


	            $relayresponse        = trim(stripslashes($row1->bankinfo_relayresponse));


	            $login                = trim(stripslashes($row1->bankinfo_login));
	            $trankey              = trim(stripslashes($row1->bankinfo_trankey));
	            $cctype               = trim(stripslashes($row1->bankinfo_cctype));
                if($relayresponse=="True") $relayresponseselected1= "selected = 'selected'";
                else                   	   $relayresponseselected2= "selected = 'selected'";
                if($delimdata=="True")     $delimdataselected1= "selected = 'selected'";
                else  			  			   $delimdataselected2= "selected = 'selected'";
                if($cctype=="AUTH_CAPTURE") $cctypesel1 = "selected = 'selected'" ;
                if($cctype=="AUTH_ONLY") $cctypesel2 = "selected = 'selected'" ;
                if($cctype=="CAPTURE_ONLY") $cctypesel3 = "selected = 'selected'" ;
                if($cctype=="CREDIT") $cctypesel4 = "selected = 'selected'" ;
                if($cctype=="VOID") $cctypesel5 = "selected = 'selected'" ;
                if($cctype=="PRIOR_AUTH_CAPTURE") $cctypesel6 = "selected = 'selected'" ;

         #---------------------------------------------------------------------
         # Additional Informaion
         #--------------------------------------------------------------------

                # Neteller account
    			$neteller_email 	= trim(stripslashes($row1->bankinfo_neteller_email));
    			$neteller_accnt	 	= trim(stripslashes($row1->bankinfo_neteller_accnt));

				# check by Mail
    			$checkpayee     	= trim(stripslashes($row1->bankinfo_checkpayee));
    			$checkcurr      	= trim(stripslashes($row1->bankinfo_checkcurr));


				# Wire Transfer
    	        $wire_AccountName   = trim(stripslashes($row1->bankinfo_wire_AccountName));
	            $wire_AccountNumber = trim(stripslashes($row1->bankinfo_wire_AccountNumber));
	            $wire_BankName      = trim(stripslashes($row1->bankinfo_wire_BankName));
	            $wire_BankAddress   = trim(stripslashes($row1->bankinfo_wire_BankAddress));
	            $wire_BankCity      = trim(stripslashes($row1->bankinfo_wire_BankCity));
	            $wire_BankState     = trim(stripslashes($row1->bankinfo_wire_BankState));
	            $wire_BankZip       = trim(stripslashes($row1->bankinfo_wire_BankZip));
	            $wire_BankCountry   = trim(stripslashes($row1->bankinfo_wire_BankCountry));
	            $wire_BankAddressNumber= trim(stripslashes($row1->bankinfo_wire_BankAddressNumber));
	            $wire_Nominate      = trim(stripslashes($row1->bankinfo_wire_Nominate));

         #---------------------------------------------------------------------
         # Additional Informaion Ends Here
         #--------------------------------------------------------------------

         }
 ?>
 
<div class="row"> 
	<div class="col-md-12">
		<div class="card stacked-form">
			<div class="card-body">
				<div class="row">  
					<div class="col-md-6 mr-auto ml-auto">
						<div class="form-group">
							<label><?=$lang_PaymentGateway?></label>
							<select class="dropdown form-control" name="modofpay" onchange="getpayment()">
								<?
								//checking for each records
								if(mysqli_num_rows($ret)>0)
								{
									while($row=mysqli_fetch_object($ret))
									{     if($modofpay==$row->pay_name) $sel="selected = 'selected'";
									else                          $sel ="";
									?>
										<option value="<?=$row->pay_name?>" <?=$sel?>>
										<?=$row->pay_name?>
										</option>
									<?
									}
								}  ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div height="190" id="td_id"></div>
<div id="layer_2checkout"  style="display:none;left:28%; top:735px;  border: 1px none #000000;">
	<div class="row"> 
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
						<h4 class="card-title"><?=$lang_2Checkout?></h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6 mr-auto ml-auto">
								<div class="form-group">
									<label><?=$lang_checkoutid?></label>
									<input type='text' name='checkoutid' size='20' value='<?=$checkoutid?>' class="form-control" />
								</div>
								<div class="form-group">
									<label><?=$lang_productid?></label>
									<input type='text' name='productid' size='20' value='<?=$productid?>' class="form-control" />
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="layer_paypal"  style="display:none;left:28%; top:735px; border: 1px none #000000;">
	<div class="row"> 
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_Paypal?></h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6 mr-auto ml-auto">
							<div class="form-group">
								<label><?=$lang_payapalemail?></label>
								<input type='text' name='paypalemail' size='20' value='<?=$paypalemail?>' class="form-control" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="layer_stormpay"  style="display:none;left:28%; top:735px; border: 1px none #000000;">
	<div class="row"> 
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_Stormpay?></h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6 mr-auto ml-auto">
							<div class="form-group">
								<label><?=$lang_stormemail?></label>
								<input type='text' name='stormemail' size='20' value='<?=$stormemail?>' class="form-control" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="layer_authorize"  style="display:none;left:28%; top:735px; border: 1px none #000000;">
	<div class="row"> 
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_Authorize?></h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6 mr-auto ml-auto">
							<div class="form-group">
								<label><?=$lang_version?></label>
								<input type='text' name='version' size='20' value='<?=$version?>' class="form-control" />
							</div>
							<div class="form-group">
								<label><?=$lang_delimdata?></label>
								<select class="form-control"  name='delimdata'><option value='True' <?=$delimdataselected1?>>True</option><option value='False' <?=$delimdataselected2?>>False</option> </select>
							</div>
							<div class="form-group">
								<label><?=$lang_relayresponse?></label>
								<select class="form-control" name='relayresponse'> <option value='True'  <?=$relayresponseselected1?>>True</option><option value='False'  <?=$relayresponseselected2?>>False</option></select>
							</div>
							<div class="form-group">
								<label><?=$lang_login?></label>
								<input name='login' type='text' class="form-control" value ='<?=$login?>' size='20' /> 
							</div>
							<div class="form-group">
								<label><?=$lang_trankey?></label>
								<input name='trankey' type='text' class="form-control" value ='<?=$trankey?>' size='20' /> 
							</div>
							<div class="form-group">
								<label><?=$lang_cctype?></label>
								<select class="form-control"  name='cctype' >        <option value='AUTH_CAPTURE' <?=$cctypesel1?>>AUTH_CAPTURE</option>        <option value='AUTH_ONLY' <?=$cctypesel2?>>AUTH_ONLY</option>         <option value='CAPTURE_ONLY' <?=$cctypesel3?>>CAPTURE_ONLY</option>        <option value='CREDIT' <?=$cctypesel4?>>CREDIT</option>         <option value='VOID' <?=$cctypesel5?>>VOID</option>        <option value='PRIOR_AUTH_CAPTURE' <?=$cctypesel6?>>PRIOR_AUTH_CAPTURE</option>     </select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="layer_egold"  style="display:none;left:28%; top:735px; border: 1px none #000000;">
	<div class="row"> 
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_eGold?></h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6 mr-auto ml-auto">
							<div class="form-group">
								<label><?=$lang_acno?></label>
								<input type='text' name='acno' size='20' value='<?=$acno?>' class="form-control" /> 
							</div>
							<div class="form-group">
								<label><?=$lang_payeename?></label>
								<input type='text' name='payeename' size='20' value='<?=$payeename?>' class="form-control" /> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="layer_checkbymail"  style="display:none;left:28%; top:735px; border: 1px none #000000;">
	<div class="row"> 
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_check_caption?></h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6 mr-auto ml-auto">
							<div class="form-group">
								<label><?=$lang_check_payee?></label>
								<input type='text' name='checkpayee' size='20' value='<?=$checkpayee?>' class="form-control" />
							</div>
							<div class="form-group">
								<label><?=$lang_check_curr?></label>
								<input type='text' name='checkcurr' size='20' value='<?=$checkcurr?>'  class="form-control" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="layer_neteller"  style="display:none;left:28%; top:735px; border: 1px none #000000;">
	<div class="row"> 
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_neteller_caption?></h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6 mr-auto ml-auto">
							<div class="form-group">
								<label><?=$lang_neteller_email?></label>
								<input type='text' name='neteller_email' size='20' value='<?=$neteller_email?>' class="form-control" /> 
							</div>
							<div class="form-group">
								<label><?=$lang_neteller_accnt?></label>
								<input type='text' name='neteller_accnt' size='20' value='<?=$neteller_accnt?>' class="form-control" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="layer_wiretransfer"  style="display:none; left:28%; top:735px;  border: 1px none #000000;">
	<div class="row"> 
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_wire_caption?></h4>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-6 mr-auto ml-auto">
							<div class="form-group">
								<label><?=$lang_wire_AccountName?></label>
								<input type='text' name='wire_AccountName' size='20' value='<?=$wire_AccountName?>' class="form-control" /> 
							</div>
							<div class="form-group">
								<label><?=$lang_wire_AccountNumber?></label>
								<input type='text' name='wire_AccountNumber' size='20' value='<?=$wire_AccountNumber?>' class="form-control"  /> 
							</div>
							<div class="form-group">
								<label><?=$lang_wire_BankName?></label>
								<input type='text' name='wire_BankName' size='20' value='<?=$wire_BankName?>' class="form-control" />
							</div>
							<div class="form-group">
								<label><?=$lang_wire_BankAddress?></label>
								<textarea class="form-control" name='wire_BankAddress' rows='5' cols='27'><?=$wire_BankAddress?></textarea>
							</div>
							<div class="form-group">
								<label><?=$lang_wire_BankCity?></label>
								<input type='text' name='wire_BankCity' size='20' value='<?=$wire_BankCity?>' class="form-control" /> 
							</div>
							<div class="form-group">
								<label><?=$lang_wire_BankState?></label>
								<input type='text' name='wire_BankState' size='20' value='<?=$wire_BankState?>'  class="form-control"/> 
							</div>
							<div class="form-group">
								<label><?=$lang_wire_BankZip?></label>
								<input type='text' name='wire_BankZip' size='20' value='<?=$wire_BankZip?>' class="form-control" />
							</div>
							<div class="form-group">
								<label><?=$lang_wire_BankCountry?></label>
								<input type='text' name='wire_BankCountry' size='20' value='<?=$wire_BankCountry?>' class="form-control" />
							</div>
							<div class="form-group">
								<label><?=$lang_wire_BankAddressNumber?></label>
								 <input type='text' name='wire_BankAddressNumber' size='20' value='<?=$wire_BankAddressNumber?>' class="form-control" />
							</div>
							<div class="form-group">
								<label><?=$lang_wire_Nominate?></label>
								 <input type='text' name='wire_Nominate' size='20' value='<?=$wire_Nominate?>' class="form-control" /> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript" type="text/javascript">
 function  getpayment() {
    if(document.reg.modofpay.value=="2checkout")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_2checkout").style.posTop = 658;
					document.getElementById("layer_2checkout").style.display = 'block';
	}
    if(document.reg.modofpay.value=="Paypal")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_paypal").style.posTop = 658;
                    document.getElementById("layer_paypal").style.display = 'block';
	}
    if(document.reg.modofpay.value=="Stormpay")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_stormpay").style.posTop = 658;
                    document.getElementById("layer_stormpay").style.display = 'block';
	}
    if(document.reg.modofpay.value=="Authorize.net")
	{
					document.getElementById("td_id").height = 210;
					if(IE) document.getElementById("layer_authorize").style.posTop = 658;
                    document.getElementById("layer_authorize").style.display = 'block';
	}
    if(document.reg.modofpay.value=="E-Gold")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_egold").style.posTop = 658;
                    document.getElementById("layer_egold").style.display = 'block';
	}
    if(document.reg.modofpay.value=="CheckByMail")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_checkbymail").style.posTop = 658;
                    document.getElementById("layer_checkbymail").style.display = 'block';
	}
    if(document.reg.modofpay.value=="NETeller")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_neteller").style.posTop = 658;
                    document.getElementById("layer_neteller").style.display = 'block';
	}
    if(document.reg.modofpay.value=="WireTransfer")
	{
					document.getElementById("td_id").height = 400;
					if(IE) document.getElementById("layer_wiretransfer").style.posTop = 658;
                    document.getElementById("layer_wiretransfer").style.display = 'block';
	}
	hide_other_layers(document.reg.modofpay.value);
}

function hide_other_layers(value){
		if(value!="2checkout") 		document.getElementById("layer_2checkout").style.display = 'none';
		if(value!="Paypal") 		document.getElementById("layer_paypal").style.display = 'none';
		if(value!="Stormpay") 		document.getElementById("layer_stormpay").style.display = 'none';
		if(value!="Authorize.net") 	document.getElementById("layer_authorize").style.display = 'none';
		if(value!="E-Gold") 		document.getElementById("layer_egold").style.display = 'none';
		if(value!="CheckByMail") 	document.getElementById("layer_checkbymail").style.display = 'none';
		if(value!="NETeller") 		document.getElementById("layer_neteller").style.display = 'none';
		if(value!="WireTransfer") 	document.getElementById("layer_wiretransfer").style.display = 'none';
}
</script>
<script language="javascript" type="text/javascript">
	var ua	=	navigator.userAgent.toLowerCase(); //alert(ua);
	var NN4	=	IE4=OP6=KO3=false, OP=!!self.opera;
	var IE	=	ua.indexOf("msie")!=-1&&!OP&&ua.indexOf("webtv")==-1;
   	var MAC  = (ua.indexOf("firefox")) != -1;
    var OP = (ua.indexOf("opera")) != -1;
    if(document.reg.modofpay.value=="2checkout")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_2checkout").style.posTop = 658;
					document.getElementById("layer_2checkout").style.display = 'block';
	}
    if(document.reg.modofpay.value=="Paypal")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_paypal").style.posTop = 658;
                    document.getElementById("layer_paypal").style.display = 'block';
	}
    if(document.reg.modofpay.value=="Stormpay")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_stormpay").style.posTop = 658;
                    document.getElementById("layer_stormpay").style.display = 'block';
	}
    if(document.reg.modofpay.value=="Authorize.net")
	{
					document.getElementById("td_id").height = 210;
					if(IE) document.getElementById("layer_authorize").style.posTop = 658;
                    document.getElementById("layer_authorize").style.display = 'block';
	}
    if(document.reg.modofpay.value=="E-Gold")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_egold").style.posTop = 658;
                    document.getElementById("layer_egold").style.display = 'block';
	}
    if(document.reg.modofpay.value=="CheckByMail")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_checkbymail").style.posTop = 658;
                    document.getElementById("layer_checkbymail").style.display = 'block';
	}
    if(document.reg.modofpay.value=="NETeller")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_neteller").style.posTop = 658;
                    document.getElementById("layer_neteller").style.display = 'block';
	}
    if(document.reg.modofpay.value=="WireTransfer")
	{
					
					if(IE) document.getElementById("layer_wiretransfer").style.posTop = 658;
                    document.getElementById("layer_wiretransfer").style.display = 'block';
	}
</script>