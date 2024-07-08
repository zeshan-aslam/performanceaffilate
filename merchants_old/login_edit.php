<?php	ob_start();
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	
	include_once 'language_include.php';
	$err		= 0;
  ?>
	<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
		function button1_onclick() {
			window.close();
		}
	</SCRIPT>
  <?
	if(isset($B1)){
	
	if($emailid=="" || $newpassword=="" || $confirmpassword==""){
		$msg	= $laccount_err2;
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
	
				$sql	= " UPDATE partners_login SET login_password = '".addslashes($newpassword)."' where login_id ='$MERCHANTID'
							and login_flag='m' ";
				mysqli_query($con,$sql);
	
				echo "<p>&nbsp;</p><p>&nbsp;</p>
				<table border='0' cellpadding='0' cellspacing='0' width='96%' id='AutoNumber1' class='tablebdr'>
					<tr>
						<td width='100%' class='tdhead'>&nbsp;</td>
					</tr>
					<tr>
						<td width='100%'>
					<p align='center'><font size='5'>$laccount_success1</font></td>
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
				$msg	= "New password and Confirm Password Should be Same !!";
			}
		}
		else{
			if($newpassword==$confirmpassword){
				$sql    = " select * from partners_login where login_email='".addslashes($emailid)."'";
				$result = mysqli_query($con,$sql);
				if(mysqli_num_rows($result)>0){
					$msg	= $lang_EmailIdAlreadyExist;
				}
				else{
	
					$sql	= " UPDATE partners_login SET login_email = '".addslashes($emailid)."',
					login_password = '".addslashes($newpassword)."' where login_id ='$MERCHANTID' and login_flag='m'";
					mysqli_query($con,$sql);
	
					echo "<p>&nbsp;</p><p>&nbsp;</p>
					<table border='0' cellpadding='0' cellspacing='0' width='96%' id='AutoNumber1' class='tablebdr'>
					<tr>
					<td width='100%' class='tdhead'>&nbsp;</td>
					</tr>
					<tr>
					<td width='100%'>
					<p align='center'><font size='5'>$laccount_success1</font></td>
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
			}
			else{
				$msg	= $laccount_err1	;
			}
	
		}
	
	}
	
	}

	else{
		$msg	= "";
		$sql    = " select * from partners_login where login_id ='$MERCHANTID' and login_flag='m'";
		$result = mysqli_query($con,$sql);
		
		while($row=mysqli_fetch_object($result)){
			$emailid	= $row->login_email;
			$origin		= $row->login_email;
			$oldpassword= $row->login_password;
		}
	}
?>


<html> <title><?=$laccount_LoginInfoEdit?></title>
<link rel="stylesheet" type="text/css" href="style.css">
<body style="background-color:#FFFFFF; background-image:url(images/white.jpg); background-repeat:repeat; margin-top:25px">
<form method="POST" action="" >

<table border="0" cellpadding="0" cellspacing="0" width="72%" id="AutoNumber1" height="129" class="tablebdr" align="center">
	<tr>
		<td width="100%" colspan="4" height="19" class="tdhead" align="center"><b><?=$laccount_LoginInfoEdit?></b></td>
	</tr>
	<tr>
		<td width="100%" height="22" colspan="4" class="textred" align="center"><?=$msg?>&nbsp;</td>
	</tr>
    <tr>
      <td width="2%" height="22">&nbsp;</td>
      <td width="48%" height="22"><?=$laccount_EmailId?></td>
      <td width="48%" height="22"><input type="text" name="emailid" size="27" value=<?=$emailid?> ></td>
      <td width="2%" height="22">&nbsp;</td>
      <input name="origin" type="hidden" value=<?=$origin?>>
    </tr>
    <tr>
      <td width="2%" height="22">&nbsp;</td>
      <td width="48%" height="22"><?=$laccount_OldPassword?></td>
      <td width="48%" height="22">
      <input type="password" name="oldpassword" size="27" value=<?=$oldpassword?> ></td>
      <td width="2%" height="22">&nbsp;</td>
    </tr>
    <tr>
      <td width="2%" height="22">&nbsp;</td>
      <td width="48%" height="22"><?=$laccount_NewPassword?></td>
      <td width="48%" height="22">
      <input type="password" name="newpassword" size="27"></td>
      <td width="2%" height="22">&nbsp;</td>
    </tr>
    <tr>
      <td width="2%" height="19">&nbsp;</td>
      <td width="48%" height="19"><?=$laccount_ConfirmPassword?></td>
      <td width="48%" height="19">
      <input type="password" name="confirmpassword" size="27"></td>
      <td width="2%" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" colspan="4" height="20">&nbsp;</td>
    </tr>
    <tr>
      <td width="49%" colspan="2" height="28" align="center">
     <input type="submit" value="<?=$common_edit?>" name="B1" title=<?=$laccount_Edit?>></td>
      <td width="51%" colspan="2" height="28" align="center">
      <INPUT id="button1" type="button" align="middle" value="close" title="<?=$laccount_close?>" name="button1" LANGUAGE=javascript onClick="return button1_onclick()"></td>
    </tr>
  </table>
</form>
</body>
</html>