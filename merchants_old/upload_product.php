<?php

$pgmid = intval($_GET['pgmid']);
$msg   = $_GET['msg'];

switch($msg) {
 case 1:
       $err = $lang_product_msg1;
      break;
 case 2:
      $err = $lang_product_msg1;
      break;
 case 3:
      $err = $lang_product_msg2;
      break;
 case 4:
      $err = $lang_product_msg4;
      break;
 case 5:
      $err = $lang_product_msg5;
      break;
}
$sql = " SELECT * FROM partners_upload 	WHERE upload_programid = '$pgmid' AND upload_status not like 'deleted' ";
$ret = mysqli_query($con,$sql) or die("You have an error while processing sql query ".mysqli_error($con) );
?>

<form name="FormName" action="upload_validate.php?pgmid=<?=$pgmid?>" method="post" enctype="multipart/form-data">
 <table width="90%" cellpadding="5" cellspacing="0" border="0" class="tablebdr" align="center">
  <tr >
  	<td class="tdhead" colspan="2" ><?=$lang_product_upload?>
  	</td>
  </tr>
  <tr>
    <td class="textred" colspan="2" ><b><u><?=$lang_product_note?>:</u>
    <br/><br/>
    <?=$lang_product_desc?><br/>
     <a href="sample.csv" target="_blank"><?=$lang_product_clk?></a>
    </b>
    </td>
  </tr>
  <tr>
    <td height="20" align="center" width="60%" valign="top">

         <table width="100%" cellpadding="5" cellspacing="0" border="0" class="tablebdr" align="center">
          <tr>
	        <td class="tdhead" colspan="5"><?=$lang_product_file?>
	        </td>
	      </tr>
          <?
           if(mysqli_num_rows($ret)>0){
            $i =1;
            while($row = mysqli_fetch_object($ret)){
            ?>
            <tr>
                <td >&nbsp;</td>
                <td ><b><?=$i?>.</b></td>
                <td class="textred"><?=$row->upload_actualfile?></td>
                <td class="textred"><?=$row->upload_status?></td>
                <td class="textred"><a href="delete_prdt.php?id=<?php echo $row->upload_id?>&amp;pgmid=<?php echo $pgmid?>"><?=$common_delete?></a>
	        	</td>
	      	</tr>
            <?
             $i++;
            }
          }else{
          ?>
           <tr>
	        <td class="textred" colspan="5"><?=$lang_product_norec?>
	        </td>
	      </tr>
          <?
          }
          ?>

         </table>
  	</td>
    <td valign="top">
     <table width="100%" cellpadding="5" cellspacing="0" border="0" class="tablebdr" align="center">
          <tr>
	        <td class="tdhead" ><?=$lang_product_uploadfile?>
	        </td>
	      </tr> <tr>
            <td class="textred" ><?=$err?>
            </td>
          </tr>

    <tr>
  	<td height="20" align="center"> <input name="product" type="file" value="" />
  	</td>
  </tr>
  <tr>
  	<td height="20" align="center"><input type="submit" value="<?=$lpgm_upld?>" />
  	</td>
  </tr>
     </table>
    </td>
  </tr>
   <tr>
  	<td class="tdhead" colspan="2" >&nbsp;
  	</td>
  </tr>
 </table>
</form>