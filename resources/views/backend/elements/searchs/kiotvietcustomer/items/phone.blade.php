@php
    $request = Request::all();
    $contactNumber = '';
    if(!empty($request['contactNumber']))
    {
        $contactNumber = $request['contactNumber'];
    }
@endphp

<input type="text" placeholder="Số điện thoại" name="contactNumber" class="form-control" value="{{ ($contactNumber) }}">