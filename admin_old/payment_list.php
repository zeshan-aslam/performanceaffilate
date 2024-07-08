<?php
	$flag		= $_GET['flag'];
	$cfrom      = trim($_POST['txtfrom']);        
	$cto        = trim($_POST['txtto']);    
	$page       = intval(trim($_GET['page']));
	if(empty($page)) 
		$page	= $partners->getpage();
	if(!$partners->is_date($cfrom) || !$partners->is_date($cto) ){
	
	}
	else{
		$From                     =$partners->date2mysql($cfrom);  //changing date format
		$To                       =$partners->date2mysql($cto);
	}
	

   //geting records from table
// $sql ="select *,date_format(transaction_dateofpayment,'%d-%M-%y') as date from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id and joinpgm_affiliateid='$id' and transaction_dateofpayment <> '0000-00-00'  and transaction_status <> 'pending' ";

   $sql ="select *,date_format(transaction_dateofpayment,'%d-%M-%y') as date from partners_affiliate,partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id and transaction_dateofpayment <> '0000-00-00' and transaction_status <> 'pending' AND joinpgm_affiliateid =affiliate_id ";
   if(!empty($From)&& !empty($To)) $sql .=" and transaction_dateofpayment between '$From' and '$To' ";
   $sql .=" ORDER BY transaction_dateofpayment DESC ";

   $topage1 =$sql;
   $sql  .="LIMIT ".($page-1)*$lines.",".$lines;
   $ret =mysqli_query($con,$sql);

//----------------------------------------------------------------

    $flag='a';
    $member="affiliate";

//   $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_$member where    affiliate_id  = adjust_memberid  and  adjust_flag like '$flag' and adjust_memberid=$id ";
   $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_$member where adjust_flag like '$flag' and adjust_memberid=affiliate_id ";
   if(!empty($From)&& ! empty($To)) $sql .=" and adjust_date between '$From' and '$To' ";
   $sql .= " order by adjust_date desc ";
   $topage2    =$sql;
   $sql  .="LIMIT ".($page-1)*$lines.",".$lines;

    $ret1 =mysqli_query($con,$sql);


//-------------------------------------------------------------

   $flag='m';
  // $member="merchant";

//   $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_merchant  where    merchant_id  = adjust_memberid  and  adjust_flag like '$flag' and adjust_memberid=$id ";
   $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_merchant  where   adjust_flag like '$flag' and adjust_memberid=merchant_id ";
   if(!empty($From)&& !empty($To)) $sql .=" and adjust_date between '$From' and '$To' ";
   $sql .= " order by adjust_date desc ";
   $topage3    =$sql;


   $sql  .="LIMIT ".($page-1)*$lines.",".$lines;

   $ret20 =mysqli_query($con,$sql);

   echo mysqli_error($con);

//-----------------------------------------------------------


  //   echo $sql;

            $sql22		=$topage1;
            $res		=mysqli_query($con,$sql22);
            $num1=mysqli_num_rows($res);

	        $sql33      =$topage2;
	        $res        =mysqli_query($con,$sql33);
            $num2=mysqli_num_rows($res);

	        $sql44      =$topage3;
	        $res        =mysqli_query($con,$sql44);
            $num3		=mysqli_num_rows($res);




    $rcount  =$num1+$num2+$num3;
    echo mysqli_error($con);


?>
<script type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.trans.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.trans.txtto,Date);
        }
</script>


<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
 <br/>
<form name="trans" method="post" action="">
  <table border='0' cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead heading-3" colspan="3" >&nbsp;Statistics For Custom Period</td>
         </tr>
         <tr>
            <td  height="19" colspan="3" >            </td>
         </tr>
         <tr>
            <td  height="19" colspan="3" >
            <?=$lang_report_forperiod?></td>
         </tr>
         <tr>
            <td width="40%" height="24" align="center">&nbsp;From Date </td>
            <td colspan="2" align="left"><input type="text" name="txtfrom" size="18" value="<?=$cfrom?>" onfocus="javascript:from_date();return false;" />           </td>
        </tr>
         <tr>
           <td colspan="4" align="center">&nbsp;</td>
         </tr>
        <tr>
            <td width="40%" height="24" align="center">&nbsp;&nbsp;&nbsp; To Date </td>
            <td colspan="3" align="left"><input type="text" name="txtto" size="18" value="<?=$cto?>"  onfocus="javascript:to_date();return false;" /></td>
        </tr>
        <tr>
          <td colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td width="40%" colspan="3" align="center" height="23"><input type="submit" name="sub"  value="View" /></td>
        </tr>
       <tr>
           <td colspan="3" height="26">&nbsp;           </td>
      </tr>
  </table>
</form>
  <br/>
<?
       //checking for each records

     if(mysqli_num_rows($ret)>0)
     {

   ?>
   <table width="95%" class="tablebdr" align="center">
     <tr >
       <td height="18" colspan="7" class="heading-2" style="text-align:center">Admin's Account Details </td>
     </tr>
     <tr >
       <td height="18" class="tdhead" align="center" >Affiliate </td>
       <td height="18" class="tdhead" align="center" >Merchant </td>
        <td height="18" class="tdhead" align="center" >PGM</td>
       <td height="18" class="tdhead" align="center">Date</td>
       <td height="18" class="tdhead" align="center" >Transaction</td>
       <td height="18" class="tdhead" align="center">To Affiliate </td>
       <td height="18" class="tdhead" align="center">To Admin</td>
     </tr>
     <?

             while($row=mysqli_fetch_object($ret))
             {
                  //geting records from table
                  $sql2 ="select * from partners_merchant where merchant_id='$row->joinpgm_merchantid'";
                  $ret2 =mysqli_query($con,$sql2);

                  $name	=$row->affiliate_company ;


                  if(mysqli_num_rows($ret2)>0)
                  {
                  	$row2=mysqli_fetch_object($ret2);
                    $affiliate=stripslashes($row2->merchant_company);
                  }

                 if ($row->transaction_status=='reversed')
                         $image      =	"<img src='../images/reversesale.gif' height='10' width='10' alt='' />";
                  else   $image		 ="<img src='../images/".$row->transaction_type.".gif' height='10' width='10' alt='' />";

	        $gridcounter++;
	        if ($gridcounter%2==1)
	        {
	        $classid="grid1";
	        }
	        else
	        {

	        	$classid="grid2";

	        }

                 ?>
     <tr class="<?=$classid?>" >
       <td height="15" <?= ( ($row->transaction_status=='reversed') ? "class ='stroke' ":""   ) ?>><?=$name?></td>
       <td height="15"  <?= ( ($row->transaction_status=='reversed') ? "class ='stroke' ":""   ) ?> >  <?=$affiliate?>
       </td>
       <td height="15" <?= ( ($row->transaction_status=='reversed') ? "class ='stroke' ":""   ) ?> ><a href="index.php?Act=programs&amp;programId=<?=$row->joinpgm_programid?>">View</a>
       </td>
       <td height="15" <?= ( ($row->transaction_status=='reversed') ? "class ='stroke' ":""   ) ?> ><?=$row->date?>
       </td>
       <td height="15" <?= ( ($row->transaction_status=='reversed') ? "class ='stroke' ":""   ) ?> ><?=$image?>
   &nbsp;&nbsp;
         <?=$row->transaction_type?></td>
       <td height="15" <?= ( ($row->transaction_status=='reversed') ? "class ='stroke' ":""   ) ?>><b>&nbsp;<?=$currSymbol?>&nbsp;
             <?= round($row->transaction_amttobepaid,2) ?>
       </b></td>
       <td height="15" <?= ( ($row->transaction_status=='reversed') ? "class ='stroke' ":""   ) ?> ><b>&nbsp;&nbsp; <img src='../images/add.gif' width='10' height='10' alt='Add' border='0' />&nbsp;&nbsp;<?=$currSymbol?>&nbsp;
             <?= round($row->transaction_admin_amount,2) ?>
       </b></td>
     </tr>
     <?

			}

              ?>
   </table>
   <br/>
   <br/>
   <?
   }

   if(mysqli_num_rows($ret1)>0)
  {

   ?>
   <br/>
	    <table width="95%" class="tablebdr" align="center">
	        <tr>
	          <td colspan="4" align="center" class="heading-2" style="text-align:center">Affiliate Payments</td>
	        </tr>
	        <tr >
			 <td width="29%" height="18" align="center" class="tdhead">Affiliate</td>
			 <td width="21%" height="18" align="center" class="tdhead">Date</td>
			 <td width="37%" height="18" align="center" class="tdhead">Transaction</td>
			 <td width="13%" height="18" align="center" class="tdhead">Amount</td>
	        </tr>
   <?
           while($row=mysqli_fetch_object($ret1))
           {     $firstname     =$member."_firstname";
                 $lastname		=$member."_lastname";
                 $affiliate	    =trim(stripslashes($row->affiliate_company));
                 $affiliate     = ucwords(strtolower($affiliate));
                 $date			=$row->DATE;

	        $gridcounter++;
	        if ($gridcounter%2==1)
	        {
	        $classid="grid1";
	        }
	        else
	        {

	        $classid="grid2";

	        }


?>
  <tr class="<?=$classid?>">
                     <td height="15" align="left"><?=$affiliate?></td>
                     <td height="15" align="left"><?=$date?> </td>

        			 <td height="15"  align="left">&nbsp;
<?

                     switch ($row->adjust_action)
                     {

                       case "add":

                       echo "<img src='../images/add.gif' width='10' height='10' alt='addd' border='0' />&nbsp;Deposited To $affiliate Account";

                         break;
                       case "deduct":

                           echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;Admin Withdrawed From $affiliate Account";

                         break;
                       case "paidmail":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;Charged For Paid Mail";
                                   break;
                        case "programFee":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;&nbsp;Program Fee";

                         break;
                        case "register":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;&nbsp;Membership Fee";

                         break;
                       case "withdraw":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;Withdrawed From $affiliate Account";
                              break;

                       case "deposit":

                       	   echo	"<img src='../images/add.gif' width='10' height='10' alt='addd' border='0' />&nbsp;Withdrawed From $affiliate Account";
                              break;



                     }


?>



                     </td>
                     <td height="15" align="left"><b>&nbsp;<?=$currSymbol?>&nbsp;<?=round($row->adjust_amount,2)?></b> </td>
		  </tr>
                   <?

            }

      ?>
</table>
      <?

        }

?>

<?
	//------------------------------------------------------------------------
if(mysqli_num_rows($ret20)>0)
{

   ?>
   <br/>
	    <table width="95%" class="tablebdr" align="center">
	        <tr>
	                        <td colspan="4" class="heading-2" style="text-align:center"> Merchant Payments
	                        </td>
	        </tr>
	        <tr >
                             <td width="29%" height="18" align="center" class="tdhead">Merchant</td>
       				 		 <td width="21%" height="18" align="center" class="tdhead">Date</td>
        			 		 <td width="37%" height="18" align="center" class="tdhead">Transaction</td>
                     		 <td width="13%" height="18" align="center" class="tdhead">Amount</td>
	        </tr>
   <?
           while($row=mysqli_fetch_object($ret20))
           {     $firstname     ="merchant_firstname";
                 $lastname		="merchant_lastname";
                 $affiliate	    =trim(stripslashes($row->merchant_company));
                 $affiliate     = ucwords(strtolower($affiliate));
                 $date			=$row->DATE;

	        $gridcounter++;
	        if ($gridcounter%2==1)
	        {
	        $classid="grid1";
	        }
	        else
	        {

	        $classid="grid2";

	        }


?>
  <tr class="<?=$classid?>">
                     <td height="15" align="left"><?=$affiliate?></td>
                     <td height="15" align="left"><?=$date?> </td>

        			 <td height="15"  align="left">&nbsp;
<?

                     switch ($row->adjust_action)
                     {

                       case "add":

                       echo "<img src='../images/add.gif' width='10' height='10' alt='Add' border='0' />&nbsp;Deposited To $affiliate Account By Admin";

                         break;
                       case "deduct":

                           echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='Add' border='0' />&nbsp;Admin Withdrawed From $affiliate Account";

                         break;
                       case "paidmail":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='Add' border='0' />&nbsp;Charged For Paid Mail";
                                   break;
                        case "programFee":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='Add' border='0' />&nbsp;&nbsp;Program Fee";

                         break;
                         case "register":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='Add' border='0' />&nbsp;&nbsp;Membership Fee";

                         break;
                       case "withdraw":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='Add' border='0' />&nbsp;Withdrawed From $affiliate Account";

                         break;

                       case "deposit":

                       	   echo	"<img src='../images/add.gif' width='10' height='10' alt='Add' border='0' />&nbsp;Deposited  To $affiliate Account";

                         break;

                     }

?>
                     </td>
                     <td height="15" align="left"><b>&nbsp;<?=$currSymbol?>&nbsp;<?=round($row->adjust_amount,2)?></b> </td>
		  </tr>
                   <?

            }

      ?>
</table>
      <?




}

	//-----------------------------------------------------------------------------


			if($num1>$num2)
            {
                         if($num1>$num3)
                         $pgsql=	$topage1;
                         else
                         $pgsql=	$topage3;

            }
            else
            {
                         if($num2>$num3)
                         $pgsql=	$topage2;
                         else
                         $pgsql=	$topage3;
            }







        if(($num1+$num2+$num3)==0)
          {
      ?><p class="error" align="center"><?=$norec?></p><?}else{?>
         <table class="tablewbdr"><tr><td><?  $url    ="index.php?Act=payment_list";   
	       include '../includes/show_pagenos.php'; ?></td></tr></table><?}?>