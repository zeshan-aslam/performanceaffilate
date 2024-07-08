<?php

    $flag 		=$_GET['flag'];
    $id			=intval($_GET['affid']);


    $cfrom      =trim($_POST['txtfrom']);          //from date
    $cto        =trim($_POST['txtto']);            //to date
    $page       =intval(trim($_GET['page']));
	 if(empty($page))                                 //getting page no
	 $page=$partners->getpage();

    if(!$partners->is_date($cfrom) || !$partners->is_date($cto) )
    {

    }
    else
    {
   		$From                     =$partners->date2mysql($cfrom);  //changing date format
   		$To                       =$partners->date2mysql($cto);
    }

   //geting records from table

   $sql ="select *,date_format(transaction_dateofpayment,'%d-%M-%y') as date from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id and joinpgm_affiliateid='$id' and transaction_dateofpayment <> '0000-00-00'  and transaction_status <> 'pending' ";
   if(!empty($From)&& !empty($To)) $sql .=" and transaction_dateofpayment between '$From' and '$To' ";
   $sql .=" ORDER BY transaction_dateofpayment DESC ";

   $topage1 =$sql;
   $sql  .="LIMIT ".($page-1)*$lines.",".$lines;



   $ret =mysqli_query($con,$sql);

   $num1	=mysqli_num_rows($ret);


    $flag='a';
    $member="affiliate";


   $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_$member where affiliate_id  = adjust_memberid  and  adjust_flag like '$flag' and adjust_memberid='$id' ";
   if(!empty($From)&& !empty($To)) $sql .=" and adjust_date between '$From' and '$To' ";
   $sql .= " order by adjust_date desc ";
        $topage2    =$sql;
     $sql  .="LIMIT ".($page-1)*$lines.",".$lines;

  //   echo $sql;

            $sql22		=$topage1;
            $res		=mysqli_query($con,$sql22);
            $num1=mysqli_num_rows($res);

	        $sql33      =$topage2;
	        $res        =mysqli_query($con,$sql33);
            $num2=mysqli_num_rows($res);

    $ret1 =mysqli_query($con,$sql);
    $rcount  =$num1+$num2;
    echo mysqli_error($con);
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
<iframe width=168 height=175 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
 <br/>
<form name="trans" method="POST" action="">
  <table border='0' cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2" >
             <p align="center">Statistics For Period</td>
         </tr>
         <tr>
            <td  height="19" colspan="2" >
            <p align="center" class="red"></td>
         </tr>
         <tr>
            <td  height="19" colspan="2" >
            <p align="center" >For Period</td>
         </tr>
         <tr>
            <td width="45%" height="24" align="center">&nbsp; From</td>
            <td width="55%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$cfrom?>" onfocus="javascript:from_date();return false;"></td>
        </tr>
        <tr>
            <td width="45%" height="24" align="center">&nbsp;&nbsp;&nbsp; To</td>
            <td width="55%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$cto?>"  onfocus="javascript:to_date();return false;"></td>
        </tr>
        <tr>
            <td  height="23" colspan="2">&nbsp;</td>
        </tr>
       <tr>
           <td colspan="6" align="center" height="26">
           <input type="submit" name="sub" title="<?=$lang_report_view?>" value="view"></td>
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
	                        <td colspan="5" align="center" class="textred">  Transaction History
	                        </td>
	        </tr>
   	<tr >
                      <td height="18" class="tdhead">Affiliate </td>
                     <td height="18" class="tdhead">Merchant</td>
       				 <td height="18" class="tdhead">Date </td>
        			 <td height="18" class="tdhead">Transaction</td>
                     <td height="18" class="tdhead">Amount</td>


    </tr>

<?

             while($row=mysqli_fetch_object($ret))
             {
                  //geting records from table
                  $sql2 ="select * from partners_merchant where merchant_id='$row->joinpgm_merchantid'";
                  $ret2 =mysqli_query($con,$sql2);

                  if(mysqli_num_rows($ret2)>0)
                  {
                  	$row2=mysqli_fetch_object($ret2);
                    $merchant=stripslashes($row2->merchant_firstname)." ".stripslashes($row2->merchant_lastname);
                  }

                  $sql2 ="select * from partners_affiliate where affiliate_id='$row->joinpgm_affiliateid'";
                  $ret2 =mysqli_query($con,$sql2);

                  if(mysqli_num_rows($ret2)>0)
                  {
                  	$row2=mysqli_fetch_object($ret2);
                    $affiliate=stripslashes($row2->affiliate_firstname)." ".stripslashes($row2->affiliate_lastname);
                  }

                 if ($row->transaction_status=='reversed')
                         $image      =	"<image src='../images/reversesale.gif' height='10' width='10'>";
                  else   $image		 ="<image src='../images/".$row->transaction_type.".gif' height='10' width='10'>";



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
                 	<tr class=<?=$classid?> >
       				 <td height="15"><?=$affiliate?></td>
                     <td height="15"><?=$merchant?> </td>
       				 <td height="15"><?=$row->date?>  </td>
        			 <td height="15"><?=$image?>&nbsp;&nbsp;<?=$row->transaction_type?></td>
                     <td height="15"><b>&nbsp;<?=$currSymbol?>&nbsp;<?= number_format($row->transaction_amttobepaid,2) ?> </b></td>
    				</tr>

<?

			}

              ?>   </table>

  <?
     }
   if(mysqli_num_rows($ret1)>0)
   {
   ?>
   <br/>
	    <table width="90%" class="tablebdr" align="center">
	        <tr>
	                        <td colspan="4" align="center" class="textred"> Payment History
	                        </td>
	        </tr>
	        <tr >               <td height="18" class="tdhead" align="center">Affiliate</td>
       				 		 <td height="18" class="tdhead" align="center">Date Of Payment</td>
        			 		 <td height="18" class="tdhead" align="center">Transaction</td>
                     		 <td height="18" class="tdhead" align="center">Amount</td>


	        </tr>
   <?
           while($row=mysqli_fetch_object($ret1))
           {     $firstname     =$member."_firstname";
                 $lastname		=$member."_lastname";
                 $affiliate	    =trim(stripslashes($row->$firstname))." ".trim(stripslashes($row->$lastname));
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
  <tr class=<?=$classid?>>
                     <td height="15" align="center"><?=$affiliate?></td>
                     <td height="15" align="center"><?=$date?> </td>

        			 <td height="15"  align="left">&nbsp;
<?

                     switch ($row->adjust_action)
                     {

                       case "add":

                       echo "<img src='../images/add.gif' width='10' height='10' alt='addd' border='0'>&nbsp;Deposited To Your Account";

                         break;
                       case "deduct":

                           echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'>&nbsp;Admin Withdrawed From Your Account";

                         break;
                       case "paidmail":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'>&nbsp;Charged For Paid Mail";
                                   break;

                       case "withdraw":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'>&nbsp;Withdrawed From Your Account";

                         break;

                     }


?>



                     </td>
                     <td height="15" align="left"><b>&nbsp;<?=$currSymbol?>&nbsp;<?=number_format($row->adjust_amount,2)?></b> </td>
		  </tr>
                   <?

            }

      ?>
</table>
      <?

        }

         if($rcount>0){
			if($num1>$num2)
            {
               $pgsql=	$topage1;
            }
            else
            {
			  $pgsql=	$topage2;
            }


	       $url    ="index.php?Act=payment_affiliate&affid=$id";    //adding page nos
	       include '../includes/show_pagenos.php';



       }else
                  {
      ?><p class="textred" align="center"><?=$norec?></p><?}?>