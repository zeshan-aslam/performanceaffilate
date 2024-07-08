<?php


$pgmid = intval($_GET['pgmid']);
$mode  = $_GET['mode'];


$sql = " SELECT * FROM partners_upload 	WHERE upload_programid = '$pgmid' AND upload_status = 'Active'";
$ret = mysqli_query($con,$sql) or die("You have an error while processing sql query ".mysql_error() );


?>
 <br/>


         <table width="80%" cellpadding="5" cellspacing="0" border="0" class="tablebdr" align="center">
          <tr>
	        <td class="tdhead" colspan="4"><?=$lang_pdt_head?>
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
                <td class="textred"><a href="get_product.php?id=<?=$row->upload_id?>"><b>&laquo; <?=$lang_pdt_download?> &raquo;</b></a>
	        	</td>
	      	</tr>
            <?
             $i++;
            }
          }else{
          ?>
           <tr>
	        <td class="textred" colspan="4" align="center"><?=$lang_pdt_norec?>
	        </td>
	      </tr>
          <?
          }
          ?>

         </table>