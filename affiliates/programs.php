	<!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		th {
			font-size: 12px !important;
			color: #000000 !important;
			font-weight: 600 !important;
		}

		tbody>tr>td>a>i {
			color: #e34d12 !important;
			padding: 1px !important;
		}

		table {
			background: white !important;

		}
	</style>


	<?php
	/************************************************************************/
	/*     PROGRAMMER     :  SMA                                            */
	/*     SCRIPT NAME    :  programs.php        				            */
	/*     CREATED ON     :  10/SEP/2009                                    */

	# View all programs
	# 	 
	#	
	/************************************************************************/


	#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	#	FUNCTIONS
	#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// $q ="SELECT affiliate_currency FROM partners_affiliate WHERE affiliate_id ='$AFFILIATEID'";
	//       $res =mysqli_query($con,$q);
	//       while($row=mysqli_fetch_assoc($res))
	// 	  {
	// 		 $curr_value = $row['affiliate_currency'];
	// 	  }

	function getStatus($programId, $affiliateId)
	{
		$con = $GLOBALS["con"];

		$sql = "SELECT joinpgm_status FROM partners_joinpgm 
			WHERE joinpgm_programid='$programId' AND joinpgm_affiliateid='$affiliateId' ";
		$res = mysqli_query($con, $sql);
		if (mysqli_num_rows($res) > 0) {
			list($status) = mysqli_fetch_row($res);
		} else
			$status = "notjoined";
		return $status;
	}



	// $AFFILIATEID       = $_SESSION['AFFILIATEID'];           //affilaiteid
	// echo "This is affiliate id".$AFFILIATEID;

	$page              = trim($_GET['page']);                 //page no
	$cat               = trim($_REQUEST['category_id']);               //selected category
	$cat_name               = trim($_REQUEST['category_name']);               //selected category Name
	$pgm               = trim($_REQUEST['pgm']);             //selected pgm
	$pgm_url               = trim($_REQUEST['pgm_url']);             //selected pgm_url

	$searchtxt         = trim($_REQUEST['searchtxt']);          //selected pgm(search)

	$joinstatus        = trim($_REQUEST['joinstatus']);          //joinpgm status
	if (empty($joinstatus))
		$joinstatus		= $_SESSION['JOINSTATUS'];          //checking status for search
	else
		$_SESSION['JOINSTATUS']	= $joinstatus;

	if (empty($page))                                 //getting page no
		$page		= $partners->getpage();

	// $sql = "SELECT * FROM partners_program, partners_joinpgm, partners_merchant WHERE program_status LIKE ('active')
	// 			AND joinpgm_programid=program_id AND program_merchantid=merchant_id AND merchant_currency='$curr_value' AND joinpgm_affiliateid='$AFFILIATEID'  ";
	$sql = "SELECT * FROM partners_program, partners_joinpgm, partners_merchant WHERE program_status LIKE ('active') AND merchant_status LIKE ('approved')
	AND joinpgm_programid=program_id AND program_merchantid=merchant_id  AND joinpgm_affiliateid='$AFFILIATEID'";
	switch ($joinstatus) {
		case "All":
			$sql = "SELECT * FROM partners_program, partners_merchant WHERE   program_status LIKE ('active')
			 AND program_merchantid=merchant_id AND merchant_status LIKE ('approved')";
			break;

		case "waiting":
			$sql .= " AND  joinpgm_status='waiting'";
			break;

		case "suspend":
			$sql .= " AND  joinpgm_status='suspend'";
			break;

		case "approved":
			$sql .= " AND  joinpgm_status='approved'";
			break;

		case "notjoined":
			$res_aff_pgms = mysqli_query($con, $sql);
			if (mysqli_num_rows($res_aff_pgms) > 0) {
				while ($row_aff_pgms = mysqli_fetch_object($res_aff_pgms)) {


					$joinedPgms .= $row_aff_pgms->joinpgm_programid . ",";
				}
				$joinedPgms = trim($joinedPgms, ",");

				$sql = "SELECT * FROM partners_program,  partners_merchant WHERE program_status LIKE ('active') AND merchant_status LIKE ('approved')
				AND  program_merchantid=merchant_id AND program_id NOT IN ($joinedPgms)  ";
			} else {
				$sql = "SELECT * FROM partners_program,  partners_merchant WHERE program_status LIKE ('active') AND merchant_status LIKE ('approved')
				AND  program_merchantid=merchant_id ";
			}
			break;

		case 'search':        //search particular pgm
			$sql = "SELECT * FROM partners_program,  partners_merchant WHERE program_status LIKE ('active')
			AND  program_merchantid=merchant_id AND program_url like '%" . addslashes($searchtxt) . "%'  ";
			break;

		case 'pgmwise':       //pgm wise search
			$sql = "SELECT * FROM partners_program,  partners_merchant WHERE  
			  program_merchantid=merchant_id AND program_id='$pgm'  ";
			break;

			// case 'catwise':
			// 	$sql = "SELECT * FROM partners_program,  partners_merchant, partners_category WHERE program_status LIKE ('active')
			// 		AND  program_merchantid=merchant_id AND cat_name='" . addslashes($cat) . "' AND ";
			// 	break;

		case 'catwise':
			$sql = "SELECT * FROM partners_program,  partners_merchant WHERE program_status LIKE ('active')
			AND  program_merchantid=merchant_id AND merchant_category='" . addslashes($cat) . "'  ";
			break;
	}

	$res_page = mysqli_query($con, $sql);
	$_SESSION['SESS_TOTALCOUNT'] = mysqli_num_rows($res_page);
	$sql .= " LIMIT " . ($page - 1) * $lines . "," . $lines; #echo "sql =".$sql;
	$res = mysqli_query($con, $sql);

	if (mysqli_num_rows($res) > 0) {	?>

		<script src="../includes/iAjax.js" type="text/javascript"></script>

		<?php
		if ($cat_name) {
		?>

			<h3>Category Wise <small>(<?= $cat_name ?>)</small></h3>

		<?php
		}
		if ($pgm_url) {
		?>
			<h3>Program Wise <small>(<?= $pgm_url ?>)</small></h3>
		<?php
		}
		?>


		<div class="row">
			<div class="col-md-12">
				<div class="col-md-3 float-right">
					<div class="card">
						<form name="search" method="post" action="index.php?Act=Programs&amp;joinstatus=search">
							<input class="form-control" type="text" name="searchtxt" size="18" placeholder="Search Programs" value="<?= stripslashes($searchtxt) ?>" />
							<input class="btn btn-fill btn-info" style="margin-top:10px; display:none;" type="submit" value="<?= $lang_bycategory_go ?>" name="B1" />
						</form>
					</div>
				</div>
			</div>
		</div>


		<form id="SearchResultsForms" name="SearchResultsForm" method="post" action="affiliates_process.php?page=<?= $page ?>&amp;joinstatus=<?= $joinstatus ?>">
			<div class="row">
				<div class="col-md-12">
					<div class="card strpied-tabled-with-hover affiliate_table">
						<div class="card-header">
							<h4 class="card-title"><?= $lpgm_Commissions ?></h4>
						</div>
						<div class="card-body table-full-width table-responsive">

							<table id="dtBasicExample" class="table  table-bordered table-sm" cellspacing="0" height="100%" width="100%">
								<thead style="background: #f1f1f1;">
									<tr>
										<th><?= $lang_affiliate_head_url ?></th>
										<!-- <th></th> -->
										<th><?= $lang_affiliate_head_merchant ?></th>
										<th>Details</th>
										<th><?= $lang_affiliate_head_action ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									while ($row = mysqli_fetch_object($res)) {
										$status = getStatus($row->program_id, $AFFILIATEID);
										if ($status == '') {
											$status = 'pending';
										}
										$check = "~" . $status . "~" . $row->program_id . "~" . $row->program_merchantid;
										$merchantid = $row->program_merchantid;
										$sqlp = "select * from partners_merchant where merchant_id = '$merchantid'";
										$resp = mysqli_query($con, $sqlp);
										$rowprofile = mysqli_fetch_object($resp);
									?>
										<tr>
											<td><input type="checkbox" name="elements[]" value="<?= $check ?>" />&nbsp;<?= $row->program_url ?></td>
											<!-- <?php if ($rowprofile->merchant_profileimage != '') { ?>
												<td class="popup_effect" style="text-align: center;"><img width="34px" height="34px" src="../merchants/uploadedimage/<?php echo $rowprofile->merchant_profileimage; ?>" >
												<div class="popup_hover">   
											// 		<div class="popup_desc">
											// 			<div class="req_mockup">
											// 				<img width="150px" height="150px" src="../merchants/uploadedimage/<?php echo $rowprofile->merchant_profileimage; ?>" >
											// 			</div> 	
											// 		</div>
											// 	</div>
											// 	</td>
											// 	<?php } else { ?>
											//   <td class="popup_effect" style="text-align: center;"><img width="34px" height="34px" src="../merchants/uploadedimage/photo.jpg" >
											// 	<div class="popup_hover">   
											// 		<div class="popup_desc">
											// 			<div class="req_mockup">
											// 				<img width="150px" height="150px" src="../merchants/uploadedimage/photo.jpg" >
											// 			</div> 	
											// 		</div>
											// 	</div>
											// 	</td>
											//    <?php } ?>  -->
											<td><a title="profile" href="index.php?Act=viewprofile&amp;id=<?= $row->program_merchantid ?>&amp;pgmid=<?= $row->program_id ?>&amp;status=<?= $status ?>"><?= $row->merchant_company ?></a></td>
											<!-- <td><a title="profile" href="index.php?Act=viewprofile&amp;id=<?= $row->program_merchantid ?>&amp;pgmid=<?= $row->program_id ?>&amp;status=<?= $status ?>"><?= $row->merchant_company ?></a></td> -->

											<td><a href="#displayBox" onclick="javascript:ShowCommissionDetails('<?= $row->program_id ?>','<?= $AFFILIATEID ?>');"><?= $lang_viewCommision ?></a>&nbsp;<img src="../images/<?= $status ?>.gif" height="<?= $icon_height ?>" width="<?= $icon_width ?>" alt="" /></td>
											<td>
												<?php
												if ($status == 'suspend') { ?>
													<?= $lang_affiliate_blocked ?>
													<a title="join program" href='affiliates_process.php?page=<?= $page ?>&amp;choice=rejoin&amp;pgmid=<?= $row->program_id ?>&amp;joinstatus=<?= $joinstatus ?>'></a>
													<!-- &nbsp;-&nbsp;<a title="join program" href='affiliates_process.php?page=<?= $page ?>&amp;choice=rejoin&amp;pgmid=<?= $row->program_id ?>&amp;joinstatus=<?= $joinstatus ?>'><i class="fa fa-plus" aria-hidden="true"></i></a> -->
												<?php
												} else if ($status == 'waiting') {
													echo $lang_affiliate_waiting;
												} elseif ($status == 'notjoined') { ?>
													<a title="join program" href="affiliates_process.php?page=<?= $page ?>&amp;joinstatus=<?= $joinstatus ?>&amp;sub='action'&amp;id=<?= $check ?>"> <i class="fa fa-plus" aria-hidden="true"></i></a>
													<!-- <a value="<?= $lang_affiliate_head_join ?>" name="sub" onclick=" return validatejoin()"><i class="fa fa-plus" aria-hidden="true"></i></a> -->

													<a title="profile" href="index.php?Act=viewprofile&amp;id=<?= $row->program_merchantid ?>&amp;pgmid=<?= $row->program_id ?>&amp;status=<?= $status ?>"><i class="fa fa-search" aria-hidden="true"></i></a><a href="index.php?Act=Getlinks&pid=<?= $row->program_id ?>" title="view_link"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
												<?php
												} else if ($status == 'approved') { ?>
													<a title="suspend" href='affiliates_process.php?page=<?= $page ?>&amp;status=sus&amp;pgmid=<?= $row->program_id ?>&amp;joinstatus=<?= $joinstatus ?>'><i class="fa fa-times" aria-hidden="true"></i></a>
													<a href="index.php?Act=viewprofile&amp;id=<?= $row->program_merchantid ?>&amp;pgmid=<?= $row->program_id ?>&amp;status=<?= $status ?>" title="profile"><i class="fa fa-search" aria-hidden="true"></i></a><a href="index.php?Act=Getlinks&pid=<?= $row->program_id ?>" title="view_link"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
												<?php	} ?>
											</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							<div style="margin-top:30px;text-align: center;"><? include '../includes/paging.php';  ?></div>
						</div>

					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card strpied-tabled-with-hover">
						<div class="card-body table-full-width table-responsive">
							<table id="" class="table  table-bordered table-sm" cellspacing="0" width="100%">
								<tbody>
									<tr>
										<td><img src="../images/arrow_ltr.gif" alt="" />
											<a href="javascript:;" onclick="flagall()"> <?= $lang_affiliate_head_check ?>/</a>
											<a href="javascript:;" onclick="unflagall()"> <?= $lang_affiliate_head_uncheck ?>&nbsp;&nbsp;&nbsp;</a>
											<input type="hidden" name="hidden_choice" value="" />

											<button value="<?= $lang_affiliate_head_join ?>" type="button" name="sub" class="btn btn-fill btn-info" onclick=" return validatejoin()"><?= $lang_affiliate_head_join ?></button>
											<button type="button" class="btn btn-fill btn-info" type="button" name="sub" value="<?= $lang_affiliate_head_suspend ?>" style="width: 110" onclick=" return validatesuspend()"><?= $lang_affiliate_head_suspend ?></button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</form>
	<?php
	} else {
	?>
		<div class="card strpied-tabled-with-hover">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="card-body table-full-width table-responsive">
						<table id="dtBasicExample" class="table  table-bordered table-sm" cellspacing="0" width="100%">
							<tbody>
								<tr>
									<td><?= $norec ?></td>
								<tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<div class="sweet-container pos_rel">
		<div id="div_fadded" class="sweet-overlay" tabindex="-1" style="display: none; opacity: 1.05;"></div>
		<div class="custompopup sweet-alert show-sweet-alert visible" id="show_viewcommission" style="display: none;">
			<div class="viewcommission_data"></div>
			<div id="loadershow" style="display:none; vertical-align:bottom; width:100%; " align="center">
				<img src="images/wait.gif" border="0" alt="Loading" /><br />
				<b>Loading.........</b>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script language="javascript" type="text/javascript">
		//check all
		function flagall() {
			for (i = 0; i < (document.SearchResultsForm.elements.length); i++) {
				document.SearchResultsForm.elements[i].checked = true;
			}
		}

		//uncheck all
		function unflagall() {
			for (i = 0; i < (document.SearchResultsForm.elements.length); i++) {
				document.SearchResultsForm.elements[i].checked = false;
			}
		}

		//confirm join
		function validatejoin() {

			Swal.fire({
				title: 'Do you want to join selected?',
				showDenyButton: true,
				confirmButtonText: 'Join Selected',
				denyButtonText: `Cancel`,
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					document.SearchResultsForm.hidden_choice.value = "Join Selected";
					jQuery("#SearchResultsForms").submit();
					Swal.fire('All Joined successfully!', '', 'success');

				} else if (result.isDenied) {
					Swal.fire('Joining Cancelled!', '', 'info')
				}
			});
		}

		//confirm suspend
		function validatesuspend() {
			Swal.fire({
				title: 'Do you want to suspend selected?',
				showDenyButton: true,
				confirmButtonText: 'Suspend Selected',
				denyButtonText: `Cancel`,
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					document.SearchResultsForm.hidden_choice.value = "Suspend Selected";
					jQuery("#SearchResultsForms").submit();
					Swal.fire('All sunpended successfully!', '', 'success');

				} else if (result.isDenied) {
					Swal.fire('Suspention Cancelled!', '', 'info')
				}
			});
		}


		function ShowCommissionDetails(programId, affiliateId) {
			if (programId) {
				jQuery('#loadershow').show();
				document.getElementById('div_fadded').style.display = 'block';
				document.getElementById('show_viewcommission').style.display = 'block';
				//document.getElementById('div_faded').className="showProgramCommissionFadeDiv";
				var urls = "CommissionDetails.php?programId=" + programId + '&affiliateId=' + affiliateId;
				//ajaxpage(url,'viewcommission_data');
				jQuery.ajax({
					url: urls,
					type: 'GET',
					success: function(html) {
						jQuery('#loadershow').hide();
						jQuery('.viewcommission_data').html(html);
					}
				});
			}
		}

		function CloseCommissionDetails() {
			document.getElementById('div_fadded').style.display = 'none';
			document.getElementById('show_viewcommission').style.display = 'none';
			jQuery('.viewcommission_data').html('');
		}
	</script>
	<!-- <script type="text/javascript">
		$(document).ready(function() {
			$('#dtBasicExample').DataTable({
				"paging": false,
				"searching": true,
			});

			$('.dataTables_length').addClass('bs-select');
			$('#dtBasicExample_info').hide();
		});
	</script> -->