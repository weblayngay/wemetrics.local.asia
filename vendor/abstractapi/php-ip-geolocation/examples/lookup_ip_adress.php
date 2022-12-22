<?php

require_once("../src/AbstractIpGeolocation/autoload.php");

use Abstractapi\IpGeolocation\AbstractIpGeolocation;

AbstractIpGeolocation::configure($api_key = "YOUR_API_KEY");

$info = AbstractIpGeolocation::look_up();

echo "<pre>";
print_r($info);
echo "</pre>";

echo "city: " ; echo $info->city;
echo "</br>";
echo "security.is_vpn: "; echo var_export($info->security->is_vpn);
