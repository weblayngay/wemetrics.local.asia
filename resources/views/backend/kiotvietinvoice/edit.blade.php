<?php
    use App\Helpers\MoneyHelper;
    use App\Helpers\StringHelper;
    use App\Helpers\ArrayHelper;
    use App\Helpers\UrlHelper;
    use App\Helpers\DateHelper;
    use VienThuong\KiotVietClient\Model\Invoice;
    use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getTotalCustomerController;
    $getTotalCustomerCtrl = new getTotalCustomerController();
    $urlHelper = new UrlHelper();
    //
    $invoice = !empty($data['invoice']) ? $data['invoice'] : [];
    $user = !empty($data['user']) ? $data['user'] : null;
    $adminName = !empty($data['adminName']) ? $data['adminName'] : null;
    $adminId = !empty($data['adminId']) ? $data['adminId'] : null;
    $title = !empty($data['title']) ? $data['title'] : '';
    /**
     * kiotvietinvoice
     */
    $id = !empty($data['id']) ? $data['id'] : null;
    $code = !empty($data['code']) ? $data['code'] : null;
    $uuid = !empty($data['uuid']) ? $data['uuid'] : null;
    $purchaseDate = !empty($data['purchaseDate']) ? $data['purchaseDate'] : null;
    $branchId = !empty($data['branchId']) ? $data['branchId'] : null;
    $branchName = !empty($data['branchName']) ? $data['branchName'] : null;
    $soldById = !empty($data['soldById']) ? $data['soldById'] : null;
    $soldByName = !empty($data['soldByName']) ? $data['soldByName'] : null;
    $customerId = !empty($data['customerId']) ? $data['customerId'] : null;
    $customerCode = !empty($data['customerCode']) ? $data['customerCode'] : null;
    $customerName = !empty($data['customerName']) ? $data['customerName'] : null;
    $orderCode = !empty($data['orderCode']) ? $data['orderCode'] : null;
    $total = !empty($data['total']) ? $data['total'] : 0;
    $discount = !empty($data['discount']) ? $data['discount'] : 0;
    $totalPayment = !empty($data['totalPayment']) ? $data['totalPayment'] : 0;
    $status = !empty($data['status']) ? $data['status'] : null;
    $statusValue = !empty($data['statusValue']) ? $data['statusValue'] : null;
    $description = !empty($data['description']) ? $data['description'] : null;
    $usingCod = !empty($data['usingCod']) ? $data['usingCod'] : null;
    $createdDate = !empty($data['createdDate']) ? $data['createdDate'] : null;
    //
    $invoiceDetails = !empty($data['invoiceDetails']) ? $data['invoiceDetails'] : [];
    $invoiceDetails = ArrayHelper::arraySort($invoiceDetails, 'subTotal', SORT_DESC);
    //
    $invoiceDelivery = !empty($data['invoiceDelivery']) ? $data['invoiceDelivery'] : [];
    $payments = !empty($data['payments']) ? $data['payments'] : [];
    $saleChannel = !empty($data['saleChannel']) ? $data['saleChannel'] : [];
    $invoiceOrderSurcharges = !empty($data['invoiceOrderSurcharges']) ? $data['invoiceOrderSurcharges'] : [];
    $paymentMethod = '';
    $voucherCode = '';
    //
    if(!empty($payments))
    {
        $paymentArr = $payments->getItems();
        if(!empty($paymentArr))
        {
            foreach($paymentArr as $key => $item)
            {
                $paymentMethod = $item->getMethod();
                if($paymentMethod == 'Voucher')
                {
                    $voucherCode = $item->getDescription();
                }
            }
        }
    }
    //
    $customerAddress = '';
    $customerEmail = '';
    $customerPhone = '';
    if(!empty($customerCode))
    {
        $customer = $getTotalCustomerCtrl->doGetCustomerByCode($customerCode);
        $customerAddress = !empty($customer->getLocationName()) ? $customer->getLocationName() : null;
        $customerEmail = !empty($customer->getEmail()) ? $customer->getEmail() : null;
        $customerPhone = !empty($customer->getContactNumber()) ? $customer->getContactNumber() : null;
    }
    //
    $receiveName = '';
    $receiveAddress = '';
    $receivePhone = '';
    $deliveryCode = '';
    $deliveryServiceTypeText = '';
    $deliveryStatusValue = '';
    $deliveryPartnerCode = '';
    $deliveryPartnerName = '';
    if(!empty($invoiceDelivery))
    {
        $receiveName = $invoiceDelivery->getReceiver();
        $receiveAddress = $invoiceDelivery->getAddress();
        $receivePhone = $invoiceDelivery->getContactNumber();
        $deliveryCode = $invoiceDelivery->getDeliveryCode();
        $deliveryServiceTypeText = $invoiceDelivery->getServiceTypeText();
        $deliveryStatusValue = $invoiceDelivery->getStatusValue();
        $deliveryPartnerCode = $invoiceDelivery->getPartnerDelivery()->getCode();
        $deliveryPartnerName = $invoiceDelivery->getPartnerDelivery()->getName();
    }
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietinvoice.kiotvietinvoice_edit'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('kiotvietinvoice', 'update')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{ $id }}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-xl-12">
                            <table class="table table-striped table-bordered table-hover w-100 display pb-30 js-main-table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th scope="col" class="col-md-6" colspan="2">
                                            <span class="text-center font-weight-bolder">{{'THÔNG TIN BILL'}}</span>
                                        </th>
                                        <th scope="col" class="col-md-6" colspan="2">
                                            <span class="text-center font-weight-bolder">{{('THÔNG TIN VẬN CHUYỂN')}}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Số Bill' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-primary">
                                                {{ $code }}
                                            </span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Số vận đơn' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-primary">
                                                {{ $deliveryCode }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Số đơn hàng' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-info">
                                                {{ $orderCode }}
                                            </span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Hình thức' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-info">
                                                {{ $deliveryServiceTypeText }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Kênh bán hàng' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-muted">
                                                @if(!empty($saleChannel)) {{ $saleChannel['Name'].' - '.$saleChannel['Img'] }} @else {{__('Cửa hàng')}} @endif
                                            </span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Phí ship' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-muted">
                                                {{ $deliveryStatusValue }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Cửa hàng' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-muted">
                                                {{ str::title($branchId.' - '.$branchName)}}
                                            </span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Đơn vị' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-muted">
                                                {{ $deliveryPartnerCode.' - '.$deliveryPartnerName }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Mã giảm giá' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-muted">
                                                <strong>{{ $voucherCode }}</strong>
                                            </span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Diễn giải' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-muted">
                                                {{__($description)}}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Trạng thái' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="btn btn-{{ Invoice::STATUSES_COLOR[$status] }}">
                                                {{ Invoice::STATUSES_LABEL[$status] }}
                                            </span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ '' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-info">
                                                {{ '' }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Hình thức thanh toán' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-{{ Invoice::PAYMENTMETHODS_COLOR[$paymentMethod] }}">
                                                {{ Invoice::PAYMENTMETHODS_LABEL[$paymentMethod] }}
                                            </span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ '' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-info">
                                                {{ '' }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Ngày Bill' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-muted">
                                                {{ DateHelper::getDate('d/m/Y', $purchaseDate) }}
                                            </span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ '' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-info">
                                                {{ '' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr>

                            <table class="table table-striped table-bordered table-hover w-100 display pb-30 js-main-table">
                                <thead class="thead-info">
                                    <tr>
                                        <th scope="col" class="col-md-6" colspan="2">
                                            <span class="text-center font-weight-bolder">{{'THÔNG TIN KHÁCH HÀNG'}}</span>
                                        </th>
                                        <th scope="col" class="col-md-6" colspan="2">
                                            <span class="text-center font-weight-bolder">{{('THÔNG TIN NGƯỜI NHẬN')}}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Tên khách hàng' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $customerName }}
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Tên người nhận' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $receiveName }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Địa chỉ' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $customerAddress }}
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Địa chỉ' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            {{ $receiveAddress }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Email' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-center text-primary font-weight-bolder">{{ $customerEmail }}</span>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Email' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <span class="text-center text-primary font-weight-bolder">{{ __() }}</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-md-3">
                                            <strong>{{ 'Điện thoại' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <a href="@php echo $urlHelper::admin('kiotvietCustomer', 'edit')."?code=$customerCode" @endphp" target="_blank">
                                                <span class="text-center text-info font-weight-bolder">
                                                    {{ StringHelper::getPhoneNumber($customerPhone) }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="col-md-3">
                                            <strong>{{ 'Điện thoại' }}</strong>
                                        </td>
                                        <td class="col-md-3">
                                            <a href="@php echo $urlHelper::admin('kiotvietCustomer', 'edit')."?code=$customerCode" @endphp" target="_blank">
                                                <span class="text-center text-info font-weight-bolder">
                                                    {{ StringHelper::getPhoneNumber($receivePhone) }}
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr>

                            @if(!empty($invoiceDetails))
                                <table class="table table-striped table-bordered table-hover w-100 display pb-30 js-main-table">
                                    <thead class="thead-success">
                                    <tr>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Mã sản phẩm')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Tên sản phẩm')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Giá sản phẩm')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Số lượng')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Thành tiền')}}
                                            </span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoiceDetails as $key => $item)
                                            <tr>
                                                <td>{{ $item['productCode'] }}</td>
                                                <td>{{ $item['productName'] }}</td>
                                                <td>{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item['price']) }}</td>
                                                <td>{{ MoneyHelper::getQuantity('', $item['quantity'] ) }}</td>
                                                <td>{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item['subTotal']) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td><strong>Tổng giá: </strong></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="text-primary font-weight-bolder">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $total) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><strong>Giảm giá: </strong></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $discount) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><strong>Thành tiền: </strong></td>
                                            <td></td>
                                            <td></td>
                                            <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalPayment) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
