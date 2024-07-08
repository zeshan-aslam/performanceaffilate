<?

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';
  include_once 'payments.php';

  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);

  $mode		= $_GET['mode'];
  $id		= intval($_GET['id']);
  $msg		=$_GET['msg'];

   $sql     ="SELECT * FROM `partners_languages` ";
   $res     =mysqli_query($con,$sql);

   echo mysqli_error($con);

   $num=mysqli_num_rows($res);

   if($mode=="edit")
   {
        $sql1       ="SELECT * FROM `partners_languages`  where languages_id='$id'";
        $res1       =mysqli_query($con,$sql1);
        echo mysqli_error($con);

               while ($row1=mysqli_fetch_object($res1))
               {
                        $language  =    stripslashes(trim($row1->languages_name ));
                        $status=    stripslashes(trim($row1->languages_status));
                        $id =   stripslashes(trim($row1->languages_id));
               }
      }
?>

<br/>
<div align="center" class="textred"><h5><?=$msg?></h5></div>
<form name="form1" method="post" action="languages_validate.php?mode=<?=$mode?>&amp;id=<?=$id?>">

<table width="70%"  border='0' class="tablebdr" align="center">
	<tr>
		<td colspan="4" class="tdhead">Add or Edit languages</td>
		<td width="43%" rowspan="3" valign="top" class="tdhead">
		<table width="100%"  border='0' class="tablewbdr">
	<tr>
		<td colspan="3" class="tdhead">Existing languages</td>
	</tr>
      <?
		  while ($row=mysqli_fetch_object($res))
		  {
					$languages_name  =	stripslashes(trim($row->languages_name ));
					$languages_status=	stripslashes(trim($row->languages_status));
					$languages_id	=	stripslashes(trim($row->languages_id));
    ?>

      <tr class="grid1">
        <td width="69%"><div align="left"  <?= ($languages_status=="inactive" ? "class='textred'" :"")    ?> ><?=$languages_name?></div></td>
        <td width="17%"><div align="center"><a href="index.php?Act=languages&amp;mode=edit&amp;id=<?=$languages_id?>">Edit</a></div></td>
        <td width="14%"><div align="center"><a href="languages_validate.php?mode=delete&amp;id=<?=$languages_id?>">Delete</a></div></td>
      </tr>

      <?
                  }
      ?>

    </table></td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="26%">Language Name</td>
    <td colspan="2" ><input name="language" type="text" size="30" value="<?=$language?>" /></td>
  </tr>
  <tr class="gtrid2">
    <td>&nbsp;</td>
    <td>Status</td>
    <td width="15%">Active &nbsp;
    <input name="status" type="radio" value="active"  <?= ($status=="active" ? "checked='checked'" :"")    ?>   <?= ($mode=="add" ? "checked='checked'" : ""  )?>  /></td>
    <td width="15%">Inactive&nbsp;
    <input name="status" type="radio" value="inactive" <?= ($status=="inactive" ? "checked='checked'" :"")    ?> /></td>
  </tr>
  <tr class="gtrid2">
    <td>&nbsp;</td>
    <td colspan="3"><div align="center">
      <input type="submit" name="Submit" value="Submit" />
    </div></td>
    <td valign="top" class="tdhead">&nbsp;</td>
  </tr>
</table>
</form>
<br/>

<table class="tablebdr" border='0' width="90%">
    <tr>
        <td class="textred">
            <p><b>NOTE :</b></p>
        </td>
    </tr>
    <tr>
        <td>
            <p>If you have added or activated a new Language to this system ,
            Please copy the langage file to lang folders &nbsp;.</p>
        </td>
    </tr>
</table><br />