<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection,WithHeadings,WithMapping

{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return OrderItem::query()->orderBy('ord_id', 'DESC')->get();
    }

    /**
     * @return string[]
     */
    public function headings(): array {
        return [
            'NGÀY ĐẶT HÀNG',
            'MÃ ĐH',
            'NGƯỜI THỰC HIỆN',
            "MÃ KH",
            "TÊN KH",
            "SỐ ĐT",
            "EMAIL",
            "ĐỊA CHỈ",
            "MÃ VẬN ĐƠN",
            "MÃ KHO",
            "MÃ SP",
            "TÊN SẢN PHẨM",
            "MÔ TẢ",
            "SỐ LƯỢNG",
            "GIÁ VỐN",
            "GIÁ BÁN",
            "VAT(%)",
            "CK(%)",
            "CK(Đ)",
            "THÀNH TIỀN",
            "LỢI NHUẬN SP",
            "DOANH SỐ",
            "CHIẾT KHẤU (Đ)",
            "DOANH THU SAU CK",
            "PHÍ VẬN CHUYỂN (Đ)",
            "PHÍ LẮP ĐẶT (Đ)",
            "DOANH THU TRƯỚC THUẾ",
            "VAT (Đ)",
            "DOANH THU",
            "ĐÃ THANH TOÁN",
            "CÒN LẠI",
            "LỢI NHUẬN",
            "ĐIỀU KHOẢN ĐƠN HÀNG",
            "HÌNH THỨC THANH TOÁN",
            "NGUỒN ĐƠN HÀNG",
            "MÃ VOUCHER",
            "NGƯỜI YÊU CẦU",
            "ĐƠN HÀNG TẶNG",
            "TẶNG HÀNG",
            "NGÀY SHIP",
            "NGÀY THU NỢ",
            "TÌNH TRẠNG ĐƠN HÀNG",
        ];
    }

    /**
     * @param $order
     * @return array
     */
    public function map($order): array {
        $orderMain = Order::query()->where('ord_id', $order->ord_id)->first();
        $paymentTitle = $orderMain->payment_method = 'cod' ? 'Thanh toán tiền mặt khi nhận hàng (COD)' : 'Thanh toán chuyển khoản';

        $user = User::query()->where('id', $order->user_id)->first();
        $admin = Auth::guard('admin')->user();
        $product = Product::query()->where('product_id', $order->product_id)->first();
        $status = Order::STATUS[$orderMain->ord_status];

        return [
            date_format($order->ordi_created_at,"Y/m/d H:i:s"),
            $orderMain->ord_code,
            $admin->username,
            $user->code,
            $user->name,
            $user->phone,
            $user->email,
            $orderMain->ord_address_detail,
            '',
            '',
            $product->product_code,
            $product->product_name,
            strip_tags($product->product_short_description),
            $order->ordi_quantity,
            '',
            $order->ordi_historical_cost,
            '',
            '',
            '',
            $order->ordi_total_cost,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'Điều khoản',
            $paymentTitle,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $status,
        ];
    }

}
