<?php


   $trans		= $_POST['trans'];
   if(empty($member))
      $member   = $_GET['member'];
   if(empty($trans))
      $trans    = $_GET['trans'];

   $page		= intval($_GET['page']);
   if(empty($page))                               //getting page no
        $page        =$partners->getpage();

   if(empty($member)) $member="affiliate";
   $memberid 		= $member."_id";

   if($member=="merchant") $flag = 'm' ;
   else                   $flag = 'a';

   $userid		= $_SESSION['AFFILIATEID'];

   $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_$member where adjust_flag like '$flag' and adjust_memberid='$memberid'  and adjust_memberid='$userid' ";
   if(!empty($trans)) $sql .= " and adjust_action like '$trans'";
   $sql .= " order by adjust_date desc ";
   $pgsql=$sql;
   $sql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no

   $ret =mysqli_query($con,$sql);
   //checking for each records
   ?>
   <form method="post" action="index.php?Act=manual_payments&page=1">
   <table width="90%" class="tablewbdr" align="center">
      	<tr >
           <td height="25" colspan="2" align="center">

           <?=$affiliate_transaction?> <select name="trans">
                <option value="">--<?=$affiliate_all?>--</option>
                <option value="add" <?echo ($trans=="add")?"selected":""?>><?=$affiliate_withdraw?></option>
                <option value="deduct" <?echo ($trans=="deduct")?"selected":""?>><?=$affiliate_payment?></option>
           </select>
           <input type="submit" value="Search" name="s1">
            </td>

       </tr>

   </table>
   </form>
   <?

   if(mysqli_num_rows($ret)>0)
   {
   ?>
   <br/>
	    <table width="90%" class="tablebdr" align="center">
	        <tr>
	        	<td colspan="4" align="center" class="textred"></td>
	        </tr>
	        <tr >
                 <td height="25" class="tdhead" align="center"><?=$affiliate_name?></td>
                 <td height="25" class="tdhead" align="center"><?=$affiliate_date?></td>
                 <td height="25" class="tdhead" align="center"><?=$affiliate_transaction?></td>
                 <td height="25" class="tdhead" align="center"><?=$affiliate_amount?></td>
	        </tr>
   <?
           while($row=mysqli_fetch_object($ret))
           {     $firstname     =$member."_firstname";
                 $lastname		=$member."_lastname";
                 $affiliate	    =trim(stripslashes($row->$firstname))." ".trim(stripslashes($row->$lastname));
      			 $date			=$row->DATE;
                   ?>
           <tr>
                 <td height="25" align="center"><?=$affiliate?></td>
                 <td height="25" align="center"><?=$date?> </td>

                 <td height="25"  align="center"><? echo ($row->adjust_action=="add" ?"Withdrawed from Admin A/C":"Added To Admin A/C")?></td>
                 <td height="25" align="center"> <?=$row->adjust_amount?> </td>
    	   </tr>
                   <?

            }

      ?> 	<tr>
            	<td height="25" colspan="5" align="right"><?
                $url    ="index.php?Act=manual_payments&member=$member&trans=$trans";    //adding page nos
                include '../includes/show_pagenos.php';
				?></td>
            <tr>
      </table>     <?    } else
      {
      ?><p class="textred" align="center"><?=$affiliate_nopay?></p><?}?>