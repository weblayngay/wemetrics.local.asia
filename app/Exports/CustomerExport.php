<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomerExport implements FromCollection,WithHeadings,WithMapping

{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $orders = Order::query()->orderBy('ord_id', 'DESC')->get()->toArray();
        $userIds = array_unique(array_column($orders, 'user_id'));
        $users = User::query()->whereIn('id', $userIds)->get();
        return $users;
    }

    /**
     * @return string[]
     */
    public function headings(): array {
        return [
            'MÃ KH',
            'TÊN KHÁCH HÀNG',
            'ĐỊA CHỈ',
            'ĐIỆN THOẠI',
            'EMAIL',
            'NGƯỜI LIÊN HỆ CHÍNH',
            'ĐIỆN THOẠI NGƯỜI LIÊN HỆ CHÍNH',
            'EMAIL NGƯỜI LIÊN HỆ CHÍNH',
            'CHỨC VỤ LIÊN HỆ CHÍNH',
            'SINH NHẬT LIÊN HỆ CHÍNH',
            'NGƯỜI PHỤ TRÁCH',
            'NHÓM KHÁCH HÀNG',
            'NGUỒN KHÁCH HÀNG',
            'WEBSITE',
            'SINH NHẬT',
            'NGÀNH KINH DOANH',
            'MỐI QUAN HỆ',
            'FAX',
            'QUỐC GIA',
            'TỈNH/THÀNH PHỐ',
            'QUẬN/HUYỆN',
            'NGÀY TẠO',
            'GIỚI TÍNH',
            'MÔ TẢ',
            'MÃ SỐ THUẾ',
            'MÃ KH NỘI BỘ',
            'HẠNG KH HIỆN TẠI',
            'HẠNG KH THÁNG TRƯỚC',
            'DOANH SỐ TRONG THÁNG',
            'ĐỔI VỎ CHAI',
            'ĐỐI TƯƠNG SỬ DỤNG',
            'PHƯƠNG THỨC THANH TOÁN',
            'TÊN NGƯỜI GIỚI THIỆU',
            'SỐ ĐIỆN THOẠI NGƯỜI GIỚI THIỆU',
            'GHI CHÚ',
            'MÃ VOUCHER',
            'MÃ ĐẠI LÝ',
            'NICK FACEBOOK',
            'NICK ZALO',
            'NGHỀ NGHIỆP HIỆN TẠI',
            'KINH NGHIỆM KINH DOANH',
            'MỤC TIÊU CUỘC SỐNG',
            'VIETWISE',
        ];
    }

    /**
     * @param $user
     * @return array
     */
    public function map($user): array {
        $order = Order::query()->where('user_id', $user->id)->first();
        $ward = Ward::query()->where('id', $order->ward_id)->first();
        $district = District::query()->where('id', $order->district_id)->first();
        $province = Province::query()->where('id', $order->province_id)->first();

        return [
            $user->code,
            $user->name,
            $order->ord_address_detail,
            $user->phone,
            $user->email,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            env('APP_URL', ''),
            $user->birthday,
            '',
            '',
            '',
            'Việt Nam',
            $province->name,
            $district->name,
            date_format($user->created_at,"Y/m/d H:i:s"),
            $user->sex,
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
            '',
            '',
            $user->facebook,
            $user->zalo,
            '',
            '',
            '',
            '',
        ];
    }

}
