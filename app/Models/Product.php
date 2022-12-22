<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    use HasFactory;
    protected $table    = PRODUCT_TBL;
    protected $primaryKey = 'product_id';
    const CREATED_AT = 'product_created_at';
    const UPDATED_AT = 'product_updated_at';

    const GROUP_NAME = [
        'new'           => 'Mới',
        'sell_a_lot'    => 'Bán chạy',
        'sale'          => 'Giảm giá',
    ];

    protected $fillable = [
        'product_id',
        'product_created_at',
        'product_updated_at',
        'product_created_by',

        //vi
        'product_name',
        'product_code',
        'product_group',
        'producer',
        'product_view',
        'product_status_show',
        'product_is_hot',
        'product_is_gift',
        'product_is_new',
        'product_is_free_ship',
        'product_is_delete',
        'product_sex',
        'product_is_sale',
        'product_is_selling',
        'product_price',
        'product_new_price',
        'product_discount',
        'product_status',
        'product_weight',
        'product_short_description',
        'product_description',
        'product_related',
        'product_note',
        'product_meta_title',
        'product_meta_keywords',
        'product_meta_description',
        'product_type',

        //en
        'product_name_en',
        'product_view_en',
        'product_price_en',
        'product_new_price_en',
        'product_discount_en',
        'product_weight_en',
        'product_short_description_en',
        'product_description_en',
        'product_note_en',
        'product_meta_title_en',
        'product_meta_keywords_en',
        'product_meta_description_en',

        // other
        'pcat_id',
    ];

    const ALIAS = [
        'product_id'  => 'id',
        'product_created_at'  => 'createdAt',
        'product_updated_at'  => 'updatedAt',
        'product_created_by'  => 'createdBy',

        //vi
        'product_name'  => 'name',
        'product_code'  => 'code',
        'product_group' => 'group',
        'producer' => 'producer',
        'product_view'  => 'view',
        'product_status_show'  => 'statusShow',
        'product_is_hot' => 'isHot',
        'product_is_gift' => 'isGift',
        'product_is_new'  => 'isNew',
        'product_is_free_ship'  => 'isFreeShip',
        'product_is_delete'  => 'isDelete',
        'product_sex'   => 'sex',
        'product_is_sale' => 'isSale',
        'product_is_selling' => 'isSelling',
        'product_price'  => 'price',
        'product_new_price'  => 'newPrice',
        'product_discount'  => 'discount',
        'product_status'  => 'status',
        'product_weight'  => 'weight',
        'product_short_description'  => 'shortDescription',
        'product_description'  => 'description',
        'product_related'  => 'related',
        'product_note'  => 'note',
        'product_meta_title'  => 'metaTitle',
        'product_meta_keywords'  => 'metaKeywords',
        'product_meta_description' => 'metaDescription',
        'product_type' => 'type',

        //en
        'product_name_en'  => 'nameEn',
        'product_view_en' => 'viewEn',
        'product_price_en' => 'priceEn',
        'product_new_price_en' => 'newPriceEn',
        'product_discount_en' => 'discountEn',
        'product_weight_en' => 'weightEn',
        'product_short_description_en' => 'shortDescriptionEn',
        'product_description_en' => 'descriptionEn',
        'product_note_en' => 'noteEn',
        'product_meta_title_en' => 'metaTitleEn',
        'product_meta_keywords_en' => 'metaKeywordsEn',
        'product_meta_description_en' => 'metaDescriptionEn',
        'pcat_id' => 'pcatId',
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
        return parent::query()->notDeleted();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('product_is_delete', 'no');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function colors()
    {
        return $this->belongstoMany('App\Models\ProductColor', 'product_using_colors',   'product_id', 'pcolor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sizes()
    {
        return $this->belongstoMany('App\Models\ProductSize', 'product_using_sizes', 'product_id', 'psize_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections()
    {
        return $this->belongstoMany('App\Models\ProductCollection', 'product_using_collections',   'product_id', 'pcollection_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nutritions()
    {
        return $this->belongstoMany('App\Models\ProductNutritions', 'product_using_nutritions',   'product_id', 'pnutri_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function odorous()
    {
        return $this->belongstoMany('App\Models\ProductOdorous', 'product_using_odorous',   'product_id', 'podo_id');
    }


    /**
     * @param int $limit
     * @return Builder[]|Collection
     */
    public function findProductIsHot(int $limit = 10)
    {
        return self::parentQuery()->where(['product_is_hot' => 'yes', 'product_is_delete' => 'no', 'product_status' => 'stocking'])->limit($limit)->get();
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'product_id')
            ->where(['3rd_type' => 'product', 'image_value' => config('my.image.value.product.avatar'), 'image_status' => 'activated', 'image_is_deleted' => 'no']);
    }

    /**
     * @return HasMany
     */
    public function banner(): HasMany
    {
        return parent::hasMany('App\Models\Image', '3rd_key', 'product_id')
            ->where(['3rd_type' => 'product', 'image_value' => config('my.image.value.product.banner'), 'image_status' => 'activated', 'image_is_deleted' => 'no']);
    }

    /**
     * @return HasMany
     */
    public function thumbnail(): HasMany
    {
        return parent::hasMany('App\Models\Image', '3rd_key', 'product_id')
            ->where(['3rd_type' => 'product', 'image_value' => config('my.image.value.product.thumbnail'), 'image_status' => 'activated', 'image_is_deleted' => 'no']);
    }

    public function pcat()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'pcat_id', 'pcat_id');
    }


    /**
     * @param array $productIds
     * @return Builder[]|Collection
     */
    public function findProductsAreStocking(array $productIds)
    {
        return self::query()
            ->select('*')
            ->where(['product_status_show' => 'yes', 'product_status' => 'stocking'])
            ->whereIn('product_id', $productIds)
            ->selectRaw('IF(product_new_price > 0, product_new_price, product_price - product_discount) AS price')
            ->get();
    }
}
