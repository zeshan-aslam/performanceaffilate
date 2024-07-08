<?php		ob_start();
    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
     include_once '../includes/allstripslashes.php';

    $id = intval($_GET['id']);


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';

    function disp(&$url,&$type,&$width,&$height,&$scrollbar)
    {
     $id = intval($_GET['id']);
     $sql="select * from partners_popup where popup_id='$id'";
      //echo $sql;
    $res=mysqli_query($con,$sql);
          $row=mysqli_fetch_object($res);

    $url=$row->popup_url;
    $type=$row->popup_type;
    $width=$row->popup_width;
    $height=$row->popup_height;
    $scrollbar=trim($row->popup_scrollbar);

    }

      if($_SERVER['REQUEST_METHOD']=="POST")
      {
             		 $url=$_POST['url'];
                     $type=$_POST['type'];
                     $width=$_POST['width'];
                     $height=$_POST['height'];
                     $scrollbar=$_POST['scrollbar'];

           if($url=="" || $width=="" || $height=="")
           {
                  echo "<h5 class='textred' align='center'>Dont leave any Field as Blank !!</h5>";
           }
           else
           {
            //$sql="update partners_popup set popup_url='$url',popup_type='$type',popup_width=$width,popup_height=$height,popup_scrollbar='$scrollbar' where popup_id=$id";
			$sql="update partners_popup set ".
			" popup_url ='".addslashes($url)."' , ".
			" popup_type ='".addslashes($type)."' , ".
			" popup_width ='".addslashes($width)."' , ".
			" popup_height ='".addslashes($height)."' , ".
			" popup_scrollbar ='".addslashes($scrollbar)."'   where popup_id='$id'";
			
			
            mysqli_query($con,$sql);

             //echo $sql;
            mysqli_error($con);

  echo "<script language='javascript' type='text/javascript'>  window.opener.location.href='index.php?Act=add_popup'; </script>";
            echo "<h5 class='textred' align='center'>Popup Add Updatted.. !!</h5>";

            disp($url,$type,$width,$height,$scrollbar);


           }



      }
      else
      {
        disp($url,$type,$width,$height,$scrollbar);
         // echo $url,$type, $width,$height, $scrollbar;
      }

?>



<html>

<head>

<title>Partners Manager System - Merchants</title>
</head>
 <link rel="stylesheet" type="text/css" href="style.css">
<body>

<form method="POST" >
 <table border="0" cellpadding="0" cellspacing="0" class="tablebdr"  bordercolor="#111111" width="77%" id="AutoNumber2" height="267" align="center">
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead">
            <p align="center"><b><?=$laddpopup_EditPopup?></b></td>
          </tr>
          <tr>
            <td width="100%" colspan="4" height="15" class="grid1">
            <p align="center"></td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$laddpopup_PopUpType?></b></td>
            <td width="62%" height="22" class="grid1"><?=$laddpopup_PopUP?> <input type="radio" value="popup" <? if($type=='popup') echo "checked"; ?> name="type">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?=$laddpopup_UnderPopUp?> <input type="radio" name="type" <? if($type=='underpopup') echo "checked"; ?> value="underpopup"></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="20%" height="22" class="grid1"><b><?=$laddpopup_URL?></b></td>
            <td width="77%" height="22" class="grid1">
            <input type="text" name="url" size="47" value="<?=stripslashes($url)?>"></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="20%" height="19" class="grid1">&nbsp;</td>
            <td width="77%" height="19" class="grid1">
            (<?=$laddpopup_Example?>- <?=$laddpopup_yoursite?>)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="24" class="grid1">&nbsp;</td>
            <td width="35%" height="24" class="grid1"><b><?=$laddpopup_Dimensions?></b></td>
            <td width="62%" height="24" class="grid1">
            <input type="text" name="width" size="5" value="<?=$width?>"> <b>&nbsp;X&nbsp; </b>
            <input type="text" name="height" size="5" value="<?=$height?>"></td>
            <td width="1%" height="24" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1">&nbsp;</td>
            <td width="62%" height="19" class="grid1">(<?=$laddpopup_Example?>- 400 X 350)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1"><b><?=$laddpopup_Scrollbar?></b></td>
            <td width="62%" height="19" class="grid1"><?=$laddpopup_Yes?>
            <input type="radio" name="scrollbar" value="yes"   <? if($scrollbar=='yes') echo "checked"; ?> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?=$laddpopup_No?><input type="radio" name="scrollbar" value="no" <? if($scrollbar=='no') echo "checked"; ?>></td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="20%" height="19" class="grid1">&nbsp;</td>
            <td width="77%" height="19" class="grid1">
            <p align="left"></td>
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
            <p align="center">
                <a href='<?=$url?>' target="new">
                <img src='images/popup.gif' border='2' width="308" height="60" align="right"></a></td>
            <td width="1%" height="64" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="97%" height="19" class="grid1" colspan="2" >
            <p align="center">
            </td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%" height="19" class="tdhead" colspan="4" align="center">
            <input type="submit" value="<?=$common_edit?>" name="B1">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="<?=$common_close?>" name="Close" onClick="window.close()"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
</form>

</body>

</html>