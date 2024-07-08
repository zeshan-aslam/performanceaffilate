<?php
          /***************************************************************************************************
                    PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE my AFFILIATES programs -HELP
                     VARIABLES          : all               =TOTAL NO OF pgms
 							 			  waiting			=waiting   pgms
                                          approved			=approved  pgms
                                          suspend   		=suspended  pgms
                                          pending			=pgms with pending transcation
          //*************************************************************************************************/


           $affiliateid =$_SESSION['AFFILIATEID'];

           /*******************listing affilaite pgms**************************/
           //getting total no of programs joined by affiliate
           $sql         ="select * from partners_program,partners_firstlevel where program_status like ('active') and firstlevel_programid=program_id ";
           $ret         =mysqli_query($con,$sql);
           $all         =mysqli_num_rows($ret) ;

           //getting total no of waiting programs joined by affiliate
           $sql         =" SELECT   * " ;
           $sql         =$sql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $sql         =$sql." WHERE joinpgm_status='waiting' and c.joinpgm_affiliateid=$AFFILIATEID and program_status like ('active') and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
           $ret         =mysqli_query($con,$sql);
           $waiting     =mysqli_num_rows($ret) ;

           //getting total no of approved programs joined by affiliate
            $sql         =" SELECT   * " ;
           $sql         =$sql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $sql         =$sql." WHERE joinpgm_status='approved' and c.joinpgm_affiliateid=$AFFILIATEID and  program_status like ('active') and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
           $ret         =mysqli_query($con,$sql);
           $approved    =mysqli_num_rows($ret) ;

           //getting total no of waiting suspended programs joined by affiliate
           $sql         =" SELECT   * " ;
           $sql         =$sql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $sql         =$sql." WHERE joinpgm_status='suspend' and c.joinpgm_affiliateid=$AFFILIATEID and program_status like ('active')  and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
           $ret         =mysqli_query($con,$sql);
           $suspend     =mysqli_num_rows($ret) ;
          /*******************************************************************/



 ?>
 <br/>
<table border="0" cellspacing="1" width="70%" align="center">
  <tr>
    <td width="25%">
             <table width="100%" border="0" cellspacing="1" class="tablebdr" >
             <tr>
                  <td width="100%"  align="center" height="19" colspan="2" class="tdhead">
                  <?=$lang_affiliate_pgms_my?></td>
             </tr>
             <tr>
                  <td width="4%" height="28">&nbsp;</td>
                  <td width="100%" height="28"><img
                   alt="" border="0" height="15" src="../images/approved.gif"
                   width="15" />&nbsp;<a href="index.php?Act=MyAffiliates&amp;joinstatus=approved"><?=$lang_aff_approved?>(<?="$approved"?>)</a></td>
             </tr>
             <tr>
                  <td width="4%" height="28">&nbsp;</td>
                  <td width="100%" height="28"><img
                   alt="" border="0" height="15" src="../images/waiting.gif"
                   width="15" /> &nbsp;<a href="index.php?Act=MyAffiliates&amp;joinstatus=waiting"><?=$lang_aff_waiting?>(<?="$waiting"?>)</a> </td>
             </tr>
             <tr>
                  <td width="4%" height="28">&nbsp;</td>
                  <td width="100%" height="28"><img
                   alt="" border="0" height="15" src="../images/suspend.gif"
                   width="15" /> &nbsp;<a href="index.php?Act=MyAffiliates&amp;joinstatus=suspend"><?=$lang_aff_blocked?>(<?="$suspend"?>)</a> </td>
             </tr>

            </table>
    </td>
    <td width="75%">
            <table border="0" cellspacing="1" width="100%" class="tablebdr">
            <tr>
                 <td width="100%" colspan="3" align="center" height="19" class="tdhead">
                 <?=$lang_aff_help?> </td>
            </tr>
            <tr>
               <td width="4%" height="28">&nbsp;</td>
               <td width="100%" height="28"><img
                   alt="" border="0" height="15" src="../images/approved.gif"
                   width="15" /> - <?=$lang_aff_approved_help?></td>
            </tr>
            <tr>
               <td width="4%" height="28">&nbsp;</td>
               <td width="100%" height="28"><img
                   alt="" border="0" height="15" src="../images/waiting.gif"
                   width="15" /> - <?=$lang_aff_waiting_help?> </td>
            </tr>
            <tr>
               <td width="4%" height="28">&nbsp;</td>
               <td width="100%" height="28"><img
                   alt="" border="0" height="15" src="../images/suspend.gif"
                   width="15" /> - <?=$lang_aff_blocked_help?> </td>
            </tr>

          </table>
     </td>
     </tr>
</table>