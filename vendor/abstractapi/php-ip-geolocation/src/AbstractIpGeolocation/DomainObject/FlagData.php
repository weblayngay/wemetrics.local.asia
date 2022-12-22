<?php

namespace Abstractapi\IpGeolocation\DomainObject;

class FlagData
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
     * Country's flag as an emoji.
     *
     * @var string
     */
    public $emoji;

    /**
     *Country's flag in unicode.
     *
     * @var string
     */
    public $unicode;

    /**
     * Link to a hosted version of the country's flag in PNG format.
     *
     * @var string
     */
    public $png;

    /**
     * Link to a hosted version of the country's flag in SVG format.
     *
     * @var string
     */
    public $svg;
}
