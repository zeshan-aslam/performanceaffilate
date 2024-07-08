<?
//Last Modified By DPT on May/28/05 to fix issues with HTML
 $Err		=$_GET['Err'];
 $Action	=$_GET['Action'];

 if ($Action=="affiliate")
    $aff="selected = 'selected' ";
 else
     $mer="selected = 'selected' ";
?>
<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    
    <td height="100%" rowspan="2" align="left" valign="top">
	
	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td class="affiliates-reg-top"><div class="box-heading">&nbsp;&nbsp;&nbsp;<?=$lang_AffiliateRegistration?></div></td>
			</tr>
			<tr>
			<td class="affiliate-reg-content-bg">
			<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			<td align="center"><table width="100%" border="0">
			<tr>
			<td width="100%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
			<tr>
			<td height="2" colspan="2" >
			<? include_once "affil_regi.php"; ?></td>
			</tr>
			</table></td>
			<td width="3%">&nbsp;</td>
			</tr>
			</table></td>
			</tr>
			</table></td>
			</tr>
			<tr>
			<td><img src="images/affiliate-reg-bottom.jpg" width="661" height="13" /></td>
			</tr>
		</table>
	
   </td>
  </tr>
</table>