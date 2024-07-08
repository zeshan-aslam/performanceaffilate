<?php
/**************************************************************************/
/*     AUTHOR         :  PHP Dev Team, iFactor Solutions, India           */
/*     PROGRAMMER     :  SMA                                              */
/*     SCRIPT NAME    :  referralDetails.php                              */
/*     CREATED ON     :  20/AUG/2009                                      */
/*     LAST MODIFIED  :  20/AUG/2009                                      */
/*     										                              */
/*     DESCRIPTION 	  :  Affiliate Referrals Detailed Report			  */
/**************************************************************************/

	if(empty($page)) $page	= $partners->getpage();	   # getting page no
	
	$affiliateParentid	= intval(trim($_REQUEST['affiliateParentid']));  
	$sql_aff = "SELECT affiliate_company FROM partners_affiliate WHERE affiliate_id='$affiliateParentid' ";
	$res_aff = mysql_query($sql_aff);
	if(mysql_num_rows($res_aff) > 0)
	{
		list($company) = mysql_fetch_row($res_aff);
	}
	?>
	<br />
	
	<table width="100%" align="center">
		<tr>
			<td width="100%" align="center" class="tdhead"><b>Affiliates Reffered By <?=$company?></b></td>
		<tr>
	</table>

	<?				

	$sql	= " SELECT affiliate_id FROM partners_affiliate WHERE affiliate_parentid = '$affiliateParentid' " ;	
	$res_page 	 = mysql_query($sql);	# Added for paging
	$_SESSION['SESS_TOTALCOUNT'] = mysql_num_rows($res_page);
	$sql		.=" LIMIT ".($page-1)*$lines.",".$lines;
	
	$res 		= mysql_query($sql);  
	if(mysql_num_rows($res)){
	?>
        <table border="0" cellpadding="1" cellspacing="1" width="70%" align="center"class="tablebdr">
            <tr>
            <td width="43%" class="tdhead" align="center"><b>Affiliate</b></td>
            <td width="34%" class="tdhead" align="center"><b>Join Date</b></td>
            </tr>		
	<?				
    
		$i = 0;
		while($row=mysql_fetch_object($res)){
		
			$affiliate_id	= $row->affiliate_id;
			$sqlAffiliate	= "SELECT * FROM partners_affiliate WHERE affiliate_id = '$affiliate_id' " ;	
			$resAffiliate 	= mysql_query($sqlAffiliate);  
			$rowAffiliate 	= mysql_fetch_object($resAffiliate);
			if ($i%2==1) { $classid	= "grid2"; } else { $classid	= "grid1"; }
?>
            <tr  class="<?=$classid?>">
                <td width="43%" height="25" align="left" style="padding-left:5px;">
                <a href="#" onclick="viewLink(<?=$rowAffiliate->affiliate_id?>)"><?=$rowAffiliate->affiliate_company?></a></td>
                <td width="34%" height="25" align="center"><?=$rowAffiliate->affiliate_date?></td>
            </tr>
<?
			$i++;
		}
?>					     
        <tr>
            <td colspan="2" align="center" >
            	<? include '../includes/paging.php';  ?>	
            </td>
        </tr>
    </table>
    <?
	}
	else{
?>
		<table width="100%" align="center">
			<tr>
				<td align="center" class="textred">No Records Found</td>
			<tr>
		</table>
<?
	}
?>   

	<table width="100%" align="center">
		<tr>
			<td width="10%" align="center" >
				<input type="button" name="back" value="Back" class="button" onclick="javascript:history.go(-1)" />
			</td>
		<tr>
	</table>

<script language= "javascript" type="text/javascript">
	function viewLink(affiliateid){
		url     = "viewprofile_affiliate.php?id="+affiliateid;
		nw      = open(url,'new','height=450,width=450,scrollbars=no');
		nw.focus();
	}
</script>

 