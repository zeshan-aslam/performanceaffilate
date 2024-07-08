<?php

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	
	$select1=trim($_POST['select1']);
	$flag=trim($_POST['flag']);
	
	
	$totmail=0;
	
	$sql ="SELECT * FROM partners_admin";
	$res=mysqli_query($con,$sql);
	
	$row=mysqli_fetch_object($res);
	
	$adminheader              	=stripslashes($row->admin_mailheader);
	$adminfooter              	=stripslashes($row->admin_mailfooter);
	$amt                      	=$row->admin_mailamnt;
	$id						=$_SESSION['MERCHANTID'];
	
     /////////////////////////////   mailre function   ?////////////////////////////////


     function mailer($to,$ah,$af)
         {

           $toaddress=$to;

           //$sql="select * from partners_admin";
           //$ret1=mysqli_query($con,$sql);
           //$row=mysqli_fetch_object($ret1);  //common header and footer
           //$adminheader=stripslashes($row->admin_mailheader);
           //$adminfooter=stripslashes($row->admin_mailfooter);

           $adminheader=$ah;
           $adminfooter=$af;


               $today         =date("Y-m-d");
               $toaddress  = stripslashes($to);

                //$subject    = stripslashes($sub);

                $from        =$_POST['fromtxt'];
                $subject     =$_POST['subjecttxt'];
                $header      =$_POST['headertxt'];
                $footer      =$_POST['footertxt'];
                $message     =$_POST['bodytxt'];

                $to1         =$_POST['to1'];



                    $headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
                    $headers       .=  "From: $from\n";
                    $body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
                    $body.="<tr>";
                    $body.="<td width='100%' align='center' valign='top'><br/>";
                    $body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";

                    $body.="<tr>";
                    $body.="<td  width='100%' align='center'> $adminheader</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'> $header</td>";
                    $body.="</tr>";

                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td width='100%' align='left'>$message";
                    $body.="</td></tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$footer</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='center'>$adminfooter</td>";
                    $body.="</tr>";

                    $body.="</table>";
                    $body.="</td>";
                    $body.="</tr>";
                    $body.="</table>";


                   mail($toaddress,$subject,$body,$headers);

                  // echo $toaddress;



            }


     ////////////////////////////  mailer function end here //////////////////////////////





  // for first time  poulating list

 if(!isset($_POST['select1']))
 {

    $sql ="SELECT * FROM partners_login WHERE login_flag='a'";
    $res=mysqli_query($con,$sql);
    $totmail=mysqli_num_rows($res);
    $select1="All Affiliate";

  }

  else
  {


    switch ($select1) {
      case "All merchants":

          $sql ="SELECT * FROM partners_login WHERE login_flag='m'";
          $res=mysqli_query($con,$sql);
           $totmail=mysqli_num_rows($res);

        break;

      case "All Affiliate":

         $sql ="SELECT * FROM partners_login WHERE login_flag='a'";
         $res=mysqli_query($con,$sql);
         $totmail=mysqli_num_rows($res);

         break;
      case 2:

        break;
    }

  }

  /////////////omnt calculatting


         $totamount=($totmail*$amt);

  		 $curAmnt  = $amt;
         $curTotal = $totamount;
         $date	   = date("Y-m-d");

         if($currValue != $default_currency_caption ){
                $curAmnt  = getCurrencyValue($date, $currValue, $curAmnt);
         		$curTotal = getCurrencyValue($date, $currValue, $curTotal);
         }


         err=="";

//////////// validatting submitted form ////////////

      if($_POST["TestSend"] or $_POST["SendMail"])

      {

            foreach ($_POST as $key => $value)//to stripslash all get variables
                    {
                       $value=stripslashes(trim($value));
                       $_POST[$key]=$value;

                    	$$key=$_POST[$key];

                                                //////////// VALIDATTING///////////

                            if(empty($$key))

                                    $err .= ".1";
                          	else
                                    $err .= ".0";;
                    } /// for each closing


                if($err!=".0.0.0.0.0.0.0.0.0")
                {
                 $msg=$lpmail_error1;
                }
                elseif(!$partners->is_email($fromtxt))
                {

                   $msg=$lpmail_error2;

                }
                elseif(!$partners->is_email($to1))
                {

                   $msg=$lpmail_error3;

                }

                else if($_POST["SendMail"])
                {
                 /// code to send all mail

                         //geting records from table
	                              $merchant_sql ="SELECT * FROM   merchant_pay  WHERE pay_merchantid='$id'";
	                              $merchant_ret =mysqli_query($con,$merchant_sql);

	                              //checking for each records
	                              if(mysqli_num_rows($merchant_ret)>0)
	                              {
	                                      $row                  =mysqli_fetch_object($merchant_ret);
	                                      $merchant_pay_amount =$row->pay_amount;

	                              }
                        if($merchant_pay_amount-$totamount>=0)
                        {
                               while($row = mysqli_fetch_object($res))
	                             {
	                             	$subto=stripslashes($row->login_email);
		                            mailer($subto,$adminheader,$adminfooter);

	                             }

                                   $admin_sql ="SELECT * FROM   admin_pay ";
                         	       $admin_ret =mysqli_query($con,$admin_sql);

	                                  //checking for each records
	                                  if(mysqli_num_rows($admin_ret)>0)
	                                  {
	                                          $row                  =mysqli_fetch_object($admin_ret);
	                                          $admin_pay_amount     =$row->pay_amount;

	                                  }

	                               $merchant_pay_amount -= $totamount;
	                               $admin_pay_amount   += $totamount;

	                             $sql1 ="update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$id'";
	                             $ret1 =mysqli_query($con,$sql1);

	                              $sql1 ="update admin_pay set pay_amount='$admin_pay_amount' ";
	                             $ret1 =mysqli_query($con,$sql1);

	                             $_SESSION['MERCHANTBALANCE']=$merchant_pay_amount;

	                             mailer($_POST['$to1'],$adminheader,$adminfooter);
	                             $msg=$lpmail_error4 ." (".$totmail.") ".$lpmail_error5;

                                $today=date("Y-m-d");
           						$sql3  = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` ,`adjust_no`)  ";
           						$sql3 .= "VALUES ('', '$id', 'paidmail', 'm','$totamount','$today','$totmail')";
           						mysqli_query($con,$sql3);
                             }
                             else
                             {
                               $msg =$mail_err1.$totamount.$mail_err2;
                             }
                } // closing else if send
                else if($_POST["TestSend"])
                {
                      mailer($to1,$adminheader,$adminfooter);
                      $msg="Test mail Message (1) Send to ".$to1;


                }
     } /// closing  if send
     /* commented by jincy
      if($flag=="")
      {
          $msg="";
      }   */




?>

<form method="post"  name="f1" action="">

    <p class="textred" align="center"><b><?=$msg?></b> </p>
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  width="80%" id="AutoNumber1" class="tablebdr" align="center">
    <tr>
      <td width="737" colspan="7" height="19" class="tdhead" align="center">
      <?=$lpmail_Selectamailinglist ?><select size="1" name="select1" onchange="javascript:document.f1.submit()">
      <option value="All Affiliate"  <? echo($select1=="All Affiliate"?"selected = 'selected'":"") ?> ><?=$lpmail_allaffiliates?></option>
      <option         value="All merchants" <? echo($select1=="All merchants"?"selected= 'selected'":"") ?> ><?=$lpmail_allmerchants?></option>

      </select></td>
    </tr>
    <tr>
      <td width="4" height="19">&nbsp;</td>
      <td width="94" height="19">&nbsp;</td>
      <td width="235" height="19">&nbsp;</td>
      <td width="177" height="19" colspan="2" >&nbsp;</td>
      <td width="228" height="19">&nbsp;</td>
      <td width="4" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="4" height="22" rowspan="3" class="grid1">&nbsp;</td>
      <td width="329" height="22" rowspan="3" class="grid1" colspan="2"  align="left">

        <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  width="100%" id="AutoNumber2" >
          <tr>
      <td width="195" height="25" class="grid1" align="left">
  		&nbsp;<?=$lpmail_TotalReceiver?></td>
      <td width="151" height="25" class="grid1" align="left">
      <font color="#FF0000">&nbsp;&nbsp;&nbsp; <?=$totmail?></font></td>
          </tr>
          <tr>
      <td width="195" height="18" class="grid1">&nbsp;<?=$lpmail_Costpermail?></td>
      <td width="151" height="18" class="grid1" align="left">
     <font color="#FF0000">&nbsp;&nbsp;&nbsp; &nbsp;<?=$currSymbol?> <?=$curAmnt?></font></td>
          </tr>
          <tr>
      <td width="195" height="18" class="grid1" align="left">
      &nbsp;<?=$lpmail_TotalAmount?></td>
      <td width="151" height="18" class="grid1" align="left">
      <font color="#FF0000">&nbsp;&nbsp;&nbsp; &nbsp;<?=$currSymbol?> <?=$curTotal?></font></td>
          </tr>
        </table>

      </td>
      <td width="9" height="22" class="grid1">&nbsp;</td>
      <td width="396" height="54" class="bdrgrid1" colspan="2" rowspan="3">
        <table border="0" cellpadding="0" cellspacing="0" class="tablewbdr" width="100%" id="AutoNumber3" >
          <tr>
      <td width="94" rowspan="3" class="grid1">&nbsp;<?=$lpmail_Receivers?></td>
      <td width="235" rowspan="3" class="grid1" align="center" valign="top"><select size="3" name="D1" multiple='multiple' style="font-size:11px; min-height:55px;" >
        <option selected="selected">-----------------
          <?=$lpmail_MailingList?>
          -----------------</option>
        <?

      while($row = mysqli_fetch_object($res))
               {
               if (trim($event)==trim($row->login_email))
                {
                                           $var="selected = 'selected'";
               }
               else {
                                           $var="";
               }

               $mail=$row->login_email;
               $mail=explode("@",$mail);

      ?>
        <option <?=$var?>>
        <?=$mail[0]."@----.com";?>
        </option>
        <?
               }


      ?>
      </select></td>
          </tr>
        </table>

      </td>
      <td width="4" height="22" rowspan="3" class="grid1">
      </td>
    </tr>
    <tr>
      <td width="9" height="15" class="grid1"></td>
    </tr>
    <tr>
      <td width="9" height="17" class="grid1"></td>
    </tr>
    <tr>
      <td width="4" height="19">&nbsp;</td>
      <td width="94" height="19">&nbsp;
      </td>
      <td width="235" height="19">&nbsp;</td>
      <td width="9" height="19">&nbsp;</td>
      <td width="168" height="19">&nbsp;</td>
      <td width="228" height="19">&nbsp;
      </td>
      <td width="4" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="742" height="19" colspan="7" class="grid1" align="center">
      <b><?=$lpmail_YouCanuseHtmlCodeonHeaderFooterandBodyFields?></b></td>
    </tr>
    <tr>
      <td width="4" height="34" class="grid1">&nbsp;</td>
      <td width="94" height="34" class="grid1"><?=$lpmail_From?></td>
      <td width="235" height="34" class="grid1"><input type="text" name="fromtxt" size="27" value="<?=$fromtxt ?>" /></td>
      <td width="9" height="34" class="grid1">&nbsp;</td>
      <td width="168" height="34" class="grid1"><?=$lpmail_Subject?></td>
      <td width="228" height="34" class="grid1"><input type="text" name="subjecttxt" size="27" value="<?=$subjecttxt ?>" /></td>
      <td width="4" height="34" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td width="4" height="27" class="grid1">&nbsp;</td>
      <td width="94" height="27" class="grid1"><?=$lpmail_Header?></td>
      <td width="235" height="27" class="grid1">
      <textarea rows="3" name="headertxt" cols="27"><?=$headertxt?></textarea></td>
      <td width="9" height="27" class="grid1">&nbsp;</td>
      <td width="168" height="27" class="grid1"><?=$lpmail_Footer?></td>
      <td width="228" height="27" class="grid1">
      <textarea rows="3" name="footertxt" cols="27"><?=$footertxt ?></textarea></td>
      <td width="4" height="27" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td width="4" height="1" class="grid1"></td>
      <td width="94" height="1" class="grid1"></td>
      <td width="640" height="1" colspan="4" class="grid1">
      &nbsp;&nbsp;&nbsp; </td>
      <td width="4" height="1" class="grid1"></td>
    </tr>
    <tr>
      <td width="4" height="1" ></td>
      <td width="94" height="1" ></td>
      <td width="640" height="1" colspan="4">
      &nbsp;&nbsp; </td>
      <td width="4" height="1" ></td>
    </tr>
    <tr>
      <td width="4" height="19" class="grid1">&nbsp;</td>
      <td width="94" height="19" class="grid1">&nbsp;</td>
      <td width="640" height="57" colspan="4" rowspan="3" class="grid1" align="center">

      <textarea rows="8" name="bodytxt" cols="77" class="bodytxt"><?=$bodytxt ?></textarea></td>
      <td width="4" height="19" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td width="4" height="19" class="grid1">&nbsp;</td>
      <td width="94" height="19" class="grid1"><?=$lpmail_Body?></td>
      <td width="4" height="19" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td width="4" height="19" class="grid1">&nbsp;</td>
      <td width="94" height="19" class="grid1">&nbsp;</td>
      <td width="4" height="19" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td width="4" height="19">&nbsp;</td>
      <td width="94" height="19">&nbsp;</td>
      <td width="235" height="19">&nbsp;</td>
      <td width="177" height="19" colspan="2" >&nbsp;</td>
      <td width="228" height="19">&nbsp;</td>
      <td width="4" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="742" height="19" colspan="7" align="center">

	    <?

        	$bal	=$_SESSION['MERCHANTBALANCE'];

        		if(($bal-$totamount)>=0)
                {


	    ?>

      <input type="submit" value="<?=$lpmail_SendMail?>"  name="SendMail" />&nbsp;&nbsp;

      <?
      			}
                else
                {
	               	echo "<div class='textred'><b>$lang_enough</b></div>";
                }
      ?>

      </td>
    </tr>
    <tr>
      <td width="4" height="19">&nbsp;</td>
      <td width="94" height="19">&nbsp;</td>
      <td width="235" height="19">&nbsp;</td>
      <td width="177" height="19" colspan="2" >&nbsp;</td>
      <td width="228" height="19">&nbsp;</td>
      <td width="4" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="4" height="19" >&nbsp;</td>
      <td width="94" height="19"><?=$lpmail_Test?></td>
      <td width="412" height="19" colspan="3" align="center">
      <input type="text" name="to1" size="56" value="<?=$to1?>" /></td>
      <td width="228" height="19">
      <input type="submit" value="<?=$lpmail_TestSendToMe?>"  name="TestSend" /></td>
      <td width="4" height="19">&nbsp;</td>
    </tr>
	
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    </table>
    </form><br />

	<script language="javascript" type="text/javascript">
		function btn_onclick(){
			document.f1.flag.value="send";
			document.f1.submit();
		}
		function test_onclick(){
			document.f1.flag.value="test";
			document.f1.submit();
		}
	</script>