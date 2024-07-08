<?

$msg		=$_GET['msg'];
$affiliate	=trim(stripslashes($_POST['affiliate']));

$sql ="select * from partners_affiliate where affiliate_status like 'approved'";// geting records from affiliate table
if(!empty($affiliate)){
    $affiliate1		 =addslashes($affiliate);
    $sql            .= " and CONCAT(affiliate_firstname,' ',affiliate_lastname) like('%$affiliate1%') ";
}
$ret =mysql_query($sql);                                                        // for getting all the affilaites recors

$temp_sql	=  "DELETE from partners_temp";
mysql_query($temp_sql);
$i=0;
echo    "<br/>";
echo    "<form name=\"pay\" method=\"post\" action=\"\"> ";
echo    "<table width=\"50%\" class=\"tablebdr\" align=\"center\">\n ";
echo    "<tr>";
echo    "<td class =\"tdhead\" height=\"25\" align=\"center\" colspan=\"3\">Search Affiliate</td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\" colspan=\"3\"></td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\">Affiliate</td>\n";
echo    "<td  height=\"25\" align=\"center\"><input type=\"text\" name=\"affiliate\" value=\"".$affiliate."\"></td>\n";
echo    "<td  height=\"25\" align=\"center\"><input type=\"submit\" name=\"search\" value=\"Search\"></td>\n";
echo    "</tr>";
echo    "<tr>";
echo    "<td  height=\"25\" align=\"center\" colspan=\"3\"></td>\n";
echo    "</tr>";
echo    "</table>";
echo    "</form>";

//checking for each records of affiliates
if(mysql_num_rows($ret)>0) {

		$Marray	   	   = array();                 								// array used to store mercahnt current amount in the account

        $printtable   ="<br/>"  ;
        $printtable .= "<table width=\"90%\" class=\"tablebdr\" align=\"center\">\n ";
        echo    $printtable;                                                                         // amount tobe paid to affiliate
        												                        // contains all selecetd transactions(for paymenst)
        while($row=mysql_fetch_object($ret))   {    						    // fisrt while
              $Tarray		   	="";
              $amount 	   	   	= 0;
              $affiliate_id		=$row->affiliate_id;              				//affiliate id
              $affiliate		=stripslashes($row->affiliate_firstname)." ".stripslashes($row->affiliate_lastname);

              $trans_sql  		= "select * from partners_transaction,partners_joinpgm where transaction_joinpgmid=joinpgm_id and transaction_status like 'approved' and transaction_subsaledate like '0000-00-00' and transaction_parentid like '$affiliate_id' and transaction_subsale >0 ";
              $trans_ret  		= mysql_query($trans_sql);           					//geting payment deatils for the selected affiliate from trnsaction table

              if(mysql_num_rows($trans_ret)>0) {       							//getting all pending paymenst
                 while($trans_row=mysql_fetch_object($trans_ret)) {
                 	$trans_id			=$trans_row->transaction_id;
                  	$merchant_id		=$trans_row->joinpgm_merchantid;        //merchant corresponding to the payment
                    $trans_amount		=$trans_row->transaction_subsale;   //amount corresponding to the payment


                    if (array_key_exists($merchant_id, $Marray))  {             //cehckin whether mercahnt already checked
                        $pay_amount  	= $Marray[$merchant_id];       		    // since this merchnat is considered before taking the amount from array
                    }
                    else {
                         $admin_sql = "select pay_amount from admin_pay ";
                    	 $admin_ret = mysql_query($admin_sql);                //since the mercahnt is considering for firsttime getting amount from table
                         if(mysql_num_rows($admin_ret)>0) {                     //checking for each records
                                $admin_row    = mysql_fetch_object($admin_ret);
	                            $pay_amount   = $admin_row->pay_amount;       //mercahnt current account amount
                    }
                    	$Marray["$merchant_id"]=  $pay_amount;
                  }

                  //checking whether minusing this amount may cause mercahnt amount to become 0
                  if(($pay_amount-$trans_amount)>=0)   {
                  		$pay_amount  			-=  $trans_amount; 				// setting the current amount as (current amount-transaction a,mount) since this payment is assumed to be adone
                        $Marray["$merchant_id"]	 =  $pay_amount;                    // setting the current amount
                        $amount		  			 += $trans_amount;                  // setting the amount to bepaid to affiliate
                        $Tarray					 .= $trans_id.",";
                  }
                  //echo $affiliate_id.",".$amount.",".$admin_amount.",".$pay_amount."<br/>";
               }

             }
           //echo $affiliate_id.",".$amount.",".$Tarray.",".$pay_amount."<br/>";
           if($amount>0){
                //insert into heap table

                $i++;
                if($i==1) {

	             $printtable  = "<tr>";
	             $printtable .= "<td class =\"tdhead\" height=\"25\" align=\"center\">Affiliate</td>\n";
	             $printtable .= "<td class =\"tdhead\" height=\"25\" align=\"center\">Amount</td>\n";
	             $printtable .= "<td class =\"tdhead\" height=\"25\" align=\"center\">Trnsactions</td>\n";
	             $printtable .= "<td class =\"tdhead\" height=\"25\" align=\"center\">Action</td>\n";
	             $printtable .= "</tr>";
	             $printtable .= "<tr>";
	             $printtable .= "<td class =\"textred\" height=\"25\" align=\"center\" colspan=\"4\">".$msg."</td>\n";
	             $printtable .= "</tr>";
	             echo    $printtable;
                }
                $today		=date("y-m-d");
                $Tarray		=trim($Tarray,",");
                $temp_sql	=  "INSERT INTO `partners_temp`";
                $temp_sql  .=  "( `temp_id` , `temp_affiliateid` , `temp_date` , `temp_amount` , `temp_transaction` )";
                $temp_sql  .=  "VALUES ('', '$affiliate_id', '$today', '$amount', '$Tarray')";
                mysql_query($temp_sql);
                $temp_id	=mysql_insert_id();


                //printing values
           	 	$printtable  = "<tr>";
	            $printtable .= "<td height=\"25\" align=\"center\">".$affiliate."</td>\n";
	            $printtable .= "<td height=\"25\" align=\"center\">".$amount."</td>\n";
                $printtable .= "<td height=\"25\" align=\"center\"><a href=\"index.php?Act=view_trans&transid=".$temp_id."\">View Transactions</a></td>\n";
                if($amount>$minimum_withdraw)
                   $printtable .= "<td height=\"25\" align=\"center\"><a href=\"2ndpayment_process.php?affiliateid=".$affiliate_id."&amp;merchantid=1&amp;transid=".$temp_id."&amp;amount=".$amount."\">DoPayments</a></td>\n";
                else
                   $printtable .= "<td height=\"25\" align=\"center\" class='textred'>Less Than Minimum</td>\n";
                $printtable .= "</tr>";
	            echo $printtable;
           }
        }

         $printtable = "</table>";
         echo $printtable;
         if($i<1)  {
                 $printtable   ="<br/>"  ;
        	     $printtable .= "<table width=\"90%\" class=\"tablewbdr\" align=\"center\">\n ";
	             $printtable .= "<tr>";
	             $printtable .= "<td class =\"textred\" height=\"25\" align=\"center\" colspan=\"4\">Sorry No Payments Are Pending Or No Money In Admin Account</td>\n";
	             $printtable .= "</tr>";
                 $printtable .= "</table>";
	             echo    $printtable;
                }
}
else{

    			 $printtable   ="<br/>"  ;
        	     $printtable .= "<table width=\"90%\" class=\"tablewbdr\" align=\"center\">\n ";
	             $printtable .= "<tr>";
	             $printtable .= "<td class =\"textred\" height=\"25\" align=\"center\" colspan=\"4\">Sorry No Payments Are Pending Or No Money In Admin Account Or No Affiliates Found</td>\n";
	             $printtable .= "</tr>";
                 $printtable .= "</table>";

	             echo    $printtable;

}



?>