<?php
    session_start();
    include_once 'session.php';



	class text_display
	{
			/*-------------------------------------------------------------------------------------------
			Function to Display the TextAd with the selected colors.  Used in get_trackingcode.php.
			Created By        :         SMA
			Created On         :         15-June-2006
			-------------------------------------------------------------------------------------------*/
			function displayTextAd($id,$col_boder,$col_back,$col_title,$col_url,$col_head,$col_desc,$trackUrl,$newwindow,$width,$height,$track_site_url)
			{

					$con = $GLOBALS["con"];

					if($col_boder=="") {
							$col_boder = "#3399FF";
							$col_back = "#FFFFFF";
							$col_title = "#000000";
							$col_url = "#009900";
							$col_head = "#FFFFFF";
							$col_desc = "#7E7E7E";
					}
					if($width == '') $width = 500;
					if($height == '') $height = 75;

					if($newwindow == 1)  {
							$OpenWindow = "target='_blank'";
					} else {
							$OpenWindow = "";
					}

					$code = "";
					$sql = "select * from partners_text where text_id='".$id."'";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0 )
					{
							$row = mysqli_fetch_object($res);
							$row_text         = $row->text_text;
							$row_no                = $row->text_rows;
							$url                = $row->text_url;
							$desc                = $row->text_description;

							# if the 1st part of the URL not contain http:/
							$url_test = substr($url, 0, 7);
							if($url_test!="http://")
							{
									$url   =    "http://".$url;
							}
							//getting only domain name from the url
							$url1        = explode("://",$url);
							$url2        = explode("/",$url1[1]);
							$disp_url        = "http://".$url2[0];

							$image                 = $row->text_image;
					}
					$tableWidth = $width-2;
					$tableHeight = $height-2;
					$imgHeight = $height - 25;

					if(!empty($image)) {
							$img_colspan = " colspan=2 ";
							$imgcode = "<img src='$track_site_url/thumbnail.php?image=$image&height=$imgHeight' alt='0' border='0' />";
					} else {
							$img_colspan = "";
							$imgcode = "";
					}

					$code  = "<div style=\"border:none; width:$width; height:$height; overflow:hidden\" >";
					$code .= "<table align=\"center\" width=\"$tableWidth\" height=\"$tableHeight\" border=\"1\" style=\"border-color:$col_boder; \" cellpadding=\"0\" cellspacing=\"0\">";
					$code .= "<tr style=\"border:none;\" valign=\"top\">";
					$code .= "<td style=\"border:none;\" valign=\"top\" width=\"$tableWidth\" height=\"$tableHeight\">";
					$code .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"$tableWidth\" height=\"$tableHeight\">";
					$code .= "<tr bgcolor=\"$col_boder\">";
					$code .= "<td align=\"left\" height=\"10\" valign=\"top\" colspan=\"2\" ><font style=\"color:$col_head; font-family:verdana; font-size:10px;\"><b>SPONSORED LISTINGS</b></font></td>";
					$code .= "</tr>";
					$code .= "<tr bgcolor=\"$col_back\">";
					$code .= "<td align=\"left\"><a href='$trackUrl' $OpenWindow ><font style=\"color:$col_title; font-family:verdana; font-size:10px;\"  ><b>$row_text</b></font></a></td>";
					$code .= "<td align=\"right\" rowspan=\"3\" > $imgcode </td>";
					$code .= "</tr>";
					$code .= "<tr bgcolor=\"$col_back\">";
					$code .= "<td align=\"left\"><font style=\"color:$col_desc; font-family:verdana; font-size:10px;\" >$desc</font></td>";
					$code .= "</tr>";
					$code .= "<tr bgcolor=\"$col_back\">";
					$code .= "<td align=\"left\"><font style=\"color:$col_url; font-family:verdana; font-size:10px;\" >$disp_url</font></td>";
					$code .= "</tr>";
					$code .= "</table>";
					$code .= "</td>";
					$code .= "</tr>";
					$code .= "</table>";
					$code .= "</div>";
					$code        = str_replace("\"","'",$code);
					return $code;

			}
			
			/*-------------------------------------------------------------------------------------------
			Function to Display the TextAd with the selected colors in Rotator.  Used in get_trackingcode.php,
			and to display Text ad in Rotator(profile_view.php & profile_add.php)
			Created By	: 	SMA
			Created On 	: 	15-MAY-2006
			-------------------------------------------------------------------------------------------*/
			function showRotatorTextAd($id,$track_site_url,$width='500',$height='75',$col_boder='#3399FF',$col_back='#FFFFFF',$col_title='#000000',$col_url='#009900',$col_head='#FFFFFF',$col_desc='#7E7E7E')
			{
 					$con = $GLOBALS["con"];
					$code = "";
					$sql = "select * from partners_text where text_id='".$id."'";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0 )
					{
							$row = mysqli_fetch_object($res);
							$row_text         = $row->text_text;
							$row_no                = $row->text_rows;
							$url                = $row->text_url;
							$desc                = $row->text_description;

							# if the 1st part of the URL not contain http:/
							$url_test = substr($url, 0, 7);
							if($url_test!="http://")
							{
									$url   =    "http://".$url;
							}
							//getting only domain name from the url
							$url1	= explode("://",$url);
							$url2	= explode("/",$url1[1]);
							$disp_url	= "http://".$url2[0];
							
							$image 		= $row->text_image;  
						
					}
					
					$tableWidth = $width-2;
					$tableHeight = $height-2;
					$imgHeight = $height - 25;
					
					if(!empty($image)) {
						$img_colspan = " colspan=2 ";
						$imgcode = "<img src='$track_site_url/thumbnail.php?image=$image&height=$imgHeight' alt='0' border='0' />";
						
					} else {
						$img_colspan = "";
						$imgcode = "";
					}
					
					$code  = "<div style=\"width:$width; height:$height; overflow:hidden\" >";
					$code .= "<table align=\"center\" width=\"$tableWidth\" height=\"$tableHeight\" border=\"1\" style=\"border-color:$col_boder; \" cellpadding=\"0\" cellspacing=\"0\">";
					$code .= "<tr style=\"border:none;\" valign=\"top\">";
					$code .= "<td style=\"border:none;\" valign=\"top\" width=\"$tableWidth\" height=\"$tableHeight\">";
					$code .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"$tableWidth\" height=\"$tableHeight\">";
					$code .= "<tr bgcolor=\"$col_boder\">";
					$code .= "<td align=\"left\" height=\"10\" valign=\"top\" colspan=\"2\" ><font style=\"color:$col_head; font-family:verdana; font-size:10px;\"><b>SPONSORED LISTINGS</b></font></td>";
					$code .= "</tr>";
					$code .= "<tr bgcolor=\"$col_back\">";
					$code .= "<td align=\"left\"><a href='$url' target='_blank' ><font style=\"color:$col_title; font-family:verdana; font-size:10px;\"  >$row_text</font></a></td>";
					$code .= "<td align=\"right\" rowspan=\"3\" height=\"$imgHeight\" > $imgcode </td>";
					$code .= "</tr>";
					$code .= "<tr bgcolor=\"$col_back\">";
					$code .= "<td align=\"left\"><font style=\"color:$col_desc; font-family:verdana; font-size:10px;\" >$desc</font></td>";
					$code .= "</tr>";
					$code .= "<tr bgcolor=\"$col_back\">";
					$code .= "<td align=\"left\"><font style=\"color:$col_url; font-family:verdana; font-size:10px;\" >$disp_url</font></td>";
					$code .= "</tr>";
					$code .= "</table>";
					$code .= "</td>";
					$code .= "</tr>";
					$code .= "</table>";
					$code .= "</div>";
					$code        = str_replace("\"","'",$code);
					return $code;

			}
			
	}
//********* End Class Textdisplay *******************************

//********* Start Class Impression  *******************************
	class impression
	{
	 
        ##Function to insert impression transaction into transaction table and trans_rates table
        ##Modified on 28-Feb-06
        function update_imp_transaction($joinid,$approvalstatus,$today,$impression_rate,$linkid,$admin_amount,$referer,$ip,$name,$subid,$impr_ids="",$unit="")
        {
        		$con = $GLOBALS["con"];
                $sql        = "INSERT into partners_transaction SET
                transaction_joinpgmid                = '$joinid'        ,
                transaction_type                     = 'impression',
                transaction_status                   = '$approvalstatus',
                transaction_dateoftransaction        = '$today',
                transaction_amttobepaid              = '$impression_rate',
                transaction_linkid                   = '$linkid',
                transaction_admin_amount             = '$admin_amount',
                transaction_referer                  = '$referer',
                transaction_ip                       = '$ip',
                transaction_country                  = '$name',
                transaction_subid                    = '$subid' ";
                if(mysqli_query($con, $sql))
                {
						#get the transaction id for the new impresion transaction
                        $trans_id        = mysql_insert_id();

						#--insert into trans_rates table
                        $sql = "INSERT into partners_trans_rates SET
                                trans_id = '$trans_id', trans_rate = '$impression_rate', trans_unit = '$unit'";
                        mysqli_query($sql);
						
                        #--delete all impressions corresponding to the new transation fro the impression table
                        $impr_ids   = trim($impr_ids,",");

						# Update pending impression count into table partners_Impression_daily after recording a transaction
						$impr_arr  =  explode(",",$impr_ids);
						for($i=0; $i<count($impr_arr); $i++)
						{
								$sum_pending = 0;
								$sql_select = "SELECT imp_pending FROM partners_impression_daily WHERE imp_id='$impr_arr[$i]'";
								$res_select = mysqli_query($con, $sql_select);
								if($res_select)
								{
										$row_select = mysqli_fetch_object($res_select);
										$sum_pending += $row_select->imp_pending;

										if($sum_pending <= $unit)
										{
												$sql_update = "UPDATE partners_impression_daily SET ".
												" imp_pending = '0' WHERE  imp_id='$impr_arr[$i]'";
												$res_update = @mysqli_query($con, $sql_update);
										}
										else
										{
												$balance_impr = $sum_pending - $unit;
												$sql_update  = "UPDATE partners_impression_daily SET ".
												" imp_pending = '$balance_impr' WHERE  imp_id='$impr_arr[$i]'";
												$res_update = @mysqli_query($con, $sql_update);
												exit;
										}
								}
						}

                }
				return true;
        }
		//End Function
		
		
	 
	}
//********* End Class Impression  *******************************	


//********* Start Class Common  *******************************
	class common
	{
		/*----------------------------------------------------------------
		Description   :- function to validate mandatory fields in a form
		Programmer    :- SMA
		Last Modified :- 05/JUNE/2006
		-------------------------------------------------------------------*/
		function nullvalidation($validationstring)
		{
			//separate the fields from the string which contains all the fields separated by '~*'
			$fieldarray         = explode("~*",trim($validationstring));
			
			//validate each field for null values
			for($i=0;$i<count($fieldarray);$i++)
			{
			//return true if any field is empty
			if(empty($fieldarray[$i]) and ($fieldarray[$i]!="0"))  return true;
			}
			//return false if no null field
			return false;
		}
	
	}

//********* End Class Common  *******************************

//********* Start Class recur  *******************************
	class recur
	{

		/*-------------------------------------------------------------------------------------------
		Function to get all the recurring commissions for the mechant with selected status
		Created By	: 	SMA
		Created On 	: 	23-JUNE-2006
		-------------------------------------------------------------------------------------------*/
		function getRecurringCommissions($display,$mid)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_affiliate A, partners_transaction T, partners_recur R, partners_recurpayments P, partners_joinpgm J ".
			" WHERE T.transaction_recur ='1' AND T.transaction_joinpgmid = J.joinpgm_id AND ".
			" J.joinpgm_affiliateid = A.affiliate_id AND R.recur_transactionid = T.transaction_id AND ".
			" P.recurpayments_recurid = R.recur_id  AND P.recurpayments_status = '$display' AND R.recur_status='Active' ".
			" AND J.joinpgm_merchantid = '".$mid."' ";
			$res = mysqli_query($con, $sql);
			
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$this->payment_id[]		= $row->recurpayments_id;
					$this->aff_name[]		= $row->affiliate_firstname." ".$row->affiliate_lastname;
					$this->aff_id[]			= $row->affiliate_id;
					$this->recur_date[]		= $row->recurpayments_date;
					$this->recur_status[]	= $row->recurpayments_status;
					$this->recur_amount[]	= $row->recurpayments_amount;
					$this->trans_orderid[]	= $row->transaction_orderid;
				}
				return true;
			}
			else
				return false;
		}
		//End function
		
		/*-------------------------------------------------------------------------------------------
		Function to get the recurring Payment details of the selected record
		Created By	: 	SMA
		Created On 	: 	23-JUNE-2006
		-------------------------------------------------------------------------------------------*/
		function getRecurDetails($id,$mid)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_affiliate A, partners_transaction T, partners_recur R, partners_recurpayments P, ".
			" partners_joinpgm J, partners_track_revenue V ".
			" WHERE P.recurpayments_id = '$id' AND P.recurpayments_recurid = R.recur_id AND ".
			" R.recur_transactionid = T.transaction_id AND T.transaction_joinpgmid = J.joinpgm_id AND ".
			" V.revenue_transaction_id = T.transaction_id AND  J.joinpgm_affiliateid = A.affiliate_id AND ".
			"  T.transaction_recur ='1'  AND J.joinpgm_merchantid = '".$mid."' "; 
			$res = mysqli_query($con, $sql);
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_object($res);
					$this->payment_id		= $row->recurpayments_id;
					$this->aff_name 		= $row->affiliate_firstname." ".$row->affiliate_lastname;
					$this->aff_id			= $row->affiliate_id;
					$this->aff_company		= $row->affiliate_company;
					$this->aff_url			= $row->affiliate_url;
					$this->recur_date		= $row->recurpayments_date;
					$this->recur_status 	= $row->recurpayments_status;
					$this->recur_amount 	= $row->recurpayments_amount;
					$this->trans_orderid	= $row->transaction_orderid;
					$this->sale_amount		= $row->revenue_amount;
					$this->total_comm		= $row->recur_totalcommission;
					$this->recur_period		= $row->recur_period;
					$this->recur_subsale	= $row->recurpayments_subsaleamount;
					$this->total_subsale	= $row->recur_total_subsalecommission;

				return true;				
			}
			else
				return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to get all the Recuuring Transactions for the Merchant
		Created By	: 	SMA
		Created On 	: 	23-JUNE-2006
		-------------------------------------------------------------------------------------------*/
		function getRecurringTransactions($mid)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_affiliate A, partners_transaction T, partners_joinpgm J, partners_recur R ".
			" WHERE T.transaction_recur ='1' AND T.transaction_joinpgmid = J.joinpgm_id AND  R.recur_transactionid = T.transaction_id AND ".
			" J.joinpgm_affiliateid = A.affiliate_id AND J.joinpgm_merchantid = '".$mid."' ";
			$res = mysqli_query($con, $sql);
			
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$this->trans_id[]		= $row->transaction_id;
					$this->aff_name[]		= $row->affiliate_firstname." ".$row->affiliate_lastname;
					$this->aff_id[]			= $row->affiliate_id;
					$this->trans_date[]		= $row->transaction_dateoftransaction;
					$this->trans_status[]	= $row->transaction_status;
					$this->trans_amount[]	= $row->transaction_amttobepaid;
					$this->trans_orderid[]	= $row->transaction_orderid;
					$this->recur_status[] 	= $row->recur_status;
				}
				return true;
			}
			else
				return false;
		}
		//End Function
		
		
		/*-------------------------------------------------------------------------------------------
		Function to get the details of the selected recurring transaction
		Created By	: 	SMA
		Created On 	: 	24-JUNE-2006
		-------------------------------------------------------------------------------------------*/
		function getRecurTransDetails($id,$mid)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_affiliate A, partners_transaction T, partners_recur R, ".
			" partners_joinpgm J, partners_track_revenue V ".
			" WHERE T.transaction_id = '$id' AND ".
			" R.recur_transactionid = T.transaction_id AND T.transaction_joinpgmid = J.joinpgm_id AND ".
			" V.revenue_transaction_id = T.transaction_id AND  J.joinpgm_affiliateid = A.affiliate_id AND ".
			"  T.transaction_recur ='1'  AND J.joinpgm_merchantid = '".$mid."' "; 
			$res = mysqli_query($con, $sql);
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_object($res);
					$this->payment_id 		= $row->transaction_id;
					$this->aff_name 		= $row->affiliate_firstname." ".$row->affiliate_lastname;
					$this->aff_id			= $row->affiliate_id;
					$this->aff_company		= $row->affiliate_company;
					$this->aff_url			= $row->affiliate_url;
					$this->lastpaid_date	= $row->recur_lastpaid;
					$this->recur_period		= $row->recur_period;
					
					$sql_date = "SELECT date_format(DATE_ADD('".$row->recur_lastpaid."',INTERVAL ".$row->recur_period." MONTH),'%Y-%m-%d') d " ;
					$res_date = @mysqli_query($con, $sql_date);
					$row_date = mysqli_fetch_object($res_date);
					
					$this->recur_nextpay	= $row_date->d;
					
					$this->recur_status 	= $row->recur_status;
					$this->recur_balance 	= $row->recur_balanceamt;
					$this->trans_orderid	= $row->transaction_orderid;
					$this->sale_amount		= $row->revenue_amount;
					$this->total_comm		= $row->recur_totalcommission;
					$this->recur_period		= $row->recur_period;
					$this->trans_date		= $row->transaction_dateoftransaction;
					$this->recur_id			= $row->recur_id;
					$this->join_id			= $row->joinpgm_id;
					$this->recur_subsale	= $row->recur_total_subsalecommission;
					$this->recur_bal_subsale= $row->recur_balance_subsaleamt;
				return true;				
			}
			else
				return false;
		}
		//End Function
		

		/*-------------------------------------------------------------------------------------------
		Function to Pay the Recurring commission to the Affiliate and to the admin if the payment is 
		first installment of the recurring commission.  Called on the click of Approve this Commision link
		Created By	: 	SMA
		Created On 	: 	28-JUNE-2006
		-------------------------------------------------------------------------------------------*/
		function RecurCommissionPayment($recur_pay_id,$mid,$cut_off)
		{  
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_affiliate A, partners_transaction T, partners_recur R, partners_recurpayments P, ".
			" partners_joinpgm J ".
			" WHERE P.recurpayments_id = '$recur_pay_id' AND P.recurpayments_recurid = R.recur_id AND ".
			" R.recur_transactionid = T.transaction_id AND T.transaction_joinpgmid = J.joinpgm_id AND ".
			" J.joinpgm_affiliateid = A.affiliate_id AND ".
			"  T.transaction_recur ='1'  AND J.joinpgm_merchantid = '$mid' "; 
			$res = mysqli_query($con, $sql);
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_object($res);
					$transId				=  $row->transaction_id;
					$amount					= $row->recurpayments_amount;
					$aid					= $row->affiliate_id;
					$flag					= $row->transaction_flag;
					$parentid				= $row->transaction_parentid;
					$subsale				= $row->recurpayments_subsaleamount;
					$admin_sale_comm		= $row->transaction_admin_amount;
					$admin_paydate			= $row->transaction_adminpaydate;
					$today = date('Y-m-d');
					
					if($admin_paydate != "0000-00-00")
						$admin_sale_comm = 0;
					else
					{
						$admin_pay_sql = "UPDATE partners_transaction SET ".
						" transaction_adminpaydate = '$today' WHERE transaction_id = '$transId' ";
						$res_admin_pay = mysqli_query($con, $admin_pay_sql);
					}
			}
			
			$sql_mer        ="SELECT *  FROM `merchant_pay`  WHERE pay_merchantid='$mid' ";
			$res_mer        =mysqli_query($con, $sql_mer);

			$num	  = mysqli_num_rows($res_mer);
			if($num>0)
			{
				$row_mer   			=   mysqli_fetch_object($res_mer);
				$merchant_balance   = $row_mer->pay_amount;
				
			   	if(($merchant_balance - $amount - $admin_sale_comm )<=$cut_off)
				{  
						return false;
				}
				else
				{
					//---------------------------------------- Adding money to affiliate account  --------------------------//
					$merchant_balance = $merchant_balance - $amount - $admin_sale_comm;
					$sql_aff       ="SELECT *  FROM `affiliate_pay` where pay_affiliateid='$aid' ";
					$res_aff       =mysqli_query($con, $sql_aff);
					echo mysqli_error();

					 $num=mysqli_num_rows($res_aff);
					 if($num>0)
					 {
						$row_aff	=	mysqli_fetch_object($res_aff);
						$curamount	= $row_aff->pay_amount;
						$curamount	= $curamount + $amount;
						
						$sql2 ="update affiliate_pay set pay_amount='$curamount' where pay_affiliateid='$aid'";
						$ret2 =mysqli_query($con, $sql2);
					 }
					 else
					 {
						$sql2 ="INSERT INTO  affiliate_pay set pay_affiliateid='$aid' , pay_amount='$amount'";
						$ret2 =mysqli_query($con, $sql2);
					 }
					 //----------------------------------- affiliate account editing Ends here--------------------------//


					//---------------------------------- Subtract Money From Merchant Account ---------------------------//
					   $sql_mpay        = "UPDATE  `merchant_pay` SET  pay_amount='$merchant_balance'  WHERE pay_merchantid='$mid' ";
					   $res_mpay        = mysqli_query($con, $sql_mpay);
					   $_SESSION['MERCHANTBALANCE']= $merchant_balance;
					//--------------------------------- END OF  Subtract Money From Merchant Account ---------------------------//

					
					//--------------------------------- For Subsale from  Admins Account-----------------------------------------//
						$sql1		="SELECT *  FROM `admin_pay`  ";
						$res1		=mysqli_query($con, $sql1);
						echo mysqli_error();
						$num=mysqli_num_rows($res1);
						if($num>0)
						{
							$row1	=	mysqli_fetch_object($res1);
							$admin_curamount	= $row1->pay_amount;
							$admin_curamount	= ($admin_curamount + $admin_sale_comm) - $subsale;
						}
						
						$sql		="UPDATE `admin_pay` SET `pay_amount` = '$admin_curamount'";
						$res		=mysqli_query($con, $sql);
						if($flag==1)
						{
							$sql1       ="SELECT *  FROM `affiliate_pay` where pay_affiliateid='$parentid' ";
							$res1       =mysqli_query($sql1);
							echo mysqli_error();
						
							 $num=mysqli_num_rows($res1);
							 if($num>0)
							 {
									$row1	=	mysqli_fetch_object($res1);
									$curamount	= $row1->pay_amount;
									$curamount	= $curamount+$subsale;
									$sql2 ="update affiliate_pay set pay_amount='$curamount' where pay_affiliateid='$parentid'";
									$ret2 =mysqli_query($con, $sql2);
							 }
						}
			 
	 			//--------------------------------- END OF Adding to admin's account -------------------------------//
				 }
			 }
			return true;
		}
		//End Function
		
		/*-------------------------------------------------------------------------------------------
		Function to Update the recurring period of a particular Recurring transaction
		Created By	: 	SMA
		Created On 	: 	28-JUNE-2006
		-------------------------------------------------------------------------------------------*/
		function UpdateRecurPeriod($transid,$period)
		{
			$con = $GLOBALS["con"];
			$sql_trans = "SELECT * FROM partners_transaction T, partners_recur R ".
			" WHERE T.transaction_id = '$transid' AND R.recur_transactionid = T.transaction_id AND T.transaction_recur='1' ";
			$res_trans = mysqli_query($con,$sql_trans);
			if(mysqli_num_rows($res_trans) > 0)
			{
				$row_trans  = mysqli_fetch_object($res_trans);
				$recur_id	= $row_trans->recur_id;
				
				$sql_update = "UPDATE partners_recur SET recur_period ='$period' WHERE recur_id = '$recur_id' ";
				$res_update = mysqli_query($con,$sql_update);
				return true;
			}
			else
				return false;
		}
		
		function rejectRecurTransaction($recurId)
		{
			$con = $GLOBALS["con"];
			$sql_status = "UPDATE partners_recur SET recur_status='Rejected' WHERE recur_id='$recurId' ";
			$res_status	= mysqli_query($con,$sql_status);
			if($res_status) 
				return true;
			else 
				return false;
		}
		
	}
//********* End Class recur  *******************************

//********* Start of Class Graphs  *******************************

	class graphs
	{
		/*-------------------------------------------------------------------------------------------
		Function to get the names of all affiliates joined for the Merchant
		Created By	: 	SMA
		Created On 	: 	30-JUNE-2006
		-------------------------------------------------------------------------------------------*/
		function GetAffiliates($mid)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT DISTINCT affiliate_id,affiliate_company FROM partners_affiliate, partners_joinpgm ".
			" WHERE affiliate_id=joinpgm_affiliateid AND joinpgm_merchantid='$mid' AND joinpgm_status='approved' ";
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$this->aff_id[]		= $row->affiliate_id;
					$this->aff_comp[]	= $row->affiliate_company;
				}
				return true;
			}
			else
				return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to get the return day values for the respective period for the selected Affiliate
		Created By	: 	SMA
		Created On 	: 	1-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function FindReturnDays($aid="All",$mid)
		{	
			$con = $GLOBALS["con"];
				$total_sameday = $total_15Day = $total_1Month = $total_2Month = $total_After = 0;
	
				if($aid == "All")
				{
					$affiliate_sql = " ";
				}
				else
				{
					$affiliate_sql = " AND joinpgm_affiliateid='$aid' ";
				} 
				$sql = "SELECT DISTINCT transaction_linkid,transaction_joinpgmid  FROM partners_transaction, partners_joinpgm WHERE ".
				" joinpgm_merchantid='$mid' AND joinpgm_id=transaction_joinpgmid AND ".
				" transaction_type='click' ";  
				$sql .= $affiliate_sql;    
				
				$res = mysqli_query($con,$sql);
				if(mysqli_num_rows($res) > 0)
				{
					while($row = mysqli_fetch_object($res))
					{
						$clickdate = $saledate = "";
						$linkId = $row->transaction_linkid;
						$joinId = $row->transaction_joinpgmid;
						
						//Finds the first click date for the individual clicks from the link and joinpgm
						$sql_click = "SELECT DISTINCT  transaction_dateoftransaction FROM partners_transaction, partners_joinpgm ".
						" WHERE joinpgm_merchantid='$mid' AND joinpgm_id='$joinId' AND joinpgm_id=transaction_joinpgmid AND ".
						" transaction_linkid='$linkId' AND transaction_type = 'click' ".$affiliate_sql.
						" ORDER BY `transaction_dateoftransaction` ASC ";  
						$res_click = mysqli_query($con,$sql_click);
						if(mysqli_num_rows($res_click) > 0)
						{
							$row_click = mysqli_fetch_object($res_click);
							$clickdate = $row_click->transaction_dateoftransaction;
						}  
						
						//Finds the first sale date for the individual clicks from the link and joinpgm 
						$sql_sale = "SELECT DISTINCT  transaction_dateoftransaction FROM partners_transaction, partners_joinpgm ".
						" WHERE joinpgm_merchantid='$mid' AND joinpgm_id='$joinId' AND joinpgm_id=transaction_joinpgmid AND ".
						" transaction_linkid='$linkId' AND transaction_type = 'sale' ".$affiliate_sql.
						" ORDER BY `transaction_dateoftransaction` ASC ";  
						$res_sale = mysqli_query($con,$sql_sale);
						if(mysqli_num_rows($res_sale) > 0)
						{
							$row_sale = mysqli_fetch_object($res_sale);
							$saledate = $row_sale->transaction_dateoftransaction;
						} 
						 
						//if both sale and click exists
						if($clickdate && $saledate)
						{
							//If sale is on the same day as click
							if($clickdate == $saledate) {
								 $total_sameday 		+= 1;
							}
							else
							{
								$sql_date = "SELECT DATE_ADD( '$clickdate', INTERVAL 15 DAY ) AS halfmonth, ".
								" DATE_ADD('$clickdate', INTERVAL 1 MONTH ) AS OneM, ".
								" DATE_ADD('$clickdate', INTERVAL 2 MONTH ) AS TwoM "; 
								$res_date = mysqli_query($con,$sql_date);  
								if(mysqli_num_rows($res_date) > 0)
								{
									$row_date   = mysqli_fetch_object($res_date);
									$day15		= $row_date->halfmonth;
									$Month1		= $row_date->OneM;
									$Month2		= $row_date->TwoM;
								}
								
								//If Sale is within 15 days from click
								if($saledate < $day15)
									$total_15Day	+= 1;
								else if($saledate < $Month1)
									$total_1Month	+= 1;
								else if($saledate < $Month2)
									$total_2Month	+= 1;
								else if($saledate > $Month2)
									$total_After	+= 1;
							}
						}
					}  
				}
			$total = $total_sameday + $total_15Day + $total_1Month + $total_2Month + $total_After;
			if($total > 0)
			{
				$total_sameday 	= $total_sameday * 100 /$total;
				$total_15Day 	= $total_15Day * 100 /$total;
				$total_1Month	= $total_1Month * 100 /$total;
				$total_2Month 	= $total_2Month * 100 /$total;
				$total_After 	= $total_After * 100 /$total;
			}
			
			$this->total_sameday	= $total_sameday;
			$this->total_15Day		= $total_15Day;
			$this->total_1Month		= $total_1Month;
			$this->total_2Month		= $total_2Month;
			$this->total_After		= $total_After;
			$this->total			= $total;
			return;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to get all the Programs of the Merchant
		Created By	: 	SMA
		Created On 	: 	3-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function GetAllPrograms($mid)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT DISTINCT program_id, program_url FROM partners_program ".
			" WHERE program_merchantid='$mid' ";
			//"AND program_status='active' ";
			$res = mysqli_query($con,$sql);  
			
			if(mysqli_num_rows($res) > 0)
			{
				while($row=mysqli_fetch_object($res))
				{
					$this->pgmId[] 	= $row->program_id;
					$this->pgmName[]	= $row->program_url;
				}
				return true;
			}
			else
				return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to Find the number of clicks and sales made by the Affiliates of a Merchnat for a 
		selected Program or for all the programs
		Created By	: 	SMA
		Created On 	: 	28-JUNE-2006
		-------------------------------------------------------------------------------------------*/
		function FindAffiliateClickPercentage($mid,$pgmid,$from,$to)
		{
			$con = $GLOBALS["con"];
			$count = 0;
			$total = $total_sale = "0,";
			$sql = "SELECT DISTINCT affiliate_id, affiliate_company FROM partners_joinpgm, partners_affiliate WHERE ".
			"joinpgm_merchantid='$mid' AND joinpgm_affiliateid=affiliate_id ";
			if($pgmid != "All") $sql .= " AND  joinpgm_programid='$pgmid'  ";
			
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$count += 1;
					$aff_id		= $row->affiliate_id;
					$aff_name	= $row->affiliate_company;
					
					$sql_common	= " FROM partners_transaction, partners_joinpgm WHERE ".
					" transaction_joinpgmid=joinpgm_id AND ".
					" joinpgm_merchantid='$mid' AND joinpgm_affiliateid='$aff_id' ";
					if($pgmid != "All") $sql_common .= " AND  joinpgm_programid='$pgmid'  "; 
					if($from != "" && $to != "") $sql_common .= " AND transaction_dateoftransaction between '$from' and '$to' ";

					$sql_affiliate = "SELECT  count(transaction_id) as clicks ".$sql_common ." AND transaction_type='click' ";
					$res_affiliate = mysqli_query($con,$sql_affiliate);
					if(mysqli_num_rows($res_affiliate) > 0)
					{
						$row_affiliate = mysqli_fetch_object($res_affiliate);
						$this->affClick[]	= $row_affiliate->clicks;
						$total	.= $row_affiliate->clicks .",";
					}

					$sql_sale = "SELECT  count(transaction_id) as sales ".$sql_common." AND transaction_type='sale' ";
					$res_sale = mysqli_query($con,$sql_sale);
					if(mysqli_num_rows($res_sale) > 0)
					{
						$row_sale = mysqli_fetch_object($res_sale);
						$this->affSale[]	= $row_sale->sales;
						$total_sale	.= $row_sale->sales .",";
					}
					
					$this->affId[]		= $aff_id;
					$this->affCompany[]	= $aff_name;
				}
				$total = trim($total,",");
				if($total != "")
				{
					$sql_maxclick = "SELECT GREATEST(".$total.") AS maxclick";  
					$res_maxclick = mysqli_query($con,$sql_maxclick);
					$row_maxclick = mysqli_fetch_object($res_maxclick);
					$total	= $row_maxclick->maxclick;
				}				
				$total_sale = trim($total_sale,",");
				if($total_sale != "")
				{
					$sql_maxsale = "SELECT GREATEST(".$total_sale.") AS maxsale ";
					$res_maxsale = mysqli_query($con,$sql_maxsale);
					$row_maxsale = mysqli_fetch_object($res_maxsale);
					$total_sale = $row_maxsale->maxsale;
				}
				$this->rowcount		= $count;
				$this->total		= $total;  
				$this->total_sale	= $total_sale; 
			}
			
		}
		
		
		/*-------------------------------------------------------------------------------------------
		Function to Find the performance of the Affiliate Groups (top 10, 11-20, 21-50, 51-75 and above) 
		for clicks sales and commmission
		Created By	: 	SMA
		Created On 	: 	5-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function FindPerformanceAffiliateGroup($mid,$type)
		{
			$con = $GLOBALS["con"];
			$sql_common = "SELECT DISTINCT affiliate_id, affiliate_company FROM partners_joinpgm, partners_affiliate WHERE ".
			"joinpgm_merchantid='$mid' AND joinpgm_affiliateid=affiliate_id ";
			$res_common = mysqli_query($con,$sql_common);
			$totalcount = mysqli_num_rows($res_common); 
		
			//$limitArr = array(1,3,50,75,$totalcount);
			$limitArr = array(10,20,50,75,$totalcount);
			$start = $end = $total = 0;
			for($i=0; $i<count($limitArr); $i++)
			{
				$value = 0;
				$end = $limitArr[$i];
				$sql = $sql_common."  LIMIT ".$start.", ".$end;  
				
				$res = mysqli_query($con,$sql);
				if(mysqli_num_rows($res) > 0)
				{   
					while($row = mysqli_fetch_object($res))
					{
						$aff_id		= $row->affiliate_id;
						if($type != 'commission')
						{
							$sql_affiliate	= "SELECT  count(transaction_id) as CNT ";
						} else {
							$sql_affiliate	= "SELECT  sum(transaction_amttobepaid) as CNT ";
						}
						$sql_affiliate	.= " FROM partners_transaction, partners_joinpgm WHERE ".
						" transaction_joinpgmid=joinpgm_id AND ".
						" joinpgm_merchantid='$mid' AND joinpgm_affiliateid='$aff_id' ";
						if($type != 'commission')
						{
							$sql_affiliate	.= " AND transaction_type='".$type."' ";
						}  
						
						$res_affiliate = mysqli_query($con,$sql_affiliate);
						if(mysqli_num_rows($res_affiliate) > 0)
						{
							$row_affiliate = mysqli_fetch_object($res_affiliate);
							$value	= $value + $row_affiliate->CNT; 
						} 
					}
				}
				$start =  $end;
				$total = $total + $value;
				$this->groupCount[]	= $value;  
				if($start > $totalcount)
					break;
			} 
			$this->total = $total; 
		}


		/*-------------------------------------------------------------------------------------------
		Function to Find the clicks or sales made by the Affiliates of the merchnat and also to get the
		commission earned by them
		Created By	: 	SMA
		Created On 	: 	7-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function GetBubbleReport($mid,$pgmid,$from,$to,$type)
		{
			$con = $GLOBALS["con"];
			$count = 0;
			$total = $max_comm = "0,";
			$sql = "SELECT DISTINCT affiliate_id, affiliate_company FROM partners_joinpgm, partners_affiliate WHERE ".
			"joinpgm_merchantid='$mid' AND joinpgm_affiliateid=affiliate_id ";
			if($pgmid != "All") $sql .= " AND  joinpgm_programid='$pgmid'  ";
			
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$count += 1;
					$aff_id		= $row->affiliate_id;
					$aff_name	= $row->affiliate_company;
					
					$sql_common	= " FROM partners_transaction, partners_joinpgm WHERE ".
					" transaction_joinpgmid=joinpgm_id AND ".
					" joinpgm_merchantid='$mid' AND joinpgm_affiliateid='$aff_id' ";
					if($pgmid != "All") $sql_common .= " AND  joinpgm_programid='$pgmid'  "; 
					if($from != "" && $to != "") $sql_common .= " AND transaction_dateoftransaction between '$from' and '$to' ";

					$sql_affiliate = "SELECT  count(transaction_id) as clicks, sum(transaction_amttobepaid) as amount ".$sql_common ." AND transaction_type='$type' ";
					$res_affiliate = mysqli_query($con,$sql_affiliate);
					if(mysqli_num_rows($res_affiliate) > 0)
					{
						$row_affiliate = mysqli_fetch_object($res_affiliate);
						$this->affClick[]	= $row_affiliate->clicks;
						$this->affCommn[]	= $row_affiliate->amount;
						$total	.= $row_affiliate->clicks .",";
						if($row_affiliate->amount > 0)
							$max_comm .= $row_affiliate->amount .",";
						else
							$max_comm .= 0 .",";
					}
					$this->affId[]		= $aff_id;
					$this->affCompany[]	= $aff_name;
				}
				$total = trim($total,",");
				if($total != "")
				{
					$sql_maxclick = "SELECT GREATEST(".$total.") AS maxclick";   
					$res_maxclick = mysqli_query($con,$sql_maxclick);
					$row_maxclick = mysqli_fetch_object($res_maxclick);
					$total	= $row_maxclick->maxclick;
				}		
				$max_comm = trim($max_comm,",");  
				if($max_comm != "")
				{
					$sql_maxcomm = "SELECT GREATEST(".$max_comm.") AS maxcomm ";  
					$res_maxcomm = mysqli_query($con,$sql_maxcomm);
					$row_maxcomm = mysqli_fetch_object($res_maxcomm);
					$max_comm = $row_maxcomm->maxcomm;
				}
			
				$this->rowcount		= $count;
				$this->total		= $total;  
				$this->maxcomm		= $max_comm; 
			}
			
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to get all the Merchants
		Created By	: 	SMA
		Created On 	: 	8-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function GetAllMerchants()
		{  
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_merchant";
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$this->merId[]		= $row->merchant_id;
					$this->merCompany[]	= $row->merchant_company;
				}
				return true;
			}
			return false;
		}
		
		
		
	}
//********* End Class Graphs  *******************************


//********* Start Class AdminUser  *******************************
	class adminuser
	{
		/*-------------------------------------------------------------------------------------------
		Function to get all the Admin users except Super Admin
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function getAllAdminUsers()
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_adminusers WHERE adminusers_id != '1' ";
			$res = mysqli_query($con,$sql); 
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$this->userid[]		= $row->adminusers_id;
					$this->username[]	= $row->adminusers_login;
					$this->email[]		= $row->adminusers_email;
					$this->password[]	= $row->adminusers_password;
				}
				return true;
			}
			else
				return false;
		}
		
		
		/*-------------------------------------------------------------------------------------------
		Function to get all the Admin users except Super Admin
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function  AddAdminUser($username,$email,$password)
		{
			$con = $GLOBALS["con"];
			$sql = "INSERT INTO partners_adminusers SET ".
			" adminusers_login = '".addslashes($username)."', ".
			" adminusers_email = '".addslashes($email)."', ".
			" adminusers_password = '".addslashes($password)."' ";
			$res = mysqli_query($con,$sql);
			if($res) return true;
			else return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to check if the email id already exists
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function IsEmailexists($email,$id='')
		{
			$con = $GLOBALS["con"];
			if($id=='')
			{
				$sql = "SELECT * FROM partners_adminusers WHERE ".
				" adminusers_email = '". addslashes($email)."' ";
			} else {
				$sql = "SELECT * FROM partners_adminusers WHERE ".
					" adminusers_email = '". addslashes($email)."' AND adminusers_id != '$id' ";
			}  
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				return false;
			} else {
				return true;
			}
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to check if the user name already exists
		Created By	: 	SMA
		Created On 	: 	11-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function IsUserNameExists($user,$id='')
		{
			$con = $GLOBALS["con"];
			if($id=='')
			{
				$sql = "SELECT * FROM partners_adminusers WHERE ".
				" adminusers_login = '". addslashes($user)."' ";
			} else {
				$sql = "SELECT * FROM partners_adminusers WHERE ".
					" adminusers_login = '". addslashes($user)."' AND adminusers_id != '$id' ";
			}  
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				return false;
			} else {
				return true;
			}
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to update Admin user details
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function UpdateAdminUser($id, $username, $email,$password)
		{
			$con = $GLOBALS["con"];
			$sql = "UPDATE partners_adminusers SET ".
			" adminusers_email = '". addslashes($email)."', ".
			" adminusers_password = '".addslashes($password)."', ".
			" adminusers_login = '". addslashes($username)."' ".
			" WHERE adminusers_id = '". addslashes($id)."' ";
			$res = mysqli_query($con,$sql);
			
			if($res) 
				return true;
			else 
				return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to Delete Admin user details
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function DeleteAdminUser($id)
		{
			$con = $GLOBALS["con"];
			$sql = "DELETE FROM partners_adminusers  WHERE adminusers_id = '". addslashes($id)."' ";
			$res = mysqli_query($con,$sql);
			
			if($res) 
				return true;
			else 
				return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to Mailing get details of Super Admin
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function GetSuperAdmin()
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_admin";
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				$row 			= mysqli_fetch_object($res);
				$this->admin_email	= $row->admin_email;
				$this->admin_header	= $row->admin_mailheader;
				$this->admin_footer	= $row->admin_mailfooter;
				return true;
			}
			else
				return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to get the details of the selecte ADMIN User
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function GetAdimUserDetails($id)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_adminusers WHERE  adminusers_id = '". addslashes($id)."' ";
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_object($res);
				$this->username 	= $row->adminusers_login;
				$this->email		= $row->adminusers_email;
				$this->password		= $row->adminusers_password;
				return true;
			}
			else
				return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to get the links available for Admin and the previleges for the diffrerent ADMIN Users
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function GetAdminLiks($parent)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_adminlinks WHERE adminlinks_parentid = '".$parent."' "; 
			$res = mysqli_query($con,$sql);  
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$this->linkid[]		= $row->adminlinks_id;
					$this->linktitle[]	= $row->adminlinks_title;
					$this->linkparent[]	= $row->adminlinks_parentid;
					$this->linkusers[]	= $row->adminlinks_userid;
				}
				return true;
			}
			else
				return false;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to get the all the details of all the links for Admin Section
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function GetAllAdminLinks()
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_adminlinks ";
			$res = mysqli_query($con,$sql);  
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$this->linkid[]		= $row->adminlinks_id;
					$this->linktitle[]	= $row->adminlinks_title;
					$this->linkparent[]	= $row->adminlinks_parentid;
					$this->linkusers[]	= $row->adminlinks_userid;
				}
			}
			return;
		}
		
		
		/*-------------------------------------------------------------------------------------------
		Function to Update the User Privilege for a selected Link
		Created By	: 	SMA
		Created On 	: 	11-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function UpdateAdminUserLinks($linkid,$users)
		{
			$con = $GLOBALS["con"];
			$sql = "UPDATE partners_adminlinks SET adminlinks_userid='$users' WHERE adminlinks_id='$linkid' ";
			$res = mysqli_query($con,$sql);
			return;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to send mail to the Admin User on adding and updating details
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function SendMailtoAdminUser($to,$subject,$from,$adminheader,$username,$password,$adminfooter)
		{
				$headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
				$headers       .=  "From: $from\n";
				$body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
				$body.="<tr>";
				$body.="<td width='100%' align='center' valign='top'><br/>";
				$body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";
	
				$body.="<tr>";
				$body.="<td  width='100%' align='center'> $adminheader</td>";
				$body.="</tr>";
	
				$body.="<tr>";
				$body.="<td  width='100%' align='left'>&nbsp;</td>";
				$body.="</tr>";
				$body.="<tr>";
				$body.="<td width='100%' align='left'>"."Your Admin User name is = ".$username;
				$body.="</td></tr>";
				$body.="<tr>";
				$body.="<td width='100%' align='left'>"."Your Password Is = ".$password;
				$body.="</td></tr>";
				$body.="<tr>";
				$body.="<td  width='100%' align='left'>&nbsp;</td>";
				$body.="</tr>";
				$body.="<tr>";
				$body.="<td  width='100%' align='center'>$adminfooter</td>";
				$body.="</tr>";
	
				$body.="</table>";
				$body.="</td>";
				$body.="</tr>";
				$body.="</table>";
	
			   mail($to,$subject,$body,$headers);
		
		}
		
		
		/*-------------------------------------------------------------------------------------------
		Function to get the user details of the selected link
		Created By	: 	SMA
		Created On 	: 	10-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function GetAdminUserLink($linkName,$adminUserId,$parent)
		{
			$con = $GLOBALS["con"];
			if($adminUserId != '1')
			{
				$sql = "SELECT * FROM partners_adminlinks WHERE adminlinks_title = '".$linkName."' AND  adminlinks_parentid = '".$parent."' "; 
				$res = mysqli_query($con,$sql);  

				$row = mysqli_fetch_object($res);
					//$this->linkid		= $row->adminlinks_id;
					//$this->linktitle	= $row->adminlinks_title;
					//$this->linkparent	= $row->adminlinks_parentid;
				$linkusers	= $row->adminlinks_userid;
				$users		= explode(",",$linkusers);
				if(in_array($adminUserId,$users)) {
					return true;
				} else {
					return false;		
				}
			}
			else
			{
				return true;
			}
		}
		
	}

//********* End Class AdminUser  *******************************


//********* Start Class Report  *******************************
	class report
	{
		function FindMerchantName($id)
		{
			$con = $GLOBALS["con"];
			$merchantName = "";
			$sql_mer = "SELECT * FROM partners_merchant WHERE merchant_id='$id' ";
			$res_mer = mysqli_query($con,$sql_mer);
			if(mysqli_num_rows($res_mer) > 0)
			{
				$row_mer = mysqli_fetch_object($res_mer);
				$merchantName	= $row_mer->merchant_company;
			}	
			return  $merchantName;
		}
		
		function FindAffiliateName($id)
		{
			$con = $GLOBALS["con"];
			$affiliateName = "";
			$sql_aff = "SELECT * FROM partners_affiliate WHERE affiliate_id='$id' ";
			$res_aff = mysqli_query($con,$sql_aff);
			if(mysqli_num_rows($res_aff) > 0)
			{
				$row_aff = mysqli_fetch_object($res_aff);
				$affiliateName = $row_aff->affiliate_company;
			}
			return $affiliateName;
		}
		
		function FindProgramName($id)
		{
			$con = $GLOBALS["con"];
			$program = "";
			$sql = "SELECT * FROM partners_program WHERE program_id='$id' ";
			$res = mysqli_query($con,$sql);
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_object($res);
				$program = $row->program_url;
			}
			return $program;
		}
		
	}
	
//********* End Class Report  *******************************

//********* Start Class MerchantLink *******************************
	class merchantLink
	{
		/*-------------------------------------------------------------------------------------------
		Function to get the header and footer details of the merchant
		Created By	: 	SMA
		Created On 	: 	25-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function merchantSignUpLink($id)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_merchant WHERE merchant_id='$id'";
			$res = mysqli_query($con,$sql);
			
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_object($res);
				$this->mer_header = $row->merchant_headercode;
				$this->mer_footer = $row->merchant_footercode;
			}
			return;
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to update the header and footer details of the merchant
		Created By	: 	SMA
		Created On 	: 	25-JULY-2006
		-------------------------------------------------------------------------------------------*/
		function UpdateLinks($id,$header,$footer)
		{
			$con = $GLOBALS["con"];
			$sql = "UPDATE partners_merchant SET ".
			" merchant_headercode  = '". addslashes($header)."' , ".
			" merchant_footercode  = '". addslashes($footer)."'  ".
			" WHERE merchant_id = '$id' ";  
			$res = mysqli_query($con,$sql);
			if($res)  
				return true;
			else   
				return false;
		}
	}

//********* End Class Report  *******************************


//********* Start Class Currency  *******************************
	class currency
	{
		/*-------------------------------------------------------------------------------------------
		Function to find if the Currency details already exists
		Created By	: 	SMA
		Created On 	: 	4-AUG-2006
		-------------------------------------------------------------------------------------------*/
		function ifCurrencyDetailsExists($type,$value)	
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_currency WHERE currency_".$type." ='$value' ";
			$res = mysqli_query($con,$sql);
			
			if(mysqli_num_rows($res) > 0)
			{  	
				return false;
			}  else {
				return true;
			}
		}
		
		
		/*-------------------------------------------------------------------------------------------
		Function to Add New Currency details
		Created By	: 	SMA
		Created On 	: 	4-AUG-2006
		-------------------------------------------------------------------------------------------*/
		function insertCurrency($caption, $code, $symbol, $relation)
		{
			$con = $GLOBALS["con"];
			$sql = "INSERT INTO partners_currency SET ".
			" currency_caption = '". addslashes($caption)."' , ".
			" currency_code = '". addslashes($code)."' , ".
			" currency_symbol = '". addslashes($symbol)."'  ";
			$res = mysqli_query($con,$sql);
			if($res)  
			{
				$today = date('Y-m-d');
				$sql_rel = "INSERT INTO partners_currency_relation SET ".
				" relation_currency_code = '". addslashes($code)."' , ".
				" relation_value = '".$relation."' , ".
				" relation_date = '".$today."' ";
				$res_rel = mysqli_query($con,$sql_rel);
				if($res_rel)
					return true;
				else
					return false;
			}
			else
				return false;
		}
		
		
		/*-------------------------------------------------------------------------------------------
		Function to Change the values of Amounts in the tables on the chage of the Base Currency
		Created By	: 	SMA
		Created On 	: 	7-AUG-2006
		-------------------------------------------------------------------------------------------*/
		function ConvertToNewBaseCurrency($newCode)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_currency, partners_currency_relation WHERE currency_code ='$newCode' ".
			" AND currency_code = relation_currency_code  ORDER BY relation_date DESC ";  
			$ret  = @mysqli_query($con,$sql); //die("sql = ".$sql);
			
			if(@mysqli_num_rows($ret)>0)
			{
				$row = @mysqli_fetch_object($ret);
				# gets currency relation
				$currRelation = $row->relation_value;
			}
			
			//Admin_pay
			$sql_admin = "Update admin_pay SET pay_amount = pay_amount * $currRelation ";  //die("sql = ".$sql_admin);
			$res_admin = mysqli_query($con,$sql_admin);
			
			//affiliate_pay
			$sql_aff_pay  = "UPDATE affiliate_pay SET pay_amount = pay_amount * $currRelation "; 
			$res_aff_pay  = mysqli_query($con,$sql_aff_pay);
			
			//merchant_pay
			$qry = "UPDATE merchant_pay SET pay_amount  = pay_amount * $currRelation "; 
			$res = mysqli_query($con,$qry);
			
			//partners_addmoney
			$qry = "Update partners_addmoney SET addmoney_amount  = addmoney_amount * $currRelation "; 
			$res = mysqli_query($con,$qry);
			
			//partners_adjustment
			$qry = "Update partners_adjustment SET adjust_amount = addmoney_amount * $currRelation "; 
			$res = mysqli_query($con,$qry);
			
			//partners_fee
			$qry = "Update partners_fee SET adjust_amount = adjust_amount  * $currRelation "; 
			$res = mysqli_query($con,$qry);
			
			$sql_pgm = "UPDATE partners_program SET program_impressionrate=program_impressionrate*$currRelation , 
				program_clickrate=program_clickrate*$currRelation ";
			$res_pgm = mysqli_query($con,$sql_pgm);
			
			$sql_comm = "UPDATE partners_pgm_commission SET commission_leadrate=commission_leadrate*$currRelation "; 
			$res_comm = mysqli_query($con,$sql_comm); 
			$sql_comm2 = "UPDATE partners_pgm_commission SET commission_salerate=commission_salerate*$currRelation  
				WHERE commission_saletype != '%' "; 
			$res_comm2 = mysqli_query($con,$sql_comm2);
			
			//partners_group
			$qry = "Update partners_group SET group_clickrate = group_clickrate * $currRelation , ".
			" group_leadrate = group_leadrate *  $currRelation ";
			$res = mysqli_query($con,$qry);
			
			//	partners_invoice
			$qry = "UPDATE partners_invoice SET invoice_amount = invoice_amount *  $currRelation ";
			$res = mysqli_query($con,$qry);
			
			//partners_ipblocking
			$qry = "UPDATE partners_ipblocking SET ipblocking_click = ipblocking_click  * $currRelation , ".
			" ipblocking_lead = ipblocking_lead   * $currRelation ";
			$res = mysqli_query($con,$qry);
			
			$qry = "UPDATE partners_ipblocking SET ipblocking_sale = ipblocking_sale * $currRelation ".
			" WHERE ipblocking_saletype != '%' ";
			$res = mysqli_query($con,$qry);
			
			
			//	partners_payment
			$qry = "UPDATE partners_payment SET pay_amount = pay_amount *  $currRelation ";
			$res = mysqli_query($con,$qry);
			
			//partners_recur
			$qry = "UPDATE partners_recur SET recur_totalcommission = recur_totalcommission *  $currRelation , ".
			" recur_balanceamt = recur_balanceamt *  $currRelation , ".
			" recur_total_subsalecommission = recur_total_subsalecommission *  $currRelation , ".
			" recur_balance_subsaleamt = recur_balance_subsaleamt *   $currRelation ";
			$res = mysqli_query($con,$qry);
			
			//partners_recurpayments
			$qry = "UPDATE partners_recurpayments SET recurpayments_amount = recurpayments_amount *  $currRelation , ".
			" recurpayments_subsaleamount = recurpayments_subsaleamount *  $currRelation ";
			$res = mysqli_query($con,$qry);
			
			//partners_request
			$qry = "UPDATE partners_request SET request_amount = request_amount  *  $currRelation ";
			$res = mysqli_query($con,$qry);
			
			//partners_track_revenue
			$qry = "UPDATE partners_track_revenue SET revenue_amount =revenue_amount   *  $currRelation ";
			$res = mysqli_query($con,$qry);
			
			//partners_transaction
			$qry = "UPDATE partners_transaction SET transaction_amttobepaid = transaction_amttobepaid  *  $currRelation , ".
			" transaction_amountpaid = transaction_amountpaid  *  $currRelation , ".
			" transaction_subsale = transaction_subsale *  $currRelation , ".
			" transaction_reverseamount = transaction_reverseamount *  $currRelation , ".
			" transaction_adminpaid = transaction_adminpaid *  $currRelation , ".
			" transaction_subsalepaid = transaction_subsalepaid *  $currRelation  ";
			$res = mysqli_query($con,$qry);
			
		}
		
		/*-------------------------------------------------------------------------------------------
		Function to find the currency details of currrencies other tahn present Base Currency
		Created By	: 	SMA
		Created On 	: 	8-AUG-2006
		-------------------------------------------------------------------------------------------*/
		function GetAllCurrencies($base)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_currency WHERE currency_code != '$base' ";
			$res = mysqli_query($con,$sql);
			
			if(mysqli_num_rows($res) > 0)
			{
				while($row = mysqli_fetch_object($res))
				{
					$this->curCode[]   	= $row->currency_code;
					$this->curCaption[]	= $row->currency_caption;
				}
				return true;
			}
			else
				return false;
		}
	
		/*-------------------------------------------------------------------------------------------
		Function to get the present rate of a currency with respect to the Base currency
		Created By	: 	SMA
		Created On 	: 	8-AUG-2006
		-------------------------------------------------------------------------------------------*/
		function FindCurrentRate($currency)
		{
			$con = $GLOBALS["con"];
			$sql = "SELECT * FROM partners_currency_relation ".
			" WHERE relation_currency_code = '$currency' ORDER BY relation_date DESC ";
			$res = mysqli_query($con,$sql);
			
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_object($res);
				$this->rate = $row->relation_value;
			}
			else
				$this->rate = 0;
			return;
		}
		
	}

//********* End Class Currency  *******************************
?>