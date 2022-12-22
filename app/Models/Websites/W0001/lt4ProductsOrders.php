<?php

namespace App\Models\Websites\W0001;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;
use App\Helpers\ArrayHelper;
use App\Helpers\CollectionPaginateHelper;

class lt4ProductsOrders extends BaseModel
{
    use HasFactory;

    protected $table = LT4_PRODUCTS_ORDERS;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created';
    const UPDATED_AT = '';

    const STATUS = [
        '1'    => 'Đang xử lý',
        '2'    => 'Đang giao hàng',
        '3'    => 'Đơn hàng đã hủy',
        '4'    => 'Thành công',
        '5'    => 'Đã thanh toán',
    ];

    const STATUS_COLOR = [
        '1'    => 'primary',
        '2'    => 'secondary',
        '3'    => 'success',
        '4'    => 'danger',
        '5'    => 'info',
    ];

    const PAYMENT = [
        '1'    => 'COD',
        '4'    => 'Thẻ ngân hàng',
        '5'    => 'Thẻ quốc tế',
        '7'    => 'MoMo',
        '8'    => 'ZaloPay',
        '11'   => 'ShopeePay',
    ];

    const PAYMENT_COLOR = [
        '1'    => 'primary',
        '4'    => 'secondary',
        '5'    => 'success',
        '7'    => 'danger',
        '8'    => 'info',
        '11'   => 'dark',
    ];

    const SHIPPING = [
        '1'    => 'Giao hàng trong 24h',
        '2'    => 'Giao hàng miễn phí (chỉ áp dụng đơn thanh toán trực tuyến)',
        '3'    => 'Cửa hàng Lee&Tee sẽ xử lý đơn hàng của Quý Khách',
        '4'    => 'Giaohangtietkiem.vn',
        '5'    => 'Miễn phí vận chuyển',
        '6'   => 'Cửa hàng tiếp nhận sẽ cung cấp về phí vận chuyển đến Quý khách. Phí giao hàng từ 22.000đ - 45.000đ',
    ];

    const SHIPPING_COLOR = [
        '1'    => 'primary',
        '2'    => 'secondary',
        '3'    => 'success',
        '4'    => 'danger',
        '5'    => 'info',
        '6'    => 'dark',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'user_info_id',
        'shipping_id',
        'payment_id',
        'order_num',
        'user_info_num',
        'isaff',
        'rid',
        'status_id',
        'order_total',
        'order_shipping',
        'engrave_fee',
        'ip_address',
        'vcode',
        'vdiscount',
        'amount',
        'paid',
        'payonline',
        'pay_status',
        'isgift',
    ];

    const ALIAS = [
        'uid'               => 'uid',
        'user_info_id'      => 'userInfoId',
        'shipping_id'       => 'shippingId',
        'payment_id'        => 'paymentId',
        'order_num'         => 'orderNum',
        'user_info_num'     => 'userInfoNum',
        'isaff'             => 'isaff',
        'rid'               => 'rid',
        'status_id'         => 'statusId',
        'order_total'       => 'orderTotal',
        'order_shipping'    => 'orderShipping',
        'engrave_fee'       => 'engraveFee',
        'ip_address'        => 'ipAddress',
        'vcode'             => 'vcode',
        'vdiscount'         => 'vdiscount',
        'amount'            => 'amount',
        'paid'              => 'paid',
        'payonline'         => 'payonline',
        'pay_status'        => 'payStatus',
        'isgift'            => 'isgift',
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
        return $query->where('payonline', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsProcessing($query)
    {
        return $query->where('status_id', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsShipping($query)
    {
        return $query->where('status_id', '2');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsCanceled($query)
    {
        return $query->where('status_id', '3');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsCompleted($query)
    {
        return $query->whereIn('status_id', ['4', '5']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($searchStr, $paymentMethod, $statusId, $paginateNum, $frmDate, $toDate)
    {
        $query = DB::table(LT4_PRODUCTS_ORDERS. " AS t1")
            ->selectRaw("t1.id AS OrderNum, t1.user_info_id AS customerId, t1.amount AS amount, '' AS customerName, '' AS customerAddress, '' AS customerCity, '' AS CustomerDist, '' AS customerEmail, '' AS customerPhone, t1.created AS createdAt, t1.status_id AS statusId, t1.payment_id AS paymentMethod")
            ->orderBy('t1.id', 'DESC')
            ->whereRaw("DATE_FORMAT(DATE(t1.created), '%Y-%m-%d') BETWEEN '".$frmDate."' AND '".$toDate."'");

            if (!empty(self::PAYMENT[$paymentMethod])) {
                $query->whereRaw("t1.payment_id LIKE '".'%'.$paymentMethod.'%'."'");
            }

            if (!empty(self::STATUS[$statusId])) {
                $query->whereRaw("t1.status_id LIKE '".'%'.$statusId.'%'."'");
            }

        $orders = $query->get();

        $customerIds = [];
        if($orders->count() > 0){
            $customerIds = array_column($orders->toArray(), 'customerId');
        }

        $customerIds = ArrayHelper::convertToString($customerIds);

        $customers = DB::table(LT4_PRODUCTS_ORDERS_USER_INFO. " AS t1")
            ->selectRaw("t1.id AS customerId, t1.name AS customerName, t1.address AS customerAddress, t1.city_name AS customerCity, t1.dist_name AS CustomerDist, t1.email AS customerEmail, t1.phone AS customerPhone")
            ->orderBy('t1.id', 'DESC')
            ->whereRaw('t1.id IN ('.$customerIds.')')
            ->whereRaw("t1.name LIKE ". parent::escapeStringLike($searchStr))
            ->orWhereRaw("t1.email LIKE ". parent::escapeStringLike($searchStr))
            ->orWhereRaw("t1.phone LIKE ". parent::escapeStringLike($searchStr))
            ->get();

        foreach ($orders as $k1 => $i1) {
            foreach ($customers as $k2 => $i2) {
                if($i1->customerId == $i2->customerId)
                {
                    $i1->customerName = $i2->customerName;
                    $i1->customerAddress = $i2->customerAddress;
                    $i1->customerCity = $i2->customerCity;
                    $i1->CustomerDist = $i2->CustomerDist;
                    $i1->customerEmail = $i2->customerEmail;
                    $i1->customerPhone = $i2->customerPhone;
                    break;
                }
            }
        }

        foreach ($orders as $key => $item) {
            if($item->customerEmail == '')
            {
                unset($orders[$key]);
            }
        }

        $orders = CollectionPaginateHelper::paginate($orders, PAGINATE_PERPAGE);

        return $orders;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\Websites\W0001\lt4ProductsOrdersDetail', 'order_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsto('App\Models\Websites\W0001\lt4ProductsOrdersUserInfo');
    }                  
}
