<?php

if($_SERVER['REQUEST_METHOD']=="POST")
{
 //echo "submitted";
 //echo $_SESSION['PGMID'];
 //echo $_SESSION['MERCHANTID'];

 function add($lPopUp_success)
            {

                    $pgmid		= $_SESSION['PGMID'];
                    $url		= $_POST['url'];
                    $type		= $_POST['type'];
                    $width		= $_POST['width'];
                    $height		= $_POST['height'];
                    $scrollbar	= $_POST['scrollbar'];

					$sql="INSERT INTO `partners_popup` SET ".
					" popup_programid ='".addslashes($pgmid)."' , ".
					" popup_url ='".addslashes($url)."' , ".
					" popup_type ='".addslashes($type)."' , ".
					" popup_width ='".addslashes($width)."' , ".
					" popup_height ='".addslashes($height)."' , ".
					" popup_scrollbar ='".addslashes($scrollbar)."'   "; 
                    mysqli_query($con,$sql);

                    echo mysqli_error($con);
                   echo "<p align='center' > <font color='red'><strong>$lPopUp_success</strong></font></p>";

            }

                if ($_POST['url']=="" || $_POST['width']=="" || $_POST['height']=="" )
                 {

                echo "<p align='center' > <font color='red'><strong>$blank</strong></font></p>";

                }
                else {


            $sql="select *  from partners_merchant where merchant_id '=$_SESSION[MERCHANTID]' AND merchant_type ='normal'";
            $result = mysqli_query($con,$sql);
            //echo $sql;
            echo mysqli_error($con);

                        if(mysqli_num_rows($result)>0)
                        {
                               $sql1="select * from partners_popup where popup_programid ='$_SESSION[PGMID]'";
                                 $result = mysqli_query($con,$sql1);
                                 echo mysqli_error($con);
                                // echo $sql1;
                                  if(mysqli_num_rows($result)>0)
                                {
                                                                //  echo "normal user with a banner cant add ";
                                echo "<p align='center' > <font color='red'><strong>$lnormal POPUP !!</strong></font></p>";
                                }
                                else
                                {

                                add($lPopUp_success);
                                 //echo "norm user no banner ok adding";
                                }


                        }
                        else
                        {
                        //echo "advance user ok adding";
                        add($lPopUp_success);
                        }



            }   /// else closing of null check


}/////////  submit check if closing

else if($_GET['mode']=="delete")
{

        $id=$_GET['id'];

   $sql="Delete from partners_popup where popup_id ='$id'";

   mysqli_query($con,$sql);

   mysqli_error($con);

  //echo $_SESSION['PGMID'];
   echo "<p align='center' ><font color='red'><strong>$lPopUp_delete</strong></font></p>";

}


?>
 <form method="post" action="" >

   <? include_once "add_link.php"; ?>
   
   <div class="row"> 
	<div class="col-md-6">
		<div class="card stacked-form">
			<div class="card-header"> 
				<h4 class="card-title"><?=$laddpopup_PopUpAdd?></h4>
				<p><b><?=$laddpopup_TocreateaPopUpaddyoumustfillthefollowingfields?></b></p>
			</div>
			<div class="card-body"> 
				<ul style="list-style-type:none;padding-left: 15px;">
					<li><b><?=$laddpopup_PopUpType?> -</b>&nbsp;<?=$laddpopup_PopUptext?></li>
					<li><b><?=$laddpopup_URL?> -</b>&nbsp;<?=$laddpopup_YoumustgivetheURLofthepagethatwillbeusedaspopupadd?></li>
					<li><b><?=$laddpopup_Example?> -</b>&nbsp;<?=$laddpopup_yoursite?></li>
					<li><b><?=$laddpopup_Size?> -</b>&nbsp;<?=$laddpopup_sizeofpopupwindow?></li>
					<li><b><?=$laddpopup_Example?> -</b>&nbsp;600 X 400.</li>
					<li><b><?=$laddpopup_Scrollbars?> -</b>&nbsp;<?=$laddpopup_Determinesifthepopupwindowwillshowscrollbarorno?></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card stacked-form"> 
			<div class="card-header"> 
				<h4 class="card-title"><?=$laddpopup_Settings?></h4>
			</div>
			<div class="card-body"> 
				<div class="form-group">
					<label><?=$laddpopup_PopUpType?></label>
					<div class="form-check form-check-radio form_radio">
						<label class="form-check-label"><?=$laddpopup_PopUP?>
							<input class="form-check-input" type="radio" value="popup" checked="checked" name="type" />
							<span class="form-check-sign"></span>
						</label>
						<label class="form-check-label"><?=$laddpopup_UnderPopUp?>
							<input class="form-check-input" type="radio" value="underpopup" checked="checked" name="type" />
							<span class="form-check-sign"></span>
						</label> 
					</div>
				</div>
				<div class="form-group">
					<label><?=$laddpopup_URL?></label>
					<input type="text" name="url" class="form-control" />
					<span>(<?=$laddpopup_Example?>- <?=$laddpopup_yoursite?>)</span>
				</div>
				<div class="form-group">
					<label><?=$laddpopup_Dimensions?></label>
					<div class="banner_dimension">
						<input class="form-control " type="text" name="width" size="5" /> <b>X</b>
						<input class="form-control" type="text" name="height" size="5" />
						<div class="clearfix"></div>
					</div>
					<span>(<?=$laddpopup_Example?>- 400 X 350)</span>
				</div>
				<div class="form-group">
					<label><?=$laddpopup_Scrollbar?></label>
					<div class="form-check form-check-radio form_radio">
						<label class="form-check-label"><?=$laddpopup_Yes?>
							<input class="form-check-input" type="radio" value="yes" checked="checked" name="scrollbar" />
							<span class="form-check-sign"></span>
						</label>
						<label class="form-check-label"><?=$laddpopup_No?>
							<input class="form-check-input" type="radio" value="no" checked="checked" name="scrollbar" />
							<span class="form-check-sign"></span>
						</label> 
					</div>
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
					<h4 class="card-title"><?=$laddpopup_ExistingPopups?></h4>
				</div>
				<div class="card-body">
					 <?php    ///////////// display  banners /////////////
					 
						$sql3="select * from partners_popup where popup_programid ='$_SESSION[PGMID]' ORDER BY popup_id DESC";
						   $res=mysqli_query($con,$sql3);
						   //echo $sql3;
						   echo mysqli_error($con);

							//Added by DPT on June/16/05
							//if no pop ups exist
							if(mysqli_num_rows($res)<=0)
							{
					?>
					<p><?=$laddpopup_no_msg?></p>
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
								<td><span class='text'><b><?=$laddpopup_Type?>:</b><?=$laddpopup_POPUP?><b><br/><?=$laddpopup_URL?>:</b> <a href='<?=$row->popup_url?>'><?=$row->popup_url?></a></span></td>
								<td>
									<a href="#" onclick="window.open('edit_popup.php?id=<?=$row->popup_id?>','new',100,400)"><?=$laddpopup_Edit?></a>&nbsp;&nbsp;
									<a href='index.php?Act=add_popup&amp;mode=delete&amp;id=<?=$row->popup_id?>'   onclick="return del_onclick()"><?=$laddpopup_Delete?></a>
								</td>
							</tr>						
							<tr>
								<td colspan="2">
									<a href="#"><img src='images/popup.gif' border='0' width="300" height="60" onclick="window.open('<?=stripslashes($row->popup_url)?>',<?=$row->popup_width?>,<?=$row->popup_height?>)" alt="" /></a>
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