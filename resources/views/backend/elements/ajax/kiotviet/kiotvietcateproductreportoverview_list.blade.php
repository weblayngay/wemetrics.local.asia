<script type="text/javascript">
$(document).ready(function(){
	$('#button-search').click(function() {
		$('#pre-load').show();
	});

	var data = <?php echo json_encode($data);?>;
	if($('#chartTotalCateProductByDate').length != 0)
	{
		chartTotalCateProductByDate(data);
	}

	if($('#chartTotalQuantityCateProduct').length != 0)
	{
		chartTotalQuantityCateProduct(data);
	}

	if($('#chartTotalAmountCateProduct').length != 0)
	{
		chartTotalAmountCateProduct(data);
	}
	//
	var totalCateProductByBranch = <?php echo (array_key_exists('totalCateProductByBranch', $data) ? json_encode($data['totalCateProductByBranch']) : json_encode([]));?>;
	var tuixachByBranch = <?php echo (array_key_exists('tuixachByBranch', $data) ? json_encode($data['tuixachByBranch']) : json_encode([]));?>;
	var tuideoByBranch = <?php echo (array_key_exists('tuideoByBranch', $data) ? json_encode($data['tuideoByBranch']) : json_encode([]));?>;
	var tuiquangByBranch = <?php echo (array_key_exists('tuiquangByBranch', $data) ? json_encode($data['tuiquangByBranch']) : json_encode([]));?>;
	var capxachByBranch = <?php echo (array_key_exists('capxachByBranch', $data) ? json_encode($data['capxachByBranch']) : json_encode([]));?>;
	var bopviByBranch = <?php echo (array_key_exists('bopviByBranch', $data) ? json_encode($data['bopviByBranch']) : json_encode([]));?>;
	var baloByBranch = <?php echo (array_key_exists('baloByBranch', $data) ? json_encode($data['baloByBranch']) : json_encode([]));?>;
	var tuidulichByBranch = <?php echo (array_key_exists('tuidulichByBranch', $data) ? json_encode($data['tuidulichByBranch']) : json_encode([]));?>;
	var daynitByBranch = <?php echo (array_key_exists('daynitByBranch', $data) ? json_encode($data['daynitByBranch']) : json_encode([]));?>;
	var phukienByBranch = <?php echo (array_key_exists('phukienByBranch', $data) ? json_encode($data['phukienByBranch']) : json_encode([]));?>;
	if(totalCateProductByBranch.length != 0)
	{
		if(tuixachByBranch.length != 0)
		{
			chartTuiXachByBranch(data);
		}

		if(tuideoByBranch.length != 0)
		{
			chartTuiDeoByBranch(data);
		}

		if(tuiquangByBranch.length != 0)
		{
			chartTuiQuangByBranch(data);
		}

		if(capxachByBranch.length != 0)
		{
			chartCapXachByBranch(data);
		}

		if(bopviByBranch.length != 0)
		{
			chartBopViByBranch(data);
		}

		if(baloByBranch.length != 0)
		{
			chartBaloByBranch(data);
		}

		if(tuidulichByBranch.length != 0)
		{
			chartTuiDuLichByBranch(data);
		}

		if(daynitByBranch.length != 0)
		{
			chartDayNitByBranch(data);
		}

		if(phukienByBranch.length != 0)
		{
			chartPhuKienByBranch(data);
		}
	}

	$('#pre-load').hide();
});     
</script>