<?php
namespace App\Helpers;
class RandomHelper
{

    /**
     * @param int $count
     * @return string
     */
    public static function character($count = 6){
        $randomChar = "";
        $charBase = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 0 1 2 3 4 5 6 7 8 9");

        for ($i = 0; $i < $count; $i++) {
            $randomChar = $randomChar . $charBase[rand(9, count($charBase) - 1)];
        }

        $length = strlen($randomChar);

        if ($length == $count) return $randomChar;
        else return self::character($count);
    }

    /**
     * @return int
     */
    public static function number(){
        mt_srand((double)microtime() * 1000000);
        $randomNumber = mt_rand(100000, 999999);

        return $randomNumber;
    }

}
