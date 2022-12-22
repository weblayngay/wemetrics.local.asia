<?php
namespace App\Helpers;
use Illuminate\Support\Arr;

class ArrayHelper
{
    /**
     * @param array $array
     * @param string $keyOfArray
     * @return array
     */
    static function valueAsKey(array $array, string $keyOfArray): array
    {
        return array_combine(array_column($array, $keyOfArray), $array);
    }

    /**
     * @param $arrayValue
     * @param $arrayKey
     * @return array
     */
    static function arrayCombine($arrayValue, $arrayKey){
        $array = [];

        if(count($arrayValue) == count($arrayKey)){
            $array = array_combine($arrayKey, $arrayValue);
        }

        if(count($arrayValue) > count($arrayKey)){
            $number = count($arrayKey) - 1;
            if($number == 0){
                $arrayValueNew = array($arrayValue[0]);
            }else{
                $arrayValueNew = array_slice($arrayValue, $number);
            }

            $array = array_combine($arrayKey, $arrayValueNew);
        }

        if(count($arrayValue) < count($arrayKey)){
            $number = count($arrayValue) - 1;
            if($number == 0){
                $arrayKeyNew = array($arrayKey[0]);
            }else{
                $arrayKeyNew = array_slice($arrayKey, $number);
            }
            $array = array_combine($arrayKeyNew, $arrayValue);
        }
        return $array;
    }

    /**
     * @param $array
     * @return string
     */
    static function arraySplit($array)
    {
        $string = '';
        foreach($array as $key => $item)
        {
            $string = ','.$item;
        }
        $string = substr($string, 1);

        return $string;
    }

    /**
     * @param $array
     * @return $array
     */
    static function arraySort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } 
                else 
                {
                    $sortable_array[$k] = $v->$on;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            $i = 0;
            foreach ($sortable_array as $k => $v) {
                $new_array[$i] = $array[$k];
                $i += 1;
            }
        }

        return $new_array;
    }

    /**
     * Join all items using a string. The final items can use a separate glue string.
     *
     * @param  array  $collection
     * @return string
     */
    public static function convertToString($collection)
    {
        $str_json = json_encode($collection); //array to json string conversion
        $str_json = str_replace('[','',$str_json);
        $result = str_replace(']','',$str_json);
        return $result; // printing json string
    }

}
