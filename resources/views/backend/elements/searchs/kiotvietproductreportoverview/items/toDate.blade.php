@php
    $request = Request::all();
    $toDate = '';
    if(!empty($request['toDate']))
    {
        $toDate = $request['toDate'];
    }
@endphp
<input class="form-control time-statistic" type="text" name="toDate" value="{{ ($toDate) }}" />