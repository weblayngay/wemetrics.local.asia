@php
    $devices = $data['devices'];
    $data = Request::all();
    $device = '';
    if(!empty($data['mDevice']))
    {
        $device = $data['mDevice'];
    }
@endphp
<select class="form-control select2" name="mDevice">
    <option value="%">{{__('Tất cả')}}</option>
    @foreach($devices as $key => $item)
        <option value="{{__($item->name)}}"  {{($item->name == $device) ? 'selected' : ''}}>
            {{__($item->name)}}
        </option>
    @endforeach
</select>