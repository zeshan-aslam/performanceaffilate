<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  adminusers.php                                 */
/*     CREATED ON     :  10/JULY/2006                                   */

/*	Page to create new admin user.  Displays all existing admin users other
	 than super Admin.  Provides links to Edit, Delete & Set Privilege  */
/************************************************************************/

	$adminobj 	= new adminuser();
	
	$note 		= $_REQUEST['msg'];
	$username   = $_REQUEST['txt_username'];
	$password	= $_REQUEST['txt_password'];
	$email		= $_REQUEST['txt_email'];
?>
<form name="frm_users" method="post" action="adminusers_manage.php" onSubmit="javascript:return Validate();">
	<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="65%" align="center">
		 <tr>
		 	<td align="center" colspan="2" class="tdhead"><b>Add New Admin User</b></td>
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
		 	<td height="30" align="center" colspan="2"><input type="submit" name="btn_add" value="Add" /></td>
		 </tr>
	</table>
	<br/>
	<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="95%" align="center">
		<tr>
			<td align="center" class="tdhead" colspan="6"><b>Existing Admin Users</b></td>
		</tr>
		<tr><td colspan="6">&nbsp;</td></tr>
		<?
		$result = $adminobj->getAllAdminUsers();
		if($result) 
		{	?>
			<tr>
				<td width="30%" align="left" height="25"><b>UserName</b></td>
				<td width="16%" align="left" height="25"><b>Password</b></td>
				<td width="30%" align="left" height="25"><b>Email</b></td>
				<td colspan="3" height="25"></td>
			</tr>
		<?
			for($i=0; $i<count($adminobj->username); $i++)
			{		
		?>
				<tr>
					<td width="30%" align="left" height="20"><?=$adminobj->username[$i]?></td>
					<td width="16%" align="left" height="20"><?=$adminobj->password[$i]?></td>
					<td width="30%" align="left" height="20"><?=$adminobj->email[$i]?></td>
					<td width="7%" align="center" height="20"><a href="index.php?Act=adminuser_edit&id=<?=$adminobj->userid[$i]?>&mode=edit" >Edit</a></td>
					<td width="10%" align="center" height="20"><a href="index.php?Act=adminuser_privilege&id=<?=$adminobj->userid[$i]?>" >Privileges</a></td>
					<td width="7%" align="center" height="20"><a href="#" onClick="deleteValidate('<?=$adminobj->userid[$i]?>')" >Delete</a></td>
				</tr>
		<?
			}
		} else
		{ ?>
			<tr><td colspan="6" align="center" class="textred">No Admin Users exists</td></tr>		
		<?
		}
		?>
		<tr><td colspan="6">&nbsp;</td></tr>
	</table>
</form><br />

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
	
	function deleteValidate(id)
	{
		if(confirm('Are you sure to delete the Admin user'))
		{
			document.frm_users.action='adminusers_manage.php?id='+id+'&mode=delete';
			document.frm_users.submit();
		}
	}
</script>
