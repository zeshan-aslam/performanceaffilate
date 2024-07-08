<?php

/*
  Monthly invoice Genration.
  Get The invoice Report for specific Period.
*/

  /* This month  */

  $month = date("Y-m-");

  /*  ---------- */
  /* Get all merchants with pay per invoice types
  /*  ---------- */
 $sql  = " SELECT * FROM partners_merchant WHERE 1";
 $sql .= " AND merchant_isInvoice = 'Yes' ";
 $ret  = mysql_query($sql);

 if(mysql_num_rows($ret)>0){
 		while($row = mysql_fetch_object($ret)){
        	$id	   = $row->merchant_id;

            /*  ---------- */
            /*  Get all invoice status for specifc month.
            /*  ---------- */

            $invoiceSql = "SELECT * FROM partners_invoice WHERE 1";
            $invoiceSql.= " AND invoice_merchantid = $id AND SUBSTRING(invoice_date,1,8) LIKE '$month' ";

            $invoiceRet = mysql_query($invoiceSql);
        }
 }

?>
