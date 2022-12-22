<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class lt4ProductsCategories extends BaseModel
{
    use HasFactory;

    protected $table = LT4_PRODUCTS_CATEGORIES;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'parent',
        'description',
        'meta_title',
        'meta_key',
        'meta_desc',
        'enable',
        'preview_img',
    ];

    const ALIAS = [
        'name'          => 'name',
        'alias'         => 'alias',
        'parent'        => 'parent',
        'description'   => 'description',
        'meta_title'    => 'metaTitle',
        'meta_key'      => 'metaKey',
        'meta_desc'     => 'metaDesc',
        'enable'        => 'enable',
        'preview_img'   => 'previewImg',
    ];

    /**
     * @return Builder
     */
    static function parentQuery(){
        return parent::query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query()
    {
        return parent::query();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('enable', '1');
    }
}
