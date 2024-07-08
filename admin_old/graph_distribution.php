<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  graph_distribution.php                         */
/*     CREATED ON     :  05/JULY/2006                                   */

/*		File is used to get the values based on which the Distribution Report                                                 
	graph is to be created and calls the page that creates the graph	*/
/************************************************************************/

	$MERCHANTID     = intval(trim($_REQUEST['merchants']));    //merchantid

	$type 	= $_REQUEST['type'];
	if($type == "")
		$type = 'click';
		
	$graphobj 	= new graphs();
	$result 	= $graphobj->GetAllMerchants();

?>
<form name="Distribution" method="post" action="">
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="60%">
		<tr>
			<td colspan="2" align="center" width="100%">
				<table border="0"  cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td align="center" class="tdhead" colspan="2" height="25" width="95%" ><b>Distribution Report</b></td>
						<td align="right" class="tdhead" width="5%" >
							<a href="#" onClick="popWin('../help_distribution.php?user=Admin');"><img src="../images/help.jpg" border="0"  >&nbsp;Help&nbsp;</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="50%" align="right" height="25" >Merchant&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td width="50%" align="left" height="25" >
				<select name="merchants" onchange="document.Distribution.submit()">
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
			<td align="right" height="25" >Action&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td align="left" height="25" >
				<select name="type" onchange="document.Distribution.submit()">
					<option <? if($type == 'click') echo "selected='selected'"; ?>  value="click" >Click</option>
					<option <? if($type == 'sale') echo "selected='selected'"; ?>  value="sale" >Sale</option>
					<option <? if($type == 'commission') echo "selected='selected'"; ?>  value="commission" >Commission</option>
				</select>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>

	</table>
	<br />
<?	
if($MERCHANTID != "")
{
?>
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="80%">
<?
			$graphobj->FindPerformanceAffiliateGroup($MERCHANTID,$type);
			$total = $graphobj->total;  
			for($i=0; $i<count($graphobj->groupCount); $i++)
			{
				$affiliate10 	= $graphobj->groupCount[0];    
				$affiliate20	= $graphobj->groupCount[1];	 
				$affiliate50	= $graphobj->groupCount[2];	 
				$affiliate75	= $graphobj->groupCount[3]; 
				$affiliateAbove	= $graphobj->groupCount[4];		 
			}
			if($total > 0)
			{
				$affiliate10Percent 	= ($affiliate10 * 100) / $total ;    
				$affiliate20Percent		= ($affiliate20 * 100) / $total ;		 
				$affiliate50Percent		= ($affiliate50 * 100) / $total ;		 
				$affiliate75Percent		= ($affiliate75 * 100) / $total ;		 
				$affiliateAbovePercent	= ($affiliateAbove * 100) / $total ;		 
			}
				$affiliate10 	= ($affiliate10Percent * 360) / 100 ;    
				$affiliate20	= ($affiliate20Percent * 360) / 100  ;		 
				$affiliate50	= ($affiliate50Percent * 360) / 100  ;		 
				$affiliate75	= ($affiliate75Percent * 360) / 100  ;		 
				$affiliateAbove	= ($affiliateAbovePercent * 360) / 100  ;		 
			
			$affiliate20	= $affiliate10 + $affiliate20;
			$affiliate50	= $affiliate50 + $affiliate20;
			$affiliate75	= $affiliate50 + $affiliate75;
			$affiliateAbove	= $affiliateAbove + $affiliate75;
		?>

		<tr>
			<td width="80%" align="center">
				<table width="100%" align="center" >
					<tr>
						<td>
							<table cellpadding="0" cellspacing="5" align="left">
								<tr>
									<td><b>Colors</b></td>
									<td><b>Percentage</b></td>
									<td align="center"><b>Color Description</b></td>
								</tr>
								<tr>
									<td align="left" bgcolor="#cc0033" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($affiliate10Percent,2)?></td>
									<td align="left">Affiliates 1-10</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#ffcc00" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($affiliate20Percent,2)?></td>
									<td align="left">Affiliates 11-20</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#3300ff" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($affiliate50Percent,2)?></td>
									<td align="left">Affiliates 21-50</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#009900" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($affiliate75Percent,2)?></td>
									<td align="left">Affiliates 51-75</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#00ccff" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($affiliateAbovePercent,2)?></td>
									<td align="left">Affiliates from 75</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#C0C0C0" width="50" height="15">&nbsp;</td>
									<td align="center"><? if($total == 0) echo "100"; else echo "0";?></td>
									<td align="left">Affiliates not performed the selected Action</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" width="100%">
							<img src="distributionreport.php?alt=0&day1=<?=$affiliate10?>&day15=<?=$affiliate20?>&month1=<?=$affiliate50?>&month2=<?=$affiliate75?>&total=<?=$affiliateAbove?>" alt="" border=0>
						</td>
					</tr>
				</table>
			</td>
		</tr>
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
</script>			