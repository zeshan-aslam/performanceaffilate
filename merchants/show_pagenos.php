<?php


  $lines_per_page=$lines;
  
  $ret        =mysqli_query($con,$pgsql);
  $nos        =mysqli_num_rows($ret);
  $nop        =ceil($nos/$lines_per_page);
  $tmp        =$url;
  //echo $pgsql." ".$nos." ".$nop;
  if(!strstr($tmp,"?")) $sp="?";
  else $sp        ="&";

?>
<table >
        <tr>
<?php

  /*if(!isset($_GET['page'])) $page=1;
  else $page=$_GET['page'];*/
  $cb        =floor(($page-1)/5)+1;

  $j        =($cb-1)*5+1;
  if($cb>1){
?>
<td class="tdwbdr"><a href="<?=$url.$sp?>page=<?=$j-1?>"><::</a></td>
<?php
}
  for ($i=$j; ($i<$j+5 and $i<=$nop); $i++) {
?>
<td class="tdwbdr">
<?php
if($i==$page) echo "<b>$i</b>";
else echo "<a href='$url$sp"."page=$i'>".$i."</a>";
?>
</td>
<?php
}
if(ceil($nop/5)!=$cb){
?>
<td class="tdwbdr"><a href="<?=$url.$sp?>page=<?=$i?>">::></a></td>
<?}?>
 </tr>
</table>