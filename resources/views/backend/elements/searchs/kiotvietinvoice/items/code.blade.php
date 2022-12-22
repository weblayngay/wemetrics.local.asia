@php
    $request = Request::all();
    $code = '';
    if(!empty($request['code']))
    {
        $code = $request['code'];
    }
@endphp

<input type="text" placeholder="Số bill.." name="code" class="form-control" value="{{ ($code) }}">