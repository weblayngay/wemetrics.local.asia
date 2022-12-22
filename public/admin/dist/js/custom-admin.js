$( document ).ready( function( ) {
    $.ajaxSetup({'cache':true});

    if ($("#editor_short").length > 0) {
        CKEDITOR.replace('editor_short', {
            height: '400px',
        });
    }
    if ($("#editor").length > 0) {
        CKEDITOR.replace('editor', {
            height: '400px',
        });
    }
    if ($("#editor_email_content").length > 0) {
        CKEDITOR.replace('editor_email_content', {
            height: '400px',
        });
    }
    if ($("#editor_short_en").length > 0) {
        CKEDITOR.replace('editor_short_en', {
            height: '400px',
        });
    }
    if ($("#editor_en").length > 0) {
        CKEDITOR.replace('editor_en', {
            height: '400px',
        });
    }
    if ($("#editor_email_content_en").length > 0) {
        CKEDITOR.replace('editor_email_content_en', {
            height: '400px',
        });
    }

    $( "input[name='type']" ).on('change', function() {
        var value = this.value;

        if(value == 'shoes'){
            $('.tr-shoes').css("display", "block");
            $('.tr-cosmetic').css("display", "none");
        }
        if(value == 'cosmetic'){
            $('.tr-shoes').css("display", "none");
            $('.tr-cosmetic').css("display", "block");
        }
    });

    // /** upload ảnh*/
    // if ($(".input-images-1").length > 0) {
    //     $('.input-images-1').imageUploader({
    //         imagesInputName: 'imageSmall',
    //         preloadedInputName: 'old'
    //     });
    // }
    //
    // if ($(".input-images-2").length > 0) {
    //     $('.input-images-2').imageUploader({
    //         imagesInputName: 'imageBig',
    //         preloadedInputName: 'old'
    //     });
    // }

    $('.add-image').click(function(e) {
        e.preventDefault();

        var check = $('.box-image').find('.box-item');
        var temp = 1;
        if(check.length > 0){
            var last = $(".box-image .box-item").last()
            temp = parseInt(last.data('index')) + 1;
        }

        $.ajax({
            url: '/admins/productcolor/list',
            type: 'GET',
            cache: false,
            success: function(data){
                var html = '<div class="box-item" data-index="'+temp+'">'
                            +'<div class="row">'
                                +'<div class="col-md-4">'
                                    +'<input type="file" name="imageThumbnail[]" class="dropify"/>'
                                +'</div>'
                                +'<div class="col-md-4">'
                                    +'<input type="file" name="imageBanner[]" class="dropify" />'
                                +'</div>'
                                +'<div class="col-md-3">'
                                    +data
                                +'</div>'
                                +'<div class="col-md-1">'
                                    +'<span class="delete-image"><i class="glyphicon glyphicon-remove"></i></span>'
                                +'</div>'
                            +'</div>'
                        +'</div>';

                $('.box-image').append(html);
                $('.dropify').dropify();
            },
            error: function (error){
               console.log(error);
            }
        });
    });

    $(document.body).on('click', '.delete-image', function() {
        var item = $(this).closest('.box-item');
        item.remove();
    });

    /**
     * change provinceId
     */
    $(document.body).on('change', '#provinceId', function(event) {
        event.preventDefault();
        var id = $(this).val();

        var data = {};
        data.id = id;
        $.ajax({
            method: "GET",
            url: "/admins/user/get-user-district",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                $('#districtId option').remove();
                $('#districtId').append(html);
            }
        });
    });

    /**
     * change districtId
     */
    $(document.body).on('change', '#districtId', function(event) {
        event.preventDefault();
        var id = $(this).val();

        var data = {};
        data.id = id;

        $.ajax({
            method: "GET",
            url: "/admins/user/get-user-ward",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                console.log(html);

                $('#wardId option').remove();
                $('#wardId').append(html);
            }
        });
    });

    /**
     * change delivery ProvinceId
     */
    $(document.body).on('change', '#deliveryProvinceId', function(event) {
        event.preventDefault();
        var id = $(this).val();

        var data = {};
        data.id = id;
        $.ajax({
            method: "GET",
            url: "/admins/user/get-user-district",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                $('#deliveryDistrictId option').remove();
                $('#deliveryDistrictId').append(html);
            }
        });
    });

    /**
     * change delivery DistrictId
     */
    $(document.body).on('change', '#deliveryDistrictId', function(event) {
        event.preventDefault();
        var id = $(this).val();

        var data = {};
        data.id = id;

        $.ajax({
            method: "GET",
            url: "/admins/user/get-user-ward",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                console.log(html);

                $('#deliveryWardId option').remove();
                $('#deliveryWardId').append(html);
            }
        });
    });

    /* Single table*/
    $('.time-statistic').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        "cancelClass": "btn-secondary",
        locale: {
            format: 'DD-MM-YYYY'
        }
    }, function(start, end, label) {
        var years = moment().diff(start, 'years');
    });
});
