<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  adminuser_edit.php                             */
/*     CREATED ON     :  10/JULY/2006                                   */

/*	Page to edit admin user. 											*/
/************************************************************************/

	$adminobj 	= new adminuser();
	
	$note 		= $_REQUEST['msg'];
	$username   = $_REQUEST['username'];
	$password	= $_REQUEST['txt_password'];
	$email		= $_REQUEST['email'];
	$id			= intval($_REQUEST['id']);
	
	if($id)
	{
		if($adminobj->GetAdimUserDetails($id))
		{
			$username   = $adminobj->username;
			$password	= $adminobj->password;
			$email		= $adminobj->email;
		}
	}
?>
<form name="frm_users" method="post" action="adminusers_manage.php?mode=edit" onSubmit="javascript:return Validate();">
	<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="65%" align="center">
		 <tr>
		 	<td align="center" colspan="2" class="tdhead"><b>Edit Admin User</b></td>
		 </tr>
		 <tr><td height="10"></td></tr>
		 <? if($note) { ?>
		 <tr><td colspan="2" align="center" class="textred"><?=$note?></td></tr>
		 <? } ?>
		 <tr>
		 	<td height="30" align="right" width="50%">Username&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td height="30" align="left" width="50%"><input type="text" name="txt_username" maxlength="25" value="<?=$username?>" /></td>
		 </tr>
		 <tr>
		 	<td height="30" align="right" width="50%">Password&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td height="30" align="left" width="50%"><input type="text" name="txt_password" maxlength="25" value="<?=$password?>" /></td>
		 </tr>
		 <tr>
		 	<td height="30" align="right" width="50%">Email&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td height="30" align="left" width="50%"><input type="text" name="txt_email" value="<?=$email?>" /></td>
		 </tr>
		 <tr>
		 	<td height="30" align="center" colspan="2">Send Mail to Admin User&nbsp;<input type="checkbox" name="chk_mail" /></td>
		 </tr>
		 <tr>
		 	<td height="30" align="center" colspan="2"><input type="submit" name="btn_update" value="Update" />
				<input type="hidden" name="id" value="<?=$id?>" />
			</td>
		 </tr>
	</table>
</form>

<script language="javascript">
	function Validate()
	{
		if(document.frm_users.txt_username.value == '')
		{
			alert('Please enter the username');
			document.frm_users.txt_username.focus();
			return false;
		}
		if(document.frm_users.txt_password.value == '')
		{
			alert('Please enter the password');
			document.frm_users.txt_password.focus();
			return false;
		}
		if(document.frm_users.txt_email.value == '')
		{
			alert('Please enter the Email Address');
			document.frm_users.txt_email.focus();
			return false;
		}
		return true;		
	}
</script>
