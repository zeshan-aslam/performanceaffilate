<?php

/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  programDetails.php                             */
/*     CREATED ON     :  04/SEP/2009                                    */

/* 	Program Details Page.			 									*/
#	 
# 	 
#	
/************************************************************************/


$sql 	= "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //To add to drop down box
$result	= mysqli_query($con, $sql);


switch ($programId) {
	case '';    //all pgm
		$sql =	"SELECT * from partners_joinpgm where joinpgm_merchantid='$MERCHANTID' ";
		break;

	default:    //selected pgm
		$sql = "SELECT * from partners_joinpgm where joinpgm_programid='$programId'";
		$_SESSION['PGMID'] = $programId;
		break;
}

$afftotal	=	GetTotalAffiliates($sql); //getting total affiliates,waiting affiliates,transactions
$afftotal =	explode('~', $afftotal);

$totallink =	GetLinks($programId, $MERCHANTID);       //getting advertising links
$totallink =	explode('~', $totallink);


if ($msg == "saved") {
	$msg = "Program Saved Successfully";
}
if ($msg == "hasProgram") {
	$msg = "A Merchant can only create 1 Program";
}


?>
<form name="frm_program" method="post" action="">
	<div class="row">
		<div class="col-md-12">
			<div class="card stacked-form">
				<div class="card-header">
					<div class="card-title">
						<?
							$con = $GLOBALS["con"];
							$sql="SELECT * FROM partners_program  WHERE program_merchantid = ".$MERCHANTID;
							$hasPrograms = mysqli_query($con,$sql); 
						    count(mysqli_fetch_all($hasPrograms));
							if(mysqli_num_rows($hasPrograms) < 1){
								echo '<a href="index.php?Act=programs&mode=newprogram" class="btn btn-primary btn-wd">'.$lpgm_CREATEPROGRAME.'</a>'
								;
							}
							
						
						
						?>
						<?php if(mysqli_num_rows($hasPrograms) >= 1){?>
                        <a class='btn btn-info btn-wd' href='index.php?Act=programs&amp;mode=editprogram&amp;programId=<?= $programId ?>'><?= $lpgm_Edit ?></a>                                         
					    <?php }?>
						
						<a class='btn btn-success btn-wd' href="index.php?Act=listaffiliate&amp;pgmid=<?= ($programId) ? $programId : 0 ?>">
							<?= $lpgm_RegisteredAffiliates ?><span class="badge badge-light"><?= $afftotal[0] ?></span></a>

						<a class="btn btn-secondary btn-wd" href="index.php?Act=waitingaff&amp;pgmid=<?= ($programId) ? $programId : 0 ?>">
							<?= $lpgm_WaitingAffiliates ?>&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?= $afftotal[1] ?> </span>&nbsp;&nbsp;&nbsp;</a>
					</div>
					<? echo "<p align='center' > <span class='textred'>$msg</span></p>"; ?>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								
								<!-- <select name="programId" onchange="document.frm_program.action='index.php?Act=programs';document.frm_program.submit()" class="selectpicker" data-title="<?= $lpgm_AllPrograms ?>" data-style="btn-primary btn-outline" data-menu-style="dropdown-blue">

									<?
									while ($row = mysqli_fetch_object($result)) {
										if ($programId == "$row->program_id")
											$programName = "selected = 'selected'";
										else
											$programName = "";

										if ($row->program_status == "active") {
											$tag = "bg-success text-white";
										} else {
											$tag = "bg-secondary text-white";
										}

									?>
										<option <?= $programName ?> value="<?= $row->program_id ?>" class="">
											<?= $common_id ?>: <?= $row->program_id ?> |
											<?= stripslashes($row->program_url) ?>
											<span class="<?= $tag ?>">
												( <?= stripslashes(ucwords($row->program_status)) ?> )
											</span>
										</option>
									<? } ?>
									<option value=""><?= $lpgm_AllPrograms ?></option>
								</select> -->

							</div>
						</div>
					</div>

				
				</div>
			</div>
		</div>
		<? if ($programId) { ?>

		<?php } ?>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="card ">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
						<label><?= $lpgm_AffiliateProgram ?></label>
							<b>
								<h5>
									<?= $lpgm_ProgramURL ?>
							</b>
							</h5>
							<p>
								<?= $programDetails['url'] ?>
							</p>


						</div>
					</div>
					<div class="row">
						<div class="col-md-12">

							<h5>
								<b><?= $lpgm_Description ?></b>
							</h5>
							<p>
								<?= nl2br($programDetails['description']) ?>
							</p>


						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">


					<div class="card stacked-form">
						<div class="card-header">Advertising Links</div>
						<div class="card-body">

							<div class="row">
								<div class="col-md-12">
									<?php
									$tot = $totallink[0] + $totallink[1] + $totallink[2] + $totallink[3] + $totallink[4];

									if ($tot == 0) { ?>

										<div class="alert alert-warning"><?= $lpgm_NoLinksAddedtoThisProgram ?></div>

										<a class="btn btn-small btn-primary" href="index.php?Act=addlinks"><?= $lpgm_ClickHereToAddLinks ?></a>


									<?php } else { ?>

										<a class="btn btn-primary btn-wd" href="index.php?Act=add_banner"> <?= $lpgm_Banner ?> <span class="badge badge-light"> <?= $totallink[0] ?></span></a>

										<a class="btn btn-info btn-wd" href="index.php?Act=add_text"> <?= $lpgm_Text ?> <span class="badge badge-light"> <?= $totallink[1] ?></span></a>



									<?php }	?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">


					<div class="card stacked-form">
						<div class="card-header"><?= $recur_commission_head ?></div>
						<div class="card-body">
						<? if ($commissionDetails[$i]['recur_sale'] == '1') {
											echo "<div class='alert alert-success'>".$recur_sale_head . " " . $commissionDetails[$i]['recur_percentage'] . " " . $recur_percent_month_head . " " . $commissionDetails[$i]['recur_period'] . " " . $recur_months_head."</div>";
										} else {
											echo "<div class='alert alert-warning'>".$recur_no_msg."</div>";
										} ?>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="row">
		<div class="col-md-12">
			<div class="card strpied-tabled-with-hover">
				<div class="card-header">
					<div class="card-title">
						<h4><?= $lpgm_Commissions ?></h4>
					</div>
				</div>
				<div class="card-body table-full-width table-responsive">
					 <table class="table table-hover table-striped">
						 <thead>
							<tr>
								<th><?= $lpgm_Type ?></th>
								<th><?= $lpgm_Commissions ?></th>
								<th><?= $lpgm_Approval ?></th>
								<th><?= $lpgm_EmailSettings ?></th>
							</tr>
						 </thead>
						 <tbody>
							<tr>
								<td>
									<img alt="" border='0' height="10" src="../images/impression.gif" width="10" />&nbsp;-&nbsp;
									<?= $lpgm_Impression ?>
								</td>
								<td>
									<?= $currSymbol . $programDetails['impression_rate'] ?>&nbsp;/&nbsp;<?= ($programDetails['impression_unit']) ? $programDetails['impression_unit'] : "1000" ?>
								</td>
								<td>
									<?= ($programDetails['imprapproval']) ? $programDetails['imprapproval'] : "manual" ?>
                                </td>
								<td>
									<?= ($programDetails['imprmail']) ? $programDetails['imprmail'] : "manual" ?>
                                </td>
							</tr>
							<tr>
								<td>
									<img border="0" height="10" src="../images/click.gif" width="10" alt="" />- <?= $lpgm_click ?>
								 </td>
								 <td><?= $currSymbol . $programDetails['click'] ?></td>
								 <td>
									<?= ($programDetails['clickapproval']) ? $programDetails['clickapproval'] : "manual" ?>
                                </td>
								<td>
									<?= ($programDetails['clickmail']) ? $programDetails['clickmail'] : "manual" ?>
                                </td>
							</tr>
						 </tbody>
					 </table>
				</div>
			</div>
		</div>
	</div> -->
	<?php
	#   For multiple Commission structure 
	$count = ($commissionDetails) ? count($commissionDetails) : 1;
	for ($i = 1; $i <= $count; $i++) {
		#$j = $i+1;
	?>
		<div class="row">
			<div class="col-md-12">
				<div class="card strpied-tabled-with-hover">
					<div class="card-header">
						<div class="card-title">
							<h4><?= $lang_commission_structure . $i ?></h4>
						</div>
					</div>
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th><?= $lpgm_Type ?></th>
									<th><?= $lang_report_from ?></th>
									<th><?= $lang_report_to ?></th>
									<th><?= $lpgm_Commissions ?></th>
									<th><?= $lpgm_Approval ?></th>
									<th><?= $lpgm_EmailSettings ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<img border="0" height="10" src="../images/lead.gif" width="10" alt="" /> - <?= $lpgm_lead ?>
									</td>
									<td>
										<?= $commissionDetails[$i]['lead_from'] ?>
									</td>
									<td>
										<?= ($commissionDetails[$i]['lead_to']) ? $commissionDetails[$i]['lead_to'] : $lang_value_above ?>
									</td>
									<td>
										<?= $currSymbol . number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'], (float)$commissionDetails[$i]['leadrate']), 2, '.', '') ?>
									</td>
									<td>
										<?php
										if ($commissionDetails[$i]['leadapproval'] == "automatic") {  ?>
											<span class="p-1 badge-success text-white">automatic</span>


										<?php } else {
											echo '<span class="bg-warning p-1 text-white">manual</span>';
										} ?>
									</td>
									<td>
										<?php
										if ($commissionDetails[$i]['leadmail'] == "automatic") {  ?>
											<span class="p-1 badge-success text-white">automatic</span>


										<?php } else {
											echo '<span class="bg-warning p-1 text-white">manual</span>';
										} ?>

									</td>
								</tr>
								<tr>
									<td>
										<img border="0" height="10" src="../images/sale.gif" width="10" alt="" /> - <?= $lpgm_sale ?>
									</td>
									<td><?= $commissionDetails[$i]['sale_from'] ?></td>
									<td><?= ($commissionDetails[$i]['sale_to']) ? $commissionDetails[$i]['sale_to'] : $lang_value_above ?></td>
									<td>
										<?php
										if ($commissionDetails[$i]['saletype'] == "%") {
											echo $commissionDetails[$i]['salerate'] . "%";
										} else {

											echo $currSymbol . number_format(getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'], (float)$commissionDetails[$i]['salerate']), 2, '.', '');
										}
										?>
									</td>
									<td>
										<?php
										if ($commissionDetails[$i]['saleapproval'] == "automatic") {  ?>
											<span class="p-1 badge-success text-white">automatic</span>


										<?php } else {
											echo '<span class="bg-warning p-1 text-white">manual</span>';
										} ?>

									</td>
									<td>
										<?php
										if ($commissionDetails[$i]['salemail'] == "automatic") {  ?>
											<span class="p-1 badge-success text-white">automatic</span>


										<?php } else {
											echo '<span class="bg-warning p-1 text-white">manual</span>';
										} ?>

									</td>
								</tr>
								<!-- <tr>
									<td colspan="6">
										<b><? $recur_commission_head ?></b>
									</td>
								</tr> -->
								<!-- <tr>
									<td colspan="6">
										<? if ($commissionDetails[$i]['recur_sale'] == '1') {
										//	echo $recur_sale_head . " " . $commissionDetails[$i]['recur_percentage'] . " " . $recur_percent_month_head . " " . $commissionDetails[$i]['recur_period'] . " " . $recur_months_head;
										} else {
											//echo $recur_no_msg;
										} ?>
									</td>
								</tr> -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php }
	# END Multiple Commission Structure
	if (($programDetails['prgm_type'] == "0")) {
		$programDetails['prgm_fee']	= $program_fee;
		$programDetails['prgm_value']	= $program_value;
		$programDetails['prgm_type']	= $program_type;
	}
	if ($programId and $programDetails['prgm_fee']) {
	?>
		<div class="row">
			<div class="col-md-12">
				<div class="card strpied-tabled-with-hover">
					<div class="card-header">
						<div class="card-title">
							<h4><?= $lpgm_programfees ?></h4>
						</div>
					</div>
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<tbody>
								<tr>
									<th><?= $lpgm_programfees ?></th>
									<td><?php echo $currSymbol . getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'], $programDetails['prgm_fee']) ?>
								</tr>
								<tr>
									<th><?= $lpgm_programtype ?></th>
									<td><?php
										if ($programDetails['prgm_type'] == 2) {
											echo "Recurring ( " . getCurrencyValue(date("Y-m-d"), $_SESSION['CURRVALUE'], $programDetails['prgm_value']) . ") ";
										} else echo "One-Time";
										?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<div class="row">
		<div class="col-md-12">
			<div class="card strpied-tabled-with-hover">
				<div class="card-header">
					<div class="card-title">
						<h4><?= $lpgm_EmailandProgramSettings ?></h4>
					</div>
				</div>
				<div class="card-body table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<tr>
							<th><?= $lpgm_Sendemailtoaffiliatewhentransactionappears ?></th>
							<td><?= $programDetails['mailaffiliate'] ?></td>
						</tr>
						<tr>
							<th><?= $lpgm_Sendemailtomewhentransactionappears ?></th>
							<td><?= $programDetails['mailmerchant'] ?></td>
						</tr>
						<tr>
							<th><?= $lpgm_AffiliateApproval ?></th>
							<td><?= $programDetails['affiliateapproval'] ?></td>
						</tr>
						<tr>
							<th><?= $lpgm_OfferAvailable ?></th>
							<td>
								<?= ucwords(strtolower(str_replace(",", ", ", $programDetails['prgm_avail']))) ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php
	#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	# Display Advertising Links for the selected program
	if ($programId) {
	?>
		<!-- <div class="row">
		<div class="col-md-12">
			<div class="card strpied-tabled-with-hover">
				<div class="card-header">
					<div class="card-title">
						<h4><?= $lpgm_AdvertisingLinks ?></h4>
					</div>
				</div>
				<div class="card-body table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<?php
						$tot = $totallink[0] + $totallink[1] + $totallink[2] + $totallink[3] + $totallink[4];

						if ($tot == 0) { ?>
								<tr>
                                    <td   colspan="6">
										<?= $lpgm_NoLinksAddedtoThisProgram ?>
                                        <br/>
                                        <a href="index.php?Act=addlinks" ><?= $lpgm_ClickHereToAddLinks ?></a>
                                    </td>
								</tr>
								
							<?php } else { ?>
                                <tr>
                                    <td>

					             	<a href="index.php?Act=add_text">View-<?= $lpgm_Text ?>-Links-<?= $totallink[1] ?></a>

                                    </td>
                                	<td  >
                                		<a href="index.php?Act=add_textnew"><?= $lpgm_temptext ?>-<?= $totallink[5] ?></a>
                                	</td>
                                    <td  >
                                    	<a href="index.php?Act=add_html"> <?= $lpgm_HTML ?> -<?= $totallink[4] ?></a>
                                    </td>
                                    <td  >
                                    	<a href="index.php?Act=add_banner">View-<?= $lpgm_Banner ?>-Links-<?= $totallink[0] ?></a>
                                    </td>
                                   <td  >
                                    	<a href="index.php?Act=add_popup"><?= $lpgm_Popup ?>-<?= $totallink[2] ?></a>
                                    </td>
                                    <td  >
                                    	<a href="index.php?Act=add_flash"><?= $lpgm_Flash ?>-<?= $totallink[3] ?></a>
                                    </td>
                                </tr>
							<?
						}
							?>
					</table>
				</div>
			</div>
		</div>
		</div> -->
	<?php
	}
	# END Of Displaying Advertising Links for the selected program
	#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	?>
</form>
<!--<table border="0" cellpadding="0" cellspacing="0" width="70%" class="tablewbdr" align="center">
    <tr>
        <td align="center" height="1"><a href="index.php?Act=programs&mode=newprogram"> <b><?/*= $lpgm_CREATEPROGRAME ?></b></a></td>
    </tr>
    <tr>
        <td align="center" height="1"><? echo "<p align='center' > <span class='textred'>$msg</span></p>";*/ ?></td>
    </tr>
</table>-->

<form name="" method="post" action="">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="80%">
		<tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tablebdr">
					<!--<tr class="tdhead" height="19">
					<td width="60%" >
                    	<b><?/*=$lpgm_AffiliateProgram?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
                            <select name="programId" onchange="document.frm_program.action='index.php?Act=programs';document.frm_program.submit()">
                                <option value="" ><?=$lpgm_AllPrograms?></option>
                            	<? 
                            	while($row=mysqli_fetch_object($result)){
                                	if($programId=="$row->program_id")
                                    	$programName = "selected = 'selected'";
                                	else
                                    	$programName = "";
                            	?>
                                	<option <?=$programName?> value="<?=$row->program_id?>">
                                    <?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> 
                                	</option>
                            	<? } ?>
                            </select>
                  	</td>
					<td align="right" width="40%" class="textred" >					
						<? if($programId){ 
						 	echo $lang_Status." : ".ucwords($programDetails['status']);
						}*/ ?>
					</td>
				</tr>-->
					<? /*if($programId){ ?>
                <tr class="grid1">
                  	<td colspan="2" align="right">
					 	<a href='index.php?Act=programs&amp;mode=editprogram&amp;programId=<?=$programId?>'><?=$lpgm_Edit?>&raquo;</a> 
                        <br/>
						<a href="index.php?Act=uploadProducts&amp;pgmid=<?=$programId?>"><?=$lang_upload_prd?>&raquo;</a>
						<br/>
						<a href='index.php?Act=programs&amp;mode=deleteprogram&amp;programId=<?=$programId?>' id="del" onclick="return del_onclick()"><?=$lpgm_Delete?>&raquo;</a>
					</td>
				</tr>
				<?php }*/ ?>


					<tr>
						<td colspan="2">
							<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
								<!--<tr>
                                <td  height="45" width="50%" class="grid1" align="left">
                                	<b><a href="index.php?Act=listaffiliate&amp;pgmid=<?= ($programId) ? $programId : 0 ?>">
                                	<?= $lpgm_RegisteredAffiliates ?>&nbsp; -<?= $afftotal[0] ?></a></b>
                                </td>
                                <td  height="45" width="50%" class="grid1" align="right">
                                    <b><a href="index.php?Act=waitingaff&amp;pgmid=<?= ($programId) ? $programId : 0 ?>">
                                    <?= $lpgm_WaitingAffiliates ?> -<?= $afftotal[1] ?> </a></b>
                                </td>
							</tr>-->

								<!--	<tr>
                                <td colspan="2" height="45" align="center">
                                	<b><?= $lpgm_ProgramURL ?></b>
                                    <br/><?= $programDetails['url'] ?><br/>
                                </td>
							</tr>
 
                            <tr>
                                <td align="center" colspan="2" height="15" class="grid1">
                                <b><?= $lpgm_Description ?></b><br/></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2" height="81" class="grid1">
                                	<div style="width:50%; background:#FFFFFF; height:70px; text-align:left; border:thin solid #d9d9d9; overflow:auto;" align="center" >&nbsp;<?= nl2br($programDetails['description']) ?></div>
                                </td>
                            </tr> -->
							</table>
						</td>
					</tr>

					<!-- <tr>
                	<td colspan="2" >
                    	<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
							<tr>
								<td align="center" colspan="6" height="25" valign="middle" ><b><?= $lpgm_Commissions ?></b></td>
							</tr>  
                            <tr >
								<td align="center" class="tdhead" width="20%"><?= $lpgm_Type ?></td>
								<td align="center" class="tdhead" width="20%"><?= $lpgm_Commissions ?></td>
								<td align="center" class="tdhead" width="30%"><?= $lpgm_Approval ?></td>
								<td align="center" class="tdhead" width="30%"><?= $lpgm_EmailSettings ?></td>
							</tr>  
                            <tr>
                                <td align="left" >
                                <img alt="" border='0' height="10" src="../images/impression.gif" width="10" />&nbsp;-&nbsp;
                                <?= $lpgm_Impression ?></td>
                                <td align="center" >
								<?= $currSymbol . $programDetails['impression_rate'] ?>&nbsp;/&nbsp;<?= ($programDetails['impression_unit']) ? $programDetails['impression_unit'] : "1000" ?>
                                </td>
                                <td align="center" >
									<?= ($programDetails['imprapproval']) ? $programDetails['imprapproval'] : "manual" ?>
                                </td>
                                <td align="center" >
									<?= ($programDetails['imprmail']) ? $programDetails['imprmail'] : "manual" ?>
                                </td>
                            </tr>                  
                            <tr>
                                <td class="grid1" align="left">
                                    <img border="0" height="10" src="../images/click.gif" width="10" alt="" />- <?= $lpgm_click ?></td>
                                <td align="center"  class="grid1"><?= $currSymbol . $programDetails['click'] ?></td>
                                <td align="center"  class="grid1">
									<?= ($programDetails['clickapproval']) ? $programDetails['clickapproval'] : "manual" ?>
                                </td>
                                <td align="center"  class="grid1">
									<?= ($programDetails['clickmail']) ? $programDetails['clickmail'] : "manual" ?>
                                </td>
                            </tr>  
						</table>
              		</td>
				</tr>
                <tr><td colspan="2" >&nbsp;</td></tr>
                -->
					<?php
					#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
					#   For multiple Commission structure 
					/*$count = ($commissionDetails)?count($commissionDetails):1;
					for($i=1; $i<=$count; $i++) { 
						#$j = $i+1;
					?>
					<tr><td colspan="2" align="left" height="25" valign="middle" ><b><?=$lang_commission_structure.$i?></b></td></tr>
					<tr>
						<td colspan="2"  class="commissionTable" >
							<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr">
								<tr >
									<td align="center" class="tdhead" width="20%"><?=$lpgm_Type?></td>
									<td align="center" class="tdhead" width="10%"><?=$lang_report_from?></td>
									<td align="center" class="tdhead" width="10%"><?=$lang_report_to?></td>
									<td align="center" class="tdhead" width="20%"><?=$lpgm_Commissions?></td>
									<td align="center" class="tdhead" width="20%"><?=$lpgm_Approval?></td>
									<td align="center" class="tdhead" width="20%"><?=$lpgm_EmailSettings?></td>
								</tr>  
								<tr>
									<td  align="left" width="20%">
										<img border="0" height="10" src="../images/lead.gif" width="10" alt="" /> - <?=$lpgm_lead?></td>
									<td align="center" ><?=$commissionDetails[$i]['lead_from']?></td>
									<td align="center" ><?=($commissionDetails[$i]['lead_to'])?$commissionDetails[$i]['lead_to']:$lang_value_above?></td>
									<td align="center" ><?=$currSymbol.$commissionDetails[$i]['leadrate']?></td>
									<td align="center" >
										<?=($commissionDetails[$i]['leadapproval'])?$commissionDetails[$i]['leadapproval']:"manual"?>
                                    </td>
									<td align="center" >
										<?=($commissionDetails[$i]['leadmail'])?$commissionDetails[$i]['leadmail']:"manual"?>
                                    </td>
								</tr>
								<tr>
									<td  class="grid1" align="left">
										<img border="0" height="10" src="../images/sale.gif" width="10" alt="" /> - <?=$lpgm_sale?></td>
									<td align="center" class="grid1" ><?=$commissionDetails[$i]['sale_from']?></td>
									<td align="center" class="grid1" ><?=($commissionDetails[$i]['sale_to'])?$commissionDetails[$i]['sale_to']:$lang_value_above?></td>
									<td align="center"  class="grid1">
										<?=($commissionDetails[$i]['saletype']=="%")?$commissionDetails[$i]['saletype']:$currSymbol?><?=$commissionDetails[$i]['salerate']?>
                                    </td>
									<td align="center"  class="grid1">
										<?=($commissionDetails[$i]['saleapproval'])?$commissionDetails[$i]['saleapproval']:"manual"?>
                                    </td>
									<td align="center" class="grid1">
										<?=($commissionDetails[$i]['salemail'])?$commissionDetails[$i]['salemail']:"manual"?>
                                    </td>
								   
								</tr>
								<tr><td colspan="6">&nbsp;</td></tr>
								
								<tr>
									<td colspan="6" class="tdhead" align="center" height="25" valign="middle" >
										<b><?=$recur_commission_head?></b>
									</td>
								</tr>
								<tr>
									<td colspan="6" align="left" height="25">
										<? if($commissionDetails[$i]['recur_sale'] == '1') {  
										 echo $recur_sale_head." ".$commissionDetails[$i]['recur_percentage']." ".$recur_percent_month_head." ".$commissionDetails[$i]['recur_period']." ".$recur_months_head;
										} else { echo $recur_no_msg; } ?>
									</td>
								</tr>
								 <tr><td colspan="6" >&nbsp;</td></tr>
							</table>
						</td>
					</tr>
				   
					<?
					}  */
					# END Multiple Commission Structure
					#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


					/*if(($programDetails['prgm_type'] == "0")){
					 $programDetails['prgm_fee']	= $program_fee;
					 $programDetails['prgm_value']	= $program_value;
					 $programDetails['prgm_type']	= $program_type;
				}
                if($programId and $programDetails['prgm_fee']){
                ?>
                <tr>
                    <td colspan="2" class="tdhead" align="center" height="25" valign="middle" ><b><?=$lpgm_programfees?></b></td>
                </tr>
                <tr>
                    <td  class="grid1" height="25" valign="middle"><?=$lpgm_programfees?> </td>
                    <td align="center" class="grid1"><?php echo $currSymbol.$programDetails['prgm_fee']?>	</td>
                </tr>
                <tr>
                    <td  class="grid1" height="25" valign="middle"><?=$lpgm_programtype?> </td>
                    <td align="center" class="grid1">
                        <?php
                        if($programDetails['prgm_type']==2){
                            echo "Recurring ( ".$programDetails['prgm_value'].") ";
                        }else echo "One-Time";
                        ?>					
                    </td>
                </tr> 
                <? }*/ ?>

					<!--  <tr>
                	<td colspan="2" class="tdhead" align="center" height="25" valign="middle">
                    	<b><?= $lpgm_EmailandProgramSettings ?></b>					
                	</td>
                </tr> 
                <tr>
                    <td colspan="2" height="22">						
                        <table border="0" cellpadding="2" cellspacing="0" width="100%" class="tablewbdr" >
                            <tr>
                                <td class="2text" height="25" width="60%" align="left">
                                <?= $lpgm_Sendemailtoaffiliatewhentransactionappears ?></td>
                                <td  class="2text" height="25" width="40%" align="left"> <?= $programDetails['mailaffiliate'] ?></td>
                        	</tr>
                            <tr>
                                <td  class="2text" height="25" ><?= $lpgm_Sendemailtomewhentransactionappears ?></td>
                                <td  class="2text" height="25" ><?= $programDetails['mailmerchant'] ?></td>
                            </tr>
                            <tr>
                                <td  class="2text" height="25" ><?= $lpgm_AffiliateApproval ?></td>
                                <td  class="2text" height="25" ><?= $programDetails['affiliateapproval'] ?></td>
                            </tr>
                            <tr>
                                <td  class="2text" height="25" ><?= $lpgm_OfferAvailable ?></td>
                                <td  class="2text" height="25" >
                                <?= ucwords(strtolower(str_replace(",", ", ", $programDetails['prgm_avail']))) ?></td>
                            </tr>
                        </table>
                    </td> 
                </tr>-->

					<?php
					#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
					# Display Advertising Links for the selected program
					/* if($programId){  	
				?>  
 				<tr>
                    <td width="25%" class="tdhead" align="center" colspan="2">
                    <b><?=$lpgm_AdvertisingLinks?></b>
                    </td>
                </tr>   
                
                <tr>
                    <td height="57" colspan="2" >
                        <table border="0" cellpadding="0"  width="100%" class="tablewbdr" cellspacing="0" align="center">
                        	<?php
                            $tot=$totallink[0]+$totallink[1]+$totallink[2]+$totallink[3]+$totallink[4];
                        
							if($tot==0){ ?>
								<tr>
                                    <td width="20%" align="center" class="textred"  colspan="6"  height="20">
										<?=$lpgm_NoLinksAddedtoThisProgram?>
                                        <br/>
                                        <a href="index.php?Act=addlinks" ><?=$lpgm_ClickHereToAddLinks?></a>
                                    </td>
								</tr>
								
							<?php } else { ?>
                                <tr>
                                    <td width="16%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_text"><?=$lpgm_Text?>-<?=$totallink[1]?></a>
                                    </td>
                                	<td width="24%" align="center" class="grid1" >
                                		<a href="index.php?Act=add_textnew"><?=$lpgm_temptext?>-<?=$totallink[5]?></a>
                                	</td>
                                    <td width="14%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_html"> <?=$lpgm_HTML?> -<?=$totallink[4]?></a>
                                    </td>
                                    <td width="18%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_banner"><?=$lpgm_Banner?>-<?=$totallink[0]?></a>
                                    </td>
                                    <td width="15%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_popup"><?=$lpgm_Popup?>-<?=$totallink[2]?></a>
                                    </td>
                                    <td width="13%" align="center" class="grid1" >
                                    	<a href="index.php?Act=add_flash"><?=$lpgm_Flash?>-<?=$totallink[3]?></a>
                                    </td>
                                </tr>
							<?
							}   
                        ?>
                        </table>
                    </td>
                </tr>
                <?php    
				}  */
					# END Of Displaying Advertising Links for the selected program
					#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
					?>



				</table>
			</td>
		</tr>
	</table>
</form>

<script language="javascript" type="text/javascript">
	function del_onclick() {
		if (confirm("<?= $lpgm_DoyouWanttoDeleteThisProgram ?>")) {
			return true;
		} else {
			return false;
		}
	}
</script>