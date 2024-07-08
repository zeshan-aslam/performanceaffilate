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
	?>
	<form name="reg" action="add_money_validate.php" method="post">		
		<input type="hidden" name="id" value="<?=$id?>" />
		
		<div class="row"> 
			<div class="col-md-6">
				<div class="card stacked-form">
					<div class="card-body"> 
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
								 	<label><?=$lang_PaymentGateway?></label>
									<select name="modofpay" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
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
									<span><? echo $msg ?></span>
								</div>					
								<div class="form-group">
									<label><?=$lang_addmoney?> : <?=$currSymbol?></label>
									<input class="form-control" type='text' name='amount' size='5' value='<?=$amount?>' />
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input name="currValue" type="hidden" value="<?=$currValue?>" />
									<?php
									if(!empty($id)){
									?>
										<input class="btn btn-fill btn-info" type="submit" value="Edit Amount" name="B1" />
									<?php
									}
									else{
									?>
										<input class="btn btn-fill btn-info"  type="submit" value="Add Money" name="B1" />
									<?php
									}?>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>
			<div class="col-md-6">
				<div class="card stacked-form">
					<div class="card-body"> 
						<div class="row">
							<div class="col-md-12">
								<h3>Bank Account Details</h3>
								<p>Account Name: 1st Stop</p>
								<p>Account Number: 53563801 &nbsp;&nbsp; Sort Code: 090126</p>
								<p>BIC: ABBYG82LXXX &nbsp;&nbsp; IBAN: GB33ABBY09012653563801</p>
								<p>Bank A/c No: 09-01-26 53563801</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<div class="row">
		<div class="col-md-12">
			<div class="card strpied-tabled-with-hover">
				<div class="card-header">
					<h4 class="card-title"><?=$lang_AddHistory?></h4>
					<?
					if(mysqli_num_rows($newRet)>0){
						$i = 0;
					?>
				</div>
				<div class="card-body table-full-width table-responsive">
					<table class="table table-hover table-striped">
						<thead>
							<th><?=$lang_SlNo?></th>
							<th><?=$lang_Amount?></th>
							<th><?=$lang_Mode?></th>
							<th><?=$lang_Pay?></th>
							<th><?=$lang_Status?></th>
						</thead>
						<tbody>
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
						<td><?=$newRow->DATE?></td>
						<td><?=$currSymbol?> <?=$amount1?>
						<?php
						# give a link to edit the amount if the status is processing
						if($newRow->addmoney_status=="waiting" and $newRow->addmoney_paytype=="WireTransfer"){
						?>
							<a href="index.php?Act=add_money&amp;id=<?=$newRow->addmoney_id?>"><?=$common_edit?></a>
						<?php
						}  
						?>
						</td>
						<td><?=$cap?></td>
						<td><?=$newRow->addmoney_paytype?></td>
						<td><?=$img?></td>
					</tr>
					<? $i++;
					$class =($i%2==0)?'grid1':'grid2';
					}?>
					
					</tbody>
				</table> 
				<div class="custom_pagination">
				<? $url ="index.php?Act=add_money";  //adding page nos
				include '../includes/show_pagenos.php';
				?>
				</div>
			</div>	
			<?
			} 
			?>			
			</div>
		</div>
	</div>