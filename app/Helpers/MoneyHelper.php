<?php
namespace App\Helpers;

class MoneyHelper
{
    /**
     * @param string $currency
     * @param string $value
     * @return string
     */
    static function getMoney(string $currency = MASTER_CURRENCY_SYMBOL, ?string $value): string
    {
        $result = '';
        if(!empty($value))
        {
            if($currency == MASTER_CURRENCY_SYMBOL)
            {
                $result = number_format($value, MASTER_CURRENCY_DECIMALS, MASTER_CURRENCY_DECIMAL_SEPERATOR, MASTER_CURRENCY_THOUSANDS_SEPERATOR).MASTER_CURRENCY_PREFIX;
            }
        }
        return $result;
    }

    /**
     * @param string $symbol
     * @param string $value
     * @return string
     */
    static function getQuantity(string $symbol = '', ?string $value): string
    {
        $result = '';
        if(!empty($value))
        {
           $result = number_format($value, 0, MASTER_CURRENCY_DECIMAL_SEPERATOR, MASTER_CURRENCY_THOUSANDS_SEPERATOR); 
        }
        return $result;
    }
}
