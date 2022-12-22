$( document ).ready( function( ) {
    $.ajaxSetup({'cache': true});

    $(document.body).on('click', '.btn-reply', function() {
        var level = $(this).data('level');
        var id = $(this).data('id');

        $("#level").val(level);
        $("#parentId").val(id);
    });

    $(document.body).on('click', '.select-product-color', function() {
        var id = $(this).data('id');
        $("#colorId").val(id);

        $('.select-product-color').removeClass('color-active');
        $(this).addClass('color-active');
    });

    $(document.body).on('click', '.select-product-size', function() {
        var id = $(this).data('id');
        $("#sizeId").val(id);

        $('.select-product-size').removeClass('size-active');
        $(this).addClass('size-active');
    });

    $(document.body).on('change', "input[name='gift']", function() {
        var value = $(this).val();

        if(value == 'yes'){
            $('#infor-user-gift').css('display', 'block');
        }else{
            $('#infor-user-gift').css('display', 'none');
        }
    });

});
