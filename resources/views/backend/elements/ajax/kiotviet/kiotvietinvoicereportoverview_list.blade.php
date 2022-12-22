<script type="text/javascript">
$(document).ready(function(){
	$('#button-search').click(function() {
		$('#pre-load').show();
	});
	var data = <?php echo json_encode($data);?>;
	chartTotalInvoiceCompletedByDate(data);
	chartTotalInvoice(data);
	chartTotalAmount(data);
	$('#pre-load').hide();
});     
</script>