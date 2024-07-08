<?php
include('../config.php');
$email = $_POST['av_email'];
if(isset($_POST['sign_in'])){
	global $con;
	
	 
	

	//$sql    = select('',"email = '$email'");
	
	$query = "select * from av_users where email = '$email'";
	$result = query($con,$query,1);	
	if($result){
		
		$sqldb = select("users","email = '$email'");
							
							while($rowdb = fetch($sqldb)){
								$userid = $rowdb['id'];
								
								
							}
		
		
		      $to =  $email;
			 // $sqlmail = select("adminmail","adminmail_id='1'");
			  //$row           = mysqli_fetch_object($sqlmail);
			 // $sub           = stripslashes($row->adminmail_subject);
			  //$message       = stripslashes($row->adminmail_message);
			  //$head          = stripslashes($row->adminmail_header);
			 // $footer        = stripslashes($row->adminmail_footer);
			 
			 
			 
			$message  =     "Click this <a href='https://avaz.co.uk/leadgen/confirmlink.php?id=$userid'>Link</a> to reset your password.";
			$from          = "info@avazai.com";
			$subject       = "Reset Your Avazai Login Password";

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
			$body.="<td width='100%' align='left'>$message</td>";
					
			
			$body.="</tr>";

			$body.="</table>";
			$body.="</td>";
			$body.="</tr>";
			$body.="</table>";
		
			 $success = mail($to,$subject,$body,$headers);
		
		$_SESSION['failurer'] = "Reset password sent link on your email";
		redirect(SITEURL.'forget.php'.$slug);
		
		
	}else{
		
		
		$_SESSION['failurer'] = "Email Is Not Exists";
		redirect(SITEURL.'forget.php'.$slug);
	}
	
	
	
	
}


?>


