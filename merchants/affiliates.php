<?php

/***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES DETAILS
      VARIABLES          :      $MERCHANTID       =merchantid
              					$page             =page no
                                $status           =aff status
                                $affid            =for view profile
                                $loginflag        =differentiating affilaite 'a'
                                $mode             =selected action
                                $pgmname          =program url
 *************************************************************************************************/

include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once 'transactions.php';

$partners         = new partners;
$partners->connection($host, $user, $pass, $db);
$sortarray	    = array();
/******************variables*************************************************/
$MERCHANTID       = $_SESSION['MERCHANTID'];       //merchantid
$page             = intval(trim($_GET['page']));           //page no
$status           = trim($_GET['status']);         //status
$affid            = trim($_GET['affid']);          // for view profile
$loginflag        = trim($_GET['loginflag']);      //differentiating affilaite 'a'
$mode             = trim($_GET['mode']);           //selected action
$pgmname          = trim($_GET['pgmname']);        //program url
/****************************************************************************/

$OrderBy = trim(stripslashes($_GET['OrderBy']));
if (empty($OrderBy))   $OrderByValue = "SORT_DESC";
if ($OrderBy == "SORT_DESC") {
	$image = "../images/up.gif";
	$OrderByValue = "SORT_ASC";
} else {
	$OrderByValue = "SORT_DESC";
	$image = "../images/dawn.gif";
}

$image1 = "../images/normal.gif";
/*********************initialisation*****************************************/
if (empty($page))                                        //getting page no
	$page           = $partners->getpage();
if (empty($status))                                       //setting for status
	$status = $_SESSION['SESSIONSTATUS'];
else
	$_SESSION['SESSIONSTATUS'] = $status;
/*****************************************************************************/




/********************view profile&reject affilaite***************************/
if ($_GET['mode'] == 'ViewProfile'  || $_GET['mode'] == 'Reject') {
	if ($_GET['mode'] == 'ViewProfile') {
		$pageurl    = "viewprofile_affiliate.php?";
		$h          = "400";
		$w          = "450";
	} else if ($_GET['mode'] == 'Reject') {
		$pageurl   = "remove_affiliate.php?loginflag=$loginflag&mode=$mode&pgmname=$pgmname";
		$h         = "400";
		$w         = "450";
	}

?>

	<script language="javascript" type="text/javascript">
		help();

		function help() {
			nw = open('<?= $pageurl ?>&id=<?= $affid ?>', 'new', 'height=<?= $h ?>,width=<?= $w ?>,scrollbars=no');
			nw.focus();
		}
	</script>
<?

}  ///// if close
/***************************************************************************/


if (empty($status)) $status = "all";


/*************************search depending on status************************/
switch ($status)   //joinpgm status
{
	case 'all':
		$sql         = " SELECT  ( c.joinpgm_id ),a.affiliate_id, a.affiliate_firstname, a.affiliate_company,c.joinpgm_status,c.joinpgm_programid, p.program_url";
		$sql         = $sql . " FROM partners_affiliate a, partners_joinpgm c, partners_program p";
		$sql         = $sql . " WHERE c.joinpgm_merchantid=$MERCHANTID and c.joinpgm_affiliateid = a.affiliate_id and c.joinpgm_programid = p.program_id";
		//echo $sql;
		break;
	case 'waiting':
		$sql         = " SELECT   ( c.joinpgm_id ),a.affiliate_id, a.affiliate_firstname, a.affiliate_company,c.joinpgm_status,c.joinpgm_programid,  p.program_url";
		$sql         = $sql . " FROM partners_affiliate a, partners_joinpgm c, partners_program p";
		$sql         = $sql . " WHERE joinpgm_status='waiting' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id and c.joinpgm_programid = p.program_id";
		break;
	case 'approve':
		$sql        = " SELECT  ( c.joinpgm_id ),a.affiliate_id, a.affiliate_firstname, a.affiliate_company,c.joinpgm_status,c.joinpgm_programid, p.program_url ";
		$sql        = $sql . " FROM partners_affiliate a, partners_joinpgm c, partners_program p";
		$sql        = $sql . " WHERE joinpgm_status='approved' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id and c.joinpgm_programid = p.program_id";
		break;
	case 'pending':
		$sql        = " SELECT  distinct( c.joinpgm_id) ,a.affiliate_id, a.affiliate_firstname, a.affiliate_company, c.joinpgm_status,c.joinpgm_programid ,  p.program_url";
		$sql        = $sql . " FROM partners_affiliate a, partners_joinpgm c, partners_transaction e, partners_program p";
		$sql        = $sql . " WHERE e.transaction_status =  'pending' and c.joinpgm_merchantid='$MERCHANTID' AND  e.transaction_joinpgmid = c.joinpgm_id AND c.joinpgm_affiliateid = a.affiliate_id  and c.joinpgm_programid = p.program_id";
		//echo "$sql";
		break;
	case 'suspend':
		$sql        = " SELECT  ( c.joinpgm_id ),a.affiliate_id,a.affiliate_company, a.affiliate_lastname,c.joinpgm_status,c.joinpgm_programid,  p.program_url";
		$sql        = $sql . " FROM partners_affiliate a, partners_joinpgm c, partners_program p";
		$sql        = $sql . " WHERE joinpgm_status='suspend' and c.joinpgm_merchantid='$MERCHANTID' and c.joinpgm_affiliateid = a.affiliate_id and c.joinpgm_programid = p.program_id";
		break;
}
/***************************************************************************/

if (!empty($affiliatename)) {
	$affiliatename1	 = addslashes($affiliatename);
	$sql            .= " and (affiliate_company) like('%$affiliatename1%') ";
}

$pgsql = $sql;
$sql .= " LIMIT " . ($page - 1) * $lines . "," . $lines;
$ret = mysqli_query($con, $sql);
if (mysqli_num_rows($ret)) {

?>
	<style>
		/* Adjust the CSS to make the dropdown look similar to a select element */
		.dropdown {
			display: inline-block;
			position: relative;
		}

		.dropdown-toggle {
			padding: 6px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			color: #333;
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		.dropdown-toggle .caret {
			margin-left: 5px;
		}

		.dropdown-menu {
			position: absolute;
			top: 100%;
			left: 0;
			z-index: 1000;
			display: none;
			float: left;
			min-width: 160px;
			padding: 5px 0;
			margin: 2px 0 0;
			font-size: 14px;
			text-align: left;
			list-style: none;
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
		}

		.dropdown-menu>li>a {
			display: block;
			padding: 3px 20px;
			clear: both;
			font-weight: normal;
			line-height: 1.42857143;
			color: #333;
			white-space: nowrap;
		}

		.dropdown-menu>li>a:hover,
		.dropdown-menu>li>a:focus {
			color: #262626;
			text-decoration: none;
			background-color: #f5f5f5;
		}

		/* Your custom CSS for the increased size and justified text in the Swal popup */
		.custom-swal-popup {
			width: 80%;
			/* Set the desired width here */
			max-width: 800px;
			/* Optionally, set a maximum width for larger screens */
		}

		/* Justify the text inside the popup */
		.custom-swal-popup .modal-body {
			text-align: initial;
		}

		/* Adjust the alignment of specific elements inside the popup */
		.custom-swal-popup .row {
			display: flex;
			justify-content: space-between;
		}
	</style>
	<div class="col-md-12">
		<div class="card regular-table-with-color">
			<div class="card-body table-full-width table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th><?= $laff_Status ?></th>
							<th>
								<? if ($SortBy == "affiliate") { ?>
									<a href="index.php?Act=affiliates&amp;SortBy=affiliate&amp;OrderBy=<?= $OrderByValue ?>&amp;page=<?= $page ?>&amp;status=<?= $status ?>&amp;affiliate=<?= $affiliatename ?>"><img src="<?= $image ?>" height="10" width="10" border="0" alt="" /><?= $laff_Affiliate ?></a>
								<? } else { ?>
									<a href="index.php?Act=affiliates&amp;SortBy=affiliate&amp;OrderBy=<?= $OrderByValue ?>&amp;page=<?= $page ?>&amp;status=<?= $status ?>&amp;affiliate=<?= $affiliatename ?>"><img src="<?= $image1 ?>" height="10" width="10" border="0" alt="" /><?= $laff_Affiliate ?></a>
								<? } ?>
							</th>
							<th>
								<? if ($SortBy == "pgmid") { ?>
									<a href="index.php?Act=affiliates&amp;SortBy=pgmid&amp;OrderBy=<?= $OrderByValue ?>&amp;page=<?= $page ?>&amp;status=<?= $status ?>&amp;affiliate=<?= $affiliatename ?>"><img src="<?= $image ?>" height="10" width="10" border="0" alt="" /><?= $laff_PGMID ?></a>
								<? } else { ?>
									<a href="index.php?Act=affiliates&amp;SortBy=pgmid&amp;OrderBy=<?= $OrderByValue ?>&amp;page=<?= $page ?>&amp;status=<?= $status ?>&amp;affiliate=<?= $affiliatename ?>"><img src="<?= $image1 ?>" height="10" width="10" border="0" alt="" /><?= $laff_PGMID ?></a>
								<? } ?>
							</th>
							<th><a href="#"><img src="<?= $image1 ?>" height="10" width="10" border="0" alt="" />Pending</a></th>
							<th>
								<? if ($SortBy == "paid") { ?>
									<a href="index.php?Act=affiliates&amp;SortBy=paid&amp;OrderBy=<?= $OrderByValue ?>&amp;page=<?= $page ?>&amp;status=<?= $status ?>&amp;affiliate=<?= $affiliatename ?>"><img src="<?= $image ?>" height="10" width="10" border="0" alt="" /><?= $laff_Paid ?></a>
								<? } else { ?>
									<a href="index.php?Act=affiliates&amp;SortBy=paid&amp;OrderBy=<?= $OrderByValue ?>&amp;page=<?= $page ?>&amp;status=<?= $status ?>&amp;affiliate=<?= $affiliatename ?>"><img src="<?= $image1 ?>" height="10" width="10" border="0" alt="" /><?= $laff_Paid ?></a>
								<? } ?>
							</th>

							<th><?= $laff_Action ?></th>
						</tr>
					</thead>
					<tbody>
						<?
						$gridcounter = 0;
						while ($row = mysqli_fetch_object($ret)) {

							$total        = GetPaymentStaus1($row->joinpgm_id, $currValue, $default_currency_caption);  //getting pending,approved,paid amnts from GetPayments.php
							$total        = explode('~', $total);
							$status1      = stripslashes(trim($row->joinpgm_status));             //setting picture
							$gridcounter  = $gridcounter + 1;
							$affiliate	= stripslashes($row->affiliate_company);
							$pgmid		= $row->joinpgm_programid;
							$pgm			= stripslashes($row->program_url);
							$id	   		= $row->affiliate_id;
							$joinid	  	= $row->joinpgm_id;
							$pending      = $total[1];
							$paid		    = $total[0];
							$sortarray[$gridcounter] =  array("idkey" => "$id", "joinidkey" => "$joinid", "affiliatekey" => "$affiliate", "pgmidkey" => "$pgmid", "pendingkey" => "$pending", "paidkey" => "$paid", "statuskey" => "$status1", "pagekey" => "$page", "programkey" => "$pgm");
						}

						foreach ($sortarray as $key => $row2) {
							$idkey[$key] 		    	= $row2["idkey"];
							$joinidkey[$key] 			= $row2["joinidkey"];
							$affiliatekey[$key] 		= $row2["affiliatekey"];
							$pgmidkey[$key] 	  		= $row2["pgmidkey"];
							$pendingkey[$key] 	 		= $row2["pendingkey"];
							$statuskey[$key] 			= $row2["statuskey"];
							$paidkey[$key] 		   		= $row2["paidkey"];
							$pagekey[$key] 		   		= $row2["pagekey"];
							$programkey[$key] 		   		= $row2["programkey"];
						}
						// $sortarray[$gridcounter] =  array("id" => "$id","joinid" => "$joinid","affiliate" => "$affiliate", "pgmid" => "$pgmid","pending" => "$pending","status" => "$status1");

						switch ($SortBy) {
							case "affiliate":
								switch ($OrderByValue) {
									case 'SORT_ASC':
										array_multisort($affiliatekey, SORT_ASC, $sortarray);
										break;
									case 'SORT_DESC':
										array_multisort($affiliatekey, SORT_DESC, $sortarray);
										break;
								}
								break;

							case "pgmid":
								switch ($OrderByValue) {
									case 'SORT_ASC':
										array_multisort($programkey, SORT_ASC, $sortarray);
										break;
									case 'SORT_DESC':
										array_multisort($programkey, SORT_DESC, $sortarray);
										break;
								}
								break;
							case "pending":
								switch ($OrderByValue) {
									case 'SORT_ASC':
										array_multisort($pendingkey, SORT_ASC, $sortarray);
										break;
									case 'SORT_DESC':
										array_multisort($pendingkey, SORT_DESC, $sortarray);
										break;
								}
								break;

							case "paid":
								switch ($OrderByValue) {
									case 'SORT_ASC':
										array_multisort($paidkey, SORT_ASC, $sortarray);
										break;
									case 'SORT_DESC':
										array_multisort($paidkey, SORT_DESC, $sortarray);
										break;
								}
								break;
						}


						function test_print($sortarray, $key, $laff_SelectAction)
						{
							$arr_val = explode("~*", $laff_SelectAction);
							$laff_SelectAction = $arr_val[0];
							$currSymbol  = $arr_val[1];
							global $con;
							$affid = $sortarray["idkey"];
							$sql        = "select * from partners_affiliate where affiliate_id='$affid'";
							$res        = mysqli_query($con, $sql);
							while ($row = mysqli_fetch_object($res)) {
								$affiliate_id                                = $row->affiliate_id;
								$affiliate_firstname              			  = stripslashes($row->affiliate_firstname);
								$affiliate_lastname               			  = stripslashes($row->affiliate_lastname);
								$affiliate_company                           = stripslashes($row->affiliate_company);
								$affiliate_address                           = stripslashes($row->affiliate_address);
								$affiliate_city                              = stripslashes($row->affiliate_city);
								$affiliate_country                           = stripslashes($row->affiliate_country);
								$affiliate_phone                             = stripslashes($row->affiliate_phone);
								$affiliate_url                               = stripslashes(trim($row->affiliate_url));
								$affiliate_category                		  = stripslashes($row->affiliate_category);
								$affiliate_status                        	  = stripslashes($row->affiliate_status);
								$affiliate_date                              = stripslashes($row->affiliate_date);
								$affiliate_fax                               = stripslashes($row->affiliate_fax);
							}

						?> <tr>
								<td>
									<?
									if ($sortarray["pendingkey"] > 0) //checking for pending transactions
									{
									?>
										<img alt=" " border="0" height="16" src="../images/pending.gif" width="16" />
									<? } ?>
								</td>
								<td>
									<img alt="" border="0" height="16" src="../images/<?= $sortarray["statuskey"] ?>.gif" width="16" />
								</td>
								<td><a href="index.php?Act=affiliate_page&amp;aid=<?= $sortarray["idkey"] ?>"><?= $sortarray["affiliatekey"] ?></a></td>
								<td><a href='index.php?Act=programs&mode=editprogram&programId=<?= $sortarray["pgmidkey"] ?>'><?= $sortarray["programkey"] ?></a></td>
								<td><?= $currSymbol ?><?= number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'], $sortarray["pendingkey"]), 2) ?> </td>
								<td><?= $currSymbol ?><?= number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'], $sortarray["paidkey"]), 2) ?> </td>
								<td><?
									$Approve          = $sortarray["joinidkey"] . "~Approve" . "~" . $sortarray["idkey"];
									$Reject           = $sortarray["joinidkey"] . "~Reject" . "~" . $sortarray["idkey"];
									$ViewProfile      = $sortarray["joinidkey"] . "~ViewProfile" . "~" . $sortarray["idkey"];
									$Suspend          = $sortarray["joinidkey"] . "~Suspend" . "~" . $sortarray["idkey"];;
									?>
									<!-- <form id="f<?= $sortarray["joinidkey"] ?>" name="f<?= $sortarray["joinidkey"] ?>" action="affiliate_actions.php?page=<?= $sortarray["pagekey"] ?>" method="post" onsubmit="return showConfirmationDialog(f<?= $sortarray['joinidkey'] ?>);">
										<select class="selectpicker selectpickeraffilate" name="selaction" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
											<? if ($sortarray["statuskey"] == 'waiting' || $sortarray["statuskey"] == 'suspend') {
											?>
												<option value="<?= $Approve ?>">Approve</option>
											<?
											}
											if ($sortarray["statuskey"] == 'waiting') {
											?>
												<option value="<?= $Reject ?>">Reject</option>
											<?
											}
											?>
											<option value="<?= $ViewProfile ?>">View Profile</option>
											<?
											if ($sortarray["statuskey"] == 'approved') {
											?>
												<option value="<?= $Suspend ?>">Suspend</option>
											<?	} ?>
										</select>
									</form> -->
									<form id="f<?= $sortarray["joinidkey"] ?>" name="f<?= $sortarray["joinidkey"] ?>" method="post">
										<div class="dropdown">
											<button class="btn btn-md btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Please Select
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
												<?php if ($sortarray["statuskey"] == 'waiting' || $sortarray["statuskey"] == 'suspend') { ?>
													<li id="aff_approve" value="<?= $Approve ?>" name="selaction" onclick="return showConfirmationDialog('<?= $Approve ?>',event,<?= $sortarray['pagekey'] ?>);"><a href="#">Approve</a></li>
												<?php }
												if ($sortarray["statuskey"] == 'waiting') { ?>
													<li id="aff_reject" value="<?= $Reject ?>" name="selaction" onclick="return showConfirmationDialog('<?= $Reject ?>',event,<?= $sortarray['pagekey'] ?>);"><a href="#">Reject</a></li>
												<?php } ?>
												<li id="aff_viewProfile" value="<?= $ViewProfile ?>" name="selaction" onclick="return showConfirmationDialog('<?= $ViewProfile ?>',event,<?= $sortarray['pagekey'] ?>);"><a href="#">View Profile</a></li>
												<?php if ($sortarray["statuskey"] == 'approved') { ?>
													<li id="aff_suspend" value="<?= $Suspend ?>" name="selaction" onclick="return showConfirmationDialog('<?= $Suspend ?>',event,<?= $sortarray['pagekey'] ?>);"><a href="#">Suspend</a></li>
												<?php } ?>
											</ul>
										</div>

									</form>



									<div class="modal fade modal-primary main_modal" id="myModal<?= $sortarray["idkey"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

										<div class="modal-dialog cust_affilte_modal modal_style">
											<div class="modal-content">
												<div class="modal-header justify-content-center">
													<div class="modal-title">
														Affiliate Profile
													</div>
													<button type="button" class="close modal_close" data-dismiss="modal">&times;</button>
												</div>
												<div class="modal-body">
													<div class="card strpied-tabled-with-hover">
														<div class="card-body">
															<p><?= $vproaff_prof ?></p>
															<div class="row">
																<div class="col-md-6 border_right">
																	<div class="form-group">
																		<label>ID: <b><?= $affiliate_id ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>Company Name: <b><?= $affiliate_company ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>First Name: <b><?= $affiliate_firstname ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>Last Name: <b><?= $affiliate_lastname ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>Address: <b><?= $affiliate_address ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>City: <b><?= $affiliate_city ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>Country: <b><?= $affiliate_country ?></b></label>
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Phone: <b><?= $affiliate_phone ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>URL: <b><?= $affiliate_url ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>Category: <b><?= $affiliate_category ?></b></label>
																	</div>

																	<div class="form-group">
																		<label>Status: <b><?= $affiliate_status ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>Date of Joining: <b><?= $affiliate_date ?></b></label>
																	</div>
																	<div class="form-group">
																		<label>Skype ID: <b><?= $affiliate_fax ?></b></label>
																	</div>
																</div>
															</div>

														</div>
														<div class="modal-footer text-center">
															<button id="<?php echo $ViewProfile; ?>" type="button" class="btn btn-success btn-wd closepopup modal_btn_close">Close</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						<? }
						$lang_param =  $laff_SelectAction . "~*" . $currSymbol;
						if (!empty($sortarray))  array_walk($sortarray, 'test_print', $lang_param);
						?>

					</tbody>
				</table>
				<div class="custom_pagination">
					<? $url = "index.php?Act=affiliates&amp;status=$status&amp;affiliate=$affiliatename"; //adding page nos
					include '../includes/show_pagenos.php';
					?>
				</div>
			</div>
		</div>
	</div>
<?php
} else {
?>
	<div class="card strpied-tabled-with-hover">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="card-body table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<tbody>
							<tr>
								<td><?= ($mode != "ViewProfile" ? $norec : "") ?> </td>
							<tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?
}
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script language="javascript" type="text/javascript">
	function viewLink(affiliateid) {
		url = "viewprofile_affiliate.php?id=" + affiliateid;
		nw = open(url, 'new', 'height=400,width=450,scrollbars=no');
		nw.focus();
	}
</script>

<script>
	function showConfirmationDialog(selected, event, pageNo) {
		event.preventDefault(); // Prevent the form from submitting normally
		console.log("Event: ", event);
		console.log("Page No: ", pageNo);

		const myString = selected;
		console.log("myString: ", myString);
		const characterToCheck = "ViewProfile";

		// Using indexOf() method
		if (myString.indexOf(characterToCheck) !== -1) {
			console.log("Character exists in the string.");
			// Get the selected value from the dropdown
			const selectedValue = selected;
			console.log("Selected value", selectedValue);

			// Create a data object with the selected value
			const formData = new FormData();
			formData.append('selaction', selectedValue);

			// Perform the AJAX request
			$.ajax({
				url: 'affiliate_actions.php?page=' + pageNo,
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function(data) {
					// Handle the response data or show a success message
					console.log("Response here: ", data);
					if (data) {
						if (data.msg === 'View Profile') {
							// Create the HTML table with responsive styles
							let tableHtml = `
                <div class="">
				<div class="modal-content">
												<div class="modal-body">
													<div class="card strpied-tabled-with-hover">
														<div class="card-body">
															<p style="align:center;"><?= $vproaff_prof ?></p>
															<div class="row">
																<div class="col-md-6 border_right">
																	<div class="form-group">
																		<label>ID: <b>` + data.affiliate_id + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>Company Name: <b>` + data.affiliate_company + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>First Name: <b>` + data.affiliate_firstname + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>Last Name: <b>` + data.affiliate_lastname + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>Address: <b>` + data.affiliate_address + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>City: <b>` + data.affiliate_city + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>Country: <b>` + data.affiliate_country + `</b></label>
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Phone: <b>` + data.affiliate_phone + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>URL: <b>` + data.affiliate_url + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>Category: <b>` + data.affiliate_category + `</b></label>
																	</div>

																	<div class="form-group">
																		<label>Status: <b>` + data.affiliate_status + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>Date of Joining: <b>` + data.affiliate_date + `</b></label>
																	</div>
																	<div class="form-group">
																		<label>Skype ID: <b>` + data.affiliate_fax + `</b></label>
																	</div>
																</div>
															</div>

														</div>
													</div>
												</div>
											</div>
                </div>
              `;

							// Swal.fire({
							// 	// title: 'Data Table',
							// 	html: tableHtml,
							// 	showConfirmButton: false, // Hide the default "Confirm" button
							// 	customClass: {
							// 		// container: 'table-responsive' // Add custom CSS class to make the table responsive
							// 	}
							// });
							// Use SweetAlert library to show the popup with custom HTML content
							Swal.fire({
								title: "Affiliate Details",
								html: tableHtml,
								showCloseButton: true,
								showConfirmButton: false,
								customClass: 'custom-swal-popup', // Add a custom CSS class for sizing
							});
						}
					} else {
						Swal.fire('Action can not be performed', '', 'error');
					}
				},
				error: function(error) {
					// Handle any errors
					console.error('Error:', error);
					Swal.fire('An error occurred!', '', 'error');
				}
			});
		} else {
			console.log("Character does not exist in the string.");

			Swal.fire({
				title: 'Do you want to perform this action?',
				showDenyButton: true,
				confirmButtonText: 'Yes',
				denyButtonText: 'No',
			}).then(function(result) {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					// Get the selected value from the dropdown
					const selectedValue = selected;
					console.log("Selected value", selectedValue);

					// Create a data object with the selected value
					const formData = new FormData();
					formData.append('selaction', selectedValue);

					// Perform the AJAX request
					$.ajax({
						url: 'affiliate_actions.php?page=' + pageNo,
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						dataType: 'json',
						success: function(data) {
							// Handle the response data or show a success message
							console.log("Response here: ", data);
							if (data) {
								// Swal.fire('Action Performed Successfully!', '', 'success');
								// Call the location.reload() method to reload the page
								location.reload();
							} else {
								Swal.fire('Action cannot be performed', '', 'error');
							}
						},
						error: function(error) {
							// Handle any errors
							console.error('Error:', error);
							Swal.fire('An error occurred!', '', 'error');
						}
					});
				} else if (result.isDenied) {
					Swal.fire('Action Cancelled!', '', 'info');
				}
			});
		}
	}
</script>