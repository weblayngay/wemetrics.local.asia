@php
    $sources = $data['sources'];
    $data = Request::all();
    $source = '';
    if(!empty($data['mSource']))
    {
        $source = $data['mSource'];
    }
@endphp
<select class="form-control select2" name="mSource">
    <option value="%">{{__('Tất cả')}}</option>
    @foreach($sources as $key => $item)
        <option value="{{__($item)}}"  {{($item == $source) ? 'selected' : ''}}>
            {{__($item)}}
        </option>
    @endforeach
</select>