<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class tsOrderStatus extends BaseModel
{
    use HasFactory;

    protected $table = TS_ORDER_STATUS;
    protected $primaryKey = 'id';
    const CREATED_AT = '';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status_name',
        'description',
        'enable',
        'ordering',
    ];

    const ALIAS = [
        'status_name' => 'status_name',
        'description' => 'description',
        'enable'      => 'enable',
        'ordering'    => 'ordering',
    ];

    /**
     * @return Builder
     */
    static function parentQuery(){
        return parent::query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query()
    {
        return parent::query();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsEnable($query)
    {
        return $query
        ->where('enable', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotEnable($query)
    {
        return $query
        ->where('enable', '0');
    }
}
