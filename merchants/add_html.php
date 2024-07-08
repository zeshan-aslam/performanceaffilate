<?php

if($_SERVER['REQUEST_METHOD']=="POST")
{
 function add($lHTML_success)
            {

              $con = $GLOBALS["con"];
                   $pgmid=$_SESSION['PGMID'];
                   $text= addslashes($_POST['t1']);
					$text = str_replace("\r\n","",$text);
            		//$sql="insert into partners_html (html_id ,html_programid ,html_text) values('','$pgmid','$text')";
					$sql="insert into partners_html SET  html_programid = '".addslashes($pgmid)."',   html_text = '$text'  ";
                    mysqli_query($con,$sql);  

                    echo mysqli_error($con);
                   echo "<p align='center' > <font color='red'><strong>$lHTML_success	</strong></font></p>";

            }

                if ($_POST['t1']=="") {

                echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";

                }
                else {


	    $sql="select *  from partners_merchant where merchant_id ='$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
	    $result = mysqli_query($con,$sql);
	    //echo $sql;
	    echo mysqli_error($con);

	                if(mysqli_num_rows($result)>0)
	                {
	                       $sql1="select * from partners_html where html_programid ='$_SESSION[PGMID]'";
	                         $result = mysqli_query($con,$sql1);
	                         echo mysqli_error($con);
	                        // echo $sql1;
	                          if(mysqli_num_rows($result)>0)
	                        {
								//  echo "normal user with a banner cant add ";
                                echo "<p align='center' > <font color='red'><strong>$lnormal HTML Code !!</strong></font></p>";
	                        }
	                        else
	                        {

	                        add($lHTML_success);
	                         //echo "norm user no banner ok adding";
	                        }


	                }
	                else
	                {
	                //echo "advance user ok adding";
	                add($lHTML_success);
	                }



            }   /// else closing of null check


}/////////  submit check if closing


else if($_GET['mode']=="delete")
{
	$id=$_GET['id'];

   $sql="Delete from partners_html where html_id='$id'";

   mysqli_query($con,$sql);

   mysqli_error($con);

  //echo $_SESSION['PGMID'];
   echo "<p align='center' ><font color='red'><strong>$lHTML_delete	</strong></font></p>";
}

?>
<form method="post" action="" >
	<? include_once "add_link.php"; ?>

	<div class="row"> 
		<div class="col-md-6">
			<div class="card stacked-form">
				<div class="card-header"> 
					<h4 class="card-title"><?=$laddhtml_HTMLAdd?></h4>
					<p><b><?=$laddhtml_TocreateHTMLaddyoumustfillthefollowingfields?></b></p>
				</div>
				<div class="card-body"> 
					<ul style="list-style-type:none;padding-left: 15px;">
						<li><b><?=$laddhtml_HTML?> -</b>&nbsp;<?=$laddhtml_text?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card stacked-form">
				<div class="card-header"> 
					<h4 class="card-title"><?=$laddhtml_Settings?></h4>
				</div>
				<div class="card-body"> 
					<div class="form-group">
						<label><?=$laddhtml_HTML?></label>
						<textarea class="form-control" name="t1" id="t1"></textarea>
					</div>
					<div class="form-group" style="text-align: center;">
						<input type="submit" class="btn btn-info btn-wd" value="<?=$common_submit?>" name="B1" />&nbsp;&nbsp;<input class="btn btn-default btn-wd" type="reset" value="<?=$common_cancel?>" name="B2" />
					</div>
				</div>
			</div>
		</div>
	</div>	

</form>

<div class="row"> 
	<div class="col-md-6">
		<div class="card regular-table-with-color">
			<div class="card-header"> 
				<h4 class="card-title"><?=$laddhtml_ExistingHtmls?></h4>
			</div>
			<div class="card-body">
				 <?php    ///////////// display  banners /////////////
				 
				    $sql3="select * from partners_html where html_programid ='$_SESSION[PGMID]' ORDER BY html_id DESC";
                       $res=mysqli_query($con,$sql3);
                       //echo $sql3;
                       echo mysqli_error($con);

						//Added by DPT on June/16/05
						//if no html ad exist
						if(mysqli_num_rows($res)<=0)
						{
				?>
				<p><?=$laddhtml_no_msg?></p>
				<?php
				}
				?>
			</div>	
			
			<div class="table-full-width table-responsive">
				<table class="table table-hover">						
				<?php							
					//End of Addition
						while($row=mysqli_fetch_object($res))
					{
				?>
					<tbody>
						<tr>
							<td><span class='text'><b>Type:</b><?=$laddhtml_HTMLCode?><b><br/><?=$laddhtml_HTMLID?>:<?=$row->html_id?></b> .....</span></td>
							<td>
								<a href="#" onclick="window.open('edit_html.php?id=<?=$row->html_id?>','new',100,400)"><?=$laddhtml_Edit?></a>&nbsp;&nbsp;
								<a href='index.php?Act=add_html&amp;mode=delete&amp;id=<?=$row->html_id?>' id="del" onclick="return del_onclick()"><?=$laddhtml_Delete?></a>
							</td>
						</tr>
						 <? $id=$row->html_id?>
						<tr>
							<td colspan="2">
								<a href="temp.php?rowid=<?=$id ?>" target="new">
								<img src='images/html.gif' border='0' width="300" height="60" alt="" /></a>
							</td>
						 </tr>
					</tbody>
					 <?php
						} /// while closing
					 ?>
				</table>
			</div>			
		</div>		
	</div>
</div> 

<script language="javascript" type="text/javascript">
<!--

function del_onclick() {
if(confirm("<?=$lang_del?>"))
	{
	 return true;
	}
	else
	{
	return false;
	} 
}

//-->
</script>