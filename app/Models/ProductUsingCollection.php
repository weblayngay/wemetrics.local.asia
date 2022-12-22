<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductUsingCollection extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_USING_COLLECTIONS_TBL;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'product_id',
        'pcollection_id',
        'is_delete'
    ];
}
