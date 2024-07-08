<?php



          /*************************************************getting no of affiliates***********************************/
           $MERCHANTID  = $_SESSION['MERCHANTID'];
           $sql         = " SELECT   ( a.affiliate_id ), a.affiliate_firstname, a.affiliate_lastname,c.joinpgm_status" ;
           $sql         = $sql." FROM partners_affiliate a, partners_joinpgm c";
           $sql         = $sql." WHERE c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id " ;
            if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret         =mysqli_query($con,$sql);
           $all         =mysqli_num_rows($ret) ; //all affilaites

           $sql         =" SELECT   ( a.affiliate_id ), a.affiliate_firstname, a.affiliate_lastname,c.joinpgm_status" ;
           $sql         =$sql." FROM partners_affiliate a, partners_joinpgm c";
           $sql         =$sql." WHERE joinpgm_status='waiting' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id " ;
            if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret         =mysqli_query($con,$sql);
           $waiting     =mysqli_num_rows($ret) ; //affilaites waiting for approval

           $sql         =" SELECT   ( a.affiliate_id ), a.affiliate_firstname, a.affiliate_lastname,c.joinpgm_status" ;
           $sql         =$sql." FROM partners_affiliate a, partners_joinpgm c";
           $sql         =$sql." WHERE joinpgm_status='approved' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id " ;
            if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret         =mysqli_query($con,$sql);
           $approved    =mysqli_num_rows($ret) ; //approved affilaites

           $sql         =" SELECT  ( a.affiliate_id ), a.affiliate_firstname, a.affiliate_lastname,c.joinpgm_status" ;
           $sql         =$sql." FROM partners_affiliate a, partners_joinpgm c";
           $sql         =$sql." WHERE joinpgm_status='suspend' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id " ;
            if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret         =mysqli_query($con,$sql);
           $suspend     =mysqli_num_rows($ret) ; //suspended affilaites

           $sql        =" SELECT  distinct( c.joinpgm_id) ,a.affiliate_id, a.affiliate_firstname, a.affiliate_lastname, c.joinpgm_status,c.joinpgm_programid" ;
           $sql        =$sql." FROM partners_affiliate a, partners_joinpgm c, partners_transaction e";
           $sql        =$sql." WHERE e.transaction_status =  'pending' and c.joinpgm_merchantid='$MERCHANTID' AND e.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_affiliateid = a.affiliate_id " ;
            if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret         =mysqli_query($con,$sql);
           $pending     =mysqli_num_rows($ret) ; //affilaites with pending transction
           /***********************************************************************************************************/
 ?>
 <br/>
<table border="0" cellspacing="1" width="95%" align="center">
  <tr>
    <td width="25%">
    <table width="100%" border="0" cellspacing="1" class="tablebdr">
         <tr>
        <td width="100%" colspan="3" align="center" height="19"  class="tdhead">
        <a href="index.php?Act=affiliates&amp;status=all&amp;affiliate=<?=$affiliatename?>"><?=$laff_AllAffiliates?>(<?="$all"?>)</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
		<img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif" />&nbsp; 
		<a href="index.php?Act=affiliates&amp;status=pending&amp;affiliate=<?=$affiliatename?>"><?=$laff_Pending?>(<?="$pending"?>)</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
		<img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif" />&nbsp; <a href="index.php?Act=affiliates&amp;status=approve&amp;affiliate=<?=$affiliatename?>"><?=$laff_Approved?>(<?="$approved"?>)</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
        <img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif" /> &nbsp;<a href="index.php?Act=affiliates&amp;status=waiting&amp;affiliate=<?=$affiliatename?>"><?=$laff_Waiting?>(<?="$waiting"?>)</a> </td>
        </tr>
         <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
        <img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif" /> &nbsp;<a href="index.php?Act=affiliates&amp;status=suspend&amp;affiliate=<?=$affiliatename?>"><?=$laff_Suspend?>(<?="$suspend"?>)</a> </td>
        </tr>

    </table>
    </td>
    <td width="75%">
    <table border="0" cellspacing="1" width="100%" class="tablebdr">
        <tr>
        <td width="100%" colspan="3" align="center" height="19" class="tdhead">
        <?=$laff_Help?>
        </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
		<img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif" /> - <?=$laff_Affiliatehaspendingtransactions?> </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
		<img alt="" border="0"  src="../images/approved.gif" height="<?=$icon_height?>" width="<?=$icon_width?>" /> - <?=$laff_Affiliateisapprovedtotakeyouradvertisinglinks?></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
		<img alt="" border="0"  src="../images/waiting.gif" height="<?=$icon_height?>" width="<?=$icon_width?>" /> - <?=$laff_Affiliateiswaitingforapprovaltogetyouradvertisinglinks ?></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
		<img alt="" border="0"  src="../images/suspend.gif" height="<?=$icon_height?>" width="<?=$icon_width?>" /> - <?=$laff_Affiliateisblocked?> </td>
        </tr>
      </table>
	  </td>
	  </tr>
</table>
