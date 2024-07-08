<?php

    include_once '../includes/constants.php';
    include_once '../includes/functions.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	$affilid=$AFFILIATEID;

    $width=$_POST['width'];
    $height=$_POST['height'];

	$co= $_COOKIE['current'];

	$co=ltrim($co,"~");

	$arr=explode("~",$co);

	$count=count($arr);
	$ctorand=$count-1;

     // http://www.alstrasoft.com/anp/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id&Act=Rotator'


	$curid="";
	for ($i=0; $i<$count; $i++)
	{

	    $sql="select * from partners_banner where banner_id='$arr[$i]'";
	    // echo "document.write(".$sql.")";
	    $res =  mysqli_query($con,$sql)or die("

	        <table width=\"80%\" align=\"center\" >
	        <tr>
	        <td><span class=\"textred\">Unrecoverable error , Either your browser may not  support JavaScript or Cookie Disabled .&nbsp;
	        </span></td>
	        </tr>
	        <tr>
	        <td><div align=\"center\">
	        <input type=\"button\" name=\"Button\" value=\"Back\" onclick=\"javascript:history.go(-1)\" />
	        </div></td>
	        </tr>
	        </table>
            </td></tr></table>
            </body></html>

	     ");

		echo mysql_error();

        while($row=mysqli_fetch_object($res))
        {

             $curid .="~".$row->banner_id;
        }
    }

    $sql="INSERT  INTO  `partners_rcode` (`rcode_bannerid`)
				VALUES (  '$curid' )";

    mysqli_query($con,$sql)or die("Sorry cant generate Banners");

    $id=mysql_insert_id();

    $codetocopy	="<script language=\"javascript\" type=\"text/javascript\" src=\"$track_site_url/affiliates/rcode.php?id=$id&affilid=$affilid&width=$width&height=$height\"></script>";

?>

	        <p>&nbsp;</p>
	        <table class="tablebdr" border="0" width="80%" align="center">
	        <tr>
	        <td width="747" colspan="3" class="tdhead">
	        <p align="center"><b><?=$genban_your?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?Act=rotator'>&lt;&lt;<?=$common_back?></a></p>
	        </td>
	        </tr>
	        <tr>
	        <td width="747" colspan="3" class="tdhead">
	        <p align="center"><b> <?=str_replace("&","&amp;",$codetocopy)?></b></p>
	        </td>
	        </tr>

	        <tr>
	        <td width="747" colspan="3" class="tdhead">
	        <p align="center"><b>&nbsp;<?=$genban_brcode?></b></p>
	        </td>
	        </tr>

	        <tr>
	        <td width="0" height="99">
	        <p>&nbsp;</p>
	        </td>
	        <td width="739" height="99" align='center'>
	        <p><textarea id="t1"  name="TEXTAREA1" rows="12" cols="100"><?=$codetocopy?>
	        </textarea>
	        </p>
	        </td>
	        <td width="-4" height="99">
	        <p>&nbsp;</p>
	        </td>
	        </tr>
	        <tr>
	        <td width="747" colspan="3" class="tdhead">
	        <p align='center'>&nbsp;<?=$genban_copy?>  <input type="button" value="<?=$genban_select?>" id="b1" onclick="return b1_onclick()" /> <?=$genban_click?></p>
	        </td>
	        </tr>
	        </table>
	        <p>&nbsp;</p>

	        <script language="javascript" type="text/javascript">
 	            function b1_onclick() {
	            document.getElementById("t1").select();
	            Copied=document.getElementById("t1").value;

	            //holdtext.innerText = copytext.innerText;
	            //Copied = Copied.createTextRange();


	            //Copied.execCommand("Copy");



	            }

	        </script>