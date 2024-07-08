<?php
include('../config.php');
if(isset($_POST['join_avaz'])){
	unset($_POST['join_avaz']);
	$fields = array(
		'email' => $_POST['av_email'],
		'date' => date('Y-m-d h:i:s'),
		'status' => 1,
		'type' => 2,
	);
	$lastinsert_id = insert('users', $fields);
	if($lastinsert_id){
		foreach($_POST as $key => $val){
			$ok = update_user_meta($lastinsert_id,$key,$val);
		}
		$_SESSION['success'] = "Data Saved successfully.";
		redirect(SITEURL);
	}else{
		$_SESSION['failure'] = mysqli_error($con);
		redirect(SITEURL);
	}
}
?>