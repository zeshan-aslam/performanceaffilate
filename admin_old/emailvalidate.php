<?php 

	include_once 'includes/db-connect.php';
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	include_once '../includes/allstripslashes.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

    if((!isset($B1))and($flag=="0")) 
	{

		// form  auto submitted by List
		$event          = $eventcompo;
		
		if($event=="ChooseEvent")
		{
			$msg="Please select an Event! ";
			$_SESSION['BODY']="";
			$_SESSION['HEADER']="";
			$_SESSION['FOOTER']="";
		}

			$_SESSION['BODY']="";
			$_SESSION['HEADER']="";
			$_SESSION['FOOTER']="";

		$sql="SELECT * FROM partners_adminmail, partners_event WHERE partners_adminmail.adminmail_eventname = partners_event.event_name AND partners_adminmail.adminmail_eventname = '$event' ";
			$res=mysqli_query($con,$sql);
			while($row = mysqli_fetch_object($res))
			{
				$from=$row->adminmail_from;
				$sub=$row->adminmail_subject;
				
				$_SESSION['BODY']=$row->adminmail_message;
				$_SESSION['HEADER']=$row->adminmail_header;
				$_SESSION['FOOTER']=$row->adminmail_footer;
				
				$status=$row->event_status;
			}

			$msg="";  
			header("Location:index.php?Act=email&from=$from&sub=$sub&header=$header&body=$body&footer=$footer&event=$event&status=$status&msg=$msg&to=$to");
			exit;
    }

    if((isset($B1))or($flag=="1"))
     {
          //  echo "submitted from button";
			$event          = $eventcompo;
	
			$from           =trim($fromtxt);
			$sub        	=trim($subjecttxt);
			$body          	=trim($bodytxt);
			$header			=trim($headertxt);
			$footer			=trim($footertxt);
			$getst         	=$statusradio;
	
			 $_SESSION['HEADER']=$header;
			 $_SESSION['BODY']=$body;
			 $_SESSION['FOOTER']=$footer;


			if ($getst=="active") {
			$status="yes";
	
			}
			else {
						  $status="no";
			}

        }
        
		
	// validations

    if(empty($from))
            $err = "1";
    else
            $err = "0";

        if(empty($sub))
            $err .= ".1";
    else
            $err .= ".0";

            if(empty($header))
            $err .= ".1";
    else
            $err .= ".0";

        if(empty($body))
            $err .= ".1";
    else
            $err .= ".0";

            if(empty($footer))
            $err .= ".1";
    else
            $err .= ".0";

	   if($err!="0.0.0.0.0")
		{
	
			$msg="Invalid Entry...Please do not empty any fields";
		
			$_SESSION['HEADER']=$header;
			$_SESSION['BODY']=$body;
			$_SESSION['FOOTER']=$footer;
		
			header("Location:index.php?Act=email&from=$from&sub=$sub&event=$event&status=$status&msg=$msg&to=$to");
		
			exit;
		}


    if($event=="ChooseEvent")
   {
			$msg="Please select an Event! ";
			header("Location:index.php?Act=email&from=$from&sub=$sub&event=$event&status=$status&msg=$msg&to=$to");
			exit;
	}

	if($from != '[from]') {
		if(!$partners->is_email($from))
		{
			$msg="From field should be a valid E-mail Id ! ";
			header("Location:index.php?Act=email&from=$from&sub=$sub&event=$event&status=$status&msg=$msg&to=$to");
			exit;
		}
	}
	
	
	
	////////////// test sending
	if ($flag=="1") 
	{
	
			if(!$partners->is_email($to))
			{
				$msg="Please Enter a valid E-mail Id  on Test Field !!";
				header("Location:index.php?Act=email&from=$from&sub=$sub&event=$event&status=$status&msg=$msg&to=$to");
				exit;
			}

			$sql_admin="select * from partners_admin";
			$res_admin=mysqli_query($con,$sql_admin);
			$row_admin =mysqli_fetch_object($res_admin);  //common header and footer
			$adminheader=stripslashes($row_admin->admin_mailheader);
			$adminfooter=stripslashes($row_admin->admin_mailfooter);
			$admin_email	 =    stripslashes($row_admin->admin_email);

			$today         =date("Y-m-d");
                /////////// mail sending

                    $headers        =  "Content-Type: text/html; charset=iso-8859-1\n";
                    $headers       .=  "From: $from\n";
					$headers		=str_replace("[from]",$admin_email,$headers); 
                    $body1="<table border ='0' cellpadding='0' cellspacing='0' width='90%' >";
                    $body1.="<tr>";
                    $body1.="<td width='100%' align='center' valign='top'><br/>";
                    $body1.="<table border='0' cellpadding='0' cellspacing='0'  width='80%'>";

                    $body1.="<tr>";
                    $body1.="<td  width='100%' align='center'> $adminheader</td>";
                    $body1.="</tr>";
                    $body1.="<tr>";
                    $body1.="<td  width='100%' align='left'> $header</td>";
                    $body1.="</tr>";

                    $body1.="<tr>";
                    $body1.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body1.="</tr>";
                    $body1.="<tr>";
                    $body1.="<td width='100%' align='left'>$body";
                    $body1.="</td></tr>";
                    $body1.="<tr>";
                    $body1.="<td  width='100%' align='left'>&nbsp;</td>";
                    $body1.="</tr>";
                    $body1.="<tr>";
                    $body1.="<td  width='100%' align='left'>$footer</td>";
                    $body1.="</tr>";
                    $body1.="<tr>";
                    $body1.="<td  width='100%' align='center'>$adminfooter</td>";
                    $body1.="</tr>";

                    $body1.="</table>";
                    $body1.="</td>";
                    $body1.="</tr>";
                    $body1.="</table>";

					//Replace variable in the content with values
                     $body1=str_replace("[aff_firstname]","Affiliate FirstName",$body1);
                     $body1=str_replace("[aff_lastname]","Affiliate LastName",$body1);
                     $body1=str_replace("[aff_company]","Affiliate Company",$body1);
                     $body1=str_replace("[aff_email]","Affiliate Email",$body1);
                     $body1=str_replace("[aff_loginlink]","Affiliate Url",$body1);
                     $body1=str_replace("[aff_password]","Affiliate Password",$body1);
                     
                     $body1=str_replace("[mer_firstname]","Merchant FirstName",$body1);
                     $body1=str_replace("[mer_lastname]","Merchant Lastname",$body1);
                     $body1=str_replace("[mer_company]","Merchant Company",$body1);
                     $body1=str_replace("[mer_email]","Merchant Email",$body1);
                     $body1=str_replace("[mer_loginlink]","Merchant Url",$body1);
                     $body1=str_replace("[mer_password]","Merchnat Password",$body1);
					 
					 $body1=str_replace("[from]",$admin_email,$body1);
                     $body1=str_replace("[commission]","Commission Earned",$body1);
                     $body1=str_replace("[program]","Program Name",$body1);
                     $body1=str_replace("[type]","Transaction type",$body1);
                     $body1=str_replace("[date]","Transaction Date",$body1);
                     $body1=str_replace("[today]",$today,$body1);

			mail($to,$sub,$body1, $headers);
			
			$msg="Mail has been send to ".$to;
			header("Location:index.php?Act=email&from=$from&sub=$sub&event=$event&status=$status&msg=$msg&to=$to");
			exit ;


	}


       ////////////// updating table


       $sql="select * from partners_adminmail WHERE adminmail_eventname='$event'";

       $res=mysqli_query($con,$sql);

       if(mysqli_num_rows($res)>0)
       {
				$sql1="UPDATE partners_adminmail  SET adminmail_from ='$from',adminmail_subject='".addslashes($sub)."',adminmail_header='".addslashes($header)."',adminmail_footer='".addslashes($footer)."',adminmail_message='".addslashes($body)."' WHERE adminmail_eventname='$event'";
				$sql2="UPDATE partners_event SET event_status ='$status' WHERE event_name='$event'";
				$res=mysqli_query($con,$sql1) or die ("cant exe");
				$res2=mysqli_query($con,$sql2) or die ("cant exe 2 nd");
				$msg="Message updated ";
				header("Location:index.php?Act=email&from=$from&sub=$sub&event=$event&status=$status&msg=$msg&to=$to");
       }
	  else
      {

				$sql1="INSERT INTO partners_adminmail ( adminmail_id , adminmail_eventname , adminmail_from , adminmail_subject , adminmail_message , adminmail_header , adminmail_footer )
					VALUES ('', '$event', '$from', '".addslashes($sub)."', '".addslashes($body)."', '".addslashes($header)."', '".addslashes($footer)."')";
				
				$sql2="UPDATE partners_event SET event_status ='$status' WHERE event_name='$event'";
				
				
				$res=mysqli_query($con,$sql1);
				echo mysqli_error($con);
				$res2=mysqli_query($con,$sql2) ;
				
				echo mysqli_error($con);
				$msg="Message updated ";
				header("Location:index.php?Act=email&from=$from&sub=$sub&event=$event&status=$status&msg=$msg&to=$to");
     }



   ?>