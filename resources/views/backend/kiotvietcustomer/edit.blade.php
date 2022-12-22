<?php
use App\Helpers\MoneyHelper;
use App\Helpers\StringHelper;
use App\Helpers\DateHelper;
use App\Helpers\UrlHelper;
use App\Helpers\ArrayHelper;
use VienThuong\KiotVietClient\Model\Customer;
use App\Http\Controllers\Backend\Intergrate\Kiotviet\Branch\KiotvietBranchController;

$urlHelper = new UrlHelper();
$getBranchCtrl = new KiotvietBranchController();

$customer = !empty($data['customer']) ? $data['customer'] : null;
$user = !empty($data['user']) ? $data['user'] : null;
$adminName = !empty($data['adminName']) ? $data['adminName'] : null;
$adminId = !empty($data['adminId']) ? $data['adminId'] : null;
$title = !empty($data['title']) ? $data['title'] : '';
/**
 * kiotvietcustomer
 */
$name =  !empty($data['name']) ? $data['name'] : '';
$contactNumber = !empty($data['contactNumber']) ? $data['contactNumber'] : '';
$gender = !empty($data['gender']) ? $data['gender'] : null;
$birthDate = !empty($data['birthDate']) ? $data['birthDate'] : '';
$address = !empty($data['address']) ? $data['address'] : '';
$locationName = !empty($data['locationName']) ? $data['locationName'] : '';
$email = !empty($data['email']) ? $data['email'] : null;
$organization = !empty($data['organization']) ? $data['organization'] : '';
$comment = !empty($data['comment']) ? $data['comment'] : null;
$taxCode = !empty($data['taxCode']) ? $data['taxCode'] : null;
$debt = !empty($data['debt']) ? $data['debt'] : 0;
$totalPoint = !empty($data['totalPoint']) ? $data['totalPoint'] : 0;
$totalRevenue = !empty($data['totalRevenue']) ? $data['totalRevenue'] : 0;
$rewardPoint = !empty($data['rewardPoint']) ? $data['rewardPoint'] : 0;
$totalInvoiced = !empty($data['totalInvoiced']) ? $data['totalInvoiced'] : 0;
$groupId = !empty($data['groupId']) ? $data['groupId'] : '';
$groups = !empty($data['groups']) ? $data['groups'] : '';
$groupIds = !empty($data['groupIds']) ? $data['groupIds'] : '';
$customerGroupDetails = !empty($data['customerGroupDetails']) ? $data['customerGroupDetails'] : null;
$id = !empty($data['id']) ? $data['id'] : '';
$code = !empty($data['code']) ? $data['code'] : '';
$createdDate = !empty($data['createdDate']) ? $data['createdDate'] : '';
$modifiedDate = !empty($data['modifiedDate']) ? $data['modifiedDate'] : '';
$retailerId = !empty($data['retailerId']) ? $data['retailerId'] : '';
$otherProperties = !empty($data['otherProperties']) ? $data['otherProperties'] : null;
$invoices = !empty($data['invoices']) ? $data['invoices'] : null;
//
$branch = (object) [];
if(!empty($otherProperties))
{
    $branchId = $otherProperties['branchId'];
    $branch = $getBranchCtrl->getBranchById($branchId);
}
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietcustomer.kiotvietcustomer_edit'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('kiotvietcustomer', 'update')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{ $id }}">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="updatedBy">{{__('Được sửa bởi')}} <span class="red">*</span></label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <input type="text" name="updatedName" class="form-control" value="{{ $adminName }}" readonly="">
                                        <input type="hidden" name="updatedBy" class="form-control" value="{{ $adminId }}" readonly="">
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <table class="table table-striped table-bordered table-hover w-100 display pb-30 js-main-table">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th scope="col" class="col-md-6" colspan="2">
                                                    <span class="text-center font-weight-bolder">{{'THÔNG TIN KHÁCH HÀNG'}}</span>
                                                </th>
                                                <th scope="col" class="col-md-6" colspan="2">
                                                    <span class="text-center font-weight-bolder">{{__('')}}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Mã khách hàng' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-primary">
                                                        {{ $code }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Tên khách hàng' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-primary">
                                                        {{ $name }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Số điện thoại' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-info">
                                                        {{ StringHelper::getPhoneNumber($contactNumber) }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Email' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-info">
                                                        {{ $email }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Giới tính' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-muted">
                                                        {{ Customer::GENDER[$gender] }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Ngày sinh' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-muted">
                                                        {{ DateHelper::getDate('d/m/Y', $birthDate) }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Ngày tạo' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-muted">
                                                        {{ DateHelper::getDate('d/m/Y', $createdDate) }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Ngày cập nhật' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-muted">
                                                        {{ DateHelper::getDate('d/m/Y', $modifiedDate) }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Dư nợ' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-muted">
                                                        {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $debt) }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Tổng điểm' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-muted">
                                                        {{ MoneyHelper::getQuantity('', $totalPoint) }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Điểm hiện tại' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-warning">
                                                        {{ MoneyHelper::getQuantity('', $rewardPoint) }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Tổng tiền hàng' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-info">
                                                        {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalInvoiced) }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Doanh thu' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-success">
                                                        {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalRevenue) }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Địa chỉ' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-info">
                                                        {{ $address }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Hóa đơn' }}</strong>
                                                </td>
                                                <td class="col-md-3" colspan="3">
                                                    @if(!empty($invoices))
                                                        @foreach($invoices as $key => $item)
                                                            <a class="btn btn-primary" href="@php echo $urlHelper::admin('kiotvietInvoice', 'edit')."?code=".$item->getCode(); @endphp" target="_blank">{{ $item->getCode() }}</a>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Mua hàng gần nhất tại' }}</strong>
                                                </td>
                                                <td class="col-md-3" colspan="3">
                                                    @if(!empty($branch))
                                                        {{ $branch->getId().' - '.$branch->getBranchName().' - '.$branch->getAddress() }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    @if(!empty($invoices))
                                        <table class="table table-striped table-bordered table-hover w-100 display pb-30 js-main-table">
                                            <thead class="thead-success">
                                            <tr>
                                                <th scope="col">
                                                    <span class="text-center font-weight-bolder">
                                                        {{__('Số bill')}}
                                                    </span>
                                                </th>
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
                                                @foreach($invoices as $key1 => $item1)
                                                    @php
                                                        $invoiceDetails = $item1->getInvoiceDetails();
                                                        $invoiceDetails = ArrayHelper::arraySort($invoiceDetails, 'subTotal', SORT_DESC);
                                                    @endphp
                                                        @if(!empty($invoiceDetails))
                                                            @foreach($invoiceDetails as $key2 => $item2)
                                                                <tr>
                                                                    <td data-label="Số bill">
                                                                        <a href="@php echo $urlHelper::admin('kiotvietInvoice', 'edit')."?code=".$item1->getCode(); @endphp" target="blank">
                                                                            {{ $item1->getCode() }}
                                                                        </a>
                                                                    </td>
                                                                    <td data-label="Mã sản phẩm">{{ $item2['productCode'] }}</td>
                                                                    <td data-label="Tên sản phẩm">{{ $item2['productName'] }}</td>
                                                                    <td data-label="Giá sản phẩm">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item2['price']) }}</td>
                                                                    <td data-label="Số lượng">{{ MoneyHelper::getQuantity('', $item2['quantity'] ) }}</td>
                                                                    <td data-label="Thành tiền">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item2['subTotal']) }}</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td></td>
                                                                <td><strong>Tổng giá: </strong></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td><span class="text-primary font-weight-bolder">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item1->getTotal()) }}</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td><strong>Giảm giá: </strong></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td>{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item1->getDiscount()) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td><strong>Thành tiền: </strong></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item1->getTotalPayment()) }}</span></td>
                                                            </tr>
                                                        @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
