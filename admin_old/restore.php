<?php	ob_start();


extract ($_REQUEST);
if (!file_exists("dbinfo.php")) {
   die("Cannot find backup info file, restore aborted");
}
include "../includes/constants.php";
include "dbinfo.php";
$password = $dbpass;

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
<body  link="#000000" alink="#000000" vlink="#000000">
<TABLE WIDTH="914" border='0' align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
		<td height="69" bgcolor="#FFFFFF">
			<table width="100%"  border='0' cellspacing="0" cellpadding="0">
          	<tr>
            	<!--<td width="216"><img src="images/admin_01.gif" width="216" height="69" alt=""></td>-->
				<td width="341"><img src="images/logo.jpg" width="341" height="112" alt=""></td>
            	<td height="69" align="right" valign="middle"></td>
          	</tr>
        	</table>
        </td>
	</tr>
			<tr>
		<td height="22" bgcolor="#FFFFFF">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td align="right" width="4"><img src="images/topbar-left.jpg" width="4" height="22" /></td>
				<td class="top-bar-tile">&nbsp;</td>
				<td align="left" width="4"><img src="images/topbar-right.jpg" width="4" height="22" /></td>
			  </tr>
			</table>
      </td>
	</tr>

	<tr>
		<td height="27" align="center" ><br />

  <table width="70%" border='0' cellspacing="2" class="tablebdr" height="290" >
    <tr>
      <td valign="top" class="tdhead" align="center"><b> Database :: Restore</b>
      </td>
    </tr>

<?
if (!isset($file)) {
    echo '
    <TR>
      <TD valign="top" class="text1">
        Below are your backup file(s). Click the Restore link to restore the backup.<br/><br/>
        <font color=\'#ff0000\'>Note:</font> By restoring your database, you will overwrite its current entries
        with the backup file. </TD>
    </TR> ';
} ?>

    <tr>
      <td valign="top" class="text1">
        <?
$x=  $_SERVER[SERVER_SOFTWARE];
if (strpos($x,"Win32")!=0) {
   $path = $path . "dump\\";
} else {
   $path = $path . "dump/";
}

// IF WINDOWS GIVES PROBLEMS
// FOR WINDOWS change to ==> $path = $path . "dump\\";
if ($file!="") {
      if (eregi("gz",$file)) { //zip file decompress first than show only
         @unlink($path."backup.sql");
         $fp2 = @fopen("dump/backup.sql","w");
         fwrite ($fp2,"");
	 fclose ($fp2);
         chmod($path."backup.sql", 0777);
         $fp = @fopen("dump/backup.sql","w");
         $zp = @gzopen("dump/$file", "rb");
         if(!$fp) {
              die("No sql file can be created");
         }
         if(!$zp) {
              die("Cannot read zip file");
         }
         while(!gzeof($zp)){
	      $data=gzgets($zp, 8192);// buffer php
	      fwrite($fp,$data);
         }
         fclose($fp);
         gzclose($zp);
         $file="backup.sql";
         echo " <br/>File backup.sql extracted from $file. <br/>";
         $file='';
      } // end of unzip
}
if ($file!=""){

      flush();
      $conn = mysql_connect($host,$user,$pass) or die(mysql_error());
	$filename = $file;
	set_time_limit(1000);
	$file=fread(fopen($path.$file, "r"), filesize($path.$file));
	$query=explode(";#%%\n",$file);
	for ($i=0;$i < count($query)-1;$i++) {
		mysql_db_query($dbname,$query[$i],$conn) or die(mysql_error());
	}
	echo "<table width=\"80%\" class=tablebdr align=center><tr><td align=\"left\"><b><b><font color=#990000>Your restore
request was processed.</font></b><br/><br/><small> If you did not receive any errors on the screen, then
you should find that your database tables have been restored. If you attemped to restore your
database using a backup file that was not created by this site, you likely encountered
errors. This site can <b>only</b> restore backups created by this	 site.</small><br/><br/></td></tr></table>";
}
?>
      </td>
    </tr>
    <tr>
      <td valign="top" class="tdbackbold"><table width="100%" cellspacing="0">
          <tr class="tdbackbold">
            <td width="125" height="21" align="left"><font size="2">&nbsp;<b>File</b></font></td>
            <td width="125" align="center"><font size="2"><b>Size</b></font></td>
            <td width="125" align="center"><font size="2"><b>Date</b></font></td>
            <td width="125"><font size="2">&nbsp;</font></td>
            <td width="125"><font size="2">&nbsp;</font></td>
          </tr>
          <?
	$dir=opendir($path);
	$file = readdir($dir);
	while ($file = readdir ($dir)) {
	    if ($file != "." && $file != ".." &&  (eregi("\.sql",$file) || eregi("\.gz",$file))){
	        if (eregi("\.sql",$file) ) {
			   echo "<tr><td nowrap class=text1 align=\"left\">&nbsp;<small><strong>$file</strong></small></td>
	        	 <td nowrap class=text1 align=\"center\" valign=middle><small><strong>".round(filesize($path.$file) / 1024, 2)." KB</strong></small></td>
	        	 <td nowrap class=text1 align=\"center\" valign=middle><small><strong>".date("d-m-Y",filemtime($path.$file))."</strong></small></td>
	        	 <td colspan=\"2\" nowrap align=\"center\" valign=middle><a href=\"restore.php?file=$file\"><small>Restore</small></a> /
				 <a href=\"dump/$file\" target=_blank><small>View</small></a> /
				 <a href=\"deletebackup.php?fl=$file\"><small>Delete</small></a> /
				 <a href=\"downloadbackup.php?fl=$file\"><small>Download</small></a>
				 </td></tr>";
	        } else {
	           echo "<tr><td nowrap bgcolor=\"#dddddd\" align=\"center\">$file</td>
	        	 <td nowrap bgcolor=\"#dddddd\" align=\"center\">".round(filesize($path.$file) / 1024, 2)." KB</td>
	        	 <td nowrap bgcolor=\"#dddddd\" align=\"center\">".date("d-m-Y",filemtime($path.$file))."</td>
	        	 <td nowrap align=\"center\"><a href=\"#\">Unzip</a></td>
	        	 <td></td></tr>";
               }
	    }
	}
	closedir($dir);
    ?>
        </table></td>
    </tr>
    <tr>
    	<td height="20" align="right" valign="top" class="text1">&nbsp;</td>
   	</tr>
    <tr>
      <td height="20" align="right" valign="top" class="text1"><small><a href="backupstart.php">Go Back to Main Screen &raquo;</a></small></td>
    </tr>
  </table>
</center>
<br />
  <tr>
    <td align="center" class="footer-bg"><?php include "footer.php"; ?></td>
  </tr>
        </table>
</BODY>
</HTML>
<?/* include 'footer.php'*/?>