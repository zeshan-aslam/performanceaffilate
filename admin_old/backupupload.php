<?php	ob_start();
	//This section upload the back up file to your server
	//check whether file selected
	if (empty($_FILES['txtbackfile']['name']))
	{
		header ("Location:backupstart.php?msg=Select the File to upload");
		exit;
	}

	$filname = $_FILES['txtbackfile']['name'];
    $tmp     = explode(".",$filname);
    if($tmp[1] != 'sql')
    {
        header ("Location:backupstart.php?msg=Please Select an SQL file to upload");
        exit;
    }

	$dest = "dump/$filname";

	copy($_FILES['txtbackfile']['tmp_name'],$dest);

    //include 'header.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
<HEAD>
<TITLE>Affiliate Network Pro - Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<meta name="generator" content="Namo WebEditor v5.0(Trial)">
<link rel="stylesheet" type="text/css" href="admin.css">
<link rel="stylesheet" type="text/css" href="includes/admin.css">
</HEAD>
<body bgcolor="#f4f4f4" link="#000000" alink="#000000" vlink="#000000">
<TABLE WIDTH=775 border='0' align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="69" bgcolor="#000000">
			<table width="100%"  border='0' cellspacing="0" cellpadding="0">
          	<tr>
            	<td width="216"><img src="images/admin_01.gif" width="216" height="69" alt=""></td>
            	<td height="69" align="right" valign="middle"></td>
          	</tr>
        	</table>
        </td>
	</tr>
	<tr>
		<td height="27" bgcolor="#999999">
		<CENTER>
	  	<br/>
	  	<TABLE WIDTH="80%" border='0' cellspacing="0" bgcolor="#8BA5C5" class="tablewbdr">
        	<TR>
	          <TD height="16" valign="top" class="tdhead">Partners Backup Upload ::</TD>
	        </TR>
        	<TR>
	          <TD height="50" valign="top" class="text1"> <h4>&nbsp;</h4>
	            <center>
	                    <p><b><font color="#990000">Your Backup File Upload  processed Successfully.</font></b></p>
	            </center>
	            <br/>
	            <font size="2">&nbsp;</font><center>
	            <font size="2">Use Restore Option to Restore the Backup data</font>
	          </center>      </TD>
	        </TR>
	        <TR>
	          <TD height="27" align="right" valign="bottom" class="tdbackbold"><B><A HREF="main.php"><font color="#FFFFFF" size="1">        </font></A> </B>
	          <small><a href="backupstart.php">Go Back to Main Screen &raquo;</a></small>     </TD>
	        </TR>
	        <TR>
	          <TD height="15" valign="top" bgcolor="#FFFFFF"><div align="right"><font color="#9999CC" face="Arial, Helvetica, sans-serif" style="font-size:6Pt"></font> </div></TD>
	        </TR>
	  	</TABLE>
	  	<br/>
	  	<br/>
		</CENTER>
	    <div align="center">Copyright 2004 &copy; AlstraSoft Affiliate Network Pro. All Rights Reserved.</div>
        </td>
	</tr>
</table>
</body>
</html>

 <?/* include 'footer.php'*/?>