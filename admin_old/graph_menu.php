<?
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];

if($userobj->GetAdminUserLink('Graphs',$adminUserId,5)) { ?>
 
<table cellpadding="0" cellspacing="0" width="95%" >

  <tr>
    <td width="100%" align="right">
     [<a href="index.php?Act=graph_return">Return Day Analysis</a>]
     [<a href="index.php?Act=graph_affiliate">Affiliate At a Glance</a>]
     [<a href="index.php?Act=graph_distribution">Distribution Report</a>]
	 [<a href="index.php?Act=graph_bubble">Bubble Plot</a>]
    	</td>
	 </tr>
</table>
<br/>
<? } ?>