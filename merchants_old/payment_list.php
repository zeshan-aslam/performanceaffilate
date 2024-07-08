<?php

	$flag 		=$_GET['flag'];
    $id			=$_SESSION['MERCHANTID'];
    $name		=$_SESSION['MERCHANTNAME'];
    $cfrom      =trim($_POST['txtfrom']);          //from date
    $cto        =trim($_POST['txtto']);            //to date
    $sub        =trim($_POST['sub']);              //submit button

    $page       =intval(trim($_GET['page']));
	 if(empty($page))                                 //getting page no
	 $page=$partners->getpage();


    if(!empty($sub))
    {
   	 if((!$partners->is_date($cfrom) || !$partners->is_date($cto)) )
	    {

	    }
	    else
	    {
	        $From                     =$partners->date2mysql($cfrom);  //changing date format
	        $To                       =$partners->date2mysql($cto);
	        $msg                      ="";
	    }
    }



   //geting records from affiliate table
   $sql ="select *,date_format(transaction_dateofpayment,'%d-%M-%y') as date from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id and joinpgm_merchantid='$id' and transaction_dateofpayment <> '0000-00-00'  and transaction_status <> 'pending' ";
   if(!empty($From)&& !empty($To)) $sql .=" and transaction_dateofpayment between '$From' and '$To'";

   $sql	.="ORDER BY transaction_dateofpayment DESC ";


   $topage1 =$sql;
   $sql  .=" LIMIT ".($page-1)*$lines.",".$lines;

   $ret =mysqli_query($con,$sql);

   $sql	= " select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_merchant 
   			where merchant_id=adjust_memberid and  adjust_flag like 'm'  and adjust_memberid = '$id' ";
   if(!empty($From)&& !empty($To)) $sql .=" and adjust_date between '$From' and '$To'";
   $sql .= " order by adjust_date desc ";
   $topage2    =$sql;
   $sql  .=" LIMIT ".($page-1)*$lines.",".$lines;
   $ret1 =mysqli_query($con,$sql);

    echo mysqli_error($con);


    $sql22      =$topage1;
    $res        =mysqli_query($con,$sql22);
    $num1=mysqli_num_rows($res);

    $sql33      =$topage2;
    $res        =mysqli_query($con,$sql33);
    $num2=mysqli_num_rows($res);

?>

<script language="javascript" type="text/javascript">
        function from_date()
        {
         gfPop.fStartPop(document.trans.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.trans.txtto,Date);
        }
</script>

<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
 <br/>
<form name="trans" method="post" action="" >
  <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr1"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2"  align="center">
             <?=$lang_report_stat?></td>
         </tr>
         <tr>
            <td  height="19" colspan="2"  align="center" class="red"></td>
         </tr>
         <tr>
            <td  height="19" colspan="2"  align="center">
            <?=$lang_report_forperiod?></td>
         </tr>
         <tr>
            <td width="49%" height="24" align="center">&nbsp; <?=$lang_report_from?></td>
            <td width="51%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$cfrom?>" onfocus="javascript:from_date();return false;" />
            </td>
        </tr>
        <tr>
            <td width="49%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
            <td width="51%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$cto?>"  onfocus="javascript:to_date();return false;" />
            </td>
        </tr>
        <tr>
            <td height="23" colspan="2">&nbsp;</td>
        </tr>
       <tr>
           <td colspan="2" align="center" height="26">
           <input type="submit" name="sub" value="<?=$lang_report_view?>" /></td>
      </tr>
  </table>
</form>
  <br/>
   <?
     //checking for each records

     if(mysqli_num_rows($ret)>0)
     {

   ?>
<table width="90%" class="tablebdr" align="center">
     <tr>
         <td height="18" class="sphead" colspan="5" align="center">
              <?=$lang_PaymentHistory2?> </td>
     </tr>
   	 <tr >
         <td height="18" class="tdhead"><?=$affiliate_name?></td>
         <td height="18" class="tdhead"><?=$lang_pay_list_pgm?></td>
         <td height="18" class="tdhead"><?=$affiliate_date?></td>
         <td height="18" class="tdhead"><?=$affiliate_transaction?></td>
         <td height="18" class="tdhead"><?=$affiliate_amount?></td>
    </tr>

<?

             while($row=mysqli_fetch_object($ret))
             {
                  //geting records from table
                  $sql2 ="select * from partners_affiliate where affiliate_id = '$row->joinpgm_affiliateid'";
                  $ret2 =mysqli_query($con,$sql2);
                  if(mysqli_num_rows($ret2)>0)
                  {
                  	$row2=mysqli_fetch_object($ret2);
                    $affiliate=stripslashes($row2->affiliate_company);
                  }

                 if ($row->transaction_status=='reversed')
                         $image      =	"<img src='../images/reversesale.gif' height='15' width='15' alt='' />";
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
     <tr class="<?=$classid?>">

     	<td height="15"> <?=$affiliate?> </td>
        <td height="15"> <a href="index.php?Act=programs&mode=editprogram&programId=<?=$row->joinpgm_programid?>"><?=$lang_pay_list_view?></a> </td>
        <td height="15"><?=$row->date?>  </td>
        <td height="15"><?=$row->transaction_type?><?=$image?></td>

        <td height="15"><strong>&nbsp;<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border="0" />&nbsp;&nbsp;<?=$currSymbol?>

         <?
                $date = $row->transaction_dateofpayment;
                if($row->transaction_status=="reversed")
                {
                        $affAmnt      =   $row->transaction_amttobepaid;
                        $adminAmnt    =   $row->transaction_subsale;

                        # converting to user currency
                        if($currValue != $default_currency_caption){
                              $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                              $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                         }

                    echo $affAmnt + $adminAmnt;
                }
                else
                {
                        $affAmnt      =   $row->transaction_amttobepaid;
                        $adminAmnt    =   $row->transaction_admin_amount;

                        # converting to user currency
                        if($currValue != $default_currency_caption){
                              $affAmnt     =   getCurrencyValue($date, $currValue, $affAmnt);
                              $adminAmnt   =   getCurrencyValue($date, $currValue, $adminAmnt);
                         }

                     echo $affAmnt + $adminAmnt;

                }

         ?>
		 </strong></td>
     </tr>

<?			}
            ?>
</table>

  <?
     }
     ?>

     <?

   if(mysqli_num_rows($ret1)>0)
   {
   ?>
   <br/>
    <table width="90%" class="tablebdr" align="center">
        <tr>
            <td colspan="4" align="center" class="sphead">    <?=$lang_PaymentHistory1?>
            </td>
        </tr>
        <tr >
             <td height="18" class="tdhead" align="center"><?=$affiliate_merchant?></td>
             <td height="18" class="tdhead" align="center"><?=$affiliate_date?></td>
             <td height="18" class="tdhead" align="center"><?=$affiliate_transaction?></td>
             <td height="18" class="tdhead" align="center"><?=$affiliate_amount?></td>
        </tr>
   <?
           while($row=mysqli_fetch_object($ret1))
           {

                 $affiliate	    =trim(stripslashes($row->merchant_company));
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

	    <tr class="<?=$classid?>" >
	        <td height="15" align="left"><?=$affiliate?>
	        </td>
	        <td height="15" align="left"><?=$date?> </td>

	        <td height="15"  align="left">
<?

                     switch ($row->adjust_action) {
                       case "add":

                       echo "<img src='../images/add.gif' width='10' height='10' alt='addd' border='0' /> &nbsp;&nbsp;Deposited To Your Account By admin";

                         break;
                       case "deduct":

                           echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;&nbsp;Withdrawed From Your Account";


                         break;
                       case "paidmail ":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;&nbsp;Charged For Paid Mail";

                         break;

                       case "programFee":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;&nbsp;Program Fee";

                         break;

                      case "register":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />&nbsp;&nbsp;Membership Fee";

                         break;

                       case "deposit":

                       	   echo	"<img src='../images/add.gif' width='10' height='10' alt='addd' border='0' />&nbsp;&nbsp;Deposited To Clients  Account ";

                         break;

                     }
?>
                     </td>
                     <td height="15"align="left"><strong>
<?

                     switch ($row->adjust_action) {
                       case "add":

                       echo "<img src='../images/add.gif' width='10' height='10' alt='addd' border='0' /> ";

                         break;
                       case "deduct":

                           echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />";


                         break;
                       case "paidmail":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />";

                         break;

                         case "programFee":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />";

                         break;

                        case "register":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0' />";

                         break;

                       case "deposit":

                       	   echo	"<img src='../images/add.gif' width='10' height='10' alt='addd' border='0' />";

                         break;

                     }


                  $Amnt = $row->adjust_amount;
                  $date = $row->adjust_date;
                  if($currValue != $default_currency_caption){
	                 $Amnt     =   getCurrencyValue($date, $currValue, $Amnt);
	             }
                 echo " ".$currSymbol." ".$Amnt;
?>
                     </strong></td>
    				</tr>
                   <?

            }
                 ?>
</table>
      <?
            }

           if(($num1+$num2)>0)
           {

			if($num1>$num2)
            {
               $pgsql=	$topage1;
            }
            else
            {
			  $pgsql=	$topage2;
            }


	       $url    ="index.php?Act=paymentlist";    //adding page nos
	       include '../includes/show_pagenos.php';
          }
          else
          {
           	echo "<div align='center' class='textred'>$norec</div>";
          }


      ?>