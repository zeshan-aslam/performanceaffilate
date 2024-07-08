<?


  # Merchant Id
   $id 			=   $_SESSION['MERCHANTID'];

   $gridcounter	=	0;

   # getting page no
   $page		=   (empty($page))? $partners->getpage(): trim($_GET['page']);

   # geting records from table
   $sql		=	"SELECT *,DATE_FORMAT(revenue_date,'%d, %m %Y') AS DATE FROM partners_track_revenue WHERE revenue_merchantid = '$id' AND revenue_amount >0 ";
   $pgsql	= 	$sql;
   $sql    .=	"LIMIT ".($page-1)*$lines.",".$lines; //adding page no
   $ret 	=	mysqli_query($con,$sql);



  # checking for each records
  if(mysqli_num_rows($ret)>0){
  ?>
 <br/>
 <br/>
 <table class="tablebdr" cellspacing="1" cellpadding="1" width="80%" id="AutoNumber1" align="center">
  <tr>
    <td width="10%" align="center" class="tdhead"><b><?=$trans_type?></b></td>
    <td width="20%" align="center" class="tdhead"><b><?=$trans_sale?></b></td>
    <td width="20%" align="center" class="tdhead"><b><?=$trans_date?></b></td>
    <td width="25%" align="center"  class="tdhead"><b><?=$trans_status?></b></td>
  </tr>
  <?
          while($rows=mysqli_fetch_object($ret))
          {

            $type				= $rows->revenue_trans_type;
            $amount				= $rows->revenue_amount;
            $date				= $rows->revenue_date;
             # converting to user currency
             if($currValue != $default_currency_caption){
                   $amount     =   getCurrencyValue($date, $currValue, $amount);

              }

            $dateoftransaction  = $rows->DATE;
            $transid			= $rows->revenue_transaction_id;
            $classid = ($gridcounter%2==1)? "grid1" : "grid2" ;

            $status =($transid)? "<img src='../images/vieworiginal1.gif'  alt=''  border='0' /> <a href='index.php?Act=transaction_merchant&amp;trans_id=$transid'>$type Through $title</a>":"<img src='../images/vieworiginal2.gif'  alt='' border='0' /> <b>Direct $type</b> ";

 	       ?>

	         <tr class="<?=$classid?>" >
	            <td width="10%" align="center"  height="3"><?=$type?>&nbsp;
				<img alt="" border="0" height="10" src="../images/<?=$type?>.gif"  width="10" />
				</td>
	            <td width="20%" align="center"  >  <?=$amount?> <?=$currSymbol?></td>
	            <td width="20%" align="center" ><?=$dateoftransaction?></td>
	            <td width="10%" align="left" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$status?></td>
	            

	          </tr>

	         <?

    		$gridcounter	 =	$gridcounter+1;
            }
      		$classid		 = ($gridcounter%2==1)? "grid1" : "grid2" ;


	        ?>
            </table>
             <table cellspacing="1" cellpadding="1" width="80%" align="center">
	        <tr>
	        <td width="100%" colspan="6" align="left">
	        <?
	        $url    ="index.php?Act=revenues&amp;merid=$id";    //adding page nos
	        include '../includes/show_pagenos.php';
	        ?>
	        </td>
	        </tr>
	        </table>
    <?
     } // outer if closing
    else{
    ?>
    	<p align="center" class="textred"><?=$norec?></p><?
    }
    ?>