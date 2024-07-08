<?php

	$MERCHANTID     = $_SESSION['MERCHANTID'];    //merchantid
	$affiliate		= intval(trim($_REQUEST['affiliates']));
	
	if(empty($affiliate))
		$affiliate		= "All";
	
	$graphobj 	= new graphs();
	$result 	= $graphobj->GetAffiliates($MERCHANTID);
	
?>
<br/>
<form name="ReturnDays" method="post" action="">
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="80%">
		<tr>
			<td colspan="2" align="center" width="100%">
				<table border="0"  cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td align="center" class="tdhead" colspan="2" height="25" width="95%" ><b><?=$lang_returnDayanalysis?></b></td>
						<td align="right" class="tdhead" width="5%" >
							<a href="#" onClick="popWin('../help_returnDays.php?user=Merchant');"><img src="../images/help.jpg" border="0"  >&nbsp;<?=$laff_Help?></a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" align="left" height="25" colspan="2" >&nbsp;&nbsp; <b><?=$laff_Affiliate?></b>
				<select name="affiliates" onchange="document.ReturnDays.submit()">
					<option value="All" ><?=$laff_AllAffiliates?></option>
				<?	
				if($result)
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
									<td><b><?=$lang_graph_color?></b></td>
									<td><b><?=$lang_graph_percent?></b></td>
									<td align="center"><b><?=$lang_graph_description?></b></td>
								</tr>
								<tr>
									<td align="left" bgcolor="#cc0033" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($graphobj->total_sameday,2)?></td>
									<td align="left"><?=$lang_saleonsameday?></td>
								</tr>
								<tr>
									<td align="left" bgcolor="#ffcc00" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($graphobj->total_15Day,2)?></td>
									<td align="left"><?=$lang_saleafter15days?></td>
								</tr>
								<tr>
									<td align="left" bgcolor="#3300ff" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($graphobj->total_1Month,2)?></td>
									<td align="left"><?=$lang_saleafter1month?></td>
								</tr>
								<tr>
									<td align="left" bgcolor="#009900" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($graphobj->total_2Month,2)?></td>
									<td align="left"><?=$lang_saleafter2months?></td>
								</tr>
								<tr>
									<td align="left" bgcolor="#00ccff" width="50" height="15">&nbsp;</td>
									<td align="center"><?=round($graphobj->total_After,2)?></td>
									<td align="left"><?=$lang_saleafter3months?></td>
								</tr>
								<tr>
									<td align="left" bgcolor="#C0C0C0" width="50" height="15">&nbsp;</td>
									<td align="center"><? if($total == 0) echo "100"; else echo "0";?></td>
									<td align="left"><?=$lang_nosales?></td>
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
</form>
<br />
<script language="javascript" type="text/javascript">

	function popWin(url)
	{
		nw = open(url,'new','height=400,width=400,scrollbars=yes');
		nw.focus();
	}


</script>						