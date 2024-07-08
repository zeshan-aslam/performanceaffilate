<?php
	include '../includes/session.php';
	$msg 		= $_GET['msg'];
	$userobj 	= new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
?>

<div align="center"><center>

<p height="18" align="center"  class="textred">
    			<small><?=$$msg?></small>
</p>

	<table border='0' cellpadding="2" cellspacing="1" width="90%" class="tablebdr">
		<tr>
    		<td colspan="4" height="18" class="tdhead"><b>Change the Administrator Email Address</b></td>
  		</tr>
				<tr>
    		<td height="4" colspan="3">&nbsp;</td>
  		</tr>

  		<tr>
  		  <td width="18%" height="26">&nbsp;</td>
	      <td width="82%" height="26" colspan="3">
		  	  <form name="mailupdate" action="admin_options_manage.php" method="post">
			  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="30%" height="24" align="right">Email Address</td>
				  <td width="3%" align="left">&nbsp;</td>
				  <td width="41%" height="24" align="left"><input type="text" name="mail" size="26" value="<?=$_SESSION['MAIL']?>" tabindex="1" /></td>
				  <td width="26%" height="24" align="center"><input type="submit" value="Modify Mail" name="action" tabindex="2" /></td>
				</tr>
			  </table>
			  </form>
		  </td>
      	</tr>
  		<tr>
    		<td height="18" colspan="4">&nbsp;</td>
  		</tr>
		<tr>
			<td colspan="4" height="18" class="tdhead"><b>Change the Administrator Login</b></td>
		</tr>
		<tr>
    		<td height="4" colspan="3">&nbsp;</td>
  		</tr>
  		<tr>
  		  <td height="26">&nbsp;</td>

	      <td height="26" colspan="3">

	<? /* if($_SESSION['ADMINUSERID'] == '1') { ?>
		  	  <form name="loginupdate" action="disabled.htm" method="get">
	<? } else { ?> <? }  */ ?>
		  	  <form name="loginupdate" action="admin_options_manage.php" method="post">
	
			  <table width="100%"  border="0" cellspacing="0" cellpadding="0">

				<tr>

				  <td width="30%" height="26" align="right">Admin login</td>

				  <td width="3%" align="left">&nbsp;</td>
				  <td width="41%" height="26" align="left"><input type="text" name="login" size="26" value="<?=$_SESSION['ADMIN']?>" tabindex="3" /></td>

				  <td width="26%" height="26" align="center"><input type="submit" value="Modify Login" name="action" tabindex="4" /></td>

				</tr>

			  </table>

			  </form>

		  </td>

      	</tr>

  		<tr>

    		<td height="18" colspan="4">&nbsp;</td>

  		</tr>

  		<tr>

    		<td colspan="4" height="18" class="tdhead"><b>Change Administrator Password</b></td>

 		</tr>

		<tr>

    		<td height="3" colspan="3">&nbsp;</td>

  		</tr>

		<tr>

		  <td height="26">&nbsp;</td>

	      <td height="26" colspan="3">

	<? /* if($_SESSION['ADMINUSERID'] == '1') { ?>
		  	  <form name="passwordupdate" action="disabled.htm" method="get">
	<? } else { ?><? } */ ?>
		  	  <form name="passwordupdate" action="admin_options_manage.php" method="post">
	

			  <table width="100%"  border="0" cellspacing="0" cellpadding="0">

				<tr>

				  <td width="30%" align="right">Current Password</td>

				  <td width="3%" align="left">&nbsp;</td>
				  <td width="41%" align="left"><input type="password" name="pass1" size="26" tabindex="5" /></td>

				  <td width="26%" rowspan="3" align="center"><input type="submit" value="Modify Password" name="action" tabindex="8" /></td>

				</tr>

				<tr><td colspan="3" height="3"></td></tr>

				<tr>

				  <td align="right">New Password</td>

				  <td align="left">&nbsp;</td>
				  <td align="left"><input type="password" name="pass2" size="26" tabindex="6" /></td>

				</tr>

				<tr><td colspan="3" height="3"></td></tr>

				<tr>

				  <td align="right">Confirm New Password</td>

				  <td align="left">&nbsp;</td>
				  <td align="left"><input type="password" name="pass3" size="26" tabindex="7" /></td>

				</tr>

			  </table>

			  </form>

		  </td>

		</tr>

		<tr>

			<td height="18" colspan="4">&nbsp;</td>

		</tr>

<?
if($userobj->GetAdminUserLink('Administrator Settings',$adminUserId,6)) { 
?>
		<tr>

			<td height="18" colspan="4" class="tdhead"><b>Change Page Settings</b></td>

		</tr>

		<tr>

    		<td height="4" colspan="3">&nbsp;</td>

  		</tr>

        <tr>

            <td height="26" >&nbsp;</td>

            <td height="26" colspan="3" >

				<form name="passwordupdate" action="admin_options_manage.php" method="post">

				<table width="100%"  border="0" cellspacing="0" cellpadding="0">

				  <tr>

					<td width="30%" height="26" align="right">Site Title</td>

					<td width="3%" align="left">&nbsp;</td>
					<td width="44%" height="26" align="left"><input type="text" name="new_title" size="26" tabindex="9" value="<?=stripslashes($title)?>" /></td>

					<td width="23%" align="center"><input type="submit" value="Change Title" name="action" tabindex="10" /></td>

				  </tr>

				</table>
				</form>

			</td>

		</tr>

        <tr>

            <td height="26" >&nbsp;</td>

            <td height="26" colspan="3" >

				<form name="passwordupdate" action="admin_options_manage.php" method="post">

				<table width="100%"  border="0" cellspacing="0" cellpadding="0">

				  <tr>

					<td width="30%" height="26" align="right">Number of records per page</td>

					<td width="3%" align="left">&nbsp;</td>
					<td width="41%" align="left"><input name="number" type="text" size="10" value="<?=$lines?>" tabindex="11" /></td>

					<td width="26%" align="center"><input type="submit" value="Change Lines/Page" name="action" tabindex="12" /></td>

				  </tr>

				</table>
				</form>

			</td>

          </tr>

          <tr>

            <td height="18" colspan="4" >&nbsp;</td>

          </tr>

          <tr>

            <td height="18" colspan="4" class="tdhead"><b>Error Page Settings</b></td>

          </tr>

         <?

               $filename="error.htm";

               $fp = fopen($filename,'r');

               $contents = fread ($fp, filesize ($filename));

               fclose($fp);

              // echo $contents;

         ?>



		  <tr>

  		  <td height="26">&nbsp;</td>

	      <td height="26" colspan="3">

		  	  <form name="error_page" action="admin_options_manage.php" method="post">

			  <table width="100%"  border="0" cellspacing="0" cellpadding="0">

				<tr>

				  <td width="30%" height="26" align="right" valign="top">Set Error Page</td>

				  <td width="3%" align="left">&nbsp;</td>
				  <td width="48%" height="26" align="left"><textarea rows="4" name="error" cols="30" ><?=$contents?></textarea></td>

				  <td width="19%" height="26" align="center"><input type="submit" value="Error Page Setting" name="action" tabindex="12" /></td>

				</tr>

			  </table>

			  </form>

		  </td>

      	</tr>
<? } ?>
	</table>

  </center>

</div>
<br />