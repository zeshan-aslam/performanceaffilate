<?php
/***************************************************************************/
/*     PROGRAMMER     :  SMA                                               */
/*     SCRIPT NAME    :  thumbnail.php                                      */
/*     CREATED ON     :  02/JAN/2008                                       */
/*                                                                         */
/*               thumbnail                                                  */
/***************************************************************************/
		imageresize($_GET['image'],$_GET['height'],'',1);

        /*----------------------------------------------------------------
        Description   :- function to resize an image based on the height
        Programmer    :- SMA
        Last Modified :- 02/JAN/2008
        -------------------------------------------------------------------*/
        function imageresize($filename,$reheight,$dest,$flag=0,$convert=0)
        {
                 list($imwidth, $imheight,$imtype,$imstring)  = getimagesize($filename);
                 switch ($imtype)
                 {
                     case 1: $im = imagecreatefromgif ($filename); break ;
                     case 2: $im = imagecreatefromjpeg ($filename); break ;
                     case 3: $im = imagecreatefrompng ($filename); break ;
                 }
                 if ($imheight > $reheight)
                 {
                            $refact = $imheight / $reheight ;
                            $rewidth = intval (ceil($imwidth / $refact));

                            $im1 = imagecreatetruecolor ($rewidth, $reheight);
                            $bg  = imagecolorallocate($im1,255,255,255);
                            imagefilledrectangle($im1,0,0,$rewidth,$reheight,$bg);
                            imagecopyresampled ( $im1, $im, 0, 0, 0, 0, $rewidth, $reheight, $imwidth, $imheight );

                            if (!$flag)
                            {
                                  if($convert)
                                  {
                                        imagejpeg ($im1,$dest,100);
                                  }
                                  else
                                  {
                                    switch ($imtype)
                                    {
                                        case 1: imagegif ($im1,$dest);  break ;
                                        case 2: imagejpeg ($im1,$dest,100); break ;
                                        case 3: imagepng ($im1,$dest); break ;
                                    }
                                  }
                             }
                             else
                             {
                               header ("Content-type: image/png");
                               imagepng ($im1);
                               imagedestroy($im1);
                             }
                 }
                 elseif($imwidth > $reheight)
                 {
                            $rewidth1 = $reheight ;
                            $refact = $imwidth / $rewidth1 ;
                            $reheight1 = intval (ceil($imheight / $refact));

                            $im1 = imagecreatetruecolor ($rewidth1, $reheight1);
                            $bg  = imagecolorallocate($im1,255,255,255);
                            imagefilledrectangle($im1,0,0,$rewidth1,$reheight1,$bg);
                            imagecopyresampled ( $im1, $im, 0, 0, 0, 0, $rewidth1, $reheight1, $imwidth, $imheight );
                            if (!$flag)
                            {
                                  if($convert)
                                  {
                                        imagejpeg ($im1,$dest,100);
                                  }
                                  else
                                  {
                                    switch ($imtype)
                                    {
                                        case 1: imagegif ($im1,$dest);  break ;
                                        case 2: imagejpeg ($im1,$dest,100); break ;
                                        case 3: imagepng ($im1,$dest); break ;
                                    }
                                  }
                             }
                             else
                             {
                               header ("Content-type: image/png");
                               imagepng ($im1);
                               imagedestroy($im1);
                             }

                 }
                 else
                 {
                            if (!$flag)
                            {
                                  if($convert)
                                  {
                                        imagejpeg ($im,$dest,100);
                                  }
                                  else
                                  {
                                    switch ($imtype)
                                    {
                                        case 1: imagegif ($im,$dest);  break ;
                                        case 2: imagejpeg ($im,$dest,100); break ;
                                        case 3: imagepng ($im,$dest); break ;
                                    }
                                  }
                             }
                             else
                             {
                                     header ("Content-type: image/png");
                                     imagepng ($im);
                             }
                 }
        	imagedestroy($im);
        }


?>