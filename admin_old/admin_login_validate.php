<?php	

   /***************************************************************************** //
     PROGRAM DESCRIPTION :  PROGRAM FOR ADMIN LOGIN VALIDATION.
     VARIABLES           :  Err           = Error message
                            login         = login name
                            password      = login name

 //*****************************************************************************/

    include_once '../includes/db-connect.php';                            
    include_once '../includes/session.php';
    include '../includes/constants.php';
    include '../includes/functions.php';
    include_once '../includes/allstripslashes.php';
    $partners = new partners;
    $partners->connection($host,$user,$pass,$db);

    /*********************variables********************************************/
    $login		= (trim($_POST['login']));         //  login name
    $passwd		= (trim($_POST['passwd']));        //  login passord
    /**************************************************************************/

	//Validating UserName and Password
	$valid = 1;
	if($login == "") $valid = 0;
	if($passwd == "") $valid = 0;
	if($valid == 0)
	{
			header("Location:index.php?Err=ad1002");
            exit;		
	}

    /********************checking login***************************************/

        //$sql        ="SELECT * FROM partners_adminusers where adminusers_login='$login' AND adminusers_password='$passwd'";
		$sql        ="SELECT * FROM partners_adminusers where adminusers_login='".addslashes($login)."' AND adminusers_password='".addslashes($passwd)."'";

        $result        =mysqli_query($con, $sql);
        echo mysqli_error(); 
        if(mysqli_num_rows($result))                              //login sussess ful
        {
            $row        	=	mysqli_fetch_object($result);
			$adminUserId 	= $row->adminusers_id;
			//Reads the last activity time and the ip address
            $sql = "SELECT `adminusers_ip` ,  UNIX_TIMESTAMP( now( ) ) - UNIX_TIMESTAMP( adminusers_lastLogin )";
	        $sql .= "FROM `partners_adminusers` WHERE adminusers_id='$adminUserId' ";
            $ret1	= mysqli_query ($con, $sql);
            if(mysqli_num_rows($ret1)) list($ip,$timeDiff)	= mysqli_fetch_row ($ret1);
			$_SESSION['ADMINLASTLOGGEDIP'] = $ip;
            //Calculate the time difference

           /* $sql = 'SELECT UNIX_TIMESTAMP( now( ) ) - UNIX_TIMESTAMP( admin_lastLogin ) ';
            $sql .= 'FROM partners_admin';
            $ret1	= mysql_query ($sql);
            list($timeDiff)	= mysql_fetch_row($ret1); */
            $timeDiff	= intval($timeDiff);
            
			
			/*if($timeDiff<1800) {
	            header("Location:index.php?Err=ad1000");
	            exit;
            } */
			
			$_SESSION['ADMINUSERID']  = stripslashes($row->adminusers_id);
            $_SESSION['ADMIN']        =	stripslashes($row->adminusers_login);      //admin name
            $_SESSION['MAIL']         =	stripslashes($row->adminusers_email);      //admin email id
           // $_SESSION['MAILAMNT']     =	stripslashes($row->admin_mailamnt);   //admin mail amnt
           // $_SESSION['MAILHEADER']   =	stripslashes($row->admin_mailheader); //admin mail header
           // $_SESSION['MAILFOOTER']   =	stripslashes($row->admin_mailfooter); //admin mail footer
		   
		   	if($_SESSION['ADMINUSERID'] == '1') {
            	header("Location:index.php?Act=merchants&status=all");
			} else {
				header("Location:index.php?Act=welcome");
			}
            exit;
        }
        else                                                     //invalid login
            {
            //$Err ="Not Authorized!!";
            header("Location:index.php?Err=ad1001");
            exit;
            }
   /***************************************************************************/
?>