<?

//=============================================================================//
//  Last Modfd	: 11-1-2005                                         
//  Script Name	: admin_currency.php               			    
//=============================================================================//


# Add provision to support multiple currencies
# sets a currency as default currency
# generates a relation between currencies based on this default currency


$id		= trim($_GET['id']);
$mode	= trim($_GET['mode']);

#-------------------------------------------------------------------------------
# getting default currency
#-------------------------------------------------------------------------------
//$dftsql =  "SELECT DISTINCT(currency_caption),currency_symbol,currency_caption FROM partners_currency WHERE currency_default = 'yes' ";
$dftsql	= "SELECT * FROM partners_currency WHERE currency_code='$default_currency_code' ";
$dftret	= mysqli_query($con,$dftsql);

if(mysqli_num_rows($dftret)>0){
	$dftrow   = mysqli_fetch_object($dftret);
    $dftcurr  = trim(stripslashes($dftrow->currency_caption));
    $dftsym   = trim(stripslashes($dftrow->currency_symbol));
    $dftid    = trim(stripslashes($dftrow->currency_id));
	$dftcode  = trim(stripslashes($dftrow->currency_code));
}

#-------------------------------------------------------------------------------
#  setting values according to $mode
#-------------------------------------------------------------------------------

if($mode=="Delete"){
      #-------------------------------------------------------------------------
      # Add condition to check whethre this currency is selected by any mercahnt
      #-------------------------------------------------------------------------

      $chkSql = "SELECT merchant_id FROM partners_merchant WHERE merchant_currency = '$id' ";
      $chkRet = mysqli_query($con,$chkSql) or die("Sorry Error while processing sql");

      if(mysqli_num_rows($chkRet)>0){
           $msg = 6;
      }else{

     	# delete
     	$deleteSql = "DELETE FROM partners_currency WHERE currency_id = '$id'";
     	$deleteRet  = mysqli_query($con,$deleteSql) or die("You have an error while processing sql query ");

     	$msg = 5;
     }

}
if($mode=="Edit"){
	$capt = "Set New Currency Relation";

    # getting currency vaules

    $editSql = "SELECT * FROM partners_currency WHERE currency_id = '$id' ";
    $edtRet  = mysqli_query($con,$editSql) or die("You have an error while processing sql query ");

    if(mysqli_num_rows($edtRet)>0){
        $editRow = mysqli_fetch_object($edtRet);

        $currency_caption  = trim(stripslashes($editRow->currency_caption));
        $currency_symbol   = trim(stripslashes($editRow->currency_symbol));
        $currency_relation = trim(stripslashes($editRow->currency_relation));
    }

}else{
    $capt = "Set New Currency Relation";
    $mode = "Add";
}

#-------------------------------------------------------------------------------
#  getting existing currencies.
#-------------------------------------------------------------------------------
//$sql = "SELECT DISTINCT(currency_caption) FROM partners_currency WHERE currency_default like 'no'";
$sql = "SELECT * FROM partners_currency WHERE currency_code != '$default_currency_code'";
$ret = mysqli_query($con,$sql) or die("You have an error while fetching currencies ".mysql_error() );
$ret1 = mysqli_query($con,$sql);

# ddisplay messages

switch($msg){
 case 1:
     $ErrMsg = "Please Don't Leave Any Fields!!";
     break;
 case 2:
     $ErrMsg = "Sorry, this entry already exists!!";
     break;
 case 3:
     $ErrMsg = "New Currency has been added successfully!!";
     break;
 case 4:
     $ErrMsg = "Currency has been edited successfully!!";
     break;
 case 5:
     $ErrMsgd = "Currency has been deleted successfully!!";
     break;
 case 6:
     $ErrMsgd = "Sorry, this Currency is being used by a merchant!!";
     break;
 case 7:
     $ErrMsgd = "Default Currency has been changed!!";
     break;
 case 8:
     $ErrMsg = "Please enter Numeric Values as relation field!!";
     break;
 case 12:
 	$ErrMsg = "Invalid Entry.  Action Failed";
	break;

}
?>

<br/>
 <form name = "currency" method="post" action="currency_validate.php?mode=<?=$mode?>&amp;id=<?=$id?>"  enctype="multipart/form-data">
<table cellpadding="0" cellspacing="0" border='0' class="tablebdr" width="90%">
       <tr><td width="100%" class="tdhead" align="center" colspan="2" >
           <b>Supported Currencies</b>
           </td>
        </tr>
        <tr><td width="100%"  align="center" colspan="2" >&nbsp;

            </td>
        </tr>
		<tr>
        <td width="50%" valign="top">
            		<table width="98%" cellpadding="5" cellspacing="0" border='0' class="tablebdr" align="center">
                        <tr><td class="tdhead" colspan="7" align="center"><b>Existing Currencies</b></td></tr>

                        <tr><td class="textred" colspan="7" align="center" ><?=$ErrMsgd?></td></tr>

                        <tr><td class="textred" colspan="7" align="left" ><b>Base Currency</b> : <b><?=$dftcurr?>(<?=$dftsym?>)&nbsp;<?=$dftcode?></b></td></tr>
                        <?
                        # displau all currencies
 	                  		if(mysqli_num_rows($ret)>0){
                            	$i = 0;
                            	while($row=mysqli_fetch_object($ret)){
                                $i++;

                                    //$newSql = "SELECT * FROM partners_currency WHERE currency_caption = '$row->currency_caption' order by currency_date DESC";
									$newSql = "SELECT * FROM partners_currency_relation WHERE relation_currency_code = '$row->currency_code' order by relation_date DESC";
                                    $newRet = @mysqli_query($con,$newSql);

                                    if(@mysqli_num_rows($newRet)){
                                      $newRow 				= @mysqli_fetch_object($newRet);
                                      //$currency_relation	= $newRow->currency_relation;
                                      //$currency_symbol		= $newRow->currency_symbol;
									  $currency_relation	= $newRow->relation_value;
                                      $currency_symbol		= $row->currency_symbol;

									  //check whether this currency is being used by any merchant
									  $sqlchk = "SELECT merchant_id FROM partners_merchant WHERE merchant_currency = '$row->currency_caption'";
									  $reschk = mysqli_query($con,$sqlchk);
									  $can_not_delete = 0;
									  if(mysqli_num_rows($reschk)>0) $can_not_delete = 1;

                                    }
                                 ?>
                                 <tr><td width="50%"  align="left"><b><?=$i?></b>.&nbsp;<?=stripslashes($row->currency_caption)?></td>
                                   <td width="37%" align="left" ><b>1&nbsp;<?=$dftsym?> = <?=$currency_relation?> <?=$currency_symbol?></b></td>
                                   <td width="13%" align="left" ><a href="#" onclick="javascript:delete_currency(<?=$can_not_delete?>,'<?=stripslashes($row->currency_caption)?>')">Delete</a></td></tr>
								   <?
                                }
	                         }
                             else{
                             ?>
                               <tr><td class="textred" colspan="7" align="center" >Sorry, No Currency(s) Found </td></tr>
                             <?
                             }
                        ?>
                     <tr><td colspan="7" align="center" >&nbsp;</td></tr>
            		</table>
        </td>
        <td width="50%" valign="top">
				<table width="98%" cellpadding="5" cellspacing="0" border='0' class="tablebdr" align="center">
               	   <tr>
                   <td width="100%" class="tdhead" align="center" colspan="3">
	                 <b><?=$capt?></b>
	                  </td>
	                </tr>
                  <?
					   $crnysql = " SELECT * FROM partners_currency  WHERE currency_code != '$default_currency_code'";
					   $crnyret = mysqli_query($con,$crnysql) or die("You have an error while processing sql query ");
                  ?>
                    <tr><td width="100%"  class="textred" align="left" colspan="3">All the * fields are mandatory</td>
                    </tr>

	                <tr><td width="100%"  class="textred" align="center" colspan="3"><?=$ErrMsg?></td>
                    </tr>

                    <tr><td width="40%"  align="center" >Currency&nbsp;<font color="#FF0000" size="1" ><b>*</b></font></td>
                          <td width="35%"  align="left" >&nbsp;
                          <select size="1" name="currency_caption" ><!--onchange="getCurrency()"-->
                          <!-- 
						  <option value="Pound" >Pound</option>
                          <option value="Yen" >Yen</option>
                          <option value="Euro" >Euro</option>
                          <option value="Swiss Francs" >Swiss Francs</option>
						  -->
							<?
							if(mysqli_num_rows($crnyret)>0){
							  while($crnyrow = mysqli_fetch_object($crnyret))
							  {
								  ?><option value="<?=$crnyrow->currency_code?>" <?=($crnyrow->currency_caption==$currency)?"selected='selected'":""?>><?=trim(stripslashes($crnyrow->currency_caption))?></option><?
							  }
							}
							?>
						 </select>
                          <!--<input name="currency_caption" type="text" value="<?=$currency_caption?>"> --></td>
                    </tr>


                    <tr><td width="40%"  align="center" >Set Relation&nbsp;<font color="#FF0000" size="1" ><b>*</b></font> ( <b>1 (<?=$dftsym?>)</b> )</td>
                          <td width="35%"  align="left" >&nbsp;<input name="currency_relation" type="text" value="" /> </td>
                    </tr>

                    <tr><td colspan="3" align="center" >
	                     <input type="submit" value="Submit" /> <input type="reset" value="Reset" /></td>
	                </tr>
                    </table>
    </td>
    </tr>
    <tr><td colspan="3" align="center"  height="10">
     </td></tr>
 	</table>
    </form>
	
<?
	$crnysql = " SELECT * FROM partners_currency  WHERE currency_code != '$default_currency_code'";
	$crnyret = mysqli_query($con,$crnysql) or die("You have an error while processing sql query ");

	$note 	= $_REQUEST['note'];
	$note1 	= $_REQUEST['note1'];
	$txt_caption		= trim(stripslashes($_REQUEST['txt_caption']));
	$txt_code			= trim(stripslashes($_REQUEST['txt_code']));
	$txt_symbol			= trim(stripslashes($_REQUEST['txt_symbol']));
	$txt_relation		= trim(stripslashes($_REQUEST['txt_relation']));
	
	if($const_getCurrencyRatesFromXe == "1")
		$var_cur =  "checked = 'checked'";
	else
		$var_cur =  " ";
?>	
<form name="frm_base" method="post"  >
	<table align="center" cellpadding="0" cellspacing="0" width="60%" >
		<tr>
			<td height="50"><b><font size="2" color="#0000FF" >Get Currency Rates From XE.com</font></b>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="chk_currency" <?=$var_cur?> onClick="ChangeRateSystem('rate')" />
			</td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" border='0' class="tablebdr" width="60%">
       	<tr>
			<td width="100%" class="tdhead" align="center" colspan="2" > <b>Base Currency</b></td>
        </tr>
		<?
		if($note1) { ?>
		<tr><td colspan="2" align="center"><font color="#FF0000" size="1" ><b><?=$note1?></b></font></td></tr>		
		<?
		}
		?>
        <tr>
			<td width="100%"  align="center" colspan="2"  >&nbsp;</td>
        </tr>
		
		<tr>
			<td align="right" width="50%">Select Base Currency&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="left" width="50%" height="30">
				<select name="basecurrency" >
					<?
					if(mysqli_num_rows($crnyret)>0){
					  while($crnyrow = mysqli_fetch_object($crnyret))
					  {
						  ?><option value="<?=$crnyrow->currency_code?>" <?=($crnyrow->currency_caption==$currency)?"selected='selected'":""?>><?=trim(stripslashes($crnyrow->currency_caption))?></option><?
					  }
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2" height="30" valign="bottom">
				<input type="button" name="base" value="Change" onClick="Currency_Process('change');" />
			</td>
		</tr>
        <tr>
			<td height="30" width="100%"  align="center" colspan="2"  >&nbsp;</td>
        </tr>
	</table>
<br />
	<table width="60%" cellpadding="0" cellspacing="0" class="tablebdr" >
       	<tr>
			<td width="100%" class="tdhead" align="center" colspan="3" > <b>Add New Currency</b></td>
        </tr>
		<?
		if($note) {	?>
		<tr><td colspan="3" align="center"><font color="#FF0000" size="1" ><b><?=$note?></b></font></td></tr>
		<?
		}
		?>
        <tr>
			<td width="100%"  align="center" colspan="3"  >&nbsp;</td>
        </tr>
		<tr>
			<td align="right" width="45%" height="30">Currency Caption&nbsp;<font color="#FF0000" size="1" ><b>*</b></font></td>
			<td width="10%" height="30"></td>
			<td width="45%" height="30"><input type="text" name="txt_caption" value="<?=$txt_caption?>" /></td>
		</tr>
		<tr>
			<td align="right" width="45%" height="30">Currency Code&nbsp;<font color="#FF0000" size="1" ><b>*</b></font></td>
			<td width="10%" height="30"></td>
			<td width="45%" height="30"><input type="text" name="txt_code" value="<?=$txt_code?>" /></td>
		</tr>
		<tr>
			<td align="right" width="45%" height="30">Currency Symbol&nbsp;<font color="#FF0000" size="1" ><b>*</b></font></td>
			<td width="10%" height="30"></td>
			<td width="45%" height="30"><input type="text" name="txt_symbol" value="<?=$txt_symbol?>" /></td>
		</tr>
		<tr>
			<td align="right" width="45%" height="30">Currency Relation&nbsp;<font color="#FF0000" size="1" ><b>*</b></font></td>
			<td width="10%" height="30"></td>
			<td width="45%" height="30"><input type="text" name="txt_relation" value="<?=$txt_relation?>" /></td>
		</tr>
		<tr>
			<td align="center" colspan="3" height="30">
				<input type="button" name="Add" value="Add Currency" onClick="Currency_Process('add');" />&nbsp;&nbsp;&nbsp;
				<input type="reset" name="cancel" value="Cancel" />
			</td>
		</tr>
	</table>	
</form><br />
	
    <script language="javascript" type="text/javascript">
				function ChangeRateSystem(mode)
				{
					if(!confirm('Are you sure to toggle the status of the integration with XE.com'))
					{
						if(document.frm_base.chk_currency.checked == true)
							document.frm_base.chk_currency.checked = false;
						else
						 	document.frm_base.chk_currency.checked = true;
						return false;
					}
					document.frm_base.action='currency_process.php?mode='+mode;
					document.frm_base.submit();
				}
	
				function delete_currency(delete_currency,caption)
				{
					if(delete_currency)
						alert("You can't delete this currency since there are some merchants using it");
					else
						window.location = "currency_validate.php?caption=" + caption + "&mode=delete";
				}
				
				
				function Currency_Process(mode)
				{
					if(mode == 'add')
					{
						if(document.frm_base.txt_caption.value == '')
						{
							alert('Please enter the Currency Caption');
							document.frm_base.txt_caption.focus();
							return false;
						}
						
						if(document.frm_base.txt_code.value == '')
						{
							alert('Please enter the Currency Code');
							document.frm_base.txt_code.focus();
							return false;
						}
						if(document.frm_base.txt_symbol.value == '')
						{
							alert('Please enter the Currency Symbol');
							document.frm_base.txt_symbol.focus();
							return false;
						}
						if(document.frm_base.txt_relation.value == '')
						{
							alert('Please enter the Currency Reltion with Base Currency');
							document.frm_base.txt_relation.focus();
							return false;
						}
					}
					if(mode == 'change')
					{
						if(!confirm('On changing the base currency the values of all the transactions will be replaced with the value of the Base Currency.  Do you wish to Continue'))
							return false;
					}
					document.frm_base.action='currency_process.php?mode='+mode;
					document.frm_base.submit();
				}
    </script>