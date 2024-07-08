<?php
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$action    	= trim($text1);
	$name      	= trim($category);
	if($_GET['msg']!=""){
		$msg1	= $_GET['msg'];
	}
	else
		$msg	= "";
	
	if($action==!""){
		if($name==""){
			$msg= "Please Enter a valid Category  !!";
		}
		else if($action=="add"){
			$sql= "insert into partners_category (cat_name) values('".addslashes($name)."')";
			mysqli_query($con,$sql);
			
			if(mysqli_errno($con)=="0"){       
				$msg= stripslashes($name)." has been added to Category list !!";
			}
			else{
				$msg= stripslashes($name)." is alredy exists in  Category list !!";
			}
		}
	}

	$sql 	= "SELECT cat_name from partners_category";
	$res	= mysqli_query($con,$sql);
?>
	<script language="javascript" type="text/javascript">
		function add_onclick() {
			document.f1.text1.value="add";
			document.f1.submit();
		}
		function remove_onclick() {
			document.f1.text1.value="remove"
			document.f1.submit();
		}
	</script>

<form method="post" action="index.php?Act=category" id="f1" name="f1">
<input  type="hidden" id="text1" name="text1" value="" />
  <table border='0' cellpadding="0" cellspacing="0" width="40%" id="AutoNumber3" class="tablebdr">
    <tr>
      	<td width="100%" colspan="5" class="tdhead" align="center"><b> Add or Remove Category </b></td>
    </tr>
    <tr>
     	<td width="100%" colspan="5" class="textred" align="center" height="30">&nbsp;<?=stripslashes($msg)?></td>
    </tr>
    <tr>
      	<td width="2%">&nbsp;</td>
      	<td width="45%">Category </td>
      	<td width="3%"><b>:</b></td>
      	<td width="48%"><input name="category" size="21" id="category" value="" /></td>
      	<td width="2%">&nbsp;</td>
    </tr>
    <tr>
		  <td colspan="5" height="15" >&nbsp;</td>
    </tr>
	<tr>
		  <td width="50%" colspan="5" align="center" >
		  <input type="button" value="Add" name="B1" id="add" onclick="return add_onclick()" /></td>
    </tr>
    <tr>
		  <td colspan="5" height="15" >&nbsp;</td>
    </tr>
  </table>
</form><br/>
<form name="FormName" action="category_remove.php" method="post">
 <table border="0" cellpadding="0" cellspacing="0" width="40%" id="AutoNumber2" class="tablebdr">
    <tr>
      <th width="402" colspan="4" height="20" class="tdhead"><p>Remove Category</p></th>
    </tr>
    <tr>
      <td width="402" colspan="4" height="30" class="textred" align="center"> <?=stripslashes($msg1)?></td>
    </tr>
    <tr>
      <td width="402" height="30">&nbsp;</td>
      <td width="125" height="30">Category </td>
      <td width="257" height="30" align="left">
      <select size="1" name="categorycompo" id="select1">
      <option selected="selected" >Choose a Category</option>
      <?
      while($row = mysqli_fetch_object($res))
               {
               if (trim($category)==trim($row->cat_name)) {
                    $var="selected='selected'";
               }
               else {
                    $var="";
               }
      ?>
               <option <?=$var?>> <?=$row->cat_name?> </option>
      <?
               }
      ?>
      </select></td>
    </tr>
    <tr>
      <td height="15" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <th width="402" height="1" colspan="4" align="center" ><input type="submit" value="Remove" /></th>
    </tr>
    <tr>
      <td height="15" colspan="4">&nbsp;</td>
    </tr>
	
  </table>
  </form>
<br />