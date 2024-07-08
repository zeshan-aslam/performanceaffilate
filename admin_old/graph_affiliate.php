<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  graph_affiliate.php                            */
/*     CREATED ON     :  08/JULY/2006                                   */

/*		File is used to get the values based on which the Affiliate at a Glance                                                 
	graph is to be created and displays the graph using tables			*/
/************************************************************************/

	$MERCHANTID     = intval(trim($_REQUEST['merchants']));    //merchantid
	$programId		= intval(trim($_REQUEST['programs']));
	
	//getting dates
	$from	= trim($_REQUEST['txtfrom']);
	$to		= trim($_REQUEST['txtto']);
	
	$partners=new partners;
	if($from != "" && $to != "")
	{
		$fromDate 	= $partners->date2mysql($from);  //changing date format
		$toDate     = $partners->date2mysql($to);
	}
	
	
	if(empty($programId))
		$programId		= "All";

	$graphobj 	= new graphs();
	$result 	= $graphobj->GetAllMerchants();

?>

<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>

<br/>
<form name="Affiliate" method="post" action="">
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="60%">
		<tr>
			<td colspan="2" align="center" width="100%">
				<table border="0"  cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td align="center" height="25" class="tdhead" width="95%" ><b> Affiliate At a Glance </b></td>
						<td align="right" class="tdhead" width="5%" >
							<a href="#" onClick="popWin('../help_affiliateGlance.php?user=Admin');"><img src="../images/help.jpg"  border="0" >&nbsp;Help&nbsp;</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td align="center" width="50%">
				<table align="center" cellpadding="0" cellspacing="0" width="100%" >
					<tr>
						<td  height="19" colspan="2"  align="center" ><b>
						For Period</b></td>
					</tr>
					<tr>
						<td width="50%" height="24" align="right">From&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td width="50%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /></td>
					</tr>
					<tr>
						<td width="50%" height="24" align="right">To&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td width="50%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$to?>" onfocus="javascript:to_date();return false;" /></td>
					</tr>
					<tr>
						<td colspan="2" height="23">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="26">
						<input name="currValue" type="hidden" value="<?=$currValue?>" />
						<input type="submit" name="sub" value="View"  /></td>
					</tr>		
				
				</table>
			</td>
			<td width="50%" align="center" valign="top">
				<table align="center" cellpadding="0" cellspacing="0" width="100%" >
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr valign="top">
						<td width="50%" align="right" height="25" ><b>Merchant</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td width="50%" align="left" height="25" >
							<select name="merchants" onchange="document.Affiliate.submit()">
								<option value="" >Select One Merchant</option>
							<?	
							if($result)
							{	
								for($i=0; $i<count($graphobj->merId); $i++)
								{
							?>
								<option <? if($MERCHANTID == $graphobj->merId[$i]) echo "selected='selected'"; ?> value="<?=$graphobj->merId[$i]?>"><?=$graphobj->merCompany[$i]?></option>
							<? 
								}
							}	
							?>
							</select>
						</td>
					</tr>
					<tr>
					<?
					if($MERCHANTID != "")
					{
						$result_prg 	= $graphobj->GetAllPrograms($MERCHANTID);
					?>
						<td width="50%" align="right" height="25"  ><b>Programs</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td width="50%" align="left" height="25"  >
							<select name="programs" onchange="document.Affiliate.submit()">
								<option value="All" >All Programs</option>
							<?	
							if($result_prg)
							{	
								for($i=0; $i<count($graphobj->pgmId); $i++)
								{
							?>
								<option <? if($programId == $graphobj->pgmId[$i]) echo "selected='selected'"; ?> value="<?=$graphobj->pgmId[$i]?>"><?=$graphobj->pgmName[$i]?></option>
							<? 
								}
							}	
							?>
							</select>
						</td>
					<?
					}
					?>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br>
<?	
if($MERCHANTID != "")
{
?>
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="95%">
<?	
	$graphobj->FindAffiliateClickPercentage($MERCHANTID,$programId,$fromDate,$toDate);
	$rowcount 	= $graphobj->rowcount;
	$total		= $graphobj->total; 
	$totalSale	= $graphobj->total_sale; 
?>
		<tr>
			<td width="100%" align="center" colspan="2">
				<table width="100%" align="center" >
				<? if($graphobj->rowcount > 0) { ?>
					<tr>
						<td>
							<table  width="100" align="left">
								<tr><td><b>Affiliate</b></td></tr>
							</table>
							<table  cellpadding="0" cellspacing="2" align="left" width="300">
								<tr>
									<td align="center"><b>Click Representation</b></td>
								</tr>
							</table>
							<table  cellpadding="0" cellspacing="2" align="center" width="300">
								<tr>
									<td align="center"><b>Sales Representation</b></td>
								</tr>
							</table>
						</td>
					</tr>
					<? } else { ?>
					<tr><td class="textred">Sorry! Merchant has no Affiliates for the selected program</td></tr>
					<? } ?>
					<tr>
						<td>
						<? 	$height = 20 * count($graphobj->affId);  
							 
							for($i=0; $i<count($graphobj->affId); $i++)
							{ 
								$affiliateClick 	= $graphobj->affClick[$i];
								$affiliateCompany 	= $graphobj->affCompany[$i];
								if($total > 0)
									$clickPercent	= ($affiliateClick * 100) / $total;
								else 
									 $clickPercent	= 0;
								$clickInTable		= (300 * $clickPercent) / 100  ; 
								$balance 			= 300 - $clickInTable;
								
								$affiliateSale		= $graphobj->affSale[$i];
								if($totalSale > 0)
									$salePercent	= ($affiliateSale * 100) / $totalSale;
								else
									$salePercent	= 0;
								$saleInTable		= (300 * $salePercent) / 100  ; 
								$balanceSale		= 300 - $saleInTable;
							?>
							<table width="100" align="left" cellpadding="0" cellspacing="1">
								<tr>
									<td align="center"><?=$affiliateCompany?></td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="1" align="left" width="300" bgcolor="silver">
								<tr>
									<td width="<?=$clickInTable?>"  bgcolor="#000099" style="color:#FFFFFF;" height="15"><? if($clickInTable>0) { echo $affiliateClick; } ?></td>
									<td width="<?=$balance?>"  bgcolor="silver" ></td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="1" align="center" width="300" bgcolor="silver">
								<tr>
									<td width="<?=$saleInTable?>"  bgcolor="#000099" style="color:#FFFFFF;" height="15"><? if($saleInTable>0) { echo $affiliateSale; } ?></td>
									<td width="<?=$balanceSale?>"  bgcolor="silver" ></td>
								</tr>
							</table>
							<? } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	</table>
<?
}
?>			
</form>
<br />
<script language="javascript" type="text/javascript">

	function popWin(url)
	{
		nw = open(url,'new','height=400,width=400,scrollbars=yes');
		nw.focus();
	}

	function from_date()
	{
	 gfPop.fStartPop(document.Affiliate.txtfrom,Date);
	}

	function to_date()
	{
	 gfPop.fStartPop(document.Affiliate.txtto,Date);
	}

</script>			