<?php

namespace Abstractapi\IpGeolocation\DomainObject;

use Abstractapi\DomainObject\FlagData;
use Abstractapi\DomainObject\CurrencyData;
use Abstractapi\DomainObject\SecurityData;
use Abstractapi\DomainObject\TimezoneData;
use Abstractapi\DomainObject\ConnectionData;

class IpGeolocationData
{
    
    /**
     * Will map succes request result to PhoneValidationData
     * 
     * @param array $succesResult 
     */
    public function __construct(array $succesResult = [])
    {
        foreach ($succesResult as $key => $val) {
            if (property_exists(__CLASS__, $key)) {
                if (!is_array($val)) {
                    $this->$key = $val;
                } else {
                    $class = __NAMESPACE__ . "\\" . ucfirst($key) . "Data";
                    $this->$key = new $class($val);
                }
            }
        }
    }

    /**
     * The requested IP address.
     * 
     * @var string
     */
    public $ip_address;

    /**
     * City's name.
     * 
     * @var string
     */
    public $city;

    /**
     * City's geoname ID.
     * 
     * @var int
     */
    public $city_geoname_id;

    /**
     * State or province in which the the city is located.
     *
     * @var string
     */
    public $region;

    /**
     * State or province's ISO 3166-2 code.
     *
     * @var string
     */
    public $region_iso_code;

    /**
     * State or province's geoname ID.
     *
     * @var int
     */
    public $region_geoname_id;

    /**
     * ZIP or postal code.
     * 
     * @var string
     */
    public $postal_code;

    /**
     * Country's name.
     *
     * @var string
     */
    public $country;

    /**
     * Country's ISO 3166-1 alpha-2 code.
     *
     * @var string
     */
    public $country_code;

    /**
     * Country's geoname ID.
     *
     * @var int
     */
    public $country_geoname_id;

    /**
     * True if the country is in the EU, false if it is not.
     *
     * @var boolean
     */
    public $country_is_eu;

    /**
     * Continent's name.
     *
     * @var string
     */
    public $continent;

    /**
     * 2 letter continent code: AF, AS, EU, NA, OC, SA, AN
     *
     * @var string
     */
    public $continent_code;

    /**
     * Continent's geoname ID.
     *
     * @var int
     */
    public $continent_geoname_id;

    /**
     * Decimal of the longitude.
     *
     * @var double
     */
    public $longitude;

    /**
     * Decimal of the latitude.
     *
     * @var double
     */
    public $latitude;

    /**
     * 
     * @var SecurityData
     */
    public $security;

    /**
     * 
     * @var TimezoneData
     */
    public $timezone;

    /**
     * 
     * @var FlagData
     */
    public $flag;

    /**
     * 
     * @var CurrencyData
     */
    public $currency;

    /**
     * 
     * @var ConnectionData
     */
    public $connection;
}
