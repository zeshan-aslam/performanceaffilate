<?php 
include('config.php');
$joinid = isset($_GET['joinid']) ? $_GET['joinid'] : '';
$sql = select("joinavaz","companyid = '$joinid' order by date DESC"); 
$csv_trans = "Submissions Report \r\n";
$csv_trans .= "First Name,Last Name,Post Code,Email,Phone Number,Confirmed,Date Recieved,Question,Answers \r\n";
while($row = fetch($sql)){ 
$questions = '';
$av_question1res = get_avaz_info($row['id'],'av_question1res',true);
$av_question2res = get_avaz_info($row['id'],'av_question2res',true);
$res1 = unserialize($av_question1res);
$res2= unserialize($av_question2res);
$is_confirmed = '';
if(get_avaz_info($row['id'],'is_confirmed',true) == 1){
	$is_confirmed = 'confirmed';
}else if(get_avaz_info($row['id'],'is_confirmed',true) == 2){
	$is_confirmed = 'cancelled';
}
foreach($res1 as $key => $val){
	$ques = '';
	if($key !=0 || $key !=''){
		$ques = $key;
	}
	$questions .= $ques.','.$val.',';
	
}
foreach($res2 as $key1 => $val1){
	$ques = '';
	if($key1 !=0 || $key1 !=''){
		$ques = $key1;
	}
	$questions .= $ques.','.$val1.',';
	
}
	$csv_trans .= get_avaz_info($row['id'],'first_name',true).",".get_avaz_info($row['id'],'sur_name',true).",".get_avaz_info($row['id'],'av_post_code',true).",".get_avaz_info($row['id'],'av_email',true).",".get_avaz_info($row['id'],'av_phone',true).",".$is_confirmed.",".date('Y-m-d',strtotime($row['date'])).",".rtrim($questions,',')." \r\n";
}

$fileName =	$joinid."_leadgen_submissionsform.csv";
$fp = fopen( ROOT."/reports/".$fileName,"w");
fwrite($fp,$csv_trans);
fclose($fp);
$newFile	= 	$fileName;
$path		=	ROOT."/reports/".$newFile;

header("Pragma: public");
header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: application/force-download");
header('Content-Disposition: attachment; filename="'.$newFile.'"');
header("Content-Transfer-Encoding: binary");
header('Content-Length: '.@filesize($path));
set_time_limit(0);
@readfile($path) OR die("file not found");

	unlink($path);

	exit;
?>