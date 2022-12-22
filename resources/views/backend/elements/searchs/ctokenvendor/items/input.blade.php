@php
    $data = Request::all();
    $searchStr = '';
    if(!empty($data['searchStr']))
    {
        $searchStr = $data['searchStr'];
    }
@endphp

<input type="text" placeholder="Tìm kiếm.." name="searchStr" class="form-control" value="{{ ($searchStr) }}">