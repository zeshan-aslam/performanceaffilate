<?php		ob_start();
    include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
     include_once '../includes/allstripslashes.php';

    $id = intval($_GET['id']);


    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';

    function disp(&$url,&$swf,&$width,&$height)   /// function by reff
    {

     $id=$_GET['id'];
     $sql="select * from partners_flash where flash_id='$id'";
      //echo $sql;
    $res=mysqli_query($con,$sql);
          $row=mysqli_fetch_object($res);


    $url=$row->flash_url;
    $swf=$row->flash_swf;
     $width=$row->flash_width;
    $height=$row->flash_height;


    }



      if($_SERVER["REQUEST_METHOD"]=="POST")
      {

            $tourl		=trim($_POST['url']);
            $toswf		=trim($_POST['swf']);
            $towidth	=trim($_POST['T1']);
            $toheight	=trim($_POST['T2']);




           if($tourl=="" || $toswf=="" || $towidth=="" || $toheight=="")
           {
                  echo "<h5 class='textred' align='center'>Dont leave any Field as Blank !!</h5>";
           }
           else
           {
            $sql="UPDATE `partners_flash` SET `flash_url` = '".addslashes($url)."' , ".
             "           `flash_swf` = '".addslashes($swf)."', ".
             "           `flash_width` = ".addslashes($towidth)." , ".
             "           `flash_height` = ".addslashes($toheight)."   where flash_id='$id' ";
 
            mysqli_query($con,$sql);


            mysqli_error($con);
			//header("Location:index.php?Act=add_flash&msg=flash Updatted.. !!");
            echo "<script language='javascript' type='text/javascript'>  window.opener.location.href='index.php?Act=add_flash'; </script>";
            echo "<h5 class='textred' align='center'>flash Updatted.. !!</h5>";

            disp($url,$swf,$width,$height);


           }



      }
      else
      {
        disp($url,$swf,$width,$height);
      }

?>



<html>

<head>

<title>Affiliate Network Pro - Merchants</title>
</head>
 <link rel="stylesheet" type="text/css" href="style.css">
<body>

<form method="POST"  name="f1" id="f1">
 <table border="0" cellpadding="0" cellspacing="0" class="tablebdr" width="66%" id="AutoNumber2" height="238" align="center">
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead">
            <p align="center"><b><?=$fflashadd_Editflash?></b></td>
          </tr>
          <tr>
            <td width="100%" colspan="4" height="15" class="grid1">
            <p align="center"></td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$fflashadd_SWFURL?></b></td>
            <td width="62%" height="22" class="grid1">
            <input type="text" name="swf" size="47" value="<?=stripslashes($swf)?>"></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="20%" height="19" class="grid1">&nbsp;</td>
            <td width="77%" height="19" class="grid1">
            <p align="left">where &lt;APID&gt; and &lt;AFFID&gt; are param of .swf&nbsp;
            file</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$fflashadd_URL?></b></td>
            <td width="62%" height="22" class="grid1">
            <input type="text" name="url" size="47" value="<?=stripslashes($url)?>"></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="20%" height="19" class="grid1">&nbsp;</td>
            <td width="77%" height="19" class="grid1">
            (<?=$fflashadd_Example?>- http://www.yoursite.com/flash.swf)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1"><b><?=$fflashadd_Dimension ?></b></td>
            <td width="62%" height="19" class="grid1">
            <input type="hidden" name="T1" size="5" value='<?=$width?>'>
            <input type="hidden" value='<?=$height?>'name="T2" size="5" >

	        <select name="select1" onChange="explode()">
	          <option value="120X600">120 X 600</option>
	          <option value="160X60">160 X 60</option>

	          <option value="160X600">160X600</option>
   	          <option value="180X150">180X150</option>
	          <option value="240X400">240X400</option>
	          <option value="250X250">250X250</option>
	          <option value="300X250">300X250</option>
	          <option value="468X60">468X60</option>
	        </select>

            </td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="20%" height="19" class="grid1">&nbsp;</td>
            <td width="77%" height="19" class="grid1">
            (<?=$fflashadd_Example ?>- 400 X 200)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="1" class="grid1"></td>
            <td width="20%" height="1" class="grid1"></td>
            <td width="77%" height="1" class="grid1">
            <p align="left"></td>
            <td width="1%" height="1" class="grid1"></td>
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
            <p>
                <EMBED src='<?=$url?>' quality=4 width=468 height=60 TYPE=application/x-shockwave-flash PLUGINSPAGE=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash></EMBED></td>
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
            <input type="submit" value="<?=$common_edit?>" name="B1" >&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="<?=$common_close?>" name="Close" onClick="window.close()"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
</form>

</body>

<script language="javascript" type="text/javascript">

	document.f1.select1.value='<?= $width."X".$height?>';
   // document.f1.select1.selectedIndex=0;
	// explode();

function explode()
{
	 var delimiter = "X";
     var last_pzindex=document.f1.select1.selectedIndex;
	 var item=document.f1.select1.options[last_pzindex].value;

	tempArray=new Array(1);
	var Count=0;
	var tempString=new String(item);
	while (tempString.indexOf(delimiter)>0) {
	tempArray[Count]=tempString.substr(0,tempString.indexOf(delimiter));
	tempString=tempString.substr(tempString.indexOf(delimiter)+1,tempString.length-tempString.indexOf(delimiter)+1);
	Count=Count+1
	}
	tempArray[Count]=tempString;
      document.f1.T1.value=tempArray[0];
      document.f1.T2.value=tempArray[1];

}
</script>

</html>