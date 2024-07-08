<?
	include "transaction.php";
	
	$MERCHANTID		= $_SESSION['MERCHANTID'];         //merchantid
	$transid        = trim($_POST['transid']);         //transactionid
	$transid        = explode('~',$transid);
	$joinpgmid      = trim($_GET['joinpgmid']);        //programid
	$mode           = trim($_POST['mode']);            //get input type
	
	//adding to dropdown box
	$sql		= " SELECT * FROM partners_joinpgm, partners_transaction, partners_program 
					WHERE joinpgm_affiliateid = '$AFFILIATEID' AND transaction_status LIKE ('reversed') 
					AND joinpgm_id = transaction_joinpgmid AND joinpgm_programid = program_id ";
	$result1 	= mysqli_query($con,$sql);
	$result2    = mysqli_query($con,$sql);

	# get pgm selected
	switch($joinpgmid){
		case '0':     //all
			$sql 	= " SELECT * FROM partners_joinpgm, partners_transaction, partners_program 
						WHERE joinpgm_affiliateid = '$AFFILIATEID' AND transaction_status LIKE ('reversed') 
						AND joinpgm_id = transaction_joinpgmid AND joinpgm_programid = program_id ";
		break;
		
		default :    //selected pgms
			$sql	= " select * from partners_joinpgm, partners_transaction, partners_program 
						where transaction_id='$transid[0]' and transaction_status like ('reversed') 
						and joinpgm_id=transaction_joinpgmid and joinpgm_programid=program_id";
		break;
	
	}

  	$result		= mysqli_query($con,$sql);

	if (mysqli_num_rows($result)>0){
		$rows		= mysqli_fetch_object($result1);  //for first time
		$id                     =$rows->transaction_id;
		$joinid                 =$rows->joinpgm_merchantid;
		$pgmname                =stripslashes($rows->program_url);
		if (empty($transid[0]))
		{
		$transid[0]                =$id;                   //transactionid
		$transid[2]                =$joinid;               //merchant id
		$transid[1]                =$pgmname;              //program name
		}
	
	$tranStat                =GetTransaction($transid[0],$currValue);  //getting Transaction Statistics from transaction.php
	$tranStat                =explode('~',$tranStat);
	//echo "$transid[2]";
	$details                = GetMerchantDetails($transid[2]);  //getting Affiliate Staistics   from transaction.php
	$details                =explode('~',$details);
	?>
	
	
	
	<br/>
	<form name="GetTransaction" method="post" action="index.php?Act=reversesale&pgmid=<?=$pgmid?>">
	<table border="0" cellpadding="0" cellspacing="0"  width="80%" align= "center"class="tablebdr" height="160">
		<tr>
			<td width="100%" class="tdhead" colspan="2" align="center"><B><?=$lang_home_reversesale?></B></td>
		</tr>
		<tr>
			<td width="40%" height="20" align="left">&nbsp;&nbsp;&nbsp;&nbsp;<b><?=$lang_home_pgms?> : <?=$transid[1]?></b></td>
			<td width="60%" height="30" align="right" ><?=$lang_home_transaction?>
				<select name="transid" onchange="document.GetTransaction.submit()">
				<?  
				while($row=mysqli_fetch_object($result2)){
					$transaction=$row->transaction_id."~".stripslashes($row->program_url)."~".$row->joinpgm_merchantid;
					if($transid[0]=="$row->transaction_id")
						$pgmName	= "selected";
					else
						$pgmName	= "";
				?>
					<option <?=$pgmName?> value="<?=$transaction?>"> 
						<?=$row->transaction_type?>&nbsp;pgmID=<?=$row->program_id;?> 
					</option>
				<?
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="60%" align="center" >
				<table border="0" cellpadding="0" width="90%" class="tablebdr" >
					<tr>
						<td width="100%" colspan="2" class="tdhead" align="center"><b><?=$lang_reverse_details?></b></td>
					</tr>
					<tr>
						<td width="50%" height="20" class="grid1"><?=$lang_reverse_name?></td>
						<td width="50%" height="20" class="grid1"><?=$details[0]?></td>
					</tr>
					<tr>
						<td width="50%" height="20" class="grid1"><?=$lang_reverse_company?></td>
						<td width="50%" height="20" class="grid1"><?=$details[1]?></td>
					</tr>
					<tr>
						<td width="50%" height="20" class="grid1"><?=$lang_reverse_url?></td>
						<td width="50%" height="20" class="grid1"><?=$details[2]?></td>
					</tr>
				</table>
			</td>
			<td width="40%" align="center">
				<table border="0" cellpadding="0"   width="90%" class="tablebdr"  >
					<tr>
						<td width="100%" class="tdhead" colspan="2" align="center" ><b><?=$lang_reverse_sale?> </b></td>
					</tr>
					<tr>
						<td width="34%" class="grid1" height="20" ><?=$lang_reverse_status?></td>
						<td width="40%" align="center"  class="grid1" height="20"><?=$tranStat[3]?></td>
					</tr>
					<tr>
						<td width="35%"  class="grid1" height="20"><?=$lang_reverse_commission?></td>
						<td width="39%" align="center"  height="20" class="grid1" ><?=$currSymbol?>&nbsp;<?=$tranStat[1]?></td>
					</tr>
					<tr>
						<td width="35%" class="grid1" height="20" ><?=$lang_reverse_date?></td>
						<td width="39%" align="center" height="20" class="grid1"><?=$tranStat[2]?></td>
					</tr>
				</table>
		</td>
		</tr>
		<tr>
			<td width="100%" height="20" colspan="3"></td>
		</tr>
	
	<tr>
	<td width="100%" height="20" colspan="3"></td>
	</tr>
	<tr>
	<td width="100%" height="20" align="center" colspan="3">
	
	</td>
	</tr>
	</table>
	</form>
	<?php
	}
  	else{
	?>
		<table width="100%" align="center">
			<tr><td align="center" class="error"><?=$norec?></td></tr>
		</table>
	<?
	}?>