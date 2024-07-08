
<?php


      function ChangeStaus($minimum_amount)
      {
        $con = $GLOBALS["con"];

        //geting records from table
        $pay_sql = "select * from merchant_pay where pay_amount < $minimum_amount  ";
        $pay_ret = mysqli_query($con, $pay_sql);
        //echo mysqli_error();
        //checking for each records
        if(@mysqli_num_rows($pay_ret)>0)
        {
                while($pay_row=@mysqli_fetch_object($pay_ret))
                {
                       $id= trim(stripslashes($pay_row->pay_merchantid));

                       //geting records from table
                       $sql1 = "update partners_merchant set merchant_status='empty' where merchant_id='$id' and merchant_status not like 'NP'";
                       $ret  = @mysqli_query($sql1);
                 }
        }
      }

      function getProgramFee(){

        $con = $GLOBALS["con"];
        $sql = "SELECT program_merchantid,program_id,program_fee,program_value,program_type FROM partners_program";
        $ret = mysqli_query($con, $sql);

        if(mysqli_num_rows($ret)>0){
           while($row = mysqli_fetch_object($ret)){
                 $merid   		= $row->program_merchantid;
                 $id   		    = $row->program_id;
                 $prgm_fee	 	= trim($row->program_fee);
                 $prgm_value  	= $row->program_value;
                 $prgm_type	   	= $row->program_type;

                 if(($prgm_type == "0")){
   					 $prgm_fee	   	= $program_fee;
                     $prgm_value	= $program_value;
                     $prgm_type		= $program_type;
  				 }

                	 if($prgm_type==2){

	                    $sqlFee = "SELECT adjust_date AS DATE FROM partners_fee WHERE adjust_no = '$id' and adjust_action like 'programFee' order by adjust_date desc";
	                    $retFee = mysqli_query($con, $sqlFee);

                        if(mysqli_num_rows($retFee)>0){
	                         $rowFee   =  mysqli_fetch_object($retFee) ;
	                         $date     = $rowFee->DATE;

                             $sqlCheck = "SELECT  date_format(date_add('$date',INTERVAL $prgm_value),'%H/%i/%s/%d/%m/%y') as R";
	                         $retCheck = mysqli_query($sqlCheck);

	                         $rowCheck =  mysqli_fetch_object($retCheck) ;
	                         $d =  $rowCheck->R;

                             if(!Compare($d)){
                               payProgramFee($merid,$prgm_fee,$id);
                             }
                       } 
	             }
             }
          }
      }
      function setPending(){
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM partners_fee WHERE adjust_flag='pending' and adjust_action like 'programFee' ";
        $ret = mysqli_query($con, $sql);

         if(mysqli_num_rows($ret)>0){
           while($row   = mysqli_fetch_object($ret)){
             $amount    = $row->adjust_amount;
             $mid       = $row->adjust_memberid;
             $id        = $row->adjust_id;
             $pgmid     = $row->adjust_no;

             closeFee($id,$mid,$pgmid,$amount);
           }
         }
      }


//--------------------------------------------------------
//  Function to get and pay Monthly membership Fee
//--------------------------------------------------------
function payMembership(){
  $con = $GLOBALS["con"];
   /*
   checks whethre mebership type is recurring or not.
   */

  //By Ankit
   $membership_type = 1;

   if($membership_type == 2 ){

        /*
         if recurring gets all merchants accounts
        */
        $sql = " SELECT * FROM partners_merchant ";
        $ret = mysqli_query($con, $sql);

        if(mysqli_num_rows($ret)>0){
        	while( $row = mysqli_fetch_object($ret)){

            			# Merchant Id
            			$id   = $row->merchant_id;
                        $type = $row->merchant_type;

                        /*
                         Checks the type of user
                         and set the fee accodingly
                        */
                        if($type=="normal")  $fee = $normal_user;
                        else                 $fee = $advanced_user;

                        /*
                          Get the last Payment Date
                        */
                  		$sqlFee = "SELECT adjust_date AS DATE FROM partners_fee WHERE adjust_memberid = '$id' and adjust_action like 'register' order by adjust_date desc LIMIT 0,1";
	                    $retFee = mysqli_query($con, $sqlFee);

                        if(mysqli_num_rows($retFee)>0){
	                         $rowFee   =  mysqli_fetch_object($retFee) ;
	                         $date     = $rowFee->DATE;

                             /*
                              checks whether the date next payment date has expired
                             */
                             $sqlCheck = "SELECT  date_format(date_add('$date',INTERVAL $membership_value),'%H/%i/%s/%d/%m/%y') as R";
	                         $retCheck = mysqli_query($con, $sqlCheck);

	                         $rowCheck =  mysqli_fetch_object($retCheck) ;
	                         $d 	   =  $rowCheck->R;

                             /*
                              if expired do payment
                             */
                             if(!Compare($d)){
                               payMembershipFee($id,$fee);
                             }


	                    }
            }
        }
   }
}

/*
 Do Pending Membership Paymets
*/
 function setMemPending(){
   $con = $GLOBALS["con"];
        $sql = "SELECT * FROM partners_fee WHERE adjust_flag='pending' and adjust_action like 'register' ";
        $ret = mysqli_query($con, $sql);
         if(mysqli_num_rows($ret)>0){
           while($row   = mysqli_fetch_object($ret)){
             $amount    = $row->adjust_amount;
             $mid       = $row->adjust_memberid;
             $id        = $row->adjust_id;
             $pgmid     = $row->adjust_no;

             closeMemFee($id,$mid,$amount);
           }
         }
}

function
 Compare($ipblock)
{
//comparing date
       $dtarray       =explode("/",$ipblock);
       $iphour        =$dtarray[0];
       $ipminute      =$dtarray[1];
       $ipsecond      =$dtarray[2];
       $ipdate        =$dtarray[3];
       $ipmonth       =$dtarray[4];
       $ipyear        =$dtarray[5];

 //current
       $d=date("d");
       $m=date("m");
       $y=date("Y");
       $h=date("H");
       $i=date("i");
       $s=date("s");

       $today=mktime($h,$i,$s,$m,$d,$y);
       $ipblock= mktime($iphour,$ipminute,$ipsecond,$ipmonth,$ipdate,$ipyear);

       if($ipblock>$today)
          return true;
       else
          return false;

}

?>