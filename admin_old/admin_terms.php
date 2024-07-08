<?php 	 
//############################################################################//
/*  Created             : 19/Oct/2004                                         */
/*  Last Modfd          : 19/Oct/2004                                         */
/*  Script Name         : admin_terms.php                                     */
//============================================================================//
//============================================================================//
// Admin can set the terms and conditions through this section                //
//============================================================================//
//############################################################################//

//Added by SMA on 14-JUly-2006 for Admin Users
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
//End Add on 14-July-2006
	$proceed = 0;
  $type 					= trim($_GET['type']);
  if($type=="merchant"){  
  	if($userobj->GetAdminUserLink('Merchant Generic Terms & Conditions',$adminUserId,6)) { 
		$proceed = 1;
	} else {
		include('permission_denied.php');
	}
  }
  else{  
  	if($userobj->GetAdminUserLink('Affiliates Generic Terms & Conditions',$adminUserId,6)) { 
		$proceed = 1;
	} else {
		include('permission_denied.php');
	}
  }
  
if($proceed == 1)
{  
  if($type=="merchant"){
      $filename                 = "mer_terms.htm";
      $caption					= "Change Merchant Terms And Conditions ";
  }
  else{
      $filename                 = "terms.htm";
      $caption					= "Change Affiliate Terms And Conditions ";
  }
	  $fp                       = fopen($filename,'r');
	  $contents                 = fread ($fp, filesize ($filename));
	  fclose($fp);

?>

<form name="terms_page" action="terms_validate.php?type=<?=$type?>" method="post">
<table border='0' cellpadding="2" cellspacing="1" width="90%" class="tablebdr">
  <tr>
    <td width="100%" colspan="4" height="18" class="tdhead"><b><?=$caption?></b></td>
  </tr>
  <tr>
    <td width="100%" colspan="4" height="18" class="textred" align="center"><?=$_GET['msg']?></td>
  </tr>
  <tr>
            <td width="20%" height="26">&nbsp;</td>
            <td width="28%" height="26"><b>Set Terms &amp; Conditions</b></td>
            <td width="31%" height="26">
            <textarea rows="10" name="error" cols="60" ><?=$contents?></textarea></td>
            <td width="23%" align="center">
            <input type="submit" value="Change" name="action" /></td>

  </tr>
  <tr>
    <td width="100%" colspan="4" height="18" ></td>
  </tr>
</table>
</form>
<? } ?><br />