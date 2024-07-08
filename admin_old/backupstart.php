<?php	ob_start();

include "../includes/constants.php";
$dbhost = $host;
$dbname = $db;

$base_url    = "http://".$_SERVER['SERVER_NAME'];
$directory   = $_SERVER['PHP_SELF'];
$script_base = "$base_url$directory";
$base_path   = $_SERVER['PATH_TRANSLATED'];
$root_path_www = $_SERVER['DOCUMENT_ROOT'];
$remove_end  = strrchr($root_path_www,"/");
$root_path   = ereg_replace("$remove_end", '', $root_path_www);
$url_base    = "$base_url$directory";
$url_base    = ereg_replace("backupstart.php", '', "$_SERVER[PATH_TRANSLATED]");

$scr 	= "backupstart.php";
$dir 	= $_SERVER['PHP_SELF'];
$bas_path = $_SERVER['PATH_TRANSLATED'];
$url_bas = ereg_replace("$scr", '', "$_SERVER[PATH_TRANSLATED]");
//$path        = ereg_replace("main.php",'',$url_base);
//extract($_POST);

//if ($send2 == "  Find  ") {
  $conn = @mysql_connect($dbhost,$user,$pass);
  /*if ($conn==FALSE)
  {
      die("<br/>ERROR: cannot connect to database<br/>" );
 }*/
  $tables = mysql_list_tables($dbname,$conn);
  $num_tables = @mysql_num_rows($tables);
  if ($num_tables==0) {
     die("ERROR: Database contains no tables");
  }
//echo $path;
  $fp3 = fopen ($path."dbinfo.php","wb");
  fwrite ($fp3,"<?\n");
  fwrite ($fp3,"\$dbhost=\"$dbhost\";\n");
  fwrite ($fp3,"\$dbuser=\"$dbuser\";\n");
  fwrite ($fp3,"\$dbpass=\"$dbpass\";\n");
  fwrite ($fp3,"\$dbname=\"$dbname\";\n");
  fwrite ($fp3,"\$path=\"$url_bas\";\n");
  $i = 0;
  while($i < $num_tables) {
      $tbl = mysql_tablename($tables, $i);

      fwrite ($fp3,"\$table$i=\"$tbl\";\n");
      $i++;
  }
  $i--;
  fwrite ($fp3,"\$numtables=\"$i\";\n");
  fwrite ($fp3,"?>\n");
  fclose ($fp3);
  //chmod($path."dbinfo.php", 0644);
  include ("dbinfo.php");

/*} else {
  if (!file_exists("dbinfo.php")) {
    echo "<meta http-equiv=Refresh  content='0;URL=index.php'>
    ";
    die("Start from index.php");
  }*/
 /* include "dbinfo.php";
  $conn = @mysql_connect($dbhost,$dbuser,$dbpass);
  if ($conn==FALSE) {
      die("<br/>ERROR: cannot connect to database<br/>" );
  }
}  */
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
<TABLE WIDTH="914" border='0' align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="69" bgcolor="#FFFFFF">
			<table width="100%"  border='0' cellspacing="0" cellpadding="0">
          	<tr>
            	<td width="341"><img src="images/logo.jpg" width="341" height="112" alt=""></td>
            	<td height="69" align="right" valign="middle">&nbsp;</td>
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
		<td height="27" bgcolor="#FFFFFF">
<?php
$c=0;
$tables="";
while ($c < $numtables){
   $var="table$c";
   $tables .= $$var."; ";
   $c++;
}
$var="table".$c;
$tables .= $$var;
//include 'header.php';
?>

<center>
  <!--backup.-->
<table width="98%" border='0' align="center" cellpadding=5 cellspacing=1 >
  <tr align=center>
    <td >
	<form name="dobackup" method="post" action="backup.php">
	<table width="78%" border='0' align="center" cellpadding="5" cellspacing="1" class="tablebdr">
 	   <tr>
	        <td colspan="5"  align="center" class="tdhead"><strong>CREATE DATABASE BACKUP</strong>
	    </td>
	    </tr>
	  <tr >
	    <td colspan="5" height="20" align="center"><?=$_GET['msg'];?></td>
	  </tr>
		
	    <tr>
	        <td colspan="5"  align="center" class="text1"><span class="styleback"><font size="1">Backup Will be stored on the server. </font></span></td>
	    </tr>
	    <tr>
	        <td colspan="5"  align="center" class="text1"><span class="styleback"><font size="1">You can View / Restore / Download / Delete the backup file using Restore option</font></span></td>
	    </tr>
	    <tr>
	        <td colspan="5"  align="center" class="text1" height="1" >
	           <input name='send2' type='submit'  value ='Backup' onClick="javascript:alert('Backup Complete')" ></td>
	    </tr>
	</table>
	</form><br />
	<form name="dorestore" method="post" action="restore.php"> <!--restore.-->
    <table width="78%" border='0' cellpadding="5" cellspacing="1" align="center" class="tablebdr">
	    <tr>
	    	<td height="24" align="center" class="tdhead"><b>RESTORE A BACKUP</b></td>
	    </tr>
	    <tr><td height="54"  align="center" class="styleback"><font size="1">Backup must be on server</font></td>
	    </tr>
	    <tr>
	    	<td height="1" align="center" class="text1" >
	        <input name="send" type="submit" value="Restore"  onClick="javascript:alert('Restore Backup')">     </td>
	    </tr>
    </table>
	</form><br />
	<form  method="post" enctype="multipart/form-data" name="dodelete" action="backupupload.php"> <!--backupupload. -->
	<center>
    <table width="78%"  border='0' cellpadding="5" cellspacing="1" align="center" class="tablebdr" >
        <tr>
          <td colspan="3" align="CENTER" class="tdhead"><b>UPLOAD BACKUP</b></td>
        </tr>
        <tr>
        	<td height="1" colspan="3" class="text1"></td>
       	</tr>
        <tr>
        	<td colspan="3" align="center" class="styleback" ><small>File being uploaded should be a <strong>*.sql</strong> file and should be backed up<br/>
with the<strong> backup feature of this site</strong>. Otherwise restoring will produce<strong> unpredictable results</strong>. </small></td>
       	</tr>
        <tr>
        	<td colspan="3" align="center" class="styleback" ><font color="#FF0000"><small>Note:</small></font> <small>
			If a have a file on server with the name same as that of the file  being uploaded,
        		it will be replaced with the new one
			</small> </td>
       	</tr>
        <tr class="text1">
        	<td width="48%" align="right" class="styleback"><small>Select the Backup file to upload</small></td>
        	<td width="3%" align="center"  >:</td>
        	<td width="49%" align="left" ><input name="txtbackfile" type="file" id="txtbackfile"></td>
       	</tr>
        <tr>
        	<td colspan="3" align="center" class="text1" ><p>&nbsp;</p>        		</td>
       	</tr>
        <tr>
          <td colspan="3" class="text1" align="center">
              	<input name="send4" type="submit"  value="Upload" onClick="javascript:alert('Upload Backup')">
			</td>
        </tr>
     </table><br />
    </center>
  	</form>
	<input type="button" name="Button" value="Close this Window" onClick="javascript:window.close()" class="textbox">
	</td>
   </tr>
</table>
</center>
</td>
</tr>
	<br />
  <tr>
    <td align="center" class="footer-bg"><?php include "footer.php"; ?></td>
  </tr>

</table>
</body>
</html>