<?php   

	$id = intval($_GET['id']);
	
	$dftsql =  "SELECT * FROM partners_currency WHERE currency_id = '$id' ";
	$dftret	= mysql_query($dftsql);
	
	if(mysql_num_rows($dftret)>0){
		$dftrow   = mysql_fetch_object($dftret);
		$dftcurr  = trim(stripslashes($dftrow->currency_caption));
		$dftsym   = trim(stripslashes($dftrow->currency_symbol));
	}
	#-------------------------------------------------------------------------------
	#  getting existing currencies.
	#-------------------------------------------------------------------------------
	$sql =  "SELECT * FROM partners_currency WHERE currency_id <> '$id' ";
	$ret =  mysql_query($sql) or die("You have an error while fetching currencies ".mysql_error() );

?>
	<form name="FormName" action="setdefault_validate.php" method="post">
		<table width="70%" cellpadding="5" cellspacing="0" border='0' class="tablebdr" align="center">
		<tr><td class="tdhead" colspan="6" align="center" >Set <?=$dftcurr?>(<?=$dftsym?>) As Default Currency</td></tr>
		<tr><td class="textred" colspan="6" align="center" ><?=$ErrMsg?></td></tr>
		<?
		# displau all currencies
		if(mysql_num_rows($ret)>0){
			$i = 0;
			while($row=mysql_fetch_object($ret)){
				$i++;
				
				$currid .= ",".$row->currency_id;
				?>
				<tr><td colspan="3" align="right" width="40%"><b><?=$i?></b>.&nbsp;Set 1 <?=$dftsym?> = </td></tr>
				<td colspan="3" align="left" >
				<input name="currency_relation[<?=$row->currency_id?>]" type="text" value="" size="10"> <?=$row->currency_symbol?>
				</td> 
			<?
			}
			$currid  = trim($currid,",");
		}
		else{
		?>
			<tr><td class="textred" colspan="6" align="center" >Sorry, No Currency(s) Found </td></tr>
		<?
		}
		?>
		<tr><td class="tdhead" colspan="6" align="center" >
		<input type="hidden" name="currid" value="<?=$currid?>">
		<input type="hidden" name="id" value="<?=$id?>">
		<input type="submit" value="Change"></td></tr>
		</table></form>