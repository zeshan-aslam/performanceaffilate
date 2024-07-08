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
            
            <form name="GetAffiliate" method="post" action="index.php?Act=waitingaff&amp;pgmid=<?=$pgmid?>">
			<div class="card stacked-form">
				<div class="card-header">
					<h5 style="display: inline-block;" class="card-title"><?=$lwaitaff_WaitingAffiliatesStaistics?></h5>
					<a style="float:right;" href="index.php?Act=programs">Back</a>
				</div>	
				<div class="card-body"> 
					<div class="row"> 
						<div class="col-md-6">
							<div class="form-group">
								<label><?=$lwaitaff_Program?>: <b><?=$pgmname?></b></label>
							</div>
						</div>
						<div class="col-md-6">
							<label><?=$lwaitaff_Affiliate?></label>
							<select name="joinid" onchange="document.GetAffiliate.submit()" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
							 <?  while($row=mysqli_fetch_object($result))
								   {
								   if($joinid=="$row->joinpgm_id")
										  $AffiliateName="selected = 'selected'";
								   else
									$AffiliateName="";
								   ?>
									 <option <?=$AffiliateName?> value="<?=$row->joinpgm_id?>"> <?=stripslashes($row->affiliate_company)?> </option>
								   <?  }  ?>
							</select> 
						</div>
					</div>
				</div>
			</div>	
			
			<div class="card strpied-tabled-with-hover">
				<div class="row">
					<div class="col-md-6">
						<div class="card-body table-full-width table-responsive">
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th colspan="2"><?=$lwaitaff_PersonalDetails?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?=$lwaitaff_Name?></td>
										<td><?=$details[0]?></td>
									</tr>
									<tr>
										<td><?=$lwaitaff_JoiningDate?></td>
										<td><?=$status[1]?></td>
									</tr>
									<tr>
										<td><?=$lwaitaff_Category?></td>
										<td><?=$details[4]?></td>
									</tr>
									<tr>
										<td><?=$lwaitaff_Company?></td>
										<td><?=$details[1]?></td>
									</tr>
									<tr>
										<td><?=$lwaitaff_SiteUrl?></td>
										<td><?=$details[2]?></td>
									</tr>						
									<tr>
										<td><?=$lwaitaff_SiteTraffic?></td>
										<td><?=$details[3]?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12 text-center">
						<div class="form-group">
							<input type="submit" name="Reject" class="btn btn-danger" onclick="return confirmDelete()" value="<?=$lwaitaff_Reject?>" />&nbsp;
                             <input type="submit" name="Approve" class="btn btn-info"  value=" <?=$lwaitaff_Approve?>"  />
						</div>	   
						<div style="margin-bottom:20px;">
							<a href='index.php?Act=programs&mode=editprogram&programId=<?=$pgmid?>'><?=$lwaitaff_ChangeProgram?></a>
						</div>
					</div>
				</div>
			</div>
			            
              <!--close table 1-->
              </form>
                <?
      }
         else
                      {
                    ?>
					<!-- table 3 Err msg-->
					<div class="card strpied-tabled-with-hover">
						<div class="row">
							<div class="col-md-12 text-center">
								<div class="card-body table-full-width table-responsive">
									<table class="table table-hover table-striped">
										<tr>
											<td><?=$norec?> </td>
										<tr>
									</table>
								</div>	
							</div>	 
						</div>
					</div> 
				<!--close 3 Err msg--> 

                     <?
                     }
                     ?>
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