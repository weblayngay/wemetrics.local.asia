@php
	use App\Helpers\DateHelper;
	//
	$action = !empty($data['action']) ? $data['action'] : 'index';
	//
	$frmDate = !empty($data['frmDate']) ? $data['frmDate'] : date('Y-m-01');
	$frmDate = DateHelper::getDate('d-m-Y', $frmDate);
	//
	$toDate = !empty($data['toDate']) ? $data['toDate'] : date('Y-m-d');
    $toDate = DateHelper::getDate('d-m-Y', $toDate);
    //
	$branch = !empty($data['branch']) ? $data['branch'] : '%';
	$cateProduct = !empty($data['cateProduct']) ? $data['cateProduct'] : '%';
	$indexUrl = app('UrlHelper')::admin('kiotvietcateproductreportoverview', 'index').'?branch='.$branch.'&cateProduct='.$cateProduct.'&frmDate='.$frmDate.'&toDate='.$toDate;
	//
	$drilldownbranchandcateproductUrl = app('UrlHelper')::admin('kiotvietcateproductreportoverview', 'drilldownbranchandcateproduct').'?branch='.$branch.'&cateProduct='.$cateProduct.'&frmDate='.$frmDate.'&toDate='.$toDate;
	//
	$drilldownbranchesandcateproductUrl = app('UrlHelper')::admin('kiotvietcateproductreportoverview', 'drilldownbranchesandcateproduct').'?branch='.$branch.'&cateProduct='.$cateProduct.'&frmDate='.$frmDate.'&toDate='.$toDate;

	//
	$drilldownbrachesandproductsUrl = app('UrlHelper')::admin('kiotvietcateproductreportoverview', 'drilldownbrachesandproducts').'?branch='.$branch.'&cateProduct='.$cateProduct.'&frmDate='.$frmDate.'&toDate='.$toDate;
@endphp
<script type="text/javascript">
$(document).ready(function(){
	@if($action == 'index')
	    // Redirect the user to where they want to go after 3 seconds.
	    setTimeout(function() {
	        window.location.replace('<?php echo $indexUrl; ?>');
	    }, 3000);
    @endif

	@if($action == 'stats')

		var mainTable = 'table.js-main-table';
		var mainForm = 'form#admin-form';
		var mainAction = 'div.js-admin-action';
		var mainSearch = 'div.js-admin-search';
		var mainReport = 'div.js-admin-report';
		var searchForm = 'form#search-form';
		var reportForm = 'form#report-form';
		var checkboxItem = mainTable + ' input.checkItem';

	    // Redirect the user to where they want to go after 3 seconds.
	    setTimeout(function() {
			/**
			 * report
			 */
		    var url = $(mainReport + ' .js-report').data('url');
		    $(reportForm).attr('action', url);
		    $(reportForm).submit();
	    }, 3000);
    @endif

	@if($action == 'drilldownbranchandcateproduct')
	    // Redirect the user to where they want to go after 3 seconds.
	    setTimeout(function() {
	        window.location.replace('<?php echo $drilldownbranchandcateproductUrl; ?>');
	    }, 3000);
    @endif

	@if($action == 'drilldownbranchesandcateproduct')
	    // Redirect the user to where they want to go after 3 seconds.
	    setTimeout(function() {
	        window.location.replace('<?php echo $drilldownbranchesandcateproductUrl; ?>');
	    }, 3000);
    @endif

	@if($action == 'drilldownbrachesandproducts')
	    // Redirect the user to where they want to go after 3 seconds.
	    setTimeout(function() {
	        window.location.replace('<?php echo $drilldownbrachesandproductsUrl; ?>');
	    }, 3000);
    @endif
});     
</script>