<?php ob_start();
/************************************************************************/
/*     PROGRAMMER     :  SMA                                            */
/*     SCRIPT NAME    :  text.php                                                      */
/*     CREATED ON     :  16/JUNE/2006                                   */
/*                                                                      */

/*      View  Text Ad                                                   */
/************************************************************************/


        include_once '../includes/session.php';
    include_once '../includes/constants.php';
    include_once '../includes/functions.php';
        include('../includes/function1.php');

         $partners=new partners;
    $partners->connection($host,$user,$pass,$db);

        $id = intval($_REQUEST['id']);

        //object creation
        $textadobj   =  new text_display();


                 echo $textadobj->showRotatorTextAd($id,$track_site_url);

?>