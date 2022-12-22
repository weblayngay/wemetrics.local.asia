@php
	$action = !empty($data['action']) ? $data['action'] : 'index';
@endphp
<script type="text/javascript">
$(document).ready(function(){
	@if($action == 'index')
	    // Redirect the user to where they want to go after 3 seconds.
	    setTimeout(function() {
	        window.location.replace("{{app('UrlHelper')::admin('kiotvietinvoicereportoverview', 'index')}}");
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
});     
</script>