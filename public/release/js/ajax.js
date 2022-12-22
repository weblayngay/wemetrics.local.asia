$(document).ready(function(){
    /**
     * add
     */
    $(document.body).on('click', '.add-to-cart', function(event) {
        event.preventDefault();

        var data = {};
        data.quantity = $('.qty').val();
        data.id = $(this).data('id');
        data.type = $(this).data('type');


        if(data.type == 'shoes'){
            if ($('#colorId').val() !== undefined ) {
                data.color_id = $('#colorId').val();
            }
            if ($('#sizeId').val() !== undefined ) {
                data.size_id = $('#sizeId').val();
            }
        }


        $.ajax({
            method: "GET",
            url: "/add-cart",
            data: data,
            success : function(response){
                var response = JSON.parse(response);

                var count = response.countCart;
                var message = response.textMessage;
                var htmlList = response.htmlList;
                var htmlListHeader = response.htmlListHeader;
                var htmlTotal = response.htmTotal;

                $('#table-shopping-cart tbody tr').remove();
                $('#table-shopping-cart tbody').append(htmlList);

                $('ul.cart-dropdown li div').remove();
                $('ul.cart-dropdown li').append(htmlListHeader);

                $('div.cart-page-total h2').remove();
                $('div.cart-page-total ul').remove();
                $('div.cart-page-total a').remove();
                $('div.cart-page-total').append(htmlTotal);

                $('#countCart').text('('+ count +')');

                $.toast({
                    heading: 'Thêm vào giỏ hàng thành công',
                    text: message,
                    position: 'top-right',
                    icon: 'success'
                });
            }
        });
    });

    /**
     * add quick
     */
    $(document.body).on('click', '.add-to-cart-quick', function(event) {
        event.preventDefault();

        var data = {};
        data.quantity = $('.qtyQuick').val();
        data.id = $(this).data('id');
        data.type = $(this).data('type');


        if(data.type == 'shoes'){
            if ($('#colorId').val() !== undefined ) {
                data.color_id = $('#colorId').val();
            }
            if ($('#sizeId').val() !== undefined ) {
                data.size_id = $('#sizeId').val();
            }
        }


        $.ajax({
            method: "GET",
            url: "/add-cart",
            data: data,
            success : function(response){
                var response = JSON.parse(response);

                var count = response.countCart;
                var message = response.textMessage;
                var htmlList = response.htmlList;
                var htmlListHeader = response.htmlListHeader;
                var htmlTotal = response.htmTotal;

                $('#table-shopping-cart tbody tr').remove();
                $('#table-shopping-cart tbody').append(htmlList);

                $('ul.cart-dropdown li div').remove();
                $('ul.cart-dropdown li').append(htmlListHeader);

                $('div.cart-page-total h2').remove();
                $('div.cart-page-total ul').remove();
                $('div.cart-page-total a').remove();
                $('div.cart-page-total').append(htmlTotal);

                $('#countCart').text('('+ count +')');

                $.toast({
                    heading: 'Thêm vào giỏ hàng thành công',
                    text: message,
                    position: 'top-right',
                    icon: 'success'
                });
            }
        });
    });

    /**
     * remove
     */
    $(document.body).on('click', '.raavin-product-remove a', function(event) {
        event.preventDefault();
        var id = $(this).data('id');

        var data = {};
        data.id = id;
        $.ajax({
            method: "GET",
            url: "/remove-item-cart",
            data: data,
            success : function(response){
                var response = JSON.parse(response);

                var count = response.countCart;
                var message = response.textMessage;
                var htmlList = response.htmlList;
                var htmlListHeader = response.htmlListHeader;
                var htmlTotal = response.htmTotal;

                $('#table-shopping-cart tbody tr').remove();
                $('#table-shopping-cart tbody').append(htmlList);

                $('ul.cart-dropdown li div').remove();
                $('ul.cart-dropdown li').append(htmlListHeader);

                $('div.cart-page-total h2').remove();
                $('div.cart-page-total ul').remove();
                $('div.cart-page-total a').remove();
                $('div.cart-page-total').append(htmlTotal);

                $('#countCart').text('('+ count +')');

                $.toast({
                    heading: 'Xóa sản phẩm khỏi giỏ thành công',
                    text: message,
                    position: 'top-right',
                    icon: 'success'
                });

                if (response.totalPrice == 0) {
                    location.reload();
                }
            }
        });
    });

    /**
     * update
     */
    $(document.body).on('click', '.raavin-product-quantity input', function(event) {
        event.preventDefault();
        var quantity = $(this).val();
        var id = $(this).data('id');

        var data = {};
        data.id = id;
        data.quantity = quantity;
        $.ajax({
            method: "GET",
            url: "/update-cart",
            data: data,
            success : function(response){
                var response = JSON.parse(response);

                var count = response.countCart;
                var message = response.textMessage;
                var htmlList = response.htmlList;
                var htmlListHeader = response.htmlListHeader;
                var htmlTotal = response.htmTotal;

                $('#table-shopping-cart tbody tr').remove();
                $('#table-shopping-cart tbody').append(htmlList);

                $('ul.cart-dropdown li div').remove();
                $('ul.cart-dropdown li').append(htmlListHeader);

                $('div.cart-page-total h2').remove();
                $('div.cart-page-total ul').remove();
                $('div.cart-page-total a').remove();
                $('div.cart-page-total').append(htmlTotal);

                $('#countCart').text('('+ count +')');

                $.toast({
                    heading: 'Cập nhật giỏ hàng thành công',
                    text: message,
                    position: 'top-right',
                    icon: 'success'
                });
            }
        });
    });

    /**
     * add wish
     */
    $(document.body).on('click', '.add-to-wish', function(event) {
        event.preventDefault();
        var data = {};
        data.id = $(this).data('id');

        $.ajax({
            method: "GET",
            url: "/add-wish",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var message = response.textMessage;
                $.toast({
                    heading: 'Thêm vào yêu thích thành công',
                    text: message,
                    position: 'top-right',
                    icon: 'success'
                });
            }
        });
    });

    /**
     * remove wish list
     */
    $(document.body).on('click', '.raavin-product-remove-wish-list a', function(event) {
        event.preventDefault();
        var id = $(this).data('id');

        var data = {};
        data.id = id;
        $.ajax({
            method: "GET",
            url: "/remove-item-wish",
            data: data,
            success : function(response){
                var response = JSON.parse(response);

                var message = response.textMessage;
                var htmlListWish = response.htmlListWish;
                $('#table-wish-list tbody tr').remove();
                $('#table-wish-list tbody').append(htmlListWish);

                $.toast({
                    heading: 'Xóa khỏi yêu thích thành công',
                    text: message,
                    position: 'top-right',
                    icon: 'success'
                });
            }
        });
    });

    /**
     * use voucher
     */
    $(document.body).on('click', '.btn-use-voucher', function(event) {
        event.preventDefault();
        var voucher = $('#voucher').val();
        voucher = $.trim(voucher);
        //
        var data = {};
        data.voucher = voucher;
        $.ajax({
            method: "GET",
            url: "/use-voucher",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var message = response.textMessage;
                var errorMessage = response.errorMessage;
                var discount = response.discount;
                var total = response.total;
                $("#errorMessageVoucher").text(errorMessage);
                $("#discount").text(discount + ' đ');
                $("#totalCart").text(total + ' đ');
                //
                var iconToast = '';
                if(discount != '0')
                {
                    iconToast = 'success';
                }
                else
                {
                    iconToast = 'error';
                }
                //
                $('#voucher').val(voucher);
                $.toast({
                    heading: 'Sử dụng mã giảm giá',
                    text: message,
                    position: 'top-right',
                    icon: iconToast
                });
            }
        });
    });

    $(document.body).on('change', '#provinceId', function(event) {
        event.preventDefault();
        var id = $(this).val();

        var data = {};
        data.id = id;
        $.ajax({
            method: "GET",
            url: "/get-district",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                $('#districtId option').remove();
                $('#districtId').append(html);
            }
        });
    });


    $(document.body).on('change', '#districtId', function(event) {
        event.preventDefault();
        var id = $(this).val();

        var data = {};
        data.id = id;

        $.ajax({
            method: "GET",
            url: "/get-ward",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                $('#wardId option').remove();
                $('#wardId').append(html);
            }
        });
    });


    $(document.body).on('change', '#provinceIdTwo', function(event) {
        event.preventDefault();
        var id = $(this).val();

        var data = {};
        data.id = id;
        $.ajax({
            method: "GET",
            url: "/get-district",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                $('#districtIdTwo option').remove();
                $('#districtIdTwo').append(html);
            }
        });
    });


    $(document.body).on('change', '#districtIdTwo', function(event) {
        event.preventDefault();
        var id = $(this).val();

        var data = {};
        data.id = id;

        $.ajax({
            method: "GET",
            url: "/get-ward",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                $('#wardIdTwo option').remove();
                $('#wardIdTwo').append(html);
            }
        });
    });

    /**
     * show model view
     */
    $(document.body).on('click', '.rav-quickviewbtn a', function(event) {
        var product_id = $(this).data('id');

        var data = {};
        data.id = product_id;

        $.ajax({
            method: "GET",
            url: "/san-pham/modal",
            data: data,
            success : function(response){
                var response = JSON.parse(response);
                var html = response.html;

                $('.modal .modal-body .row div').remove();
                $('.modal .modal-body .row').append(html);
                $('.modal').modal('show');



                $('.single-slide-menu').owlCarousel({
                    smartSpeed: 1000,
                    nav: false,
                    responsive: {
                        0: {
                            items: 3
                        },
                        450: {
                            items: 3
                        },
                        768: {
                            items: 4
                        },
                        1000: {
                            items: 4
                        },
                        1200: {
                            items: 4
                        }
                    }
                });
                $('.modal').on('shown.bs.modal', function (e) {
                    $('.single-slide-menu').resize();
                })

                $('.single-slide-menu a').on('click',function(e){
                    e.preventDefault();

                    var $href = $(this).attr('href');

                    $('.single-slide-menu a').removeClass('active');
                    $(this).addClass('active');

                    $('.product-details-large .tab-pane').removeClass('active show');
                    $('.product-details-large '+ $href ).addClass('active show');

                })
            }
        });
    });

});


