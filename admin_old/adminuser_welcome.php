<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  adminuser_welcome.php                          */
/*     CREATED ON     :  10/JULY/2006                                   */

/*	Welcome Page for admin users other than Super Admin. 				*/
/************************************************************************/

	$userobj = new adminuser();
	$id 	 = $_SESSION['ADMINUSERID'];
	$userobj->GetAdimUserDetails($id);
	
	$username = $userobj->username;
?>

<table align="center" cellpadding="0" cellspacing="0" class="tablebdr" width="100%" height="350">
	<tr>
		<td align="center" valign="middle">
			<b><font size="+2" color="#000000"><?=$username?><br/>&nbsp;Welcome to Administrator Control Panel.</font></b>
		</td>
	</tr>
</table>

