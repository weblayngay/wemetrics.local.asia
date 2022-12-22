@php
    $request = Request::all();
    $frmDate = '';
    if(!empty($request['frmDate']))
    {
        $frmDate = $request['frmDate'];
    }
@endphp
<input class="form-control time-statistic" type="text" name="frmDate" value="{{ ($frmDate) }}" />