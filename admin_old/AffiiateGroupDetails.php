<?php	

	include_once '../includes/db-connect.php';

	$mode 	= $_REQUEST['mode']; 
	if($mode == "ajax") {
		include '../includes/session.php';
		include '../includes/constants.php';
		include_once '../includes/functions.php';
		include '../includes/allstripslashes.php';

		$partners=new partners;
		$partners->connection($host,$user,$pass,$db);

		$group	= $_REQUEST['group']; 
	}
	
	$commisionDetails 	= GetGroupCommission($group);
	$groupDetails		= getGroupDetails($group);
	
	if($group > 0) {
?>
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" >
            <tr>
                <td align="right" width="40%" height="30" >Number of Levels</td>
                <td width="5%">&nbsp;:&nbsp;</td>
                <td align="left"><?=$groupDetails['level']?></td>
            </tr>
            
        <?php
            for($i=1; $i<=$groupDetails['level']; $i++) {
            ?>
                <tr>
                    <td align="right" width="40%" height="30" ><b>Level <?=$i?></b></td>
                    <td align="center" width="5%">&nbsp;:&nbsp;</td>
                    <td align="left" >
                        <?=$commisionDetails[$i]['commission']?>&nbsp;<?=($commisionDetails[$i]['type']=="percentage")?"%":"$"?>
                    </td>
                </tr>
            <?php			
            }
        ?>	
            
        </table>
<?php 
	}
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
#	FUNCTIONS
#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	# Get the commission details set for a group
	function GetGroupCommission($groupId) {
		$con = $GLOBALS["con"];
		$sql_get = "SELECT * FROM partners_affiliategroup_commission WHERE commission_groupid='$groupId' ";
		$res_get = mysqli_query($con,$sql_get);
		if(mysqli_num_rows($res_get) > 0)
		{
			$i = 1;
			while($row_get = mysqli_fetch_object($res_get)) {
				$rows[$i]['commission'] = $row_get->commission_amount;
				$rows[$i]['type'] 		= $row_get->commission_type;
				$i++;
			}
			return $rows;
		}
	}
	
	# Gets the details of the selected Affiliate Group
	function getGroupDetails($groupId)
	{
		$con = $GLOBALS["con"];
		$sql_details = "SELECT * FROM partners_affiliategroup WHERE  affiliategroup_id = '$groupId' ";
		$res_details = mysqli_query($con,$sql_details);  
		if(mysqli_num_rows($res_details) > 0){
			$row_details 	= mysqli_fetch_object($res_details);
			$result_group['grouptitle'] 	= $row_details->affiliategroup_title;
			$result_group['level'] 	= $row_details->affiliategroup_levels;
			
			return $result_group;
		}
		else
			return false;
	}
	
	
	
?> 