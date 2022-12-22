@php
    $request = Request::all();
    $paymentMethod = '';
    if(!empty($request['paymentMethod']))
    {
        $paymentMethod = $request['paymentMethod'];
    }
use App\Models\Websites\W0001\lt4ProductsPaymentMethod;
$lt4ProductsPaymentMethod = new lt4ProductsPaymentMethod();
$dataPaymentMethod = $lt4ProductsPaymentMethod::query()->IsEnabled()->get();
@endphp
<select class="form-control select2" name="paymentMethod">
    <option value="">{{__('PT Thanh toán')}}</option>
    @foreach($dataPaymentMethod as $key => $item)
    	<option value="{{$item->id}}" {{ ($paymentMethod == $item->id) ? 'selected' : '' }}>{{__($item->name)}}</option>
	@endforeach
</select>