@php
    $request = Request::all();
    $isUsed = '';
    if(!empty($request['isUsed']))
    {
        $isUsed = $request['isUsed'];
    }
@endphp
<select class="form-control select2" name="isUsed">
    <option value="">{{__('Sử dụng')}}</option>
    <option value="yes" {{ ($isUsed == 'yes') ? 'selected' : '' }}>{{__('Đã dùng')}}</option>
    <option value="no" {{ ($isUsed == 'no') ? 'selected' : '' }}>{{__('Chưa dùng')}}</option>
</select>