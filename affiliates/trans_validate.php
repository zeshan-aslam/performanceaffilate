<?php
	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	include_once '../includes/allstripslashes.php';


	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);


	$Merchant	= trim($_POST['Mname']);
	$Affiliate	= trim($_POST['Aname']);
	$From		= trim($_POST['fromtxt']);
	$To			= trim($_POST['totxt']);

	$sale		= trim($_POST['salecb']);
	$click		= trim($_POST['clickcb']);
	$lead		= trim($_POST['leadcb']);

	//validation

	$fdate		= trim($_POST['fromtxt']);
	$tdate		= trim($_POST['totxt']);


	if(!$partners->is_date($From) || !$partners->is_date($To) )
	{
	    $msg="Please Enter Valid Date" ;
	    header("Location:index.php?Act=transaction&sale=$sale&click=$click&lead=$lead&mer=$Merchant&afil=$Affiliate&from=$From&to=$To&msg=$msg");
	    // echo "err";
	    exit;
	}

	if ($sale=="" and $click=="" and $lead =="")
	{
	    $msg="Please select Sale,Click,Lead or all" ;
	    header("Location:index.php?Act=transaction&sale=$sale&click=$click&lead=$lead&mer=$Merchant&afil=$Affiliate&from=$From&to=$To&msg=$msg");
	    // echo "err";
	    exit;
	}


	$From=$partners->date2mysql($From);
	$To=$partners->date2mysql($To);

    $result1=mysqli_query($con,$sql);

    ///// report creation for click

	if ($click=="clickcb")
	{
                                  //echo "in side click";
	    while($rows=mysqli_fetch_object($result1))
	    {
	    $joinid=$rows->joinpgm_id;


    	$sql="SELECT * FROM partners_transaction AS t, partners_joinpgm AS j WHERE transaction_dateoftransaction between '$From' and '$To' AND transaction_type = 'click' AND transaction_joinpgmid = '1' AND t.transaction_joinpgmid = j.joinpgm_programid GROUP BY j.joinpgm_programid";

        $result=mysqli_query($con,$sql) or die("cant exe");

        $nclick=mysqli_num_rows($result);

    	if ($nclick > 0) {

           /// result table creation

           include"header.php";
           include 'report_links.php';
           include 'report_trans.php';
           include "footer.php"

    ?>

    <table border="1" cellspacing="1" width="720" id="AutoNumber1">
   <tr>
    <td width="70" align="center" class="tdhead">Type</td>
    <td width="93" align="center" class="tdhead">Merchant</td>
    <td width="116" align="center" class="tdhead">Affiliate</td>
    <td width="117" align="center" class="tdhead">Commission</td>
    <td width="151" align="center" class="tdhead">Date of Transaction</td>
    <td width="140" align="center" class="tdhead">Status</td>
  </tr>
  <?
                            while($rows=mysqli_fetch_object($result))
                                          { //////// column creation

                                }


                                            }
    else {
            $msg="Sorry no records found !! " ;
                header("Location:index.php?Act=transaction&sale=$sale&click=$click&lead=$lead&mer=$Merchant&afil=$Affiliate&from=$fdate&to=$tdate&msg=$msg");
                    }

       }  // while close

    } // ifclose


    /*
    $sql="SELECT * from partners_transaction where transaction_dateoftransaction between '$txtfrom' and '$txtto' and transaction_type='lead' and transaction_joinpgmid=$joinid";
    $result=mysqli_query($con,$sql);
    $nlead=mysqli_num_rows($result);

    while($row=mysqli_fetch_object($result))
    {
    $lead=$row->transaction_amttobepaid+$lead;
    }

   // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
    $sql="SELECT *  from partners_transaction where transaction_dateoftransaction between '$txtfrom' and '$txtto' and transaction_type='sale' and transaction_joinpgmid=$joinid";
    $result=mysqli_query($con,$sql);
    $nsale=mysqli_num_rows($result);
    while($row=mysqli_fetch_object($result))
    {
    $sale=$row->transaction_amttobepaid+$sale;
    }

     }

    header("location:index.php?Act=forperiod&click=$click");*/

?>