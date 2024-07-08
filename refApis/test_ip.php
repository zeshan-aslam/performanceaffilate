<?php
echo "Working Fine";
echo $contry=getIP('17.142.180.78');

echo $ip=getIP($_SERVER['REMOTE_ADDR']);

// echo ip_info("173.252.110.27", "Country"); // United States
// echo ip_info("173.252.110.27", "Country Code"); // US
// echo ip_info("173.252.110.27", "State"); // California
// echo ip_info("173.252.110.27", "City"); // Menlo Park
// echo ip_info("173.252.110.27", "Address"); // Menlo Park, California, United States

// print_r(ip_info("173.252.110.27", "Location")); // Array ( [city] => Menlo Park [state] => California [country] => United States [country_code] => US [continent] => North America [continent_code] => NA )

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

?>
