@php
    $request = Request::all();
    $voucher = '';
    if(!empty($request['voucher']))
    {
        $voucher = $request['voucher'];
    }
@endphp

<input type="text" placeholder="Mã giảm giá.." name="voucher" class="form-control" value="{{ ($voucher) }}">