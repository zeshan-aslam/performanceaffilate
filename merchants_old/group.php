<?php
	include "transactions.php";
	$MERCHANTID		= $_SESSION['MERCHANTID']; //merchantid
	$programs		= intval(trim($_POST['programs'])); // programid
	$groupid		= trim($_POST['group']);
	$mod			= trim($_GET['mode']);

	# removing and adding to group
	if($mode=="add" and $_POST['affiliatelist']!=""){
		while (list ($key, $val) = each ($_POST['affiliatelist'])){
			# echo "$val ,$programs,$groupid\n";
			$sql	= " UPDATE partners_joinpgm SET joinpgm_group = '$groupid' WHERE joinpgm_programid = '$programs' 
						and joinpgm_affiliateid='$val'";
			mysqli_query($con,$sql);
			echo mysqli_error($con);
		}
	
	}
	if($mode=="remove" and $_POST['grouplist']!="")
      {

             while (list ($key, $val) = each ($_POST['grouplist']))
	        {
	                //echo "$val ,$programs,$groupid\n";
                    $sql="UPDATE partners_joinpgm SET joinpgm_group = 'nill' WHERE joinpgm_programid = '$programs' and joinpgm_affiliateid='$val'";
					mysqli_query($con,$sql);
                    echo mysqli_error($con);
	        }
      }

///////////////////// removing and adding  ends here.








  if (empty($programs))
       $programs="All";
  else
      $_SESSION['PGMID']=$programs;


       // data to add to dropdown box
  $sql        ="SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
  $result     =mysqli_query($con,$sql);

  switch ($programs)//checking program
      {
       case 'All';    //all pgm

           $gsql		="select * from partners_group where group_merchantid='$MERCHANTID' " ;
           $pgmid        =0;
           break;

       default:    //selected pgm
           $gsql		 ="select * from partners_group where  group_programid ='$programs'";
           $pgmid        =$programs;
           break;
      }

      $gresult     =mysqli_query($con,$gsql);



      /////// members and non members display

      if($groupid!="All" and $groupid!="")
      {
       		$groupid;
            $programs;

            $msql="SELECT  * FROM partners_joinpgm, partners_affiliate
					WHERE joinpgm_programid ='$programs' AND joinpgm_group =  '$groupid'  AND joinpgm_status =  'approved'
               		AND ( partners_joinpgm.joinpgm_affiliateid = partners_affiliate.affiliate_id )";

            $asql="SELECT  * FROM partners_joinpgm, partners_affiliate
					WHERE joinpgm_programid ='$programs' AND joinpgm_group <> '$groupid'  AND joinpgm_status =  'approved'
               		AND ( partners_joinpgm.joinpgm_affiliateid = partners_affiliate.affiliate_id )";

           $mresult     =mysqli_query($con,$msql);
           $aresult     =mysqli_query($con,$asql);

           echo mysqli_error($con);

           $mem= mysqli_num_rows($mresult);
           $affil= mysqli_num_rows($aresult);


      }


?>
<table border="0" cellpadding="0" cellspacing="0" width="70%" id="AutoNumber1" align="center" class="tablebdr">
	<tr>
		<td width="98%" height="19" align="center" class="tdhead" >
		<a href="index.php?Act=add_group"><strong><?=$lgroup_AddNewGroup?></strong></a></td>
	</tr>
	<tr>
		<td width="98%" height="191" align="center">
		<form method="post" name="f1" action="">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" id="AutoNumber2" >
			<tr>
			<td width="100%" height="28" colspan="3"> <b>&nbsp;&nbsp;<?=$lgroup_Program?></b>
			<select name="programs" onchange="document.f1.action='index.php?Act=group';document.f1.submit()">
				<option value="All" ><?=$lgroup_SelectAProgram ?></option>
			<?  
				while($row=mysqli_fetch_object($result)){
					if($programs=="$row->program_id")
						$programName = "selected = 'selected'";
					else
						$programName = "";
			?>
					<option <?=$programName?> value="<?=$row->program_id?>">
						<?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> 
					</option>
			<?
				}
			?>
			</select>&nbsp;&nbsp; <b><?=$lgroup_Group?></b>
			
			<select name="group" onchange="document.f1.action='index.php?Act=group';document.f1.submit()">
				<option value="All" ><?=$lgroup_SelectAGroup ?></option>
			<?  
				while($row=mysqli_fetch_object($gresult)){
					if($groupid=="$row->group_id")
						$programName	= "selected = 'selected'";
					else
						$programName	= "";
			
			?>
					<option <?=$programName?> value="<?=$row->group_id?>">
						<?=stripslashes($row->group_name)?> 
					</option>
			<?
				}
			?>
			</select></td>
			</tr>
			<tr>
				<td width="100%" height="1" class="grid1" colspan="3" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td width="39%" height="82" rowspan="5" class="grid1">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" id="AutoNumber3" class="grid1">
				<tr>
				<td width="97%" height="82" colspan="2" rowspan="5" align="center">
				<fieldset style="width: 116; height: 118; padding: 2">
				<legend ><b><?=$lgroup_Affiliates?> <img src="../images/head.gif" width="15" height="15" alt="" /></b></legend>
				<?  
				if($affil!=0){
					?>
					<select size="4" name="affiliatelist[]" multiple="multiple" class="selectMulti">
					<?  
						while($row=mysqli_fetch_object($aresult)){
						?>
						<option  value="<?=$row->joinpgm_affiliateid?>"> 
							<?=stripslashes($row->affiliate_company)?> 
						</option>
					<?
						}
					?>
					</select>
					<?
				} 
				else{
				?>
					<h5 class="textred" align="center" ><?=$lgroup_Thereisnoonetojoin?> ...</h5>
				<?
				}
				?>
				</fieldset> </td>
				<td width="3%">&nbsp;</td>
				</tr>
				</table> </td>
			<td width="23%" height="23" class="grid1">&nbsp;</td>
			<td width="39%" height="82" rowspan="5" class="grid1">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" id="AutoNumber4" class="grid1">
			<tr>
			<td width="3%"> </td>
			<td width="97%" height="82" colspan="2" rowspan="5" valign="top">
			<fieldset style="width: 116; height: 118; padding: 2">
			<legend>
			<b><?=$lgroup_Members?> <img src="../images/head.gif" width="10" height="10" alt="" /><img src="../images/head.gif" width="15" height="15" alt="" /><img src="../images/head.gif" width="12" height="12" alt="" /></b></legend>
			<?   if($mem!=0){
			?>
			<select size="4" name="grouplist[]" multiple="multiple"  class="selectMulti" >
			<?  while($row=mysqli_fetch_object($mresult)){
			?>
				<option  value="<?=$row->joinpgm_affiliateid?>"> <?=stripslashes($row->affiliate_company)?> </option>
			<?
			}
			?>
			</select>
			<?
			} //closing of if
			else{
			?>
			<h5 class="textred" align="center" ><?=$lgroup_ThereisnoMembersonthisgroup?> ...</h5>
			<?
			}
			?>
			</fieldset></td>
			</tr>
			</table>              </td>
			</tr>
		<tr>
		<td width="23%" height="2" class="grid1" align="center">&nbsp;<input type="button" name="remove"  value="<?=$lgroup_Add?>" onclick="document.f1.action='index.php?Act=group&amp;mode=add';document.f1.submit()" /></td>
		</tr>
		<tr>
			<td width="23%" height="19" class="grid1">&nbsp;</td>
		</tr>
		<tr>
		<td width="23%" height="19" class="grid1" align="center">
		&nbsp;<input type="button" name="remove" value="<?=$lgroup_Remove?>" onclick="document.f1.action='index.php?Act=group&amp;mode=remove';document.f1.submit()" />&nbsp;              </td>
		</tr>
	<tr>
	<td width="23%" height="19" class="grid1">&nbsp;</td>
	</tr>
	<tr>
	<td height="35" colspan="3" align="center">
	<b><?=$lgroup_FormultipleselectionCtrlclickonList?></b></td>
	</tr>
	</table>
	</form>      </td>
	</tr>
	<tr>
	<td width="98%" height="19">     </td>
	</tr>
	<tr>
	<td width="98%" height="19">&nbsp;</td>
	</tr>
	</table>
