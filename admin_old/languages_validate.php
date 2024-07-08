<?php	ob_start();

	include_once '../includes/constants.php';
	include_once '../includes/functions.php';
	include_once '../includes/session.php';
	include_once '../includes/allstripslashes.php';
	
	$partners=new partners;
	$partners->connection($host,$user,$pass,$db);
	
	$mode		= $_GET['mode'];
	$id		=$_GET['id'];

    foreach ($_POST as $key => $value)//to stripslash all posted variables
            {
          $value=trim($value);
          $value=stripslashes($value);
          $$key=$value;

        }

        if($language=="" and $mode != "delete")
        {
         	Header("Location:index.php?Act=languages&mode=$mode&id=$id&msg=Blank value ");
            exit;
        }


         foreach ($_POST as $key => $value)//to stripslash all posted variables
            {
          $value=trim($value);
          $value=addslashes($value);
          $$key=$value;

        }
        if($mode=="add")

        {
			$sql	= " INSERT INTO partners_languages (languages_name , languages_status ) VALUES ('$language', '$status')";
			mysql_query($sql);
			echo mysql_error();
			Header("Location:index.php?Act=languages&mode=$mode&id=$id&msg=Language Added Successfully  ");
        }
        if($mode=="edit")
        {
            $sql	= " UPDATE partners_languages SET languages_name = '$language', languages_status = '$status' 
						WHERE languages_id = '$id' ";
            mysql_query($sql);
            echo mysql_error();
         	Header("Location:index.php?Act=languages&mode=add&msg=Language Updated Successfully ");
        }

         if($mode=="delete")
          {
              $sql		="DELETE FROM partners_languages WHERE languages_id = '$id'";
              $res		=mysql_query($sql);

              echo mysql_error();

              	Header("Location:index.php?Act=languages&mode=add&msg=Language Deleted Successfully  ");
          }

?>