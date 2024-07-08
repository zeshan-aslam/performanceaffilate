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
<br/>
<!--total categories-->
<table border="1" cellspacing="3" width="95%"  class="tablewbdr" align="center">
  <tr>
    <td width="49%">
             <table border="0"  width="100%" id="AutoNumber1" class="tablebdr" cellspacing="3" >
               <tr>
                 <td width="100%" class="tdhead" colspan="2" height="10" align="center">
                 <b><?=$lang_bycategory_all?></b></td>
               </tr>

               <?
               while($j<$count )      //listing
               {
               ?>
                <tr>
                 <td width="50%" align="center" class="grid1" height="10"><a href="index.php?Act=cat&amp;joinstatus=catwise&amp;category=<?=$cat[$j]?>"><?=$cat[$j]?><?=$no[$j]?></a></td>
                 <td width="50%" align="center" class="grid1" height="10"><a href="index.php?Act=cat&amp;joinstatus=catwise&amp;category=<?=$cat[$j+1]?>"><?=$cat[$j+1]?><?=$no[$j+1]?></a></td>

               </tr>
               <?
               $j=$j+2;
               }
               while($j<20)       //checking for 10 rows
                {
               ?>
                <tr>
                 <td width="50%" align="center" class="grid1" height="10"></td>
                 <td width="50%" align="center" class="grid1" height="10">&nbsp;</td>
               </tr>
               <?
               $j=$j+2;
               }
                ?>
             </table>
     <!--close total categories-->
    </td>
    <td width="29%">
    <!--total new pgms-->
             <table border="0" cellspacing="3" width="100%" id="AutoNumber2" class="tablebdr">
               <tr>
                 <td width="100%" class="tdhead" height="10" align="center">
                 <b><?=$lang_bycategory_new?></b></td>
               </tr>
                <?
               /*while($k<$count1)
               {
               ?>
               <tr>
                 <td width="100%" align="center" class="grid1" height="10"><a href="index.php?Act=cat&amp;joinstatus=pgmwise&amp;pgm=<?=$pgm[$k]?>"><?=$link[$k]?></a></td>
               </tr>
               <?
               $k=$k+1;
               }*/
			$k = 0;   
			while($row_newPgms = mysqli_fetch_object($res_newPgms))
			{
				$k=$k+1;
               ?>
               <tr>
                 <td width="100%" align="center" class="grid1" height="10"><a href="index.php?Act=cat&amp;joinstatus=pgmwise&amp;pgm=<?=$row_newPgms->program_id?>"><?=$row_newPgms->program_url?></a></td>
               </tr>
               <?
			}
			   
			while($k<=10  )
			{
               ?>
               <tr>
                 <td width="100%" align="center" class="grid1" height="10"></td>
               </tr>
               <?
               $k=$k+1;
			}
               ?>
             </table>
    <!--close total pgms-->
    </td>
    <td width="22%">

            <!--   listing pgms-->
			<form name="search" method="post" action="index.php?Act=cat&amp;joinstatus=search">
            <table border="0" cellpadding="0" cellspacing="3" width="100%" id="AutoNumber4" class="tablebdr" >

			  <tr>
                <td width="100%" colspan="2" class="tdhead" align="center">
                <b><?=$lang_bycategory_search?></b></td>
              </tr>
              <tr>
                <td width="100%" colspan="2" class="grid1">&nbsp;</td>
              </tr>
              <tr>
                <td width="100%" colspan="2" class="grid1" height="20" align="center">
                <input type="text" name="searchtxt" size="18" value="<?=stripslashes($searchtxt)?>" />
                <input type="submit" value="<?=$lang_bycategory_go?>" name="B1"  /></td>
              </tr>

              <tr>
                <td width="100%" colspan="2" class="grid1" height="21">&nbsp;</td>
              </tr>
              <tr>
                <td width="100%" colspan="2" class="tdhead" height="21">

                  <a href="index.php?Act=cat&amp;joinstatus=All"><?=$lang_aff_total?>(<?="$all"?>)</a></td>
              </tr>
              <tr>
                <td width="5%" class="grid1">&nbsp;</td>
                <td width="95%" align="left" class="grid1"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/approved.gif"
                   />&nbsp; <a href="index.php?Act=cat&amp;joinstatus=approved"><?=$lang_aff_approved?>(<?="$approved"?>)</a></td>
              </tr>
              <tr>
                <td width="5%" class="grid1">&nbsp;</td>
                <td width="95%" align="left" class="grid1"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/waiting.gif"
                   /> &nbsp;<a href="index.php?Act=cat&amp;joinstatus=waiting"><?=$lang_aff_waiting?>(<?="$waiting"?>)</a>
                </td>
              </tr>
              <tr>
                <td width="5%" class="grid1">&nbsp;</td>
                <td width="95%" align="left" class="grid1"><img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/suspend.gif"
                   /> &nbsp;<a href="index.php?Act=cat&amp;joinstatus=suspend"><?=$lang_aff_blocked?>(<?="$suspend"?>)</a>
                </td>
              </tr>
              <tr>
                <td width="5%" class="grid1">&nbsp;</td>
                <td width="95%" align="left" class="grid1">
                  <img
                   alt="" border="0" height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/notjoined.gif"
                   />
                 <a href="index.php?Act=cat&amp;joinstatus=notjoined"><?=$lang_aff_notjoined?>(<?="$notjoin"?>)</a></td>
              </tr>
            </table>
            </form>

    </td>
     </tr>
</table>