<?php
   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE joinpgms according to  category
      VARIABLES          :


  //*************************************************************************************************/


      $affiliateid =$_SESSION['AFFILIATEID'];      //affiliateid


     /*************************************listing new category****************/
     $sql		 	= "select * from partners_program where program_status like 'active'  order by program_date desc LIMIT 0,10";
     $res_newPgms 	= mysqli_query($con,$sql);
     $count1		= mysqli_num_rows($res_newPgms);
     /*************************************************************************/


     /******************listing category**************************************/
     $sql="select * from partners_category";
     $ret=mysqli_query($con,$sql);
     $i=0;
     $j=0;
     $k=0;
     $count=mysqli_num_rows($ret);
     while($row=mysqli_fetch_object($ret))
               {
                   $cat[$i]=$row->cat_name;
                   $sql="select * from partners_merchant,partners_program where program_status='active' and merchant_category='".addslashes($cat[$i])."' and merchant_id=program_merchantid"   ;
                   $result=mysqli_query($con,$sql);
                   $no[$i]="(".mysqli_num_rows($result).")";          //finding pgm of specified category
                   $i=$i+1;
              }

    /**************************************************************************/


   /**********listing pgms ****************************************************/

           //getting total no of programs joined by affiliate
		   $sql_all 	= "SELECT COUNT(program_id)  FROM partners_program WHERE program_status = 'active' ";
           $ret_all     = mysqli_query($con,$sql_all);  
           list($all)   = mysqli_fetch_row($ret_all) ;

           //getting total no of waiting programs joined by affiliate
		   $sql_wait 	= "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm 
		   					WHERE joinpgm_status='waiting' AND joinpgm_affiliateid=$AFFILIATEID 
							AND program_status = 'active' AND joinpgm_programid = program_id ";
           $ret_wait   	= mysqli_query($con,$sql_wait);
           list($waiting) = mysqli_fetch_row($ret_wait) ;

           //getting total no of approved programs joined by affiliate
		   $sql_approved 	= "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm 
		   						WHERE joinpgm_status='approved'  AND joinpgm_affiliateid=$AFFILIATEID 
								AND program_status = 'active' AND joinpgm_programid = program_id ";
           $ret_approved   	= mysqli_query($con,$sql_approved);
           list($approved)  = mysqli_fetch_row($ret_approved) ;

           //getting total no of waiting suspended programs joined by affiliate
		   $sql_suspend = "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm 
		   						WHERE joinpgm_status='suspend'  AND joinpgm_affiliateid=$AFFILIATEID 
								AND program_status = 'active' AND joinpgm_programid = program_id ";
           $ret_suspend = mysqli_query($con,$sql_suspend);
           list($suspend) = mysqli_fetch_row($ret_suspend) ;

            //getting total no of  programs not joined by affiliate
           $notjoin     =$all-($approved+$waiting+$suspend);
  /****************************************************************************/

?>
<!--total categories-->
<div class="row"> 
	<div class="col-md-6"> 
		<div class="card">
			<div class="card-header">				
				<h4 class="card-title"><?=$lang_bycategory_all?></h4>
			</div>
			<div class="card-body">
				<div class="all_cate_list cus_prog_list">
					<ul>
						<?
					   while($j<$count )      //listing
					   {
					   ?>					   
						<li><a href="index.php?Act=cat&amp;joinstatus=catwise&amp;category=<?=$cat[$j]?>"><?=$cat[$j]?><?=$no[$j]?></a></li>
						<li><a href="index.php?Act=cat&amp;joinstatus=catwise&amp;category=<?=$cat[$j+1]?>"><?=$cat[$j+1]?><?=$no[$j+1]?></a></li>
					   <?
					   $j=$j+2;
					   }
					   while($j<20)       //checking for 10 rows
						{
					   ?>
						 <li></li>
					   <?
					   $j=$j+2;
					   }
					  ?>
					  <div class="clearfix"></div>
					</ul>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header">				
				<h4 class="card-title"><?=$lang_bycategory_new?></h4>
			</div>
			<div class="card-body">
				<div class="new_prog_list cus_prog_list">
					<ul>				
						 <?
						$k = 0;   
						while($row_newPgms = mysqli_fetch_object($res_newPgms))
						{
						$k=$k+1;
					   ?>
					   <li><a href="index.php?Act=cat&amp;joinstatus=pgmwise&amp;pgm=<?=$row_newPgms->program_id?>"><?=$row_newPgms->program_url?></a></li>
					   <?
						}								   
						while($k<=10  )
						{
					 ?>
					 <li></li>
					  <?
					   $k=$k+1;
						}
					  ?>
					</ul>				
				</div>
			</div>
		</div> 
	</div>
	<div class="col-md-3">
		<div class="card">
			<form name="search" method="post" action="index.php?Act=cat&amp;joinstatus=search">
				<div class="card-header">				
					<h4 class="card-title"><?=$lang_bycategory_search?></h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<input class="form-control" type="text" name="searchtxt" size="18" value="<?=stripslashes($searchtxt)?>" />
						<input class="btn btn-fill btn-info" style="margin-top:10px;" type="submit" value="<?=$lang_bycategory_go?>" name="B1"  />
					</div>	
					<div class="search_prog_list cus_prog_list">
						<ul>
							<li><a href="index.php?Act=cat&amp;joinstatus=All"><?=$lang_aff_total?>(<?="$all"?>)</a></li>
							<li><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif" />&nbsp; <a href="index.php?Act=cat&amp;joinstatus=approved"><?=$lang_aff_approved?>(<?="$approved"?>)</a></li>
							<li><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif" /> &nbsp;<a href="index.php?Act=cat&amp;joinstatus=waiting"><?=$lang_aff_waiting?>(<?="$waiting"?>)</a></li>
							<li><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif" /> &nbsp;<a href="index.php?Act=cat&amp;joinstatus=suspend"><?=$lang_aff_blocked?>(<?="$suspend"?>)</a></li>
							<li><img alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/notjoined.gif"/>
							<a href="index.php?Act=cat&amp;joinstatus=notjoined"><?=$lang_aff_notjoined?>(<?="$notjoin"?>)</a></li>
						</ul>	
					</div>
				</div>
			</form>	
		</div>
	</div>
 </div>