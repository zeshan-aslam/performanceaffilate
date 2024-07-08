<?php
/***************************************************************************/
/*     PROGRAMMER     :  DPT                                               */
/*     SCRIPT NAME    :  send_invoice.php                                  */
/*     CREATED ON     :  31/MAY/2005                                       */
/*     LAST MODIFIED  :  31/MAY/2005									   */
/*                                                                         */
/*     Send an Invoice as mail                                             */
/***************************************************************************/

	//get invoice details
	$sql1 = "SELECT * FROM partners_invoice WHERE invoice_id = '$invoice_id'";
	$res1 = mysql_query($sql1);
	if($row1 = mysql_fetch_object($res1))
	{
		$merchantid = $row1->invoice_merchantid;
		$monthyear	= $row1->invoice_monthyear;

		//get month and year
		$month_arr = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		$month = $month_arr[ceil(substr($monthyear,0,2))-1];
		$year = substr($monthyear,3,4);
		$year_month	= substr($monthyear,3,4)."-".substr($monthyear,0,2);
	}

	//get details of the merchant
	$sql1 = " SELECT * FROM partners_merchant WHERE merchant_id = '$merchantid' ";
	$res1 = mysql_query($sql1);
	if($row1 = mysql_fetch_object($res1))
	{
		$name 			= stripslashes($row1->merchant_firstname." ".$row1->merchant_lastname);
		$address 		= stripslashes($row1->merchant_address);
		$city			= stripslashes($row1->merchant_city);
		$state			= stripslashes($row1->merchant_state);
	}

	//get email id of user
	$sql1 = "SELECT  login_email FROM partners_login WHERE login_flag='m' AND login_id = '$merchantid'";
	$res1 = mysql_query($sql1);
	if($row1 = mysql_fetch_object($res1)) $email = $row1->login_email;

$message = "<style>";
$message .= ".invoiceAdd{\n";
$message .= "    font-family: Verdana, Arial, Helvetica, sans-serif;\n";
$message .= "    font-size: 10px;\n";
$message .= " background-color:#FBF9EC;\n";
$message .= " border:1px solid #666666\n";
$message .= "}\n";
$message .= ".invoiceAdd2{\n";
$message .= "    font-family: Verdana, Arial, Helvetica, sans-serif;\n";
$message .= "    font-size: 10px;\n";
$message .= " background-color: #CCCCCC;\n";
$message .= " border:1px solid #666666\n";
$message .= "}\n";
$message .= ".invoiceHead{\n";
$message .= "    font-family: Verdana, Arial, Helvetica, sans-serif;\n";
$message .= "    font-size: 10px;\n";
$message .= "    color: #003366 ;\n";
$message .= "    font-weight: bold;\n";
$message .= "\n";
$message .= "    text-decoration:  underline;\n";
$message .= "}\n";
$message .= ".tablebdr {\n";
$message .= " 	 font-family: Verdana; color: #666666; border: 1px solid #666666;\n";
$message .= "   font-size:10pt; background-color:#FFFFFF\n";
$message .= "}\n";
$message .= ".textred{\n";
$message .= "   font-family: Verdana; color: #CC3300; font-size:10pt; }\n";
$message .= "\n";
$message .= ".grid1    {\n";
$message .= "   border:0px solid #808080; font-family: Verdana;\n";
$message .= "   color: #000000 ; font-size:9pt; background-color: #F7F7F7;\n";
$message .= "}\n";
$message .= "\n";
$message .= ".grid2   {\n";
$message .= "  border:1px solid #808080; font-family: Verdana;\n";
$message .= "  background-color: #EEEEEE; font-size:9pt;color: #7E7E7E;\n";
$message .= "}\n";
$message .= ".tdhead   {\n";
$message .= "                       border:0px solid #808080; font-family: Verdana;\n";
$message .= "                       color: #FFFFFF; font-size:10pt; background-color: #C0C0C0; font-weight:bold\n";
$message .= "}\n";
$message .= "</style>";
$message .= "<br/><br/>\n";
$message .= "<fieldset class=\"tablebdr\"><legend><strong>INVOICE</strong></legend>\n";
$message .= " <table width=\"98%\"   border='0' cellpadding=\"5\" cellspacing=\"5\" >\n";
$message .= "    <tr>\n";
$message .= "        <td valign=\"top\">\n";
$message .= "        <table width=\"100%\"  border='0' cellpadding=\"2\" cellspacing=\"2\" >\n";
$message .= "                        <tr>\n";
$message .= "                          <td height=\"25\" colspan=\"2\"  align=\"center\">\n";
$message .= "\n";
$message .= "            <table width=\"100%\"   border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" bgcolor=\"#D4D0C8\" class=\"invoiceAdd\">\n";
$message .= "            <tr>\n";
$message .= "                <td align=\"left\" class=\"textred\" height=\"25\">&nbsp;&nbsp;<u><strong>INVOICE</strong></u></td>\n";
$message .= "            </tr>\n";
$message .= "            <tr>\n";
$message .= "                <td align=\"left\" height=\"20\">&nbsp;&nbsp;&nbsp;$name</u></td>\n";
$message .= "            </tr>\n";
$message .= "            <tr>\n";
$message .= "                <td align=\"left\" height=\"20\">&nbsp;&nbsp;&nbsp; $address</u></td>\n";
$message .= "            </tr>\n";
$message .= "            <tr>\n";
$message .= "            <td align=\"left\" height=\"20\">&nbsp;&nbsp;&nbsp; $city</u></td>\n";
$message .= "            </tr>\n";
$message .= "                <tr>\n";
$message .= "            <td align=\"left\" height=\"20\">&nbsp;&nbsp;&nbsp;  $state</u></td>\n";
$message .= "            </tr>\n";
$message .= "            </table>\n";
$message .= "\n";
$message .= "                          </td>\n";
$message .= "                          <td height=\"25\"  align=\"center\">&nbsp;</td>\n";
$message .= "                          <td height=\"25\" colspan=\"2\" align=\"center\" ></td>\n";
$message .= "                      </tr>\n";
$message .= "                        <tr>\n";
$message .= "                            <td height=\"25\" class=\"tdhead\" align=\"center\">Transaction  </td>\n";
$message .= "                            <td height=\"25\" class=\"tdhead\" align=\"center\">Date</td>\n";
$message .= "                            <td height=\"25\" class=\"tdhead\" align=\"center\">Affiliate Commission  </td>\n";
$message .= "                            <td height=\"25\" class=\"tdhead\" align=\"center\">Admin Commission  </td>\n";
$message .= "                            <td height=\"25\" class=\"tdhead\" align=\"center\">Total</td>\n";
$message .= "                        </tr>\n";

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
$message .= "                              <tr class=\"$class\">\n";
$message .= "                                      <td height=\"25\" align=\"center\">$trans</td>\n";
$message .= "                                      <td height=\"25\" align=\"center\">$date</td>\n";
$message .= "                                      <td height=\"25\" align=\"center\">$".$transamount."</td>\n";
$message .= "                                      <td height=\"25\" align=\"center\">$".$adminamnt."</td>\n";
$message .= "                                       <td height=\"25\" align=\"center\">$".$total."</td>\n";
$message .= "                              </tr>\n";

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

$message .= "            </table>\n";
$message .= "        </td>\n";
$message .= "    </tr>\n";
$message .= "    <tr>\n";
$message .= "        <td align=\"center\">\n";
$message .= "            <table width=\"81%\"  border='0' cellspacing=\"2\" cellpadding=\"2\" class=\"invoiceAdd\">\n";
$message .= "            <tr align=\"center\">\n";
$message .= "                <td colspan=\"6\" class=\"invoiceHead\" height=\"30\"> Consolidated Report </td>\n";
$message .= "                </tr>\n";
$message .= "            <tr>\n";
$message .= "                <td width=\"3%\">&nbsp;</td>\n";
$message .= "                <td width=\"18%\" align=\"right\"><strong>Clicks(  $total_clicks ) :</strong></td>\n";
$message .= "                <td width=\"17%\" align=\"right\" class=\"textred\"><strong>    $".$click_amount."</strong></td>\n";
$message .= "                <td width=\"33%\" align=\"right\"><strong>Membership Fee(  $total_register ) : </strong></td>\n";
$message .= "                <td width=\"18%\" align=\"right\" class=\"textred\"><strong>  $".$fee_amount." </strong></td>\n";
$message .= "                <td width=\"11%\" align=\"right\" class=\"textred\">&nbsp;</td>\n";
$message .= "            </tr>\n";
$message .= "            <tr>\n";
$message .= "                <td>&nbsp;</td>\n";
$message .= "                <td align=\"right\"><strong>Leads(  $total_leads ) :</strong></td>\n";
$message .= "                <td align=\"right\" class=\"textred\"><strong>$".$lead_amount."</strong></td>\n";
$message .= "                <td align=\"right\"><strong>Program Fee( $total_program ) :</strong></td>\n";
$message .= "                <td align=\"right\" class=\"textred\"><strong>  $".$program_amount." </strong></td>\n";
$message .= "                <td align=\"right\" class=\"textred\">&nbsp;</td>\n";
$message .= "            </tr>\n";
$message .= "            <tr>\n";
$message .= "                <td>&nbsp;</td>\n";
$message .= "                <td align=\"right\"><strong>Sale( $total_sales ) :</strong></td>\n";
$message .= "                <td align=\"right\" class=\"textred\"><strong>$".$sale_amount." </strong></td>\n";
$message .= "                <td align=\"right\" class=\"textred\">&nbsp;</td>\n";
$message .= "                <td align=\"right\" class=\"textred\">&nbsp;</td>\n";
$message .= "                <td align=\"right\" class=\"textred\">&nbsp;</td>\n";
$message .= "                </tr>\n";
$message .= "            <tr align=\"center\">\n";
$message .= "                <td colspan=\"6\">-------------------------------------------------------------------------------------------------</td>\n";
$message .= "                </tr>\n";
$message .= "            <tr>\n";
$message .= "                <td>&nbsp;</td>\n";
$message .= "                <td align=\"right\" colspan=\"3\" ><strong>Total</strong></td>\n";
$message .= "                <td align=\"right\" class=\"textred\"><strong>  $".$total." </strong></td>\n";
$message .= "\n";
$message .= "                <td align=\"right\" class=\"textred\">&nbsp;</td>\n";
$message .= "            </tr>\n";
$message .= "            </table>\n";
$message .= "        </td>\n";
$message .= "    </tr>\n";
$message .= "</table>\n";
$message .= "</fieldset>\n";

//send mail
$fromAddress = $_SESSION['MAIL'];
$messageers        =  "Content-Type: text/html; charset=iso-8859-1\n";
$messageers       .=  "From: $fromAddress\n";
$subject 		= "Invoice For ".$month.", ".$year;
mail($email,$subject,$message,$messageers);
?>