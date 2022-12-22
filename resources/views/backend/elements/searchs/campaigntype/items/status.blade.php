@php
    $request = Request::all();
    $status = '';
    if(!empty($request['status']))
    {
        $status = $request['status'];
    }
@endphp
<select class="form-control select2" name="status">
    <option value="">{{__('Trạng thái')}}</option>
    <option value="activated" {{ ($status == 'activated') ? 'selected' : '' }}>{{__('Bật')}}</option>
    <option value="inactive" {{ ($status == 'inactive') ? 'selected' : '' }}>{{__('Tắt')}}</option>
</select>