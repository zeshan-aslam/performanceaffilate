 <? 
 #------------------------------------------------------------------------------
 # opens terms file
 # reads all contents
 #------------------------------------------------------------------------------
  $filename                = "admin/terms.htm";
  $fp                      = fopen($filename,'r');
  $contents                = fread ($fp, filesize ($filename));
  fclose($fp);

 ?>

 <br/><!--  -->
<table width="100%"  border="0" cellpadding="0" cellspacing="0" id="AutoNumber1" >
  <tr>
    <td height="10" bgcolor="#5BA7E3" align="center"><b style="color: #ffffff">
        <?=$lang_PaymentGateway?>
        <select class="dropdown" name="modofpay" onchange="getpayment()">
          <?//checking for each records
               if(mysqli_num_rows($ret)>0)
               {
                       while($row= mysqli_fetch_object($ret))
                       {     if($modofpay==$row->pay_name) $sel="selected = 'selected'";
                             else                          $sel ="";
                             ?>
                               <option value="<?=$row->pay_name?>" <?=$sel?>><?=$row->pay_name?> </option>
                              <?
                       }
               }  ?>
        </select>
    </b> </td>
  </tr>

 <tr>
    <td><font color="#FFA200">* <?=$allreqd?></font>
    </td>
  </tr>
<tr>
<td id="td_id" height = "75" valign="top">
<div id="layer_2checkout"  style="position:absolute;   display:none;width:615px; left:28%; border:0px none #000000;">
<table width="90%" class="tablewbdr" align="center"><tr><td height='25' colspan='2' align='center'><?=$lang_2Checkout?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_checkoutid?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='checkoutid' size='20' value='<?=$checkoutid?>' /></td></tr><!--tr><td height='25' width='50%' align="right"><? //$lang_productid?>&nbsp;</td><td height='25' width='50%'> <input type='text' name='productid' size='20' value='<? //$productid?>' /> </td></tr--></table>
</div>
<div id="layer_paypal"  style="position:absolute;  display:none; width:615px; left:28%;  border: 0px none #000000;">
<table width="90%" class="tablewbdr" align="center"><tr><td height='25' colspan='2' align='center'><?=$lang_Paypal?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_payapalemail?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='paypalemail' size='20' value='<?=$paypalemail?>' />  </td>    </tr><tr> <td height='25' width='50%'>  </td><td height='25' width='50%'>  </td>  </tr> </table>
</div>
<div id="layer_stormpay"  style="position:absolute;  display:none; width:615px; left:28%;  border: 0px none #000000;">
<table width="90%" class="tablewbdr" align="center"><tr ><td height='25' colspan='2' align='center'><?=$lang_Stormpay?></td>    </tr><tr><td height='25' width='50%' align='right'><?=$lang_stormemail?>&nbsp;&nbsp;  </td> <td height='25' width='50%'> <input type='text' name='stormemail' size='20' value='<?=$stormmail?>' />  </td>    </tr><tr>  <td height='25' width='50%'>  </td>   <td height='25' width='50%'>  </td>  </tr></table>
</div>
<div id="layer_authorize"  style="position:absolute; display:none; width:615px; left:28%; border: 0px none #000000;">
<table width="90%" class="tablewbdr" align="center"><tr ><td height='25' colspan='2' align='center'><?=$lang_Authorize?></td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_version?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input name='version' type='text'  value ='<?=$version?>' size='20' />  </td>    </tr><tr><td height='25' width='50%' align='right'><?=$lang_delimdata?>&nbsp;&nbsp;</td><td height='25' width='50%'>  <select name='delimdata'><option value='True' <?=$delimdataselected1?>><?=$regbank_true?></option>     <option value='False' <?=$delimdataselected2?>><?=$regbank_false?></option> </select></td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_relayresponse?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <select name='relayresponse'> <option value='True'  <?=$relayresponseselected1?>><?=$regbank_true?></option><option value='False'  <?=$relayresponseselected2?>><?=$regbank_false?></option></select> </td></tr><tr><td height='25' width='50%' align='right'><?=$lang_login?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input name='login' type='text'  value ='<?=$login?>' size='20' />   </td>    </tr><tr> <td height='25' width='50%' align='right'><?=$lang_trankey?>&nbsp;&nbsp;</td> <td height='25' width='50%'> <input name='trankey' type='text'  value ='<?=$trankey?>' size='20' />  </td>    </tr><tr><td height='25' width='50%' align='right'><?=$lang_cctype?>&nbsp;&nbsp;</td> <td height='25' width='50%'> <select name='cctype' ><option value='AUTH_CAPTURE' <?=$cctypesel1?>><?=$regbank_authcap?></option>        <option value='AUTH_ONLY' <?=$cctypesel2?>><?=$regbank_authonly?></option>   <option value='CAPTURE_ONLY' <?=$cctypesel3?>><?=$regbank_caponly?></option>        <option value='CREDIT' <?=$cctypesel4?>><?=$regbank_credit?></option>         <option value='VOID' <?=$cctypesel5?>><?=$regbank_void?></option>        <option value='PRIOR_AUTH_CAPTURE' <?=$cctypesel6?>><?=$regbank_prior?></option>     </select>  </td>    </tr></table>
</div>
<div id="layer_egold"  style="position:absolute; display:none; width:615px; left:28%;   border: 0px none #000000;">
<table width="90%" class="tablewbdr" align="center"><tr ><td height='25' colspan='2' align='center'><?=$lang_eGold?></td> </tr><tr> <td height='25' width='50%' align='right'><?=$lang_acno?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='acno' size='20' value='<?=$acno?>' />  </td>    </tr> <tr> <td height='25' width='50%' align='right'><?=$lang_payeename?>&nbsp;&nbsp;</td>   <td height='25' width='50%'><input type='text' name='payeename' size='20' value='<?=$payeename?>' />  </td>      </tr> </table>
</div>
<div id="layer_checkbymail"  style="position:absolute; display:none; width:615px; left:28%;  border: 0px none #000000;">
<table width="90%" class="tablewbdr" align="center"> <tr><td height='25' colspan='2' align='center'><?=$lang_check_caption?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_check_payee?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='checkpayee' size='20' value='<?=$checkpayee?>' />  </td></tr><tr><td height='25' width='50%' align='right'><?=$lang_check_curr?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='checkcurr' size='20' value='<?=$checkcurr?>'  />  </td> </tr><tr><td height='25' width='50%'>  </td><td height='25' width='50%'>  </td> </tr></table>
</div>
<div id="layer_neteller"  style="position:absolute; display:none; width:615px; left:28%;  border: 0px none #000000;">
<table width="90%" class="tablewbdr" align="center"> <tr><td height='25' colspan='2' align='center'><?=$lang_neteller_caption?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_neteller_email?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='neteller_email' size='20' value='<?=$neteller_email?>' />  </td></tr><tr><td height='25' width='50%' align='right'><?=$lang_neteller_accnt?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='neteller_accnt' size='20' value='<?=$neteller_accnt?>'  />  </td> </tr><tr><td height='25' width='50%'>  </td><td height='25' width='50%'>  </td> </tr></table>
</div>
<div id="layer_wiretransfer"  style="position:absolute; display:none;width:615px; left:28%;  border: 0px none #000000;">
<table width="90%" class="tablewbdr" align="center"> <tr><td height='25' colspan='2' align='center'><?=$lang_wire_caption?></td></tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_AccountName?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='wire_AccountName' size='20' value='<?=$wire_AccountName?>' />  </td></tr> <tr><td height='25' width='50%' align='right'><?=$lang_wire_AccountNumber?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_AccountNumber' size='20' value='<?=$wire_AccountNumber?>'  />  </td> </tr> <tr><td height='25' width='50%' align='right'><?=$lang_wire_BankName?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankName' size='20' value='<?=$wire_BankName?>'  />  </td> </tr><tr><td height='25' width='50%' align='right' valign='top'><?=$lang_wire_BankAddress?>&nbsp;&nbsp;</td><td height='25' width='50%'> <textarea name='wire_BankAddress' rows='5' cols='27'><?=$wire_BankAddress?></textarea>  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankCity?>&nbsp;&nbsp;</td><td height='25' width='50%'> <input type='text' name='wire_BankCity' size='20' value='<?=$wire_BankCity?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankState?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankState' size='20' value='<?=$wire_BankState?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankZip?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankZip' size='20' value='<?=$wire_BankZip?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankCountry?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankCountry' size='20' value='<?=$wire_BankCountry?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_BankAddressNumber?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_BankAddressNumber' size='20' value='<?=$wire_BankAddressNumber?>'  />  </td> </tr><tr><td height='25' width='50%' align='right'><?=$lang_wire_Nominate?>&nbsp;&nbsp;</td>        <td height='25' width='50%'> <input type='text' name='wire_Nominate' size='20' value='<?=$wire_Nominate?>'  />  </td> </tr><tr><td height='25' width='50%'></td><td height='25' width='50%'>  </td> </tr>            </table>
</div>

 </td>
 </tr>
</table>
 <table cellpadding="0" cellspacing="0" width="100%">
 <tr>
     <td height="20" bgcolor="#5BA7E3" align="center"><b style="color: #ffffff"><?=$lang_terms_condn?></b>
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
    <td height="19" align="center"><input name="terms" type="checkbox" value="1"/> <?=$lang_terms?>

    </td>
  </tr>
  <tr>
    <td height="19">&nbsp;

    </td>
  </tr>
  <tr>
    <td height="19" align="center">
      <input type="submit" value="Register" name="B1" />
    </td>
  </tr>
</table>

<script language="javascript" type="text/javascript">
 function  getpayment() {
    if(document.reg.modofpay.value=="2checkout")
        {
                                        document.getElementById("td_id").height = 100;
                                        document.getElementById("layer_2checkout").style.display = 'block';
        }
    if(document.reg.modofpay.value=="Paypal")
        {
                                        document.getElementById("td_id").height = 75;
                    document.getElementById("layer_paypal").style.display = 'block';
        }
    if(document.reg.modofpay.value=="Stormpay")
        {
                                        document.getElementById("td_id").height = 75;
                    document.getElementById("layer_stormpay").style.display = 'block';
        }
    if(document.reg.modofpay.value=="Authorize.net")
        {
                                        document.getElementById("td_id").height = 205;
                    document.getElementById("layer_authorize").style.display = 'block';
        }
    if(document.reg.modofpay.value=="E-Gold")
        {
                                        document.getElementById("td_id").height = 95;
                    document.getElementById("layer_egold").style.display = 'block';
        }
    if(document.reg.modofpay.value=="CheckByMail")
        {
                                        document.getElementById("td_id").height = 95;
                    document.getElementById("layer_checkbymail").style.display = 'block';
        }
    if(document.reg.modofpay.value=="NETeller")
        {
                                        document.getElementById("td_id").height = 195;
                    document.getElementById("layer_neteller").style.display = 'block';
        }
    if(document.reg.modofpay.value=="WireTransfer")
        {
                                        document.getElementById("td_id").height = 380;
                    document.getElementById("layer_wiretransfer").style.display = 'block';

        }
        hide_other_layers(document.reg.modofpay.value);
}

function hide_other_layers(value){
                if(value!="2checkout")                 document.getElementById("layer_2checkout").style.display = 'none';
                if(value!="Paypal")                 document.getElementById("layer_paypal").style.display = 'none';
                if(value!="Stormpay")                 document.getElementById("layer_stormpay").style.display = 'none';
                if(value!="Authorize.net")         document.getElementById("layer_authorize").style.display = 'none';
                if(value!="E-Gold")                 document.getElementById("layer_egold").style.display = 'none';
                if(value!="CheckByMail")         document.getElementById("layer_checkbymail").style.display = 'none';
                if(value!="NETeller")                 document.getElementById("layer_neteller").style.display = 'none';
                if(value!="WireTransfer")         document.getElementById("layer_wiretransfer").style.display = 'none';
}


    if(document.reg.modofpay.value=="2checkout")
        {
                                        document.getElementById("td_id").height = 100;
                                        document.getElementById("layer_2checkout").style.display = 'block';
        }
    if(document.reg.modofpay.value=="Paypal")
        {
                                        document.getElementById("td_id").height = 75;
                    document.getElementById("layer_paypal").style.display = 'block';
        }
    if(document.reg.modofpay.value=="Stormpay")
        {
                                        document.getElementById("td_id").height = 75;
                    document.getElementById("layer_stormpay").style.display = 'block';
        }
    if(document.reg.modofpay.value=="Authorize.net")
        {
                                        document.getElementById("td_id").height = 205;
                    document.getElementById("layer_authorize").style.display = 'block';
        }
    if(document.reg.modofpay.value=="E-Gold")
        {
                                        document.getElementById("td_id").height = 95;
                    document.getElementById("layer_egold").style.display = 'block';
        }
    if(document.reg.modofpay.value=="CheckByMail")
        {
                                        document.getElementById("td_id").height = 95;
                    document.getElementById("layer_checkbymail").style.display = 'block';
        }
    if(document.reg.modofpay.value=="NETeller")
        {
                                        document.getElementById("td_id").height = 195;
                    document.getElementById("layer_neteller").style.display = 'block';
        }
    if(document.reg.modofpay.value=="WireTransfer")
        {
                                        document.getElementById("td_id").height = 380;
                    document.getElementById("layer_wiretransfer").style.display = 'block';

        }


</script>
