<?
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$nocol="0";

    $sql 	= "SELECT * from partners_merchant ";
    $ret	= mysql_query($sql);

    $sql 	= "SELECT * from partners_affiliate ";
    $ret1	= mysql_query($sql) or die("cant exe");

     if(!$btnsub=="View")
      {   $_SESSION['$msg']="";
          $_SESSION['$res']="";
          $schk="checked = 'checked'";
          $cchk="checked = 'checked'";
          $lchk="checked = 'checked'";
     }

     ?>

<script language="javascript" type="text/javascript">
function from_date()
{
 gfPop.fStartPop(document.trans.fromtxt,Date);
}

function to_date()
{
 gfPop.fStartPop(document.trans.totxt,Date);
}
</script>

<form method="post" name="trans" id="trans" action="index.php?Act=transaction">
<table border='0' class="tablehdbdr" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="78%" >
    <tr>
      	<td colspan="8" height="19" class="tdhead">
      		<p align="center">Statistics For Custom Period</p></td>
    </tr>
    <tr>
      	<td colspan="8" height="19" >
      		<p align="center" class="textred"><?=$_SESSION['$msg']?></p></td>
    </tr>
    <tr>
      <td width="2%" height="13"></td>
      <td colspan="3" height="13">For Period</td>
      <td colspan="4" height="13"></td>
    </tr>
    <tr>
      <td width="2%" height="22">&nbsp;</td>
      <td width="9%" height="22" align="right">From</td>
      <td width="2%">&nbsp;</td>
      <td width="24%" height="22" align="left"><input type="text" name="fromtxt" size="18" value="<?=$from?>" onfocus="javascript:from_date();return false;" /></td>
      <td width="12%" height="22">&nbsp;</td>
      <td width="11%" height="22" align="right">Merchant&nbsp; </td>
      <td width="3%">&nbsp;</td>
      <td width="37%" height="22" align="left"><select size="1" name="Mname">
        <option selected="selected" value="All">All Merchants</option>

		   <?  while($row=mysql_fetch_object($ret))

		   {
			   if($merchant=="$row->merchant_id")
							   $MerchantName="selected = 'selected'";
			   else
							   $MerchantName="";

		   ?>
			 <option <?=$MerchantName?> value="<?=$row->merchant_id?>"> <?=stripslashes($row->merchant_company)?> </option>
		   <?
			  }    // while close
		   ?>

      </select></td>
    </tr>
	<tr><td colspan="8" height="10"></td></tr>
    <tr>
      <td width="2%" height="22">&nbsp;&nbsp; </td>
      <td width="9%" height="22" align="right">To</td>
      <td width="2%">&nbsp;</td>
      <td width="24%" height="22" align="left"><input type="text" name="totxt" size="18" value="<?=$to?>"  onfocus="javascript:to_date();return false;" /></td>
      <td width="12%" height="22">&nbsp;</td>
      <td width="11%" height="22" align="right">Affiliate </td>
      <td width="3%">&nbsp;</td>
      <td width="37%" height="22" align="left"><select size="1" name="Aname">
      <option selected="selected" value="All">All  Affiliate</option>
		<?  while($row=mysql_fetch_object($ret1))
		   {
		   if($affiliate=="$row->affiliate_id")
				 $AffiliateName="selected = 'selected'";
		   else
				 $AffiliateName="";
		?>
			 <option <?=$AffiliateName?> value="<?=$row->affiliate_id?>"><?=stripslashes($row->affiliate_company)?></option>
		   <?
		   } /// while close
		   ?>
      </select></td>
    </tr>
    <tr>
      <td width="2%" height="11"></td>
      <td height="11" colspan="7" align="center"></td>
    </tr>
    <tr>
      <td width="2%" height="21" class="tdhead">&nbsp;</td>
      <td width="9%" height="21" class="tdhead"><input type="checkbox" name="salecb" value="salecb" <?=$schk?> />
            Sale</td>
      <td width="2%" class="tdhead">&nbsp;</td>
      <td width="24%" height="21" class="tdhead">&nbsp;</td>
      <td width="12%" height="21" class="tdhead"><input type="checkbox" name="leadcb" value="leadcb" <?=$lchk?> />
      Lead</td>
      <td width="11%" height="21" class="tdhead">&nbsp;</td>
      <td width="3%" class="tdhead">&nbsp;</td>
      <td width="37%" height="21" class="tdhead"><input type="checkbox" name="clickcb" value="clickcb" <?=$cchk?> />
      Click</td>
    </tr>
    <tr>
      <td colspan="8" align="center" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="8" align="center" height="26" ><input type="submit" value="View" name="btnsub" /></td>
    </tr>
</table>
</form>
<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>

<?php
/////////////////////////   form prossesing /////////

    if(isset($btnsub)){
		$Merchant=trim($_POST['Mname']);
		$Affiliate=trim($_POST['Aname']);
		$From=trim($_POST['fromtxt']);
		$To=trim($_POST['totxt']);

		$sale=trim($_POST['salecb']);
		$click=trim($_POST['clickcb']);
		$lead=trim($_POST['leadcb']);
		//validation

		$fdate=trim($_POST['fromtxt']);
		$tdate=trim($_POST['totxt']);

		if (($From==!"")||($To ==!"")){
			 if(!$partners->is_date($From) || !$partners->is_date($To) ){
				  echo "<p class=textred>";
				  echo "Please Enter a Valid Date";
				  echo "</p>";
				  exit;
			 }
		}

		 if ($sale=="" and $click=="" and $lead ==""){
			  echo "<p class=textred>";
			  echo "Please select Sale,Click,Lead or all";
			  echo "</p>";
			  exit;
	   }

   $From=$partners->date2mysql($From);
   $To=$partners->date2mysql($To);

    switch($Merchant)
    {
      case 'All':
            {
            switch ($Affiliate)
            {
               case 'All':
                   {
                   $sql="SELECT * from partners_joinpgm ";
                   break;
                   }
                  default:
                   {
                   $sql="SELECT * from partners_joinpgm where joinpgm_affiliateid = '$Affiliate'";
                   break;
                   }
            }
            break;
            }

         default:
         {
           switch ($Affiliate)
            {
               case 'All':
                   {
                   $sql="SELECT * from partners_joinpgm, partners_program where program_merchantid = '$Merchant' and  joinpgm_programid=program_id   ";
                   break;
                   }
                  default:
                   {
                    $sql="SELECT * from partners_joinpgm,partners_program where program_merchantid = '$Merchant' and joinpgm_affiliateid='$Affiliate' and joinpgm_programid=program_id   ";
                   break;
                   }
            }
         }
    }


    $result1=mysql_query($sql);
    $count="0";  // for  result table  head

	if ($click=="clickcb" || $sale=="salecb" || $lead=="leadcb")
	 {
		  if($click=="clickcb"){
			  $querytype="'click'";
		  }

		  if($sale=="salecb"){
			  $querytype="'sale'";
		  }

		  if($lead=="leadcb"){
			  $querytype="'lead'";
		  }

		   if($click=="clickcb" and $sale=="salecb"){
			  $querytype= "'click' or transaction_type = 'sale'";
		  }

		 if($lead=="leadcb" and $sale=="salecb"){
			 $querytype= "'lead' or transaction_type = 'sale'";
		  }

		 if($lead=="leadcb" and $click=="clickcb"){
			$querytype= "'lead' or transaction_type = 'click'";
		  }

		 if($lead=="leadcb" and $sale=="salecb" and $click=="clickcb"){
			   $querytype= "'lead' or transaction_type = 'sale' or transaction_type = 'click'";
		  }

			while($rows=mysql_fetch_object($result1))
			{
			 $joinid=$rows->joinpgm_id;
			 $sql="SELECT * FROM partners_transaction AS t, partners_joinpgm AS j,partners_merchant as m, partners_affiliate AS a";
			 $sql.=" WHERE transaction_dateoftransaction between '$From' and '$To'";
			 $sql.=" AND (transaction_type = $querytype)";
			 $sql.=" AND transaction_joinpgmid = '$joinid' AND t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_merchantid=m.merchant_id AND j.joinpgm_affiliateid=a.affiliate_id";


			 if ((trim($From)=="0000-00-00") and (trim($To)=="0000-00-00"))
				 {
								$sql="SELECT * FROM partners_transaction AS t, partners_joinpgm AS j,partners_merchant as m, partners_affiliate AS a";
								$sql.=" where (transaction_type = $querytype)";
								$sql.=" AND transaction_joinpgmid = '$joinid' AND t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_merchantid=m.merchant_id AND j.joinpgm_affiliateid=a.affiliate_id";
				 }

            $result=mysql_query($sql) or die("cant exe");

            $nclick=mysql_num_rows($result);

			if ($nclick=="0"){
			   $count="1";
			}

			if ($count=="0"){
			   	$table="ok";
				$_SESSION['$res']="Report Between ".$From." and ".$To;

				if ((trim($From)=="0000-00-00") and (trim($To)=="0000-00-00")){
					  $_SESSION['$res']="Complete Report ";
				}
 ?>
				 <p align="center" class="textred"><?=$_SESSION['$res']?></p>

				<table class="tablebdr" cellspacing="1" width="95%">
				<tr>
					<td width="10%" align="center" class="tdhead">Type</td>
					<td width="20%" align="center" class="tdhead">Merchant</td>
					<td width="20%" align="center" class="tdhead">Affiliate ID</td>

					<td width="10%" align="center" class="tdhead">Commission</td>
					<td width="20%" align="center" class="tdhead">Date</td>
					<td width="15%" align="center" colspan="2" class="tdhead">Status</td>
				</tr>
  <?
            }   // closing of if count

			$count="1";
			$gridcounter=0;

			while($rows=mysql_fetch_object($result))
			{                 //////// column creation
			if ($table!="ok")  //// checking table head is set
			{
				$_SESSION['$res']="Report Between ".$From." and ".$To;

				if ((trim($From)=="0000-00-00") and (trim($To)=="0000-00-00"))
					 {
						   $_SESSION['$res']="Complete Report ";
					  }
	?>

                <p align="center" class="textred"><?=$_SESSION['$res']?></p>

				<table class="tablebdr" cellspacing="1" width="85%">
					<tr>
						<td width="10%" align="center" class="tdhead">Type</td>
						<td width="20%" align="center" class="tdhead">Merchant</td>
						<td width="20%" align="center" class="tdhead">Affiliate ID</td>

						<td width="10%" align="center" class="tdhead">Commission</td>
						<td width="20%" align="center" class="tdhead">Date</td>
						<td width="15%" align="center" colspan="5" class="tdhead">Status</td>
				  </tr>
  <?

                  $table="ok";

              	}  // closing if of table haed check;
				else
				{
					$table="ok";
				}
				$nocol="1";
				$type=$rows->transaction_type ;
				$merchantid			= $rows->joinpgm_merchantid ;
				$merchantname		= stripslashes($rows->merchant_company);
				$affiliateid 		= $rows->joinpgm_affiliateid ;
				$affiliatename 		= stripslashes($rows->affiliate_company) ;
				$tstatus 			= $rows->transaction_status ;
				$commission			= $rows->transaction_amttobepaid ;
				$dateoftransaction 	= $rows->transaction_dateoftransaction ;
				$astatus			= $rows->joinpgm_status;

				if ($gridcounter%2==1){
					$classid="grid1";
				}else{
					$classid="grid2";
				}
  ?>

				 <tr class="<?=$classid?>" >
					<td width="10%" align="center"  ><?=$type?>&nbsp;<img
							  alt="" border='0' height="10" src="../images/<?=$type?>.gif"
							  width="10" /></td>
					<td width="20%" align="center"  >
					<a href="#" onclick="help(<?=$merchantid?>)">
					<?=$merchantname?>
					</a></td>
					<td width="20%" align="center" ><a href="#"  onclick="help1(<?=$affiliateid?>)"> <?=$affiliatename?></a></td>
					<td width="10%" align="center"  ><?=$commission?></td>
					<td width="20%" align="center" ><?=$dateoftransaction?></td>
					<td width="10%" align="left" >
					&nbsp;<img alt="" border='0' height="<?=$icon_height?>" width="<?=$icon_width?>" src="../images/<?=$tstatus?>.gif"/>&nbsp;<?=$tstatus?></td>
					
				  </tr>

  <?
    			$gridcounter=$gridcounter+1; ;
            } // inner while close
		} // outer while closing
	}  // if checking the value of 3 chbox closing
    ?>
                  </table>
    <?

	if($nocol=="0")
	{
		echo "<p class=textred align='center'>";
		echo "No record Found Between ".$From;
		echo " And ".$To;
		echo "</p>";
		exit;
	}
} // closing of if of submit check
?>

<script language="javascript" type="text/javascript">

	function help(merchantid)
	{
		url="viewprofile_merchant.php?id="+merchantid;
		nw = open(url,'new','height=500,width=500,scrollbars=yes');
		nw.focus();
	}
	
	function help1(afiliateid)
	{
		url="viewprofile_affiliate.php?id="+afiliateid;
		nw = open(url,'new','height=500,width=500,scrollbars=yes');
		nw.focus();
	}
</script>