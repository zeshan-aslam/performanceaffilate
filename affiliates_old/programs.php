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
        
        <form name="SearchResultsForm" method="post" action="affiliates_process.php?page=<?=$page?>&amp;joinstatus=<?=$joinstatus?>">
        <table  cellpadding="1" cellspacing="0"  width="95%" class="tablebdr" align="center" border="0" >
            <tr class="tdhead">
                <td width="5%" height="20" align="center">&nbsp;</td>
                <td width="30%" align="left"><?=$lang_affiliate_head_url?></td>
                <td width="25%" align="left"><?=$lang_affiliate_head_merchant?></td>
                <td width="15%" align="center" >&nbsp;</td>
                <td width="5%"  align="center"><?=$lang_affiliate_head_status?></td>
                <td width="20%"  align="center"><?=$lang_affiliate_head_action?></td>
            </tr>
            <tr>
            	<td height="10" colspan="6" ></td>
            </tr>
			<?php
			while($row = mysqli_fetch_object($res)) { 
			
				 $status = getStatus($row->program_id, $AFFILIATEID);
				 $check="~".$status."~".$row->program_id."~".$row->program_merchantid;
			?>
	
                <tr >
                    <td align="center" height="20"><input type="checkbox" name="elements[]" value="<?=$check?>" /></td>
                    <td align="left"><?=$row->program_url?></td>
                    <td align="left">
						<a href="index.php?Act=viewprofile&amp;id=<?=$row->program_merchantid?>&amp;pgmid=<?=$row->program_id?>&amp;status=<?=$status?>"><?=$row->merchant_company?></a>
                    </td>
                    <td align="center" >
                    	<a href="#displayBox" onclick="javascript:ShowCommissionDetails('<?=$row->program_id?>','<?=$AFFILIATEID?>');"><?=$lang_viewCommision?></a>
                    </td>
                    <td align="center">
						<img src="../images/<?=$status?>.gif" height="<?=$icon_height?>" width="<?=$icon_width?>" alt="" />
                    </td>
                    <td align="center">
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
							<a href="index.php?Act=Getlinks"><?=$lang_affiliate_getlinks?></a> || <a href="index.php?Act=products&amp;pgmid=<?=$row->program_id?>"><?=$lang_pdt_files?></a>							
						<?	} ?>	
                    </td>
                </tr>
	
			<?php
			}
            ?>        
            <tr>
                <td colspan="6" align="center" >
                    <? include '../includes/paging.php';  ?>	
                </td>
            </tr>

		</table>
        
        <table  cellpadding="0" cellspacing="1"  width="95%" class="tablewbdr" align="center">
             <tr>
                    <td width="100%" align="left" height="30" >
                        <img src="../images/arrow_ltr.gif" alt="" />
                        <a href="#" onclick="flagall()"  > <?=$lang_affiliate_head_check?>/</a>
                        <a href="#" onclick="unflagall()"> <?=$lang_affiliate_head_uncheck?>&nbsp;&nbsp;&nbsp;</a>
                            <input type="hidden" name="hidden_choice" value="" />
                          <input type="submit" name="sub" value="<?=$lang_affiliate_head_join?>" style="width: 110" onclick="return validatejoin()" />
                          <input type="submit" name="sub"  value="<?=$lang_affiliate_head_suspend?>" style="width: 110" onclick=" return validatesuspend()" />
                   </td>
            </tr>
        </table>
        
    	</form>
	<?php
	} else {
	?>
		<table width="100%" align="center">
			<tr>
				<td align="center" class="error" height="50" valign="bottom"><?=$norec?> </td>
			</tr>
		</table>
	<?
	}
	
?>
<div id="div_faded" style="display:none;"></div>
<div id="div_ViewCommission" style="display:none;" class="showProgramCommission" >
	<div style="height:250px; width:100%; vertical-align:bottom;" align="center" >&nbsp;</div>
    
	<div style=" vertical-align:bottom; width:100%; " align="center" >
    	<img src="images/wait.gif" border="0" alt="Loading" /><br/>
        <b>Loading.........</b>
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
		var del=window.confirm("<?=$lang_affiliate_join_msg?>") ;
		if (del)
		{
			document.SearchResultsForm.hidden_choice.value = "Join Selected";
			return true;
		}
		else
		return false;
	}
	
	//confirm suspend
	function validatesuspend()
	{
		var del=window.confirm("<?=$lang_affiliate_suspend_msg?>") ;
		if (del)
		{
			document.SearchResultsForm.hidden_choice.value = "Suspend Selected";
			return true;
		}
		else
		return false;
	}
	
	
	function ShowCommissionDetails(programId, affiliateId)
	{
		if(programId){
			
			document.getElementById('div_faded').style.display='block';
			document.getElementById('div_ViewCommission').style.display='block';
			document.getElementById('div_faded').className="showProgramCommissionFadeDiv";
			var url = "CommissionDetails.php?programId="+programId+'&affiliateId='+affiliateId;
			ajaxpage(url,'div_ViewCommission');
			
		}
	}
	
	function CloseCommissionDetails()
	{
			document.getElementById('div_faded').style.display='none';
			document.getElementById('div_ViewCommission').style.display='none';
	}
</script>                                



