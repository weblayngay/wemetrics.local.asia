<?php
$title = isset($data['title']) ? $data['title'] : '';
$adminName = $data['adminName'];
$products = !empty($data['products']) ? $data['products'] : [];

$colors = !empty($data['colors']) ? $data['colors'] : [];
$sizes = !empty($data['sizes']) ? $data['sizes'] : [];
$collections = !empty($data['collections']) ? $data['collections'] : [];
$nutritions = !empty($data['nutritions']) ? $data['nutritions'] : [];
$odorous = !empty($data['odorous']) ? $data['odorous'] : [];

$producers = !empty($data['producers']) ? $data['producers'] : [];
$productCategories = !empty($data['productCategories']) ? $data['productCategories'] : [];

$type = $data['type'];
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.product.product_add'])
    <form method="POST" id="admin-form" action="{{app('UrlHelper')::admin('product', 'store')}}" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="type" value="{{$type}}">
        @csrf
        <input type="hidden" name="typeSubmit" value="0">
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row product-module">
                        <nav id="nav-tabs">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-vi-tab" data-toggle="tab" href="#nav-vi" role="tab" aria-controls="nav-vi" aria-selected="true">Thông tin (Tiếng Việt)</a>
{{--                                <a class="nav-item nav-link" id="nav-en-tab" data-toggle="tab" href="#nav-en" role="tab" aria-controls="nav-en" aria-selected="false">Thông tin (Tiếng Anh)</a>--}}
                                <a class="nav-item nav-link" id="nav-setting-tab" data-toggle="tab" href="#nav-setting" role="tab" aria-controls="nav-setting" aria-selected="false">Cấu hình </a>
                                <a class="nav-item nav-link" id="nav-upload-tab" data-toggle="tab" href="#nav-upload" role="tab" aria-controls="nav-upload" aria-selected="false">Upload ảnh</a>
                                <a class="nav-item nav-link" id="nav-related-tab" data-toggle="tab" href="#nav-related" role="tab" aria-controls="nav-related" aria-selected="false">Sản phẩm liên quan</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-vi" role="tabpanel" aria-labelledby="nav-vi-tab">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="table-wrap">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Được tạo bởi</th>
                                                                    <td>{{ $adminName }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Tên sản phẩm <span class="red">*</span></th>
                                                                    <td><input type="text" name="name" class="form-control form-control-sm" placeholder="Tên sản phẩm"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Mã SP</th>
                                                                    <td><input type="text" name="code" class="form-control form-control-sm" placeholder="Mã sản phẩm"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Nhóm sản phẩm</th>
                                                                    <td>
                                                                        <select name="pcatId" class="form-control custom-select form-control custom-select-sm mt-15">
                                                                            <option value="">--- Chọn nhóm ---</option>
                                                                            @foreach($productCategories as $item)
                                                                                @php
                                                                                    $level = $item->level - 2;
                                                                                @endphp
                                                                                <option value="{{$item->pcat_id}}">{{app('NestedSetModelHelper')::notationByLevel($level) . $item->pcat_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
  {{--                                                              <tr>
                                                                    <th scope="row">Nhóm sản phẩm</th>
                                                                    <td>
                                                                        <select name="group" class="form-control custom-select form-control custom-select-sm mt-15">
                                                                            <option value="">--- Chọn nhóm ---</option>
                                                                            <option value="new">Mới</option>
                                                                            <option value="sell_a_lot">Bán chạy</option>
                                                                            <option value="sale">Khuyến mãi</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>--}}
                                                                <tr>
                                                                    <th scope="row">Hãng sản xuất</th>
                                                                    <td>
                                                                        <select name="producer" class="form-control custom-select form-control custom-select-sm mt-15">
                                                                                <option value="">--- Chọn hãng ---</option>
                                                                            @if(count($producers) > 0)
                                                                                @foreach($producers as $key => $itemproducer)
                                                                                    <option value="{{ $itemproducer['producer_id'] }}">{{ $itemproducer['producer_name'] }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Lượt xem</th>
                                                                    <td><input type="number" name="view" class="form-control form-control-sm" placeholder="Nhập lượt xem"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Giá</th>
                                                                    <td><input type="number" name="price" class="form-control form-control-sm" placeholder="Nhập giá"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Giá mới</th>
                                                                    <td><input type="number" name="newPrice" class="form-control form-control-sm" placeholder="Nhập giá mới"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Giảm giá</th>
                                                                    <td><input type="number" name="discount" class="form-control form-control-sm" placeholder="Nhập giảm giá"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Trạng thái</th>
                                                                    <td>
                                                                        <select name="status" class="form-control custom-select form-control custom-select-sm mt-15">
                                                                            <option value="">--- Chọn trạng thái ---</option>
                                                                            <option value="stocking">Còn hàng</option>
                                                                            <option value="out_of_stock">Hết hàng</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Trọng lượng</th>
                                                                    <td><input type="number" name="weight" class="form-control form-control-sm" placeholder="Nhập trọng lượng"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Mô tả ngắn</th>
                                                                    <td><textarea id="editor_short" name="shortDescription" class="form-control" placeholder="Nhập mô tả ngắn"></textarea></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Mô tả</th>
                                                                    <td><textarea id="editor" name="description" class="form-control" placeholder="Nhập mô tả"></textarea></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Meta Title</th>
                                                                    <td><input type="text" name="metaTitle" class="form-control form-control-sm" placeholder=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Meta Keywords</th>
                                                                    <td><input type="text" name="metaKeywords" class="form-control form-control-sm" placeholder=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Meta Description</th>
                                                                    <td><input type="text" name="metaDescription" class="form-control form-control-sm" placeholder=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Ghi chú cho sản phẩm</th>
                                                                    <td><textarea name="note" class="form-control" rows="3" placeholder="Nhập ghi chú"></textarea></td>
                                                                </tr>
                                                            <tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
{{--                            <div class="tab-pane fade" id="nav-en" role="tabpanel" aria-labelledby="nav-en-tab">--}}
{{--                                <div class="col-xl-12">--}}
{{--                                    <section class="hk-sec-wrapper">--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm">--}}
{{--                                                <div class="table-wrap">--}}
{{--                                                    <div class="table-responsive">--}}
{{--                                                        <table class="table mb-0">--}}
{{--                                                            <tbody>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Tên sản phẩm</th>--}}
{{--                                                                <td><input type="text" name="nameEn" class="form-control form-control-sm" placeholder="Tên sản phẩm"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Mã SP</th>--}}
{{--                                                                <td><input type="text" name="codeEn" class="form-control form-control-sm" placeholder="Mã sản phẩm"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Lượt xem</th>--}}
{{--                                                                <td><input type="number" name="viewEn" class="form-control form-control-sm" placeholder="Nhập lượt xem"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Giá</th>--}}
{{--                                                                <td><input type="number" name="priceEn" class="form-control form-control-sm" placeholder="Nhập giá"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Giá mới</th>--}}
{{--                                                                <td><input type="number" name="newPriceEn" class="form-control form-control-sm" placeholder="Nhập giá mới"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Giảm giá</th>--}}
{{--                                                                <td><input type="number" name="discountPriceEn" class="form-control form-control-sm" placeholder="Nhập giảm giá"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Trọng lượng</th>--}}
{{--                                                                <td><input type="number" name="weight" class="form-control form-control-sm" placeholder="Nhập trọng lượng"></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Mô tả ngắn</th>--}}
{{--                                                                <td><textarea id="editor_short_en" name="shortDescriptionEn" class="form-control" placeholder="Nhập mô tả ngắn"></textarea></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Mô tả</th>--}}
{{--                                                                <td><textarea id="editor_en" name="descriptionEn" class="form-control" placeholder="Nhập mô tả"></textarea></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Meta Title</th>--}}
{{--                                                                <td><input type="text" name="metaTitleEn" class="form-control form-control-sm" placeholder=""></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Meta Keywords</th>--}}
{{--                                                                <td><input type="text" name="metaKeywordsEn" class="form-control form-control-sm" placeholder=""></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Meta Description</th>--}}
{{--                                                                <td><input type="text" name="metaDescriptionEn" class="form-control form-control-sm" placeholder=""></td>--}}
{{--                                                            </tr>--}}
{{--                                                            <tr>--}}
{{--                                                                <th scope="row">Ghi chú cho sản phẩm</th>--}}
{{--                                                                <td><textarea name="noteEn" class="form-control" rows="3" placeholder="Nhập ghi chú"></textarea></td>--}}
{{--                                                            </tr>--}}
{{--                                                            </tbody>--}}
{{--                                                        </table>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </section>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="tab-pane fade" id="nav-setting" role="tabpanel" aria-labelledby="nav-setting-tab">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="table-wrap">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                            @if($type == 'shoes')
                                                            <tr>
                                                                <th scope="row">Màu</th>
                                                                <td>
                                                                    @if(!empty($colors))
                                                                        @foreach($colors as $itemColor)
                                                                            <label class="checkbox-inline label-right"><input type="checkbox" value="{{ $itemColor->pcolor_id }}" name="color[]"> {{ $itemColor->pcolor_code}} <span class="span-color" style="background: {{ $itemColor->pcolor_hex }}"></span></label>
                                                                        @endforeach
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Kích thước</th>
                                                                <td>
                                                                    @if(!empty($sizes))
                                                                        @foreach($sizes as $itemSize)
                                                                            <label class="checkbox-inline label-right"><input type="checkbox" value="{{ $itemSize->psize_id }}" name="size[]"> {{ $itemSize->psize_code}}</label>
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @else
                                                            <tr>
                                                                <th scope="row">Bộ sưu tập</th>
                                                                <td>
                                                                    @if(!empty($collections))
                                                                        @foreach($collections as $itemCollection)
                                                                            <label class="checkbox-inline label-right"><input type="checkbox" value="{{ $itemCollection->pcollection_id }}" name="collection[]"> {{ $itemCollection->pcollection_name}}</label>
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Dưỡng chất</th>
                                                                <td>
                                                                    @if(!empty($nutritions))
                                                                        @foreach($nutritions as $itemNutritions)
                                                                            <label class="checkbox-inline label-right"><input type="checkbox" value="{{ $itemNutritions->pnutri_id }}" name="nutritions[]"> {{ $itemNutritions->pnutri_name }}</label>
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Mùi hương</th>
                                                                <td>
                                                                    @if(!empty($odorous))
                                                                        @foreach($odorous as $itemOdorous)
                                                                            <label class="checkbox-inline label-right"><input type="checkbox" value="{{ $itemOdorous->podo_id }}" name="odorous[]"> {{ $itemOdorous->podo_name}}</label>
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <th scope="row">Bật</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="statusShow" value="yes" checked="">
                                                                        <label class="form-check-label" >Có</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="statusShow" value="no">
                                                                        <label class="form-check-label">Không</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Giới tính</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="sex" value="male" checked="">
                                                                        <label class="form-check-label" >Dành cho nam</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="sex" value="female">
                                                                        <label class="form-check-label">Dành cho nữ</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Sản phẩm HOT (hiện trang chủ)</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isHot" value="yes">
                                                                        <label class="form-check-label">Có</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isHot" value="no" checked="">
                                                                        <label class="form-check-label">Không</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Sản phẩm làm quà tặng</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isGift" value="yes">
                                                                        <label class="form-check-label">Có</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isGift" value="no" checked="">
                                                                        <label class="form-check-label">Không</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Sản phẩm mới</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isNew" value="yes">
                                                                        <label class="form-check-label">Có</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isNew" value="no" checked="">
                                                                        <label class="form-check-label">Không</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Sản phẩm khuyến mãi</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isSale" value="yes">
                                                                        <label class="form-check-label">Có</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isSale" value="no" checked="">
                                                                        <label class="form-check-label">Không</label>
                                                                        <img width="45px" src="{{asset(ADMIN_CSS_AND_JAVASCRIPT_PATH) . '/dist/icons/coupon.png'}}" alt="">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Sản phẩm bán chạy</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isSelling" value="yes">
                                                                        <label class="form-check-label">Có</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isSelling" value="no" checked="">
                                                                        <label class="form-check-label">Không</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Miễn phí giao hàng</th>
                                                                <td>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isFreeShip" value="yes">
                                                                        <label class="form-check-label">Có</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="isFreeShip" value="no" checked="">
                                                                        <label class="form-check-label">Không</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-tab">
                                <div class="col-xl-12">
                                    <section class="hk-sec-wrapper">
                                        <h5 class="hk-sec-title">Ảnh đại diện</h5>
                                        <input type="file" name="imageAvatar" class="dropify" />
                                    </section>
                                    <section class="hk-sec-wrapper">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <h5 class="hk-sec-title">Ảnh thu nhỏ</h5>
                                            </div>
                                            <div class="col-md-5">
                                                <h5 class="hk-sec-title">Ảnh đầy đủ</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-outline-light btn-sm add-image"><i class="glyphicon glyphicon-plus"></i> Thêm ảnh</button>
                                            </div>
                                            <div class="box-image col-md-12">
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-related" role="tabpanel" aria-labelledby="nav-related-tab">
                                <div class="col-xl-6">
                                    <select multiple class="form-control custom-select-sm" name="related[]">
                                        @if($products->count() > 0)
                                            @foreach($products as $key => $itemProduct)
                                                <option value="{{ $itemProduct->product_id }}">{{ $itemProduct->product_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
