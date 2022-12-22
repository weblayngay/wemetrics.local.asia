@php
	use App\Helpers\DateHelper;
	//
	$action = !empty($data['action']) ? $data['action'] : 'index';
    //
	$branch = !empty($data['branch']) ? $data['branch'] : '%';
	$code = !empty($data['code']) ? $data['code'] : '';
	$name = !empty($data['name']) ? $data['name'] : '';
	$contactNumber = !empty($data['contactNumber']) ? $data['contactNumber'] : '';
	//
	$indexUrl = app('UrlHelper')::admin('kiotvietCustomer', 'index').'?branch='.$branch.'&code='.$code.'&name='.$name.'&contactNumber='.$contactNumber;
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