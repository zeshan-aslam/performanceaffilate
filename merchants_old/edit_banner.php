<?php 	ob_start();
    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
    include_once '../includes/allstripslashes.php';

    $id = intval($_GET['id']);

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

	include_once 'language_include.php';

    function disp(&$url1,&$bannername2,&$bHeight, &$bWidth, &$bSize)
    {

     	$id				=	$_GET['id'];
     	$sql			=	"select * from partners_banner where banner_id='$id'";
        $res			=	@mysqli_query($con,$sql);
        $row			=	@mysqli_fetch_object($res);
    	$url1			=	$row->banner_url; 
    	$bannername2	=	$row->banner_name;
        $bHeight		=	$row->banner_height;
        $bWidth			=	$row->banner_width;
        $bSize			=   $bWidth."X".$bHeight   ;
    }



   if($_SERVER["REQUEST_METHOD"]=="POST")
   {
         # banner size
    	$bannerHeight		= intval($_POST['bannerHeight']);
    	$bannerWidth		= intval($_POST['bannerWidth']);
       	$tourl				=	trim($_POST['url']);  
       	$toname				=	trim($_POST['banner']);

    	if($tourl=="" || $toname=="")
    	{
                  echo "<h5 class='textred' align='center'>Dont leave any Field as Blank !!</h5>";
    	}else{

			$sql="update partners_banner set ".
			" banner_url='".addslashes($tourl)."' , ".
			" banner_name='".addslashes($toname)."' , ".
			" banner_height='".addslashes($bannerHeight)."' , ".
			" banner_width='".addslashes($bannerWidth)."'   where banner_id='$id' ";
         	@mysqli_query($con,$sql);

            echo "<h5 class='textred' align='center'>Banner Updatted.. !!</h5>";
            echo "<script language='javascript' type='text/javascript'>  window.opener.location.href='index.php?Act=add_banner'; </script>";

            disp($url,$bannername,$bHeight, $bWidth, $bSize);
       }
  }else{
        disp($url,$bannername,$bHeight, $bWidth, $bSize);
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <!--<link rel="stylesheet" type="text/css" href="main.css" />--> 
 <link rel="stylesheet" type="text/css" href="style.css" />
 </head>
<body>

<form method="post" name="bannerForm" action="">
 <table border="0" cellpadding="0" cellspacing="0" class="tablebdr"  width="66%"  align="center">
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead" align="center">
            <b><?=$langeditbann_EditBanner?></b></td>
          </tr>
          <tr>
            <td width="100%" colspan="4" height="15" class="grid1">
            </td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="20%" height="22" class="grid1"><b><?=$laddban_Banner?>&nbsp; </b></td>
            <td width="77%" height="22" class="grid1">
            <input type="text" name="banner" size="47" value="<?=stripslashes($bannername)?>" /></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="20%" height="19" class="grid1">&nbsp;</td>
            <td width="77%" height="19" class="grid1" align="left">
            (<?=$laddban_Example?>- http://www.yoursite.com/banner.gif)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="20%" height="22" class="grid1"><b><?=$laddban_URL?></b></td>
            <td width="77%" height="22" class="grid1">
            <input type="text" name="url" size="47" value="<?=stripslashes($url)?>" /></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="20%" height="19" class="grid1">&nbsp;</td>
            <td width="77%" height="19" class="grid1" align="left">
            (<?=$laddban_Example?>- http://www.yoursite.com)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
           <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1"><b><?=$fflashadd_Dimension?> </b></td>
            <td width="62%" height="19" class="grid1">


             <input type="text" name="bannerWidth" size="5" value="<?=$bWidth?>" /> <b> X </b>
            <input type="text" name="bannerHeight" size="5" value="<?=$bHeight?>" />

            </td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
           <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1">&nbsp;</td>
            <td width="62%" height="19" class="grid1">(<?=$laddpopup_Example?>- 400 X 350)</td>
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
            <td width="97%" height="64" class="grid1" colspan="2" align="center" >

                <img src='<?=$bannername?>' border='2' width="<?=$bWidth?>" height="<?=$bHeight?>" align="left" alt="" /></td>
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
<script language="javascript" type="text/javascript">


function explode()
{

  var delimiter = "X";
  var last_pzindex=document.bannerForm.bannerSize.selectedIndex;
  var item=document.bannerForm.bannerSize.options[last_pzindex].value;

  tempArray=new Array(1);

  var Count=0;
  var tempString=new String(item);

  while (tempString.indexOf(delimiter)>0) {
	tempArray[Count]=tempString.substr(0,tempString.indexOf(delimiter));
	tempString=tempString.substr(tempString.indexOf(delimiter)+1,tempString.length-tempString.indexOf(delimiter)+1);
	Count=Count+1
  }

  tempArray[Count]=tempString;
  document.bannerForm.bannerWidth.value=tempArray[0];
  document.bannerForm.bannerHeight.value=tempArray[1];

}

</script>
</body>

</html>