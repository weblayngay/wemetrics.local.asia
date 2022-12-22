@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => 'Quản lý sản phẩm'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <a href="{{app('UrlHelper')->admin('product', 'index?type=shoes')}}" class="btn btn-primary">Sản phẩm GIÀY</a>
                            <a href="{{app('UrlHelper')->admin('product', 'index?type=cosmetic')}}" class="btn btn-primary">Sản phẩm MỸ PHẨM</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
