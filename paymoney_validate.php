<?

# include all files
    include_once 'includes/db-connect.php';
	include_once 'includes/constants.php';
	include_once 'includes/functions.php';
	include_once 'includes/session.php';

# establishing connection
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

# language including
	include_once 'language_include.php';

#getting amount and payment gateway
	$modofpay   		=	trim($_POST['modofpay']);
	$amount     		=	 trim($_POST['amount']);
	$payment_method     =   $modofpay;
    $curid 				=   $_GET['id'];

    
# payment method
	include_once "pay_togateway.php";

?>
