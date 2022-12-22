<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class tsOrders extends BaseModel
{
    use HasFactory;

    protected $table = TS_ORDERS;
    protected $primaryKey = 'id';
    const CREATED_AT = '';
    const UPDATED_AT = '';

    const STATUS = [
        'N'    => 'Đang xử lý',
        'D'    => 'Đang giao hàng',
        'C'    => 'Đơn hàng đã hủy',
        'F'    => 'Thành công',
        'P'    => 'Đã thanh toán',
    ];

    const STATUS_COLOR = [
        'N'    => 'primary',
        'D'    => 'secondary',
        'C'    => 'success',
        'F'    => 'danger',
        'P'    => 'info',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
        'status_id',
        'name',
        'phone',
        'email',
        'address',
        'order_total',
        'vdiscount',
        'vcode',
        'shipping',
        'shipping_fee',
        'engrave_fee',
        'engrave_value',
        'payment',
        'payonline',
        'paid',
        'note',
        'isgift',
    ];

    const ALIAS = [
        'sale_id'       => 'saleId',
        'status_id'     => 'statusId',
        'name'          => 'name',
        'phone'         => 'phone',
        'email'         => 'email',
        'address'       => 'address',
        'order_total'   => 'orderTotal',
        'vdiscount'     => 'vdiscount',
        'vcode'         => 'vcode',
        'shipping'      => 'shipping',
        'shipping_fee'  => 'shippingFee',
        'engrave_fee'   => 'engraveFee',
        'engrave_value' => 'engraveValue',
        'payment'       => 'payment',
        'payonline'     => 'payonline',
        'paid'          => 'paid',
        'note'          => 'note',
        'isgift'        => 'isgift',
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
    public function scopeIsPaid($query)
    {
        return $query
        ->where('paid', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotPaid($query)
    {
        return $query
        ->where('paid', '0');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsPayOnline($query)
    {
        return $query
        ->where('payonline', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotPayOnline($query)
    {
        return $query
        ->where('payonline', '0');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsUsedVoucher($query)
    {
        return $query
        ->whereRaw("IFNULL(vcode, '') <> ''");
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotUsedVoucher($query)
    {
        return $query
        ->whereRaw("IFNULL(vcode, '') = ''");
    }
}
