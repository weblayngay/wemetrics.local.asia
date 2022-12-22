<?php
namespace App\Helpers;

class NestedSetModelHelper
{

    /**
     * @param int $level
     * @return string
     */
    public static function notationByLevel(int $level): string
    {
        return str_repeat('|---> ', $level);
    }
}
