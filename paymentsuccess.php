<?php


# include all files
	include_once 'includes/constants.php';
	include_once 'includes/functions.php';
	include_once 'includes/session.php';

# establishing connection
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

# language including
	include_once 'language_include.php';

  $type		= $_GET['type'];
  $curid	= $_GET['curid'];
  $amount	= $_GET['amount'];

#-----------------------------------------------------------
# security module
#-----------------------------------------------------------
  $secid    = $_GET['secid'];
  $secpass  = $_GET['secpass'];

  $secsql   = "select * from random_gen where rand_genid='$secid' and rand_genpwd='$secpass'";
  $secres=mysql_query($secsql);
  if(mysql_num_rows($secres)>0) {

     $secdel ="delete from random_gen where rand_genid='$secid' and rand_genpwd='$secpass'";
     mysql_query($secdel);

  }
  else
  {

   $msg=$lang_perror;
   header("Location:index.php?Act=register&msg=$msg");
   exit;

  }
#-----------------------------------------------------------
# security module
#-----------------------------------------------------------

 $type		=	trim(strtolower($type));

 $getmoney = " select `pay_amount` from `merchant_pay` WHERE `pay_merchantid` = '$curid'";
 $getret   = @mysql_query($getmoney);

 if(mysql_num_rows($getret)>0){
     $getrow      = mysql_fetch_object($getret);
     $pay_amount = $getrow->pay_amount;

     $changamount =   $amount +  $pay_amount;

     $sql2		=	"UPDATE  `merchant_pay` set `pay_amount` ='$changamount'    Where  `pay_merchantid` = '$curid'";
 	 $result 	= 	@mysql_query($sql2);
 }
 else{
     $sql2		=	"INSERT INTO `merchant_pay` ( `pay_merchantid` , `pay_amount`  )
            		VALUES ('$curid', '$amount')";
      $result 	= mysql_query($sql2);
 }



 $today     = date("Y-m-d");
 $sql22  	= "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag` , `adjust_amount` , `adjust_date` , `adjust_no` )
 				VALUES ('', '$curid', 'deposit', 'm', '$amount', '$today', '0')";
 $result22  = @mysql_query($sql22);

 $sql3  = "INSERT INTO `partners_fee` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
                $sql3 .= "VALUES ('', '$curid', 'register', 'closed','$amount','$today')";
                mysql_query($sql3);


 $updatestat= "UPDATE partners_merchant SET merchant_status= 'approved' WHERE merchant_id = '$curid'";
 $updateret = @mysql_query($updatestat);
 $msg		=	$lang_success;


 /* $sql		=	"select * from partners_admin";
  $ret1		=	mysql_query($sql);
  $row		=	mysql_fetch_object($ret1);  //common header and footer

  $adminheader	=	stripslashes($row->admin_mailheader);
  $adminfooter	=	stripslashes($row->admin_mailfooter);

  $sql		=	"select * from partners_adminmail where adminmail_eventname='Merchant Registration' ";
  $result	=	mysql_query($sql);

   if(mysql_num_rows($result)>0)  {
       $row           = mysql_fetch_object($result);
       $sub           = stripslashes($row->adminmail_subject);
       $message       = stripslashes($row->adminmail_message);
       $head          = stripslashes($row->adminmail_header);
       $footer        = stripslashes($row->adminmail_footer);
       $from          = stripslashes($row->adminmail_from);
       $subject       = $sub;
    }

    $sql       = "select * from partners_login where login_id =$curid and login_flag='m'";
    $ret       = mysql_query($sql);
    if(mysql_num_rows($ret)>0) {
      $row   = mysql_fetch_object($ret);
      $to    = $row->login_email;
      $pass  = $row->login_password;
    }


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
     $body.="<td  width='100%' align='center'> $adminheader</td>";
     $body.="</tr>";
     $body.="<tr>";
     $body.="<td  width='100%' align='left'> $head</td>";
     $body.="</tr>";

     $body.="<tr>";
     $body.="<td  width='100%' align='left'>&nbsp;</td>";
     $body.="</tr>";
     $body.="<tr>";
     $body.="<td width='100%' align='left'>$message";
     $body.="</td></tr>";

     $body.="<tr>";
     $body.="<td width='100%' align='left'>"."Your Password Is =".$pass;
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
     $body.="<tr>";
     $body.="<td  width='100%' align='left'  bgcolor='#000000'>&nbsp;</td>";
     $body.="</tr>";
     $body.="</table>";
     $body.="</td>";
     $body.="</tr>";
     $body.="</table>";

  	 mail($to,$subject,$body,$headers);  */

     header("Location:index.php?Act=register&msg=$msg");
     exit;

?>