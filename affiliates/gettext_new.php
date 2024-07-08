<?

  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/session.php';

   if(empty($page))                               //getting page no
        $page        =$partners->getpage();


   $sql   = "SELECT  joinpgm_programid, program_url FROM partners_joinpgm, partners_program
            WHERE joinpgm_affiliateid =  '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved'  AND program_id=joinpgm_programid "; //adding to drop down box

  $result = mysqli_query($con,$sql);

  if(mysqli_num_rows($result)<"1")
  {

   echo "<p>&nbsp;</p>
                                                     <table border='0' align='center' cellpadding='0' cellspacing='0' style='border-collapse: collapse'  width='96%' id='AutoNumber1' class='tablebdr'>
                                                             <tr>
                                                               <td width='100%' class='tdhead'>
                                                               &nbsp;</td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%' align='center'>
                                                               <font size='4'>$lang_notjoined</font></td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%'>
                                                               &nbsp;</td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%'>
                                                               <h5 align='center'><a href='index.php?Act=Affiliates&joinstatus=notjoined'> click here to Join</a></td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%' class='tdhead'>
                                                               &nbsp;</td>
                                                             </tr>
                                                           </table> ";

                                                           exit;
  } ///closing of if list populating ;

  /////////////////////////////




$programs = intval(trim($_POST['programs']));
if(empty($programs))
        $programs = intval(trim($_GET['programs']));

if (empty($programs))
{
  $programs="All";
   $link=0;
}

switch ($programs)//checking program
{
       case 'All';    //all pgm
           $bsql="SELECT * FROM partners_text,partners_joinpgm  where        text_status ='active' and joinpgm_affiliateid = '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' AND joinpgm_programid =text_programid " ;
           $pgmid=0;
            $link=0;

           $allresult="--";
           $flag=0;
           break;

       default:    //selected pgm
           $bsql="SELECT * FROM partners_text where text_programid ='$programs' and text_status ='active'        ";
}

include 'getadd.php'
 ?>
<form name="f1" action="index.php?Act=gettextnew" method="post">
<table border="0" cellpadding="0" cellspacing="0"  align="center" width="90%"  >
    <tr>
      <td width="1%" height="3"></td>
      <td width="98%" height="3">
           </td>
      <td width="1%" height="3"></td>
    </tr>
    <tr>
      <td width="1%" height="19">&nbsp;</td>

      <td width="98%" height="19">
                 <table border="0" align='center' cellpadding="0" cellspacing="0" style=" text-align: center"  width="90%" class="tablebdr">
                    <tr>
                                  <td width="100%" height="18" colspan="3" class="tdhead">
                                  <?=$lang_Gettext?>
                                        <select name="programs" onChange="document.f1.submit()"><option value="All" ><?=$lang_home_all_pgms?></option>
                               <?  while($row=mysqli_fetch_object($result))

                               {
                               if($programs=="$row->joinpgm_programid")
                                      $programName="selected = 'selected'";
                               else
                                $programName="";

                               ?>
                                 <option <?=$programName?> value="<?=$row->joinpgm_programid?>"><?=$common_id?>:<?=$row->joinpgm_programid?>...<?=stripslashes($row->program_url)?> </option>
                               <?
                               }
                               ?>
                                    </select>
                                </td>
                      </tr>

                  <!--Choose Sub-ID-->
                        <?php include("subid_choose.php"); ?>
                  <!--Choose Sub-ID-->

                <?php    ///////////// display  texts /////////////

                   $bsql1=$bsql;
                   $bsql  .="LIMIT ".($page-1)*$lines.",".$lines; //adding page no
                   $bres=mysqli_query($con,$bsql);
                   //echo $sql3;
                   //echo mysql_error();

                   if(mysqli_num_rows($bres)<="0")
                   {
                   ?>

                                  <tr>
                                  <td width="2%" height="19">&nbsp;</td>
                                  <td width="94%" height="19" class='textred'><b><?=$lang_text_norec?></b>
                                  </td>
                                  <td></td>
                                  &nbsp;</tr>
                                  <tr>
                                  <td width="3%" height="19"></td>
                                  <td></td>
                                  <td></td>
                                  </tr>
                <? }
                   else
                   {

                                while($row=mysqli_fetch_object($bres))
                                {
                                        $text_url = $row->text_url;
                                        $text_text = $row->text_text;
                                        $text_id = $row->text_id;
                                        $text_image = $row->text_image;
                                        # if the 1st part of the URL not contain http:/
                                        $url_test = substr($text_url, 0, 7);
                                        if($url_test!="http://")
                                        {
                                                $text_url   =    "http://".$text_url;
                                        }
                                        //getting only domain name from the url
                                        $url1        = explode("://",$text_url);
                                        $url2        = explode("/",$url1[1]);
                                        $disp_url        = "http://".$url2[0];

                                        //Added by SMA on 12-APR-06 to display pgm & commn details
                                        $text_pgmid = $row->text_programid;
                                        $sql_pgm = "SELECT * FROM partners_program  WHERE program_id =$text_pgmid  ";
                                        $res_pgm = mysqli_query($con,$sql_pgm);
                                        if(mysqli_num_rows($res_pgm) > 0)
                                        {
                                                $row_pgm = mysqli_fetch_object($res_pgm);
                                                $pgm_name = $row_pgm->{program_url};
                                                //$pgm_date = $row_pgm->{program_enddate};

                                                $date = date("Y-m-d");
                                        }
                                        //End add on 12-APR-06
                                          ?>

                                        
                                        <tr><td colspan="3" height="30" >&nbsp;</td></tr>

                                        <tr>
                                                <!--<td width="1%" height="18">&nbsp;&nbsp;</td>-->
                                                <td width="100%" colspan="3" >
                                                           <table cellspacing="0" cellpadding="5" width='100%' border="0"  >
                                                                <!-- Added by SMA on 12-APR-06 to display pgm & commn details -->
                                                                <tr>
                                                                    <td width='593' class="grid1" align="center">
                                                                        <table align="center" width="400">

                                                                                <tr>
                                                                                        <td width="50">&nbsp;</td>
                                                                                        <td align="right"><strong><?=$lang_home_pgms?></strong></td>
                                                                                        <td width="20">&nbsp;</td>
                                                                                        <td align="left"><b><?=$pgm_name?></b></td>
                                                                                </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <!-- End add on 12-APR-06 -->

                                                                <!-- Added by SMA on 6-May-2006 for the new display of Text Ad  -->
                                                                <tr>
                                                                        <td align="center">
                                                                                <div align="center" style="border:none; overflow:hidden; width:500; height:75" id="<?=$text_id?>_div" >
                                                                                <table align="center" width="500" height="75" border="1" style="border-color:#3399FF; " id="<?=$text_id?>_table" cellpadding="0" cellspacing="0">
                                                                                        <tr style="border:none;" valign="top">
                                                                                                <td style="border:none;" valign="top" width="100%" height="100%">
                                                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
                                                                                                                <tr bgcolor="#3399FF"  id="<?=$text_id?>_tr">
                                                                                                                        <td align="left" height="10" valign="top" colspan="2"><font color="#FFFFFF" id="<?=$text_id?>_borderfont_font"><b>SPONSORED LISTINGS</b></font></td>
                                                                                                                </tr>
                                                                                                                <tr id="<?=$text_id?>_tr_text">
                                                                                                                        <td align="left"><a href="<?=$text_url?>" target="_blank"><font id="<?=$text_id?>_title_font" ><?=$text_text?></font></a></td>
                                                                                                                        <td rowspan="3" align="right" height='50' id="<?=$text_id?>_td_image">
                                                                                                                        <?  if(!empty($text_image)) { ?>
                                                                                                                                <img id="<?=$text_id?>_image" src='../thumbnail.php?image=<?=$text_image?>&height=50' alt='0' border='0' />
                                                                                                                        <? } ?>
                                                                                                                        </td>
                                                                                                                </tr>
                                                                                                                <tr id="<?=$text_id?>_tr_desc">
                                                                                                                        <td align="left"><font id="<?=$text_id?>_desc_font" style="color:#7E7E7E;" ><? echo stripslashes($row->text_description)?></font></td>
                                                                                                                </tr>
                                                                                                                <tr id="<?=$text_id?>_tr_url">
                                                                                                                        <td align="left"><font style="color:#009900" id="<?=$text_id?>_url_font" ><?=$disp_url?></font></td>
                                                                                                                </tr>
                                                                                                        </table>
                                                                                                </td>
                                                                                        </tr>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                </tr>
                                                                <!-- Added on 18-May-06 to allow affiliates to select the size of the Text Banner to be displayed in their site -->
                                                                <tr>
                                                                        <td align="center">
                                                                                <table align="center">
                                                                                        <tr><td colspan="3" align="center"><b><?=$text_banner_size?></b></td></tr>
                                                                                        <tr>
                                                                                                <td><?=$lang_top_Width?>&nbsp;<input type="text" onKeyPress="CheckNumeric();" name="txtwidth_<?=$text_id?>" id="txtwidth_<?=$text_id?>" style="width:50px;" /></td>
                                                                                                <td><?=$lang_top_Height?>&nbsp;<input type="text" onKeyPress="CheckNumeric();" name="txtheight_<?=$text_id?>" id="txtheight_<?=$text_id?>" style="width:50px;" /></td>
                                                                                                <td align="right">&nbsp;<input type="button" name="change_<?=$text_id?>" value="<?=$text_changesize?>" onClick="ChangeSize('<?=$text_id?>','<?=$text_image?>');"  /></td>
                                                                                        </tr>
                                                                                </table>
                                                                        </td>
                                                                </tr>

                                                                <tr>
                                                                    <td align="center">
                                                                        <table align="center" >
                                                                                <tr>
                                                                                        <td align="left"><?=$custom_Border_Color?>&nbsp;&nbsp;</td>
                                                                                        <td width="50"  id="<?=$text_id?>_border" style="background-color:#6699FF;"></td>
                                                                                        <td>&nbsp;&nbsp;<input type="text" readonly="true"  style="width:75;" value="#6699FF"  id="<?=$text_id?>_color_border" /></td>
                                                                                        <td><a href="#" onClick="Popup('colorpicker.php?objname=<?=$text_id?>&section=color_border');">Pick color</a></td>
                                                                                </tr>
                                                                                <tr><td colspan="4" height="2"></td></tr>
                                                                                <tr>
                                                                                        <td align="left"><?=$custom_BorderFont_Color?>&nbsp;&nbsp;</td>
                                                                                        <td width="50" height="10"  id="<?=$text_id?>_borderfont" style="background-color:#FFFFFF;"></td>
                                                                                        <td>&nbsp;&nbsp;<input type="text" readonly="true"  style="width:75;" value="#FFFFFF"  id="<?=$text_id?>_color_borderfont" /></td>
                                                                                        <td><a href="#" onClick="Popup('colorpicker.php?objname=<?=$text_id?>&section=color_borderfont');" >Pick color</a></td>
                                                                                </tr>
                                                                                <tr><td colspan="4" height="2"></td></tr>
                                                                                <tr>
                                                                                        <td align="left"><?=$custom_back_Color?>&nbsp;&nbsp;</td>
                                                                                        <td width="50" height="10"  id="<?=$text_id?>_back" style="background-color:#FFFFFF;"></td>
                                                                                        <td>&nbsp;&nbsp;<input type="text" readonly="true" style="width:75;" value="#FFFFFF"  id="<?=$text_id?>_color_back" /></td>
                                                                                        <td><a href="#" onClick="Popup('colorpicker.php?objname=<?=$text_id?>&section=color_back');" >Pick color</a></td>
                                                                                </tr>
                                                                                <tr><td colspan="4" height="2"></td></tr>
                                                                                <tr>
                                                                                        <td align="left"><?=$custom_title_Color?>&nbsp;&nbsp;</td>
                                                                                        <td width="50" height="10"  id="<?=$text_id?>_title" style="background-color:#000000;"></td>
                                                                                        <td>&nbsp;&nbsp;<input type="text" readonly="true"  style="width:75;" value="#000000"  id="<?=$text_id?>_color_title" /></td>
                                                                                        <td><a href="#" onClick="Popup('colorpicker.php?objname=<?=$text_id?>&section=color_title');" >Pick color</a></td>
                                                                                </tr>
                                                                                <tr><td colspan="4" height="2"></td></tr>
                                                                                <tr>
                                                                                        <td align="left"><?=$custom_url_Color?>&nbsp;&nbsp;</td>
                                                                                        <td width="50" height="10"  id="<?=$text_id?>_url" style="background-color:#009900;"></td>
                                                                                        <td>&nbsp;&nbsp;<input type="text" readonly="true"  style="width:75;" value="#009900"  id="<?=$text_id?>_color_url" /></td>
                                                                                        <td><a href="#" onClick="Popup('colorpicker.php?objname=<?=$text_id?>&section=color_url');" >Pick color</a></td>
                                                                                </tr>
                                                                                <tr><td colspan="4" height="2"></td></tr>
                                                                                <tr>
                                                                                        <td align="left"><?=$custom_desc_Color?>&nbsp;&nbsp;</td>
                                                                                        <td width="50" height="10"  id="<?=$text_id?>_description" style="background-color:#7E7E7E;"></td>
                                                                                        <td>&nbsp;&nbsp;<input type="text" readonly="true"  style="width:75;" value="#7E7E7E"  id="<?=$text_id?>_color_description" /></td>
                                                                                        <td><a href="#" onClick="Popup('colorpicker.php?objname=<?=$text_id?>&section=color_description');" >Pick color</a></td>
                                                                                </tr>
                                                                                <tr><td colspan="4" height="2"></td></tr>

                                                                        </table>
                                                                    </td>
                                                                </tr>

                                                                <!-- Added on 28 Apr 2006 by SMA for new window option -->
                                                                <tr>
                                                                        <td align="center"><b><?=$custom_color_help?></b></td>
                                                                </tr>

                                                                <tr>
                                                                        <td width="50%" align="center">
                                                                                <table width="50%" align="center">
                                                                                        <tr>
                                                                                         <!-- Commented to hide the code for new window  -->
																						        <td align="right"><b><?=$newwindow_text?></b></td>
                                                                                                <td align="left"><input type="checkbox" name="chk_<?=$row->text_id?>" onChange="OpenInNewWindow('<?=$row->text_id?>');">&nbsp;&nbsp;&nbsp;&nbsp;</td>
																						
                                                                                                <td align="center"><input type="button" name="applycolor" value="<?=$custom_apply_color?>" onClick="ApplyColors('<?=$text_id?>');" /></td>
                                                                                        </tr>
                                                                                </table>
                                                                        </td>
                                                                </tr>
                                                                        <!-- End 28 Apr 2006 by SMA for new window option -->
                
                <!-- Added on 27th July 2009 to display the tracking URL -->
                    <?php
                    //if the affiliate has chosen a sub id then add that also to the url
                    $subidurl = "&amp;subid=1";
                    if(!empty($subid)) $subidurl = "&amp;subid=$subid";
                    
                    $targetUrl = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=T$row->text_id".$subidurl;
                    ?>
                    <!--  Display URL -->
                    <tr>
                        <td height='1' width='100%' class="grid2">
                        <span><?=$lang_TrackURL?>: <a href='<?=$targetUrl?>' target="new"><?php echo $targetUrl?></a></span>
                        </td>
                    </tr>
                <!-- END display the tracking URL -->


                                                                 <tr>
                                                                          <td  height='44' width='599' class="grid1">
                                                                          <?=$lang_Gettext_help?></td>
                                                                  </tr>
                                                                  <tr>
                                                                          <td  height='73' width='599' class="grid2">
                                                                           <!-- Text Ad   -->

                                                                          <!-- <textarea rows="4" name="S1" cols="75">         -->
                                                                          <textarea rows="4" name="code_<?=$row->text_id?>" cols="75">
                                                                          <?
                                                                                //$track_site_url = urlencode($track_site_url);

                                                                                //if the affiliate has chosen a sub id then add that also to the url
                                                                                $subidurl = "";
                                                                                if(!empty($subid)) $subidurl = "&amp;subid=$subid";

                                                                                        $default_colors="3399FF~FFFFFF~000000~009900~FFFFFF~7E7E7E";
                                                                                 $track_site_url = str_replace(" ","%20",$track_site_url);
                                                                                 $code = "<!-- START $title CODE -->\n<script language='javascript'  type='text/javascript'>\nvar r=document.referrer;\n var counter = new Object();\ncounter.src = '$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&color=$default_colors&newwindow=0&width=500&height=75&amp;linkid=T$row->text_id&amp;r='+r;\n</script><script src=$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&color=$default_colors&newwindow=0&width=500&height=75&amp;linkid=T$row->text_id$subidurl>\n</script>\n<!-- END $title CODE -->";
                                                                                 //if window is to be opened in new window
                                                                                 $newcode = "<!-- START $title CODE -->\n<script language='javascript'  type='text/javascript'>\nvar r=document.referrer;\n var counter = new Object();\ncounter.src = '$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&color=$default_colors&newwindow=1&width=500&height=75&amp;linkid=T$row->text_id&amp;r='+r;\n</script><script src=$track_site_url/get_trackingcode.php?aid=$_SESSION[AFFILIATEID]&color=$default_colors&newwindow=1&width=500&height=75&amp;linkid=T$row->text_id$subidurl>\n</script>\n<!-- END $title CODE -->";
                                                                                 echo $code;
                                                                         ?>
                                                                          </textarea>

                                                                                <!-- Hidden box to store the code for new window & Same window to be used dynamically on click of check box  -->
                                                                                <input type="hidden" name="hdnSame_<?=$row->text_id?>" value="<?=$code?>" />
                                                                                <input type="hidden" name="hdnNew_<?=$row->text_id?>" value="<?=$newcode?>" />
                                                                          </td>
                                                                  </tr>

                                                                          </table>
                                                                        </td>
                                                                        <!--<td width="4%" height="18"></td>-->
                                                                        
                                                                </tr>

                         <?php

                                                } /// while closing

                        ?>

                                                <tr>
                                                        <td width="1%" height="18">
                                                        </td>
                                                        <td width="95%" height="18">
                                                        <?

                                                                 $pgsql=$bsql1;
                                                                 $url    ="index.php?Act=gettextnew&amp;programs=$programs";    //adding page nos
                                                                include '../includes/show_pagenos.php';
                                                ?>
                                                   </td>
                                                        <td width="4%" height="18">&nbsp;&nbsp;
                                                        </td>
                                                </tr>
                        <?php
                        }
                        ?>

                        <tr>
                          <td width="100%" height="19" colspan="3" class="tdhead">&nbsp;<input type="hidden" name="hdn_colorcode"  /></td>
                        </tr>
                  </table>
          </td>
          <td width="1%" height="19">
           </td>
        </tr>
        <tr>
          <td width="1%" height="19">&nbsp;</td>
          <td width="98%" height="19">&nbsp;</td>
          <td width="1%" height="19">&nbsp;</td>
        </tr>
        <tr>
          <td width="1%" height="19">&nbsp;</td>
          <td width="98%" height="19">&nbsp;</td>
          <td width="1%" height="19">&nbsp;</td>
        </tr>
  </table>
 </form>

         <script language="javascript">
        /* --------------------------------------------------------------------------------------------------
        Function to chnage the tracking code to display the target url in a new window or not depending on
        the value of the check box.  Function called on chnage of checkbox.
        Created BY          : SMA
        Created ON                : 28-Apr-2006
        -------------------------------------------------------------------------------------------------- */
        function OpenInNewWindow(chk)
        {
                var id = "document.f1.chk_"+chk+".checked";
                if(eval(id))
                {
                        code = "document.f1.code_"+chk+".value = document.f1.hdnNew_"+chk+".value";
                        eval(code);
                } else
                {
                        code = "document.f1.code_"+chk+".value = document.f1.hdnSame_"+chk+".value";
                        eval(code);
                }
        }

        /* --------------------------------------------------------------------------------------------------
        Function to chnage the tracking code to display the Text Ad with the colors selected by the Affiliate.
        Function is called on the click of the button applycolors
        Created BY          : SMA
        Created ON                : 8-May-2006
        -------------------------------------------------------------------------------------------------- */
        function ApplyColors(id)
        {
                bord_val = id+"_color_border";
                bord_val = eval("document.getElementById(bord_val).value");
                color = bord_val.substring(1,7);
                back_val = id+"_color_back";
                back_val = eval("document.getElementById(back_val).value");
                color = color+"~"+back_val.substring(1,7);
                col_val = id+"_color_title";
                col_val = eval("document.getElementById(col_val).value");
                color = color+"~"+col_val.substring(1,7);
                col_val = id+"_color_url";
                col_val = eval("document.getElementById(col_val).value");
                color = color+"~"+col_val.substring(1,7);
                col_val = id+"_color_borderfont";
                col_val = eval("document.getElementById(col_val).value");
                color = color+"~"+col_val.substring(1,7);
                col_val = id+"_color_description";
                col_val = eval("document.getElementById(col_val).value");
                color = color+"~"+col_val.substring(1,7);

                code = "document.f1.code_"+id+".value";
                code = eval(code);
                pos = code.indexOf('color');
                newcode = code.substring(0,pos);
                newcode = newcode+"color="+color;
                code1 = code.substring(pos,code.length);
                pos1 = code1.indexOf('&');
                code2 = code1.substring(pos1,code1.length);
                pos2 =  code2.indexOf('color');
                newcode = newcode + code2.substring(0,pos2) + "color="+color;
                code3 = code2.substring(pos2,code2.length);
                pos3 = code3.indexOf('&');
                newcode = newcode + code3.substring(pos3,code3.length);

                wcode1 = newcode.indexOf('newwindow');
                windowcode = newcode.substring(wcode1,wcode1+11);
                if(windowcode=='newwindow=0')
                {
                        samewindow = newcode;
                        newwindow  = newcode.replace('newwindow=0','newwindow=1');
                        newwindow  = newwindow.replace('newwindow=0','newwindow=1');
                } else
                {
                        samewindow = newcode.replace('newwindow=1','newwindow=0');
                        samewindow = samewindow.replace('newwindow=1','newwindow=0');
                        newwindow  = newcode;
                }
                document.f1.hdn_colorcode.value=newwindow;
                putcode = "document.f1.hdnNew_"+id+".value = document.f1.hdn_colorcode.value";
                eval(putcode);
                document.f1.hdn_colorcode.value=samewindow;
                putcode = "document.f1.hdnSame_"+id+".value = document.f1.hdn_colorcode.value";
                eval(putcode);

                OpenInNewWindow(id);
        }

    /*--------------------------------------------------------------------------
    Description   :- function to chnage the size of the Text Ad displaye to the height & width entered.
        Called on the click of the button Change  Size.
    Programmer    :- SMA
    Last Modified :- 18/MAY/2006
    --------------------------------------------------------------------------*/
        function ChangeSize(id,image_src)
        {
                tableid         = id+"_table";
                divid                = id+"_div";
                heightid        = "txtheight_"+id;
                widthid                = "txtwidth_"+id;
                height                = document.getElementById(heightid).value;
                width                = document.getElementById(widthid).value;

                code = "document.f1.code_"+id+".value";
                code = eval(code);
                if(width!='')
                {
                        document.getElementById(tableid).style.width = width-2;
                        document.getElementById(divid).style.width = width;
                        pos = code.indexOf('width');
                        newcode = code.substring(0,pos);
                        newcode = newcode+"width="+width;
                        code1 = code.substring(pos,code.length);
                        pos1 = code1.indexOf('&');
                        code2 = code1.substring(pos1,code1.length);
                        pos2 =  code2.indexOf('width');
                        newcode = newcode + code2.substring(0,pos2) + "width="+width;
                        code3 = code2.substring(pos2,code2.length);
                        pos3 = code3.indexOf('&');
                        newcode = newcode + code3.substring(pos3,code3.length);
                        code = newcode;
                }

                if(height!='')
                {
                        document.getElementById(tableid).style.height = height-2;
                        document.getElementById(divid).style.height = height;
                        pos = code.indexOf('height');
                        newcode = code.substring(0,pos);
                        newcode = newcode+"height="+height;
                        code1 = code.substring(pos,code.length);
                        pos1 = code1.indexOf('&');
                        code2 = code1.substring(pos1,code1.length);
                        pos2 =  code2.indexOf('height');
                        newcode = newcode + code2.substring(0,pos2) + "height="+height;
                        code3 = code2.substring(pos2,code2.length);
                        pos3 = code3.indexOf('&');
                        newcode = newcode + code3.substring(pos3,code3.length);
                        code = newcode;

                        imgid = id+"_image";
                        imgheight =  height-25;
                        img_tdid = id+"_td_image";
                        document.getElementById(img_tdid).style.height = imgheight;
                        if(image_src != '')
                        {
                                document.getElementById(imgid).src = '../thumbnail.php?image='+image_src+'&height='+imgheight;
                        }
                }

                wcode1 = code.indexOf('newwindow');
                windowcode = code.substring(wcode1,wcode1+11);
                if(windowcode=='newwindow=0')
                {
                        samewindow = code;
                        newwindow  = code.replace('newwindow=0','newwindow=1');
                        newwindow  = newwindow.replace('newwindow=0','newwindow=1');
                } else
                {
                        samewindow = code.replace('newwindow=1','newwindow=0');
                        samewindow = samewindow.replace('newwindow=1','newwindow=0');
                        newwindow  = code;
                }
                document.f1.hdn_colorcode.value=newwindow;
                putcode = "document.f1.hdnNew_"+id+".value = document.f1.hdn_colorcode.value";
                eval(putcode);
                document.f1.hdn_colorcode.value=samewindow;
                putcode = "document.f1.hdnSame_"+id+".value = document.f1.hdn_colorcode.value";
                eval(putcode);

                OpenInNewWindow(id);

        }

    /*--------------------------------------------------------------------------
    Description   :- function to open a new popup window
    Programmer    :- SMA
    Last Modified :- 13/FEB/2006
    --------------------------------------------------------------------------*/
     function Popup(url)
     {
        window.open(url,'remote','menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,dependent,width=440,height=100,left=300,top=300,modal=no');
        //window.showModalDialog(url,"","dialogWidth:255px;dialogHeight:250px");

     }

    /*--------------------------------------------------------------------------
    Description   :- function to allow only Numeric values in a textbox.
        Called in the onKeyPress event.
    Programmer    :- SMA
    Last Modified :- 18/MAY/2006
    --------------------------------------------------------------------------*/
        function CheckNumeric()
        {
                if((window.event.keyCode>57 || window.event.keyCode<48) && (window.event.keyCode!=8))
                {
                        alert('<?=$js_numeric_value?>');
                        window.event.returnValue = null;
                        return false;
                }
                return true;
        }

        </script>

<!--  This code wass removed
  <tr>
  <td  height='73' width='599' class="grid2">
   Text Link

  <textarea rows="4" name="S1" cols="75">
  <?  /*
        //if the affiliate has chosen a sub id then add that also to the url
        $subidurl = "";
        if(!empty($subid)) $subidurl = "&amp;subid=$subid";

        //$track_site_url = urlencode($track_site_url);
         $track_site_url = str_replace(" ","%20",$track_site_url);
         $url = $track_site_url."/trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=T$row->text_id".$subidurl;
         $code = "<!-- START $title CODE -->\n<a href='$url'>$row->text_text</a>\n\n<!-- END $title CODE -->";
         echo $code;
         */
 ?>


  </textarea>
  </td>
  </tr>
  -->

                                                          <!--
                                                                <tr>
                                                                        <td height='1' width='593' class="grid2">
                                                                        <span><?=$lang_home_text?>:<?=$row->text_text?><br/>
                                                                        <?=$lang_URL?>: <a href='<?=$text_url?>' target="new">
                                                                        <?=$row->text_url?></a></span></td>
                                                                  </tr>
                                                        -->


