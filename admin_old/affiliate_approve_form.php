<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<TITLE>Affiliate Network Pro - Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<meta name="generator" content="Namo WebEditor v5.0(Trial)">
<link rel="stylesheet" type="text/css" href="admin.css">

	<script  src="../includes/iAjax.js" type="text/javascript" ></script>
	<script language="javascript" >
    
        function CloseWindow(url)
        { 
            var test =  url + "";
            var start = test.indexOf('mode='); 
            var end = test.indexOf('&',start);
            var newurl = test.substring(0,start) + test.substring(end+1); 
            window.opener.location = newurl;
            self.close();
        }
		
		function displayDetails()
		{
			document.getElementById('TD_GroupDetails').innerHTML = "<img src='images/loading.gif' border='0' alt='Loading Please wait' /><br/>Loading Please Wait!!";
			var group 	= document.frm_approve.group.value; 
			url = "AffiiateGroupDetails.php?mode=ajax&group="+group;
			ajaxpage(url, 'TD_GroupDetails');
			return true;
		}
    </script>	


</head>
<?php
	if($mode == "TierGroup")
		$action = "setCommission";
	else 
		$action = "submit";
?>
<body  style="background-color:#FFFFFF; " >
<form name="frm_approve" method="post" action="affiliate_approve.php?mode=<?php echo $action?>" >
<input type="hidden" name="id" id="id" value="<?php echo $affiliateId?>" />
<input type="hidden" name="page" id="page" value="<?php echo $page?>" />

<table border='0' align="center" class="tablebdr" cellpadding="0" cellspacing="0" width="85%" id="AutoNumber1" >
  	<tr>
    	<td width="100%" colspan="3" class="tdhead" height="19" align="center">
    		<b><?=($mode=="TierGroup")?"":"Approve and "?>Set Commission Group for Affiliate, <?=$affiliate?></b>
		</td>
  	</tr>
    <tr><td colspan="3" height="20" >&nbsp;</td></tr>
	<?php if($msg) { ?>
	<tr>
		<td colspan="3" align="center" class="textred" height="30" ><?php echo $msg?></td>
	</tr>
	<?php } ?>

<?php if($message != "approved") { ?>
	<tr>
		<td align="right" width="40%" height="30" ><b>Commission Group&nbsp;</b></td>
		<td width="5%">&nbsp;:&nbsp;</td>
		<td align="left">
        	<select name="group" onChange="javascript: displayDetails();" >
            	<option value="0" >No Tier Commissions</option>
            	<?php
            	for($i=0; $i<count($groupList); $i++) 
				{ ?>
                	<option value="<?=$groupList[$i]['groupId']?>" <?=($groupList[$i]['groupId']==$group)?"selected='selected'":""?> ><?=$groupList[$i]['groupTitle']?></option>
				<?php
				}
				?>
            </select>
        </td>
	</tr>
    <tr>
    	<td colspan="3" id="TD_GroupDetails" align="center" >
        	<?php
			if($group > 0) { 
				include "AffiiateGroupDetails.php";	
			}
			?>
        </td>
	</tr>        
    <tr><td colspan="3" height="20" >&nbsp;</td></tr>
	<tr>
		<td colspan="3" align="center" height="30" valign="bottom" >
			<input type="submit" name="Approve" id="Approve" value="<?=($mode=='TierGroup')?'Set':'Approve'?>" />&nbsp;&nbsp;&nbsp;
			<input type="button" name="Close"   id="Close"   value="Close" onClick="CloseWindow(window.opener.location);" />
		</td>
	</tr>
	<tr><td colspan="3" height="10" >&nbsp;</td></tr>
<?php } else { ?>
    <tr><td colspan="3" height="20" >&nbsp;</td></tr>
	<tr>
		<td colspan="3" align="center" height="30" valign="bottom" >
			<input type="button" name="Close"   id="Close"   value="Close" onClick="CloseWindow(window.opener.location);" />
		</td>
	</tr>
	<tr><td colspan="3" height="10" >&nbsp;</td></tr>

<?php } ?>    
</table>
</form>
</body>
</html>