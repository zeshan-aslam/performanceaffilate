<?php

  //--------------payment-------------------------------------------------//

  doPayment($affiliate_id,$merchant_id,$transid,$minimum_amount)
  {

    //get the transaction details///

     $sql_trns ="select * from partners_transaction where transaction_id='$transid'";
     $ret_trns =mysql_query($sql_trns);

     //checking for each records
     if(mysql_num_rows($ret_trns)>0)
     {
             $row_trns		=mysql_fetch_object($ret_trns);
             $amount        =$row_trns->transaction_amttobepaid ;
             $subsale       =$row_trns->transaction_subsale;
             $parentid      =$row_trns->transaction_parentid;
             $admin_amount  =$row_trns->transaction_admin_amount;
             $flag			=$row_trns->transaction_flag;
     }



   //---------------------getting existing amounts----------------------------//

              //geting records from table
              $merchant_sql ="SELECT * FROM   merchant_pay  WHERE merchant_id='$merchant_id'";
              $merchant_ret =mysql_query($merchant_sql);

              //checking for each records
              if(mysql_num_rows($merchant_ret)>0)
              {
                      $row			        =mysql_fetch_object($merchant_ret);
                      $merchant_pay_amount	=$row->pay_amount;




              //geting records from table
              $affiliate_sql ="SELECT * FROM   affiliate_pay  WHERE affiliate_id='$affiliate_id'";
              $affiliate_ret =mysql_query($affiliate_sql);

              //checking for each records
              if(mysql_num_rows($affiliate_ret)>0)
              {
                      $row			        =mysql_fetch_object($affiliate_ret);
                      $affiliate_pay_amount	=$row->pay_amount;

              }

              //geting records from table
              $admin_sql ="SELECT * FROM   admin_pay ";
              $admin_ret =mysql_query($admin_sql);

              //checking for each records
              if(mysql_num_rows($admin_ret)>0)
              {
                      $row			        =mysql_fetch_object($admin_ret);
                      $admin_pay_amount	    =$row->pay_amount;

              }
    //---------------------------getting existing amounts end here------------//


   //---------------------------getting new amounts --------------------------//

      $merchant_pay_amount  =  $merchant_pay_amount - ($amount+$admin_amount);
      $affiliate_pay_amount =  $affiliate_pay_amount + $amount;
      $admin_pay_amount 	=  $admin_pay_amount +  $admin_amount;
      if(($flag != "0" ))
       {
          $admin_pay_amount 	=  $admin_pay_amount - $subsale;

          //geting records from table
          $sql ="SELECT * FROM pay_affiliate  WHERE pay_affiliate_id='$parentid'";
          $ret =mysql_query($sql);

          //checking for each records
          if(mysql_num_rows($ret)>0)
          {
                 $row=mysql_fetch_object($ret);
                 $parent_amount=$row->pay_amount;
          }

          $parent_amount = $parent_amount+$subsale;

          //paying for subsale
          $sql ="update pay_affiliate set pay_amount='$parent_amount' where pay_affiliateid='$parentid'";
          $ret =mysql_query($sql);
       }

        //paying for merchant
          $sql ="update pay_merchant set pay_amount='$merchant_pay_amount' where pay_merchantid='$merchant_id'";
          $ret =mysql_query($sql);

           //paying for affiliate
          $sql ="update pay_affiliate set pay_amount='$affiliate_pay_amount' where pay_affiliateid='$affiliate_id'";
          $ret =mysql_query($sql);

           //paying for admin
          $sql ="update pay_admin set pay_amount='$admin_pay_amount' ";
          $ret =mysql_query($sql);

   //---------------------------getting new amounts end here-----------------//
       }
  }

  //---------------------------------------------------------------------//



  //--------------payment-------------------------------------------------//

  reverseSale($affiliate_id,$merchant_id,$transid)
  {

    //get the transaction details///

     $sql_trns ="select * from partners_transaction where transaction_id='$transid'";
     $ret_trns =mysql_query($sql_trns);

     //checking for each records
     if(mysql_num_rows($ret_trns)>0)
     {
             $row_trns		=mysql_fetch_object($ret_trns);
             $amount        =$row_trns->transaction_amttobepaid ;
             $subsale       =$row_trns->transaction_subsale;
             $parentid      =$row_trns->transaction_parentid;
             $admin_amount  =$row_trns->transaction_admin_amount;
     }



   //---------------------getting existing amounts----------------------------//

              //geting records from table
              $merchant_sql ="SELECT * FROM   merchant_pay  WHERE merchant_id='$merchant_id'";
              $merchant_ret =mysql_query($merchant_sql);

              //checking for each records
              if(mysql_num_rows($merchant_ret)>0)
              {
                      $row			        =mysql_fetch_object($merchant_ret);
                      $merchant_pay_amount	=$row->pay_amount;

              }




              //geting records from table
              $admin_sql ="SELECT * FROM   admin_pay ";
              $admin_ret =mysql_query($admin_sql);

              //checking for each records
              if(mysql_num_rows($admin_ret)>0)
              {
                      $row			        =mysql_fetch_object($admin_ret);
                      $admin_pay_amount	    =$row->pay_amount;

              }
    //---------------------------getting existing amounts end here------------//


   //---------------------------getting new amounts --------------------------//

      $merchant_pay_amount  =  $merchant_pay_amount + ($admin_amount);
      $admin_pay_amount 	=  $admin_pay_amount - $admin_amount;


    //paying for merchant
      $sql ="update pay_merchant set pay_amount='$merchant_pay_amount' where pay_merchantid='$merchant_id'";
      $ret =mysql_query($sql);

       //paying for admin
      $sql ="update pay_admin set pay_amount='$admin_pay_amount' ";
      $ret =mysql_query($sql);

   //---------------------------getting new amounts end here-----------------//

  }

  //---------------------------------------------------------------------//


  
?>