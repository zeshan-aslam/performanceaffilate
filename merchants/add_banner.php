<?php
# modified : 16/01/2005

# Allows mercahnts to add new banners to the program
# mercahnt can delete, edit nanner


# checking whther the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	# function to add banners into databse
	function add($lbann_success)
	{

		$con = $GLOBALS["con"];

		# gets pgmid
		$pgmid		= $_SESSION['PGMID'];

		# banner url
		$url		= $_POST['url'];

		# actual banner location to be added
		$banner		= $_POST['banner'];

		# banner size
		$bannerHeight		= intval($_POST['bannerHeight']);
		$bannerWidth		= intval($_POST['bannerWidth']);

		# inserting into database
		$sql = "insert into partners_banner SET " .
			" banner_programid= '" . addslashes($pgmid) . "' , " .
			" banner_url= '" . addslashes($url) . "' , " .
			" banner_name= '" . addslashes($banner) . "' , " .
			" banner_height= '" . addslashes($bannerHeight) . "' , " .
			" banner_width= '" . addslashes($bannerWidth) . "' ";

		@mysqli_query($con, $sql);

		# success msg
		echo "<p align='center' > <font color='red'><strong>$lbann_success</strong></font></p>";
	}

	# if the values are not filled correctly
	if ($_POST['url'] == "" || $_POST['banner'] == "") {
		echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";
	} else {

		# checks whther the user normal or advanced
		# normal user can add only one banner per program
		$sql	 = "select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
		$result = @mysqli_query($con, $sql);

		if (@mysqli_num_rows($result) > 0) {

			/*
        $sql1	= "select * from partners_banner where banner_programid ='$_SESSION[PGMID]'";
        $result = @mysqli_query($con,$sql1);

        if(mysqli_num_rows($result)>0){
             echo "<p align='center' > <font color='red'><strong>$lbann_normal</strong></font></p>";
        }else{
             add($lbann_success);
        }
        */

			add($lbann_success);
		} else {
			add($lbann_success);
		}
	}   /// else closing of null check
} /////////  submit check if closing
# deleting banner
else if ($_GET['mode'] == "delete") {
	$id	=	$_GET['id'];

	$sql = "Delete from partners_banner where banner_id='$id'";
	@mysqli_query($con, $sql);

	echo "<p align='center' ><font color='red'><strong>$lbann_delete</strong></font></p>";
}

?>
<form method="post" name="bannerForm" action="">
	<? include_once "add_link.php"; ?>

	<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css"> -->
	<style>
		.pagination {
			float: right;
		}

		table {
			table-layout: fixed;
		}

		.action {
			width: 80px !important;
		}

		.check {
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		.check {
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		.check:hover {
			overflow: visible;
			white-space: normal;
			-ms-word-break: break-all;
		}

		.check:hover {
			overflow: visible;
			white-space: normal;
		}
	</style>
	<div class="row">
		<div class="col-md-6">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?= $laddban_BannerAdd ?></h4>
					<p><b><?= $laddban_TocreateaBanneraddyoumustfillthefollowingfields ?></b></p>
				</div>
				<div class="card-body">
					<ul style="list-style-type:none;padding-left: 15px;">
						<li><b><?= $laddban_Banner ?> -</b>&nbsp;<?= $laddban_InfoforthebanneryoumusttypetheURLofthebanner ?></li>
						<li><b><?= $laddban_Example ?> -</b>&nbsp;<?= $laddban_yoursite ?></li>
						<li><b><?= $laddban_URL ?> -</b>&nbsp;<?= $laddban_InfoforthelinkofthebanneryoumustinputtheDestinationurltowhichthebannerwilllead ?></li>
						<li><b><?= $laddban_Example ?> -</b>&nbsp;<?= "http://www.yoursite.com" ?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?= $laddban_Settings ?></h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label><?= $laddban_Banner ?></label>
						<input type="text" name="banner" class="form-control" />
						<span>(<?= $laddban_Example ?>- http://www.yoursite.com/banner.gif)</span>
					</div>
					<div class="form-group">
						<label><?= $laddban_URL ?></label>
						<input type="text" name="url" class="form-control" />
						<span>(<?= $laddban_Example ?>- http://www.yoursite.com)</span>
					</div>
					<div class="form-group">
						<label><?= $fflashadd_Dimension ?></label>
						<div class="banner_dimension">
							<input class="form-control " type="text" name="bannerWidth" size="5" /> <b>X</b>
							<input class="form-control" type="text" name="bannerHeight" size="5" />
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="form-group" style="text-align: center;">
						<input type="submit" class="btn btn-info btn-wd" value="<?= $common_submit ?>" name="B1" />&nbsp;&nbsp;<input class="btn btn-default btn-wd" type="reset" value="<?= $common_cancel ?>" name="B2" />
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="row">
	<div class="col-md-8">
		<div class="card regular-table-with-color">
			<div class="card-header">
				<h4 class="card-title"><?= $laddban_ExistingBanners ?></h4>
			</div>
			<div class="card-body">
				<?php    ///////////// display  banners /////////////

				$sql3 = "select * from partners_banner where banner_programid ='$_SESSION[PGMID]' ORDER BY banner_id DESC";
				$res = mysqli_query($con, $sql3);
				//echo $sql3;
				echo mysqli_error($con);


				//Added by DPT on June/16/05
				//if no banner exist
				if (mysqli_num_rows($res) <= 0) {
				?>
					<p><?= $laddban_no_msg ?></p>
				<?php
				}
				?>
			</div>

			<div class="table-full-width table-responsive">
				<table id="table_id" class="table">
					<thead>
						<th><b><?= $laddban_Type; ?></th>
						<th class="text-center"><b><?= $laddban_URL; ?></b></th>
						<th><b>Banner</b></th>
						<th class="text-center"><b>Action</b></th>
					</thead>
					<tbody>
						<?php
						//End of Addition
						while ($row = mysqli_fetch_object($res)) {
						?>
							<tr>
								<td><span class='text'>Banners</span></td>
								<td class="action check"><a href='<?= $row->banner_url ?>' target="new"><?= $row->banner_url ?></a></td>
								<td class="text-center" style="background: gray; height:2px;"><a href='javascript:void(0)'>
										<img src="<?= $row->banner_name ?>" data-toggle="modal" data-target="#divBannerFull" data-width="<?= $row->banner_width ?>" data-height="<?= $row->banner_height ?>" border='0' width="80" height="60" alt="" /></a></td>
								<td style="display: inline-flex;">
									<a href="#" class="btn btn-primary" onclick="window.open('edit_banner.php?id=<?= $row->banner_id ?>','new',100,400)"><?= $laddban_Edit ?></a>&nbsp;&nbsp;
									<a href='index.php?Act=add_banner&amp;mode=delete&amp;id=<?= $row->banner_id ?>' class="btn btn-danger" onclick="return del_onclick()"><?= $laddban_Delete ?>&nbsp;</a>
								</td>

							</tr>
						<?php
						} /// while closing
						?>
					</tbody>

				</table>

			</div>
		</div>
	</div>
</div>
<div id="divBannerFull" class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">&nbsp;</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: center;">


				<img id="imgBannerFull" src="" class="img-fluid" />

			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {

		$('#divBannerFull').on('show.bs.modal', function(event) {
			var img = $(event.relatedTarget) // Button that triggered the modal

			var src = $(img).attr("src");
			var width = $(img).data("width");
			var height = $(img).data("height");

			$("#imgBannerFull").attr("src", src);
			$("#imgBannerFull").attr("width", width);
			$("#imgBannerFull").attr("height", height);



		})

	})
</script>
<script language="javascript" type="text/javascript">
	<!--
	function del_onclick() {
		if (confirm("<?= $lang_del ?>")) {
			return true;
		} else {
			return false;
		}
	}
	//
	
</script>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script>
	$(document).ready(function() {
		$('#table_id').DataTable();
	});
</script>
<script language="javascript" type="text/javascript">
	//document.bannerForm.bannerSize.selectedIndex=0;
	//explode();

	function explode() {

		var delimiter = "X";
		var last_pzindex = document.bannerForm.bannerSize.selectedIndex;
		var item = document.bannerForm.bannerSize.options[last_pzindex].value;

		tempArray = new Array(1);

		var Count = 0;
		var tempString = new String(item);

		while (tempString.indexOf(delimiter) > 0) {
			tempArray[Count] = tempString.substr(0, tempString.indexOf(delimiter));
			tempString = tempString.substr(tempString.indexOf(delimiter) + 1, tempString.length - tempString.indexOf(delimiter) + 1);
			Count = Count + 1
		}

		tempArray[Count] = tempString;
		document.bannerForm.bannerWidth.value = tempArray[0];
		document.bannerForm.bannerHeight.value = tempArray[1];

	}
</script>