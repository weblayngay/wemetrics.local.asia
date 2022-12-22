@php
    $mLimits = $data['mLimits'];
    $data = Request::all();
    $mLimit = '';
    if(!empty($data['mLimit']))
    {
        $mLimit = $data['mLimit'];
    }
@endphp
<select class="form-control select2" name="mLimit">
    <option value="10">{{__('10 Items')}}</option>
    @foreach($mLimits as $key => $item)
        <option value="{{__($key)}}"  {{($key == $mLimit) ? 'selected' : ''}}>
            {{__($item)}}
        </option>
    @endforeach
</select>