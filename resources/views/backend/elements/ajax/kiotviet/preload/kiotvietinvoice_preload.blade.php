@php
	use App\Helpers\DateHelper;
	//
	$action = !empty($data['action']) ? $data['action'] : 'index';
    //
	$branch = !empty($data['branch']) ? $data['branch'] : '%';
	$status = !empty($data['status']) ? $data['status'] : '%';
	$code = !empty($data['code']) ? $data['code'] : '';
	$customercode = !empty($data['customercode']) ? $data['customercode'] : '';
	$frmDate = !empty($data['frmDate']) ? $data['frmDate'] : date('Y-m-01');
	$frmDate = DateHelper::getDate('d-m-Y', $frmDate);
	$toDate = !empty($data['toDate']) ? $data['toDate'] : date('Y-m-d');
    $toDate = DateHelper::getDate('d-m-Y', $toDate);
	//
	$indexUrl = app('UrlHelper')::admin('kiotvietInvoice', 'index').'?branch='.$branch.'&code='.$code.'&status='.$status.'&frmDate='.$frmDate.'&toDate='.$toDate.'&customercode='.$customercode;
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