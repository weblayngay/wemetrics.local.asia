@php
    use App\Helpers\MoneyHelper;
    use App\Helpers\StringHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\UrlHelper;
    use App\Helpers\ArrayHelper;
    use VienThuong\KiotVietClient\Model\Product;
    use App\Http\Controllers\Backend\Intergrate\Kiotviet\Branch\KiotvietBranchController;

    $urlHelper = new UrlHelper();
    $productModel = new Product();
    $getBranchCtrl = new KiotvietBranchController();

    $product = !empty($data['product']) ? $data['product'] : null;
    $user = !empty($data['user']) ? $data['user'] : null;
    $adminName = !empty($data['adminName']) ? $data['adminName'] : null;
    $adminId = !empty($data['adminId']) ? $data['adminId'] : null;
    $title = !empty($data['title']) ? $data['title'] : '';
    /**
     * kiotvietproduct
     */
    $name =  !empty($data['name']) ? $data['name'] : '';
    $id = !empty($data['id']) ? $data['id'] : '';
    $code = !empty($data['code']) ? $data['code'] : '';
    $fullName = !empty($data['fullName']) ? $data['fullName'] : '';
    $image = !empty($data['image']) ? $data['image'] : '';
    $categoryId = !empty($data['categoryId']) ? $data['categoryId'] : '';
    $categoryName = !empty($data['categoryName']) ? $data['categoryName'] : '';
    $allowsSale = !empty($data['allowsSale']) ? $data['allowsSale'] : null;
    $description = !empty($data['description']) ? $data['description'] : '';
    $inventories = !empty($data['inventories']) ? $data['inventories'] : null;
    $basePrice = !empty($data['basePrice']) ? $data['basePrice'] : 0;
    $createdDate = !empty($data['createdDate']) ? $data['createdDate'] : '';
    $modifiedDate = !empty($data['modifiedDate']) ? $data['modifiedDate'] : '';
    $retailerId = !empty($data['retailerId']) ? $data['retailerId'] : '';
    $otherProperties = !empty($data['otherProperties']) ? $data['otherProperties'] : null;
    //
    $totalInventoryQuantity = 0;
    if(!empty($inventories))
    {
        $inventoriesArr = [];
        foreach($inventories as $key => $item)
        {
            $inventoriesArr[$item->getId() * 100 + $key] = [];
            $inventoriesArr[$item->getId() * 100 + $key]['branchId'] = $item->getBranchId();
            $inventoriesArr[$item->getId() * 100 + $key]['branchName'] = $item->getBranchName();
            $inventoriesArr[$item->getId() * 100 + $key]['onHand'] = $item->getOnHand();
            $totalInventoryQuantity += $item->getOnHand();
        }
        $inventoriesArr = collect($inventoriesArr)->where('onHand', '>',  0)->sortBy([
                                ['onHand', 'desc'],
                            ]);
    }
    $type = 'Hàng hóa thông thường';
    $batchExpired = 'Không theo dõi hạn sử dụng theo lô';
    //
    if(!empty($otherProperties))
    {
        $type = $productModel::PRODUCT_TYPE[$otherProperties['type']];
        $batchExpired = $productModel::PRODUCT_BATCH_EXPIRED[$otherProperties['isBatchExpireControl']];
    }
    // dd($inventoriesArr, $otherProperties, $type, $batchExpired);
@endphp

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.kiotvietproduct.kiotvietproduct_edit'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('kiotvietproduct', 'update')}}" enctype="multipart/form-data">
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
                                                    <span class="text-center font-weight-bolder">{{'THÔNG TIN SẢN PHẨM'}}</span>
                                                </th>
                                                <th scope="col" class="col-md-6" colspan="2">
                                                    <span class="text-center font-weight-bolder">{{__('')}}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Mã sản phẩm' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-primary">
                                                        {{ $code }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Tên sản phẩm' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-primary">
                                                        {{ $name }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Nhóm sản phẩm' }}</strong>
                                                </td>
                                                <td class="col-md-3">
                                                    <span class="text-primary">
                                                        {{ $categoryName }}
                                                    </span>
                                                </td>
                                                <td class="col-md-3">
                                                    <strong>{{ 'Loại hàng hóa' }}</strong>
                                                </td>
                                                <td class="col-md-3" colspan="3">
                                                    {{ $type }}
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
                                                    <strong>{{ 'Theo dõi hạn sử dụng' }}</strong>
                                                </td>
                                                <td class="col-md-3" colspan="3">
                                                    {{ $batchExpired }}
                                                </td>                                                
                                            </tr>
                                        </tbody>
                                    </table>

                                    @if(!empty($inventoriesArr))
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-striped table-bordered table-hover w-100 display pb-30 js-main-table">
                                                    <thead class="thead-info">
                                                    <tr>
                                                        <th scope="col">
                                                            <span class="text-center font-weight-bolder">
                                                                {{__('Tên cửa hàng')}}
                                                            </span>
                                                        </th>
                                                        <th scope="col">
                                                            <span class="text-center font-weight-bolder">
                                                                {{__('Tồn kho')}}
                                                            </span>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($inventoriesArr as $key => $item)
                                                            @php
                                                                $item = (object) $item;
                                                                $quantityInventoryPercent = Round($item->onHand / $totalInventoryQuantity * 100, 0);
                                                                //
                                                                if($loop->index + 1 == 1)
                                                                {
                                                                    $badgebg = 'primary';
                                                                }
                                                                if($loop->index + 1 == 2)
                                                                {
                                                                    $badgebg = 'success';
                                                                }
                                                                if($loop->index + 1 == 3)
                                                                {
                                                                    $badgebg = 'info';
                                                                }
                                                                if($loop->index + 1 == 4)
                                                                {
                                                                    $badgebg = 'warning';
                                                                }
                                                                if($loop->index + 1 == 5)
                                                                {
                                                                    $badgebg = 'danger';
                                                                }
                                                                if($loop->index + 1 > 5)
                                                                {
                                                                    $badgebg = 'secondary';
                                                                }                                                        
                                                            @endphp
                                                            <tr>                                                       
                                                                <td data-label="Tên cửa hàng">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="card">
                                                                                @if($loop->index <= 4)
                                                                                    <div class="ribbon-wrapper">
                                                                                        <div class="ribbon ribbon-{{__($badgebg)}}">{{__('Top ').($loop->index + 1)}}</div>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="ribbon-wrapper">
                                                                                        <div class="ribbon ribbon-{{__($badgebg)}}">{{__('Regular')}}</div>
                                                                                    </div>
                                                                                @endif
                                                                                <div class="card-body">
                                                                                    <p class="mb-0">
                                                                                        <strong>{{ Str::title($item->branchName) }}</strong>
                                                                                    </p>
                                                                                    <p class="mb-0">
                                                                                      <a href="@php echo $urlHelper::admin('kiotvietproductreportoverview', 'preloadindex')."?branch=".$item->branchId."&code=".$code; @endphp" target="_blank" type="button" class="btn btn-info btn-sm">
                                                                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> {{__('Xem chi tiết')}}
                                                                                      </a>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>                                                                                    
                                                                    </div>
                                                                </td>
                                                                <td data-label="Tồn kho">{{ MoneyHelper::getQuantity('', $item->onHand ) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-4">
                                                @if(!empty($image))
                                                    <img src="{{ __($image) }}" alt="{{\Str::slug($name)}}">
                                                @endif
                                            </div>
                                        </div>
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
