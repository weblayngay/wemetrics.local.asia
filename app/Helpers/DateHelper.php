<?php
namespace App\Helpers;
use Carbon\Carbon;

class DateHelper
{
    /**
     * @param string $format
     * @param string $value
     * @return array
     */
    static function getDate(string $format = 'd/m/Y', string $value = null): string
    {
        $result = '';
        if(!empty($value))
        {
            $result = Carbon::parse($value)->format($format);
        }
        return $result;
    }
}
