<?php
$indicesServer = array('PHP_SELF',
'REQUEST_TIME',
'HTTP_REFERER',
'HTTP_USER_AGENT',
'HTTPS',
'REMOTE_ADDR',
'REMOTE_HOST',
'REMOTE_PORT',
'REMOTE_USER',
'REDIRECT_REMOTE_USER',
'PHP_AUTH_DIGEST',
'PHP_AUTH_USER',
'PHP_AUTH_PW',
'AUTH_TYPE',
'PATH_INFO',
'ORIG_PATH_INFO') ;

$date = date('l jS \of F Y h:i:s A');

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
$location = $details->city;
$messageIN = '
<b>YOUR LOCATION IS '.$location.' GOTCHA!!!!</b><BR>
NOW START TO PANIC<p> <b>SCUMBAGS like you will always get caught!!!</b><p>
Your IP is: '.$_SERVER['REMOTE_ADDR'].'<br>
The time you accessed this: '.$date.'<br>
<br>
<br>
<br>
<br>
<br>
Heres some more info ive got let the games begin!!
';
echo $messageIN ;
$to      = 'andrew.reeve@searlco.com';
$subject = 'gotcha V2';
$message = $messageIN;
$headers = 'From: admin@avaz.co.uk' . "\r\n" .
    'Reply-To: admin@avaz.co.uk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <admin@avaz.co.uk>' . "\r\n";
$headers .= 'Cc: madmin@avaz.co.uk' . "\r\n";

mail($to,$subject,$message,$headers);


//echo $details->city;
echo '<table cellpadding="10">' ;
foreach ($indicesServer as $arg) {
    if (isset($_SERVER[$arg])) {
        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
    }
    else {
        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
    }
}
echo '</table>' ; 
?>