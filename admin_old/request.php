<?
  $msg                    = $_GET['msg'];
  $page                   =	intval($_GET['page']);
  $paypalAcc			  = 0;
  if(empty($page))                              //getting page no
        $page        =$partners->getpage();

//Added by SMA on 14-JUly-2006 for Admin Users
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
//End Add on 14-July-2006


$sql  = "SELECT *, date_format( request_date, '%d-%b-%Y' ) AS DATE
         FROM partners_request, partners_affiliate, affiliate_pay
         WHERE  affiliate_id = request_affiliateid
         AND affiliate_id=pay_affiliateid
         AND request_affiliateid= pay_affiliateid
         AND request_status LIKE 'active'
         GROUP BY request_id
         ORDER BY request_date DESC  ";

  $pgsql=$sql;

  $sql  .= "LIMIT ".($page-1)*$lines.",".$lines; //adding page no
  $ret 	 = mysqli_query($con, $sql);
  if(mysqli_num_rows($ret)>0)
  {
        ?>

<br/>
<form action="#" method="post" name="requestForm">
<table width="98%" align="center" class="tablebdr">

        <tr>
        <td width="21%" height="21" align="center" class="tdhead"> Affiliate </td>
        <td width="12%" align="center" class="tdhead">With Draw Amount</td>
        <td width="10%" align="center" class="tdhead">Current Balance </td>
        <td width="16%" height="21" align="center" class="tdhead"> Gateway</td>
        <td width="16%" height="21" align="center" class="tdhead"> Date</td>
        <td height="21" align="center" class="tdhead">Delete</td>
        <td height="21" align="center" class="tdhead">Manual Pay</td>
        <td height="21" align="center" class="tdhead">Pay</td>
        </tr>
    <tr>
      <td height="20" colspan="6" align="center" class="style11"><strong><?=$msg?></strong></td>
    </tr>
     <?
     while($row=mysqli_fetch_object($ret))
     {
      $affiliate        = trim(stripslashes($row->affiliate_company));
      $date             = $row->DATE;
      $status           = $row->request_status;
      $amount           = round($row->request_amount,2);
      $amount1          = round($row->request_amount,2);
      $balance          = round($row->pay_amount,2);
      $request_id       = $row->request_id;
      $affiliateid      = $row->request_affiliateid ;

      $sqlGate			= " SELECT bankinfo_modeofpay as payGate FROM partners_bankinfo WHERE bankinfo_affiliateid = '$affiliateid' ";
      $retGate			= mysqli_query($con, $sqlGate);


      if(mysqli_num_rows($retGate)>0){
      	$rowGate	=  mysqli_fetch_object($retGate);
        $payGate	= stripslashes(trim($rowGate->payGate));
      }

      if($payGate=='Paypal') $paypalAcc++;

      $url              = "payment_process.php?affiliateid=$affiliateid&amp;request_id=$request_id&amp;amount=$amount";
      if(($balance-$amount)<0){

            $sql            ="DELETE FROM partners_request where request_id='$request_id'";
            $res                =mysqli_query($con, $sql);

      }

      $gridcounter++;
      if ($gridcounter%2==1) $classid="grid1";
      else   $classid="grid2";

     ?>
    <tr class="<?=$classid?>">
        <td height="21" align="left"> <input type="checkbox" name="elements[]" value="<?=$row->request_id?>" />&nbsp;&nbsp;<?=$affiliate?>  </td>
        <td align="center"><strong><?=$currSymbol?><?=$amount1?>(<?=$currSymbol?><?=$amount?>)</strong></td>
        <td align="center"><strong><?=$currSymbol?><?=round($balance,2)?></strong></td>
        <td height="21" align="center" class="style11"><?=$payGate?> </td>
        <td height="21" align="center"><?=$date?>  </td>
        <td width="11%" height="21" align="center">
		<? if($userobj->GetAdminUserLink('Manage Affiliate Requests',$adminUserId,4)) { ?>
			<a href="request_delete.php?id=<?=$row->request_id?>" class="style11" onclick="return validateDelete()">Delete</a>  
		<? } else { ?>Delete<? } ?>
		</td>
        <td width="10%" height="21" align="center">
		<? if($userobj->GetAdminUserLink('Manage Affiliate Requests',$adminUserId,4)) { ?>
			<a href="mark_validate.php?request_id=<?=$row->request_id?>&amp;affiliate_id=<?=$affiliateid?>&amp;amount=<?=$amount?>" > Completed ?</a> 
		<? } else { ?>Completed<? } ?>
		</td>
        <td width="10%" height="21" align="center">
		<? if($userobj->GetAdminUserLink('Manage Affiliate Requests',$adminUserId,4)) { ?>
			<a href="<?=$url?>" onclick="return confirmPay('<?=$payGate?>')"> PayNow</a> 
		<? } else { ?>PayNow<? } ?>
		</td>
    </tr>
   <?
  }
   ?>
    <tr>
                <td width="50%" colspan="9" align="left" height="30" >
               <img src="../images/arrow_ltr.gif" alt="" />
                <a href="#" onclick="flagall()"  > Check All/</a>
                <a href="#" onclick="unflagall()"> UnCheck All&nbsp;&nbsp;&nbsp;</a>
				<? if($userobj->GetAdminUserLink('Manage Affiliate Requests',$adminUserId,4)) 
				{ 
                   if($paypalAcc>0){ ?><input type="submit" name="sub"  value="Export MassPay File"  onclick="return validate(1)" />&nbsp;<input type="submit" name="sub"  value="Make Mass Payment"  onclick="return masspay(1)" /><? }?>
                  <input type="submit" name="sub"  value="Delete" style="width: 110" onclick="return validate(0)" />
				 <? } ?>
               </td>
   </tr>
   <tr>
       <td width="50%" colspan="9" align="left" height="30" > <span class="style11">Note: </span> Export MassPay File &amp; Make Mass Payment Are Applicable only for Paypal Accounts  </td>
   </tr>
   <tr>
                <td height="20" colspan="7" align="center"><?
                $url    ="index.php?Act=request";    //adding page nos
                include '../includes/show_pagenos.php';
                ?>
   			   </td>
    </tr>
    </table>
    </form>
	<?
    } else
    {
    ?><p class="textred" align="center">No  Payment Requests</p><?}?>
<br />

 <script language="javascript" type="text/javascript">

 //check all
 function confirmPay(gateWay){

 	if(gateWay=='CheckByMail' || gateWay=='WireTransfer') {
      var result = confirm('Payment Gateway used is '+gateWay+'. Before making payment through the sytem make sure that you have made the actual payment through '+gateWay + '. Do you still want to make payment?');
      if(result)  return true;
      else 		  return false;
    }
    else{
     return true;
    }
  }
 function validate(flag)
        {
         if(flag)document.requestForm.action = "request_validate.php";
         else {
            var result1 = confirm('Are You sure You Want to delete');
     	    if(result1) 	document.requestForm.action = "request_Massdelete.php";
      		else
               return false;
           }
        }

 function masspay(flag)
        {
        document.requestForm.action = "mass_validate.php";
        }
 function flagall()
        {
        for (i=0; i < document.requestForm.elements.length; i++)
         {
          document.requestForm.elements[i].checked = true;
         }
        }

 //uncheck all
 function unflagall()
         {
        for (i=0; i < document.requestForm.elements.length; i++)
         {
         	document.requestForm.elements[i].checked = false;
         }
         }

 </script>


