<?php
   //daily procedure


   //-----------function inactive mercahnt account where the status become money empty-------------------//
   function MakeUserInactive()
   {
        //geting records from merchant table where the amount reached money empty ststus
        $sql ="select * from merchant_pay where pay_amount<=400";
        $ret =mysql_query($sql);

        //checking for each records
        if(mysql_num_rows($ret)>0)
        {
                while($row=mysql_fetch_object($ret))
                {
                       //geting records from table
                       $update_sql ="update partners_merchant set merchant_status='empty' where merchat_id='$row->pay_merchantid'";
                       $update_ret =mysql_query($update_sql);

                 }
        }
    }
    //-----------------------------------------------------------------------------------------------------//
   ?>