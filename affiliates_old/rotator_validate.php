<?php		ob_start();

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
    include_once '../includes/allstripslashes.php';

    $partners=new partners;
    $partners->connection($host,$user,$pass,$db);
	include_once 'language_include.php';

	 $cmd           = trim($_POST['action_val']);
     $details		= trim($_GET['element']);
     $status		= trim($_GET['status']);

    // echo $status;


     $cat	= trim($_GET['element']);   //////////// when single link clicks.
     $catid	= intval(trim($_GET['catid']));





    if (empty($cmd))
         $cmd      =trim($_GET['sub']);
        // echo $cmd;
         $count1        =count($elements);
         $i=0;

          switch($cmd)
               {

                  case 'Join selected programs':
                  		   //	echo $count1;
                      for($i=0;$i<$count1;$i++)
                        {

                                        $temp		=$elements[$i];

                                        //echo $temp."\t";

             							$arr=explode("~",$temp);
            							$cat=$arr[0];
            							$catid=$arr[1];


                                        /////////// checking alredy inserted

                               $sql="select * from partners_rotator where rotator_catid = '$catid' AND rotator_affilid='$AFFILIATEID'";

                               $res=mysqli_query($con,$sql);
                              // echo $sql;
                               if(mysqli_num_rows($res)==0)
                               {
                                      $sql1="SELECT  merchant_id FROM partners_merchant WHERE merchant_status =  'approved' and  merchant_category='$cat'";
                                     $res=mysqli_query($con,$sql1);
                                   // $sql1;
	                                         if(mysqli_num_rows($res)>0)
	                                         {

                                                   $sql="INSERT INTO partners_rotator ( rotator_catid , rotator_affilid )
                                                        VALUES ('$catid','$AFFILIATEID')";

                                                	mysqli_query($con,$sql);
                                               		//echo mysql_error();
                                                    $rid=mysql_insert_id();



	                                                     while($row=mysqli_fetch_object($res))
	                                                     {
                                                           	  		$merid=$row->merchant_id;
	                                                                    //echo $merid;




	                                                                 $sql="insert into partners_rotatorsta (rotatorsta_roid , rotatorsta_merid)
	                                                                        values ('$rid','$merid')";

	                                                                  mysqli_query($con,$sql);
	                                                                 // echo mysql_error();



	                                                     }
	                                             	header("location:index.php?Act=rotator?status=$status");







	                                         } ////if closing merchant is on this catgory


                                } ////////// closing of if no registered before
                                     else
                                     {
                                       // echo "you r registred on this cat";
                                     }
                                     //echo mysql_error();

                        }    /////////// for loop closing

                        //$msg="There is no Merchents on this Category ....Try after some time";
				     		header("location:index.php?Act=rotator&amp;status=$status&msg=$msg");



                  break;

                   ///////////

                    case 'Unjoin selected programs':



                            //echo $count1;
	                              for($i=0;$i<$count1;$i++)
	                                {

	                                                $temp       =$elements[$i];

	                                                //echo $temp."\t";

	                                                $arr=explode("~",$temp);
	                                                $cat=$arr[0];
	                                                $catid=$arr[1];


                                                    $sql="select rotator_id from partners_rotator where rotator_catid='$catid' and rotator_affilid='$AFFILIATEID'";

                                                    $res=mysqli_query($con,$sql);
                                     	//echo $sql;
                               							if(mysqli_num_rows($res)>0)
                                                          {

                                                                    //////////   geting rotator id befor delete

                                                                  $row=mysqli_fetch_object($res);
                                                                  $rid=$row->rotator_id;

                                                                  //echo $rid;

                                                                  $sql="delete from partners_rotatorsta where rotatorsta_roid='$rid'";
                                                                  $res=mysqli_query($con,$sql);
                                                                  //echo $sql."\n";

                                                            }
                                                         $sql1="delete from partners_rotator where rotator_catid='$catid' and rotator_affilid='$AFFILIATEID'";
                                                         mysqli_query($con,$sql1);


                                                         //echo mysql_error();
                                                         //echo $sql1."\n";


	                                 }/// closing of for

							header("location:index.php?Act=rotator&amp;status=$status");
                            break;

                   //////////////
                   default :

                                    // echo $cat."entering";

                                     $sql1="SELECT  * FROM partners_merchant WHERE merchant_status =  'approved' and  merchant_category='$cat'";
                           			 $res=mysqli_query($con,$sql1);
                                    // echo mysql_error();
                                     if(mysqli_num_rows($res)>0)
                                     {
                                              $sql="INSERT INTO partners_rotator ( rotator_catid , rotator_affilid )
                                                        VALUES ('$catid','$AFFILIATEID')";
                                                mysqli_query($con,$sql);
                                                $rid=mysql_insert_id();

                                                echo mysql_error();

	                                         while($row=mysqli_fetch_object($res))
	                                         {
                                       	       $merid=$row->merchant_id;
	                                            //echo $merid;
                                              $sql="insert into partners_rotatorsta (rotatorsta_roid , rotatorsta_merid)
                                              		values ('$rid','$merid')";

                                                mysqli_query($con,$sql);
                                               // echo mysql_error();
                                             }
                                            header("location:index.php?Act=rotator");
                                     }
				     else
				     {
				     		$msg=$lang_nomerchant;
				     		header("location:index.php?Act=rotator&msg=$msg");
				     }
                }/// closing of switch

?>