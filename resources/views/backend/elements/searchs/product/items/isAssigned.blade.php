@php
    $request = Request::all();
    $isAssigned = '';
    if(!empty($request['isAssigned']))
    {
        $isAssigned = $request['isAssigned'];
    }
@endphp
<select class="form-control select2" name="isAssigned">
    <option value="">{{__('Cấp phát')}}</option>
    <option value="yes" {{ ($isAssigned == 'yes') ? 'selected' : '' }}>{{__('Đã cấp')}}</option>
    <option value="no" {{ ($isAssigned == 'no') ? 'selected' : '' }}>{{__('Chưa cấp')}}</option>
</select>