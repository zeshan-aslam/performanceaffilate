<?
	//geting records from table
	$id		= intval($_GET['merid']);
	$msg	= $_GET['msg'];
	
	$sql 	= "select * from merchant_pay where pay_merchantid='$id'";
	$ret 	= mysqli_query($con,$sql);
	//checking for each records
	if(mysqli_num_rows($ret)>0)
	{
		while($row=mysqli_fetch_object($ret)){
			   $curr_amount=trim(stripslashes($row->pay_amount));
		}
	}
?>
<form name ="adjust" action="adjust_process1.php?id=<?=$id?>" method="post">
<table width="50%" class="tablebdr" align="center">
	<tr >
        <td height="25" colspan="2" class="tdhead heading-3" style="text-align:center"> Adjust Money - Merchant </td>
    </tr>
    <tr >
        <td height="25" colspan="2" align="center" class="textred"> <?=$msg?> </td>
    </tr>
    <tr>
        <td width="51%" height="25">Current Amount</td>
        <td width="49%" height="25" align="left">: <?=round($curr_amount,2)?> </td>
    </tr>
    <tr>
        <td height="25">Amount  </td>
        <td height="25" align="left">:
          <input type="text" name="amount" value="<?=$amount?>" />      </td>
    </tr>
    <tr>
        <td height="25">Action  </td>
        <td height="25" align="left">:
          <select name="action" >
        <option value="add" <? echo $act='add' ?"selected='selected'":""?>>Add</option>
        <option value="deduct" <? echo $act='deduct' ?"selected='selected'":""?>>Deduct</option>
      </select>  </td>
    </tr>
     <tr>
        <td height="25" colspan="2" align="center"><input type="submit" name="submit" value="Adjust Money" />
        </td>
    </tr>
</table>
</form>
<br />