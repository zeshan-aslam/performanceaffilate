<?php	ob_start();

  /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW LINK REPORTS (PROCESSING PAGE)
      VARIABLES          :  $AFFILIATEID        =affilaiteid
	                        $From ,$cFrom       =from date
	                        $To,cTo             =to date
	                        $sub                =submit button
	                        $msg                =errmsg
	                        $LINKS              =getting statstics
                            $total              =statstics
	                        $programs           =program id
                            $click              =click amnt
                            $lead               =lead amnt
	                        $sale               =sale amnt
	                        $nclick             =no of click
                            $nlead              =no of lead
	                        $nsale              =no of sale
	                        $pendingamnt        =pending amnt
	                        $approvedamnt       =approved amnt
	                        $paidamnt           =paid amnt
	                        $rejectedamnt       =reversed amnt
  //*************************************************************************************************/

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once '../includes/allstripslashes.php';

   $partners=new partners;
   $partners->connection($host,$user,$pass,$db);
   include_once 'language_include.php';

   /**************************variables***************************************/
   $cfrom                                  =trim($_POST['txtfrom']);    //from date
   $cto                                    =trim($_POST['txtto']);      //to date
   $sub                                    =trim($_POST['sub']);        //submit button
   $programs                               =trim($_POST['programs']);   //program id
   $AFFILIATEID                            =$_SESSION['AFFILIATEID'];   //affilaiteid
   $_SESSION['LINKS'] 					   = "";                        //intialise statistics
   /*************************************************************************/



   /***********date validation************************************************/
   if(!$partners->is_date($cfrom) || !$partners->is_date($cto) )
   {
    $Err=$lang_report_err ;
    header("location:index.php?Act=LinkReport&programs=$programs&msg=$Err");
    exit;
   }
   //changing date format
   $From                        =$partners->date2mysql($cfrom);
   $To                          =$partners->date2mysql($cto);
   /**************************************************************************/



   /*********************getting all programid*********************************/
   switch($programs)
   {
     case 'All':
        $sql       ="SELECT * from partners_joinpgm,partners_program  where joinpgm_affiliateid ='$AFFILIATEID' and joinpgm_status not like('waiting')  and joinpgm_programid=program_id   ";
        break;
      default:
         $sql      ="SELECT * from partners_program where program_id ='$programs' ";
         break;
      }
    $result       =mysqli_query($con,$sql);
    /*************************************************************************/




    /**************getting statistics of particular pgnm*************************/
     while($row=mysqli_fetch_object($result))
                          {
                                 $pgmid         =$row->program_id;
                                 $sql           ="select * from partners_banner where banner_programid ='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                 //for all banners
                                 while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,B.$rows->banner_id);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
                                 }

                                 $sql           ="select * from partners_text where text_programid ='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                 //for all text
                                 while($rows=mysqli_fetch_object($ret))
                             {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,T.$rows->text_id);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;

                               }

                                 $sql           ="select * from partners_popup where popup_programid ='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                 //all popup
                                while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,P.$rows->popup_id);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
                                 }

                                 $sql           ="select * from partners_flash where flash_programid ='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                 //for all flash
                                while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,F.$rows->flash_id);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
                                 }
                                 $sql           ="select * from partners_html where html_programid ='$pgmid'";
                                 $ret           =mysqli_query($con,$sql);
                                 //all html
                                 while($rows=mysqli_fetch_object($ret))
                                 {
                                 $From          =$partners->date2mysql($txtfrom);
                                 $To            =$partners->date2mysql($txtto);
                                 $total         =get($To,$From,H.$rows->html_id);
                                 $_SESSION['LINKS'] = $_SESSION['LINKS']."^".$total ;
                                 }
                      }
   /**************************************************************************/

  HEADER("location:index.php?Act=LinkReport&sub=$sub&i=1&txtto=$txtto&txtfrom=$txtfrom&programs=$programs");




  /******************getting statistics for particular linkid******************/
  function get($To,$From,$linkid)
  {
    $AFFILIATEID           =$_SESSION['AFFILIATEID'];
    //initiating
	$impression	   			=0;
	$impression_count		=0;
	
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


			//Added by SMA to find the impression comission amt on 8-Mar-06
            $sql      =  "SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_type='impression' and transaction_linkid='$linkid' and joinpgm_affiliateid='$AFFILIATEID' AND transaction_joinpgmid=joinpgm_id ";
            $result   =  mysqli_query($con,$sql);
            while($row=mysqli_fetch_object($result))
            {
                //$impression         =$row->transaction_amttobepaid + $impression; //total impression amnt
				$imp_amt = $row->transaction_amttobepaid;
				$date		 =   $row->transaction_dateoftransaction;
				$impression = $imp_amt + $impression;
				

				//To get the number of impressions
				$trans_id = $row->transaction_id;
				$trans_sql = "SELECT * FROM partners_trans_rates WHERE trans_id='$trans_id'";
				$trans_result = mysqli_query($con,$trans_sql);
				if(mysqli_num_rows($trans_result) > 0)
				{ 
					$trans_row = mysqli_fetch_object($trans_result);
					$impression_count = $trans_row->trans_unit + $impression_count;
				}
            }
			//End add on 8-Mar-06


            $sql                ="SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_type='click' and transaction_linkid='$linkid' and joinpgm_affiliateid='$AFFILIATEID' AND transaction_joinpgmid=joinpgm_id ";
            $result             =mysqli_query($con,$sql); 
            $nclick             =mysqli_num_rows($result)+$nclick;

          // echo "$sql";//no of click
            while($row=mysqli_fetch_object($result))
                {
                $click         =$row->transaction_amttobepaid+$click; //total click amnt
                }


            //echo "$sql";
          //  echo "$nclick";
            $sql                ="SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_type='lead' and transaction_linkid='$linkid'  and joinpgm_affiliateid='$AFFILIATEID' AND transaction_joinpgmid=joinpgm_id ";
            $result             =mysqli_query($con,$sql);
            $nlead              =mysqli_num_rows($result)+$nlead;  //no of lead

            while($row=mysqli_fetch_object($result))
                {
                $lead           =$row->transaction_amttobepaid+$lead;// total lead amnt
                }  //end while



           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql="SELECT *  from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_type='sale' and transaction_linkid='$linkid'  and joinpgm_affiliateid='$AFFILIATEID' AND transaction_joinpgmid=joinpgm_id ";
            $result            =mysqli_query($con,$sql);
            $nsale             =mysqli_num_rows($result)+$nsale; //no of sale
            while($row=mysqli_fetch_object($result))
            {
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
							$sale 	 =  $row_recurpay->recurpayments_amount + $sale; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
	                $sale          =$row->transaction_amttobepaid+$sale;//total sale amnt
				 }
            }  //end  while


             $sql            ="SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_status='approved' and transaction_linkid='$linkid'  and joinpgm_affiliateid='$AFFILIATEID' AND transaction_joinpgmid=joinpgm_id ";
             $result4        =mysqli_query($con,$sql);
             while($row1=mysqli_fetch_object($result4))
             {
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
							$approvedamnt 	 =  $row_recurpay->recurpayments_amount + $approvedamnt; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
	                $approvedamnt=$row1->transaction_amttobepaid + $approvedamnt;// total approved amnt
				 }
             }  //end while


           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql            ="SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To'and transaction_linkid='$linkid'  and joinpgm_affiliateid='$AFFILIATEID' AND transaction_joinpgmid=joinpgm_id ";
            $result4        =mysqli_query($con,$sql);
            while($row1=mysqli_fetch_object($result4))
            {
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
							$paidamnt 	 =  $row_recurpay->recurpayments_amount + $paidamnt; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
		               $paidamnt   =$row1->transaction_amountpaid + $paidamnt;//total sale amnt
				 }
            }  //end  while


            $sql            ="SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_status='reversed' and transaction_linkid='$linkid'  and joinpgm_affiliateid='$AFFILIATEID' AND transaction_joinpgmid=joinpgm_id ";
            $result4        =mysqli_query($con,$sql);
            while($row1=mysqli_fetch_object($result4))
            {
               $rejectedamnt=$row1->transaction_amttobepaid+$rejectedamnt;// total approved amnt
             }  //end while

           $sql            ="SELECT * from partners_transaction,partners_joinpgm where transaction_dateoftransaction between '$From' and '$To' and transaction_status='pending' and transaction_linkid='$linkid'  and joinpgm_affiliateid='$AFFILIATEID' AND transaction_joinpgmid=joinpgm_id ";
           $result4        =mysqli_query($con,$sql);
           while($row1=mysqli_fetch_object($result4))
           {
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
							$pendingamnt 	 =  $row_recurpay->recurpayments_amount + $pendingamnt; 
						}
					}
				 }
				 else
				 {	 
		// END Modified on 23-JUNE-06
				       $pendingamnt=$row1->transaction_amttobepaid+$pendingamnt;// total approved amnt
			   	 }
           }  //end while




           $total          =$click."~".$nclick."~".$lead."~".$nlead."~".$sale."~".$nsale."~".$linkid."~".$approvedamnt."~".$pendingamnt."~".$pensubsale."~".$rejectedamnt."~".$impression."~".$impression_count;
        //  echo "$total";
       return($total);

  }
 /****************************************************************************/
?>