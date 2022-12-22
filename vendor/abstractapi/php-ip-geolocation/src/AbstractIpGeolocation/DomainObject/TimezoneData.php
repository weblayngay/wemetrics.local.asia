<?php

namespace Abstractapi\IpGeolocation\DomainObject;

class TimezoneData
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
     * Timezone's name from the IANA Time Zone Database.
     *
     * @var string
     */
    public $name;

    /**
     * Timezone's abbreviation, also from the IANA Time Zone Database.
     *
     * @var string
     */
    public $abbreviation;

    /**
     * Timezone's offset from Greenwich Mean Time (GMT).
     *
     * @var int
     */
    public $gmt_offset;

    /**
     * Current time in the local time zone.
     *
     * @var string
     */
    public $current_time;

    /**
     * True if the location is currently in Daylight Savings Time (DST).
     *
     * @var bool
     */
    public $is_dst; //boolean
}
