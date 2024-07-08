<?php
    session_start();
    session_register("VAR");
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
    include_once '../includes/allstripslashes.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

    $id		 = intval($_GET['id']); 
    $affilid = intval($_GET['affilid']);
    $width	 = $_GET['width'];
    $height	 = $_GET['height'];


    $sql="SELECT * FROM  partners_rcode  where rcode_id= '$id' ";

	$res=mysqli_query($con,$sql);

   	while ($row=mysqli_fetch_object($res))
    {

    	$bids=stripslashes($row->rcode_bannerid);

    }

	$arr	= explode("~",$bids);

    $tot = count($arr);

    $rand=rand(1,$tot-1);

    $okid = $arr[$rand];

      // $tot	=$arr[1];

    $sql="select * from partners_banner where banner_id='$okid'";

	$res =  mysqli_query($con,$sql);

	echo mysql_error();

	while($row=mysqli_fetch_object($res))
	{

    	$curimg = $row->banner_name;
        $cururl = $row->banner_url;
        $curid  = $row->banner_id;
        $pgmid  = $row->banner_programid;

        $sqlMer = "SELECT * FROM partners_program WHERE program_id = '".$pgmid."'";
        $retMer = mysqli_query($con,$sqlMer);
        if(mysqli_num_rows($retMer)){
        	$rowMer = mysqli_fetch_object($retMer);
            $mid	 = $rowMer->program_merchantid;
        }
    }

#------------------------------------------------------------------------
# Recording Impression
#------------------------------------------------------------------------
    # checking whtehre the impression is from the same session
    if(($_SESSION['VAR']!= $PHPSESSID ) or (empty($PHPSESSID))) {
       $_SESSION['VAR'] = $PHPSESSID;
       $sessset	=	0;
    }else{
       $sessset	=	1;
    }

	$today  				=   date("Y-m-d");
    $referer 				=   getenv(HTTP_REFERER);

	if($sessset==0){
		InsertDailyImpression($pgmid, $affilid, $mid, 'B$curid', $subid, $today);		
	}
#added on 18.JUNE.06
InsertRawTrans_daily($pgmid, $affilid,$mid, 'B$curid', $today)  ;


    $image	=	$curimg;

    $imagelist .= "<a href=$track_site_url/trackingcode.php?aid=$affilid&linkid=B$curid&Act=Rotator><img src=".$image." height=".$height." width=".$width." border=0></a>";

	echo "document.write('$imagelist');";
	
	
 //------------------------------------------------------------------------------------
    # This function is used to insert/update the  raw impression count into
    # the table partners_rawtrans_daily
    #Created on 14.Mar.06 by SMI
    //------------------------------------------------------------------------------------
    function InsertRawTrans_daily($programid, $aid,$mid, $linkid, $today)
    {
                $daily_impression        = 1;
                $sql           = "SELECT * FROM partners_rawtrans_daily";
                $sql_where = "  WHERE  transdaily_affiliateid='$aid' AND transdaily_programid='$programid'
                              AND  transdaily_merchantid='$mid' AND transdaily_date ='$today'
                              AND transdaily_linkid = '$linkid'";
                            $res        = mysqli_query($con,$sql.$sql_where); // echo $sql.$sql_where ;
                if(mysqli_num_rows($res)>0)
                {
                    #get the existing impression count
                    $row        = mysqli_fetch_object($res);
                    $daily_impression += $row->{transdaily_impression};
                    #update
                    $sql         = "UPDATE partners_rawtrans_daily SET ";
                    $sql.= " transdaily_impression = '$daily_impression' ".$sql_where;
                }
                else
                {
                        #insert record
                    $sql = "INSERT INTO `partners_rawtrans_daily` SET
                            transdaily_affiliateid='$aid' , transdaily_programid='$programid',
                            transdaily_merchantid='$mid' , transdaily_date ='$today' ,
                            transdaily_linkid = '$linkid' ,transdaily_impression = '$daily_impression' ";

                }
               // echo '<br>sql='.$sql  ;exit;
                $ret =@mysqli_query($con,$sql) ;

    }// end function InsertRawTrans_daily
	
	
        /**************************************************************************************
        Created By         : SMA
        Created On         : 16-JUNE-2006
           Function to insert impression Records based on the program, merchant, affiliate,
            link, subid, and date of the impression.  If the record already exists then the
                count of the fielda imp_count and imp_pending is updated.   Else a new record is
                inserted for the details by setting the count of the fielda imp_count and
                imp_pending  to 1
        **************************************************************************************/
        function InsertDailyImpression($programid, $aid,$mid, $linkid, $subid, $today)
        {
                $daily_impr_count         = 1;
                $daily_pending_impr = 1;
                $sql = "SELECT * FROM partners_impression_daily WHERE  ".
                " imp_programid                 = '".$programid."' AND ".
                " imp_merchantid                = '".$mid."' AND ".
                " imp_affiliateid               = '".$aid."' AND ".
                " imp_linkid                    = '".$linkid."' AND ".
                " imp_date                      = '".$today."' AND ".
                " imp_subid                     = '".$subid."'  ";

                $res = mysqli_query($con,$sql);
                if(mysqli_num_rows($res) > 0)
                {
                        //updating coun tfor existing daily impression
                        $row = mysqli_fetch_object($res);
                        $impr_daily_id                = $row->imp_id;
                        //Increments daily count and pending count by 1
                        $daily_impr_count         += $row->imp_count;
                        $daily_pending_impr        += $row->imp_pending ;

                        $sql_count        = "UPDATE partners_impression_daily    SET ".
                        " imp_count       ='".$daily_impr_count."', ".
                        " imp_pending     ='".$daily_pending_impr."' WHERE ".
                        " imp_id          ='".$impr_daily_id."'";
                }
                else
                {
                        //inserting new record for daily impression
                        $sql_count = "INSERT INTO partners_impression_daily SET ".
                        " imp_programid                 = '".$programid."' , ".
                        " imp_merchantid                = '".$mid."' , ".
                        " imp_affiliateid               = '".$aid."' , ".
                        " imp_linkid                    = '".$linkid."' , ".
                        " imp_date                      = '".$today."' , ".
                        " imp_subid                     = '".$subid."' , ".
                        " imp_count                     ='".$daily_impr_count."', ".
                        " imp_pending                   ='".$daily_pending_impr."'  ";

                }
                $res_count = @mysqli_query($con,$sql_count);

        }
        // end of function InsertDailyImpression
	
?>