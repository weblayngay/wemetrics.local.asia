<?php
namespace App\Helpers;
use \RecursiveIteratorIterator;
use \RecursiveArrayIterator;

class JsonHelper
{
    /**
    * @param none
    */
    static function getPhpInput(): string
    {
        $result = file_get_contents("php://input");
        return $result;
    }

    /**
    * @param object
    */
    static function getIteratorFromString($data): object
    {
        $result = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($data, TRUE)),RecursiveIteratorIterator::SELF_FIRST);
        return $result;
    }

    /**
    * @param object
    */
    static function getObjectFromArray($data): object
    {
        $result = new \stdClass();
        $data = json_encode($data, true);
        $result = json_decode($data);
        return $result;
    }

    /**
    * @param object
    */
    static function getArrayFromIterator($data): array
    {
        $result = iterator_to_array($data);
        return $result;
    }

}
