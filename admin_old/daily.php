<?
  /***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW DAILY REPORTS
      VARIABLES          :   click		=total click amnt
   			  				 lead		=total lead amnt
    						 sale		=total sale amnt
    						 nclick		=total no of clicks
   						     nlead      =total no of leads
   							 nsale      =total no of sales
                             Merchant   =MERCHANT ID
                             Affilaiete =AFFILAIE ID
  //*************************************************************************************************/

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once '../includes/allstripslashes.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    /***************getting total merchants,affiliates to add to drop down box*/
    $sql 	= "SELECT * from partners_merchant ";
    $ret	= mysqli_query($con,$sql);
    $sql 	= "SELECT * from partners_affiliate ";
    $ret1	= mysqli_query($con,$sql);
    /**************************************************************************/


   /**************initial settings*********************************************/
    if (empty($_SESSION['MERCHANT']))
    $_SESSION['MERCHANT']='All';

    if (empty($_SESSION['AFFILIATE']))
    $_SESSION['AFFILIATE']='All';

    if (!empty($Mname))
    $_SESSION['MERCHANT']=$Mname;

    if (!empty($Mname))
    $_SESSION['AFFILIATE']=$Aname;

	if (empty($d))
	{
          $today= getdate();
          $d 	= $today['mday'];
          $m 	= date("m");  	//setting as todays
          $y	= $today['year'];
	}
   /***************************************************************************/


   $Merchant	= intval($_SESSION['MERCHANT']);  //merchant id
   $Affiliate	= intval($_SESSION['AFFILIATE']);    //affiliate id
   $dateoftrans = $y."-".$m."-".$d;

    switch($Merchant)
    {
      case 'All':  //all merchant
            {
            switch ($Affiliate)
            {
               case 'All':       //all affiliate
                   {
                   $sql="SELECT * from partners_joinpgm ";

                   # calculate impressions
                   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE 1 ";

                   $rawClick = GetRawTrans('click', 0, 0,0, 0, 0, 0, $dateoftrans);
                   $rawImp   = GetRawTrans('impression', 0, 0,0, 0, 0, 0, $dateoftrans);
                   break;
                   }
                  default:   //selected affiliate
                   {
                   $sql="SELECT * from partners_joinpgm where joinpgm_affiliateid='$Affiliate'";;

                   # calculate impressions
                   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_affiliateid = '$Affiliate' ";

                   $rawClick = GetRawTrans('click', 0, $Affiliate,0, 0, 0, 0, $dateoftrans);
                   $rawImp   = GetRawTrans('impression', 0, $Affiliate,0, 0, 0, 0, $dateoftrans);

                   break;

                   }
            }
            break;
            }

         default:      //selected  merchant
         {
           switch ($Affiliate)
            {
               case 'All':  //all affiliate
                   {
                   $sql="SELECT * from partners_joinpgm,partners_program where program_merchantid='$Merchant' and  joinpgm_programid=program_id   ";

                   # calculate impressions
                   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid = '$Merchant'  ";

                   $rawClick = GetRawTrans('click', $Merchant, 0,0, 0, 0, 0, $dateoftrans);
                   $rawImp   = GetRawTrans('impression', $Merchant, 0,0, 0, 0, 0, $dateoftrans);

                   break;


                   }
                  default: //selected affiliate
                   {
                    $sql="SELECT * from partners_joinpgm,partners_program where program_merchantid='$Merchant' and joinpgm_affiliateid='$Affiliate' and joinpgm_programid=program_id ";

                     # calculate impressions
                   $impSql = " SELECT sum(imp_count) AS impr_count FROM partners_impression_daily WHERE imp_merchantid = '$Merchant' AND  imp_affiliateid = '$Affiliate'";

                   $rawClick = GetRawTrans('click', $Merchant, $Affiliate,0, 0, 0, 0, $dateoftrans);
                   $rawImp   = GetRawTrans('impression', $Merchant, $Affiliate,0, 0, 0, 0, $dateoftrans);

                   break;
                   }
            }
         }
    }



    $result1     = mysqli_query($con,$sql);

    # impression count
    $impSql .= " And imp_date = '$dateoftrans' ";

    $impRet	= mysqli_query($con,$impSql);
        $row_impr = mysqli_fetch_object($impRet);
        $numRec = $row_impr->impr_count;
        if($numRec == '') $numRec = 0;


    /************initialising**************************************************/
    $click=0;           //total click amnt
    $lead=0;            //total lead amnt
    $sale=0;            //total sale amnt
    $nclick=0;          //total no of clicks
    $nlead=0;           //total no of leads
    $nsale=0;           //total no of sales
	$impression = 0;
    /***************************************************************************/

    while( $rows=mysqli_fetch_object($result1))
    {
			$joinid=$rows->joinpgm_id; //getting affiliates joined pgms for aprticular merchant
		
			$sql="SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='click' and transaction_joinpgmid='$joinid'";
			$result=mysqli_query($con,$sql);
			$nclick=mysqli_num_rows($result)+$nclick;   //no of click
			while($row=mysqli_fetch_object($result))
			{
			$click=$row->transaction_amttobepaid+$row->transaction_admin_amount +$click;  //click amnt
			}
		
			$sql="SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='lead' and transaction_joinpgmid='$joinid'";
			$result=mysqli_query($con,$sql);
			$nlead=mysqli_num_rows($result)+$nlead;  //no of lead
		
			while($row=mysqli_fetch_object($result))
			{
			$lead=$row->transaction_amttobepaid+$row->transaction_admin_amount+$lead;  //lead amnt
			}
		
		   // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
			$sql="SELECT *  from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid='$joinid'";
			$result=mysqli_query($con,$sql);
			$nsale=mysqli_num_rows($result)+$nsale;  //no of sales
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
					$sale = $row->transaction_amttobepaid + $sale;  //sale amnt
				 }
				 $sale =  + $row->transaction_admin_amount +  $sale;
			}
			


		//Added on 16-JUNE-2006
			$sql="SELECT * from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='impression' and transaction_joinpgmid='$joinid'";
			$result=mysqli_query($con,$sql);  
		
		   while($row=mysqli_fetch_object($result))
			{
					#get the impressioncount(unit) from trans_rates table
					$imp_amt = $row->transaction_amttobepaid+$row->transaction_admin_amount;
					$date                 =   $row->transaction_dateoftransaction;
					$impression = $imp_amt + $impression;  
			}
		
     }

	$selDate		= $d.".".$m.".".$y;	
	$values	= $numRec."~".$impression."~".$nclick."~".$click."~".$nlead."~".$lead."~".$nsale."~".$sale;
 ?>
 <p align="right">
 <a href="#" onClick="window.open('../print_daily.php?mid=<?=$Merchant?>&mode=admin&date=<?=$selDate?>&values=<?=$values?>&aid=<?=$Affiliate?>','new','400,400,scrollbars=1,resizable=1');" ><b>Print Report</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../csv_daily.php?mid=<?=$Merchant?>&mode=admin&date=<?=$selDate?>&values=<?=$values?>&aid=<?=$Affiliate?>"><b>Export as CSV</b></a>
 </p>

	<table width="90%" align="center" border="0">
  		<tr>
  			<td  align="right">
        		<table border='0'  cellpadding="0" cellspacing="0" class="tablebdr"  width="100%">
        			<tr>
           				<td  width="100%" class="tdhead" align="center"><b> Statistics on <? echo "$d.$m.$y" ?></b></td>
        			</tr>
        			<tr>
           				<td>
               			<form name="showreport" method="post" action="">
               			<table width="95%" align="center"  class="tablewbdr">
               				<tr>
                     			<td width="25%" height="28">Merchants</td>
                     			<td width="50%" height="28" align="left">
									<select name="Mname" ><option value="All" >All Merchants </option>
									   <?  while($row=mysqli_fetch_object($ret))
		
									   {
									   if($_SESSION['MERCHANT']=="$row->merchant_id")
											  $MerchantName="selected";
									   else
										$MerchantName="";
		
									   ?>
										 <option <?=$MerchantName?> value="<?=$row->merchant_id?>"> <?=stripslashes($row->merchant_company)?> </option>
									   <?
									   }
									   ?>
							  </select>                   			  </td>
               				</tr>
               				<tr>
								<td width="25%" height="28" >Affiliates</td>
								<td width="50%" height="28" align="left"><select name="Aname"><option value="All">All Affiliates </option>

								   <?  while($row=mysqli_fetch_object($ret1))
								   {
								   if($_SESSION['AFFILIATE']=="$row->affiliate_id")
									$AffiliateName="selected";
								   else
									$AffiliateName="";
		
								   ?>
									 <option <?=$AffiliateName?> value="<?=$row->affiliate_id?>"><?=stripslashes($row->affiliate_company)?></option>
								   <?
								   }
								   ?>
                       			</select>
                   			  <input type="submit" name="merchant" value="View" />                     		</td>
               			</tr>
               		</table>
               		</form>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td>
						<table width="100%" align="center"  class="tablewbdr">
							<tr>
								 <td width="40%" class="tdhead"><b>Transactions</b></td>
								 <td width="30%" class="tdhead"><b>Number</b></td>
								 <td width="30%" class="tdhead"><b>Commissions</b></td>
							</tr>
							<tr>
								 <td width="25%" class="grid1" height="28">Impressions&nbsp;<img
								  alt="" border='0'  src="../images/impression.gif" height="10" width="10" /></td>
								 <td width="25%" class="grid1"  height="28"> <?=$numRec?></td>
								 <td width="25%" class="grid1"  height="28"><?=$currSymbol?><?=round($impression,2)?></td>
							</tr>
							<tr>
								<td width="25%" class="grid1" height="28">Clicks&nbsp;<img
									alt="" border='0' height="10" width="10" src="../images/click.gif" /></td>
								<td width="25%" class="grid1"  height="28"><?=$nclick?></td>
								<td width="25%" class="grid1"  height="28"><?=$currSymbol?><?=round($click,2)?></td>
							</tr>
							<tr>
								<td width="25%" class="grid1"  height="28">Leads&nbsp;<img
									alt="" border='0'  height="10" width="10" src="../images/lead.gif" /></td>
								<td width="25%" class="grid1" height="28"><?=$nlead?></td>
								<td width="25%" class="grid1"   height="28"><?=$currSymbol?><?=round($lead,2)?></td>
							</tr>
							<tr>
								<td width="25%" class="grid1"  height="28">Sales&nbsp;<img
									alt="" border='0' height="10" width="10" src="../images/sale.gif" /></td>
								 <td width="25%" class="grid1"  height="28"><?=$nsale?></td>
								 <td width="25%" class="grid1"  height="28"><?=$currSymbol?><?=round($sale,2)?></td>
							</tr>
						</table>
					 <br/>
					 </td>
				</tr>
			</table> <? viewRawTrans($rawClick, $rawImp) ?>
		</td>

	<?php
	
	include 'calender.php';
	$d=$_GET['d'];
	$m=$_GET['m'];
	$y=$_GET['y'];
	
	//adding calender
	
	class MyCalendar1 extends Calendar
	{
		function getCalendarLink($month, $year)
		{
			$s = getenv('SCRIPT_NAME');
			$act        =$_GET['Action'];
	
			$qry="?";
			$sep="" ;
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
	if ($month == ""){      
		$month = date("m");
	}
	if ($year == ""){
	    $year = date("Y");
	}
	$cal1 = new MyCalendar1($id);
	echo $cal1->getMonthView($month, $year);
	?>
		</td>
	</tr>
</table><br/>