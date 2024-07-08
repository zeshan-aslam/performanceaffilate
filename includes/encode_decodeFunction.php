<?php

function MultipleTimeEncode($id)
 {                                                       
    $encrpyt_id = $id;
                                                
    for($i=0;$i<5;$i++)
    {
       $encrpyt_id = base64_encode($encrpyt_id);
    }
      return $encrpyt_id;
 }
function MultipleTimeDecode($id)
{                                                       
   $encrpyt_id = $id;
                                               
   for($i=0;$i<5;$i++)
   {
      $encrpyt_id = base64_decode($encrpyt_id);
   }
     return $encrpyt_id;
}



?>