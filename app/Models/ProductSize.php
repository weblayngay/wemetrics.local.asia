<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductSize extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_SIZE_TBL;
    protected $primaryKey = 'psize_id';
    const CREATED_AT = 'psize_created_at';
    const UPDATED_AT = 'psize_updated_at';

    protected $fillable = [
        'psize_id',
        'psize_code',
        'psize_value',
        'psize_status',
        'psize_is_delete',
        'psize_created_at',
        'psize_updated_at'
    ];

    const ALIAS = [
        'psize_id'             => 'id',
        'psize_code'           => 'code',
        'psize_value'          => 'value',
        'psize_status'         => 'status',
        'psize_is_delete'      => 'isDelete',
        'psize_created_at'     => 'createdAt',
        'psize_updated_at'     => 'updatedAt',
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
        return $query->where('psize_is_delete', 'no');
    }
}
