<?php

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once '../includes/allstripslashes.php';
    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);


  $select1	=	trim($_POST['select1']);
  $flag		=	trim($_POST['flag']);

    $totmail=0;

/*     $sql ="SELECT * FROM partners_admin";
     $res=mysqli_query($con,$sql);

     $row=mysqli_fetch_object($res);

     $adminheader              =stripslashes($row->admin_mailheader);
     $adminfooter              =stripslashes($row->admin_mailfooter);
     $amt                      =$row->admin_mailamnt;*/


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
                    $body.="<td  width='100%' align='center' bgcolor='#000000'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";

                  //  $body.="<td  width='100%' align='center'> $adminheader</td>";

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

                  //  $body.="<td  width='100%' align='center'>$adminfooter</td>";

                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'  bgcolor='#000000'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="</table>";
                    $body.="</td>";
                    $body.="</tr>";
                    $body.="</table>";

                   mail($toaddress,$subject,$body,$headers);
            }

     ////////////////////////////  mailer function end here //////////////////////////////

  // for first time  poulating list

	if(!isset($_POST['select1']))
	{
		$sql 	= "SELECT * FROM partners_login WHERE login_flag='a'";
		$res	= mysqli_query($con,$sql);
		$totmail= mysqli_num_rows($res);
		$select1= "All Affiliate";
	}
	else{

	switch ($select1) {
		case "All merchants":
			$sql 	= "SELECT * FROM partners_login WHERE login_flag='m'";
			$res	= mysqli_query($con,$sql);
			$totmail= mysqli_num_rows($res);
		break;
	
		case "All Affiliate":
			$sql 	= "SELECT * FROM partners_login WHERE login_flag='a'";
			$res	= mysqli_query($con,$sql);
			$totmail= mysqli_num_rows($res);
		break;
	}

  }

  /////////////omnt calculatting
         $totamount=($totmail*$amt);
         err=="";

//////////// validatting submitted form ////////////

	if($flag=="send" or $flag=="Test Send To Me" ){
		foreach ($_POST as $key => $value)//to stripslash all get variables
		{
			$value=stripslashes(trim($value));
			$_POST[$key]=$value;
			$$key=$_POST[$key];
			//////////// VALIDATTING///////////
			
			if($flag=="send"){
				if($key!="to1"){
					if(empty($$key))
						$err .= ".1";
					else
						$err .= ".0";
				}
			}
			else{
				if(empty($$key))
					$err .= ".1";
				else
					$err .= ".0";
			}
		
		} /// for each closing
	
	
		if($err!=".0.0.0.0.0.0.0.0" and $flag=="send" )
		{
			$lpmail_error1="Dont Leave Any Field as Blank";
			$msg=$lpmail_error1;
		}
		
		if($err!=".0.0.0.0.0.0.0.0.0" and $flag!="send" )
		{
			$lpmail_error1="Dont Leave Any Field as Blank";
			$msg=$lpmail_error1		;
		}

		elseif(!$partners->is_email($fromtxt))
		{
			$lpmail_error2="From Field Should Be a Valid E-mail Id";
			$msg=$lpmail_error2;
		}
		elseif( ( ($flag=="Test Send To Me") and (!$partners->is_email($to1) )  ) )
		{
			$lpmail_error3="Test Field Should Be a Valid E-mail Id";
			$msg=$lpmail_error3;
		}
	
		else if($flag=="send")
		{
		/// code to send all mail
			while($row = mysqli_fetch_object($res)){
				$subto=stripslashes($row->login_email);
				mailer($subto,$adminheader,$adminfooter);
				// mailer($_POST['$to'],$adminheader,$adminfooter);
				
			}
			$lpmail_error4=" E-mails  Successfully send";
			$msg=" (".$totmail.") ".$lpmail_error4;
		} // closing else if send
	
		else if($flag=="Test Send To Me")
		{
			mailer($to1,$adminheader,$adminfooter);
			$msg="Test mail Message (1) Send to ".$to1;
		}
	
	} /// closing  if send

	if($flag=="")
	{
		$msg="";
	}


?>
<form name="f1" action="" method="post">
    <table border='0' cellpadding="0" cellspacing="0" width="80%" id="AutoNumber1" class="tablebdr">
    <tr>
      <td width="742" colspan="7" height="19" class="tdhead" align="center"><b>
        Select a mailinglist</b>
        <select size="1" name="select1" onchange="f1.submit()">
      <option value="All Affiliate"  <? echo($select1=="All Affiliate"?"selected='selected'":"") ?> >All Affiliates</option>
      <option         value="All merchants" <? echo($select1=="All merchants"?"selected='selected'":"") ?> >All Merchants</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="7" align="center" class="textred"><?=$msg?></td>
    </tr>
	
    <tr>
      <td width="742" height="19">&nbsp;</td>
      <td width="329" height="19">&nbsp;</td>
      <td width="640" height="19">&nbsp;</td>
      <td width="177" height="19" colspan="2" >&nbsp;</td>
      <td width="228" height="19">&nbsp;</td>
      <td width="4" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="742" height="22" rowspan="3" class="grid1">&nbsp;</td>
      <td width="329" height="65" rowspan="3" class="grid1" colspan="2" align="left">
      	
        <table border="0" cellpadding="0" cellspacing="0" width="100%" id="AutoNumber2" class="hdbdr">
          <tr>
			  <td width="195" height="22" class="grid1">&nbsp;</td>
			  <td width="151" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
			  <td width="195" height="15" class="grid1">Total Receivers</td>
			  <td width="151" height="15" class="grid1">&nbsp;<?=$totmail?></td>
          </tr>
          <tr>
			  <td width="195" height="17" class="grid1">&nbsp;</td>
			  <td width="151" height="17" class="grid1">&nbsp;</td>
          </tr>
        </table>      </td>
      <td width="177" height="22" class="grid1">&nbsp;</td>
      <td width="396" height="65" class="grid1" colspan="2" rowspan="3">
      
        <table border="0" cellpadding="0" cellspacing="0" width="100%" id="AutoNumber3" >
          <tr>
            <td height="6">&nbsp;</td>
            <td height="6">&nbsp;</td>
          </tr>
          <tr>
      		<td width="94" height="54" rowspan="3" class="grid1">&nbsp;Receivers</td>
      		<td width="235" height="54" rowspan="3" class="grid1">
      		<select size="3" name="D1" multiple="multiple" class="selectMailingList" >
      		<option selected='selected'>-----------------MailingList -----------------</option>
			  <?
			  while($row = mysqli_fetch_object($res))
					   {
					   if (trim($event)==trim($row->login_email))
						{
							$var="selected='selected'";
					   }else {
							$var="";
					   }

					   $mail=$row->login_email;
					   //$mail=explode("@",$mail);
			  ?>
               <option <?=$var?>> <?=$mail;?> </option>
      		<?
               }
      		?>
      		</select></td>
          </tr>
        </table>      </td>
      <td width="4" height="22" rowspan="3" class="grid1"></td>
    </tr>
    <tr>
      <td width="177" height="15" class="grid1"></td>
    </tr>
    <tr>
      <td width="177" height="17" class="grid1"></td>
    </tr>
    <tr>
      <td width="742" height="19">&nbsp;</td>
      <td width="329" height="19">&nbsp;</td>
      <td width="640" height="19">&nbsp;</td>
      <td width="177" height="19">&nbsp;</td>
      <td width="396" height="19">&nbsp;</td>
      <td width="228" height="19">&nbsp;</td>
      <td width="4" height="19">&nbsp;</td>
    </tr>
    <tr>
      <td width="742" height="19" colspan="7" class="grid1" align="center">
      <b>You Can use Html Code on Header Footer and Body Fields</b></td>
    </tr>
    <tr>
      <td width="742" height="34" class="grid1">&nbsp;</td>
      <td width="329" height="34" class="grid1">From</td>
      <td width="640" height="34" class="grid1"><input type="text" name="fromtxt" size="27" value="<?=$fromtxt ?>" /></td>
      <td width="177" height="34" class="grid1">&nbsp;</td>
      <td width="396" height="34" class="grid1">Subject</td>
      <td width="228" height="34" class="grid1"><input type="text" name="subjecttxt" size="27" value="<?=$subjecttxt ?>" /></td>
      <td width="4" height="34" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td width="742" height="27" class="grid1">&nbsp;</td>
      <td width="329" height="27" class="grid1">Header</td>
      <td width="640" height="27" class="grid1">
      <textarea rows="3" name="headertxt" cols="27"><?=$headertxt?></textarea></td>
      <td width="177" height="27" class="grid1">&nbsp;</td>
      <td width="396" height="27" class="grid1">Footer</td>
      <td width="228" height="27" class="grid1">
      <textarea rows="3" name="footertxt" cols="27"><?=$footertxt ?></textarea></td>
      <td width="4" height="27" class="grid1">&nbsp;</td>
    </tr>
    <tr class="grid1"><td height="1" colspan="7" >&nbsp;</td></tr>
    <tr>
      <td height="1" colspan="7" >&nbsp; </td>
    </tr>
    <tr>
      <td width="742" height="19" class="grid1">&nbsp;</td>
      <td width="329" height="19" class="grid1">&nbsp;</td>
      <td width="640" height="57" colspan="4" rowspan="3" class="grid1">
      
      <textarea rows="8" name="bodytxt" cols="77" class="bodytxt"><?=$bodytxt ?></textarea></td>
      <td width="4" height="19" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td width="742" height="19" class="grid1">&nbsp;</td>
      <td width="329" height="19" class="grid1">Body</td>
      <td width="4" height="19" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td width="742" height="19" class="grid1">&nbsp;</td>
      <td width="329" height="19" class="grid1">&nbsp;</td>
      <td width="4" height="19" class="grid1">&nbsp;</td>
    </tr>
    <tr>
      <td height="19" colspan="7">&nbsp;</td>
      </tr>
    <tr>
      <td width="742" height="19" colspan="7" align="center">
      <input type="submit" value="send" name="flag" />&nbsp;&nbsp;      </td>
    </tr>
    <tr>
      <td width="742" height="19">&nbsp;</td>
      <td width="329" height="19">&nbsp;</td>
      <td width="640" height="19">&nbsp;</td>
      <td width="177" height="19" colspan="2" >&nbsp;</td>
      <td width="228" height="19">&nbsp;</td>
      <td width="4" height="19">&nbsp;</td>
    </tr>
    <tr class="grid1">
      <td width="742" height="19" >&nbsp;</td>
      <td width="329" height="19" >Test</td>
      <td width="640" height="19" colspan="3" align="center">
      <input type="text" name="to1" size="56" value="<?=$to1?>" /></td>
      <td width="228" height="19" >
      <input type="submit" value="Test Send To Me" name="flag" /></td>
      <td width="4" height="19" >&nbsp;</td>
     <!--   <input type="hidden" value="nill" id ="flag" name="flag"> onclick="return btn_onclick()"    onclick="return test_onclick()"   -->
    </tr>
    </table>
    </center></form><br />