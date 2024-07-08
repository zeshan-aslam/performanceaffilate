<?
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
   include_once '../includes/allstripslashes.php';


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';

            $event          = $eventcompo;

        $from       =trim($fromtxt);
        $sub        =trim($subjecttxt);
        $body       =trim($bodytxt);
        $header     =trim($headertxt);
        $footer     =trim($footertxt);
        $getst      =$statusradio;

         $_SESSION['HEADER']=$header;
         $_SESSION['BODY']=$body;
         $_SESSION['FOOTER']=$footer;
         $flag=trim($_POST['flag']);
                 $dontupdate ="false";


            //echo  $from=trim($fromtxt);
         //echo $flag;

    if($flag=="0")

      {

               //    echo  "form  auto submitted by List";

                         $event          = $eventcompo;

                     if($event=="ChooseEvent")
                     {
                                             $msg=$lemail_error1		;

                                             $_SESSION['BODY']="";
                                             $_SESSION['HEADER']="";
                                             $_SESSION['FOOTER']="";

                       header("Location:index.php?Act=emails&msg=$msg");

                                    exit;
                   }
                   else
                   {

                                $sql="SELECT * FROM partners_mermail, partners_event WHERE partners_mermail.mermail_eventname = partners_event.event_name AND partners_mermail.mermail_eventname = '".addslashes($event)."' ";
                                        $res=mysqli_query($con,$sql);
                                 while($row = mysqli_fetch_object($res))
                                   {
                                             $from=$row->mermail_from;
                                             $sub=$row->mermail_subject;

                                            $_SESSION['BODY']=$row->mermail_message;
                                            $_SESSION['HEADER']=$row->mermail_header;
                                            $_SESSION['FOOTER']=$row->mermail_footer;

                                            $status=$row->event_status;
                                   }


                                     $msg="";
                                   header("Location:index.php?Act=emails&from=$from&sub=$sub&header=$header&body=$body&footer=$footer&event=$event&amp;status=$status&msg=$msg&to=$to");
                                          exit;
                    }
      }



    if($flag=="2")
     {
            //echo "submitted from button";


        $event          = $eventcompo;

        $from           =trim($fromtxt);
        $sub        =trim($subjecttxt);
        $body          =trim($bodytxt);
        $header                        =trim($headertxt);
        $footer                        =trim($footertxt);
        $getst         =$statusradio;

         $_SESSION['HEADER']=$header;
         $_SESSION['BODY']=$body;
         $_SESSION['FOOTER']=$footer;


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

                $msg=$lemail_error2;

                $_SESSION['HEADER']=$header;
                $_SESSION['BODY']=$body;
                $_SESSION['FOOTER']=$footer;

               header("Location:index.php?Act=emails&from=$from&sub=$sub&event=$event&amp;status=$status&msg=$msg&to=$to");

               $dontupdate="true";

                exit;
                }
        }  /// closing submit


    if(event=="ChooseEvent")
       {
                $msg=$lemail_error1;
                $from="";
                $to="";
                                header("Location:index.php?Act=emails");
                exit;
                }

    if(!$partners->is_email($from))
                {
                $msg=$lemail_error3;
header("Location:index.php?Act=emails&from=$from&sub=$sub&event=$event&amp;status=$status&msg=$msg&to=$to");
                exit;
                }




       ////////////// updating table

       /// checking entry already existing ???

       if($flag !="1")
       {

       //echo $flag."fai";

       $sql="select * from partners_mermail WHERE mermail_eventname='$event'";

       $res=mysqli_query($con,$sql);

       if(mysqli_num_rows($res)>0)

      {
                      $sql1="UPDATE partners_mermail  SET mermail_from ='".addslashes($from)."',mermail_subject='".addslashes($sub)."',mermail_header='".addslashes($header)."',mermail_footer='".addslashes($footer)."',mermail_message='".addslashes($body)."' WHERE mermail_eventname='".addslashes($event)."'";
            $res=mysqli_query($con,$sql1) or die ("cant exe");
            $msg=$lemail_error4;
                        header("Location:index.php?Act=emails&from=$from&sub=$sub&event=$event&amp;status=$status&msg=$msg&to=$to");
       }
     else
     {
           $sql1="INSERT INTO `partners_mermail` ( `mermail_id` , `mermail_eventname` , `mermail_from` , `mermail_subject` , `mermail_message` , `mermail_header` , `mermail_footer`, mermail_merchantid  )
                                        VALUES ('', '".addslashes($event)."', '".addslashes($from)."', '".addslashes($sub)."', '".addslashes($body)."', '".addslashes($header)."', '".addslashes($footer)."', '$_SESSION[MERCHANTID]')";

           $res=mysqli_query($con,$sql1);
           echo mysqli_error($con);

           $msg=$lemail_error4	;
                           header("Location:index.php?Act=emails&from=$from&sub=$sub&event=$event&amp;status=$status&msg=$msg&to=$to");

     }


     }/// closing if flag =0;
      ////////////// test sending


  if ($flag=="1") {



                if(!$partners->is_email($to))
                {
                $msg=$lemail_error5	;
header("Location:index.php?Act=emails&from=$from&sub=$sub&event=$event&amp;status=$status&msg=$msg&to=$to");
                exit;
                }

                /////////// mail sending


                $message=$header.$body.$footer;

                   $headers = "Content-Type: text/html; charset=iso-8859-1\n";
                       $headers .= "From:  <$from>\n";


                mail($to,$sub,$message, $headers);

                  $msg=$lemail_error7.$to;
        header("Location:index.php?Act=emails&from=$from&sub=$sub&event=$event&amp;status=$status&msg=$msg&to=$to");
                //echo "mail send and exit";
                exit ;


                }
   ?>