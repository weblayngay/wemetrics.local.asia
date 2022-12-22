<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends BaseModel
{
    use HasFactory;
    protected $table    = ORDER_TBL;
    protected $primaryKey = 'ord_id';
    const CREATED_AT = 'ord_created_at';
    const UPDATED_AT = 'ord_updated_at';
    const STATUS = [
        'new'           => 'Mới đặt',
        'pending'       => 'Đang xử lý',
        'processing'    => 'Đang giao hàng',
        'paid'          => 'Đã thanh toán',
        'cancelled'     => 'Đơn hàng hủy',
    ];
    const PAYMENT = [
        'cod'           => 'Thanh toán tiền mặt khi nhận hàng (COD)',
        'transfer'      => 'Thanh toán chuyển khoản',
    ];

    protected $fillable = [
        'ord_id',
        'ord_name',
        'ord_code',
        'ord_total_cost',
        'ord_status',
        'ord_note',
        'ord_address_detail',
        'user_id',
        'product_type',
        'ord_created_at',
        'ord_created_at',
        'ord_is_deleted',
        'ord_is_view',
        'ward_id',
        'province_id',
        'district_id',
        'order_full_name',
        'order_phone',
        'ord_quantity',
        'order_email',

        'order_full_name_two',
        'province_id_two',
        'district_id_two',
        'ward_id_two',
        'order_phone_two',
        'ord_address_detail_two',
        'ord_note_two',
        'order_email_two',
        'ord_discount',
        'voucher_code',
    ];

    const ALIAS = [
        'ord_name'              => 'name',
        'ord_code'              => 'code',
        'ord_total_cost'        => 'totalCost',
        'ord_status'            => 'status',
        'ord_note'              => 'note',
        'ord_address_detail'    => 'addressDetail',
        'user_id'               => 'userId',
        'product_type'          => 'productType',
        'ord_created_at'        => 'createdAt',
        'ord_updated_at'        => 'updatedAt',
        'ord_is_deleted'        => 'isDeleted',
        'ord_is_view'           => 'isView',
        'ward_id'               => 'wardId',
        'province_id'           => 'provinceId',
        'district_id'           => 'districtId',
        'order_full_name'       => 'fullName',
        'order_phone'           => 'phone',
        'order_email'           => 'email',


        'order_full_name_two'  => 'fullNameTwo',
        'province_id_two'      => 'provinceIdTwo',
        'district_id_two'      => 'districtIdTwo',
        'ward_id_two'          => 'wardIdTwo',
        'order_phone_two'      => 'phoneTwo',
        'ord_address_detail_two'  => 'addressDetailTwo',
        'ord_note_two'         => 'noteTwo',
        'order_email_two'      => 'emailTwo',
        'ord_discount'         => 'discount',
        'voucher_code'         => 'voucherCode',
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
        return $query->where('ord_is_deleted', 'no');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'ord_id', 'ord_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsto('App\Models\User');
    }
}
