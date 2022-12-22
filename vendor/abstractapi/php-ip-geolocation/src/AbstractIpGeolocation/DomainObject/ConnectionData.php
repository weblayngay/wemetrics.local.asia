<?php

namespace Abstractapi\IpGeolocation\DomainObject;

class ConnectionData
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
     * Autonomous System number
     *
     * @var int
     */
    public $autonomous_system_number;

    /**
     * Autonomous System Organization name.
     *
     * @var string
     */
    public $autonomous_system_organization;

    /**
     * Type of network connection: Dialup, Cable/DSL, Cellular, Corporate
     *
     * @var string
     */
    public $connection_type;

    /**
     * Internet Service Provider (ISP) name.
     *
     * @var string
     */
    public $isp_name;

    /**
     * Organization name.
     *
     * @var string
     */
    public $organization_name;
}
