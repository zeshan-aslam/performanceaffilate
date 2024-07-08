<?php     

   $ContentType        = "application/rtf";
   $filename           = "contactlist.rtf";

   header ("Content-Type: $ContentType");
   header ("Content-Disposition: attachment; filename=$filename");

  $filename                 = "contactlist.rtf";
  $fp                       = fopen($filename,'r');
  $contents                 = fread ($fp, filesize ($filename));
  fclose($fp);

  echo  $contents;
?>
