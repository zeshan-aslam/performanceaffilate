<?php
/***************************************************************************/
/*     PROGRAMMER     :  SMA                                               */
/*     SCRIPT NAME    :  paging.php                                        */
/*     CREATED ON     :  10/OCT/2007                                       */
/*     LAST MODIFIED  :  10/OCT/2007                                       */
/*                                                                         */
/*     Paging                                                              */
/***************************************************************************/
 //die("sssssssssssssssss".$_SESSION['SESS_TOTALCOUNT']);
   // for paging
    $paging_ofover				= "Of ";
    //$paging_ofover              = "Of Over";
    $paging_records				= "Record(s) ";
	$paging_first				= "First";
    $paging_next				= "Next";
    $paging_prev				= "Prev";
    $paging_last				= "Last";
                //set up record count per page
                $recordcountperpage        = $lines; 
				//echo "  limit = ".$recordcountperpage."  tot  = ".$_SESSION['SESS_TOTALCOUNT']."<br/>";
                //find pagecount
                $pagecount = ceil($_SESSION['SESS_TOTALCOUNT']/$recordcountperpage);
//echo "  pages = ".$pagecount."<br/>";

                //if total records is greater than the no of records per page then only show paging
                if($pagecount>1)
                {
                        //find from and to
                        if($page==1) $from = 1;
                        else $from = (($page-1)*$recordcountperpage) + 1;
                        $to = $from + $recordcountperpage - 1;
                        if($to>$_SESSION['SESS_TOTALCOUNT']) $to = $_SESSION['SESS_TOTALCOUNT'];

                        //url to load the same page
                        $url_arr = explode("&page=",$_SERVER['REQUEST_URI']);
                        $request_url = $url_arr[0];
?>
<span class="paging"><?=$from?> - <?=$to?> <?=$paging_ofover?> <?=$_SESSION['SESS_TOTALCOUNT']?> <?=$paging_records?>
<?php
                        //do not display the links if there is only onepage
                        if($pagecount>1)
                        {
                                //need not show 'First'/'Prev' link for first page
                                if($page!=1)
                                {
?>
&laquo; <a href="<?=$request_url?>&amp;page=1"><?=$paging_first?></a> &raquo; |
&laquo; <a href="<?=$request_url?>&amp;page=<?=($page-1)?>"><?=$paging_prev?></a> &raquo;
<?php
                                }

                                //need not show 'Next'/'Last' link for last page
                                if($page!=$pagecount)
                                {
?>
  | &laquo; <a href="<?=$request_url?>&amp;page=<?=($page+1)?>"><?=$paging_next?></a> &raquo; | &laquo; <a href="<?=$request_url?>&amp;page=<?=$pagecount?>"><?=$paging_last?></a>  &raquo;
<?php
                                 }
                        }//end of checking for pagecount
?>
</span><br>

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<select name="cmb_page" id="cmb_page" onchange="javascript: GoToPage('<?php echo $request_url?>');" >
	<?php
		for($i=1; $i<=$pagecount; $i++) { ?>		
		<option value="<?php echo $i?>" <?php if($page == $i) echo "selected='selected'" ?> ><b><?php echo $i?></b></option>
	<? 	} ?>
	</select>
<?php
                }//end of checking for paging
?>	
<script language="javascript" >
	//Function to got to the selected page number of the present page
	function GoToPage(url)
	{  
		var page = document.getElementById('cmb_page').value;
		url = url+"&page="+page;
		window.location.href = url;
	}
</script>	