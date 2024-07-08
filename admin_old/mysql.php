<?php
 include '../includes/session.php';
 include '../includes/constants.php';
 include '../includes/functions.php';
 include '../includes/allstripslashes.php';

 $partners=new partners;
 $partners->connection($host,$user,$pass,$db);


    $mode = $_POST['mode'];

    if(empty($mode))
    {
	    $sql = stripslashes($_POST['txta_query']);
	    if(!empty($sql))
	    {
	        $res = mysql_query($sql);
	        if(mysql_error()) echo "Error: ".mysql_error();
	        $sql_arr = explode(" ",$sql);
	        if(strtolower($sql_arr[0])=="select") echo "No of rows Returned = ".mysql_num_rows($res);
	        else echo "Executed";
	    }
    }
    else
    {
    	$table = $_POST['txt_tablename'];
        //get fields of this table
		$fields = mysql_list_fields($db, $table);
		$columns = mysql_num_fields($fields);
?>
        <table border="1">
        <tr>
<?php
        for ($i = 0; $i < $columns; $i++)
        {
?>
			<td><?=mysql_field_name($fields, $i)?></td>
<?php
        }
?>
		</tr>

<?php
		$sql1 = "select * from ".$table;
        $res = mysql_query($sql1);
        while($row = mysql_fetch_row($res))
        {
?>
        <tr>
<?php
        for ($i = 0; $i < $columns; $i++)
        {
?>
			<td><?=$row[$i]?></td>
<?php
        }
?>
        </tr>
<?php
        }
?>

        </table>
<?php
    }
?>
<html>

<head>
  <title></title>
</head>

<body>
<form action="" method="post">
<table>
	<tr><td>SQL</td></tr>
	<tr><td><textarea name="txta_query" rows="5" cols="50"><?=$sql?></textarea>
    </td></tr>
    <tr><td><input type="submit" value="Run" /></td></tr>
</table>
</form>
<br/>
<form action="" method="post">
<input type="hidden" name="mode" value="table"/>
<table>
	<tr><td>Table Name</td></tr>
	<tr><td><input type="text" name="txt_tablename" />
    </td></tr>
    <tr><td><input type="submit" value="Run" /></td></tr>
</table>
</form>
</body>

</html>