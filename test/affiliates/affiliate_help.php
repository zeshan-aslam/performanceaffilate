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
 <div class="col-md-12">
	<div class="card regular-table-with-color">		
		<div class="card-body table-full-width table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><a href="index.php?Act=Affiliates&amp;joinstatus=All"><?=$lang_aff_total?>(<?="$all"?>)</a></th>
						<th><?=$lang_aff_help?></th>
					</tr>
				</thead>
				<tbody>
					<tr class="success">
						<td><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
                   />&nbsp;<a href="index.php?Act=Affiliates&amp;joinstatus=approved"><?=$lang_aff_approved?>(<?="$approved"?>)</a></td>
						<td><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
                   /> - <?=$lang_aff_approved_help?></td>
					</tr>
					<tr class="info">
						<td><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
                   /> &nbsp;<a href="index.php?Act=Affiliates&amp;joinstatus=waiting"><?=$lang_aff_waiting?>(<?="$waiting"?>)</a></td>
						<td><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
                   /> - <?=$lang_aff_waiting_help?></td>
					</tr>
					<tr class="danger">
						<td><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
                   /> &nbsp;<a href="index.php?Act=Affiliates&amp;joinstatus=suspend"><?=$lang_aff_blocked?>(<?="$suspend"?>)</td>
						<td><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
                   /> - <?=$lang_aff_blocked_help?></td>
					</tr>
					<?php if($Act != "MyAffiliates") { ?>
					<tr class="warning">
						<td><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/notjoined.gif"
                   />&nbsp;<a href="index.php?Act=Affiliates&amp;joinstatus=notjoined"><?=$lang_aff_notjoined?>(<?="$notjoin"?>)</a></td>
						<td><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/notjoined.gif"
                   /> - <?=$lang_aff_notjoined_help?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div> 
</div>