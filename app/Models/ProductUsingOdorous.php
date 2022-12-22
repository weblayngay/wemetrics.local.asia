<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class ProductUsingOdorous extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_USING_ODOROUS_TBL;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'product_id',
        'podo_id',
        'is_delete'
    ];
}
