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
	<div class="card">
		<div class="row"> 
			<div class="col-md-12">
				<div class="card-header">					
					<span class="textred"><? echo $msg ?></span>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body">
					<div class="form-group">
						<label><?=$lpmail_Selectamailinglist ?></label>
						<select size="1" class="form-control" name="select1" onchange="javascript:document.f1.submit()">
							<option value="All Affiliate"  <? echo($select1=="All Affiliate"?"selected = 'selected'":"") ?> ><?=$lpmail_allaffiliates?></option>
							<option value="All merchants" <? echo($select1=="All merchants"?"selected= 'selected'":"") ?> ><?=$lpmail_allmerchants?></option>
						 </select>	
					</div>
				</div>
			</div>
		</div>
		<div class="card-body strpied-tabled-with-hover"> 
			<div class="row"> 
				<div class="col-md-6">						
					<div class="table-full-width table-responsive">
						<table class="table table-hover table-striped">
							<tbody>
								<tr>
									<td><b><?=$lpmail_TotalReceiver?></b></td>
									<td><span class="textred"><?=$totmail?></span></td>
								</tr>
								<tr>
									<td><b><?=$lpmail_Costpermail?></b></td>
									<td><span class="textred"><?=$currSymbol?> <?=$curAmnt?></span></td>
								</tr>
								<tr>
									<td><b><?=$lpmail_TotalAmount?></b></td>
									<td><span class="textred"><?=$currSymbol?> <?=$curTotal?></span></td>
								</tr>
							</tbody>
						</table>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label><?=$lpmail_Receivers?></label>
						<select size="3" name="D1" multiple='multiple' class="selectpicker"data-title="Mailing List Multiple" data-style="btn-info btn-fill btn-block" data-menu-style="dropdown-blue">
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
						</select>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<div class="card stacked-form">
		<div class="card-header text-center">
			<p><b><?=$lpmail_YouCanuseHtmlCodeonHeaderFooterandBodyFields?></b></p>
		</div>
		<div class="card-body">
			<div class="row"> 
				<div class="col-md-6">
					<div class="form-group">
						<label><?=$lpmail_From?></label>
						<input type="text" class="form-control" name="fromtxt" size="27" value="<?=$fromtxt ?>" />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label><?=$lpmail_Subject?></label>
						<input type="text" class="form-control" name="subjecttxt" size="27" value="<?=$subjecttxt ?>" />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label><?=$lpmail_Header?></label>
						<textarea rows="3" name="headertxt" class="form-control textarea_contrl"><?=$headertxt?></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label><?=$lpmail_Footer?></label>
						<textarea rows="3" name="footertxt" class="form-control textarea_contrl"><?=$footertxt ?></textarea>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label><?=$lpmail_Body?></label>
						<textarea rows="5" name="bodytxt" class="form-control textarea_contrl bodytxt"><?=$bodytxt ?></textarea>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						 <?
							$bal = $_SESSION['MERCHANTBALANCE'];
							if(($bal-$totamount)>=0)
							{
							?>
							<input type="submit" class="btn btn-fill btn-info" value="<?=$lpmail_SendMail?>"  name="SendMail" />
							<?
							}
							else
							{
								echo "<span class='textred'><b>$lang_enough</b></span>";
							}
							?>
					</div>
				</div> 
				<div class="col-md-6">
					<div class="form-group">
						 <label><?=$lpmail_Test?></label>
						 <input type="text" class="form-control" name="to1" size="56" value="<?=$to1?>" />
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<input type="submit" class="btn btn-fill btn-info" value="<?=$lpmail_TestSendToMe?>"  name="TestSend" />
					</div>
				</div>
			</div>
		</div>
	</div>    
</form>

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