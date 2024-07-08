<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  graph_affiliate.php                            */
/*     CREATED ON     :  04/JULY/2006                                   */

/*		File is used to get the values based on which the Affiliate at a Glance                                                 
	graph is to be created and displays the graph using tables			*/
/************************************************************************/

	$MERCHANTID     = $_SESSION['MERCHANTID'];    //merchantid
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
	$result 	= $graphobj->GetAllPrograms($mid);
	
?>

<script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.Affiliate.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.Affiliate.txtto,Date);
        }
</script>

<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>

<br/>
<form name="Affiliate" method="post" action="">
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="80%">
		<tr>
			<td colspan="2" align="center" width="100%">
				<table border="0"  cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td align="center"   height="25" class="tdhead" width="95%" ><?=$lang_affiliate_at_glance?></td>
						<td align="right" class="tdhead" width="5%" >
							<a href="#" onClick="popWin('../help_affiliateGlance.php?user=Merchant');"><img src="../images/help.jpg" border="0"  >&nbsp;<?=$laff_Help?>&nbsp;</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" width="100%">
				<table align="center" cellpadding="0" cellspacing="0" width="100%" >
					<tr>
						<td  height="19" colspan="2"  align="center" >
						<?=$lang_report_forperiod?></td>
					</tr>
					<tr>
						<td width="50%" height="24" align="right"><?=$lang_report_from?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td width="50%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /></td>
					</tr>
					<tr>
						<td width="50%" height="24" align="right"><?=$lang_report_to?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td width="50%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$to?>" onfocus="javascript:to_date();return false;" /></td>
					</tr>
					<tr>
						<td colspan="2" height="23">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="26">
						<input name="currValue" type="hidden" value="<?=$currValue?>" />
						<input type="submit" name="sub" value="<?=$lang_report_view?>"  /></td>
					</tr>		
				
				</table>
			</td>
		</tr>
		
		<tr>
			<td align="center" height="25" colspan="2" class="tdhead" ><?=$lhome_Programs?>
				<select name="programs" onchange="document.Affiliate.submit()">
					<option value="All" ><?=$lhome_AllPrograms?></option>
				<?	
				if($result)
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
		</tr>
<?php		
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
								<tr><td><b><?=$trans_affiliate?></b></td></tr>
							</table>
							<table  cellpadding="0" cellspacing="2" align="left" width="300">
								<tr>
									<td align="center"><b><?=$lang_affiliate_clicks?></b></td>
								</tr>
							</table>
							<table  cellpadding="0" cellspacing="2" align="center" width="300">
								<tr>
									<td align="center"><b><?=$lang_affiliate_sales?></b></td>
								</tr>
							</table>
						</td>
					</tr>
					<? } else { ?>
					<tr><td class="textred"><?=$err_no_affiliates?></td></tr>
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
</form>
<script language="javascript" type="text/javascript">

	function popWin(url)
	{
		nw = open(url,'new','height=400,width=400,scrollbars=yes');
		nw.focus();
	}


</script>			