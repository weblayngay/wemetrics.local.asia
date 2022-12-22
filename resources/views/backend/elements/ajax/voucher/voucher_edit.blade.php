<script type="text/javascript">
   $(document).ready(function(){

        $('.choose-voucher-type').on('change', function(){

            var choose_id   = $(this).attr('id');
            var code        = $(this).val();
            
            if(code == 'percent')
            {
                // Sử dụng tỷ lệ
                $('#percent').val('0');
                $('#percent').trigger('change'); // Notify any JS components that the value changed
                $('#percent').prop('readonly', false);
                $('#cost').val('0'); 
                $('#cost').prop('readonly', true);  
            }
            else if(code == 'value')
            {
                // Sử dụng giá trị
                $('#cost').val('0');
                $('#cost').trigger('change'); // Notify any JS components that the value changed
                $('#cost').prop('readonly', false);
                $('#percent').val('0'); 
                $('#percent').prop('readonly', true);                                    
            }
            else
            {
                $('#cost').val('0');
                $('#cost').prop('readonly', true);
                $('#percent').val('0');
                $('#percent').prop('readonly', true); 
            }
        });

        var code = $('input[name="type"]:checked').val();

        if(code == 'percent')
        {
            // Sử dụng tỷ lệ
            $('#percent').prop('readonly', false);
            $('#cost').val('0'); 
            $('#cost').prop('readonly', true);    
        }
        else if (code == 'value')
        {
            // Sử dụng giá trị
            $('#cost').prop('readonly', false);
            $('#percent').val('0'); 
            $('#percent').prop('readonly', true);                                   
        }
        else
        {
            $('#cost').val('0');
            $('#cost').prop('readonly', true);
            $('#percent').val('0');
            $('#percent').prop('readonly', true);            
        }  
    });                   
</script>