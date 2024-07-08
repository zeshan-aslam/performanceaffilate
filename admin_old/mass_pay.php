<?
  $msg                        =$_GET['msg'];
  $page                        =$_GET['page'];
  if(empty($page))                              //getting page no
                $page        =$partners->getpage();


//        geting records from table
//  $sql ="select *,date_format(request_date,'%d-%M-%Y') AS DATE from partners_request,partners_affiliate where request_status like 'active' and affiliate_id=request_affiliateid order by request_date desc";

$sql        = "SELECT *, date_format( request_date, '%d-%b-%Y' ) AS DATE
                        FROM partners_request, partners_affiliate, affiliate_pay
                        WHERE  affiliate_id = request_affiliateid
                        AND      affiliate_id=pay_affiliateid
                        AND request_affiliateid= pay_affiliateid
                        AND request_status LIKE 'active'
                        GROUP BY request_id
                        ORDER BY request_date DESC  ";


  $pgsql=$sql;

  $sql  .=" LIMIT ".($page-1)*$lines.",".$lines; //adding page no
  $ret =mysql_query($sql);
  if(mysql_num_rows($ret)>0)
  {
        ?>
        <style type="text/css">
        <!--
        .style1 {
        color: #FF0000;
        font-weight: bold;
        }
        -->
        </style>

<br/>
<form action="#" method="post" name="requestForm">
<table width="90%" align="center" class="tablebdr">

        <tr>
        <td width="21%" height="21" align="center" class="tdhead"> Affiliate </td>
        <td width="22%" align="center" class="tdhead">With Draw Amount</td>
        <td width="20%" align="center" class="tdhead">Current Balance </td>
        <td width="16%" height="21" align="center" class="tdhead"> Gateway</td>
        <td width="16%" height="21" align="center" class="tdhead"> Date</td>
        <td height="21" align="center" class="tdhead">Delete</td>
        <td height="21" align="center" class="tdhead">Pay</td>
        </tr>
    <tr>
      <td height="20" colspan="6" align="center" class="style1"><strong><?=$msg?></strong></td>
    </tr>
     <?
     while($row=mysql_fetch_object($ret))
     {
      $affiliate        = trim(stripslashes($row->affiliate_firstname))." ".trim(stripslashes($row->affiliate_lastname));
      $date             = $row->DATE;
      $status           = $row->request_status;
      $amount           = $row->request_amount;

      $balance          = $row->pay_amount;

      $request_id       = $row->request_id;
      $affiliateid      = $row->request_affiliateid ;

      $sqlGate			= " SELECT bankinfo_modeofpay as payGate FROM partners_bankinfo WHERE bankinfo_affiliateid = '$affiliateid' ";
      $retGate			= mysql_query($sqlGate);


      if(mysql_num_rows($retGate)>0){
      	$rowGate	=  mysql_fetch_object($retGate);
        $payGate	= stripslashes(trim($rowGate->payGate));
      }

      $url              = "payment_process.php?affiliateid=$affiliateid&request_id=$request_id&amount=$amount";


      if(($balance-$amount)<0)
      {

                   //   echo ($balance-$amount)." Delete ".$request_id." <br/>";

                $sql                ="DELETE FROM partners_request where request_id='$request_id'";
                $res                =mysql_query($sql);
                echo mysql_error();



      }
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
        <td height="21" align="left"> <?if($payGate=="Paypal"){?><input type="checkbox" name="elements[]" value="<?=$row->request_id?>"><<?}?>&nbsp;&nbsp;<?=$affiliate?>  </td>
        <td align="center"><strong>$<?=$amount?></strong></td>
        <td align="center"><strong>$<?=$balance?></strong></td>
        <td height="21" align="center" class="style1"><?=$payGate?> </td>
        <td height="21" align="center"><?=$date?>  </td>
        <td width="11%" height="21" align="center"><a href="request_delete.php?id=<?=$row->request_id?>" class="style1">Delete</a>  </td>
        <td width="10%" height="21" align="center"><a href="<?=$url?>" ONCLICK=confirmPay('<?=$payGate?>')>PayNow</a> </td>
    </tr>
   <?
}

      ?>

         <tr>
                <td width="50%" colspan="9" align="left" height="30" >
                <img src="../images/arrow_ltr.gif" >
                <a href="#" onclick="flagall()"  > Check All/</a>
                <a href="#" onclick="unflagall()"> UnCheck All&nbsp;&nbsp;&nbsp;</a>
                  <input type="submit" name="sub"  value="PAY NOW" style="width: 110" onclick="return validate()">
                  <input type="submit" name="sub"  value="DELETE" style="width: 110" onclick=" return validateDelete()">
               </td>
        </tr>


          <tr>
                  <td height="20" colspan="7" align="center"><?
                $url    ="index.php?Act=request";    //adding page nos
                include '../includes/show_pagenos.php';
                                ?></td></tr></table></form>
<?    } else
      {
      ?><p class="textred" align="center">No  Payment Requests</p><?}?>


 <script language="javascript" type="text/javascript">

 //check all

 function validate()
        {
         document.requestForm.action = "request_validate.php";
        }
 function flagall()
        {
        for (i=0; i < document.requestForm.elements.length; i++)
         {document.requestForm.elements[i].checked = true;
         }
        }

 //uncheck all
 function unflagall()
         {
        for (i=0; i < document.requestForm.elements.length; i++)
         {document.requestForm.elements[i].checked = false;
         }
         }

 </script>


