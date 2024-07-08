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
	function getStatus($programId, $affiliateId)
	{
		$con = $GLOBALS["con"];
		
		$sql = "SELECT joinpgm_status FROM partners_joinpgm 
			WHERE joinpgm_programid='$programId' AND joinpgm_affiliateid='$affiliateId' ";	
		$res = mysqli_query($con,$sql);  
		if(mysqli_num_rows($res) > 0) {
			list($status) = mysqli_fetch_row($res);
		}	
		else 
			$status = "notjoined";
		return $status;
	}

	
	/*$AFFILIATEID       = $_SESSION['AFFILIATEID'];           //affilaiteid
	$page              = trim($_GET['page']);       */          //page no
	$cat               = trim($_REQUEST['category']);               //selected category
	$pgm               = trim($_REQUEST['pgm']);             //selected pgm
	$searchtxt         = trim($_REQUEST['searchtxt']);          //selected pgm(search)
 
	$joinstatus        = trim($_REQUEST['joinstatus']);          //joinpgm status
	if(empty($joinstatus))
		$joinstatus		= $_SESSION['JOINSTATUS'];          //checking status for search
	else
		$_SESSION['JOINSTATUS']	= $joinstatus;
	
	if(empty($page))                                 //getting page no
		$page		= $partners->getpage();
	
	$sql = "SELECT * FROM partners_program, partners_joinpgm, partners_merchant WHERE program_status LIKE ('active')
				AND joinpgm_programid=program_id AND program_merchantid=merchant_id AND joinpgm_affiliateid='$AFFILIATEID'  ";
	
    switch ($joinstatus){
		case "All":
			$sql = "SELECT * FROM partners_program, partners_merchant WHERE program_status LIKE ('active')
						AND program_merchantid=merchant_id ";
		break;

		case "waiting":
			$sql .= " AND  joinpgm_status='waiting' ";
		break;

		case "suspend":
			$sql .= " AND  joinpgm_status='suspend' ";
		break;

		case "approved":
			$sql .= " AND  joinpgm_status='approved' ";
		break;

		case "notjoined":
			$res_aff_pgms = mysqli_query($con,$sql);
			if(mysqli_num_rows($res_aff_pgms) > 0) {
				while($row_aff_pgms = mysqli_fetch_object($res_aff_pgms)) {
					$joinedPgms .= $row_aff_pgms->joinpgm_programid.",";
				}	
				$joinedPgms = trim($joinedPgms,",");
				
				$sql = "SELECT * FROM partners_program,  partners_merchant WHERE program_status LIKE ('active')
				AND  program_merchantid=merchant_id AND program_id NOT IN ($joinedPgms)  ";
			} else {
				$sql = "SELECT * FROM partners_program,  partners_merchant WHERE program_status LIKE ('active')
				AND  program_merchantid=merchant_id ";
			}
 		break;
		
       	case 'search':        //search particular pgm
			$sql = "SELECT * FROM partners_program,  partners_merchant WHERE program_status LIKE ('active')
			AND  program_merchantid=merchant_id AND program_url like '%".addslashes($searchtxt)."%'  ";
		break;

       	case 'pgmwise':       //pgm wise search
			$sql = "SELECT * FROM partners_program,  partners_merchant WHERE  
			  program_merchantid=merchant_id AND program_id='$pgm'  "; 
		break;
	
		case 'catwise':
			$sql = "SELECT * FROM partners_program,  partners_merchant WHERE program_status LIKE ('active')
			AND  program_merchantid=merchant_id AND merchant_category='".addslashes($cat)."'  ";
		break;


	}  
	
	$res_page = mysqli_query($con,$sql);
	$_SESSION['SESS_TOTALCOUNT'] = mysqli_num_rows($res_page);
	$sql .= " LIMIT ".($page-1)*$lines.",".$lines; #echo "sql =".$sql;
	$res = mysqli_query($con,$sql);
	 
	if(mysqli_num_rows($res) > 0) 
	{	?>

	<script  src="../includes/iAjax.js" type="text/javascript" ></script>
   
    <form id="SearchResultsForms"  name="SearchResultsForm" method="post" action="affiliates_process.php?page=<?=$page?>&amp;joinstatus=<?=$joinstatus?>">
		<div class="row"> 
			<div class="col-md-12"> 
				<div class="card strpied-tabled-with-hover">
					<div class="card-header">				
						<h4 class="card-title"><?=$lpgm_Commissions?></h4>
					</div>
					<div class="card-body table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th><?=$lang_affiliate_head_url?></th>
									<th><?=$lang_affiliate_head_merchant?></th>
									<th><?=$lang_affiliate_head_status?></th>
									<th><?=$lang_affiliate_head_action?></th>
								</tr>
							</thead>
							<tbody> 
								<?php
								while($row = mysqli_fetch_object($res)) {
								 $status = getStatus($row->program_id, $AFFILIATEID);
								 $check="~".$status."~".$row->program_id."~".$row->program_merchantid;
								?>
								<tr>
									<td><input type="checkbox" name="elements[]" value="<?=$check?>" />&nbsp;<?=$row->program_url?></td>
									<td><a href="index.php?Act=viewprofile&amp;id=<?=$row->program_merchantid?>&amp;pgmid=<?=$row->program_id?>&amp;status=<?=$status?>"><?=$row->merchant_company?></a></td>
									<td><a href="#displayBox" onclick="javascript:ShowCommissionDetails('<?=$row->program_id?>','<?=$AFFILIATEID?>');"><?=$lang_viewCommision?></a>&nbsp;<img src="../images/<?=$status?>.gif" height="<?=$icon_height?>" width="<?=$icon_width?>" alt="" /></td>
									<td>
									<?php
									if($status == 'suspend') { ?>
										<?=$lang_affiliate_blocked?>
										&nbsp;-&nbsp;<a href='affiliates_process.php?page=<?=$page?>&amp;choice=rejoin&amp;pgmid=<?=$row->program_id?>&amp;joinstatus=<?=$joinstatus?>'><?=$lang_affiliate_rejoin?></a>
									<?php 
									} else if($status=='waiting') {
										echo $lang_affiliate_waiting;
									} elseif($status=='notjoined') { ?>
										<a href="affiliates_process.php?page=<?=$page?>&amp;joinstatus=<?=$joinstatus?>&amp;sub='action'&amp;id=<?=$check?>" onclick="return validatejoin()  "><?=$lang_affiliate_joinpgm?></a>
									<?php 
									} else if($status=='approved') { ?>
										<a href="index.php?Act=Getlinks"><?=$lang_affiliate_getlinks?></a><!-- || <a href="index.php?Act=products&amp;pgmid=<?=$row->program_id?>"><?=$lang_pdt_files?></a>-->							
									<?	} ?>	
									</td>
								</tr>
								<?php
									}
								?>
							</tbody>
					</table>
					<? include '../includes/paging.php';  ?>
				</div>
			</div>
		</div>
	 </div>
	 
	 <div class="row"> 
		<div class="col-md-12"> 
			<div class="card strpied-tabled-with-hover">
				<div class="card-body table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<tbody>
							 <tr> 
								<td><img src="../images/arrow_ltr.gif" alt="" />
									<a href="javascript:;" onclick="flagall()"  > <?=$lang_affiliate_head_check?>/</a>
									<a href="javascript:;" onclick="unflagall()"> <?=$lang_affiliate_head_uncheck?>&nbsp;&nbsp;&nbsp;</a>
										<input type="hidden" name="hidden_choice" value="" />
										
									   <button value="<?=$lang_affiliate_head_join?>" type="button" name="sub" class="btn btn-fill btn-info" onclick=" return validatejoin()"><?=$lang_affiliate_head_join?></button>
									  <button type="button" class="btn btn-fill btn-info" type="button" name="sub"  value="<?=$lang_affiliate_head_suspend?>" style="width: 110" onclick=" return validatesuspend()"><?=$lang_affiliate_head_suspend?></button>
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
					<table class="table table-hover table-striped">
						<tbody>
							<tr>
								<td><?=$norec?></td>
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
<div class="sweet-container pos_rel">
	 <div id="div_fadded" class="sweet-overlay" tabindex="-1" style="display: none; opacity: 1.05;"></div>    
	<div class="custompopup sweet-alert show-sweet-alert visible" id="show_viewcommission" style="display: none;">
		<div class="viewcommission_data"></div>
		<div id="loadershow" style="display:none; vertical-align:bottom; width:100%; " align="center" >
			<img src="images/wait.gif" border="0" alt="Loading" /><br/>
			<b>Loading.........</b>
		</div>  
	</div>
</div>
<script language="javascript" type="text/javascript">
	
	//check all
	function flagall(){
		for (i=0;i<(document.SearchResultsForm.elements.length);i++)
		{
			document.SearchResultsForm.elements[i].checked = true;
		}
	}
	
	//uncheck all
	function unflagall()
	{
		for (i=0;i<(document.SearchResultsForm.elements.length);i++)
		{
			document.SearchResultsForm.elements[i].checked = false;
		}
	}

	//confirm join
	function validatejoin()
	{
	
		  swal({
                title: "Are you sure?",
                text: "<?php echo $lang_affiliate_join_msg;?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
            }, function(isConfirm) {
                if (isConfirm) {
                   document.SearchResultsForm.hidden_choice.value = "Join Selected";
				   jQuery("#SearchResultsForms").submit();
                } else {
                 swal("Cancelled", "", "error");
                }
            });
	
		/* var del=window.confirm("<?=$lang_affiliate_join_msg?>") ;
		if (del)
		{
			document.SearchResultsForm.hidden_choice.value = "Join Selected";
			return true;
		}
		else
		return false; */
	}
	
	//confirm suspend
	function validatesuspend()
	{
		 swal({
                title: "Are you sure?",
                text: "<?=$lang_affiliate_suspend_msg?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
            }, function(isConfirm) {
                if (isConfirm) {
                  document.SearchResultsForm.hidden_choice.value = "Suspend Selected";
				   jQuery("#SearchResultsForms").submit();
                } else {
                 swal("Cancelled", "", "error");
                }
            });
		/* var del=window.confirm("<?=$lang_affiliate_suspend_msg?>") ;
		if (del)
		{
			
			return true;
		}
		else
		return false; */
	}
	
	
	function ShowCommissionDetails(programId, affiliateId)
	{
		if(programId){
			jQuery('#loadershow').show();
			document.getElementById('div_fadded').style.display='block';
			document.getElementById('show_viewcommission').style.display='block';
			//document.getElementById('div_faded').className="showProgramCommissionFadeDiv";
			var urls = "CommissionDetails.php?programId="+programId+'&affiliateId='+affiliateId;
			//ajaxpage(url,'viewcommission_data');
			jQuery.ajax({
				url:urls,
				type:'GET',
				success: function(html){
					jQuery('#loadershow').hide();
					jQuery('.viewcommission_data').html(html);
				}	
			});
		}
	}
	
	function CloseCommissionDetails()
	{
			document.getElementById('div_fadded').style.display='none';
			document.getElementById('show_viewcommission').style.display='none';
			jQuery('.viewcommission_data').html('');
	}
</script>                                
