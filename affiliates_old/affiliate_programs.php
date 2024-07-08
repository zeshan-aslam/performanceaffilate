<br/>
<?php
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$AFFILIATEID       =$_SESSION['AFFILIATEID'];           //affilaiteid
	$page              =trim($_GET['page']);                //page no
	$joinstatus        =trim($_GET['joinstatus']);          //joinpgm status
	$cat               =trim($_GET['category']);            //selected category
	$pgm               =trim($_GET['pgm']);                 //selected pgm
	$searchtxt         =trim($_POST['searchtxt']);          //selected pgm(search)

	if(empty($joinstatus))
		$joinstatus		= $_SESSION['JOINSTATUS'];          //checking status for search
	else
		$_SESSION['JOINSTATUS']	= $joinstatus;
	
	if(empty($page))                                 //getting page no
		$page		= $partners->getpage();
	
	# function get infmn of joined and unjoined pgms
    function GetStatus($pgmid){
		$AFFILIATEID	= $_SESSION['AFFILIATEID'];    //get affiliateid
		$sql			= "select * from partners_joinpgm where joinpgm_programid=$pgmid and joinpgm_affiliateid=$AFFILIATEID";
		$ret			= mysqli_query($con,$sql);
		if (mysqli_num_rows($ret)>0){
			$row		= mysqli_fetch_object($ret);
			$status		= $row->joinpgm_status;        //join status
		}
		else{
			$status		= "notjoined";                  //not joined
		}
		return $status;
     }    ///function ends here

   	# serach query
    switch ($joinstatus){
		case 'All':
			$sql	= " select * from partners_program,partners_firstlevel where program_status like ('active') 
						and firstlevel_programid=program_id   ";
		break;

         case 'waiting':        //waiting programs
           $sql         =" SELECT   * " ;
           $sql         =$sql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $sql         =$sql." WHERE joinpgm_status='waiting' and c.joinpgm_affiliateid=$AFFILIATEID and program_status like ('active') and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
           break;

         case 'approved':      //approved pgms
           $sql         =" SELECT   * " ;
           $sql         =$sql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $sql         =$sql." WHERE joinpgm_status='approved' and c.joinpgm_affiliateid=$AFFILIATEID and  program_status like ('active') and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
           break;

        case 'suspend':       //suspended pgms
           $sql         =" SELECT   * " ;
           $sql         =$sql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
           $sql         =$sql." WHERE joinpgm_status='suspend' and c.joinpgm_affiliateid=$AFFILIATEID and program_status like ('active')  and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
           break;

        case 'notjoined':     //not joined pgms



            $query="select * from partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID";
            $ret=mysqli_query($con,$query);     //finding joined pgms///////////////////

            // finding  joined pgms id/////////////
            $a  ="(";
            $i  =1;
            while($row=mysqli_fetch_object($ret))
            {
              if (mysqli_num_rows($ret)==$i)
                 $a  =$a.$row->joinpgm_programid;
              else
                 $a  =$a.$row->joinpgm_programid.",";
              $i=$i+1;
            }
            $a  .= ")";
            ///////////////////////////////////////

            if (mysqli_num_rows($ret)==0)          //no joined pgms
                $sql         ="select * from partners_program,partners_firstlevel where program_status like ('active') and firstlevel_programid=program_id   ";
            else                                  //pgms which are not joined
                $sql         ="select * from partners_program,partners_firstlevel where program_status like ('active') and program_id not in $a and  firstlevel_programid=program_id ";
             break;

       case 'catwise':         //category wise seacrh
             $sql="select * from partners_merchant,partners_program,partners_firstlevel where program_status='active' and merchant_category='$cat' and merchant_id=program_merchantid and  firstlevel_programid=program_id "   ;
             break;

       case 'pgmwise':       //pgm wise search
             $sql="select * from partners_program,partners_firstlevel where program_id=$pgm and  firstlevel_programid=program_id "   ;
             break;

       case 'search':        //search particular pgm
             $sql="select * from partners_program,partners_firstlevel where program_url like '%$searchtxt%' and program_status='active' and  firstlevel_programid=program_id "   ;
             break;

       case 'myprograms':     //search for only myprograms
             $sql="select * from partners_program,partners_firstlevel,partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID and joinpgm_programid=program_id and  firstlevel_programid=program_id "   ;
             break;

    }


  $sql  .="LIMIT ".($page-1)*$lines.",".$lines;
  $ret   =mysqli_query($con,$sql);

	if(mysqli_num_rows($ret)>0) {  //if records exists
	
		?>
		  
				 <form name="SearchResultsForm" method="post" action="affiliates_process.php?page=<?=$page?>&amp;joinstatus=<?=$joinstatus?>">
				 <table  cellpadding="1" cellspacing="0"  width="95%" class="tablebdr" align="center" border="0" >
					  <tr class="tdhead">
							<td width="4%"  height="20" align="center">&nbsp;</td>
							<td width="20%"  align="left"><?=$lang_affiliate_head_url?></td>
							<td width="15%"  align="left"><?=$lang_affiliate_head_merchant?></td>
							<td width="14%"  align="center"><?=$lang_affiliate_imp?></td>
							<td width="8%"  align="center"><?=$lang_affiliate_head_click?></td>
							<td width="7%"  align="center"><?=$lang_affiliate_head_lead?></td>
							<td width="7%"  align="center"><?=$lang_affiliate_head_sale?></td>
							<td width="5%"  align="center"><?=$lang_affiliate_head_status?></td>
							<td width="20%"  align="center"><?=$lang_affiliate_head_action?></td>
				   </tr>
					 <tr>
						<td height="10" colspan="9" ></td>
					 </tr>
	
					   <?
					   while($row=mysqli_fetch_object($ret))
					   {
							$date		= date('Y-m-d');
							$clickRate  = $row->firstlevel_clickrate;
							$leadRate	= $row->firstlevel_leadrate;
							$saleType  	= $row->firstlevel_saletype;
							$saleRate	= $row->firstlevel_salerate;
							$imprRate	= $row->firstlevel_impressionrate;
							$imprUnit	= $row->firstlevel_unitimpression;	
	
							if($saleType == '$')
							{
								$saleType = $currSymbol;
								$saleRate = number_format($saleRate,2);
							}
	
								 $status=getstatus($row->program_id);             //function get status of joinprogram
								 if ($status=='approved')
									$link=$lang_affiliate_getlinks;                             //link to diaplay(corresponding action)
								 elseif ($status=='notjoined')
									$link=$lang_affiliate_joinpgm;
	
								 $check="~".$status."~".$row->program_id."~".$row->program_merchantid;
	
								 $msql	=	"select * from partners_merchant where merchant_id=$row->program_merchantid";
								 $mret    =   mysqli_query($con,$msql);
								 if(mysqli_num_rows($mret)>0) {
										 $mrow       = mysqli_fetch_object($mret);
										 $merchant	 = $mrow->merchant_firstname." ".$mrow->merchant_lastname;
										 $mer        = stripslashes(ucwords($merchant));
	
								 }
									   ?>
	
						  <tr>
							<td width="4%"  align="center"  height="20"> <input type="checkbox" name="elements[]" value="<?=$check?>" /></td>
							<td width="20%"  align="left"  height="20"><?=stripslashes($row->program_url)?></td>
							<td width="15%"  align="left"  height="20"><a href="index.php?Act=viewprofile&amp;id=<?=$row->program_merchantid?>&amp;pgmid=<?=$row->program_id?>&amp;status=<?=$status?>"><?=$mrow->merchant_company?></a></td>
							<td width="14%"  align="center"  height="20"><?=$currSymbol?>&nbsp;<?=number_format($imprRate,2)."/".$imprUnit?></td>
							<td width="8%"  align="center"  height="20"><?=$currSymbol?>&nbsp;<?=number_format($clickRate,2)?></td>
							<td width="7%"  align="center"  height="20"><?=$currSymbol?>&nbsp;<?=number_format($leadRate,2)?></td>
							<td width="7%"  align="center" height="20"><?=$saleType?>&nbsp;<?=$saleRate?></td>
							<td width="5%"  align="center"  height="20"><img src="../images/<?=$status?>.gif" height="<?=$icon_height?>" width="<?=$icon_width?>" alt="" /></td>
	
							<td width="20%"  align="center"  height="20">
							<?
							  if ($status=='suspend' or   $status=='waiting')
								  {        if  ($status=='suspend')
												//for blocked programs give a link to Rejoin
											   $link=$lang_affiliate_blocked."&nbsp;- <a href='affiliates_process.php?page=$page&amp;choice=rejoin&amp;pgmid=$row->program_id&amp;joinstatus=$joinstatus'>$lang_affiliate_rejoin</a>";
										   elseif ($status=='waiting')
											   $link=$lang_affiliate_waiting;
								 echo $link;
								 }
							 elseif($status=='notjoined')
							 {
							?>
							<a href="affiliates_process.php?page=<?=$page?>&amp;joinstatus=<?=$joinstatus?>&amp;sub='action'&amp;id=<?=$check?>" onclick="return validatejoin()  "><?=$link?></a>
							<?
							}
							else
							  {
							?>
							<a href="index.php?Act=Getlinks"><?=$link?></a> || <a href="index.php?Act=products&amp;pgmid=<?=$row->program_id?>"><?=$lang_pdt_files?></a>
							<?
							}
							?>
							</td>
					</tr>
	
				   <?php
					}
					?>
	
				  <tr>
					   <td colspan="9" align="center" >
					 <?
	  /*****************for page no**********************************************/
	   switch ($joinstatus)
	{
	
		 case 'All':
		   $pgsql="select * from partners_program,partners_firstlevel where program_status like ('active') and firstlevel_programid=program_id ";
		   break;
	
		 case 'waiting':
		   $pgsql         =" SELECT   * " ;
		   $pgsql         =$pgsql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
		   $pgsql         =$pgsql." WHERE joinpgm_status='waiting' and c.joinpgm_affiliateid=$AFFILIATEID and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
			 break;
	
		 case 'approved':
		   $pgsql         =" SELECT   * " ;
		   $pgsql         =$pgsql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
		   $pgsql         =$pgsql." WHERE joinpgm_status='approved' and c.joinpgm_affiliateid=$AFFILIATEID and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
			break;
	
		case 'suspend':
		   $pgsql         =" SELECT   * " ;
		   $pgsql         =$pgsql." FROM partners_joinpgm c,partners_firstlevel,partners_program";
		   $pgsql         =$pgsql." WHERE joinpgm_status='suspend' and c.joinpgm_affiliateid=$AFFILIATEID and c.joinpgm_programid = program_id and firstlevel_programid=program_id " ;
		   break;
	
	   case 'notjoined':
			$query="select * from partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID";
			$ret=mysqli_query($con,$query);
	
			// finding not joined pgms/////////////
			$a  ="(";
			$i  =1;
			while($row=mysqli_fetch_object($ret))
			{
			  if (mysqli_num_rows($ret)==$i)
				 $a  =$a.$row->joinpgm_programid;
			  else
				 $a  =$a.$row->joinpgm_programid.",";
			  $i=$i+1;
			}
			$a  .= ")";
			///////////////////////////////////////
	
			if (mysqli_num_rows($ret)==0)
				$pgsql="select * from partners_program,partners_firstlevel where program_status like ('active') and firstlevel_programid=program_id   ";
			 else
				 $pgsql         ="select * from partners_program,partners_firstlevel where program_status like ('active') and program_id not in $a and  firstlevel_programid=program_id ";
			 break;
	
		  case 'catwise':
			   $pgsql="select * from partners_merchant,partners_program,partners_firstlevel where program_status='active' and merchant_category='$cat' and merchant_id=program_merchantid and  firstlevel_programid=program_id "   ;
			   break;
	
		  case 'pgmwise':
			   $pgsql="select * from partners_program,partners_firstlevel where program_id=$pgm and  firstlevel_programid=program_id "   ;
			   break;
	
		  case 'search':
			   $pgsql="select * from partners_program,partners_firstlevel where program_url like '%$searchtxt%' and program_status='active' and  firstlevel_programid=program_id "   ;
			   break;
	
		  case 'myprograms':
			   $pgsql="select * from partners_program,partners_firstlevel,partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID and joinpgm_programid=program_id and  firstlevel_programid=program_id "   ;
			   break;
	
	}
					   $url    ="index.php?Act=$Act";    //adding page nos
					   include '../includes/show_pagenos.php';
	 /************************************************************************/
			?>
					 </td>
					 </tr>
	
	
	</table>
	<table  cellpadding="0" cellspacing="1"  width="95%" class="tablewbdr" align="center">
		 <tr>
				<td width="50%" colspan="9" align="left" height="30" >
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
	<?
	}
	# if no records
	else{
?>
		<table width="100%" align="center">
			<tr>
				<td align="center" class="error"><?=$norec?> </td>
			</tr>
		</table>
	<?
	}
	?>

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
	
	function viewLink(merchantid,pgmid,status)
	{
	alert (url="viewprofile_merchant.php?id="+merchantid+"&amp;pgmid="+pgmid+"&amp;status="+status);
	nw = open(url,'new','height=0,width=0,scrollbars=yes');
	nw.focus();
	}
</script>