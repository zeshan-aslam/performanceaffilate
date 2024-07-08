

<?php

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
    include_once '../includes/allstripslashes.php';
    include_once 'getstatistics.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    $catid = intval($_GET['catid']);

    if (empty($page))                          //getting page no
       {
	       $page        =$partners->getpage();
       }
    else
    {
          // *************************** if page exist get cookies -> returns the value prev page ticked  checkbox


   			 $co= $_COOKIE['current'];
   			 echo $co;

    }
    $sql=" select DISTINCT(b.banner_id) , b.banner_programid , b.banner_url,b.banner_name,m.merchant_url,m.merchant_category from

	    partners_banner as b,
	    partners_program as p,
	    partners_merchant as m,
	    partners_rotatorsta as s,
	    partners_rotator as r,
	    partners_category as c

	    where r.rotator_affilid='$AFFILIATEID' 

        AND c.cat_id     ='$catid' 
        AND s.rotatorsta_status     ='approved'
	    AND s.rotatorsta_roid       =r.rotator_id
	    AND r.rotator_catid     =c.cat_id

	    AND c.cat_name          =m.merchant_category
	    AND m.merchant_status       ='approved'
	    AND m.merchant_id       =p.program_merchantid
	    AND p.program_id        =b.banner_programid
	    AND p.program_status        ='active'
	    AND b.banner_status     ='active' ";
        $sql1=$sql;
        $sql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
        $res=mysqli_query($con,$sql);


        echo mysql_error();

        $bcount= mysqli_num_rows($res);

        echo mysql_error();

        //// links including

        include_once 'toplinks.php';             // ***************************  top table and links **************//
?>
	    <form name="f1" action="index.php?Act=gen_banner" method="post">
	    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber1" align="center" class="hdbdr">
	      <tr>
	    	<td width="100%" height="19" colspan="4">
	    	<table border="0" align='center' cellpadding="0" cellspacing="0" style="text-align: center" width="90%" id="AutoNumber4" class="tablehdbdr">
	    	  <tr>
	    		<td width="100%" height="18" colspan="3" class="tdhead">
	    		<p style="text-align: left" align="center"><?=$lang_top_GetBannersFor0BannerAdds?></p></td>
	          </tr>
	    	  <tr>
        	    <td width="1%" height="19"><p align="center">&nbsp;&nbsp;</p></td>

	            <td width="99%" height="19"><p align="center"></p></td>

	            <td width="1"><p align="center"></p></td>
 	    	  </tr>
	    	  <tr>
	            <td width="1%" height="139"><p align="center"> &nbsp;&nbsp;</p></td>
	    		<td width="99%" height="139">


	            <?php

	            //***************** if  banners found ***************//
	            if ($bcount>0) {

	            while ($row=mysqli_fetch_object($res)) {

	            //echo $row->banner_name."sdfsfs";

	            ?>
                    <table cellspacing="0" cellpadding="5" width="70%" style="border-collapse: collapse" align="center" class="tablebdr">
                    <tbody>
                        <tr>
                            <td height='1' colspan="2" class="grid2">
                                <p align="center">
                                <a href='<?=$row->banner_url?>' target='new'><img src='<?=$row->banner_name?>' border='0' width="468" height="60" alt=""/></a></p>
                            </td>
                            <td height="133" width="30%" rowspan="2">
                                <p align="center"><b><?=$lang_top_SelectForBannerRotator?></b></p>
                                <p align="center" >

                                <?

                                $bid=$row->banner_id;

                                ?>
                            <input type="checkbox" name="b<?=$bid?>"  value="<?=$bid?>" onclick="return a<?=$bid?>_onclick()" />&nbsp;

	            <?
                           //**********************writing client side cookies with check box value***********//


                   	     echo "

	                    <script language=\"javascript\" type=\"text/javascript\">

	                    function a".$bid."_onclick() {

	                    	foo =f1.text1.value ;
	                   		but=f1.b".$bid.".value;
	                    	theResult = foo.indexOf(f1.b".$bid.".value);

	                    	// alert(theResult);
	                    	if(theResult==-1)
	                    	{
			                    f1.text1.value=f1.text1.value+'~'+f1.b".$bid.".value;
			                    document.cookie = 'current='+f1.text1.value;
	                    		// alert(document.cookie);
	                    	}
	                    	else
	                    	{
			                     myString = new String(f1.text1.value);

	                    		rExp =   new RegExp('~'+f1.b".$bid.".value);

	                    		newString = new String ('')
	                    		results = myString.replace(rExp, newString)

			                    f1.text1.value=results

			                    document.cookie = 'current='+f1.text1.value;
			                    // alert(document.cookie);
			                    //replace(f1.text1.value,f1.b".$bid.".value)
	                    	}
	                    }
	                    </script>

	                    ";  //// close of echo


                    /// ********************************//

                   ?>



	                      	</p>
	                      	</td>
	                    </tr>
	                    <tr>
	                    	<td  height="89" width="70%" class="grid1">
	                    	<table border="0" class="tablebdr" width="468" align="center">
	                    		<tr>
	                    			<td width="462" colspan="6" class="tdhead" height="24">
	                    			<p align="center"><b><?=$lang_top_BannerStatistics?></b></p>
	                    			</td>
	                    		</tr>
	                    		<tr>
	                    			<td width="462" colspan="6" class="grid1" height="26">
	                    			<p align="center">&nbsp;<?=$lang_top_MerchantURL?>
	                    			&nbsp;<a href='<?=$row->merchant_url ?>' target='new'><?=$row->merchant_url ?></a> </p>
	                    			</td>
	                    		</tr>
	                    		<tr>
                <?php

                //************************************statistics generator **************//

                    $linkid="B".$row->banner_id;
                    //echo $linkid."\n";

                    //// function to getstsatistics of banner .

                    $out=GetStat($linkid);

                    $arr=explode("~",$out);

                    $click=$arr[0];
                    $nclick=$arr[1];
                    $lead=$arr[2];
                    $nlead=$arr[3];
                    $sale=$arr[4];
                    $nsale=$arr[5];
                ?>

	                    			<td width="75" class="grid1"><p align="right"><img
	                    				alt="" border="0" height="10" src="../images/click.gif"/>&nbsp;
	                    				<?=$lang_top_Click?>(<?=$nclick?>)</p>
	                    			</td>
	                    			<td width="75" class="grid1">
	                    				<p align="left">&nbsp;<?=$click?>$</p>
	                    			</td>
	                    			<td width="75" class="grid1">
	                    				<p align="right"><img alt="" border="0" height="10" src="../images/lead.gif"/>&nbsp;<?=$lang_top_Lead?>(<?=$nlead?>)</p>
	                    			</td>
	                    			<td width="75" class="grid1"><p align="left">&nbsp;<?=$lead?>$</p>
	                    			</td>
	                    			<td width="75" class="grid1">
	                    				<p align="right"><img
	                    				alt="" border="0" height="10" src="../images/sale.gif"/>&nbsp;<?=$lang_top_Sale?>(<?=$nsale?>)</p>
	                    			</td>
	                    			<td width="75" class="grid1">
	                    				<p align="left">&nbsp;<?=$sale?>$</p>
	                    			</td>
	                    		</tr>
	                    	</table>
	                    	</td>
	                  	</tr>
	            	</tbody>
	                </table>
            		</td>
			    	<td width="0%" height="139"><p align="center"></p></td>
          	  </tr>
	          <tr>
	           		<td width="8" height="14"><p align="center">&nbsp;</p></td>
	            	<td width="565" height="14" colspan="2" ><p>&nbsp;</p></td>
	          </tr>
	          <tr>
	            	<td width="1%" height="18"><p>&nbsp;</p></td>
	            	<td width="99%" height="18">
	            <?php
			    }
	            ?>
			    	</td>
	            	<td width="1"><p>&nbsp;</p></td>
          	  </tr>
	      	  <tr>
	            	<td width="1%" height="18"><p>&nbsp;</p></td>
	            	<td width="99%" height="18">

                 <?
                          $pgsql=$sql1;
                          $url    ="index.php?Act=getrotator";    //adding page nos
                          include '../includes/show_pagenos.php';

                  ?>
                 	</td>
                	<td width="1%"><p>&nbsp; </p></td>
              	</tr>
          	</table>
		  </td>
        </tr>
      </table>
      &nbsp;
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" width="90%" id="AutoNumber3" class="tablehdbdr" align="center">
        <tr>
          <td width="705" class="tdhead" colspan="2" ><p><?=$lang_top_BannerCode?> </p></td>
        </tr>
      	<tr>
          <td width="705" valign="top" colspan="2" ><p align="center">&nbsp;</p></td>
        </tr>
        <tr>
          <td width="30%" valign="middle" align="left">
            <p> &nbsp;&nbsp;&nbsp; <?=$lang_top_Width?>  &nbsp;&nbsp;&nbsp;<input name="width" type="text" value=""/></p>
            <p> &nbsp;&nbsp;&nbsp; <?=$lang_top_Height?> &nbsp; <input name="height" type="text" value=""/> </p>
          </td>
          <td width="50%" valign="middle" align="left">
            <p align="left"><?=$lang_top_Selectall?>
            <input type="hidden" id="text1" style="width: 353px; height: 22px" size="45" name="text1" value="<?=$co?>" /></p>
          </td>
        </tr>
        <tr>
          <td width="705" height="17" colspan="2" class="tdhead">
             <p>&nbsp;<input type="button" value=" Generate Banner Rotator" onclick="sub()"/> </p>
           <?php

                    }
                    else {



                    echo "$getbann_nomsg";
                    echo "<p><a href='index.php?Act=rotator'><big>$getbann_switch</big></a></p> ";

                    ?>

                      </td><td width="1">
                      <p align="center"></p>

                       </td></tr></table>               	<!--Added for debugging  -->

                <?
                    }

	            ?>
</td>
</tr>
</table>
</form>
	                    <p>&nbsp;</p>

<script language="javascript" type="text/javascript">
    function sub()
    {
	    var a= document.f1.width.value;
    	var b= document.f1.height.value;
    	if( (a=="") || (b=="") )
    	{
    		alert("Do not Leave width and height fields as blank");
	    }else{
    		document.f1.submit();
    	}
    }
</script>