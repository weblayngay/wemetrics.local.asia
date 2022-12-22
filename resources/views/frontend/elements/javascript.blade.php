@php
    $javascriptArr = [
              'js/vendor/jquery-1.12.4.min.js',
              'js/vendor/popper.min.js',
              'js/bootstrap.min.js',
              'js/jquery.meanmenu.min.js',
              'js/wow.min.js',
              'js/slick.min.js',
              'js/jquery.nivo.slider.js',
              'js/owl.carousel.min.js',
              'js/jquery.magnific-popup.min.js',
              'js/isotope.pkgd.min.js',
              'js/imagesloaded.pkgd.min.js',
              'js/jquery.mixitup.min.js',
              'js/jquery.countdown.min.js',
              'js/jquery.counterup.min.js',
              'js/waypoints.min.js',
              'js/jquery.barrating.min.js',
              'js/jquery-ui.min.js',
              'js/venobox.min.js',
              'js/jquery.nice-select.min.js',
              'js/scrollUp.min.js',
              'js/jquery.toast.js',
              'js/custom.js',
              'js/ajax.js',
              'js/main.js',
              'js/fontawesome.v5.15.3/all.js',
              'js/fontawesome.v5.15.3/v4-shims.js'
          ];
@endphp

@section('javascript_tag')
    @foreach($javascriptArr as $javascript)
        <script src="{{@asset(FRONTEND_CSS_AND_JAVASCRIPT_PATH . $javascript. '?v=' . FRONTEND_CSS_AND_JAVASCRIPT_VERSION)}}"></script>
    @endforeach
    <script>
         $('img.js-lazy-loading').each(function( index ) {
             var dataSrc = $(this).data('src');
             if (dataSrc) {
                 $(this).attr('src', dataSrc);
             }
        });
    </script>
@show

@section('custom-javascript')
  <script type="text/javascript"> 
    //Function refresh notification
    function refreshErrorMsg() {
      $(".notification-error").css('display','none');
    }

    function refreshSuccessMsg() {
      $(".notification-success").css('display','none');
    }
           
    //Function trả dữ liệu thông báo
    function releaseErrorMsg (msg) {
        $(".notification-error").find("ul").html('');
        $(".notification-error").css('display','block');
        if($.isArray(msg))
        {
            $.each( msg, function( key, value ) {
                $(".notification-error").find("ul").append('<li><i class="bx bx-error"></i><span>'+value+'</span></li>'); 
            });                
        }
        else
        {
            $(".notification-error").find("ul").append('<li><i class="bx bx-error"></i><span>'+msg+'</span></li>');
        }
    }

    function releaseSuccessMsg (msg) {
        $(".notification-success").find("ul").html('');
        $(".notification-success").css('display','block');
        if($.isArray(msg))
        {
            $.each( msg, function( key, value ) {
                $(".notification-success").find("ul").append('<li><i class="bx bx-success"></i><span>'+value+'</span></li>'); 
            });                
        }
        else
        {
            $(".notification-success").find("ul").append('<li><i class="bx bx-success"></i><span>'+msg+'</span></li>');
        }
    }

    //Function format date
    function formatDate(date) {
          var purchaseDate = new Date(date);
          var dd = purchaseDate.getDate();
          var MM = purchaseDate.getMonth();
          MM += 1;  // JavaScript months are 0-11
          var YYYY = purchaseDate.getFullYear();
      if (dd < 10) dd = "0" + dd;
      if (MM < 10) MM = "0" + MM;
          var result = dd + "/" + MM + "/" + YYYY;
          if(result == "NaN/NaN/NaN")
          {
            result = "Chưa xác định";
          }
          return result;
    }

    //Function format currency
    function formatCurrency(amount) {
      var nf = new Intl.NumberFormat("vi-VN", {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0,
        maximumFractionDigits: 3
      });
      var result;
      result = nf.format(amount);
      return result;
    }

    //Function format quantity
    function formatQuantity(quantity) {
      var nf = new Intl.NumberFormat("vi-VN", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 3
      });
      var result;
      result = nf.format(quantity);
      return result;
    }

    
    // Function Symbol number
    function abbreviateNumber(number){

      // Synmbol
      var SI_SYMBOL = ["", "k", "M", "B", "T", "P", "E"];

        // what tier? (determines SI symbol)
        var tier = Math.log10(Math.abs(number)) / 3 | 0;

        // if zero, we don't need a suffix
        if(tier == 0) return number;

        // get suffix and determine scale
        var suffix = SI_SYMBOL[tier];
        var scale = Math.pow(10, tier * 3);

        // scale the number
        var scaled = number / scale;

        // format number and add suffix
        return scaled.toFixed(1) + suffix;
    }
  </script>
@show
