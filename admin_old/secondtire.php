<?php	ob_start();
 include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include"header.php";
 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);
 ?>
<SCRIPT LANGUAGE="javascript" type="text/javascript">
function button1_onclick() {
window.close();
}
</SCRIPT>
<table  cellpadding="0" cellspacing="0" width="60%" class="tablebdr" align="center">
      <tr>
        <td width="100%" colspan="3" class="tdhead" align="center">Second Tire Commissions</td>
      </tr>
      <tr>
        <td width="100%" colspan="3"  align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="30%" align="right" height="30">Sale</td>
        <td width="5%" align="center" height="30"></td>
        <td width="65%" align="left" height="30"><input type="text" name="txtsale" size="10" value="<?=$sale?>">
        <select size="1" name="txtsaletype">
          <option value="$" <?=$ds1?> >$</option>
          <option value="%" <?=$ps1?> >%</option>
          </select></td>
      </tr>
      <tr>
        <td width="100%" colspan="3"  align="center">&nbsp;</td>
      </tr>
      <tr>
         <td width="100%" colspan="2" height="23" >
         <p align="center">
         <input type="submit" value="Change " name ="B1"></p></td>
        <td  width="100%" height=23>
        <P align="center"><INPUT id="button1" type="button" align="middle" value="close" name="button1" onclick="return button1_onclick()"></P></TD>
    </tr>
    <tr>
       <td width="100%" colspan="4" height="23" class="tdhead"></td>
    </tr>
    </table>

  <?
      if($ssale =="nill")
      {
      ?>
<TD align=right bgColor="#FFFFFF" class="tdhead" colspan="2" ><a href="#" onclick="help()">Add New</a></TD>
    <?
      }
      else
      {
    ?>
<TD align=right bgColor="#FFFFFF" class="tdhead" colspan="2" ><a href="#">Edit</a></TD>
    <?
      }
    ?>