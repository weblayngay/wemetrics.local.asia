<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductColor extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_COLOR_TBL;
    protected $primaryKey = 'pcolor_id';
    const CREATED_AT = 'pcolor_created_at';
    const UPDATED_AT = 'pcolor_created_at';

    protected $fillable = [
        'pcolor_id',
        'pcolor_code',
        'pcolor_hex',
        'pcolor_status',
        'pcolor_is_delete',
        'pcolor_created_at',
        'pcolor_updated_at'
    ];

    const ALIAS = [
        'pcolor_id'             => 'id',
        'pcolor_code'           => 'code',
        'pcolor_hex'            => 'hex',
        'pcolor_status'         => 'status',
        'pcolor_is_delete'      => 'isDelete',
        'pcolor_created_at'     => 'createdAt',
        'pcolor_updated_at'     => 'updatedAt',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function parentQuery(){
        return parent::query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query()
    {
        return parent::query()->notDeleted();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('pcolor_is_delete', 'no');
    }
}
