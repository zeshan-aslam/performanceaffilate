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
<div class="row"> 
	<div class="col-md-8">
		<div class="card">			
			<form name="frm_subid" action="sub_id_validate.php" method="post">
			<input type="hidden" name="id" value="<?=$id?>" />
				<div class="card-header">
					<h4 class="card-title"><?=$lang_subid_title?></h4>
					<span class="textred"><?=$msg?></span>
				</div> 
				<div class="card-body manage_sub_affi">
					<label><span><?=$lang_subid_subid?>:</span><input type="text" class="form-control" name="txt_subid" value="<?=$subid?>" />
					<?=$lang_subid_max?>
					<div class="clearfix"></div>
					</label>
					<div class="clearfix"></div>
					<div class="text-center">
						<input class="btn btn-fill btn-info" type="submit" name="Submit" value="<?=$lang_subid_submit?>" />	
					</div>
				</div>
			</form>
		</div>	 
	</div>	
</div>
<?php
	//getting page no
  	if(empty($page))  	$page = $partners->getpage();

	//get all sub-ids created by this affiliate
	$sql = "SELECT * FROM partners_sub_id WHERE sub_affiliateid = '".$_SESSION[AFFILIATEID]."' ";
	$pgsql = $sql;
	$sql  .= " LIMIT ".($page-1)*$lines.",".$lines;
	$res = mysqli_query($con,$sql);
?>
<div class="row"> 
	<div class="col-md-12">
		<div class="card strpied-tabled-with-hover">
			<div class="card-header">
				<h4 class="card-title"><?=$lang_subid_list?></h4>
			</div>
			<div class="card-body">
				<?php
					//if no records were found
					if(mysqli_num_rows($res)<=0)
					{
				?>
				<span class="textred"><?=$lang_subid_no_msg?></span>
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
				<div class="table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<tbody>
							<tr>
								<td><?=$i?></td>
								<td><?=$row->sub_subid?></td>
								<td><a href="index.php?Act=sub_id_list&amp;id=<?=$row->sub_id?>"><?=$lang_subid_edit?>
								</a></td>
								<td><a href="#" onclick="javascript:confirm_deletion(<?=$row->sub_id?>,<?=$c?>)"><?=$lang_subid_delete?>
								</a></td>
							</tr>							
						</tbody>
					</table>
				</div>
				<?php
					}//end of while loop
				}//end of checking for records	
				?>				
			<?
			  /*****************for page no ********************/
			  
			   $url    ="index.php?Act=$Act";    //adding page nos
				include '../includes/show_pagenos.php';
							   
			 /**************************************/
			?>
			</div>	 
		</div>	 
	</div>	
</div>

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
 