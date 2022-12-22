@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => 'Quản lý nhóm sản phẩm'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <a href="{{app('UrlHelper')->admin('productcategory', 'type?type=shoes')}}" class="btn btn-primary">Nhóm sản phẩm của GIÀY</a>
                            <a href="{{app('UrlHelper')->admin('productcategory', 'type?type=cosmetic')}}" class="btn btn-primary">Nhóm sản phẩm của MỸ PHẨM</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
