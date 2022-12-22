@php
    $data = Request::all();
    $isUsed = '';
    if(!empty($data['isUsed']))
    {
        $isUsed = $data['isUsed'];
    }
@endphp
<select class="form-control select2" name="isUsed">
    <option value="">{{__('Sử dụng')}}</option>
    <option value="yes" {{ ($isUsed == 'yes') ? 'selected' : '' }}>{{__('Đã dùng')}}</option>
    <option value="no" {{ ($isUsed == 'no') ? 'selected' : '' }}>{{__('Chưa dùng')}}</option>
</select>