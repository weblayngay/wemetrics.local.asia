@php
    $blockCode = 'header';
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
    $hotline = app('Config')->getConfig('so-hot-line', '');
    $companyName = app('Config')->getConfig('ten-cong-ty', '');
    $companyOfficial = app('Config')->getConfig('trang-official', '');
    $companyLogo = app('Config')->getConfig('logo-cong-ty-main', '');
    // dd($companyLogo);
@endphp
<header>
    <div class="top">
        <div class="container">
            <div class="hotline"> <span>{{__('Hotline:')}} <a href="tel:{{str_replace('.','',$hotline)}}">{{$hotline}}</a></span> </div>
        </div>
    </div>
    <div class="nav-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-2">
                    <div class="logo"><a href="{{__($companyOfficial)}}" title="{{__($companyName)}}"><h1><p><img src="{{($companyLogo)}}"></p></h1></a></div>
                </div>
                <div class="col-lg-7 col-sm-8">
                    <div class="main-menu">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="slider">
        <div class="blockslideshow">
            <div class="b-inner">
                <div class="b-content">
                    <div class="slider" id="home">
                        <div id="main-slider" class="carousel">
                            <div id="carousel-example-generic1" class="carousel slide carousel-fade" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    @foreach($banners as $key => $banners_item)
                                        @php
                                            $bannerUrl =$banners_item->avatar ? config('my.path.image_banner_of_module') . $banners_item->avatar->image_name : '';
                                        @endphp
                                        <div class="item active"> 
                                            <a href="#form-get-coupon">
                                                <img src="{{$bannerUrl}}" alt="{{__($banners_item->banner_name)}}" title="" width="1920" height="884">
                                            </a>
                                            <div class="carousel-caption text-right">
                                                <h2 class="upper animation animated-item-1"><span class="text-color"></span></h2> </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>