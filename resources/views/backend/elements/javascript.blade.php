@php
    $javascriptArr = [
              // 'vendors/jquery/dist/jquery.min.js',
              'vendors/popper.js/dist/umd/popper.min.js',
              // 'vendors/bootstrap/dist/js/bootstrap.min.js',
              'vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
              'vendors/jquery-image-upload/src/image-uploader.js',
              'vendors/ckeditor/ckeditor.js',
              'vendors/dropify/dist/js/dropify.min.js',
              'vendors/dropzone/dist/dropzone.js',
              'dist/js/jquery.slimscroll.js',
              'dist/js/dropdown-bootstrap-extended.js',
              'dist/js/feather.min.js',
              'vendors/jquery-toggles/toggles.min.js',
              'dist/js/toggle-data.js',
              'dist/js/init.js',
              'dist/js/custom-admin.js',
              'dist/js/form-file-upload-data.js',
              'vendors/moment/min/moment.min.js',
              'vendors/daterangepicker/daterangepicker.js',
              'dist/js/daterangepicker-data.js',
              'vendors/datatables.net/js/jquery.dataTables.min.js',
              'vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
              'vendors/datatables.net-dt/js/dataTables.dataTables.min.js',
              'vendors/datatables.net-buttons/js/dataTables.buttons.min.js',
              'vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js',
              'vendors/datatables.net-buttons/js/buttons.flash.min.js',
              'vendors/jszip/dist/jszip.min.js',
              'vendors/pdfmake/build/pdfmake.min.js',
              'vendors/pdfmake/build/vfs_fonts.js',
              'vendors/datatables.net-buttons/js/buttons.html5.min.js',
              'vendors/datatables.net-buttons/js/buttons.print.min.js',
              'vendors/datatables.net-responsive/js/dataTables.responsive.min.js',
              'vendors/bootstrap-confirm/bootstrap-confirm-delete.js',
              'dist/js/dataTables-data.js',
              'vendors/select2/dist/js/select2.full.min.js',
              'vendors/jquery.lazy/jquery.lazy.js',
              'vendors/jquery.lazy/jquery.lazy.min.js',
              'vendors/jquery.lazy/jquery.lazy.plugins.js',
              'vendors/jquery.lazy/jquery.lazy.plugins.min.js',
              'dist/js/select2-data.js',
              'dist/js/my/style.js',
          ];
@endphp

@php
    $javascriptArrFrest = [
              'vendors/frest/dist/vendors/js/charts/apexcharts.min.js',
              
              // BEGIN: Vendor JS
              'vendors/frest/dist/vendors/js/vendors.min.js',
              // END: Vendor JS

              // BEGIN: Theme JS
              'vendors/frest/dist/js/core/app-menu.js',
              'vendors/frest/dist/js/core/app.js',
              'vendors/frest/dist/js/scripts/components.js',
              'vendors/frest/dist/js/scripts/footer.js',
              // END: Theme JS
          ];
@endphp

@php
    $javascriptArrFontawesome = [
            // BEGIN: fontawesome v6
            'vendors/fontawesome/v6/dist/js/fontawesome.js',
            // 'vendors/fontawesome/v6/dist/js/all.js',
            'vendors/fontawesome/v6/dist/js/brands.js',
            'vendors/fontawesome/v6/dist/js/solid.js',
            'vendors/fontawesome/v6/dist/js/duotone.js',
            'vendors/fontawesome/v6/dist/js/light.js',
            'vendors/fontawesome/v6/dist/js/regular.js',
            'vendors/fontawesome/v6/dist/js/sharp-solid.js',
            'vendors/fontawesome/v6/dist/js/thin.js',
            'vendors/fontawesome/v6/dist/js/v4-shims.js',
            // 'vendors/fontawesome/v6/dist/js/conflict-detection.js',
            // END: fontawesome v6
          ];
@endphp

@section('javascript_tag')
    @foreach($javascriptArrFrest as $javascript)
        <script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $javascript. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}"></script>
    @endforeach
    @foreach($javascriptArrFontawesome as $javascript)
        <script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $javascript. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}"></script>
    @endforeach
    @foreach($javascriptArr as $javascript)
        <script src="{{@asset(ADMIN_CSS_AND_JAVASCRIPT_PATH . $javascript. '?v=' . ADMIN_CSS_AND_JAVASCRIPT_VERSION)}}"></script>
    @endforeach
    <script>
        $('img.js-lazy-loading').each(function( index ) {
            var dataSrc = $(this).data('src');
            if (dataSrc) {
                $(this).attr('src', dataSrc);
            }
        });

      // Function Symbol number
      function abbreviateNumber(number){

        // Synmbol
        var SI_SYMBOL = ["", "k", "M", "B", "T", "P", "E"];

          if (number < 1000) return number;
                    
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
