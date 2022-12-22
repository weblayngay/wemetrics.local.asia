@php
    $request = Request::all();
    $statusId = '';
    if(!empty($request['statusId']))
    {
        $statusId = $request['statusId'];
    }
use App\Models\Websites\W0001\lt4ProductsOrdersStatus;
$lt4ProductOrdersStatus = new lt4ProductsOrdersStatus();
$dataStatus = $lt4ProductOrdersStatus::query()->IsEnabled()->get();
@endphp
<select class="form-control select2" name="statusId">
    <option value="">{{__('Trạng thái')}}</option>
    @foreach($dataStatus as $key => $item)
    	<option value="{{$item->id}}" {{ ($statusId == $item->id) ? 'selected' : '' }}>{{__($item->name)}}</option>
	@endforeach
</select>