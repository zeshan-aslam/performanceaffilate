<?php
  $page		=$_GET['page'];
   if(empty($page))                               //getting page no
        $page        =$partners->getpage();

  //geting records from table
  $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_merchant where adjust_action like 'paidmail' and merchant_id=adjust_memberid order by adjust_date desc";
  $pgsql=$sql;
  $sql  .=" LIMIT ".($page-1)*$lines.",".$lines; //adding page no
  $ret =mysql_query($sql);

  //checking for each records
  if(mysql_num_rows($ret)>0)
  {    ?>
        <br/>
  		<table width="90%" class="tablebdr" align="center">
        <tr><td colspan="4"><?=$msg?></td></tr>
    	<tr>
        <td height="25" class="tdhead" align="center"> Merchant</td>
        <td height="25" class="tdhead" align="center"> Date</td>
        <td height="25" class="tdhead" align="center"> Amount</td>
        <td height="25" class="tdhead" align="center"> Recipients</td>
        </tr>
  	   <?
          while($row=mysql_fetch_object($ret))
          {
                  $merchant	=trim(stripslashes($row->merchant_firstname))." ".trim(stripslashes($row->merchant_lastname));
                  $date			=$row->DATE;
                ?>
                <tr>
                     <td height="25" align="center"><?=$merchant?></td>
                     <td height="25" align="center"><?=$date?> </td>
                     <td height="25" align="center"> <?=$row->adjust_amount?> </td>
                     <td height="25" align="center"> <?=$row->adjust_no?> </td>
    				</tr>
                <?

           }

      ?> 	<tr>
                  <td height="25" colspan="5" align="right"><?
                $url    ="index.php?Act=paid_mails";    //adding page nos
                include '../includes/show_pagenos.php';
				?></td></tr> </table>     <?    } else
      {
      ?><p class="textred" align="center">No  Payments</p><?}?>