<?php

 function GetStat($linkid)
  {

    //initiating
    $click                 =0;
    $lead                  =0;
    $sale                  =0;
    $nclick                =0;
    $nlead                 =0;
    $nsale                 =0;
    $subsale               =0;
    $nsubsale              =0;
    $pendingamnt           =0;
    $approvedamnt          =0;
    $paidamnt              =0;
    $rejectedamnt          =0;




            $sql                ="SELECT * from partners_transaction where  transaction_type='click' and transaction_linkid='$linkid'";
            $result             =mysqli_query($con,$sql);
            $nclick             =mysqli_num_rows($result)+$nclick;

      //  echo "$sql";//no of click
            while($row=mysqli_fetch_object($result))
                {
                $click         =$row->transaction_amttobepaid+$click; //total click amnt
                }


            //echo "$sql";
          //  echo "$nclick";
            $sql                ="SELECT * from partners_transaction where transaction_type='lead' and transaction_linkid='$linkid'";
            $result             =mysqli_query($con,$sql);
            $nlead              =mysqli_num_rows($result)+$nlead;  //no of lead

            while($row=mysqli_fetch_object($result))
                {
                $lead           =$row->transaction_amttobepaid+$lead;// total lead amnt
                }  //end while



           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql="SELECT *  from partners_transaction where  transaction_type='sale' and transaction_linkid='$linkid'";
            $result            =mysqli_query($con,$sql);
            $nsale             =mysqli_num_rows($result)+$nsale; //no of sale
            while($row=mysqli_fetch_object($result))
                {
                $sale          =$row->transaction_amttobepaid+$sale;//total sale amnt
                }  //end  while



            $sql               ="SELECT *  from partners_transaction where transaction_flag=1 and transaction_linkid='$linkid'";
            $result            =mysqli_query($con,$sql);
            $nsubsale          =mysqli_num_rows($result)+$nsubsale; //no of subsale
            while($row=mysqli_fetch_object($result))
                {
                $subsale      =$row->transaction_subsale+$subsale;//total sale amnt
                }  //end  while


             $sql            ="SELECT * from partners_transaction where  transaction_status='approved' and transaction_linkid='$linkid'";
             $result4        =mysqli_query($con,$sql);
             while($row1=mysqli_fetch_object($result4))
               {
                $approvedamnt=$row1->transaction_amttobepaid+$approvedamnt;// total approved amnt
               }  //end while


           // $sql="SELECT sum( transaction_amttobepaid ) sale from partners_transaction where transaction_dateoftransaction='$dateoftrans' and transaction_type='sale' and transaction_joinpgmid=$joinid";
            $sql            ="SELECT * from partners_transaction where  transaction_linkid='$linkid'";
            $result4        =mysqli_query($con,$sql);
            while($row1=mysqli_fetch_object($result4))
                    {
               $paidamnt   =$row1->transaction_amountpaid+$paidamnt;//total sale amnt
             }  //end  while


            $sql            ="SELECT * from partners_transaction where  transaction_status='reversed' and transaction_linkid='$linkid'";
            $result4        =mysqli_query($con,$sql);
            while($row1=mysqli_fetch_object($result4))
            {
                $rejectedamnt=$row1->transaction_amttobepaid+$rejectedamnt;// total approved amnt
             }  //end while

           $sql            ="SELECT * from partners_transaction where  transaction_status='pending' and transaction_linkid='$linkid'";
           $result4        =mysqli_query($con,$sql);
           while($row1=mysqli_fetch_object($result4))
                    {
               $pendingamnt=$row1->transaction_amttobepaid+$pendingamnt;// total approved amnt
             }  //end while


           $total          =$click."~".$nclick."~".$lead."~".$nlead."~".$sale."~".$nsale."~".$linkid."~".$approvedamnt."~".$pendingamnt."~".$paidamnt."~".$rejectedamnt;
        //  echo "$total";
       return($total);

  }

?>