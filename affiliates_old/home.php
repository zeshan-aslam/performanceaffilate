<?php
  include "transaction.php";

  $AFFILIATEID  =$_SESSION['AFFILIATEID'];
  $programs     =trim($_POST['programs']);

  ##Modified on 18.JUNE.06
  $rawClick1	=0;
  $rawImp1      =0;

  if (empty($programs))
       $programs="All";

  $sql="SELECT * from partners_joinpgm,partners_program where joinpgm_affiliateid=$AFFILIATEID and joinpgm_status not like('waiting') and program_id=joinpgm_programid"; //adding to drop down box

  $result=mysqli_query($con,$sql);
  switch ($programs)//checking program
      {
       case 'All';    //all pgm
           $sql			=	"SELECT * from partners_joinpgm where joinpgm_affiliateid=$AFFILIATEID " ;
           $joinpgmid	=	0;

           # impression tracking
           $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE  imp_affiliateid = $AFFILIATEID ";

			 ##Modified on 18.JUNE.06
            $rawClick = GetRawTrans('click',  0, $AFFILIATEID, 0, 0,  $From,$To, 0)   ;
    		$rawImp   = GetRawTrans('impression', 0, $AFFILIATEID, 0, 0,  $From,$To, 0)   ;
           break;

       default:    //selected pgm
           $sql			=	"SELECT * from partners_joinpgm where joinpgm_id=$programs ";
           $joinpgmid	=	$programs;

	   ##Modified on 18.JUNE.06
		   # impression tracking
           $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily,partners_joinpgm WHERE  imp_affiliateid = $AFFILIATEID  and joinpgm_id =$programs AND joinpgm_programid = imp_programid";

           # impression tracking
           $rawCSql = " SELECT sum(transdaily_click) as rawclick_count FROM partners_rawtrans_daily,partners_joinpgm WHERE  transdaily_affiliateid = $AFFILIATEID   AND transdaily_programid = joinpgm_programid and joinpgm_id =$programs";

            # impression tracking
           $rawISql = " SELECT sum(transdaily_impression) as rawimpression_count FROM partners_rawtrans_daily,partners_joinpgm WHERE  transdaily_affiliateid = $AFFILIATEID   AND transdaily_programid = joinpgm_programid and joinpgm_id =$programs";
			/*
            $rawCRet	= mysqli_query($con,$rawCSql);
   			$rawClick	= mysqli_num_rows($rawCRet);

            $rawIRet	= mysqli_query($con,$rawISql);
   			$rawImp 	= mysqli_num_rows($rawIRet);
			*/
            $rawCRet        = mysqli_query($con,$rawCSql);

            $cRow           = mysqli_fetch_object($rawCRet);
            $rawClick        = $cRow->{rawclick_count};

            $rawIRet        = mysqli_query($con,$rawISql);

            $iRow           = mysqli_fetch_object($rawIRet);
            $rawImp         = $iRow->{rawimpression_count};
	   ### End Modified on 18.JUNE.06
           break;
      }

   $impRet	= mysqli_query($con,$impSql);
        $row_impr = mysqli_fetch_object($impRet);
        $numRec = $row_impr->impr_count;
        if($numRec == '') $numRec = 0;

 
  $total=GetPaymentDetails($sql,$currValue,$default_currency_caption); //getting payments (click,sale,lead) values
  $total =explode('~',$total);


  $totallink=GetLinks($joinpgmid,$AFFILIATEID);       //getting advertising links
  $totallink =explode('~',$totallink);

  $sql="select * from partners_joinpgm where joinpgm_id=$joinpgmid";
  $ret1=mysqli_query($con,$sql);
  $field=mysqli_fetch_object($ret1);
  $pgmid=$field->joinpgm_programid;

 ?>
	<table border="0" cellpadding="0" cellspacing="1" width="90%" align="center" class="tablewbdr" >
	<?php
	//check whether the balance for this affiliate has reached the maximum amount set up by the admin
	$affiliate_sql = "SELECT pay_amount FROM  affiliate_pay  WHERE pay_affiliateid = $AFFILIATEID";
	$affiliate_ret = mysqli_query($con,$affiliate_sql);
	if($affiliate_row = mysqli_fetch_object($affiliate_ret)) 
		$affiliate_balance = $affiliate_row->pay_amount;
	
	# if maximum limit (from constants.php) is reached
	if($affiliate_balance>$affiliate_maximum_amount){
	/*get message from file
	$filename			= "../admin/affiliate_maximum_balance_msg.htm";
	$fp 				= fopen($filename,'r');
	$affiliate_message 	= fread ($fp, filesize ($filename));
	fclose($fp);	*/
	?>
		<tr>
			<td width="100%"   align="center" height="30" class="textred"><?=$lang_home_maximum_limit_reached?></td>
		</tr>
	<?php
	}
	?>
		<tr>
			<td>
			<form name="Getprogram" method="post" action="">
			<table border="0" cellpadding="0" cellspacing="1" width="100%"  align="center" class="tablebdr">
				<tr>
					<td width="100%"  colspan="3" align="center" class="tdhead" height="20"><b><?=$lang_home_pgmstat?></b></td>
				</tr>
				<tr>
				
				<td width="100%" align="right" height="30" colspan="3"  ><strong><?=$lang_home_pgms?></strong>
				<select name="programs" onchange="document.Getprogram.submit()">
				<option value="All" ><?=$lang_home_all_pgms?></option>
				<?  while($row=mysqli_fetch_object($result)){
						if($programs=="$row->joinpgm_id")
							$programName="selected = 'selected'";
						else
							$programName="";
				?>
						<option <?=$programName?> value="<?=$row->joinpgm_id?>">
							<?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> </option>
						<?
						}
						?>
				</select>
				</td>
				</tr>
			<tr>
			<td width="100%" height="30" colspan="3" >
			
			<br/>
			<table border="0" cellpadding="0" width="70%" class="tablebdr" align="center">
			<tr>
			<td width="34%" class="tdhead"><strong><?=$lang_home_transaction?></strong></td>
			<td width="26%" align="center" class="tdhead"><strong><?=$lang_home_number?></strong></td>
			<td width="40%" align="center"class="tdhead"><strong><?=$lang_home_commission?></strong></td>
			</tr>
			<tr>
			<td width="35%" ><strong><?=$lang_affiliate_imp?></strong></td>
			<td width="26%" align="center" ><?=$numRec?></td>
			<td width="39%" align="center" ><?=$currSymbol?>&nbsp;<?=number_format($total[14],2)?></td>
			</tr>
			<tr>
			<td width="35%"  class="grid1"><strong><?=$lang_affiliate_head_click?>&nbsp;</strong>
			<img alt="" border="0" height="8" src="../images/click.gif" width="8" /></td>
			<td width="26%" align="center" class="grid1" ><?=$total[0]?></td>
			<td width="39%" align="center"  class="grid1" ><?=$currSymbol?>&nbsp;<?=number_format($total[1],2)?></td>
			</tr>
			
			<tr>
			<td width="35%" ><strong><?=$lang_affiliate_head_lead?>&nbsp;</strong>
			<img alt="" border="0" height="8" src="../images/lead.gif" width="8" /></td>
			<td width="26%" align="center" ><?=$total[2]?></td>
			<td width="39%" align="center" ><?=$currSymbol?>&nbsp;<?=number_format($total[3],2)?></td>
			</tr>
			<tr>
			<td width="35%" class="grid1"><strong><?=$lang_affiliate_head_sale?>&nbsp;</strong>
			<img alt="" border="0" height="8" src="../images/sale.gif" width="8" /></td>
			<td width="26%" align="center"  class="grid1"><?=$total[4]?></td>
			<td width="39%" align="center"  class="grid1"><?=$currSymbol?>&nbsp;<?=number_format($total[5],2)?></td>
			</tr>
			</table>
			<? viewRawTrans($rawClick, $rawImp) ?>
			
			<br/>
			<br/>
			<?
			if ($programs<>'All')
			{
			$tot=$totallink[1]+$totallink[2]+$totallink[3]+$totallink[4]+$totallink[0];
			if($tot==0)
			{
			?>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tablewbdr" align="center" >
			<tr  class="grid1" >
			<td width="20%" align="center" class="textred" height="30" colspan="5" ><?=$lang_home_no_link?></td>
			</tr>
			</table>
			<? }
			else
			{
			?>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tablewbdr" align="center" >
			<tr>
			<td width="25%" class="tdhead" align="center" colspan="5" height="20"><?=$lang_home_ad_links?></td>
			</tr>																	<tr  class="grid1" >
			<td width="20%" align="center"   ><a href="index.php?Act=gettext"><?=$lang_home_text?> - <?=$totallink[1]?></a></td>
			<td width="20%" align="center"  ><a href="index.php?Act=gethtml"><?=$lang_home_html?> - <?=$totallink[4]?></a></td>
			<td width="20%" align="center"  ><a href="index.php?Act=getbanner&amp;programs=<?=$pgmid?>"><?=$lang_home_banner?> -<?=$totallink[0]?></a></td>
			<td width="20%" align="center"  ><a href="index.php?Act=getpopup"><?=$lang_home_popup?> - <?=$totallink[2]?></a></td>
			<td width="20%" align="center" ><a href="index.php?Act=getflash"><?=$lang_home_flash?> - <?=$totallink[3]?></a></td>
			</tr>
			</table>
			<?
			}
			
			}
			
			?>
			</td>
			</tr>
			
			</table>
			</form>
			</td>
		<td width="1%">
		</td>
		<td width="40%">
		
		<form  name="report" method="post" action="#">
		<table border="0" cellpadding="0"   width="100%"  class="tablebdr">
		<tr>
		<td width="100%" class="tdhead" colspan="2" align="center"><b><?=$lang_home_statistics?></b></td>
		</tr>
		
		<tr>
		<td width="50%" ><b>
		<img alt="" border="0" height="12" src="../images/waiting.gif" width="12" />&nbsp;<?=$lang_home_pending?>&nbsp;</b></td>
		<td width="50%" align="center" ><?=$currSymbol?>&nbsp;<?=number_format($total[7],2)?></td>
		</tr>

		<tr>
		<td width="100%" colspan="2" align="center" height="20">
		<a href="index.php?Act=reversesale&amp;joinpgmid=0"><?=$lang_home_reversesale?> </a></td>
		</tr>
		<tr>
		<td width="100%" colspan="2" align="center" class="tdhead" height="15"><b><?=$lang_home_report?></b></td>
		</tr>
		
		<tr >
		
		<td width="50%" align="center" ><?=$lang_home_search?></td>
		<td width="50%" align="center"  height="30"><select name="reportRE" onchange="getpage()">
		<option value="#"><?=$lang_home_select?></option>
		<option value="daily"><?=$lang_home_daily?></option>
		<option value="forperiod"><?=$lang_home_forperiod?></option>
		<option value="LinkReport"><?=$lang_home_links?></option>
		<option value="TransReport"><?=$lang_home_transaction?></option>
		</select></td>
		</tr>
		
		</table>
		</form>
		</td>
		</tr>
	</table>
<br />
<script language="javascript" type="text/javascript">
   function getpage(){
	   var Action				= (document.report.reportRE.value);
	   var url					= "index.php?Act="+Action; 
	   document.report.action	= url ;
	   document.report.submit();
   }
</script>