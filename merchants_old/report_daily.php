<?php


    $programs    =trim($_POST['programs']);        //programid

    if (empty($_SESSION['PROGRAMID']))
    $_SESSION['PROGRAMID']='All';
	
	$d                =$_GET['d'];
	$m                =$_GET['m'];
	$y                =$_GET['y'];

    if (!empty($programs))
    $_SESSION['PROGRAMID']=$programs;

    $PROGRAMID       = $_SESSION['PROGRAMID'];
    $MERCHANTID      = $_SESSION['MERCHANTID'];    //merchantid

    if (empty($d))
       {
          $today  = getdate();
          $d      = $today['mday'];  
          $m      = date("m");     //setting as todays
          $y      = $today['year'];
       }

    //adding programs to dropdown
    $sql      = "SELECT * from partners_program where program_merchantid='$MERCHANTID'"; //adding to drop down box
    $result2  = mysqli_query($con,$sql);

     $dateoftrans  = $y."-".$m."-".$d;

    //getting statistics based on seacrh
    switch($PROGRAMID)
    {
    case 'All':
         $sql="SELECT * from partners_joinpgm,partners_program where program_merchantid='$MERCHANTID' and  joinpgm_programid=program_id   ";

          # calculate impressions
         $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid = '$MERCHANTID' and imp_date ='$dateoftrans' ";


            $rawClick = GetRawTrans('click', $MERCHANTID, 0, 0, 0,  0,0, $dateoftrans)   ;
            $rawImp   = GetRawTrans('impression', $MERCHANTID, 0, 0, 0,  0,0, $dateoftrans) ;

        break;
     default:
         $sql="SELECT * from partners_joinpgm,partners_program where program_id='$PROGRAMID' and  joinpgm_programid=program_id   ";

          # calculate impressions
         $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_programid = $PROGRAMID  and imp_date ='$dateoftrans' ";

         $rawClick = GetRawTrans('click',  0, 0, $PROGRAMID,0,  0,0, $dateoftrans)   ;
         $rawImp   = GetRawTrans('impression', 0, 0, $PROGRAMID,0, 0,0, $dateoftrans) ;


         break;
     }
   //   echo "this is a test after query to test";

     $impRet	= mysqli_query($con,$impSql);
	 $row_impr = mysqli_fetch_object($impRet);
	 $numRec	= $row_impr->impr_count;
	 if($numRec == '') $numRec = 0;

   //  if (!$numRec) echo "Error1".mysqli_error($con);

     // echo "this is a test after query 11";
    //  exit;

    $result1                  =mysqli_query($con,$sql) or die($sql.mysqli_error($con));

    $click                    =0;
    $lead                     =0;
    $sale                     =0;
    $nclick                   =0;
    $nlead                    =0;
    $nsale                    =0;
    $impression               =0;
    $impression_counts		  =0;
	

 //   echo "this is a test after query 1";
    while( $rows=mysqli_fetch_object($result1))
    {
			$joinid   = $rows->joinpgm_id; //getting affiliates joined pgms for aprticular merchant
			
			$sql      = "SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='click' and transaction_joinpgmid='$joinid'";
			$result   = mysqli_query($con,$sql);
			$nclick   = mysqli_num_rows($result)+$nclick;   //no of click
			// echo "this is a test after query2";
			while($row =mysqli_fetch_object($result))
			{
				# get transaction details
				$date		 =   $row->transaction_dateoftransaction;
				$affAmnt 	 =   $row->transaction_amttobepaid;
				$adminAmnt    =   $row->transaction_admin_amount;
				
				# converting to user currency
				if($currValue != $default_currency_caption){
					$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
					$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
				}
				
				$click                 =$affAmnt + $adminAmnt + $click;  //click amnt
			}
			
			$sql                  ="SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='lead' and transaction_joinpgmid='$joinid'";
			$result               =mysqli_query($con,$sql);
			$nlead                =mysqli_num_rows($result)+$nlead;  //no of lead
			//   echo "this is a test after query3";
			while($row=mysqli_fetch_object($result))
			{
					# get transaction details
					$date		 =   $row->transaction_dateoftransaction;
					$affAmnt 	 =   $row->transaction_amttobepaid;
					$adminAmnt    =   $row->transaction_admin_amount;
					
					# converting to user currency
					if($currValue != $default_currency_caption){
						$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
						$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
					}
					$lead                =$affAmnt + $adminAmnt + $lead;  //lead amnt
			}
			
			// $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
			$sql                 ="SELECT *  from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid='$joinid'";
			$result              =mysqli_query($con,$sql);
			$nsale               =mysqli_num_rows($result)+$nsale;  //no of sales
			//  echo "this is a test after query4";
			while($row=mysqli_fetch_object($result))
			{
					# get transaction details
					$date		 =   $row->transaction_dateoftransaction;
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
				// END Modified on 23-JUNE-06
					 else
					 {	 
						$affAmnt 	 =   $row->transaction_amttobepaid;
					 }
					
					# converting to user currency
					if($currValue != $default_currency_caption){
						$affAmnt 	 =   getCurrencyValue($date, $currValue, $affAmnt);
						$adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
					}
					$sale                =$affAmnt + $adminAmnt + $sale;  //sale amnt
			}
		


	
 #== Modified on JuNE.17.06 by SMA to get the impression commission
        $sql      		= "SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='impression' and transaction_joinpgmid='$joinid'";
	    $result   		= mysqli_query($con,$sql);

	    while($row =mysqli_fetch_object($result))
	    {
        	# get transaction details
	        $date         =   $row->transaction_dateoftransaction;
	        $affAmnt      =   $row->transaction_amttobepaid;
	        $adminAmnt    =   $row->transaction_admin_amount;
            $trans_id     =   $row->transaction_id;

	        # converting to user currency
	        if($currValue != $default_currency_caption)
            {
            	$affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
	            $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
	        }

	        $impression   =$affAmnt + $adminAmnt + $impression;  //impression amnt
    	}
  #== End of Modification on  JuNE.17.06 by SMA  to get the impression commission
			
     }

if($currSymbol=="&pound") $currSymbol = "&pound;";
 ?>

        <br/>
		<form name="Getprogram" method="post" action="">
        <table border="0"  cellpadding="0" cellspacing="0"  class="tablebdr"  align="center" width="80%">

         <tr>

          <td align="left" height="25" class="tdhead">&nbsp;&nbsp;<b><?=$lang_report_pgm?></b>
          <select name="programs" onchange="document.Getprogram.submit()"><option value="All" ><?=$lang_report_AllProgram?></option>
                   <?  while($row=mysqli_fetch_object($result2))

                   {
                   if($PROGRAMID=="$row->program_id")
                          $programName="selected";
                   else
                    $programName="";

                   ?>
                     <option <?=$programName?> value="<?=$row->program_id?>">
                     <?=$common_id?>:<?=$row->program_id?>...<?=stripslashes($row->program_url)?> </option>
                   <?
                   }
                   ?>
          </select>
          </td>
		  <? 	$selDate		= $d.".".$m.".".$y;	
		  		$values	= $numRec."~".$impression."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale."~".$nsubsale."~".$subsale."~".$currSymbol;
		  ?>

		<td width="20%" class="tdhead" align="right"><a href="#" onClick="window.open('../print_daily.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&values=<?=$values?>&program=<?=$PROGRAMID?>','new','400,400,scrollbars=1,resizable=1');" ><b><?=$lang_print_report_head?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_daily.php?mid=<?=$MERCHANTID?>&mode=merchant&date=<?=$selDate?>&values=<?=$values?>&program=<?=$PROGRAMID?>"><b><?=$lang_export_csv_head?></b></a></td>
        </tr>
        <tr>
           <td  width="100%" align="center" height="30" colspan="2" class="red"><?=$lang_report_stat?> <? echo "$d.$m.$y" ?></td>
        </tr>
        <tr>
           <td width ="60%" height="100%" valign='top'>

              <table width="95%" align="center" cellspacing="1" class="tablebdr" >

               <tr>
                     <td width="40%"  class="tdhead"><b><?=$lang_report_transaction?></b></td>
                     <td width="30%"  class="tdhead"><b><?=$lang_report_number?></b></td>
                     <td width="30%"  class="tdhead"><b><?=$lang_report_commission?></b></td>
               </tr>
                <tr>
                    <td width="35%"  class="grid1" height="28"> <?=$lhome_Imp?>
                          </td>
                    <td width="26%"  class="grid1" ><?=$numRec?></td>
                    <td width="39%"   class="grid1" ><?=$currSymbol?><?=$impression?> </td>
                  </tr>
               <tr>
                     <td width="25%" class="grid1" height="28"><?=$lang_report_click?>&nbsp;<img
                      alt="" border="0" height="10" src="../images/click.gif"
                     width="10"/></td>
                     <td width="25%" class="grid1"  height="28"><?=$nclick?></td>
                     <td width="25%" class="grid1"  height="28"><?=$currSymbol?><?=$click?> </td>
                 </tr>
                 <tr>
                     <td width="25%" class="grid1"  height="28"><?=$lang_report_lead?>&nbsp;<img
                     alt="" border="0"   height="10" src="../images/lead.gif"
                     width="10"/></td>
                     <td width="25%" class="grid1" height="28"><?=$nlead?></td>
                     <td width="25%" class="grid1"   height="28"><?=$currSymbol?><?=$lead?> </td>
                 </tr>
                 <tr>
                     <td width="25%" class="grid1"  height="28"><?=$lang_report_sale?>&nbsp;<img
                      alt="" border="0" height="10" src="../images/sale.gif"
                      width="10"/></td>
                     <td width="25%" class="grid1"  height="28"><?=$nsale?></td>
                     <td width="25%" class="grid1"  height="28"><?=$currSymbol?><?=$sale?> </td>
                 </tr>
               </table>
               <br/>
             </td>

<?php

include 'calender.php';

$d                =$_GET['d'];
$m                =$_GET['m'];
$y                =$_GET['y'];

//adding calender

class MyCalendar1 extends Calendar
{
    function getCalendarLink($month, $year)
    {
        $s                         = getenv('SCRIPT_NAME');
        $act        =$_GET['Action'];

        $qry                ="?";
        $sep                ="" ;

       foreach($_GET as $k => $v) {
            if($k=="month" or $k=="year") continue;
            $qry.=$sep.$k."=".$v;
                           $sep="&";
                  }
        return "$s$qry&amp;month=$month&amp;year=$year";
    }



    function getDateLink($day, $month, $year)
    {
        // Only link the first day of every month
        $link = "";
        return $link;
    }



}
if ($month == "")

{      $month = date("m");
}
if ($year == "")
{    $year = date("Y");
}
$cal1 = new MyCalendar1($id);
echo $cal1->getMonthView($month, $year);
?>
 <? viewRawTrans($rawClick, $rawImp) ?>
</td> </tr>
</table>
</form><br />