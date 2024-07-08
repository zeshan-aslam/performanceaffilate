<?php

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{

	 function add($lflash_success)
	            {
                $con = $GLOBALS["con"];
	                   $pgmid=$_SESSION['PGMID'];

                   	   $url=$_POST['url'];
	                   $swf=$_POST['swf'];
	                   $width=$_POST['T1'];
	                   $height=$_POST['T2'];

				$sql="INSERT INTO `partners_flash` SET ".
				" flash_programid = '".addslashes($pgmid)."' , ".
				" flash_url = '".addslashes($url)."' , ".
				" flash_swf = '".addslashes($swf)."' , ".
				" flash_width = '".addslashes($width)."' , ".
				" flash_height = '".addslashes($height)."' ";
				mysqli_query($con,$sql);
	
			   echo mysqli_error($con);
			   echo "<p align='center' > <font color='red'> <strong>$lflash_success</strong></font></p>";

	            }

	                if ($_POST['swf']=="" || $_POST['url']=="" || $_POST['T1']=="" || $_POST['T1']=="" )
                     {

	                echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";

	                }
	                else {


	        $sql="select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
	        $result = mysqli_query($con,$sql);
	        //echo $sql;
	        echo mysqli_error($con);

	                    if(mysqli_num_rows($result)>0)
	                    {
	                           $sql1="select * from partners_flash where flash_programid ='$_SESSION[PGMID]'";
	                             $result = mysqli_query($con,$sql1);
	                             echo mysqli_error($con);
	                            // echo $sql1;
	                              if(mysqli_num_rows($result)>0)
	                            {
	                                //  echo "normal user with a flash cant add ";
	                                echo "<p align='center' > <font color='red'><strong>$lflash_normal</strong></font></p>";
	                            }
	                            else
	                            {

	                            add($lflash_success);
	                             //echo "norm user no flash ok adding";
	                            }


	                    }
	                    else
	                    {
	                    //echo "advance user ok adding";
	                    add($lflash_success);
	                    }
	            }   /// else closing of null check
	}/////////  submit check if closing


else if($_GET['mode']=="delete")
{
	$id=$_GET['id'];

   $sql="Delete from partners_flash where flash_id='$id'";

   mysqli_query($con,$sql);

   mysqli_error($con);

  //echo $_SESSION['PGMID'];
   echo "<p align='center' ><font color='red'><strong>$lflash_delete&nbsp;</strong></font></p>";
}




?>
<form method="post" action="" name="f1" id="f1">
<? include_once "add_link.php"; ?>
<? /*
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" align="center" width="719" id="AutoNumber3" class="tablebdr">
          <tr>
            <td width="5" class="tdhead">&nbsp;</td>
            <td width="137" class="tdhead"><b>
              <?=$laddban_Text?>
            </b></td>
            <td width="5">&nbsp;</td>
            <td width="142" class="tdhead"> <b>
              <?=$laddban_Banner?>
            </b></td>
            <td width="5">&nbsp;</td>
            <td width="138" class="tdhead"><b>
              <?=$laddban_Flash?>
            </b></td>
            <td width="5">&nbsp;</td>
            <td width="138" class="tdhead"><b>
              <?=$laddban_HTML?>
            </b></td>
            <td width="5">&nbsp;</td>
            <td width="145" class="tdhead"><b>
              <?=$laddban_Popupads?>
            </b></td>
            <td width="13" class="tdhead">&nbsp;</td>
          </tr>
          <tr>
            <td width="5" valign="top">&nbsp;</td>
            <td width="137" valign="top" style="text-align: left">&nbsp;
              <?=$laddban_Texttext?>
              <br/>
        &nbsp;</td>
            <td width="5" valign="top" style="text-align: left">&nbsp;</td>
            <td width="142" valign="top" style="text-align: left">&nbsp;
                <?=$laddban_Bannertext?>
                <br/>
          &nbsp;</td>
            <td width="5" valign="top" style="text-align: left">&nbsp;</td>
            <td width="138" valign="top" style="text-align: left"> &nbsp;
              <?=$laddban_Flashtext?>
&nbsp; </td>
            <td width="5" valign="top" style="text-align: left">&nbsp;</td>
            <td width="138" valign="top" style="text-align: left">&nbsp;
                <?=$laddban_Flashtext?></td>
            <td width="5" valign="top" style="text-align: left">&nbsp;</td>
            <td width="145" valign="top" style="text-align: left">&nbsp;
                <?=$laddban_Popupadstext?></td>
            <td width="13" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td width="5">&nbsp;</td>
            <td width="137"><a href="index.php?Act=add_text"> <img src='images/grapgicb.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="5">&nbsp;</td>
            <td width="142"><a href="index.php?Act=add_banner"> <img src='images/grapgicc.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="5">&nbsp;</td>
            <td width="138"> <a href="index.php?Act=add_flash"> <img src='images/grapgicd.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="5">&nbsp;</td>
            <td width="138">  <a href="index.php?Act=add_html"> <img src='images/grapgice.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="5">&nbsp;</td>
            <td width="145"> <a href="index.php?Act=add_popup"> <img src='images/grapgicf.gif' width='135' height='34' border='0' alt="" /></a></td>
            <td width="13">&nbsp;</td>
          </tr>
          <tr>
            <td width="738" class="tdhead" colspan="11">&nbsp;</td>
          </tr>
        </table>
*/ ?>				
		
        <p>&nbsp;</p>

    <table border="0" cellpadding="0" style="border-collapse: collapse"  width="78%"  class="tablebdr" align="center" >
      <tr>
        <td colspan="5" class="tdhead" height="19">
        <b><?=$fflashadd_FlashAdd?></b></td>
      </tr>
      <tr>
        <td width="2%" height="25">&nbsp;</td>
        <td colspan="3" height="25" align="center">
        <b><?=$fflashadd_TocreateaFlashaddyoumustfillthefollowingfields?> </b></td>
        <td width="6%" height="25">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="22">&nbsp;</td>
        <td width="10%" height="22" align="right" valign="top"><b><?=$fflashadd_SWFURL?></b></td>
        <td width="2%">&nbsp;</td>
        <td width="80%" height="22" align="left"><?=$fflashadd_infofortheSWFURLThisislinkthatyoumustembeddedinyourflashflashThisisrequiredbecausetrackingwillbecorrect ?>.</td>
        <td width="6%" height="22">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="10%" height="19" align="right"><b><?=$fflashadd_URLLINK?> </b></td>
        <td width="2%">&nbsp;</td>
        <td width="80%" height="19" align="left"><?=$fflashadd_TheaddressoftheSWFflash?></td>
        <td width="6%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="10%" height="19" align="right"><b><?=$fflashadd_Example?></b> </td>
        <td width="2%">&nbsp;</td>
        <td width="80%" height="19" align="left"><b>-</b><?=$fflashadd_yorsite	?>
        </td>
        <td width="6%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="10%" height="19" align="right"><b><?=$fflashadd_Dimension?></b> </td>
        <td width="2%">&nbsp;</td>
        <td width="80%" height="19" align="left"><?=$fflashadd_Youmustgivewidthandheightofflash?></td>
        <td width="6%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="10%" height="19" align="right"><b><?=$fflashadd_Example?></b> </td>
        <td width="2%">&nbsp;</td>
        <td width="80%" height="19" align="left"><?=$fflashadd_480X60?></td>
        <td width="6%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="155">&nbsp;</td>
        <td colspan="3" height="155">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  width="100%"  >
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead" align="center">
         <b><?=$fflashadd_Settings?></b></td>
          </tr>
          <tr>
            <td width="100%" colspan="4" height="4" class="grid1">
            </td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$fflashadd_SWFURL?></b></td>
            <td width="62%" height="22" class="grid1">
            <input type="text" name="swf" size="47" value="" /></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1">&nbsp;</td>
            <td width="62%" height="19" class="grid1" align="left">
            <?=$fflashadd_where?></td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$fflashadd_URL?></b></td>
            <td width="62%" height="22" class="grid1">
            <input type="text" name="url" size="47" /></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1">&nbsp;</td>
            <td width="62%" height="19" class="grid1">
            (<?=$fflashadd_Example?> - <?=$fflashadd_yorsite?>)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1"><b><?=$fflashadd_Dimension?> </b></td>
            <td width="62%" height="19" class="grid1">
            <input type="hidden" name="T1" size="5" />
            <input type="hidden" name="T2" size="5" />

	        <select name="select1" onchange="explode()">
	          <option value="120X600" selected="selected">120 X 600</option>
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
            <td width="35%" height="19" class="grid1">&nbsp;</td>
            <td width="62%" height="19" class="grid1">(<?=$fflashadd_Example?> - 400 X 200)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
        </table>
        </td>
        <td width="6%" height="155">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="tdhead" height="26" align="center">
        <input type="submit" value="<?=$common_submit?>" name="B1" /><input type="reset" value="<?=$common_cancel?>" name="B2" /></td>
      </tr>
    </table>
    <p>&nbsp;</p>



  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" align="center" width="77%"   class="tablebdr">
    <tr>
      <td width="100%" height="16" colspan="3" class="tdhead"><?=$fflashadd_Existingflashs?></td>
 </tr>

      	  <?php    ///////////// display  flashs /////////////

                       $sql3="select * from partners_flash where flash_programid = '$_SESSION[PGMID]' ORDER BY flash_id DESC";
                       $res=mysqli_query($con,$sql3);
                       //echo $sql3;
                       echo mysqli_error($con);

						//Added by DPT on June/16/05
						//if no flashs exist
						if(mysqli_num_rows($res)<=0)
						{
?>
	<tr>
		<td colspan="3"><?=$fflashadd_no_msg?></td>
	</tr>
<?php
						}
						//End of Addition

                        while($row=mysqli_fetch_object($res))
                    {

	          ?>

    <tr>
      <td width="100%" height="18" colspan="3">
      </td>
    </tr>
    <tr>
      <td width="2%" height="19">&nbsp;</td>
      <td width="97%" height="19">


            	    <table cellspacing="0" cellpadding="5" width='622' border="1"  style="border-collapse: collapse" >
	                  <tbody>
	                  <tr>
	                    <td height='1' width='300' bgcolor="#FFFFFF" class="grid1">
	                    		<span class='text'><b><?=$fflashadd_Type?>: <?=$fflashadd_Flash?><br/>
	                    		<?=$fflashadd_URL?>: <a href='<?=$row->flash_swf?>'>
	                    		<?=$row->flash_swf?></a></b></span>
                        </td>
	                    <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
    <a href="#" onclick="window.open('edit_flash.php?id=<?=$row->flash_id?>','new',100,400)"><?=$fflashadd_Edit?></a>&nbsp;&nbsp;


	                    </td>
                      </tr>
	                  <tr>
                      <td colspan="2" height='69' width='608'>
<?
                        $i=$row->flash_width."_".$row->flash_height;

                        $main="images/flash/".$i.".swf";
                        $src = $main."?inner=".$row->flash_url."&url=".$row->flash_swf;
                       // echo "ttes==".$row->flash_swf;
?>

                   <!--	<embed src="" quality="4" width="<?=$row->flash_width?>" height="<?=$row->flash_height ?>"  type="application/x-shockwave-flash PLUGINSPAGE=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed>-->
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="<?=$row->flash_width?>" height="<?=$row->flash_height ?>">
                  		<param name="movie" value="<?=$row->flash_swf?>" />
                  		<param name="quality" value="high" />
                  		<embed src="<?=$row->flash_swf?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$row->flash_width?>" height="<?=$row->flash_height ?>"></embed>
              		</object>
	              </td>
                   </tr>
                      </tbody>
	                </table>
      </td>
      <td width="1%" height="19">&nbsp;</td>
    </tr>
                    <?php

                    } /// while closing

					?>

    <tr>
      <td width="2%" height="19">&nbsp;</td>
      <td width="97%" height="19">&nbsp;</td>
      <td width="1%" height="19">
     </td>
    </tr>
    <tr>
      <td width="100%" height="19" colspan="3" class="tdhead">&nbsp;</td>
    </tr>
  </table>

</form>

<script language="javascript" type="text/javascript">

<!--

function del_onclick() {
if(confirm("<?=$lang_del?>"))
        {
                return true;
        }
        else
        {
        return false;
        }

}

//-->
</script>

<script language="javascript" type="text/javascript">
document.f1.select1.selectedIndex=0;
explode();

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