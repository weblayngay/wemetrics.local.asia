<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends BaseModel
{
    use HasFactory;

    protected $table = PROVINCE_TBL;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gso_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @return Builder
     */
    static function parentQuery(){
        return parent::query();
    }

    /**
     * @return Builder
     */
    static function query()
    {
        return parent::query();
    }

}
