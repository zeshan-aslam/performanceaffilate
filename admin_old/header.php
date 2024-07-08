<?php

	if($Act=="referer_report" or $Act=="link_report" or $Act=="product_report") 
		$body_onload = "onLoad='LoadPrgms();'";
	
	?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="96%" height="85" valign="middle">
		
		<?php
			if($partners->islogin()){
				$sql 	= "SELECT * FROM admin_pay";
				$ret 	= mysqli_query($con, $sql);
				if(mysqli_num_rows($ret)>0){
					while($row=mysqli_fetch_object($ret)){
						$admin_pay=$row->pay_amount;
					}
				}
		?>
		<table width="430" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td width="6"><img src="images/payment-box-left.jpg" width="6" height="75" /></td>
            <td class="payment-box-contentbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="28%" align="center" class="heading1">Payment</td>
                <td width="72%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="payment-inner-box"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="49%"><div class="text-01"><?=$currSymbol?><?=round($admin_pay,2)?></div>
                                      <div class="text-01">
								<? if($userobj->GetAdminUserLink('Payment History',$adminUserId,0)) {  ?>
								<a href="index.php?Act=payment_list" class="link-01">Payment History</a>
								<? } ?>
									  <!--<a href="#" class="link-01">Payment History</a>--> </div></td>
                        <td width="3%" align="center"><img src="images/sep.jpg" width="1" height="51" /></td>
                        <td width="48%">
						<div class="text-01"><a href="index.php?Act=transaction" class="link-01">Transaction</a></div></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            <td width="6" align="right"><img src="images/payment-box-right.jpg" width="6" height="75" /></td>
          </tr>
        </table>
		<?php
		}
		?>
		</td>
        <td width="2%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" height="3"></td>
      </tr>
	<?php
	if($partners->islogin()){
	?>
	  <tr><td colspan="3"><?php include"links.php";?> </td></tr>
	  	<?php
		}
		?>
    </table>