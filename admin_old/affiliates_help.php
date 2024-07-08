<?php

	# getting total affiliates,waiting,approved,pending affiliates
	$sql        ="SELECT * from partners_affiliate";
	if(!empty($affiliatename)){
		$affiliatename1		 =addslashes($affiliatename);
		$sql            .= " where CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
	}
	$ret=mysqli_query($con, $sql);
	$all=mysqli_num_rows($ret) ; //all
	
	$sql        ="SELECT * from partners_affiliate where affiliate_status like ('waiting')";
	if(!empty($affiliatename)){
		$affiliatename1		 =addslashes($affiliatename);
		$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
	}
	$ret=mysqli_query($con, $sql);
	$waiting=mysqli_num_rows($ret) ; //waiting
	
	$sql        ="SELECT * from partners_affiliate where affiliate_status like ('approved')";
	if(!empty($affiliatename)){
		$affiliatename1		 =addslashes($affiliatename);
		$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
	}
	$ret=mysqli_query($con, $sql);
	$approved=mysqli_num_rows($ret) ;  //approved
	
	$sql        ="SELECT * from partners_affiliate where affiliate_status like ('suspend')";
	if(!empty($affiliatename)){
		$affiliatename1		 =addslashes($affiliatename);
		$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
	}
	$ret=mysqli_query($con, $sql);
	$suspend=mysqli_num_rows($ret) ;  //suspend
	
	$sql=" SELECT  DISTINCT ( a.affiliate_id ), a.affiliate_firstname, a.affiliate_lastname, a.affiliate_status,a.affiliate_date " ;
	$sql=$sql." FROM partners_affiliate a, partners_joinpgm c, partners_transaction d";
	$sql=$sql." WHERE d.transaction_status =  'pending' AND d.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_affiliateid = a.affiliate_id " ;
	if(!empty($affiliatename)){
		$affiliatename1		 =addslashes($affiliatename);
		$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
	}
	$ret=mysqli_query($con, $sql);
	$pending=mysqli_num_rows($ret) ;  //pending

 ?>
<?php /*?>
<table border='0' cellspacing="1" width="95%">
  <tr>
    <td width="25%">
    <!-- displaying no of affiliates depending on status-->

    <table width="100%" border='0' cellspacing="1" class="tablebdr">
         <tr>
        <td width="100%" colspan="3" align="center" height="19"  class="tdhead">
        <a href="index.php?Act=affiliates&amp;status=all&amp;affiliate=<?=$affiliatename?>" >All Affiliates(<?="$all"?>)</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28" align="left"><img
            alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif"
            />&nbsp; <a href="index.php?Act=affiliates&amp;status=pending&amp;affiliate=<?=$affiliatename?>">Pending(<?="$pending"?>)</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28" align="left"><img
            alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
            />&nbsp; <a href="index.php?Act=affiliates&amp;status=approve&amp;affiliate=<?=$affiliatename?>">Approved(<?="$approved"?>)</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28" align="left">
        <img
            alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
            /> &nbsp;<a href="index.php?Act=affiliates&amp;status=waiting&amp;affiliate=<?=$affiliatename?>">Waiting(<?="$waiting"?>)</a> </td>
        </tr>
         <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28" align="left">
        <img
            alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
            /> &nbsp;<a href="index.php?Act=affiliates&amp;status=suspend&amp;affiliate=<?=$affiliatename?>">Suspend(<?="$suspend"?>)</a> </td>
        </tr>
    </table>

    <!-- end ++++++++++++++++++++++++++++-->
    </td>
    <td width="75%">

    <!-- help+++++++++++++++++++++++++++++-->
    <table border='0' cellspacing="1" width="100%" class="tablebdr">
        <tr>
        <td width="100%" colspan="3" align="center" height="19" class="tdhead">
        Help
        </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28" align="left"><img
            alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif"
            /> - Affiliate has pending transactions </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28" align="left"><img
            alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
            /> - Affiliate is approved to take your advertising links</td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28" align="left"><img
            alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
            /> - Affiliate is waiting for approval to get your advertising links </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28" align="left"><img
            alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
            /> - Affiliate is blocked. Can't login </td>
        </tr>
      </table>
	  </td>
	  </tr>
  <!-- end +++++++++++++++++++++++++++++++++++++++-->
</table><?php */?>



<table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
       <tr>
        <td colspan="3" height="7"></td>
      </tr>

      <tr> 
	  	<td width="316" valign="top" style="border:#dddddd thin solid;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="33" colspan="2" class="heading-2">
			<a href="index.php?Act=affiliates&amp;status=all&amp;affiliate=<?=$affiliatename?>" class="adminLink">All Affiliates(<?="$all"?>)</a>
			</td>
        </tr> 
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="images/pending.jpg" width="24" height="24" /></td>
            <td align="left">
			<a href="index.php?Act=affiliates&amp;status=pending&amp;affiliate=<?=$affiliatename?>"class="link-01">Pending (<?="$pending"?>)</a>			</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="images/approved.jpg" width="24" height="24" /></td>
            <td align="left">
			<a href="index.php?Act=affiliates&amp;status=approve&amp;affiliate=<?=$affiliatename?>" class="link-01">Approved (<?="$approved"?>)</a>			</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="images/waiting.jpg" width="24" height="24" /></td>
            <td align="left">
			<a href="index.php?Act=affiliates&amp;status=waiting&amp;affiliate=<?=$affiliatename?>" class="link-01">Waiting (<?="$waiting"?>)</a>			</td>
          </tr>
          <tr>
            <td width="24%" height="30" align="center"><img src="images/block.jpg" width="24" height="24" /></td>
            <td width="76%" align="left">
			<a href="index.php?Act=affiliates&amp;status=suspend&amp;affiliate=<?=$affiliatename?>" class="link-01">Suspend (<?="$suspend"?>)</a>	 </td>
          </tr>
          
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
		</td>
        <td width="7">&nbsp;</td>
		
        <td width="556" valign="top" style="border:#dddddd thin solid;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" class="heading-3 heading-4">Help</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="images/pending.jpg" width="24" height="24" /></td>
            <td class="text-02">- Affiliate has pending transactions </td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="images/approved.jpg" width="24" height="24" /></td>
            <td class="text-02">- Affiliate is approved to take your advertising links </td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="images/waiting.jpg" width="24" height="24" /></td>
            <td class="text-02">- Affiliate is waiting for approval to get your advertising links </td>
          </tr>
          <tr>
            <td width="15%" height="30" align="center"><img src="images/block.jpg" width="24" height="24" /></td>
            <td width="85%" class="text-02">- Affiliate is blocked. Can't login </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3" height="7"></td>
      </tr>
    </table>