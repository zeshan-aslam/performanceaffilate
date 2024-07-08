<?php
	include "transactions.php";
	include "../mail.php";
	
	$MERCHANTID                                =$_SESSION['MERCHANTID'];   //merchantid
	$id                                        =trim($_POST['joinid']);    //joinid
	$id                                        =explode("~",$id);
	$joinid                                    =$id[0];
	$rid                                       =$id[1];
	$mode                                      =($_SERVER['REQUEST_METHOD'] == "POST" ? 1 : "");     //get input type
	
	if($mode){
	if(trim($_POST['Approve'])){     //approve affiliate
		$sql	= " update partners_rotatorsta set rotatorsta_status='approved' where rotatorsta_id='$id[1]' ";
		mysqli_query($con,$sql);
		GetTotalPro($joinid,$MERCHANTID) ;
	}
	
	if(trim($_POST['Reject'])){          //reject affiliate
		$sql	= " update partners_rotatorsta set rotatorsta_status='suspend' where rotatorsta_id='$id[1]'  ";
		mysqli_query($con,$sql);
	}
	
	if(trim($_POST['change'])){         //change program
		header("Location:index.php");
		exit();
	}
}

		//adding to drop down box
		$sql		= " select * from partners_rotatorsta, partners_rotator, partners_affiliate  
						where rotatorsta_merid='$MERCHANTID' AND rotator_id=rotatorsta_roid AND rotator_affilid=affiliate_id ";
		$result     = mysqli_query($con,$sql);
		$result1    = mysqli_query($con,$sql);

  //if records found
  //checking for records
	if (mysqli_num_rows($result1)>0){ 
		$rows	= mysqli_fetch_object($result1);
		$id		= $rows->rotator_affilid;
		$rid 	= $rows->rotatorsta_id;
		
		if (empty($joinid)){ // for first time
			$joinid		= $id;
			$rid		= $rows->rotatorsta_id;
			$pgmid		= $rows->joinpgm_programid;
		}

		# getting affilaite details
		$status		= GetAffiliateStatus1($rid); // get affiliates details (join date)from transactions.php
		$status 	= explode('~',$status);
		$details 	= GetAffiliateDetails1($joinid);  // get affiliates details from transactions.php
		$details    = explode('~',$details);
		
		?>
		<br/>
<form name="GetAffiliate" method="post" action="index.php?Act=waitrotator">

	<table border="0" cellpadding="0" cellspacing="0"  width="70%" align= "center"class="tablebdr" >
		<tr>
			<td width="100%" class="tdhead" colspan="2" align="center"><b><?=$lang_rtr_AffiliatesStaistics?></b></td>
		</tr>
		<tr>
			<td width="70%" height="30" align="right" ><b><?=$lang_rtr_Affiliate?></b>
			<select name="joinid" onchange="document.GetAffiliate.submit()">
			<?  
			while($row=mysqli_fetch_object($result)){
				if($joinid=="$row->rotator_affilid")
					$AffiliateName	= "selected = 'selected'";
				else 
					$AffiliateName	= "";
			
			?>
				<option <?=$AffiliateName?> value="<?=$row->rotator_affilid."~".$row->rotatorsta_id?>"> 
					PgmID=<?=$row->rotatorsta_id?>&nbsp;<?=stripslashes($row->rotator_affilid)?> 
				</option>
			<?
			}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td width="80%" align="center" colspan="3" ><br/>
			<table border="0" cellpadding="0"  width="80%" class="tablebdr" >
				<tr>
					<td width="100%" colspan="2" class="tdhead"><b><?=$lang_rtr_PersonalDetails?></b></td>
				</tr>
				<tr>
					<td width="50%" height="20" class="grid1"><?=$lang_rtr_Name?></td>
					<td width="50%" height="20" class="grid1"><?=$details[0]?></td>
				</tr>
				<tr>
					<td width="50%" height="20" class="grid1"><?=$lang_rtr_JoiningStatus?></td>
					<td width="50%" height="20" class="grid1"><?=$status[0]?></td>
				</tr>
				<tr>
					<td width="50%" height="20" class="grid1"><?=$lang_rtr_Category?></td>
					<td width="50%" height="20" class="grid1"><?=$details[4]?></td>
				</tr>
				<tr>
					<td width="50%" height="20" class="grid1"><?=$lang_rtr_Company?></td>
					<td width="50%" height="20" class="grid1"><?=$details[1]?></td>
				</tr>
				<tr>
					<td width="50%" height="20" class="grid1"><?=$lang_rtr_SiteUrl?></td>
					<td width="50%" height="20" class="grid1"><?=$details[2]?></td>
				</tr>
				<tr>
					<td width="50%" height="20" class="grid1"><?=$lang_rtr_SiteTraffic?></td>
					<td width="50%" height="20" class="grid1"><?=$details[3]?></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td width="100%" height="20" colspan="3" align="center">&nbsp;</td>
		</tr>
		
		<tr>
			<td width="100%" height="20" colspan="3" align="center">
			<input type="submit" name="Reject" value="<?=$common_reject?>" style="width: 100" onclick="return confirmDelete()" />
			<input type="submit" name="Approve" value="<?=$common_approve?>" style="width: 100" /></td>
		</tr>
	</table>
</form>
	<?
	}
	else{
	?>
		<table width="100%" align="center">
			<tr><td align="center" class="red"><?=$norec?></td><tr>
		</table>
	<?
	}
?>
<br />
<script language="javascript" type="text/javascript">

   function confirmDelete(){
	   var del	= window.confirm("<?=$lang_rtr_Suspend?> ") ;
	   if (del)
		  return true;
	   else
		  return false;
   }

</script>