<?
	include "transactions.php";
	include "../mail.php";
	
	$MERCHANTID                        =$_SESSION['MERCHANTID']; 
	$transid                           =trim($_POST['transid']);
	$transid                           =explode('~',$transid);
	$pgmid                             =trim($_GET['pgmid']); 
	$mode                              =trim($_POST['mode']); 
	
	# reversale
	switch($mode){
		case 'Reverse Sale':    //Reverse Sale
			$sql	= " update partners_transaction set transaction_status = 'reverserequest' where transaction_id = '$transid[0]'";
			mysqli_query($con,$sql);
		//   MailEvent("Reverse Sale",$MERCHANTID,$transid[2],$to,$transid[0]);
			$pgmid	= 0;
		break;
	
	}

	switch($pgmid){
		case '0':     //all
			$sql	= " select * from partners_joinpgm, partners_transaction, partners_program 
						where joinpgm_merchantid='$MERCHANTID' and transaction_type='sale' 
						and transaction_status  not like ('pending') and transaction_status  not like ('reversed') 
						and joinpgm_id=transaction_joinpgmid and program_id=joinpgm_programid 
						AND transaction_recur not like '1'  ";
		break;
		
		default :    //selected pgms
			$sql	= " select * from partners_joinpgm, partners_transaction, partners_program 
						where program_id='$pgmid' and transaction_type='sale' and transaction_status not like ('pending') 
						and transaction_status  not like ('reversed') and joinpgm_id=transaction_joinpgmid 
						and program_id=joinpgm_programid AND transaction_recur not like '1' ";
		break;
	}  
	$result			= mysqli_query($con,$sql);
	$result1        = mysqli_query($con,$sql);

	# getting statistics
	if (mysqli_num_rows($result)>0){
              $rows                        =mysqli_fetch_object($result1);  //for first time
              $id                          =$rows->transaction_id;
              $joinid                      =$rows->joinpgm_id;
              $pgmname                     =stripslashes($rows->program_url);
              if (empty($transid[0]))
                       {
                     $transid[0]                =$id;
                     $transid[2]                =$joinid;
                     $transid[1]                =$pgmname;
                     }

              $tranStat                =GetTransaction($transid[0],$currValue,$default_currency_caption);   //getting Transaction Statistics from transaction.php
              $tranStat                =explode('~',$tranStat);
              //echo "$transid[2]";
              $details                = GetAffiliateDetails($transid[2]);  //getting Affiliate Staistics   from transaction.php
              $details                =explode('~',$details);
               ?>



            <br/>
	<form name="GetTransaction" method="post" action="index.php?Act=reversesale&amp;pgmid=<?=$pgmid?>">
	<table border="0" cellpadding="0" cellspacing="0" width="70%" align= "center"class="tablebdr">
		<tr>
			<td width="100%" class="tdhead" colspan="2" align="center"><b><?=$lang_reverse_totalsale?></b></td>
		</tr>
		<tr>
			<td width="40%" height="20" align="left" >&nbsp;&nbsp;&nbsp;
			<b><?=$lang_report_pgm?></b> : <?=stripslashes($transid[1])?></td>
			<td width="60%" height="30" align="right" ><b><?=$lang_report_transaction?></b>
			<select name="transid" onchange="document.GetTransaction.submit()">
			<?  
			while($row=mysqli_fetch_object($result)){
				$transaction=$row->transaction_id."~".stripslashes($row->program_url)."~".$row->joinpgm_id;
				if($transid[0]=="$row->transaction_id")
					$pgmName="selected = 'selected'";
				else
					$pgmName="";
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
	
	<table border="0" cellpadding="0"  width="90%" class="tablebdr" >
	<tr>
	<td width="100%" colspan="2" class="tdhead" align="center"><b><?=$lang_reverse_details?></b></td>
	</tr>
	<tr>
	<td width="50%" height="20" class="grid1"><b><?=$lang_reverse_name?></b></td>
	<td width="50%" height="20" class="grid1"><?=$details[0]?></td>
	</tr>
	<tr>
	<td width="50%" height="20" class="grid1"><b><?=$lang_reverse_company?></b></td>
	<td width="50%" height="20" class="grid1"><?=$details[1]?></td>
	</tr>
	<tr>
	<td width="50%" height="20" class="grid1"><b><?=$lang_reverse_url?></b></td>
	<td width="50%" height="20" class="grid1"><?=$details[2]?></td>
	</tr>
	</table>
	
	</td>
	<td width="40%" align="center">
	
	<table border="0" cellpadding="0"   width="90%" class="tablebdr"  >
	<tr>
	<td width="100%" class="tdhead" colspan="2"  align="center"><b><?=$lang_reverse_sale?> </b></td>
	</tr>
	<tr>
	<td width="34%" class="grid1" height="20" ><b><?=$lang_reverse_status?></b></td>
	<td width="40%" align="center"  class="grid1" height="20"><?=$tranStat[3]?></td>
	</tr>
	<tr>
	<td width="35%"  class="grid1" height="20"><b><?=$lang_reverse_commission?></b></td>
	<td width="39%" align="center"  height="20" class="grid1" ><?=$tranStat[1]?> <?=$currSymbol?></td>
	</tr>
	
	<tr>
	<td width="35%" class="grid1" height="20" ><b><?=$lang_reverse_date?></b></td>
	<td width="39%" align="center" height="20" class="grid1"><?=$tranStat[2]?></td>
	</tr>
	</table>
	</td>
	</tr>
	<tr>
	<td width="100%" height="20" colspan="3"></td>
	</tr>
	<tr>
	<td width="100%" height="20"  colspan="3" align="center">
	<input type="submit" name="mode" value="Reverse Sale" title="<?=$lang_reversesale?>" style="width: 100" onclick="return confirmDelete()"/>
	
	</td>
	</tr>
	<tr>
	<td width="100%" height="20" colspan="3">&nbsp;</td>
	</tr>
	</table>
	</form>
           <?php
  }
  else
             {
            ?>

              <!--  table  4-->
             <table width="100%" align="center">
             <tr>
                <td align="center" class="error"><?=$norec?></td>
             <tr>
             </table>
               <!-- close table 4-->

             <?
             }?>


<script language="javascript" type="text/javascript">
   function confirmDelete()
           {
           var del=window.confirm("<?=$lang_reverse_confirm?>") ;
           if (del)
              return true;
           else
              return false;
         }
</script>