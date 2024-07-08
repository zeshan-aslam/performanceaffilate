<?php
	$flag 		=$_GET['flag'];
	$id			=intval($_GET['merid']);
	$cfrom      =trim($_POST['txtfrom']);          //from date
	$cto        =trim($_POST['txtto']);            //to date
	$sub        =trim($_POST['sub']);              //submit button
	$page       =intval(trim($_GET['page']));

    if($_SERVER["REQUEST_METHOD"] == 'GET'){
	    $cfrom 	= $From      =trim($_GET['cfrom']);          //from date
	    $cto 	= $To        =trim($_GET['cto']);
    }

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
	if(!empty($From)&& !empty($To)) $date_con .=" and transaction_dateofpayment between '$From' and '$To'";
    if($date_con) $sql .= $date_con;
	$sql	.=" ORDER BY transaction_dateofpayment DESC ";
	$topage1 =$sql;
    $sql  .=" LIMIT ".($page-1)*$lines.",".$lines;
	$ret =mysqli_query($con,$sql);
    $date_con = "";

	// $ret =mysqli_query($con,$sql);
	$sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_merchant where merchant_id=adjust_memberid and  adjust_flag like 'm'  and adjust_memberid='$id' ";
	if(!empty($From)&& !empty($To)) $date_con .=" and adjust_date between '$From' and '$To'";
    if($date_con) $sql .= $date_con;
    $sql .= " order by adjust_date desc ";
	$topage2 = $sql;

    //to add limit when records > 10
  //  $countsql = "select COUNT(*) AS c FROM partners_adjustment,partners_merchant where merchant_id=adjust_memberid and  adjust_flag like 'm'  and adjust_memberid=$id ";
   // if($date_con) $countsql .= $date_con;

	$sql  .=" LIMIT ".($page-1) * $lines.",".$lines;
	$ret1 =mysqli_query($con,$sql);


	echo mysqli_error($con);
	$sql22		=$topage1;
	$res		=mysqli_query($con,$sql22);
	$num1=mysqli_num_rows($res);
	$sql33      =$topage2;
	$res        =mysqli_query($con,$sql33);
	$num2=mysqli_num_rows($res);
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
<iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">

</iframe>
 <br/>
<form name="trans" method="post" action="">
  <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr"  width="50%" align="center">
		 <tr>
			 <td width="100%"  height="19" class="tdhead" colspan="2">
			 Statistics for Custom Period</td>
		 </tr>
         <tr>
            <td width="100%"  height="19" colspan="2">
            </td>
         </tr>
         <tr>
            <td width="39%"  height="19" colspan="2">
            For Period</td>
         </tr>
         <tr>
            <td width="50%" height="24" align="center">&nbsp; From Date</td>
            <td width="50%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$cfrom?>" onfocus="javascript:from_date();return false;" /></td>
        </tr>
        <tr>
            <td width="50%" height="24" align="center">&nbsp;&nbsp;&nbsp; To Date</td>
            <td width="50%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$cto?>"  onfocus="javascript:to_date();return false;" /></td>
        </tr>
        <tr>
            <td  height="23"  colspan="2">&nbsp;</td>
        </tr>
       <tr>
           <td align="center"  colspan="2" height="26">
           <input type="submit" name="sub"  value="View" /></td>
      </tr>
  </table>
  </form>
  <br/>
<table width="90%" class="tablebdr" align="center">
<?
     //checking for each records
     if(mysqli_num_rows($ret)>0)
     {
?>
     <tr>
	 <td height="18" class="textred" colspan="5" align="center">Account Details ( Related To Transaction )</td>
	 </tr>
   	<tr>
        			 <td height="18" class="tdhead">Merchant</td>
                     <td height="18" class="tdhead">Affiliate</td>
       				 <td height="18" class="tdhead">Date Of Payment</td>
        			 <td height="18" class="tdhead">Transaction</td>
                     <td height="18" class="tdhead">Amount</td>
    </tr>
<?
	    while($row=mysqli_fetch_object($ret))
	    {

	        //geting records from table
	        $sql2 ="select * from partners_affiliate where affiliate_id='$row->joinpgm_affiliateid'";
	        $ret2 =mysqli_query($con,$sql2);
	        if(mysqli_num_rows($ret2)>0)
	        {
	            $row2=mysqli_fetch_object($ret2);
	            $affiliate=stripslashes($row2->affiliate_firstname)." ".stripslashes($row2->affiliate_lastname);
	        }
	        if ($row->transaction_status=='reversed')
	            $image      =  "<img src='../images/reversesale.gif' height='15' width='15' alt='' />";
	        else
	            $image       ="<img src='../images/".$row->transaction_type.".gif' height='10' width='10' alt='' />";
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
       				 <td height="15"><?=$name?></td>
                     <td height="15"> <?=$affiliate?> </td>
       				 <td height="15"><?=$row->date?>  </td>
        			 <td height="15"><?=$row->transaction_type?><?=$image?></td>
                     <td height="15"><strong>&nbsp;<?=$currSymbol?>&nbsp;<?= number_format(($row->transaction_amttobepaid + $row->transaction_admin_amount),2) ?>
                     </strong></td>
    				</tr>
<?
		}
?>
		</table>
<?
	}
	if(mysqli_num_rows($ret1)>0)
	{
?>
   <br/>
	    <table width="90%" class="tablebdr" align="center">
	        <tr>
	                        <td colspan="4" align="center" class="textred">Account Details ( Withdrawn / Deposited )</td>
	        </tr>
	        <tr >
                             <td height="18" class="tdhead" align="center">Merchant</td>
       				 		 <td height="18" class="tdhead" align="center">Date Of Payment</td>
        			 		 <td height="18" class="tdhead" align="center">Transaction</td>
                     		 <td height="18" class="tdhead" align="center">Amount</td>
	        </tr>
   <?
	    while($row=mysqli_fetch_object($ret1))
	    {
	        $affiliate     =trim(stripslashes($row->merchant_firstname))." ".trim(stripslashes($row->merchant_lastname));
	        $date          =$row->DATE;
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
	        switch ($row->adjust_action)
	        {
	            case "add":
	                echo "<img src='../images/add.gif' width='10' height='10' alt='addd' border=0 /> &nbsp;&nbsp;Deposited To Your Account By admin";
	                break;
	            case "deduct":
	                echo "<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border=0 />&nbsp;&nbsp;Withdrawed From Your Account";
	                break;
	            case "paidmail":
	                echo "<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border=0 />&nbsp;&nbsp;Charged For Paid Mail";
	                break;
	            case "deposit":
	                echo "<img src='../images/add.gif' width='10' height='10' alt='addd' border=0 />&nbsp;&nbsp;Deposited To Clients  Account ";
	                break;
	        }
?>
                     </td>
                     <td height="15"align="left"><strong>
                     &nbsp;<?=$currSymbol?>&nbsp;<?=number_format($row->adjust_amount,2)?></strong>
                     </td>
    				</tr>
                   <?
		} ?>
</table>
<?	}	?>

      <?
	if(($num1+$num2)>0)
	{
	    if($num1>$num2)
	    {
		    $pgsql=  $topage1;
	    }
	    else
	    {
		    $pgsql=   $topage2;
	    }
	    $url    ="index.php?Act=payment_merchant&merid=$id&cfrom=$From&cto=$To";    //adding page nos
	    include '../includes/show_pagenos.php';
	}
	else
	{
		echo "<div align='center' class='textred'>$norec</div>";
	}
      ?>