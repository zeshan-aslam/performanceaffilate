<?php	ob_start();

#-------------------------------------------------------------------------------
# Admin Panel Link Report
# Gets date range, merchnat id and corresponding programs
# Finds Transctions happend for this progarms through specific ad link

# Pgmmr        : RR
# Date Created :   21-10-2004
# Date Modfd   :   26-10-2004
#-------------------------------------------------------------------------------


# includes all header files

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once '../includes/allstripslashes.php';

# estalshing connection

   $partners = new partners;
   $partners->connection($host,$user,$pass,$db);


# getting all form variables
   $cfrom             = trim($_POST['txtfrom']);  //from date
   $cto               = trim($_POST['txtto']);    //to date
   $sub               = trim($_POST['sub']);      //submit button
   $programs          = intval(trim($_POST['programs'])); //program id
   $MERCHANTID        = intval($_POST['merchants']);      //merchantid
   $_SESSION['LINKS'] = "";                      //initialise statistics

# setting default values for merchnatid
   if($MERCHANTID=='All')
          $MERCHANTID = "0";

# validating date firlds
# if incorrect format rediraects to main page
# with err msg
   if(!$partners->is_date($cfrom) || !$partners->is_date($cto)){
        $Err="Please Enter Valid Date" ;
        header("location:index.php?Act=link_report&programs=$programs&merchants=$MERCHANTID&msg=$Err");
        exit;
   }


#change to sql formats
   $From      = $partners->date2mysql($cfrom);
   $To        = $partners->date2mysql($cto);

# getiing all programs
   switch($programs)
   {
      case 'AllPgms':
        $sql = "SELECT * from partners_program ";
        break;

     case 'All':
        $sql = "SELECT * from partners_program  where program_merchantid='$MERCHANTID' ";
        break;

     default:
        $sql = "SELECT * from partners_program where program_id='$programs' ";
        break;
   }

   $result    = mysql_query($sql);

	while($row=mysql_fetch_object($result)) {
		$pgmid         =$row->program_id;
		$sql           ="select * from partners_banner where banner_programid=$pgmid";
		$ret           =mysql_query($sql);
		
		//for all banners
		while($rows=mysql_fetch_object($ret))
		{
			$From          =$partners->date2mysql($txtfrom);
			$To            =$partners->date2mysql($txtto);
			$total         =get($To,$From,B.$rows->banner_id);
			$_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
		}
		
		$sql           ="select * from partners_text where text_programid=$pgmid";
		$ret           =mysql_query($sql);
		//for all text
		while($rows=mysql_fetch_object($ret))
		{
			$From          =$partners->date2mysql($txtfrom);
			$To            =$partners->date2mysql($txtto);
			$total         =get($To,$From,T.$rows->text_id);
			$_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
		}
		
		$sql           ="select * from partners_popup where popup_programid=$pgmid";
		$ret           =mysql_query($sql);
		//for all popup
		while($rows=mysql_fetch_object($ret))
		{
			$From          =$partners->date2mysql($txtfrom);
			$To            =$partners->date2mysql($txtto);
			$total         =get($To,$From,P.$rows->popup_id);
			$_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
		}
		
		$sql           ="select * from partners_flash where flash_programid=$pgmid";
		$ret           =mysql_query($sql);
		//for all flash
		while($rows=mysql_fetch_object($ret))
		{
			$From          =$partners->date2mysql($txtfrom);
			$To            =$partners->date2mysql($txtto);
			$total         =get($To,$From,F.$rows->flash_id);
			$_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
		}
		
		$sql           ="select * from partners_html where html_programid=$pgmid";
		$ret           =mysql_query($sql);
		//for all html
		while($rows=mysql_fetch_object($ret))
		{
			$From          =$partners->date2mysql($txtfrom);
			$To            =$partners->date2mysql($txtto);
			$total         =get($To,$From,H.$rows->html_id);
			$_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
		}
	}

header("location:index.php?Act=link_report&sub=$sub&i=1&txtto=$txtto&txtfrom=$txtfrom&programs=$programs&merchants=$MERCHANTID");

  function get($To,$From,$linkid)
  {

    //initiating
    $click        =0;
    $lead         =0;
    $sale         =0;
    $nclick       =0;
    $nlead        =0;
    $nsale        =0;
    $pendingamnt  =0;
    $approvedamnt =0;
    $paidamnt     =0;
    $rejectedamnt =0;
	 $impression =0;

            $sql                ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_linkid='$linkid'";
            $result             =mysql_query($sql);
            $nclick             =mysql_num_rows($result)+$nclick;

            while($row=mysql_fetch_object($result))
			{
				$click         =$row->transaction_amttobepaid+$row->transaction_admin_amount+$click; //total click amnt
			}


            $sql                ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='lead' and transaction_linkid='$linkid'";
            $result             =mysql_query($sql);
            $nlead              =mysql_num_rows($result)+$nlead;  //no of lead

            while($row=mysql_fetch_object($result))
			{
				$lead           =$row->transaction_amttobepaid+$row->transaction_admin_amount+$lead;// total lead amnt
			}  //end while



           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql="SELECT *  from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='sale' and transaction_linkid='$linkid'";
            $result            =mysql_query($sql);
            $nsale             =mysql_num_rows($result)+$nsale; //no of sale
            while($row=mysql_fetch_object($result))
			{
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
							$sale 	 =  $row_recurpay->recurpayments_amount + $sale ; 
						}
					}
				 }
				else
				{	 
					// END Modified on 23-JUNE-06
					$sale          =$row->transaction_amttobepaid + $sale;//total sale amnt
				}
				$sale          = $row->transaction_admin_amount + $sale;
			}  //end  while


			$sql            ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='approved' and transaction_linkid='$linkid'";
			$result4        =mysql_query($sql);
			while($row1=mysql_fetch_object($result4))
			{
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
						
						$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'approved' ";
						$res_recurpay	= mysql_query($sql_recurpay);
						if(mysql_num_rows($res_recurpay) > 0)
						{
							$row_recurpay 	= mysql_fetch_object($res_recurpay);
							$approvedamnt 	 =  $row_recurpay->recurpayments_amount + $approvedamnt ; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
						$approvedamnt=$row1->transaction_amttobepaid + $approvedamnt;// total approved amnt
				 }
				 $approvedamnt 	 =  $row1->transaction_admin_amount + $approvedamnt;
			}  //end while


           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql            ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To'and transaction_linkid='$linkid'";
            $result4        =mysql_query($sql);
            while($row1=mysql_fetch_object($result4))
			{
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
							$paidamnt 	 =  $row_recurpay->recurpayments_amount + $paidamnt ; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
					   $paidamnt   =$row1->transaction_amountpaid + $paidamnt;//total sale amnt
				 }
				 $paidamnt 	 =  $row1->transaction_adminpaid + $paidamnt;
             }  //end  while


            $sql            ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='reversed' and transaction_linkid='$linkid'";
            $result4        =mysql_query($sql);
            while($row1=mysql_fetch_object($result4))
            {
                              $rejectedamnt=$row1->transaction_amttobepaid+$rejectedamnt;// total approved amnt
            }  //end while
			
			//Calculate reversed commissions fro Recurring sales
			$sql_rev = "SELECT * FROM partners_transaction, partners_recur, partners_recurpayments WHERE ".
			" transaction_linkid='$linkid' AND recur_transactionid=transaction_id AND ".
			" transaction_dateoftransaction between '$From' and '$To' AND ".
			" recurpayments_recurid=recur_id  AND recurpayments_status='reversed' ";
			$res_rev = mysql_query($sql_rev);
			if(mysql_num_rows($res_rev) > 0)
			{
				while($row_rev = mysql_fetch_object($res_rev))
				{
					$rejectedamnt = $row_rev->recurpayments_amount + $rejectedamnt;
				}
			}
			//End Reverse Calculation
			


           $sql            ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_linkid='$linkid'";
           $result4        =mysql_query($sql);
           while($row1=mysql_fetch_object($result4))
			{
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
						
						$sql_recurpay	= "SELECT * FROM partners_recurpayments WHERE recurpayments_recurid = '$recurId' AND recurpayments_status = 'pending' ";
						$res_recurpay	= mysql_query($sql_recurpay);
						if(mysql_num_rows($res_recurpay) > 0)
						{
							$row_recurpay 	= mysql_fetch_object($res_recurpay);
							$pendingamnt 	 =  $row_recurpay->recurpayments_amount + $pendingamnt ; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
					   $pendingamnt=$row1->transaction_amttobepaid + $pendingamnt;// total approved amnt
				 }
				 $pendingamnt 	 =  $row1->transaction_admin_amount + $pendingamnt;
            }  //end while



			#modified on 16.JUNE.06 to get impression amount from transaction table
			$sql                ="SELECT * from partners_transaction where transaction_dateoftransaction between '$From' and '$To' and transaction_type='impression' and transaction_linkid='$linkid'";
			$result             =mysql_query($sql);
			
			while($row=mysql_fetch_object($result))
			{
					$imp_amt = $row->transaction_amttobepaid+$row->transaction_admin_amount;
					$date                 =   $row->transaction_dateoftransaction;
					$impression = $imp_amt + $impression;
			
			}  //end while

           $total          =$click."~".$nclick."~".$lead."~".$nlead."~".$sale."~".$nsale."~".$linkid."~".$approvedamnt."~".$pendingamnt."~".$paidamnt."~".$rejectedamnt."~".$impression;
        //  echo "$total";
       return($total);

  }
?>