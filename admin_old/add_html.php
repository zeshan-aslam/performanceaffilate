<?
   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO DISPLAY THE EXISTING HTMLS OF A SELECTED PROGRAM(PROGRAM.PHP)
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
         $sql="update partners_html set html_status='active' where html_id='$linkid'";
          mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'Reject':    //REJECTING ADDS
         $sql="update partners_html set html_status='inactive' where html_id='$linkid'";
          mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;
   }
  /*******************APPROVING OR REJECTING ADDS **************************************/


   /*******************APPROVING OR REJECTING ADDS **************************************/
    switch ($adstatus)
  {
    case 'active':    //APPROVING ADDS
          $sql3="select * from partners_html where html_programid='$pgmid' and html_status='active' ORDER BY html_id DESC  ";
         // mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'inactive':    //REJECTING ADDS
          $sql3="select * from partners_html where html_programid='$pgmid' and html_status='inactive' ORDER BY html_id DESC  ";
         // mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'all':
	default :
          $sql3="select * from partners_html where html_programid='$pgmid' ORDER BY html_id DESC  ";
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
             <td width="100%" height="18" colspan="3" class="tdhead">Existing HTMLs</td>
		</tr>
                   <?php    ///////////// display  htmls /////////////

                       //$sql3="select * from partners_html where html_programid=$_SESSION[PGMID] ORDER BY html_id DESC";
                       $res=mysql_query($sql3);
                       //echo $sql3;
                       echo mysql_error();

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
                         while($row=mysql_fetch_object($res))
                        {
                            $status                        =stripslashes(trim($row->html_status));
                            $id                            =stripslashes(trim($row->html_id));

                  ?>


           <table cellspacing="0" cellpadding="5" width='622' class="tablebdr">
                   <tbody>
                   <tr>
                            <td height='1' width='300' bgcolor="#FFFFFF" class="grid1">
                                            <span class='text'><b>Type:</b>HTML Code<b><br/>
                                            HTML ID:<?=$row->html_id?></b> .....</span>
                            </td>
                            <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
                                                         <?
														 //checks if Admin user has access to Approve/Reject links
														if($userobj->GetAdminUserLink('Approve/Reject Links',$adminUserId,3)) { 
                                                             if($status=="active")
                                                              {
                                                                ?>
                                                                  <a href="index.php?Act=add_html&amp;pgmstatus=Reject&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Reject</a>
                                                                <?
                                                                }
                                                              else
                                                                {
                                                                ?>
                                                                  <a href="index.php?Act=add_html&amp;pgmstatus=Approve&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Approve</a>
                                                                <?
                                                                }
															}
                                                         ?>

                            </td>
                   </tr>                                                       <? $id=$row->html_id?>
                   <tr>
                           <td colspan="2" height='69' width='608' align="center" ><a href='../merchants/temp.php?rowid=<?=$id ?>' target="new">
                                       <img src='../merchants/images/html.gif' border='0' width="300" height="60" alt="" /></a>
                           </td>
                   </tr>
            </tbody>
           </table>
                    <?php

                    } /// while closing

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
                         <td width="100%" align="center" class="textred" colspan="3"><?=$norec?>
                         </td>
                     </tr>

                     <?
                       }
                       ?>
        </table>
	 </center>
   </div>