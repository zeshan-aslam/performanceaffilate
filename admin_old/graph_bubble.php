<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  graph_bubble.php                               */
/*     CREATED ON     :  08/JULY/2006                                    */

/*		File is used to get the values based on which the   bubble chart                                                 
 		is to be created and calls the page that creates the graph		*/
/************************************************************************/

	$MERCHANTID     = intval(trim($_REQUEST['merchants']));    //merchantid
	$programId		= intval(trim($_REQUEST['programs']));
	$type 	= $_REQUEST['type'];
	if($type == "")
		$type = 'click';
	
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
<script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.Distribution.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.Distribution.txtto,Date);
        }
</script>

<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<form name="Distribution" method="post" action="">
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="60%">
		<tr>
			<td colspan="2" align="center" width="100%">
				<table border="0"  cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td align="center" class="tdhead" colspan="2" height="25" width="95%" ><b>Bubble Plot</b></td>
						<td align="right" class="tdhead" width="5%" >
							<a href="#" onClick="popWin('../help_bubblePlot.php?user=Admin');"><img src="../images/help.jpg" border="0"  >&nbsp;Help&nbsp;</a>						</td>
					</tr>
				</table>			</td>
		</tr>
		
		<tr>
			<td align="center" width="50%">
				<table align="center" cellpadding="0" cellspacing="0" width="100%" >
					<tr>
						<td  height="30" colspan="2"  align="center" ><b>
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
				</table>			</td>
			<td width="50%" align="center" valign="top">
				<table align="center" cellpadding="0" cellspacing="0" width="100%" >
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr valign="top">
						<td width="50%" align="right" height="25" ><b>Merchant</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
							</select>						</td>
					</tr>
					<tr>
						<td align="right" height="25" ><b>Action</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td align="left" height="25" >
							<select name="type" onchange="document.Distribution.submit()">
								<option <? if($type == 'click') echo "selected='selected'"; ?>  value="click" >Click</option>
								<option <? if($type == 'sale') echo "selected='selected'"; ?>  value="sale" >Sale</option>
							</select>						</td>
					</tr>
					<tr>
					<?
					if($MERCHANTID != "")
					{
						$result_prg 	= $graphobj->GetAllPrograms($MERCHANTID);
					?>
						<td width="50%" align="right" height="25"  ><b>Programs</b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td width="50%" align="left" height="25"  >
							<select name="programs" onchange="document.Distribution.submit()">
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
							</select>						</td>
					<?
					}
					?>
					</tr>
				</table>			</td>			
		</tr>
		<tr>
			<td align="center" colspan="2" height="25" width="95%" >
			<input name="currValue" type="hidden" value="<?=$currValue?>" />
			<input type="submit" name="sub" value="View"  /></td>
	  </tr>
	</table>
	<br />
<?	
if($MERCHANTID != "")
{
?>
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="95%">
<?
	$graphobj->GetBubbleReport($MERCHANTID,$programId,$fromDate,$toDate,$type);
	$affiliate_count 	= $graphobj->rowcount; 
	$maxClick			= $graphobj->total;
	$maxValue			= $graphobj->maxcomm;   
	
		for($i=0; $i<count($graphobj->affId); $i++)
		{
			$affiliateClick 	= $graphobj->affClick[$i];
			$affiliateCompany 	= $graphobj->affCompany[$i];
			$affiliateComision 	= $graphobj->affCommn[$i];
			
			if($maxClick > 0)
				$affiliateClick 	= round(($affiliateClick * 100) / $maxClick ,2);
			else
				$affiliateClick 	= 0;
				
			if($maxValue > 0)
				$affiliateComision 	= round(($affiliateComision * 100) / $maxValue ,2);
			else
				$affiliateComision 	= 0;
				
			$clicks .= $affiliateClick.",";
			$comms 	.= $affiliateComision.",";
			$name	.= $affiliateCompany.",";
		}
		
		$clicks 	= trim($clicks,",");
		$affiliateCompany 	= trim($affiliateCompany,",");
		$comms 	= trim($comms,","); 
		$xAxis	= $type." made by the Affiliates for the selected Program";
		
		if($graphobj->rowcount > 0) { ?>
		<tr>
			<td colspan="2">
				<table  cellpadding="0" cellspacing="5" align="left">
					<tr>
						<td align="left"><b><?=$bubble_graph_description?></b></td>
					</tr>
					<tr>
						<td align="left"><img src="../images/help.jpg" alt="0" border="0" />&nbsp;&nbsp;The clicks or sales made by the Affiliate is represented along the X-axis</td>
					</tr>
					<tr>
						<td align="left"><img src="../images/help.jpg" alt="0" border="0" />&nbsp;&nbsp;The Affiliates joined for the selected Program is represented along the Y-axis</td>
					</tr>
					<tr>
						<td align="left"><img src="../images/help.jpg" alt="0" border="0" />&nbsp;&nbsp;The commission earned by the Affiliate is represented by the diameter of the bubble</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<img src="bubble_plot.php?rows=<?=$affiliate_count?>&maxComm=<?=$maxValue?>&click=<?=$clicks?>&comm=<?=$comms?>&name=<?=$name?>&type=<?=$xAxis?>" alt="0" border="0" />
			</td>		
		</tr>
		<? } else { ?>
			<tr><td colspan="2"  class="textred" align="center">Sorry! Merchant has no Affiliates for the selected program</td></tr>
		<? } ?>
		<tr><td>&nbsp;</td></tr>
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