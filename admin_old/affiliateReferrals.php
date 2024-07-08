<?php
/**************************************************************************/
/*     AUTHOR         :  PHP Dev Team, iFactor Solutions, India           */
/*     PROGRAMMER     :  SMA                                              */
/*     SCRIPT NAME    :  affiliateReferrals.php                           */
/*     CREATED ON     :  20/AUG/2009                                      */
/*     LAST MODIFIED  :  20/AUG/2009                                      */
/*     										                              */
/*     DESCRIPTION 	  :  Affiliate Referrals 							  */
/**************************************************************************/


	if(empty($page)) $page	= $partners->getpage();		# getting page no
			
?>


	<br />
	<table width="100%" align="center">
		<tr>
			<td width="100%" align="center" class="tdhead"><b>Affiliate Refferals </b></td>
		<tr>
	</table>

<?				

	$sql = "SELECT DISTINCT(affiliate_parentid) FROM partners_affiliate WHERE affiliate_parentid != '0'" ;	
	
	$res_page 	 = mysqli_query($con,$sql);	# Added for paging
	$_SESSION['SESS_TOTALCOUNT'] = mysqli_num_rows($res_page);
	$sql		.= " LIMIT ".($page-1)*$lines.",".$lines;
	
	$res 		= mysqli_query($con,$sql);  
	if(mysqli_num_rows($res))
	{
?>
        <table border="0" cellpadding="1" cellspacing="1" width="90%" align="center"class="tablebdr">
            <tr>
                <td width="43%" class="tdhead" align="center"><b>Affiliate</b></td>
                <td width="34%" class="tdhead" align="center"><b>Join Date</b></td>
                <td width="23%" class="tdhead" align="center"><b>Referral Count</b></td>
                <td width="23%" class="tdhead" align="center">&nbsp;</td>
            </tr>		
<?php	
		$i = 0;
		while($row=mysqli_fetch_object($res))
		{
		
			$affiliateParentid	= $row->affiliate_parentid;
			$sqlAffiliate	= " SELECT * FROM partners_affiliate WHERE affiliate_id = '$affiliateParentid' " ;	
			$resAffiliate 	= mysqli_query($con,$sqlAffiliate);  
			$rowAffiliate 	= mysqli_fetch_object($resAffiliate);
			
			$affiliateId		= $rowAffiliate->affiliate_id ;
			$affiliateCompany	= $rowAffiliate->affiliate_company ;
			$joinDate			= $rowAffiliate->affiliate_date ;
			$affiliateStatus	= $rowAffiliate->affiliate_status ;
			
			$sqlReferral		= " SELECT count(affiliate_id) AS referralCount FROM partners_affiliate 
				WHERE affiliate_parentid = '$affiliateParentid'";
			$resReferral		= mysqli_query($con,$sqlReferral); 
			$rowReferral		= mysqli_fetch_object($resReferral);
			$referralCount		= $rowReferral->referralCount;
			
			if ($i%2==1) { $classid	= "grid2"; } else { $classid	= "grid1"; }

?>

            <tr  class="<?=$classid?>">
                <td width="43%" height="25" align="left" style="padding-left:5px;">
                	<a href="#" onclick="viewLink(<?=$affiliateId?>)"><?=$affiliateCompany?></a>
                </td>
                <td width="34%" height="25" align="center"><?=$joinDate?></td>
                <td width="23%" height="25" align="center" ><?=$referralCount?></td>
                <td width="23%" height="25" align="center" >
                	<a href="index.php?Act=referralDetails&affiliateParentid=<?=$affiliateParentid?>&company=<?=$affiliateCompany?>">Details</a>
                </td>
            </tr>
<?
			$i++;
		}
?>					     
            <tr>
                <td colspan="4" align="center" >
					<? include '../includes/paging.php';	?>	
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
	<script language= "javascript" type="text/javascript">
		function viewLink(affiliateid){
			url     = "viewprofile_affiliate.php?id="+affiliateid;
			nw      = open(url,'new','height=450,width=450,scrollbars=no');
			nw.focus();
		}
	</script>
