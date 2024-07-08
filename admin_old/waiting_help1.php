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

          //getting total no of waiting programs joined by affiliate
           $sql         =" SELECT   * " ;
           $sql         =$sql." FROM partners_program";
           $sql         =$sql." WHERE program_status='inactive' " ;
           $ret         =mysqli_query($con,$sql);
           $waiting     =mysqli_num_rows($ret) ;

           //getting total no of approved programs joined by affiliate
           $sql         =" SELECT   * " ;
           $sql         =$sql." FROM partners_program";
           $sql         =$sql." WHERE program_status='active' " ;
           $ret         =mysqli_query($con,$sql);
           $approved    =mysqli_num_rows($ret) ;

           $sql           = "SELECT * FROM partners_merchant WHERE merchant_status='waiting'";
           $ret           = mysqli_query($con,$sql);
           $waitmerchant  = mysqli_num_rows($ret);

           $sql           = "SELECT * FROM partners_affiliate  WHERE affiliate_status='waiting'";
           $ret           = mysqli_query($con,$sql);
           $waitaffiliate = mysqli_num_rows($ret);



 ?>
 <br/>

    <table width="80%" border='0' cellspacing="1" class="tablebdr">
        <tr>
        <td  colspan="3" align="center" height="19"  class="tdhead"><b> Help</b></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="20%" height="28" align="left">
		<img alt="" border='0' height="24" width="24" src="../images/approved.gif" />&nbsp;
        <a href="index.php?Act=status&amp;pgmstatus=active">Approved Programs(<?="$approved"?>)</a></td>
        <td width="80%" height="28" align="left"><a href="approve.php?mode=rejectPgm"> -- Reject All Approved Programs</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="20%" height="28" align="left">
		<img alt="" border='0' height="24" width="24" src="../images/waiting.gif"/>&nbsp; 
		<a href="index.php?Act=status&amp;pgmstatus=inactive">Waiting Programs(<?="$waiting"?>)</a> </td>
         <td width="4%" height="28" align="left"><a href="approve.php?mode=approvePgm"> -- Approve All Waiting Programs</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="20%" height="28" align="left">
		<img alt="" border='0' height="24" width="24" src="../images/pending.gif" />&nbsp; <a href="index.php?Act=waiting_merchants&amp;status=waiting">Waiting Merchants(<?="$waitmerchant"?>)</a></td>
         <td width="4%" height="28" align="left"><a href="approve.php?mode=approveMerchants"> -- Approve All Waiting Merchants</a> || <a href="approve.php?mode=rejectMerchants">Reject All Waiting Merchants</a></td>
        </tr>
        <tr>
        <td width="4%" height="28">&nbsp;</td>
        <td width="28%" height="28" align="left">
        <img alt="" border='0' height="24" width="24" src="../images/notjoined.gif"/> <a href="index.php?Act=waiting_affiliates&amp;status=waiting">&nbsp;Waiting Affiliates(<?="$waitaffiliate"?>)</a> </td>
         <td width="4%" height="28" align="left"><a href="approve.php?mode=approveAffiliates"> -- Approve All Waiting Affiliates</a> || <a href="approve.php?mode=rejectAffiliates">Reject All Waiting Affiliates</a></td>
        </tr>
</table>
