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
 <br/>
<table width="100%"  border="0" cellpadding="0" cellspacing="0"  class="tablewbdr" >
  <tr>
    <td height="10" class="tdhead" align="center"><strong>
        <?=$lang_PaymentGateway?></strong>
        <select class="dropdown" name="modofpay" onchange="getpayment()">
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
     </td>
  </tr>
  <tr>
  <td><br/>
 </td></tr>
  <tr>
    <td height="190" id="td_id">&nbsp;

    </td>
  </tr>
</table>
<div id="layer_2checkout"  style="position:absolute;   visibility:hidden;width:450px; left:28%; top:735px;  border: 1px none #000000;">
<table width='90%' class='tablebdr' align='center'><tr><td height='25' colspan='2' align='center'><?=$lang_2Checkout?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_checkoutid?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='checkoutid' size='20' value='<?=$checkoutid?>' /></td></tr><tr><td height='25' width='50%'><?=$lang_productid?></td><td height='25' width='50%'> <input type='text' name='productid' size='20' value='<?=$productid?>' /> </td></tr></table>
</div>
<div id="layer_paypal"  style="position:absolute;   visibility:hidden; width:450px; left:28%; top:735px; border: 1px none #000000;">
<table width='90%' class='tablebdr' align='center'><tr><td height='25' colspan='2' align='center'><?=$lang_Paypal?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_payapalemail?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='paypalemail' size='20' value='<?=$paypalemail?>' />  </td>    </tr><tr> <td height='25' width='50%'>  </td><td height='25' width='50%'>  </td>  </tr> </table>
</div>
<div id="layer_stormpay"  style="position:absolute;  visibility:hidden; width:450px; left:28%; top:735px; border: 1px none #000000;">
<table width='90%' class='tablebdr' align='center'><tr ><td height='25' colspan='2' align='center'><?=$lang_Stormpay?></td>    </tr><tr><td height='25' width='50%' align='right'><?=$lang_stormemail?>&nbsp;&nbsp;</td> <td height='25' width='50%'> <input type='text' name='stormemail' size='20' value='<?=$stormmail?>' />  </td>    </tr><tr>  <td height='25' width='50%'>  </td>   <td height='25' width='50%'>  </td>  </tr></table>
</div>
<div id="layer_authorize"  style="position:absolute;   visibility:hidden; width:450px; left:28%; top:735px; border: 1px none #000000;">
<table width='90%' class='tablebdr' align='center'><tr ><td height='25' colspan='2' align='center'><?=$lang_Authorize?></td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_version?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input name='version' type='text'  value ='<?=$version?>' size='20' />  </td>    </tr><tr><td height='25' width='50%' align='right'><?=$lang_delimdata?>&nbsp;&nbsp;</td><td height='25' width='50%'>  <select name='delimdata'><option value='True' <?=$delimdataselected1?>>True</option>          <option value='False' <?=$delimdataselected2?>>False</option> </select></td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_relayresponse?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <select name='relayresponse'> <option value='True'  <?=$relayresponseselected1?>>True</option><option value='False'  <?=$relayresponseselected2?>>False</option></select> </td></tr><tr><td height='25' width='50%' align='right'><?=$lang_login?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input name='login' type='text'  value ='<?=$login?>' size='20' />   </td>    </tr><tr> <td height='25' width='50%' align='right'><?=$lang_trankey?>&nbsp;&nbsp;</td> <td height='25' width='50%'> <input name='trankey' type='text'  value ='<?=$trankey?>' size='20' />  </td>    </tr><tr><td height='25' width='50%' align='right'><?=$lang_cctype?>&nbsp;&nbsp;</td> <td height='25' width='50%'> <select name='cctype' >        <option value='AUTH_CAPTURE' <?=$cctypesel1?>>AUTH_CAPTURE</option>        <option value='AUTH_ONLY' <?=$cctypesel2?>>AUTH_ONLY</option>         <option value='CAPTURE_ONLY' <?=$cctypesel3?>>CAPTURE_ONLY</option>        <option value='CREDIT' <?=$cctypesel4?>>CREDIT</option>         <option value='VOID' <?=$cctypesel5?>>VOID</option>        <option value='PRIOR_AUTH_CAPTURE' <?=$cctypesel6?>>PRIOR_AUTH_CAPTURE</option>     </select>  </td>    </tr></table>
</div>
<div id="layer_egold"  style="position:absolute;  visibility:hidden; width:450px; left:28%; top:735px; border: 1px none #000000;">
<table width='90%' class='tablebdr' align='center'><tr ><td height='25' colspan='2' align='center'><?=$lang_eGold?></td> </tr><tr> <td height='25' width='50%' align='right'><?=$lang_acno?>&nbsp;&nbsp;  </td><td height='25' width='50%'> <input type='text' name='acno' size='20' value='<?=$acno?>' />  </td>    </tr> <tr> <td height='25' width='50%' align='right'><?=$lang_payeename?>&nbsp;&nbsp; </td>   <td height='25' width='50%'><input type='text' name='payeename' size='20' value='<?=$payeename?>' />  </td>      </tr> </table>
</div>
<div id="layer_checkbymail"  style="position:absolute; visibility:hidden; width:450px; left:28%; top:735px; border: 1px none #000000;">
<table width='90%' class='tablebdr' align='center'> <tr><td height='25' colspan='2' align='center'><?=$lang_check_caption?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_check_payee?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='checkpayee' size='20' value='<?=$checkpayee?>' />  </td></tr><tr><td height='25' width='50%' align='right'><?=$lang_check_curr?>&nbsp;&nbsp;  </td>        <td height='25' width='50%'> <input type='text' name='checkcurr' size='20' value='<?=$checkcurr?>'  />  </td> </tr><tr><td height='25' width='50%'>  </td><td height='25' width='50%'>  </td> </tr></table>
</div>
<div id="layer_neteller"  style="position:absolute; visibility:hidden; width:450px; left:28%; top:735px; border: 1px none #000000;">
<table width='90%' class='tablebdr' align='center'> <tr><td height='25' colspan='2' align='center'><?=$lang_neteller_caption?></td></tr><tr><td height='25' width='50%'><?=$lang_neteller_email?></td><td height='25' width='50%'> <input type='text' name='neteller_email' size='20' value='<?=$neteller_email?>' />  </td></tr><tr><td height='25' width='50%'><?=$lang_neteller_accnt?>  </td>        <td height='25' width='50%'> <input type='text' name='neteller_accnt' size='20' value='<?=$neteller_accnt?>'  />  </td> </tr><tr><td height='25' width='50%'>  </td><td height='25' width='50%'>  </td> </tr></table>
</div>
<div id="layer_wiretransfer"  style="position:absolute; visibility:hidden;width:450px; left:28%; top:735px;  border: 1px none #000000;">
<table width='90%' class='tablebdr' align='center'> <tr><td height='25' colspan='2' align='center'><?=$lang_wire_caption?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_AccountName?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='wire_AccountName' size='20' value='<?=$wire_AccountName?>' />  </td></tr> <tr><td height='25' width='50%' align='right'><?=$lang_wire_AccountNumber?>&nbsp;&nbsp;  </td>        <td height='25' width='50%'> <input type='text' name='wire_AccountNumber' size='20' value='<?=$wire_AccountNumber?>'  />  </td> </tr> <tr><td height='25' width='50%' align='right'><?=$lang_wire_BankName?>&nbsp;&nbsp;  </td>        <td height='25' width='50%'> <input type='text' name='wire_BankName' size='20' value='<?=$wire_BankName?>'  />  </td> </tr><tr><td height='25' width='50%' align='right' valign='top'><?=$lang_wire_BankAddress?>&nbsp;&nbsp;</td><td height='25' width='50%'> <textarea name='wire_BankAddress' rows='5' cols='27'><?=$wire_BankAddress?></textarea>  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankCity?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='wire_BankCity' size='20' value='<?=$wire_BankCity?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankState?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankState' size='20' value='<?=$wire_BankState?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankZip?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankZip' size='20' value='<?=$wire_BankZip?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankCountry?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankCountry' size='20' value='<?=$wire_BankCountry?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankAddressNumber?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankAddressNumber' size='20' value='<?=$wire_BankAddressNumber?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_Nominate?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_Nominate' size='20' value='<?=$wire_Nominate?>'  />  </td> </tr><tr><td height='25' width='50%'></td><td height='25' width='50%'>  </td> </tr>            </table>
</div>
 <br/>
<script language="javascript" type="text/javascript">
 function  getpayment() {
    if(document.reg.modofpay.value=="2checkout")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_2checkout").style.posTop = 658;
					document.getElementById("layer_2checkout").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="Paypal")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_paypal").style.posTop = 658;
                    document.getElementById("layer_paypal").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="Stormpay")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_stormpay").style.posTop = 658;
                    document.getElementById("layer_stormpay").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="Authorize.net")
	{
					document.getElementById("td_id").height = 210;
					if(IE) document.getElementById("layer_authorize").style.posTop = 658;
                    document.getElementById("layer_authorize").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="E-Gold")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_egold").style.posTop = 658;
                    document.getElementById("layer_egold").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="CheckByMail")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_checkbymail").style.posTop = 658;
                    document.getElementById("layer_checkbymail").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="NETeller")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_neteller").style.posTop = 658;
                    document.getElementById("layer_neteller").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="WireTransfer")
	{
					document.getElementById("td_id").height = 400;
					if(IE) document.getElementById("layer_wiretransfer").style.posTop = 658;
                    document.getElementById("layer_wiretransfer").style.visibility = 'visible';
	}
	hide_other_layers(document.reg.modofpay.value);
}

function hide_other_layers(value){
		if(value!="2checkout") 		document.getElementById("layer_2checkout").style.visibility = 'hidden';
		if(value!="Paypal") 		document.getElementById("layer_paypal").style.visibility = 'hidden';
		if(value!="Stormpay") 		document.getElementById("layer_stormpay").style.visibility = 'hidden';
		if(value!="Authorize.net") 	document.getElementById("layer_authorize").style.visibility = 'hidden';
		if(value!="E-Gold") 		document.getElementById("layer_egold").style.visibility = 'hidden';
		if(value!="CheckByMail") 	document.getElementById("layer_checkbymail").style.visibility = 'hidden';
		if(value!="NETeller") 		document.getElementById("layer_neteller").style.visibility = 'hidden';
		if(value!="WireTransfer") 	document.getElementById("layer_wiretransfer").style.visibility = 'hidden';
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
					document.getElementById("layer_2checkout").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="Paypal")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_paypal").style.posTop = 658;
                    document.getElementById("layer_paypal").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="Stormpay")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_stormpay").style.posTop = 658;
                    document.getElementById("layer_stormpay").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="Authorize.net")
	{
					document.getElementById("td_id").height = 210;
					if(IE) document.getElementById("layer_authorize").style.posTop = 658;
                    document.getElementById("layer_authorize").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="E-Gold")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_egold").style.posTop = 658;
                    document.getElementById("layer_egold").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="CheckByMail")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_checkbymail").style.posTop = 658;
                    document.getElementById("layer_checkbymail").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="NETeller")
	{
					document.getElementById("td_id").height = 190;
					if(IE) document.getElementById("layer_neteller").style.posTop = 658;
                    document.getElementById("layer_neteller").style.visibility = 'visible';
	}
    if(document.reg.modofpay.value=="WireTransfer")
	{
					document.getElementById("td_id").height = 400;
					if(IE) document.getElementById("layer_wiretransfer").style.posTop = 658;
                    document.getElementById("layer_wiretransfer").style.visibility = 'visible';
	}
</script>