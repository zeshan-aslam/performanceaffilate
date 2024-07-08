<?php
   /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO CAHNGE AND DISPLAY THE EXISTING MAIL SETTINGS
      VARIABLES          : footertxt       = COMMON MAIL FOOTER
                           headertxt       = COMMON MAIL HEADER
                           mailamnt        = COST PER PAID MAIL
                           action		   = SELECTED ACTION(CHANGE COST PER MAIL,HERADER OR F0OTTER
  //*************************************************************************************************/

    include '../includes/session.php';
    //[^a-zA-Z0-9_].
?>
<div align="center">
<table border='0' cellpadding="2" cellspacing="1" width="60%" class="tablebdr">
	<tr>
		 <td colspan="4" height="18" class="tdhead"><b>Change the Amount Per Mail</b></td>
	</tr>
	<tr>
		 <td colspan="4" align="center" class="textred"><?=$_GET['msg']?></td>
	</tr>
	<tr>
		  <td height="26" colspan="4">&nbsp;</td>
	</tr>
	<tr>
	  <td height="26">&nbsp;</td>
	  <td height="26" colspan="3">
	  <form name="amountupdate" action="admin_mail_manage.php" method="post">
	  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="45%" height="26" align="center">Amount Per Mail</td>
          <td width="32%" height="26" align="left"><input type="text" name="mailamnt" size="30" value="<?=$_SESSION['MAILAMNT']?>" tabindex="3" /></td>
          <td width="23%" align="center"><input type="submit" value="Modify Amount" name="action" tabindex="1" /></td>
        </tr>
      </table></form>
	 </td>
	</tr>
    <tr><td height="26" colspan="4">&nbsp;</td></tr>
    <tr><td colspan="4" height="18" class="tdhead"><b>Change Mail Header And Footer</b></td></tr>
    <tr>
      	<td height="26" colspan="4">&nbsp;</td>
    </tr>
    <tr>
		<td height="26">&nbsp;</td>
      	<td height="26" colspan="3">
			<form name="changeheader" action="admin_mail_manage.php" method="post">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="45%" align="center">Header</td>
				  <td width="32%" align="left"><textarea rows="4" name="headertxt" cols="30" ><?=$_SESSION['MAILHEADER']?></textarea></td>
				  <td width="23%" rowspan="3" align="center"><input type="submit" value="Modify  Options" name="action" tabindex="6" /></td>
				</tr>
				<tr>
				  <td colspan="2" align="center" height="5">&nbsp;</td>
			  </tr>
				<tr>
				  <td align="center">Footer</td>
				  <td align="left"><textarea rows="4" name="footertxt" cols="30"><?=$_SESSION['MAILFOOTER']?></textarea></td>
			    </tr>
			</table>
			</form>
		</td>
    </tr>
</table>
</div><br />