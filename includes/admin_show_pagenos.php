<?php

  $lines_per_page=$lines1;
  $ret	=mysql_query($pgsql);
  $nos	=mysql_num_rows($ret);
//  echo "Dishum$nos<br/>";
  $nop	=ceil($nos/$lines_per_page);
  $tmp	=$url;
  if(!strstr($tmp,"?")) $sp="?";
  else $sp	="&amp;";

?>
<table >
	<tr>
<?php

  /*if(!isset($_GET['page'])) $page=1;
  else $page=$_GET['page'];*/
  $cb	=floor(($page-1)/5)+1;

  $j	=($cb-1)*5+1;
  if($cb>1){
?>
<td class="tdwbdr"><a href="<?=$url.$sp?>page=<?=$j-1?>"><::</a></td>
<?php
}
  if ($nop >1)
  {
?>
	<td class="tdwbdr"><b>Pages: &nbsp;</b></td>
<?
  }
  for ($i=$j; ($i<$j+5 and $i<=$nop); $i++) {
  	if($page==$i)	{
?>
<td class="tdwbdr"><b><?=$i?></b></td>
<?php	}	else	{	?>
<td class="tdwbdr"><a href="<?=$url.$sp?>page=<?=$i?>"><?=$i?></a></td>

<?php
}
}
if(ceil($nop/5)!=$cb){
?>
<td class="tdwbdr"><a href="<?=$url.$sp?>page=<?=$i?>">::></a></td>
<?}?>
 </tr>
</table>