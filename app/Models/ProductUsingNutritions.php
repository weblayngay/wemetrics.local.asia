<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductUsingNutritions extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_USING_NUTRITIONS_TBL;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'product_id',
        'pnutri_id',
        'is_delete'
    ];
}
