@php
    $request = Request::all();
    $name = '';
    if(!empty($request['name']))
    {
        $name = $request['name'];
    }
@endphp

<input type="text" placeholder="Tên sản phẩm" name="name" class="form-control" value="{{ ($name) }}">