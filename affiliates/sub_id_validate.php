<?php		

	include_once '../includes/db-connect.php';
	//include files
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	include_once '../includes/allstripslashes.php';
	include_once 'language_include.php';
	
	//database connection
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	//get value
	$subid	= $_POST['txt_subid'];
	$id		= intval($_POST['id']);
	$mode	= $_GET['mode'];
	
	//if delete
	if($mode=="delete")
	{
		//get the subid
		$sql = "SELECT sub_subid FROM partners_sub_id WHERE sub_id = '".intval($_GET['id'])."' ";
		$res = mysqli_query($con,$sql);
		if($row = mysqli_fetch_object($res)) $subid = $row->sub_subid;
		
		//make the sub id to null for all those transaction records which are under this sub id
		$sql = "UPDATE partners_transaction SET transaction_subid = '' WHERE transaction_subid = '$subid'";
		mysqli_query($con,$sql);
	
		//delete
		$sql = "DELETE FROM partners_sub_id WHERE sub_id = '".intval($_GET['id'])."' ";
		mysqli_query($con,$sql);
		$msg = urlencode($lang_subid_del_msg);
		header("location:index.php?Act=sub_id_list&msg=$msg");
		exit;		
	}
	
	//null validation
	if(empty($subid))
	{
		$msg = urlencode($lang_subid_null_msg);
		header("location:index.php?Act=sub_id_list&msg=$msg");
		exit;
	}
	
	//check max length
	if(strlen($subid)>50)
	{
		$msg = urlencode($lang_subid_max_msg);
		header("location:index.php?Act=sub_id_list&msg=$msg");
		exit;	
	}
	
	//check whether already exists
	/*$sql = "SELECT * FROM partners_sub_id WHERE sub_subid = '".addslashes($subid)."' "; //AND sub_affiliateid = ".$_SESSION[AFFILIATEID];
	if(!empty($id)) $sql .= " AND sub_id  <> '".$id."' ";
	$res = mysqli_query($con,$sql);
	if(mysqli_num_rows($res))
	{
		$msg = urlencode($lang_subid_dupl_msg);
		header("location:index.php?Act=sub_id_list&msg=$msg");
		exit;	
	}*/
	
	//if edit
	if(!empty($id))
		//edit sub id
		$sql = "UPDATE partners_sub_id SET sub_subid = '".addslashes($subid)."' WHERE sub_id = ".$id;
	else
		//add sub id
		$sql = "INSERT INTO partners_sub_id SET sub_subid = '".addslashes($subid)."', sub_affiliateid = ".$_SESSION[AFFILIATEID];
	mysqli_query($con,$sql);
	
	$msg = urlencode($lang_subid_success_msg);
	header("location:index.php?Act=sub_id_list&msg=$msg");
	exit;
?>