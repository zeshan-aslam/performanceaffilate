<?
  /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO DISPLAY THE EXISTING TEXTS OF A SELECTED PROGRAM(PROGRAM.PHP)
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
   $pgmid                 =intval(trim($_GET['programid']));
   $adstatus              =trim($_GET['adstatus']);
   if(empty($pgmid))
            $pgmid        =$_SESSION['PGMID'] ;

   if(empty($adstatus))
            $adstatus     ='all' ;

  /*********************END*******************************/


  /*******************APPROVING OR REJECTING ADDS **************************************/
    switch ($pgmstatus)
  {
    case 'Approve':  //APPROVING ADDS
         $sql="update partners_text set text_status='active' where text_id='$linkid'";
          mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'Reject':    //REJECTING ADDS
         $sql="update partners_text set text_status='inactive' where text_id='$linkid'";
          mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

  }
  /*******************APPROVING OR REJECTING ADDS **************************************/

  /*******************APPROVING OR REJECTING ADDS **************************************/
    switch ($adstatus)
  {
    case 'active':    //APPROVING ADDS
          $sql3="select * from partners_text where text_programid='$pgmid' and text_status='active' ORDER BY text_id DESC";
         // mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'inactive':    //REJECTING ADDS
          $sql3="select * from partners_text where text_programid='$pgmid' and text_status='inactive' ORDER BY text_id DESC";
         // mysql_query($sql)or die($sql."<br/>".mysql_error());
         break;

    case 'all':
	default :
          $sql3="select * from partners_text where text_programid='$pgmid' ORDER BY text_id DESC";
         // mysql_query($sql)or die($sql."<br/>".mysql_error());
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

                       //$sql3="select * from partners_text where text_programid=$_SESSION[PGMID] ORDER BY text_id DESC";
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
                       $status                        =stripslashes(trim($row->text_status));
                       $id                            =stripslashes(trim($row->text_id));

                                                $text_url = $row->text_url;
                                                $text_text = $row->text_text;
                                                $text_image = $row->text_image;
                                                # if the 1st part of the URL not contain http:/
                                                $url_test = substr($text_url, 0, 7);
                                                if($url_test!="http://")
                                                {
                                                        $text_url   =    "http://".$text_url;
                                                }

                  ?>


           <table cellspacing="0" cellpadding="5" width='622' class="tablebdr" >
                    <tbody>
                     <tr>
                               <td height='1' width='300' bgcolor="#FFFFFF" class="grid1">&nbsp;</td>
                               <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
                                                         <? //checks if Admin user has access to Approve/Reject links
														 if($userobj->GetAdminUserLink('Approve/Reject Links',$adminUserId,3)) { 
                                                               if($status=="active")
                                                                {
                                                                ?>
                                                                  <a href="index.php?Act=add_text&amp;pgmstatus=Reject&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Reject</a>
                                                                <?
                                                                }
                                                              else
                                                                {
                                                                ?>
                                                                  <a href="index.php?Act=add_text&amp;pgmstatus=Approve&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Approve</a>
                                                                <?
                                                                }
															}
                                                         ?>

                               </td>
                      </tr>
                                                <tr>
                                                        <td align="center" colspan="2" >
                                                                <div align="center" style="overflow:auto; border:none; width:500; height:75" >
                                                                <table align="center" width="500" height="75" border="1" style="border-color:#3399FF; " cellpadding="0" cellspacing="0">
                                                                        <tr style="border:none;" valign="top">
                                                                                        <td style="border:none;" valign="top" width="100%" height="100%">
                                                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
                                                                                                        <tr bordercolor="#3399FF" bgcolor="#3399FF" height="20">
                                                                                                                <td align="left" <? if(!empty($text_image)){ ?> colspan="2" <? } ?>><font color="#FFFFFF"><b>SPONSORED LISTINGS</b></font></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td align="left"><a href="<?=$text_url?>" target="_blank"><?=$text_text?></a></td>
                                                                                                        <?  if(!empty($text_image)) { ?>
                                                                                                                <td rowspan="3" align="right"><img src="../thumbnail.php?image=<?=$text_image?>&height=50" alt="0" border="0" /></td>
                                                                                                        <? } ?>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td align="left"><?=stripslashes($row->text_description)?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                                <td align="left"><?=$text_url?></td>
                                                                                                        </tr>
                                                                                        </table>
                                                                                </td>
                                                                        </tr>
                                                                </table>
                                                                </div>
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