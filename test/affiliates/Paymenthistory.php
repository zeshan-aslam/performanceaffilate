<?php

      $sqlGate			= "SELECT * FROM partners_request";
      $retGate			= mysqli_query($con, $sqlGate);
	 
	 ?>
<div class="row"> 
	<div class="col-md-12"> 
		<div class="card regular-table-with-color">
			<div class="card-body table-full-width table-responsive">	 	 
				<table class="table table-hover">
					<thead> 
						<tr>
							<th>Request ID</th>
							<th>Request Affiliate ID</th>
							<th>Request Date</th>
							<th>Request Amount</th>
							<th>Request Status</th>
						</tr> 
					</thead>
					<tbody>       
			<?php
			 while($row=mysqli_fetch_object($retGate))
			 {		
				  $request_id_val           = $row->request_id;
				  $request_affiliateid_val    = $row->request_affiliateid;
				  $request_date_val           = $row->request_date;
				  $request_amount_val           = $row->request_amount;
				  $request_status_val           = $row->request_status;
		   
			?>
	    <tr class="<?=$classid?>">
			<td><?=$row->request_id?>  </td>
			<td><?=$row->request_affiliateid?>  </td>
			<td><?=$row->request_date?>  </td>
			<td><?=$currSymbol?><?
			echo $mainval= number_format((float)$request_amount_val, 2, '.', '');  // Outputs -> 105.00?>
				
			</td>
			<td><?=$row->request_status?>  </td>        
		</tr>
		<?php
			}	 
		?>
		</tbody>
    </table>