 <?php
 
	$id 	= intval($_GET['affid']) ;
	$page	= intval(trim($_GET['page']));           // page no
	$gridcounter	= 0;
	if(empty($page))                               //getting page no
	$page   = $partners->getpage();
	//geting records from table
	$sql	= " SELECT * FROM partners_transaction AS t, partners_joinpgm AS j, partners_affiliate AS a 
				WHERE affiliate_id = '$id' AND t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_affiliateid=a.affiliate_id ";
	$pgsql	= $sql;
	$sql   .= "LIMIT ".($page-1)*$lines.",".$lines; //adding page no
	$ret 	= mysqli_query($con,$sql);

  //checking for each records
  if(mysqli_num_rows($ret)>0){
  ?>

 <br/>
 <br/>
 <table class="tablebdr" cellspacing="1" width="95%" id="AutoNumber1">
    <tr>
	    <td width="10%" align="center" class="tdhead">Type</td>
	    <td width="20%" align="center" class="tdhead">Merchant</td>
	    <td width="20%" align="center" class="tdhead">Affiliate </td>
	    <td width="10%" align="center" class="tdhead">Commission</td>
	    <td width="20%" align="center" class="tdhead">Date</td>
	    <td width="15%" align="center"  class="tdhead">Status</td>
    </tr>
 <?
	while($rows=mysqli_fetch_object($ret))
	{
		$type		   	= $rows->transaction_type ;
		$merchantid	   	= $rows->joinpgm_merchantid ;
		$affiliate		= stripslashes($rows->affiliate_firstname)." ".stripslashes($rows->affiliate_lastname);
		$affiliateid   	= $rows->joinpgm_affiliateid ;
		$sql2 			= " select * from partners_merchant where merchant_id='$merchantid' ";
		$ret2 			= mysqli_query($con,$sql2);
	
		if(mysqli_num_rows($ret2)>0)
		{
			$row2		= mysqli_fetch_object($ret2);
			$merchant	= stripslashes($row2->merchant_firstname)." ".stripslashes($row2->merchant_lastname);
		}
		$tstatus 	  		=$rows->transaction_status ;
		$commission			=$rows->transaction_amttobepaid ;
		$dateoftransaction  =$rows->transaction_dateoftransaction ;
		$astatus			=$rows->joinpgm_status;
		
		if ($gridcounter%2==1)  
			$classid="grid1";
		else
			$classid="grid2";

  ?>

 	<tr class=<?=$classid?> >
	    <td width="10%" align="center"  ><?=$type?>&nbsp;<IMG alt="" border='0' height=10 src="../images/<?=$type?>.gif"
	              width=10></td>
	    <td width="20%" align="center" ><a href="#" onclick="help(<?=$merchantid?>)"><?=$merchant?></a></td>
	    <td width="20%" align="center" ><a href="#" onclick="help1(<?=$affiliateid?>)"> <?=$affiliate?></a></td>
	    <td width="10%" align="center"  ><?=$currSymbol?>&nbsp;<?=round($commission,2)?></td>
	    <td width="20%" align="center" ><?=$dateoftransaction?></td>
	    <td width="10%" align="left" >
	        &nbsp;<IMG alt="" border='0' height=15 src="../images/<?=$tstatus?>.gif" width=15>&nbsp;<?=$tstatus?></td>
   	</tr>

  <?
    $gridcounter=$gridcounter+1;
	} // inner while close
   if ($gridcounter%2==1)   $classid="grid1";
   else                     $classid="grid2";
	?>
    <tr>
		<td colspan="6" align="center">
	<?

	/**********************************for pageno***************************/
	$url    ="index.php?Act=transaction_affiliate&amp;affid=$id";    //adding page nos
	include '../includes/show_pagenos.php';

	/********************************************************************************/
	?>
		</td>
	</tr>
</table>
<?

	} // outer if closing
	else
	{
	?><p align="center" class="textred"><?=$norec?></p><?
	}
	?>

	<script language="javascript" type="text/javascript">

	function help(merchantid)
	{
	    url="viewprofile_merchant.php?&id="+merchantid;
	    nw = open(url,'new','height=0,width=400,scrollbars=yes');
	    nw.focus();
	}

	function help1(afiliateid)
	{
	    url="viewprofile_affiliate.php?&id="+afiliateid;
	    nw = open(url,'new','height=0,width=400,scrollbars=yes');
	    nw.focus();
	}

</SCRIPT>