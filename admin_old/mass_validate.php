<?php	ob_start();

 	include '../includes/session.php';
 	include '../includes/constants.php';
 	include '../includes/functions.php';
 	include '../includes/allstripslashes.php';
    $partners=new partners;
 	$partners->connection($host,$user,$pass,$db);

    $today		= date("Y-m-d");
    $elements   = $_POST['elements'];

	if(!count($elements)){
		Header("Location:index.php?Act=request&msg=Please Select Requests");
		exit;
	}

     for($i=0;$i<count($elements);$i++){

     	 $request_id  = $elements[$i];

	    $sqlMass  =   " SELECT * FROM  partners_request AS R , partners_bankinfo AS B " ;
	    $sqlMass .=   " WHERE R.request_id = $request_id ";
	    $sqlMass .=   " AND B.bankinfo_modeofpay = 'Paypal' ";
	    $sqlMass .=   " AND R.request_affiliateid = B.bankinfo_affiliateid ";

        $retMass  = mysql_query($sqlMass);
        if(mysql_num_rows($retMass)>0){
          $rowMass              = mysql_fetch_object($retMass);
          $affiliate_id			= $rowMass->request_affiliateid;
          $amount				= $rowMass->request_amount;

         $sql		= "DELETE FROM partners_request where request_id ='$request_id'";
         $res		= mysql_query($sql);
         echo mysql_error();

        $today            =date("Y-m-d");
        $sql       ="INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag` , `adjust_amount` , `adjust_date` , `adjust_no` )
        VALUES ('', '$affiliate_id', 'withdraw', 'a', '$amount', '$today', '0') ";
        $res        =mysql_query($sql);
        echo mysql_error();

        $sql		="SELECT * FROM `affiliate_pay` where pay_affiliateid='$affiliate_id'";
        $res		=mysql_query($sql);
        echo mysql_error();
        $num=mysql_num_rows($res);
        if($num>0)
        {
            while ($row=mysql_fetch_object($res))
            {
                        $balance    =   stripslashes(trim($row->pay_amount));
            }
        }
        $amount	=  $balance -$amount;

	    $sql        ="UPDATE `affiliate_pay` SET  pay_amount = $amount where pay_affiliateid='$affiliate_id'";
	    $res        =mysql_query($sql);
	    echo mysql_error();
        }
       }


       Header("Location:index.php?Act=request&msg=Amount Transferd Successfully");
       exit;

    //geting records from table

?>