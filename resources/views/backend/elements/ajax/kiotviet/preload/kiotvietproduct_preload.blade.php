@php
	use App\Helpers\DateHelper;
	//
	$action = !empty($data['action']) ? $data['action'] : 'index';
    //
	$branch = !empty($data['branch']) ? $data['branch'] : '%';
	$cateProduct = !empty($data['cateProduct']) ? $data['cateProduct'] : '%';
	$code = !empty($data['code']) ? $data['code'] : '';
	$name = !empty($data['name']) ? $data['name'] : '';
	//
	$indexUrl = app('UrlHelper')::admin('kiotvietProduct', 'index').'?branch='.$branch.'&code='.$code.'&name='.$name.'&cateProduct='.$cateProduct;
	//
@endphp
<script type="text/javascript">
$(document).ready(function(){
	@if($action == 'index')
	    // Redirect the user to where they want to go after 3 seconds.
	    setTimeout(function() {
	        window.location.replace('<?php echo $indexUrl; ?>');
	    }, 3000);
    @endif

	@if($action == 'search')

		var mainSearch = 'div.js-admin-search';
		var searchForm = 'form#search-form';

	    // Redirect the user to where they want to go after 3 seconds.
	    setTimeout(function() {
			/**
			 * search
			 */
		    var url = $(mainSearch + ' .js-search').data('url');
		    $(searchForm).attr('action', url);
		    $(searchForm).submit();
	    }, 3000);
    @endif
});     
</script>