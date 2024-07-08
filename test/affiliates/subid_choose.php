<?php
	//get sub id after user select one
	$subid	= $_POST['cbo_sub_id'];
?>
	  <div class="form-group">
		 <label><?=$lang_getlinks_choose_subid?></label>
		 <select name="cbo_sub_id" onchange="document.f1.submit()" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
				<option value=""><?=$cmaff_none?></option>
<?php
	//list all sub ids of this affiliate
	$sql = "SELECT * FROM partners_sub_id WHERE sub_affiliateid = '".$_SESSION[AFFILIATEID]."' ";
	$res = mysqli_query($con,$sql);
	while($row = mysqli_fetch_object($res))
	{
		$selected = "";
		if($subid == $row->sub_subid) $selected = "selected = 'selected'";
?>
				<option value="<?=$row->sub_subid?>" <?=$selected?>><?=$row->sub_subid?></option>
<?php
	}
?>
		</select>
	</div>	 
	
	<!--<a href="index.php?Act=sub_id_list">&laquo;<?//=$lang_home_manage_subid?>&raquo;</a>-->