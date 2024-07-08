<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  graph_bubble.php                               */
/*     CREATED ON     :  06/JULY/2006                                    */

/*		File is used to get the values based on which the   bubble chart                                                 
 		is to be created and calls the page that creates the graph		*/
/************************************************************************/

	$MERCHANTID     = $_SESSION['MERCHANTID'];    //merchantid
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
	$result 	= $graphobj->GetAllPrograms($mid);

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
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="80%">
		<tr>
			<td colspan="2" align="center" width="100%">
				<table border="0"  cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td align="center" class="tdhead" colspan="2" height="25" width="95%" ><?=$lang_bubblePlot?></td>
						<td align="right" class="tdhead" width="5%" >
							<a href="#" onClick="popWin('../help_bubblePlot.php?user=Merchant');"><img src="../images/help.jpg" border="0"  >&nbsp;<?=$laff_Help?></a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" width="50%">
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
			<td width="50%" align="center" valign="top">
				<table align="center" cellpadding="0" cellspacing="0" width="100%" >
		
					<tr>
						<td width="50%" align="right" height="25"  ><b><?=$lhome_Programs?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td width="50%" align="left" height="25"  >
							<select name="programs" onchange="document.Distribution.submit()">
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
						<!--
						<td width="50%" class="tdhead" align="center">
							<?=$lhome_Click?><input <? if($type=='click') echo "checked='checked'"; ?> type="radio" name="type" value="click" /><?=$lhome_Sale?><input <? if($type=='sale') echo "checked='checked'"; ?> type="radio" name="type" value="sale" />
						</td>  -->
					</tr>
					<tr>
						<td align="right" height="25" ><b><?=$lnewgrp_Action?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td align="left" height="25" >
							<select name="type" onchange="document.Distribution.submit()">
								<option <? if($type == 'click') echo "selected='selected'"; ?>  value="click" ><?=$lhome_Click?></option>
								<option <? if($type == 'sale') echo "selected='selected'"; ?>  value="sale" ><?=$lhome_Sale?></option>
							</select>
						</td>
					</tr>
					
				</table>
			</td>
		</tr>
	</table>
	<br />
		
	<table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="95%">
<?php		
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
		$xAxis	= $type.$bubble_x_axis_legend;
		
		if($graphobj->rowcount > 0) { ?>
		<tr>
			<td colspan="2">
				<table  cellpadding="0" cellspacing="5" align="left">
					<tr>
						<td><b><?=$bubble_graph_description?></b></td>
					</tr>
					<tr>
						<td><img src="../images/help.jpg" alt="0" border="0" />&nbsp;&nbsp;<?=$bubble_xaxis_desc?></td>
					</tr>
					<tr>
						<td><img src="../images/help.jpg" alt="0" border="0" />&nbsp;&nbsp;<?=$bubble_yaxis_desc?></td>
					</tr>
					<tr>
						<td><img src="../images/help.jpg" alt="0" border="0" />&nbsp;&nbsp;<?=$bubble_zaxis_desc?></td>
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
			<tr><td colspan="2"  class="textred" align="center"><?=$err_no_affiliates?></td></tr>
		<? } ?>
		<tr><td>&nbsp;</td></tr>
	</table>
</form>

<script language="javascript" type="text/javascript">
	function popWin(url)
	{
		nw = open(url,'new','height=400,width=400,scrollbars=yes');
		nw.focus();
	}
</script>			