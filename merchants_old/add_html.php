<?php

if($_SERVER['REQUEST_METHOD']=="POST")
{
 function add($lHTML_success)
            {

              $con = $GLOBALS["con"];
                   $pgmid=$_SESSION['PGMID'];
                   $text= addslashes($_POST['t1']);
					$text = str_replace("\r\n","",$text);
            		//$sql="insert into partners_html (html_id ,html_programid ,html_text) values('','$pgmid','$text')";
					$sql="insert into partners_html SET  html_programid = '".addslashes($pgmid)."',   html_text = '$text'  ";
                    mysqli_query($con,$sql);  

                    echo mysqli_error($con);
                   echo "<p align='center' > <font color='red'><strong>$lHTML_success	</strong></font></p>";

            }

                if ($_POST['t1']=="") {

                echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";

                }
                else {


	    $sql="select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
	    $result = mysqli_query($con,$sql);
	    //echo $sql;
	    echo mysqli_error($con);

	                if(mysqli_num_rows($result)>0)
	                {
	                       $sql1="select * from partners_html where html_programid ='$_SESSION[PGMID]'";
	                         $result = mysqli_query($con,$sql1);
	                         echo mysqli_error($con);
	                        // echo $sql1;
	                          if(mysqli_num_rows($result)>0)
	                        {
								//  echo "normal user with a banner cant add ";
                                echo "<p align='center' > <font color='red'><strong>$lnormal HTML Code !!</strong></font></p>";
	                        }
	                        else
	                        {

	                        add($lHTML_success);
	                         //echo "norm user no banner ok adding";
	                        }


	                }
	                else
	                {
	                //echo "advance user ok adding";
	                add($lHTML_success);
	                }



            }   /// else closing of null check


}/////////  submit check if closing


else if($_GET['mode']=="delete")
{
	$id=$_GET['id'];

   $sql="Delete from partners_html where html_id='$id'";

   mysqli_query($con,$sql);

   mysqli_error($con);

  //echo $_SESSION['PGMID'];
   echo "<p align='center' ><font color='red'><strong>$lHTML_delete	</strong></font></p>";
}



?>
<form method="post" action="" >

       <? include_once "add_link.php"; ?>
        <p>&nbsp;</p>
    <table border="0" cellpadding="0" style="border-collapse: collapse" align="center" width="78%" id="AutoNumber1" class="tablebdr">
      <tr>
        <td colspan="4" class="tdhead" height="19">
        <b><?=$laddhtml_HTMLAdd?></b></td>
      </tr>
      <tr>
        <td width="6%" height="19">&nbsp;</td>
        <td colspan="2" height="19">
        <b><?=$laddhtml_TocreateHTMLaddyoumustfillthefollowingfields?> .</b></td>
        <td width="6%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="6%" height="70">&nbsp;</td>
        <td width="10%" height="70" valign="top"><b><?=$laddhtml_HTML?></b></td>
        <td width="78%" height="70" align="left" valign="top"><?=$laddhtml_text?></td>
        <td width="6%" height="70">&nbsp;</td>
      </tr>
      <tr>
        <td width="6%" height="19">&nbsp;</td>
        <td width="10%" height="19">&nbsp;</td>
        <td width="78%" height="19">&nbsp;</td>
        <td width="6%" height="19">&nbsp;</td>
      </tr>
      <tr>
        <td width="6%" height="146">&nbsp;</td>
        <td colspan="2" height="146">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" id="AutoNumber2" >
          <tr>
            <td height="19" colspan="4" class="tdhead">
            <b><?=$laddhtml_Settings?></b></td>
          </tr>
          <tr>
            <td colspan="4" height="14" class="grid1">
            </td>
          </tr>
          <tr>
            <td width="1%" height="22" class="grid1">&nbsp;</td>
            <td width="10%" height="22" valign="top" class="grid1"><b><?=$laddhtml_HTML?>&nbsp; </b></td>
            <td width="87%" height="22" class="grid1">
            <textarea rows="6" cols="44" name="t1" id="t1"></textarea>
			</td>
            <td width="2%" height="22" class="grid1">&nbsp;</td>
          </tr>
          <tr>
            <td width="1%" height="9" class="grid1"></td>
            <td width="10%" height="9" class="grid1"></td>
            <td width="87%" height="9" class="grid1"></td>
            <td width="2%" height="9" class="grid1"></td>
          </tr>
        </table>
        </td>
        <td width="6%" height="146">&nbsp;</td>
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

  <table border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse: collapse; text-align: center"  width="77%" id="AutoNumber4" class="tablebdr">
    <tr>
      <td width="100%" height="18" colspan="3" class="tdhead"><?=$laddhtml_ExistingHtmls?></td>

  </tr>
      	  <?php    ///////////// display  banners /////////////

                       $sql3="select * from partners_html where html_programid ='$_SESSION[PGMID]' ORDER BY html_id DESC";
                       $res=mysqli_query($con,$sql3);
                       //echo $sql3;
                       echo mysqli_error($con);

						//Added by DPT on June/16/05
						//if no html ad exist
						if(mysqli_num_rows($res)<=0)
						{
?>
	<tr>
		<td colspan="3"><?=$laddhtml_no_msg?></td>
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
	                    <td height='1' width='300' bgcolor="#ffffff" class="grid1">
	                    		<span class='text'><b>Type:</b><?=$laddhtml_HTMLCode?><b><br/>
	                    		<?=$laddhtml_HTMLID?>:<?=$row->html_id?></b> .....</span>
                        </td>
	                    <td height='1' width='302' bgcolor="#FFFFFF" class="grid1" align="right">
                 <a href="#" onclick="window.open('edit_html.php?id=<?=$row->html_id?>','new',100,400)"><?=$laddhtml_Edit?></a>&nbsp;&nbsp;
                  <a href='index.php?Act=add_html&amp;mode=delete&amp;id=<?=$row->html_id?>' id="del" onclick="return del_onclick()"><?=$laddhtml_Delete?></a>

	                    </td>
                      </tr>
					  <? $id=$row->html_id?>
	                  <tr>
                      <td colspan="2" height='69' width='608' align="center" ><a href="temp.php?rowid=<?=$id ?>" target="new">
                		<img src='images/html.gif' border='0' width="300" height="60" alt="" /></a></td>
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