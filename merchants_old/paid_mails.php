<?php
  $page		=$_GET['page'];
   if(empty($page))                               //getting page no
        $page        =$partners->getpage();

  $userid		=$_SESSION['MERCHANTID'];

  //geting records from table
  $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_merchant where adjust_action like 'paidmail' and merchant_id=adjust_memberid and adjust_memberid='$userid' order by adjust_date desc";
  $pgsql=$sql;
  $sql  .=" LIMIT ".($page-1)*$lines.",".$lines; //adding page no
  $ret =mysqli_query($con,$sql);

    ?>
        <br/>
  		<table width="90%" class="tablebdr" align="center">
<?php
  //checking for each records
  if(mysqli_num_rows($ret)<=0)
  {
?>
	<tr><td colspan="4" align="center" class="red"><?=$affiliate_nopaidmails_msg?></td></tr>
<?php  
  }
  else
  {
?>  
    	<tr>
        <td height="25" width="30%" class="tdhead" align="center"> <?=$affiliate_merchant?></td>
        <td height="25" width="30%" class="tdhead" align="center"> <?=$affiliate_date?></td>
        <td height="25" width="20%" class="tdhead" align="center"> <?=$affiliate_noppl?></td>
        <td height="25" width="20%" class="tdhead" align="center"> <?=$affiliate_amount?></td>

        </tr>
  	   <?
          while($row=mysqli_fetch_object($ret))
          {
                  $merchant	=trim(stripslashes($row->merchant_firstname))." ".trim(stripslashes($row->merchant_lastname));
                  $date			=$row->DATE;
                ?>
                <tr>
                     <td height="25" align="center"><?=$merchant?></td>
                     <td height="25" align="center"><?=$date?> </td>
                     <td height="25" align="center"> <?=$row->adjust_no?> </td>
                     <td height="25" align="center"> <?=$row->adjust_amount?> </td>

    				</tr>
                <?

           }
         }

      ?>

      </table>

