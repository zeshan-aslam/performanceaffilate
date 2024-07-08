<?

$affiliatename	= trim(stripslashes($_POST['affiliate']));
$searchbut		= trim($_POST['search'])  ;
if(empty($affiliatename))  	$affiliatename	  = trim(stripslashes($_GET['affiliate']));
if($searchbut=="Search")    $_SESSION['SESSIONSTATUS']="all";

echo    "<form name=\"searchaffiliateform\" method=\"post\" action=\"index.php?Act=affiliates\"> ";
?> 	
	<div class="row"> 
		<div class="col-md-8">
			<div class="card stacked-form"> 
				<div class="card-header">
					<h4 class="card-title"><?=$lang_report_searchaff?></h4>
				</div>			
				<div class="card-body">
					<div class="row"> 
						<div class="col-md-12">
							<div class="form-group">
								<label><?=$laff_Affiliate?></label>
								<div class="input-group input_icon">
									<i class="nc-icon nc-zoom-split"></i>
									<input class="form-control" type="text" name="affiliate" value="<?=$affiliate?>" />
								</div>						
							</div>
						</div> 
						<div class="col-md-12">
							<div class="form-group">
								<input class="btn btn-fill btn-info" type="submit" name="search" value="<?=$affl_search?>" />
							</div>
						</div> 
					</div>
				</div>
			</div>
		</div>	 
	</div>
<?php
echo "</form>";

?>