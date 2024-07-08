<?php	ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  print_link.php        		                    */
/*     CREATED ON     :  19/JULY/2006                                   */

/*		Printable version of the link Report of Mer, Aff & Admin		*/
/************************************************************************/
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
	$affiliate	= intval($_REQUEST['aid']);
	$From		= $_REQUEST['from'];
	$To			= $_REQUEST['to'];
	$program	= $_REQUEST['program'];
	$currValue	= $_REQUEST['currValue'];
	$currsymbol	= $_REQUEST['currsymbol'];
	
	if($currsymbol == '') 
		$currsymbol = $_SESSION['DEFAULTCURRENCYSYMBOL'];

	
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

?>
<html>
<title><?=$title?></title>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>

	<table border="0" cellpadding="0" cellspacing="3"  class="tableNew"  width="90%" align="center">
		<tr><td colspan="9" align="center"><b><?=$lang_report_stat?>&nbsp;<?=$date?></b></td></tr>
		<? if($mode == 'admin' || $mode == 'merchant') { ?>
		<tr><td colspan="9" align="center"><b><?=$lang_report_merchant?>&nbsp;:&nbsp;<?=$merchantName?></b></td></tr>
		<? }  
		if($mode == 'affiliate') { ?>
			<tr><td colspan="9" align="center"><b><?=$lang_report_affiliate?>&nbsp;:&nbsp;<?=$affiliateName?></b></td></tr>
		<? } ?>
		<tr><td colspan="9" align="center"><b><?=$lang_pgm?>&nbsp;:&nbsp;<?=$programName?></b></td></tr>

		<tr><td colspan="9"><hr /></td></tr>
		<tr>
			<td align="center"  width="28%"><b><?=$lang_report_linkname?></b></td>
			<td align="center" colspan="2" width="18%"><b><?=$lang_impression?></b></td>
			<td align="center" colspan="2" width="18%"><b><?=$lang_click?></b></td>
			<td align="center" colspan="2" width="18%"><b><?=$lang_lead?></b></td>
			<td align="center" colspan="2" width="18%"><b><?=$lang_sale?></b></td>
		</tr>
		<tr>
			<td align="left" width="28%">&nbsp;</b></td>
			<td align="left" width="8%"><b><?=$lang_report_count?></b></td>
			<td align="left" width="10%"><b><?=$lang_report_commission?></b></td>
			<td align="left" width="8%"><b><?=$lang_report_count?></b></td>
			<td align="left" width="10%"><b><?=$lang_report_commission?></b></td>
			<td align="left" width="8%"><b><?=$lang_report_count?></b></td>
			<td align="left" width="10%"><b><?=$lang_report_commission?></b></td>
			<td align="left" width="8%"><b><?=$lang_report_count?></b></td>
			<td align="left" width="10%"><b><?=$lang_report_commission?></b></td>
		</tr>	
		<tr><td colspan="9"><hr /></td></tr>
<?		
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
				$sql       ="SELECT * from partners_joinpgm,partners_program  where joinpgm_affiliateid=$affiliate and joinpgm_status not like('waiting')  and joinpgm_programid=program_id   ";
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
		
	$res = mysql_query($sql);  
	if(mysql_num_rows($res) > 0)
	{
		while($row = mysql_fetch_object($res))
		{
			$pgmid      = $row->program_id;
			$pgmName 	= $row->program_url;
			
			$sql_banner = "select * from partners_banner where banner_programid='$pgmid'";
			$res_banner = mysql_query($sql_banner);
			//for all banners
			while($row_banner = mysql_fetch_object($res_banner))
			{
				$total  = get($To,$From,B.$row_banner->banner_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);
				?>
				<tr>
					<td align="left" width="28%"><?=$pgmName?>-B<?=$row_banner->banner_id?></td>
					<td align="left" width="8%"><?=$total[13]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[12]?></td>
					<td align="left" width="8%"><?=$total[1]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[0]?></td>
					<td align="left" width="8%"><?=$total[3]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[2]?></td>
					<td align="left" width="8%"><?=$total[5]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[4]?></td>
				</tr>	
				<?
			}
			
			$sql_text = "select * from partners_text where text_programid='$pgmid'";
			$res_text = mysql_query($sql_text);
			//for all text
			while($row_text = mysql_fetch_object($res_text))
			{
				$total = get($To,$From,T.$row_text->text_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);
				?>
				<tr>
					<td align="left" width="28%"><?=$pgmName?>-T<?=$row_text->text_id?></td>
					<td align="left" width="8%"><?=$total[13]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[12]?></td>
					<td align="left" width="8%"><?=$total[1]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[0]?></td>
					<td align="left" width="8%"><?=$total[3]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[2]?></td>
					<td align="left" width="8%"><?=$total[5]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[4]?></td>
				</tr>	
				<?
			}			
			
			$sql_popup = "select * from partners_popup where popup_programid='$pgmid'";
			$res_popup = mysql_query($sql_popup);
			//for all popup
			while($row_popup = mysql_fetch_object($res_popup))
			{
				$total = get($To,$From,P.$row_popup->popup_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);
				?>
				<tr>
					<td align="left" width="28%"><?=$pgmName?>-P<?=$row_popup->popup_id?></td>
					<td align="left" width="8%"><?=$total[13]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[12]?></td>
					<td align="left" width="8%"><?=$total[1]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[0]?></td>
					<td align="left" width="8%"><?=$total[3]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[2]?></td>
					<td align="left" width="8%"><?=$total[5]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[4]?></td>
				</tr>	
				<?
			}
			
			$sql_flash = "select * from partners_flash where flash_programid='$pgmid'";
			$res_flash = mysql_query($sql_flash);
			//for all flash
			while($row_flash = mysql_fetch_object($res_flash))
			{
				$total         =get($To,$From,F.$row_flash->flash_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);
				?>
				<tr>
					<td align="left" width="28%"><?=$pgmName?>-F<?=$row_flash->flash_id?></td>
					<td align="left" width="8%"><?=$total[13]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[12]?></td>
					<td align="left" width="8%"><?=$total[1]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[0]?></td>
					<td align="left" width="8%"><?=$total[3]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[2]?></td>
					<td align="left" width="8%"><?=$total[5]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[4]?></td>
				</tr>	
				<?
			}
			
			$sql_html = "select * from partners_html where html_programid='$pgmid'";
			$res_html = mysql_query($sql_html);
			//for all html
			while($row_html = mysql_fetch_object($res_html))
			{
				$total         =get($To,$From,H.$row_html->html_id,$currValue,$subquery,$subquery2,$mode,$default_currency_caption);
				$total 	= explode("~",$total);
				?>
				<tr>
					<td align="left" width="28%"><?=$pgmName?>-H<?=$row_html->html_id?></td>
					<td align="left" width="8%"><?=$total[13]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[12]?></td>
					<td align="left" width="8%"><?=$total[1]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[0]?></td>
					<td align="left" width="8%"><?=$total[3]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[2]?></td>
					<td align="left" width="8%"><?=$total[5]?></td>
					<td align="left" width="10%"><?=$currsymbol?>&nbsp;<?=$total[4]?></td>
				</tr>	
				<?
			}
			
		}
	}
			
?>		
		<tr><td colspan="9">&nbsp;</td></tr>
		<tr><td colspan="9"><hr /></td></tr>
		<tr><td align="right" colspan="9">
			<img src="images/printer.png" /><a href="#" onClick="javascript: window.print();" ><?=$lang_print_report?></a>
		</td></tr>
	</table>
	
<?

   /******************getting statistics for particular linkid******************/
  function get($To,$From,$linkid,$currValue,$subquery,$subquery2,$mode,$default_currency_caption)
  {    
		if($currValue == '') $currValue = $default_currency_caption;
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
            $result     = mysql_query($sql); //echo "click qry = ".$sql;
            $nclick     = mysql_num_rows($result)+$nclick;

            while($row=mysql_fetch_object($result))
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
            $result   = mysql_query($sql);
            $nlead    = mysql_num_rows($result)+$nlead;  //no of lead

            while($row=mysql_fetch_object($result))
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
            $result =        mysql_query($sql);
            $nsale  =        mysql_num_rows($result)+$nsale; //no of sale

            while($row=mysql_fetch_object($result))
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
						$res_Recur	= mysql_query($sql_Recur);
						if(mysql_num_rows($res_Recur) > 0)
						{
							$row_recur	= mysql_fetch_object($res_Recur);
							$recurId	= $row_recur->recur_id;
							
							$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
							$res_recurpay	= mysql_query($sql_recurpay);
							if(mysql_num_rows($res_recurpay) > 0)
							{
								$row_recurpay 	= mysql_fetch_object($res_recurpay);
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
            $result4  = mysql_query($sql);

             while($row1=mysql_fetch_object($result4))
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
						$res_Recur	= mysql_query($sql_Recur);
						if(mysql_num_rows($res_Recur) > 0)
						{
							$row_recur	= mysql_fetch_object($res_Recur);
							$recurId	= $row_recur->recur_id;
							
							$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
							$res_recurpay	= mysql_query($sql_recurpay);
							if(mysql_num_rows($res_recurpay) > 0)
							{
								$row_recurpay 	= mysql_fetch_object($res_recurpay);
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
            $result4   = mysql_query($sql);
            while($row1=mysql_fetch_object($result4))
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
					$res_Recur	= mysql_query($sql_Recur);
					if(mysql_num_rows($res_Recur) > 0)
					{
						$row_recur	= mysql_fetch_object($res_Recur);
						$recurId	= $row_recur->recur_id;
						
						$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
						$res_recurpay	= mysql_query($sql_recurpay);
						if(mysql_num_rows($res_recurpay) > 0)
						{
							$row_recurpay 	= mysql_fetch_object($res_recurpay);
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
            $result4        =mysql_query($sql);
            while($row1=mysql_fetch_object($result4))
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
			$res_rev = mysql_query($sql_rev);  
			if(mysql_num_rows($res_rev) > 0) 
			{
				while($row_rev = mysql_fetch_object($res_rev))
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
           $result4        =mysql_query($sql);
           while($row1=mysql_fetch_object($result4))
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
						$res_Recur	= mysql_query($sql_Recur);
						if(mysql_num_rows($res_Recur) > 0)
						{
							$row_recur	= mysql_fetch_object($res_Recur);
							$recurId	= $row_recur->recur_id;
							
							$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' ";
							$res_recurpay	= mysql_query($sql_recurpay);
							if(mysql_num_rows($res_recurpay) > 0)
							{
								$row_recurpay 	= mysql_fetch_object($res_recurpay);
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
            $result     = mysql_query($sql);


            while($row=mysql_fetch_object($result))
            {
                 # get transaction details
                   $date         =   $row->transaction_dateoftransaction;
                   $affAmnt      =   $row->transaction_amttobepaid;
                   $adminAmnt    =   $row->transaction_admin_amount;
                   $trans_id     =   $row->transaction_id;  
                   #get the impressioncount(unit) from trans_rates table
              	   $sql_rate     = "SELECT trans_unit FROM partners_trans_rates WHERE trans_id ='$trans_id'";
	               $res_rate     = mysql_query($sql_rate);

	               if(mysql_num_rows($res_rate) >0)
	               {
	                    while($row  = mysql_fetch_object($res_rate))
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
	
		   $impRet	= mysql_query($impSql);
		   $row_impr	= mysql_fetch_object($impRet);
		   $numRec	= $row_impr->impr_count;
			if($numRec == '') $numRec = 0; 
			


           $total          =$click."~".$nclick."~".$lead."~".$nlead."~".$sale."~".$nsale."~".$linkid."~".$approvedamnt."~".$pendingamnt."~".$paidamnt."~".$rejectedamnt."~".$impression_counts."~".$impression."~".$numRec;
        //  echo "$total";
       return($total);

  }
  /****************************************************************************/
?>	