<?php
if (!in_array($actionName, ['index', 'detail'])
    || !in_array($controllerName, ['post', 'index'])
    || session()->get('is_open_popup') == 'no'
    || app('Config')->getConfig('bat-tat-popup-lien-he', '') == 'off'
){
    return false;
}

if ($timesShowContactPopup = session()->get('so-lan-hien-thi-popup-lien-he')) {
    if ( $timesShowContactPopup > app('Config')->getConfig('so-lan-hien-thi-popup-lien-he') ) {
        return false;
    }
    session()->put('so-lan-hien-thi-popup-lien-he', $timesShowContactPopup + 1);
}else{
    session()->put('so-lan-hien-thi-popup-lien-he', 1);
}
$timeDisplayContactPopup = app('Config')->getConfig('so-giay-se-bat-dau-hien-thi-popup-lien-he') * 1000;

$m_imageCategoryBanners = app('Banner')->findByBannerCode('banner_lien_he', 1);

?>

@foreach($m_imageCategoryBanners as $m_imageCategoryBanner)
    @php
        $m_imageCategoryUrl = $m_imageCategoryBanner->avatar ? config('my.path.image_banner_of_module') . $m_imageCategoryBanner->avatar->image_name : '';
    @endphp 
@endforeach

<!--<style>
    .popup_wrapper {
        background-image: url({{$m_imageCategoryUrl}})!important;
    }
    
</style>-->

<div class="popup_wrapper" style="display: none">
    <div class="test js-contact-popup" style="height: 470px;">
        <span class="popup_off">Đóng</span>
        <div class="subscribe_area text-center">
            <h2>Liên hệ với chúng tôi</h2>
            <div class="js-error-block alert alert-danger alert-wth-icon alert-dismissible text-left" role="alert" style="display: none;">
                <div class="js-content-error">
                </div>
            </div>
            <div class="js-success-block alert alert-success" role="alert" style="display: none">
                Gửi liên hệ thành công.
            </div>
            <div class="subscribe-form-group">
                <form id="popupContactForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-form-style mb-20">
                                <input name="subject" placeholder="Tiêu đề*" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-form-style mb-20">
                                <input name="name" placeholder="Họ và Tên*" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-form-style mb-20">
                                <input name="phoneNumber" placeholder="Số điện thoại*" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-form-style mb-20">
                                <input name="email" placeholder="Email*" type="email" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="contact-form-style">
                                <textarea name="content" placeholder="Lời nhắn*"></textarea>
                            </div>
                        </div>
                        <button class="js-submit" type="submit" style="margin: 0px auto">Gửi Email</button>
                        <button class="js-submit-processing"  style="margin: 0px auto; display: none">Đang xử lý</button>
                    </div>
                </form>
            </div>
            <div class="js-not-show-contact-popup subscribe-bottom mt-15">
                <input id="not-show-contact-popup" type="checkbox">
                <label for="not-show-contact-popup">Không hiển thị lại</label>
            </div>
        </div>
    </div>
</div>
@section('javascript_tag')
    @parent
    <script>
        $( document ).ready(function() {
            var mainForm = 'form#popupContactForm';
            $(mainForm + ' button.js-submit').click(function (e) {
                $('div.js-content-error').html('');
                $('button.js-submit-processing').css('display', 'block');
                $('button.js-submit').css('display', 'none');
                e.preventDefault();

                var _token      = $(mainForm + ' input[name=_token]').val();
                var subject     = $(mainForm + ' input[name=subject]').val();
                var name        = $(mainForm + ' input[name=name]').val();
                var phoneNumber = $(mainForm + ' input[name=phoneNumber]').val();
                var email       = $(mainForm + ' input[name=email]').val();
                var content     = $(mainForm + ' textarea[name=content]').val();

                $.ajax({
                    url: "/lien-he-popup",
                    type:'POST',
                    data: {_token:_token, subject:subject, name:name, email:email, phoneNumber:phoneNumber, content:content},
                    success: function(data) {
                        if(data.error){
                            $('button.js-submit-processing').css('display', 'none');
                            $('button.js-submit').css('display', 'block');

                            $('div.js-contact-popup').css('height', '600px');
                            $.each(data.error, function( index, value ) {
                                $('div.js-content-error').append(value + '<br/>');
                            });
                            $('div.js-error-block').css('display', 'block');
                        }else{
                            $('div.js-contact-popup').css('height', '520px');
                            $('div.js-error-block').css('display', 'none');
                            $('div.js-success-block').css('display', 'block');

                            $('button.js-submit-processing').css('display', 'none');

                            setTimeout(function(){
                                $( "div.js-contact-popup" ).parent().remove();
                            }, 2500);

                        }
                    }
                });
                return false;
            });


            // Không hiển thị lại popup
            $('div.js-not-show-contact-popup').click(function () {
                if ($('div.js-not-show-contact-popup input#not-show-contact-popup').is(':checked')) {
                    $.ajax({
                        url: "/tat-lien-he-popup",
                        type:'GET',
                        success: function(data) {
                            if(data.success){
                                $('div.js-contact-popup').css('display', 'none');
                                setTimeout(function(){
                                    $( "div.js-contact-popup" ).parent().remove();
                                }, 500);
                            }
                        }
                    });
                }
            });

            setTimeout(function(){
                $('div.js-contact-popup').parent().css('display', 'block');
            }, <?php echo $timeDisplayContactPopup ?>);
        });
    </script>
@endsection
