<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductUsingColor extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_USING_COLOR_TBL;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'product_id',
        'color_id',
        'is_delete'
    ];
}
