<?php
include('../../config.php');
if(isset($_POST['is_campaign'])){
	global $con;
	$userid = $_POST['userid'];
	
	$approvests = $_POST['av_campaign_status'];
	//$email = $_POST['email'];
	
	
	

	
	$av_campaignarray = unserialize(get_user_info($userid,'av_campaign',true));
	if(isset($_POST['av_campaign']) && $_POST['av_campaign'] != ''){
		$av_campaign = $_POST['av_campaign'];
	
	if(!in_array($av_campaign, $av_campaignarray)){
		$av_campaignarray[] = $av_campaign;
	}else{
		$_SESSION['failuireuser'] = "Campaigns already assigned to users.";
		redirect(ADMINURL.'user-view.php?action=view&uid='.$userid);
		exit;
	}
	}
	$avcamp = serialize($av_campaignarray);
	$data = array(
		'av_campaign_status' => $_POST['av_campaign_status'],
		'monthly_license_fee' => $_POST['monthly_license_fee'],
		'av_Currency' => $_POST['av_Currency'],
		'av_campaign' => $avcamp,
	);
	foreach($data as $key => $val){
		$vals = mysqli_real_escape_string($con,$val);
		$keys = mysqli_real_escape_string($con,$key);
		$success = update_user_meta($userid,$keys,$vals);	
	}
	
	if($success){
		$_SESSION['successuser'] = "Your Record is successfully saved";
		redirect(ADMINURL.'user-view.php?action=view&uid='.$userid);
		
		if($approvests == 'approve')
		{
			
			  $to =  $_POST['email'];
			  $sqlmail = select("adminmail","adminmail_id='1'");
			  $row           = mysqli_fetch_object($sqlmail);
			  $sub           = stripslashes($row->adminmail_subject);
			  $message       = stripslashes($row->adminmail_message);
			  $head          = stripslashes($row->adminmail_header);
			  $footer        = stripslashes($row->adminmail_footer);
			  $from          = stripslashes($row->adminmail_from);
			  $subject       = $sub;

			$headers    =  "Content-Type: text/html; charset=iso-8859-1\n";
			$headers   .=  "From: $from\n";

			$body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
			$body.="<tr>";
			$body.="<td width='100%' align='center' valign='top'><br/>";
			$body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";

			$body.="<tr>";
			$body.="<td  width='100%' align='center'> </td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td  width='100%' align='left'> $head</td>";
			$body.="</tr>";

			$body.="<tr>";
			$body.="<td  width='100%' align='left'>&nbsp;</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td width='100%' align='left'>$message";
			$body.="</td></tr>";
			$body.="<tr>";
			$body.="<td width='100%' align='left'>";
			$body.="</td></tr>";
			$body.="<tr>";
			$body.="<td  width='100%' align='left'>&nbsp;</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td  width='100%' align='left'>$footer</td>";
			$body.="</tr>";
			$body.="<tr>";
			$body.="<td  width='100%' align='center'></td>";
			$body.="</tr>";

			$body.="</table>";
			$body.="</td>";
			$body.="</tr>";
			$body.="</table>";
		
			 $success = mail($to,$subject,$body,$headers);
			
		}
		else
		{
			
			
			
		}
			
		
		
		
	}else{
		$_SESSION['failuireuser'] = "Please try again.";
		redirect(ADMINURL.'user-view.php?action=view&uid='.$userid);
	}
}
?>