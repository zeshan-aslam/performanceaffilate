<?php

include_once 'includes/db-connect.php';

#-------------------------------------------------------------------------------
# Mercahnt Payment Form
# Merchant is alreday registered with the site
# But the payment is not yet done

# Pgmmr           : RR
# Date Created 	  :   22-11-2004
# Date Modfd   	  :   22-1-2005
#-------------------------------------------------------------------------------

# get mercahnt id
  $mer_id = $_GET['id'];

# getting msg
  $ErrMsg	= $_GET['Errmsg'];

  #-----------------------------------------------------------------
  # fetching mercahnt account type from table
  #-----------------------------------------------------------------


  $Mersql = "SELECT  merchant_type,merchant_status,merchant_currency FROM  partners_merchant WHERE merchant_id= $mer_id " ;
  $Merret = @mysqli_query($con, $Mersql);

  if(@mysqli_num_rows($Merret)>0){
  	$Merrow  = @mysqli_fetch_object($Merret);
    $Mertype = trim($Merrow->merchant_type);
    $Merstat = trim($Merrow->merchant_status);
    $Mercur  = trim($Merrow->merchant_currency);
    $MerSym  = $currArray[$Mercur];
  }

  #-----------------------------------------------------------------
  # setting pay amount according to the mercahnt type
  #-----------------------------------------------------------------
  if($Merstat=="NP") {
   	  		$type   = trim(strtolower($Mertype));
	        if($type=="normal") {
	         $amount  = $normal_user;
	        }else{
	         $amount  = $advanced_user;
	        }

             $date		= date("Y-m-d");
     		 $newAmount = getCurrencyValue($date, $Mercur, $amount);
             $textcation= $lang_NPcaption;

   }
   if($Merstat=="empty"){

           $newamount = $_SESSION['MERCHANTBALANCE'];
           $amount    = $minimum_amount ;

           $date		= date("Y-m-d");
           $newAmount   = getCurrencyValue($date, $Mercur, $amount);
           $currAmount  = getCurrencyValue($date, $Mercur, $newamount);
           $textcation= $lang_NPcaption1.$newAmount." ".$MerSym." (".$lang_NPcaption2.$currAmount." ".$MerSym.")".$lang_NPcaption3;

   }
  #-----------------------------------------------------------------
  # fetching payment information from table
  #-----------------------------------------------------------------

  $sql 	= "select * from partners_paymentgateway where pay_status like 'Active' and pay_flag= 'b'";
  $ret 	= @mysqli_query($con, $sql);

 # checking whtehre the mercahnt payemnet is already doen
  if($Merstat<>"NP" and $Merstat<>"empty"){
    ?><table class="tablewbdr" id="AutoNumber1" style="border-collapse: collapse" width="100%" >
  <tr>
    <td height="19" class="textred" align="center" colspan="2" ><?=$ErrMsg?>&nbsp;<?=$lang_pay_msg?></td>
  </tr></table><?;
  }
  else{

?>
<br/>
<form name="test" action="paymoney_validate.php?id=<?=$mer_id?>" method="post">
<table class="tablewbdr" id="AutoNumber1" style="border-collapse: collapse" width="100%" >
  <tr>
    <td height="19"  align="left" colspan="2" ><span class='textred'><b><?=$lang_NPcaption4?> :</b> </span> <b><?=$textcation?></b>

    </td>
  </tr>
  <tr>
    <td height="19" class="textred" align="center" colspan="2" ><?=$ErrMsg?>

    </td>
  </tr>
  <tr>
    <td height='25' width='50%' align="right"><b>
        <?=$lang_PaymentGateway?> :</b> &nbsp;&nbsp;&nbsp; </td>
        <td width='50%' height='25' align="left">
        <select class="dropdown" name="modofpay" >
          <?//checking for each records
               if(mysqli_num_rows($ret)>0)
               {
                       while($row=mysqli_fetch_object($ret))
                       {     if($modofpay==$row->pay_name) $sel="selected='selected'";
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
  <td height='25' width='50%' align="right"><b><?=$lang_Amount?> :</b> &nbsp;&nbsp;&nbsp;</td>
  <td width='50%' height='25' align="left"><b><?=$MerSym?></b>&nbsp;&nbsp;&nbsp;
  <?=$newAmount?>
  <input name="amount" type="hidden" value="<?=$amount?>" /></td></tr>

  <tr>
    <td height="19" colspan="2">&nbsp;

    </td>
  </tr>
  <tr>
    <td height="19" colspan="2"  align="center">
      <input type="submit" value="<?=$paymoney_but?>" name="B1" />


    </td>
  </tr>
  <tr>
    <td height="19" colspan="2">&nbsp;

    </td>
  </tr>
</table>
</form>
 <? } ?>