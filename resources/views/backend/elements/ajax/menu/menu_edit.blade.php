<script type="text/javascript">
   $(document).ready(function(){

        $('.choose-menu-type').on('change', function(){

            var choose_id   = $(this).attr('id');
            var code        = $(this).val();
            
            if(code == 'static')
            {
                // Sử dụng url tĩnh
                $('.static-url').show();
                $('.dynamic-url').hide();
            }
            else if(code == 'dynamic')
            {
                // Sử dụng url động
                $('.static-url').hide();
                $('.dynamic-url').show();                                 
            }
            else
            {
                // Sử dụng url tĩnh
                $('.static-url').show();
                $('.dynamic-url').hide();
            }
        });

        var code = $('input[name="type"]:checked').val();

        if(code == 'static')
        {
            // Sử dụng url tĩnh
            $('.static-url').show();
            $('.dynamic-url').hide();
        }
        else if(code == 'dynamic')
        {
            // Sử dụng url động
            $('.static-url').hide();
            $('.dynamic-url').show();                                 
        }
        else
        {
            // Sử dụng url tĩnh
            $('.static-url').show();
            $('.dynamic-url').hide();
        }
    });                   
</script>