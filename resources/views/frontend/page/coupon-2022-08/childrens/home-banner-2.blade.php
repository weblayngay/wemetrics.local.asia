@php
    $blockCode = 'home-banner-2';
    $blockBannerGroup = '';
    foreach($blocks as $key => $block_item)
    {
        if($block_item->block_code == $blockCode)
        {
            $blockBannerGroup = $block_item->block_banner_group;
            // dd($blockBannerGroup);
        }
    }
    $banners = app('Banner')->findByBannerGroupId($blockBannerGroup);
    // dd($banners);
@endphp
<section class="home-banner-2">
<div class="container"><div class="inner">
    <div class="row">
        @foreach($banners as $key => $banners_item)
            @php
                $bannerUrl =$banners_item->avatar ? config('my.path.image_banner_of_module') . $banners_item->avatar->image_name : '';
            @endphp
            <div class="col-sm-6">
                <a href="https://leeandtee.vn" class="effect_hover_image">
                    <img src="{{$bannerUrl}}" alt="See You In Me">
                    <span class="hover hover1"></span>
                    <span class="hover hover2"></span>
                    <span class="hover hover3"></span>
                    <span class="hover hover4"></span>
                </a>
            </div>
        @endforeach
        <div class="col-sm-6">
            <div class="info">
                {{__('Thương hiệu Lee&Tee được khách hàng yêu mến vì sự đơn giản, chắc chắn và chất lượng, chấm phá thêm nét cổ điển trong từng sản phẩm cùng đội ngũ nhân viên thân thiện, tận tình sẽ giúp khách hàng có những sự lựa chọn sản phẩm phù hợp nhất cho mình.')}}
                <br>
                <h2 style="color:#fff">{{__('See You')}} <br>{{__('In Me')}}</h2>
            </div>
        </div>
    </div>
</div></div>
</section>