<?php ob_start();
    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
     include_once '../includes/allstripslashes.php';

    $id = intval($_GET['id']);


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

        include_once 'language_include.php';

    function disp(&$url,&$text,&$description,&$image)
    {
				$id = intval($_GET['id']);
				
                $sql="select * from partners_text where text_id ='$id'";
                //echo $sql;
                $res=mysqli_query($con,$sql);
                $row=mysqli_fetch_object($res);
                $url                = trim( $row->text_url);   
                $text               = trim($row->text_text);
                $description        = trim($row->text_description);
                $image              = trim($row->text_image) ;
    }



      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
            $tourl = trim($_POST['url']);
                        # if the 1st part of the URL not contain http:/
                        $url_test = substr($tourl, 0, 7);
                        if($url_test!="http://")
                        {
                                $tourl   =    "http://".$tourl;
                        }

            $totext = trim($_POST['text']);
            $todescription = trim($_POST['description']);
            $toimage   = trim($_POST['image']);

            //echo $todescription,$tourl,$toetext;

           if($tourl=="" || $totext=="" || $todescription=="")
           {
                  echo "<h5 class='textred' align='center'>Dont leave any Field as Blank !!</h5>";
           }
           else
           {
            $sql="update partners_text set ".
			" text_url='".addslashes($tourl)."', ".
			" text_text='".addslashes($totext)."', ".
			" text_description='".addslashes($todescription)."', ".
			" text_image='".addslashes($toimage)."'   where text_id='$id'";

            mysqli_query($con,$sql);


            mysqli_error($con);

                  echo "<script language='javascript' type='text/javascript'>  window.opener.location.href='index.php?Act=add_textnew'; </script>";
            echo "<h5 class='textred' align='center'>Text Updatted.. !!</h5>";

            disp($url,$text,$description,$image);


           }



      }
      else
      {
        disp($url,$text,$description,$image);
      }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Affiliate Network Pro</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="stylesheet" type="text/css" href="style.css" />
 </head>
<body>

<form method="post" action="" >
        <table align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  width="65%" id="AutoNumber2" >
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead">
            <b><?=$ltextadd_UpdateTextLinks?></b></td>
          </tr>
          <tr>
            <td width="100%" colspan="4" height="17" class="grid1">
            </td>
          </tr>
          <tr>
            <td width="2%" height="28" class="grid1">&nbsp;</td>
            <td width="35%" height="28" class="grid1"><b><?=$ltextadd_URL?></b></td>
            <td width="61%" height="28" class="grid1">
			<input type="text" name="url" size="53" value="<?=stripslashes($url)?>" />
			</td> 
            <td width="5%" height="28" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="29" class="grid1">&nbsp;</td>
            <td width="35%" height="29" class="grid1"><b><?=$ltextadd_Text?></b></td>
            <td width="61%" height="29" class="grid1">
            <input type="text" name="text" size="53" value="<?=stripslashes($text)?>" />
			</td>
            <td width="5%" height="29" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="95" class="grid1">&nbsp;</td>
            <td width="35%" height="95" class="grid1" valign="top"><b><?=$ltextadd_Description?></b></td>
            <td width="61%" height="95" class="grid1">
            <textarea rows="5" name="description" cols="44"><?=stripslashes($description)?></textarea></td>
            <td width="5%" height="95" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="29" class="grid1">&nbsp;</td>
            <td width="35%" height="29" class="grid1"><b><?=$text_image?></b></td>
            <td width="61%" height="29" class="grid1">
            <input type="text" name="image" size="53" value="<?=stripslashes($image)?>" /></td>
            <td width="5%" height="29" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="3" class="grid1"></td>
            <td width="35%" height="3" class="grid1"></td>
            <td width="61%" height="3" class="grid1">
            </td>
            <td width="5%" height="3" class="grid1"></td>
          </tr>
          <tr>
            <td width="100%" height="1" class="grid1" colspan="4" align="center">
            <input type="submit" value="<?=$common_edit?>" name="B1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="<?=$common_close?>" name="B2" onclick="window.parent.location.href=window.parent.location;window.close()" /></td>
          </tr>
        </table>
</form>
</body>
</html>