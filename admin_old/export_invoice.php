<?php
/***************************************************************************/
/*     PROGRAMMER     :  DPT                                               */
/*     SCRIPT NAME    :  export_invoice.php                                */
/*     CREATED ON     :  31/MAY/2005                                       */
/*     LAST MODIFIED  :  31/MAY/2005									   */
/*                                                                         */
/*     Export Invoice                                                      */
/***************************************************************************/

	//get invoice id
	$invoiceid = intval($_GET['id']);
	
	//open file
	$fp = fopen("invoice.xls","w");
	
	//write first line
	fwrite($fp,"Program ID;From Date;To Date;Fee Type;Quantity;Unit Price;TotalPrice\n\r");	
	
	//get merchant of this invoice
	$sql1 = "SELECT * FROM partners_invoice WHERE invoice_id = '$invoiceid'";
	$res1 = mysql_query($sql1);
	if($row1 = mysql_fetch_object($res1))
	{
		$merchantid = $row1->invoice_merchantid;	
		$monthyear	= $row1->invoice_monthyear;
		
		$year_month	= substr($monthyear,3,4)."-".substr($monthyear,0,2);
	}
	
	//Initialize
	$totalprice	= 0;
	
	//Get all periods and store in an array
	//get all active-inactive periods for the month and store in an array
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
	
	//Get all programs ids of the merchant
	$sql1 = "SELECT joinpgm_programid FROM partners_joinpgm WHERE joinpgm_merchantid = '$merchantid'";
	$res1 = mysql_query($sql1);
	while($row1 = mysql_fetch_object($res1)) $program_id_arr[]	= $row1->joinpgm_programid;
	
	//For each program id get the join program ids
	for($i=0;$i<count($program_id_arr);$i++)
	{	
		$programid = $program_id_arr[$i];
		$sql1 = "SELECT joinpgm_id FROM partners_joinpgm WHERE joinpgm_programid = '".$programid."' AND joinpgm_merchantid = '$merchantid'";
		$res1 = mysql_query($sql1);
	
		//For each join program id 
		while($row1 = mysql_fetch_object($res1))
		{
			$joinpgmid = $row1->joinpgm_id;
			//For each period
			$count = count($invoice_date_arr);
			for($p=0;$p<$count;$p+=2)
			{				
				$fromdate 	=	$invoice_date_arr[$p];
				$todate 	=	$invoice_date_arr[$p+1];
				
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
				
				//Initialize
				$clicks_count = $sales_count = $leads_count = $register_count = $program_count = 0;
							
				//Get Clicks count
				$sql_count = "SELECT COUNT(*) AS c FROM partners_transaction WHERE transaction_type = 'click'";
				$sql_count .= " AND transaction_dateoftransaction BETWEEN '".$fromdate."' AND '".$todate."'";
				$sql_count .= " AND transaction_joinpgmid = '$joinpgmid'";
				$res_count = mysql_query($sql_count);
				if($row_count = mysql_fetch_object($res_count)) $clicks_count = $row_count->c;
				
				//Get Sales count
				$sql_count = "SELECT COUNT(*) AS c FROM partners_transaction WHERE transaction_type = 'sale'";
				$sql_count .= " AND transaction_dateoftransaction BETWEEN '".$fromdate."' AND '".$todate."'";
				$sql_count .= " AND transaction_joinpgmid = '$joinpgmid'";
				$res_count = mysql_query($sql_count);
				if($row_count = mysql_fetch_object($res_count)) $sales_count = $row_count->c;
				
				//Get Leads count
				$sql_count = "SELECT COUNT(*) AS c FROM partners_transaction WHERE transaction_type = 'lead'";
				$sql_count .= " AND transaction_dateoftransaction BETWEEN '".$fromdate."' AND '".$todate."'";
				$sql_count .= " AND transaction_joinpgmid = '$joinpgmid'";
				$res_count = mysql_query($sql_count);
				if($row_count = mysql_fetch_object($res_count)) $leads_count = $row_count->c;
				
				//Get Member Fee
				$sql_count = "SELECT COUNT(*) AS c FROM partners_fee WHERE adjust_memberid = '$merchantid' AND adjust_action like 'register'";
				$sql_count .= " AND adjust_date BETWEEN '".$fromdate."' AND '".$todate."'";
				$res_count = mysql_query($sql_count);
				if($row_count = mysql_fetch_object($res_count)) $register_count = $row_count->c;				
				
				//Get Program Fee				
				$sql_count = "SELECT COUNT(*) AS c FROM partners_fee WHERE adjust_memberid = '$merchantid' AND adjust_action like 'programFee'";
				$sql_count .= " AND adjust_date BETWEEN '".$fromdate."' AND '".$todate."'";
				$res_count = mysql_query($sql_count);
				if($row_count = mysql_fetch_object($res_count)) $program_count = $row_count->c;
				
				//Find totals
				$click_total	= ($clicks_count * $admin_clickrate);
				$lead_total		= ($leads_count * $admin_leadrate);
				$sale_total		= ($sales_count * $admin_salerate);			
				$totalprice		+= $click_total + $lead_total + $sale_total;
				
				//Write to file
				if($clicks_count>0) fwrite($fp,$programid.";".$fromdate.";".$todate.";".'Click'.";".$clicks_count.";$currSymbol".$admin_clickrate.";$currSymbol".round($click_total,2)."\n\r");
				if($sales_count>0) fwrite($fp,$programid.";".$fromdate.";".$todate.";".'Sale'.";".$sales_count.";$currSymbol".$admin_salerate.";$currSymbol".round($sale_total,2)."\n\r");			
				if($leads_count>0) fwrite($fp,$programid.";".$fromdate.";".$todate.";".'Lead'.";".$leads_count.";$currSymbol".$admin_leadrate.";$currSymbol".round($lead_total,2)."\n\r");							
				if($register_count>0) fwrite($fp,$programid.";".$fromdate.";".$todate.";".'Member Fee'.";".$register_count.";$currSymbol".$unitprice.";\n\r");			
				if($program_count>0) fwrite($fp,$programid.";".$fromdate.";".$todate.";".'Program Fee'.";".$program_count.";$currSymbol".$unitprice.";\n\r");							
			}//end of for loop for periods
		}//end of for loop for join program ids
	}//end of for loop for program ids	
	
	//Last row should be date range and total amount
	fwrite($fp,"Total;".$invoice_date_arr[0].";".$invoice_date_arr[$count-1].";;;;$currSymbol".round($totalprice,2));
	
	//close file
	fclose($fp);
?>
<br/><br/><a href="invoice.xls">Click here to download the file</a>