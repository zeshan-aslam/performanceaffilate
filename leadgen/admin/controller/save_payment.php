 <?php
include('../../config.php');
if(isset($_POST['submit_pay']))
{
		$postid = isset($_GET['postid']) ? $_GET['postid'] : -1;
		$redirect_url = $_POST['redirect_url'];
	
		if($postid == -1){
		$data = array(
			'leadgen_id' => mysqli_real_escape_string($con,$_POST['username']),
			'date' => mysqli_real_escape_string($con,date('Y-m-d',strtotime($_POST['date']))),
			'amount' => mysqli_real_escape_string($con,$_POST['amount']),
			'pay_mode' => mysqli_real_escape_string($con,$_POST['pay_mode']),
			'status' => mysqli_real_escape_string($con,$_POST['status']),
			'currency_mode' => mysqli_real_escape_string($con,$_POST['currency_mode']),
			'vat_tax_number' => mysqli_real_escape_string($con,$_POST['vat_tax_number']),
			
		);
	}else{
		$data = array(
			'leadgen_id' => mysqli_real_escape_string($con,$_POST['username']),
			'date' => mysqli_real_escape_string($con,date('Y-m-d',strtotime($_POST['date']))),
			'amount' => mysqli_real_escape_string($con,$_POST['amount']),
			'pay_mode' => mysqli_real_escape_string($con,$_POST['pay_mode']),
			'status' => mysqli_real_escape_string($con,$_POST['status']),
			'currency_mode' => mysqli_real_escape_string($con,$_POST['currency_mode']),
			'vat_tax_number' => mysqli_real_escape_string($con,$_POST['vat_tax_number']),
			
		);
	}
	
	$result = insert_post($con,'addmoney',$data,'',$postid); 
	if($result){
		$leadgen_id = $_POST['username'];
		$amount = $_POST['amount'];
		$sqls = select('users',"id='$leadgen_id'");
		$rowsd = fetch($sqls);
		$balance = $rowsd['balance'] + $amount;
		mysqli_query($con, "update av_users set balance = '$balance' where id='$leadgen_id'");
		$_SESSION['successpost'] = "Page saved successfully";
		if($postid == -1){
			redirect(ADMINURL.$redirect_url.'.php');
		}else{
			redirect(ADMINURL.$redirect_url.'.php?action=edit&id='.$postid);
		}
	}else{
		$_SESSION['faliurepost'] = "Please try again";
		if($postid == -1){
			redirect(ADMINURL.$redirect_url.'.php');
		}else{
			redirect(ADMINURL.$redirect_url.'.php?action=edit&id='.$postid);
		}
		
	}
}
?>