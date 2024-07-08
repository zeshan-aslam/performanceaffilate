<script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.trans.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.trans.txtto,Date);
        }
</script>

<?
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

    $AFFILIATEID                                                                        =$_SESSION['AFFILIATEID'];   //affilaiteid
    $txtfrom                                        =trim($_GET['txtfrom']);     //from date
    $txtto                                          =trim($_GET['txtto']);       //to date
    $sub                                            =trim($_GET['sub']);         //submit button
    $msg                                            =trim($_GET['msg']);         //errmsg
    $LINKS                                          =trim($_SESSION['LINKS']);   //getting statstics
    $i                                              =trim($_GET['i']);           //count(next record)
    $programs                                       =trim($_GET['programs']);    //program id
    $Link                                           =explode("^",$LINKS);
    $TOTALREC   	 =count($Link)-1;             //total records
    /*************************************************************************/

    $sql 	= " SELECT * from partners_joinpgm,partners_program where joinpgm_affiliateid='$AFFILIATEID'  
				and joinpgm_status not like('waiting') and  program_id=joinpgm_programid"; //adding to drop down box
    $result2                                        =mysqli_query($con,$sql);

     if(!empty($txtto) && !empty($txtfrom))
    {
     $heading=$txtfrom. " - ".$txtto;               //subject
    }

 ?>

 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
 </iframe>
 <br/>
 <form name="trans" method="post" action="link_process.php?currCaption=<?=$currValue?>">
    <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center" >
           <tr>
                <td  height="19" class="tdhead" colspan="2" ><b> <?=$lang_report_stat?> </b></td>
           </tr>
            <tr>
                <td  height="19" colspan="2" class="error" align="center"> <?=$msg?></td>
            </tr>
            <tr>
                <td  height="19" colspan="2" >&nbsp;&nbsp;&nbsp;<b><?=$lang_report_forperiod?></b></td>
            </tr>
            <tr>
                 <td width="49%" height="24" align="center">&nbsp; <?=$lang_report_from?></td>
                 <td width="49%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$txtfrom?>" onfocus="javascript:from_date();return false;" /></td>
            </tr>
            <tr>
                 <td width="49%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
                 <td width="49%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$txtto?>" onfocus="javascript:to_date();return false;" /></td>
            </tr>
            <tr>
                 <td height="23" colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td height="20"colspan="2" align="center"><b><?=$lang_report_SearchProgram?></b> </td>
            </tr>
            <tr>
                 <td height="13" colspan="2">&nbsp;</td>
            </tr>
        <tr>
             <td height="25" colspan="2" align="center" >
                      <select name="programs" ><option value="All" ><?=$lang_report_AllProgram?></option>
                               <?  while($row=mysqli_fetch_object($result2))

                               {
                               if($programs=="$row->program_id")
                                      $programName="selected = 'selected'";
                               else
                                $programName="";

                               ?>
                                 <option <?=$programName?> value="<?=$row->program_id?>"><?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> </option>
                               <?
                               }
                               ?>
                   </select>
            </td>
            </tr>
            <tr>
                <td colspan="2" align="center" height="26">
                <input type="submit" name="sub" value="<?=$lang_report_view?>" /></td>
            </tr>
  </table>
  </form>

	<?
	if(!empty($sub)){
		$total=explode("~",$Link[$i]);   //getting statistics
		if(!empty($_SESSION['LINKS'])){

       $To   = $partners->date2mysql($txtto);
       $From = $partners->date2mysql($txtfrom);
        # calculate impressions
           $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_linkid= '$total[6]' AND imp_affiliateid = '$AFFILIATEID' ";
       $impSql .= " And imp_date between '$From' AND '$To' ";

       $rawClick = GetRawTrans('click', 0, $AFFILIATEID,0, $total[6], $From, $To, 0);
       $rawImp   = GetRawTrans('impression', 0,$AFFILIATEID, 0,$total[6],$From, $To, 0);

       $impRet        = mysqli_query($con,$impSql);
           $row_impr          = mysqli_fetch_object($impRet);
       //$numRec        = mysqli_num_rows($impRet);
           $numRec                  = $row_impr->impr_count;
           if($numRec == '') $numRec = 0;

	   $selDate		= $heading ;

	   ?>
		 <p align="right">
			<a href="#" onClick="window.open('../print_link.php?aid=<?=$AFFILIATEID?>&mode=affiliate&date=<?=$selDate?>&from=<?=$From?>&to=<?=$To?>&program=<?=$programs?>&currValue=<?=$currValue?>&currsymbol=<?=$currSymbol?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_link.php?aid=<?=$AFFILIATEID?>&mode=affiliate&date=<?=$selDate?>&from=<?=$From?>&to=<?=$To?>&program=<?=$programs?>&currValue=<?=$currValue?>&currsymbol=<?=$currSymbol?>"><b><?=$lang_export_csv_head?></b></a> 	
		 </p>

		<table border="0"  cellpadding="0" cellspacing="0" width="75%" class="tablebdr1" align="center">
			<tr>
				<td  height="25" width="100%" align="center" class="tdhead" colspan="4"><?=$lang_report?><br/><?=$heading?></td>
			</tr>
			
			<tr>
				<td  height="20" width="100%" align="center" colspan="4"></td>
			</tr>
			<tr>
			<td  height="51" width="100%" align="center" colspan="4">
			<?
			if (  substr($total[6],0,1)=='H' ){
				$id = substr($total[6],1,strlen($total[6])-1);  //linkid
			?>
				<a href='temp.php?rowid=<?=$id ?>' target="new"><?=$lang_report_Click?> </a>
			<?
			}
			if (  substr($total[6],0,1)=='T' ){
				$id		= substr($total[6],1,strlen($total[6])-1); //linkid
			?>
				<a href='../admin/text.php?id=<?=$id ?>' target="new"><?=$lang_report_Click_text?> </a>
			<?
			}
			
			//added on 21-apr-06 for template text ads
			if (  substr($total[6],0,1)=='N' )              //fortemplate text ad display
			{
			$id=substr($total[6],1,strlen($total[6])-1);  //linkid
			?>
			<a href='../merchants/preview_textad.php?id=<?=$id ?>' target="new">
			<?=$lang_report_Click_texttemplate?>  </a>
			
			<?
			}
			
			
			if (  substr($total[6],0,1)=='P' )                                     //for popup display
			{
			
			$id                                 =substr($total[6],1,strlen($total[6])-1); //linkid
			$sql                                            ="select * from partners_popup where popup_id=$id";
			$result                                            =mysqli_query($con,$sql);
			$row                                        =mysqli_fetch_object($result)
			?>
			<a href="#" onclick="window.open('<?=stripslashes($row->popup_url)?>',<?=$row->popup_width?>,<?=$row->popup_height?>)" ><?=$lang_report_Click_pop?>
			</a>
			<?
			}
			if (substr($total[6],0,1)=='B')                                       //for banner display
			{
			$id                                 =substr($total[6],1,strlen($total[6])-1); //linkid
			$sql                                ="select * from partners_banner where banner_id=$id";
			$result                             =mysqli_query($con,$sql);
			$row                                =mysqli_fetch_object($result);
			?>
			<img border="0" src="<?=$row->banner_name?>" width="300" height="70" />
			<?
			}
			
			if  (substr($total[6],0,1)=='F')                                           //for flash display
			{
			$id                                =substr($total[6],1,strlen($total[6])-1);       //linkid
			$sql                               ="select * from partners_flash where flash_id=$id";
			$result                                =mysqli_query($con,$sql);
			$row                                =mysqli_fetch_object($result);
			
			?>
			<embed border="0" src="<?=$row->flash_swf?>" width="300" height="70"> <!-- Modified on 11-Mar-06 to view the flash link.-->
			<?
			}
			
			?>
			</td>
			</tr>
		<tr>
		<td colspan="4">
		<br/><? viewRawTrans($rawClick, $rawImp) ?> <br/>
		<table width="85%" align="center" class="tablebdr">
			<tr >
				<td width="40%"  class="tdhead"><?=$lang_home_transaction?></td>
				<td width="30%"  class="tdhead"><?=$lang_home_number?></td>
				<td width="30%"  class="tdhead"><?=$lang_home_commission?></td>
			</tr>
		<tr>
		<td width="35%"  class="grid1" height="28"> <?=$lang_affiliate_imp?>
		   <img  alt="" border="0" height="10" src="../images/impression.gif" width="10" />                             </td>
		<td width="26%"  class="grid1" ><?=$numRec?></td>
		<td width="39%"   class="grid1" ><?=$currSymbol?><?=$total[11]?></td>
		</tr>
		<tr>
		<td width="25%" class="grid1" height="28"><?=$lang_affiliate_head_click?>&nbsp;<img
		alt="" border="0" height="10" src="../images/click.gif" width="10" /></td>
		<td width="25%"  class="grid1" height="28"><?=$total[1]?></td>
		<td width="25%" class="grid1" height="28"><?=$currSymbol?><?=$total[0]?></td>
		</tr>
		<tr>
		<td width="25%" class="grid1" height="28"><?=$lang_affiliate_head_lead?>&nbsp;<img
		alt="" border="0" class="grid1" height="10" src="../images/lead.gif" width="10" /></td>
		<td width="25%" class="grid1" height="28"><?=$total[3]?></td>
		<td width="25%" class="grid1" height="28"><?=$currSymbol?><?=$total[2]?></td>
		</tr>
		<tr>
		<td width="25%" class="grid1" height="28"><?=$lang_affiliate_head_sale?>&nbsp;<img
		alt="" border="0" class="grid1" height="10" src="../images/sale.gif" width="10" /></td>
		<td width="25%" class="grid1" height="28"><?=$total[5]?></td>
		<td width="25%" class="grid1" height="28"><?=$currSymbol?><?=$total[4]?></td>
		</tr>
		</table>
		<br/>
		
		<br/>
		<table width="100%" align="center"  class="tablewbdr">
            <tr>
                <td width="25%"  class="tdhead" align="center"><?=$lang_home_pending?></td>
            </tr>
            
            <tr>
                <td width="25%" height="28" align="center"><?=$currSymbol?><?=$total[8]?></td>
            </tr>
		</table>
		</td>
		</tr>
		<tr>
		<td  height="25" width="50%" align="center" class="tdhead"  >
		<?
		if($i!=1)              //for checking beginning of record
		{
		?>
		<a href="index.php?Act=LinkReport&amp;i=<?=($i-1)?>&amp;sub=$sub&amp;txtto=<?=$txtto?>&amp;txtfrom=<?=$txtfrom?>&amp;programs=<?=$programs?>"><font color="#FFFFFF"><?=$lang_previous?></font></a>
		<?
		}
		else
		{
		echo "$lang_previous";
		}
		?>
		</td>
		<td  height="25" width="100%" align="center"  class="tdhead" colspan="2" ><?=$lang_totalrec?> - <?=$TOTALREC?></td>
		<td  height="25" width="50%" align="center" class="tdhead"  >
		<?
		if($i!=(count($Link)-1))       //for checking end of records
		{
		?>
		<a href="index.php?Act=LinkReport&amp;i=<?=($i+1)?>&amp;sub=$sub&amp;txtto=<?=$txtto?>&amp;txtfrom=<?=$txtfrom?>&amp;programs=<?=$programs?>"><font color="#FFFFFF"><?=$lang_next?></font></a>
		<?
		}
		else
		{
		echo "$lang_next";
		}
		?>
		</td>
		</tr>
		</table>
		<?
		}
		else {
			?>
			<table width="100%" align="center">
				<tr>
					<td align="center" class="error"><?=$norec?> </td>
				<tr>
			</table>
			<?
		}
	}
    ?>