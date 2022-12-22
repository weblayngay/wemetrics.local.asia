<?php

require_once("../src/AbstractIpGeolocation/autoload.php");

use Abstractapi\IpGeolocation\AbstractIpGeolocation;
use Abstractapi\IpGeolocation\Common\Exception\AbstractHttpErrorException;

AbstractIpGeolocation::configure($api_key = "YOUR_API_KEY");

try
{
    $info = AbstractIpGeolocation::look_up();
}
catch (AbstractHttpErrorException $e)
{
    echo "Message:          ". $e->getMessage().     "; <br>";
    echo "Code:             ". $e->code.             "; <br>";
    echo "HttpStatusCode:   ". $e->http_code. "; <br>";
    echo "Details:          ";
    print_r($e->details);

    echo "<pre>";
    print_r(AbstractIpGeolocation::getLastResponse());
    echo "</pre>";

}
catch (InvalidArgumentException $e)
{
    // Handle somehow
}
