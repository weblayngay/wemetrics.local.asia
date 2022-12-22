@php
    $request = Request::all();
    $customercode = '';
    if(!empty($request['customercode']))
    {
        $customercode = $request['customercode'];
    }
@endphp

<input type="text" placeholder="Mã khách hàng.." name="customercode" class="form-control" value="{{ ($customercode) }}">