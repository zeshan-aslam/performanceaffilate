<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  fraudsettings.php                              */
/*     CREATED ON     :  18/JUNE/2006                                   */
/*                                                                      */
/*     Fraud Settings                                                   */
/************************************************************************/

	$recentclick	= $fraudsettings_recentclick;
	$clickseconds	= $fraudsettings_clickseconds;
	$clickaction	= $fraudsettings_clickaction;
	$recentsale		= $fraudsettings_recentsale;
	$saleseconds	= $fraudsettings_saleseconds;
	$saleaction		= $fraudsettings_saleaction;
	$loginretry		= $fraudsettings_login_retry;
	$logindelay		= $fraudsettings_login_delay;
	$declinesale  	= $fraudsettings_decline_recentsale;

$msg = $_REQUEST['msg'];
if($msg)
{
	$recentclick	= stripslashes(trim($_REQUEST['recentclick']));
	$clickseconds	= stripslashes(trim($_REQUEST['clickseconds']));
	$clickaction	= stripslashes(trim($_REQUEST['clickaction']));
	$recentsale		= stripslashes(trim($_REQUEST['recentsale']));
	$saleseconds	= stripslashes(trim($_REQUEST['saleseconds']));
	$saleaction		= stripslashes(trim($_REQUEST['saleaction']));
	$loginretry		= stripslashes(trim($_REQUEST['loginretry']));
	$logindelay		= stripslashes(trim($_REQUEST['logindelay']));
	$declinesale  	= stripslashes(trim($_REQUEST['declinesale'])); 
}


$clickseconds	=  ($clickseconds)? $clickseconds : $fraudsettings_clickseconds ;
$saleseconds	=  ($saleseconds)? $saleseconds : $fraudsettings_saleseconds ;
$loginretry		=  ($loginretry)? $loginretry : $fraudsettings_login_retry ;
$logindelay		=  ($logindelay)? $logindelay : $fraudsettings_login_delay ;

?>
	<table border='0' cellpadding="2" cellspacing="1" width="90%" class="tablebdr">
		<form name="frm_fraud" action="fraudsettings_manage.php" onSubmit="return managefraud();" method="post">
		<tr>
    		<td colspan="2" height="18" class="tdhead" align="left">Fraud Protection</td>
  		</tr>

  		<tr>
    		<td colspan="2" height="18" align="center" class="textred">
    			<small><?=$msg?></small>
    		</td>
  		</tr>

  		<tr>
  		  	<td width="1%" height="26">&nbsp;</td>
	      	<td width="99%" height="26">

				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100%" height="30" align="left">
							<input type="checkbox" name="chk_click" <? if($recentclick==1) echo "checked = 'checked'"; ?> />&nbsp;
							Check multiple repeating clicks that came from the same IP Address(same computer) within&nbsp;
							<input type="text" name="txt_clickseconds" value="<?=$clickseconds?>" style="width:40px; " />&nbsp;seconds from initial click
						</td>
					</tr>
					<tr>
						<td width="100%" align="left" height="30">
							What to do with repeating clicks&nbsp;
							<select name="cmb_clickaction" >
								<option value="do not save" <? if($clickaction=='do not save') echo "selected='selected'"; ?> >do not save</option>
								<option value="save as click" <? if($clickaction=='save as click') echo "selected='selected'"; ?>>save as click</option>
							</select>
						</td>
					</tr>

					<tr>
						<td width="100%" height="30" align="left">
							<input type="checkbox" name="chk_sale" <? if($recentsale==1) echo "checked = 'checked'"; ?> />&nbsp;
							Check multiple repeating sales that came from the same IP Address(same computer) within&nbsp;
							<input type="text" name="txt_saleseconds" value="<?=$saleseconds?>" style="width:40px; " />&nbsp;seconds from initial sale
						</td>
					</tr>
					<tr>
						<td width="100%" align="left" height="30">
							What to do with repeating sales&nbsp;
							<select name="cmb_saleaction" >
								<option value="decline" <? if($saleaction=='decline') echo "selected='selected'"; ?> >decline</option>
								<option value="save" <? if($saleaction=='save') echo "selected='selected'"; ?> >save</option>
							</select>
						</td>
					</tr>

					<tr>
						<td width="100%" height="30" align="left">
							<input type="checkbox" name="chk_samesale" <? if($declinesale==1) echo "checked = 'checked'"; ?> />&nbsp;
							Automatically decline multiple repeating sales that have the same (non-empty) OrderId as the initial sale&nbsp;
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
			  	</table>
		  	</td>
      	</tr>
		<tr>
			<td colspan="2" align="left"  height="18" class="tdhead">Login Protection</td>
		</tr>
		<tr>
			<td width="1%">&nbsp;</td>
			<td width="99%">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td align="left" height="20">Login Protection Retries</td>
						<td align="left" height="20">&nbsp;&nbsp;<input type="text" name="txt_login_retry" value="<?=$loginretry?>" style="width:40px; "/></td>
						<td align="left" height="20">&nbsp;<b>miniHelp</b>&nbsp;How many times allow to login with incorrect username/password</td>
					</tr>
					<tr>
						<td colspan="2" height="20">&nbsp;</td>
						<td align="left" height="20">&nbsp;After specified number of retries, login is blocked for the user for "Login Protection delay seconds</td>
					</tr>
					<tr>
						<td colspan="2" height="20">&nbsp;</td>
						<td align="left" height="20">&nbsp;Default is 3, if it is 0, Login Protection is switched off.</td>
					</tr>
					
					<tr><td colspan="3"><hr></td></tr>
					
					<tr>
						<td align="left" height="20">Login Protection delay</td>
						<td align="left" height="20">&nbsp;&nbsp;<input type="text" name="txt_login_delay" value="<?=$logindelay?>" style="width:40px; "/></td>
						<td align="left" height="20">&nbsp;<b>miniHelp</b>&nbsp;When anaccount was blocked beacuse of a few unsuccessful login attempts</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
						<td align="left">&nbsp;it will remain blocked for the specified amount of seconds</td>
					</tr>
					
					<tr><td colspan="3"><hr></td></tr>
					
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>					
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" valign="middle" height="30"><input type="submit" name="fraud_submit" value="Submit" /></td>
		</tr>
		</form>
	</table><br />
	
	
	<script language="javascript">
		function  managefraud()
		{	 
			if(document.frm_fraud.chk_click.checked==true)
			{
				if(document.frm_fraud.txt_clickseconds.value == '')
				{
					alert('Please enter the seconds for repeating clicks');
					document.frm_fraud.txt_clickseconds.focus();
					return false;
				}
			}		
			if(document.frm_fraud.chk_sale.checked==true)
			{
				if(document.frm_fraud.txt_saleseconds.value == '')
				{
					alert('Please enter the seconds for repeating sale');
					document.frm_fraud.txt_saleseconds.focus();
					return false;
				}
			}				
			if(document.frm_fraud.txt_login_retry.value == '')
			{
				alert('Please enter the login retry seconds');
				document.frm_fraud.txt_login_retry.focus();
				return false;
			} 
			if(document.frm_fraud.txt_login_delay.value == '')
			{
				alert('Please enter the login delay seconds');
				document.frm_fraud.txt_login_delay.focus();
				return false;
			}
			return true;			
		}
	</script>