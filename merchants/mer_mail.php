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


<form name="f1" method="post" action="">
	<div class="row"> 
		<div class="col-md-8">
			<div class="card stacked-form">				
				<div class="card-header"> 
					<p><a href="index.php?Act=paidmail"><img src="../images/mail.gif" border="0" alt="" /> <?=$lemail_ClickToSendPaidMails?></a></p>
					<h4 class="card-title"><?=$lemail_EmailMessages?></h4>
					<span class="textred"><? echo $msg ?></span>
				</div>	
				<div class="card-body"> 
					<div class="form-group">
						<label><?=$lemail_ActiveMessages?><span class="textred span_font" colspan="2" >: <?=$num?></span></label>						
					</div>
					<div class="form-group">
						<label><?=$lemail_ChooseAction?></label>
						<?
							if($num>0)
							{
						?>
						<select name="eventcompo" class="form-control" onchange="document.f1.submit()">
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
					</div>
					<div class="form-group">
						<label><?=$lemail_From?></label>
						<input type="text" class="form-control" name="fromtxt" size="27" value="<?=$from ?>" />
					</div>
					<div class="form-group">
						<label><?=$lemail_Subject?></label>
						<input type="text" class="form-control" name="subjecttxt" size="27" value="<?=$sub ?>" />
					</div>
					
					<p><b><?=$lemail_PleasePastHTMLcodeonHeaderBodyandFooterFields?></b></p>
					
					<div class="form-group">
						<label><?=$lemail_Header?></label>
						<textarea rows="2" name="headertxt" class="form-control textarea_contrl"><?=$header?></textarea>
					</div>
					<div class="form-group">
						<label><?=$lemail_Body?></label>
						<textarea rows="5" name="bodytxt" class="form-control textarea_contrl bodytxt"><?=$body ?></textarea>
					</div>
					<div class="form-group">
						<label><?=$lemail_Footer?></label>
						 <textarea rows="2" name="footertxt" class="form-control textarea_contrl"><?=$footer ?></textarea>
					</div>
					<div class="form-group text-center">
						<?
							if($num>0)
							{
						?>
						  <input type="Submit" class="btn btn-fill btn-info" value="<?=$lemail_Update?>" name="B1" />
						<?
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- Affiliate variable starts here -->
		<div class="col-md-4">
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lemail_AffiliateVariables?></h4>
				</div>	
				<div class="card-body"> 
					<div class="form-group label_group">
						<label><b>[firstname]:</b>&nbsp;&nbsp;<?=$lemail_FirstName?></label>
						<label><b>[lastname]:</b>&nbsp;&nbsp;<?=$lemail_SecondName?></label>
						<label><b>[company]:</b>&nbsp;&nbsp;<?=$lemail_CompanyName?></label>
						<label><b>[password]:</b>&nbsp;&nbsp;<?=$lemail_AffiliatePassword?></label>
						<label><b>[affemail]:</b>&nbsp;&nbsp;<?=$lemail_AffiliateEmail?></label>
						<label><b>[from]:</b>&nbsp;&nbsp;<?=$lemail_MerchantEmail?></label>
						<label><b>[loginlink]:</b>&nbsp;&nbsp;<?=$lemail_AffiliateLoginLink?></label>
						<label><b>[today]:</b>&nbsp;&nbsp;<?=$lemail_CurrentTime?></label>
					</div>
				</div> 
			</div>
			
			<!-- Transaction Start Here -->
			
			<div class="card stacked-form">
				<div class="card-header">
					<h4 class="card-title"><?=$lemail_Transaction?></h4>
				</div>	
				<div class="card-body"> 
					<div class="form-group label_group">
						<label><b>[type]:</b>&nbsp;&nbsp;<?=$lemail_ieclickleadsale?></label>
						<label><b>[commission]:</b>&nbsp;&nbsp;<?=$lemail_Commision?></label>
						<label><b>[date]:</b>&nbsp;&nbsp;<?=$lemail_DateofTransaction?></label>
						<label><b>[program]:</b>&nbsp;&nbsp;<?=$lemail_ProgramName?></label>
					</div>
				</div> 
			</div>
		</div>
	</div>
	
  
  <table border="0" cellpadding="0" align='center' style="border-collapse: collapse" class="tablebdr" width="97%" id="AutoNumber1" cellspacing="0">   
    <!--tr>
      <td width="11%" height="20" class="tdhead" >
      <td width="49%" height="20" class="tdhead" ><?=$lemail_Test?></td>
      <td width="67%" height="20" class="tdhead" colspan="2" >
      <input type="text" name="to" size="28" value =<?=$to?> >&nbsp;&nbsp;&nbsp;
      <input type="submit" value="TestSend" title="<?=$lemail_TestSend?>" name="B1"></td>
    </tr-->
  </table>

</form>