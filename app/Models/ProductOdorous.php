<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductOdorous extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_ODOROUS_TBL;
    protected $primaryKey = 'podo_id';
    const CREATED_AT = 'podo_created_at';
    const UPDATED_AT = 'podo_updated_at';

    protected $fillable = [
        'podo_name',
        'podo_status',
        'pcolor_is_delete',
        'pcolor_created_at',
        'pcolor_updated_at'
    ];

    const ALIAS = [
        'podo_id'             => 'id',
        'podo_name'           => 'name',
        'podo_status'         => 'status',
        'podo_is_delete'      => 'isDelete',
        'podo_created_at'     => 'createdAt',
        'podo_updated_at'     => 'updatedAt'
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
        return $query->where('podo_is_delete', 'no');
    }
}
