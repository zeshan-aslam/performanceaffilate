<?php
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  csv_link.php     		            	        */
/*     CREATED ON     :  18/JULY/2006                                   */

/*		Exporting Link Report of Mer, Aff, Admin to CSV Format			*/
/************************************************************************/
include_once 'includes/db-connect.php';
  include 'includes/session.php';
  include 'includes/constants.php';
  include 'includes/functions.php';
  include 'includes/allstripslashes.php';
  include 'includes/function1.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	include_once 'language_include.php';

	$reportobj	= new report();

	$mode		= $_REQUEST['mode'];
	$date		= $_REQUEST['date'];
	$merchant	= $_REQUEST['mid'];
	$affiliate	= $_REQUEST['aid'];
	$From		= $_REQUEST['from'];
	$To			= $_REQUEST['to'];
	$program	= $_REQUEST['program'];
	$currValue	= $_REQUEST['currValue'];
	$currsymbol	= $_REQUEST['currsymbol'];

	if($currsymbol == '') $currsymbol = html_entity_decode($_SESSION['DEFAULTCURRENCYSYMBOL']);

	if($currValue == '') $currValue = $default_currency_caption;

	if($merchant == 'All' || empty($merchant)) $merchantName = $lang_report_allmerchant;
	else {
		$merchantName	= $reportobj->FindMerchantName($merchant);
	}

	if($program == 'All' || $program == 'AllPgms') $programName = $lang_report_AllProgram;
	else {
		$programName = $reportobj->FindProgramName($program);
	}

	$affiliateName = $reportobj->FindAffiliateName($affiliate);

	//Getting values to export as csv
	$csv_trans = $lang_report_stat." ".$date."\r\n";
	if($mode == 'admin' || $mode == 'merchant') {
		$csv_trans .= $lang_report_merchant." : ".$merchantName."\r\n";
	}
	if($mode == 'affiliate') {
		$csv_trans .= $lang_report_affiliate." : ".$affiliateName."\r\n";
	}
	$csv_trans .= $lang_pgm." : ".$programName."\r\n";

	//Column Headings
	$csv_trans .= $lang_report_linkname.",".$lang_impression.","." ".",".$lang_click.","." ".",".$lang_lead.","." ".",".$lang_sale."\r\n";
	$csv_trans .= " ".",".$lang_report_count.",".$lang_report_commission.",".$lang_report_count.",".$lang_report_commission.",".$lang_report_count.",".$lang_report_commission.",".$lang_report_count.",".$lang_report_commission."\r\n";


	if($mode == 'merchant')
	{
		switch($program)
		{
			 case 'All':
				$sql       ="SELECT * from partners_program  where program_merchantid='$merchant'    ";
				break;
			 default:
				 $sql      ="SELECT * from partners_program where program_id='$program' ";
				 break;
		}
		$subquery = " AND joinpgm_merchantid='$merchant' AND transaction_joinpgmid=joinpgm_id ";
		$subquery2 = " AND imp_merchantid='$merchant' ";
	}
	else if($mode == 'affiliate')
	{
		switch($program)
		{
			case 'All':
				$sql       ="SELECT * from partners_joinpgm,partners_program  where joinpgm_affiliateid='$affiliate' and joinpgm_status not like('waiting')  and joinpgm_programid=program_id   ";
				break;
			default:
				 $sql      ="SELECT * from partners_program where program_id='$program' ";
				 break;
		}
		$subquery = " AND joinpgm_affiliateid='$affiliate' AND transaction_joinpgmid=joinpgm_id ";
		$subquery2 = " AND imp_affiliateid='$affiliate' ";
	}
	else if($mode == 'admin')
	{
		switch($program)
		{
			  case 'AllPgms':
				$sql = "SELECT * from partners_program     ";
				break;

			 case 'All':
				$sql = "SELECT * from partners_program  where program_merchantid='$merchant'    ";
				break;

			 default:
				$sql = "SELECT * from partners_program where program_id='$program' ";
				break;
		}
		if($merchant) {
			$subquery = " AND joinpgm_merchantid='$merchant' AND transaction_joinpgmid=joinpgm_id ";
			$subquery2 = " AND imp_merchantid='$merchant' ";
		} else {
			$subquery = "  AND transaction_joinpgmid=joinpgm_id ";
			$subquery2 = " ";
		}
	}

	$res = mysqli_query($con,$sql);
	if(mysqli_num_rows($res) > 0)
	{
		while($row = mysqli_fetch_object($res))
		{
			$pgmid      = $row->program_id;
			$pgmName 	= $row->program_url;

			$sql_banner = "select * from partners_banner where banner_programid='$pgmid'";
			$res_banner = mysqli_query($con,$sql_banner);
			//for all banners
			while($row_banner = mysqli_fetch_object($res_banner))
			{
				$total  = get($To,$From,B.$row_banner->banner_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);

				$csv_trans .= $pgmName."-B".$row_banner->banner_id.",".$total[13].",".$currsymbol.$total[12].",".$total[1].",".$currsymbol.$total[0].",".$total[3].",".$currsymbol.$total[2].",".$total[5].",".$currsymbol.$total[4]."\r\n";

			}

			$sql_text = "select * from partners_text where text_programid='$pgmid'";
			$res_text = mysqli_query($con,$sql_text);
			//for all text
			while($row_text = mysqli_fetch_object($res_text))
			{
				$total = get($To,$From,T.$row_text->text_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);

				$csv_trans .= $pgmName."-T".$row_text->text_id.",".$total[13].",".$currsymbol.$total[12].",".$total[1].",".$currsymbol.$total[0].",".$total[3].",".$currsymbol.$total[2].",".$total[5].",".$currsymbol.$total[4]."\r\n";
			}

			$sql_popup = "select * from partners_popup where popup_programid='$pgmid'";
			$res_popup = mysqli_query($con,$sql_popup);
			//for all popup
			while($row_popup = mysqli_fetch_object($res_popup))
			{
				$total = get($To,$From,P.$row_popup->popup_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);

				$csv_trans .= $pgmName."-P".$row_popup->popup_id.",".$total[13].",".$currsymbol.$total[12].",".$total[1].",".$currsymbol.$total[0].",".$total[3].",".$currsymbol.$total[2].",".$total[5].",".$currsymbol.$total[4]."\r\n";
			}

			$sql_flash = "select * from partners_flash where flash_programid='$pgmid'";
			$res_flash = mysqli_query($con,$sql_flash);
			//for all flash
			while($row_flash = mysqli_fetch_object($res_flash))
			{
				$total         =get($To,$From,F.$row_flash->flash_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);

				$csv_trans .= $pgmName."-F".$row_flash->flash_id.",".$total[13].",".$currsymbol.$total[12].",".$total[1].",".$currsymbol.$total[0].",".$total[3].",".$currsymbol.$total[2].",".$total[5].",".$currsymbol.$total[4]."\r\n";
			}

			$sql_html = "select * from partners_html where html_programid='$pgmid'";
			$res_html = mysqli_query($con,$sql_html);
			//for all html
			while($row_html = mysqli_fetch_object($res_html))
			{
				$total         =get($To,$From,H.$row_html->html_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);

				$csv_trans .= $pgmName."-H".$row_html->html_id.",".$total[13].",".$currsymbol.$total[12].",".$total[1].",".$currsymbol.$total[0].",".$total[3].",".$currsymbol.$total[2].",".$total[5].",".$currsymbol.$total[4]."\r\n";
			}

		}
	}

//Creating file
	if($mode == 'admin')
		$fileName =$_SESSION['ADMINUSERID']."_admin_link.csv";
	else if($mode == 'merchant')
		$fileName = $_SESSION['MERCHANTID']."_merchant_link.csv";
	else if($mode == 'affiliate')
		$fileName = $_SESSION['AFFILIATEID']."_affiliate_link.csv";


	$fp = fopen( "reports/".$fileName,"w");
	fwrite($fp,$csv_trans);
	fclose($fp);

//Download file
	$newFile	= 	$fileName;
	$path		=	"reports/".$newFile;
/*
	header('Content-Type: application/force-download; filename="'.$newFile.'"');
	header('Content-Disposition: attachment; filename="'.$newFile.'"');
	readfile($path);

	unlink($path);
	exit;
*/

	header("Pragma: public");
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-Type: application/force-download");
	header('Content-Disposition: attachment; filename="'.$newFile.'"');
	header("Content-Transfer-Encoding: binary");
	header('Content-Length: '.@filesize($path));
	set_time_limit(0);
	@readfile($path) OR die("file not found");

	unlink($path);

	exit;




   /******************getting statistics for particular linkid******************/
  function get($To,$From,$linkid,$currValue,$subquery,$subquery2,$mode,$default_currency_caption)
  {
  		if($currValue == '') $currValue =  $default_currency_caption;

    //initiating
    $click                 =0;
    $lead                  =0;
    $sale                  =0;
    $nclick                =0;
    $nlead                 =0;
    $nsale                 =0;
    $pendingamnt           =0;
    $approvedamnt          =0;
    $paidamnt              =0;
    $rejectedamnt          =0;
    $impression               =0;
    $impression_counts        =0;



            $sql        = "SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_linkid='$linkid'";
			//$sql        = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_linkid='$linkid'";
			$sql .= $subquery;
            $result     = mysqli_query($con,$sql); //echo "click qry = ".$sql;
            $nclick     = mysqli_num_rows($result)+$nclick;

            while($row=mysqli_fetch_object($result))
            {
                 # get transaction details
                   $date         =   $row->transaction_dateoftransaction;
                   $affAmnt      =   $row->transaction_amttobepaid;
                   $adminAmnt    =   $row->transaction_admin_amount;

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
				if($mode != 'affiliate') {
	                $click    = $affAmnt + $adminAmnt + $click; //total click amnt
				} else {
					$click    = $affAmnt + $click; //total click amnt
				}
            }


            $sql      = "SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_type='lead' and transaction_linkid='$linkid'";
			//$sql        = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_linkid='$linkid'";
			$sql .= $subquery;
            $result   = mysqli_query($con,$sql);
            $nlead    = mysqli_num_rows($result)+$nlead;  //no of lead

            while($row=mysqli_fetch_object($result))
            {
               $date         =   $row->transaction_dateoftransaction;
                   $affAmnt      =   $row->transaction_amttobepaid;
                   $adminAmnt    =   $row->transaction_admin_amount;

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
				if($mode != 'affiliate') {
	                $lead           = $affAmnt + $adminAmnt + $lead;// total lead amnt
				} else {
					$lead           = $affAmnt + $lead;// total lead amnt
				}
            }  //end while


            $sql        =        "SELECT *  from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_type='sale' and transaction_linkid='$linkid'";
			//$sql        =        "SELECT *  from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='sale' and transaction_linkid='$linkid'";
			$sql .= $subquery;
            $result =        mysqli_query($con,$sql);
            $nsale  =        mysqli_num_rows($result)+$nsale; //no of sale

            while($row=mysqli_fetch_object($result))
            {
               $date         =   $row->transaction_dateoftransaction;
                   $adminAmnt    =   $row->transaction_admin_amount;
			//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
					 $transactionId	= $row->transaction_id;
					 $recur 	 = 	$row->transaction_recur;

					  // If the sale commission is of recurring type
					 if($recur == '1')
					 {
						$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
						$res_Recur	= mysqli_query($con,$sql_Recur);
						if(mysqli_num_rows($res_Recur) > 0)
						{
							$row_recur	= mysqli_fetch_object($res_Recur);
							$recurId	= $row_recur->recur_id;

							$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
							$res_recurpay	= mysqli_query($con,$sql_recurpay);
							if(mysqli_num_rows($res_recurpay) > 0)
							{
								$row_recurpay 	= mysqli_fetch_object($res_recurpay);
								$affAmnt 	 =  $row_recurpay->recurpayments_amount;
							}
						}
					 }
					 else
					 {
			// END Modified on 23-JUNE-06
						   $affAmnt      =   $row->transaction_amttobepaid;
					 }

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
                if($mode != 'affiliate') {
					$sale          =$affAmnt + $adminAmnt +$sale;//total sale amnt
				} else {
					$sale          =$affAmnt + $sale;//total sale amnt
				}
            }

			

            $sql      = "SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_status='approved' and transaction_linkid='$linkid'";
			//$sql       = "SELECT *  from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_flag=1 and transaction_linkid='$linkid'";
			$sql .= $subquery;
            $result4  = mysqli_query($con,$sql);

             while($row1=mysqli_fetch_object($result4))
             {

               $date         =   $row1->transaction_dateoftransaction;
                   $adminAmnt    =   $row1->transaction_admin_amount;
			//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
					 $transactionId	= $row1->transaction_id;
					 $recur 	 = 	$row1->transaction_recur;

					  // If the sale commission is of recurring type
					 if($recur == '1')
					 {
						$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
						$res_Recur	= mysqli_query($con,$sql_Recur);
						if(mysqli_num_rows($res_Recur) > 0)
						{
							$row_recur	= mysqli_fetch_object($res_Recur);
							$recurId	= $row_recur->recur_id;

							$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
							$res_recurpay	= mysqli_query($con,$sql_recurpay);
							if(mysqli_num_rows($res_recurpay) > 0)
							{
								$row_recurpay 	= mysqli_fetch_object($res_recurpay);
								$affAmnt 	 =  $row_recurpay->recurpayments_amount;
							}
						}
					 }
					 else
					 {
			// END Modified on 23-JUNE-06
	                   $affAmnt      =   $row1->transaction_amttobepaid;
					 }

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
                if($mode != 'affiliate') {
					$approvedamnt=$affAmnt + $adminAmnt + $approvedamnt;// total approved amnt
				} else {
					$approvedamnt=$affAmnt + $approvedamnt;// total approved amnt
				}
             }


            $sql       = "SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To'and transaction_linkid='$linkid'";
			//$sql       = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To'and transaction_linkid='$linkid'";
			$sql .= $subquery;
            $result4   = mysqli_query($con,$sql);
            while($row1=mysqli_fetch_object($result4))
            {
               $date         =   $row1->transaction_dateoftransaction;
                   $adminAmnt    =   $row1->transaction_admin_amount;
		//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
				 $transactionId	= $row1->transaction_id;
				 $recur 	 = 	$row1->transaction_recur;

				  // If the sale commission is of recurring type
				 if($recur == '1')
				 {
					$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
					$res_Recur	= mysqli_query($con,$sql_Recur);
					if(mysqli_num_rows($res_Recur) > 0)
					{
						$row_recur	= mysqli_fetch_object($res_Recur);
						$recurId	= $row_recur->recur_id;

						$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
						$res_recurpay	= mysqli_query($con,$sql_recurpay);
						if(mysqli_num_rows($res_recurpay) > 0)
						{
							$row_recurpay 	= mysqli_fetch_object($res_recurpay);
							$affAmnt 	 =  $row_recurpay->recurpayments_amount;
						}
					}
				 }
				 else
				 {
		// END Modified on 23-JUNE-06
	                   $affAmnt      =   $row1->transaction_amttobepaid;
				 }

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
               if($mode != 'affiliate') {
			   		$paidamnt   = $affAmnt + $adminAmnt +$paidamnt;//total sale amnt
				} else {
					$paidamnt   = $affAmnt + $paidamnt;//total sale amnt
				}
             }  //end  while


            $sql            ="SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_status='reversed' and transaction_linkid='$linkid'";
			//$sql            ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='reversed' and transaction_linkid='$linkid'";
			$sql .= $subquery;
            $result4        =mysqli_query($con,$sql);
            while($row1=mysqli_fetch_object($result4))
            {
               $date         =   $row1->transaction_dateoftransaction;
                   $affAmnt      =   $row1->transaction_admin_amount;


                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);

                   }
                $rejectedamnt=$affAmnt + $rejectedamnt;// total approved amnt
             }  //end while

			//Calculate reversed commissions fro Recurring sales
			$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments,partners_joinpgm WHERE ".
			" transaction_linkid='$linkid' AND recur_transactionid=transaction_id AND ".
			" transaction_dateoftransaction between '$From' and '$To' AND ".
			" recurpayments_recurid=recur_id  AND recurpayments_status='reversed' ";
			/*$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE ".
			" transaction_linkid='$linkid' AND recur_transactionid=transaction_id AND ".
			" transaction_dateoftransaction between '$From' and '$To' AND ".
			" recurpayments_recurid=recur_id  AND recurpayments_status='reversed' ";	*/
			$sql_rev .= $subquery;
			$res_rev = mysqli_query($con,$sql_rev);
			if(mysqli_num_rows($res_rev) > 0)
			{
				while($row_rev = mysqli_fetch_object($res_rev))
				{
					 # get transaction details
					 $date		 =   $row_rev->transaction_dateoftransaction;
					 $affAmt	= $row_rev->recurpayments_amount;
					 # converting to user currency
					 if($currValue != $default_currency_caption){
							$affAmt 	 =   getCurrencyValue($date, $currValue, $affAmt);
					 }

					$rejectedamnt = $affAmt + $rejectedamnt;
				}
			}
			//End Reverse Calculation


           $sql            ="SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_linkid='$linkid'";
		   //$sql            ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_linkid='$linkid'";
		   $sql .= $subquery;
           $result4        =mysqli_query($con,$sql);
           while($row1=mysqli_fetch_object($result4))
           {
               $date         =   $row1->transaction_dateoftransaction;
                   $adminAmnt    =   $row1->transaction_admin_amount;
			//Modified on 23-JUNE-06 for Recurring Sale Commission by SMA
					 $transactionId	= $row1->transaction_id;
					 $recur 	 = 	$row1->transaction_recur;

					  // If the sale commission is of recurring type
					 if($recur == '1')
					 {
						$sql_Recur 	= "SELECT * FROM partners_recur WHERE recur_transactionid = '$transactionId' ";
						$res_Recur	= mysqli_query($con,$sql_Recur);
						if(mysqli_num_rows($res_Recur) > 0)
						{
							$row_recur	= mysqli_fetch_object($res_Recur);
							$recurId	= $row_recur->recur_id;

							$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
							$res_recurpay	= mysqli_query($con,$sql_recurpay);
							if(mysqli_num_rows($res_recurpay) > 0)
							{
								$row_recurpay 	= mysqli_fetch_object($res_recurpay);
								$affAmnt 	 =  $row_recurpay->recurpayments_amount;
							}
						}
					 }
					 else
					 {
			// END Modified on 23-JUNE-06
						   $affAmnt      =   $row1->transaction_amttobepaid;
					 }

                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
               if($mode != 'affiliate') {
			   		$pendingamnt=$affAmnt + $adminAmnt +$pendingamnt;// total approved amnt
				} else {
					$pendingamnt=$affAmnt + $pendingamnt;// total approved amnt
				}
           }  //end while


            $sql        = "SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_type='impression' and transaction_linkid='$linkid'";
			//$sql        = "SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='impression' and transaction_linkid='$linkid'";
			$sql .= $subquery;
            $result     = mysqli_query($con,$sql);


            while($row=mysqli_fetch_object($result))
            {
                 # get transaction details
                   $date         =   $row->transaction_dateoftransaction;
                   $affAmnt      =   $row->transaction_amttobepaid;
                   $adminAmnt    =   $row->transaction_admin_amount;
                   $trans_id     =   $row->transaction_id;
                   #get the impressioncount(unit) from trans_rates table
              	   $sql_rate     = "SELECT trans_unit FROM partners_trans_rates WHERE trans_id ='$trans_id'";
	               $res_rate     = mysqli_query($con,$sql_rate);

	               if(mysqli_num_rows($res_rate) >0)
	               {
	                    while($row  = mysqli_fetch_object($res_rate))
	                    {
	                       $impression_counts  += $row->{trans_unit};
	                    }
	               }
                   # converting to user currency
                   if($currValue != $default_currency_caption){
                        $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                        $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                   }
                if($mode != 'affiliate') {
					$impression    = $affAmnt + $adminAmnt + $impression; //total click amnt
				} else {
					$impression    = $affAmnt + $impression; //total click amnt
				}
            }

			# calculate impressions
		   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_linkid= '$linkid'";
		   $impSql .= " And imp_date between '$From' AND '$To' ";
		   $impSql .= $subquery2;

		   $impRet	= mysqli_query($con,$impSql);
		   $row_impr	= mysqli_fetch_object($impRet);
		   $numRec	= $row_impr->impr_count;
			if($numRec == '') $numRec = 0;



           $total          =$click."~".$nclick."~".$lead."~".$nlead."~".$sale."~".$nsale."~".$linkid."~".$approvedamnt."~".$pendingamnt."~".$paidamnt."~".$rejectedamnt."~".$impression_counts."~".$impression."~".$numRec;
        //  echo "$total";
       return($total);

  }
  /****************************************************************************/
?>