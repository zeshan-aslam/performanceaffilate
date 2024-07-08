<?php	

        include_once 'includes/db-connect.php';
        include_once 'includes/session.php';
        include_once 'includes/constants.php';
   		  include_once 'includes/functions.php';
           
        $partners=new partners;
    	  $partners->connection($host,$user,$pass,$db);
           include_once 'language_include.php';   

           $Email    =  stripslashes(trim($_POST['Email']));
           $Name     =  stripslashes(trim($_POST['Name']));
           $Phone =  stripslashes(trim($_POST['Phone']));
           $Subject  =  stripslashes(trim($_POST['Subject']));
           $Message  =  stripslashes(trim($_POST['Message']));
          

           $response["status"] = false;
           $response["message"] = "";
		   $statusflag = true;
			if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 
				$secretKey = '6Le5c1IiAAAAAJ8CP9hb3BtG2Lg3FcXPUaQgc0Cu';
				$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 	
				$responseData = json_decode($verifyResponse); 	
			 if($responseData->success){
				 $statusflag = true;
			 }
			}else{
				 $statusflag = false;
			}

           if(empty($Name) || empty($Phone) || empty($Subject) || empty($Message))
           {
              $response["message"] = "Name, Phone, Subject, Message are required";
           }
          else
          {
			// Validate reCAPTCHA box 
			
            if($partners->is_email($Email)==0)
            {
                 $response["message"]  = "Invalid email address";
            }
            else 
            {
				if(!$statusflag){
					 $response["message"]  = "Robot verification failed, please try again.";	
				}else{
                   $sql="select * from partners_admin  ";
                   $result             =mysqli_query($con,$sql);
                   $row                =mysqli_fetch_object($result);
                   $to                 =stripslashes($row->admin_email);
                   $subject            ="Query about $title";
                   // $to='zeshantest.123@gmail.com';
                    $headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
                    $headers       .= "From: $Email\n";
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
                    $body.="<td width='100%' align='left'>$Name";
                    $body.="</td></tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$Subject</td>";
                    $body.="</tr>";
                    $body.="<tr>";
                    $body.="<td  width='100%' align='left'>$Message</td>";
                    $body.="</tr>";
                    $body.="<td  width='100%' align='left'  bgcolor='#000000'>&nbsp;</td>";
                    $body.="</tr>";
                    $body.="</table>";
                    $body.="</td>";
                    $body.="</tr>";
                    $body.="</table>";

                  mail($to,$subject,$body,$headers);
                  
                  
                  $response["status"] = true;
                  $response["message"] = $lang_contactmsg;
			}
              }
          }

  echo json_encode($response);
?>