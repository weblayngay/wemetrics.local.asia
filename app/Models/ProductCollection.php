<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductCollection extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_COLLECTION_TBL;
    protected $primaryKey = 'pcollection_id';
    const CREATED_AT = 'pcollection_created_at';
    const UPDATED_AT = 'pcollection_updated_at';

    protected $fillable = [
        'pcollection_name',
        'pcollection_status',
        'pcollection_is_delete',
        'pcollection_created_at',
        'pcollection_updated_at'
    ];

    const ALIAS = [
        'pcollection_id'             => 'id',
        'pcollection_name'           => 'name',
        'pcollection_status'         => 'status',
        'pcollection_is_delete'      => 'isDelete',
        'pcollection_created_at'     => 'createdAt',
        'pcollection_updated_at'     => 'updatedAt'
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
        return $query->where('pcollection_is_delete', 'no');
    }
}
