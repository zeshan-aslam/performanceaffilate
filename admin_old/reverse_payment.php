<?php

//Added by SMA on 14-JUly-2006 for Admin Users
	$userobj = new adminuser();
	$adminUserId = $_SESSION['ADMINUSERID'];
//End Add on 14-July-2006

	$flag 		=$_GET['flag'];
    $id			=intval($_SESSION['AFFILIATEID']);
    $name		=$_SESSION['AFFILIATENAME'];
    $msg		=$_GET['msg'];
     if(empty($page))                               //getting page no
        $page        =$partners->getpage();
   //geting records from table
  $sql ="select * from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id and transaction_status like 'reverserequest'  ";
   $pgsql  = $sql;
   $sql   .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
   $ret =mysqli_query($con,$sql);


     //checking for each records
     if(mysqli_num_rows($ret)>0)
     {
	 	 
     ?>
 	   <br/>
	    <table width="90%" class="tablebdr" align="center">
	        <tr>
	                        <td colspan="5" align="center" class="textred"><?=$msg?>
	                        </td>
	        </tr>
	        <tr >
	                         <td height="25" class="tdhead" align="center">Affiliate</td>
	                         <td height="25" class="tdhead" align="center">Merchant</td>
	                         <td height="25" class="tdhead" align="center">Transaction</td>
	                         <td height="25" class="tdhead" align="center">Amount</td>
	                         <td height="25" class="tdhead" align="center">Do Payment</td>


	        </tr>
        <?
             while($row=mysql_fetch_object($ret))
             {
                  if ($row->transaction_status=='reversed')
                         $image      =	"<image src='../images/reversesale.gif' height='15' width='15'>";
                  else   $image		 ="";


                  //geting records from table
                  $sql2 ="select * from partners_merchant where merchant_id='$row->joinpgm_merchantid'";
                  $ret2 =mysqli_query($con,$sql2);
                  if(mysqli_num_rows($ret2)>0)
                  {
                  	$row2=mysql_fetch_object($ret2);
                    $merchant=stripslashes($row2->merchant_company);
                  }

                  $sql3 ="select * from partners_affiliate where affiliate_id='$row->joinpgm_affiliateid'";
                  $ret3 =mysqli_query($con,$sql3);
                  if(mysqli_num_rows($ret3)>0)
                  {
                  	$row3=mysql_fetch_object($ret3);
                    $affiliate=stripslashes($row3->affiliate_company);
                  }
                 //geting records from table
                 if($row->transaction_flag==1) 	   $amount =$row->transaction_admin_amount - $row->transaction_subsale;
                 else                              $amount =$row->transaction_admin_amount;
				 $amount = round($amount,2);
                 ?>
                 	<tr>
       				 <td height="25" align="center"><?=$affiliate?></td>
                     <td height="25" align="center"> <?=$merchant?> </td>
       				 <td height="25" align="center"><?=$row->transaction_type?><?=$image?></td>
        			 <td height="25" align="center"><?=$currSymbol?>&nbsp;<?=$amount?></td>
                     <td height="25" align="center"> 
					 <? if($userobj->GetAdminUserLink('Manage Reverse Sales',$adminUserId,4)) {  ?>
					 	<a href="reverse_process.php?affiliateid=<?=$row->joinpgm_affiliateid?>&amp;merchantid=<?=$row->joinpgm_merchantid?>&amp;transid=<?=$row->transaction_id?>&amount=<?=$amount?>">Pay</a>
					<? } else { ?>Pay<? } ?>
					</td>
    				</tr>


                 <?
              }  //End of reverse requests for normal commissions
			  
			  //Start of Reverse Requests with Recurring Commisions
			  
			  
			  // End of Reverse Requests with Recurring Commisions
      ?>
            <tr>
             <td height="25" colspan="5" align="right"><?
                $url    ="index.php?Act=reverse_payments";    //adding page nos
                include '../includes/show_pagenos.php';
				?></td></tr> </table>     
<?    } else
      {
      ?><p class="textred" align="center">No Reverse Requests</p>
<?	  } ?>