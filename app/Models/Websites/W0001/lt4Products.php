<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class lt4Products extends BaseModel
{
    use HasFactory;

    protected $table = LT4_PRODUCTS;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = '';

    const STATUS = [
        '1'    => 'Hàng sắp về',
        '2'    => 'Tạm hết hàng',
        '3'    => 'Hết hàng',
        '4'    => 'Tạm ngưng sản xuất',
    ];

    const CATEGORIES = [
        '3'    => 'Bóp - Ví',
        '6'    => 'Balo',
        '17'    => 'Túi Du lịch',
        '21'    => 'Túi xách',
        '24'    => 'Dây nịt',
        '31'    => 'Phụ Kiện Khác',
        '33'    => 'Quà tặng',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent',
        'catid',
        'mfid',
        'code',
        'name',
        'alias',
        'price',
        'price2',
        'vat',
        'discount_value',
        'short_desc',
        'description',
        'thumb',
        'is_new',
        'is_hot',
        'is_saleoff',
        'is_empty',
        'enable',
        'meta_title',
        'meta_key',
        'meta_desc',
        'man',
        'wom',
        'uni',
        'isgift',
        'status_id',
    ];

    const ALIAS = [
        'parent'            => 'parent',
        'catid'             => 'catid',
        'mfid'              => 'mfid',
        'code'              => 'code',
        'name'              => 'name',
        'alias'             => 'alias',
        'price'             => 'price',
        'price2'            => 'price2',
        'vat'               => 'vat',
        'discount_value'    => 'discountValue',
        'short_desc'        => 'shortDesc',
        'description'       => 'description',
        'thumb'             => 'thumb',
        'is_new'            => 'isNew',
        'is_hot'            => 'isHot',
        'is_saleoff'        => 'isSaleoff',
        'is_empty'          => 'isEmpty',
        'enable'            => 'enable',
        'meta_title'        => 'metaTitle',
        'meta_key'          => 'metaKey',
        'meta_desc'         => 'metaDesc',
        'man'               => 'man',
        'wom'               => 'wom',
        'uni'               => 'uni',
        'isgift'            => 'isgift',
        'status_id'         => 'statusId',
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsComing($query)
    {
        return $query->where('status_id', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsDelay($query)
    {
        return $query->where('status_id', '2');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsOutOfStock($query)
    {
        return $query->where('status_id', '3');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsStop($query)
    {
        return $query->where('status_id', '4');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotGift($query)
    {
        return $query->where('isgift', '0');
    }
}
