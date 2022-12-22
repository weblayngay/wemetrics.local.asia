@php
    $blockCode = 'form-get-coupon';
    foreach($blocks as $key => $block_item)
    {
        if($block_item->block_code == $blockCode)
        {
            $description = $block_item->block_description;
            // dd($description);
        }
    }
    $campaignType = 'use-phone';
    // dd($banners);
@endphp
@if($campaign->campaign_is_ended == 'no')
<div class="contact-area">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-md-3">
            </div>
            <div class="col-md-8">
                <div class="contact-form-wrap">
                    <div class="contact-form-style mt-20 ml-20 mr-20">
                        <h5 class="contact-title">{{__('Nhận ngay mã quà tặng siêu khủng từ nhà Tee')}}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            @include('frontend.elements.notify')
                        </div>
                    </div>
                    <form name="form-get-coupon" id="form-get-coupon" method="post" enctype="multipart/form-data" class="ml-20 mr-20">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                @if($campaignType == 'use-phone')
                                    <div class="contact-form-style mb-20">
                                        <input id="phoneNumber" name="phoneNumber" placeholder="Số điện thoại*" type="tel">
                                    </div>
                                @else
                                    <div class="contact-form-style mb-20">
                                        <input id="email" name="email" placeholder="Email*" type="email">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="contact-form-style">
                                    <div class="contact-form-style mb-20">
                                        <input id="coupon" name="coupon" placeholder="Mã coupon" type="text" readonly="" hidden="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="contact-form-style">
                                    <div class="contact-form-style mb-20">
                                        <button class="form-button" type="button" class="btn-save" name="btn-get-voucher-by-phone" id="btn_get_voucher_by_phone" value="btn-save"><span>{{__('Nhận coupon ngay')}}</span></button>
                                    </div>

                                    <div class="contact-form-style mb-20">
                                        <button class="form-button" type="button" class="btn-save" name="btn-shopping-now" id="btn_shopping_now" value="btn-save" hidden=""><span>{{__('Mua hàng ngay')}}</span></button>
                                    </div>
                                </div>
                            </div>
                            <input class="from-control" type="hidden" id="ip" name="ip">
                            <input class="from-control" type="hidden" id="browser" name="browser">
                            <input class="from-control" type="hidden" id="versionBrowser" name="versionBrowser">
                            <input class="from-control" type="hidden" id="deviceType" name="deviceType">
                            <input class="from-control" type="hidden" id="platform" name="platform">
                            <input class="from-control" type="hidden" id="versionPlatform" name="versionPlatform">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-1">
            </div>
        </div>
    </div>
</div>
@else
<div class="contact-area">
    <div class="container-fluid p-0">
        <form name="form-get-coupon" id="form-get-coupon" method="post" enctype="multipart/form-data" class="ml-20 mr-20">
        @csrf
            <div class="row no-gutters">
                <div class="col-md-3">
                </div>
                <div class="col-md-8">
                    <div class="contact-form-wrap">
                        <div class="contact-form-style mt-20 ml-20 mr-20">
                            <h5 class="contact-title">{{__('Chương trình đã kết thúc. Cám ơn khách hàng đã ủng hộ nhà Tee')}}</h5>
                            <p>{{__('Sắp tới sẽ còn rất nhiều chương trình khuyến mãi cực kỳ hấp dẫn đến từ nhà Tee. 
                                Các khách hàng yêu chuộng và ủng hộ sản phẩm của Lee&Tee hãy tham gia và nhận nhiều ưu đãi nhé.')}}</p>
                            <p><strong>{{__('Chọn xem sản phẩm để xem thêm nhiều sản phẩm thương hiệu Lee&Tee. Xin cám ơn.')}}</strong></p>
                            <div class="contact-form-style mb-20">
                                <a href="<?php echo app('Config')->getConfig('trang-cua-hang', ''); ?>" target="_blank"><button class="form-button" type="button" class="btn-save" value="btn-save"><span>{{__('Xem sản phẩm')}}</span></button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
        </form>
    </div>
</div>
@endif