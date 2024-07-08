<?php

if($_SERVER['REQUEST_METHOD']=="POST")
{
 //echo "submitted";
 //echo $_SESSION['PGMID'];
 //echo $_SESSION['MERCHANTID'];



 function add($lPopUp_success)
            {

                    $pgmid		= $_SESSION['PGMID'];
                    $url		= $_POST['url'];
                    $type		= $_POST['type'];
                    $width		= $_POST['width'];
                    $height		= $_POST['height'];
                    $scrollbar	= $_POST['scrollbar'];

					$sql="INSERT INTO `partners_popup` SET ".
					" popup_programid ='".addslashes($pgmid)."' , ".
					" popup_url ='".addslashes($url)."' , ".
					" popup_type ='".addslashes($type)."' , ".
					" popup_width ='".addslashes($width)."' , ".
					" popup_height ='".addslashes($height)."' , ".
					" popup_scrollbar ='".addslashes($scrollbar)."'   "; 
                    mysqli_query($con,$sql);

                    echo mysqli_error($con);
                   echo "<p align='center' > <font color='red'><strong>$lPopUp_success</strong></font></p>";

            }

                if ($_POST['url']=="" || $_POST['width']=="" || $_POST['height']=="" )
                 {

                echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";

                }
                else {


            $sql="select *  from partners_merchant where merchant_id '=$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
            $result = mysqli_query($con,$sql);
            //echo $sql;
            echo mysqli_error($con);

                        if(mysqli_num_rows($result)>0)
                        {
                               $sql1="select * from partners_popup where popup_programid ='$_SESSION[PGMID]'";
                                 $result = mysqli_query($con,$sql1);
                                 echo mysqli_error($con);
                                // echo $sql1;
                                  if(mysqli_num_rows($result)>0)
                                {
                                                                //  echo "normal user with a banner cant add ";
                                echo "<p align='center' > <font color='red'><strong>$lnormal POPUP !!</strong></font></p>";
                                }
                                else
                                {

                                add($lPopUp_success);
                                 //echo "norm user no banner ok adding";
                                }


                        }
                        else
                        {
                        //echo "advance user ok adding";
                        add($lPopUp_success);
                        }



            }   /// else closing of null check


}/////////  submit check if closing

else if($_GET['mode']=="delete")
{

        $id=$_GET['id'];

   $sql="Delete from partners_popup where popup_id ='$id'";

   mysqli_query($con,$sql);

   mysqli_error($con);

  //echo $_SESSION['PGMID'];
   echo "<p align='center' ><font color='red'><strong>$lPopUp_delete</strong></font></p>";

}


?>
 <form method="post" action="" >

   <? include_once "add_link.php"; ?>
        <p>&nbsp;</p>
    <table border="0" cellpadding="0" style="border-collapse: collapse"  align="center" width="78%" id="AutoNumber1" class="tablebdr">
      <tr>
        <td colspan="4" class="tdhead" height="19" align="center">
        <b><?=$laddpopup_PopUpAdd?></b></td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td colspan="2" height="19" align="center">
        <b><?=$laddpopup_TocreateaPopUpaddyoumustfillthefollowingfields?></b></td>
        <td width="5%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="57">&nbsp;</td>
        <td width="15%" height="57"><b><?=$laddpopup_PopUpType?></b></td>
        <td width="78%" height="57"><?=$laddpopup_PopUptext?></td>
        <td width="5%" height="57">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="15%" height="19"><b><?=$laddpopup_URL?> </b></td>
        <td width="78%" height="19"><?=$laddpopup_YoumustgivetheURLofthepagethatwillbeusedaspopupadd?></td>
        <td width="5%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="15%" height="19"><b><?=$laddpopup_Example?></b>&nbsp; </td>
        <td width="78%" height="19"><?=$laddpopup_yoursite?>
        </td>
        <td width="5%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="15"></td>
        <td width="15%" height="15"><b><?=$laddpopup_Size?> </b></td>
        <td width="78%" height="15"><?=$laddpopup_sizeofpopupwindow?></td>
        <td width="5%" height="15"></td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="15%" height="19"><b><?=$laddpopup_Example?></b>&nbsp; </td>
        <td width="78%" height="19">600 X 400.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td width="5%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="15%" height="19"><b><?=$laddpopup_Scrollbars?></b></td>
        <td width="78%" height="19"><?=$laddpopup_Determinesifthepopupwindowwillshowscrollbarorno?></td>
        <td width="5%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="19">&nbsp;</td>
        <td width="15%" height="19">&nbsp;</td>
        <td width="78%" height="19">&nbsp;</td>
        <td width="5%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="2%" height="132">&nbsp;</td>
        <td colspan="2" height="132">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  width="100%" id="AutoNumber2" >
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead">&nbsp;
            </td>
          </tr>
          <tr>
            <td width="100%" height="19" colspan="4" class="tdhead" align="center">
            <b><?=$laddpopup_Settings?></b></td>
          </tr>
          <tr>
            <td width="100%" colspan="4" height="19" class="grid1">
            </td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$laddpopup_PopUpType?></b></td>
            <td width="62%" height="22" class="grid1"><?=$laddpopup_PopUP?> <input type="radio" value="popup" checked="checked" name="type" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?=$laddpopup_UnderPopUp?> <input type="radio" name="type" value="underpopup" /></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
            <td width="35%" height="22" class="grid1"><b><?=$laddpopup_URL?></b></td>
            <td width="62%" height="22" class="grid1">
            <input type="text" name="url" size="47" /></td>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1">&nbsp;</td>
            <td width="62%" height="19" class="grid1" align="left">
            (<?=$laddpopup_Example?>- <?=$laddpopup_yoursite?>)</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1"><b><?=$laddpopup_Dimensions?></b></td>
            <td width="62%" height="19" class="grid1">
            <input type="text" name="width" size="5" /> <b>&nbsp;X&nbsp; </b>
            <input type="text" name="height" size="5" /></td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
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
            <input type="radio" name="scrollbar" value="yes" checked="checked" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?=$laddpopup_No?><input type="radio" name="scrollbar" value="no" /></td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="2%" height="19" class="grid1">&nbsp;</td>
            <td width="35%" height="19" class="grid1">&nbsp;</td>
            <td width="62%" height="19" class="grid1">&nbsp;</td>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
          </tr>
        </table>
        </td>
        <td width="5%" height="132">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="tdhead" height="26" align="center">
        <input type="submit" value="<?=$common_submit?>" name="B1" /><input type="reset" value="<?=$common_cancel?>" name="B2" /></td>
      </tr>
    </table>

</form>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center"  align="center" width="77%" id="AutoNumber4" class="tablebdr">
    <tr>
      <td width="100%" height="18" colspan="3" class="tdhead"><?=$laddpopup_ExistingPopups?></td>
    </tr>

                <?php    ///////////// display  banners /////////////

                       $sql3="select * from partners_popup where popup_programid ='$_SESSION[PGMID]' ORDER BY popup_id DESC";
                       $res=mysqli_query($con,$sql3);
                       //echo $sql3;
                       echo mysqli_error($con);

						//Added by DPT on June/16/05
						//if no pop ups exist
						if(mysqli_num_rows($res)<=0)
						{
?>
	<tr>
		<td colspan="3"><?=$laddpopup_no_msg?></td>
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
                                            <span class='text'><b><?=$laddpopup_Type?>:</b><?=$laddpopup_POPUP?><b><br/>
                                            <?=$laddpopup_URL?>:</b> <a href='<?=$row->popup_url?>'>
                                            <?=$row->popup_url?></a></span>
                        </td>
                            <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
                                <a href="#" onclick="window.open('edit_popup.php?id=<?=$row->popup_id?>','new',100,400)"><?=$laddpopup_Edit?></a>&nbsp;&nbsp;
  <a href='index.php?Act=add_popup&amp;mode=delete&amp;id=<?=$row->popup_id?>'   onclick="return del_onclick()"><?=$laddpopup_Delete?></a>


                            </td>
                      </tr>
                          <tr>
                      <td colspan="2" height='69' width='608' align="center" ><a href="#">
                <img src='images/popup.gif' border='0' width="300" height="60" onclick="window.open('<?=stripslashes($row->popup_url)?>',<?=$row->popup_width?>,<?=$row->popup_height?>)" alt="" /></a>
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