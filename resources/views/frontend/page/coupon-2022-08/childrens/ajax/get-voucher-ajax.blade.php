<script type="text/javascript">
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        $("#form-get-coupon")[0].reset();
        $('input[name="coupon"]').hide();
        $('#btn_shopping_now').hide();
    }
    
    $(document).ready(function(){
        $('#btn_get_voucher_by_phone').click(function(){
            refreshErrorMsg();
            var frmGetCoupon = new FormData(document.getElementById("form-get-coupon")); 
            $.ajax ({
                url: '{{Route('get-voucher-by-phone-coupon-2022-08')}}',
                method: 'POST',
                data:frmGetCoupon,
                processData: false,
                contentType: false, 
                success:function(data){
                    if($.isEmptyObject(data.error))
                    {
                        releaseSuccessMsg(data.success);
                        $('input[name="coupon"]').val(data.voucherCode);
                        $('input[name="coupon"]').removeAttr('hidden');
                        $('input[name="coupon"]').show();
                        $('#btn_get_voucher_by_phone').hide();
                        $('#btn_shopping_now').removeAttr('hidden');
                        $('#btn_shopping_now').show();
                    }
                    else {
                        if($.isEmptyObject(data.voucherCode))
                        {
                            refreshSuccessMsg();
                            releaseErrorMsg(data.error);
                        }
                        else
                        {
                            refreshSuccessMsg();
                            releaseErrorMsg(data.error);
                            $('input[name="coupon"]').val(data.voucherCode);
                            $('input[name="coupon"]').removeAttr('hidden');
                            $('input[name="coupon"]').show();
                            $('#btn_get_voucher_by_phone').hide();
                            $('#btn_shopping_now').removeAttr('hidden');
                            $('#btn_shopping_now').show();
                        }
                    }
                }
            });
        });

        $('#btn_shopping_now').click(function(){
            var url = "<?php echo app('Config')->getConfig('trang-cua-hang', ''); ?>";
            window.open(url, '_blank');
        });     
    });                   
</script>