<?php
   	$transid	= intval($_GET['transid']);

  //geting records from table
    $trn_sql 	= "select * from partners_temp where temp_id='$transid'";
    $trn_ret 	= mysql_query($trn_sql);
    if(mysql_num_rows($trn_ret)>0)   {

		$trn_row		=mysql_fetch_object($trn_ret);
		$transids		=$trn_row->temp_transaction;

		//geting records from table
		$sql ="select *,date_format(transaction_dateoftransaction,'%d-%M-%Y') as DATE from partners_transaction where transaction_id in ($transids)";
		$ret =mysql_query($sql);
		//checking for each records
		if(mysql_num_rows($ret)>0)
		{
			?>
			<br/>
			<table width="90%" class="tablebdr" align="center">
				<tr>
					<td height="25" class="tdhead" align="center">Transaction  </td>
					<td height="25" class="tdhead" align="center">Date</td>
					<td height="25" class="tdhead" align="center">Affiliate Commission  </td>
					<td height="25" class="tdhead" align="center">Admin Commission  </td>
				</tr>
			   <?
				while($row=mysql_fetch_object($ret))
				{
				   $transamount =$row->transaction_amttobepaid;
				   $trans	    =$row->transaction_type;
				   $date	    =$row->DATE;
				   $adminamnt	=$row->transaction_amttobepaid;
				   ?>
				  <tr>
					  <td height="25" align="center"><?=$trans?></td>
					  <td height="25" align="center"><?=$date?></td>
					  <td height="25" align="center"><?=$transamount?></td>
					  <td height="25" align="center"><?=$adminamnt?></td>
				  </tr>
					   <?
				}
		}
                ?>
                </table>
                <?
   }
?>
