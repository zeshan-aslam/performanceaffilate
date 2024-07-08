 <?
	$id =intval($_GET['affid'])  ;
	//geting records from table
	$sql	= "SELECT * FROM partners_transaction AS t, partners_joinpgm AS j,partners_affiliate as a and affiliate_id='$id'";
	$sql	.= " AND transaction_joinpgmid = '$joinid' AND t.transaction_joinpgmid = j.joinpgm_id AND j.joinpgm_affiliateid=m.affiliate_id";
	$ret 	= mysqli_query($con,$sql);

 ?>

 <table class="tablebdr" cellspacing="1" width="95%" id="AutoNumber1">
<tr>
    <td width="10%" align="center" class="tdhead">Type</td>
    <td width="20%" align="center" class="tdhead">Merchant</td>
    <td width="20%" align="center" class="tdhead">Affiliate ID</td>

    <td width="10%" align="center" class="tdhead">Commission</td>
    <td width="20%" align="center" class="tdhead">Date</td>
    <td width="15%" align="center" colspan="2" class="tdhead">Status</td>
  </tr>
 <?
  //checking for each records
  if(mysqli_num_rows($ret)>0)
  {
          while($row=mysqli_fetch_object($ret))
          {
            $type		   		=$rows->transaction_type ;
            $merchantid	   		=$rows->joinpgm_merchantid ;
            $merchantname  		=$rows->merchant_firstname;
            $affiliateid   		=$rows->joinpgm_affiliateid ;
            $tstatus 	  		=$rows->transaction_status ;
            $commission			=$rows->transaction_amttobepaid ;
            $dateoftransaction  =$rows->transaction_dateoftransaction ;
            $astatus			=$rows->joinpgm_status;

           if ($gridcounter%2==1)   $classid="grid1";
           else                     $classid="grid2";

  ?>

 <tr class=<?=$classid?> >
    <td width="10%" align="center"  ><?=$type?>&nbsp;<IMG
              alt="" border="0" height=10 src="../images/<?=$type?>.gif"
              width=10></td>
    <td width="20%" align="center"  >

    <a href="#" id="show"  onclick="help(<?=$merchantid?>)">
    ID:<?=$merchantid?>..<?=$merchantname?>
    </a></td>

    <td width="20%" align="center" ><a href="#" id="show"  onclick="help1(<?=$affiliateid?>)"> <?=$affiliateid?></a></td>

    <td width="10%" align="center"  ><?=$commission?></td>
    <td width="20%" align="center" ><?=$dateoftransaction?></td>

    <td width="10%" align="left" >
        &nbsp;<IMG alt="" border="0" height=15 src="../images/<?=$tstatus?>.gif"
                          width=15>&nbsp;<?=$tstatus?></td>
    </td>

  </tr>

  <?

    $gridcounter=$gridcounter+1; ;

      } // inner while close

                                 } // outer while closing