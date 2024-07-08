<?php

	include '../includes/session.php';
	include '../includes/constants.php';
	include '../includes/functions.php';
	include_once '../includes/allstripslashes.php';
	include"header.php";
	
	$partners	= new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$merid		= intval(intval($_GET['id']));
	$loginflag	= $_GET['loginflag'];
	$tick		= "checked";

    //// sub form  valid
	if(isset($B1))
	{
		$err	= "";
        $mailid	= $_POST['mailid'];
        $pwd	= $t1;
        $conpass= $t2;
        $cb		= $_POST['C1'];
        if ($cb=$_POST['C1']=="ON")
        {
          $tick="checked";
        }
        else
        {
          $tick="";
        }
        if($pwd=="" or $conpass=="")
        {
       		 $merid		=$_POST['merid'];
	   		 $loginflag	=$_POST['loginflag'];
         	 $ok		="Please Dont leave any Field as Blank";
       }
       else if ($pwd!=$conpass) {
			$merid=$_POST['merid'];
			$loginflag=$_POST['loginflag'];
			$ok="Password and Confirm Password Should Be Same";

        }
             else
             {
              $merid=$_POST['merid'];
			  $loginflag=$_POST['loginflag'];
        	  $updatesql="UPDATE partners_login SET login_password = '$pwd' WHERE login_id = '$merid' and login_flag='$loginflag' ";
              $res=mysql_query($updatesql) or die("dasda");
         	  $ok="Your Password has been Changed !!";
              $mailok="Didn't send any mail now";

            ////////////// notification mail

             if ($cb=$_POST['C1']=="ON")  /// mail sending
              {
				$sql="select * from partners_admin";
				$res=mysql_query($sql);

	     	while($row=mysql_fetch_object($res))
		    	{
                      $from=$row->admin_email ;
       				  echo "$from";
		     	}

                 $message="your password has been changed by super Admin\n";
                 $message .="Your Password Id is ".$pwd;
				 $to=$mailid;
                 $sub="Password Change Notification Mail";
                 $headers = "Content-Type: text/html; charset=iso-8859-1\n";
	             $headers .= "From:  <$from>\n";
                 mail($to,$sub,$message, $headers);
                 $mailok="Password Change Notification Mail Has been Send \n";
                 $mailok .= " To :".$to." \n";
                 $mailok.=" From :".$from;

            }
         }
    }
        ///////////// sub mitted form pross end



//echo "$loginflag,$merid";

$sql="select * from partners_login where login_id='$merid' and login_flag='$loginflag'";

$res=mysql_query($sql);

while($row=mysql_fetch_object($res))
{
         $lid=$row->login_email ;
}

?>


<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
	function button1_onclick() {
	window.close();
}
</SCRIPT>
<html>


<body>

<form method="post" action="change_mer_pass.php " id=f1>
 <table border='0' cellpadding="0" cellspacing="0" style="WIDTH: 385px; BORDER-COLLAPSE: collapse; HEIGHT: 168px" bordercolor="#111111" width="385" id="tbl" height="168" class="tablebdr">
    <tr>
      <td width="100%" colspan="3" height="19" class="tdhead">
      <p align="center">Change Password</p> </td>
    </tr>
    <tr>
      <td width="100%" colspan="3" height="19" >
      <p align="center" class="textred"><?=$ok?></p> </td>
    </tr>

    <tr>
      <td width="2%" height="25">&nbsp;</td>
      <td width="48%" height="25">Email ID </td>
      <td width="50%" height="25"><?= $lid?></td>
    </tr>
    <tr>
      <td width="2%" height="22">&nbsp;</td>
      <td width="48%" height="22">Password</td>
      <td width="50%" height="22"><input name="t1" id=t1 value=<?=$pwd?>></td>
    </tr>
    <tr>
      <td width="2%" height="27">&nbsp;</td>
      <td width="48%" height="27">Confirm Password</td>
      <td width="50%" height="27"><input name="t2" id=t2 value=<?=$conpass?> ></td>
    </tr>
    <tr>
      <td width="100%" colspan="3" height="29">
      <p align="center"><input type="checkbox" name="C1" value="ON"
      id=chk1 <?=$tick?> > Send a Notification Mail To Merchant with
      new Password</p>
            </td>
    </tr>
    <tr>
      <td width="100%" colspan="2" height="23" class="tdhead">
      <p align="center">
      <input type="submit" value="Change " name ="B1"></p></td>
    <TD class=tdhead width="100%" height=23>
      <P align=center><INPUT id="button1" type="button" value="close" name="button1" LANGUAGE="javascript" onClick="return button1_onclick()"></P></TD>
    </tr>
    <tr>
      <td width="100%" colspan="3" height="19" >
      <p align="center" class="textred"><?=$mailok?></p> </td>
    </tr>

  </table>

  <p> <INPUT type=hidden name="merid" value='<?=$merid?>' >
  <INPUT type=hidden name=loginflag value='<?=$loginflag?>' >
  <INPUT type=hidden name=mailid value='<?= $lid?>' >
  </p>
</form>

</body>

</html>