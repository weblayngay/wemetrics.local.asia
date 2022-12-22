<script type="text/javascript">
$(document).ready(function(){
	$('#button-search').click(function() {
		$('#pre-load').show();
	});
	var data = <?php echo json_encode($data);?>;
	charttotalAssignedVoucher(data);
	charttotalAssignedVoucherGroupByDevice(data);
	charttotalUsedVoucher(data);
	charttotalUsedVoucherGroupByDevice(data);
	chartorderAndVoucherByDate(data);
	chartorderUsedVoucherByReseller(data);
	chartorderUsedVoucherByCity(data);
	$('#pre-load').hide();
});     
</script>