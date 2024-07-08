<form name="langform" action="" method="post">

<!--
     <table width="100%" class="tablewbdr"><tr>
     <td  width="5%" align="left" valign="bottom"><font color="#954A00"><b>Merchant</b></font></td>
     <td  width="5%" align="left"  valign="bottom"><font color="#3C3C77"><b>:<?=$_SESSION['MERCHANTNAME']?></td>
     <td  width="15%" align="right" valign="bottom">

-->
        <!------------Languages------->
        <?
		//get all languages
		$sqllang = "select * from partners_languages where languages_status = 'active'";
		$reslang = mysqli_query($con,$sqllang);
        if(mysqli_num_rows($reslang)>0)
        {
		?>

        Language : <select name="languageid" onChange="javascript:langform.submit();">

          <?
		while($rowlang = mysqli_fetch_object($reslang))
		{
			$langsel = "";
			if($language==$rowlang->languages_id) $langsel = "selected";
         ?>

          <option value="<?=$rowlang->languages_id?>" <?=$langsel?>><?=$rowlang->languages_name?>
          </option>
         <?
		}
    	?>
        </select>
        <?
		}
        ?>
        <!--------End of Languages------->

   <!--
           </td>
             </tr>
             <tr>
     			<td  width="5%" align="left" valign="bottom" ><font color="#954A00"><b>Balance</b></font></td>
     			<td  width="5%" align="left" valign="bottom"><font color="#3C3C77">:$<?=$_SESSION['MERCHANTBALANCE']?></b></font></td>
                <td  width="15%" align="right" valign="bottom">
                </tr>
                <tr>
               	<td  width="85%" align="left" valign="bottom" colspan="2" ><a href="index.php?Act=paymentlist">Payment History</a></td>

     			<td  width="15%" align="right" valign="bottom">
                </tr>


     </table>

     --></form>