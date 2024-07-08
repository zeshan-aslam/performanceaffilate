<?php

	$pgmid  = intval($_GET['pgmid']);
	$mode   = $_GET['mode'];
	$status = trim($_GET['status']);
	
	if($mode=="changeStat"){
		$sql = " UPDATE partners_upload SET upload_status='$change' WHERE upload_id = '$id'";
		mysqli_query($con,$sql);
	}
	
	$sql 	= " SELECT * FROM partners_upload WHERE upload_programid = '$pgmid' ";
	if(!empty($status)){
		$sql .= " AND upload_status ='$status' ";
	}
	else 
		$sql .= " AND upload_status not like 'deleted' ";
		$ret = mysqli_query($con,$sql) or die("You have an error while processing sql query ".mysqli_error($con) );
?>
 <br/>
         <table width="80%" cellpadding="5" cellspacing="0" border='0' class="tablebdr" align="center">
          <tr>
	        <td class="tdhead" colspan="4">Product File(s) Management
	        </td>
	      </tr>
          <?
			if(mysqli_num_rows($ret)>0){
				$i =1;
			while($row = mysqli_fetch_object($ret)){
				$status1 			=  $row->upload_status;
				if($status1=="Active") {
					$chn 			= "Inactive";
					$chn_caption 	= "Inactivate";
				}else{
					$chn 			= "Active";
					$chn_caption 	= "Activate";
				}
				?>
				<tr>
					<td >&nbsp;</td>
					<td ><b><?=$i?>.</b></td>
					<td class="textred"><a href="../images/uploads/<?=$row->upload_filename?>" target="_blank"><?=$row->upload_actualfile?></a></td>
					<td class="textred"><a href="index.php?Act=products&amp;pgmid=<?=$pgmid?>&amp;change=<?=$chn?>&amp;mode=changeStat&amp;id=<?=$row->upload_id?>&amp;status=<?=$status?>"><?=$chn_caption?> </a>
					</td>
				</tr>
				<?
				 $i++;
				}
          }else{
          ?>
           <tr>
	        <td class="textred" colspan="4" align="center">Sorry No Product File(s) Found
	        </td>
	      </tr>
          <?
          }
          ?>

         </table>