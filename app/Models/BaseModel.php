<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BaseModel extends Model
{
    const ALIAS = []; //To convert data key and format

    /**
     * @param $data
     * @return array
     */
    public function revertAlias($data)
    {
        $return = [];
        foreach (static::ALIAS as $field => $alias) {
            if (($value = Arr::get($data, $alias)) !== null) {
                Arr::set($return, $field, strip_tags($value));
            }
        }

        return $return;
    }


    /**
     * @return Builder
     */
    public static function parentQuery()
    {
        return static::query();
    }


    /**
     * @param array $ids
     * @return string
     */
    public function getIds(array $ids)
    {
        return ',' . implode(',', $ids) . ',';
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function escapeStringLike($string)
    {
        $search = array('%', '_');
        $replace   = array('\%', '\_');
        $string = str_replace($search, $replace, $string);
        $string = "'%".$string."%'";
        return $string;
    }
}
