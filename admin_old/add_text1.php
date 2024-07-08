<?
  /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO DISPLAY THE EXISTING TEXTS OF A SELECTED PROGRAM(PROGRAM.PHP)
                           SO THAT ADMIN CAN MANUALLY CHECK IT AND APPROVE/REJECT.
      VARIABLES          : pgmstatus       = AD STATUS(APPROVE OR REJECT)
                           linkid,id       = AD ID
                           status          = AD status
  //*************************************************************************************************/



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
    case 'Approve':  //APPROVING ADDS
         $sql="update partners_text_old set text_status='active' where text_id='$linkid'";
          mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;

    case 'Reject':    //REJECTING ADDS
         $sql="update partners_text_old set text_status='inactive' where text_id='$linkid'";
          mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;

  }
  /*******************APPROVING OR REJECTING ADDS **************************************/

  /*******************APPROVING OR REJECTING ADDS **************************************/
    switch ($adstatus)
  {
    case 'active':    //APPROVING ADDS
          $sql3="select * from partners_text_old where text_programid='$pgmid' and text_status='active' ORDER BY text_id DESC";
         // mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;

    case 'inactive':    //REJECTING ADDS
          $sql3="select * from partners_text_old where text_programid='$pgmid' and text_status='inactive' ORDER BY text_id DESC";
         // mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;

    case 'all':
	default :
          $sql3="select * from partners_text_old where text_programid='$pgmid' ORDER BY text_id DESC";
         // mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;
   }
  /*******************APPROVING OR REJECTING ADDS **************************************/
?>



<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<div align="center">
  <center>
  <table border='0' cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center"  width="77%" id="AutoNumber4" class="tablebdr">
    <tr>
             <td width="100%" height="18" colspan="3" class="tdhead">Existing Texts</td>
	</tr>

                <?php    ///////////// display  texts /////////////

                       //$sql3="select * from partners_text_old where text_programid=$_SESSION[PGMID] ORDER BY text_id DESC";
                       $res=mysqli_query($con,$sql3);
                       //echo $sql3;
                       echo mysqli_error($con);
                       if(mysqli_num_rows($res)>0)
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
                       while($row=mysqli_fetch_object($res))
                      {
                       $status                        =stripslashes(trim($row->text_status));
                       $id                            =stripslashes(trim($row->text_id));


                  ?>


           <table cellspacing="0" cellpadding="5" width='622' class="tablebdr" >
                    <tbody>
                     <tr>
                               <td height='1' width='300' bgcolor="#FFFFFF" class="grid1">
                                            <span class='text'><b>Type:</b>Text<b><br/>
                                            URL:</b> <a href='<?=$row->text_url?>' target="new">
                                            <?=stripslashes($row->text_text)?></a></span></td>
                               <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
                                                         <?
                                                               if($status=="active")
                                                                {
                                                                ?>
                                                                  <a href="index.php?Act=add_text1&amp;pgmstatus=Reject&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Reject</a>
                                                                <?
                                                                }
                                                              else
                                                                {
                                                                ?>
                                                                  <a href="index.php?Act=add_text1&amp;pgmstatus=Approve&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Approve</a>
                                                                <?
                                                                }
                                                         ?>

                               </td>
                      </tr>
                      <tr>
                              <td colspan="2" height='69' width='608'>
                              <textarea rows="4" name="S1" cols="55"><?=stripslashes($row->text_description)?></textarea></td>

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