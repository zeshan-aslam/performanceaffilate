<?php	ob_start();

           include_once 'includes/constants.php';
   		   include_once 'includes/functions.php';
           $partners=new partners;
    	   $partners->connection($host,$user,$pass,$db);
           include_once 'language_include.php';   

           $Email    =  stripslashes(trim($_POST['Email']));
           $Name     =  stripslashes(trim($_POST['Name']));
           $Location =  stripslashes(trim($_POST['Location']));
           $Address  =  stripslashes(trim($_POST['Address']));
           $Message  =  stripslashes(trim($_POST['Message']));
          // $Err      =  stripslashes(trim($_POST['Err']));*/

           if(empty($Name))
                  $err = "1";
           else
                  $err = "0";

 		   if(empty($Location))
                  $err .= ".1";
    	   else
                  $err .= ".0";
           if(empty($Address))
                  $err .= ".1";
    	   else
                  $err .= ".0";
           if(empty($Message))
                  $err .= ".1";
    	   else
                  $err .= ".0";


           if($err!="0.0.0.0")
                 {
                 $msg=$lang_dontleave;
                 header("Location:index.php?Act=contactus&Err1=$msg&Name=$Name&Address=$Address&Email=$Email&Location=$Location&Message=$Message");
                 exit;
                 }

            if($partners->is_email($Email)==0)
                 {
                 $msg=$lang_emailmsg;
                 header("Location:index.php?Act=contactus&Err1=$msg&Name=$Name&Address=$Address&Email=$Email&Location=$Location&Message=$Message");
                 exit;
                 }




           $sql="select * from partners_admin  ";
           $result             =mysql_query($sql);
           $row                =mysql_fetch_object($result);
           $to                 =stripslashes($row->admin_email);
           $subject            ="Query about $title";

                    $headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
                    $headers       .= "From: $Name < $Email \n";
                    $body="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
                    $body.="<tr>";
                    $body.="<td width='100%' align='center' valign='top'><br/>";
                    $body.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='center' bgcolor='#000000'>&nbsp;</td>";
                    $body.="</tr>";


                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td width='100%' align='left'>$Message";
                    $body.="</td></tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$Name</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$Address</td>";
                    $body.="</tr>";
                    $body.="<td  width='100%' align='left'  bgcolor='#000000'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="</table>";
                    $body.="</td>";
                    $body.="</tr>";
                    $body.="</table>";

                  mail($to,$subject,$body,$headers);
                  $msg=$lang_contactmsg	;
                  Header("Location:index.php?Act=contactus&Err1=$msg");
?>
