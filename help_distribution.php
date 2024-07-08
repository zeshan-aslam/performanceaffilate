<?php ob_start();
	include_once 'includes/session.php';
	include_once 'includes/constants.php';
	include_once 'includes/functions.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	include_once 'language_include.php';
	
	
	$user	= $_REQUEST['user'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
<HEAD>
<TITLE>Affiliate Network Pro</TITLE>
<link rel="stylesheet" type="text/css" href="main.css">
</HEAD>
<body>

<table cellpadding="0" class="tablebdr" cellspacing="0" width="95%" align="center">
	<tr>
		<td align="center"><b><?=$lang_Distribution?></b></td>
	</tr>
	<tr><td height="19">&nbsp;</td></tr>
	<tr>
		<td align="left"  height="30"><img src="images/help.jpg" />&nbsp;<?=$lang_DR_help1?></td>
	</tr>
	<tr>
		<td align="left"  height="30"><img src="images/help.jpg" />&nbsp;<?=$lang_DR_help2?></td>
	</tr>
	<? if($user=='Admin') { ?>
		<tr>
			<td align="left"  height="25"><img src="images/help.jpg" />&nbsp;<?=$lang_DR_help3?></td>
		</tr>
	<? } ?>
	<tr>
		<td align="left"  height="30"><img src="images/help.jpg" />&nbsp;<?=$lang_DR_help4?></td>
	</tr>
	<tr>
		<td align="left"  height="40"><img src="images/help.jpg" />&nbsp;<?=$lang_DR_help5?></td>
	</tr>
	<tr>
		<td align="left"  height="40"><img src="images/help.jpg" />&nbsp;<?=$lang_DR_help6?></td>
	</tr>



	<tr><td  height="25">&nbsp;</td></tr>
	<tr><td align="center"><input type="button" onClick="window.close();" value="<?=$lang_help_close?>" /></td></tr>
	<tr><td>&nbsp;</td></tr>
</table>
</body>
</html>	
