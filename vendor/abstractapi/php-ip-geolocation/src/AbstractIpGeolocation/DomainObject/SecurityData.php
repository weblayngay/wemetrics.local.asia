<?php

namespace Abstractapi\IpGeolocation\DomainObject;

class SecurityData
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
     * Whether the IP address is using from a VPN or using a proxy
     *
     * @var bool
     */
    public $is_vpn;
}
