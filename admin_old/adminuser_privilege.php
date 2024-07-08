<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  adminuser_edit.php                             */
/*     CREATED ON     :  10/JULY/2006                                   */

/*			Set Privileges to Selected admin user. 						*/
/************************************************************************/

	$adminobj 	= new adminuser();
	
	$id			= intval($_REQUEST['id']);
	$adminobj->GetAdimUserDetails($id);
	
	$note = $_REQUEST['msg'];
	
?>
<form name="frm_users" method="post" action="adminuser_privilege_manage.php" >
	<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="65%" align="center">
		 <tr>
		 	<td align="center" colspan="2" class="tdhead"><b>Admin User Privileges</b></td>
		 </tr>
		 <tr><td height="10"></td></tr>
		 <? if($note) { ?>
		 <tr><td colspan="2" align="center" class="textred"><?=$note?></td></tr>
		 <? } ?>
		 <tr>
		 	<td width="100%" align="center" colspan="2" >
				<table cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td height="30">Privileges for the user : &nbsp;<b><?=$adminobj->username?></b></td>
					</tr>
				</table>
			</td>
		 </tr>
		 <tr>
		 	<td width="90%" align="left" height="30" class="tdhead"><b>Links</b></td>
			<td width="10%" align="center" height="30" class="tdhead"><b>Privilege</b></td>
		 </tr>
		 <?  
		 $adminobj->GetAdminLiks(0);
		 for($i=0; $i<count($adminobj->linkid); $i++)
		 {	
		 	$mainLinkUsers = "";
		 	$mainLinkUsers = $adminobj->linkusers[$i];
			$mainLinkUsers = explode(",",$mainLinkUsers);  
			if(in_array($id,$mainLinkUsers))  
				$chekstatus = "checked = 'checked'";  
			else
				$chekstatus = "";
		 ?> 
		 	<tr>
				<td width="90%" align="left" height="30"><b><?=$adminobj->linktitle[$i]?></b></td>
				<td width="10%" align="right" height="30"><input type="checkbox" <?=$chekstatus?> name="chk_<?=$adminobj->linkid[$i]?>" />&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<?
			$userobj	= new adminuser();
			$childResult = $userobj->GetAdminLiks($adminobj->linkid[$i]);
			if($childResult)
			{
				for($j=0;$j<count($userobj->linkid);$j++)
				{	
					$childLinkUsers = "";
					$childLinkUsers = $userobj->linkusers[$j];
					$childLinkUsers = explode(",",$childLinkUsers);
					if(in_array($id,$childLinkUsers))
						$childstatus = "checked = 'checked'";
					else
						$childstatus = "";
				?>
					<tr>
						<td colspan="2" width="100%">
							<table cellpadding="0" cellspacing="0" align="center" width="100%">
								<tr>
									<td align="left" width="10%">&nbsp;</td>
									<td align="left" width="80%"><?=$userobj->linktitle[$j]?></td>
									<td width="10%" align="right" height="30"><input type="checkbox" <?=$childstatus?> name="chk_<?=$userobj->linkid[$j]?>" />&nbsp;&nbsp;&nbsp;&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr> 
			<?	}
			}
		 }  
		 ?>
		
		<tr>
			<td colspan="2">
				<input type="submit" name="Update" value="Update" />
				<input type="hidden" name="id" value="<?=$id?>" />
			 </td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	</table>
</form>

