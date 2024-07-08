<?
// version 2.1 may 2004 Unix version
// for win32 replace with backup_timeout.php
include "../includes/constants.php";
include "dbinfo.php";

function get_def($dbname, $table) {
    global $conn;
    $def = "";
    $def .= "DROP TABLE IF EXISTS $table;#%%\n";
    $def .= "CREATE TABLE $table (\n";
    $result = mysql_db_query($dbname, "SHOW FIELDS FROM $table",$conn) or die("Table $table not existing in database");
    while($row = mysql_fetch_array($result)) {
        $def .= "    $row[Field] $row[Type]";
        if ($row["Default"] != "") $def .= " DEFAULT '$row[Default]'";
        if ($row["Null"] != "YES") $def .= " NOT NULL";
       	if ($row[Extra] != "") $def .= " $row[Extra]";
        	$def .= ",\n";
     }
     $def = ereg_replace(",\n$","", $def);
     $result = mysql_db_query($dbname, "SHOW KEYS FROM $table",$conn);
     while($row = mysql_fetch_array($result)) {
          $kname=$row[Key_name];
          if(($kname != "PRIMARY") && ($row[Non_unique] == 0)) $kname="UNIQUE|$kname";
          if(!isset($index[$kname])) $index[$kname] = array();
          $index[$kname][] = $row[Column_name];
     }
     while(list($x, $columns) = @each($index)) {
          $def .= ",\n";
          if($x == "PRIMARY") $def .= "   PRIMARY KEY (" . implode($columns, ", ") . ")";
          else if (substr($x,0,6) == "UNIQUE") $def .= "   UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")";
          else $def .= "   KEY $x (" . implode($columns, ", ") . ")";
     }

     $def .= "\n);#%%";
     return (stripslashes($def));
}

function get_content($dbname, $table) {
     global $conn;
     $content="";
     mysql_query("LOCK TABLES ".$table." WRITE");
     $result = mysql_db_query($dbname, "SELECT * FROM $table",$conn);
     while($row = mysql_fetch_row($result)) {
         $insert = "INSERT INTO $table VALUES (";
         for($j=0; $j<mysql_num_fields($result);$j++) {
            if(!isset($row[$j])) $insert .= "NULL,";
            else if($row[$j] != "") $insert .= "'".addslashes($row[$j])."',";
            else $insert .= "'',";
         }
         $insert = ereg_replace(",$","",$insert);
         $insert .= ");#%%\n";
         $content .= $insert;
     }
     mysql_query("UNLOCK TABLES");
     return $content;
}


extract($_POST);
//include 'header.php';
flush();
$conn = @mysql_connect($host,$user,$pass);
if ($conn==false)  die("password / user or database name wrong");
mysql_select_db($dbname,$conn);

   $x=$_SERVER[SERVER_SOFTWARE];
   if (strpos($x,"Win32")!=0) {
      $path = $path . "dump\\";
   } else {
      $path = $path . "dump/";
   }

   // If windows gives problems
   // FOR WINDOWS change to ==> $path = $path . "dump\\";

   if (!is_dir($path)) mkdir($path, 0766);
   //chmod($path, 0777);

	///$fp2 = fopen ($path."backup.sql","w");
        /*$copyr="# Table backup from MySql PHP Backup\n".
               "# AB Webservices 1999-2004\n".
               "# www.absoft-my.com/pondok\n".
               "# Creation date: ".date("d-M-Y h:s",time())."\n".
               "# Database: ".$dbname."\n\n" ;*/

	//fwrite ($fp2,$copyr);
	//fclose ($fp2);
     //   chmod($path."backup.sql", 0777);

   if(file_exists($path . "backup.gz"))
   {
       unlink($path."backup.gz");
   }
   $recreate = 0;

$filename = "backup-".date("d-m-Y");
$filetype = "sql";

if (!eregi("/restore\.",$PHP_SELF)) {
	$cur_time=date("Y-m-d H:i");
	$i = 0;
	while($i < $numtables+1) {
             // if ($tables[$i] != "") {
			 $tname = "table$i";
	         $newfile .= get_def($dbname,$$tname);
	         $newfile .= "\n\n";
	         if ($structonly!="Yes") {
	            $newfile .= get_content($dbname,$$tname);
	            $newfile .= "\n\n";
                 }
	      //}
	      $i++;
	}
	$fp = fopen ($path."$filename.$filetype","w");
	fwrite ($fp,$newfile);
	fwrite ($fp,"# Valid end of backup from $title Backup\n");
	fclose ($fp);
}
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
<TABLE WIDTH="914" border='0' align="center" cellpadding="0" cellspacing="0" height="530">
	<tr>
		<td height="114" bgcolor="#FFFFFF" >
			<table width="100%"  border='0' cellspacing="0" cellpadding="0">
          	<tr>
            	<!--<td width="216"><img src="images/admin_01.gif" width="216" height="69" alt=""></td>-->
	           	<td width="341"><img src="images/logo.jpg" width="341" height="112" alt=""></td>
            	<td height="112" align="right" valign="middle"></td>
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
		<td bgcolor="#FFFFFF"><TABLE WIDTH="80%" border='0' cellspacing="0" class="tablebdr" align="center">
	        <TR>
	          <TD height="26" valign="top" class="tdhead"><b>Partners Backup ::</b></TD>
	        </TR>
			<tr><td>&nbsp;   </td></tr>
	        <TR>
	          <TD height="100" valign="top" align="center"  >
				<strong>Your Backup request was processed Successfully.</strong>
	            <br/>
	            <font size="2">&nbsp;</font><center>
	                <font size="2">Use Restore Option to Restore the Backup data</font>
	          	</center>
              </TD>
	        </TR>
   			<TR>
      		  <TD height="27" align="right" valign="top" class="tdbackbold"><B><A HREF="main.php"><font color="#FFFFFF" size="1"><br/>
        </font></A> </B>
	  <small><a href="backupstart.php">Go Back to Main Screen &raquo;</a></small>     </TD>
    </TR>
    <TR>
      <TD height="15" valign="top" bgcolor="#FFFFFF"><div align="right"><font color="#9999CC" face="Arial, Helvetica, sans-serif" style="font-size:6Pt"></font> </div></TD>
    </TR>
  </TABLE>
  </TD>
</TR>
<br />
  <tr>
    <td align="center" class="footer-bg"><?php include "footer.php"; ?></td>
  </tr>

</TABLE>
