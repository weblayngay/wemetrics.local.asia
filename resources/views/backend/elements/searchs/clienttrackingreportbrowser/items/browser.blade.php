@php
    $browsers = $data['browsers'];
    $data = Request::all();
    $browser = '';
    if(!empty($data['mBrowser']))
    {
        $browser = $data['mBrowser'];
    }
@endphp
<select class="form-control select2" name="mBrowser">
    <option value="%">{{__('Tất cả')}}</option>
    @foreach($browsers as $key => $item)
        <option value="{{__($item->name)}}"  {{($item->name == $browser) ? 'selected' : ''}}>
            {{__($item->name)}}
        </option>
    @endforeach
</select>