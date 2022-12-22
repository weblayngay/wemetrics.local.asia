@php
    $blockCode = 'stl-bottom';
    $hotline = app('Config')->getConfig('so-hot-line', '');
    $saleline = app('Config')->getConfig('dien-thoai-dat-hang', '');
    $registerBCT = app('Config')->getConfig('dang-ky-bo-cong-thuong', '');
    $companyName = app('Config')->getConfig('ten-cong-ty', '');
    $companyOfficial = app('Config')->getConfig('trang-official', '');
    $companyLogo = app('Config')->getConfig('logo-cong-ty-main', '');
    $companyLicense = app('Config')->getConfig('giay-phep-kinh-doanh', '');
    $companyDepartment = app('Config')->getConfig('tru-so-chinh', '');
    $companyEmail = app('Config')->getConfig('email-cong-ty', '');
    // dd($companyLogo);
@endphp
<div id="stl-bottom">
    <div class="container">
        <div class="row">
            <div class="blocknewsletter col-sm-5">
                <div class="b-inner">
                    <div class="b-content">
                        <div class="b-title">{{__('Tham gia cộng đồng #LeeandTeeCommunity')}}</div>
                        <div class="title">{{__('Đồng hành cùng chúng tôi')}}</div>
                        <ul class="social-icons">
                            <li><a href="https://www.facebook.com/leeandtee" target="_blank" rel="nofollow"><i class="fa-customize-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/leeandteeofficial/" target="_blank" rel="nofollow"><i class="fa-customize-instagram"></i></a></li>
                            <li><a href="https://www.tiktok.com/@lee_and_tee?" target="_blank" rel="nofollow"><i class="fa-customize-tiktok"></i></a></li>
                            <li><a href="https://www.youtube.com/user/LeeandTeevn" target="_blank" rel="nofollow"><i class="fa-customize-youtube"></i></a></li>
                            <li><a href="https://zalo.me/1352890198216527308" target="_blank" rel="nofollow"><i class="fa-customize-zalo"></i></a></li>
                            <li><a href="https://www.pinterest.com/leeandteevnn" target="_blank" rel="nofollow"><i class="fa-customize-pinterest"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/leeandteevn/" target="_blank" rel="nofollow"><i class="fa-customize-linkedin"></i></a></li>
                            <li><a href="https://twitter.com/leeandteevn" target="_blank" rel="nofollow"><i class="fa-customize-twitter"></i></a></li>
                        </ul>
                        <a href="{{__($registerBCT)}}" target="_blank"><img alt="dang-ky-bo-cong-thuong" title="" src="https://leeandtee.vn/images/logoSaleNoti.png" style="max-width:150px;"></a>
                    </div>
                </div>
            </div>
            <div class="blockcontact col-sm-3">
                <div class="b-inner">
                    <h4 class="b-title">{{__('Liên hệ chúng tôi')}}</h4>
                    <div class="b-content">
                        <p class="contact"><strong>{{__($companyName)}}</strong></p>
                        <p class="contact">{{__($companyLicense)}}</p>
                        <p class="contact">Trụ sở: {{__($companyDepartment)}}</p>
                        <p class="contact"><strong></strong>{{__('Hotline: ')}}<span><span><b>{{__($hotline)}}</b></span></span>
                        </p>
                        <p class="contact">Email: {{__($companyEmail)}}</p>
                        <p class="contact"><span><span></span></span>{{__('ĐT đặt hàng: ')}}<strong><b><b>{{__($saleline)}}</b></b></strong></p>
                    </div>
                </div>
            </div>
            <div class="block col-sm-2">
                <div class="b-inner">
                    <h4 class="b-title">{{__('Về chúng tôi')}}</h4>
                    <div class="b-content">
                        <ul class="menu">
                            <li><a href="https://leeandtee.vn/gioi-thieu-leetee.html">{{__('Giới thiệu')}}</a></li>
                            <li><a href="https://leeandtee.vn/he-thong-cua-hang-leetee.html">{{__('Chuỗi cửa hàng')}}</a></li>
                            <li><a href="https://leeandtee.vn/lien-he.html">{{__('Liên hệ')}}</a></li>
                            <li><a href="https://leeandtee.vn/tuyen-dung.html">{{__('Tuyển dụng')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="block col-sm-2">
                <div class="b-inner">
                    <h4 class="b-title">{{__('Dịch vụ khách hàng')}}</h4>
                    <div class="b-content">
                        <ul class="menu">
                            <li><a href="https://leeandtee.vn/huong-dan-mua-hang.html">{{__('Hướng dẫn mua hàng')}}</a></li>
                            <li><a href="https://leeandtee.vn/huong-dan-doi-tra-hang.html">{{__('Hướng dẫn đổi trả hàng')}}</a></li>
                            <li><a href="https://leeandtee.vn/chinh-sach-bao-hanh-va-doi-tra.html">{{__('Chính sách bảo hành và đổi trả')}}</a></li>
                            <li><a href="https://leeandtee.vn/chinh-sach-van-chuyen.html">{{__('Chính sách vận chuyển')}}</a></li>
                            <li><a href="https://leeandtee.vn/cau-hoi-thuong-gap.html">{{__('Câu hỏi thường gặp')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br class="break"> </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="blockftmenu col-sm-6">
                    <div class="b-inner">
                        <div class="b-content">
                            <ul class="menu">
                                <li><a href="https://leeandtee.vn/chinh-sach-bao-mat-thanh-toan.html" style="color:#fff;">{{__('Chính sách bảo mật thanh toán')}}</a></li>
                                <li><a href="https://leeandtee.vn/chinh-sach-bao-mat.html" style="color:#fff;">{{__('Chính sách bảo mật')}}</a></li>
                                <li><a href="https://leeandtee.vn/ban-hang-su-dung-leeandtee-affiliate.html" style="color:#fff;">{{__('Bán hàng sử dụng Lee&Tee Affiliate')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="blockcopyright col-sm-6">
                    <div class="b-inner">
                        <div class="b-content">
                            <p style="text-align: justify; color:#fff;">{{__('Phương thức thanh toán và Đơn vị vận chuyển')}}</p>
                            <p style="text-align: justify; color:#fff;"><img src="https://leeandtee.vn/uploads/images/test/thanhtoan1-2021.png"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>