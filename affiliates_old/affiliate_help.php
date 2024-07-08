<?php
           /***************************************************************************************************
                    PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES pgms -HELP
                       VARIABLES          : all             =TOTAL NO OF pgms
 							 			  waiting			=waiting   pgms
                                          approved			=approved  pgms
                                          suspend   		=suspended  pgms
                                          pending			=pgms with pending transcation
          //*************************************************************************************************/


           /*****************************list affiliate pgms*******************/
           $affiliateid =$_SESSION['AFFILIATEID'];

           //getting total no of programs joined by affiliate
		   $sql_all 	= "SELECT COUNT(program_id)  FROM partners_program WHERE program_status = 'active' ";
           $ret_all     = mysqli_query($con,$sql_all);  
           list($all)   = mysqli_fetch_row($ret_all) ;

           //getting total no of waiting programs joined by affiliate
		   $sql_wait 	= "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm 
		   					WHERE joinpgm_status='waiting' AND joinpgm_affiliateid='$AFFILIATEID' 
							AND program_status = 'active' AND joinpgm_programid = program_id ";
           $ret_wait   	= mysqli_query($con,$sql_wait);
           list($waiting) = mysqli_fetch_row($ret_wait) ;

           //getting total no of approved programs joined by affiliate
		   $sql_approved 	= "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm 
		   						WHERE joinpgm_status='approved'  AND joinpgm_affiliateid='$AFFILIATEID' 
								AND program_status = 'active' AND joinpgm_programid = program_id ";
           $ret_approved   	= mysqli_query($con,$sql_approved);
           list($approved)  = mysqli_fetch_row($ret_approved) ;

           //getting total no of waiting suspended programs joined by affiliate
		   $sql_suspend = "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm 
		   						WHERE joinpgm_status='suspend'  AND joinpgm_affiliateid='$AFFILIATEID' 
								AND program_status = 'active' AND joinpgm_programid = program_id ";
           $ret_suspend = mysqli_query($con,$sql_suspend);
           list($suspend) = mysqli_fetch_row($ret_suspend) ;


            //getting total no of  programs not joined by affiliate
           $notjoin     =$all-($approved+$waiting+$suspend);

           /*******************************************************************/
 ?>
 <br/>
 <!-- list pgms-->
<table border="0" cellspacing="1" width="70%" align="center">
  <tr>
    <td width="25%">
             <table width="100%" border="0" cellspacing="1" class="tablebdr" >
             <tr>
                  <td width="100%"  align="center" height="19" colspan="2" class="tdhead">
                  <a href="index.php?Act=Affiliates&amp;joinstatus=All"><?=$lang_aff_total?>(<?="$all"?>)</a></td>
             </tr>
             <tr>
                  <td width="4%" height="28">&nbsp;</td>
                  <td width="100%" height="28"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
                   />&nbsp;<a href="index.php?Act=Affiliates&amp;joinstatus=approved"><?=$lang_aff_approved?>(<?="$approved"?>)</a></td>
             </tr>
             <tr>
                  <td width="4%" height="28">&nbsp;</td>
                  <td width="100%" height="28"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
                   /> &nbsp;<a href="index.php?Act=Affiliates&amp;joinstatus=waiting"><?=$lang_aff_waiting?>(<?="$waiting"?>)</a> </td>
             </tr>
             <tr>
                  <td width="4%" height="28">&nbsp;</td>
                  <td width="100%" height="28"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
                   /> &nbsp;<a href="index.php?Act=Affiliates&amp;joinstatus=suspend"><?=$lang_aff_blocked?>(<?="$suspend"?>)</a> </td>
             </tr>
		<?php if($Act != "MyAffiliates") { ?>
             <tr>
                  <td width="4%" height="28">&nbsp;</td>
                  <td width="100%" height="28">
                  <img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/notjoined.gif"
                   />
                 &nbsp;<a href="index.php?Act=Affiliates&amp;joinstatus=notjoined"><?=$lang_aff_notjoined?>(<?="$notjoin"?>)</a></td>
             </tr>
       	<?php } ?>
           
            </table>
    <!-- close list pgms-->
    </td>
    <td width="75%">
    <!-- help-->
            <table border="0" cellspacing="1" width="100%" class="tablebdr">
            <tr>
                 <td width="100%" colspan="2" align="center" height="19" class="tdhead"><b> <?=$lang_aff_help?> </b></td>
            </tr>
            <tr>
               <td width="4%" height="28">&nbsp;</td>
               <td width="100%" height="28"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
                   /> - <?=$lang_aff_approved_help?></td>
            </tr>
            <tr>
               <td width="4%" height="28">&nbsp;</td>
               <td width="100%" height="28"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
                   /> - <?=$lang_aff_waiting_help?> </td>
            </tr>
            <tr>
               <td width="4%" height="28">&nbsp;</td>
               <td width="100%" height="28"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
                   /> - <?=$lang_aff_blocked_help?> </td>
            </tr>
		<?php if($Act != "MyAffiliates") { ?>
            <tr>
               <td width="4%" height="28">&nbsp;</td>
               <td width="100%" height="28"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/notjoined.gif"
                   /> - <?=$lang_aff_notjoined_help?></td>
           </tr>
       	<?php } ?>
          </table>
     <!-- close help-->
     </td>
     </tr>
</table>