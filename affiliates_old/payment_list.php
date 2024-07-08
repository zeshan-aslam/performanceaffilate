<?php

    $flag 		= $_GET['flag'];
    $id			= $_SESSION['AFFILIATEID'];
    $name		= $_SESSION['AFFILIATENAME'];

    $cfrom      = trim($_POST['txtfrom']);          //from date
    $cto        = trim($_POST['txtto']);            //to date
    $page       = intval(trim($_GET['page']));
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


   $sql ="select *,date_format(transaction_dateofpayment,'%d-%M-%y') as date from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id and transaction_parentid='$id' and transaction_dateofpayment <> '0000-00-00'  and transaction_status <> 'pending' and transaction_flag = '1'";
   if(!empty($From)&& !empty($To)) $sql .=" and transaction_dateofpayment between '$From' and '$To' ";
   $sql .=" ORDER BY transaction_dateofpayment DESC ";
  //ho $sql;
   $topage3 =$sql;
   $sql  .="LIMIT ".($page-1)*$lines.",".$lines;



   $ret100 =mysqli_query($con,$sql);

   $num100	=mysqli_num_rows($ret100);



    $flag='a';
    $member="affiliate";


   $sql ="select *,date_format(adjust_date,'%d-%M-%Y') AS DATE from partners_adjustment,partners_$member where    affiliate_id  = adjust_memberid  and  adjust_flag like '$flag' and adjust_memberid='$id' ";
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

            $sql33      =$topage3;
	        $res        =mysqli_query($con,$sql33);
            $num3		=mysqli_num_rows($res);

    $ret1 =mysqli_query($con,$sql);
    $rcount  =$num1+$num2+$num3;
    echo mysqli_error($con);






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
  <table border="0" cellpadding="0" cellspacing="0"  class="tablebdr1"  width="50%" align="center">
         <tr>
             <td  height="19" class="tdhead" colspan="2" >
             <p align="center"><?=$lang_report_stat?></p></td>
         </tr>
         <tr>
            <td  height="19" colspan="2" >
            <p align="center" class="red"></p></td>
         </tr>
         <tr>
            <td height="19" colspan="2" >
            <p align="center" ><?=$lang_report_forperiod?></p></td>
         </tr>
         <tr>
            <td width="45%" height="24" align="center">&nbsp; <?=$lang_report_from?></td>
            <td width="55%" height="24" align="left"><input type="text" name="txtfrom" size="18" value="<?=$cfrom?>" onfocus="javascript:from_date();return false;"></input></td>

        </tr>
        <tr>
            <td width="45%" height="24" align="center">&nbsp;&nbsp;&nbsp; <?=$lang_report_to?></td>
            <td width="55%" height="24" align="left"><input type="text" name="txtto" size="18" value="<?=$cto?>"  onfocus="javascript:to_date();return false;"></input></td>

        </tr>
        <tr>
            <td width="35%" height="23">&nbsp;</td>
        </tr>
       <tr>
           <td colspan="2" align="center" height="26">
           <input type="submit" name="sub" title="<?=$lang_report_view?>" value="view"></input></td>
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
	                        <td colspan="5" align="center" class="sphead" >  <?=$lang_Account_Details?>
	                        </td>
	        </tr>
   	<tr >


        			 <td height="18" class="tdhead"><?=$affiliate_merchant?></td>
                     <td height="18" class="tdhead"><?=$lang_pay_list_pgm?></td>
       				 <td height="18" class="tdhead"><?=$affiliate_date?></td>
        			 <td height="18" class="tdhead"><?=$affiliate_transaction?></td>
                     <td height="18" class="tdhead"><?=$affiliate_amount?></td>


    </tr>

<?

             while($row=mysqli_fetch_object($ret))
             {
                  //geting records from table
                  $sql2 ="select * from partners_merchant where merchant_id=$row->joinpgm_merchantid";
                  $ret2 =mysqli_query($con,$sql2);
                  if(mysqli_num_rows($ret2)>0)
                  {
                  	$row2=mysqli_fetch_object($ret2);
                    $affiliate=stripslashes($row2->merchant_company);
                  }

                 if ($row->transaction_status=='reversed')
                         $image      =	"<image src='../images/reversesale.gif' height='10' width='10'>";
                  else   $image		 ="<image src='../images/".$row->transaction_type.".gif' height='10' width='10'>";

                  $sign="<img src='../images/add.gif' width='10' height='10' alt='addd' border='0'>";


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

                     <td height="15"><?=$affiliate?> </td>
                     <td height="15"><a href="index.php?Act=cat&joinstatus=pgmwise&pgm=<?=$row->joinpgm_programid?>"><?=$lang_pay_list_view?></a></td>
       				 <td height="15"><?=$row->date?>  </td>
        			 <td height="15"><?=$image?>&nbsp;&nbsp;<?=$row->transaction_type?></td>
                     <td height="15"><b>&nbsp;<?=$sign?>&nbsp;<?=$currSymbol?>&nbsp;<?=number_format($row->transaction_amttobepaid ,2) ?> </b></td>
    				</tr>

<?

			}

              ?>   </table>

  <?
     }




  if(mysqli_num_rows($ret100)>0)
     {

   ?>
   <br/>
<table width="90%" class="tablebdr" align="center">
    <tr>
	                        <td colspan="5" align="center" class="sphead" >  <?=$lang_Account_sub?>
	                        </td>
	        </tr>
   	<tr >

    				 <td height="18" class="tdhead"><?=$affiliate_name?></td>
        			 <td height="18" class="tdhead"><?=$affiliate_merchant?></td>

       				 <td height="18" class="tdhead"><?=$affiliate_date?></td>
        			 <td height="18" class="tdhead"><?=$affiliate_transaction?></td>
                     <td height="18" class="tdhead"><?=$affiliate_amount?></td>


    </tr>

<?

             while($row=mysqli_fetch_object($ret100))
             {
                  //geting records from table
                  $sql2 ="select * from partners_merchant where merchant_id=$row->joinpgm_merchantid";
                  $ret2 =mysqli_query($con,$sql2);
                  if(mysqli_num_rows($ret2)>0)
                  {
                  	$row2=mysqli_fetch_object($ret2);
                    $affiliate=stripslashes($row2->merchant_company);
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
                 	<tr class=<?=$classid?> >
       				 <td height="15"><?=$name?></td>
                     <td height="15"><?=$affiliate?> </td>
       				 <td height="15"><?=$row->date?>  </td>
        			 <td height="15">&nbsp;&nbsp;Sub<?=$row->transaction_type?></td>
                     <td height="15"><b>&nbsp;<?=$sign?>&nbsp;<?=$currSymbol?><?=number_format($row->transaction_subsale ,2) ?> </b></td>
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
	                        <td colspan="4" align="center" class="sphead">  <?=$lang_Account_withdraw?>
	                        </td>
	        </tr>
	        <tr >
                             <td height="18" class="tdhead" align="center"><?=$affiliate_name?></td>
       				 		 <td height="18" class="tdhead" align="center"><?=$affiliate_date?></td>
        			 		 <td height="18" class="tdhead" align="center"><?=$affiliate_transaction?></td>
                     		 <td height="18" class="tdhead" align="center"><?=$affiliate_amount?></td>



	        </tr>
   <?
           while($row=mysqli_fetch_object($ret1))
           {     $firstname     =$member."_company";
                 $lastname		=$member."_lastname";
                 $affiliate	    =trim(stripslashes($row->$firstname));
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
  <tr class="<?=$classid?>">
                     <td height="15" align="center"><?=$affiliate?></td>
                     <td height="15" align="center"><?=$date?> </td>

        			 <td height="15"  align="left">&nbsp;
<?

                     switch ($row->adjust_action)
                     {

                       case "add":

                       echo "<img src='../images/add.gif' width='10' height='10' alt='addd' border='0'></img>&nbsp;Deposited To Your Account";

                         break;
                       case "deduct":

                           echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'></img>&nbsp;Admin Withdrawed From Your Account";

                         break;
                       case "paidmail":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'></img>&nbsp;Charged For Paid Mail";
                                   break;

                       case "withdraw":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'></img>&nbsp;Withdrawed From Your Account";

                         break;

                     }


?>



                     </td>
                     <td height="15" align="left"><b>&nbsp;
<?

                     switch ($row->adjust_action)
                     {

                       case "add":

                       echo "<img src='../images/add.gif' width='10' height='10' alt='addd' border='0'></img>";

                         break;
                       case "deduct":

                           echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'></img>";

                         break;
                       case "paidmail":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'></img>";
                                   break;

                       case "withdraw":

                       	   echo	"<img src='../images/withdraw.gif' width='10' height='10' alt='addd' border='0'></img>";

                         break;

                     }


?>



                     &nbsp;<?=$currSymbol?>&nbsp;<?=number_format($row->adjust_amount,2)?></b> </td>
		  </tr>
                   <?

            }

      ?>
</table>
      <?

        }


			if($num1>$num2)
            {
               if($num1>$num3)
              			 $pgsql=	$topage1;
               else
                         $pgsql=	$topage3;
            }
            else
            {
               if($num2>$num3)
              			 $pgsql=	$topage2;
               else
                         $pgsql=	$topage3;

            }


	       $url    ="index.php?Act=paymentlist";    //adding page nos
	       include '../includes/show_pagenos.php';




        if($rcount==0)
          {
      ?><p class="textred" align="center"><?=$norec?></p><?}?>