<?
  # Merchant Id
   $id 			=	(empty($_GET['merid']))? $_SESSION['TRANS_MERCHANTID'] : intval($_GET['merid']) ;
   $_SESSION['TRANS_MERCHANTID'] =  $id ;
   $trans_id	= $_GET['trans_id'];
   $gridcounter	=	0;
   # getting page no
   $page		=   (empty($page))? $partners->getpage(): trim($_GET['page']);

   # geting records from table
   $sql		= " SELECT *, date_format(transaction_dateoftransaction,'%d, %m %Y') AS DATE 
   				FROM partners_transaction AS t, partners_joinpgm AS j, partners_merchant as a where merchant_id='$id'";
   $sql	   .=	" AND t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_merchantid=a.merchant_id ";
   $sql    .=   (!empty($trans_id)) ? " AND transaction_id = '$trans_id' " :"";
   $pgsql	= 	$sql;
   $sql    .=	"LIMIT ".($page-1)*$lines.",".$lines; //adding page no
   $ret 	=	mysqli_query($con,$sql);

  # checking for each records
  if(mysqli_num_rows($ret)>0){
  ?>
 <br/>
 <br/>
 <table class="tablebdr" cellspacing="1" width="95%" id="AutoNumber1">
  <tr>
    <td width="10%" align="center" class="tdhead">Type</td>
    <td width="20%" align="center" class="tdhead">Merchant</td>
    <td width="20%" align="center" class="tdhead">Affiliate </td>

    <td width="10%" align="center" class="tdhead">Commission</td>
    <td width="20%" align="center" class="tdhead">Date</td>
    <td width="15%" align="center"  class="tdhead">Status</td>
  </tr>
  <?
          while($rows=mysqli_fetch_object($ret))
          {
            $type		   		=	$rows->transaction_type ;
            $merchantid	   		=	$rows->joinpgm_merchantid ;
            $merchantname  		=	stripslashes($rows->merchant_company);
            $affiliateid   		=	$rows->joinpgm_affiliateid ;

            $sql2 =	"select * from partners_affiliate where affiliate_id='$affiliateid' ";
            $ret2 =	mysqli_query($con,$sql2);

            if(mysqli_num_rows($ret2)>0){
              	$row2		=	mysqli_fetch_object($ret2);
                $affiliate	=	stripslashes($row2->affiliate_company);
            }

            $tstatus 	  		=	$rows->transaction_status ;
            $commission			=	$rows->transaction_amttobepaid ;
            $dateoftransaction  =	$rows->DATE ;
            $astatus			=	$rows->joinpgm_status;

            $classid = ($gridcounter%2==1)? "grid1" : "grid2" ;

 	       ?>

	         <tr class="<?=$classid?>" >
	            <td width="10%" align="center"  ><?=$type?>&nbsp;<img
	                      alt="" border='0' height="10" src="../images/<?=$type?>.gif"
	                      width="10" /></td>
	            <td width="20%" align="center"  >

	            <a href="#" onclick="help(<?=$merchantid?>)">
	            <?=$merchantname?>
	            </a></td>

	            <td width="20%" align="center" ><a href="#" onclick="help1(<?=$affiliateid?>)"> <?=$affiliate?></a></td>

	            <td width="10%" align="center"  ><?=$currSymbol?>&nbsp;<?=round($commission,2)?></td>
	            <td width="20%" align="center" ><?=$dateoftransaction?></td>

	            <td width="10%" align="left" >
	                &nbsp;<img alt="" border='0' height="15" src="../images/<?=$tstatus?>.gif" width="15" />&nbsp;<?=$tstatus?>
	            </td>

	          </tr>

	         <?
    			$gridcounter	 =	$gridcounter+1;
            }
      		$classid		 = ($gridcounter%2==1)? "grid1" : "grid2" ;
	        ?>
            </table>
            <table>
	        <tr>
	        <td width="100%" colspan="6" align="center">
	        <?
	        $url    ="index.php?Act=transaction_merchant&amp;merid=$id&amp;trans_id=$trans_id";    //adding page nos
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

<script language="javascript" type="text/javascript">
	function help(merchantid)
	{
		url="viewprofile_merchant.php?id="+merchantid;
		nw = open(url,'new','height=400,width=400,scrollbars=yes');
		nw.focus();
	}
	
	function help1(afiliateid)
	{
		url="viewprofile_affiliate.php?id="+afiliateid;
		nw = open(url,'new','height=400,width=400,scrollbars=yes');
		nw.focus();
	}
</script>