<?php    

function GetLinks($sql){

  $con = $GLOBALS["con"];

  	$ret1   =   mysqli_query($con,$sql);
	$i      =   0;
	$stat   =   "";
   while($row=mysqli_fetch_object($ret1)){

           $pgmid         =$row->program_id;

           $sql           ="select * from partners_banner where banner_programid='$pgmid' and banner_status='inactive'";
           $ret           =mysqli_query($con,$sql);
           $wait1[$i]     =mysqli_num_rows($ret);

           $sql           ="select * from partners_banner where banner_programid='$pgmid' and banner_status='active'";
           $ret           =mysqli_query($con,$sql);
           $approve1[$i]  =mysqli_num_rows($ret);

           $sql           ="select * from partners_text where text_programid='$pgmid' and text_status='inactive'";
           $ret           =mysqli_query($con,$sql);
           $wait2[$i]     =mysqli_num_rows($ret);

           $sql           ="select * from partners_text where text_programid='$pgmid' and text_status='active'";
           $ret           =mysqli_query($con,$sql);
           $approve2[$i]  =mysqli_num_rows($ret);


           $sql           ="select * from partners_popup where popup_programid='$pgmid' and popup_status='inactive'";
           $ret           =mysqli_query($con,$sql);
           $wait3[$i]     =mysqli_num_rows($ret);

           $sql           ="select * from partners_popup where popup_programid='$pgmid' and popup_status='active'";
           $ret           =mysqli_query($con,$sql);
           $approve3[$i]  =mysqli_num_rows($ret);

           $sql           ="select * from partners_flash where flash_programid='$pgmid' and flash_status='inactive'";
           $ret           =mysqli_query($con,$sql);
           $wait4[$i]     =mysqli_num_rows($ret);

            $sql           ="select * from partners_flash where flash_programid='$pgmid' and flash_status='active'";
           $ret           =mysqli_query($con,$sql);
           $approve4[$i]  =mysqli_num_rows($ret);

           $sql           ="select * from partners_html where html_programid='$pgmid' and html_status='inactive'";
           $ret           =mysqli_query($con,$sql);
           $wait5[$i]     =mysqli_num_rows($ret);

           $sql           ="select * from partners_html where html_programid='$pgmid' and html_status='active'";
           $ret           =mysqli_query($con,$sql);
           $approve5[$i]  =mysqli_num_rows($ret);

           $sql           ="SELECT * FROM partners_upload 	WHERE upload_programid = '$pgmid' and upload_status='Inactive'";
           $ret           =mysqli_query($con,$sql);
           $wait6[$i]     =mysqli_num_rows($ret);

           $sql           = "SELECT * FROM partners_upload 	WHERE upload_programid = '$pgmid' and upload_status='Active'";
           $ret           = mysqli_query($con,$sql);
           $approve6[$i]  = mysqli_num_rows($ret);

           $sql           = "SELECT * FROM partners_merchant WHERE merchant_status='inactive'";
           $ret           = mysqli_query($con,$sql);
           $wait7[$i]     = mysqli_num_rows($ret);

           $sql           = "SELECT * FROM partners_affiliate	WHERE affiliate_status='inactive'";
           $ret           = mysqli_query($con,$sql);
           $wait8[$i]     = mysqli_num_rows($ret);

           $sql           ="select * from partners_text_old where text_programid='$pgmid' and text_status='inactive'";
           $ret           =mysqli_query($con,$sql);
           $wait9[$i]     =mysqli_num_rows($ret);

           $sql           ="select * from partners_text_old where text_programid='$pgmid' and text_status='active'";
           $ret           =mysqli_query($con,$sql);
           $approve9[$i]  =mysqli_num_rows($ret);


           $stat=$stat."^".$wait1[$i]."~".$wait2[$i]."~".$wait3[$i]."~".$wait4[$i]."~".$wait5[$i]."~".$approve1[$i]."~".$approve2[$i]."~".$approve3[$i]."~".$approve4[$i]."~".$approve5[$i]."~".$wait6[$i]."~".$approve6[$i]."~".$wait9[$i]."~".$approve9[$i];
           $i=i+1;
   }
  // $stat=$wait1."~".$wait2."~".$wait3."~".$wait4."~".$wait5."~".$approve1."~".$approve2."~".$approve3."~".$approve4."~".$approve5;
   return($stat);
}
?>