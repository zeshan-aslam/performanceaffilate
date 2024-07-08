<?php
        include_once '../includes/constants.php';
        include_once '../includes/functions.php';

        $partners=new partners;
        $partners->connection($host,$user,$pass,$db);

		if($_POST['b1']=="Update")
        {
            reset ($_POST);
        	while (list ($key, $val) = each ($_POST))
	        { 
	          $arr	=	explode("_",$key);
			  $count = count($arr);
              $key	=	$arr[0]." ".$arr[1];
			  if($count == 3)
			  	$key	.=	" ".$arr[2];

              $sql1= "UPDATE partners_event SET event_flag = '".$val."' WHERE event_name = '".$key."'"; 
              mysqli_query($con,$sql1);

	        }
           $msg="Records Updated.";
        }

      $sql ="SELECT * from partners_event where event_status='yes' and event_type='0'";
      $res=mysqli_query($con,$sql);

?>
	<form name='f1' method="post" action="">
  	<table border='0' width="62%" align="center" class="tablebdr" cellpadding="2" cellspacing="2">
        <tr>
            <td width="680" colspan="5" class="tdhead" align="center"><b>Enable Mail Settings To Merchants</b></td>
        </tr>
        <tr>
            <td width="680" colspan="5" class="textred"><p align="center"><?=$msg?></p></td>
        </tr>
        <?
      	while($row = mysqli_fetch_object($res)){
        	$eventname	=trim($row-> event_name);  
        	$flag   =trim($row-> event_flag);
        ?>
        <tr>
            <td width="4" class="grid1"><p>&nbsp;</p></td>
            <td width="189" class="grid1" ><p align="left"><?=$eventname?></p></td>
            <td width="165" class="grid1">
                <p align="center"><input type="radio" name="<?=$eventname?>" value="a" <? echo ($flag=="a" ?  "checked='checked'" :  "" );   ?> /> &nbsp;&nbsp;Enable
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </td>
            <td width="304" class="grid1">
                <p align="center"><input type="radio" name="<?=$eventname?>" value="m"   <? echo ($flag=="m" ?  "checked='checked'" :  "" );   ?>  /> &nbsp;&nbsp;Disable</p>
            </td>  </tr>
     		 <?
                 }

             ?> 
      
		<tr>
            <td width="680" colspan="5" align="center" ><input type="submit" value="Update" name='b1' /> </td>
        </tr>
    </table>
	</form><br />