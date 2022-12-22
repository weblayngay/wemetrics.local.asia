<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductNutritions extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_NUTRITIONS_TBL;
    protected $primaryKey = 'pnutri_id';
    const CREATED_AT = 'pnutri_created_at';
    const UPDATED_AT = 'pnutri_updated_at';

    protected $fillable = [
        'pnutri_name',
        'pnutri_status',
        'pcolor_is_delete',
        'pcolor_created_at',
        'pcolor_updated_at'
    ];

    const ALIAS = [
        'pnutri_id'             => 'id',
        'pnutri_name'           => 'name',
        'pnutri_status'         => 'status',
        'pnutri_is_delete'      => 'isDelete',
        'pnutri_created_at'     => 'createdAt',
        'pnutri_updated_at'     => 'updatedAt'
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
        return $query->where('pnutri_is_delete', 'no');
    }
}
