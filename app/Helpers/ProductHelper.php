<?php
namespace App\Helpers;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ProductHelper
{

    /**
     * Lấy thông tin product được lưu trong session so sánh với product trong database.
     * @param Collection $productsOnDB
     * @return array
     */
    public static function compareProductsInSessionsWithProductsOnDb(Collection $productsOnDB): array
    {
        if (count($productsOnDB) < 1) {
            session()->put('total_price', 0);
            session()->put('total', 0);
            session()->put('cart', []);
            return ['products' => [], 'total_price' => 0, 'total' => 0];
        }

        $productsOnSession = session()->get('cart');
        $productsOnDB = ArrayHelper::valueAsKey($productsOnDB->toArray(), 'product_id');
        $price = 0;
        $quantity = 0;
        foreach ($productsOnSession as $key => $item) {
            if (isset($productsOnDB[$key])) {
                $itemProductOnDb = $productsOnDB[$key];
                $productsOnSession[$key]['name'] = $itemProductOnDb['product_name'];
                $productsOnSession[$key]['slug'] = Str::slug($itemProductOnDb['product_name']);
                $productsOnSession[$key]['price'] = $itemProductOnDb['price'];
                $productsOnSession[$key]['sub_total_price'] = $item['quantity'] * $itemProductOnDb['price'];
                $price += $productsOnSession[$key]['sub_total_price'];
                $quantity += $item['quantity'];
            }else{
                unset($productsOnSession[$key]);
            }
        }

        session()->put('cart', $productsOnSession);
        session()->put('total_price', $price);
        session()->put('total', $price);
        return [
            'products'      => $productsOnSession,
            'total_price'   => $price,
            'total'         => $price,
            'quantity'      => $quantity,
        ];
    }


    /**
     * @param $number
     * @return string
     */
    public static function formatMoney($number): string
    {
        return number_format($number, 0, '.', ',');
    }

}
