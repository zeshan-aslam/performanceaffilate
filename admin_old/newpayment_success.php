<?php


 	include '../includes/session.php';
 	include '../includes/constants.php';
 	include '../includes/functions.php';
 	include '../includes/allstripslashes.php';
    $partners=new partners;
 	$partners->connection($host,$user,$pass,$db);

    $today               = date("Y-m-d");
	$affiliate_id        = intval($_GET['affiliateid']);
 	$amount   			 = $_GET['amount'];
 	$request_id			 = $_GET['request_id'];

//----------------------------------  security -------------------------------------------------------------//
	$secid               =$_GET['secid'];
	$secpass             =$_GET['secpass'];

	$secsql	= "select * from random_gen where rand_genid='$secid' and rand_genpwd='$secpass'";
	$secres=mysql_query($secsql);

	if(mysql_num_rows($secres)>0){
		$secdel ="delete from random_gen where rand_genid='$secid' and rand_genpwd='$secpass'";
		mysql_query($secdel);
	}
	else{
		Header("Location:index.php?Act=request&msg=Sorry Payment error ....");
		exit;
	}
// ----------------------------- security test end ------------------------------------------//

	$sql		="DELETE FROM partners_request where request_id ='$request_id'";
	$res		=mysql_query($sql);
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

       Header("Location:index.php?Act=request&msg=Amount Transferd Successfully");
       exit;

    //geting records from table

?>