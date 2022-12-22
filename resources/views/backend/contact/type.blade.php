@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => 'Quản Lý Liên Hệ Facebook, Zalo, Phone'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <a href="{{app('UrlHelper')->admin('contact', 'index?type=facebook')}}" class="btn btn-primary">Liên Hệ Facebook</a>
                            <a href="{{app('UrlHelper')->admin('contact', 'index?type=zalo')}}" class="btn btn-primary">Liên Hệ Zalo</a>
                            <a href="{{app('UrlHelper')->admin('contact', 'index?type=phone')}}" class="btn btn-primary">Liên Hệ Phone</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
