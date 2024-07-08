<?php

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';

	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);

	$width=$_POST['width'];
	$height=$_POST['height'];


	//***************************** Reading Cookie -> get the vale of selected banners*****//

	$co= $_COOKIE['current'];

	$co=ltrim($co,"~");

	$arr=explode("~",$co);

	$count=count($arr);
	$ctorand=$count-1;


	//****************************** Generatign javascript Banner Rtator Code **************//


     $code="";

     $code.="<a href='#' id='a1' ><EMBED  id='img1' src='www.partners.com/images/spacer.swf' quality=4 WIDTH=".$width."   HEIGHT=".$height."   TYPE=application/x-shockwave-flash PLUGINSPAGE=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash></a>";

     $code .="
        	<script>
           random_num = (Math.round(Math.random()*".$ctorand."))
           var images  = new Array(".$count.")
           var to  = new Array(".$count.")

            ";

	for ($i=0; $i<$count; $i++) {

		$sql="select * from partners_flash where flash_id='$arr[$i]'";
		// echo "document.write(".$sql.")";
		$res =  mysqli_query($con,$sql);

		//echo mysql_error();



	    while($row=mysqli_fetch_object($res))
	    {
         $curimg=$row->flash_swf;
         $cururl=$row->flash_url ;

         ///////////////// echo script

         $code.="


	      images[".$i."]  = '".$curimg."';

           to[".$i."]  ='$track_site_url/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=F$row->flash_id&Act=Rotator';

          //          to[".$i."]  = '".$cururl."';

        //  alert(to[".$i."]);

         ";
         //////////////////// echo closing


        }  // closing of while



    }     // closing of for


        $code.="img1.src=images[random_num];";
        $code.="a1.href=to[random_num]";

        $code.= "</script>";


?>

	    <p>&nbsp;</p>
	    <table class="tablebdr" border="0" width="80%" align="center">
	    <tr>
	    <td width="747" colspan="3" class="tdhead">
	    <p align="center"><b><?=$genban_your?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?Act=rotator'>&lt;&lt;<?=$common_back?><a></p>
	    </td>
	    </tr>
	    <tr>
	    <td width="747" colspan="3" class="tdhead">
	    <p align="center"><b><?=$code?></b></p>
	    </td>
	    </tr>

	    <tr>
	    <td width="747" colspan="3" class="tdhead">
	    <p align="center"><b>&nbsp;<?=$genflsh_code?></b></p>
	    </td>
	    </tr>

	    <tr>
	    <td width="0" height="99">
	    <p>&nbsp;</p>
	    </td>
	    <td width="739" height="99" align='center'>
	    <p><textarea id="t1"  name="TEXTAREA1" rows="12" cols="100">

	    <?=$code?>

	    </textarea>

	    </p>
	    </td>
	    <td width="-4" height="99">
	    <p>&nbsp;</p>
	    </td>
	    </tr>
	    <tr>
	    <td width="747" colspan="3" class="tdhead">
	    <p align='center'>&nbsp;<?=$genban_copy?> <input type="button" value="<?=$genban_select?>" id="b1" LANGUAGE="javascript" onclick="return b1_onclick()"> <?=$genban_click?></p>
	    </td>
	    </tr>
	    </table>
	    <p>&nbsp;</p>
	    </body>
	             <script language="javascript" type="text/javascript">


	            function b1_onclick() {
	            t1.select();
	            Copied=t1.value;

	            //holdtext.innerText = copytext.innerText;
	            //Copied = Copied.createTextRange();


	            //Copied.execCommand("Copy");
	            }

	            </script>