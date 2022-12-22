<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Config
 * @property int conf_id
 * @property string conf_name
 * @property string conf_key
 * @property string conf_value
 * @property string conf_status
 * @property string conf_description
 * @method isActivated
 * @package App\Models
 */
class Config extends Model
{
    use HasFactory;

    protected $table = CONFIG_TBL;
    protected $primaryKey = 'conf_id';
    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conf_status',
        'conf_value',
        'conf_key',
        'conf_name',
        'conf_description',
    ];

    /**
     * @return Builder
     */
    public static function parentQuery(): Builder
    {
        return parent::query();
    }

    /**
     * @return Builder
     */
    public static function query(): Builder
    {
        return parent::query()->isActivated();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('conf_status', 'activated');
    }


    /**
     * @param $configKey
     * @param string $default
     * @return HigherOrderBuilderProxy|mixed|string
     */
    public static function getConfig($configKey, $default = '')
    {
        $configs = Cache::get('config_model');
        if (isset($configs[$configKey])) {
            return $configs[$configKey] ?? $default;
        }

        $config = self::query()->select('conf_value')->where(['conf_key' => $configKey])->first();
        if ($config) {
            return $config->conf_value ?? $default;
        }else{
            return $default;
        }

    }
}
