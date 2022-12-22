<?php
namespace App\Helpers;


class OrderHelper
{
    /**
     * @param $orderId
     * @return string
     */
    public static function getOrderName($orderId): string
    {
        return 'ORD' . $orderId;
    }

}
