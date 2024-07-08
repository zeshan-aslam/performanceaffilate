<?

    /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO DISPLAY THE EXISTING POPUPS OF A SELECTED PROGRAM(PROGRAM.PHP)
                           SO THAT ADMIN CAN MANUALLY CHECK IT AND APPROVE/REJECT.
      VARIABLES          : pgmstatus       = AD STATUS(APPROVE OR REJECT)
                           linkid,id       = AD ID
                           status          = AD status
  //*************************************************************************************************/

//Added by SMA on 14-JUly-2006 for Admin Users
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
//End Add on 14-July-2006


  /***********GETTING AD STATUS AND LINKID***************/
   $pgmstatus             =trim($_GET['pgmstatus']);    //AD STATUS(APPROVE OR REJECT)
   $linkid                =intval(trim($_GET['programs']));     //AD ID
   $pgmid				  =intval(trim($_GET['programid']));
   $adstatus			  =trim($_GET['adstatus']);
   if(empty($pgmid))
            $pgmid        =$_SESSION['PGMID'] ;

   if(empty($adstatus))
            $adstatus     ='all' ;

  /*********************END*******************************/



  /*******************APPROVING OR REJECTING ADDS **************************************/
    switch ($pgmstatus)
  {
    case 'Approve':    //APPROVING ADDS
         $sql="update partners_popup set popup_status='active' where popup_id='$linkid'";
          mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'Reject':    //REJECTING ADDS
         $sql="update partners_popup set popup_status='inactive' where popup_id='$linkid'";
          mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;
   }
  /*******************APPROVING OR REJECTING ADDS **************************************/


   /*******************APPROVING OR REJECTING ADDS **************************************/
    switch ($adstatus)
  {
    case 'active':    //APPROVING ADDS
          $sql3="select * from partners_popup where popup_programid='$pgmid' and popup_status='active' ORDER BY popup_id DESC";
         // mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'inactive':    //REJECTING ADDS
          $sql3="select * from partners_popup where popup_programid='$pgmid' and popup_status='inactive' ORDER BY popup_id DESC";
         // mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'all':
	default :
          $sql3="select * from partners_popup where popup_programid='$pgmid' ORDER BY popup_id DESC";
         // mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;
   }
  /*******************APPROVING OR REJECTING ADDS **************************************/
?>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
  <div align="center">
  <center>
  <table border='0' cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" width="77%" id="AutoNumber4" class="tablebdr">
            <tr>
             <td width="100%" height="18" colspan="3" class="tdhead">Existing Popups</td>
			</tr>

                <?php

                      /******************* selaecting  popups ************************/
                      // $sql3="select * from partners_popup where popup_programid=$_SESSION[PGMID] ORDER BY popup_id DESC";
                       $res=mysql_query($sql3);
                       echo mysql_error();
                       /********************end selaecting  popups**********************/

                     if(mysql_num_rows($res)>0)
                     {

                     ?>
                      <tr>
             	           <td width="100%" height="18" colspan="3">
	                          </td>
	                   </tr>
	                   <tr>
	                          <td width="2%" height="19">&nbsp;</td>
	                          <td width="97%" height="19">
                     <?
                        /******************* display  popups ************************/
                       while($row=mysql_fetch_object($res))
                       {
                         $status                        =stripslashes(trim($row->popup_status)); //ADDS STATUS
                         $id                            =stripslashes(trim($row->popup_id));     //LINK ID

                  ?>


                  <table cellspacing="0" cellpadding="5" width='622'  class="tablebdr">
                          <tbody>
                          <tr>
                              <td height='1' width='300' bgcolor="#FFFFFF" class="grid1">
                                            <span class='text'><b>Type:</b>POPUP<b><br/>
                                            URL:</b> <a href='<?=stripslashes($row->popup_url)?>'>
                                            <?=stripslashes($row->popup_url)?></a></span>
                              </td>
                              <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
                              <?
							  							//checks if Admin user has access to Approve/Reject links
														if($userobj->GetAdminUserLink('Approve/Reject Links',$adminUserId,3)) { 
							                               //CHECKING ADS STATUS///////////
                                                             if($status=="active")
                                                              {
                                                                ?>
                                                                  <a href="index.php?Act=add_popup&amp;pgmstatus=Reject&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>" >Reject</a>
                                                                <?
                                                                }
                                                              else
                                                                {
                                                                ?>
                                                                  <a href="index.php?Act=add_popup&amp;pgmstatus=Approve&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Approve</a>
                                                                <?
                                                                }
                                                              //////////END//////////////
															}
                                                         ?>

                              </td>
                        </tr>
                        <tr>
                              <td colspan="2" height='69' width='608' align="center" ><a href="#">
                              <img src='../merchants/images/popup.gif' border='0' width="300" height="60" onclick="window.open('<?=stripslashes($row->popup_url)?>',<?=$row->popup_width?>,<?=$row->popup_height?>)" alt="" /></a></td>
                       </tr>
                       </tbody>
                  </table>
                    <?php
                       } /******end displaying popups*************/

                    ?>
             </td>
             <td width="1%" height="19">&nbsp;</td>
        </tr>
        <tr>
            <td width="2%" height="19">&nbsp;</td>
            <td width="97%" height="19">&nbsp;</td>
            <td width="1%" height="19">
            </td>
        </tr>
        <tr>
            <td width="100%" height="19" colspan="3" class="tdhead">&nbsp;</td>
        </tr>


   <?
     }
                       else
                       {
                       ?>

                     <tr>
                         <td width="100%" align="center" class="textred" colspan="3" ><?=$norec?>
                         </td>
                     </tr>

                     <?
                       }
                       ?>
</table>
</center>
    </div>

