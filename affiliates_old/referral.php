<?php
/**************************************************************************/
/*     AUTHOR         :  PHP Dev Team, iFactor Solutions, India           */
/*     PROGRAMMER     :  SMA                                              */
/*     SCRIPT NAME    :  referral.php                                     */
/*     CREATED ON     :  19/AUG/2009                                      */
/*     LAST MODIFIED  :  19/AUG/2009                                      */
/*     										                              */
/*     DESCRIPTION 	  :  Referral Report								  */
/**************************************************************************/


	$AFFILIATEID 	= $_SESSION['AFFILIATEID'];    
	$msg 			= "";
	
	if($_POST) {
		$txtfrom 	= trim($_POST['txtfrom']);      
		$txtto 		= trim($_POST['txtto']);  

	   /********date validation***************************************************/
		if(!$partners->is_date($txtfrom) || !$partners->is_date($txtto) )
		{
			$msg 	= $lang_report_err;
		}
		else
		{
			$From 	= $partners->date2mysql($txtfrom);  
			$To 	= $partners->date2mysql($txtto);
			
		}
	}
	else
	{
		$txtfrom 	= date("d/m/Y");      
		$txtto 		= date("d/m/Y");
		
		$From 	= $partners->date2mysql($txtfrom);  
		$To 	= $partners->date2mysql($txtto);
	}
	#echo "from = ".$From."  to = ".$To ;

	$heading = $txtfrom. " - ".$txtto;
	if(empty($msg))
	{
		$sql_referal = "SELECT COUNT(subsale_id) AS Cnt, SUM(subsale_amount) AS Sum, affiliate_company, affiliate_id 
				FROM partners_transaction_subsale, partners_affiliate 
				WHERE subsale_affiliateid='$AFFILIATEID' AND subsale_date BETWEEN '$From' AND '$To' 
				AND affiliate_id = subsale_childaffiliateid 
				GROUP BY subsale_childaffiliateid ";
		$res_referal = mysqli_query($con,$sql_referal);  
		$rows_referal = mysqli_num_rows($res_referal);
	}
?>

	<script language="javascript" type="text/javascript">
		function from_date(){
			gfPop.fStartPop(document.trans.txtfrom,Date);
		}
		function to_date(){
			gfPop.fStartPop(document.trans.txtto,Date);
		}

		function help(pageurl){
			nw 	= open(pageurl,'new','height=450,width=450,scrollbars=yes');
		}
	</SCRIPT>

<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<br/>
    <form name="trans" method="post" action="" >
    <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2" align="center" >&nbsp;&nbsp;<b> <?=$lang_referral_report?> </b></td>
         </tr>
         <tr>
            <td  height="19" colspan="2" class="error" align="center"> <?=$msg?></td>
         </tr>
         <tr>
            <td  height="19" colspan="2" >&nbsp;&nbsp;&nbsp;&nbsp;<b><?=$lang_report_forperiod?></b></td>
         </tr>
         <tr>
            <td width="49%" height="24" align="center">&nbsp; <?=$lang_report_from?></td>
            <td width="51%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" readonly />
            </td>
        </tr>
        <tr>
            <td width="49%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
            <td width="51%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$txtto?>"  onfocus="javascript:to_date();return false;" readonly  />
            </td>
        </tr>
        <tr>
            <td width="49%" height="23">&nbsp;</td>
        </tr>
       <tr>
           <td colspan="6" align="center" height="26">
           <input type="submit" name="sub"  value="<?=$lang_report_view?>" /></td>
      </tr>
  </table>
  </form>
  
<?php
if($rows_referal)
{ 
?>  
 <p align="right">
	<a href="#" onClick="window.open('../print_referral.php?aid=<?=$AFFILIATEID?>&mode=affiliate&heading=<?=$heading?>&txtfrom=<?=$txtfrom?>&txtto=<?=$txtto?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_referral.php?aid=<?=$AFFILIATEID?>&mode=affiliate&heading=<?=$heading?>&txtfrom=<?=$txtfrom?>&txtto=<?=$txtto?>"><b><?=$lang_export_csv_head?></b></a> 	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
  	<table border="0"  cellpadding="0" cellspacing="0" width="75%" class="tablebdr" align="center">
        <tr >
            <td width="40%"  class="tdhead">&nbsp;<b><?=$lang_referral_downlines?></b></td>
            <td width="30%"  class="tdhead"><b><?=$lang_referral_salesMade?></b></td>
            <td width="30%"  class="tdhead"><b><?=$lang_home_commission?></b></td>
        </tr>
        <?php
		$total = 0;
		while($row_referal = mysqli_fetch_object($res_referal)){
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
        	<td colspan="2" align="left"  class="tdhead" >&nbsp;<b><?=$lang_total_commission?></b></td>
            <td colspan="2" align="left"  class="tdhead" ><b>$<?=$total?></b></td>
        </tr>
    </table>
  
<?php
} else { ?>
    <table width="85%"  align="center" >
         <tr>
            <td  height="40" colspan="2" class="error" align="center" valign="middle"> <?=$lang_report_no_rec?></td>
         </tr>
   	</table>
<?php } ?>   
<br/>
<br/>
 