<?php

namespace Abstractapi\IpGeolocation;

use Abstractapi\IpGeolocation\Common\AbstractEndpointBase;
use Abstractapi\IpGeolocation\DomainObject\IpGeolocationData;
use Abstractapi\IpGeolocation\Common\Extension\StringExtension;
use Abstractapi\IpGeolocation\Common\DomainObject\HttpErrorDetail;
use Abstractapi\IpGeolocation\Common\Exception\InvalidArgumentException;
use Abstractapi\IpGeolocation\Common\Exception\AbstractHttpErrorException;

/** 
 * Abstract's IP Geolocation  API client.
 * The IP Geolocation allows you to look up the location, timezone, 
 * country details, and more of an IPv4 or IPv6 address
 */
class AbstractIpGeolocation extends AbstractEndpointBase
{
    /** 
     * @var string api_endpoint  Abstract's IP Geolocation  API.
     */
    const API_ENDPOINT = "https://ipgeolocation.abstractapi.com/v1";

    /**
     * Configure IP Geolocation  API.
     * 
     * @param string $api_key This is your private API key, specific to the IP Geolocation  API.
     */
    public static function configure($api_key)
    {
        parent::configureEndpoint(self::API_ENDPOINT, $api_key);
    }

    /**
     * Make an HTTP GET request to Abstract's IP Geolocation  API,
     * to look up the location, timezone, country details, and more 
     * of an IPv4 or IPv6 address.
     * 
     * @param   string  $ip_address         The Ip address to look up.
     * @return  IpGeolocationData|null      Returns filled IpGeolocationData or when no location data for the submitted IP returns null.
     * 
     * @throws  InvalidArgumentException
     * @throws  AbstractHttpErrorException
     */
    public static function look_up($ip_address = null)
    {
        // Will make a GET request for ip address look up.
        $result = parent::client()->get(
            '',
            [
                'ip_address' => $ip_address
            ]
        );

        // Get the status code of the last request.
        $http_status_code = parent::client()->getLastResponse()['headers']['http_code'];

        // Their is no location data for the submitted IP.
        if ($http_status_code === 204 ) {
            return null;
        }   

        // Will check the status of the request response, 
        // if successful returns a filled object.
        if (parent::client()->success()) {
            return new IpGeolocationData($result);
        }       

        // When there is no network or the wrong endpoint address is set.
        if ($http_status_code === 0) {
            throw new \Exception("Check network connection.");
        }

        throw new AbstractHttpErrorException(
            $result['error']['message'],
            $result['error']['code'],
            $http_status_code,
            $result['error']['details']
        );
    }
}
