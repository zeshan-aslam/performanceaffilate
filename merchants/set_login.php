<?php	ob_start();
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	$partners	= new partners;
	 $host       ='localhost';
   $user       ='afdbuser';
   $pass       ='tnf-@840L';
   $db         ='db_per_aff';
    $MERCHANTID =$_GET['merchant'];
   $msg="";
   $con = mysqli_connect($host,$user,$pass, $db);

   if(mysqli_connect_error())
   {
   		die("Failed to connect to MySql: ".mysqli_connect_error());
   }
	
	
	include_once 'language_include.php';
	$err		= 0;
  ?>
  <?
  $confirmpassword =$_POST['confirmpassword'];
    $newpassword =$_POST['newpassword'];
   $emailid = $_POST['emailid'];
  $mer_id =$_POST['merchant'];

if($confirmpassword==$newpassword){
	
$sql	= " UPDATE partners_login SET login_password = '".addslashes($newpassword)."', login_email='".addslashes($emailid)."' where login_id ='$mer_id'
							and login_flag='m' ";
				mysqli_query($con,$sql);
	
				echo "<p>&nbsp;</p><p>&nbsp;</p>
				<table border='0' cellpadding='0' cellspacing='0' width='96%' id='AutoNumber1' class='tablebdr'>
					<tr>
						<td width='100%' class='tdhead'>&nbsp;</td>
					</tr>
					<tr>
						<td width='100%'>
					<p align='center'><font size='5'>Email/Password Updated Successfully..!</font></td>
					</tr>
					<tr>
					<td width='100%'>
					&nbsp;</td>
					</tr>
					<tr>
					<td width='100%'>
					<p align='center'><INPUT id=button1 type=button align=middle value=close  title=$laccount_close  name=button1 LANGUAGE=javascript onclick='return button1_onclick()'></td>
					</tr>
					<tr>
					<td width='100%' class='tdhead'>
					<p align='center'>&nbsp;</td>
					</tr>
				</table> ";
				exit;
			}
			else{
				$msg= "New password and Confirm Password Should be Same !!";
							echo "<p>&nbsp;</p><p>&nbsp;</p>
				<table border='0' cellpadding='0' cellspacing='0' width='96%' id='AutoNumber1' class='tablebdr'>
					<tr>
						<td width='100%' class='tdhead'>&nbsp;</td>
					</tr>
					<tr>
						<td width='100%'>
					<p align='center'><font size='5'>$msg</font></td>
					</tr>
					<tr>
					<td width='100%'>
					&nbsp;</td>
					</tr>
					<tr>
					<td width='100%'>
					<p align='center'><INPUT id=button1 type=button align=middle value=close  title=$laccount_close  name=button1 LANGUAGE=javascript onclick='return button1_onclick()'></td>
					</tr>
					<tr>
					<td width='100%' class='tdhead'>
					<p align='center'>&nbsp;</td>
					</tr>
				</table> ";
				exit;
			}


  
?>
	<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
		function button1_onclick() {
			window.close();
		}
	</SCRIPT>
