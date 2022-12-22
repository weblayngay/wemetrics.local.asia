<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductUsingSize extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_USING_SIZE_TBL;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'product_id',
        'size_id',
        'is_delete'
    ];
}
