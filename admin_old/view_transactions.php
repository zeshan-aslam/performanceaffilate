<?php
/***************************************************************************/
/*     PROGRAMMER     :  DPT                                               */
/*     SCRIPT NAME    :  view_transactions.php                             */
/*     CREATED ON     :  30/MAY/2005                                       */
/*     LAST MODIFIED  :  31/MAY/2005									   */
/*                                                                         */
/*     List all transactions under an invoice                              */
/***************************************************************************/

	//get invoice id
	$invoiceid = intval($_GET['id']);

	//get invoice details
	$sql = "SELECT * FROM partners_invoice WHERE invoice_id = '$invoiceid'";
	$res = mysql_query($sql);
	if($row = mysql_fetch_object($res))
	{
		$merchantid = $row->invoice_merchantid;
		$monthyear	= $row->invoice_monthyear;
		$year_month	= substr($monthyear,3,4)."-".substr($monthyear,0,2);
	}

	//get details of the merchant
	$sql1 = "SELECT * FROM partners_merchant WHERE merchant_id = '$merchantid'";
	$res1 = mysql_query($sql1);
	if($row1 = mysql_fetch_object($res1))
	{
		$name 			= stripslashes($row1->merchant_firstname." ".$row1->merchant_lastname);
		$address 		= stripslashes($row1->merchant_address);
		$city			= stripslashes($row1->merchant_city);
		$state			= stripslashes($row1->merchant_state);
	}
?>

<br/><br/>
<fieldset class="tablebdr"><legend><strong>INVOICE</strong></legend>
 <table width="98%"   border='0' cellpadding="5" cellspacing="5" >
    <tr>
        <td valign="top">
        <table width="100%"  border='0' cellpadding="2" cellspacing="2" >
                    	<tr>
                    	  <td height="25" colspan="2"  align="center">

			<table width="100%"   border="0" cellpadding="0" cellspacing="0" bgcolor="#D4D0C8" class="invoiceAdd">
            <tr>
                <td align="left" class="textred" height="25">&nbsp;&nbsp;<u><strong>INVOICE</strong></u></td>
            </tr>
            <tr>
                <td align="left" height="20">&nbsp;&nbsp;&nbsp;<?=$name?></td>
            </tr>
            <tr>
                <td align="left" height="20">&nbsp;&nbsp;&nbsp; <?=$address?></td>
            </tr>
            <tr>
            <td align="left" height="20">&nbsp;&nbsp;&nbsp; <?=$city?></td>
            </tr>
                <tr>
            <td align="left" height="20">&nbsp;&nbsp;&nbsp;  <?=$state?></td>
            </tr>
            </table>

			</td>
				  <td height="25"  align="center">&nbsp;</td>
				  <td height="25" colspan="2" align="center" >
				  <a href="#" onclick="javascript:history.go(-1);">Back to Invoices&raquo;</a>

				  </td>
			  </tr>
			<tr>
				<td height="25" class="tdhead" align="center">Transaction  </td>
				<td height="25" class="tdhead" align="center">Date</td>
				<td height="25" class="tdhead" align="center">Affiliate Commission  </td>
				<td height="25" class="tdhead" align="center">Admin Commission  </td>
				<td height="25" class="tdhead" align="center">Total</td>
			</tr>
<?php

		//initialize
		$total_clicks = $total_leads = $total_sales = $click_amount = $lead_amount = $sale_amount = 0;

		//get all join program ids of this merchant
		$sql1 = "SELECT joinpgm_id FROM partners_joinpgm WHERE joinpgm_merchantid = '$merchantid'";
		$res1 =  mysql_query($sql1);
		$join_pgm_ids = "";
		while($row1 = mysql_fetch_object($res1)) $join_pgm_ids .= $row1->joinpgm_id.",";
		$join_pgm_ids = trim($join_pgm_ids,",");

		if(!empty($join_pgm_ids))
		{
			//get all active-inactive periods for current month and store in an array
			$sql1 = "SELECT invoice_date,invoice_status FROM partners_invoiceStat WHERE invoice_merchantid = '$merchantid'";
			$sql1 .= " AND SUBSTRING(invoice_date,1,7) = '".$year_month."'";
			$sql1 .= " ORDER BY invoice_id ASC";
			$res1 = mysql_query($sql1);
			$invoice_date_arr = $status_arr = array();
			while($row1 = mysql_fetch_object($res1))
			{
				$invoice_date_arr[] = $row1->invoice_date;
				$status_arr[]		= $row1->invoice_status;
			}

			//find the transactions for each period
			$total  = 0;
			$count = count($invoice_date_arr);
			for($i=0;$i<$count;$i+=2)
			{
				$fromdate 	=	$invoice_date_arr[$i];
				$todate 	=	$invoice_date_arr[$i+1];

				//in the case of last one
				if(empty($todate))
				{
					//if the last status is inactive
					if($status_arr[$count-1] == 'inactive')
						//then skip the loop
						break;
					else
						//consider transactions till current date
						$todate = date('Y-m-d');
				}

				//get transactions
				$sql_trans = "SELECT * FROM partners_transaction ";
				$sql_trans .= " WHERE transaction_joinpgmid IN ($join_pgm_ids)";
				$sql_trans .= " AND transaction_dateoftransaction BETWEEN '".$fromdate."' AND '".$todate."'";
				$res_trans	= mysql_query($sql_trans);

				//list one by one
				$r = 0;
				while($row_trans = mysql_fetch_object($res_trans))
				{
					//alternate row colors
					if($r%2) $class =  "grid1";
					else $class = "grid2";
					$r++;

				   $transamount = $row_trans->transaction_amttobepaid;
				   $trans	    = $row_trans->transaction_type;
				   $date	    = $row_trans->transaction_dateoftransaction;
				   $adminamnt	= $row_trans->transaction_admin_amount;
				   $total		= $transamount + $adminamnt;

				   //get consolidated report
				   if($trans=="click")
				   {
				   		$total_clicks++;
						$click_amount += $total;
				   }
				   if($trans=="lead")
				   {
				   		$total_leads++;
						$lead_amount += $total;
				   }
				   if($trans=="sale")
				   {
				   		$total_sales++;
						$sale_amount += $total;
				   }
?>
                              <tr class="<?=$class?>">
                                      <td height="25" align="center"><?=$trans?></td>
                                      <td height="25" align="center"><?=$date?></td>
                                      <td height="25" align="center"><?=$currSymbol?>&nbsp;<?=round($transamount,2)?></td>
                                      <td height="25" align="center"><?=$currSymbol?>&nbsp;<?=round($adminamnt,2)?></td>
                                       <td height="25" align="center"><?=$currSymbol?>&nbsp;<?=round($total,2)?></td>
                              </tr>
<?php
				}//end of while loop
			}//end of for loop

		}//end of checking for join pgm ids

	//get total fee amount for membership free and program fee
	$sql_mem		= "SELECT COUNT(*) AS c, SUM(adjust_amount) AS sum FROM partners_fee WHERE adjust_memberid = '$merchantid' AND adjust_action like 'register' ";
	$res_mem		= mysql_query($sql_mem);
	$fee_amount = $program_amount = 0;
	if($row_mem = mysql_fetch_object($res_mem))
	{
		$fee_amount 	= $row_mem->sum;
		$total_register	= $row_mem->c;
	}
	$sql_pgm		= "SELECT COUNT(*) AS c,SUM(adjust_amount) as sum FROM partners_fee WHERE adjust_memberid = '$merchantid' AND adjust_action like 'programFee' ";
	$res_pgm		= mysql_query($sql_pgm);
	if($row_pgm = mysql_fetch_object($res_pgm))
	{
		$program_amount = $row_pgm->sum;
		$total_program	= $row_pgm->c;
	}

	//find final total
	$total = $click_amount + $lead_amount + $sale_amount + $fee_amount + $program_amount;
?>
            </table>
		</td>
    </tr>
	<tr>
		<td align="center">
			<table width="81%"  border='0' cellspacing="2" cellpadding="2" class="invoiceAdd">
            <tr align="center">
                <td colspan="6" class="invoiceHead" height="30"> Consolidated Report </td>
                </tr>
            <tr>
                <td width="3%">&nbsp;</td>
                <td width="18%" align="right"><strong>Clicks(  <?=$total_clicks?> ) :</strong></td>
                <td width="17%" align="right" class="textred"><strong><?=$currSymbol?>&nbsp;<?=round($click_amount,2)?></strong></td>
                <td width="33%" align="right"><strong>Membership Fee(  <?=$total_register?> ) : </strong></td>
                <td width="18%" align="right" class="textred"><strong><?=$currSymbol?>&nbsp;<?=round($fee_amount,2)?> </strong></td>
                <td width="11%" align="right" class="textred">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="right"><strong>Leads(  <?=$total_leads?> ) :</strong></td>
                <td align="right" class="textred"><strong><?=$currSymbol?>&nbsp;<?=round($lead_amount,2)?></strong></td>
                <td align="right"><strong>Program Fee( <?=$total_program?> ) :</strong></td>
                <td align="right" class="textred"><strong><?=$currSymbol?>&nbsp;<?=round($program_amount,2)?> </strong></td>
                <td align="right" class="textred">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="right"><strong>Sale( <?=$total_sales?> ) :</strong></td>
                <td align="right" class="textred"><strong><?=$currSymbol?>&nbsp;<?=round($sale_amount,2)?> </strong></td>
                <td align="right" class="textred">&nbsp;</td>
                <td align="right" class="textred">&nbsp;</td>
                <td align="right" class="textred">&nbsp;</td>
                </tr>
            <tr align="center">
                <td colspan="6">-------------------------------------------------------------------------------------------------</td>
                </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="right" colspan="3" ><strong>Total</strong></td>
                <td align="right" class="textred"><strong><?=$currSymbol?>&nbsp;<?=round($total,2)?> </strong></td>

                <td align="right" class="textred">&nbsp;</td>
            </tr>
            </table>
		</td>
	</tr>
</table>
</fieldset>