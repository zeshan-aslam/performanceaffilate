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
		<table border='0' align='center' cellpadding='0' cellspacing='0' width='70%' class='tablebdr'>
			<tr>
				<td width='100%' class='tdhead'>&nbsp;</td>
			</tr>
			<tr>
				<td width='100%' align="center" class="error"><? echo $lang_notjoined?></td>
			</tr>
			<tr>
				<td width='100%'>&nbsp;</td>
			</tr>
			<tr>
				<td width='100%'><h5 align='center'>
				<a href='index.php?Act=Affiliates&amp;joinstatus=notjoined'><? echo $lang_notjoined2 ?></a></h5></td>
			</tr>
			<tr>
				<td width='100%' ><p align='center'>&nbsp;</p></td>
			</tr>
		</table><br />
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
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="68%" >
		<tr>
		<td width="1%" height="3"></td>
		<td width="98%" height="3"></td>
		<td width="1%" height="3"></td>
		</tr>
	<tr>
	<td width="1%" height="19">&nbsp;</td>
	<td width="98%" height="19">
	<table border="0" align='center' cellpadding="0" cellspacing="0" width="90%" class="tablebdr">
	<tr>
	<td height="18" colspan="3" class="tdhead">
	<?=$lang_Getbanner?>
	<select name="programs" onchange="document.f1.submit()"><option value="All" ><?=$lang_home_all_pgms	?></option>
	
	
	<?
	while($row=mysqli_fetch_object($result))
	{
	if($programs=="$row->joinpgm_programid") $programName	="selected = 'selected''";
	else 									 $programName	="";
	
	?>
	<option <?=$programName?> value="<?=$row->joinpgm_programid?>"><?=$common_id?>:<?=$row->joinpgm_programid?>...<?=stripslashes($row->program_url)?> </option>
	<?
	}
	?>
	</select>
	
	</td>
	</tr>
	<!--Choose Sub-ID-->
	<?php include("subid_choose.php"); ?>
	<!--Choose Sub-ID-->
	
	<?php
	///////////// display  banners /////////////
	$bsql1	 =  $bsql;
	$bsql    .=  "LIMIT ".($page-1)*$lines.",".$lines; //adding page no
	$bres	 =  mysqli_query($con,$bsql);
	
	
	if(mysqli_num_rows($bres)<="0")
	{
	
	?>
	
	<tr>
	<td width="2%" height="19">&nbsp;</td>
	<td width="96%" height="19" class='textred'><b><?=$lang_banner_norec?></b></td>
	<td></td>
	</tr>
	<tr>
	<td height="19" colspan="3"></td>
	</tr>
	
	
	
	<? }
	
	else
	{
	
	while($row=mysqli_fetch_object($bres))
	{
	
	?>
	
	
	<tr>
	<td width="2%" height="19">&nbsp;</td>
	<td width="96%" height="19"></td>
	<td width="2%" height="19"></td>
	</tr>
	<tr>
	<td width="2%" height="18">&nbsp;&nbsp;
	</td>
	<td width="96%" height="18">
	<table cellspacing="0" cellpadding="5" width='501' border="1"  style="border-collapse: collapse" >
	<tr>
	<td height='1' width='593' class="grid2">
	<p align="center">
	<a href='<?=$row->banner_url?>' target='new'>
	<img src='<?=$row->banner_name?>' border='0' width="<?=$row->banner_width?>" height="<?=$row->banner_height?>" alt="" /></a></p></td>
	</tr>
                <!-- Added on 24th July 2009 to display the tracking URL -->
					<?php
                    //if the affiliate has chosen a sub id then add that also to the url
                    $subidurl = "&amp;subid=1";
                    if(!empty($subid)) $subidurl = "&amp;subid=$subid";
                    
                    $targetUrl = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id".$subidurl;
                    ?>
                    <!--  Display URL -->
                    <tr>
                        <td height='1' width='100%' class="grid1">
                        <span><?=$lang_TrackURL?>: <a href='<?=$targetUrl?>' target="new"><?php echo $targetUrl?></a></span>
                        </td>
                    </tr>
                <!-- END display the tracking URL -->
                
	<tr>
	<td  height='44' width='599' class="grid1">
	<?=$lang_Gettext_help?></td>
	
	
	</tr>
	<tr>
	<td  height='73' width='599' class="grid2" align="center">
	
	
	<textarea rows="4" name="S1" cols="75">
	
	<?
	
	//$track_site_url = urlencode($track_site_url);
	$track_site_url = str_replace(" ","%20",$track_site_url);
	$code = "<!-- START $title CODE -->\n<script language='javascript' type='text/javascript'>\nvar r=document.referrer;\n var counter = new Object() ;\ncounter.src = '$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id&r='+r;\n</script><script src=$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id$subidurl>\n</script>\n<!-- END $title CODE -->";
	echo $code;
	?>
	
	
	</textarea>
	</td>
	
	
	</tr>
	</table>
	
	</td>
	<td width="2%" height="18">
	</td>
	</tr>
	
	<?php
	
	} /// while closing
	
	?>
	
	<tr>
	<td width="2%" height="18">
	</td>
	<td width="96%" height="18">
	<?
	$pgsql=$bsql1;
	$url    ="index.php?Act=getbanner&programs=$programs";    //adding page nos
	include '../includes/show_pagenos.php';
	?>
	</td>
	<td width="2%" height="18">&nbsp;&nbsp;
	</td>
	
	</tr>
	<?php				 
	}
	?>
	<tr>
	<td height="19" colspan="3" class="tdhead">&nbsp;</td>
	</tr>
	</table>
	</td>
	<td width="1%" height="19">
	</td>
	</tr>
	<tr>
	<td width="1%" height="19">&nbsp;</td>
	<td width="98%" height="19">&nbsp;</td>
	<td width="1%" height="19">&nbsp;</td>
	</tr>
	<tr>
	<td width="1%" height="19">&nbsp;</td>
	<td width="98%" height="19">&nbsp;</td>
	<td width="1%" height="19">&nbsp;</td>
	</tr>
	</table>
	
	</form>
	
	<?
	}
	?>