<?
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	
	if(empty($page)) 
		$page    = $partners->getpage();

	# get all approced programs for drop down box
	$sql   	= " SELECT  joinpgm_programid, program_url FROM partners_joinpgm, partners_program
				WHERE joinpgm_affiliateid =  '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' 
				AND program_id=joinpgm_programid "; 
	
	$result = mysqli_query($con,$sql);
	if(mysqli_num_rows($result)<"1"){
	?>
<div class="row">  
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<span class="error"><? echo $lang_notjoined?></span>
				<h5 align='center'><a href='index.php?Act=Affiliates&amp;joinstatus=notjoined'><? echo $lang_notjoined2 ?></a></h5>
			</div>	
		</div>	 
	</div>	
</div>   
		<?
	}
	else{
	$programs	=	trim($_POST['programs']);
	if(empty($programs)) 	
		$programs	=	trim($_GET['programs']);
	if (empty($programs)){
		$programs	=	"All";
		$link		=	0;
	}

	switch ($programs){
		case 'All';    //all pgm
			$bsql	= " SELECT * FROM partners_banner, partners_joinpgm WHERE banner_status ='active' 
						AND joinpgm_affiliateid = '$AFFILIATEID' AND joinpgm_status = 'approved' 
						AND joinpgm_programid= banner_programid " ;
			$pgmid		= 0;
			$link		= 0;
			$allresult	= "--";
			$flag		= 0;
		break;
		
		default:
			$bsql   = "SELECT * FROM partners_banner where banner_programid = '$programs' and banner_status ='active'";
	}

	include 'getadd.php' ;

 ?>

	<form name="f1" action="index.php?Act=getbanner" method="post">
		<div class="row"> 
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						
						<div class="form-group">
							<label><?=$lang_Getbanner?></label>
							<select name="programs" onchange="document.f1.submit()" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
							<option value="All" ><?=$lang_home_all_pgms	?></option>
                               <?  while($row=mysqli_fetch_object($result))

                               {
                               if($programs=="$row->joinpgm_programid")
                                      $programName="selected";
                               else
                                $programName="";

                               ?>
                                 <option <?=$programName?> value="<?=$row->joinpgm_programid?>"><?=$common_id?>:<?=$row->joinpgm_programid?>...<?=stripslashes($row->program_url)?> </option>
                               <?
                               }
                               ?> 
    					</select>
					</div>
					<!--Choose Sub-ID-->
					<?php include("subid_choose.php"); ?>
					<!--Choose Sub-ID-->
				</div>	
			</div>	 
		</div>	
		<!--<div class="col-md-12">
			<div class="card">
				<div class="card-body">	  
				<?php
				///////////// display  banners /////////////
				/*$bsql1	 =  $bsql;
				$bsql    .=  "LIMIT ".($page-1)*$lines.",".$lines; //adding page no
				$bres	 =  mysqli_query($con,$bsql);
					
				if(mysqli_num_rows($bres)<="0")
				{	
				?>
				 <p class="textred"><b><?=$lang_banner_norec?></b></p>	
				
				<? }				
				else
				{				
				while($row = mysqli_fetch_object($bres))
				{*/				
				?>
				<!--<div class="affi_banner_img">
					<a href='<?/*=$row->banner_url?>' target='new'>
					<img src='<?=$row->banner_name?>' border='0' width="<?=$row->banner_width?>" height="<?=$row->banner_height*/?>"></a>  
				</div>-->
	
                <!-- Added on 24th July 2009 to display the tracking URL -->
					<?php
                    //if the affiliate has chosen a sub id then add that also to the url
                   /* $subidurl = "&amp;subid=1";
                    if(!empty($subid)) $subidurl = "&amp;subid=$subid";
                    
                    $targetUrl = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id".$subidurl;
                    ?>
                    <!--  Display URL -->
                    
                   <span><?=$lang_TrackURL?>: <a href='<?=$targetUrl?>' target="new"><?php echo $targetUrl?></a></span>
					<!-- END display the tracking URL -->
					
					<p><?=$lang_Gettext_help?></p>
					
					<div class="form-group">
						<textarea class="form-control textarea_contrl" rows="14" name="S1"><?						
						//$track_site_url = urlencode($track_site_url);
						$track_site_url = str_replace(" ","%20",$track_site_url);
						
	$url = $track_site_url."/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id&r=+r"; */
						
						/*$code = "<!-- START $title CODE -->\n<script language='javascript' type='text/javascript'>\nvar r=document.referrer;\n var counter = new Object() ;\ncounter.src = '$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id&r='+r;\n</script><script src=$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id$subidurl>\n</script>\n<!-- END $title CODE -->";*/
										 		
						/*$code = "<!-- START $title CODE -->\n<a href='$url'>\n<img src='<?=$row->banner_name?>' border='0' />\n</a>\n<!-- END $title CODE -->";
						 
						echo $code; 
						?>   
					</textarea>
				</div> 
				<?php				
					} /// while closing
				?>
				<?
				$pgsql=$bsql1;
				$url    ="index.php?Act=getbanner&programs=$programs";    //adding page nos
				include '../includes/show_pagenos.php';
				?>	
				<?php				 
				}*/
				?>
				<!--</div> 	
			</div> 	
		</div>-->	
	</div> 	
</form> 
	
	<?
	}
	?>