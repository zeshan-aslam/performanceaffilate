<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  programDetails.php        	      	            */
/*     CREATED ON     :  14/SEP/2009                                    */

# Program Details List 
# 	 
#	
/************************************************************************/

# Gets variables
	$joinstatus 	= trim($_REQUEST['joinstatus']);  
	$page        	= intval(trim($_REQUEST['page']));    
	$cat         	= trim($_GET['category']);      
	$pgm       		= intval(trim($_GET['pgm']));        
	

/************************intialisation*****************************************/
	if(empty($joinstatus))
		$joinstatus="All";
	if(empty($page))                                 
		$page=$partners->getpage();
/***************************************************************************/

	switch ($joinstatus)
	{
		case 'catwise':         //category wise seacrh
			$sql_list = "SELECT * FROM partners_merchant, partners_program WHERE program_status='active' 
				AND program_merchantid = merchant_id ";
			 if(!empty($cat))$sql_list.= " and merchant_category='".addslashes($cat)."' ";
		 break;
		
		case 'pgmwise':       //pgm wise search
			$sql_list = "SELECT * FROM partners_merchant, partners_program WHERE program_status='active' 
				AND program_merchantid = merchant_id ";
			 if(!empty($pgm))$sql_list.= " and program_id='$pgm' ";
		 break;
	
		default:              //all pgms
			$sql_list = "SELECT * FROM partners_merchant, partners_program WHERE program_status='active' 
				AND program_merchantid = merchant_id ";
		break;
		
	}
	
	if(!empty($SortBy))  
		$sql_list .= " order by $SortBy $OrderByValue ";
	$pgsql=$sql_list;
	$sql_list  .= " LIMIT ".($page-1)*$lines.",".$lines;
	$res_list   = mysqli_query($con, $sql_list);  


   	if(mysqli_num_rows($res_list)>0) {  ?>
		<script  src="includes/iAjax.js" type="text/javascript" ></script>
        <table  cellpadding="1" cellspacing="0"  width="95%" class="tablewbdr" align="center" >
    	<?php
		while($row_list = mysqli_fetch_object($res_list)) {
		?> 
            <tr>
            
                <td width="40%"  align="left"  height="20"><?=substr(stripslashes($row_list->program_url),0,25)?></td>
                <td width="30%"   align="left"  height="20"><?=$row_list->merchant_company;?></td>
                <td width="20%"  align="center"  height="20"><a href="#displayBox" onclick="javascript:ShowCommissionDetails('<?=$row_list->program_id?>');"><?=$lang_viewCommision?></a></td>
                <td width="10%"   align="center"  height="20"><a href="index.php?Act=affil_regi"><?=$directory_help_join?></a></td>
            
            </tr>
            
		<?php
		}	?>
    	</table>
    <?php    
	}
	else
	{	?>
        <table width="100%" align="center">
             <tr>
                <td align="center" class="red"><?=$norec?> </td>
             </tr>
        </table>
    <?php
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

	function ShowCommissionDetails(programId)
	{
		if(programId){
			
			document.getElementById('div_faded').style.display='block';
			document.getElementById('div_ViewCommission').style.display='block';
			document.getElementById('div_faded').className="showProgramCommissionFadeDiv";
			var url = "CommissionDetails.php?programId="+programId;
			ajaxpage(url,'div_ViewCommission');
			
		}
	}
	
	function CloseCommissionDetails()
	{
			document.getElementById('div_faded').style.display='none';
			document.getElementById('div_ViewCommission').style.display='none';
	}
	
</script>                                


