<?php
# modified : 16/01/2005

# Allows mercahnts to add new banners to the program
# mercahnt can delete, edit nanner


# checking whther the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
 # function to add banners into databse
 function add($lbann_success) {

  $con = $GLOBALS["con"];

   # gets pgmid
    $pgmid		= $_SESSION['PGMID'];

   # banner url
    $url		= $_POST['url'];

   # actual banner location to be added
    $banner		= $_POST['banner'];

   # banner size
    $bannerHeight		= intval($_POST['bannerHeight']);
    $bannerWidth		= intval($_POST['bannerWidth']);

  # inserting into database
	 $sql = "insert into partners_banner SET ".
	 " banner_programid= '".addslashes($pgmid)."' , ".
	 " banner_url= '".addslashes($url)."' , ".
	 " banner_name= '".addslashes($banner)."' , ".
	 " banner_height= '".addslashes($bannerHeight)."' , ".
	 " banner_width= '".addslashes($bannerWidth)."' ";
	 
    @mysqli_query($con,$sql);

  # success msg
    echo "<p align='center' > <font color='red'><strong>$lbann_success</strong></font></p>";

 }

 # if the values are not filled correctly
 if ($_POST['url']=="" || $_POST['banner']=="") {
	 echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";
 }
 else {

    # checks whther the user normal or advanced
    # normal user can add only one banner per program
     $sql	 = "select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
     $result = @mysqli_query($con,$sql);

     if(@mysqli_num_rows($result)>0){

        $sql1	= "select * from partners_banner where banner_programid ='$_SESSION[PGMID]'";
        $result = @mysqli_query($con,$sql1);

        if(mysqli_num_rows($result)>0){
             echo "<p align='center' > <font color='red'><strong>$lbann_normal</strong></font></p>";
        }else{
             add($lbann_success);
        }
     }else{
        add($lbann_success);
     }
  }   /// else closing of null check
}/////////  submit check if closing
# deleting banner
else if($_GET['mode']=="delete")
{
   $id	=	$_GET['id'];

   $sql = "Delete from partners_banner where banner_id='$id'";
   @mysqli_query($con,$sql);

   echo "<p align='center' ><font color='red'><strong>$lbann_delete</strong></font></p>";
}



?>
<br/>
<form method="post" name="bannerForm" action="" >
<? include_once "add_link.php"; ?>

        <p>&nbsp;</p>
        <table border="0" cellpadding="0" style="border-collapse: collapse"  width="78%"  class="tablebdr" align="center" >
      <tr>
        <td colspan="5" class="tdhead" height="19" align="center">
       <b><?=$laddban_BannerAdd?></b></td>
      </tr>
      <tr>
        <td width="1%" height="25">&nbsp;</td>
        <td colspan="3" height="25" align="center">
        <b><?=$laddban_TocreateaBanneraddyoumustfillthefollowingfields?></b></td>
        <td width="4%" height="25">&nbsp;</td>
      </tr>
      <tr>
        <td width="1%" height="19">&nbsp;</td>
        <td width="14%" height="19" align="right"><b><?=$laddban_Banner?>
        </b> </td>
        <td width="2%">&nbsp;</td>
        <td width="79%" height="19" align="left"><?=$laddban_InfoforthebanneryoumusttypetheURLofthebanner?></td>
        <td width="4%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="1%" height="19">&nbsp;</td>
        <td width="14%" height="19" align="right"><b><?=$laddban_Example?>
        </b></td>
        <td width="2%">&nbsp;</td>
        <td width="79%" height="19" align="left"><?=$laddban_yoursite?></td>
        <td width="4%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="1%" height="19">&nbsp;</td>
        <td width="14%" height="19" align="right"><b><?=$laddban_URL?>
        </b></td>
        <td width="2%">&nbsp;</td>
        <td width="79%" height="19" align="left"><?=$laddban_InfoforthelinkofthebanneryoumustinputtheDestinationurltowhichthebannerwilllead?> </td>
        <td width="4%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="1%" height="19">&nbsp;</td>
        <td width="14%" height="19" align="right"><b><?=$laddban_Example?></b> </td>
        <td width="2%">&nbsp;</td>
        <td width="79%" height="19" align="left"><?=$laddban_yoursite?>;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td width="4%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="1%" height="19">&nbsp;</td>
        <td width="14%" height="19">&nbsp;</td>
        <td width="2%">&nbsp;</td>
        <td width="79%" height="19">&nbsp;</td>
        <td width="4%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="1%" height="132">&nbsp;</td>
        <td colspan="3" height="132">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse"  width="100%" id="AutoNumber2">
          <tr>
            <td height="19" colspan="5" class="tdhead" align="center">
            <b><?=$laddban_Settings?></b></td>
          </tr>
          <tr>
            <td colspan="5" height="4" class="grid1">
            </td>
          </tr>
          <tr>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
            <td width="37%" height="22" align="right" class="grid1"><b><?=$laddban_Banner?>
            </b></td>
            <td width="3%" align="left" class="grid1">&nbsp;</td>
            <td width="56%" height="22" align="left" class="grid1">
            <input type="text" name="banner" size="47" /></td>
            <td width="3%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
            <td width="37%" height="19" align="right" class="grid1">&nbsp;</td>
            <td width="3%" align="left" class="grid1">&nbsp;</td>
            <td width="56%" height="19" align="left" class="grid1">
            (<?=$laddban_Example?>- http://www.yoursite.com/banner.gif)</td>
            <td width="3%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
            <td width="37%" height="22" align="right" class="grid1"><b><?=$laddban_URL?></b></td>
            <td width="3%" align="left" class="grid1">&nbsp;</td>
            <td width="56%" height="22" align="left" class="grid1">
            <input type="text" name="url" size="47" /></td>
            <td width="3%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
            <td width="37%" height="19" align="right" class="grid1">&nbsp;</td>
            <td width="3%" class="grid1" align="left">&nbsp;</td>
            <td width="56%" height="19" class="grid1" align="left">
            (<?=$laddban_Example?>- http://www.yoursite.com)</td>
            <td width="3%" height="19" class="grid1">&nbsp;</td>
          </tr>
           <tr>
            <td width="1%" height="19" class="grid1">&nbsp;</td>

            <td width="37%" height="19" align="right" class="grid1"><b><?=$fflashadd_Dimension?> </b></td>
            <td width="3%" align="left" class="grid1">&nbsp;</td>
            <td width="56%" height="19" align="left" class="grid1">
            <input type="text" name="bannerWidth" size="5" /> <b>X</b>
            <input type="text" name="bannerHeight" size="5" />            </td>
            <td width="3%" height="19" class="grid1">&nbsp;</td>
          </tr>
           <tr>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
            <td width="37%" height="19" class="grid1">&nbsp;</td>
            <td width="3%" align="left" class="grid1">&nbsp;</td>
            <td width="56%" height="19" align="left" class="grid1">(<?=$laddpopup_Example?>- 400 X 350)</td>
            <td width="3%" height="19" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="1%" height="19" class="grid1">&nbsp;</td>
            <td width="37%" height="19" class="grid1">&nbsp;</td>
            <td width="3%" class="grid1">&nbsp;</td>
            <td width="56%" height="19" class="grid1">&nbsp;</td>
            <td width="3%" height="19" class="grid1">&nbsp;</td>
          </tr>
        </table>
        </td>
        <td width="4%" height="132">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="tdhead" height="26" align="center">
        <input type="submit" value="<?=$common_submit?>" name="B1" /><input type="reset" value="<?=$common_cancel?>" name="B2" /> </td>
      </tr>
    </table>

</form>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" width="77%"  class="tablebdr" align="center">
    <tr>
      <td width="100%" height="18" colspan="3" class="tdhead"><?=$laddban_ExistingBanners?></td>

      </tr>
                <?php    ///////////// display  banners /////////////

                       $sql3="select * from partners_banner where banner_programid ='$_SESSION[PGMID]' ORDER BY banner_id DESC";
                       $res=mysqli_query($con,$sql3);
                       //echo $sql3;
                       echo mysqli_error($con);


						//Added by DPT on June/16/05
						//if no banner exist
						if(mysqli_num_rows($res)<=0)
						{
?>
	<tr>
		<td colspan="3"><?=$laddban_no_msg?></td>
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

                          <tr>
                            <td height='1' width='300' bgcolor="#FFFFFF" class="grid1">
                                            <span class='text'><b><?=$laddban_Type?>:</b>Banners<b><br/>
                                            <?=$laddban_URL?>:</b> <a href='<?=$row->banner_url?>' target="new">
                                            <?=$row->banner_url?></a></span>
                        </td>
                            <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
                                            <a href="#" onclick="window.open('edit_banner.php?id=<?=$row->banner_id?>','new',100,400)"><?=$laddban_Edit?></a>&nbsp;&nbsp;
                                <a href='index.php?Act=add_banner&amp;mode=delete&amp;id=<?=$row->banner_id?>'   onclick="return del_onclick()"><?=$laddban_Delete?>&nbsp;</a>
                            </td>
                      </tr>
                          <tr>
                      <td colspan="2" height='69' width='608'><a href='<?=$row->banner_url?>'>
                <img src="<?=$row->banner_name?>" border='0' width="<?=$row->banner_width?>" height="<?=$row->banner_height?>" alt="" /></a></td>


                      </tr>

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

<script language="javascript" type="text/javascript">
	//document.bannerForm.bannerSize.selectedIndex=0;
	//explode();

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