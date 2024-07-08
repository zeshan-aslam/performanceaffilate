<?php
/***************************************************************************/
/*     PROGRAMMER     :  DPT                                               */
/*     SCRIPT NAME    :  invoice_format.php                                */
/*     CREATED ON     :  30/MAY/2005                                       */
/*     LAST MODIFIED  :  31/MAY/2005									   */
/*                                                                         */
/*     Invoices Listing Page    	                                       */
/***************************************************************************/

//Added by SMA on 14-JUly-2006 for Admin Users
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
//End Add on 14-July-2006

	//mark an invoice as paid/unpaid
	$id		= intval($_GET['id']);
	$status	= $_GET['status'];
	if(!empty($id))
	{
		//update new status
		$sql = "UPDATE partners_invoice SET invoice_paidstatus = '$status' WHERE invoice_id = '$id'";
		mysqli_query($con,$sql);
	}
	
	//get date range
	$partners = new partners;
	$fromdate		= $partners->date2mysql($_POST['txt_fromdate']);
	$todate			= $partners->date2mysql($_POST['txt_todate']);  
	
	//get invoice type (all, paid or unpaid)
	$invoice_type 	= $_POST['cbo_invoicetype'];	
	
	//------Send Invoice---------
	$option 		= $_POST['hidden_option'];
	if($option=="sendinvoice")
	{
		//get all invoices
		$sql = "SELECT * FROM partners_invoice";
		$res = mysqli_query($con,$sql);
		while($row = mysqli_fetch_object($res))
		{
			$invoice_id = $row->invoice_id;
			$name 		= "chk_".$invoice_id;
			if($_POST[$name]=="on")
			{
				//get details and send to the user as email
				include("send_invoice.php");
			}
		}
	}
	//-----------End of Sending Invoice----------

	/* First check whether for the current month invoice has been created for every merchant, if not create invoice
	   Each invoice for the current month will include only those transactions which occurred during the period when the Invoice
			Status was active for that merchant
	*/	
	//------check whether invoice is created for all merchants for the current month----
	//get all merchants who have active invoice status
	$sql = "SELECT merchant_id FROM partners_merchant WHERE merchant_invoiceStatus='active'";
	$res = mysqli_query($con,$sql);
	while($row = mysqli_fetch_object($res))
	{
		$merchantid = $row->merchant_id;
		
		//get all join program ids of this merchant
		$sql1 = "SELECT joinpgm_id FROM partners_joinpgm WHERE joinpgm_merchantid = '$merchantid'";
		$res1 =  mysqli_query($con,$sql1);
		$join_pgm_ids = "";
		while($row1 = mysqli_fetch_object($res1)) $join_pgm_ids .= $row1->joinpgm_id.",";
		$join_pgm_ids = trim($join_pgm_ids,",");
		
		if(!empty($join_pgm_ids))
		{
			//check whether there is any transaction for this merchant for the current month
			$sql_chk = "SELECT transaction_id FROM partners_transaction WHERE transaction_joinpgmid IN ($join_pgm_ids)";
			$sql_chk .= " AND SUBSTRING(transaction_dateoftransaction,1,7) = '".date('Y-m')."'";
			$res_chk = mysqli_query($con,$sql_chk);
			if(mysqli_num_rows($res_chk)>0)
			{
				//check whether invoices are created for this merchant for the current month
				$sql_chk = "SELECT invoice_id FROM partners_invoice WHERE invoice_merchantid = '$merchantid'";
				$sql_chk .= " AND invoice_monthyear = '".date('m-Y')."'";
				$res_chk = mysqli_query($con,$sql_chk);
				//if not created yet
				if(mysqli_num_rows($res_chk)<=0)
				{
					//calculate the amount for this invoice (sum of amounts only for that period for which the invoice status is active)
					//get all active-inactive periods for current month and store in an array
					$sql1 = "SELECT invoice_date,invoice_status FROM partners_invoiceStat WHERE invoice_merchantid = '$merchantid'";
					$sql1 .= " AND SUBSTRING(invoice_date,1,7) = '".date('Y-m')."'";
					$sql1 .= " ORDER BY invoice_id ASC";
					$res1 = mysqli_query($con,$sql1);
					$invoice_date_arr = $status_arr = array();
					while($row1 = mysqli_fetch_object($res1))
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
						
						//get sum of amount to be paid
						$sql_amount = "SELECT SUM(transaction_amttobepaid) AS total FROM partners_transaction ";
						$sql_amount .= " WHERE transaction_joinpgmid IN ($join_pgm_ids)";
						$sql_amount .= " AND transaction_dateoftransaction BETWEEN '".$fromdate."' AND '".$todate."'";
						$res_amount = mysqli_query($con,$sql_amount);
						if($row_amount = mysqli_fetch_object($res_amount)) $total += $row_amount->total;
						
						//get sum of admin amount
						$sql_amount = "SELECT SUM(transaction_admin_amount) AS total FROM partners_transaction ";
						$sql_amount .= " WHERE transaction_joinpgmid IN ($join_pgm_ids)";
						$sql_amount .= " AND transaction_dateoftransaction BETWEEN '".$invoice_date_arr[$i]."' AND '".$invoice_date_arr[$i+1]."'";
						$res_amount = mysqli_query($con,$sql_amount);
						if($row_amount = mysqli_fetch_object($res_amount)) $total += $row_amount->total;
					}
				
					//get total fee amount for membership free and program fee
					$sql_mem		= "SELECT SUM(adjust_amount) as sum FROM partners_fee WHERE adjust_memberid = $merchantid AND adjust_action like 'register' ";
					$res_mem		= mysqli_query($con,$sql_mem);
					if($row_mem = mysqli_fetch_object($res_mem)) $total += $row_mem->sum;
	                $sql_pgm		= "SELECT SUM(adjust_amount) as sum FROM partners_fee WHERE adjust_memberid = $merchantid AND adjust_action like 'programFee' ";
					$res_pgm		= mysqli_query($con,$sql_pgm);
					if($row_pgm = mysqli_fetch_object($res_pgm)) $total += $row_pgm->sum;				

					//create invoice for this month
					$sql_create = "INSERT INTO partners_invoice SET ";
					$sql_create .= " invoice_merchantid 	= ".$merchantid.",";
					$sql_create .= " invoice_monthyear 		= '".date('m-Y')."',";
					$sql_create .= " invoice_amount 		= ".$total;
					mysqli_query($con,$sql_create);
				}
			}//end of checking for transaction
		}//end of checking for join pgm ids
	}//end of while loop
	
	//for paging
	$page			= trim($_GET['page']);
	if(empty($page)) $page        = $partners->getpage();
	
	//get all invoices
	$sql = "SELECT * FROM partners_invoice WHERE 1";	
	//if from date is specified
	if(isset($_POST['txt_fromdate']))
	{
		//if from date is specified
		if($fromdate!="0000-00-00")
		{
			//get month and year
			$year 	= substr($fromdate,0,4);
			$month 	= substr($fromdate,5,2);
			$sql .= " AND SUBSTRING(invoice_monthyear,1,2) >= '$month'";
			$sql .= " AND SUBSTRING(invoice_monthyear,4,4) >= '$year'";
		}
		//if to date is specified
		if($todate!="0000-00-00")
		{
			//get month and year
			$year 	= substr($todate,0,4);
			$month 	= substr($todate,5,2);
			$sql .= " AND SUBSTRING(invoice_monthyear,1,2) <= '$month'";
			$sql .= " AND SUBSTRING(invoice_monthyear,4,4) <= '$year'";
		}
		//if type is specified
		if(!empty($invoice_type))
		{
			if($invoice_type=="paid") $sql .= " AND invoice_paidstatus = '1'";
			if($invoice_type=="unpaid") $sql .= " AND invoice_paidstatus = '0'";
		}
	}

	//for paging
	$pgsql = $sql;
	$sql  .= " LIMIT ".($page-1)*$lines.",".$lines; 
	

?>

  <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
  </iframe>
			 <form name="frm_invoice1" action="" method="post">          
			 <table width="60%" border='0' cellpadding="0" cellspacing="0" class="tablebdr" >
			    <tr>
                 <td align="left" class="tdhead heading-3" height="25" colspan="2">&nbsp;&nbsp;<u><strong>CHOOSE BILLING PERIOD</strong></u></td>
               </tr>
				<tr>
					<td height="35" align="right">From Date&nbsp;</td><td><input type="text" name="txt_fromdate"  value="" onfocus="javascript:from_date();return false;" /></td></tr>				<tr><td align="right">To Date&nbsp;</td><td><input type="text" name="txt_todate"  value="" onfocus="javascript:to_date();return false;"/></td>
				</tr>				
				<tr>
					<td colspan="2" height="4"></td>
				</tr>            
				<tr>
                <td align="left" height="25" colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;CHOOSE TYPE</b></td>
              </tr>
				<tr><td height="35" align="right">Choose Type&nbsp;</td><td>
						<select name="cbo_invoicetype">
							<option value="">All</option>
							<option value="paid" >Only Paid</option>
							<option value="unpaid" >Only UnPaid</option>
						</select>
				</td></tr>				
				<tr>
					<td colspan="2" height="4"></td>
				</tr>				
				<tr>
					<td colspan="2" align="center"><input type="submit"/></td>
				</tr>				
				<tr><td colspan="2" height="4"></td></tr>			 
				</table>			 	
				</form>                <br />
<br />


<fieldset style="width:95%" class="tablebdr"><legend><strong>INVOICES</strong></legend>
 <table width="95%" border='0' cellpadding="5" cellspacing="5" >
    <tr>
        <td valign="top">
		<form name="frm_invoice2" action="" method="post" onsubmit="return send_invoices()">	
		<input type="hidden" name="hidden_option" value="sendinvoice"/>	
        <table width="100%"  border='0' cellpadding="2" cellspacing="2" >
<?php
	//if no invoice is found	
	$res = mysqli_query($con,$sql);
	if(mysqli_num_rows($res)<=0)
	{
?>
				<tr>
					<td colspan="8" align="center" class="textred">Sorry...No Invoice was found.</td>
				</tr>
<?php	
	}
	else
	{
?>		
				<tr>
					<td colspan="8" align="left">Please select the invoice(s) (by clicking on the checkbox) to send as email.</td>
				</tr>

				<tr class="tdhead">
				  <td width="3%" class="invoiceHead" ></td>
					<td width="9%" height="25" class="invoiceHead" >Id #</td>
					<td width="14%" class="invoiceHead">Month-Year</td>
					<td width="11%" class="invoiceHead">Merchant</td>
					<td width="16%" class="invoiceHead">Amount</td>
					<td width="18%" class="invoiceHead"></td>
					<td width="15%" class="invoiceHead"></td>
					<td width="14%" class="invoiceHead"></td>
				</tr>    
<?php
	//list invoices one by one
	$i = 0;
	while($row = mysqli_fetch_object($res))
	{
		//alternate row colors
		if($i%2) $class =  "grid1";
		else $class = "grid2";
		$i++;
		
		//get merchant name
		$sql1 = "SELECT merchant_firstname, merchant_lastname FROM partners_merchant WHERE merchant_id = '$row->invoice_merchantid'";
		$res1 = mysqli_query($con,$sql1);
		if($row1 = mysqli_fetch_object($res1)) $merchantname = stripslashes($row1->merchant_firstname." ".$row1->merchant_lastname);
		
		//paid status
		if($row->invoice_paidstatus)
		{
			$paidstatus = "Mark as UnPaid";
			$newstatus = '0';
		}
		else
		{
			$paidstatus = "Mark as Paid";
			$newstatus = '1';
		}
		
		//get month and year
		$month_arr = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		$month = $month_arr[ceil(substr($row->invoice_monthyear,0,2))-1];
		$year = substr($row->invoice_monthyear,3,4);
?>				
				<tr class="<?=$class?>">
				  <td ><input type="checkbox" name="chk_<?=$row->invoice_id?>" /></td>
					<td  height="20" ><?=$row->invoice_id?></td>
					<td ><?=$month?>, <?=$year?></td>
					<td ><?=$merchantname?></td>
					<td ><?=$currSymbol?><?=round($row->invoice_amount,2)?></td>
					<td >
					<? if($userobj->GetAdminUserLink('Manage Invoices',$adminUserId,4)) {  ?>
						<a href="index.php?Act=view_transactions&id=<?=$row->invoice_id?>">View Transactions</a>
					<? } else { ?>View Transactions<? } ?>
					</td>
					<td >
					<? if($userobj->GetAdminUserLink('Manage Invoices',$adminUserId,4)) {  ?>
						<a href="index.php?Act=invoice&page=<?=$page?>&id=<?=$row->invoice_id?>&status=<?=$newstatus?>"><?=$paidstatus?></a>
					<? } else { ?><?=$paidstatus?><? } ?>
					</td>
					<td >
					<? if($userobj->GetAdminUserLink('Manage Invoices',$adminUserId,4)) {  ?>
						<a href="index.php?Act=export_invoice&id=<?=$row->invoice_id?>">Export to Excel</a>
					<? } else { ?>Export to Excel<? } ?>
					</td>
				</tr>
<?php
	}
?>				
                <tr>
                  <td  height="20" colspan="8" align="left" >
				  <? if($userobj->GetAdminUserLink('Manage Invoices',$adminUserId,4)) {  ?>
				  <input type="submit" value="Send Invoice(s)"/>&nbsp;
				  <? } ?>
				  </td>
                </tr>
                <tr class="invoiceAdd">
                <td  height="20" colspan="8" align="center" >
<?php
                $url    ="index.php?Act=invoice";    //adding page nos
                include '../includes/show_pagenos.php';
?>				
				</td>
                </tr>
<?php
	}//end of checking for invoice
?>				
            </table>			
		  </form>

	  </td>
    </tr>
    <tr>
        <td height="30">&nbsp;
        </td>
    </tr>
    <tr>

        <td align="center">     </td>
    </tr>
</table>
</fieldset>
	<script language="javascript" type="text/javascript" >
		//function to choose from date
		function from_date()
		{	 
		 gfPop.fStartPop(document.frm_invoice1.txt_fromdate,Date);
		}
		
		//function to choose to date
		function to_date()
		{
		 gfPop.fStartPop(document.frm_invoice1.txt_todate,Date);
		}		
		
		//function to validate send invoice option
		function send_invoices()
		{
			//check whether atleast one check box is selected
			flag = 0;
			for(i=0;i<document.frm_invoice2.elements.length;i++)
			{
				//if check box
				if(document.frm_invoice2.elements[i].name.substr(0,3)=="chk") 
					//if selected
					if(document.frm_invoice2.elements[i].checked) flag = 1;
			}
			//if not selected
			if(!flag)
			{
				alert("Please choose the invoice(s) to be sent");
				return false;
			}

		}
</script> 
<br />