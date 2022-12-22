@php
    $platforms = $data['platforms'];
    $data = Request::all();
    $platform = '';
    if(!empty($data['mPlatform']))
    {
        $platform = $data['mPlatform'];
    }
@endphp
<select class="form-control select2" name="mPlatform">
    <option value="%">{{__('Tất cả')}}</option>
    @foreach($platforms as $key => $item)
        <option value="{{__($item->name)}}"  {{($item->name == $platform) ? 'selected' : ''}}>
            {{__($item->name)}}
        </option>
    @endforeach
</select>