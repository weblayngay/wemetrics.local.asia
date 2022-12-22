<?php
namespace App\Helpers;

class TranslateHelper
{
    /**
     * @param string $format
     * @param string $value
     * @return array
     */
    static function getTranslate(string $format = 'vi', string $col = '', string $value = ''): string
    {
        $result = '';
        if($format == 'vi')
        {
            if($col == 'status')
            {
                if($value == 'activated')
                {
                    $result = 'bật';
                } elseif($value == 'inactive') {
                    $result = 'tắt';
                } elseif($value == 'approved') {
                    $result = 'duyệt';
                } elseif($value == 'unapproved') {
                    $result = 'không duyệt';
                } else {
                    $result = '';
                }
            }
            elseif($col == 'type')
            {
                if($value == 'percent')
                {
                    $result = 'phần trăm';
                } elseif($value == 'value'){
                    $result = 'giá trị';
                }
                else {
                    $result = '';
                }
            }
            elseif($col == 'isUsed')
            {
                if($value == 'yes')
                {
                    $result = 'đã dùng';
                } elseif($value == 'no') {
                    $result = 'chưa dùng';
                } else {
                    $result = '';
                }
            }
            elseif($col == 'isAssigned')
            {
                if($value == 'yes')
                {
                    $result = 'đã cấp';
                } elseif($value == 'no') {
                    $result = 'chưa cấp';
                } else {
                    $result = '';
                }
            }
            elseif($col == 'type')
            {
                if($value == 'product')
                {
                    $result = 'sản phẩm';
                } elseif($value == 'post')  {
                    $result = 'bài viết';
                } elseif($value == 'news') {
                    $result = 'tin tức';
                } else {
                    $result = '';
                }
            }
            elseif($col == 'gender')
            {
                if($value == 'male')
                {
                    $result = 'nam';
                } elseif($value == 'no') {
                    $result = 'nữ';
                } else {
                    $result = '';
                }
            }            
        }
        return $result;
    }
}
