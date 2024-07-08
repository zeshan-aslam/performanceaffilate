
<?
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	// for poulating list
	
	$sql ="SELECT event_name from partners_event";
	$res=mysql_query($sql);
	
	$name        =        $_GET['name'];
	$msg         =        $_GET['msg'];
	$status      =        $_GET['status'];

	if ($status=="active") {
		$active="checked";
	}
	else {
		$inactive="checked";
	}

?>

<form method="POST" action="eventvalidate.php" id="f1">
  <p class="textred"><?=$msg?></p>
  <table border='0' cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="373" class="tablebdr">
    <tr>
      <th width="301" colspan="4" height="20" class="tdhead">
      <p align="right">Add Event and Configure E-mail for It</th>
    </tr>
    <tr>
      <td width="12" height="30">&nbsp;</td>
      <td width="125" height="30">Event Name</td>
      <td width="257" height="30"><input type="text" name="nametxt" size="23" value="<?=$name?>" ></td>

    </tr>
    <tr>
      <td width="12" height="24">&nbsp;</td>
      <td width="125" height="24">Status</td>
      <td width="257" height="24">Active<input type="radio" value="active" <?=$active?> name="status">&nbsp;
      Inactive<input type="radio" name="status" value="inactive" <?=$inactive?>></td>
      <td width="9" height="24">&nbsp;</td>
    </tr>
    <tr>
      <td width="12" height="1" ></td>
      <td width="125" height="1" ></td>
      <td width="257" height="1" >
      <input type="submit" value="Add Event" name="B1" style="float: left"></td>
      <td width="7" height="1" ></td>
    </tr>
    <tr>
      <td width="12" height="4"></td>
      <td width="125" height="4"></td>
      <td width="257" height="4">
      </td>
      <td width="7" height="4"></td>
    </tr>
    <tr>
      <th width="402" height="1" colspan="4" class="tdhead">
      <p align="center"></th>
    </tr>
  </table>
 <p>&nbsp;</p>

 </form>

  <form name="FormName" action="event_remove.php" method="post">

 <table border='0' cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="373" class="tablebdr">
    <tr>
      <th width="301" colspan="4" height="20" class="tdhead">
      <p>Remove An Event</th>
    </tr>
    <tr>
      <td width="12" height="24">&nbsp;</td>
      <td width="125" height="24">&nbsp;</td>
      <td width="257" height="24">&nbsp;</td>
      <td width="9" height="24">&nbsp;</td>
    </tr>

    <tr>
      <td width="12" height="30">&nbsp;</td>
      <td width="125" height="30">Event Name</td>
      <td width="257" height="30">
      <select size="1" name="eventcompo" id="select1">
      <option selected >ChooseEvent</option>
      <?

      while($row = mysql_fetch_object($res))
               {
               if (trim($event)==trim($row-> event_name)) {
                                           $var="selected";
               }
               else {
                                           $var="";
               }

      ?>
               <option <?=$var?>> <?=$row->event_name?> </option>
      <?
               }


      ?>

      </select></td>

    </tr>
    <tr>
      <td width="12" height="24">&nbsp;</td>
      <td width="125" height="24">&nbsp;</td>
      <td width="257" height="24">&nbsp;</td>
      <td width="9" height="24">&nbsp;</td>
    </tr>

    <tr>
      <td width="12" height="4"></td>
      <td width="125" height="4"></td>
      <td width="257" height="4">
      </td>
      <td width="7" height="4"></td>
    </tr>
    <tr>
      <th width="402" height="1" colspan="4" class="tdhead">
      <p align="center"><input type="submit" value="REMOVE">
     </th>
    </tr>

  </table>
  <p>&nbsp;</p>

  </form>