<?php
	//get message
	$msg = $_GET['msg'];
	

	//get id
	$id = intval($_GET['id']);

	//if for editing
	if(!empty($id))
	{
		//get sub id
		$sql = "SELECT sub_subid FROM partners_sub_id WHERE sub_id = '".$id."' ";
		$res = mysqli_query($con,$sql);
		if($row = mysqli_fetch_object($res)) $subid = $row->sub_subid;
	}
?>
<br/>
<form name="frm_subid" action="sub_id_validate.php" method="post">
<input type="hidden" name="id" value="<?=$id?>" />
<table cellpadding="0" cellspacing="0" width="65%" align="center" class="tablebdr">
	<tr>
	    <td class="tdhead" colspan="3" height="20" align="center"><b><?=$lang_subid_title?></b></td>
	</tr>
	<tr>
	    <td colspan="3" align="center" class="textred"><?=$msg?></td>
	</tr>
	<tr>
	    <td width="47%" align="right" height="30"><?=$lang_subid_subid?></td>
	    <td width="3%"></td>
	  <td width="50%" align="left"><input type="text" name="txt_subid" value="<?=$subid?>" />
	    <?=$lang_subid_max?> </td>
	</tr>
	<tr>
	  <td align="right">&nbsp;</td>
	  <td></td>
	  <td align="left">&nbsp;</td>
	</tr>
	<tr>
	  <td align="right">&nbsp;</td>
	  <td></td>
	  <td align="left"><input type="submit" name="Submit" value="<?=$lang_subid_submit?>" /></td>
	</tr>
</table>
</form>
<br/>
<?php
	//getting page no
  	if(empty($page))  	$page = $partners->getpage();

	//get all sub-ids created by this affiliate
	$sql = "SELECT * FROM partners_sub_id WHERE sub_affiliateid = '".$_SESSION[AFFILIATEID]."' ";
	$pgsql = $sql;
	$sql  .= " LIMIT ".($page-1)*$lines.",".$lines;
	$res = mysqli_query($con,$sql);
?>
<table  cellpadding="1" cellspacing="0"  width="65%" class="tablebdr" align="center" >
	<tr>
		<td colspan="4" class="tdhead" height="20" align="center"><b><?=$lang_subid_list?></b></td>
	</tr>

<?php
	//if no records were found
	if(mysqli_num_rows($res)<=0)
	{
?>
  <tr>
    <td height="10" colspan="4" align="center" class="textred" ><?=$lang_subid_no_msg?></td>
  </tr>
<?php
	}
	else
	{
		//list one by one
		$i = 0;
		while($row = mysqli_fetch_object($res))
		{
			$i++;

			//check whether there are any transaction for this sub id
			$sql1 = "SELECT COUNT(*) AS c FROM partners_transaction WHERE transaction_subid = '".$row->sub_subid."'";
			$res1 = mysqli_query($con,$sql1);
			$c = 0;
			if($row1 = mysqli_fetch_object($res1)) $c = $row1->c;
?>
  <tr>
    <td width="3%"  align="left"  height="20"><?=$i?></td>
    <td width="82%"  align="left"  height="20"><?=$row->sub_subid?></td>
    <td width="7%"  align="center"  height="20"><a href="index.php?Act=sub_id_list&amp;id=<?=$row->sub_id?>"><?=$lang_subid_edit?>
    </a></td>
    <td width="8%"  align="center"  height="20"><a href="#" onclick="javascript:confirm_deletion(<?=$row->sub_id?>,<?=$c?>)"><?=$lang_subid_delete?>
    </a>
        </td>
  </tr>
<?php
		}//end of while loop
?>
  <tr>
    <td colspan="4" align="center" >
      <?
      /*****************for page no**********************************************/

                       $url    ="index.php?Act=$Act";    //adding page nos
                       include '../includes/show_pagenos.php';
     /************************************************************************/
            ?>
    </td>
  </tr>
<?php
	}//end of checking for records
?>
</table>
<script language="javascript" type="text/javascript">
	function confirm_deletion(id,count)
	{
		//confirm
		msg = "Are you sure you want to delete this Sub-ID?";
		if(count>0) msg = msg + "\nThere are some transactions which come under this Sub-Id. If you delete this, then the Sub-Id will be removed from all those transactions.";
		if(confirm(msg))
			window.location = 'sub_id_validate.php?mode=delete&id=' + id;
	}
</script>

