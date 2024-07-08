<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  AffiliateGroupForm.php                         */
/*     CREATED ON     :  27/JULY/2009                                   */

/*	 	AffiliateGroup Management section. 								*/
# Administrator can add or edit groups for the affiliates with a name and the number of levels (1 to 5) that the group will have.
/************************************************************************/


?>
<br/>
<table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="65%" align="center">
    <tr>
    	<td align="center" colspan="5" class="tdhead"><b>Existing Affiliate Groups</b></td>
    </tr>

	<?php
	if($groupList = ListAllAffiliateGroups()) 
	{ 
	?>
        <tr>
            <td width="45%" align="left" height="25"><b>Group Title</b></td>
            <td width="15%" align="left" height="25"><b>Levels</b></td>
            <td colspan="3" height="25">&nbsp;</td>
        </tr>
	<?php
		for($i=0; $i<count($groupList); $i++) 
		{ ?>
            <tr>
                <td align="left" height="25"><?=$groupList[$i]['groupTitle']?></td>
                <td align="left" height="25"><?=$groupList[$i]['groupLevels']?></td>
                <td width="20%"  height="25">
                	<a href="index.php?Act=AffiliateGroup&mode=setCommission&groupId=<?=$groupList[$i]['groupId']?>" >Set Commission</a>
                </td>
                <td width="10%"  height="25">
                	<a href="index.php?Act=AffiliateGroup&mode=edit&groupId=<?=$groupList[$i]['groupId']?>" >Edit</a>
                </td>
                <td width="10%"  height="25">
                	<?php if($groupList[$i]['groupId'] != '1') { ?>
                	<a href="#" onclick="javascript: return confirmDelete(<?=$groupList[$i]['groupId']?>);" >Delete</a>
                    <?php } else { ?><b>Default</b><?php } ?>
                </td>
            </tr>
        
        <?php
		}
    } 
	else 
	{ ?>
        <tr>
            <td align="center" colspan="5" class="textred" height="50" valign="middle" ><b>No Affiliate Groups found</b></td>
        </tr>
	<?php
	}
	?>


</table>


<?php
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
#	FUNCTIONS
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 	function ListAllAffiliateGroups()
	{
		$con = $GLOBALS["con"];

		$sql_list = "SELECT * FROM partners_affiliategroup WHERE 1 ";
		$res_list = mysqli_query($con,$sql_list);
		if(mysqli_num_rows($res_list) > 0)
		{
			$i = 0;
			while($row_list = mysqli_fetch_object($res_list))
			{
				$rows_list[$i]['groupId']		= $row_list->affiliategroup_id;
				$rows_list[$i]['groupTitle']	= stripslashes($row_list->affiliategroup_title);
				$rows_list[$i]['groupLevels']	= $row_list->affiliategroup_levels;
				$i++;
			}
			return $rows_list;
		}
		else
			return false;
	}
	
?>
<script language="javascript" >
	function confirmDelete(groupId){
		if(confirm("Are you sure to delete this group?")) {
			window.location = "index.php?Act=AffiliateGroup&mode=delete&groupId="+groupId;
			return true;
		} else {
			return false;	
		}
	}
</script>	