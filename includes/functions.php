<?php



// beginning of class desi definition
class partners
        {

          var $conLink = null;

        function connection($host,$user,$pass,$db)
        {
          $this->conLink = mysqli_connect($host,$user,$pass);
          mysqli_select_db($this->conLink, $db);

          return ;
        }


        function query($sql)
        {
          if($this->conLink == null)
          {
            $this->conLink = mysqli_connect($host,$user,$pass);
          }

          $result = mysqli_query($this->conLink,$sql);

          return $result;
        }


    //check for admin login
    function islogin()
            {
            if($_SESSION['ADMIN'] || $_SESSION['ADMINUSERID'])
                    return 1;
            else
                    return 0;
            }

      //check for affiliate login
    function isAffiliatelogin()
            {
            if($_SESSION['AFFILIATEID'])
                    return 1;
            else
                    return 0;
            }
             //check for MERCHANT login
    function isMerchantlogin()
            {
            if($_SESSION['MERCHANTID'])
                    return 1;
            else
                    return 0;
            }

    //check for e-mail validation
    function is_email($mail)
            {
               $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/";
               $email = strtolower($email);

               if(!preg_match ($regex, $mail)) return 0;
                  else return 1;
            }
    //check for valid date
   function is_date($date){
		$tmp        =explode('/',$date);
        if(count($tmp)!=3) {
            $tmp  =explode('-',$date);
            if(count($tmp)!=3) return 0;
		}
		if(!is_numeric($tmp[1]) || !is_numeric($tmp[0]) || !is_numeric($tmp[2]))
			return 0;
        if(checkdate($tmp[1],$tmp[0],$tmp[2])) return 1;
        else return 0;

      }
	//check for valid date in mysql Format
	function is_date_Mysql($date){
		$tmp        =explode('/',$date);
		if(count($tmp)!=3) {
			$tmp        =explode('-',$date);
			if(count($tmp)!=3) return 0;
		}
		if(!is_numeric($tmp[1]) || !is_numeric($tmp[0]) || !is_numeric($tmp[2]))
			return 0;
		if(checkdate($tmp[1],$tmp[2],$tmp[0])) return 1;
		else return 0;
	
	}
    // formats the date (mm/dd/yy) to mysql format (yyyy-mm-dd)
    function date2mysql($date){
              $tmp        =explode('/',$date);
       if(count($tmp)!=3) {
               $tmp        =explode('-',$date);
           if(count($tmp)!=3) return "0000-00-00";
          }
       $date        ="$tmp[2]-$tmp[1]-$tmp[0]";
       return $date;
       }

       function format_date($dob,$time=0)
                    {
                    $tmp        =explode(" ",$dob);
                        $date2        =explode("/",$tmp[0]);
                        $dob        =$date2[2]."/".$date2[0]."/".$date2[1];
                        if($time)
                         return $dob." ".$tmp[1];
                        else
                         return $dob;
            }



    function getpage(){
              if(!isset($_GET['page'])) $page=1; //Which page to display?
              else $page=$_GET['page'];
        return $page;
      }

    function show_page_nos($sql,$url,$lines1,$page){

    $tmp	=explode("LIMIT",$sql);

    if(count($tmp)<1) $tmp	=explode("limit",$sql);
  	$pgsql	=$tmp[0];

    include 'admin_show_pagenos.php';
  }

  function RandomNumber( $noLength ) {
	                        $randNo = "";
                            $randArray =  array();

                            $randArray1 =  array(0,1,2,3,4,5,6,9,8,9);//'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

                            $randArray2 =  array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
                            $randArray3 =  array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

	                        for ($index = 1; $index <= $noLength; $index++) {
	                        // Pick random number between 1 and 10

	                        $rand    = mt_rand(0,9);
                            $randNo .= $randArray1[$rand];

                            $rand    = mt_rand(0,25);
                            $randNo .= $randArray2[$rand];

                            $rand    = mt_rand(0,25);
                            $randNo .= $randArray3[$rand];

	                    }
	                    return $randNo;
	             }

        }


 function GetRawTrans($type, $mid, $aid, $pgmid, $linkid,  $from,$to, $date)
 {
 		//Calls function to get the Raw Transaction value sfrom the table rawtrans_daily
   		return  GetRawTrans_daily($type, $mid, $aid, $pgmid, $linkid,  $from,$to, $date) ;

 }

 # -----------------------------------------------------------------------------
 # function to get the raw transcount  from rawtrans_daily table
 # -----------------------------------------------------------------------------
  function GetRawTrans_daily($type, $mid, $aid, $pgmid, $linkid,  $from,$to, $date)
  {
    $con = $GLOBALS["con"];

         # getting all the raw clicks / impressions depending on $type
		 if($type=='impression')
				  $tranSql = " SELECT sum(transdaily_impression )AS TOTAL FROM partners_rawtrans_daily WHERE 1";
		 else
				  $tranSql = " SELECT sum(transdaily_click) AS TOTAL FROM partners_rawtrans_daily WHERE 1";
	
		# finds for a perticular merchant
	
		  if($mid) $tranSql .= " AND transdaily_merchantid = '$mid' ";
	
		# finds for a perticular affilitate
	
		  if($aid) $tranSql .= " AND transdaily_affiliateid = '$aid' ";
	
		# finds for a perticular affilitate
	
		  if($pgmid) $tranSql .= " AND transdaily_programid = '$pgmid' ";
	
		# finds for a perticular affilitate
	
		  if($linkid) $tranSql .= " AND transdaily_linkid = '$linkid' ";
	
	   # finds for particular date randge
		  if($date) $tranSql .= " AND transdaily_date like '$date' ";
	
		  if(($to)and($from)) $tranSql .= " AND transdaily_date between '$from' AND '$to' ";
	
      $con = $GLOBALS["con"];
		  $transRet = @mysqli_query($con, $tranSql);
						 //echo $tranSql; 	exit;
		# finds the count
	
		if(@mysqli_num_rows($transRet)>0){
			$tranRow         = @mysqli_fetch_object($transRet);
		   $totalRecord = $tranRow->TOTAL;
		}
	
		return $totalRecord;
 }



 function viewRawTrans($click, $imp){
				if(!$click)$click 	= '0';
				if(!$imp)$imp 		= '0';
      ?>
      <table width="50%" class="tablewbdr" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr >
		<td height="7" colspan="2" ></td>
      </tr>
	  <tr >
          <td  height="20"  ><b><font color='#923D4E'>Raw Clicks</font></b></td>
		  <td  height="20"  ><b>: <?=$click?></b></td>
	  </tr>
       <tr>
          <td  height="20"  ><b><font color='#923D4E'>Raw Impressions</font></b></td>
		  <td  height="20"  ><b>: <?=$imp?></b></td>
	  </tr>
      </table>
      <?
 }
 

#-------------------------------------------------------------------------------
# Added : 18/1/2005
# Modfd : 18/1/2005
# Function gets the date on which the transaction happended and the currency Name
# and the transaction Amount
# returns the amount corresponding to the specified currency
#-------------------------------------------------------------------------------

/* 
function getCurrencyValue($date, $currencyName, $amount){
  $con = $GLOBALS["con"];

    # initialising currency Value

    $currValue = 0;

    # gets the currency Relation

   // $sql  = " SELECT currency_relation FROM partners_currency WHERE currency_date <= '$date' AND ";
   // $sql .= " currency_caption like '$currencyName' ORDER BY currency_date DESC ";
	
	$sql = "SELECT * FROM partners_currency, partners_currency_relation WHERE currency_caption ='$currencyName' ".
	" AND currency_code = relation_currency_code AND relation_date<='$date' ORDER BY relation_date DESC ";  

    $ret  = @mysqli_query($con,$sql);


    if(@mysqli_num_rows($ret)>0){

          $row = @mysqli_fetch_object($ret);

          # gets currency relation

          $currRelation = $row->relation_value;

          # calculate currency value

          $currValue 	= ( $amount * $currRelation );

          $currValue 	= round($currValue,2);

         //  echo "<br/>date = ".$date.",amount= ".$amount.",relation=".$currRelation.",currency= ".$currName;
    }
     //echo "<br/>date = ".$date.",amount= ".$amount.",relation=".$currRelation.",currency= ".$currencyName;
    return($currValue);
}
*/

// function getCurrencyValue($date, $currencyName, $amount)
// {
//     $con = $GLOBALS["con"];
//     $currValue = 0;

    

//     if(!isset($_SESSION['CURRENCYRELATION']) || $_SESSION['CURRENCYRELATION'] == NULL)
//     { 
//         $sql = " SELECT * FROM partners_currency, partners_currency_relation WHERE currency_caption ='$currencyName' ";
//       $sql.= " AND currency_code = relation_currency_code ";  

//         $ret  = mysqli_query($con,$sql);

//         if(mysqli_num_rows($ret) > 0)
//         {
//             $row = mysqli_fetch_assoc($ret);
//             $_SESSION['CURRENCYRELATION'] = $row;

//         }
//       }

    
//     $currRelation = $_SESSION['CURRENCYRELATION'];
//     $currRelationVal = floatval($currRelation["relation_value"]);
//     $currValue  = ( $amount * $currRelationVal );
//     $currValue  = round($currValue,2);


    
//     return($currValue);
// }



function getCurrencyValue($date, $currencyName, $amount)
{

    return($amount);
}

#-------------------------------------------------------------------------------
# Created By	: SMA
# Created On 	: 5-AUG_2006
#	Function to Convert the currency to the base Currency
#-------------------------------------------------------------------------------
function getDefaultCurrencyValue($date, $currencyName, $amount){
  $con = $GLOBALS["con"];


   $con = $GLOBALS["con"];
    # initialising currency Value

    $currValue = 0;

    # gets the currency Relation

    //$sql  = " SELECT currency_relation FROM partners_currency WHERE currency_date <= '$date' AND ";
    //$sql .= " currency_caption like '$currencyName' ORDER BY currency_date DESC ";
	
	$sql = "SELECT * FROM partners_currency, partners_currency_relation WHERE currency_caption ='$currencyName' ".
	" AND currency_code = relation_currency_code AND relation_date<='$date'  ORDER BY relation_date DESC ";  
	

    $ret  = mysqli_query($con,$sql);


    if(mysqli_num_rows($ret)>0){

          $row = @mysqli_fetch_object($ret);

          # gets currency relation

          $currRelation = $row->relation_value;

          # calculate currency value

          $currValue 	= ( $amount / $currRelation );

          //$currValue 	= round($currValue,2);
         //  echo "<br/>date = ".$date.",amount= ".$amount.",relation=".$currRelation.",currency= ".$currName;
    }
     //echo "<br/>date = ".$date.",amount= ".$amount.",relation=".$currRelation.",currency= ".$currencyName;
    return($currValue);
}





#-------------------------------------------------------------------------------
# Added : 18/1/2005
# Modfd : 18/1/2005
# Function gets the date on which the transaction happended and the currency Name
# and the transaction Amount
# returns the amount corresponding to the specified currency
#-------------------------------------------------------------------------------
function getDollarValue($date, $currencyName, $amount){
  $con = $GLOBALS["con"];

    # initialising currency Value

    $currValue = 0;

    # gets the currency Relation

    $sql  = " SELECT currency_relation FROM partners_currency WHERE currency_date <= '$date' AND ";
    $sql .= " currency_caption like '$currencyName' ORDER BY currency_date DESC ";

    $ret  = @mysqli_query($con,$sql);


    if(@mysqli_num_rows($ret)>0){

          $row = @mysqli_fetch_object($ret);

          # gets currency relation

          $currRelation = $row->currency_relation;

          # calculate currency value

          $currValue 	= ( $amount / $currRelation );

          //$currValue 	= round($currValue,2);
         //  echo "<br/>date = ".$date.",amount= ".$amount.",relation=".$currRelation.",currency= ".$currName;
    }
     //echo "<br/>date = ".$date.",amount= ".$amount.",relation=".$currRelation.",currency= ".$currencyName;
    return($currValue);
}

#-------------------------------------------------------------------------------
# Added : 25/04/2005
# Modfd : 29/04/2005
# Function do payment for program fee
#-------------------------------------------------------------------------------
 function payProgramFee($id,$totamount,$pgmid){
  $con = $GLOBALS["con"];

           /*
            Gets merchant current balance
           */
           $merchant_sql = "SELECT * FROM   merchant_pay  WHERE pay_merchantid='$id'";
           $merchant_ret = @mysqli_query($con,$merchant_sql);

           if(@mysqli_num_rows($merchant_ret)>0) {
                 $row                  = @mysqli_fetch_object($merchant_ret);
                 $merchant_pay_amount  = $row->pay_amount;
           }

           /*
            Checks whether the payment may leave user money empty
           */
           if($merchant_pay_amount-$totamount>=0){
              $admin_sql = "SELECT * FROM   admin_pay ";
              $admin_ret = @mysqli_query($con,$admin_sql);

               # checking for each records
               if(@mysqli_num_rows($admin_ret)>0)
               {
                       $row               =  @mysqli_fetch_object($admin_ret);
                       $admin_pay_amount  =  $row->pay_amount;

               }

               $merchant_pay_amount -= $totamount;
               $admin_pay_amount   += $totamount;

               /*
                Update Mercahnt Balance
               */
               $sql1  = "update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$id'";
               $ret1  = @mysqli_query($con,$sql1);

               /*
                Update Admin Balance
               */
               $sql1 ="update admin_pay set pay_amount='$admin_pay_amount' ";
               $ret1 = @mysqli_query($con,$sql1);

               $_SESSION['MERCHANTBALANCE']=$merchant_pay_amount;

               /*
                 Record Sucessful Payment
               */
                $today=date("Y-m-d");
                if($totamount){
                	$sql3  = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date`,`adjust_no` )  ";
                	$sql3 .= "VALUES ('', '$id', 'programFee', 'm','$totamount','$today','$pgmid')";
                	@mysqli_query($con,$sql3);
                }
                $sql3  = "INSERT INTO `partners_fee` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date`,`adjust_no` )  ";
                $sql3 .= "VALUES ('', '$id', 'programFee', 'closed','$totamount','$today','$pgmid')";
                @mysqli_query($con,$sql3);
           }else{
                /*
                 Record Pending Payment
                */
                $today=date("Y-m-d");
                $sql3  = "INSERT INTO `partners_fee` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date`,`adjust_no` )  ";
                $sql3 .= "VALUES ('', '$id', 'programFee', 'pending','$totamount','$today','$pgmid')";
                @mysqli_query($con,$sql3);
           }
   }

#-------------------------------------------------------------------------------
# Added : 25/04/2005
# Modfd : 29/04/2005
# Function do payment for program fee (Pending)
#-------------------------------------------------------------------------------
function closeFee($tid,$id,$pgmid,$totamount){
  $con = $GLOBALS["con"];
           /*
                Gets merchant current balance
           */
           $merchant_sql = "SELECT * FROM   merchant_pay  WHERE pay_merchantid='$id'";
           $merchant_ret = @mysqli_query($con,$merchant_sql);

           if(@mysqli_num_rows($merchant_ret)>0) {
                 $row                  = @mysqli_fetch_object($merchant_ret);
                 $merchant_pay_amount  = $row->pay_amount;
           }

           /*
            Checks whether the payment may leave user money empty
           */
           if($merchant_pay_amount-$totamount>=0){
              $admin_sql = "SELECT * FROM   admin_pay ";
              $admin_ret = @mysqli_query($con,$admin_sql);

               # checking for each records
               if(@mysqli_num_rows($admin_ret)>0)
               {
                       $row               =  @mysqli_fetch_object($admin_ret);
                       $admin_pay_amount  =  $row->pay_amount;

               }

               $merchant_pay_amount -= $totamount;
               $admin_pay_amount   += $totamount;

               /*
                Update Mercahnt Balance
               */
               $sql1  = "update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$id'";
               $ret1  = @mysqli_query($con,$sql1);

               /*
                Update Admin Balance
               */
               $sql1 ="update admin_pay set pay_amount='$admin_pay_amount' ";
               $ret1 =@mysqli_query($con,$sql1);

               /*
                Make Pending Payment
               */
               $sql = "UPDATE partners_fee SET adjust_flag='closed' WHERE adjust_id = '$tid'";
               @mysqli_query($con,$sql);

               $today=date("Y-m-d");

               /*
                 Record Payment
               */
               if($totamount){
                	$sql3  = "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date`,`adjust_no` )  ";
                	$sql3 .= "VALUES ('', '$id', 'programFee', 'm','$totamount','$today','$pgmid')";
                	@mysqli_query($con,$sql3);
               }
        }

   }
	#-------------------------------------------------------------------------------
	# Added : 25/04/2005
	# Modfd : 29/04/2005
	# Function do payment for program fee
	#-------------------------------------------------------------------------------
	function payMembershipFee($id,$totamount){
    $con = $GLOBALS["con"];

           /*
            Gets merchant current balance
           */
           $merchant_sql = "SELECT * FROM   merchant_pay  WHERE pay_merchantid = '$id'";
           $merchant_ret = @mysqli_query($con,$merchant_sql);

           if(@mysqli_num_rows($merchant_ret)>0) {
                 $row                  = @mysqli_fetch_object($merchant_ret);
                 $merchant_pay_amount  = $row->pay_amount;
           }

           /*
            Checks whether the payment may leave user money empty
           */
           if($merchant_pay_amount-$totamount>=0){
              $admin_sql = "SELECT * FROM   admin_pay ";
              $admin_ret = @mysqli_query($con,$admin_sql);

               # checking for each records
               if(@mysqli_num_rows($admin_ret)>0)
               {
                       $row               =  @mysqli_fetch_object($admin_ret);
                       $admin_pay_amount  =  $row->pay_amount;
               }

               $merchant_pay_amount -= $totamount;
               $admin_pay_amount   += $totamount;

               /*
                Update Mercahnt Balance
               */
               $sql1  = "update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$id'";
               $ret1  = @mysqli_query($con,$sql1);

               /*
                Update Admin Balance
               */
               $sql1 ="update admin_pay set pay_amount='$admin_pay_amount' ";
               $ret1 = @mysqli_query($con,$sql1);

               $_SESSION['MERCHANTBALANCE']=$merchant_pay_amount;

               /*
                 Record Sucessful Payment
               */
                $today=date("Y-m-d");
                if($totamount){
                   $sql22  	= "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag` , `adjust_amount` , `adjust_date` , `adjust_no` )
 				   VALUES ('', '$id', 'deposit', 'm', '$totamount', '$today', '0')";
                   $result22  = @mysqli_query($con,$sql22);
                }
                $sql3  = "INSERT INTO `partners_fee` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
                $sql3 .= "VALUES ('', '$id', 'register', 'closed','$totamount','$today')";
                @mysqli_query($con,$sql3);
           }else{
                /*
                 Record Pending Payment
                */
                $today=date("Y-m-d");
                $sql3  = "INSERT INTO `partners_fee` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag`,`adjust_amount`,`adjust_date` )  ";
                $sql3 .= "VALUES ('', '$id', 'register', 'pending','$totamount','$today')";
                @mysqli_query($con,$sql3);
           }
   }

#-------------------------------------------------------------------------------
# Added : 25/04/2005
# Modfd : 29/04/2005
# Function do payment for program fee (Pending)
#-------------------------------------------------------------------------------
function closeMemFee($tid,$id,$totamount){

$con = $GLOBALS["con"];

           /*
            Gets merchant current balance
           */
           $merchant_sql = "SELECT * FROM   merchant_pay  WHERE pay_merchantid='$id'";
           $merchant_ret = @mysqli_query($con,$merchant_sql);

           if(@mysqli_num_rows($merchant_ret)>0) {
                 $row                  = @mysqli_fetch_object($merchant_ret);
                 $merchant_pay_amount  = $row->pay_amount;
           }

           /*
            Checks whether the payment may leave user money empty
           */
           if($merchant_pay_amount-$totamount>=0){
              $admin_sql = "SELECT * FROM   admin_pay ";
              $admin_ret = @mysqli_query($con,$admin_sql);

               # checking for each records
               if(@mysqli_num_rows($admin_ret)>0)
               {
                       $row               =  @mysqli_fetch_object($admin_ret);
                       $admin_pay_amount  =  $row->pay_amount;

               }

               $merchant_pay_amount -= $totamount;
               $admin_pay_amount   += $totamount;

               /*
                Update Mercahnt Balance
               */
               $sql1  = "update merchant_pay set pay_amount='$merchant_pay_amount' where pay_merchantid='$id'";
               $ret1  = @mysqli_query($con,$sql1);

               /*
                Update Admin Balance
               */
               $sql1 ="update admin_pay set pay_amount='$admin_pay_amount' ";
               $ret1 = @mysqli_query($con,$sql1);

               /*
                Make Pending Payment
               */
               $sql = "UPDATE partners_fee SET adjust_flag='closed' WHERE adjust_id = '$tid'";
               @mysqli_query($con,$sql);

               $today=date("Y-m-d");

               /*
                 Record Payment
               */
               if($totamount){
                    $sql22  	= "INSERT INTO `partners_adjustment` ( `adjust_id` , `adjust_memberid` , `adjust_action` , `adjust_flag` , `adjust_amount` , `adjust_date` , `adjust_no` )
 				   VALUES ('', '$id', 'register', 'm', '$totamount', '$today', '0')";
                   $result22  = @mysqli_query($con,$sql22);
               }
        }

   }
?>