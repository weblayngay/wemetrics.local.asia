<?php

namespace Abstractapi\IpGeolocation\DomainObject;

class CurrencyData
{

    /**
     *   
     * @param array $input 
     */
    public function __construct(array $input = [])
    {
        foreach ($input as $key => $val) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $val;
            }
        }
    }

    /**
     * The currency's name.
     *
     * @var string
     */
    public $currency_name;

    /**
     * The currency's code in ISO 4217 format.
     *
     * @var string
     */
    public $currency_code;
}
