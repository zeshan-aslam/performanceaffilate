<?php
	include "transactions.php";
	include "../mail.php";

	$MERCHANTID    = $_SESSION['MERCHANTID'];   //merchantid
	$joinid        = intval(trim($_POST['joinid'])); //joinpgmid
	$pgmid         = intval(trim($_GET['pgmid']));   //programid
	$mode          = ($_SERVER['REQUEST_METHOD']== "POST" ? 1 : "") ;

	# Perform selected action
	# Reverse Sale
	if($mode){
		$sql	= " update partners_joinpgm set joinpgm_status='suspend' where joinpgm_id='$joinid '";
		@mysqli_query($con,$sql);
		
		$sql	= " select * from partners_login, partners_joinpgm where joinpgm_id='$joinid' and login_flag='a' 
					and joinpgm_affiliateid=login_id";
		$ret1	= @mysqli_query($con,$sql);
		
		$row	= @mysqli_fetch_object($ret1);
		$to   	= $row->login_email;
		
		MailEvent("Suspend AffiliateProgram",$MERCHANTID,$joinid,$to,0);
		$pgmid        =0;
	}

  	# select programs
	switch($pgmid){
		case '0':
			$sql	= " select * from partners_joinpgm, partners_affiliate where joinpgm_merchantid = '$MERCHANTID' 
						and joinpgm_status not like ('waiting') and joinpgm_affiliateid = affiliate_id ";
		break;
		
		default :       //selected pgm
			$sql	= " select * from partners_joinpgm, partners_affiliate where joinpgm_programid='$pgmid'
						and joinpgm_status not like ('waiting') and joinpgm_affiliateid=affiliate_id ";
		break;
	}

	$result   = @mysqli_query($con,$sql);
	$result1  = @mysqli_query($con,$sql);
	
  if (@mysqli_num_rows($result1)>0) //checking for records
  {
              $rows   = @mysqli_fetch_object($result1);
              $id     = $rows->joinpgm_id;  //for first time
              if (empty($joinid))  $joinid=$id;

              # getting affiliates information
              $status      = GetAffiliateStatus($joinid);
              $status      = explode('~',$status);

              # getting program payment information
              $details     = GetAffiliateDetails($joinid);
              $details     = explode('~',$details);

              # getting affiliates paayment information
              $total       = GetPaymentDetails1($joinid , $currValue,$default_currency_caption);
              $total       = explode('~',$total);

              # getting affiliates paymentstatus
              $payStatus   = GetPaymentStaus($joinid, $currValue,$default_currency_caption) ;
              $payStatus   = explode('~',$payStatus);

              $sql         	= " select * from partners_joinpgm,partners_program 
			  					where joinpgm_id='$joinid' and program_id = joinpgm_programid";
              $ret         = @mysqli_query($con,$sql);
              $field       = @mysqli_fetch_object($ret);
              $pgmname     = stripslashes($field->program_url); //getting page url


            ?><!-- Table 1-->
			<form name="GetAffiliate" method="post" action="index.php?Act=listaffiliate&amp;pgmid=<?=$pgmid?>">
            <table border="0" cellpadding="0" cellspacing="0"  width="70%" align= "center" class="tablebdr" >
               <tr>
                   <td width="100%" class="tdhead" colspan="4" align="center"><b><?=$ltotaff_AffiliateStaistics?></b></td>
               </tr>
               <tr>

                   <td width="40%" height="20" align="left" colspan="2" >&nbsp;&nbsp;&nbsp;<b><?=$ltotaff_Program?></b> :<?=$pgmname?> </td>
                   <td width="60%" height="30" align="right" colspan="2" ><b><?=$ltotaff_Affiliate?></b>
                       <select name="joinid" onchange="document.GetAffiliate.submit()">
                           <?  while($row=mysqli_fetch_object($result))
                                           {
                                           if($joinid=="$row->joinpgm_id")
                                                  $AffiliateName="selected = 'selected'";
                                           else
                                            $AffiliateName="";

                                           ?>
                                             <option <?=$AffiliateName?> value="<?=$row->joinpgm_id?>"> <?=stripslashes($row->affiliate_firstname)?>&nbsp;PgmID=<?=$row->joinpgm_programid;?> </option>
                                           <?

                                           }
                                           ?>
                       </select>
                   </td>

               </tr>
               <tr>
               <td  height="10">
               </td>
               </tr>
               <tr>

                   <td width="60%" align="center" >

                         <!-- Table 2 adding pERSONAL details-->
                        <table border="0" cellpadding="0"  width="90%" class="tablebdr" >
                           <tr>
                            <td width="100%" colspan="2" class="tdhead"><?=$ltotaff_PersonalDetails?></td>
                          </tr>
                           <tr>
                            <td width="50%" height="20" class="grid1"><?=$ltotaff_Name?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[0]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$ltotaff_Status?></td>
                            <td width="50%" height="20" class="grid1"><?=$status[0]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$ltotaff_JoiningDate?></td>
                            <td width="50%" height="20" class="grid1"><?=$status[1]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$ltotaff_Category?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[4]?></td>
                          </tr>
                          <tr>
                            <td width="50%" height="20" class="grid1"><?=$ltotaff_Company?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[1]?></td>
                          </tr>
                           <tr>
                            <td width="50%" height="20" class="grid1"><?=$ltotaff_SiteUrl?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[2]?></td>
                          </tr>

                           <tr>
                            <td width="50%" height="20" class="grid1"><?=$ltotaff_SiteTraffic?></td>
                            <td width="50%" height="20" class="grid1"><?=$details[3]?></td>
                          </tr>
                        </table>
                        <!-- close table 2-->
                   </td>

                  <td width="1%">
                  </td>
                  <td width="40%" align="center">

                  <!-- table 3  adding transactions-->
                   <table border="0" cellpadding="0"   width="90%" class="tablebdr">
                           <tr>
                              <td width="34%" align="center" class="tdhead"><b><?=$ltotaff_Transaction?></b></td>
                              <td width="40%" align="center" class="tdhead"><b><?=$ltotaff_Commission?></b></td>
                     </tr>
                            <tr>
                              <td width="35%"  class="grid1" height="20"><?=$ltotaff_Click?>&nbsp;<img
                                           alt="" border="0" height="10" src="../images/click.gif"
                                           width="10"/></td>
                              <td width="39%" align="center"  height="20" class="grid1" ><?=$total[1]?> <?=$currSymbol?></td>
                            </tr>
                            <tr>
                              <td width="35%" class="grid1" height="20" ><?=$ltotaff_Lead?>&nbsp;<img
                                           alt="" border="0" height="10" src="../images/lead.gif"
                                           width="10"/></td>
                              <td width="39%" align="center" height="20" class="grid1"><?=$total[3]?> <?=$currSymbol?></td>
                            </tr>
                            <tr>
                              <td width="35%" class="grid1" height="20" ><?=$ltotaff_Sale?>&nbsp;<img
                                           alt="" border="0" height="10" src="../images/sale.gif"
                                           width="10"/></td>
                              <td width="39%" align="center"  height="20" class="grid1"><?=$total[5]?> <?=$currSymbol?></td>
                            </tr>
                          <!--  <tr>
                              <td width="35%" class="grid1"><?=$ltotaff_Approved?></td>
                              <td width="39%" align="center" height="20"class="grid1"><?=$payStatus[0]?></td>
                            </tr> -->
                            <tr>
                              <td width="35%" class="grid1"><?=$ltotaff_Reversed?></td>
                              <td width="39%" align="center" height="20"class="grid1"><?=$payStatus[3]?> <?=$currSymbol?></td>
                            </tr>
                            <tr>
                              <td width="35%" class="grid1"><?=$ltotaff_Pending?></td>
                              <td width="39%" align="center" height="20"class="grid1"><?=$payStatus[1]?> <?=$currSymbol?></td>
                            </tr>
                    </table>
                       <!-- close table 3-->


                 </td>
               </tr>
              <tr>
                   <td width="100%" height="20" colspan="3">

                   </td>
              </tr>
               <tr>
                   <td width="100%" height="20" colspan="3" align="center">
                     <input type="submit" name="Suspend" value="<?=$common_suspend?>" style="width: 100" title="<?=$ltotaff_Suspend?>"/>
                   </td>
               </tr>
               <tr>
                   <td width="100%" height="20" colspan="3">

                   </td>
               </tr>
			   <tr>
                  <td width="100%" height="20" colspan="4" align="center" >


                 </td>
               </tr>
              </table>
              <!-- close table 1-->
</form>

			<?php
			}else
			{
			?>
			<table width="100%" align="center">
			<tr>
			<td align="center" class="red"><?=$norec?></td>
			<tr>
			</table>
			<?
			}
			?>
			<br />