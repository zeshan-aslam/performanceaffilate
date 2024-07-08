<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{

 function add($lText_success)
          {
            $con = $GLOBALS["con"];
            
                   $pgmid = $_SESSION['PGMID'];
                   $url	  = $_POST['url'];
                   $text  = $_POST['text'];
                   $description=$_POST['description'];

                   $sql="INSERT INTO `partners_text_old` ( `text_id` , `text_programid` , `text_text` , `text_url` , `text_description` )
						VALUES ('', '$pgmid', '".addslashes($text)."', '".addslashes($url)."', '".addslashes($description)."')";


            		//$sql="insert into partners_banner (banner_id ,banner_programid ,banner_url ,banner_name) values('','$pgmid','$url','$banner')";
                    mysqli_query($con,$sql);

                    echo mysqli_error($con);
                   echo "<p align='center' > <font color='red'><strong>$lText_success</strong></font></p>";

            }

                if ($_POST['url']=="" || $_POST['text']=="" || $_POST['description']=="") {

                echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";

                }
                else {


	    $sql="select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
	    $result = mysqli_query($con,$sql);
	    //echo $sql;
	    echo mysqli_error($con);

	                if(mysqli_num_rows($result)>0)
	                {
	                       $sql1="select * from partners_text_old where text_programid ='$_SESSION[PGMID]'";
	                         $result = mysqli_query($con,$sql1);
	                         echo mysqli_error($con);
	                        // echo $sql1;
	                          if(mysqli_num_rows($result)>0)
	                        {
								//  echo "normal user with a banner cant add ";
                                echo "<p align='center' > <font color='red'><strong>$lText_normal</strong></font></p>";
	                        }
	                        else
	                        {

	                        add($lText_success);
	                         //echo "norm user no banner ok adding";
	                        }


	                }
	                else
	                {
	                //echo "advance user ok adding";
	                add($lText_success);
	                }



            }   /// else closing of null check


}/////////  submit check if closing

else if($_GET['mode']=="delete")
{
	$id = intval($_GET['id']);

   $sql="Delete from partners_text_old where text_id ='$id'";

   mysqli_query($con,$sql);

   mysqli_error($con);


   echo "<P align='center' ><font color='red'><strong>$lText_delete &nbsp;</strong></font></p>";
}


?>
<br/>
<form method="post" action="" >

  <? include_once "add_link.php"; ?>

    <table border="0" cellpadding="0" style="border-collapse: collapse"  width="78%"  class="tablebdr"  align="center">
      <tr>
        <td colspan="5" class="tdhead" height="19" align="center">
        <b><?=$ltextadd_TextAdd?></b></td>
      </tr>
      <tr>
        <td width="2%" height="24">&nbsp;</td>
        <td colspan="3" height="24" align="center">
        <b><?=$ltextadd_TocreateaTextaddyoumustfillthefollowingfields?></b></td>
        <td width="4%" height="24">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="23">&nbsp;</td>
        <td width="34%" height="23" align="right"><b><?=$ltextadd_URL?></b> </td>
        <td width="2%">&nbsp;</td>
        <td width="58%" height="23" align="left"><?=$ltextadd_ThisistheDestinationURLtowhichthetextaddwilllead?></td>
        <td width="4%" height="23">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="24">&nbsp;</td>
        <td width="34%" height="24" align="right"><b><?=$ltextadd_Example?>
        </b></td>
        <td width="2%">&nbsp;</td>
        <td width="58%" height="24" align="left"><?=$ltextadd_yoursite?>/</td>
        <td width="4%" height="24">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="25">&nbsp;</td>
        <td width="34%" height="25" align="right"><b><?=$ltextadd_Text ?></b></td>
        <td width="2%">&nbsp;</td>
        <td width="58%" height="25" align="left"><?=$ltextadd_Thistextwillbethelink?></td>
        <td width="4%" height="25">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="24">&nbsp;</td>
        <td width="34%" height="24" align="right"><b><?=$ltextadd_Example?></b> </td>
        <td width="2%">&nbsp;</td>
        <td width="58%" height="24" align="left"><?=$ltextadd_BuyTheLatestNokia8080?></td>
        <td width="4%" height="24">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="25">&nbsp;</td>
        <td width="34%" height="25" align="right"><b><?=$ltextadd_Description?></b></td>
        <td width="2%">&nbsp;</td>
        <td width="58%" height="25" align="left"><?=$ltextadd_ThisisthelongDescriptionabouttheLink?>.</td>
        <td width="4%" height="25">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="24">&nbsp;</td>
        <td width="34%" height="24" align="right"><b><?=$ltextadd_Example?></b> </td>
        <td width="2%">&nbsp;</td>
        <td width="58%" height="24" align="left"><?=$ltextadd_ThisisthelinktoHomePageofNokia?>
        </td>
        <td width="4%" height="24">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="34%" height="19">&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="58%" height="19">&nbsp;</td>
        <td width="4%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="158">&nbsp;</td>
        <td colspan="3" height="158">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  width="100%" id="AutoNumber2" >
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead" align="center">
            <b><?=$ltextadd_Settings?></b></td>
          </tr>
          <tr>
            <td width="100%" colspan="4" height="13" class="grid1">
            </td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$ltextadd_URL?></b></td>
            <td width="62%" height="22" align="left" class="grid1">
            <input type="text" name="url" size="47" /></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$ltextadd_Text?></b></td>
            <td width="62%" height="22" align="left" class="grid1">
            <input type="text" name="text" size="47" /></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="36" class="grid1">&nbsp;</td>
            <td width="35%" height="36" class="grid1"><b><?=$ltextadd_Description?></b></td>
            <td width="62%" height="36" align="left" class="grid1">
            <textarea rows="3" name="description" cols="39"></textarea></td>
            <td width="1%" height="36" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1">&nbsp;</td>
            <td width="62%" height="19" class="grid1">&nbsp;</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
        </table>
        </td>
        <td width="4%" height="158">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="tdhead" height="26" align="center">
        <input type="submit" value="<?=$common_submit?>" name="B1" /><input type="reset" value="<?=$common_cancel?>" name="B2" /></td>
      </tr>
    </table>

</form>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" width="77%"  align="center" class="tablebdr">
    <tr>
      <td width="100%" height="18" colspan="3" class="tdhead"><?=$ltextadd_ExistingTexts?></td>
 </tr>

      	  <?php    ///////////// display  banners /////////////

                       $sql3="select * from partners_text_old where text_programid = '$_SESSION[PGMID]' ORDER BY text_id DESC";
                       $res=mysqli_query($con,$sql3);
                       //echo $sql3;
                       echo mysqli_error($con);

						//Added by DPT on June/16/05
						//if no texts exist
						if(mysqli_num_rows($res)<=0)
						{
?>
	<tr>
		<td colspan="3"><?=$ltextadd_no_msg?></td>
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


            	    <table cellspacing="0" cellpadding="5" width='622' border="1" style="border-collapse: collapse" >
	                  <tbody>
	                  <tr>
	                    <td height='1' width='300' bgcolor="#FFFFFF" class="grid1">
	                    		<span class='text'><b><?=$laddban_Type?>:</b>Text<b><br/>
	                    		<?=$laddban_URL?>:</b> <a href='<?=$row->text_url?>' target="new">
	                    		<?=$row->text_text?></a></span>
                        </td>
	                    <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
	                    		<a href="#" onclick="window.open('edit_text1.php?id=<?=$row->text_id?>','new',100,400)"><?=$laddban_Edit?></a>&nbsp;&nbsp;
                                <a href='index.php?Act=add_text&amp;mode=delete&amp;id=<?=$row->text_id?>' id="del"  onclick="return del_onclick()"><?=$laddban_Delete?></a>

	                    </td>
                      </tr>
	                  <tr>
                      <td colspan="2" height='69' width='608' align="center">
                <textarea rows="4" name="S1" cols="55"><?=stripslashes($row->text_description)?></textarea></td>


                      </tr>
                        </tbody>
	                </table>
                    <?php

                    } /// while closing

					?>
              </td>
      <td width="1%" height="19">&nbsp;</td>
    </tr>
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

 <script  language="javascript" type="text/javascript">

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