@php
    $request = Request::all();
    $searchStr = '';
    if(!empty($request['searchStr']))
    {
        $searchStr = $request['searchStr'];
    }
@endphp

<input type="text" placeholder="Tìm kiếm.." name="searchStr" class="form-control" value="{{ ($searchStr) }}">