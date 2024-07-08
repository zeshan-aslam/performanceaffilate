<?
	include "doTransaction.php";
	include "transactions.php";
	include  "../mail.php";
	
	$MERCHANTID    = $_SESSION['MERCHANTID'];   //merchantid
	$transid       = trim($_POST['transid']);   //transactionid
	$transid       = explode('~',$transid);
	$pgmid         = intval(trim($_GET['pgmid']));      //programid
	$mode          = ($_POST['Reject'] ? trim($_POST['Reject']) : trim($_POST['Approve']));      //select input type
	$msg			 = "";

	switch($mode){
		case 'Approve': 
			$returnvalue	=	doPayment($MERCHANTID,$transid[0],$minimum_amount);
			if($returnvalue){
				$today	= date("Y-m-d");
				$sql    = " update partners_transaction  set transaction_status='approved',transaction_dateofpayment='$today' 
							where transaction_id='$transid[0]'  ";
				mysqli_query($con,$sql);
				
				$sql	= " select * from partners_login, partners_joinpgm where joinpgm_id='$transid[2]' 
							and login_flag='a' and joinpgm_affiliateid=login_id";
				$ret1   = mysqli_query($con,$sql);
				$row    = mysqli_fetch_object($ret1);
				$to     = $row->login_email;
				
				MailEvent("Approve Transaction",$MERCHANTID,$transid[2],$to,$transid[0]);
				$pgmid    = 0;
			}
			else
			{
				$msg=$money_empty_err;
			}
		break;
		
		case 'Reject':   //Rejection
		
			$sql	= " select * from partners_login,partners_joinpgm where joinpgm_id='$transid[2]' 
						and login_flag='a' and joinpgm_affiliateid=login_id";
			$ret1	= mysqli_query($con,$sql);
			$row	= mysqli_fetch_object($ret1);
			$to		= $row->login_email;
			MailEvent("Reject Transaction",$MERCHANTID,$transid[2],$to,$transid[0]);
			
			$sql    = " delete from partners_transaction where transaction_id='$transid[0]'";
			mysqli_query($con,$sql);
			
			$pgmid  = 0;
		break;
	}

	switch($pgmid)   //select programs
	{
		case '0':    //all
		/*
		$sql	= " select * from partners_joinpgm,partners_transaction,partners_program, partners_affiliate  
					where joinpgm_merchantid='$MERCHANTID' and transaction_status  like ('pending') 
					and joinpgm_id=transaction_joinpgmid and program_id=joinpgm_programid AND transaction_recur = '0' 
					AND affiliate_id = joinpgm_affiliateid";
					*/
		$sql	= " select * from partners_joinpgm,partners_transaction,partners_program, partners_affiliate  
					where joinpgm_merchantid='$MERCHANTID' and transaction_status  like ('pending') 
					and joinpgm_id=transaction_joinpgmid and program_id=joinpgm_programid  
					AND affiliate_id = joinpgm_affiliateid";

		break;

		default :   //selected programs
		/*
		$sql   	= " select * from partners_joinpgm,partners_transaction,partners_program, partners_affiliate   
					where program_id='$pgmid' and transaction_status  like ('pending') and joinpgm_id=transaction_joinpgmid 
					and program_id=joinpgm_programid AND transaction_recur = '0'  AND affiliate_id = joinpgm_affiliateid ";
					*/

		$sql   	= " select * from partners_joinpgm,partners_transaction,partners_program, partners_affiliate   
			where program_id='$pgmid' and transaction_status  like ('pending') and joinpgm_id=transaction_joinpgmid 
			and program_id=joinpgm_programid  AND affiliate_id = joinpgm_affiliateid ";

		break;

   	}
	$result   = mysqli_query($con,$sql);
	$result1  = mysqli_query($con,$sql);

	if (mysqli_num_rows($result)>0)  //checking for records
	{
              $rows     = mysqli_fetch_object($result1);                 //for first time
              $id       = $rows->transaction_id;
              $joinid   = $rows->joinpgm_id;
              $pgmname  = stripslashes($rows->program_url);

              if (empty($transid[0])){
                     $pgmid        = $rows->program_id;
                     $transid[0]   = $id;
                     $transid[2]   = $joinid;
                     $transid[1]   = $pgmname;
               }

              $tranStat    = GetTransaction($transid[0], $currValue, $default_currency_caption);  //getting Transaction Statistics from transaction.php
 
             //get revenue details order id etc from partners_track_revenue
              $sql	=	"select * FROM partners_track_revenue WHERE revenue_transaction_id='$transid[0]'";
		      $ret	=	@mysqli_query($con,$sql);
     		  $row	=	@mysqli_fetch_object($ret);
		      # get transaction details
		      $revenue_amount	=	$row->revenue_amount;
		      
		      // Get transaction_orderid from partners_transaction 
              $sql	=	"select * FROM partners_transaction WHERE transaction_id='$transid[0]'";
		      $ret	=	@mysqli_query($con,$sql);
     		  $row	=	@mysqli_fetch_object($ret);
		      # get transaction details
		      $transaction_orderid 	=	$row->transaction_orderid;
		     
		     
              $tranStat    = explode('~',$tranStat);
              //echo "$transid[2]";
              $details     = GetAffiliateDetails($transid[2]);  //getting Affiliate Staistics   from transaction.php
              $details     = explode('~',$details);
               ?>



            <br/>
	<form name="GetTransaction" method="post" action="index.php?Act=waitingpgm&amp;pgmid=<?=$pgmid?>">
	<table border="0" cellpadding="0" cellspacing="0"  width="70%" align= "center"class="tablebdr" >
	<tr>
	<td width="100%" class="textred" colspan="2" align="center" ><?=$msg?></td>
	</tr>
	<tr>
	<td width="100%" class="tdhead" colspan="2" align="center"><b><?=$lang_PendingTransactions?></b></td>
	</tr>
	<tr>
	
	<td width="40%" height="20" align="left"  >&nbsp;&nbsp;&nbsp;<b><?=$lang_Program?></b> :<?=$transid[1]?></td>
	<td width="60%" height="30" align="right" ><b><?=$lang_Transaction?></b>
	<select name="transid" onchange="document.GetTransaction.submit()">
	<?  while($row=mysqli_fetch_object($result))
	{
	$transaction=$row->transaction_id."~".stripslashes($row->program_url)."~".$row->joinpgm_id;
	if($transid[0]=="$row->transaction_id")
	$pgmName="selected = 'selected'";
	else
	$pgmName="";
	
	?>
	<option <?=$pgmName?> value="<?=$transaction?>"><?=$row->transaction_type?>&nbsp;pgmID=<?=$row->program_id;?> </option>
	<?
	}
	?>
	</select>
	</td>
	</tr>
	<tr>
	<td width="60%" align="center" >
	
	<table border="0" cellpadding="0"  width="90%" class="tablebdr" >
	<tr>
	<td width="100%" colspan="2" class="tdhead" align="center"><b><?=$lang_AffiliateDetails?></b></td>
	</tr>
	<tr>
	<td width="50%" height="20" class="grid1"><?=$lang_Name?></td>
	<td width="50%" height="20" class="grid1"><?=$details[0]?></td>
	</tr>
	<tr>
	<td width="50%" height="20" class="grid1"><?=$lang_Company?></td>
	<td width="50%" height="20" class="grid1"><?=$details[1]?></td>
	</tr>
	<tr>
	<td width="50%" height="20" class="grid1"><?=$lang_SiteUrl?></td>
	<td width="50%" height="20" class="grid1"><?=$details[2]?></td>
	</tr>
	</table>
	<!-- close Table 2 -->
	
	</td>
	<td width="40%" align="center">
	
	<!-- Table 3 adding transaction details-->
	<table border="0" cellpadding="0"   width="90%" class="tablebdr"  >
	<tr>
	<td width="100%" class="tdhead" colspan="2" align="center" ><b><?=$lang_Transaction?> </b></td>
	</tr>
	<tr>
	<td width="34%" class="grid1" height="20" ><?=$lang_Type?></td>
	<td width="40%" align="center"  class="grid1" height="20"><?=$tranStat[0]?></td>
	</tr>
	<tr>
	<td width="35%"  class="grid1" height="20"><?=$lang_Commission?></td>
	<td width="39%" align="center"  height="20" class="grid1" ><?=$currSymbol?><?=$tranStat[1]?></td>
	</tr>
	
	<tr>
	<td width="35%" class="grid1" height="20" ><?=$lang_Date?></td>
	<td width="39%" align="center" height="20" class="grid1"><?=$tranStat[2]?></td>
	</tr>
	<tr>
	<td width="35%" class="grid1" height="20" >Order Value</td>
	<td width="39%" align="center" height="20" class="grid1"><?=$currSymbol?><?php echo $revenue_amount; ?></td>
	</tr>
	<tr>
	<td width="35%" class="grid1" height="20" >Order ID</td>
	<td width="39%" align="center" height="20" class="grid1"><?php echo $transaction_orderid; ?></td>
	</tr>
	
	</table>
	<!-- close Table 3 -->
	
	</td>
	</tr>
	<tr>
	<td width="100%" height="20" colspan="3"></td>
	</tr>
	<tr>
	<td width="100%" height="20"  colspan="3" align="center">
	<input type="submit" name="Reject" value="<?=$common_reject?>" style="width: 100" onclick="return confirmDelete()"/>
	<input type="submit" name="Approve" value="<?=$common_approve?>"  style="width: 100"/>
	</td>
	</tr>
	<tr>
	<td width="100%" height="20" colspan="3"></td>
	</tr>
	<tr>
	<td width="100%" height="20"   align="center" colspan="3">
	<?	if($pgmid){?>
	<a href='index.php?Act=programs&mode=editprogram&programId=<?=$pgmid?>'><?}?><?=$lang_ChangeProgram?> <?   if($pgmid){?></a><?}?>
	</td>
	</tr>
	</table>
	<!-- close Table 1 -->
	
	</form>
           <?php
  }
 else
             {
            ?>
            <!-- Table 4 Err msg-->
             <table width="100%" align="center">
             <tr>
                <td align="center" class="error"><?=$norec?>  </td>
             <tr>
             </table>
             <!-- close Table 4 -->
             <?
             }
             ?>


<!-- Delete confirmation-->
<script language="javascript" type="text/javascript">
   function confirmDelete()
           {
           var del=window.confirm("<?=$lang_rtr_Delete?>") ;
           if (del)
              return true;
           else
              return false;
         }
</script>