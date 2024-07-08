<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  graph_returndays.php                           */
/*     CREATED ON     :  08/JULY/2006                                   */

/*		File is used to get display the graph taht shows     
    	when an Affiliate makes a sale after a click	 				*/
/************************************************************************/

	$MERCHANTID     = intval(trim($_REQUEST['merchants']));    //merchantid
	$affiliate		= trim($_REQUEST['affiliates']);
	
	if(empty($affiliate))
		$affiliate		= "All";

	$graphobj 	= new graphs();
	$result 	= $graphobj->GetAllMerchants();
	
?>

<form name="ReturnDays" method="post" action="">
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="80%">
		<tr>
			<td colspan="2" align="center" width="100%">
				<table border="0"  cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td align="center"   height="25" class="tdhead" width="95%" >Return Day Analysis</td>
						<td align="right" class="tdhead" width="5%" >
							<a href="#" onClick="popWin('../help_returnDays.php?user=Admin');"><img src="../images/help.jpg" border="0" >&nbsp;Help&nbsp;</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td width="50%" align="right" height="25" ><b>Merchant</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td width="50%" align="left" height="25" >
				<select name="merchants" onchange="document.ReturnDays.submit()">
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
		<?
		if($MERCHANTID != "")
		{
			$result_aff 	= $graphobj->GetAffiliates($MERCHANTID);
			
		?>
		<tr>
			<td width="50%" align="right" height="25"  ><b>Affiliate</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td width="50%" align="left" height="25"  >
				<select name="affiliates" onchange="document.ReturnDays.submit()">
					<option value="All" >All Affiliates</option>
				<?	
				if($result_aff)
				{	
					for($i=0; $i<count($graphobj->aff_id); $i++)
					{
				?>
					<option <? if($affiliate == $graphobj->aff_id[$i]) echo "selected='selected'"; ?> value="<?=$graphobj->aff_id[$i]?>"><?=$graphobj->aff_comp[$i]?></option>
				<? 
					}
				}	
				?>
				</select>
			</td>
		</tr>
		<?
		}
		?>
		<tr><td colspan="2">&nbsp;</td></tr>
	</table>
	</br>
<?	
if($MERCHANTID != "")
{
?>
<br />
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="80%">
	
<?
					//gets the return day values for the respective period for the selected Affiliate
					$graphobj->FindReturnDays($affiliate,$MERCHANTID);
					$sameday 		= ($graphobj->total_sameday * 360) / 100;	 
					$within15 		= ($graphobj->total_15Day * 360) / 100;
					$withinOneMonth = ($graphobj->total_1Month * 360) / 100;
					$within2Month 	= ($graphobj->total_2Month * 360) / 100;
					$total			= $graphobj->total;

//echo "<br> same = ".$graphobj->total_sameday."  15day = ".$graphobj->total_15Day."  onemonth = ".$graphobj->total_1Month."  2month = ".$graphobj->total_2Month."  total = ".$graphobj->total_After;
					$within15 		= $sameday + $within15 ;		
					$withinOneMonth = $withinOneMonth + $within15;		
					$within2Month 	= $withinOneMonth + $within2Month;		
?>					
		<tr>
			<td width="80%" align="center">
				<table width="100%" align="center" height="100" >
					<tr>
						<td>
							<table cellpadding="0" cellspacing="5" align="left">
								<tr>
									<td><b>Colors</b></td>
									<td width="50"><b>Percentage</b></td>
									<td align="center"><b>Color Description</b></td>
								</tr>
								<tr>
									<td align="left" bgcolor="#cc0033" width="50" height="15">&nbsp;</td>
									<td align="center" width="50"><?=round($graphobj->total_sameday,2)?></td>
									<td align="left">Sales on the same day from click</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#ffcc00" width="50" height="15">&nbsp;</td>
									<td align="center" width="50"><?=round($graphobj->total_15Day,2)?></td>
									<td align="left">Sales within 15 days from click</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#3300ff" width="50" height="15">&nbsp;</td>
									<td align="center" width="50"><?=round($graphobj->total_1Month,2)?></td>
									<td align="left">Sales within 1 Month from click</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#009900" width="50" height="15">&nbsp;</td>
									<td align="center" width="50"><?=round($graphobj->total_2Month,2)?></td>
									<td align="left">Sales within 2 months from click</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#00ccff" width="50" height="15">&nbsp;</td>
									<td align="center" width="50"><?=round($graphobj->total_After,2)?></td>
									<td align="left">Sales after 2 months from click</td>
								</tr>
								<tr>
									<td align="left" bgcolor="#C0C0C0" width="50" height="15">&nbsp;</td>
									<td align="center" width="50"><? if($total == 0) echo "100"; else echo "0";?></td>
									<td align="left">Affiliate has no Sale</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center">
							<img src="returndayanalysis.php?alt=0&day1=<?=$sameday?>&day15=<?=$within15?>&month1=<?=$withinOneMonth?>&month2=<?=$within2Month?>&total=<?=$total?>" alt="" border=0>
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