<?php	ob_start();

  	include_once '../includes/constants.php';
  	include_once '../includes/functions.php';
  	include_once '../includes/session.php';
   	include_once '../includes/allstripslashes.php';
    include	'lang/english.php';

	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';
	$err		= 0;

  ?>
    <SCRIPT LANGUAGE=javascript type="text/javascript">
		function button1_onclick() {
			window.close();
		}
	</SCRIPT>
  <?
	if(isset($B1)){
		if($emailid=="" || $newpassword=="" || $confirmpassword==""){
			$msg	= $lang_account_blank ;
			$err	= 1;
		}
	
		if($partners->is_email($emailid)==0){
			$msg	= $emailerr;
			$err	= 1;
		}
	
		if($err==0){
			$emailid;
			if($origin==trim($emailid)){
				if($newpassword==$confirmpassword){
					$newpassword	= addslashes($newpassword);
					$sql	= " UPDATE partners_login SET login_password = '$newpassword' 
								where login_id ='$_SESSION[AFFILIATEID]' and login_flag='a'";
					mysqli_query($con,$sql);
		
					echo "<p>&nbsp;</p><p>&nbsp;</p>
					<table border='0' cellpadding='0' cellspacing='0' width='96%' id='AutoNumber1' class='tablebdr'>
					<tr>
					<td width='100%' class='tdhead'>
					&nbsp;</td>
					</tr>
					<tr>
					<td width='100%'>
					<p align='center'><font size='5'>$lang_pass_success</font></td>
					</tr>
					<tr>
					<td width='100%'>
					&nbsp;</td>
					</tr>
					<tr>
					<td width='100%'>
					<p align='center'>
					<INPUT id=button1 type=button align=middle value=close name=button1 LANGUAGE=javascript onclick='return button1_onclick()'></td>
					</tr>
					<tr>
					<td width='100%' class='tdhead'>
					<p align='center'>&nbsp;</td>
					</tr>
					</table> ";
					exit;
				}
				else{
					$msg = $pass_mismatch;
				}
			}
			else{
				if($newpassword==$confirmpassword){
					$sql    = "select * from partners_login where login_email='$emailid'";
					$result = mysqli_query($con,$sql);
					if(mysqli_num_rows($result)>0){
						$msg=    $lang_EmailIdAlreadyExist;
					}
					else{
						$sql	= " UPDATE partners_login SET login_email = '$emailid',	login_password = '$newpassword' 
									where login_id ='$_SESSION[AFFILIATEID]' AND login_flag='a'";
						mysqli_query($con,$sql);
						echo "<p>&nbsp;</p><p>&nbsp;</p>
						<table border='0' cellpadding='0' cellspacing='0'  width='96%' id='AutoNumber1' class='tablebdr'>
						<tr>
						<td width='100%' class='tdhead'>
						&nbsp;</td>
						</tr>
						<tr>
						<td width='100%'>
						<p align='center'><font size='5'>$lang_pass_success</font></td>
						</tr>
						<tr>
						<td width='100%'>
						&nbsp;</td>
						</tr>
						<tr>
						<td width='100%'>
						<p align='center'><INPUT id=button1 type=button align=middle value=close name=button1 LANGUAGE=javascript onclick='return button1_onclick()'></td>
						</tr>
						<tr>
						<td width='100%' class='tdhead'>
						<p align='center'>&nbsp;</td>
						</tr>
						</table> ";
						exit;
					}
		
				}
				else{
					$msg	= $pass_mismatch;
				}
		
			}
		
		}
	
	}
	else{
		$msg	= "";
		$sql    = "select * from partners_login where login_id ='$_SESSION[AFFILIATEID]' and login_flag='a'";
		$result = mysqli_query($con,$sql);
		
		while($row=mysqli_fetch_object($result)){
			$emailid	= $row->login_email;
			$origin		= $row->login_email;
			$oldpassword= $row->login_password;
		}
	}

?>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<body style="background-color:#FFFFFF; background-image:url(images/white.jpg); background-repeat:repeat;">
<title><?=$logine_edit?></title>

<form method="POST" action="" >
<table border="0" cellpadding="0" cellspacing="0" width="80%" id="AutoNumber1" class="tablebdr" align="center">
    <tr>
      <td colspan="4" height="19" class="tdhead" align="center"><b><?=$lang_LoginInfoEdit?></b></td>
    </tr>
    <tr>
      <td height="22" colspan="4" class="textred" align="center"><?=$msg?></td>
    </tr>
    <tr height="28">
      <td width="7%">&nbsp;</td>
      <td width="30%"><?=$lang_EmailId?></td>
      <td width="54%"><input type="text" name="emailid" size="27" value=<?=$emailid?> ></td>
      <td width="9%">&nbsp;</td>
      <input name="origin" type="hidden" value=<?=$origin?>>
    </tr>
    <tr height="28">
      <td width="7%">&nbsp;</td>
      <td width="30%"><?=$lang_OldPassword?></td>
      <td width="54%">
      <input type="password" name="oldpassword" size="27" value=<?=$oldpassword?> ></td>
      <td width="9%">&nbsp;</td>
    </tr>
    <tr height="28">
      <td width="7%">&nbsp;</td>
      <td width="30%"><?=$lang_NewPassword?></td>
      <td width="54%">
      <input type="password" name="newpassword" size="27"></td>
      <td width="9%">&nbsp;</td>
    </tr>
    <tr height="28">
      <td width="7%" >&nbsp;</td>
      <td width="30%" ><?=$lang_ConfirmPassword?></td>
      <td width="54%" >
      <input type="password" name="confirmpassword" size="27"></td>
      <td width="9%" >&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" height="20">&nbsp;      </td>
    </tr>
    <tr>
      <td colspan="2" height="28" >
      <p align="center"><input type="submit" value="<?=$common_edit?>" name="B1" title="<?=$lang_Edit?>"></td>
      <td colspan="2" height="28" >
      <p align="center"><INPUT type="button" value="<?=$lang_close?>" name="button1" onClick="return button1_onclick()"></td>
    </tr>
  </table>
</form>
</body>
</html>