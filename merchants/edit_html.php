<?php		ob_start();
    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
    include_once '../includes/allstripslashes.php';

    $id = intval($_GET['id']);


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';

    function disp(&$text)
    {

     $id=$_GET['id'];
     $sql="select * from partners_html where html_id='$id'";
    $res=mysqli_query($con,$sql);
          $row=mysqli_fetch_object($res);

    $text=$row->html_text;


    }



      if($_SERVER['REQUEST_METHOD']=="POST")
      {
			$totext=addslashes(trim($_POST['t1']));
			$totext = str_replace("\r\n","",$totext);


           if($totext=="")
           {
                  echo "<h5 class='textred' align='center'>Dont leave any Field as Blank !!</h5>";
           }
           else
           {
            $sql="update partners_html set html_text='$totext' where html_id='$id' ";
				mysqli_query($con,$sql);
				mysqli_error($con);
  echo "<script language='javascript' type='text/javascript'>  window.opener.location.href='index.php?Act=add_html'; </script>";
            echo "<h5 class='textred' align='center'>Html Updatted.. !!</h5>";

            disp($text);


           }



      }
      else
      {
        disp($text);
      }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="stylesheet" type="text/css" href="style.css" />
 </head>
<body>

<form method="post" action="" >
 <table border="0" cellpadding="0" cellspacing="0" class="tablebdr" width="77%" id="AutoNumber2"  align="center">
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead" align="center">
            <b><?= $laddhtml_EditHtml?></b></td>
          </tr>
          <tr>
            <td width="100%" colspan="4" height="15" class="grid1">
            </td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?= $laddhtml_HTML?></b></td>
            <td width="62%" height="22" class="grid1">
            <textarea rows="6" name="t1" cols="44" id="t1"><?=htmlspecialchars(stripslashes($text))?></textarea></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="20%" height="19" class="grid1">&nbsp;</td>
            <td width="77%" height="19" class="grid1">
            </td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="1" class="grid1"></td>
            <td width="20%" height="1" class="grid1"></td>
            <td width="77%" height="1" class="grid1"></td>
            <td width="1%" height="1" class="grid1"></td>
          </tr>
          <tr>
            <td width="2%" height="64" class="grid1">&nbsp;</td>
            <td width="97%" height="64" class="grid1" colspan="2" >

                <a href='temp.php?rowid=<?=$id ?>' target="new">
                <img src='images/html.gif' border='0' width="308" height="60" align="right" alt="" /></a></td>
            <td width="1%" height="64" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="97%" height="19" class="grid1" colspan="2" >

            </td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%" height="19" class="tdhead" colspan="4" align="center">
            <input type="submit" value="<?=$common_edit?>" name="B1" />&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="<?=$common_close?>" name="Close" onclick="window.close()" /></td>
          </tr>
        </table>
        <p>&nbsp;</p>
</form>

</body>

</html>