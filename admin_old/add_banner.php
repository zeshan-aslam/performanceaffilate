<?
 /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO DISPLAY THE EXISTING BANNERS OF A SELECTED PROGRAM(PROGRAM.PHP)
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
         $sql="update partners_banner set banner_status='active' where banner_id='$linkid'";
          mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;

    case 'Reject':    //REJECTING ADDS
         $sql="update partners_banner set banner_status='inactive' where banner_id='$linkid'";
          mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;
   }
  /*******************APPROVING OR REJECTING ADDS **************************************/


   /*******************APPROVING OR REJECTING ADDS **************************************/
    switch ($adstatus)
  {
    case 'active':    //APPROVING ADDS
          $sql3="select * from partners_banner where banner_programid='$pgmid' and banner_status='active' ORDER BY banner_id DESC";
         // mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;

    case 'inactive':    //REJECTING ADDS
          $sql3="select * from partners_banner where banner_programid='$pgmid' and banner_status='inactive' ORDER BY banner_id DESC";
         // mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;

    case 'all':
	default :
          $sql3="select * from partners_banner where banner_programid='$pgmid' ORDER BY banner_id DESC";
         // mysqli_query($con,$sql)or die($sql."<br/>".mysqli_error($con));
         break;
   }
  /*******************APPROVING OR REJECTING ADDS **************************************/
?>



<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
  <div align="center">
  <center>
  <table border='0' cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" width="77%" id="AutoNumber4" class="tablebdr">
       <tr>
             <td width="100%" height="18" colspan="3" class="tdhead">Existing Banners</td>
         </tr>

                <?php    ///////////// display  banners /////////////
                      // $sql3="select * from partners_banner where banner_programid=$_SESSION[PGMID] ORDER BY banner_id DESC";
                       $res=mysqli_query($con,$sql3);


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
                    <? while($row=mysqli_fetch_object($res))
                    {
                       $status                        =stripslashes(trim($row->banner_status));
                       $id                            =stripslashes(trim($row->banner_id));

                    ?>
						<table cellspacing="0" cellpadding="5" width='622' class="tablebdr">
						<tbody>
						<tr>
						<td height='1' width='300' bgcolor="#FFFFFF" class="grid1">
						<span class='text'><b>Type:</b>Banners<b><br/>
						URL:</b> <a href='<?=$row->banner_url?>' target="new">
						<?=stripslashes($row->banner_url)?></a></span>
						</td>
						<td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
						<?
						//checks if Admin user has access to Approve/Reject links
						if($userobj->GetAdminUserLink('Approve/Reject Links',$adminUserId,3)) { 
						if($status=="active")
						{
						?>
						<a href="index.php?Act=add_banner&amp;pgmstatus=Reject&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Reject</a>
						<?
						}
						else
						{
						?>
						<a href="index.php?Act=add_banner&amp;pgmstatus=Approve&amp;programs=<?=$id?>&amp;programid=<?=$pgmid?>&amp;adstatus=<?=$adstatus?>">Approve</a>
						<?
						}
						}
						?>
						
						</td>
						</tr>
						<tr>
						<td colspan="2" height='69' width='608'><a href='<?=stripslashes($row->banner_url)?>'>
						<img src="<?=stripslashes($row->banner_name)?>" border='0' width="<?=$row->banner_width?>"  alt="" height="<?=$row->banner_height?>" /></a>
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
				<td width="100%" align="center" class="textred" colspan="3"><?=$norec?></td>
			</tr>
			<?
			}
			?>

    </table>
    </center>
    </div>