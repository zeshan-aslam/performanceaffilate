<?php

	# search merchant according to status
	$sql		= " SELECT * from partners_merchant ";
	if(!empty($merchantname)){
		$merchantname1		 =addslashes($merchantname);
		$sql            .= " where CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') ";
	}
	$ret=mysqli_query($con, $sql);
	$all=mysqli_num_rows($ret) ;      //all merchants
	
	$sql        ="SELECT * from partners_merchant where merchant_status like ('waiting') ";
	if(!empty($merchantname)){
	$merchantname1		 =addslashes($merchantname);
	$sql            .= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') ";
	}
	$ret = mysqli_query($con, $sql);
	$waiting = mysqli_num_rows($ret) ;
	
	$sql        ="SELECT * from partners_merchant where merchant_status like ('NP') ";
	if(!empty($merchantname)){
	$merchantname1		 =addslashes($merchantname);
	$sql            .= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') ";
	}
	
	$ret=mysqli_query($con, $sql);
	$NP=mysqli_num_rows($ret) ;  //waiting merchants
	
	$sql        ="SELECT * from partners_merchant where merchant_status like ('approved') ";
	if(!empty($merchantname)){
	$merchantname1		 =addslashes($merchantname);
	$sql            .= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') ";
	}
	$ret=mysqli_query($con, $sql);
	$approved=mysqli_num_rows($ret) ; //approved merchants
	
           $sql        ="SELECT * from partners_merchant where merchant_status like ('empty') ";
            if(!empty($merchantname)){
    			$merchantname1		 =addslashes($merchantname);
    			$sql            .= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') ";
            }
           $ret=mysqli_query($con, $sql);
           $moneyempty=mysqli_num_rows($ret) ; //money empty merchants

           $sql        ="SELECT * from partners_merchant where merchant_status like ('suspend') ";
            if(!empty($merchantname)){
    			$merchantname1		 =addslashes($merchantname);
    			$sql            .= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') ";
            }
           $ret=mysqli_query($con, $sql);
           $suspend=mysqli_num_rows($ret) ;    //suspended merchants

           $sql=" SELECT  DISTINCT ( a.merchant_id ), a.merchant_firstname, a.merchant_lastname, a.merchant_status, a.merchant_date " ;
           $sql=$sql." FROM partners_merchant a, partners_joinpgm c, partners_transaction d";
           $sql=$sql." WHERE d.transaction_status =  'pending' AND d.transaction_joinpgmid = c.joinpgm_id AND  c.joinpgm_merchantid = a.merchant_id " ;
            if(!empty($merchantname)){
    			$merchantname1		 =addslashes($merchantname);
    			$sql            .= " and CONCAT(merchant_firstname,' ',merchant_lastname) like('%$merchantname1%') ";
            }
           $ret=mysqli_query($con, $sql);
           $pending=mysqli_num_rows($ret) ;    ////all merchants with pending transactions

 ?>
 <?php /*?><table border='1' cellspacing="1" width="95%" >
  <tr>
    <td width="25%">
    <table width="100%" border='0' cellspacing="1" class="tablebdr">
        <tr>
			<td colspan="3" align="center" height="33"  class="heading-2">
			<a href="index.php?Act=merchants&status=all&merchant=<?=$merchantname?>">All Merchants(<?="$all"?>)</a></td>
        </tr>
        <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="96%" height="28" align="left">
			<img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif" />&nbsp;
			<a href="index.php?Act=merchants&status=pending&merchant=<?=$merchantname?>">Pending(<?=$pending?>)</a></td>
        </tr>
        <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="96%" height="28" align="left"><img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif" />&nbsp;
			<a href="index.php?Act=merchants&status=approved&merchant=<?=$merchantname?>">Approved(<?="$approved"?>)</a></td>
        </tr>
        <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="96%" height="28" align="left"><img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/NP.gif" />&nbsp;
			<a href="index.php?Act=merchants&status=notpaid&merchant=<?=$merchantname?>">Not Paid(<?="$NP"?>)</a></td>
        </tr>
        <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="96%" height="28" align="left">
			<img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif" />&nbsp; 
			<a href="index.php?Act=merchants&status=waiting&merchant=<?=$merchantname?>">Waiting(<?="$waiting"?>)</a> </td>
        </tr>
		<tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="96%" height="28" align="left"><img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/empty.gif" />&nbsp; 
				<a href="index.php?Act=merchants&status=empty&merchant=<?=$merchantname?>">Money Empty(<?="$moneyempty"?>)</a> </td>
        </tr>
       <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="96%" height="28" align="left"><img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
				/>&nbsp; <a href="index.php?Act=merchants&status=suspend&merchant=<?=$merchantname?>">Suspend(<?="$suspend"?>)</a> </td>
      </tr>
    </table>
    <!-- =================================================================== -->
    </td>
    <td width="75%">
    <!--  ==============================help+++++++++++++++++++++++++++++++++++++ -->
    <table border='0' cellspacing="1" width="100%" class="tablebdr">
      	<tr>
       	 	<td width="100%" colspan="3" align="center" height="19" class="tdhead"> Help </td>
        </tr>
        <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="96%" height="28" align="left"><img 
				alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif"
				/> - Merchant has pending transactions </td>
        </tr>
        <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="96%" height="28" align="left"><img 
				alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
				/> -  Merchant is approved to publish advertising links </td>
        </tr>
		<tr>
			 <td width="4%" height="28">&nbsp;</td>
			 <td width="96%" height="28" align="left"><img 
				alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/NP.gif"
				/> -  Merchant has registered, but doesn't complete the payment process </td>
        </tr>
        <tr>
        	<td width="4%" height="28">&nbsp;</td>
			<td width="100%" height="28" align="left"><img 
				alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
				/> - Merchant is waiting for approval to publish advertising links</td>
        </tr>
        <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="100%" height="28" align="left"><img 
				alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/empty.gif"
				/> - Merchant has no money in his account</td>
        </tr>
        <tr>
			<td width="4%" height="28">&nbsp;</td>
			<td width="100%" height="28" align="left"><img 
				alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
				/> - Merchant is blocked. Can't login </td>
        </tr>
     </table>
	 </td>
	 </tr>
 </table><?php */?>
 <table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
       <tr>
        <td colspan="3" height="7"></td>
      </tr>

      <tr> 
	  	<td width="316" valign="top" style="border:#dddddd thin solid;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td height="33" colspan="2" class="heading-2"><a href="index.php?Act=merchants&status=all&merchant=<?=$merchantname?>"  class="adminLink">All Merchants (<?="$all"?>)</a></td>
        </tr> 
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/pending.gif" width="24" height="24" /></td>
            <td align="left">
			<a href="index.php?Act=merchants&status=pending&merchant=<?=$merchantname?>" class="link-01">Pending (<?=$pending?>)</a>			</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/approved.gif" width="24" height="24" /></td>
            <td align="left">
			<a href="index.php?Act=merchants&status=approved&merchant=<?=$merchantname?>" class="link-01">Approved (<?="$approved"?>)</a> </td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/NP.gif" width="24" height="24" /></td>
            <td align="left">
			<a href="index.php?Act=merchants&status=notpaid&merchant=<?=$merchantname?>" class="link-01">Not Paid (<?="$NP"?>)</a>			</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/waiting.gif" width="24" height="24" /></td>
            <td align="left">
			<a href="index.php?Act=merchants&status=waiting&merchant=<?=$merchantname?>" class="link-01">Waiting (<?="$waiting"?>)</a>			</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/empty.gif" width="24" height="24" /></td>
            <td align="left">
			<a href="index.php?Act=merchants&status=empty&merchant=<?=$merchantname?>" class="link-01">Money Empty (<?="$moneyempty"?>)</a> </td>
          </tr>
          <tr>
            <td width="24%" height="30" align="center"><img src="../images/suspend.gif" width="24" height="24" /></td>
            <td width="76%" align="left">
			<a href="index.php?Act=merchants&status=suspend&merchant=<?=$merchantname?>" class="link-01">Suspend (<?="$suspend"?>)</a> </td>
          </tr>
          
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table></td>
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
            <td height="30" align="center"><img src="../images/pending.gif" width="24" height="24" /></td>
            <td class="text-02">- Merchant has pending transactions </td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/approved.gif" width="24" height="24" /></td>
            <td class="text-02">- Merchant is approved to publish advertising links </td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/NP.gif" width="24" height="24" /></td>
            <td class="text-02">- Merchant has registered, but doesn't complete the payment process </td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/waiting.gif" width="24" height="24" /></td>
            <td class="text-02">- Merchant is waiting for approval to publish advertising links</td>
          </tr>
          <tr>
            <td height="30" align="center"><img src="../images/empty.gif" width="24" height="24" /></td>
            <td class="text-02">- Merchant has no money in his account</td>
          </tr>
          <tr>
            <td width="15%" height="30" align="center"><img src="../images/suspend.gif" width="24" height="24" /></td>
            <td width="85%" class="text-02">- Merchant is blocked. Can't login </td>
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