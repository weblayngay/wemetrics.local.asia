<script type="text/javascript">
$(document).ready(function(){
	$('#button-search').click(function() {
		$('#pre-load').show();
	});
	var data = <?php echo json_encode($data);?>;
	chartTotalSalesByDate(data);
	chartTotalCommByDate(data);
	$('#pre-load').hide();
});     
</script>