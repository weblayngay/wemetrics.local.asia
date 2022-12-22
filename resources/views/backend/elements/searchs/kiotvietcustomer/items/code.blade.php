@php
    $request = Request::all();
    $code = '';
    if(!empty($request['code']))
    {
        $code = $request['code'];
    }
@endphp

<input type="text" placeholder="Mã khách hàng" name="code" class="form-control" value="{{ ($code) }}">