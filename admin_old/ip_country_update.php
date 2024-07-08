<?php
        include '../includes/session.php';

?>
<div align="center"><center>

	<table border='0' cellpadding="2" cellspacing="1" width="90%" class="tablebdr">
		<tr>
    		<td colspan="4" height="18" class="tdhead">Update IP to Country Database</td>
  		</tr>
  		<tr>
    		<td colspan="4" height="18" align="center" class="textred">
    			<small><?=$_GET['msg']?></small>
    		</td>
  		</tr>
  		<tr>
  		  <td width="18%" height="26">&nbsp;</td>
	      <td width="82%" height="26" colspan="3">
		  	  <form name="frmupdate" action="ip_country_update_validate.php" method="post" enctype="multipart/form-data">
			  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="33%" height="24">Choose SQL File</td>
				  <td width="35%" height="24"><input type="file" name="txt_file" tabindex="1" /></td>
				  <td width="32%" height="24" align="center"><input type="submit" value="Update" name="action" tabindex="2" /></td>
				</tr>
			  </table>
			  </form>
		  </td>
      	</tr>
		<tr>
    		<td height="4" colspan="3"></td>
  		</tr>

	</table>
  </center>
</div>