<?php
         /***************************************************************************************************
                    PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES -HELP
                     VARIABLES          : all               =TOTAL NO OF AFFILIATES
 							 			  waiting			=waiting  AFFILIATES
                                          approved			=approved  AFFILIATES
                                          suspend   		=suspended  AFFILIATES
                                          pending			=AFFILIATES with pending transcation
         //*************************************************************************************************/



        /*********************getting total affiliates,waiting,approved,pending affiliates**********************/

           $sql        ="SELECT * from partners_affiliate";
           if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " where CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret=mysqli_query($con,$sql);
           $all=mysqli_num_rows($ret) ; //all

           $sql        ="SELECT * from partners_affiliate where affiliate_status like ('waiting')";
           if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret=mysqli_query($con,$sql);
           $waiting=mysqli_num_rows($ret) ; //waiting

           $sql        ="SELECT * from partners_affiliate where affiliate_status like ('approved')";
           if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret=mysqli_query($con,$sql);
           $approved=mysqli_num_rows($ret) ;  //approved

           $sql        ="SELECT * from partners_affiliate where affiliate_status like ('suspend')";
           if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
            }
           $ret=mysqli_query($con,$sql);
           $suspend=mysqli_num_rows($ret) ;  //suspend

           $sql=" SELECT  DISTINCT ( a.affiliate_id ), a.affiliate_firstname, a.affiliate_lastname, a.affiliate_status,a.affiliate_date " ;
           $sql=$sql." FROM partners_affiliate a, partners_joinpgm c, partners_transaction d";
           $sql=$sql." WHERE d.transaction_status =  'pending' AND d.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_affiliateid = a.affiliate_id " ;
           if(!empty($affiliatename)){
    			$affiliatename1		 =addslashes($affiliatename);
    			$sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliatename1%') ";
           }
           $ret=mysqli_query($con,$sql);
           $pending=mysqli_num_rows($ret) ;  //pending

     /***********************************************************************************************************/
 ?>
 <br/>
<table border="0" cellspacing="1" width="95%">
  <tr>
    <td width="25%">
    <!-- displaying no of affiliates depending on status-->

    <table width="100%" border="0" cellspacing="1" class="tablebdr">
         <tr>
        <td width="100%" colspan="3" align="center" height="19"  class="tdhead">
        <a href="index.php?Act=affiliates&amp;status=all&affiliate=<?=$affiliatename?>">All Transactions(<?="$all"?>)</td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28"><IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/pending.gif"
            >&nbsp; <a href="index.php?Act=affiliates&amp;status=pending&affiliate=<?=$affiliatename?>">Pending(<?="$pending"?>)</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28"><IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
            >&nbsp; <a href="index.php?Act=affiliates&amp;status=approve&affiliate=<?=$affiliatename?>">Approved(<?="$approved"?>)</a></td>
        </tr>
          <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
        <IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
            > &nbsp;<a href="index.php?Act=affiliates&amp;status=suspend&affiliate=<?=$affiliatename?>">Click(<?="$suspend"?>)</a> </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
        <IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
            > &nbsp;<a href="index.php?Act=affiliates&amp;status=waiting&affiliate=<?=$affiliatename?>">Sale(<?="$waiting"?>)</a> </td>
        </tr>
         <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28">
        <IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
            > &nbsp;<a href="index.php?Act=affiliates&amp;status=suspend&affiliate=<?=$affiliatename?>">Lead(<?="$suspend"?>)</a> </td>
        </tr>

    </table>

    <!-- end --------------------------------------------------->
    </td>
    <td width="75%">

    <!-- help--------------------------------------------------->
    <table border="0" cellspacing="1" width="100%" class="tablebdr">
        <tr>
        <td width="100%" colspan="3" align="center" height="19" class="tdhead">
        Help
        </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28"><IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/click.gif"
            > - Affiliate has pending transactions </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28"><IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/sale.gif"
            > - Affiliate is approved to take your advertising links</td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28"><IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/lead.gif"
            > - Affiliate is waiting for approval to get your advertising links </td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="100%" height="28"><IMG
            alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
            > -Affiliate is blocked. Can't login </td>
        </tr>
      </table>
  <!-- end ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
</table>
</form>