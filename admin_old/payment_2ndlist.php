<?php
    $cfrom      =trim($_POST['txtfrom']);          //from date
    $cto        =trim($_POST['txtto']);            //to date
    $sub        =trim($_POST['sub']);              //submit button

    if(empty($page))                               //getting page no
        $page        =$partners->getpage();
    if(empty($cfrom))
       $cfrom      =trim($_GET['txtfrom']);          //from date

    if(empty($cto))
       $cto        =trim($_GET['txtto']);            //to date
    if((!$partners->is_date($cfrom) || !$partners->is_date($cto)) )
	    {

	    }
	    else
	    {
	        $From                     =$partners->date2mysql($cfrom);  //changing date format
	        $To                       =$partners->date2mysql($cto);
	        $msg                      ="";
	    }


    $flag 		=$_GET['flag'];
    $id			=$_SESSION['AFFILIATEID'];
    $name		=$_SESSION['AFFILIATENAME'];

   //geting records from table
   $sql ="select * from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id and joinpgm_affiliateid='$id' and transaction_amountpaid>0 ";

   $ret =mysql_query($sql);


   //geting records from table
   $sql1 ="select *,date_format(transaction_subsaledate,'%d-%M-%y') as date from partners_transaction,partners_joinpgm  where   transaction_joinpgmid=joinpgm_id and transaction_subsalepaid>0 ";
   if(!empty($From)&& !empty($To)) $sql1 .=" and transaction_subsaledate between '$From' and '$To' ";
   $pgsql	=$sql1;
   $sql1  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
   $ret1 =mysql_query($sql1);


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
             <td height="19" class="tdhead" colspan="2" >
             <p align="center">Statistics For Custom Period</td>
         </tr>
         <tr>
            <td height="19" colspan="2" >
            <p align="center" class="red"></td>
         </tr>
         <tr>
            <td height="19" colspan="2" >
            <p align="center" ></td>
         </tr>
         <tr>
            <td width="40%" height="24" align="center">&nbsp; From</td>
            <td width="60%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$cfrom?>" onfocus="javascript:from_date();return false;"></td>
        </tr>
        <tr>
            <td width="40%" height="24" align="center">&nbsp;&nbsp;&nbsp; To</td>
            <td width="60%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$cto?>"  onfocus="javascript:to_date();return false;"></td>
        </tr>
        <tr>
            <td width="35%" height="23">&nbsp;</td>
        </tr>
       <tr>
           <td colspan="2" align="center" height="26">
           <input type="submit" name="sub" title="<?=$lang_report_view?>" value="view"></td>
      </tr>
  </table>
  </form>
<br/>
   <?



    if(mysql_num_rows($ret1)>0)
     {
     ?>
     <br/>
        <table width="90%" class="tablebdr" align="center">
   	<tr >
        			 <td height="25" class="tdhead">Affiliate</td>
                     <td height="25" class="tdhead">Merchant</td>
       				 <td height="25" class="tdhead">Date Of Payment</td>
        			 <td height="25" class="tdhead">Transaction</td>
                     <td height="25" class="tdhead">Amount</td>


    </tr>

     <?
             while($row1=mysql_fetch_object($ret1))
             {
                 //geting records from table
                  $sql2 ="select * from partners_merchant where merchant_id='$row1->joinpgm_merchantid'";
                  $ret2 =mysql_query($sql2);
                  if(mysql_num_rows($ret2)>0)
                  {
                  	$row2=mysql_fetch_object($ret2);
                    $merchant=stripslashes($row2->merchant_firstname)." ".stripslashes($row2->merchant_lastname);
                  }

                  $sql3 ="select * from partners_affiliate where affiliate_id='$row1->transaction_parentid'";
                  $ret3 =mysql_query($sql3);
                  if(mysql_num_rows($ret3)>0)
                  {
                  	$row3=mysql_fetch_object($ret3);
                    $affiliate=stripslashes($row3->affiliate_firstname)." ".stripslashes($row3->affiliate_lastname);
                  }


                 if ($row1->transaction_status=='reversed')
                         $image      =	"<image src='../images/reversesale.gif' height='15' width='15'>";
                  else   $image		 ="";
                 ?>
                 	<tr>
       				 <td height="25"><?=$affiliate?></td>
                     <td height="25"> <?=$merchant?> </td>
       				 <td height="25"><?=$row1->date?>  </td>
        			 <td height="25"><?=$row1->transaction_type?><?=$image?></td>
                     <td height="25"> <?=$row1->transaction_subsalepaid?> </td>
    				</tr>

                 <?

              }
      ?>  	<tr>
                     <td height="25" colspan="5" align="right"><?
                $url    ="index.php?Act=payment_2ndlist&txtto=$cto&txtfrom=$cfrom";    //adding page nos
                include '../includes/show_pagenos.php';
				?></td></tr> </table>         <?    } else
      {
      ?><p class="textred" align="center">No  Payments</p><?}?>