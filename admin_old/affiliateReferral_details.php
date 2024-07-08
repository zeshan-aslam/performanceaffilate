<?php
/**************************************************************************/
/*     AUTHOR         :  PHP Dev Team, iFactor Solutions, India           */
/*     PROGRAMMER     :  SMA                                              */
/*     SCRIPT NAME    :  affiliateReferral_details.php                    */
/*     CREATED ON     :  19/AUG/2009                                      */
/*     LAST MODIFIED  :  19/AUG/2009                                      */
/*     										                              */
/*     DESCRIPTION 	  :  Detailed Referral Report fro an Affiiate 		  */
/**************************************************************************/

	$affiliate	= intval($_REQUEST['affiliate']);
	$From 		= trim($_REQUEST['From']);      
	$To 		= trim($_REQUEST['To']);  

   /******** validation***************************************************/
	if(!$partners->is_date_Mysql($From) || !$partners->is_date_Mysql($To) || empty($affiliate))
	{ 
		$msg 	= "Invalid Request";
?>
        <table width="85%"  align="center" >
             <tr>
                <td  height="40" colspan="2" class="error" align="center" valign="middle"> <?=$msg?></td>
             </tr>
        </table>
<?php 
	}
	else
	{ 
		$sql_referal = "SELECT COUNT(subsale_id) AS Cnt, SUM(subsale_amount) AS Sum, affiliate_company, affiliate_id 
				FROM partners_transaction_subsale, partners_affiliate 
				WHERE subsale_affiliateid='$affiliate' AND subsale_date >= '$From' AND subsale_date <= '$To' 
				AND affiliate_id = subsale_childaffiliateid 
				GROUP BY subsale_childaffiliateid ";  
		$res_referal = mysql_query($sql_referal);  
		$rows_referal = mysql_num_rows($res_referal);
	
		if($rows_referal)
		{ 
			$sql_aff = "SELECT affiliate_company FROM partners_affiliate WHERE affiliate_id='$affiliate' ";
			$res_aff = mysql_query($sql_aff);
			if(mysql_num_rows($res_aff) > 0)
			{
				list($affiliateName) = mysql_fetch_row($res_aff);
			}
		?>  
		
			<script language="javascript" type="text/javascript">
				function help(pageurl){
					nw 	= open(pageurl,'new','height=450,width=450,scrollbars=yes');
				}
			</SCRIPT>
		
			<p align="center"><b>Referral Commission Report for Affiliate <?=$affiliateName?> from <?=$From?> to <?=$To?></b></p>
			<table border="0"  cellpadding="0" cellspacing="0" width="75%" class="tablebdr" align="center">
				<tr >
					<td width="45%"  class="tdhead">&nbsp;<b>Affiliates</b></td>
					<td width="18%"  class="tdhead"><b>Referral Sales</b></td>
					<td width="22%"  class="tdhead"><b>Commission Earned</b></td>
				</tr>
				<?php
				$total = 0;
				while($row_referal = mysql_fetch_object($res_referal)){
					$total += $row_referal->Sum;
				?>
				<tr >
					<td height="25" >&nbsp;
						<a href="#" onClick="javascript: help('viewprofile_affiliate.php?id=<?=$row_referal->affiliate_id?>');" >
							<?=$row_referal->affiliate_company?>
						</a>
					</td>
					<td height="25" ><?=$row_referal->Cnt?></td>
					<td height="25" >$<?=$row_referal->Sum?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="2" align="left"  class="tdhead" >&nbsp;<b>Total Commission</b></td>
					<td colspan="2" align="left"  class="tdhead" ><b>$<?=$total?></b></td>
				</tr>
			</table>
		  
		<?php
		} else { ?>
			<table width="85%"  align="center" >
				 <tr>
					<td  height="40" colspan="2" class="error" align="center" valign="middle">No Records Found</td>
				 </tr>
			</table>
		<?php } 	
}
?>   
<br/>
<p align="center"><input type="button" name="Back" value="Back" onclick="javascript: history.go(-1);"  /></p>
<br/>
 