<?

	# get id for editing the amount
	$id		= intval($_GET['id']);
    if(!empty($id))
    {
    	# get current amount
        $sql = "SELECT * FROM partners_addmoney WHERE addmoney_id = '".$id."' ";
        $res = mysqli_query($con,$sql);
        if($row = mysqli_fetch_object($res))
        {
        	$amount		= $row->addmoney_amount;
            $modofpay	= $row->addmoney_paytype;
            if($currValue != $default_currency_caption)
          		$amount  = getCurrencyValue($date, $currValue, $amount);
        }
    }

	if(empty($page))  
		$page  = $partners->getpage();

	# get all payment methods from table
	$sql 	= "select * from partners_paymentgateway where pay_status like 'Active'";
	$ret 	= mysqli_query($con,$sql);
	$msg	= $_GET['msg'];

	# get all ad money requets
	$MERCHANTID	= $_SESSION['MERCHANTID'];
	
	$newSql 	= " SELECT *, date_format(addmoney_date,'%d-%M-%Y') AS DATE FROM partners_addmoney 
					WHERE addmoney_merchantid = '$MERCHANTID'  ";


	$pgsql  	= $newSql;
	$newSql	   .= " LIMIT ".($page-1)*$lines.",".$lines;
	$newRet 	= mysqli_query($con,$newSql);

/*	echo "<div align='center' class='textred'><b>$msg</b></div>"			*/?>
	<form name="reg" action="add_money_validate.php" method="post">
	<input type="hidden" name="id" value="<?=$id?>" />
	<table width="60%" border="0" cellpadding="0" cellspacing="0" class="tablebdr" id="AutoNumber1" align="center">
	
		<tr>
			<td height="10" class="tdhead" align="center"><b><?=$lang_PaymentGateway?></b>
			<select class="dropdown" name="modofpay" >
			<?php
			if(mysqli_num_rows($ret)>0){
				while($row=mysqli_fetch_object($ret)){
					if($modofpay==$row->pay_name) 
						$sel	= "selected = 'selected'";
					else
						$sel 	= "";
			?>
					<option value="<?=$row->pay_name?>" <?=$sel?>><?=$row->pay_name?></option>
			<?
				}
			}  
			?>
			</select>
			 </td>
		</tr>
  		<tr> <td align="center" class="error" height="25"> <? echo $msg ?></td ></tr>
		<tr>
			<td>
				<table width="90%" class="tablebdr" align="center" border="0">
					<tr>
						<td height="25" width="50%">&nbsp;</td>
						<td height="25" width="50%">&nbsp;</td>
					</tr>
					<tr>
						<td height='25' width='50%' align="right"><b><?=$lang_addmoney?> :</b> &nbsp;&nbsp;&nbsp;</td>
						<td height='25' width='50%'><b><?=$currSymbol?></b>&nbsp;&nbsp;&nbsp;
						<input type='text' name='amount' size='5' value='<?=$amount?>' /></td>
					</tr>
					<tr>
						<td height="25" width="50%">&nbsp;</td>
						<td height="25" width="50%">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="19">&nbsp;</td>
		</tr>
		<tr>
			<td height="19" align="center">
			<input name="currValue" type="hidden" value="<?=$currValue?>" />
			<?php
			if(!empty($id)){
			?>
				<input type="submit" value="Edit Amount" name="B1" />
			<?php
			}
			else{
			?>
				<input type="submit" value="Add Money" name="B1" />
			<?php
			}
			?>
			</td>
		</tr>
		<tr>
			<td height="19">&nbsp;</td>
		</tr>
	</table>
	</form>
	<br />
	<?
	if(mysqli_num_rows($newRet)>0){
		$i = 0;
	?>
	<table width="85%" class="tablebdr" align="center" border="0" >
		<tr>
		<td colspan="5" class="heading-2" style="text-align:center"><b><?=$lang_AddHistory?> </b>	</td>
		</tr>
		<tr >
			<td height="20" width="20%" align="center" class="tdhead"><b><?=$lang_SlNo?></b></td>
			<td height="20" width="10%" align="center" class="tdhead"><b><?=$lang_Amount?></b></td>
			<td height="20" width="15%" align="center" class="tdhead"><b><?=$lang_Mode?></b></td>
			<td height="20" width="15%" align="center" class="tdhead"><b><?=$lang_Pay?></b></td>
			<td height="20" width="20%" align="center" class="tdhead"><b><?=$lang_Status?></b> </td>
		</tr>
		<?php
		while($newRow = mysqli_fetch_object($newRet)){
		
			switch($newRow->addmoney_mode){
				case "register":
					$cap = "Registration Fee";
				break;
				
				case "upgrade";
					$cap = "Upgradation Amount";
				break;
				case "addmoney";
					$cap = "Deposited";
				break;
		}
		$date	= $newRow->addmoney_date;
		if($currValue != $default_currency_caption){
			$amount1  = getCurrencyValue($date, $currValue, $newRow->addmoney_amount);
		}else   
			$amount1  = $newRow->addmoney_amount;
		
		if($newRow->addmoney_status=="waiting") 
			$img = "<font color='#006400' size='2'>Processing.......</font>";
		elseif($newRow->addmoney_status=="suspend") 
			$img = "<font color='#98344E' size='2'>Payment Rejected</font>";
		else 
			$img = "<font color='#98344E' size='2'>Payment Success</font>";
		
		$class =($i%2==0)?'grid1':'grid2';
		?>
		<tr class="<?=$class?>">
			<td height="20" width="20%" class='textred' align="center"><b><?=$newRow->DATE?></b></td>
			<td height="20" width="10%"  align="center"><b><?=$currSymbol?> <?=$amount1?></b>
			<?php
			# give a link to edit the amount if the status is processing
			if($newRow->addmoney_status=="waiting" and $newRow->addmoney_paytype=="WireTransfer"){
			?>
				<a href="index.php?Act=add_money&amp;id=<?=$newRow->addmoney_id?>"><?=$common_edit?></a>
			<?php
			}
			?>
			</td>
			<td height="20" width="15%" ALIGN="center"><b><?=$cap?></b></td>
			<td height="20" width="15%" align="center"><b><?=$newRow->addmoney_paytype?></b></td>
			<td height="20" width="20%" ALIGN="center"><b><?=$img?></b></td>
		</tr>
		<? $i++;
		$class =($i%2==0)?'grid1':'grid2';
		}?>
		<tr>
			<td width="100%" colspan="5" align="center" >
				<?
				$url    ="index.php?Act=add_money";    //adding page nos
				include '../includes/show_pagenos.php';
				?>
			</td>
		</tr>
	</table>
	<?
	}
	?>
	<br />