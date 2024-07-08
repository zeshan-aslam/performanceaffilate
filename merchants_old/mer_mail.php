<?

  	include_once '../includes/constants.php';
  	include_once '../includes/functions.php';
  	include_once '../includes/session.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    include_once 'language_include.php';

    foreach ($_POST as $key => $value)//to stripslash all posted variables
        {
      $value=trim($value);
      $value=stripslashes($value);
      $$key=$value;

      //echo "$key=>$value <br/>";
    }
                               // for poulating list
          $mid		=    $_SESSION['MERCHANTID'];

    $sql ="SELECT event_name from partners_event where event_status = 'yes' and event_flag='a'";
    $res100=mysqli_query($con,$sql);

// To get count of active mails

    $num=mysqli_num_rows($res100);
//retriving values from submitted form
    if($_POST['B1']=="" and $eventcompo=="")
    {

       //	echo "firsttime";
       $msg="";

		    $sql1 ="SELECT event_name from partners_event where event_status = 'yes' and event_flag='a'";
		    $res1=mysqli_query($con,$sql1);


            if(mysqli_num_rows($res1))
            {
                        while ($row=mysqli_fetch_object($res1))

                        {
                         			$event_name1    =	stripslashes(trim($row->event_name));
                                    break;
                        }

           }

            $sql2="SELECT * FROM partners_mermail, partners_event WHERE partners_mermail.mermail_eventname = partners_event.event_name AND partners_mermail.mermail_eventname = '$event_name1' AND mermail_merchantid ='$mid' ";
            $res2=mysqli_query($con,$sql2);


            while ($row=mysqli_fetch_object($res2))

            {
                        $from           =   stripslashes(trim($row->mermail_from));
                        $sub            =   stripslashes(trim($row->mermail_subject));
                        $body           =   stripslashes(trim($row->mermail_message));
                        $header         =   stripslashes(trim($row->mermail_header));
                        $footer         =   stripslashes(trim($row->mermail_footer));

            }
    }
    else
    {
    		// echo "submitted";

             	if($_POST['B1']=="")
                {
                		// if posted by list box

	                    $sql1 ="SELECT event_name from partners_event where event_status = 'yes' and event_flag='a' and event_name='$eventcompo' ";
	                    $res1=mysqli_query($con,$sql1);


	                    if(mysqli_num_rows($res1))
	                    {
	                   		 while ($row=mysqli_fetch_object($res1))

	                    		{
	                    $event_name1    =   stripslashes(trim($row->event_name));
	                    break;
	                    		}
	                    }


                                $sql2="SELECT * FROM partners_mermail, partners_event WHERE partners_mermail.mermail_eventname = partners_event.event_name AND partners_mermail.mermail_eventname = '$event_name1' AND mermail_merchantid ='$mid' ";
                                $res2=mysqli_query($con,$sql2);

                                            while ($row=mysqli_fetch_object($res2))

                                            {
                                             			$from    		=	stripslashes(trim($row->mermail_from));
                                               			$sub	 		=	stripslashes(trim($row->mermail_subject));
                                             			$body   		=	stripslashes(trim($row->mermail_message));
                                               			$header  	    =	stripslashes(trim($row->mermail_header));
                                               			$footer 	    =	stripslashes(trim($row->mermail_footer));

                                            }
                     ///  list box submit endhere
                }
                if($_POST['B1']=="Update")
                {

                             reset($_POST);
                              foreach ($_POST as $key => $value)//to stripslash all posted variables
                                {
                                            $value=trim($value);
                                            $value=addslashes($value);
                                            $$key=$value;

                                           // echo "$key=>$value <br/>";
                                }

                //echo "Update dffdfdf";
                                $sql2="SELECT * FROM partners_mermail, partners_event WHERE partners_mermail.mermail_eventname = partners_event.event_name AND partners_mermail.mermail_eventname = '$eventcompo' AND mermail_merchantid ='$mid' ";
                                $res2=mysqli_query($con,$sql2);

                                if(mysqli_num_rows($res2)>0)
                                {


	                                    $sql1="UPDATE partners_mermail  SET mermail_from ='".addslashes($fromtxt)."',mermail_subject='".addslashes($subjecttxt)."',mermail_header='".addslashes($headertxt)."',mermail_footer='".addslashes($footertxt)."',mermail_message='".addslashes($bodytxt)."' WHERE mermail_eventname='$eventcompo' AND mermail_merchantid ='$mid' ";
	                                    $res=mysqli_query($con,$sql1) or die ("cant exe");
	                                    $msg=$lemail_error4;

                                        //echo $sql1;

                                $sql2="SELECT * FROM partners_mermail, partners_event WHERE partners_mermail.mermail_eventname = partners_event.event_name AND partners_mermail.mermail_eventname = '$eventcompo' AND mermail_merchantid ='$mid' ";
                                $res2=mysqli_query($con,$sql2);

                                $event =$eventcompo;


                                            while ($row=mysqli_fetch_object($res2))

                                            {
                                             			$from    		=	stripslashes(trim($row->mermail_from));
                                               			$sub	 		=	stripslashes(trim($row->mermail_subject));
                                             			$body   		=	stripslashes(trim($row->mermail_message));
                                               			$header  	    =	stripslashes(trim($row->mermail_header));
                                               			$footer 	    =	stripslashes(trim($row->mermail_footer));

                                            }
                                }
                                else
                                {

                                        $sql1="INSERT INTO `partners_mermail` ( `mermail_id` , `mermail_eventname` , `mermail_from` , `mermail_subject` , `mermail_message` , `mermail_header` , `mermail_footer`, mermail_merchantid  )
                                        VALUES ('', '".addslashes($eventcompo)."', '".addslashes($fromtxt)."', '".addslashes($subjecttxt)."', '".addslashes($bodytxt)."', '".addslashes($headertxt)."', '".addslashes($footertxt)."', '$_SESSION[MERCHANTID]')";

                                        $res=mysqli_query($con,$sql1);
                                        echo mysqli_error($con);

                                        $msg=$lemail_error4  ;


                                $sql2="SELECT * FROM partners_mermail, partners_event WHERE partners_mermail.mermail_eventname = partners_event.event_name AND partners_mermail.mermail_eventname = '$eventcompo' AND mermail_merchantid ='$mid' ";
                                $res2=mysqli_query($con,$sql2);

                                $event =$eventcompo;


                                            while ($row=mysqli_fetch_object($res2))

                                            {
                                             			$from    		=	stripslashes(trim($row->mermail_from));
                                               			$sub	 		=	stripslashes(trim($row->mermail_subject));
                                             			$body   		=	stripslashes(trim($row->mermail_message));
                                               			$header  	    =	stripslashes(trim($row->mermail_header));
                                               			$footer 	    =	stripslashes(trim($row->mermail_footer));

                                            }

                                }


                               if($fromtxt=="" and $subjecttxt==""  and $headertxt=="" and $bodytxt== "" and $footertxt=="" )
                                {

                                        $sql1del	="Delete from `partners_mermail` where  mermail_merchantid = '$_SESSION[MERCHANTID]' and  mermail_eventname = '$eventcompo'";
										mysqli_query($con,$sql1del);
                                        echo mysqli_error($con);
                                }
                }
    }


/*       $from        =        $_GET['from'];
       $sub         =        $_GET['sub'];
       $event       =        $_GET['event'];
       $status      =        $_GET['status'];
       $to          =        $_GET['to'];

       $body        =        stripslashes($_SESSION['BODY']);
       $header      =        stripslashes($_SESSION['HEADER']);
       $footer      =        stripslashes($_SESSION['FOOTER']);*/


    ?>



<form name="f1" method="post" action=""  >

   &nbsp;&nbsp;&nbsp; <big><a href="index.php?Act=paidmail"><img src="../images/mail.gif" border="0" alt="" /> <?=$lemail_ClickToSendPaidMails?></a> </big>
    <table border="0" cellpadding="0" cellspacing="0"  width="80%" class="tablebdr" align="center">
    <tr>
    <td width="4">&nbsp;</td>
    <td width="473">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="246">&nbsp;</td>
    <td width="4">&nbsp;</td>
    </tr>
    <tr>
    <td width="4">&nbsp;</td>
    <td width="473">
  <table border="0" cellpadding="0" align='center' style="border-collapse: collapse" class="tablebdr" width="97%" id="AutoNumber1" cellspacing="0">
    <tr>
      <th width="119%" colspan="4" class="tdhead" height="19"><?=$lemail_EmailMessages?></th>
    </tr>
    <tr>
      <td width="119%" height="19" colspan="4" align="center" class="textred"><?=$msg ?></td>
    </tr>


    <tr>
      <td width="17%" height="19" >&nbsp;</td>
      <td width="35%" height="19" ><?=$lemail_ActiveMessages?></td>
      <td width="67%" height="19" class="textred" colspan="2" >: <?=$num?></td>
    </tr>
    <tr>
      <td width="23%" height="28" class="body">&nbsp;</td>
      <td width="71%" height="28"><?=$lemail_ChooseAction?> </td>
      <td width="25%" height="28" class="body" colspan="2" >

<?
        if($num>0)
        {
?>
      <select size="1" name="eventcompo"  onchange="document.f1.submit()">


      <?

      while($row = mysqli_fetch_object($res100))
               {
               if (trim($event)==trim($row->event_name))
                {
                                           $var="selected";
               }
               else {
                                           $var="";
               }

      ?>
               <option  value="<?=$row->event_name?>"  <?= ($eventcompo==$row->event_name ? "selected" : ""  ) ?> > <?=$row->event_name?> </option>
      <?
               }


      ?>

      </select>

<?php
      }
      else
      {
       	echo "<div align='left' class='textred'>$labg_no_active</div>";
      }

?>
      </td>
    </tr>



    <tr>
      <td width="11%" height="38" class="body">&nbsp;</td>
      <td width="49%" height="38"><?=$lemail_From?></td>
      <td width="67%" height="38" colspan="2" ><input type="text" name="fromtxt" size="27" value="<?=$from ?>" /></td>
    </tr>
    <tr>
      <td width="11%" height="43" class="body">&nbsp;</td>
      <td width="49%" height="43"><?=$lemail_Subject?></td>
      <td width="67%" height="43" colspan="2" ><input type="text" name="subjecttxt" size="27" value="<?=$sub ?>" /></td>
    </tr>
    <tr>
     <th align="center"width="119%" colspan="4" class="tdhead" height="19">
      <?=$lemail_PleasePastHTMLcodeonHeaderBodyandFooterFields?></th>
    </tr>
    <tr>
     <td align="center"width="119%" colspan="4"  height="19">&nbsp;

     </td>
    </tr>
    <tr>
      <td width="11%" height="32" class="body">&nbsp;</td>
      <td width="49%" height="32"><?=$lemail_Header?></td>
      <td width="67%" height="32" colspan="2" >
      <textarea rows="2" name="headertxt" cols="41"><?=$header?></textarea></td>
    </tr>
    <tr>
      <td width="11%" height="148" class="body">&nbsp;</td>
      <td width="49%" height="148"><?=$lemail_Body?></td>
      <td width="67%" height="148" colspan="2" >
      <textarea rows="8" name="bodytxt" cols="41" class="bodytxt"><?=$body ?></textarea></td>
    </tr>
      <tr>
      <td width="11%" height="24" >&nbsp;</td>
      <td width="49%" height="24"  ><?=$lemail_Footer?></td>
      <td width="67%" height="24" colspan="2" >
      <textarea rows="2" name="footertxt" cols="41"><?=$footer ?></textarea></td>

    </tr>
      <tr>
      <td width="11%" height="6" >
      </td>
      <td width="49%" height="6"  ></td>
      <td width="67%" height="6" colspan="2" >
      </td>

    </tr>
    <tr>
      <td width="11%" height="20" >&nbsp;</td>
      <td width="49%" height="20" >
      </td>
      <td width="34%" height="20"  align="left">

<?
        if($num>0)
        {

?>
      <input type="Submit" value="<?=$lemail_Update?>" name="B1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?

		}
?>
       </td>
	   <td width="33%" height="20" >&nbsp;</td>
    </tr>
    <tr>
      <td width="11%" height="5" ></td>
      <td width="49%" height="5"  ></td>
      <td width="67%" height="5" colspan="2" >
      </td>

    </tr>

    <!--tr>

      <td width="11%" height="20" class="tdhead" >
      <td width="49%" height="20" class="tdhead" ><?=$lemail_Test?></td>
      <td width="67%" height="20" class="tdhead" colspan="2" >
      <input type="text" name="to" size="28" value =<?=$to?> >&nbsp;&nbsp;&nbsp;
      <input type="submit" value="TestSend" title="<?=$lemail_TestSend?>" name="B1"></td>


    </tr-->
  </table>
 </td>
 <td width="4">&nbsp;</td>
 <td width="1" valign="top">
            <table bgcolor="#ffffff" border="1" cellpadding="5" cellspacing="0"
            width="100%" class="tablebdr" style="border-collapse: collapse">

              <tr>
                <td align="center" bgcolor="#FFFFFF" class="tdhead"><b><?=$lemail_AffiliateVariables?></b>
				</td></tr><!-- variable table starts here -->
              <tr>
                <td align="center">

                  <table border="0" cellpadding="2" cellspacing="0"
                  width="237" class="tablewbdr" style="border-collapse: collapse" >

                    <tr bgcolor="#eeeeee">
                      <td width="86" bgcolor="#FFFFFF" class="grid1"><b>[firstname] </b> </td>
                      <td align="left" width="140" bgcolor="#FFFFFF" class="grid1"><?=$lemail_FirstName?> </td></tr>
                    <tr bgcolor="#eeeeee">
                      <td width="86" bgcolor="#FFFFFF"><b>[lastname]</b></td>
                      <td align="left" width="140" bgcolor="#FFFFFF"><?=$lemail_SecondName?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td width="86" bgcolor="#FFFFFF" class="grid1"><b>[company]</b></td>
                      <td align="left" width="140" bgcolor="#FFFFFF" class="grid1"><?=$lemail_CompanyName?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td width="86" bgcolor="#FFFFFF"><b>[password]</b></td>
                      <td align="left" width="140" bgcolor="#FFFFFF"><?=$lemail_AffiliatePassword?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td width="86" bgcolor="#FFFFFF" class="grid1"><b>[affemail]</b></td>
                      <td align="left" width="140" bgcolor="#FFFFFF" class="grid1"><?=$lemail_AffiliateEmail?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td width="86" bgcolor="#FFFFFF"><b>[from]</b></td>
                      <td align="left" width="140" bgcolor="#FFFFFF"><?=$lemail_MerchantEmail?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td width="86" bgcolor="#FFFFFF" class="grid1"><b>[loginlink]</b></td>
                      <td align="left" width="140" bgcolor="#FFFFFF" class="grid1"><?=$lemail_AffiliateLoginLink?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td width="86" bgcolor="#FFFFFF"><b>[today]</b></td>
                      <td align="left" width="140" bgcolor="#FFFFFF"><?=$lemail_CurrentTime?></td></tr></table>

                </td></tr><!-- End Quickstats --><!-- Start Run Reports -->
              <tr bgcolor="#cccccc">
                <td align="center" bgcolor="#FFFFFF" class="tdhead"><b>
                <?=$lemail_Transaction?></b></td></tr>
              <tr>
                <td align="center">

                  <table border="0" cellpadding="2" cellspacing="0"
                  width="237" class="tablewbdr" style="border-collapse: collapse" >

                    <tr bgcolor="#eeeeee">
                      <td bgcolor="#FFFFFF" class="grid1" width="86" height="19"><b>
                      [type]</b></td>
                      <td align="left" bgcolor="#FFFFFF" class="grid1" width="143" height="19">
                      <?=$lemail_ieclickleadsale?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td bgcolor="#FFFFFF" width="86" height="19"><b>[commission]</b></td>
                      <td align="left" bgcolor="#FFFFFF" width="143" height="19">
                      <?=$lemail_Commision?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td bgcolor="#FFFFFF" class="grid1" width="86" height="19"><b>
                      [date]</b></td>
                      <td align="left" bgcolor="#FFFFFF" class="grid1" width="143" height="19">
                      <?=$lemail_DateofTransaction?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td bgcolor="#FFFFFF" width="86" height="19"><b>[program]</b></td>
                      <td align="left" bgcolor="#FFFFFF" width="143" height="19">
                      <?=$lemail_ProgramName?></td></tr>
                    <tr bgcolor="#eeeeee">
                      <td bgcolor="#FFFFFF" width="86" class="grid1" height="0%">&nbsp;</td>
                      <td align="left" bgcolor="#FFFFFF" width="143" class="grid1" height="0%">&nbsp;</td></tr></table>
                </td></tr></table></td>
     <td width="4">&nbsp;</td>
   </tr>
   <tr>
     <td width="4">&nbsp;</td>
     <td width="473">&nbsp;</td>
     <td width="4">&nbsp;</td>
     <td width="246">&nbsp;</td>
     <td width="4">&nbsp;</td>
   </tr>
   <tr>
     <td width="4">&nbsp;</td>
     <td width="473">&nbsp;</td>
     <td width="4">&nbsp;</td>
     <td width="246">&nbsp;</td>
     <td width="4">&nbsp;</td>
   </tr>
 </table>

</form><br />