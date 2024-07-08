<?php
include_once '../includes/db-connect.php';
include_once '../includes/session.php';
header("Cache-control: private"); 

	$response = array();

	$secretkey = $_GET["key"];
	$from = $_GET["from"];
	$to = $_GET["to"];

	if(!empty($secretkey))
	{
		if(!empty($from) && !empty($to))
		{
			$response["from"] = $from;
			$response["to"] = $to;

			$sql = "Select * from partners_affiliate where affiliate_secretkey = '$secretkey' ";
			$result = mysqli_query($con, $sql);

			if(mysqli_num_rows($result) > 0)
			{
				$affiliate = mysqli_fetch_assoc($result) ;

				$sql = "Select GROUP_CONCAT(joinpgm_id) as programids from partners_joinpgm where joinpgm_affiliateid = '".$affiliate["affiliate_id"]."' ";

				$result = mysqli_query($con, $sql);
				if(mysqli_num_rows($result) > 0)
				{
					$pgmidsresult = mysqli_fetch_assoc($result) ;

					if($pgmidsresult["programids"] != null)
					{
						$programids = $pgmidsresult["programids"];

						

						$sql = " Select  transaction_id, transaction_type, transaction_status, transaction_dateoftransaction, transaction_amttobepaid, transaction_dateofpayment, transaction_referer, transaction_orderid, transaction_subid, transaction_transactiontime ";
						$sql.= " from partners_transaction where transaction_type in ('sale','lead') and transaction_joinpgmid in (".$programids.") and transaction_status = 'approved' and (transaction_dateoftransaction between '$from' and '$to'  )";

						$result = mysqli_query($con, $sql);

						if(mysqli_num_rows($result) > 0)
						{
							while($record = mysqli_fetch_assoc($result))
							{
								$response["transactions"][] = $record;
							}
						}

					}
				}
			}
		}
		else
		{
			$response["message"] = "Invalid dates";
		}
	}
	else
	{
		$response["message"] = "Invalid secret key";
	}

	// echo "these are records";
	echo json_encode($response);

?>