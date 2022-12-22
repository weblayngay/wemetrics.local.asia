<?php
    use App\Helpers\DateHelper;
    $user = !empty($data['user']) ? $data['user'] : null;
    $title = isset($data['title']) ? $data['title'] : '';
    $adminName = $data['adminName'];
    $adminId = $data['adminId'];
    $province = $data['province'];
    $birthday = DateHelper::getDate('d/m/Y', $user->birthday);
?>

@extends('backend.main')

@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.user.user_edit'])

    <form method="POST" id="admin-form" action="" enctype="multipart/form-data">
        <input type="hidden" name="action_type">
        <input type="hidden" name="id" value="{{ $user->id }}">
        <input type="hidden" name="task" value="update">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="createdBy">{{__('Được tạo bởi')}} <span class="red">*</span></label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-3">
                                    <fieldset class="form-group">
                                        <input type="text" name="createdName" class="form-control" value="{{ $adminName }}" readonly="">
                                        <input type="hidden" name="createdBy" class="form-control" value="{{ $adminId }}" readonly="">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="name">{{__('Tên người dùng')}} <span class="red">*</span></label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Tên người dùng" value="{{ $user->name }}" required="">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="gender">{{__('Giới tính')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="male" @if($user->gender == 'male') checked @endif>
                                            <label class="form-check-label" >{{__('Nam')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="female" @if($user->gender == 'female') checked @endif>
                                            <label class="form-check-label">{{__('Nữ')}}</label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="phone">{{__('Điện thoại')}} <span class="red">*</span></label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="text" name="phone" class="form-control" placeholder="Điện thoại" value="{{ $user->phone }}">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="email">{{__('Email')}} <span class="red">*</span></label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="password">{{__('Mật khẩu')}} <span class="red">*</span></label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required="">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="password_confirmation">{{__('Xác nhận mật khẩu')}} <span class="red">*</span></label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required="">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="userBirthday">{{__('Sinh nhật')}} <span class="red">*</span></label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-3">
                                    <fieldset class="form-group">
                                        <input class="form-control time-statistic" type="text" name="userBirthday" value="{{ $birthday }}" />
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="zaloId">{{__('Zalo Id')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="text" name="zaloId" class="form-control" placeholder="Zalo Id" value="{{ $user->zalo_id }}">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="facebookId">{{__('Facebook Id')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="text" name="facebookId" class="form-control" placeholder="Facebook Id" value="{{ $user->facebook_id }}">
                                    </fieldset>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="gmail">{{__('Gmail')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="text" name="gmail" class="form-control" placeholder="Gmail" value="{{ $user->gmail }}">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="address">{{__('Địa chỉ')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-10">
                                    <fieldset class="form-group">
                                        <input type="text" name="address" class="form-control" placeholder="Địa chỉ liên hệ" value="{{ $user->address }}">
                                    </fieldset>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="status">{{__('Bật')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" value="activated" @if($user->status == 'activated') checked @endif>
                                            <label class="form-check-label" >{{__('Có')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" value="inactive" @if($user->status == 'inactive') checked @endif>
                                            <label class="form-check-label">{{__('Không')}}</label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="provinceId">{{__('Tỉnh/ Thành phố')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <select class="form-control select2" id="provinceId" name="provinceId" required>
                                            <option value="">{{__('Chọn')}}</option>
                                            @if(!empty($province) && count($province) > 0)
                                                @foreach($province as $key => $item)
                                                    <option value="{{ $item->id }}" @if($item->id == $user->province_id) selected @endif>{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="districtId">{{__('Quận/ huyện')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <select class="form-control select2" id="districtId" name="districtId" required>
                                            @if($user->district_id > 0)
                                                <?php
                                                    $district = \App\Models\District::query()->where('id', $user->district_id)->first();
                                                    $districtName = !empty($district) ? $district->name : '';
                                                ?>
                                                <option value="{{ $user->district_id }}">{{ $districtName }}</option>
                                            @else
                                                <option value="">{{__('Chọn')}}</option>
                                            @endif
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="wardId">{{__('Phường/ xã')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <select class="form-control select2" id="wardId" name="wardId" required>
                                            @if($user->ward_id > 0)
                                                <?php
                                                $ward = \App\Models\Ward::query()->where('id', $user->ward_id)->first();
                                                $wardName = !empty($ward) ? $ward->name : '';
                                                ?>
                                                <option value="{{ $user->ward_id }}">{{ $wardName }}</option>
                                            @else
                                                <option value="">{{__('Chọn')}}</option>
                                            @endif
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="deliveryProvinceId">{{__('Tỉnh/ Thành phố (Shipping)')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <select class="form-control select2" id="deliveryProvinceId" name="deliveryProvinceId" required>
                                            <option value="">{{__('Chọn')}}</option>
                                            @if(!empty($province) && count($province) > 0)
                                                @foreach($province as $key => $item)
                                                    <option value="{{ $item->id }}" @if($item->id == $user->province_id) selected @endif>{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="deliveryDistrictId">{{__('Quận/ huyện (Shipping)')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <select class="form-control select2" id="deliveryDistrictId" name="deliveryDistrictId" required>
                                            @if($user->district_id > 0)
                                                <?php
                                                    $district = \App\Models\District::query()->where('id', $user->district_id)->first();
                                                    $districtName = !empty($district) ? $district->name : '';
                                                ?>
                                                <option value="{{ $user->district_id }}">{{ $districtName }}</option>
                                            @else
                                                <option value="">{{__('Chọn')}}</option>
                                            @endif
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <fieldset class="form-group">
                                        <label for="deliveryWardId">{{__('Phường/ xã (Shipping)')}}</label>
                                    </fieldset>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <select class="form-control select2" id="deliveryWardId" name="deliveryWardId" required>
                                            @if($user->ward_id > 0)
                                                <?php
                                                $ward = \App\Models\Ward::query()->where('id', $user->ward_id)->first();
                                                $wardName = !empty($ward) ? $ward->name : '';
                                                ?>
                                                <option value="{{ $user->ward_id }}">{{ $wardName }}</option>
                                            @else
                                                <option value="">{{__('Chọn')}}</option>
                                            @endif
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
