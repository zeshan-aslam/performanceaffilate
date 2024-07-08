<?php	ob_start();
  
	include '../includes/session.php';
	include '../includes/constants.php';
	include '../includes/functions.php';
	include_once '../includes/allstripslashes.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$base        ="index.php?Act=programs";
	
	//Get Values
	$ProgramId 	= $_REQUEST['ProgramId'];  echo "program = " .$ProgramId;
	$impression = trim($_REQUEST['imprate']);
	$click		= trim($_REQUEST['click']);
	$lead		= trim($_REQUEST['lead']);
	$sale		= trim($_REQUEST['sale']);
	$clicktype	= $_REQUEST['rad_click_type']; echo "clicktype = ".$clicktype;
	$leadtype 	= $_REQUEST['rad_lead_type'];
	$saletype	= $_REQUEST['rad_sale_type'];
	
	$err  		= (empty($impression) or !is_numeric($impression)) ? 1 : 0 ;
	$err		.= (empty($click) or !is_numeric($click)) ? 1 : 0 ;
	$err		.= (empty($lead) or !is_numeric($lead)) ? 1 : 0 ;
	$err		.= (empty($sale) or !is_numeric($sale)) ? 1 : 0 ;

	$flag = bindec ($err);

	if ($flag)
	{
		$return = "admin_impr=$impression{x}admin_click=$click{x}admin_lead=$lead{x}admin_sale=$sale{x}admin_clicktype=$clicktype{x}admin_leadtype=$leadtype{x}admin_saletype=$saletype{x}";
		$return .= "programs=$ProgramId{x}";
		$return .= "flag=$flag{x}fcount=4";
		$url = $base."&return=".base64_encode($return);
	}
	else
	{
		$sql = " UPDATE partners_firstlevel SET ".
		" firstlevel_admin_impr = '".$impression."' , ".
		" firstlevel_admin_click = '".$click."' , ".
		" firstlevel_admin_clicktype = '".$clicktype."' , ".
		" firstlevel_admin_lead = '".$lead."' , ".
		" firstlevel_admin_leadtype = '".$leadtype."' ,".
		" firstlevel_admin_sale = '".$sale."' , ".
		" firstlevel_admin_saletype = '".$saletype."' , ".
		" firstlevel_admin_default = '0'  WHERE firstlevel_programid='$ProgramId' ";
		$res = mysql_query($sql);
		
		if($res) $msg = "Admin Transaction Rates Updated";
		else $msg = "Unknown Error!.  Updation Failed";
		$url = $base."&programs=$ProgramId&msg=$msg";
	}

header ("Location:$url");
exit;

	
?>