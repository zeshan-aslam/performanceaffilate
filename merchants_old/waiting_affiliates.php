<?php
  include "transactions.php";
  include "../mail.php";

  /*******************************variables*************************************/
  $MERCHANTID                                =$_SESSION['MERCHANTID'];   //merchantid
  $joinid                                    =intval(trim($_POST['joinid']));    //joinid
  $pgmid                                     =intval(trim($_GET['pgmid']));      //programs
  $mode                                      =($_SERVER['REQUEST_METHOD'] == "POST" ? 1 : "");
  /****************************************************************************/


  /*******************selected action******************************************/
  if($mode){
      if(trim($_POST['Approve'])){        //approve affiliate
              $sql                        ="update partners_joinpgm  set joinpgm_status='approved' where joinpgm_id='$joinid'  ";
              mysqli_query($con,$sql);
              $sql="select * from partners_login,partners_joinpgm where joinpgm_id='$joinid' and login_flag='a' and joinpgm_affiliateid=login_id";
                  $ret1=mysqli_query($con,$sql);
                  $row=mysqli_fetch_object($ret1);
                  $to=$row->login_email;
              MailEvent("Approve AffiliateProgram",$MERCHANTID,$joinid,$to,0);    //mailing
              $pgmid                =0;
      }else
      if(trim($_POST['Reject'])){         //reject affiliate

              $sql="select * from partners_login,partners_joinpgm where joinpgm_id='$joinid' and login_flag='a' and joinpgm_affiliateid=login_id";
                  $ret1=mysqli_query($con,$sql);
                  $row=mysqli_fetch_object($ret1);
                  $to=$row->login_email;
              MailEvent("Reject AffiliateProgram",$MERCHANTID,$joinid,$to,0);     //mailing

              $sql                        ="delete  from partners_joinpgm where joinpgm_id='$joinid'";
              mysqli_query($con,$sql);
              $pgmid                =0;
      }/*else{
              header("Location:index.php?Act=home");
              exit();
   }*/
   }
  /****************************************************************************/


  /**********************for adding to drop down box***************************/
  switch($pgmid)  //select pgm
  {
      case '0':   //all
              $sql                ="select * from partners_joinpgm,partners_affiliate where joinpgm_merchantid='$MERCHANTID' and joinpgm_status  like ('waiting') and joinpgm_affiliateid=affiliate_id ";
              break;

      default :   //selected pgm
              $sql                ="select * from partners_joinpgm,partners_affiliate where joinpgm_programid='$pgmid' and  joinpgm_status  like ('waiting') and joinpgm_affiliateid=affiliate_id ";
             break;
    }
  /***************************************************************************/


  $result                        =mysqli_query($con,$sql);
  $result1                       =mysqli_query($con,$sql);
  if (mysqli_num_rows($result1)>0) //checking for records
  {
              $rows                     =mysqli_fetch_object($result1);
              $id                       =$rows->joinpgm_id;

              if (empty($joinid))
                  { // for first time
                     $joinid        =$id;
                     $pgmid         =$rows->joinpgm_programid;
                  }
              $status                =GetAffiliateStatus($joinid); // get affiliates details from transactions.php
              $status                =explode('~',$status);
              $details               = GetAffiliateDetails($joinid);  // get affiliates details from transactions.php
              $details               =explode('~',$details);
              $sql                   =" select * from partners_joinpgm,partners_program where joinpgm_id=$joinid and program_id=joinpgm_programid";
              $ret                   =mysqli_query($con,$sql);
              $field                 =mysqli_fetch_object($ret);
              $pgmname               =stripslashes($field->program_url);              //get page url

             ?>
            <br/>
            <form name="GetAffiliate" method="post" action="index.php?Act=waitingaff&amp;pgmid=<?=$pgmid?>">

            <!-- table 1-->
            <table border="0" cellpadding="0" cellspacing="0"  width="70%" align= "center"class="tablebdr">
                 <tr>
                   <td width="100%" class="tdhead" colspan="2" align="center"><b><?=$lwaitaff_WaitingAffiliatesStaistics?></b></td>
                </tr>
                <tr>
                   <td width="30%" height="20" align="left">&nbsp;&nbsp;&nbsp;<b><?=$lwaitaff_Program ?></b>:<?=$pgmname?>
                       </td>
                       <td width="70%" height="30" align="right" ><b><?=$lwaitaff_Affiliate?></b>
                                <select name="joinid" onchange="document.GetAffiliate.submit()">
                                    <?  while($row=mysqli_fetch_object($result))
                                           {
                                           if($joinid=="$row->joinpgm_id")
                                                  $AffiliateName="selected = 'selected'";
                                           else
                                            $AffiliateName="";

                                           ?>
                                             <option <?=$AffiliateName?> value="<?=$row->joinpgm_id?>"> <?=$waitaff_programid.$row->joinpgm_programid?>&nbsp;<?=stripslashes($row->affiliate_firstname)?> </option>
                                           <?

                                           }
                                           ?>
                                </select>
                   </td>
                 </tr>
                 <tr>
                       <td width="80%" align="center" colspan="3" >
                       <br/>

                       <!-- table 2 -->
                         <table border="0" cellpadding="0"  width="80%" class="tablebdr" >
                          <tr>
                            <td width="100%" colspan="2" class="tdhead" align="center"><b><?=$lwaitaff_PersonalDetails?></b></td>
                          </tr>
                           <tr>
                            <td width="50%" height="20" class="grid1"><?=$lwaitaff_Name?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[0]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$lwaitaff_JoiningDate?></td>
                            <td width="50%" height="20" class="grid1"><?=$status[1]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$lwaitaff_Category?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[4]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$lwaitaff_Company?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[1]?></td>
                          </tr>
                           <tr>
                            <td width="50%" height="20" class="grid1"><?=$lwaitaff_SiteUrl?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[2]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$lwaitaff_SiteTraffic?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[3]?></td>
                          </tr>
                          <tr>
                            <td width="100%" height="20" class="grid1" colspan="2" align="center">
                             <input type="submit" name="Reject" style="width: 100" onclick="return confirmDelete()" value="<?=$lwaitaff_Reject?>" />
                             <input type="submit" name="Approve" style="width: 100" value=" <?=$lwaitaff_Approve?>"  />
                            </td>
                          </tr>
                        </table>
                       <!--close table 2-->

                       </td>
                 </tr>
                 <tr>
                       <td width="100%" height="20" colspan="3">
                       </td>
                 </tr>
				 <tr>
                       <td width="100%" height="20"   align="center" colspan="3">

                             <a href='index.php?Act=programs&mode=editprogram&programId=<?=$pgmid?>'><?=$lwaitaff_ChangeProgram?></a>
                       </td>
                 </tr>
              </table>
              <!--close table 1-->
              </form>
                <?
      }
         else
                      {
                    ?>

                    <!-- table 3 Err msg-->
                     <table width="100%" align="center">
                     <tr>
                        <td align="center" class="red"><?=$norec?>         </td>
                     <tr>
                     </table>
                     <!--close table 3-->

                     <?
                     }
                     ?>

<br />
   <!-- delete confirmation-->
<script language="javascript" type="text/javascript">

   function confirmDelete()
   {
   var del=window.confirm("Are You Sure You Want To Delete? ") ;
   if (del)
      return true;
   else
      return false;
   }

</script>