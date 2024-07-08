<?php

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
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


        //**************reading cockie first time loading ****//

    $co= $_COOKIE['current'];
     echo $co;

    }
    $sql=" select DISTINCT(b.flash_id) , b.flash_programid , b.flash_url,m.merchant_url,m.merchant_category from

	    partners_flash as b,
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
	    AND p.program_id        =b.flash_programid
	    AND p.program_status        ='active'
	    AND b.flash_status     ='active' ";
        $sql1=$sql;
        $sql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
        $res=mysqli_query($con,$sql);

        $bcount=mysqli_num_rows($res);

	       // echo $sql;
        echo mysql_error();


        //// links including

        include_once 'toplinks.php';             // ***************************  top table and links **************//

 ?>


<form name="f1" action="index.php?Act=gen_flash" method="post">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="68%" id="AutoNumber1" align="center" class="hdbdr">
	<tr>
		<td width="100%" height="19">
			<table border="0" align='center' cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" width="90%" id="AutoNumber4" class="tablehdbdr">
    	        <tr>
	                <td width="100%" height="18" colspan="3" class="tdhead">
	                <p style="text-align: left" align="center"><?=$getflash_get?></p></td>

	            </tr>
	            <tr>
	                <td width="1%" height="19"><p align="center">&nbsp;&nbsp;</p></td>
	                <td width="99%" height="19"><p align="center"></p></td>
	                <td width="1"><p align="center"></p></td>
	            </tr>
	            <tr>
	                <td width="1%" height="139"><p align="center">&nbsp;&nbsp;</p></td>
	                <td width="99%" height="139">

	                <?php

	                //***************** if no flashs found ***************//
	                if ($bcount>0) {

	                while ($row=mysqli_fetch_object($res)) {

        ?>
            	    <table cellspacing="0" cellpadding="5" width="543" border="1" style="border-collapse: collapse" align="center" class="tablebdr">
	                <tbody>
	                    <tr>
	                        <td height='1' width="474" class="grid2"><p align="center">
	                            <a href='<?=$row->flash_url?>' target='new'>
                                <object type="application/x-shockwave-flash" data='<?=$row->flash_swf?>' width="468" height="60">
									<param name="movie" value="<?=$row->flash_swf?>" />
								</object>
                                </a>
	                		</p></td>
	                		<td height="133" width="43" rowspan="2">
                    	        <p align="center"><b><?=$getflash_select?></b></p>
	                			<p align="center" >

                       	  		<?

	                            $bid=$row->flash_id;

	                            ?>

	                			<input type="checkbox" name="b<?=$bid?>"  value="<?=$bid?>" onclick="return a<?=$bid?>_onclick()" />&nbsp;

	                            <?

                           	 	// *******************************************//

	                            echo "

	                            <script language=\"javascript\" type=\"text/javascript\">

	                            function a".$bid."_onclick() {

	                            // alert('hai');

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

	                            ";

	                    	?>
	            				</p>
	        				</td>
	                    </tr>
	                    <tr>
	                        <td  height="89" width="474" class="grid1">
	                            <table border="0" class="tablebdr" width="468" align="center">
	                                <tr>
	                                    <td width="462" colspan="6" class="tdhead" height="24">
	                                            <p align="center"><b><?=$getflash_stat?></b></p>
	                                    </td>
	                                </tr>
	                                <tr>
	                                    <td width="462" colspan="6" class="grid1" height="26">
	                                        <p align="center">&nbsp;<?=$getflash_url?>
	                                        &nbsp;<a href='<?=$row->merchant_url ?>' target='new'><?=$row->merchant_url ?></a> </p>
	                                    </td>
	                                </tr>
	                                <tr>
	                                <?php

                                //************************************//

                                    $linkid="F".$row->flash_id;
                                    //echo $linkid."\n";
                                    $out=GetStat($linkid);

                                    $arr=explode("~",$out);

                                    $click=$arr[0];
                                    $nclick=$arr[1];
                                    $lead=$arr[2];
                                    $nlead=$arr[3];
                                    $sale=$arr[4];
                                    $nsale=$arr[5];
								?>

	                                    <td width="75" class="grid1">
	                                        <p align="right"><img alt="" border="0" height="10" src="../images/click.gif" />&nbsp;
	                                       Click(<?=$nclick?>)</p>
	                                    </td>
	                                    <td width="75" class="grid1">
	                                        <p align="left">&nbsp;<?=$click?>$</p>
	                                    </td>
	                                    <td width="75" class="grid1">
	                                        <p align="right"><img alt="" border="0" height="10" src="../images/lead.gif" />&nbsp;Lead(<?=$nlead?>)</p>
	                                    </td>
	                                    <td width="75" class="grid1">
	                                        <p align="left">&nbsp;<?=$lead?>$</p>
	                                    </td>
	                                    <td width="75" class="grid1">
	                                        <p align="right"><img
	                                        alt="" border="0" height="10" src="../images/sale.gif"/>&nbsp;Sale(<?=$nsale?>)</p>
	                                    </td>
	                                    <td width="75" class="grid1"><p align="left">&nbsp;<?=$sale?>$</p></td>
	                                </tr>
	                            </table>
	                        </td>
	                    </tr>
	                </tbody>
	                </table>
	            </td>
	            <td width="0%" height="139"><p align="center"></p></td>
	        </tr>
	        <tr><td width="8" height="14"><p align="center">&nbsp;</p></td>
	            <td width="565" height="14" colspan="2" ><p>&nbsp;</p></td>
	        </tr>
	        <tr>
	            <td width="1%" height="18"><p>&nbsp;</p></td>
	            <td width="99%" height="18">
	        <?php

	   //**************************//  \

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
                <td width="1"><p>&nbsp; </p></td>
            </tr>
         </table>
		</td>
	</tr>
</table>
&nbsp;
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-align: center" width="90%" id="AutoNumber3" class="tablehdbdr" align="center">
	<tr>
        <td class="tdhead" colspan="2" ><p><?=$getflash_code?></p></td>
    </tr>
    <tr>
        <td valign="top" colspan="2" ><p align="center">&nbsp;</p></td>
    </tr>
    <tr>
        <td width="30%" valign="middle" align="left">
        	<p> &nbsp;&nbsp;&nbsp; <?=$getflash_width?>  &nbsp;&nbsp;&nbsp;<input name="width" type="text" value="" /></p>
            <p> &nbsp;&nbsp;&nbsp; <?=$getflash_height?> &nbsp; <input name="height" type="text" value="" /> </p>
		</td>
        <td width="50%" valign="middle" align="left">
            <p align="left"><?=$getflash_text?>
                <b>Eg : <?=$getflash_width?>=480 <?=$getflash_height?>=60.</b>
                <input type="hidden" id="text1" style="WIDTH: 353px; HEIGHT: 22px" size="45" name="text1" value="<?=$co?>" /></p>
		</td>
    </tr>
    <tr>
      	<td width="705" height="17" colspan="2" class="tdhead">
                <p>&nbsp;<input type="button" value=" Generate flash Rotator" onclick="sub()" /> </p>

    <?php

    				}else {

                        echo $getflash_nomsg;
                        echo "<p><a href='index.php?Act=rotator'><big>$getflash_switch</big></a></p> ";
                        ?>

                          </td>
                          <td width="1"><p align="center"></p></td> </tr>
                                                                  	<!--Added for debugging  -->
                       </table>


                        <?

                        }

	?>
</td>
</tr>
</table></form>
<p>&nbsp;</p>


<script language="javascript" type="text/javascript">

function sub()
{
	var a= f1.width.value;
	var b= f1.height.value;

	if( (a=="") || (b=="") ){
 		alert("Do not Leave width and height field as blank");
	}else{
		f1.submit();
	}
}
</script>